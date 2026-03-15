# 🤖 Asesor Financiero IA - Guía de Implementación

Tu sistema de chat con inteligencia artificial está completamente configurado. Aquí te mostro cómo usarlo.

## 📋 Tabla de Contenidos
1. [Configuración Inicial](#configuración-inicial)
2. [Características](#características)
3. [Cómo Usarlo](#cómo-usarlo)
4. [Gestión del Servidor](#gestión-del-servidor)
5. [Solución de Problemas](#solución-de-problemas)

---

## ⚙️ Configuración Inicial

### 1. Agregar tu API Key de OpenAI

El sistema ya está preparado para usar OpenAI. Solo necesitas agregar tu clave API:

**Paso 1:** Abre el archivo `.env`

**Paso 2:** Busca la línea:
```
OPENAI_API_KEY=sk-your-openai-api-key-here
```

**Paso 3:** Reemplázala con tu clave real:
```
OPENAI_API_KEY=sk-proj-xxxxxxxxxxxxxxxxxxxxxxxx
```

**Cómo obtener tu API Key:**
- Ve a https://platform.openai.com/account/api-keys
- Crea una nueva clave secreta
- Cópiala (solo aparece una vez)

### 2. Configurar la Cola de Procesamiento

El sistema procesa los mensajes de IA de forma **asincrónica** usando una cola. Necesitas mantener el queue listener corriendo:

```bash
php artisan queue:listen
```

**O durante desarrollo (comando completo):**
```bash
composer run dev
```

Esto iniciará automáticamente:
- Servidor PHP
- Queue listener
- Vite (assets)
- Pail (logs)

---

## 🎯 Características

### ✨ Análisis Financiero Inteligente

El chat analiza automáticamente:

- **Cuentas del Usuario**: Saldos actuales, nombres y tipos
- **Transacciones Recientes**: Últimas 20 transacciones
- **Totalización**: Ingresos y gastos totales
- **Contexto Personalizado**: Cada chat incluye datos específicos del usuario

### 🏗️ Estructura del Sistema

```
┌─────────────────────────────────────────────┐
│         Interfaz Web del Chat                │
│  (resources/views/chat/)                    │
└────────────────────┬────────────────────────┘
                     │
┌────────────────────▼────────────────────────┐
│      ChatController                         │
│  (app/Http/Controllers/)                    │
└────────────────────┬────────────────────────┘
                     │
        ┌────────────┴────────────┐
        │                         │
        ▼                         ▼
    Base de Datos         Cola de Trabajos
    (Chats, Messages)     (ProcessChatMessage)
        │                         │
        │                         ▼
        │                  OpenAI API
        │                         │
        └────────────┬────────────┘
                     │
                     ▼
            Respuestas Almacenadas
```

---

## 🚀 Cómo Usarlo

### Acceder al Chat

1. **Autenticarse** en tu aplicación
2. **Tener suscripción activa** (según tus middleware)
3. **Ir a "Asesor IA"** en la barra lateral
4. **Ver historial** de todos tus chats o crear uno nuevo

### Crear un Nuevo Chat

```
1. Haz clic en "Nuevo Chat"
2. Dale un título descriptivo:
   - "Análisis de Gastos Mensuales"
   - "Preguntas sobre Impuestos"
   - "Optimización de Ingresos"
3. Elige el modelo de IA (recomendado: GPT-4o Mini)
4. ¡Haz clic en "Crear Chat"!
```

### Conversar con el IA

```
1. Escribe tu pregunta en el campo de entrada
2. Ejemplos de preguntas:
   ✓ "¿Cuáles fueron mis gastos más altos este mes?"
   ✓ "Dame un resumen de mis ingresos"
   ✓ "¿Cuál es mi saldo total?"
   ✓ "¿Cómo puedo reducir mis gastos?"
   ✓ "Analiza mis patrones de gasto"
4. El IA procesará tu pregunta
5. Recibirás una respuesta personalizada basada en tus datos
```

### Modelos de IA Disponibles

| Modelo | Velocidad | Costo | Recomendado |
|--------|-----------|-------|-------------|
| GPT-4o Mini | ⚡⚡⚡ Rápido | 💰 Económico | ✓ |
| GPT-4o | ⚡⚡ Bueno | 💰💰 Medio | Para análisis complejos |
| GPT-4 Turbo | ⚡ Lento | 💰💰💰 Caro | Máxima precisión |
| GPT-4 | ⚡ Muy Lento | 💰💰💰💰 Muy Caro | No recomendado |
| GPT-3.5 Turbo | ⚡⚡⚡ Muy Rápido | 💰 Muy Económico | Para pruebas |

---

## 🔧 Gestión del Servidor

### Iniciando el Desarrollo

```bash
# Opción 1: Comando simple
php artisan serve

# Pero también necesitas la cola en otra terminal:
php artisan queue:listen

# Opción 2: Todo automático (recomendado)
composer run dev
```

### Procesar Mensajes Manualmente

Si los mensajes no se procesan automáticamente:

```bash
# En otra terminal
php artisan queue:listen --tries=1
```

### Ver Logs en Tiempo Real

```bash
php artisan pail
```

### Limpiar la Cola (si hay errores)

```bash
# Ver trabajos fallidos
php artisan queue:failed

# Relanzar un trabajo
php artisan queue:retry {id}

# Limpiar todos los fallidos
php artisan queue:flush
```

---

## 🗂️ Estructura de Archivos


```
proyecto/
├── app/
│   ├── Models/
│   │   ├── Chat.php              ← Modelo de chat
│   │   └── ChatMessage.php       ← Modelo de mensajes
│   ├── Http/Controllers/
│   │   └── ChatController.php    ← Lógica principal
│   └── Jobs/
│       └── ProcessChatMessage.php ← Procesa con OpenAI
├── database/migrations/
│   ├── *_create_chats_table.php  ← Tabla de chats
│   └── *_create_chat_messages_table.php ← Tabla de mensajes
├── resources/views/chat/
│   ├── index.blade.php           ← Lista de chats
│   ├── create.blade.php          ← Crear nuevo chat
│   └── show.blade.php            ← Interfaz del chat
└── routes/
    └── web.php                    ← Rutas del chat
```

---

## 📊 Base de Datos

### Tabla: Chats

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | int | ID único |
| user_id | int | Usuario dueño |
| title | string | Nombre del chat |
| model | string | Modelo IA usado (ej: gpt-4o-mini) |
| system_prompt | text | Contexto con datos financieros |
| created_at | timestamp | Creación |
| updated_at | timestamp | Última actualización |
| deleted_at | timestamp | (soft delete) |

### Tabla: Chat Messages

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | int | ID único |
| chat_id | int | Chat al que pertenece |
| role | enum | 'user' o 'assistant' |
| content | longText | Contenido del mensaje |
| tokens_used | int | Tokens consumidos |
| status | enum | 'pending', 'processing', 'completed', 'failed' |
| created_at | timestamp | Creación |
| updated_at | timestamp | Actualización |

---

## 🐛 Solución de Problemas

### "No me aparece el botón de Asesor IA"

**Solución:**
- Verifica que tengas suscripción activa
- Recarga la página
- Borra cookies del navegador

### "El chat no responde"

**Solución:**
```bash
# 1. Verifica que la cola está corriendo:
php artisan queue:listen

# 2. Verifica tu API Key en .env
echo $OPENAI_API_KEY

# 3. Ver logs:
php artisan pail
```

### "Error: Invalid OpenAI API Key"

**Solución:**
1. Ve a https://platform.openai.com/account/api-keys
2. Verifica que tu clave no haya expirado
3. Crea una nueva clave
4. Actualiza el `.env`
5. Reinicia el servidor

### "¡Los mensajes se quedan en 'Procesando...'"

**Solución:**
```bash
# Verifica que la cola está activa:
php artisan queue:listen

# Ve en otra terminal los logs:
php artisan pail

# Si hay muchos fallidos:
php artisan queue:flush
```

### "El contexto financiero no se actualiza"

**Solución:**
- El contexto se genera automáticamente al crear el chat
- Si agregaste transacciones nuevas, crea un nuevo chat
- O elimina el chat viejo y crea uno nuevo

---

## 💡 Tips & Trucos

### Preguntas Efectivas

❌ Malo: "¿Cuánto tengo?"
✅ Bueno: "¿Cuál es mi saldo total y cómo se distribuye entre mis cuentas?"

❌ Malo: "Gastos"
✅ Bueno: "Analiza mi patrón de gastos y dame recomendaciones para ahorrar"

### Monitoreo

```bash
# Terminal 1: Servidor
php artisan serve

# Terminal 2: Cola
php artisan queue:listen

# Terminal 3: Logs en vivo
php artisan pail
```

### Depuración

Si algo falla, mira los logs:
```bash
tail -f storage/logs/laravel.log
```

---

## 🔐 Seguridad

✅ **Implementado:**
- Validación de usuario (solo puede ver sus chats)
- Protección CSRF
- Rate limiting con Cola
- Datos sensibles no se loguean

⚠️ **Recomendaciones:**
- Mantén tu API Key en secreto
- No compartas tu `.env`
- Monitorea el uso de OpenAI en tu dashboard
- Establece límites de gasto en OpenAI

---

## 📞 Soporte

Si tienes problemas:

1. Verifica que el queue listener está corriendo
2. Mira `php artisan pail` para ver los logs
3. Verifica tu API Key de OpenAI
4. Revisa que tienes suscripción activa

---

## 🎉 ¡Listo!

Tu Asesor Financiero IA está completamente funcional. 

**Próximos pasos:**
1. ✅ Configura tu OPENAI_API_KEY
2. ✅ Inicia el servidor: `composer run dev`
3. ✅ Accede a "Asesor IA" en la barra lateral
4. ✅ ¡Crea tu primer chat!

¡Que disfrutes! 🚀
