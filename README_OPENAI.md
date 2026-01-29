# 📋 REFERENCIA RÁPIDA - ARCHIVOS Y UBICACIONES

## 🎯 Archivos Clave

| Archivo | Ubicación | Propósito | Estado |
|---------|-----------|----------|--------|
| AiChatService | `app/Services/AiChatService.php` | Conecta con OpenAI | ✅ Creado |
| AiChatController | `app/Http/Controllers/AiChatController.php` | Maneja requests | ✅ Creado |
| AiInteraction | `app/Models/AiInteraction.php` | Modelo BD | ✅ Creado |
| Migration | `database/migrations/2026_01_18_120000_create_ai_interactions_table.php` | Crea tabla | ✅ Creado |
| Widget | `resources/views/components/ai-chat-widget.blade.php` | UI flotante | ✅ Creado |
| Config | `config/services.php` | Config OpenAI | ✅ Modificado |
| Routes | `routes/web.php` | Endpoints | ✅ Modificado |
| Layout | `resources/views/layouts/app.blade.php` | Incluye widget | ✅ Modificado |
| Env | `.env` | Variables | ✅ Modificado |

---

## 🔗 Rutas Disponibles

```
POST   /ai/chat           → Enviar mensaje al chat
GET    /ai/test           → Página de pruebas
GET    /ai/debug          → Panel de diagnóstico
```

---

## 📊 Base de Datos

**Tabla**: `ai_interactions`

| Columna | Tipo | Descripción |
|---------|------|-------------|
| id | BIGINT UNSIGNED | PK |
| user_id | BIGINT UNSIGNED | FK users |
| prompt_id | BIGINT UNSIGNED | FK prompts (nullable) |
| request_json | JSON | Mensaje + contexto enviado |
| response_json | JSON | Respuesta de OpenAI |
| created_at | TIMESTAMP | Fecha creación |
| updated_at | TIMESTAMP | Fecha actualización |

---

## 🔐 Configuración Requerida

```env
OPENAI_API_KEY=sk-... ← Debe estar en .env
OPENAI_MODEL=gpt-4o-mini ← Debe estar en .env
DB_CONNECTION=mysql ← Ya debe estar
```

---

## 📚 Documentación

| Archivo | Contenido |
|---------|----------|
| `QUICK_FIX.md` | Solución en 3 pasos (LEER PRIMERO) |
| `SETUP_OPENAI.md` | Guía completa de instalación |
| `GUIA_VISUAL.md` | Pasos visuales con detalles |
| `TROUBLESHOOTING.md` | Solución de problemas |
| `RESUMEN_IMPLEMENTACION.md` | Qué se creó y cómo funciona |

---

## ⚙️ Componentes

### Frontend
- **Widget Component**: `resources/views/components/ai-chat-widget.blade.php`
  - Botón flotante 🤖
  - Panel de chat
  - Historial en localStorage
  - CSRF token handling

### Backend
- **Service**: `app/Services/AiChatService.php`
  - Llamadas a OpenAI
  - Construir prompts con contexto
  - Manejo de errores

- **Controller**: `app/Http/Controllers/AiChatController.php`
  - Validar requests
  - Rate limiting
  - Guardar a BD

- **Model**: `app/Models/AiInteraction.php`
  - Relación con User
  - Relación con Prompt

---

## 🚀 Flujo de Uso

```
1. Usuario autenticado accede a página
   ↓
2. Layout incluye ai-chat-widget
   ↓
3. Widget se renderiza (aparece botón 🤖)
   ↓
4. Usuario hace clic y abre panel
   ↓
5. Usuario escribe mensaje
   ↓
6. JavaScript envía POST /ai/chat (con CSRF)
   ↓
7. Laravel valida + rate limit
   ↓
8. AiChatController invoca AiChatService
   ↓
9. Service conecta con OpenAI API
   ↓
10. Guarda request + response en ai_interactions
   ↓
11. Retorna JSON con respuesta
   ↓
12. Frontend muestra respuesta en panel
   ↓
13. Historial se guarda en localStorage
```

---

## 🔍 Puntos de Verificación

- [ ] Tabla `ai_interactions` existe en BD
- [ ] `.env` tiene `OPENAI_API_KEY` y `OPENAI_MODEL`
- [ ] `app/Services/AiChatService.php` existe
- [ ] `app/Http/Controllers/AiChatController.php` existe
- [ ] `resources/views/components/ai-chat-widget.blade.php` existe
- [ ] `routes/web.php` tiene rutas `/ai/*`
- [ ] `resources/views/layouts/app.blade.php` incluye widget
- [ ] Laravel está corriendo (`php artisan serve`)
- [ ] Usuario está autenticado (@auth)

---

## 🛠️ Comandos Útiles

```bash
# Ver rutas AI
php artisan route:list | findstr "ai"

# Limpiar caché
php artisan config:clear
php artisan cache:clear

# Ver config
php artisan tinker
>>> config('services.openai')

# Ver tabla
>>> Schema::hasTable('ai_interactions')
>>> DB::table('ai_interactions')->count()

# Reiniciar
Ctrl+C
php artisan serve
```

---

## 📞 Debugging

```
Si algo no funciona:
1. Abre: http://localhost:8000/ai/debug
2. Ejecuta pruebas
3. Lee los errores mostrados
4. Sigue las instrucciones
```

---

**¿LISTO? Ejecuta QUICK_FIX.md**
