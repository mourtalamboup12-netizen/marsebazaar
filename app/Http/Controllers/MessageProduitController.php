<?php

namespace App\Http\Controllers;

use App\Models\MessageProduit;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Http\Request;

class MessageProduitController extends Controller
{
    // Le client pose une question sur un produit
    public function store(Request $request, Produit $produit)
    {
        $request->validate([
            'contenu' => 'required|string|max:1000',
        ]);

        MessageProduit::create([
            'id_produit' => $produit->id,
            'id_client' => auth()->id(),
            'id_expediteur' => auth()->id(),
            'contenu' => $request->contenu,
        ]);

        return back()->with('success', 'Question envoyée au vendeur.');
    }

    // Le vendeur répond à un client précis sur un produit précis
    public function repondre(Request $request, Produit $produit, User $client)
    {
        $request->validate([
            'contenu' => 'required|string|max:1000',
        ]);

        $vendeur = auth()->user();
        if (!$vendeur->boutique || $produit->id_boutique !== $vendeur->boutique->id) {
            abort(403);
        }

        MessageProduit::create([
            'id_produit' => $produit->id,
            'id_client' => $client->id,
            'id_expediteur' => $vendeur->id,
            'contenu' => $request->contenu,
        ]);

        return back()->with('success', 'Réponse envoyée.');
    }
} 
