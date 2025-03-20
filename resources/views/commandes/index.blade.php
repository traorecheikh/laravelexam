@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Liste des Commandes</h1>

        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Total</th>
                <th>Statut</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($commandes as $commande)
                <tr>
                    <td>{{ $commande->id }}</td>
                    <td>{{ $commande->user->name }}</td>
                    <td>{{ $commande->total }} €</td>
                    <td>
                        @php
                            $statusClass = '';
                            $statusText = ucfirst($commande->statut);

                            switch ($commande->statut) {
                                case 'en attente':
                                    $statusClass = 'badge bg-secondary'; // gray
                                    break;
                                case 'en preparation':
                                    $statusClass = 'badge bg-primary'; // blue
                                    break;
                                case 'prete':
                                    $statusClass = 'badge bg-success'; // green
                                    break;
                                case 'payee':
                                    $statusClass = 'badge bg-success'; // green
                                    break;
                                default:
                                    $statusClass = 'badge bg-warning';
                            }
                        @endphp

                        <span class="{{ $statusClass }}">{{ $statusText }}</span>
                    </td>
                    @can('gerer commandes')
                        <td>
                            <a href="{{ route('commande.show', $commande) }}" class="btn btn-primary">Details</a>
                        </td>
                    @endcan
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $commandes->links() }}
    </div>

    @if (session('success'))
        <script>
            toastr.success("{{ session('success') }}");
        </script>
    @endif
@endsection
