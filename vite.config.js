import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                // 'resources/css/estructura.css',  // ← Eliminado
                // 'resources/css/tema-claro.css',  // ← Eliminado
                // 'resources/css/tema-oscuro.css', // ← Eliminado
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
