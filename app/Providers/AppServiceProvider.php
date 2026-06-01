<?php

namespace App\Providers;

use App\Models\AdminInfo;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        Schema::defaultStringLength(191);

        // Make AdminInfo available in all Blade views.
        // Prevents layout.blade.php from failing when controllers forget to pass $adminInfo.
        View::composer('*', function ($view) {
            $view->with('adminInfo', AdminInfo::getFirst());
        });

        // Protect log-viewer routes with a simple password gate middleware.
        // This pushes the middleware into the web group at runtime so package routes
        // under /log-viewer are also protected.
        $router = $this->app->make('router');
        $router->pushMiddlewareToGroup('web', \App\Http\Middleware\ProtectLogViewer::class);
    }
}

