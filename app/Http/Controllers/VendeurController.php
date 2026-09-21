<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use App\Models\Commande;
use Illuminate\Http\Request;

class VendeurController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'vendeur') {
                abort(403, 'Accès réservé aux vendeurs.');
            }
            return $next($request);
        });
    }

    // Tableau de bord vendeur
    public function dashboard()
    {
        $boutique = auth()->user()->boutique;

        // Si le vendeur n'a pas encore de boutique, on l'invite à en créer une
        if (!$boutique) {
            return view('vendeur.creer-boutique');
        }

        $produits = $boutique->produits;

        $idsProduits = $produits->pluck('id');
        $nbCommandesEnCours = 0;
        $chiffreAffaires = 0;

        foreach ($idsProduits as $idProduit) {
            $lignes = \App\Models\LigneCommande::where('id_produit', $idProduit)->get();
            foreach ($lignes as $ligne) {
                $chiffreAffaires += $ligne->prix_unitaire * $ligne->quantite;
            }
        }

        return view('vendeur.dashboard', [
            'boutique' => $boutique,
            'nbProduits' => $produits->count(),
            'chiffreAffaires' => $chiffreAffaires,
        ]);
    }

    // Créer sa boutique (première connexion vendeur)
    public function creerBoutique(Request $request)
{
    if (auth()->user()->boutique) {
        return redirect()->route('vendeur.dashboard')->with('success', 'Tu as déjà une boutique.');
    }

    $request->validate([
        'nom_boutique' => 'required|string|max:150',
        'description' => 'nullable|string',
    ]);

    Boutique::create([
        'nom_boutique' => $request->nom_boutique,
        'description' => $request->description,
        'id_vendeur' => auth()->id(),
    ]);

    return redirect()->route('vendeur.dashboard')->with('success', 'Boutique créée avec succès ! Elle est en attente de validation par un administrateur.');
}
    // Liste des produits de la boutique
    public function produits()
    {
        $boutique = auth()->user()->boutique;
        $produits = $boutique->produits()->with('categorie')->latest()->get();

        return view('vendeur.produits.index', compact('produits'));
    }

    // Formulaire de création d'un produit
    public function creerProduit()
    {
        $categories = \App\Models\Categorie::all();
        return view('vendeur.produits.creer', compact('categories'));
    }

    // Enregistrer le nouveau produit
    public function storeProduit(Request $request)
    {
        $request->validate([
            'nom_produit' => 'required|string|max:150',
            'description' => 'nullable|string',
            'prix' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'id_categorie' => 'required|exists:categories,id',
        ]);

        \App\Models\Produit::create([
            'nom_produit' => $request->nom_produit,
            'description' => $request->description,
            'prix' => $request->prix,
            'stock' => $request->stock,
            'id_categorie' => $request->id_categorie,
            'id_boutique' => auth()->user()->boutique->id,
        ]);

        return redirect()->route('vendeur.produits')->with('success', 'Produit ajouté avec succès !');
    }

    // Formulaire de modification
    public function editProduit(\App\Models\Produit $produit)
    {
        if ($produit->id_boutique !== auth()->user()->boutique->id) {
            abort(403);
        }

        $categories = \App\Models\Categorie::all();
        return view('vendeur.produits.modifier', compact('produit', 'categories'));
    }

    // Enregistrer la modification
    public function updateProduit(Request $request, \App\Models\Produit $produit)
    {
        if ($produit->id_boutique !== auth()->user()->boutique->id) {
            abort(403);
        }

        $request->validate([
            'nom_produit' => 'required|string|max:150',
            'description' => 'nullable|string',
            'prix' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'id_categorie' => 'required|exists:categories,id',
        ]);

        $produit->update($request->only(['nom_produit', 'description', 'prix', 'stock', 'id_categorie']));

        return redirect()->route('vendeur.produits')->with('success', 'Produit mis à jour.');
    }

    // Supprimer un produit
    public function destroyProduit(\App\Models\Produit $produit)
    {
        if ($produit->id_boutique !== auth()->user()->boutique->id) {
            abort(403);
        }

        $produit->delete();

        return redirect()->route('vendeur.produits')->with('success', 'Produit supprimé.');
    }
    // Liste des commandes contenant au moins un produit de la boutique
    public function commandes()
    {
        $boutique = auth()->user()->boutique;
        $idsProduits = $boutique->produits()->pluck('id');

        $idsCommandes = \App\Models\LigneCommande::whereIn('id_produit', $idsProduits)
            ->pluck('id_commande')
            ->unique();

        $commandes = \App\Models\Commande::whereIn('id', $idsCommandes)
            ->with(['client', 'suivis', 'lignes.produit'])
            ->latest()
            ->get();

        $etapes = ['confirmee', 'en_preparation', 'expediee', 'en_livraison', 'livree'];

        return view('vendeur.commandes.index', compact('commandes', 'etapes'));
    }

    public function commandeDetail(\App\Models\Commande $commande)
    {
       $boutique = auth()->user()->boutique;
       $idsProduits = $boutique->produits()->pluck('id');

       $appartientALaBoutique = $commande->lignes()->whereIn('id_produit', $idsProduits)->exists();
       if (!$appartientALaBoutique) {
          abort(403);
       }

        $commande->load('client', 'suivis', 'lignes.produit', 'messages');
        $etapes = ['confirmee', 'en_preparation', 'expediee', 'en_livraison', 'livree'];

        return view('vendeur.commandes.show', compact('commande', 'etapes'));
    }

    // Fait avancer le statut ColisPlus d'une commande
    public function majStatut(Request $request, \App\Models\Commande $commande)
    {
        $request->validate([
            'statut' => 'required|in:confirmee,en_preparation,expediee,en_livraison,livree',
        ]);

        // Sécurité : vérifier que la commande contient bien un produit de ce vendeur
        $boutique = auth()->user()->boutique;
        $idsProduits = $boutique->produits()->pluck('id');
        $contientProduitVendeur = $commande->lignes()->whereIn('id_produit', $idsProduits)->exists();

        if (!$contientProduitVendeur) {
            abort(403);
        }

        \App\Models\SuiviCommande::create([
            'id_commande' => $commande->id,
            'statut' => $request->statut,
        ]);

        return redirect()->route('vendeur.commandes')->with('success', 'Statut mis à jour.');
    }
    // ... tes méthodes existantes (dashboard, produits, commandes, etc.) ...

    public function questions()
    {
        $boutique = auth()->user()->boutique;
        $idsProduits = $boutique->produits()->pluck('id');

        $fils = \App\Models\MessageProduit::whereIn('id_produit', $idsProduits)
            ->with('produit', 'client')
            ->latest()
            ->get()
            ->unique(fn($m) => $m->id_produit . '-' . $m->id_client);

        return view('vendeur.questions.index', compact('fils'));
    }

    public function questionDetail(\App\Models\Produit $produit, \App\Models\User $client)
    {
        $boutique = auth()->user()->boutique;
        if ($produit->id_boutique !== $boutique->id) {
            abort(403);
        }

        $messages = \App\Models\MessageProduit::where('id_produit', $produit->id)
            ->where('id_client', $client->id)
            ->with('expediteur')
            ->oldest()
            ->get();

        return view('vendeur.questions.show', compact('produit', 'client', 'messages'));
    }

} // <-- cette accolade ferme la classe VendeurController, ne pas la dupliquer
