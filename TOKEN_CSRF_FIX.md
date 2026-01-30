# 🔐 SOLUCIÓN - Token CSRF No Detectado

## ❌ Error Reportado
"No detecta el token"

---

## ✅ Solución Rápida (3 pasos)

### Paso 1: Abre la Consola
```
Presiona: F12
Ve a: Console (pestaña)
```

### Paso 2: Busca los logs de verificación
Deberías ver mensajes como:
```
=== VERIFICACIÓN CSRF TOKEN ===
Meta tag presente: true ✓
Token obtenido: ✓ Sí
✅ CSRF Token detectado correctamente
Token: eyJpdiI6IkRqMzJGTUd1...
```

Si ves esto → **El token SÍ está detectado. El problema es otro.**

### Paso 3: Reinicia Laravel
```bash
Ctrl+C (en la terminal)
php artisan serve
```

Luego recarga la página (F5 o Ctrl+R).

---

## 🔍 ¿Qué significa cada mensaje?

### ✅ Si ves "✅ CSRF Token detectado correctamente"
```
El token ESTÁ siendo detectado correctamente.
Recarga la página:
  - Presiona F5
  - O Ctrl+Shift+R (sin caché)

Prueba a escribir un mensaje en el widget.
```

### ❌ Si ves "❌ ERROR: CSRF Token NO detectado"
```
Significa que el meta tag NO está en <head>

Solución:
1. Abre: resources/views/layouts/app.blade.php
2. Busca dentro de <head>
3. Debe estar esta línea:
   <meta name="csrf-token" content="{{ csrf_token() }}">
4. Si NO está, agrégala
5. Recarga la página
```

### ⚠️ Si ves "Alpine.js cargado: false"
```
Significa que Alpine.js NO se cargó

Solución:
1. Verifica que en app.js está: import Alpine from 'alpinejs'
2. Verifica que @vite(['resources/css/app.css', 'resources/js/app.js'])
   está en el layout
3. Reinicia: php artisan serve
```

---

## 🛠️ Verificación Manual

### En la Consola (F12 → Console)

Copia y ejecuta esto:

```javascript
// Verificar meta tag
const meta = document.querySelector('meta[name="csrf-token"]');
console.log('Meta tag existe:', !!meta);
console.log('Token:', meta?.content);

// Verificar widget
const widget = document.getElementById('ai-chat-widget');
console.log('Widget existe:', !!widget);
console.log('Widget visible:', widget?.style.display !== 'none');

// Verificar Alpine
console.log('Alpine disponible:', !!window.Alpine);
```

Debería mostrar:
```
Meta tag existe: true ✓
Token: eyJpdiI6IkRqMzJGTUd1MTlGRVVUc0tRM...
Widget existe: true ✓
Widget visible: true ✓
Alpine disponible: true ✓
```

---

## 🔄 ¿Aún no funciona?

### Opción 1: Limpiar caché
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan serve
```

### Opción 2: Ir a página de debug
```
Abre: http://localhost:8000/ai/debug
```

### Opción 3: Ver archivo de layout
```
Abre: resources/views/layouts/app.blade.php
Busca <meta name="csrf-token">

Debe estar dentro de <head>:
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        ← AQUÍ ESTÁ
```

---

## 📝 Resumen

El token CSRF se detecta buscando el meta tag en el HTML.

**Si está en `<head>` y ves "✅ CSRF Token detectado":**
→ El token funciona. Recarga la página.

**Si ves "❌ ERROR: CSRF Token NO detectado":**
→ Falta agregar el meta tag en el layout.

**Si aún hay problema:**
→ Abre la consola (F12) y copia los errores exactos que ves.

---

## 🎯 Próximo Paso

1. Abre la consola (F12)
2. Reporta qué mensajes ves exactamente
3. Con eso podré ayudarte con la solución específica
