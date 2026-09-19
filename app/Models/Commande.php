<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $fillable = [
        'montant_total', 'mode_paiement', 'statut_paiement', 'id_client',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'id_client');
    }

    public function lignes()
    {
        return $this->hasMany(LigneCommande::class, 'id_commande');
    }

    public function suivis()
    {
        return $this->hasMany(SuiviCommande::class, 'id_commande');
    }
}