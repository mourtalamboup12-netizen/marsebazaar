<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageProduit extends Model
{
    protected $table = 'messages_produits';

    protected $fillable = ['id_produit', 'id_client', 'id_expediteur', 'contenu'];

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'id_produit');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'id_client');
    }

    public function expediteur()
    {
        return $this->belongsTo(User::class, 'id_expediteur');
    }
}