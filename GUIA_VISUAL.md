# 🎬 GUÍA VISUAL PASO A PASO

## Problema: "Ya ejecuté el SQL pero aún no veo cambios en mi página"

Aquí está exactamente QUÉ está pasando y QUÉ FALTA hacer:

---

## 📍 PASO 1: Verificar que la tabla existe

### Via PhpMyAdmin (Recomendado)

```
1. Abre: http://localhost/phpmyadmin
2. En el panel izquierdo, haz clic en "promptvault"
   
   [Base de datos]
   promptvault ← Haz clic aquí
   
3. Ahora deberías ver una lista de tablas:
   
   Tables in promptvault
   ✓ actividades
   ✓ categorias
   ✓ etiquetas
   ✓ migrations ← Busca aquí
   ✓ prompts
   ✓ users
   ✓ versions
   ...
   
   ¿VES "ai_interactions"? 
   NO  → Ir a PASO 2
   YES → Ir a PASO 3
```

---

## 📋 PASO 2: Crear la tabla (SI NO EXISTE)

### Método A: SQL directo en PhpMyAdmin

```
1. En phpMyAdmin, ve a la pestaña "SQL"
   
   [Estructura] [SQL] ← Haz clic en SQL
   
2. Copia ESTE SQL completo:

---COPIAR ESTO---

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

---FIN---

3. Pega en el editor (Ctrl+V)

   +--------- SQL ---------+
   | CREATE TABLE IF NOT   |
   | EXISTS `ai_interact   | ← El SQL aparecerá aquí
   | ions` (               |
   |   `id` bigint unsig   |
   |   ...                 |
   +------------------------

4. Haz clic en botón "Ejecutar" (abajo)
   
   Debería mostrar:
   "Consulta ejecutada correctamente"
   
5. ¡LISTO! La tabla está creada
```

### Método B: Importar desde archivo

```
1. Ve a: database/migrations/ai_interactions.sql
2. En PhpMyAdmin, clic en pestaña "Importar"
3. Clic en "Seleccionar archivo"
4. Busca: ai_interactions.sql
5. Haz clic en "Importar"
6. Debería mostrar "Consulta ejecutada correctamente"
```

---

## 🔄 PASO 3: Reiniciar Laravel

Después de crear la tabla, **DEBES reiniciar Laravel** para que los cambios se apliquen.

```
1. En la terminal donde corre Laravel, presiona:
   
   Ctrl+C
   
   Deberías ver:
   ^CTerminated
   
2. Luego ejecuta de nuevo:
   
   php artisan serve
   
   Deberías ver:
   INFO  Server running on [http://127.0.0.1:8000]
   
3. ¡Listo! Laravel reinició
```

---

## 🔍 PASO 4: Verificar que todo esté en lugar

### Via Terminal (Rápido)

```bash
cd "c:\Users\hp\Desktop\Usuaria A\JS\ing Sistemas\6to Semestre\Sistemas de informacion\Proyecto promt\promptvault"
php artisan route:list | findstr "ai"
```

Debería mostrar:
```
POST   ai/chat ..................... ai.chat.send
GET    ai/debug .................... ai.debug
GET    ai/test ..................... ai.test
```

Si ves las 3 rutas → ✅ Está bien

---

## 🌐 PASO 5: Ir a tu aplicación

```
1. Abre: http://localhost:8000
2. Inicia sesión con tu usuario
3. Después del login, vas a ver tu dashboard
4. Ahora mira la ESQUINA INFERIOR DERECHA
   
   ┌─────────────────────────┐
   │                         │
   │     Tu aplicación      │
   │                         │
   │                         │
   │                         │
   │                   🤖 ← Debería estar aquí
   └─────────────────────────┘
   
   ¿VES el botón 🤖?
   NO  → Ir a PASO 6
   YES → Ir a PASO 7
```

---

## 🐛 PASO 6: Si NO ves el botón 🤖

### Causa A: No inició sesión

```
✗ PROBLEMA: Estás viendo la página como usuario NO autenticado
✓ SOLUCIÓN: 
   1. Haz clic en "Registrarse" o "Inicia Sesión"
   2. Crea una cuenta o inicia sesión
   3. Vuelve a mirar la esquina inferior derecha
   → Ahora debería estar el botón 🤖
```

### Causa B: Browser cache

```
✗ PROBLEMA: El navegador tiene CSS/JS en caché
✓ SOLUCIÓN: Presiona
   
   Windows: Ctrl+Shift+R
   Mac:     Cmd+Shift+R
   
   Esto recarga la página sin cache
   → Debería aparecer el botón 🤖
```

### Causa C: Error en consola

```
✗ PROBLEMA: Hay un error de JavaScript
✓ SOLUCIÓN:
   1. Presiona F12 (abre consola de desarrollador)
   2. Ve a pestaña "Console"
   3. Busca mensajes rojos (errores)
   4. Copia los errores
   5. Comparte en STEP 8 (debugging)
```

### Causa D: Widget no está incluido en el layout

```
✗ PROBLEMA: El archivo resources/views/layouts/app.blade.php
           no incluye el widget
           
✓ SOLUCIÓN:
   1. Abre: resources/views/layouts/app.blade.php
   2. Busca: </body>
   3. Antes de </body>, debe estar:
      @include('components.ai-chat-widget')
   4. Si NO está, agrega esta línea
   5. Guarda
   6. Recarga la página
```

---

## ✨ PASO 7: Probar el chat

```
1. Ves el botón 🤖 en esquina inferior derecha
2. Haz clic en él
   → Se abre un panel oscuro
   
3. En el cuadro de texto, escribe:
   "Hola, ¿cómo estás?"
   
4. Presiona Enter
   → Debería mostrar: "Pensando..." con un spinner
   
5. Espera 2-5 segundos
   → Debería aparecertu respuesta de OpenAI
   
6. ¡FUNCIONÓ! 🎉
```

---

## 📊 PASO 8: Verificar en la base de datos

```
1. Abre PhpMyAdmin
2. Selecciona la base de datos "promptvault"
3. Busca la tabla "ai_interactions"
4. Haz clic en "Examinar"
   
   Debería ver:
   ID | user_id | prompt_id | request_json | response_json | ...
   1  | 1       | NULL      | {...}        | {...}         |
   2  | 1       | NULL      | {...}        | {...}         |
   ...
   
5. Tus mensajes están siendo guardados ✓
```

---

## 🎯 RESUMEN RÁPIDO

| Paso | Acción | Verificación |
|------|--------|--------------|
| 1 | Crear tabla en BD | Ves `ai_interactions` en PhpMyAdmin |
| 2 | Reiniciar Laravel | `php artisan serve` |
| 3 | Ir a app | Inicia sesión en http://localhost:8000 |
| 4 | Buscar widget | Ves botón 🤖 en esquina inferior derecha |
| 5 | Probar | Escribes mensaje y recibes respuesta |
| 6 | Verificar BD | Ves registros en `ai_interactions` |

---

## 🚨 SI ALGO FALLA EN CUALQUIER PASO

### Opción 1: Usar la página de DEBUG
```
1. Abre: http://localhost:8000/ai/debug
2. Haz clic en "Ejecutar Pruebas"
3. Ver qué falla
4. Seguir las instrucciones de error
```

### Opción 2: Ver logs
```bash
# Ver últimos 50 líneas de errores
tail -f storage/logs/laravel.log

# En PowerShell:
Get-Content storage\logs\laravel.log -Tail 50 -Wait
```

### Opción 3: Consola de desarrollador
```
F12 → Console → Buscar mensajes rojos
Copiar el mensaje de error completo
```

---

## ✅ CHECKLIST FINAL

- [ ] Tabla `ai_interactions` creada en PhpMyAdmin
- [ ] Laravel reiniciado (`php artisan serve`)
- [ ] Inicia sesión en la aplicación
- [ ] Ves botón 🤖 en esquina inferior derecha
- [ ] Puedes escribir mensajes en el chat
- [ ] Recibes respuestas de OpenAI
- [ ] Los registros aparecen en `ai_interactions` table

¿Completaste todos? **¡FELICIDADES! 🎉 El sistema está funcionando perfectamente**

---

Si aún tienes problemas, ejecuta:
```bash
http://localhost:8000/ai/debug
```
Y comparte el resultado.
