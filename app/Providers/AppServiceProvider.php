<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use UserRoles;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        #region gates

        Gate::define('customers', function (User $user) {
            return $this->isAuthorized($user, 'customers');
        });
        Gate::define('materials', function (User $user) {
            return $this->isAuthorized($user, 'materials');
        });
        Gate::define('users', function (User $user) {
            return $this->isAuthorized($user, 'users');
        });
        Gate::define('receivings', function (User $user) {
            return $this->isAuthorized($user, 'receivings');
        });
        Gate::define('put_away', function (User $user) {
            return $this->isAuthorized($user, 'put_away');
        });
        Gate::define('full_bin_to_bin', function (User $user) {
            return $this->isAuthorized($user, 'full_bin_to_bin');
        });
        Gate::define('partial_bin_to_bin', function (User $user) {
            return $this->isAuthorized($user, 'partial_bin_to_bin');
        });
        Gate::define('picking_confirmation', function (User $user) {
            return $this->isAuthorized($user, 'picking_confirmation');
        });
        Gate::define('bins', function (User $user) {
            return $this->isAuthorized($user, 'bins');
        });
        Gate::define('dispatches', function (User $user) {
            return $this->isAuthorized($user, 'dispatches');
        });
        Gate::define('picklists', function (User $user) {
            return $this->isAuthorized($user, 'picklists');
        });
        Gate::define('picklist_auto_confirm', function (User $user) {
            return $this->isAuthorized($user, 'picklist_auto_confirm');
        });
        Gate::define('users', function (User $user) {
            return $this->isAuthorized($user, 'users');
        });

        #endregion
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Check if user is authorize to use endpoint
     * We use users->role for now but may expand to abilities for more control
     * @param mixed $user 
     * @param mixed $ability
     * @return void 
     */
    private function isAuthorized($user, $ability)
    {
        if ($user->user_role_id === UserRoles::SUPER)
            return true;

        $role = $user->user_role_id;
        switch ($ability) {
            case 'customers':
            case 'users':
            case 'warehouse':
                return (in_array($role, [UserRoles::ADMINISTRATOR]));

            case 'materials':
                return (in_array($role, [UserRoles::ADMINISTRATOR, UserRoles::ANALYST]));

            case 'receivings':
                return (in_array($role, [UserRoles::ADMINISTRATOR, UserRoles::ANALYST, UserRoles::CONTROLLER, UserRoles::CHECKER]));

            case 'put_away':
            case 'full_bin_to_bin':
            case 'partial_bin_to_bin':
            case 'picking_confirmation':
            case 'bins':
                return (in_array($role, [UserRoles::ADMINISTRATOR, UserRoles::ANALYST, UserRoles::CONTROLLER, UserRoles::CHECKER, UserRoles::FORKLIFT, UserRoles::PICKER])); // all

            case 'dispatches':
            case 'picklists':
            case 'picklist_auto_confirm':
                return (in_array($role, [UserRoles::ADMINISTRATOR, UserRoles::ANALYST, UserRoles::CONTROLLER]));


            default:
                return false;
        }
    }
}
