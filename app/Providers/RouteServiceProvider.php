<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use File;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/admin';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */

    // protected $namespace = 'App\Http\Controllers';
    public function boot()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            // Route::middleware(['web', 'auth', 'adminRoleAccess', 'adminPermissionAccess'])
            //     ->prefix('admin')->name('admin.')
            //     ->namespace($this->namespace . '\SuperAdmin')
            //     ->group(function () {
            //         $files = File::allFiles(base_path('routes' . DIRECTORY_SEPARATOR . 'super_admin'));
            //         foreach ($files as $file) {
            //             // dd($file->getRealPath());
            //             require_once $file->getRealPath();
            //         }
            //     });
        });
    }

}
