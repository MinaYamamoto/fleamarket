const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js').js('resources/js/tab.js', 'public/js').js('resources/js/admintab.js', 'public/js').js('resources/js/profileimg.js', 'public/js').js('resources/js/sell.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
    ]);
