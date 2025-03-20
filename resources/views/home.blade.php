@extends('layouts.app')

@section('content')
    <link href="{{asset('home.css')}}" rel="stylesheet">
    <div class="container fade-in">

        @can('gerer burgers')
            <div class="manager-dashboard">
                <h1>Bienvenue, Gestionnaire</h1>
                <p class="lead">Comment allez-vous aujourd'hui? Voici votre tableau de bord.</p>

                <h3>Statistiques et Rapports</h3>
                <div class="stats-container">
                    <div class="stat-card">
                        <strong>Commandes en cours</strong>
                        <span>{{ $commandesEnCours }}</span>
                    </div>
                    <div class="stat-card">
                        <strong>Commandes validées</strong>
                        <span>{{ $commandesValidees }}</span>
                    </div>
                    <div class="stat-card">
                        <strong>Recettes journalières</strong>
                        <span>{{ number_format($recettesJournalières) }} CFA</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="chart-container">
                            <h4>Commandes mensuelles</h4>
                            <canvas id="chartCommandesMois"></canvas>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="chart-container">
                            <h4>Produits par catégorie</h4>
                            <canvas id="chartProduitsCategorie"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="jumbotron text-center my-4">
                <h1>Bienvenue chez ISI BURGER</h1>
                <p class="lead">Le meilleur burger de la ville vous attend!</p>
            </div>

            <div class="about-section hover-scale">
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
            </div>

            <div class="specialties-section hover-scale">
                <h3>Nos Spécialités</h3>
                <p>
                    Découvrez notre menu varié comprenant des burgers classiques, des burgers gourmet et des
                    options végétariennes. Chaque burger est accompagné de frites croustillantes et d'une
                    sélection de sauces maison pour une expérience culinaire unique.
                </p>
            </div>

            <div class="info-section">
                <h3>Informations Pratiques</h3>
                <p>
                    <strong>Adresse :</strong> 123 Rue des Saveurs, 75000 Paris<br>
                    <strong>Téléphone :</strong> 01 23 45 67 89<br>
                    <strong>Horaires :</strong> Du lundi au dimanche : 11h00 - 23h00
                </p>
            </div>

            <div class="cta-section">
                <h3>Prêt à déguster nos burgers?</h3>
                <p>Venez nous rendre visite ou commandez en ligne dès aujourd'hui!</p>
                <button class="btn btn-cta">Commander maintenant</button>
            </div>
        @endcan
    </div>
@endsection

@push('scripts')
    <!-- Include Chart.js from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Include AOS library for scroll animations -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize AOS
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true
            });

            // Chart for the number of commandes per month (bar chart)
            const ctxCommandes = document.getElementById('chartCommandesMois').getContext('2d');
            const commandesChart = new Chart(ctxCommandes, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($commandesParMois['labels'] ?? []) !!},
                    datasets: [{
                        label: 'Nombre de commandes',
                        data: {!! json_encode($commandesParMois['data'] ?? []) !!},
                        backgroundColor: 'rgba(230, 57, 70, 0.7)',
                        borderColor: 'rgba(230, 57, 70, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                font: {
                                    family: 'Poppins',
                                    size: 14
                                }
                            }
                        }
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeOutQuart'
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
                            'rgba(230, 57, 70, 0.7)',
                            'rgba(69, 123, 157, 0.7)',
                            'rgba(29, 53, 87, 0.7)',
                            'rgba(241, 250, 238, 0.7)'
                        ],
                        borderColor: [
                            'rgba(230, 57, 70, 1)',
                            'rgba(69, 123, 157, 1)',
                            'rgba(29, 53, 87, 1)',
                            'rgba(241, 250, 238, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                font: {
                                    family: 'Poppins',
                                    size: 14
                                },
                                padding: 20
                            }
                        }
                    },
                    animation: {
                        animateScale: true,
                        animateRotate: true,
                        duration: 2000,
                        easing: 'easeOutBounce'
                    }
                }
            });
        });
    </script>
@endpush
