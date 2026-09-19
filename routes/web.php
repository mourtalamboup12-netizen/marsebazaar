<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\VendeurController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\http\controllers\AvisController;

Route::get('/', function () {
    return redirect()->route('produits.index');
});

// Routes publiques du catalogue (accessibles sans connexion)
Route::get('/panier', [PanierController::class, 'index'])->name('panier.index');
Route::post('/panier/ajouter/{produit}', [PanierController::class, 'ajouter'])->name('panier.ajouter');
Route::post('/panier/supprimer/{produit}', [PanierController::class, 'supprimer'])->name('panier.supprimer');

Route::get('/produits', [ProduitController::class, 'index'])->name('produits.index');
Route::get('/produits/{produit}', [ProduitController::class, 'show'])->name('produits.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::post('/produits/{produit}/avis', [AvisController::class, 'store'])->name('avis.store');
    Route::get('/commande/checkout', [CommandeController::class, 'checkout'])->name('commande.checkout');
    Route::post('/commande/valider', [CommandeController::class, 'valider'])->name('commande.valider');
    Route::get('/commande/{commande}/confirmation', [CommandeController::class, 'confirmation'])->name('commande.confirmation');
    Route::get('/mes-commandes', [CommandeController::class, 'historique'])->name('commande.historique');
    Route::get('/commande/{commande}/suivi', [CommandeController::class, 'suivi'])->name('commande.suivi');

    Route::prefix('vendeur')->group(function () {
        Route::get('/dashboard', [VendeurController::class, 'dashboard'])->name('vendeur.dashboard');
        Route::post('/boutique', [VendeurController::class, 'creerBoutique'])->name('vendeur.boutique.creer');

        Route::get('/produits', [VendeurController::class, 'produits'])->name('vendeur.produits');
        Route::get('/produits/creer', [VendeurController::class, 'creerProduit'])->name('vendeur.produits.creer');
        Route::post('/produits', [VendeurController::class, 'storeProduit'])->name('vendeur.produits.store');
        Route::get('/produits/{produit}/modifier', [VendeurController::class, 'editProduit'])->name('vendeur.produits.edit');
        Route::put('/produits/{produit}', [VendeurController::class, 'updateProduit'])->name('vendeur.produits.update');
        Route::delete('/produits/{produit}', [VendeurController::class, 'destroyProduit'])->name('vendeur.produits.destroy');

        Route::get('/commandes', [VendeurController::class, 'commandes'])->name('vendeur.commandes');
        Route::post('/commandes/{commande}/statut', [VendeurController::class, 'majStatut'])->name('vendeur.commandes.statut');
    });

    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/boutiques', [AdminController::class, 'boutiquesEnAttente'])->name('admin.boutiques');
        Route::post('/boutiques/{boutique}/valider', [AdminController::class, 'validerBoutique'])->name('admin.boutiques.valider');
        Route::delete('/boutiques/{boutique}/refuser', [AdminController::class, 'refuserBoutique'])->name('admin.boutiques.refuser');
    });

});

require __DIR__.'/auth.php';