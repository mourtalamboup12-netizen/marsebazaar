<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Categorie;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    // Affiche le catalogue (liste des produits)
    public function index(Request $request)
    {
        $query = Produit::with(['boutique', 'categorie'])
    ->whereHas('boutique', function ($q) {
        $q->where('valide', true);
    });

        // Recherche par nom
        if ($request->filled('recherche')) {
            $query->where('nom_produit', 'like', '%' . $request->recherche . '%');
        }

        // Filtre par catégorie
        if ($request->filled('categorie')) {
            $query->where('id_categorie', $request->categorie);
        }

        $produits = $query->latest()->paginate(12);
        $categories = Categorie::all();

        return view('produits.index', compact('produits', 'categories'));
    }

    // Affiche le détail d'un produit
   public function show(Produit $produit)
{
    if (!$produit->boutique->valide) {
        abort(404);
    }

    $produit->load(['boutique', 'categorie', 'avis.client']);

    return view('produits.show', compact('produit'));
}
}