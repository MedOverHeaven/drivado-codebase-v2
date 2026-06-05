@extends('layouts.main')

@section('content')
<div class="dashboard-wrapper bg-light min-vh-100 pt-5 mt-5">
    <div class="container py-5">
        <div class="row g-4">
            <!-- Sidebar Navigation -->
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm p-4 rounded-4 sticky-top" style="top: 100px;">
                    <div class="text-center mb-4 pb-2">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px; font-weight: 800; font-size: 1.5rem;">
                            AD
                        </div>
                        <h5 class="fw-bold mb-1">Administrator</h5>
                        <p class="text-secondary small mb-0">Platform Controller</p>
                    </div>
                    
                    <div class="nav flex-column gap-2">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link px-3 py-2 rounded-3 {{ Request::is('admin/dashboard') ? 'bg-dark text-white active' : 'text-secondary hover-bg-light' }}">
                            <i class="bi bi-speedometer2 me-2"></i> Command Center
                        </a>
                        <a href="{{ route('admin.agencies') }}" class="nav-link px-3 py-2 rounded-3 {{ Request::is('admin/agencies*') ? 'bg-dark text-white active' : 'text-secondary hover-bg-light' }}">
                            <i class="bi bi-shop me-2"></i> Agency Moderation
                        </a>
                        <a href="#" class="nav-link px-3 py-2 rounded-3 text-secondary hover-bg-light">
                            <i class="bi bi-people-fill me-2"></i> User Directory
                        </a>
                        <a href="#" class="nav-link px-3 py-2 rounded-3 text-secondary hover-bg-light">
                            <i class="bi bi-cash-stack me-2"></i> Commissions
                        </a>
                        <hr class="my-3 opacity-10">
                        <a href="#" class="nav-link px-3 py-2 rounded-3 text-secondary hover-bg-light">
                            <i class="bi bi-gear-fill me-2"></i> System Settings
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-800 mb-0">Platform Overview</h3>
                    <div class="badge bg-white text-dark shadow-sm px-3 py-2 rounded-pill fw-bold">SYSTEM STATUS: OPTIMAL</div>
                </div>

                <!-- Stats Grid -->
                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm p-4 rounded-4 h-100">
                            <span class="text-secondary small fw-bold text-uppercase mb-3 d-block">Agencies</span>
                            <h2 class="fw-800 mb-1">{{ $stats['total_agencies'] }}</h2>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-warning bg-opacity-10 text-warning px-2 py-1 small rounded-pill">{{ $stats['pending_agencies'] }} Pending</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm p-4 rounded-4 h-100">
                            <span class="text-secondary small fw-bold text-uppercase mb-3 d-block">Marketplace Users</span>
                            <h2 class="fw-800 mb-1">{{ $stats['total_users'] }}</h2>
                            <p class="small text-success mb-0"><i class="bi bi-graph-up"></i> +8% Growth</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm p-4 rounded-4 h-100 bg-success text-white">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <span class="text-white-50 small fw-bold text-uppercase mb-3 d-block">Net Commissions</span>
                                    <h2 class="fw-800 mb-0">{{ number_format($stats['total_revenue'], 2) }} MAD</h2>
                                </div>
                                <div class="bg-white bg-opacity-20 p-3 rounded-circle">
                                    <i class="bi bi-bank fs-3"></i>
                                </div>
                            </div>
                            <p class="small text-white-50 mt-3 mb-0">Total earnings from <strong>{{ $stats['total_bookings'] }}</strong> completed bookings</p>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0">Recent Agency Signups</h5>
                        <a href="{{ route('admin.agencies') }}" class="btn btn-dark btn-sm px-4 fw-bold rounded-pill">MANAGE ALL</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr class="small text-uppercase text-secondary fw-bold">
                                    <th class="border-0 px-3 py-3">Agency Name</th>
                                    <th class="border-0 py-3">Representative</th>
                                    <th class="border-0 py-3">Location</th>
                                    <th class="border-0 py-3">Status</th>
                                    <th class="border-0 py-3 text-end">Review</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_agencies as $agency)
                                    <tr>
                                        <td class="px-3 fw-bold">{{ $agency->agency_name }}</td>
                                        <td>{{ $agency->user->name }}</td>
                                        <td>{{ $agency->city }}</td>
                                        <td>
                                            <span class="badge rounded-pill bg-{{ $agency->status == 'approved' ? 'success' : ($agency->status == 'pending' ? 'warning' : 'danger') }} bg-opacity-10 text-{{ $agency->status == 'approved' ? 'success' : ($agency->status == 'pending' ? 'warning' : 'danger') }} px-3 py-2">
                                                {{ strtoupper($agency->status) }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.agencies') }}" class="btn btn-sm btn-outline-dark rounded-circle p-2" title="View Detail">
                                                <i class="bi bi-arrow-right"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">No recent signups.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .fw-800 { font-weight: 800; }
    .hover-bg-light:hover { background-color: var(--soft-gray); color: var(--primary-black) !important; }
</style>
@endpush
@endsection
