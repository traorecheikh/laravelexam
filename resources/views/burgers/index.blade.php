@extends('layouts.app')

@section('content')
    <div class="container-fluid hero-section">
        <div class="container text-center">
            <h1 class="display-3 fw-bold">🍔 Des Burgers Qui Font Rêver</h1>
            <p class="lead fs-4">Découvrez notre sélection de burgers gourmets préparés avec des ingrédients frais et de
                qualité</p>
            <a href="#catalogue" class="btn btn-primary btn-lg mt-3">Explorer le menu</a>
        </div>
    </div>
    <div class="container">
        <h1>Catalogue des Burgers</h1>
        @can('gerer burgers')
            <a href="{{ route('burgers.create') }}" class="btn btn-primary mb-3">Ajouter Burger</a>
        @endcan

        {{-- Filtres optionnels --}}
        <form method="GET" action="{{ route('catalogue') }}" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <input type="number" name="prix_min" class="form-control" placeholder="Prix Min">
                </div>
                <div class="col-md-3">
                    <input type="number" name="prix_max" class="form-control" placeholder="Prix Max">
                </div>
                <div class="col-md-4">
                    <input type="text" name="libelle" class="form-control" placeholder="Nom du burger">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filtrer</button>
                </div>
            </div>
        </form>

        <div class="row">
            @forelse($burgers as $burger)
                <div class="col-md-4">
                    <div class="card mb-4">
                        @if($burger->image)
                            <img src="{{ asset('storage/' . $burger->image) }}" class="card-img-top"
                                 alt="{{ $burger->nom }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $burger->nom }}</h5>
                            <p class="card-text">{{ Str::limit($burger->description, 100) }}</p>
                            <p class="card-text"><strong>Prix:</strong> {{ number_format($burger->prix, 2) }} €</p>
                            <p class="card-text"><strong>Stock:</strong> {{ $burger->stock }}</p>
                            <a href="{{ route('burger.details', $burger) }}" class="btn btn-info">Voir Détails</a>
                            @can('gerer burgers')
                                <a href="{{ route('burgers.edit', $burger) }}" class="btn btn-warning">Modifier</a>
                                <form action="{{ route('burgers.destroy', $burger) }}" method="POST"
                                      style="display:inline-block;"
                                      onsubmit="return confirm('Confirmez-vous l\'archivage de ce burger ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Archiver</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="alert alert-info">
                        <i class="fas fa-hamburger fa-3x mb-3"></i>
                        <h4>Aucun burger ne correspond à votre recherche</h4>
                        <p>Essayez d'autres critères de recherche ou consultez notre catalogue complet.</p>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {{ $burgers->links() }}
        </div>
    </div>
@endsection
