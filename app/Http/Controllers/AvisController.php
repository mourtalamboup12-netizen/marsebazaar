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

        Avis::create([
            'id_client' => auth()->id(),
            'id_produit' => $produit->id,
            'note' => $request->note,
            'commentaire' => $request->commentaire,
        ]);

        return redirect()->route('produits.show', $produit)->with('success', 'Merci pour ton avis !');
    }
}