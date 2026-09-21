<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $fillable = [
        'nom_produit', 'description', 'prix', 'stock', 'photo',
        'id_boutique', 'id_categorie',
    ];

    public function boutique()
    {
        return $this->belongsTo(Boutique::class, 'id_boutique');
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'id_categorie');
    }

    public function avis()
    {
        return $this->hasMany(Avis::class, 'id_produit');
    }
    public function messagesProduits()
    {
        return $this->hasMany(MessageProduit::class, 'id_produit');
    }
}