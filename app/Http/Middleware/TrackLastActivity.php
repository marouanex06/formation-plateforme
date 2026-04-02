<?php
// app/Http/Middleware/TrackLastActivity.php
// Middleware 3 — Enregistre la dernière activité de l'utilisateur
// Utile pour savoir si un user est "en ligne"

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TrackLastActivity
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // Sauvegarde dans le cache la dernière activité
            // Clé: "last_activity_userId" — expire après 5 minutes
            $key = 'last_activity_' . Auth::id();
            Cache::put($key, now(), 300); // 300 secondes = 5 min
        }

        return $next($request);
    }
}