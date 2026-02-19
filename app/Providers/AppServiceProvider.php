<?php

namespace App\Providers;

use App\Models\Feedback;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
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

public function boot()
{
    Schema::defaultStringLength(191);
    View::composer('*', function ($view) {

        if (!auth()->check()) return;

        $role = auth()->user()->role;

        $count = 0;

        if ($role == 'Commissioner') {
            $count = Feedback::where('status', 'commissioner')->count();
        }

        elseif ($role == 'Administrative Officer') {
            $count = Feedback::where('status', 'ao')->count();
        }

        else {
            $count = Feedback::where(function ($q) {
                $q->whereNull('status')
                  ->orWhere('status', 'pending');
            })->count();
        }

        $view->with('notificationCount', $count);
    });
}
}
