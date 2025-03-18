<?php

namespace App\Http\Controllers;

use App\Models\Burger;
use App\Models\Commande;
use Illuminate\Http\Request;

class PanierController extends Controller
{
    // Afficher le panier
    public function index()
    {
        $panier = session('panier', []);
        return view('panier.index', compact('panier'));
    }

    // Checkout process
    public function checkout()
    {
        $panier = session('panier');

        if (!$panier) {
            return redirect()->route('burgers.index')->with('error', 'Votre panier est vide.');
        }
        // dd($panier);
        // Create a new order (Commande)
        $commande = Commande::create([
            'user_id' => auth()->id(),
            'total' => $this->calculateTotal($panier),
            'statut' => 'en attente',
        ]);

        // Attach the items from the panier to the commande
        foreach ($panier as $burgerId => $burgerDetails) {
            $burger = Burger::find($burgerId);

            // Attach the burger with quantity from the panier
            $commande->burgers()->attach($burger->id, ['quantite' => $burgerDetails['quantite']]);
        }

        // Clear the panier session after the order is created
        session()->forget('panier');

        return redirect()->route('commande.checkout.view')->with('success', 'Votre commande a été passée.');
    }


    private function calculateTotal($panier)
    {
        $total = 0;
        foreach ($panier as $burgerId => $quantity) {
            $burger = Burger::find($burgerId);
            $total += $burger->prix * $quantity['quantite'];

        }
        return $total;
    }

    // Ajouter un burger au panier
    public function ajouter(Request $request)
    {
        $request->validate([
            'burger_id' => 'required|exists:burgers,id',
            'quantite' => 'required|integer|min:1'
        ]);

        $burger = Burger::findOrFail($request->burger_id);

        $panier = session()->get('panier', []);

        // If burger already exists, update quantity, otherwise add it
        if (isset($panier[$burger->id])) {
            $panier[$burger->id]['quantite'] += $request->quantite;
        } else {
            $panier[$burger->id] = [
                "nom" => $burger->nom,
                "prix" => $burger->prix,
                "quantite" => $request->quantite
            ];
        }

        session()->put('panier', $panier);
        return redirect()->route('panier.index')->with('success', 'Burger ajouté au panier !');
    }


    // Supprimer un burger du panier
    public function supprimer(Request $request)
    {
        $panier = session()->get('panier', []);
        unset($panier[$request->burger_id]);
        session()->put('panier', $panier);

        return redirect()->route('panier.index')->with('success', 'Burger retiré du panier.');
    }

    // Vider tout le panier
    public function vider()
    {
        session()->forget('panier');
        return redirect()->route('panier.index')->with('success', 'Panier vidé.');
    }
}
