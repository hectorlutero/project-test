<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('manage_companies', function (User $user) {
            // dd($user->id);
            return $user->is_admin == "Y";
        });
        Gate::define('manage_products', function (User $user) {
            return $user->is_admin == "Y" || ($user->hasRole('client') || $user->hasRole('partner'));
        });
        Gate::define('manage_services', function (User $user) {
            return $user->is_admin == "Y" || ($user->hasRole('client') || $user->hasRole('partner'));
        });
        Gate::define('company_categories', function (User $user) {
            return $user->is_admin == "Y";
        });
        Gate::define('manage_users', function (User $user) {
            return $user->is_admin == "Y";
        });
        Gate::define('manage_delivery', function (User $user) {
            return $user->is_admin == "Y";
        });
        Gate::define('manage_admin_settings', function (User $user) {
            return $user->is_admin == "Y";
        });
        Gate::define('manage_midias', function (User $user) {
            return $user->is_admin == "Y";
        });
        Gate::define('company_categories', function (User $user) {
            return $user->is_admin == "Y";
        });
        Gate::define('manage_business', function (User $user) {
            return $user->is_admin == "N" && ($user->hasRole('client') || $user->hasRole('partner'));
        });
        Gate::define('manage_user_plan', function (User $user) {
            return $user->is_admin == "N";
        });


    }
}