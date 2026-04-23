# 🔧 Documentación Técnica - Analista de Datos

## Arch Implementación

```
Usuario
  ↓
Navegación Sidebar
  ↓ (amalistajr.index)
GET /analistajr
  ↓
GraficasController@index
  ↓ (retorna vista)
resources/views/analistajr/dashboard.blade.php
  ↓
JavaScript en el cliente
  ↓
GET /api/analistajr/datos (con filtros opcionales)
  ↓
GraficasController@obtenerDatos()
  ↓
JSON Response
  ↓
Chart.js renderiza las gráficas
```

## 📁 Archivos Modificados/Creados

### 1. Controlador: `app/Http/Controllers/GraficasController.php`
**Cambios**: Reemplazado completamente el controlador

**Métodos principales**:
- `index()` - Retorna la vista dashboard
- `obtenerDatos(Request $request)` - API principal con filtros
- `obtenerResumen()` - KPIs (patrimonio, ingresos, gastos, balance)
- `obtenerPorCategoria()` - Agregación por categoría
- `obtenerPorCuenta()` - Saldos por cuenta
- `obtenerTendenciaMensual()` - 12 meses de datos
- `obtenerFlujoCaja()` - 6 meses flujo
- `obtenerHistoricoSaldo()` - Evolución de saldo
- `obtenerTopGastos()` - Top 10 gastos
- `exportarDatos()` - CSV export

### 2. Vista: `resources/views/analistajr/dashboard.blade.php`
**Nuevo archivo** con:
- Layout x-app-layout (mantiene sidebar)
- Header con gradient y branding
- Filtros (período y cuenta)
- 4 KPI cards
- 6 gráficas Chart.js
- Tabla de datos HTML
- JavaScript para gestionar gráficas
- CSS Tailwind integrado

### 3. Rutas: `routes/web.php`
**Nuevas rutas agregadas**:
```php
Route::get('api/analistajr/datos', [GraficasController::class, 'obtenerDatos'])
    ->name('api.analistajr.datos');
    
Route::get('api/analistajr/exportar', [GraficasController::class, 'exportarDatos'])
    ->name('api.analistajr.exportar');
```

### 4. Navegación: `resources/views/layouts/navigation.blade.php`
**Cambios**:
- Agregado nuevo item al array $menuItems
- Ruta: 'analistajr.index'
- Icono: Bar chart SVG
- Actualizado el condicional de estados activos

## 🔐 Seguridad

### Middleware aplicado en todas las rutas
- `auth` - Usuario autenticado
- `verified` - Email verificado
- `verificar.suscripcion` - Suscripción activa

### Scopes automáticos
```php
// En todos los queries se filtra por usuario actual
->where('user_id', Auth::id())
```

## 📊 Estructura de Datos API

### Request
```
GET /api/analistajr/datos?dias=30&cuenta_id=5
```

**Parámetros opcionales**:
- `dias` (int): 30, 90, 365, o vacío para "todo el tiempo"
- `cuenta_id` (int): ID de la cuenta a filtrar, o vacío para todas

### Response (ejemplo simplificado)
```json
{
  "resumen": {
    "patrimonio_total": 15000.50,
    "total_ingresos": 5000.00,
    "total_gastos": 2000.00,
    "balance": 3000.00,
    "total_transacciones": 45
  },
  "por_categoria": [
    {
      "categoria": { "id": 1, "nombre": "Alimentos" },
      "monto_total": "850.50",
      "total": 12
    },
    ...
  ],
  "por_cuenta": [
    {
      "cuenta": { "id": 1, "nombre": "Bancaria" },
      "saldo": "10000.00"
    },
    ...
  ],
  "tendencia_mensual": [
    {
      "mes": 1,
      "año": 2024,
      "ingresos": "4000.00",
      "gastos": "1500.00",
      "balance": "2500.00"
    },
    ...
  ],
  "flujo_caja": [
    {
      "mes": 10,
      "año": 2024,
      "entradas": "2500.00",
      "salidas": "1200.00"
    },
    ...
  ],
  "historico_saldo": [
    {
      "fecha": "2024-01-01",
      "saldo": 5000.00
    },
    ...
  ],
  "top_gastos": [
    {
      "id": 123,
      "monto": "500.50",
      "descripcion": "Compra en supermercado",
      "fecha": "2024-01-15"
    },
    ...
  ],
  "transacciones": [
    {
      "id": 456,
      "fecha": "2024-01-20",
      "cuenta": { "id": 1, "nombre": "Bancaria" },
      "categoria": { "id": 2, "nombre": "Comida" },
      "tipo": "gasto",
      "monto": "75.99",
      "descripcion": "Almuerzo en restaurante"
    },
    ...
  ]
}
```

## 🎨 Frontend Stack

### Librerías
- **Chart.js v4**: Renderizado de gráficas
- **TailwindCSS v3**: Estilos y layout
- **Blade Components**: Componente x-app-layout

### Colores
```css
--rojo: #ef4444
--verde: #22c55e
--azul: #3b82f6
--amarillo: #eab308
--purpura: #8b5cf6
--cyan: #22d3ee
--rosa: #f43f5e
--naranja: #f97316

--bg-primary: #0b0b0e
--bg-surface: #12141a
--bg-surface-dark: #18181b
--text-primary: #f1f5f9
--text-secondary: #94a3b8
--text-tertiary: #64748b
```

### Gráficas Chart.js
Paletawith colores consistentes en todas las gráficas

## 🚀 Performance

### Optimizaciones
1. **Agregaciones en BD**: Uso de DB::raw() y GROUP BY
2. **Select selectivo**: Solo columnas necesarias
3. **Relaciones cargadas**: with(['cuenta', 'categoria'])
4. **Límites**: Top gastos limitado a 10, tabla a 20 filas

### Consultas ejecutadas por request
- ~8 queries (una por cada sección de datos)
- Podrían optimizarse con un único query complejo

## 🔄 Flujo de Actualización

1. Usuario carga `/analistajr`
2. Se renderiza dashboard.blade.php
3. Script JavaScript en el cliente
4. DOMContentLoaded event trigger
5. Carga lista de cuentas desde `/api/cuentas-del-usuario`
6. Llama `actualizarDatos()`
7. GET `/api/analistajr/datos` (con filtros)
8. Recibe JSON
9. `actualizarKPIs()` - Actualiza 4 tarjetas
10. `crearGraficaX()` - Renderiza cada gráfica
11. `actualizarTabla()` - Llena tabla HTML

## 📤 Exportación CSV

### Método: `exportarDatos()`
```php
- Aplica filtros (período, cuenta)
- Ordena por fecha DESC
- Genera CSV con formato RFC 4180
- Escapa comillas en descripción
- Headers HTTP para descargar automáticamente
```

### Formato del CSV
```
Fecha,Cuenta,Categoría,Tipo,Monto,Descripción
2024-01-20,"Bancaria","Comida","gasto",75.99,"Almuerzo en restaurante"
2024-01-19,"Bancaria","Salario","ingreso",2000.00,"Pago mensual"
```

## 🧪 Testing

### Endpoint GET /api/analistajr/datos
```bash
# Test sin filtros
curl https://localhost/api/analistajr/datos

# Test con período de 30 días
curl https://localhost/api/analistajr/datos?dias=30

# Test con cuenta específica
curl https://localhost/api/analistajr/datos?cuenta_id=1

# Test con ambos filtros
curl https://localhost/api/analistajr/datos?dias=90&cuenta_id=2
```

### Endpoint GET /api/analistajr/exportar
```bash
# Exportar sin filtros
curl -o reporte.csv https://localhost/api/analistajr/exportar

# Exportar último año
curl -o reporte.csv https://localhost/api/analistajr/exportar?periodo=365
```

## 🛠️ Mantenimiento

### Cache que se debe limpiar después de cambios
```bash
php artisan view:clear
php artisan route:clear
php artisan config:clear
```

### Ubicación de logs de usuarios
```
storage/logs/laravel.log
```

### Posibles errores comunes
1. **"View not found"** → Ejecutar `view:clear`
2. **"Route not defined"** → Ejecutar `route:clear`
3. **"User not authenticated"** → Falta middleware auth
4. **"CSRF token mismatch"** → Falta meta tag en Blade

## 📈 Escalabilidad

### Para grandes datasets (>10k transacciones)
Consideraciones:
- Pagination en tabla
- Cache de resultados computados
- Índices en BD: (user_id, fecha), (user_id, tipo), (user_id, categoría_id)
- Considerar materialized views para tendencias mensuales

### Límites actuales
- Top gastos: 10
- Tabla en dashboard: 20
- Histórico: Todas las transacciones cargadas en memoria

## 🔍 Monitoreo

### Métricas a monitorear
- Tiempo de respuesta de `/api/analistajr/datos`
- Número de queries ejecutadas
- Memoria usada en procesamiento
- Errores de validación de filtros

## 📚 Referencias

### Documentación relacionada
- [Documentación del Usuario](ANALISTA_DATOS_GUIDE.md)
- [Laravel Docs - Eloquent](https://laravel.com/docs/eloquent)
- [Chart.js Docs](https://www.chartjs.org/docs/latest/)
- [Tailwind CSS Docs](https://tailwindcss.com/docs)
