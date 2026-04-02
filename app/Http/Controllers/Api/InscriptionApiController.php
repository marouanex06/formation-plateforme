<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inscription;
use App\Models\TrainingSession;
use App\Http\Requests\StoreInscriptionRequest;
use Illuminate\Http\Request;

class InscriptionApiController extends Controller
{
    public function myInscriptions(Request $request)
    {
        $inscriptions = $request->user()
            ->inscriptions()
            ->with(['session.formation'])
            ->latest()
            ->get();

        return response()->json(['data' => $inscriptions]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'session_id' => ['required', 'exists:training_sessions,id'],
        ]);

        $session = TrainingSession::findOrFail($request->session_id);

        if ($session->isFull()) {
            return response()->json(['message' => 'Session complète.'], 422);
        }

        $alreadyRegistered = $request->user()
            ->inscriptions()
            ->where('session_id', $request->session_id)
            ->whereIn('status', ['en_attente', 'confirmee'])
            ->exists();

        if ($alreadyRegistered) {
            return response()->json(['message' => 'Déjà inscrit.'], 422);
        }

        $inscription = Inscription::create([
            'user_id'    => $request->user()->id,
            'session_id' => $request->session_id,
            'status'     => 'en_attente',
        ]);

        return response()->json(['data' => $inscription], 201);
    }
}