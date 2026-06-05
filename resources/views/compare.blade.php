@extends('layouts.main')

@section('content')
<!-- Header -->
<div style="background: var(--primary-black); color: white; padding-top: 120px; padding-bottom: 60px;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="fw-800 display-5 mb-2">Comparer les Véhicules</h1>
                <p class="opacity-75 lead mb-0">Analysez côte à côte les caractéristiques, les tarifs et les évaluations pour trouver le meilleur choix.</p>
            </div>
            <div class="col-md-4 text-md-end mt-4 mt-md-0">
                <a href="{{ url('/search') }}" class="btn btn-light fw-bold px-4">← Retour à la Recherche</a>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <!-- Drivado Score Summary -->
    <div class="row g-4 mb-5">
        @foreach($vehicles as $vehicle)
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                    <div class="card-body p-4">
                        <div class="position-relative mb-3">
                            @if($loop->first)
                                <span class="badge bg-success position-absolute top-0 start-0 mt-2 ms-2">⭐ MEILLEUR CHOIX</span>
                            @endif
                            <img src="{{ $vehicle->photos->first() ? asset('storage/' . $vehicle->photos->first()->photo_path) : 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&q=80&w=800' }}" class="img-fluid rounded-3" alt="{{ $vehicle->make }} {{ $vehicle->model }}">
                        </div>
                        
                        <h5 class="fw-bold mb-1">{{ $vehicle->make }} {{ $vehicle->model }}</h5>
                        <p class="text-secondary small mb-3">{{ $vehicle->year }} • {{ $vehicle->agency->agency_name }}</p>

                        <!-- Drivado Score Circle -->
                        <div class="text-center mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-dark text-white" style="width: 120px; height: 120px;">
                                <div class="text-center">
                                    <div class="fw-bold" style="font-size: 2.5rem;">{{ number_format($vehicle->drivado_score, 1) }}</div>
                                    <div class="small">Drivado Score</div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Stats -->
                        <div class="row text-center g-2 small mb-3">
                            <div class="col-6">
                                <div class="bg-light rounded-2 p-2">
                                    <div class="fw-bold">{{ number_format($vehicle->price_per_day, 0) }} MAD</div>
                                    <div class="text-secondary text-nowrap">par jour</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-light rounded-2 p-2">
                                    <div class="fw-bold">{{ count($vehicle->options ?? []) }}</div>
                                    <div class="text-secondary">options</div>
                                </div>
                            </div>
                        </div>

                        <a href="{{ url('/vehicle/'.$vehicle->id) }}" class="btn btn-dark w-100 fw-bold py-2">VER DÉTAILS</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Main Comparison Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="fw-bold" style="min-width: 200px;">Critères</th>
                        @foreach($vehicles as $vehicle)
                            <th class="text-center fw-bold" style="min-width: 200px;">
                                {{ $vehicle->make }} {{ $vehicle->model }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <!-- Photo & Infos -->
                    <tr>
                        <td class="fw-bold">Photo & Informations</td>
                        @foreach($vehicles as $vehicle)
                            <td class="text-center">
                                <img src="{{ $vehicle->photos->first() ? asset('storage/' . $vehicle->photos->first()->photo_path) : 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&q=80&w=800' }}" class="img-fluid rounded-2" alt="{{ $vehicle->make }} {{ $vehicle->model }}" style="max-height: 120px; max-width: 100%;">
                            </td>
                        @endforeach
                    </tr>

                    <!-- Année -->
                    <tr>
                        <td class="fw-bold">Année</td>
                        @foreach($vehicles as $vehicle)
                            <td class="text-center">{{ $vehicle->year }}</td>
                        @endforeach
                    </tr>

                    <!-- Prix -->
                    <tr class="table-light">
                        <td class="fw-bold">Prix par jour</td>
                        @foreach($vehicles as $vehicle)
                            <td class="text-center">
                                <span class="fw-bold">{{ number_format($vehicle->price_per_day, 0) }} MAD</span>
                            </td>
                        @endforeach
                    </tr>

                    <tr class="table-light">
                        <td class="fw-bold">Prix par semaine</td>
                        @foreach($vehicles as $vehicle)
                            <td class="text-center">
                                @if($vehicle->price_per_week)
                                    <span class="fw-bold">{{ number_format($vehicle->price_per_week, 0) }} MAD</span>
                                @else
                                    <span class="text-secondary">{{ number_format($vehicle->price_per_day * 7, 0) }} MAD</span>
                                @endif
                            </td>
                        @endforeach
                    </tr>

                    <!-- Specs -->
                    <tr>
                        <td class="fw-bold">Catégorie</td>
                        @foreach($vehicles as $vehicle)
                            <td class="text-center">
                                <span class="badge bg-dark text-uppercase" style="letter-spacing: 1px;">{{ $vehicle->category }}</span>
                            </td>
                        @endforeach
                    </tr>

                    <tr>
                        <td class="fw-bold">Carburant</td>
                        @foreach($vehicles as $vehicle)
                            <td class="text-center">{{ $vehicle->fuel_type ?? 'Non spécifié' }}</td>
                        @endforeach
                    </tr>

                    <tr>
                        <td class="fw-bold">Transmission</td>
                        @foreach($vehicles as $vehicle)
                            <td class="text-center">{{ $vehicle->transmission ?? 'Non spécifié' }}</td>
                        @endforeach
                    </tr>

                    <tr>
                        <td class="fw-bold">Nombre de places</td>
                        @foreach($vehicles as $vehicle)
                            <td class="text-center">{{ $vehicle->seats ?? 'Non spécifié' }} places</td>
                        @endforeach
                    </tr>

                    <!-- Options/Features -->
                    <tr class="table-light">
                        <td class="fw-bold">Options & Équipements</td>
                        @foreach($vehicles as $vehicle)
                            <td class="text-center">
                                @if($vehicle->options && count($vehicle->options) > 0)
                                    <div class="d-flex flex-wrap gap-2 justify-content-center">
                                        @foreach($vehicle->options as $option)
                                            <span class="badge bg-light text-dark small" style="border: 1px solid #dee2e6;">{{ $option }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-secondary">Aucune option spécifiée</span>
                                @endif
                            </td>
                        @endforeach
                    </tr>

                    <!-- Cancellation Policy -->
                    <tr>
                        <td class="fw-bold">Politique d'annulation</td>
                        @foreach($vehicles as $vehicle)
                            <td class="text-center text-secondary small">
                                {{ $vehicle->cancellation_policy ?? 'Non spécifiée' }}
                            </td>
                        @endforeach
                    </tr>

                    <!-- Agency Info -->
                    <tr class="table-light">
                        <td class="fw-bold">Agence</td>
                        @foreach($vehicles as $vehicle)
                            <td class="text-center">
                                <strong>{{ $vehicle->agency->agency_name }}</strong><br>
                                <span class="text-secondary small">{{ $vehicle->agency->city }}</span>
                            </td>
                        @endforeach
                    </tr>

                    <!-- Drivado Score -->
                    <tr class="table-dark text-white">
                        <td class="fw-bold">Drivado Score</td>
                        @foreach($vehicles as $vehicle)
                            <td class="text-center">
                                <div class="display-6 fw-bold">{{ number_format($vehicle->drivado_score, 1) }}/100</div>
                                @if($loop->first)
                                    <span class="badge bg-success">⭐ MEILLEUR</span>
                                @endif
                            </td>
                        @endforeach
                    </tr>

                    <!-- Score Breakdown -->
                    <tr class="table-light small">
                        <td class="fw-bold">Valeur du prix (30 pts)</td>
                        @foreach($vehicles as $vehicle)
                            <td class="text-center">
                                <div class="fw-bold text-dark">{{ number_format($vehicle->score_breakdown['price'], 1) }}/30</div>
                                @if($vehicle->score_breakdown['price'] == $vehicles->max('score_breakdown.price'))
                                    <span class="badge bg-success">Meilleur prix</span>
                                @endif
                            </td>
                        @endforeach
                    </tr>

                    <tr class="table-light small">
                        <td class="fw-bold">Évaluation (25 pts)</td>
                        @foreach($vehicles as $vehicle)
                            <td class="text-center">
                                <div class="fw-bold text-dark">{{ number_format($vehicle->score_breakdown['rating'], 1) }}/25</div>
                                @if($vehicle->score_breakdown['rating'] == $vehicles->max('score_breakdown.rating'))
                                    <span class="badge bg-success">Mieux noté</span>
                                @endif
                            </td>
                        @endforeach
                    </tr>

                    <tr class="table-light small">
                        <td class="fw-bold">Options & Équipements (20 pts)</td>
                        @foreach($vehicles as $vehicle)
                            <td class="text-center">
                                <div class="fw-bold text-dark">{{ number_format($vehicle->score_breakdown['features'], 1) }}/20</div>
                                @if($vehicle->score_breakdown['features'] == $vehicles->max('score_breakdown.features'))
                                    <span class="badge bg-success">Plus d'options</span>
                                @endif
                            </td>
                        @endforeach
                    </tr>

                    <tr class="table-light small">
                        <td class="fw-bold">Flexibilité d'annulation (15 pts)</td>
                        @foreach($vehicles as $vehicle)
                            <td class="text-center">
                                <div class="fw-bold text-dark">{{ number_format($vehicle->score_breakdown['cancellation'], 1) }}/15</div>
                                @if($vehicle->score_breakdown['cancellation'] == $vehicles->max('score_breakdown.cancellation'))
                                    <span class="badge bg-success">Plus flexible</span>
                                @endif
                            </td>
                        @endforeach
                    </tr>

                    <tr class="table-light small">
                        <td class="fw-bold">Fiabilité de disponibilité (10 pts)</td>
                        @foreach($vehicles as $vehicle)
                            <td class="text-center">
                                <div class="fw-bold text-dark">{{ number_format($vehicle->score_breakdown['availability'], 1) }}/10</div>
                                @if($vehicle->score_breakdown['availability'] == $vehicles->max('score_breakdown.availability'))
                                    <span class="badge bg-success">Plus populaire</span>
                                @endif
                            </td>
                        @endforeach
                    </tr>

                    <!-- Call to Action -->
                    <tr class="table-dark text-white">
                        <td class="fw-bold">Action</td>
                        @foreach($vehicles as $vehicle)
                            <td class="text-center">
                                <a href="{{ url('/vehicle/'.$vehicle->id) }}" class="btn btn-light btn-sm fw-bold">Voir les détails</a>
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Back Button -->
    <div class="text-center mt-5">
        <a href="{{ url('/search') }}" class="btn btn-dark fw-bold px-5 py-3">← Retour à la Recherche</a>
    </div>
</div>

@push('scripts')
<script>
    // Clear comparison on page load (user can select new vehicles)
    // localStorage is managed by JavaScript on search and detail pages
</script>
@endpush

@endsection
