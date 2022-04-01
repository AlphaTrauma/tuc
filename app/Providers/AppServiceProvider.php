<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        Schema::defaultStringLength(191);
        View::composer('layouts.app', function($view)
        {

            $pages = [
                'information' => ['information', 'schedule', 'structure', 'documents', 'managers', 'teachers'],
                'teaching' => ['timetable']
            ];

            $view->with('pages', $pages);

        });
    }
}
