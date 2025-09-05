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

mix.js('resources/js/app.js', 'public/js')
    .copy('resources/js/product_listing_page.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]).version();

const crypto = require("crypto");
module.exports = {
    resolve: {
        fallback: {
            crypto: false
        }
    },
    output: {
        hashFunction: "xxhash64"  // fallback to a non-wasm hashing algorithm
    }
};
