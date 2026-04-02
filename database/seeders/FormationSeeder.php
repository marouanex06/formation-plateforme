<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\Formation;
use App\Models\Category;
use App\Enums\FormationStatus;

class FormationSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all()->keyBy('name_fr');

        $items = [
            [
                'title_fr' => 'Laravel Avance',
                'title_en' => 'Advanced Laravel',
                'short_desc_fr' => 'Maitriser Laravel pour construire des apps solides.',
                'short_desc_en' => 'Master Laravel to build solid applications.',
                'full_desc_fr' => 'Routing avance, policies, jobs, events et bonnes pratiques.',
                'full_desc_en' => 'Advanced routing, policies, jobs, events and best practices.',
                'price' => 500,
                'duration' => '24',
                'level' => 'Intermediaire',
                'category' => 'Developpement Web',
            ],
            [
                'title_fr' => 'React Essentials',
                'title_en' => 'React Essentials',
                'short_desc_fr' => 'Composants, state, hooks et routing.',
                'short_desc_en' => 'Components, state, hooks and routing.',
                'full_desc_fr' => 'Build UI reactives avec les meilleurs patterns.',
                'full_desc_en' => 'Build reactive UIs with solid patterns.',
                'price' => 450,
                'duration' => '20',
                'level' => 'Intermediaire',
                'category' => 'Developpement Web',
            ],
            [
                'title_fr' => 'UI/UX Design',
                'title_en' => 'UI/UX Design',
                'short_desc_fr' => 'Principes UI, research et parcours utilisateur.',
                'short_desc_en' => 'UI principles, research and user journeys.',
                'full_desc_fr' => 'Wireframes, prototypes et tests utilisateurs.',
                'full_desc_en' => 'Wireframes, prototypes and user testing.',
                'price' => 400,
                'duration' => '18',
                'level' => 'Debutant',
                'category' => 'Design & UX',
            ],
            [
                'title_fr' => 'Marketing Digital',
                'title_en' => 'Digital Marketing',
                'short_desc_fr' => 'SEO, reseaux sociaux, ads et contenu.',
                'short_desc_en' => 'SEO, social media, ads and content.',
                'full_desc_fr' => 'Plan marketing, analytics et strategie.',
                'full_desc_en' => 'Marketing plan, analytics and strategy.',
                'price' => 350,
                'duration' => '16',
                'level' => 'Debutant',
                'category' => 'Communication',
            ],
            [
                'title_fr' => 'Analyse de donnees avec Excel',
                'title_en' => 'Data Analysis with Excel',
                'short_desc_fr' => 'Tableaux, TCD et dashboards.',
                'short_desc_en' => 'Tables, pivot tables and dashboards.',
                'full_desc_fr' => 'Nettoyage, analyse et visualisation.',
                'full_desc_en' => 'Cleaning, analysis and visualization.',
                'price' => 300,
                'duration' => '14',
                'level' => 'Debutant',
                'category' => 'Communication',
            ],
            [
                'title_fr' => 'JavaScript Moderne',
                'title_en' => 'Modern JavaScript',
                'short_desc_fr' => 'ES6+, async, modules et tooling.',
                'short_desc_en' => 'ES6+, async, modules and tooling.',
                'full_desc_fr' => 'Bases solides pour front et back.',
                'full_desc_en' => 'Solid foundations for front and back.',
                'price' => 420,
                'duration' => '22',
                'level' => 'Intermediaire',
                'category' => 'Developpement Web',
            ],
        ];

        $gradients = [
            ['#1D4ED8', '#60A5FA'],
            ['#0F766E', '#5EEAD4'],
            ['#7C3AED', '#C4B5FD'],
            ['#B45309', '#FCD34D'],
            ['#BE123C', '#FDA4AF'],
            ['#374151', '#9CA3AF'],
        ];

        foreach ($items as $index => $item) {
            $category = $categories[$item['category']] ?? null;
            if (!$category) {
                continue;
            }

            $formation = Formation::firstOrCreate(
                ['title_fr' => $item['title_fr']],
                [
                    'category_id' => $category->id,
                    'title_en' => $item['title_en'],
                    'short_desc_fr' => $item['short_desc_fr'],
                    'short_desc_en' => $item['short_desc_en'],
                    'full_desc_fr' => $item['full_desc_fr'],
                    'full_desc_en' => $item['full_desc_en'],
                    'price' => $item['price'],
                    'duration' => $item['duration'],
                    'level' => $item['level'],
                    'status' => FormationStatus::Publie,
                    'published_at' => now(),
                ]
            );

            if (empty($formation->image)) {
                $colors = $gradients[$index % count($gradients)];
                $svg = $this->makePlaceholderSvg($colors[0], $colors[1]);
                $path = 'formations/placeholders/formation-' . $formation->id . '.svg';
                Storage::disk('public')->put($path, $svg);
                $formation->image = $path;
                $formation->save();
            }
        }
    }

    private function makePlaceholderSvg(string $start, string $end): string
    {
        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="1200" height="700" viewBox="0 0 1200 700">
  <defs>
    <linearGradient id="grad" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0%" stop-color="{$start}"/>
      <stop offset="100%" stop-color="{$end}"/>
    </linearGradient>
  </defs>
  <rect width="1200" height="700" fill="url(#grad)"/>
  <circle cx="980" cy="140" r="120" fill="rgba(255,255,255,0.15)"/>
  <circle cx="260" cy="520" r="180" fill="rgba(255,255,255,0.12)"/>
  <rect x="120" y="210" width="520" height="60" rx="30" fill="rgba(255,255,255,0.18)"/>
  <text x="120" y="250" font-family="Arial, sans-serif" font-size="36" fill="white" letter-spacing="2">FORMATION</text>
</svg>
SVG;
    }
}
