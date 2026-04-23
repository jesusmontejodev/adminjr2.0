/**
 * Chat API Client
 * Consume el backend con autenticación Sanctum
 */

class ChatAPI {
    constructor(baseUrl = '/api/chat') {
        this.baseUrl = baseUrl;
        this.token = this.getToken();
        this.sanctumInitialized = false;
    }

    /**
     * Obtener token de autenticación (CSRF token de Laravel)
     */
    getToken() {
        return document.querySelector('meta[name="csrf-token"]')?.content || '';
    }

    /**
     * Inicializar Sanctum - CRÍTICO para autenticación
     */
    async initSanctum() {
        if (this.sanctumInitialized) {
            console.log('✅ Sanctum ya fue inicializado');
            return;
        }

        try {
            console.log('🔐 Inicializando Sanctum CSRF cookie...');
            const response = await fetch('/sanctum/csrf-cookie', {
                method: 'GET',
                credentials: 'include',
                headers: {
                    'Accept': 'application/json',
                }
            });

            if (response.ok) {
                this.sanctumInitialized = true;
                console.log('✅ Sanctum CSRF cookie inicializado correctamente');
            } else {
                console.warn('⚠️ Advertencia: Sanctum CSRF cookie retornó', response.status);
            }
        } catch (error) {
            console.error('❌ Error inicializando Sanctum:', error);
        }
    }

    /**
     * Headers para las peticiones
     */
    getHeaders() {
        return {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': this.token,
        };
    }

    /**
     * Manejar respuestas
     */
    async handleResponse(response) {
        const data = await response.json().catch(() => null);

        if (!response.ok) {
            const errorMsg = data?.message 
                || data?.error 
                || `Error ${response.status}: ${response.statusText}`;
            console.error('API Error:', {
                status: response.status,
                data: data,
                message: errorMsg
            });
            throw new Error(errorMsg);
        }

        return data;
    }

    /**
     * Obtener todos los chats
     */
    async getChats() {
        await this.ensureSanctumInitialized();
        
        const response = await fetch(this.baseUrl, {
            method: 'GET',
            headers: this.getHeaders(),
            credentials: 'include',
        });

        return this.handleResponse(response);
    }

    /**
     * Crear nuevo chat
     */
    async createChat(title, model = 'gpt-4o-mini') {
        await this.ensureSanctumInitialized();
        
        const response = await fetch(this.baseUrl, {
            method: 'POST',
            headers: this.getHeaders(),
            credentials: 'include',
            body: JSON.stringify({ title, model }),
        });

        return this.handleResponse(response);
    }

    /**
     * Obtener chat específico
     */
    async getChat(chatId) {
        await this.ensureSanctumInitialized();
        
        const response = await fetch(`${this.baseUrl}/${chatId}`, {
            method: 'GET',
            headers: this.getHeaders(),
            credentials: 'include',
        });

        return this.handleResponse(response);
    }

    /**
     * Enviar mensaje al chat
     */
    async sendMessage(chatId, content) {
        await this.ensureSanctumInitialized();
        
        const response = await fetch(`${this.baseUrl}/${chatId}/mensaje`, {
            method: 'POST',
            headers: this.getHeaders(),
            credentials: 'include',
            body: JSON.stringify({ content }),
        });

        return this.handleResponse(response);
    }

    /**
     * Garantizar que Sanctum esté inicializado antes de cualquier petición
     */
    async ensureSanctumInitialized() {
        if (!this.sanctumInitialized) {
            await this.initSanctum();
        }
    }

    /**
     * Eliminar chat
     */
    async deleteChat(chatId) {
        await this.ensureSanctumInitialized();
        
        const response = await fetch(`${this.baseUrl}/${chatId}`, {
            method: 'DELETE',
            headers: this.getHeaders(),
            credentials: 'include',
        });

        return this.handleResponse(response);
    }
}

// Exportar para usarlo globalmente
window.chatAPI = new ChatAPI();
