const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
//    .copy('node_modules/bootstrap/dist/css/bootstrap.css', 'public/css/bootstrap.css')
//    .copy('node_modules/bootstrap/dist/js/bootstrap.js', 'public/js/bootstrap.js')
//    .copy('node_modules/jquery/dist/jquery.js', 'public/js/jquery.js')
//    .copy('node_modules/popper.js/dist/popper.js', 'public/js/popper.js');

// if (mix.inProduction()) {
//     mix.version();
// }
