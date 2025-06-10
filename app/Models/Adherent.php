<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adherent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'prenom', 'nom', 'date_naissance', 'adresse', 'ville',
        'code_postal', 'telephone', 'statut', 'photo_path', 'date_certificat',
        'est_archive', 'visible_trombinoscope', 'visible_annuaire',
        'date_cotisation', 'consentement_rgpd_at',
    ];

    protected $casts = [
        'prenom'               => 'encrypted',
        'nom'                  => 'encrypted',
        'date_naissance'       => 'encrypted',
        'adresse'              => 'encrypted',
        'ville'                => 'encrypted',
        'code_postal'          => 'encrypted',
        'telephone'            => 'encrypted',
        'statut'               => 'encrypted',
        'photo_path'           => 'encrypted',
        'date_certificat'      => 'encrypted',
        'date_cotisation'      => 'encrypted',
        'est_archive'          => 'encrypted:boolean',
        'visible_trombinoscope'=> 'encrypted:boolean',
        'visible_annuaire'     => 'encrypted:boolean',
        'consentement_rgpd_at' => 'encrypted',
        'user_id'              => 'integer',
        'created_at'           => 'datetime',
        'updated_at'           => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
