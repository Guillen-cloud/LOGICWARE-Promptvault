# 🚀 GUÍA DE INSTALACIÓN - OpenAI Chat Widget

## ✅ PASO 1: Configurar Variables de Entorno

Abre el archivo `.env` y asegúrate de tener:

```env
# Base de datos (ya debe estar configurada)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=promptvault
DB_USERNAME=root
DB_PASSWORD=

# OpenAI Configuration - AGREGA ESTO:
OPENAI_API_KEY=sk-xxxxxxxxxxxxxxxxxxxxx
OPENAI_MODEL=gpt-4o-mini
```

**Cómo obtener tu OPENAI_API_KEY:**
1. Ve a https://platform.openai.com/api-keys
2. Crea una nueva API key
3. Cópiala en `OPENAI_API_KEY` (NO la compartas públicamente)

---

## ✅ PASO 2: Crear la Tabla en la Base de Datos

### Opción A: PhpMyAdmin (Recomendado)
1. Abre http://localhost/phpmyadmin
2. Selecciona la base de datos `promptvault`
3. Ve a la pestaña "SQL"
4. Copia y ejecuta este SQL:

```sql
-- Crear tabla ai_interactions
CREATE TABLE IF NOT EXISTS `ai_interactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `prompt_id` bigint unsigned DEFAULT NULL,
  `request_json` json NOT NULL,
  `response_json` json NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `ai_interactions_user_id_index` (`user_id`),
  KEY `ai_interactions_prompt_id_index` (`prompt_id`),
  CONSTRAINT `ai_interactions_prompt_id_foreign` FOREIGN KEY (`prompt_id`) REFERENCES `prompts` (`id`) ON DELETE SET NULL,
  CONSTRAINT `ai_interactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Registrar la migración
INSERT IGNORE INTO migrations (migration, batch) VALUES 
('2026_01_18_120000_create_ai_interactions_table', 99);
```

### Opción B: Importar archivo SQL
1. Abre PhpMyAdmin
2. Selecciona `promptvault`
3. Ve a "Importar"
4. Sube el archivo: `database/migrations/ai_interactions.sql`

---

## ✅ PASO 3: Verificar los Archivos Creados

Asegúrate de que existan estos archivos:

```
app/
  ├── Services/
  │   └── AiChatService.php ✓
  ├── Http/Controllers/
  │   └── AiChatController.php ✓
  └── Models/
      └── AiInteraction.php ✓

config/
  └── services.php (modificado) ✓

routes/
  └── web.php (modificado con rutas /ai/chat) ✓

app/Providers/
  └── RouteServiceProvider.php (modificado con rate limiter) ✓

resources/views/
  ├── components/
  │   └── ai-chat-widget.blade.php ✓
  ├── ai-test.blade.php ✓
  ├── ai-debug.blade.php ✓
  └── layouts/
      └── app.blade.php (modificado con @include('components.ai-chat-widget')) ✓
```

---

## ✅ PASO 4: Verificar la Instalación

### Via Browser
1. Abre: `http://localhost:8000/ai/debug`
2. Ejecuta las pruebas
3. Debería mostrar ✓ en todos los checks

### Via Terminal (Artisan)
```bash
php artisan route:list | grep ai
php artisan config:show services.openai
php artisan tinker
>>> config('services.openai.key') // Debe mostrar tu API key
>>> config('services.openai.model') // Debe mostrar gpt-4o-mini
```

---

## ✅ PASO 5: Probar el Sistema

### Prueba 1: Ver el Widget
1. Inicia sesión en tu aplicación
2. Abre cualquier página autenticada
3. Deberías ver un botón 🤖 en la esquina inferior derecha
4. Haz clic para abrir el chat

### Prueba 2: Enviar un Mensaje
1. Abre el widget
2. Escribe: `"Hola, ¿cómo funcionas?"`
3. Presiona Enter o haz clic en el botón de enviar
4. Deberías recibir una respuesta de OpenAI en 2-5 segundos

### Prueba 3: Con Contexto
1. Ve a: `http://localhost:8000/ai/test`
2. Llena los campos:
   - Prompt Actual: `"Actúa como un experto en marketing"`
   - Objetivo: `"Generar ideas para campañas"`
   - Tono: `"Profesional pero creativo"`
3. Haz clic en el widget y luego en "⚡ Mejorar"
4. El AI usará el contexto para mejorar

---

## 🔧 Troubleshooting

### Error: "Falta configurar OPENAI_API_KEY"
- **Causa**: La variable no está en `.env`
- **Solución**: Agrega `OPENAI_API_KEY=sk-...` al archivo `.env`
- **Reinicia**: El servidor de desarrollo después de cambiar `.env`

### Error: "Base table or view not found: ai_interactions"
- **Causa**: La tabla no fue creada
- **Solución**: Ejecuta el SQL del PASO 2 en PhpMyAdmin

### El widget no aparece en la página
- **Causa**: No está incluido en el layout
- **Solución**: Verifica que `resources/views/layouts/app.blade.php` tenga:
  ```blade
  @include('components.ai-chat-widget')
  ```

### Error 429 (Rate Limit)
- **Causa**: Se alcanzó el límite de 30 solicitudes/10 minutos
- **Solución**: Espera 10 minutos o prueba con otra cuenta

### Error 401/403 (Autenticación OpenAI)
- **Causa**: La API key es inválida o no tiene créditos
- **Solución**: 
  1. Verifica tu API key en https://platform.openai.com/api-keys
  2. Verifica tu cuenta en https://platform.openai.com/account/billing/overview
  3. Asegúrate de tener créditos disponibles

### Error: "CSRF token mismatch"
- **Causa**: El token CSRF no se envía correctamente
- **Solución**: Asegúrate que el meta tag está en el `<head>`:
  ```blade
  <meta name="csrf-token" content="{{ csrf_token() }}">
  ```

---

## 📊 Verificar en la Base de Datos

Ejecuta esta query en PhpMyAdmin para ver tus interacciones:

```sql
SELECT ai.*, u.name as usuario FROM ai_interactions ai
JOIN users u ON ai.user_id = u.id
ORDER BY ai.created_at DESC
LIMIT 10;
```

---

## 🎯 Próximos Pasos

1. **Personalizar el system prompt**: Edita `app/Services/AiChatService.php` línea 130
2. **Cambiar el modelo**: Cambia `OPENAI_MODEL` a `gpt-4o` para mejor calidad
3. **Agregar análisis**: Crea dashboards con los datos de `ai_interactions`
4. **Mejorar UI**: Modifica `resources/views/components/ai-chat-widget.blade.php`

---

## 📚 Archivos de Referencia

- **Modelo de datos**: `app/Models/AiInteraction.php`
- **Lógica de OpenAI**: `app/Services/AiChatService.php`
- **Rutas**: `routes/web.php` (líneas con `/ai/`)
- **Widget UI**: `resources/views/components/ai-chat-widget.blade.php`
- **Rate Limiter**: `app/Providers/RouteServiceProvider.php`

---

## ✨ ¡Listo!

Si todo funciona correctamente, tendrás:
✓ Un chat flotante en todas las páginas autenticadas
✓ Integración con OpenAI (gpt-4o-mini)
✓ Auditoría de todas las interacciones
✓ Rate limiting para evitar abusos
✓ Contexto automático de prompts
✓ Historial persistente en localStorage

**¿Problemas?** Ejecuta `http://localhost:8000/ai/debug` para diagnosticar.
