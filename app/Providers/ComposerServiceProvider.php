<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        return view()->composers([
            'App\Http\ViewComposers\CategoryComposer' => [
                'store.home',
                'store.cart',
                'store.order',
                'store.auth.register',
                'store.auth.login',
                'store.pages.tos',
            ],
        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
