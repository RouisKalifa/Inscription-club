<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SecretaireController extends Controller
{
    /**
     * Affiche le tableau de bord pour le secrétaire.
     */
    public function dashboard()
    {
        return view('secretaire.dashboard');
    }
}
