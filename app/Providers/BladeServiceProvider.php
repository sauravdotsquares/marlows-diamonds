<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::extend(function($value)
        {
            $value = preg_replace('/<!--(.+?)-->/s', '', $value); // Removing <!-- multiline comments -->
            $value = preg_replace('/\/\*(.*?)\*\//s', '', $value); // Removing /* multiline comments */
            $value = preg_replace('/(?<!:)\/\/.+/', '', $value); // Removing // single line comments in JS
            return $value;
        });
    }
}
