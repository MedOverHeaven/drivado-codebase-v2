@extends('layouts.main')

@section('content')
<!-- Hero Section -->
<section class="hero-wrapper position-relative overflow-hidden" style="background: var(--primary-black); min-height: 95vh; display: flex; align-items: center;">
    <!-- Abstract Background Elements -->
    <div class="position-absolute top-0 end-0 p-5 opacity-10 d-none d-lg-block">
        <i class="bi bi-speedometer2" style="font-size: 30rem; transform: rotate(-15deg);"></i>
    </div>
    
    <div class="container position-relative z-1">
        <div class="row align-items-center">
            <div class="col-lg-7 text-white hero-content">
                <span class="badge rounded-pill bg-white text-dark fw-bold px-3 py-2 mb-4 animate__animated animate__fadeInDown">NOUVEAUTÉ : NOTRE FLOTTE DE LUXE 2024 EST DISPONIBLE</span>
                <h1 class="hero-title mb-4 animate__animated animate__fadeInLeft">Sublimez Votre <br><span class="text-secondary">Expérience de Conduite.</span></h1>
                <p class="lead mb-5 opacity-75 animate__animated animate__fadeInLeft animate__delay-1s" style="max-width: 500px;">Découvrez la liberté de la route avec la marketplace de location de voitures la plus exclusive d'Oujda. Véhicules premium, agences vérifiées et aucun frais caché.</p>
                
                <div class="d-flex gap-3 animate__animated animate__fadeInLeft animate__delay-1s">
                    <a href="{{ url('/search') }}" class="btn btn-premium px-5 py-3 fw-bold">EXPLORER LA FLOTTE</a>
                    <a href="#how-it-works" class="btn btn-outline-light px-5 py-3 fw-bold">COMMENT ÇA MARCHE</a>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block">
                <!-- Premium Car Image Placeholder with subtle floating animation -->
                <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&q=80&w=1000" class="img-fluid rounded-4 shadow-lg animate__animated animate__fadeInRight" alt="Premium Car">
            </div>
        </div>
    </div>
</section>

<!-- Advanced Search Widget (Floating) -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="search-widget p-4 p-lg-5 animate__animated animate__fadeInUp">
                <form action="{{ url('/search') }}" method="GET" class="row g-4">
                    <div class="col-lg-4">
                        <label class="form-label fw-bold text-dark mb-3"><i class="bi bi-geo-alt-fill me-2"></i>OÙ ALLEZ-VOUS ?</label>
                        <input type="text" name="location" class="form-control form-control-lg" placeholder="Ville ou nom de l'agence" value="Oujda">
                    </div>
                    <div class="col-lg-3">
                        <label class="form-label fw-bold text-dark mb-3"><i class="bi bi-calendar-event-fill me-2"></i>DÉPART</label>
                        <input type="date" name="start_date" class="form-control form-control-lg">
                    </div>
                    <div class="col-lg-3">
                        <label class="form-label fw-bold text-dark mb-3"><i class="bi bi-calendar-check-fill me-2"></i>RETOUR</label>
                        <input type="date" name="end_date" class="form-control form-control-lg">
                    </div>
                    <div class="col-lg-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-dark w-100 py-3 fw-bold">RECHERCHER</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Featured Vehicles Section -->
<section class="py-5 mt-5">
    <div class="container py-5">
        <div class="row align-items-end mb-5">
            <div class="col-md-7">
                <span class="text-uppercase fw-bold text-secondary small letter-spacing-2">Collection Exclusive</span>
                <h2 class="section-title">Disponible à Oujda</h2>
                <p class="section-subtitle">Découvrez nos véhicules les plus populaires disponibles immédiatement à des tarifs compétitifs.</p>
            </div>
            <div class="col-md-5 text-md-end">
                <a href="{{ url('/search') }}" class="text-dark fw-bold text-decoration-none">VOIR TOUTE LA FLOTTE <i class="bi bi-arrow-right ms-2"></i></a>
            </div>
        </div>

        <div class="row g-4">
            @foreach($vehicles as $vehicle)
                <div class="col-md-6 col-lg-4">
                    <div class="vehicle-card position-relative" data-vehicle-id="{{ $vehicle->id }}">
                        <div class="card-img-wrapper position-relative">
                           <img src="{{ $vehicle->photos->first() ? asset('storage/' . $vehicle->photos->first()->photo_path) : 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&q=80&w=800' }}" alt="{{ $vehicle->make }} {{ $vehicle->model }}">
                            <div class="price-tag">
                                {{ number_format($vehicle->price_per_day, 0) }} MAD <span class="small opacity-75 fw-normal">/ jour</span>
                            </div>
                            <!-- Compare Button on Hover -->
                            <button class="btn btn-light fw-bold py-2 compare-btn position-absolute" style="bottom: 10px; right: 10px; opacity: 0; transition: opacity 0.3s;" data-id="{{ $vehicle->id }}">
                                <i class="bi bi-plus-lg me-1"></i> Comparer
                            </button>
                        </div>
                        <div class="p-4">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <span class="badge bg-light text-dark text-uppercase mb-2" style="font-size: 0.65rem; font-weight: 700; letter-spacing: 1px;">{{ $vehicle->category }}</span>
                                    <h5 class="fw-bold mb-1">{{ $vehicle->make }} {{ $vehicle->model }}</h5>
                                    <p class="text-secondary small mb-0"><i class="bi bi-shop me-1"></i> {{ $vehicle->agency->agency_name }}</p>
                                </div>
                                <div class="text-warning">
                                    <i class="bi bi-star-fill"></i> <span class="text-dark fw-bold">4.9</span>
                                </div>
                            </div>

                             <div class="vehicle-specs">
                                <div class="spec-item"><i class="bi bi-fuel-pump"></i> Diesel</div>
                                <div class="spec-item"><i class="bi bi-gear"></i> {{ $vehicle->options[2] ?? 'Auto' }}</div>
                                <div class="spec-item"><i class="bi bi-people"></i> 5 Places</div>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ url('/vehicle/'.$vehicle->id) }}" class="btn btn-dark w-100 fw-bold stretched-link">RÉSERVER MAINTENANT</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section id="how-it-works" class="py-5 bg-white border-top border-bottom">
    <div class="container py-5 text-center">
        <span class="text-uppercase fw-bold text-secondary small letter-spacing-2">Processus Simple</span>
        <h2 class="section-title mb-5">Commencer est très simple</h2>
        
        <div class="row g-5 mt-4">
            <div class="col-md-4">
                <div class="rounded-circle bg-soft-gray d-inline-flex align-items-center justify-content-center mb-4" style="width: 100px; height: 100px;">
                    <i class="bi bi-search fs-1"></i>
                </div>
                <h5 class="fw-bold mb-3">1. Sélectionnez votre véhicule</h5>
                <p class="text-secondary px-lg-4">Choisissez parmi une large gamme de véhicules, des citadines aux SUV de luxe à travers tout Oujda.</p>
            </div>
            <div class="col-md-4">
                <div class="rounded-circle bg-soft-gray d-inline-flex align-items-center justify-content-center mb-4" style="width: 100px; height: 100px;">
                    <i class="bi bi-calendar-check fs-1"></i>
                </div>
                <h5 class="fw-bold mb-3">2. Réservez & Confirmez</h5>
                <p class="text-secondary px-lg-4">Sélectionnez vos dates, examinez nos tarifs transparents et validez votre réservation instantanément.</p>
            </div>
            <div class="col-md-4">
                <div class="rounded-circle bg-soft-gray d-inline-flex align-items-center justify-content-center mb-4" style="width: 100px; height: 100px;">
                    <i class="bi bi-key fs-1"></i>
                </div>
                <h5 class="fw-bold mb-3">3. Récupérez & Profitez</h5>
                <p class="text-secondary px-lg-4">Recevez les coordonnées et contacts immédiatement. Retrouvez l'agence et prenez la route.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 position-relative overflow-hidden" style="background: var(--primary-black);">
    <div class="container py-5 text-center position-relative z-1 text-white">
        <h2 class="section-title mb-4">Êtes-vous une agence de location ?</h2>
        <p class="lead mb-5 opacity-75" style="max-width: 700px; margin: 0 auto;">Rejoignez la marketplace de location de voitures à la croissance la plus rapide de la région et touchez des milliers de clients dès aujourd'hui.</p>
        <a href="{{ route('register') }}" class="btn btn-premium px-5 py-3 fw-bold">PROPOSEZ VOTRE FLOTTE SUR DRIVADO</a>
    </div>
</section>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<style>
    .letter-spacing-2 { letter-spacing: 2px; }
    .bg-soft-gray { background-color: var(--soft-gray); }
    
    /* Hover effect for compare button */
    .vehicle-card:hover .compare-btn {
        opacity: 1 !important;
    }
    
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
    // Comparison functionality
    const COMPARISON_KEY = 'drivado_comparison';
    const MAX_VEHICLES = 3;
    
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
        
        // Update all checkboxes
        document.querySelectorAll('.compare-btn').forEach(btn => {
            const id = btn.dataset.id;
            if (selectedIds.includes(parseInt(id))) {
                btn.classList.add('active');
                btn.innerHTML = '<i class="bi bi-check-lg me-1"></i> Sélectionné';
            } else {
                btn.classList.remove('active');
                btn.innerHTML = '<i class="bi bi-plus-lg me-1"></i> Comparer';
            }
        });
        
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
        
        // Compare buttons
        document.querySelectorAll('.compare-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const vehicleId = parseInt(this.dataset.id);
                let selectedIds = loadComparison();
                
                if (selectedIds.includes(vehicleId)) {
                    selectedIds = selectedIds.filter(id => id !== vehicleId);
                } else {
                    if (selectedIds.length < MAX_VEHICLES) {
                        selectedIds.push(vehicleId);
                    } else {
                        alert('Vous ne pouvez comparer que 3 véhicules maximum');
                        return;
                    }
                }
                
                saveComparison(selectedIds);
                updateComparisonUI();
            });
        });
        
        // Initial UI update
        updateComparisonUI();
    });
</script>
@endpush
@endsection
