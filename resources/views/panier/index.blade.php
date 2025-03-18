@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>🛒 Mon Panier</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(count($panier) > 0)
            <table class="table">
                <thead>
                <tr>
                    <th>Burger</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @php $total = 0; @endphp
                @foreach($panier as $id => $item)
                    @php $total += $item['prix'] * $item['quantite']; @endphp
                    <tr>
                        <td>{{ $item['nom'] }}</td>
                        <td>{{ number_format($item['prix']) }} FCFA</td>
                        <td>{{ $item['quantite'] }}</td>
                        <td>{{ number_format($item['prix'] * $item['quantite']) }} FCFA</td>
                        <td>
                            <form action="{{ route('panier.supprimer') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="burger_id" value="{{ $id }}">
                                <button type="submit" class="btn btn-danger btn-sm">🗑 Retirer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <h3>Total: {{ number_format($total) }} FCFA</h3>

            <form action="{{ route('panier.vider') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-warning">Vider le panier</button>
            </form>

            <!-- Checkout Button -->
            @cannot('gerer burgers')
                <form action="{{ route('commande.checkout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success btn-lg">Procéder au Paiement</button>
                </form>
            @endcannot

        @else
            <p>Votre panier est vide.</p>
        @endif
    </div>
@endsection
