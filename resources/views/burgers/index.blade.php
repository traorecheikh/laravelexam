@extends('layouts.app')

@section('content')
    <link href="{{asset('burger.css')}}" rel="stylesheet">
    <div class="container-fluid hero-section">
        <div class="container text-center">
            <h1 class="display-3 fw-bold">🍔 Des Burgers Qui Font Rêver</h1>
            <p class="lead fs-4">Découvrez notre sélection de burgers gourmets préparés avec des ingrédients frais et de
                qualité</p>
            <a href="#catalogue" class="btn btn-primary btn-lg mt-3">Explorer le menu</a>
        </div>
    </div>
    <div class="container" id="catalogue">
        <h1>Catalogue des Burgers</h1>
        @can('gerer burgers')
            <a href="{{ route('burgers.create') }}" class="btn btn-primary mb-3">
                <i class="fas fa-plus-circle"></i> Ajouter Burger
            </a>
        @endcan

        {{-- Filtres optionnels --}}
        <form method="GET" action="{{ route('catalogue') }}" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <label for="prix_min" class="form-label">Prix minimum</label>
                    <input type="number" id="prix_min" name="prix_min" class="form-control" placeholder="Prix Min"
                           value="{{ request('prix_min') }}">
                </div>
                <div class="col-md-3">
                    <label for="prix_max" class="form-label">Prix maximum</label>
                    <input type="number" id="prix_max" name="prix_max" class="form-control" placeholder="Prix Max"
                           value="{{ request('prix_max') }}">
                </div>
                <div class="col-md-4">
                    <label for="libelle" class="form-label">Nom du burger</label>
                    <input type="text" id="libelle" name="libelle" class="form-control" placeholder="Nom du burger"
                           value="{{ request('libelle') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Filtrer
                    </button>
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
                        @else
                            <img
                                src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80"
                                class="card-img-top" alt="Burger image par défaut">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $burger->nom }}</h5>
                            <p class="card-text">{{ Str::limit($burger->description, 100) }}</p>
                            <p class="card-text"><strong>Prix:</strong> {{ number_format($burger->prix,0,'.','.') }}
                                FCFA
                            </p>

                            @php
                                $stockClass = 'stock-high';
                                if ($burger->stock < 10) {
                                    $stockClass = 'stock-low';
                                } elseif ($burger->stock < 20) {
                                    $stockClass = 'stock-medium';
                                }
                            @endphp

                            <p class="card-text">
                                <strong>Stock:</strong>
                                <span class="{{ $stockClass }}">
                                    {{ $burger->stock }}
                                    @if($burger->stock < 5)
                                        <i class="fas fa-exclamation-circle"></i>
                                    @endif
                                </span>
                            </p>

                            <div class="burger-actions">
                                <a href="{{ route('burger.details', $burger) }}" class="btn btn-view">Details</a>
                                @can('gerer burgers')
                                    <a href="{{ route('burgers.edit', $burger) }}" class="btn btn-edit">Edit</a>
                                    <form action="{{ route('burgers.destroy', $burger) }}" method="POST"
                                          class="delete-form" onsubmit="return confirm('Archive this burger?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-delete">Archive</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="alert alert-info">
                        <i class="fas fa-hamburger fa-3x mb-3"></i>
                        <h4>Aucun burger ne correspond à votre recherche</h4>
                        <p>Essayez d'autres critères de recherche ou consultez notre catalogue complet.</p>
                        <a href="{{ route('catalogue') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-redo"></i> Voir tous les burgers
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {{ $burgers->links() }}
        </div>
    </div>

    @push('scripts')
        <script>
            // Add smooth scrolling
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();

                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });
        </script>
    @endpush
@endsection
