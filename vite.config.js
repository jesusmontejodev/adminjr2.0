import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/estructura.css',
                'resources/css/temas-claro.css',
                'resources/css/tema-oscuro.css',
                'resources/css/cuentas.css',
                'resources/css/dashboard.css',
                'resources/css/categorias.css',
                'resources/css/transacciones.css',
                'resources/css/analistajr.css',
                'resources/css/transaccionesinternas.css',
                'resources/css/numeros-whatsapp.css',
                'resources/css/chat.css',
                'resources/css/integraciones-ia.css',
                'resources/css/perfil.css',
                'resources/js/app.js',
                'resources/js/chat-api.js'
            ],
            refresh: true,
        }),
    ],
    server: {
        hmr: {
            overlay: false,
        },
    },
    esbuild: {
        legalComments: 'none'
    },
    build: {
        sourcemap: false,
    }
});
