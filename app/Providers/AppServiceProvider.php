<?php

namespace App\Providers;

use App\Models\Admin\userTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use App\Models\Admin\userrolesaccesstable;
use App\Models\Admin\approveauthoritytable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
       // Dynamically share user-specific data with all views
        View::composer('*', function ($view) {
            $user = Auth::user(); // Ensure this runs after authentication is initialized
            $email = Session::get('email');
            $userTable=userTable::where('email',$email)->first();
            if ($userTable) {
                $approveauthority = userrolesaccesstable::where('user_id', $userTable->userid)->first();

                $settings = [
                    'role' => $approveauthority ? $approveauthority->role_id : 'Guest',
                ];

                $view->with('settings', $settings);
            } else {
                $view->with('settings', ['role' => 'Guest']);
            }
        });
    }
}
