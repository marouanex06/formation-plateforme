<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TrainingSession;
use App\Models\Formation;
use App\Models\User;

class TrainingSessionSeeder extends Seeder
{
    public function run(): void
    {
        $formations = Formation::orderBy('id')->get();
        $formateurs = User::role('formateur')->get();

        if ($formations->isEmpty() || $formateurs->isEmpty()) {
            return;
        }

        $modes = ['presentiel', 'en_ligne', 'hybride'];
        $cities = ['Casablanca', 'Rabat', 'Marrakech'];

        foreach ($formations as $index => $formation) {
            $start = now()->addDays(7 + ($index * 7));
            $end = (clone $start)->addDays(1);
            $mode = $modes[$index % count($modes)];

            TrainingSession::create([
                'formation_id' => $formation->id,
                'user_id' => $formateurs[$index % $formateurs->count()]->id,
                'start_date' => $start->toDateString(),
                'end_date' => $end->toDateString(),
                'capacity' => 20,
                'mode' => $mode,
                'city' => $mode === 'presentiel' ? $cities[$index % count($cities)] : null,
                'meeting_link' => $mode === 'presentiel' ? null : 'https://meet.example.com/session-' . $formation->id,
                'status' => 'planifiee',
            ]);
        }
    }
}
