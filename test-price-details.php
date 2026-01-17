<?php
// test-price-details.php
require 'vendor/autoload.php';

\Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET'));

$priceId = getenv('STRIPE_PRICE_BASICO');

echo "=== VERIFICANDO PRICE ID ===\n\n";
echo "Price ID en .env: " . $priceId . "\n\n";

try {
    $price = \Stripe\Price::retrieve($priceId);

    echo "✅ Price ID encontrado!\n";
    echo "Detalles:\n";
    echo "  - ID: " . $price->id . "\n";
    echo "  - Precio: $" . ($price->unit_amount / 100) . " " . strtoupper($price->currency) . "\n";
    echo "  - Tipo: " . $price->type . "\n";

    if ($price->type === 'recurring') {
        echo "  - Intervalo: " . $price->recurring->interval . "\n";
    }

    echo "  - Activo: " . ($price->active ? '✅ Sí' : '❌ No') . "\n";
    echo "  - Modo: " . ($price->livemode ? 'LIVE' : 'TEST') . "\n\n";

    // Verificar si coincide con lo que esperas
    if ($price->unit_amount !== 45900) {
        echo "⚠️  ADVERTENCIA: El precio NO es 459 MXN\n";
        echo "   Es: $" . ($price->unit_amount / 100) . " " . $price->currency . "\n";
        echo "   Debería ser: $459.00 MXN\n";
    }

    if ($price->currency !== 'mxn') {
        echo "⚠️  ADVERTENCIA: La moneda NO es MXN\n";
        echo "   Es: " . $price->currency . "\n";
        echo "   Debería ser: mxn\n";
    }

} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";

    // Listar todos los precios disponibles
    echo "\n=== BUSCANDO PRECIOS DISPONIBLES ===\n";

    $prices = \Stripe\Price::all(['limit' => 10, 'active' => true]);

    if (count($prices->data) > 0) {
        echo "Precios encontrados:\n";
        foreach ($prices->data as $p) {
            $isMatching = ($p->unit_amount === 45900 && $p->currency === 'mxn');
            echo ($isMatching ? "⭐ " : "  ") . $p->id . " - $" . ($p->unit_amount/100) . " " . $p->currency;

            if ($p->type === 'recurring') {
                echo " /" . $p->recurring->interval;
            }

            echo "\n";
        }
    } else {
        echo "No hay precios creados.\n";
    }
}
