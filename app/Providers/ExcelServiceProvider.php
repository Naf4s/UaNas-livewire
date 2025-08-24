<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\ExcelServiceProvider as BaseExcelServiceProvider;

class ExcelServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register the base Excel service provider
        $this->app->register(BaseExcelServiceProvider::class);
        
        // Register Excel facade
        $this->app->alias('excel', Excel::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Publish config if not already published
        if (!file_exists(config_path('excel.php'))) {
            $this->publishes([
                __DIR__.'/../../config/excel.php' => config_path('excel.php'),
            ], 'config');
        }
    }
}
