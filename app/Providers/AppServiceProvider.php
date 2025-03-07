<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\FooterContent;
use Illuminate\Support\Facades\View;
use App\Models\AboutUs;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('footerContent', FooterContent::first());
        });


        View::composer('*', function ($view) {
            $view->with('aboutUs', AboutUs::first());
        });
    }
}
