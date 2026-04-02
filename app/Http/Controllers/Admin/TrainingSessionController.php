<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainingSession;
use App\Models\Formation;
use App\Models\User;
use App\Http\Requests\StoreSessionRequest;
use App\Enums\SessionMode;

class TrainingSessionController extends Controller
{
    public function index()
    {
        $sessions = TrainingSession::with(['formation', 'formateur'])
            ->latest()
            ->paginate(15);

        return view('admin.sessions.index', compact('sessions'));
    }

    public function create()
    {
        $formations = Formation::published()->get();
        $formateurs = User::role('formateur')->get();
        $modes      = SessionMode::cases();

        return view('admin.sessions.create', compact('formations', 'formateurs', 'modes'));
    }

    public function store(StoreSessionRequest $request)
    {
        TrainingSession::create($request->validated());

        return redirect()->route('admin.sessions.index')
            ->with('success', 'Session créée avec succès.');
    }

    public function edit(TrainingSession $session)
    {
        $formations = Formation::published()->get();
        $formateurs = User::role('formateur')->get();
        $modes      = SessionMode::cases();

        return view('admin.sessions.edit', compact('session', 'formations', 'formateurs', 'modes'));
    }

    public function update(StoreSessionRequest $request, TrainingSession $session)
    {
        $session->update($request->validated());

        return redirect()->route('admin.sessions.index')
            ->with('success', 'Session mise à jour.');
    }

    public function destroy(TrainingSession $session)
    {
        $session->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.sessions.index')
            ->with('success', 'Session supprimée.');
    }
}