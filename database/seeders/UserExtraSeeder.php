<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserExtraSeeder extends Seeder
{
    public function run(): void
    {
        $formateurs = [
            ['name' => 'Formateur One', 'email' => 'formateur1@gmail.com'],
            ['name' => 'Formateur Two', 'email' => 'formateur2@gmail.com'],
        ];

        foreach ($formateurs as $item) {
            $user = User::firstOrCreate(
                ['email' => $item['email']],
                [
                    'name' => $item['name'],
                    'password' => Hash::make('formateur123'),
                    'phone' => '0600000001',
                    'language' => 'fr',
                    'is_active' => true,
                ]
            );
            $user->syncRoles(['formateur']);
        }

        $participants = [
            ['name' => 'Participant One', 'email' => 'participant1@gmail.com'],
            ['name' => 'Participant Two', 'email' => 'participant2@gmail.com'],
        ];

        foreach ($participants as $item) {
            $user = User::firstOrCreate(
                ['email' => $item['email']],
                [
                    'name' => $item['name'],
                    'password' => Hash::make('participant123'),
                    'phone' => '0600000002',
                    'language' => 'fr',
                    'is_active' => true,
                ]
            );
            $user->syncRoles(['participant']);
        }
    }
}
