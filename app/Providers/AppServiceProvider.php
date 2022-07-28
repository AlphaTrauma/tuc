<?php

namespace App\Providers;

use App\Models\Direction;
use App\Models\Settings;
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
            $directions = Direction::where('status', 1)->pluck('title', 'slug')->toArray();
            $contacts = Settings::query()->pluck('value', 'key')->toArray();
            $pricelist = Settings::where('key', 'pricelist')->with('document')->first();

            $view->with(compact('pages', 'directions', 'contacts', 'pricelist'));
        });
        View::composer('dashboard.navigation', function($view){
            $leads_count = \App\Models\Lead::where('status', 0)->count();
            $types = \App\Models\Type::where('status', 1)->pluck('title', 'id')->toArray();
            $view->with(compact('leads_count', 'types'));
        });
    }
}
