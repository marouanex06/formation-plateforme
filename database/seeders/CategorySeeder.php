<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name_fr' => 'Developpement Web', 'name_en' => 'Web Development'],
            ['name_fr' => 'Design & UX', 'name_en' => 'Design & UX'],
            ['name_fr' => 'Communication', 'name_en' => 'Communication'],
        ];

        foreach ($items as $item) {
            Category::firstOrCreate(
                ['name_fr' => $item['name_fr']],
                ['name_en' => $item['name_en']]
            );
        }
    }
}
