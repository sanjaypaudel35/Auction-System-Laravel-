<?php

namespace App\Providers;

use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $categoryRepository = $this->app->make(CategoryRepository::class);
        $categories = $categoryRepository->fetchAll(["no_paginate" => true]);

        Facades\View::composer("frontend.pages.product.*", function (View $view) use ($categories) {
            $view->with("categories", $categories);
        });
    }
}