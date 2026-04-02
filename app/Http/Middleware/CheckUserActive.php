<?php
// app/Http/Middleware/CheckUserActive.php
// Middleware 2 - Verifie si l'utilisateur connecte est actif
// Si is_active = false -> deconnexion forcee

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserActive
{
    public function handle(Request $request, Closure $next)
    {
        // Si l'user est connecte mais desactive par l'admin
        if (Auth::check() && !Auth::user()->is_active) {
            Auth::logout(); // deconnexion

            $lang = $request->segment(1);
            if (!in_array($lang, ['fr', 'en'])) {
                $lang = session('locale', 'fr');
            }

            return redirect()->route('login', ['lang' => $lang])
                ->with('error', 'Votre compte a ete desactive.');
        }

        return $next($request);
    }
}
