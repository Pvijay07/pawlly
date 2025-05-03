const mix = require("laravel-mix");
const path = require('path');

if (process.env.MIX_PUBLIC_PATH !== null && process.env.MIX_PUBLIC_PATH !== undefined && process.env.MIX_PUBLIC_PATH !== '') {
  mix.setPublicPath('public')
    .webpackConfig({
      output: { publicPath: process.env.MIX_PUBLIC_PATH }
    });
}

// Add alias configuration
mix.webpackConfig({
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'resources/js')
    },
    extensions: ['.wasm', '.mjs', '.js', '.jsx', '.json', '.vue']
  }
});

// Copying assets
mix.copy(
  "node_modules/@fortawesome/fontawesome-free/webfonts/*",
  "public/webfonts"
);

// Backend/Dashboard Styles
mix.styles(
  [
    "public/css/hope-ui.css",
    "public/css/pro.css",
  ],
  "public/css/backend.css"
);

// Backend/Dashboard Scripts
mix.js("resources/js/libs.js", "public/js/core/libs.min.js")
  .js("resources/js/backend-custom.js", "public/js/backend-custom.js");

// Global Vue Script
mix.js('resources/js/vue/app.js', 'public/js/vue.min.js').vue();
mix.js('resources/js/vue/booking-form.js', 'public/js/booking-form.min.js').vue();

// Module-based Script & Style Bundles
const Modules = require("./modules_statuses.json");
const Fs = require("fs");

for (const key in Modules) {
  if (Object.hasOwnProperty.call(Modules, key)) {
    if (Fs.existsSync(`${__dirname}/Modules/${key}/Resources/assets/js/app.js`)) {
      mix.js(`${__dirname}/Modules/${key}/Resources/assets/js/app.js`, `modules/${key.toLocaleLowerCase()}/script.js`).vue().sourceMaps();
    }
    if (Fs.existsSync(`${__dirname}/Modules/${key}/Resources/assets/sass/app.scss`)) {
      mix.sass(`${__dirname}/Modules/${key}/Resources/assets/sass/app.scss`, `modules/${key.toLocaleLowerCase()}/style.css`).sourceMaps();
    }
  }
}

// For Production Build: Add Versioning to Enable Cache Busting
if (mix.inProduction()) {
  mix.version();
}

// Your existing code for development
mix.js('resources/js/app.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css');

mix.js("resources/js/profile-vue.js", "public/js/profile-vue.min.js")
  .js("resources/js/setting-vue.js", "public/js/setting-vue.min.js");

// Additional styles
mix.styles([
  "node_modules/@fortawesome/fontawesome-free/css/all.min.css"
], 'public/css/icon.min.css');
