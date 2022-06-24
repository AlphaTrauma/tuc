const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js(['resources/js/main.js'], 'public/js/main.js')
    .js(['resources/js/app.js'],
        'public/js/app.js')
    .vue().version()
    .styles([
        'node_modules/uikit/dist/css/uikit.min.css',
        'public/css/main.css'],
        'public/css/app.css').version();
