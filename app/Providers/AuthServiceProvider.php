<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\User;
use App\Models\Device;
use App\Models\DeviceType;
use App\Models\Document;
use App\Models\Worksheet;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use App\Policies\DevicePolicy;
use App\Policies\DeviceTypePolicy;
use App\Policies\DocumentPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\WorksheetPolicy;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Permission::class => PermissionPolicy::class,
        Role::class => RolePolicy::class,
        User::class => UserPolicy::class,
        Device::class => DevicePolicy::class,
        DeviceType::class => DeviceTypePolicy::class,
        Document::class => DocumentPolicy::class,
        Worksheet::class => WorksheetPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
