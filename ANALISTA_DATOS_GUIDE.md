# 📊 Interfaz de Analista de Datos - Guía de Uso

## 🚀 Acceso

La nueva interfaz **Analista de Datos** está disponible en tu aplicación:

**URL**: `https://tudominio.com/analistajr`

O haz clic en el nuevo botón **"Analista Datos"** en el menú lateral (sidebar) de la aplicación.

---

## ✨ Características Principales

### 1. **KPIs en Tiempo Real** (4 tarjetas)
- 💰 **Patrimonio Total**: Suma de todos tus saldos de cuentas
- 📈 **Total Ingresos**: Suma de todos los ingresos en el período
- 📉 **Total Gastos**: Suma de todos los gastos en el período  
- 💱 **Balance**: Ingresos menos gastos (Dinero neto en el período)

### 2. **8 Gráficas Interactivas**

#### 📊 Distribución por Categoría (Gráfica de Dona)
- Visualiza qué categorías consumen más dinero
- Proporcional al monto total de cada categoría

#### 💰 Balance por Cuenta (Gráfica de Barras Horizontal)
- Saldo actual de cada una de tus cuentas
- Identifica rápidamente dónde tienes más dinero

#### 📈 Tendencia Mensual (Gráfica de Líneas)
- Últimos 12 meses
- Dos líneas: Ingresos (verde) vs Gastos (rojo)
- Visualiza tu comportamiento de gasto a lo largo del tiempo

#### 🔄 Flujo de Caja (Gráfica de Barras Agrupadas)
- Últimos 6 meses
- Entradas vs Salidas lado a lado
- Entiende tu liquidez mes a mes

#### 🕐 Histórico de Saldo (Gráfica de Área)
- Evolución del saldo total a lo largo del tiempo
- Muestra si vas al alza o a la baja

#### 📉 Top 10 Gastos (Gráfica de Barras Horizontal)
- Tus 10 mayores gastos registrados
- Identifica dónde se va más dinero

#### 📋 Tabla de Datos
- Últimas 20 transacciones con detalles
- Fecha, cuenta, categoría, tipo, monto, descripción

### 3. **Filtros Dinámicos**

#### 📅 Período
- Últimos 30 días
- Últimos 90 días
- Último año
- **Todo el tiempo** (predeterminado)

#### 🏦 Cuenta
- Filtra por cuenta específica
- "Todas las cuentas" (predeterminado)

### 4. **Acciones**

#### 🔄 Actualizar
- Recarga todos los datos en tiempo real
- Los cambios se reflejan inmediatamente

#### 🔄 Resetear
- Vuelve a los filtros predeterminados
- Período: Todo el tiempo
- Cuenta: Todas

#### 📥 Exportar
- Descarga un archivo CSV con todas las transacciones
- Incluye: Fecha, Cuenta, Categoría, Tipo, Monto, Descripción
- Ideal para análisis en Excel o Google Sheets

---

## 🎨 Diseño Visual

### 🌙 Tema Oscuro Premium
- Fondo oscuro: #0b0b0e (muy oscuro, confortable para los ojos)
- Superficies: #12141a, #18181b (gris oscuro)
- Accento: Rojo #ef4444 (coherente con la marca)

### 📱 Responsive
- ✅ Desktop: Todas las gráficas en dos columnas
- ✅ Tablet: Layout ajustado
- ✅ Móvil: Stack vertical

---

## 📊 Ejemplo de Uso Real

### Escenario 1: Analizar Gastos por Categoría
1. Abre **Analista Datos**
2. Busca la gráfica **"Distribución por Categoría"**
3. Identifica la categoría más grande
4. Filtra por esa categoría (editando el período)
5. Usa la **Tabla de Datos** para ver transacciones específicas

### Escenario 2: Comparar Diferentes Períodos
1. Abre **Analista Datos**
2. Selecciona **"Últimos 30 días"** en el filtro
3. Anota los números de KPIs
4. Cambia a **"Últimos 90 días"**
5. Compara las diferencias en ingresos/gastos

### Escenario 3: Exportar para Auditoría
1. Abre **Analista Datos**
2. Aplica los filtros que necesites
3. Haz clic en **"Exportar"**
4. Se descarga un CSV
5. Abre en Excel o Google Sheets para análisis avanzado

---

## 🔧 Datos Técnicos

### API Endpoints (para desarrolladores)

#### Obtener datos del dashboard
```
GET /api/analistajr/datos?dias=30&cuenta_id=1
```

Respuesta JSON incluye:
- `resumen` - KPIs principales
- `por_categoria` - Datos agregados por categoría
- `por_cuenta` - Saldos por cuenta
- `tendencia_mensual` - Últimos 12 meses
- `flujo_caja` - Últimos 6 meses
- `historico_saldo` - Histórico de saldos
- `top_gastos` - 10 mayores gastos
- `transacciones` - Lista de transacciones

#### Exportar datos
```
GET /api/analistajr/exportar?periodo=90
```

Retorna: Archivo CSV descargable

---

## ⚙️ Configuración

### Período Predeterminado
- **Actual**: "Todo el tiempo"
- Puedes cambiar esto en el controlador si lo necesitas

### Número de Top Gastos
- **Actual**: 10 transacciones
- Editable en `GraficasController@obtenerTopGastos()`

### Número de Filas en Tabla
- **Actual**: 20 transacciones
- Editable en la vista Blade

---

## 🐛 Solución de Problemas

### Las gráficas no se muestran
✅ **Solución**: Limpia la caché de vistas
```bash
php artisan view:clear
```

### Los datos no se actualizan
✅ **Solución**: Haz clic en el botón "Actualizar"

### Exportación no funciona
✅ **Solución**: Verifica que tengas transacciones en el período seleccionado

---

## 📈 Mejoras Futuras

Posibles enhancements:
- 📅 Selector de rango de fechas (date picker)
- 📊 Más tipos de gráficas (gráficas de comparación mes vs mes)
- 📌 Benchmarking (comparar contra promedios históricos)
- 🎯 Objetivos financieros (presupuestos vs actual)
- 📧 Reportes automáticos por email

---

## 👥 Soporte

Si encuentras algún problema o tienes sugerencias de mejora, contacta al equipo de desarrollo.

¡Disfruta analizando tus datos financieros! 🚀
