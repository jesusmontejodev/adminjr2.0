const mix = require('laravel-mix');

mix.js('resources/js/dashboard.js', 'public/js') // <- aquí defines el destino
    .postCss('resources/css/app.css', 'public/css', [])
    .version();
