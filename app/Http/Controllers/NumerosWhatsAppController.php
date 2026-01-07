<?php

namespace App\Http\Controllers;

use App\Models\NumerosWhatsApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NumerosWhatsAppController extends Controller
{
    private $paises = [
        'MX' => ['nombre' => 'México', 'codigo' => '521', 'longitud' => 10],
        'US' => ['nombre' => 'Estados Unidos', 'codigo' => '1', 'longitud' => 10],
        'CA' => ['nombre' => 'Canada', 'codigo' => '1', 'longitud' => 10],
        'ES' => ['nombre' => 'España', 'codigo' => '34', 'longitud' => 9],
        'AR' => ['nombre' => 'Argentina', 'codigo' => '54', 'longitud' => 10],
        'CO' => ['nombre' => 'Colombia', 'codigo' => '57', 'longitud' => 10],
        'PE' => ['nombre' => 'Perú', 'codigo' => '51', 'longitud' => 9],
        'CL' => ['nombre' => 'Chile', 'codigo' => '56', 'longitud' => 9],
        'BR' => ['nombre' => 'Brasil', 'codigo' => '55', 'longitud' => 11],
        'EC' => ['nombre' => 'Ecuador', 'codigo' => '593', 'longitud' => 9],
        'VE' => ['nombre' => 'Venezuela', 'codigo' => '58', 'longitud' => 10],
        'GT' => ['nombre' => 'Guatemala', 'codigo' => '502', 'longitud' => 8],
        'SV' => ['nombre' => 'El Salvador', 'codigo' => '503', 'longitud' => 8],
        'HN' => ['nombre' => 'Honduras', 'codigo' => '504', 'longitud' => 8],
        'NI' => ['nombre' => 'Nicaragua', 'codigo' => '505', 'longitud' => 8],
        'CR' => ['nombre' => 'Costa Rica', 'codigo' => '506', 'longitud' => 8],
        'PA' => ['nombre' => 'Panamá', 'codigo' => '507', 'longitud' => 8],
        'DO' => ['nombre' => 'República Dominicana', 'codigo' => '1', 'longitud' => 10],
        'UY' => ['nombre' => 'Uruguay', 'codigo' => '598', 'longitud' => 8],
        'PY' => ['nombre' => 'Paraguay', 'codigo' => '595', 'longitud' => 9],
        'BO' => ['nombre' => 'Bolivia', 'codigo' => '591', 'longitud' => 8],
        'CU' => ['nombre' => 'Cuba', 'codigo' => '53', 'longitud' => 8],
        // Agrega más países según necesites
    ];

    private $formatoPaises = [
        'MX' => 'XX-XXXX-XXXX',
        'US' => '(XXX) XXX-XXXX',
        'CA' => '(XXX) XXX-XXXX',
        'ES' => 'XXX XXX XXX',
        'AR' => 'XX-XXXX-XXXX',
        'CO' => 'XXX-XXX-XXXX',
        'PE' => 'XXX-XXX-XXX',
        'CL' => 'X-XXXX-XXXX',
        'BR' => '(XX) XXXXX-XXXX',
        'EC' => 'XX-XXX-XXXX',
        'VE' => 'XXX-XXX-XXXX',
        'GT' => 'XXXX-XXXX',
        'SV' => 'XXXX-XXXX',
        'HN' => 'XXXX-XXXX',
        'NI' => 'XXXX-XXXX',
        'CR' => 'XXXX-XXXX',
        'PA' => 'XXXX-XXXX',
        'DO' => '(XXX) XXX-XXXX',
        'UY' => 'X-XXX-XX-XX',
        'PY' => 'XXX-XXX-XXX',
        'BO' => 'X-XXX-XXXX',
        'CU' => 'X-XXX-XXXX',
    ];

    /**
     * Mostrar formulario para crear nuevo número
     */
    public function create()
    {
        return view('numeros-whatsapp.create', [
            'paises' => array_map(fn($p) => $p['nombre'], $this->paises)
        ]);
    }

    /**
     * Almacenar nuevo número de WhatsApp
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pais' => 'required|string|size:2|in:' . implode(',', array_keys($this->paises)),
            'numero_local' => 'required|string|max:20',
            'etiqueta' => 'nullable|string|max:50',
            'es_principal' => 'nullable|boolean',
        ]);

        try {
            // Procesar y normalizar el número
            $processedNumber = $this->processPhoneNumber(
                $validated['numero_local'],
                $validated['pais']
            );

            // Verificar si el número ya existe para este usuario
            $exists = NumerosWhatsApp::where('user_id', Auth::id())
                ->where('numero_whatsapp', $processedNumber['whatsapp'])
                ->exists();

            if ($exists) {
                return back()->withErrors([
                    'numero_local' => 'Este número de WhatsApp ya está registrado.'
                ])->withInput();
            }

            // Si se marca como principal, desmarcar otros
            if ($request->boolean('es_principal')) {
                NumerosWhatsApp::where('user_id', Auth::id())
                    ->update(['es_principal' => false]);
            }

            // Crear el registro
            $numeroWhatsApp = NumerosWhatsApp::create([
                'user_id' => Auth::id(),
                'numero_whatsapp' => $processedNumber['whatsapp'],
                'numero_internacional' => $processedNumber['international'],
                'codigo_pais' => $processedNumber['country_code'],
                'numero_local' => $processedNumber['local'],
                'pais' => $validated['pais'],
                'etiqueta' => $validated['etiqueta'],
                'es_principal' => $request->boolean('es_principal'),
            ]);

            return redirect()->route('numeros-whatsapp.index')
                ->with('success', 'Número de WhatsApp registrado correctamente.');

        } catch (\InvalidArgumentException $e) {
            return back()->withErrors([
                'numero_local' => $e->getMessage()
            ])->withInput();

        } catch (\Exception $e) {
            return back()->withErrors([
                'numero_local' => 'Error al procesar el número: ' . $e->getMessage()
            ])->withInput();
        }
    }

    /**
     * Procesar y normalizar número de teléfono
     */
    private function processPhoneNumber(string $localNumber, string $countryCode): array
    {
        // Verificar que el país existe
        if (!isset($this->paises[$countryCode])) {
            throw new \InvalidArgumentException('País no válido.');
        }

        $paisConfig = $this->paises[$countryCode];

        // Limpiar el número local (solo números)
        $cleanLocal = preg_replace('/[^0-9]/', '', $localNumber);

        // Validar longitud
        $longitudEsperada = $paisConfig['longitud'];
        if (strlen($cleanLocal) !== $longitudEsperada) {
            throw new \InvalidArgumentException(
                "El número debe tener {$longitudEsperada} dígitos para {$this->paises[$countryCode]['nombre']}."
            );
        }

        // Validar formato básico (primer dígito no debe ser 0 para algunos países)
        if (in_array($countryCode, ['MX', 'US', 'CA']) && $cleanLocal[0] === '0') {
            throw new \InvalidArgumentException('El número no puede comenzar con 0.');
        }

        // Generar número de WhatsApp (código de país + número local)
        $whatsappNumber = $paisConfig['codigo'] . $cleanLocal;

        // Formatear número internacional
        $internationalNumber = '+' . $whatsappNumber;

        // Formatear número local con formato específico del país
        $formattedLocal = $this->formatLocalNumber($cleanLocal, $countryCode);

        return [
            'whatsapp' => $whatsappNumber,
            'international' => $this->formatInternationalNumber($whatsappNumber, $countryCode),
            'country_code' => '+' . $paisConfig['codigo'],
            'local' => $formattedLocal,
            'raw_local' => $cleanLocal,
        ];
    }

    /**
     * Formatear número local según el formato del país
     */
    private function formatLocalNumber(string $number, string $countryCode): string
    {
        if (!isset($this->formatoPaises[$countryCode])) {
            return $number;
        }

        $formato = $this->formatoPaises[$countryCode];
        $digits = str_split($number);
        $result = '';
        $digitIndex = 0;

        for ($i = 0; $i < strlen($formato); $i++) {
            if ($formato[$i] === 'X') {
                if ($digitIndex < count($digits)) {
                    $result .= $digits[$digitIndex];
                    $digitIndex++;
                }
            } else {
                $result .= $formato[$i];
            }
        }

        return $result;
    }

    /**
     * Formatear número internacional
     */
    private function formatInternationalNumber(string $whatsappNumber, string $countryCode): string
    {
        $codigoPais = $this->paises[$countryCode]['codigo'];
        $numeroLocal = substr($whatsappNumber, strlen($codigoPais));
        $numeroLocalFormateado = $this->formatLocalNumber($numeroLocal, $countryCode);

        return "+{$codigoPais} {$numeroLocalFormateado}";
    }

    /**
     * Validar estructura del número telefónico
     */
    private function validatePhoneStructure(string $number, string $countryCode): bool
    {
        // Eliminar espacios y caracteres no numéricos
        $cleanNumber = preg_replace('/[^0-9]/', '', $number);

        // Validar longitud mínima
        if (strlen($cleanNumber) < 8) {
            return false;
        }

        // Validaciones específicas por país
        switch ($countryCode) {
            case 'MX':
                // Números mexicanos: 10 dígitos, no empiezan con 0
                return strlen($cleanNumber) === 10 && $cleanNumber[0] !== '0';

            case 'US':
            case 'CA':
                // Números norteamericanos: 10 dígitos, código de área válido
                if (strlen($cleanNumber) !== 10) return false;
                $areaCode = substr($cleanNumber, 0, 3);
                // Validar que el código de área no comience con 0 o 1
                return $areaCode[0] !== '0' && $areaCode[0] !== '1';

            case 'ES':
                // Números españoles: 9 dígitos
                return strlen($cleanNumber) === 9;

            default:
                // Para otros países, validar longitud según configuración
                if (isset($this->paises[$countryCode])) {
                    return strlen($cleanNumber) === $this->paises[$countryCode]['longitud'];
                }
                return true;
        }
    }

    /**
     * Mostrar lista de números del usuario
     */
    public function index()
    {
        $numeros = NumerosWhatsApp::where('user_id', Auth::id())
            ->orderBy('es_principal', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('numeros-whatsapp.index', compact('numeros'));
    }

    /**
     * Marcar un número como principal
     */
    public function setPrincipal(NumerosWhatsApp $numero)
    {
        // Verificar que el número pertenezca al usuario
        $this->authorize('update', $numero);

        // Desmarcar todos los números como principales
        NumerosWhatsApp::where('user_id', Auth::id())
            ->update(['es_principal' => false]);

        // Marcar este número como principal
        $numero->update(['es_principal' => true]);

        return back()->with('success', 'Número marcado como principal.');
    }

    /**
     * Eliminar un número
     */
    public function destroy($id)
    {
        NumerosWhatsApp::destroy($id);

        return back()->with('success', 'Número eliminado correctamente.');
    }

    /**
     * Validar número (para AJAX)
     */
    public function validateNumber(Request $request)
    {
        $request->validate([
            'numero' => 'required|string',
            'pais' => 'required|string|size:2|in:' . implode(',', array_keys($this->paises)),
        ]);

        try {
            $result = $this->processPhoneNumber(
                $request->numero,
                $request->pais
            );

            return response()->json([
                'valid' => true,
                'whatsapp' => $result['whatsapp'],
                'international' => $result['international'],
                'local' => $result['local'],
                'formato_esperado' => $this->formatoPaises[$request->pais] ?? 'Sin formato específico',
            ]);

        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'valid' => false,
                'message' => $e->getMessage(),
                'formato_esperado' => $this->formatoPaises[$request->pais] ?? 'Sin formato específico',
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'valid' => false,
                'message' => 'Error al procesar el número.',
            ], 400);
        }
    }

    /**
     * Obtener información del país (para AJAX)
     */
    public function getCountryInfo($countryCode)
    {
        if (!isset($this->paises[$countryCode])) {
            return response()->json(['error' => 'País no válido'], 404);
        }

        return response()->json([
            'codigo_pais' => $this->paises[$countryCode]['codigo'],
            'longitud' => $this->paises[$countryCode]['longitud'],
            'formato' => $this->formatoPaises[$countryCode] ?? 'Sin formato específico',
            'ejemplo' => $this->generateExampleNumber($countryCode),
        ]);
    }

    /**
     * Generar número de ejemplo para un país
     */
    private function generateExampleNumber(string $countryCode): string
    {
        $longitud = $this->paises[$countryCode]['longitud'];
        $ejemplo = '';

        for ($i = 0; $i < $longitud; $i++) {
            $ejemplo .= $i % 10; // Números del 0 al 9
        }

        return $this->formatLocalNumber($ejemplo, $countryCode);
    }
}
