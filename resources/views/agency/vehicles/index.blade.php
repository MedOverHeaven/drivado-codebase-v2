@extends('layouts.main')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar (Reused) -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm p-4 mb-4">
                <ul class="nav flex-column gap-2">
                    <li class="nav-item">
                        <a class="nav-link text-secondary" href="{{ route('agency.dashboard') }}">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-bold text-dark" href="{{ route('agency.vehicles') }}">
                            <i class="bi bi-car-front me-2"></i> My Fleet
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-secondary" href="#">
                            <i class="bi bi-calendar-check me-2"></i> Reservations
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold mb-0">My Fleet</h3>
                <a href="{{ route('agency.vehicles.create') }}" class="btn btn-dark fw-bold px-4">
                    <i class="bi bi-plus-lg me-2"></i> ADD NEW VEHICLE
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success border-0 mb-4">{{ session('success') }}</div>
            @endif

            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Vehicle</th>
                                <th>Category</th>
                                <th>Daily Price</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vehicles as $vehicle)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&q=80&w=80" class="rounded me-3" alt="">
                                            <div>
                                                <div class="fw-bold">{{ $vehicle->make }} {{ $vehicle->model }}</div>
                                                <div class="text-secondary small">{{ $vehicle->year }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-light text-dark text-uppercase small">{{ $vehicle->category }}</span></td>
                                    <td><span class="fw-bold">{{ $vehicle->price_per_day }} MAD</span></td>
                                    <td>
                                        @if($vehicle->is_available)
                                            <span class="badge bg-success px-2">Available</span>
                                        @else
                                            <span class="badge bg-secondary px-2">Unavailable</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-sm btn-outline-dark"><i class="bi bi-pencil"></i></a>
                                            <form action="#" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this vehicle?')"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <p class="text-secondary mb-3">No vehicles found in your fleet.</p>
                                        <a href="{{ route('agency.vehicles.create') }}" class="btn btn-dark fw-bold">Add Your First Vehicle</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-4">
                {{ $vehicles->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
