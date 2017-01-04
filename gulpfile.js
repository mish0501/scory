const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

// elixir.config.sourcemaps = process.env.NODE_ENV !== 'production';

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */


elixir(mix => {
    mix.sass('app.scss', "public/assets/css");
    elixir.config.production ? mix.webpack(['main.js', 'prod.env.js'], "public/assets/js/app.js") : mix.webpack('main.js', "public/assets/js/app.js");
});
