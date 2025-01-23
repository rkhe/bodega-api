<?php

namespace App\Providers;

use App\Models\User;
use AuthorizedPages;
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

        // General
        Gate::define(AuthorizedPages::USERS, function (User $user) {
            return $this->isAuthorized($user, AuthorizedPages::USERS);
        });
        Gate::define(AuthorizedPages::CUSTOMERS, function (User $user) {
            return $this->isAuthorized($user, AuthorizedPages::CUSTOMERS);
        });
        Gate::define(AuthorizedPages::WAREHOUSES, function (User $user) {
            return $this->isAuthorized($user, AuthorizedPages::WAREHOUSES);
        });

        // Materials and configurations
        Gate::define(AuthorizedPages::MATERIALS, function (User $user) {
            return $this->isAuthorized($user, AuthorizedPages::MATERIALS);
        });

        // Inbound
        Gate::define(AuthorizedPages::RECEIVINGS, function (User $user) {
            return $this->isAuthorized($user, AuthorizedPages::RECEIVINGS);
        });
        Gate::define(AuthorizedPages::PUT_AWAYS, function (User $user) {
            return $this->isAuthorized($user, AuthorizedPages::PUT_AWAYS);
        });
        Gate::define(AuthorizedPages::FULL_BIN_TO_BIN, function (User $user) {
            return $this->isAuthorized($user, AuthorizedPages::FULL_BIN_TO_BIN);
        });
        Gate::define(AuthorizedPages::PARTIAL_BIN_TO_BIN, function (User $user) {
            return $this->isAuthorized($user, AuthorizedPages::PARTIAL_BIN_TO_BIN);
        });

        // Outbound
        Gate::define(AuthorizedPages::DISPATCHES, function (User $user) {
            return $this->isAuthorized($user, AuthorizedPages::DISPATCHES);
        });
        Gate::define(AuthorizedPages::PICKLISTS, function (User $user) {
            return $this->isAuthorized($user, AuthorizedPages::PICKLISTS);
        });
        Gate::define(AuthorizedPages::PICKLIST_CONFIRMATIONS, function (User $user) {
            return $this->isAuthorized($user, AuthorizedPages::PICKLIST_CONFIRMATIONS);
        });

        // Storages
        Gate::define(AuthorizedPages::STORAGES, function (User $user) {
            return $this->isAuthorized($user, AuthorizedPages::STORAGES);
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
            case AuthorizedPages::USERS:
            case 'warehouses':
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
