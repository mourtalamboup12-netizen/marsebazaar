<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['id_commande', 'id_expediteur', 'contenu'];

    public function commande()
    {
        return $this->belongsTo(Commande::class, 'id_commande');
    }

    public function expediteur()
    {
        return $this->belongsTo(User::class, 'id_expediteur');
    }
} 
