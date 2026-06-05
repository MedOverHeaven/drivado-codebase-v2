@extends('layouts.main')

@section('content')
<div class="dashboard-wrapper bg-light min-vh-100 pt-5 mt-5">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-800 mb-1">Agency Moderation</h3>
                <p class="text-secondary mb-0">Review and manage rental agency applications.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark rounded-pill px-4 fw-bold">
                <i class="bi bi-arrow-left me-2"></i> BACK TO DASHBOARD
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-dark text-white">
                        <tr class="small text-uppercase fw-bold">
                            <th class="border-0 px-4 py-3">Agency Details</th>
                            <th class="border-0 py-3">Legal Info</th>
                            <th class="border-0 py-3">Location</th>
                            <th class="border-0 py-3">Current Status</th>
                            <th class="border-0 py-3 text-end px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($agencies as $agency)
                            <tr>
                                <td class="px-4 py-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-soft-gray rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; font-weight: 800;">
                                            {{ substr($agency->agency_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $agency->agency_name }}</div>
                                            <div class="small text-secondary">{{ $agency->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="small fw-bold text-dark">ID: {{ $agency->legal_id }}</div>
                                    <div class="small text-secondary">Registered: {{ $agency->created_at->format('M d, Y') }}</div>
                                </td>
                                <td>
                                    <div class="small"><i class="bi bi-geo-alt me-1"></i> {{ $agency->city }}</div>
                                    <div class="small text-secondary text-truncate" style="max-width: 150px;">{{ $agency->address }}</div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill bg-{{ $agency->status == 'approved' ? 'success' : ($agency->status == 'pending' ? 'warning' : 'danger') }} bg-opacity-10 text-{{ $agency->status == 'approved' ? 'success' : ($agency->status == 'pending' ? 'warning' : 'danger') }} px-3 py-2">
                                        {{ strtoupper($agency->status) }}
                                    </span>
                                </td>
                                <td class="text-end px-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        @if($agency->status == 'pending')
                                            <form action="{{ route('admin.agencies.approve', $agency->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 fw-bold">APPROVE</button>
                                            </form>
                                            <form action="{{ route('admin.agencies.reject', $agency->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-bold">REJECT</button>
                                            </form>
                                        @elseif($agency->status == 'approved')
                                            <button class="btn btn-sm btn-light rounded-pill px-3 fw-bold disabled">APPROVED</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="opacity-50 mb-3"><i class="bi bi-inbox fs-1"></i></div>
                                    <h5 class="fw-bold">No agency applications found.</h5>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($agencies->hasPages())
                <div class="p-4 bg-white border-top">
                    {{ $agencies->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .fw-800 { font-weight: 800; }
    .bg-soft-gray { background-color: var(--soft-gray); }
</style>
@endpush
@endsection
