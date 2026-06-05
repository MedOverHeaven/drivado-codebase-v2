@extends('layouts.main')

@section('content')
<div class="dashboard-wrapper bg-light min-vh-100 pt-5 mt-5">
    <div class="container py-5">
        <div class="row g-4">
            <!-- Sidebar Navigation -->
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm p-4 rounded-4 sticky-top" style="top: 100px;">
                    <div class="text-center mb-4 pb-2">
                        <div class="bg-dark text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px; font-weight: 800; font-size: 1.5rem;">
                            {{ substr($agency->agency_name, 0, 1) }}
                        </div>
                        <h5 class="fw-bold mb-1">{{ $agency->agency_name }}</h5>
                        <p class="text-secondary small mb-0"><i class="bi bi-geo-alt me-1"></i> {{ $agency->city }}, Morocco</p>
                    </div>
                    
                    <div class="nav flex-column gap-2">
                        <a href="{{ route('agency.dashboard') }}" class="nav-link px-3 py-2 rounded-3 {{ Request::is('agency/dashboard') ? 'bg-dark text-white active' : 'text-secondary hover-bg-light' }}">
                            <i class="bi bi-grid-1x2-fill me-2"></i> Overview
                        </a>
                        <a href="{{ route('agency.vehicles') }}" class="nav-link px-3 py-2 rounded-3 {{ Request::is('agency/vehicles*') ? 'bg-dark text-white active' : 'text-secondary hover-bg-light' }}">
                            <i class="bi bi-car-front-fill me-2"></i> My Fleet
                        </a>
                        <a href="#" class="nav-link px-3 py-2 rounded-3 text-secondary hover-bg-light">
                            <i class="bi bi-calendar-check-fill me-2"></i> Reservations
                        </a>
                        <a href="#" class="nav-link px-3 py-2 rounded-3 text-secondary hover-bg-light">
                            <i class="bi bi-graph-up-arrow me-2"></i> Analytics
                        </a>
                        <hr class="my-3 opacity-10">
                        <a href="#" class="nav-link px-3 py-2 rounded-3 text-secondary hover-bg-light">
                            <i class="bi bi-gear-fill me-2"></i> Settings
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-800 mb-0">Agency Overview</h3>
                    <div class="text-secondary small fw-bold">{{ date('F d, Y') }}</div>
                </div>

                <!-- Stats Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm p-4 rounded-4 h-100">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-soft-blue p-2 rounded-3 me-3"><i class="bi bi-car-front text-primary fs-4"></i></div>
                                <span class="text-secondary small fw-bold text-uppercase">Fleet</span>
                            </div>
                            <h2 class="fw-800 mb-0">{{ $stats['total_vehicles'] }}</h2>
                            <p class="small text-success mt-2 mb-0"><i class="bi bi-arrow-up-short"></i> +2 this month</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm p-4 rounded-4 h-100">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-soft-green p-2 rounded-3 me-3"><i class="bi bi-calendar-check text-success fs-4"></i></div>
                                <span class="text-secondary small fw-bold text-uppercase">Bookings</span>
                            </div>
                            <h2 class="fw-800 mb-0">{{ $stats['total_bookings'] }}</h2>
                            <p class="small text-success mt-2 mb-0"><i class="bi bi-arrow-up-short"></i> +12% vs last month</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm p-4 rounded-4 h-100 bg-dark text-white overflow-hidden position-relative">
                            <div class="position-relative z-1">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-white bg-opacity-10 p-2 rounded-3 me-3"><i class="bi bi-wallet2 text-white fs-4"></i></div>
                                    <span class="text-white-50 small fw-bold text-uppercase">Total Revenue</span>
                                </div>
                                <h2 class="fw-800 mb-0">{{ number_format($stats['total_revenue'], 0) }} MAD</h2>
                                <p class="small text-white-50 mt-2 mb-0">Net earnings after platform commission</p>
                            </div>
                            <i class="bi bi-currency-dollar position-absolute top-50 end-0 translate-middle-y opacity-10" style="font-size: 8rem; margin-right: -2rem;"></i>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- Recent Activity -->
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4 p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0">Recent Reservations</h5>
                                <a href="#" class="btn btn-link text-dark text-decoration-none fw-bold small p-0">VIEW ALL <i class="bi bi-arrow-right"></i></a>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr class="small text-uppercase text-secondary fw-bold">
                                            <th class="border-0 px-3 py-3">Customer</th>
                                            <th class="border-0 py-3">Vehicle</th>
                                            <th class="border-0 py-3">Dates</th>
                                            <th class="border-0 py-3">Total</th>
                                            <th class="border-0 py-3">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recent_bookings as $booking)
                                            <tr>
                                                <td class="px-3">
                                                    <div class="fw-bold">{{ $booking->user->name }}</div>
                                                    <div class="small text-secondary">{{ $booking->user->phone }}</div>
                                                </td>
                                                <td>
                                                    <div class="fw-bold">{{ $booking->vehicle->make }} {{ $booking->vehicle->model }}</div>
                                                </td>
                                                <td class="small fw-500">
                                                    {{ $booking->start_date->format('M d') }} - {{ $booking->end_date->format('M d') }}
                                                </td>
                                                <td class="fw-bold text-dark">{{ $booking->total_amount }} MAD</td>
                                                <td>
                                                    <span class="badge rounded-pill bg-{{ $booking->status == 'confirmed' ? 'success' : 'warning' }} bg-opacity-10 text-{{ $booking->status == 'confirmed' ? 'success' : 'warning' }} px-3 py-2">
                                                        {{ strtoupper($booking->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-5 text-secondary">No recent reservations.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Side Widgets -->
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-primary text-white">
                            <h6 class="fw-bold mb-3">Pending Action</h6>
                            <p class="small opacity-75 mb-4">You have <strong>{{ $stats['pending_bookings'] }}</strong> new reservations waiting for confirmation.</p>
                            <a href="#" class="btn btn-premium w-100 fw-bold">REVIEW NOW</a>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4 p-4">
                            <h6 class="fw-bold mb-3">Quick Actions</h6>
                            <div class="d-grid gap-2">
                                <a href="{{ route('agency.vehicles.create') }}" class="btn btn-outline-dark text-start py-3 px-4 rounded-3 d-flex justify-content-between align-items-center">
                                    <span>Add New Vehicle</span>
                                    <i class="bi bi-plus-circle"></i>
                                </a>
                                <a href="#" class="btn btn-outline-dark text-start py-3 px-4 rounded-3 d-flex justify-content-between align-items-center">
                                    <span>Download Report</span>
                                    <i class="bi bi-file-earmark-pdf"></i>
                                </a>
                            </div>
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
    .bg-soft-blue { background: #eef2ff; }
    .bg-soft-green { background: #f0fdf4; }
    .hover-bg-light:hover { background-color: var(--soft-gray); color: var(--primary-black) !important; }
</style>
@endpush
@endsection
