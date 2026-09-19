<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;

class PanierController extends Controller
{
    // Affiche le contenu du panier
    public function index()
    {
        $panier = session('panier', []);
        $produits = [];
        $total = 0;

        foreach ($panier as $id => $quantite) {
            $produit = Produit::with('boutique')->find($id);
            if ($produit) {
                $sousTotal = $produit->prix * $quantite;
                $total += $sousTotal;
                $produits[] = [
                    'produit' => $produit,
                    'quantite' => $quantite,
                    'sous_total' => $sousTotal,
                ];
            }
        }

        return view('panier.index', compact('produits', 'total'));
    }

    // Ajoute un produit au panier
    public function ajouter(Request $request, Produit $produit)
    {
        $panier = session('panier', []);
        $quantite = $request->input('quantite', 1);

        if (isset($panier[$produit->id])) {
            $panier[$produit->id] += $quantite;
        } else {
            $panier[$produit->id] = $quantite;
        }

        session(['panier' => $panier]);

        return redirect()->route('panier.index')->with('success', 'Produit ajouté au panier.');
    }

    // Retire un produit du panier
    public function supprimer(Produit $produit)
    {
        $panier = session('panier', []);
        unset($panier[$produit->id]);
        session(['panier' => $panier]);

        return redirect()->route('panier.index')->with('success', 'Produit retiré du panier.');
    }
}