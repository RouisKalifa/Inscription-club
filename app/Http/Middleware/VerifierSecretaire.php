<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifierSecretaire
{
    /**
     * Empêche l’accès si l’utilisateur n’est pas “secretaire”.
     */
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::check() || Auth::user()->role !== 'secretaire') {
            // Renvoie une 403 Forbidden si le rôle n’est pas “secretaire”
            abort(403, 'Accès réservé aux secrétaires.');
        }

        return $next($request);
    }
}

