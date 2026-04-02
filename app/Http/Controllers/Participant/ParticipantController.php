<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use App\Models\TrainingSession;
use App\Models\Inscription;
use App\Enums\InscriptionStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ParticipantController extends Controller
{
    // Dashboard participant
    public function dashboard()
    {
        $user = Auth::user();
        $inscriptions = Inscription::with(['session.formation'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('participant.dashboard', compact('inscriptions'));
    }

    // Liste des formations disponibles
    public function formations()
    {
        $formations = Formation::published()
            ->with(['category', 'sessions' => function($q) {
                $q->where('start_date', '>', now())
                  ->where('status', 'planifiee');
            }])
            ->paginate(12);

        return view('participant.formations', compact('formations'));
    }

    // Détail formation + sessions disponibles
    public function showFormation(Formation $formation)
    {
        $formation->load(['category']);
        $sessions = TrainingSession::where('formation_id', $formation->id)
            ->where('start_date', '>', now())
            ->where('status', 'planifiee')
            ->with('formateur')
            ->get();

        $userInscriptions = Inscription::where('user_id', Auth::id())
            ->whereIn('session_id', $sessions->pluck('id'))
            ->pluck('session_id')
            ->toArray();

        return view('participant.formation-detail', compact('formation', 'sessions', 'userInscriptions'));
    }

    // S'inscrire à une session
    public function inscrire(Request $request, TrainingSession $session)
    {
        $user = Auth::user();

        // Vérifier si déjà inscrit
        $exists = Inscription::where('user_id', $user->id)
            ->where('session_id', $session->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Vous êtes déjà inscrit à cette session.');
        }

        // Vérifier capacité
        $count = Inscription::where('session_id', $session->id)
            ->whereIn('status', ['en_attente', 'confirmee'])
            ->count();

        if ($count >= $session->capacity) {
            return back()->with('error', 'Cette session est complète.');
        }

        Inscription::create([
            'user_id'    => $user->id,
            'session_id' => $session->id,
            'status'     => InscriptionStatus::EnAttente,
            'reference'  => 'INS-' . strtoupper(Str::random(8)),
        ]);

        return back()->with('success', 'Inscription effectuée ! En attente de confirmation.');
    }

    // Annuler son inscription
    public function annuler(Inscription $inscription)
    {
        if ($inscription->user_id !== Auth::id()) {
            abort(403);
        }

        $inscription->update(['status' => InscriptionStatus::Annulee]);

        return back()->with('success', 'Inscription annulée.');
    }
}