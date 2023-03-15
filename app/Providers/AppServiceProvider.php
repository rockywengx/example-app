<?php

namespace App\Providers;

use App\Models\Repositories\BookRepositories;
use App\Services\BookServices;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);

        //$this->app->scoped(BookServices::class, function (Application $app) {
        //    return new BookServices($app->make(BookRepositories::class));
        //});
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
