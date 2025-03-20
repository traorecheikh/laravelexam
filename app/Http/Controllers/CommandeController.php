<?php

namespace App\Http\Controllers;

use App\Jobs\CreatePaiement;
use App\Models\Commande;
use App\Notifications\OrderConfirmed;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('gestionnaire')) {
            $commandes = Commande::latest()->paginate(10);
        } else {
            $commandes = Commande::where('user_id', auth()->id())->latest()->paginate(10);
        }

        return view('commandes.index', compact('commandes'));
    }


    public function show(Commande $commande)
    {
        return view('commandes.show', compact('commande'));
    }

    public function update(Request $request, Commande $commande)
    {
        $request->validate([
            'statut' => 'required|in:en attente,en préparation,prête,payée',
        ]);

        $commande->update(['statut' => $request->statut]);

        return redirect()->route('commandes.index')->with('success', 'Statut mis à jour');
    }

    public function validateCommande(Request $request, Commande $commande)
    {

        $commande->statut = 'en preparation';
        $commande->save();


        return redirect()->route('commande.index')->with('success', 'Commande validée et payée.');
    }

    public function finalizeCommande(Request $request, Commande $commande)
    {

        $commande->statut = 'prete';

        $commande->user->notify(new OrderConfirmed($commande));
        CreatePaiement::dispatch($commande)->delay(now()->addMinutes(1));
        $commande->statut = 'payee';
        $commande->save();

        return redirect()->route('commande.index')->with('success', 'Commande validée et payée.');
    }
}
