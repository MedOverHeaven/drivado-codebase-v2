@extends('layouts.main')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h3 class="fw-bold mb-4">Vérifier & Confirmer la Réservation</h3>
            
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm p-4 mb-4">
                        <h5 class="fw-bold mb-4">Résumé de la Réservation</h5>
                        <div class="d-flex align-items-center mb-4">
                            <img src="https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&q=80&w=150" class="rounded me-3" alt="">
                            <div>
                                <h6 class="fw-bold mb-1">{{ $vehicle->make }} {{ $vehicle->model }}</h6>
                                <p class="text-secondary small mb-0">{{ $vehicle->agency->agency_name }} &middot; {{ $vehicle->agency->city }}</p>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <p class="text-secondary small fw-bold text-uppercase mb-1">Départ</p>
                                <p class="fw-bold mb-0">{{ $booking_data['start_date'] }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-secondary small fw-bold text-uppercase mb-1">Retour</p>
                                <p class="fw-bold mb-0">{{ $booking_data['end_date'] }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-secondary small fw-bold text-uppercase mb-1">Durée</p>
                                <p class="fw-bold mb-0">{{ $booking_data['days'] }} Jours</p>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm p-4">
                        <h5 class="fw-bold mb-4">Conditions d'Annulation</h5>
                        <p class="text-secondary">{{ $vehicle->cancellation_policy }}</p>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm p-4">
                        <h5 class="fw-bold mb-4">Détails du Prix</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ $booking_data['days'] }} Jours &times; {{ $vehicle->price_per_day }} MAD</span>
                            <span>{{ $booking_data['subtotal'] }} MAD</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 text-secondary small">
                            <span>Frais de plateforme ({{ $booking_data['commission_rate'] }}%)</span>
                            <span>{{ $booking_data['commission_amount'] }} MAD</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-4 mb-4">
                            <span>Total</span>
                            <span>{{ $booking_data['total'] }} MAD</span>
                        </div>

                        <form action="{{ route('booking.confirm') }}" method="POST">
                            @csrf
                            <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                            <input type="hidden" name="start_date" value="{{ $booking_data['start_date'] }}">
                            <input type="hidden" name="end_date" value="{{ $booking_data['end_date'] }}">

                            <button type="submit" class="btn btn-dark w-100 fw-bold py-3">CONFIRMER & PAYER</button>
                        </form>
                        
                        <p class="text-center text-secondary small mt-3">
                            <i class="bi bi-shield-lock me-1"></i> Paiement Sécurisé par Stripe
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
