<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\LigneCommande;
use App\Models\Produit;
use App\Models\SuiviCommande;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    // Affiche la page de choix du mode de paiement
    public function checkout()
    {
        $panier = session('panier', []);

        if (empty($panier)) {
            return redirect()->route('panier.index');
        }

        $produits = [];
        $total = 0;

        foreach ($panier as $id => $quantite) {
            $produit = Produit::find($id);
            if ($produit) {
                $sousTotal = $produit->prix * $quantite;
                $total += $sousTotal;
                $produits[] = ['produit' => $produit, 'quantite' => $quantite, 'sous_total' => $sousTotal];
            }
        }

        return view('commande.checkout', compact('produits', 'total'));
    }

    // Valide la commande : vérifie le stock, crée Commande + LigneCommande + premier SuiviCommande, décrémente le stock
    public function valider(Request $request)
    {
        $request->validate([
            'mode_paiement' => 'required|in:wave,orange_money,livraison',
            'telephone' => 'required|string|min:9|max:20',
        ]);

        $panier = session('panier', []);

        if (empty($panier)) {
            return redirect()->route('panier.index');
        }

        $total = 0;
        $lignes = [];

        // Étape 1 : vérifier le stock AVANT de créer quoi que ce soit
        foreach ($panier as $id => $quantite) {
            $produit = Produit::find($id);

            if (!$produit) {
                continue;
            }

            if ($produit->stock < $quantite) {
                return redirect()->route('panier.index')
                    ->with('error', "Stock insuffisant pour \"{$produit->nom_produit}\" (disponible : {$produit->stock}).");
            }

            $sousTotal = $produit->prix * $quantite;
            $total += $sousTotal;
            $lignes[] = [
                'produit' => $produit,
                'quantite' => $quantite,
                'prix_unitaire' => $produit->prix,
            ];
        }

        $statutPaiement = $request->mode_paiement === 'livraison' ? 'regle_a_la_livraison' : 'en_attente';

        $commande = Commande::create([
            'montant_total' => $total,
            'mode_paiement' => $request->mode_paiement,
            'telephone' => $request->telephone,
            'statut_paiement' => $statutPaiement,
            'id_client' => auth()->id(),
        ]);

        foreach ($lignes as $ligne) {
            LigneCommande::create([
                'id_commande' => $commande->id,
                'id_produit' => $ligne['produit']->id,
                'quantite' => $ligne['quantite'],
                'prix_unitaire' => $ligne['prix_unitaire'],
            ]);

            // Étape 2 : décrémenter le stock après création de la ligne
            $ligne['produit']->decrement('stock', $ligne['quantite']);
        }

        SuiviCommande::create([
            'id_commande' => $commande->id,
            'statut' => 'confirmee',
        ]);

        session()->forget('panier');

        return redirect()->route('commande.confirmation', $commande)->with('success', 'Commande passée avec succès !');
    }

    // Page de confirmation après commande
    public function confirmation(Commande $commande)
    {
        return view('commande.confirmation', compact('commande'));
    }

    // Liste des commandes du client connecté
    public function historique()
    {
        $commandes = Commande::where('id_client', auth()->id())
            ->with('suivis')
            ->latest()
            ->get();

        return view('commande.historique', compact('commandes'));
    }

    // Page de suivi ColisPlus d'une commande précise
    public function suivi(Commande $commande)
    {
        // Sécurité : un client ne peut voir que ses propres commandes
        if ($commande->id_client !== auth()->id()) {
            abort(403);
        }

        $commande->load('suivis', 'lignes.produit');

        $etapes = ['confirmee', 'en_preparation', 'expediee', 'en_livraison', 'livree'];
        $statutActuel = $commande->suivis->last()->statut ?? 'confirmee';
        $indexActuel = array_search($statutActuel, $etapes);

        return view('commande.suivi', compact('commande', 'etapes', 'indexActuel'));
    }
}