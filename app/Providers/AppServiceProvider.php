<?php

namespace App\Providers;

use App\Models\Feedback;
use App\Models\ManualComplaint;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Collection;
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
                        $view->with('manualCommissionerCount', 0);
            return;
        }

          $user = auth()->user();
          $roleKey = strtolower(trim((string) $user->role));
                    $manualCommissionerCount = 0;

      if (in_array($roleKey, ['user'], true)) {
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
                                  elseif (in_array($roleKey, ['administrative officer', 'a/o', 'ao'], true)) {
            $notifications = Feedback::where('status', 'ao')->latest()->take(25)->get();
            $count = Feedback::where('status', 'ao')->count();
        } elseif ($roleKey === 'super admin' || (method_exists($user, 'isSuperAdmin') && $user->isSuperAdmin()) || in_array($roleKey, ['commissioner', 'commisioner'], true)) {
            $manualNotifications = ManualComplaint::where('status', 'commissioner')->latest()->get();
            $feedbackNotifications = Feedback::where('status', 'commissioner')->latest()->get();

            $notifications = $manualNotifications
                ->concat($feedbackNotifications)
                ->sortByDesc('created_at')
                ->take(25)
                ->values();

            $manualCommissionerCount = $manualNotifications->count();
            $count = $manualCommissionerCount + $feedbackNotifications->count();
        } else {
            $notifications = [];
            $count = 0;
        }

        $view->with('notificationCount', $count);
        $view->with('notificationList', $notifications);
        $view->with('manualCommissionerCount', $manualCommissionerCount);
    });
}}