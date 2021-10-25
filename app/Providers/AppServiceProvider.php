<?php

namespace App\Providers;

use SelarDevTestCore;
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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ( !request()->cookie( config( 'app.timezone_index' ) ) )
        {
            SelarDevTestCore::cookieTimezone();
        }
    }
}
