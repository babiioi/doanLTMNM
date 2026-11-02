<?php

namespace App\Providers;

use App\Listeners\RestoreCartOnLogin;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Collection;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('layouts.store', function ($view) {
            $view->with('navCollections', Collection::query()->orderBy('name')->get());
        });
    }
}
