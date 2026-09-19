<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuiviCommande extends Model
{
    protected $fillable = [
        'id_commande', 'statut',
    ];

    public function commande()
    {
        return $this->belongsTo(Commande::class, 'id_commande');
    }
}