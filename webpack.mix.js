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

mix.setPublicPath('./wp-content/themes/portfolio/public')
    .js('wp-content/themes/portfolio/resources/js/script.js', 'wp-content/themes/portfolio/public/js/')
    .sass('wp-content/themes/portfolio/resources/sass/style.scss', 'wp-content/themes/portfolio/public/css/')
    .options({
        processCssUrls: false
    })
    .browserSync({
        proxy: 'portfolio.localhost',
        notify: false
    })
    .version();