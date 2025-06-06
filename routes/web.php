<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route publique (page d'accueil)
Route::get('/', function () {
    return view('welcome');
});

// Route “Dashboard” accessible uniquement aux utilisateurs authentifiés ET vérifiés
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes pour la gestion du profil de l'utilisateur (auth required)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ---------------------------------------------------------------------------
//  Routes réservées aux secrétaires
//  (nécessite d’avoir créé le middleware VerifierSecretaire
//   et l’alias “secretaire” dans bootstrap/app.php)
// ---------------------------------------------------------------------------
Route::middleware(['auth', 'secretaire'])
     ->prefix('secretaire')
     ->name('secretaire.')
     ->group(function () {
         // 1) Dashboard Secrétaire
         Route::get('/dashboard', [\App\Http\Controllers\SecretaireController::class, 'dashboard'])
              ->name('dashboard');

         // 2) Liste des adhérents archivés (on place cette route AVANT la resource)
         Route::get('adherents/archives', [\App\Http\Controllers\AdherentController::class, 'archived'])
              ->name('adherents.archived');

         // 3) Désarchiver un adhérent (POST)
         Route::post('adherents/{adherent}/restore', [\App\Http\Controllers\AdherentController::class, 'restore'])
              ->name('adherents.restore');

         // 4) CRUD complet pour les adhérents (index, create, store, show, edit, update, destroy)
         Route::resource('adherents', \App\Http\Controllers\AdherentController::class);
     });

// ---------------------------------------------------------------------------
//  Routes réservées aux nageurs
//  (optionnel : seulement si vous avez créé le middleware VerifierNageur
//   et l’alias “nageur” dans bootstrap/app.php)
// ---------------------------------------------------------------------------
Route::middleware(['auth', 'nageur'])
     ->prefix('nageur')
     ->name('nageur.')
     ->group(function () {
         Route::get('/espace', [\App\Http\Controllers\NageurController::class, 'espace'])
              ->name('espace');

         // On va rajouter :
         // 1) Profil (affichage + traitement du POST)
         // 2) Trombinoscope
         // 3) Annuaire

         Route::get('/profil', [\App\Http\Controllers\NageurController::class, 'profil'])
              ->name('profil');

         Route::put('/profil', [\App\Http\Controllers\NageurController::class, 'updateProfil'])
              ->name('profil.update');

         Route::get('/trombinoscope', [\App\Http\Controllers\NageurController::class, 'trombinoscope'])
              ->name('trombinoscope');

         Route::get('/annuaire', [\App\Http\Controllers\NageurController::class, 'annuaire'])
              ->name('annuaire');
     });


require __DIR__.'/auth.php';
