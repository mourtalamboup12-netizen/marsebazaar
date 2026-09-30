<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\Produit;
use Illuminate\Http\Request;

class AvisController extends Controller
{
    public function store(Request $request, Produit $produit)
    {
        $request->validate([
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string|max:500',
        ]);

        $aAchete = \App\Models\LigneCommande::where('id_produit', $produit->id)
            ->whereHas('commande', function ($query) {
                $query->where('id_client', auth()->id());
            })
            ->exists();

        if (!$aAchete) {
            return redirect()->route('produits.show', $produit)
                ->with('error', 'Tu dois avoir acheté ce produit pour laisser un avis.');
        }

        $dejaLaisse = Avis::where('id_client', auth()->id())
            ->where('id_produit', $produit->id)
            ->exists();

        if ($dejaLaisse) {
            return redirect()->route('produits.show', $produit)
                ->with('error', 'Tu as déjà laissé un avis sur ce produit.');
        }

        Avis::create([
            'id_client' => auth()->id(),
            'id_produit' => $produit->id,
            'note' => $request->note,
            'commentaire' => $request->commentaire,
        ]);

        return redirect()->route('produits.show', $produit)->with('success', 'Merci pour ton avis !');
    }
}