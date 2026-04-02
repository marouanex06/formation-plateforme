<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Formation;
use App\Models\TrainingSession;
use App\Models\Inscription;
use App\Models\ContactMessage;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'          => User::count(),
            'total_formations'     => Formation::count(),
            'total_sessions'       => TrainingSession::count(),
            'total_inscriptions'   => Inscription::count(),
            'pending_inscriptions' => Inscription::where('status', 'en_attente')->count(),
            'unread_messages'      => ContactMessage::where('is_read', false)->count(),
        ];

        $recentInscriptions = Inscription::with(['user', 'session.formation'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentInscriptions'));
    }
}