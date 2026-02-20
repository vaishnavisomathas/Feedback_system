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

        if (!auth()->check()) {
            $view->with('notificationCount', 0);
            $view->with('notificationList', []);
            return;
        }

        $user = auth()->user();

     if ($user->role == 'User1') {
    $notifications = Feedback::where(function ($q) {
                            $q->whereNull('status')
                              ->orWhere('status', 'pending');
                        })
                        ->whereNotNull('note')
                        ->where('note', '!=', '')
                        ->latest()
                        ->take(25)
                        ->get();

    $count = Feedback::where(function ($q) {
                        $q->whereNull('status')
                          ->orWhere('status', 'pending');
                    })
                    ->whereNotNull('note')
                    ->where('note', '!=', '')
                    ->count();
}
                                  elseif ($user->role == 'Administrative Officer') {
            $notifications = Feedback::where('status', 'ao')->latest()->take(25)->get();
            $count = Feedback::where('status', 'ao')->count();
        } elseif ($user->role == 'Commissioner') {
            $notifications = Feedback::where('status', 'commissioner')->latest()->take(25)->get();
            $count = Feedback::where('status', 'commissioner')->count();
        } else {
            $notifications = [];
            $count = 0;
        }

        $view->with('notificationCount', $count);
        $view->with('notificationList', $notifications);
    });
}}