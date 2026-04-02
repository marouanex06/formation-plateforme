<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inscription;
use App\Enums\InscriptionStatus;
use App\Notifications\InscriptionConfirmedNotification;
use App\Notifications\InscriptionCancelledNotification;

class InscriptionController extends Controller
{
    public function index()
    {
        $inscriptions = Inscription::with(['user', 'session.formation'])
            ->latest()
            ->paginate(20);

        return view('admin.inscriptions.index', compact('inscriptions'));
    }

    public function show(Inscription $inscription)
    {
        $inscription->load(['user', 'session.formation', 'session.formateur']);
        return view('admin.inscriptions.show', compact('inscription'));
    }

    public function confirm(Inscription $inscription)
    {
        $inscription->update([
            'status'       => InscriptionStatus::Confirmee,
            'confirmed_at' => now(),
        ]);

        try {
            $inscription->user?->notify(new InscriptionConfirmedNotification($inscription));
        } catch (\Throwable $e) {
            // Notifications are optional; ignore failures in local/dev.
        }

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'status' => 'confirmee']);
        }

        return back()->with('success', 'Inscription confirmée.');
    }

    public function cancel(Inscription $inscription)
    {
        $inscription->update([
            'status'       => InscriptionStatus::Annulee,
            'cancelled_at' => now(),
        ]);

        try {
            $inscription->user?->notify(new InscriptionCancelledNotification($inscription));
        } catch (\Throwable $e) {
            // Notifications are optional; ignore failures in local/dev.
        }

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'status' => 'annulee']);
        }

        return back()->with('success', 'Inscription annulée.');
    }

    public function destroy(Inscription $inscription)
    {
        $inscription->delete();

        return redirect()->route('admin.inscriptions.index')
            ->with('success', 'Inscription supprimée.');
    }
}
