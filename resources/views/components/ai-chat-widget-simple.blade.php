@auth
    <!-- AI Chat Widget - Versión Vanilla JS (Sin Alpine.js) -->
    <div id="ai-chat-widget" class="ai-chat-widget">
        <!-- Botón Flotante -->
        <button id="ai-chat-toggle" class="ai-chat-toggle" title="Asistente IA">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M12 2C6.48 2 2 6.48 2 12c0 1.54.36 3 .97 4.29L2 22l6.29-.97C9 21.64 10.46 22 12 22c5.52 0 10-4.48 10-10S17.52 2 12 2zm0 18c-1.41 0-2.73-.36-3.88-.98l-.28-.15-2.89.44.44-2.89-.15-.28C4.36 14.73 4 13.41 4 12c0-4.41 3.59-8 8-8s8 3.59 8 8-3.59 8-8 8z" />
            </svg>
            <span class="ai-chat-badge">🤖</span>
        </button>

        <!-- Panel Flotante -->
        <div id="ai-chat-panel" class="ai-chat-panel" style="display: none;">
            <!-- Header -->
            <div class="ai-chat-header">
                <div class="ai-chat-title">
                    <span class="ai-chat-icon">🤖</span>
                    <h3>Asistente de Prompts</h3>
                </div>
                <button id="ai-chat-close" class="ai-chat-close" title="Cerrar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Mensajes -->
            <div id="ai-chat-messages" class="ai-chat-messages">
                <div class="ai-chat-message ai-message">
                    <p>Hola 👋 Soy tu asistente de IA. Puedo ayudarte a mejorar tus prompts. ¿En qué puedo ayudarte?</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="ai-chat-footer">
                <div class="ai-chat-input-wrapper">
                    <textarea id="ai-chat-input" class="ai-chat-input" placeholder="Escribe tu pregunta aquí..."
                        rows="2"></textarea>
                    <button id="ai-chat-send" class="ai-chat-send" title="Enviar">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M16.6915026,12.4744748 L3.50612381,13.2599618 C3.19218622,13.2599618 3.03521743,13.4170592 3.03521743,13.5741566 L1.15159189,20.0151496 C0.8376543,20.8006365 0.99,21.89 1.77946707,22.52 C2.41,22.99 3.50612381,23.1 4.13399899,22.8429026 L21.714504,14.0454487 C22.6563168,13.5741566 23.1272231,12.6315722 22.9702544,11.6889879 L4.13399899,1.16584654 C3.34915502,0.9 2.40734225,0.9 1.77946707,1.4429026 C0.994623095,2.0768377 0.837654326,3.16623099 1.15159189,3.9517179 L3.03521743,10.3927109 C3.03521743,10.5498083 3.19218622,10.7069057 3.50612381,10.7069057 L16.6915026,11.4923926 C16.6915026,11.4923926 17.1624089,11.4923926 17.1624089,12.0353971 C17.1624089,12.4744748 16.6915026,12.4744748 16.6915026,12.4744748 Z">
                            </path>
                        </svg>
                    </button>
                </div>

                <!-- Quick Actions -->
                <div class="ai-chat-actions">
                    <button class="ai-action-btn" data-action="copy" title="Copiar última respuesta">
                        📋 Copiar
                    </button>
                    <button class="ai-action-btn" data-action="use" title="Usar como prompt">
                        ✏️ Usar Prompt
                    </button>
                    <button class="ai-action-btn" data-action="improve" title="Mejorar prompt actual">
                        ⚡ Mejorar
                    </button>
                </div>

                <!-- Loading Indicator -->
                <div id="ai-chat-loading" class="ai-chat-loading" style="display: none;">
                    <span class="spinner"></span>
                    <p>Pensando...</p>
                </div>

                <!-- Error Display -->
                <div id="ai-chat-error" class="ai-chat-error" style="display: none;"></div>
            </div>
        </div>
    </div>

    <style>
        .ai-chat-widget {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .ai-chat-toggle {
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
        }

        .ai-chat-toggle:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.5);
        }

        .ai-chat-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            font-size: 18px;
        }

        .ai-chat-panel {
            position: absolute;
            bottom: 90px;
            right: 0;
            width: 400px;
            height: 600px;
            background: rgba(15, 23, 42, 0.95);
            border: 1px solid rgba(100, 116, 139, 0.2);
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6);
            display: flex;
            flex-direction: column;
            backdrop-filter: blur(10px);
            overflow: hidden;
        }

        .ai-chat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px;
            border-bottom: 1px solid rgba(100, 116, 139, 0.2);
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        }

        .ai-chat-title {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #e2e8f0;
        }

        .ai-chat-title h3 {
            font-size: 16px;
            font-weight: 600;
            margin: 0;
        }

        .ai-chat-close {
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        .ai-chat-close:hover {
            background: rgba(100, 116, 139, 0.2);
            color: #e2e8f0;
        }

        .ai-chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .ai-chat-message {
            display: flex;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .ai-chat-message p {
            margin: 0;
            padding: 12px;
            border-radius: 8px;
            max-width: 85%;
            word-wrap: break-word;
            line-height: 1.5;
            font-size: 14px;
        }

        .user-message {
            justify-content: flex-end;
        }

        .user-message p {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .ai-message p {
            background: rgba(51, 65, 85, 0.6);
            color: #cbd5e1;
        }

        .ai-chat-footer {
            padding: 16px;
            border-top: 1px solid rgba(100, 116, 139, 0.2);
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .ai-chat-input-wrapper {
            display: flex;
            gap: 8px;
        }

        .ai-chat-input {
            flex: 1;
            padding: 10px;
            background: rgba(30, 41, 59, 0.8);
            border: 1px solid rgba(100, 116, 139, 0.3);
            border-radius: 8px;
            color: #e2e8f0;
            font-family: inherit;
            font-size: 14px;
            resize: none;
        }

        .ai-chat-input:focus {
            outline: none;
            border-color: rgba(102, 126, 234, 0.6);
        }

        .ai-chat-send {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .ai-chat-send:hover {
            transform: translateY(-2px);
        }

        .ai-chat-actions {
            display: flex;
            gap: 8px;
        }

        .ai-action-btn {
            flex: 1;
            padding: 8px;
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            border: 1px solid rgba(102, 126, 234, 0.3);
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .ai-action-btn:hover {
            background: rgba(102, 126, 234, 0.2);
            border-color: rgba(102, 126, 234, 0.5);
        }

        .ai-chat-loading {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #94a3b8;
            font-size: 14px;
        }

        .spinner {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 2px solid rgba(102, 126, 234, 0.2);
            border-top-color: #667eea;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .ai-chat-error {
            padding: 12px;
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 6px;
            color: #fca5a5;
            font-size: 13px;
            line-height: 1.4;
        }

        @media (max-width: 768px) {
            .ai-chat-panel {
                width: 90vw;
                height: 70vh;
                max-width: 400px;
                max-height: 600px;
            }
        }

        @media (max-width: 480px) {
            .ai-chat-panel {
                width: 100vw;
                height: 100vh;
                border-radius: 0;
                bottom: 0;
                right: 0;
            }
        }
    </style>

    <script>
        (function () {
            // Estado del widget
            const widgetState = {
                isOpen: false,
                messages: [],
                csrfToken: null,
                isLoading: false
            };

            // Elementos DOM
            const elements = {
                widget: null,
                toggle: null,
                panel: null,
                close: null,
                input: null,
                send: null,
                messages: null,
                loading: null,
                error: null,
                actions: null
            };

            // Inicializar
            function init() {
                // Obtener elementos
                elements.widget = document.getElementById('ai-chat-widget');
                elements.toggle = document.getElementById('ai-chat-toggle');
                elements.panel = document.getElementById('ai-chat-panel');
                elements.close = document.getElementById('ai-chat-close');
                elements.input = document.getElementById('ai-chat-input');
                elements.send = document.getElementById('ai-chat-send');
                elements.messages = document.getElementById('ai-chat-messages');
                elements.loading = document.getElementById('ai-chat-loading');
                elements.error = document.getElementById('ai-chat-error');
                elements.actions = document.querySelectorAll('.ai-action-btn');

                // Obtener CSRF token
                const csrfMeta = document.querySelector('meta[name="csrf-token"]');
                widgetState.csrfToken = csrfMeta?.content;

                if (!widgetState.csrfToken) {
                    console.error('❌ CSRF Token no encontrado en meta tag');
                    showError('Error de seguridad: Token CSRF no detectado');
                    return;
                }

                console.log('✅ CSRF Token detectado correctamente');

                // Cargar historial del localStorage
                loadMessages();

                // Event listeners
                elements.toggle.addEventListener('click', togglePanel);
                elements.close.addEventListener('click', closePanel);
                elements.send.addEventListener('click', sendMessage);
                elements.input.addEventListener('keypress', handleKeyPress);
                elements.actions.forEach(btn => {
                    btn.addEventListener('click', handleAction);
                });
            }

            function togglePanel() {
                widgetState.isOpen ? closePanel() : openPanel();
            }

            function openPanel() {
                widgetState.isOpen = true;
                elements.panel.style.display = 'flex';
                elements.input.focus();
            }

            function closePanel() {
                widgetState.isOpen = false;
                elements.panel.style.display = 'none';
            }

            function handleKeyPress(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    sendMessage();
                }
            }

            async function sendMessage() {
                const message = elements.input.value.trim();

                if (!message) return;
                if (widgetState.isLoading) return;

                // Agregar mensaje del usuario
                addMessage('user', message);
                elements.input.value = '';
                saveMessages();

                // Mostrar loading
                showLoading(true);

                try {
                    const context = getContext();
                    const response = await fetch('{{ route("ai.chat.send") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': widgetState.csrfToken,
                        },
                        body: JSON.stringify({
                            message: message,
                            context: context,
                        }),
                    });

                    const data = await response.json();
                    showLoading(false);

                    if (!response.ok) {
                        showError(data.error || 'Error al procesar la solicitud');
                        return;
                    }

                    // Agregar respuesta
                    addMessage('assistant', data.reply);
                    saveMessages();
                    scrollToBottom();

                } catch (error) {
                    showLoading(false);
                    showError('Error de conexión. Intenta nuevamente.');
                    console.error('Error:', error);
                }
            }

            function addMessage(role, content) {
                widgetState.messages.push({ role, content });
                renderMessages();
            }

            function renderMessages() {
                elements.messages.innerHTML = '';
                widgetState.messages.slice(-30).forEach(msg => {
                    const div = document.createElement('div');
                    div.className = msg.role === 'user' ? 'ai-chat-message user-message' : 'ai-chat-message ai-message';

                    const p = document.createElement('p');
                    p.textContent = msg.content;

                    div.appendChild(p);
                    elements.messages.appendChild(div);
                });
                scrollToBottom();
            }

            function scrollToBottom() {
                setTimeout(() => {
                    elements.messages.scrollTop = elements.messages.scrollHeight;
                }, 50);
            }

            function getContext() {
                const context = {};

                const promptEl = document.getElementById('prompt-content');
                if (promptEl) context.current_prompt = promptEl.value;

                const goalEl = document.getElementById('prompt-goal');
                if (goalEl) context.goal = goalEl.value;

                const toneEl = document.getElementById('prompt-tone');
                if (toneEl) context.tone = toneEl.value;

                return Object.keys(context).length > 0 ? context : null;
            }

            function showLoading(show) {
                widgetState.isLoading = show;
                elements.loading.style.display = show ? 'flex' : 'none';
            }

            function showError(message) {
                elements.error.textContent = message;
                elements.error.style.display = 'block';
                setTimeout(() => {
                    elements.error.style.display = 'none';
                }, 5000);
            }

            function saveMessages() {
                localStorage.setItem('ai-chat-messages', JSON.stringify(widgetState.messages.slice(-30)));
            }

            function loadMessages() {
                try {
                    const saved = localStorage.getItem('ai-chat-messages');
                    if (saved) {
                        widgetState.messages = JSON.parse(saved);
                        renderMessages();
                    }
                } catch (e) {
                    console.error('Error loading messages:', e);
                }
            }

            function handleAction(e) {
                const action = e.target.dataset.action || e.target.closest('button').dataset.action;

                if (action === 'copy') {
                    const lastMsg = widgetState.messages[widgetState.messages.length - 1];
                    if (lastMsg?.role === 'assistant') {
                        navigator.clipboard.writeText(lastMsg.content);
                        showError('✓ Copiado al portapapeles');
                    }
                } else if (action === 'use') {
                    const lastMsg = widgetState.messages[widgetState.messages.length - 1];
                    if (lastMsg?.role === 'assistant') {
                        const promptEl = document.getElementById('prompt-content');
                        if (promptEl) promptEl.value = lastMsg.content;
                    }
                } else if (action === 'improve') {
                    const promptEl = document.getElementById('prompt-content');
                    if (promptEl && promptEl.value) {
                        elements.input.value = `Por favor, mejora este prompt: "${promptEl.value}"`;
                        elements.input.focus();
                    }
                }
            }

            // Iniciar cuando el DOM esté listo
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', init);
            } else {
                init();
            }
        })();
    </script>
@endauth