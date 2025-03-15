{{-- resources/views/burgers/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Catalogue des Burgers</h1>
    @can('gerer burgers')
    <a href="{{ route('burgers.create') }}" class="btn btn-primary">Ajouter Burger</a>
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
        @foreach($burgers as $burger)
            <div class="col-md-4">
                <div class="card mb-4">
                    @if($burger->image)
                        <img src="{{ asset('storage/' . $burger->image) }}" class="card-img-top" alt="{{ $burger->nom }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $burger->nom }}</h5>
                        <p class="card-text">{{ Str::limit($burger->description, 100) }}</p>
                        <p class="card-text"><strong>Prix:</strong> {{ number_format($burger->prix, 2) }} €</p>
                        <a href="{{ route('burger.details', $burger) }}" class="btn btn-primary">Voir Détails</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Pagination si nécessaire --}}
    <div class="d-flex justify-content-center">
        {{ $burgers->links() }}
    </div>
</div>
@endsection
