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
                'resources/js/app.js',
                'resources/js/analistajr/dashboard.js',
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
