<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BurgerController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PaiementController;

Route::resource('burgers', BurgerController::class);

Route::group(['middleware' => 'auth'], function () {
    Route::get('catalogue', [BurgerController::class, 'index'])->name('catalogue');
    Route::get('burger/{burger}', [BurgerController::class, 'show'])->name('burger.details');
    Route::post('commande', [CommandeController::class, 'store'])->name('commande.passer');
    Route::get('mes-commandes', [CommandeController::class, 'index'])->name('commande.mes');

    // Panier Routes
    Route::get('/panier', [PanierController::class, 'index'])->name('panier.index');
    Route::post('/panier/ajouter', [PanierController::class, 'ajouter'])->name('panier.ajouter');
    Route::post('/panier/supprimer', [PanierController::class, 'supprimer'])->name('panier.supprimer');
    Route::post('/panier/vider', [PanierController::class, 'vider'])->name('panier.vider');

    // Checkout Routes
    Route::post('/commande/checkout', [PanierController::class, 'checkout'])->name('commande.checkout');
    Route::get('/commande/checkout', [PanierController::class, 'checkout'])->name('commande.checkout.view');

    // Commande Routes
    Route::post('commande', [CommandeController::class, 'store'])->name('commande.passer');

    // Commande Validation Routes
    Route::post('/commande/{commande}/validate', [CommandeController::class, 'validateCommande'])->name('commande.validate');

    Route::post('/commande/{commande}/finalize', [CommandeController::class, 'finalizeCommande'])->name('commande.finalize');

    // Admin Routes (Role-based middleware)
        Route::get('commande/{commande}', [CommandeController::class, 'show'])->name('commande.show');
        Route::get('commandes', [CommandeController::class, 'index'])->name('commande.index');
        Route::put('commande/{commande}/annuler', [CommandeController::class, 'annuler'])->name('commande.annuler');
        Route::put('commande/{commande}/statut', [CommandeController::class, 'updateStatut'])->name('commande.updateStatut');
        Route::post('paiement', [PaiementController::class, 'store'])->name('paiement.enregistrer');
    
});

// Authentication Routes
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');
