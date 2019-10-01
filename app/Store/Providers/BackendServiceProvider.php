<?php

namespace App\Store\Providers;
use App\Store\Categories\CategoryRepository;
use App\Store\Categories\CategoryService;
use App\Store\Contracts\Repository\Category;
use App\Store\Contracts\Services\Product;
use App\Store\Products\ProductRepository;
use App\Store\Products\ProductService;
use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            Category::class,
            CategoryRepository::class
        );
        $this->app->bind(
            \App\Store\Contracts\Services\Category::class,
            CategoryService::class
        );

        $this->app->bind(
            Product::class,
            ProductService::class
        );
        $this->app->bind(
            \App\Store\Contracts\Repository\Product::class,
            ProductRepository::class
        );
    }
}
