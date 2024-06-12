<?php

namespace App\Providers;

use App\Models\Permission;
use App\Broadcasting\CustomChannel;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\NotificationChannel;
use Illuminate\Contracts\Database\Eloquent\Builder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\Faker\Generator::class . ':' . config('app.faker_locale'), \Faker\Generator::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            foreach (Permission::pluck('name') as $permission) {
                Gate::define($permission, function ($user) use ($permission) {
                    return $user->roles()->whereHas('permissions', function (Builder $q) use ($permission) {
                        $q->where('name', $permission);
                    })->exists();
                });
            }
        } catch (\Illuminate\Database\QueryException $e) {
            //avoid error when booting before running migrations
        }
    
        Notification::resolved(function (ChannelManager $service) {
            $service->extend('custom', function ($app) {
                return new CustomChannel();
            });
        });
    }
}
