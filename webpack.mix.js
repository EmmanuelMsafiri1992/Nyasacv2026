const mix = require("laravel-mix");

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

// app
mix.styles(
  [
    "node_modules/tabler-ui/dist/assets/css/dashboard.css",
    "node_modules/tabler-ui/dist/assets/plugins/charts-c3/plugin.css",
    "node_modules/flatpickr/dist/flatpickr.css",
    "public/resume_public/assets/builder.min.css",
    "public/css/customize.css",
  ],
  "public/css/app.bundle.css"
);

mix.scripts(
  [
    "node_modules/tabler-ui/src/assets/js/vendors/jquery-3.2.1.min.js",
    "node_modules/tabler-ui/src/assets/js/vendors/bootstrap.bundle.min.js",
    "node_modules/tabler-ui/src/assets/js/vendors/selectize.min.js",
    "node_modules/flatpickr/dist/flatpickr.js",
    "node_modules/flatpickr/dist/l10n/ru.js",
    "node_modules/flatpickr/dist/l10n/pt.js",
    "node_modules/flatpickr/dist/l10n/tr.js",
    "public/resume_public/assets/builder.min.js",
    "public/resume_public/assets/sweetalert.js",
  ],
  "public/js/app.bundle.js"
);

mix.copyDirectory("node_modules/tabler-ui/dist/assets/fonts", "public/fonts");

// Enable versioning for production
if (mix.inProduction()) {
  mix.version();
}
