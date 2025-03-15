<?php

namespace App\Http\Controllers;

use App\Models\Burger;
use Illuminate\Http\Request;

class BurgerController extends Controller
{
    // Affiche le catalogue avec filtres optionnels
    public function index(Request $request)
    {
        $query = Burger::query();

        if ($request->has('prix_min') && is_numeric($request->prix_min)) {
            $query->where('prix', '>=', $request->prix_min);
        }
        if ($request->has('prix_max') && is_numeric($request->prix_max)) {
            $query->where('prix', '<=', $request->prix_max);
        }
        if ($request->has('libelle') && !empty($request->libelle)) {
            $query->where('nom', 'like', '%' . $request->libelle . '%');
        }

        $burgers = $query->paginate(9);
        return view('burgers.index', compact('burgers'));
    }

    // Affiche le détail d'un burger
    public function show(Burger $burger)
    {
        return view('burgers.show', compact('burger'));
    }
}
