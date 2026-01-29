@auth
    <!-- AI Chat Widget Component -->
    <div id="ai-chat-widget" class="ai-chat-widget" x-data="aiChatWidget()" x-init="init()" style="display: none;">
        <!-- Botón Flotante -->
        <button id="ai-chat-toggle" @click="toggleChat()" class="ai-chat-toggle" title="Asistente IA">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M12 2C6.48 2 2 6.48 2 12c0 1.54.36 3 .97 4.29L2 22l6.29-.97C9 21.64 10.46 22 12 22c5.52 0 10-4.48 10-10S17.52 2 12 2zm0 18c-1.41 0-2.73-.36-3.88-.98l-.28-.15-2.89.44.44-2.89-.15-.28C4.36 14.73 4 13.41 4 12c0-4.41 3.59-8 8-8s8 3.59 8 8-3.59 8-8 8z" />
            </svg>
            <span class="ai-chat-badge">🤖</span>
        </button>

        <!-- Panel Flotante -->
        <div id="ai-chat-panel" class="ai-chat-panel" x-show="isOpen" @click.outside="closeChat()" style="display: none;">
            <!-- Header -->
            <div class="ai-chat-header">
                <div class="ai-chat-title">
                    <span class="ai-chat-icon">🤖</span>
                    <h3>Asistente de Prompts</h3>
                </div>
                <button @click="closeChat()" class="ai-chat-close" title="Cerrar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Mensajes -->
            <div id="ai-chat-messages" class="ai-chat-messages">
                <div class="ai-chat-message ai-message">
                    <p>Hola 👋 Soy tu asistente de IA. Puedo ayudarte a mejorar tus prompts, dar sugerencias y optimizarlos
                        para mejores resultados. ¿En qué puedo ayudarte?</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="ai-chat-footer">
                <div class="ai-chat-input-wrapper">
                    <textarea id="ai-chat-input" class="ai-chat-input" placeholder="Escribe tu pregunta aquí..."
                        rows="2"></textarea>
                    <button @click="sendMessage()" id="ai-chat-send" class="ai-chat-send" title="Enviar">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M16.6915026,12.4744748 L3.50612381,13.2599618 C3.19218622,13.2599618 3.03521743,13.4170592 3.03521743,13.5741566 L1.15159189,20.0151496 C0.8376543,20.8006365 0.99,21.89 1.77946707,22.52 C2.41,22.99 3.50612381,23.1 4.13399899,22.8429026 L21.714504,14.0454487 C22.6563168,13.5741566 23.1272231,12.6315722 22.9702544,11.6889879 L4.13399899,1.16584654 C3.34915502,0.9 2.40734225,0.9 1.77946707,1.4429026 C0.994623095,2.0768377 0.837654326,3.16623099 1.15159189,3.9517179 L3.03521743,10.3927109 C3.03521743,10.5498083 3.19218622,10.7069057 3.50612381,10.7069057 L16.6915026,11.4923926 C16.6915026,11.4923926 17.1624089,11.4923926 17.1624089,12.0353971 C17.1624089,12.4744748 16.6915026,12.4744748 16.6915026,12.4744748 Z">
                            </path>
                        </svg>
                    </button>
                </div>

                <!-- Quick Actions -->
                <div class="ai-chat-actions">
                    <button @click="copyLastResponse()" class="ai-action-btn" title="Copiar última respuesta">
                        📋 Copiar
                    </button>
                    <button @click="useAsPrompt()" class="ai-action-btn" title="Usar como prompt">
                        ✏️ Usar Prompt
                    </button>
                    <button @click="improveCurrentPrompt()" class="ai-action-btn" title="Mejorar prompt actual">
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

    <script>
        function aiChatWidget() {
            return {
                isOpen: false,
                messages: [],
                csrfToken: null,

                init() {
                    // Obtener CSRF token
                    this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                    if (!this.csrfToken) {
                        console.warn('⚠️ CSRF token no detectado. Verifica que el meta tag exista en <head>');
                    }

                    // Cargar mensajes del localStorage
                    const saved = localStorage.getItem('ai-chat-messages');
                    if (saved) {
                        try {
                            this.messages = JSON.parse(saved);
                            this.renderMessages();
                        } catch (e) {
                            console.error('Error al cargar mensajes del localStorage:', e);
                            this.messages = [];
                        }
                    }

                    // Mostrar widget
                    document.getElementById('ai-chat-widget').style.display = 'block';

                    // Listeners
                    const input = document.getElementById('ai-chat-input');
                    input.addEventListener('keypress', (e) => {
                        if (e.key === 'Enter' && !e.shiftKey) {
                            e.preventDefault();
                            this.sendMessage();
                        }
                    });
                },

                toggleChat() {
                    this.isOpen = !this.isOpen;
                    document.getElementById('ai-chat-panel').style.display = this.isOpen ? 'flex' : 'none';
                    if (this.isOpen) {
                        setTimeout(() => document.getElementById('ai-chat-input').focus(), 100);
                    }
                },

                closeChat() {
                    this.isOpen = false;
                    document.getElementById('ai-chat-panel').style.display = 'none';
                },

                async sendMessage() {
                    const input = document.getElementById('ai-chat-input');
                    const message = input.value.trim();

                    if (!message) return;

                    // Validar CSRF token
                    if (!this.csrfToken) {
                        this.showError('Error de seguridad: Token CSRF no detectado. Recarga la página.');
                        return;
                    }

                    // Agregar mensaje del usuario
                    this.messages.push({ role: 'user', content: message });
                    this.renderMessages();
                    input.value = '';

                    // Guardar en localStorage
                    this.saveMessages();

                    // Mostrar loading
                    this.showLoading();

                    try {
                        const context = this.getContext();
                        const response = await fetch('{{ route("ai.chat.send") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': this.csrfToken,
                            },
                            body: JSON.stringify({
                                message: message,
                                context: context,
                            }),
                        });

                        const data = await response.json();

                        this.hideLoading();

                        if (!response.ok) {
                            this.showError(data.error || 'Error al procesar la solicitud');
                            return;
                        }

                        // Agregar respuesta de la IA
                        this.messages.push({ role: 'assistant', content: data.reply });
                        this.renderMessages();
                        this.saveMessages();

                        // Scroll al final
                        setTimeout(() => {
                            const messagesDiv = document.getElementById('ai-chat-messages');
                            messagesDiv.scrollTop = messagesDiv.scrollHeight;
                        }, 100);

                    } catch (error) {
                        this.hideLoading();
                        this.showError('Error de conexión. Intenta nuevamente.');
                    }
                },

                getContext() {
                    const context = {};

                    // Detectar prompt actual (si existe textarea con id="prompt-content")
                    const promptTextarea = document.getElementById('prompt-content');
                    if (promptTextarea) {
                        context.current_prompt = promptTextarea.value;
                    }

                    // Detectar objetivo (si existe input con id="prompt-goal")
                    const goalInput = document.getElementById('prompt-goal');
                    if (goalInput) {
                        context.goal = goalInput.value;
                    }

                    // Detectar tono (si existe input con id="prompt-tone")
                    const toneInput = document.getElementById('prompt-tone');
                    if (toneInput) {
                        context.tone = toneInput.value;
                    }

                    return Object.keys(context).length > 0 ? context : null;
                },

                renderMessages() {
                    const messagesDiv = document.getElementById('ai-chat-messages');
                    messagesDiv.innerHTML = '';

                    this.messages.slice(-30).forEach((msg) => {
                        const div = document.createElement('div');
                        div.className = msg.role === 'user' ? 'ai-chat-message user-message' : 'ai-chat-message ai-message';

                        const p = document.createElement('p');
                        // Permitir markdown básico
                        p.innerHTML = this.parseMarkdown(msg.content);

                        div.appendChild(p);
                        messagesDiv.appendChild(div);
                    });
                },

                parseMarkdown(text) {
                    return text
                        .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                        .replace(/\*(.*?)\*/g, '<em>$1</em>')
                        .replace(/\n/g, '<br>');
                },

                saveMessages() {
                    localStorage.setItem('ai-chat-messages', JSON.stringify(this.messages.slice(-30)));
                },

                showLoading() {
                    document.getElementById('ai-chat-loading').style.display = 'block';
                    document.getElementById('ai-chat-send').disabled = true;
                },

                hideLoading() {
                    document.getElementById('ai-chat-loading').style.display = 'none';
                    document.getElementById('ai-chat-send').disabled = false;
                },

                showError(message) {
                    const errorDiv = document.getElementById('ai-chat-error');
                    errorDiv.textContent = message;
                    errorDiv.style.display = 'block';
                    setTimeout(() => {
                        errorDiv.style.display = 'none';
                    }, 5000);
                },

                copyLastResponse() {
                    const lastAssistantMsg = [...this.messages].reverse().find(m => m.role === 'assistant');
                    if (!lastAssistantMsg) {
                        this.showError('No hay respuesta para copiar');
                        return;
                    }

                    navigator.clipboard.writeText(lastAssistantMsg.content).then(() => {
                        alert('✓ Copiado al portapapeles');
                    });
                },

                useAsPrompt() {
                    const lastAssistantMsg = [...this.messages].reverse().find(m => m.role === 'assistant');
                    if (!lastAssistantMsg) {
                        this.showError('No hay contenido para usar');
                        return;
                    }

                    const promptTextarea = document.getElementById('prompt-content');
                    if (promptTextarea) {
                        promptTextarea.value = lastAssistantMsg.content;
                        alert('✓ Contenido insertado en el prompt');
                    } else {
                        navigator.clipboard.writeText(lastAssistantMsg.content);
                        alert('✓ Copiado (no se encontró campo de prompt)');
                    }
                },

                improveCurrentPrompt() {
                    const promptTextarea = document.getElementById('prompt-content');
                    if (!promptTextarea) {
                        this.showError('No se encontró un campo de prompt en esta página');
                        return;
                    }

                    const currentPrompt = promptTextarea.value.trim();
                    if (!currentPrompt) {
                        this.showError('El campo de prompt está vacío');
                        return;
                    }

                    // Insertar mensaje automático
                    const input = document.getElementById('ai-chat-input');
                    input.value = '¿Cómo puedo mejorar este prompt?';
                    this.sendMessage();
                }
            };
        }

        // Inicializar widget cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', () => {
            const widget = aiChatWidget();
            widget.init();
        });
    </script>

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

        .ai-chat-toggle:active {
            transform: translateY(-1px);
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

        .ai-chat-icon {
            font-size: 20px;
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
            align-items: flex-end;
        }

        .ai-chat-input {
            flex: 1;
            background: rgba(30, 41, 59, 0.8);
            border: 1px solid rgba(100, 116, 139, 0.3);
            border-radius: 8px;
            padding: 10px;
            color: #e2e8f0;
            font-family: inherit;
            font-size: 14px;
            resize: none;
            max-height: 80px;
            transition: border-color 0.2s ease;
        }

        .ai-chat-input:focus {
            outline: none;
            border-color: rgba(102, 126, 234, 0.6);
            background: rgba(30, 41, 59, 1);
        }

        .ai-chat-send {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .ai-chat-send:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .ai-chat-send:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .ai-chat-actions {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .ai-action-btn {
            flex: 1;
            min-width: 80px;
            padding: 8px 10px;
            background: rgba(100, 116, 139, 0.15);
            border: 1px solid rgba(100, 116, 139, 0.3);
            color: #e0e7ff;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .ai-action-btn:hover {
            background: rgba(100, 116, 139, 0.25);
            border-color: rgba(100, 116, 139, 0.6);
            color: #f1f5f9;
        }

        .ai-chat-loading {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px;
            background: rgba(102, 126, 234, 0.1);
            border-radius: 6px;
            color: #667eea;
            font-size: 12px;
        }

        .spinner {
            width: 16px;
            height: 16px;
            border: 2px solid rgba(102, 126, 234, 0.3);
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
            padding: 10px;
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #ff6b6b;
            border-radius: 6px;
            font-size: 13px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .ai-chat-panel {
                width: calc(100vw - 40px);
                height: 70vh;
                bottom: 80px;
                right: 20px;
                left: 20px;
                max-width: none;
            }

            .ai-chat-actions {
                flex-direction: column;
            }

            .ai-action-btn {
                min-width: auto;
            }
        }

        @media (max-width: 480px) {
            .ai-chat-panel {
                width: calc(100vw - 20px);
                height: 60vh;
                bottom: 70px;
                right: 10px;
                left: 10px;
            }

            .ai-chat-toggle {
                width: 50px;
                height: 50px;
            }
        }
    </style>
@endauth