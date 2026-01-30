<!-- AI Chat Widget - Standalone (Para agregarlo a cualquier layout) -->
@auth
    <script>
        (function () {
            // Esperar a que DOM esté listo
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initWidget);
            } else {
                initWidget();
            }

            function initWidget() {
                // Verificar que no exista ya
                if (document.getElementById('ai-chat-widget')) {
                    console.log('✓ Widget ya existe en la página');
                    return;
                }

                // Inyectar el widget al final del body
                const widgetHTML = `
                <div id="ai-chat-widget" class="ai-chat-widget" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                    <!-- Botón Flotante -->
                    <button id="ai-chat-toggle" class="ai-chat-toggle" title="Asistente IA" style="
                        width: 60px;
                        height: 60px;
                        border-radius: 50%;
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                        color: white;
                        border: none;
                        cursor: pointer;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
                        transition: all 0.3s ease;
                        position: relative;
                    ">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" style="width: 24px; height: 24px;">
                            <path d="M12 2C6.48 2 2 6.48 2 12c0 1.54.36 3 .97 4.29L2 22l6.29-.97C9 21.64 10.46 22 12 22c5.52 0 10-4.48 10-10S17.52 2 12 2zm0 18c-1.41 0-2.73-.36-3.88-.98l-.28-.15-2.89.44.44-2.89-.15-.28C4.36 14.73 4 13.41 4 12c0-4.41 3.59-8 8-8s8 3.59 8 8-3.59 8-8 8z"/>
                        </svg>
                        <span class="ai-chat-badge" style="position: absolute; top: -5px; right: -5px; font-size: 18px;">🤖</span>
                    </button>

                    <!-- Panel Flotante -->
                    <div id="ai-chat-panel" class="ai-chat-panel" style="
                        position: absolute;
                        bottom: 90px;
                        right: 0;
                        width: 400px;
                        height: 600px;
                        background: rgba(15, 23, 42, 0.95);
                        border: 1px solid rgba(100, 116, 139, 0.2);
                        border-radius: 12px;
                        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6);
                        display: none;
                        flex-direction: column;
                        backdrop-filter: blur(10px);
                        overflow: hidden;
                    ">
                        <!-- Header -->
                        <div style="
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                            padding: 16px;
                            border-bottom: 1px solid rgba(100, 116, 139, 0.2);
                            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
                        ">
                            <div style="display: flex; align-items: center; gap: 10px; color: #e2e8f0;">
                                <span style="font-size: 20px;">🤖</span>
                                <h3 style="font-size: 16px; font-weight: 600; margin: 0;">Asistente de Prompts</h3>
                            </div>
                            <button id="ai-chat-close" style="
                                background: none;
                                border: none;
                                color: #94a3b8;
                                cursor: pointer;
                                padding: 4px;
                                border-radius: 4px;
                            " title="Cerrar">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Mensajes -->
                        <div id="ai-chat-messages" style="
                            flex: 1;
                            overflow-y: auto;
                            padding: 16px;
                            display: flex;
                            flex-direction: column;
                            gap: 12px;
                        ">
                            <div style="display: flex;">
                                <p style="
                                    margin: 0;
                                    padding: 12px;
                                    border-radius: 8px;
                                    max-width: 85%;
                                    word-wrap: break-word;
                                    line-height: 1.5;
                                    font-size: 14px;
                                    background: rgba(51, 65, 85, 0.6);
                                    color: #cbd5e1;
                                ">Hola 👋 Soy tu asistente de IA. Puedo ayudarte a mejorar tus prompts. ¿En qué puedo ayudarte?</p>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div style="
                            padding: 16px;
                            border-top: 1px solid rgba(100, 116, 139, 0.2);
                            display: flex;
                            flex-direction: column;
                            gap: 12px;
                        ">
                            <div style="display: flex; gap: 8px;">
                                <textarea id="ai-chat-input" placeholder="Escribe tu pregunta aquí..." style="
                                    flex: 1;
                                    padding: 10px;
                                    background: rgba(30, 41, 59, 0.8);
                                    border: 1px solid rgba(100, 116, 139, 0.3);
                                    border-radius: 8px;
                                    color: #e2e8f0;
                                    font-family: inherit;
                                    font-size: 14px;
                                    resize: none;
                                    rows: 2;
                                "></textarea>
                                <button id="ai-chat-send" style="
                                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                                    color: white;
                                    border: none;
                                    padding: 10px 15px;
                                    border-radius: 8px;
                                    cursor: pointer;
                                ">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                                        <path d="M16.6915026,12.4744748 L3.50612381,13.2599618 C3.19218622,13.2599618 3.03521743,13.4170592 3.03521743,13.5741566 L1.15159189,20.0151496 C0.8376543,20.8006365 0.99,21.89 1.77946707,22.52 C2.41,22.99 3.50612381,23.1 4.13399899,22.8429026 L21.714504,14.0454487 C22.6563168,13.5741566 23.1272231,12.6315722 22.9702544,11.6889879 L4.13399899,1.16584654 C3.34915502,0.9 2.40734225,0.9 1.77946707,1.4429026 C0.994623095,2.0768377 0.837654326,3.16623099 1.15159189,3.9517179 L3.03521743,10.3927109 C3.03521743,10.5498083 3.19218622,10.7069057 3.50612381,10.7069057 L16.6915026,11.4923926 C16.6915026,11.4923926 17.1624089,11.4923926 17.1624089,12.0353971 C17.1624089,12.4744748 16.6915026,12.4744748 16.6915026,12.4744748 Z"></path>
                                    </svg>
                                </button>
                            </div>

                            <!-- Error Display -->
                            <div id="ai-chat-error" style="
                                padding: 12px;
                                background: rgba(239, 68, 68, 0.1);
                                border: 1px solid rgba(239, 68, 68, 0.3);
                                border-radius: 6px;
                                color: #fca5a5;
                                font-size: 13px;
                                display: none;
                            "></div>
                        </div>
                    </div>
                </div>
                `;

                // Inyectar HTML al final del body
                const div = document.createElement('div');
                div.innerHTML = widgetHTML;
                document.body.appendChild(div.firstElementChild);

                // Inicializar funcionalidad
                setupWidgetEvents();
            }

            function setupWidgetEvents() {
                const toggle = document.getElementById('ai-chat-toggle');
                const close = document.getElementById('ai-chat-close');
                const panel = document.getElementById('ai-chat-panel');
                const send = document.getElementById('ai-chat-send');
                const input = document.getElementById('ai-chat-input');
                const error = document.getElementById('ai-chat-error');

                let isOpen = false;

                toggle.addEventListener('click', function () {
                    isOpen = !isOpen;
                    panel.style.display = isOpen ? 'flex' : 'none';
                    if (isOpen) input.focus();
                });

                close.addEventListener('click', function () {
                    isOpen = false;
                    panel.style.display = 'none';
                });

                send.addEventListener('click', sendMessage);
                input.addEventListener('keypress', function (e) {
                    if (e.key === 'Enter' && !e.shiftKey) {
                        e.preventDefault();
                        sendMessage();
                    }
                });

                async function sendMessage() {
                    const message = input.value.trim();
                    if (!message) return;

                    // Obtener CSRF token
                    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
                    const csrfToken = csrfMeta?.content;

                    if (!csrfToken) {
                        showError('Error de seguridad: Token CSRF no detectado');
                        return;
                    }

                    input.value = '';

                    try {
                        const response = await fetch('/ai/chat', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                            },
                            body: JSON.stringify({
                                message: message,
                                context: null,
                            }),
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            showError(data.error || 'Error al procesar la solicitud');
                            return;
                        }

                        // Agregar respuesta
                        const messagesDiv = document.getElementById('ai-chat-messages');
                        const responseDiv = document.createElement('div');
                        responseDiv.style.display = 'flex';
                        responseDiv.innerHTML = `<p style="
                            margin: 0;
                            padding: 12px;
                            border-radius: 8px;
                            max-width: 85%;
                            word-wrap: break-word;
                            line-height: 1.5;
                            font-size: 14px;
                            background: rgba(51, 65, 85, 0.6);
                            color: #cbd5e1;
                        ">${data.reply}</p>`;
                        messagesDiv.appendChild(responseDiv);
                        messagesDiv.scrollTop = messagesDiv.scrollHeight;

                    } catch (err) {
                        console.error('Error:', err);
                        showError('Error de conexión. Intenta nuevamente.');
                    }
                }

                function showError(msg) {
                    error.textContent = msg;
                    error.style.display = 'block';
                    setTimeout(() => {
                        error.style.display = 'none';
                    }, 5000);
                }
            }
        })();
    </script>
@endauth