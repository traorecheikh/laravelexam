<?php

namespace App\Http\Controllers;

use App\Models\Burger;
use App\Models\Commande;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Set today's date boundaries using Carbon
        $todayStart = Carbon::today(); // start of today
        $todayEnd = Carbon::tomorrow(); // start of tomorrow

        // 1. Commandes en cours de la journée: all orders created today
        $commandesEnCours = Commande::whereBetween('created_at', [$todayStart, $todayEnd])->count();

        // 2. Commandes validées de la journée: orders with status 'payée' created today
        $commandesValidees = Commande::where('statut', 'payée')
            ->whereBetween('created_at', [$todayStart, $todayEnd])
            ->count();

        // 3. Recettes journalières: Sum of 'total' from orders with status 'payée' created today
        $recettesJournalières = Commande::where('statut', 'payée')
            ->whereBetween('created_at', [$todayStart, $todayEnd])
            ->sum('total');

        // 4. Nombre de commande par mois:
        // Using SQLite's strftime function to extract the month (as a two-digit string)
        $commandesParMoisData = Commande::select(
            DB::raw('strftime("%m", created_at) as month'),
            DB::raw('count(*) as count')
        )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $commandesParMois = [
            'labels' => $commandesParMoisData->pluck('month'),
            'data' => $commandesParMoisData->pluck('count')
        ];

        // 5. Nombre de Produit par catégorie par mois:
        // This example assumes your Burger model has a 'categorie' column.
        // If not, you can either add that column or return empty data.
        $produitsParCategorieData = Burger::select('categorie', DB::raw('count(*) as count'))
            ->groupBy('categorie')
            ->orderBy('categorie')
            ->get();

        $produitsParCategorie = [
            'labels' => $produitsParCategorieData->pluck('categorie'),
            'data' => $produitsParCategorieData->pluck('count')
        ];

        return view('home', compact(
            'commandesEnCours',
            'commandesValidees',
            'recettesJournalières',
            'commandesParMois',
            'produitsParCategorie'
        ));
    }
}
