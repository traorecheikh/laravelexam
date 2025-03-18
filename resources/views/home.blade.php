@extends('layouts.app')

@section('content')
    <div class="container">


        @can('gerer burgers')
            <h1>Bienvenue, Gestionnaire Comment aller vous ?</h1>
            <h3>Statistiques et Rapports</h3>
            <ul>
                <li>
                    <strong>Commandes en cours de la journée :</strong> {{ $commandesEnCours }}
                </li>
                <li>
                    <strong>Commandes validées de la journée :</strong> {{ $commandesValidees }}
                </li>
                <li>
                    <strong>Recettes journalières :</strong> {{ number_format($recettesJournalières) }} CFA
                </li>
            </ul>

            <div class="row">
                <div class="col-md-6">
                    <canvas id="chartCommandesMois"></canvas>
                </div>
                <div class="col-md-6">
                    <canvas id="chartProduitsCategorie"></canvas>
                </div>
            </div>
        @else
            <div class="container">
                <div class="jumbotron text-center my-4">
                    <h1>Bienvenue chez ISI BURGER</h1>
                    <p class="lead">Le meilleur burger de la ville vous attend!</p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h2>À propos de ISI BURGER</h2>
                        <p>
                            ISI BURGER est un restaurant moderne et convivial dédié à offrir à ses clients des produits
                            frais et de qualité. Notre passion est de créer des burgers savoureux qui allient tradition
                            et innovation pour satisfaire tous les palais.
                        </p>
                        <h3>Nos Engagements</h3>
                        <ul>
                            <li>Ingrédients frais et locaux</li>
                            <li>Préparation artisanale de chaque burger</li>
                            <li>Service rapide et chaleureux</li>
                            <li>Environnement agréable et familial</li>
                        </ul>
                        <h3>Nos Spécialités</h3>
                        <p>
                            Découvrez notre menu varié comprenant des burgers classiques, des burgers gourmet et des
                            options végétariennes. Chaque burger est accompagné de frites croustillantes et d'une
                            sélection de sauces maison pour une expérience culinaire unique.
                        </p>
                        <h3>Informations Pratiques</h3>
                        <p>
                            <strong>Adresse :</strong> 123 Rue des Saveurs, 75000 Paris<br>
                            <strong>Téléphone :</strong> 01 23 45 67 89<br>
                            <strong>Horaires :</strong> Du lundi au dimanche : 11h00 - 23h00
                        </p>
                        <p>
                            Nous vous remercions de votre confiance et espérons vous accueillir très bientôt pour une
                            expérience gustative inoubliable!
                        </p>
                    </div>
                </div>
            </div>
        @endcan
    </div>
@endsection

@push('scripts')
    <!-- Include Chart.js from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Chart for the number of commandes per month (bar chart)
            const ctxCommandes = document.getElementById('chartCommandesMois').getContext('2d');
            const commandesChart = new Chart(ctxCommandes, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($commandesParMois['labels'] ?? []) !!},
                    datasets: [{
                        label: 'Nombre de commandes',
                        data: {!! json_encode($commandesParMois['data'] ?? []) !!},
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Chart for the number of produits per categorie (pie chart)
            const ctxProduits = document.getElementById('chartProduitsCategorie').getContext('2d');
            const produitsChart = new Chart(ctxProduits, {
                type: 'pie',
                data: {
                    labels: {!! json_encode($produitsParCategorie['labels'] ?? []) !!},
                    datasets: [{
                        label: 'Produits par catégorie',
                        data: {!! json_encode($produitsParCategorie['data'] ?? []) !!},
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                }
            });
        });
    </script>
@endpush
