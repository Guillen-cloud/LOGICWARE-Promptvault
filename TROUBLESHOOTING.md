# ✅ CHECKLIST COMPLETO - OpenAI Integration

## 📊 ESTADO ACTUAL

### ✓ Archivos Creados
- [x] `app/Services/AiChatService.php` - Servicio que conecta con OpenAI
- [x] `app/Http/Controllers/AiChatController.php` - Controller para manejar requests del chat
- [x] `app/Models/AiInteraction.php` - Modelo Eloquent para auditoría
- [x] `database/migrations/2026_01_18_120000_create_ai_interactions_table.php` - Migración
- [x] `resources/views/components/ai-chat-widget.blade.php` - Widget flotante (800+ líneas)
- [x] `resources/views/ai-test.blade.php` - Página de pruebas
- [x] `resources/views/ai-debug.blade.php` - Página de diagnóstico

### ✓ Archivos Modificados
- [x] `.env` - Agregadas OPENAI_API_KEY y OPENAI_MODEL
- [x] `config/services.php` - Agregada configuración de OpenAI
- [x] `routes/web.php` - Agregadas rutas POST /ai/chat, GET /ai/test, GET /ai/debug
- [x] `app/Providers/RouteServiceProvider.php` - Agregado rate limiter 'ai-chat' (30 req/10 min)
- [x] `resources/views/layouts/app.blade.php` - Incluido widget con @include('components.ai-chat-widget')
- [x] `.env.example` - Ya contenía placeholders para OpenAI

### ✓ Configuración
- [x] OPENAI_API_KEY configurada en .env ✓
- [x] OPENAI_MODEL = gpt-4o-mini ✓
- [x] DB_CONNECTION = mysql ✓
- [x] Rate limiting configurado ✓

---

## 🎯 QUÉ FALTA (POR QUE NO VES CAMBIOS)

### 1. ❌ LA TABLA NO EXISTE EN LA BD
**Problema**: `ai_interactions` no fue creada en MySQL

**Solución**: Ejecuta ESTE SQL en PhpMyAdmin:

```sql
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
```

**Pasos en PhpMyAdmin:**
1. Ve a http://localhost/phpmyadmin
2. Selecciona base de datos `promptvault`
3. Clic en pestaña "SQL"
4. Copia el SQL anterior
5. Pega en el editor
6. Clic en "Ejecutar"

---

### 2. ❌ EL SERVIDOR NECESITA REINICIARSE

**Problema**: Laravel cachea configuración. Los cambios en `.env` no se aplican hasta reiniciar

**Solución**:
```bash
# Opción 1: Reiniciar servidor
Ctrl+C (si está ejecutándose)
php artisan serve

# Opción 2: Limpiar caché
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan serve
```

---

### 3. ❌ VERIFICA QUE LARAVEL ESTÉ CORRIENDO

**Problema**: Si tu Laravel no está ejecutándose, el widget no funcionará

**Solución**:
```bash
cd "c:\Users\hp\Desktop\Usuaria A\JS\ing Sistemas\6to Semestre\Sistemas de informacion\Proyecto promt\promptvault"
php artisan serve
```

Deberías ver: `INFO  Server running on [http://127.0.0.1:8000]`

---

## 🔍 VERIFICAR QUE TODO ESTÁ EN LUGAR

### Opción 1: Usar la página de DEBUG
1. Abre: http://localhost:8000/ai/debug
2. Debería mostrar un checklist verde

### Opción 2: Verificar archivos manualmente

**En el explorador, revisa que existan:**
```
app/
  └── Services/
      └── AiChatService.php ← Debería estar aquí
  
  └── Http/Controllers/
      └── AiChatController.php ← Debería estar aquí
  
  └── Models/
      └── AiInteraction.php ← Debería estar aquí

  └── Providers/
      └── RouteServiceProvider.php ← Modificado

resources/views/
  ├── components/
  │   └── ai-chat-widget.blade.php ← Debería estar aquí
  ├── ai-test.blade.php ← Debería estar aquí
  ├── ai-debug.blade.php ← Debería estar aquí
  └── layouts/
      └── app.blade.php ← Debe incluir el widget

routes/
  └── web.php ← Debe tener rutas /ai/*

config/
  └── services.php ← Debe tener openai config
```

### Opción 3: Verificar en terminal
```bash
# Ver rutas de AI
php artisan route:list | findstr "ai"

# Salida esperada:
# POST   ai/chat ................................ ai.chat.send
# GET    ai/debug ............................. ai.debug
# GET    ai/test ............................... ai.test
```

---

## 🚀 PASOS PARA PROBAR

### Paso 1: Preparación (UNA VEZ)
1. ✅ Crear tabla en BD (ver arriba)
2. ✅ Asegurar que OPENAI_API_KEY está en .env
3. ✅ Reiniciar servidor Laravel

### Paso 2: Verificar Widget
1. Inicia sesión en http://localhost:8000
2. Abre cualquier página protegida (ej: http://localhost:8000/dashboard)
3. Mira la esquina INFERIOR DERECHA
4. Deberías ver un botón 🤖 AZUL

### Paso 3: Probar el Chat
1. Haz clic en el botón 🤖
2. Se abrirá un panel flotante
3. Escribe: `"Hola, ¿funcionas?"`
4. Presiona Enter
5. Espera 2-5 segundos
6. Deberías recibir una respuesta de OpenAI

### Paso 4: Verificar BD
1. Abre PhpMyAdmin
2. Selecciona `promptvault`
3. Abre tabla `ai_interactions`
4. Deberías ver tu request + response registrados

---

## 💡 SI AÚNNO VES EL WIDGET

### Causa 1: No inició sesión
- ✗ **Problema**: Widget solo aparece para usuarios autenticados (@auth)
- ✓ **Solución**: Inicia sesión primero

### Causa 2: Página no usa el layout correcto
- ✗ **Problema**: Algunos vistas no heredan de `layouts.app`
- ✓ **Solución**: Verifica que la vista use:
  ```blade
  @extends('layouts.app')
  ```

### Causa 3: Browser cache
- ✗ **Problema**: El navegador cachea CSS/JS
- ✓ **Solución**:
  ```
  Ctrl+Shift+R (reload sin cache)
  o
  Ctrl+Shift+Del (limpiar caché)
  ```

### Causa 4: Console errors
- ✗ **Problema**: Hay un error de JavaScript
- ✓ **Solución**:
  ```
  F12 → Console → Busca errores rojos
  ```

---

## 📝 COMANDOS ÚTILES

```bash
# Verificar estructura
ls -la app/Services/
ls -la app/Http/Controllers/
ls -la app/Models/

# Limpiar caché
php artisan config:clear
php artisan cache:clear

# Ver rutas
php artisan route:list | findstr "ai"

# Ver configuración OpenAI
php artisan tinker
>>> config('services.openai')

# Ver tabla en BD
php artisan tinker
>>> Schema::hasTable('ai_interactions')
>>> DB::table('ai_interactions')->count()
```

---

## 🎯 RESULTADO ESPERADO

Una vez todo funcione correctamente:

✓ Ves botón 🤖 en esquina inferior derecha en TODAS las páginas autenticadas
✓ Haces clic y se abre un panel oscuro
✓ Escribes un mensaje
✓ Presionas Enter
✓ El panel muestra "Pensando..." con spinner
✓ Después de 2-5 segundos aparece la respuesta de OpenAI
✓ Puedes seguir escribiendo (historial persiste)
✓ Si recargas la página, el historial sigue ahí (localStorage)
✓ En PhpMyAdmin ves los registros en `ai_interactions`

---

## 🔧 SI ALGO FALLA

### Error: "Error de conexión"
```
1. Verifica que .env tenga OPENAI_API_KEY
2. Verifica que Laravel está corriendo (php artisan serve)
3. Verifica que tienes conexión a internet
4. Verifica que la API key es válida
```

### Error: "Rate limit exceeded"
```
1. Has alcanzado 30 requests en 10 minutos
2. Espera 10 minutos
3. O prueba con otra cuenta de usuario
```

### Error: "CSRF token mismatch"
```
1. Asegúrate que <head> tiene:
   <meta name="csrf-token" content="{{ csrf_token() }}">
2. Recarga la página (F5)
```

### Error: "Base table not found"
```
1. La tabla ai_interactions no existe
2. Ejecuta el SQL en PhpMyAdmin
3. Reinicia Laravel
```

---

## 📞 CONTACTO/DEBUG

Para diagnosticar mejor:

1. Abre: http://localhost:8000/ai/debug
2. Ejecuta "Ejecutar Pruebas"
3. Toma screenshot de los resultados
4. Copia el output de la consola (F12 → Console)
5. Comparte los errores

---

**¿Listó? Sigue estos pasos y debería funcionar perfecto.** 🎉
