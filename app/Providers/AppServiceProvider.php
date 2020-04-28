<?php

namespace App\Providers;

use App\Models\School;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $school_info = School::getInfo();
        $school_name = $school_info->school_name;
        $school_description = $school_info->description;
        View::share([
            'school_name' => $school_name,
            'school_description' => $school_description
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
