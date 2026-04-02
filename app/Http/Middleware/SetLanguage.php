<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLanguage
{
    public function handle(Request $request, Closure $next)
    {
        $normalize = function (?string $value): ?string {
            if ($value === null) {
                return null;
            }

            if ($value === 'eng') {
                return 'en';
            }

            return in_array($value, ['fr', 'en']) ? $value : null;
        };

        $lang = $normalize($request->segment(1));

        if ($lang) {
            app()->setLocale($lang);
            session(['locale' => $lang]);
        } elseif (session()->has('locale')) {
            $sessionLang = $normalize(session('locale')) ?: 'fr';
            app()->setLocale($sessionLang);
            session(['locale' => $sessionLang]);
        } else {
            app()->setLocale('fr');
            session(['locale' => 'fr']);
        }

        return $next($request);
    }
}
