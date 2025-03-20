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
        $todayStart = Carbon::today();
        $todayEnd = Carbon::tomorrow();

        $commandesEnCours = Commande::whereBetween('created_at', [$todayStart, $todayEnd])->count();

        $commandesValidees = Commande::where('statut', 'payée')
            ->whereBetween('created_at', [$todayStart, $todayEnd])
            ->count();

        $recettesJournalières = Commande::where('statut', 'payée')
            ->whereBetween('created_at', [$todayStart, $todayEnd])
            ->sum('total');

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
