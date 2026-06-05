@extends('layouts.main')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('agency.vehicles') }}" class="btn btn-link text-dark me-3"><i class="bi bi-arrow-left fs-4"></i></a>
                <h3 class="fw-bold mb-0">Add New Vehicle</h3>
            </div>

            <div class="card border-0 shadow-sm p-4 p-md-5">
                <form action="{{ route('agency.vehicles.store') }}" method="POST">
                    @csrf
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Make</label>
                            <input type="text" name="make" class="form-control" placeholder="e.g. Dacia" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Model</label>
                            <input type="text" name="model" class="form-control" placeholder="e.g. Logan" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Year</label>
                            <input type="number" name="year" class="form-control" value="{{ date('Y') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Category</label>
                            <select name="category" class="form-select" required>
                                <option value="suv">SUV</option>
                                <option value="sedan">Sedan</option>
                                <option value="city">City Car</option>
                                <option value="utility">Utility</option>
                                <option value="luxury">Luxury</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Price Per Day (MAD)</label>
                            <div class="input-group">
                                <input type="number" name="price_per_day" class="form-control" step="0.01" required>
                                <span class="input-group-text">MAD</span>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold small text-uppercase">Description</label>
                            <textarea name="description" class="form-control" rows="5" placeholder="Describe the vehicle's features, condition, etc." required></textarea>
                        </div>

                        <div class="col-12">
                            <hr class="my-4">
                            <div class="d-flex justify-content-end gap-3">
                                <a href="{{ route('agency.vehicles') }}" class="btn btn-light px-4 fw-bold">CANCEL</a>
                                <button type="submit" class="btn btn-dark px-5 fw-bold">SAVE VEHICLE</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
