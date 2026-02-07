import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/estructura.css',     // ← Añadir esto
                'resources/css/tema-claro.css',     // ← Añadir esto
                'resources/css/tema-oscuro.css',    // ← Añadir esto
                'resources/js/app.js',
                'resources/js/analistajr/dashboard.js'
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
