<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boutique extends Model
{
    protected $fillable = ['nom_boutique', 'description', 'logo', 'id_vendeur','valide'];

    public function vendeur()
    {
        return $this->belongsTo(User::class, 'id_vendeur');
    }

    public function produits()
    {
        return $this->hasMany(Produit::class, 'id_boutique');
    }
}