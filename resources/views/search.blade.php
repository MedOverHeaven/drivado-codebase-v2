@extends('layouts.main')

@section('content')
<!-- Header with extra padding to avoid navbar overlap -->
<div class="search-header" style="background: var(--primary-black); color: white; padding-top: 120px; padding-bottom: 60px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="fw-800 display-5 mb-2">Explorez Notre Flotte</h1>
                <p class="opacity-75 lead mb-0">Découvrez le véhicule parfait pour votre prochain voyage à Oujda.</p>
            </div>
            <div class="col-md-4 text-md-end mt-4 mt-md-0">
                <div class="btn-group p-1 bg-white bg-opacity-10 rounded-pill">
                    <button class="btn btn-premium rounded-pill px-4 active" id="btn-grid-view">
                        <i class="bi bi-grid-fill me-2"></i> GRILLE
                    </button>
                    <button class="btn btn-outline-light border-0 rounded-pill px-4" id="btn-map-view">
                        <i class="bi bi-map-fill me-2"></i> CARTE
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Inline Map View (Hidden by default) -->
<div id="map-container" class="border-bottom d-none" style="height: 400px; background: #eee;">
    <div id="map" style="height: 100%;"></div>
</div>

<div class="container py-5">
    <div class="row g-4">
        <!-- Sidebar Filters -->
        <div class="col-lg-3">
            <div class="filter-sidebar card border-0 shadow-sm p-4 sticky-top" style="top: 100px; z-index: 10; border-radius: 20px; max-height: calc(100vh - 120px); overflow-y: auto;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Filtres</h5>
                    <a href="{{ url('/search') }}" class="text-secondary small text-decoration-none">Réinitialiser</a>
                </div>
                
                <form action="{{ url('/search') }}" method="GET" id="filterForm">
                    <!-- Localisation -->
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase mb-3">Localisation</label>
                        <input type="text" name="location" class="form-control border-0 bg-light rounded-3" value="{{ request('location') }}" placeholder="Ville ou Agence">
                    </div>

                    <!-- Marque & Modèle -->
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase mb-3">Marque</label>
                        <input type="text" name="make" class="form-control border-0 bg-light rounded-3" value="{{ request('make') }}" placeholder="Ex: Dacia, Hyundai">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase mb-3">Modèle</label>
                        <input type="text" name="model" class="form-control border-0 bg-light rounded-3" value="{{ request('model') }}" placeholder="Ex: Logan, Tucson">
                    </div>

                    <!-- Fuel Type -->
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase mb-3">Carburant</label>
                        <div class="d-flex flex-column gap-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="fuel[]" value="Essence" id="fuel_essence" {{ in_array('Essence', (array)request('fuel', [])) ? 'checked' : '' }}>
                                <label class="form-check-label small" for="fuel_essence">Essence</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="fuel[]" value="Diesel" id="fuel_diesel" {{ in_array('Diesel', (array)request('fuel', [])) ? 'checked' : '' }}>
                                <label class="form-check-label small" for="fuel_diesel">Diesel</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="fuel[]" value="Électrique" id="fuel_electric" {{ in_array('Électrique', (array)request('fuel', [])) ? 'checked' : '' }}>
                                <label class="form-check-label small" for="fuel_electric">Électrique</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="fuel[]" value="Hybride" id="fuel_hybrid" {{ in_array('Hybride', (array)request('fuel', [])) ? 'checked' : '' }}>
                                <label class="form-check-label small" for="fuel_hybrid">Hybride</label>
                            </div>
                        </div>
                    </div>

                    <!-- Seats -->
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase mb-3">Nombre de Places</label>
                        <div class="d-flex flex-column gap-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="seats[]" value="2" id="seats_2" {{ in_array('2', (array)request('seats', [])) ? 'checked' : '' }}>
                                <label class="form-check-label small" for="seats_2">2 places</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="seats[]" value="5" id="seats_5" {{ in_array('5', (array)request('seats', [])) ? 'checked' : '' }}>
                                <label class="form-check-label small" for="seats_5">5 places</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="seats[]" value="7" id="seats_7" {{ in_array('7', (array)request('seats', [])) ? 'checked' : '' }}>
                                <label class="form-check-label small" for="seats_7">7+ places</label>
                            </div>
                        </div>
                    </div>

                    <!-- Transmission -->
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase mb-3">Transmission</label>
                        <div class="d-flex flex-column gap-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="transmission[]" value="Automatique" id="trans_auto" {{ in_array('Automatique', (array)request('transmission', [])) ? 'checked' : '' }}>
                                <label class="form-check-label small" for="trans_auto">Automatique</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="transmission[]" value="Manuelle" id="trans_manual" {{ in_array('Manuelle', (array)request('transmission', [])) ? 'checked' : '' }}>
                                <label class="form-check-label small" for="trans_manual">Manuelle</label>
                            </div>
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase mb-3">Catégorie</label>
                        <select name="category" class="form-select border-0 bg-light rounded-3">
                            <option value="">Toutes les catégories</option>
                            <option value="suv" {{ request('category') == 'suv' ? 'selected' : '' }}>SUV</option>
                            <option value="sedan" {{ request('category') == 'sedan' ? 'selected' : '' }}>Berline</option>
                            <option value="city" {{ request('category') == 'city' ? 'selected' : '' }}>Citadine</option>
                            <option value="utility" {{ request('category') == 'utility' ? 'selected' : '' }}>Utilitaire</option>
                            <option value="luxury" {{ request('category') == 'luxury' ? 'selected' : '' }}>Luxe</option>
                        </select>
                    </div>

                    <!-- Year Range -->
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase mb-3">Année</label>
                        <div class="d-flex gap-2 align-items-center">
                            <input type="number" name="year_min" class="form-control border-0 bg-light rounded-3" placeholder="Min" value="{{ request('year_min') }}" min="2000" max="2099">
                            <span class="text-secondary">-</span>
                            <input type="number" name="year_max" class="form-control border-0 bg-light rounded-3" placeholder="Max" value="{{ request('year_max') }}" min="2000" max="2099">
                        </div>
                    </div>

                    <!-- Price Per Week -->
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase mb-3">Prix par Semaine (MAD)</label>
                        <div class="d-flex gap-2 align-items-center">
                            <input type="number" name="price_week_min" class="form-control border-0 bg-light rounded-3" placeholder="Min" value="{{ request('price_week_min') }}" min="0">
                            <span class="text-secondary">-</span>
                            <input type="number" name="price_week_max" class="form-control border-0 bg-light rounded-3" placeholder="Max" value="{{ request('price_week_max') }}" min="0">
                        </div>
                    </div>

                    <!-- Rating Filter -->
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase mb-3">Évaluation</label>
                        <div class="d-flex flex-column gap-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="rating[]" value="5" id="rating_5" {{ in_array('5', (array)request('rating', [])) ? 'checked' : '' }}>
                                <label class="form-check-label small" for="rating_5">
                                    <i class="bi bi-star-fill" style="color: #ffc107;"></i>
                                    <i class="bi bi-star-fill" style="color: #ffc107;"></i>
                                    <i class="bi bi-star-fill" style="color: #ffc107;"></i>
                                    <i class="bi bi-star-fill" style="color: #ffc107;"></i>
                                    <i class="bi bi-star-fill" style="color: #ffc107;"></i>
                                    5 étoiles
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="rating[]" value="4" id="rating_4" {{ in_array('4', (array)request('rating', [])) ? 'checked' : '' }}>
                                <label class="form-check-label small" for="rating_4">
                                    <i class="bi bi-star-fill" style="color: #ffc107;"></i>
                                    <i class="bi bi-star-fill" style="color: #ffc107;"></i>
                                    <i class="bi bi-star-fill" style="color: #ffc107;"></i>
                                    <i class="bi bi-star-fill" style="color: #ffc107;"></i>
                                    <i class="bi bi-star" style="color: #ccc;"></i>
                                    4+ étoiles
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="rating[]" value="3" id="rating_3" {{ in_array('3', (array)request('rating', [])) ? 'checked' : '' }}>
                                <label class="form-check-label small" for="rating_3">
                                    <i class="bi bi-star-fill" style="color: #ffc107;"></i>
                                    <i class="bi bi-star-fill" style="color: #ffc107;"></i>
                                    <i class="bi bi-star-fill" style="color: #ffc107;"></i>
                                    <i class="bi bi-star" style="color: #ccc;"></i>
                                    <i class="bi bi-star" style="color: #ccc;"></i>
                                    3+ étoiles
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="rating[]" value="2" id="rating_2" {{ in_array('2', (array)request('rating', [])) ? 'checked' : '' }}>
                                <label class="form-check-label small" for="rating_2">
                                    <i class="bi bi-star-fill" style="color: #ffc107;"></i>
                                    <i class="bi bi-star-fill" style="color: #ffc107;"></i>
                                    <i class="bi bi-star" style="color: #ccc;"></i>
                                    <i class="bi bi-star" style="color: #ccc;"></i>
                                    <i class="bi bi-star" style="color: #ccc;"></i>
                                    2+ étoiles
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="rating[]" value="1" id="rating_1" {{ in_array('1', (array)request('rating', [])) ? 'checked' : '' }}>
                                <label class="form-check-label small" for="rating_1">
                                    <i class="bi bi-star-fill" style="color: #ffc107;"></i>
                                    <i class="bi bi-star" style="color: #ccc;"></i>
                                    <i class="bi bi-star" style="color: #ccc;"></i>
                                    <i class="bi bi-star" style="color: #ccc;"></i>
                                    <i class="bi bi-star" style="color: #ccc;"></i>
                                    1+ étoile
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Available Only Toggle -->
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="available_only" id="available_only" value="1" {{ request('available_only') ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold small" for="available_only">Disponible uniquement</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-dark w-100 fw-bold py-3">APPLIQUER LES FILTRES</button>
                </form>

                <!-- Small Info Card -->
                <div class="mt-4 p-3 bg-soft-gray rounded-4 border">
                    <p class="small text-secondary mb-0"><i class="bi bi-info-circle me-2"></i> Tous les tarifs incluent la protection de la plateforme et l'assurance de base.</p>
                </div>
            </div>
        </div>

        <!-- Search Results -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">{{ $vehicles->total() }} Véhicules Disponibles</h4>
                <div class="dropdown">
                    <button class="btn btn-white border-0 shadow-sm rounded-pill px-4 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Trier par : Nouveautés
                    </button>
<ul class="dropdown-menu border-0 shadow-lg">
    <li><a class="dropdown-item" href="{{ url('/search') }}?{{ http_build_query(array_merge(request()->query(), ['sort' => 'price_asc'])) }}">Prix : Du moins cher au plus cher</a></li>
    <li><a class="dropdown-item" href="{{ url('/search') }}?{{ http_build_query(array_merge(request()->query(), ['sort' => 'price_desc'])) }}">Prix : Du plus cher au moins cher</a></li>
    <li><a class="dropdown-item" href="{{ url('/search') }}?{{ http_build_query(array_merge(request()->query(), ['sort' => 'newest'])) }}">Les plus récents en premier</a></li>
</ul>
                </div>
            </div>

            <div class="row g-4" id="grid-view">
                @forelse($vehicles as $vehicle)
                    <div class="col-md-6 col-xl-4">
                        <div class="vehicle-card shadow-sm position-relative" data-vehicle-id="{{ $vehicle->id }}">
                            <div class="card-img-wrapper position-relative">
                                <img src="{{ $vehicle->photos->first() ? asset('storage/' . $vehicle->photos->first()->photo_path) : 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&q=80&w=800' }}" class="img-fluid" alt="{{ $vehicle->make }} {{ $vehicle->model }}">
                                <div class="price-tag">
                                    {{ number_format($vehicle->price_per_day, 0) }} MAD <span class="small opacity-75 fw-normal">/ jour</span>
                                </div>
                                <!-- Compare Button on Hover -->
                                <button class="btn btn-light fw-bold py-2 compare-btn position-absolute" style="bottom: 10px; right: 10px; opacity: 0; transition: opacity 0.3s;" data-id="{{ $vehicle->id }}">
                                    <i class="bi bi-plus-lg me-1"></i> Comparer
                                </button>
                            </div>
                            <div class="p-4">
                                <span class="badge bg-light text-dark text-uppercase mb-2" style="font-size: 0.65rem; font-weight: 700;">{{ $vehicle->category }}</span>
                                <h6 class="fw-bold mb-1">{{ $vehicle->make }} {{ $vehicle->model }}</h6>
                                <p class="text-secondary small mb-3"><i class="bi bi-shop me-1"></i> {{ $vehicle->agency->agency_name }}</p>
                                
                                <div class="d-flex gap-2">
                                    <a href="{{ url('/vehicle/'.$vehicle->id) }}" class="btn btn-dark w-100 fw-bold py-2 stretched-link">DÉTAILS</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <img src="https://illustrations.popsy.co/white/car-service.svg" alt="No results" style="height: 200px;" class="mb-4">
                        <h4 class="fw-bold">Aucun résultat trouvé</h4>
                        <p class="text-secondary mb-4">Essayez d'ajuster vos filtres pour voir d'autres véhicules.</p>
                        <a href="{{ url('/search') }}" class="btn btn-dark fw-bold px-4">EFFACER TOUS LES FILTRES</a>
                    </div>
                @endforelse
            </div>

            <div class="mt-5 d-flex justify-content-center">
                {{ $vehicles->links() }}
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .fw-800 { font-weight: 800; }
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
    
    /* Fix potential overlap on very small screens */
    @media (max-width: 991px) {
        .filter-sidebar { position: static !important; margin-bottom: 2rem; }
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
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
        // Initialize comparison bar
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
        
        // Map functionality (existing code)
        const btnGrid = document.getElementById('btn-grid-view');
        const btnMap = document.getElementById('btn-map-view');
        const mapContainer = document.getElementById('map-container');
        const gridView = document.getElementById('grid-view');
        
        let map;

        btnMap.addEventListener('click', function() {
            btnMap.classList.add('btn-premium', 'active');
            btnMap.classList.remove('btn-outline-light');
            btnGrid.classList.remove('btn-premium', 'active');
            btnGrid.classList.add('btn-outline-light');
            
            mapContainer.classList.remove('d-none');
            
            if (!map) {
                map = L.map('map').setView([34.6867, -1.9114], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

                @foreach($vehicles as $vehicle)
                    @if($vehicle->agency->latitude && $vehicle->agency->longitude)
                        L.marker([{{ $vehicle->agency->latitude }}, {{ $vehicle->agency->longitude }}])
                            .addTo(map)
                            .bindPopup(`
                                <div class="text-center p-2">
                                    <h6 class="fw-bold mb-1">{{ $vehicle->make }} {{ $vehicle->model }}</h6>
                                    <p class="small text-secondary mb-2">{{ $vehicle->agency->agency_name }}</p>
                                    <a href="{{ url('/vehicle/'.$vehicle->id) }}" class="btn btn-dark btn-sm fw-bold px-3">RÉSERVER</a>
                                </div>
                            `);
                    @endif
                @endforeach
            } else {
                setTimeout(() => map.invalidateSize(), 100);
            }
        });

        btnGrid.addEventListener('click', function() {
            btnGrid.classList.add('btn-premium', 'active');
            btnGrid.classList.remove('btn-outline-light');
            btnMap.classList.remove('btn-premium', 'active');
            btnMap.classList.add('btn-outline-light');
            
            mapContainer.classList.add('d-none');
        });
    });
</script>
@endpush
@endsection
