<?php

namespace App\Providers;

use App\Policies\AppPolicy;
use App\Policies\FieldPolicy;
use App\Policies\NodePolicy;
use App\Policies\ResourcePolicy;
use App\Policies\RowPolicy;
use App\Policies\SharingPolicy;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Policies\RegisteredUserAppPolicy;

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
    public function boot(App $app): void
    {

        Gate::define('select', [SharingPolicy::class, 'select']);

    }
}
