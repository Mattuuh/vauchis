<?php

namespace App\Providers;

use App\Models\Rubro;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('partials.navbar', function ($view) {

        $rubros = Rubro::where('rub_estado', 1)
            ->where('rub_publico', 1)
            ->get();

        $view->with([
            'rubros' => $rubros
        ]);
    });
    }
}
