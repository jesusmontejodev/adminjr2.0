<?php

namespace App\Jobs;

use App\Models\ChatMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessChatMessage implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected ChatMessage $userMessage,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->process();
    }

    public function process(): array
    {
        $chat = $this->userMessage->chat;
        
        // Marcar el mensaje como procesando
        $this->userMessage->update(['status' => 'processing']);

        try {
            // Configurar certificado SSL para cURL
            $certPath = storage_path('certs/cacert.pem');
            if (file_exists($certPath)) {
                ini_set('curl.cainfo', $certPath);
            }
            
            $apiKey = trim((string) config('services.openai.api_key', ''));
            
            if (!$apiKey) {
                throw new \Exception('OPENAI_API_KEY no esta configurada en config/services.php');
            }

            // Crear cliente OpenAI usando Factory con API key
            $factory = new \OpenAI\Factory();
            $client = $factory->withApiKey($apiKey)->make();

            // Obtener contexto financiero si no está ya generado
            if (!$chat->system_prompt) {
                $chat->update(['system_prompt' => $chat->generateFinancialContext()]);
            }

            // Preparar mensajes para OpenAI
            $messages = [
                [
                    'role' => 'system',
                    'content' => $chat->system_prompt,
                ],
            ];

            // Agregar todos los mensajes previos
            $chat->messages()
                ->where('id', '!=', $this->userMessage->id)
                ->orderBy('created_at')
                ->get()
                ->each(function ($message) use (&$messages) {
                    $messages[] = [
                        'role' => $message->role,
                        'content' => $message->content,
                    ];
                });

            // Agregar el mensaje actual del usuario
            $messages[] = [
                'role' => 'user',
                'content' => $this->userMessage->content,
            ];

            // Llamar a OpenAI API
            $response = $client->chat()->create([
                'model' => $chat->model,
                'messages' => $messages,
                'temperature' => 0.7,
                'max_tokens' => 2000,
            ]);

            // Guardar respuesta como nuevo mensaje
            $assistantMessage = $chat->messages()->create([
                'role' => 'assistant',
                'content' => $response->choices[0]->message->content,
                'tokens_used' => $response->usage->totalTokens ?? 0,
                'status' => 'completed',
            ]);

            // Marcar el mensaje del usuario como completado
            $this->userMessage->update(['status' => 'completed']);

            $this->userMessage->refresh();

            return [
                'processed' => true,
                'user_message' => $this->serializeMessage($this->userMessage),
                'assistant_message' => $this->serializeMessage($assistantMessage),
            ];

        } catch (\Exception $e) {
            // Registrar el error PRIMERO
            $errorMsg = $e->getMessage();
            $errorCode = $e->getCode();
            $errorFile = $e->getFile();
            $errorLine = $e->getLine();
            
            \Log::error("Job Error: {$errorMsg} (Code: {$errorCode}) at {$errorFile}:{$errorLine}", [
                'chat_id' => $chat->id,
                'exception_class' => get_class($e),
                'trace' => $e->getTraceAsString(),
            ]);
            
            // Marcar como fallido
            $this->userMessage->update(['status' => 'failed']);
            
            // Crear mensaje de error
            $assistantMessage = $chat->messages()->create([
                'role' => 'assistant',
                'content' => 'Lo siento, ocurrió un error procesando tu mensaje. Por favor intenta de nuevo.',
                'status' => 'failed',
            ]);

            $this->userMessage->refresh();

            return [
                'processed' => false,
                'user_message' => $this->serializeMessage($this->userMessage),
                'assistant_message' => $this->serializeMessage($assistantMessage),
            ];
        } catch (\Throwable $t) {
            // Catch even more serious errors
            \Log::error("Critical Job Error: " . $t->getMessage(), [
                'chat_id' => $chat->id,
                'throwable_class' => get_class($t),
            ]);
            
            $this->userMessage->update(['status' => 'failed']);
            $assistantMessage = $chat->messages()->create([
                'role' => 'assistant',
                'content' => 'Lo siento, ocurrió un error crítico. Por favor intenta de nuevo.',
                'status' => 'failed',
            ]);

            $this->userMessage->refresh();

            return [
                'processed' => false,
                'user_message' => $this->serializeMessage($this->userMessage),
                'assistant_message' => $this->serializeMessage($assistantMessage),
            ];
        }
    }

    protected function serializeMessage(ChatMessage $message): array
    {
        return [
            'id' => $message->id,
            'role' => $message->role,
            'content' => $message->content,
            'status' => $message->status,
            'tokens_used' => $message->tokens_used,
            'created_at' => $message->created_at,
        ];
    }
}
