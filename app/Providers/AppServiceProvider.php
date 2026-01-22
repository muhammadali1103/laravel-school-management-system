<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrapFive();

        // Register User Observer for automatic profile creation
        \App\Models\User::observe(\App\Observers\UserObserver::class);

        // View Composer for Teacher Layout to share notification count
        view()->composer('teacher.layouts.app', function ($view) {
            if (auth()->check() && auth()->user()->isTeacher()) {
                $user = auth()->user();
                $lastCheck = $user->last_notification_check ?? now()->subYears(10); // Default to old date if never checked

                $count = \App\Models\Notification::whereIn('receiver_role', ['all', 'teacher'])
                    ->where('created_at', '>', $lastCheck)
                    ->count();
                $view->with('teacherNotificationCount', $count);
            }
        });

        // View Composer for Student Layout to share notification count
        view()->composer('student.layouts.app', function ($view) {
            if (auth()->check() && auth()->user()->isStudent()) {
                $user = auth()->user();
                $lastCheck = $user->last_notification_check ?? now()->subYears(10); // Default to old date

                $count = \App\Models\Notification::whereIn('receiver_role', ['all', 'student'])
                    ->where('created_at', '>', $lastCheck)
                    ->count();
                $view->with('studentNotificationCount', $count);
            }
        });
    }
}
