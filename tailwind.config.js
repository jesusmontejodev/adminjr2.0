import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class', // 👈 Habilita el modo oscuro manual (no automático por sistema)

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Rojo de marca "Rubí" — reemplaza la escala red-* por defecto de Tailwind
                red: {
                    50: '#fef2f4',
                    100: '#fee2e6',
                    200: '#fdcbd1',
                    300: '#fba6b1',
                    400: '#f67384',
                    500: '#ed465c',
                    600: '#d7263d',
                    700: '#b71e32',
                    800: '#971d2d',
                    900: '#7d1f2b',
                    950: '#440b12',
                },
            },
        },
    },

    plugins: [forms],
};
