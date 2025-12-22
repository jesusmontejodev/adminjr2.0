import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/analistajr/dashboard.js'
            ],
            refresh: true,
        }),
    ],
    server: {
        hmr: {
            overlay: false, // quita overlay molesto
        },
    },
    esbuild: {
        legalComments: 'none'
    },
    build: {
        sourcemap: false, // desactiva mapas que usan eval
    }
});
