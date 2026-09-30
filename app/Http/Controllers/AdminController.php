<?php

namespace App\Http\Controllers;

use App\Models\Boutique;
use App\Models\Commande;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'Accès réservé aux administrateurs.');
            }
            return $next($request);
        });
    }

    // Tableau de bord admin : statistiques globales
    public function dashboard()
    {
        $nbUtilisateurs = User::count();
        $nbBoutiquesActives = Boutique::where('valide', true)->count();
        $nbCommandesTotales = Commande::count();
        $nbVendeursEnAttente = Boutique::where('valide', false)->count();

        return view('admin.dashboard', compact(
            'nbUtilisateurs', 'nbBoutiquesActives', 'nbCommandesTotales', 'nbVendeursEnAttente'
        ));
    }

    // Liste de toutes les boutiques (gestion/modération)
public function boutiquesEnAttente()
{
    $boutiques = Boutique::with('vendeur')->latest()->get();
    return view('admin.boutiques', compact('boutiques'));
}
    

    // Valider une boutique
    public function validerBoutique(Boutique $boutique)
    {
        $boutique->update(['valide' => true]);
        return redirect()->route('admin.boutiques')->with('success', 'Boutique validée.');
    }

    public function desactiverBoutique(\App\Models\Boutique $boutique)
{
    $boutique->update(['valide' => false]);
    return back()->with('success', 'Boutique désactivée.');
}

public function activerBoutique(\App\Models\Boutique $boutique)
{
    $boutique->update(['valide' => true]);
    return back()->with('success', 'Boutique réactivée.');
}

    // Refuser (supprimer) une boutique
    public function refuserBoutique(Boutique $boutique)
    {
        $boutique->delete();
        return redirect()->route('admin.boutiques')->with('success', 'Boutique refusée et supprimée.');
    }
}