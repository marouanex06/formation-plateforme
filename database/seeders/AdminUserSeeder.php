<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'      => 'Super Admin',
                'password'  => bcrypt('admin123'),
                'phone'     => '0600000000',
                'language'  => 'fr',
                'is_active' => true,
            ]
        );

        $admin->assignRole('super-admin');
    }
}