const mix = require('laravel-mix');
const crypto = require("crypto");

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

// mix.js('resources/js/app.js', 'public/js')
    // .copy('resources/js/index.js', 'public/js')
    // .minify('public/js/index.js')
    // .copy('resources/js/product_listing_page.js', 'public/js')
    // .minify('public/js/product_listing_page.js')
    // .copy('resources/js/product-details-dyes.js', 'public/js')
    // .minify('public/js/product-details-dyes.js')
    // .copy('resources/js/googlepay_checkout_code.js', 'public/js')
    // .minify('public/js/googlepay_checkout_code.js')
    // .postCss('resources/css/app.css', 'public/css', [
        // 
    // ]).version();

mix.scripts('resources/js/app.js', 'public/js/app.min.js')
    .scripts('resources/js/index.js', 'public/js/index.min.js')
    .scripts('resources/js/product_listing_page.js', 'public/js/product_listing_page.min.js')
    .scripts('resources/js/product-details-dyes.js', 'public/js/product-details-dyes.min.js')
    .scripts('resources/js/googlepay_checkout_code.js', 'public/js/googlepay_checkout_code.min.js')
    .version(); // <-- important



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
