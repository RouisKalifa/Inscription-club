<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adherent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'prenom',
        'nom',
        'date_naissance',
        'adresse',
        'ville',
        'code_postal',
        'telephone',
        'statut',
        'photo_path',
        'date_certificat',
        'est_archive',
        // ← Nos deux nouveaux champs :
        'visible_trombinoscope',
        'visible_annuaire',
        'date_cotisation',
        'consentement_rgpd_at', // ← ajouté
    ];

    protected $casts = [
        'date_naissance'        => 'date',
        'date_certificat'       => 'date',
        'est_archive'           => 'boolean',
        'visible_trombinoscope' => 'boolean',
        'visible_annuaire'      => 'boolean',
        'date_cotisation'  => 'date',   // ← ajouté
        'consentement_rgpd_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}