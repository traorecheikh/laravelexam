{{-- resources/views/burgers/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $burger->nom }}</h1>
    @if($burger->image)
        <img src="{{ asset('storage/' . $burger->image) }}" alt="{{ $burger->nom }}" class="img-fluid mb-3">
    @endif
    <p>{{ $burger->description }}</p>
    <p><strong>Prix:</strong> {{ number_format($burger->prix, 2) }} €</p>

    {{-- Formulaire pour passer commande --}}
    <form action="{{ route('panier.ajouter') }}" method="POST">
        @csrf
        <input type="hidden" name="burger_id" value="{{ $burger->id }}">
        <button type="submit" class="btn btn-success">Ajouter au Panier</button>
    </form>

</div>
@endsection
