<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifierNageur
{
    /**
     * Empêche l'accès si l'utilisateur n'est pas "nageur".
     */
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::check() || Auth::user()->role !== 'nageur') {
            // Renvoie une 403 Forbidden si le rôle n'est pas "nageur"
            abort(403, 'Accès réservé aux nageurs.');
        }

        return $next($request);
    }
}
