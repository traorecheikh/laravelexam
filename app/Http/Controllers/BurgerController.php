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

    public function destroy(Burger $burger)
    {
        $burger->delete();
        return redirect()->route('burgers.index');
    }

    public function edit(Burger $burger)
    {
        return view('burgers.edit', compact('burger'));
    }

    public function update(Request $request, Burger $burger)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            // Optionally, delete the old image here
            $path = $request->file('image')->store('burgers', 'public');
            $validated['image'] = $path;
        }

        $burger->update($validated);

        return redirect()->route('burgers.index')->with('success', 'Burger mis à jour avec succès!');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('burgers', 'public');
            $validated['image'] = $path;
        }

        Burger::create($validated);

        return redirect()->route('burgers.index')->with('success', 'Burger ajouté avec succès!');
    }

    public function create()
    {
        return view('burgers.create');
    }


}
