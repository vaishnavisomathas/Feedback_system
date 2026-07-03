<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $roles = [
            'Super Admin',
            'Admin',
            'Commissioner',
            'Administrative Officer',
            'User',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web',
            ]);
        }

        $superAdminEmail = env('SEED_SUPER_ADMIN_EMAIL', 'superadmin@pdmt.local');
        $superAdminPassword = env('SEED_SUPER_ADMIN_PASSWORD', 'password123');

        $superAdmin = User::updateOrCreate(
            ['email' => $superAdminEmail],
            [
                'name' => 'Super Admin',
                'password' => Hash::make($superAdminPassword),
                'role' => 'Super Admin',
                'must_change_password' => false,
            ]
        );

        $superAdmin->syncRoles(['Super Admin']);
    }
}
