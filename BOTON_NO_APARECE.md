# ❌ "No me sale el botón del chatbot"

## 🔍 Diagnóstico Rápido

### Paso 1: ¿Iniciaste sesión?
```
✗ NO INICIASTE SESIÓN
  → El widget SOLO aparece para usuarios autenticados
  → Solución: Inicia sesión primero

✓ SÍ INICIASTE SESIÓN
  → Continúa con el Paso 2
```

### Paso 2: Abre la página de diagnóstico
```
Abre: http://localhost:8000/diagnostico

Deberías ver un checklist que te dice:
✓ Usuario autenticado?
✓ Meta CSRF token?
✓ Widget HTML existe?
✓ Botón del widget?
✓ Widget visible?
✓ LocalStorage?

Si todo es ✓ (verde): El widget DEBERÍA verse
Si hay ✗ (rojo): Te indica qué falta
```

---

## 🎯 Soluciones Comunes

### Causa 1: No iniciaste sesión
```
❌ PROBLEMA: Estás viendo la página sin estar autenticado
✓ SOLUCIÓN:
   1. Haz clic en "Inicia Sesión" o "Registrarse"
   2. Completa el formulario
   3. Accede a tu cuenta
   4. Ahora debería aparecer el botón 🤖 en esquina inferior derecha
```

### Causa 2: Página cacheada
```
❌ PROBLEMA: El navegador tiene versión vieja
✓ SOLUCIÓN:
   Presiona: Ctrl+Shift+R (limpia caché)
   O:        Ctrl+F5
   
   Deberías ver el botón 🤖 ahora
```

### Causa 3: Laravel no reiniciado
```
❌ PROBLEMA: Los cambios no se aplicaron
✓ SOLUCIÓN:
   1. En terminal, presiona Ctrl+C
   2. Ejecuta: php artisan serve
   3. Recarga la página (F5)
   4. Ahora debería aparecer
```

### Causa 4: Widget no está incluido en el layout
```
❌ PROBLEMA: El archivo layout no tiene el widget
✓ SOLUCIÓN:
   1. Abre: resources/views/layouts/app.blade.php
   2. Antes de </body>, debe estar:
      @include('components.ai-chat-widget-simple')
   3. Si NO está, agrégala
   4. Recarga la página
```

### Causa 5: Error en la consola
```
❌ PROBLEMA: Hay un error de JavaScript
✓ SOLUCIÓN:
   1. Presiona F12 (abre consola)
   2. Ve a "Console"
   3. Busca mensajes ROJOS
   4. Copia el error exacto
   5. Comparte el error
```

---

## 📋 Checklist de Verificación

- [ ] ¿Iniciaste sesión?
- [ ] ¿La página de diagnóstico muestra todo verde?
- [ ] ¿Recargaste la página con Ctrl+Shift+R?
- [ ] ¿Reiniciaste Laravel (Ctrl+C, php artisan serve)?
- [ ] ¿Miras la esquina INFERIOR DERECHA?
- [ ] ¿La página está autenticada (veo nombre de usuario)?

---

## 🔧 Verificación Técnica

### En la Consola (F12 → Console)

Ejecuta esto:

```javascript
// Verificar elemento
const widget = document.getElementById('ai-chat-widget');
console.log('Widget existe:', !!widget);
console.log('Widget HTML:', widget?.outerHTML.substring(0, 100));

// Verificar botón
const button = document.getElementById('ai-chat-toggle');
console.log('Botón existe:', !!button);

// Verificar si está en el DOM
console.log('Widget en el árbol:', document.body.contains(widget));
```

Deberías ver:
```
Widget existe: true
Widget HTML: <div id="ai-chat-widget" class="ai-chat-widget">...
Botón existe: true
Widget en el árbol: true
```

---

## 🚨 Si aún no funciona

### Plan de Acción

1. **Abre**: http://localhost:8000/diagnostico
2. **Toma screenshot** de los resultados
3. **Abre consola**: F12 → Console
4. **Copia cualquier error rojo**
5. **Comparte**: El screenshot y los errores

Con eso podré diagnosticar exactamente qué está faltando.

---

## 💡 Ubicación del Botón

Cuando funcione correctamente, verás el botón aquí:

```
┌─────────────────────────────────┐
│                                 │
│     Tu Página / Dashboard      │
│                                 │
│                                 │
│                                 │
│                            🤖 ← AQUÍ
│                                 │ (esquina inferior derecha)
└─────────────────────────────────┘
```

**Si NO lo ves ahí, es que algo está mal.**

Usa el diagnóstico (http://localhost:8000/diagnostico) para descubrir qué.

---

## ✨ Resumen

| Paso | Acción |
|------|--------|
| 1 | Inicia sesión |
| 2 | Abre http://localhost:8000/diagnostico |
| 3 | Verifica que todo está ✓ (verde) |
| 4 | Si algo está ✗, sigue la solución |
| 5 | Prueba el widget |

**Si todo está verde en diagnóstico pero aún no ves el botón:**
→ Presiona Ctrl+Shift+R (limpia caché del navegador)
