<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        //Переопределение класса для Laravel filemanager
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('UniSharp\LaravelFilemanager\Handlers\ConfigHandler', 'App\Vendor\ConfigFileManagerHandler');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
