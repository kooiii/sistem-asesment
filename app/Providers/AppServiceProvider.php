<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Guru;


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
        View::composer('*', function ($view) {

        if (session('role') == 'guru' && session()->has('id')) {

            $guru = Guru::with(['kelas','mapel'])
                        ->find(session('id'));

            $view->with('guru', $guru);
        }

    });
    }
}
