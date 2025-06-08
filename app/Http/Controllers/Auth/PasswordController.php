<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Affiche le formulaire de changement de mot de passe.
     */
    public function edit(): \Illuminate\View\View
    {
        return view('auth.passwords.change');
    }

    /**
     * Met à jour le mot de passe de l'utilisateur.
     */
    public function update(Request $request): RedirectResponse
    {
        // Validation des champs
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => [
    'required',
    'confirmed',
    Password::min(12)      // longueur ≥ 12
        ->mixedCase()      // majuscule + minuscule
        ->letters()        // au moins une lettre
        ->numbers()        // au moins un chiffre
        ->symbols(),       // au moins un caractère spécial
],
        ]);

        // Mise à jour du mot de passe
        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        // Redirection avec message de succès
        return back()->with('success', 'Votre mot de passe a bien été mis à jour.');
    }
}
