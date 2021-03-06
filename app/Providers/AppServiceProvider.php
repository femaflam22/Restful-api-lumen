<?php

namespace App\Providers;

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
        $this->register_repositories();
    }

    private function register_repositories()
    {
        $this->app->bind('App\Repositories\Contracts\IBookRepository', 'App\Repositories\BookRepository');
        $this->app->bind('App\Repositories\Contracts\ICategoryRepository', 'App\Repositories\CategoryRepository');
        $this->app->bind('App\Repositories\Contracts\IUserRepository', 'App\Repositories\UserRepository');
    }
}
