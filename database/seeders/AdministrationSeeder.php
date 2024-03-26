<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;


class AdministrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // USER MODEL
        $userPermission1 = Permission::create(['name' => 'create users']);
        $userPermission2 = Permission::create(['name' => 'read users']);
        $userPermission3 = Permission::create(['name' => 'update users']);
        $userPermission4 = Permission::create(['name' => 'delete users']);

        // ROLE MODEL
        $rolePermission1 = Permission::create(['name' => 'create roles']);
        $rolePermission2 = Permission::create(['name' => 'read roles']);
        $rolePermission3 = Permission::create(['name' => 'update roles']);
        $rolePermission4 = Permission::create(['name' => 'delete roles']);

        // PERMISSION MODEL
        $permission1 = Permission::create(['name' => 'create permissions']);
        $permission2 = Permission::create(['name' => 'read permissions']);
        $permission3 = Permission::create(['name' => 'update permissions']);
        $permission4 = Permission::create(['name' => 'delete permissions']);

        // DEVICETYPE MODEL
        $deviceType1 = Permission::create(['name' => 'create devicetypes']);
        $deviceType2 = Permission::create(['name' => 'read devicetypes']);
        $deviceType3 = Permission::create(['name' => 'update devicetypes']);
        $deviceType4 = Permission::create(['name' => 'delete devicetypes']);

        // DEVICE MODEL
        $device1 = Permission::create(['name' => 'create devices']);
        $device2 = Permission::create(['name' => 'read devices']);
        $device3 = Permission::create(['name' => 'update devices']);
        $device4 = Permission::create(['name' => 'delete devices']);

        // DOCUMENT MODEL
        $document1 = Permission::create(['name' => 'create documents']);
        $document2 = Permission::create(['name' => 'read documents']);
        $document3 = Permission::create(['name' => 'update documents']);
        $document4 = Permission::create(['name' => 'delete documents']);

        $adminRole = Role::create(['name' => 'admin'])->syncPermissions([
            $userPermission1,
            $userPermission2,
            $userPermission3,
            $userPermission4,
            $rolePermission1,
            $rolePermission2,
            $rolePermission3,
            $rolePermission4,
            $permission1,
            $permission2,
            $permission3,
            $permission4,
            $deviceType1,
            $deviceType2,
            $deviceType3,
            $deviceType4,
            $device1,
            $device2,
            $device3,
            $device4,
            $document1,
            $document2,
            $document3,
            $document4,
        ]);
        $repairerRole = Role::create(['name' => 'karbantartó'])->syncPermissions([
            $device2,
            $document2,
        ]);
        $operatorRole = Role::create(['name' => 'gépkezelő'])->syncPermissions([
            $device2,
            $document2,
        ]);

        // CREATE ADMINS & USERS
        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.hu',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ])->assignRole($adminRole);

        User::create([
            'name' => 'repairer',
            'email' => 'repairer@admin.hu',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ])->assignRole($repairerRole);

        User::create([
            'name' => 'operator',
            'email' => 'operator@admin.hu',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ])->assignRole($operatorRole);
    }
}
