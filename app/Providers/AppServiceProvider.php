<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Schema;
use Laravel\Passport\Client;
use Laravel\Passport\PersonalAccessClient;
use Ramsey\Uuid\Uuid;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Passport::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        setLocale(LC_TIME, 'id_ID');
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        Schema::defaultStringLength(191);

        /* Begin : UUID Adjustment */
        Client::creating(function (Client $client) {
            $client->incrementing = false;
            $client->id = Uuid::uuid4()->toString();
        });

        PersonalAccessClient::creating(function (PersonalAccessClient $personal_access_client) {
            $personal_access_client->incrementing = false;
            $personal_access_client->id = Uuid::uuid4()->toString();
        });

        Permission::retrieved(function (Permission $permission) {
            $permission->incrementing = false;
        });

        Permission::creating(function (Permission $permission) {
            $permission->incrementing = false;
            $permission->id = Uuid::uuid4()->toString();
        });

        Role::retrieved(function (Role $role) {
            $role->incrementing = false;
        });

        Role::creating(function (Role $role) {
            $role->incrementing = false;
            $role->id = Uuid::uuid4()->toString();
        });

        /* End : UUID Adjustment */

        $registrar = new \App\Core\ResourceRegistrar($this->app['router']);

        $this->app->bind('Illuminate\Routing\ResourceRegistrar', function () use ($registrar) {
            return $registrar;
        });

        Passport::routes();

        // Own Directive
        $this->generateOwnDirective();
    }

    private function generateOwnDirective()
    {
        // Input Form
        Blade::include('directives.input-text', 'inputText');

        Blade::include('directives.input-textarea', 'inputTextArea');

        Blade::include('directives.input-option', 'inputOption');

        Blade::include('directives.input-radio', 'inputRadio');

        Blade::include('directives.input-file', 'inputFile');

        Blade::include('directives.input-checkbox', 'inputCheckbox');

        Blade::include('directives.input-readonly', 'inputReadonly');

        // Navs
        Blade::include('directives.navs', 'navs');
    }
}
