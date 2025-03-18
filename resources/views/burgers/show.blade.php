@extends('layouts.app')

@section('content')
    @stack('styles')
    <div class="container my-5">
        <div class="row">
            <!-- Image Section -->
            <div class="col-md-6 mb-4 mb-md-0">
                @if($burger->image)
                    <img src="{{ asset('storage/' . $burger->image) }}" alt="{{ $burger->nom }}"
                         class="img-fluid rounded shadow">
                @endif
            </div>
            <!-- Details Section -->
            <div class="col-md-6">
                <h1 class="mb-3">{{ $burger->nom }}</h1>
                <p class="lead">{{ $burger->description }}</p>
                <p class="h4 text-primary">
                    <strong>Prix :</strong> {{ number_format($burger->prix, 2) }} €
                </p>
                <!-- Quantity Selection and Form -->
                @cannot('gerer burgers')
                    <div class="mt-4">
                        <form action="{{ route('panier.ajouter') }}" method="POST">
                            @csrf
                            <input type="hidden" name="burger_id" value="{{ $burger->id }}">

                            <div class="d-flex align-items-center mb-3">
                                <button type="button" class="btn btn-outline-secondary" id="decrease">-</button>
                                <input type="number" name="quantite" id="quantite" value="1" min="1"
                                       class="form-control text-center mx-2" style="width: 80px;">
                                <button type="button" class="btn btn-outline-secondary" id="increase">+</button>
                            </div>

                            <button type="submit" class="btn btn-success btn-lg w-100">Ajouter au Panier</button>
                        </form>
                    </div>
                @endcannot
            </div>
        </div>
        @stack('scripts')
    </div>

    @push('scripts')
        <script>
            document.addEventListener('click', function (event) {
                if (event.target.id === 'increase') {
                    let input = document.getElementById('quantite');
                    input.value = parseInt(input.value) + 1;
                } else if (event.target.id === 'decrease') {
                    let input = document.getElementById('quantite');
                    let currentValue = parseInt(input.value);
                    if (currentValue > 1) {
                        input.value = currentValue - 1;
                    }
                }
            });

        </script>
    @endpush
@endsection
