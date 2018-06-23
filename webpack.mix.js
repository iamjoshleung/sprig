let mix = require("laravel-mix");
let webpack = require('webpack');

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

mix
  .js("resources/assets/js/cm/app.js", "public/js/cm")
  .sass("resources/assets/sass/cm/app.scss", "public/css/cm")
  .js("resources/assets/js/app.js", "public/js")

  .sass("resources/assets/sass/app.scss", "public/css")
  .options({
    processCssUrls: false
  })
  .sourceMaps()
  .extract(["vue", "jquery", "bootstrap", "dropzone", "parsleyjs"])
  .webpackConfig({
    plugins: [
      new webpack.ProvidePlugin({
        $: 'jquery',
        jQuery: 'jquery',
        jquery: 'jquery',
        'window.jQuery': 'jquery',
      })
    ],
  })
  .browserSync({
    proxy: "sprig.test"
  });

if (mix.inProduction()) {
  mix.version();
}
