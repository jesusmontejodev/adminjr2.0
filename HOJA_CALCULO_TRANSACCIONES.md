# 📊 Hoja de Cálculo Interactiva de Transacciones

¡He creado una pestaña tipo Excel para gestionar tus transacciones! Aquí te muestro cómo usarla.

## 🎯 Acceso

Accede a la hoja de cálculo en: **`/transacciones-hoja`**

Por ejemplo: `http://tudominio.com/transacciones-hoja`

## ⚙️ Características

### 1. **Interfaz tipo Excel**
- Tabla profesional estilo IDE con tema oscuro
- 6 columnas: ID | Fecha | Cuenta | Monto | Tipo | Descripción
- Navegación total con teclado (flechas, Enter, Tab)
- Soporte para selección múltiple

### 2. **Filtros Avanzados**
Filtra tus transacciones por:
- **Cuenta**: Selecciona la cuenta específica
- **Tipo**: Ingreso, Egreso, Inversión, Costo
- **Rango de fechas**: Desde y Hasta

Los filtros se aplican automáticamente mientras escribes.

### 3. **Edición Inline**
Haz doble clic en una celda para editar:
- **Monto** ($): Edita el valor de la transacción
- **Descripción**: Edita los detalles

Presiona **Enter** para guardar o **Escape** para cancelar.

### 5. **Crear Nuevas Transacciones** ⭐ AUTO-GUARDADO
Ahora puedes agregar transacciones directamente desde la última fila de la hoja:
1. Navega hasta la última fila (debajo de todas las transacciones existentes)
2. Haz doble clic en una celda para editar:
   - **Fecha**: Selecciona o ingresa la fecha (opcional, por defecto es hoy)
   - **Cuenta**: Selecciona de tu lista de cuentas *(requerido)*
   - **Monto**: Ingresa el monto de la transacción *(requerido)*
   - **Tipo**: Elige entre Ingreso, Egreso, Inversión o Costo *(requerido)*
   - **Descripción**: Agrega detalles opcionales

3. **Auto-guardado**: Una vez que completes los 3 campos requeridos (Cuenta, Monto y Tipo), la transacción se guardará automáticamente
4. Presiona **Enter** o **Tab** para pasar al siguiente campo
5. ¡Listo! La nueva transacción se agregará automáticamente a la tabla

**Campos requeridos para nueva transacción:**
- ✓ Cuenta
- ✓ Monto
- ✓ Tipo
- ✗ Descripción (opcional pero recomendado)
- ✗ Fecha (opcional, usa hoy si no especificas)

**Ejemplo de creación rápida:**
```
Fila Vacía:
✓ Haz doble clic en "Cuenta" → Selecciona "Mi Cuenta Ahorro"
✓ Tab → Presiona Enter en "Monto" → 500.00
✓ Tab → Presiona Enter en "Tipo" → Selecciona "ingreso"
✓ ¡Automáticamente se guarda! ✓
```
| Botón | Función |
|-------|---------|
| 🔄 | Recarga las transacciones |
| ↓ CSV | Exporta a archivo CSV |
| 🗑 | Elimina la fila seleccionada |

### 5. **Estadísticas en Vivo**
En la barra inferior ves automáticamente:
- **TOTAL**: Ingresos menos egresos
- **INGRESOS**: Suma total de ingresos
- **EGRESOS**: Suma total de egresos
- **FILAS**: Cantidad de transacciones

## 🎮 Controles del Teclado

| Tecla | Acción |
|-------|--------|
| **↑ ↓ ← →** | Navegar entre celdas |
| **Enter** | Guardar cambios o editar la celda (en filas nuevas) |
| **Tab** | Ir a la siguiente columna y guardar |
| **F2** | Activar edición en la celda actual |
| **Escape** | Cancelar edición |
| **Delete** | Limpiar celda |

**Nota**: En filas nuevas, cuando completes los 3 campos requeridos (Cuenta, Monto, Tipo), la transacción se guardará automáticamente sin necesidad de un botón adicional.

## 📝 Flujo de Uso

### Para agregar una nueva transacción:
1. Navega hasta la última fila (debajo de todas las transacciones)
2. Haz doble clic en la celda que quieres editar
3. Completa los campos: Fecha, Cuenta, Monto, Tipo y Descripción
4. Presiona **Enter** para crear la transacción
5. La nueva transacción se agregará automáticamente a la tabla

### Para editar una transacción existente:
1. Navega hasta la fila que quieres editar (usa flechas)
2. Haz doble clic en la celda (Monto o Descripción)
3. Modifica el valor
4. Presiona **Enter** para guardar

### Para eliminar una transacción:
1. Haz clic en la fila que quieres eliminar
2. Presiona el botón **🗑 Eliminar**
3. Confirma la acción

### Para exportar tus datos:
1. Aplica los filtros que quieras (opcional)
2. Presiona el botón **↓ CSV**
3. Se descargará un archivo `transacciones_FECHA.csv`

## 🔒 Seguridad

- Solo ves tus propias transacciones
- Cada cambio está protegido por token CSRF
- Los saldos de cuentas se actualizan automáticamente
- Las operaciones son transaccionales (todo o nada)

## 🎨 Tema Visual

- **Tema oscuro profesional**: Fácil para la vista
- **Colores por tipo**:
  - 🟢 **Verde**: Ingresos
  - 🔴 **Rojo**: Egresos
- **Indicadores visuales**: Celda activa, selección, errores

## 📈 Ejemplo de Uso

```
Filtros:
- Cuenta: Mi Cuanta Ahorro
- Tipo: Ingreso
- Desde: 2024-01-01
- Hasta: 2024-12-31

Resultado:
├─ ID 1 | 2024-01-15 | Mi Cuenta Ahorro | $500.00 | ingreso | Salario
├─ ID 2 | 2024-02-15 | Mi Cuenta Ahorro | $500.00 | ingreso | Salario
└─ ID 3 | 2024-03-15 | Mi Cuenta Ahorro | $500.00 | ingreso | Salario

TOTAL: $1,500.00
```

## ❓ Preguntas Frecuentes

**P: ¿Puedo agregar nuevas transacciones desde la hoja?**
R: ¡Sí! Ahora puedes agregar transacciones directamente desde la última fila. Se guardan automáticamente cuando completas los 3 campos requeridos (Cuenta, Monto y Tipo).

**P: ¿Necesito hacer clic en un botón "Guardar"?**
R: No, el auto-guardado se activa automáticamente cuando tienes los datos requeridos completos. ¡Sin necesidad de submit!

**P: ¿Cuál es la forma más rápida de agregar una transacción?**
R: Ve a la última fila, haz doble clic en Cuenta, selecciona, Tab, ingresa Monto, Tab, selecciona Tipo → ¡Se guarda sola!

**P: ¿Puedo cambiar la fecha de la transacción?**
R: Sí, ahora puedes editar la fecha en la nueva transacción. Para transacciones existentes, puedes usar el formulario estándar.

**P: ¿Puedo tener varias hojas para diferentes cuentas?**
R: Sí, usa el filtro de "Cuenta" para ver transacciones de diferentes cuentas.

## 🚀 Próximas Mejoras

En el futuro podría incluir:
- ✏️ Edición de fechas en transacciones existentes
- ✓ ➕ **Agregar transacciones directamente desde la hoja** (IMPLEMENTADO)
- 📊 Gráficos en tiempo real
- 📥 Importar desde CSV
- 🔀 Múltiples hojas por cuenta
- 🖨️ Impresión y formato PDF

---

¿Necesitas ayuda? El formulario estándar en `/transacciones` también está disponible.
