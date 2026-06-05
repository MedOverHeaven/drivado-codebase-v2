@extends('layouts.main')
@push('styles')
<style>
    .navbar {
        background: var(--primary-black) !important;
    }
</style>
@endpush
@section('content')
<div class="pt-5 mt-5">
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small text-uppercase fw-bold letter-spacing-1">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-secondary">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/search') }}" class="text-decoration-none text-secondary">Flotte</a></li>
                <li class="breadcrumb-item active text-dark">{{ $vehicle->make }} {{ $vehicle->model }}</li>
            </ol>
        </nav>

        <div class="row g-5 mt-2">
            <!-- Left: Vehicle Gallery & Specs -->
            <div class="col-lg-8">
                <!-- Gallery -->
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-5">
                    <img src="{{ $vehicle->photos->first() ? asset('storage/' . $vehicle->photos->first()->photo_path) : '' }}" class="img-fluid" alt="{{ $vehicle->make }} {{ $vehicle->model }}">
                    <!-- Thumbnails placeholder if multiple photos existed -->
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <span class="badge bg-dark text-uppercase px-3 py-2 mb-3" style="letter-spacing: 1px;">{{ $vehicle->category }}</span>
                        <h1 class="fw-800 display-4 mb-2">{{ $vehicle->make }} {{ $vehicle->model }}</h1>
                        <p class="text-secondary lead"><i class="bi bi-geo-alt me-2"></i>Disponible chez {{ $vehicle->agency->agency_name }}, {{ $vehicle->agency->city }}</p>
                    </div>
                    <div class="text-end d-none d-md-block">
                        <div class="text-warning mb-1">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <p class="small fw-bold mb-0">MIEUX NOTÉ</p>
                    </div>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-6 col-md-3">
                        <div class="card border-0 bg-white shadow-sm p-4 text-center rounded-4 h-100">
                            <i class="bi bi-gear fs-2 mb-2"></i>
                            <p class="small text-secondary fw-bold text-uppercase mb-0">Transmission</p>
                            <p class="fw-bold mb-0">Automatique</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="card border-0 bg-white shadow-sm p-4 text-center rounded-4 h-100">
                            <i class="bi bi-people fs-2 mb-2"></i>
                            <p class="small text-secondary fw-bold text-uppercase mb-0">Capacité</p>
                            <p class="fw-bold mb-0">5 Places</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="card border-0 bg-white shadow-sm p-4 text-center rounded-4 h-100">
                            <i class="bi bi-fuel-pump fs-2 mb-2"></i>
                            <p class="small text-secondary fw-bold text-uppercase mb-0">Carburant</p>
                            <p class="fw-bold mb-0">Diesel</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="card border-0 bg-white shadow-sm p-4 text-center rounded-4 h-100">
                            <i class="bi bi-snow fs-2 mb-2"></i>
                            <p class="small text-secondary fw-bold text-uppercase mb-0">Confort</p>
                            <p class="fw-bold mb-0">Climatisation</p>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm p-4 p-md-5 rounded-4 mb-5">
                    <h5 class="fw-bold mb-4">Description du Véhicule</h5>
                    <p class="text-secondary mb-5 lead">{{ $vehicle->description }}</p>

                    <h5 class="fw-bold mb-4">Options Premium</h5>
                    <div class="row g-3">
                        @foreach($vehicle->options as $option)
                            <div class="col-md-6">
                                <div class="d-flex align-items-center p-3 rounded-3 bg-soft-gray border">
                                    <i class="bi bi-check2-circle text-success fs-5 me-3"></i>
                                    <span class="fw-bold">{{ $option }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right: Booking Widget -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-lg p-4 p-md-5 rounded-4 sticky-top" style="top: 120px; z-index: 10;">
                    <div class="d-flex justify-content-between align-items-end mb-4">
                        <h4 class="fw-bold mb-0">Réserver</h4>
                        <div class="text-end">
                            <span class="fs-2 fw-800">{{ number_format($vehicle->price_per_day, 0) }}</span>
                            <span class="text-secondary small">MAD/JOUR</span>
                        </div>
                    </div>

                    <form action="{{ route('booking.checkout') }}" method="POST">
                        @csrf
                        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase">Date de départ</label>
                            <input type="date" name="start_date" class="form-control form-control-lg border-0 bg-light" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase">Date de retour</label>
                            <input type="date" name="end_date" class="form-control form-control-lg border-0 bg-light" required>
                        </div>

                        <div class="bg-light p-4 rounded-4 mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-secondary">Tarif de base</span>
                                <span class="fw-bold">{{ $vehicle->price_per_day }} MAD</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-secondary">Frais de plateforme</span>
                                <span class="fw-bold">10%</span>
                            </div>
                            <hr class="opacity-10">
                            <div class="d-flex justify-content-between fw-800 fs-5 text-dark">
                                <span>Estimation Totale</span>
                                <span id="total-preview">-- MAD</span>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 py-3 fw-bold mb-3 shadow-lg">CONTINUER VERS LE PAIEMENT</button>
                        
                        <button type="button" id="compare-this-vehicle" class="btn btn-outline-dark w-100 py-2 fw-bold mb-3">
                            <i class="bi bi-diagram-2 me-2"></i> Comparer ce Véhicule
                        </button>
                        
                        <div class="text-center">
                            <p class="small text-secondary mb-0"><i class="bi bi-shield-lock me-1"></i> Paiement sécurisé traité par Stripe</p>
                        </div>
                    </form>
                </div>

                <!-- Agency Small Info -->
                <div class="card border-0 shadow-sm p-4 rounded-4 mt-4 bg-white">
                    <h6 class="fw-bold mb-3">Agence de location</h6>
                    <div class="d-flex align-items-center">
                        <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; font-weight: 800;">
                            {{ substr($vehicle->agency->agency_name, 0, 1) }}
                        </div>
                        <div>
                            <p class="fw-bold mb-0">{{ $vehicle->agency->agency_name }}</p>
                            <p class="small text-secondary mb-0">Agence vérifiée</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .fw-800 { font-weight: 800; }
    .bg-soft-gray { background-color: var(--soft-gray); }
    .letter-spacing-1 { letter-spacing: 1px; }
    
    /* Floating comparison bar */
    #comparison-bar {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: var(--primary-black);
        color: white;
        padding: 20px 30px;
        box-shadow: 0 -2px 20px rgba(0,0,0,0.2);
        z-index: 1000;
        transform: translateY(150%);
        transition: transform 0.3s ease;
    }
    
    #comparison-bar.show {
        transform: translateY(0);
    }
</style>
@endpush

@push('scripts')
<script>
    // Comparison functionality for detail page
    const COMPARISON_KEY = 'drivado_comparison';
    const MAX_VEHICLES = 3;
    const CURRENT_VEHICLE_ID = {{ $vehicle->id }};
    
    function loadComparison() {
        const stored = localStorage.getItem(COMPARISON_KEY);
        return stored ? JSON.parse(stored) : [];
    }
    
    function saveComparison(ids) {
        localStorage.setItem(COMPARISON_KEY, JSON.stringify(ids));
    }
    
    function updateComparisonUI() {
        const selectedIds = loadComparison();
        const bar = document.getElementById('comparison-bar');
        const countSpan = document.getElementById('comparison-count');
        const compareBtn = document.getElementById('comparison-compare-btn');
        
        // Show/hide and update bar
        if (selectedIds.length >= 2) {
            countSpan.textContent = selectedIds.length;
            bar.classList.add('show');
        } else {
            bar.classList.remove('show');
        }
        
        // Update compare button href
        if (selectedIds.length >= 2) {
            const params = selectedIds.map(id => `ids[]=${id}`).join('&');
            compareBtn.href = `/compare?${params}`;
        }
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-pre-select current vehicle
        let selectedIds = loadComparison();
        if (!selectedIds.includes(CURRENT_VEHICLE_ID)) {
            selectedIds.push(CURRENT_VEHICLE_ID);
            saveComparison(selectedIds);
        }
        
        // Initialize comparison bar if not already initialized
        if (!document.getElementById('comparison-bar')) {
            const bar = document.createElement('div');
            bar.id = 'comparison-bar';
            bar.innerHTML = `
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="fw-bold">
                            <span id="comparison-count">0</span> véhicules sélectionnés — 
                            <a id="comparison-compare-btn" href="#" class="btn btn-light fw-bold px-4">Voir la comparaison</a>
                        </div>
                        <button id="close-comparison" class="btn-close btn-close-white" aria-label="Fermer"></button>
                    </div>
                </div>
            `;
            document.body.appendChild(bar);
            
            // Close button
            document.getElementById('close-comparison').addEventListener('click', function() {
                bar.classList.remove('show');
            });
        }
        
        // Handle compare button click
        const compareBtn = document.getElementById('compare-this-vehicle');
        if (compareBtn) {
            compareBtn.addEventListener('click', function(e) {
                e.preventDefault();
                let selectedIds = loadComparison();
                
                // Open search page with comparison bar visible
                window.location.href = '/search';
            });
        }
        
        // Initial UI update
        updateComparisonUI();
    });
</script>
@endpush
@endsection
