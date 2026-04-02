<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Créer les permissions
        $permissions = [
            'manage-users',
            'manage-categories',
            'manage-formations',
            'manage-sessions',
            'manage-inscriptions',
            'publish-formation',
            'view-dashboard',
            'manage-blog',
            'view-reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Créer les rôles et assigner les permissions
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo([
            'manage-users',
            'manage-categories',
            'manage-formations',
            'manage-sessions',
            'manage-inscriptions',
            'publish-formation',
            'view-dashboard',
            'manage-blog',
            'view-reports',
        ]);

        $formateur = Role::firstOrCreate(['name' => 'formateur']);
        $formateur->givePermissionTo([
            'manage-sessions',
            'view-dashboard',
        ]);

        $participant = Role::firstOrCreate(['name' => 'participant']);
        $participant->givePermissionTo([
            'manage-inscriptions',
        ]);
    }
}