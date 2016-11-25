<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
    'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function($user) {
            if($user->roles->where('name', 'super_admin')->count())
                return true;
        });

        Gate::define('adminsystem', function ($user) {
            return (Gate::allows('view_list_admin') || Gate::allows('view_list_partner') || Gate::allows('modify_overdue') || Gate::allows('view_report_overdue') || Gate::allows('view_log') || Gate::allows('view_systeminfo'));
        });

        Gate::define('view_list_admin', function ($user) {
            if(Gate::allows('create_admin_account') || Gate::allows('modify_admin_account') || Gate::allows('restore_password_admin_account'))
                return true;
            return $user->roles->where('name', 'view_list_admin')->count();
        });

        Gate::define('create_admin_account', function ($user) {
            return $user->roles->where('name', 'create_admin_account')->count();
        });

        Gate::define('modify_admin_account', function ($user) {
            return $user->roles->where('name', 'modify_admin_account')->count();
        });

        Gate::define('restore_password_admin_account', function ($user) {
            return $user->roles->where('name', 'restore_password_admin_account')->count();
        });

        Gate::define('view_list_partner', function ($user) {
            if(Gate::allows('create_partner_account') || Gate::allows('modify_partner_account') || Gate::allows('restore_password_partner_account'))
                return true;
            return $user->roles->where('name', 'view_list_partner')->count();
        });

        Gate::define('create_partner_account', function ($user) {
            return $user->roles->where('name', 'create_partner_account')->count();
        });

        Gate::define('modify_partner_account', function ($user) {
            return $user->roles->where('name', 'modify_partner_account')->count();
        });

        Gate::define('restore_password_partner_account', function ($user) {
            return $user->roles->where('name', 'restore_password_partner_account')->count();
        });

        Gate::define('view_list_sector_type_location', function ($user) {
            if(Gate::allows('add_sector') || Gate::allows('add_type') || Gate::allows('add_location') || Gate::allows('view_list_billdetail_payment'))
                return true;
            return $user->roles->where('name', 'view_list_sector_type_location')->count();
        });

        Gate::define('add_sector', function ($user) {
            return $user->roles->where('name', 'add_sector')->count();
        });

        Gate::define('add_type', function ($user) {
            return $user->roles->where('name', 'add_type')->count();
        });

        Gate::define('add_location', function ($user) {
            return $user->roles->where('name', 'add_location')->count();
        });

        Gate::define('view_list_billdetail_payment', function ($user) {
            if(Gate::allows('add_payment') || Gate::allows('modify_payment') || Gate::allows('delete_payment') || Gate::allows('delete_billdetail'))
                return true;
            return $user->roles->where('name', 'view_list_billdetail_payment')->count();
        });

        Gate::define('add_payment', function ($user) {
            return $user->roles->where('name', 'add_payment')->count();
        });

        Gate::define('modify_payment', function ($user) {
            return $user->roles->where('name', 'modify_payment')->count();
        });

        Gate::define('delete_payment', function ($user) {
            return $user->roles->where('name', 'delete_payment')->count();
        });

        Gate::define('delete_billdetail', function ($user) {
            return $user->roles->where('name', 'delete_billdetail')->count();
        });

        Gate::define('view_list_group', function ($user) {
            if(Gate::allows('add_group') || Gate::allows('modify_group'))
                return true;
            return $user->roles->where('name', 'view_list_group')->count();
        });

        Gate::define('add_group', function ($user) {
            return $user->roles->where('name', 'add_group')->count();
        });

        Gate::define('modify_group', function ($user) {
            return $user->roles->where('name', 'modify_group')->count();
        });

        Gate::define('view_list_bill', function ($user) {
            if(Gate::allows('add_bill') || Gate::allows('modify_bill'))
                return true;
            return $user->roles->where('name', 'view_list_bill')->count();
        });

        Gate::define('add_bill', function ($user) {
            return $user->roles->where('name', 'add_bill')->count();
        });

        Gate::define('modify_bill', function ($user) {
            return $user->roles->where('name', 'modify_bill')->count();
        });

        Gate::define('modify_billdetail', function ($user) {
            return $user->roles->where('name', 'modify_billdetail')->count();
        });

        Gate::define('new_message', function ($user) {
            return $user->roles->where('name', 'new_message')->count();
        });

        Gate::define('new_file', function ($user) {
            return $user->roles->where('name', 'new_file')->count();
        });

        Gate::define('delete_message_file', function ($user) {
            return $user->roles->where('name', 'delete_message_file')->count();
        });

        Gate::define('modify_overdue', function ($user) {
            return $user->roles->where('name', 'modify_overdue')->count();
        });

        Gate::define('view_report_overdue', function ($user) {
            return $user->roles->where('name', 'view_report_overdue')->count();
        });

        Gate::define('view_report_external_accounting', function ($user) {
            return $user->roles->where('name', 'view_report_external_accounting')->count();
        });

        Gate::define('view_log', function ($user) {
            return $user->roles->where('name', 'view_log')->count();
        });

        Gate::define('view_systeminfo', function ($user) {
            return $user->roles->where('name', 'view_systeminfo')->count();
        });

        Gate::define('mail_ssd_warning', function ($user) {
            return $user->roles->where('name', 'mail_ssd_warning')->count();
        });
    }
}
