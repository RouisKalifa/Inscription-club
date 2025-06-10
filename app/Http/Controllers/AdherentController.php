<?php

namespace App\Http\Controllers;

use App\Models\Adherent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // (si jamais vous supprimez la photo, mais pas obligatoire pour restore)
use Illuminate\Validation\Rules\Password;


class AdherentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupère tous les adherents où est_archive = false, triés par nom
        $adherents = Adherent::where('est_archive', false)
                             ->orderBy('nom')
                             ->orderBy('prenom')
                             ->get();

        // Passe la collection à la vue
        return view('secretaire.adherents.index', compact('adherents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // On renvoie simplement la vue avec le formulaire
        return view('secretaire.adherents.create');
    }

    public function store(Request $request)
{
    // 1) Valider le compte utilisateur
    $request->validate([
        'email_user'                     => ['required', 'email', 'unique:users,email'],
        'password_user'                  => [
    'required',
    'string',
    'confirmed',
    Password::min(12)      // ≥ 12 caractères
        ->mixedCase()      // majuscule + minuscule
        ->letters()        // au moins une lettre
        ->numbers()        // au moins un chiffre
        ->symbols(),       // au moins un caractère spécial
],
        // Ensuite on ajoute les validations déjà en place pour Adherent :
        'prenom'                         => ['required', 'string', 'max:255'],
        'nom'                            => ['required', 'string', 'max:255'],
        'date_naissance'                 => ['nullable', 'date'],
        'adresse'                        => ['nullable', 'string', 'max:255'],
        'ville'                          => ['nullable', 'string', 'max:100'],
        'code_postal'                    => ['nullable', 'string', 'max:10'],
        'telephone'                      => ['nullable', 'string', 'max:20'],
        'statut'                         => ['required', 'string', 'in:adhérent,coach,président'],
        'photo_path'                     => ['nullable', 'image', 'max:2048'],
        'date_certificat'                => ['nullable', 'date'],
        'date_cotisation'    => ['nullable', 'date'],   // ← bien une règle
        'consentement_rgpd'    => ['accepted'],   // ← case cochée obligatoirement
    ]);

    // 2) Créer le compte utilisateur (rôle nageur)
    $user = \App\Models\User::create([
        'name'     => $request->prenom . ' ' . $request->nom,
        'email'    => $request->email_user,
        'password' => bcrypt($request->password_user),
        'role'     => 'nageur',
    ]);

    // 3) Gérer l’upload de la photo, si nécessaire
    $validatedAdherent = $request->only([
        'prenom', 'nom', 'date_naissance', 'adresse',
        'ville', 'code_postal', 'telephone', 'statut',
        'date_certificat','date_cotisation', // ← ajouté
    ]);

    // Enregistres le consentement
$validatedAdherent['consentement_rgpd_at'] = now();

    if ($request->hasFile('photo_path') && $request->file('photo_path')->isValid()) {
        $chemin = $request->file('photo_path')
                          ->store('adherents_photos', 'public');
        $validatedAdherent['photo_path'] = $chemin;
    }

    // 4) Créer la fiche Adherent en liant user_id
    Adherent::create(array_merge($validatedAdherent, [
        'user_id'     => $user->id,
        'est_archive' => false,
        // Les flags de visibilité par défaut à true
        'visible_trombinoscope' => true,
        'visible_annuaire'      => true,
    ]));

    // 5) Rediriger avec message de succès
    return redirect()
        ->route('secretaire.adherents.index')
        ->with('success', "L’adhérent « {$request->prenom} {$request->nom} » a bien été créé et lié au compte nageur.");
}


    /**
     * Display the specified resource.
     */
    public function show(Adherent $adherent)
{
    return view('secretaire.adherents.show', compact('adherent'));
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Adherent $adherent)
{
    // On renvoie la vue avec l’adhérent à modifier
    return view('secretaire.adherents.edit', compact('adherent'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Adherent $adherent)
{
    // 1) Valider les données (mêmes règles que pour store)
    $validated = $request->validate([
        'prenom'         => ['required', 'string', 'max:255'],
        'nom'            => ['required', 'string', 'max:255'],
        'date_naissance' => ['nullable', 'date'],
        'adresse'        => ['nullable', 'string', 'max:255'],
        'ville'          => ['nullable', 'string', 'max:100'],
        'code_postal'    => ['nullable', 'string', 'max:10'],
        'telephone'      => ['nullable', 'string', 'max:20'],
        'statut'         => ['required', 'string', 'in:adhérent,coach,président'],
        'photo_path'     => ['nullable', 'image', 'max:2048'],
        'date_certificat'=> ['nullable', 'date'],
        'date_cotisation'  => ['nullable', 'date'],    // ← ajouté
    ]);

    // 2) Si une nouvelle photo est uploadée, supprimer l’ancienne (le cas échéant) et stocker la nouvelle
    if ($request->hasFile('photo_path') && $request->file('photo_path')->isValid()) {
        // Supprimer l’ancienne si elle existait
        if ($adherent->photo_path) {
            Storage::disk('public')->delete($adherent->photo_path);
        }

        $chemin = $request->file('photo_path')
                          ->store('adherents_photos', 'public');
        $validated['photo_path'] = $chemin;
    }

    // 3) Mettre à jour l’adhérent en base
    $adherent->update($validated);

    // 4) Rediriger vers la liste ou la fiche, avec message de succès
    return redirect()
        ->route('secretaire.adherents.show', $adherent)
        ->with('success', "Les informations de « {$validated['prenom']} {$validated['nom']} » ont été mises à jour.");
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Adherent $adherent)
{
    // On met simplement est_archive à true
    $adherent->update(['est_archive' => true]);

    // Optionnel : supprimer la photo si vous ne voulez pas garder le fichier
    // if ($adherent->photo_path) {
    //     Storage::disk('public')->delete($adherent->photo_path);
    // }

    // Redirection vers la liste avec message de succès
    return redirect()
        ->route('secretaire.adherents.index')
        ->with('success', "L’adhérent « {$adherent->prenom} {$adherent->nom} » a été archivé.");
}



/**
     * Affiche la liste des adhérents **archivés** (est_archive = true).
     */
    public function archived()
    {
        $archivedAdherents = Adherent::where('est_archive', true)
                                     ->orderBy('nom')
                                     ->orderBy('prenom')
                                     ->get();

        return view('secretaire.adherents.archived', compact('archivedAdherents'));
    }



    /**
     * « Désarchive » un adhérent donné (passer est_archive = false).
     */
    public function restore(Adherent $adherent)
    {
        $adherent->update(['est_archive' => false]);

        return redirect()
            ->route('secretaire.adherents.archived')
            ->with('success', "L adhérent « {$adherent->prenom} {$adherent->nom} » a été désarchivé.");
    }


    /**
 * Affiche les cotisations des adhérents non archivés.
 */
public function cotisations()
{
    $adherents = Adherent::where('est_archive', false)
                         ->orderBy('nom')
                         ->orderBy('prenom')
                         ->get();

    return view('secretaire.adherents.cotisations', compact('adherents'));
}









}