<?php

namespace App\Http\Controllers;

use App\Models\Adherent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NageurController extends Controller
{
    /**
     * Espace d'accueil du nageur.
     */
    public function espace()
    {
        // Simple vue de bienvenue (tu peux y mettre des stats, etc.)
        return view('nageur.espace');
    }

    /**
     * Affiche le formulaire de profil personnel du nageur (lié à son user_id).
     */
    public function profil()
    {
        $user     = Auth::user();
        $adherent = Adherent::where('user_id', $user->id)->first();

        // Si aucun article Adherent n'existe pour ce user, on en crée un vide (ou on l'invite à remplir)
        if (! $adherent) {
            $adherent = Adherent::create([
                'user_id'               => $user->id,
                'prenom'                => $user->name,    // Valeur par défaut : on peut suggérer le nom depuis le User
                'nom'                   => '',
                'date_naissance'        => null,
                'adresse'               => null,
                'ville'                 => null,
                'code_postal'           => null,
                'telephone'             => null,
                'statut'                => 'adhérent',
                'photo_path'            => null,
                'date_certificat'       => null,
                'est_archive'           => false,
                'visible_trombinoscope' => true,
                'visible_annuaire'      => true,
            ]);
        }

        return view('nageur.profil', compact('adherent'));
    }

    /**
     * Met à jour les infos personnelles du nageur (son Adherent lié).
     */
    public function updateProfil(Request $request)
    {
        $user     = Auth::user();
        $adherent = Adherent::where('user_id', $user->id)->firstOrFail();

        // Validation (tu peux ajuster selon besoins)
        $validated = $request->validate([
            'prenom'                => ['required', 'string', 'max:255'],
            'nom'                   => ['required', 'string', 'max:255'],
            'date_naissance'        => ['nullable', 'date'],
            'adresse'               => ['nullable', 'string', 'max:255'],
            'ville'                 => ['nullable', 'string', 'max:100'],
            'code_postal'           => ['nullable', 'string', 'max:10'],
            'telephone'             => ['nullable', 'string', 'max:20'],
            'photo_path'            => ['nullable', 'image', 'max:2048'],
            'date_certificat'       => ['nullable', 'date'],
            'visible_trombinoscope' => ['sometimes', 'boolean'],
            'visible_annuaire'      => ['sometimes', 'boolean'],
        ]);

        // Gestion de l’upload de la photo, si nouvelle photo
        if ($request->hasFile('photo_path') && $request->file('photo_path')->isValid()) {
            if ($adherent->photo_path) {
                Storage::disk('public')->delete($adherent->photo_path);
            }
            $chemin                = $request->file('photo_path')
                                           ->store('adherents_photos', 'public');
            $validated['photo_path'] = $chemin;
        }

        // Met à jour les flags de visibilité : si inexistant dans la requête, on force à false
        $validated['visible_trombinoscope'] = $request->has('visible_trombinoscope');
        $validated['visible_annuaire']      = $request->has('visible_annuaire');

        // Met à jour l’Adherent en base
        $adherent->update($validated);

        return redirect()
            ->route('nageur.profil')
            ->with('success', 'Votre profil a bien été mis à jour.');
    }

    /**
     * Affiche le trombinoscope : lister tous les adhérents où visible_trombinoscope = true ET non archivés.
     */
    public function trombinoscope()
    {
        $trombinos = Adherent::where('visible_trombinoscope', true)
                             ->where('est_archive', false)
                             ->orderBy('nom')
                             ->orderBy('prenom')
                             ->get();

        return view('nageur.trombinoscope', compact('trombinos'));
    }

    /**
     * Affiche l’annuaire : lister tous les adhérents où visible_annuaire = true ET non archivés.
     */
    public function annuaire()
    {
        $annuaire = Adherent::where('visible_annuaire', true)
                            ->where('est_archive', false)
                            ->orderBy('nom')
                            ->orderBy('prenom')
                            ->get();

        return view('nageur.annuaire', compact('annuaire'));
    }
}

