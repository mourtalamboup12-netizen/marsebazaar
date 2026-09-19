<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    protected $fillable = ['id_client', 'id_produit', 'note', 'commentaire'];

    public function client()
    {
        return $this->belongsTo(User::class, 'id_client');
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'id_produit');
    }
}