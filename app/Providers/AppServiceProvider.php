<?php

namespace App\Providers;

use App\Models\OfficeHour;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use View;

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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        // Отправка данных о режиме работы во все представления
        View::composer('layouts._footer', function ($view) {
            $officeHours = OfficeHour::all();
            $view->with('officeHours', $officeHours);
        });
    }
}
