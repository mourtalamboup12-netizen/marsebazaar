<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request, Commande $commande)
    {
        $request->validate([
            'contenu' => 'required|string|max:1000',
        ]);

        $user = auth()->user();
        $estLeClient = $commande->id_client === $user->id;

        $estLeVendeur = false;
        if ($user->role === 'vendeur' && $user->boutique) {
            $idsProduitsBoutique = $user->boutique->produits()->pluck('id');
            $estLeVendeur = $commande->lignes()->whereIn('id_produit', $idsProduitsBoutique)->exists();
        }

        if (!$estLeClient && !$estLeVendeur) {
            abort(403);
        }

        Message::create([
            'id_commande' => $commande->id,
            'id_expediteur' => $user->id,
            'contenu' => $request->contenu,
        ]);

        return back()->with('success', 'Message envoyé.');
    }
} 
