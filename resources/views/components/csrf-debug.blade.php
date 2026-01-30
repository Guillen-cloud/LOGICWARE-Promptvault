<!-- Script de verificación del CSRF Token -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Verificación del CSRF Token
        const csrfMeta = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = csrfMeta?.content;

        console.log('=== VERIFICACIÓN CSRF TOKEN ===');
        console.log('Meta tag presente:', !!csrfMeta);
        console.log('Token obtenido:', csrfToken ? '✓ Sí' : '✗ No');
        console.log('Longitud del token:', csrfToken?.length || 0);

        if (csrfToken) {
            console.log('✅ CSRF Token detectado correctamente');
            console.log('Token:', csrfToken.substring(0, 20) + '...');
        } else {
            console.error('❌ ERROR: CSRF Token NO detectado');
            console.error('Asegúrate que el meta tag existe en <head>:');
            console.error('<meta name="csrf-token" content="{{ csrf_token() }}">');
        }

        // Verificación del Widget
        console.log('\n=== VERIFICACIÓN DEL WIDGET ===');
        const widget = document.getElementById('ai-chat-widget');
        console.log('Widget HTML presente:', !!widget);

        if (widget) {
            // Esperar a Alpine.js
            setTimeout(() => {
                const xData = widget.__x || widget._x_dataStack || null;
                console.log('Alpine.js cargado:', !!window.Alpine);
                console.log('Widget inicializado:', !!xData);
            }, 1000);
        }
    });
</script>