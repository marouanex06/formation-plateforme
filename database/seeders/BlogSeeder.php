<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\Category;
use App\Models\User;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::where('email', 'admin@gmail.com')->first();
        if (!$author) {
            return;
        }

        $category = Category::first();

        $items = [
            [
                'title_fr' => 'Comment choisir une formation efficace',
                'title_en' => 'How to choose an effective training',
                'content_fr' => 'Conseils pour choisir une formation adaptee a vos objectifs et a votre niveau.',
                'content_en' => 'Tips to choose a training that fits your goals and level.',
            ],
            [
                'title_fr' => 'Les tendances du developpement web',
                'title_en' => 'Web development trends',
                'content_fr' => 'Un tour rapide des tendances actuelles: frameworks, IA et cloud.',
                'content_en' => 'A quick look at current trends: frameworks, AI and cloud.',
            ],
            [
                'title_fr' => 'Ameliorer son CV apres une formation',
                'title_en' => 'Improve your resume after training',
                'content_fr' => 'Structure, mots cles et conseils pratiques pour un CV plus fort.',
                'content_en' => 'Structure, keywords and practical tips for a stronger resume.',
            ],
        ];

        foreach ($items as $item) {
            Blog::firstOrCreate(
                ['title_fr' => $item['title_fr']],
                [
                    'user_id' => $author->id,
                    'category_id' => $category?->id,
                    'title_en' => $item['title_en'],
                    'content_fr' => $item['content_fr'],
                    'content_en' => $item['content_en'],
                    'status' => 'published',
                    'published_at' => now(),
                ]
            );
        }
    }
}
