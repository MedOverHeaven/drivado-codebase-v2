@extends('layouts.main')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center py-5">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4 p-md-5">
                <div class="text-center mb-5">
                    <h2 class="fw-bold">Créer un compte</h2>
                    <p class="text-secondary">Rejoignez la plateforme de location de voitures premium</p>
                </div>

                <form action="{{ url('/register') }}" method="POST">
                    @csrf
                    
                    <div class="row g-3 mb-4">
                        <div class="col-md-12">
                            <label class="form-label fw-bold small text-uppercase">Type de compte</label>
                            <div class="d-flex gap-3">
                                <div class="flex-fill">
                                    <input type="radio" class="btn-check" name="role" id="role-user" value="user" checked>
                                    <label class="btn btn-outline-dark w-100 py-2 fw-bold" for="role-user">Je suis un Client</label>
                                </div>
                                <div class="flex-fill">
                                    <input type="radio" class="btn-check" name="role" id="role-agency" value="agency">
                                    <label class="btn btn-outline-dark w-100 py-2 fw-bold" for="role-agency">Je suis une Agence</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase">Nom complet</label>
                        <input type="text" name="name" class="form-control form-control-lg" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase">Adresse E-mail</label>
                        <input type="email" name="email" class="form-control form-control-lg" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase">Numéro de téléphone</label>
                        <input type="text" name="phone" class="form-control form-control-lg" required>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Mot de passe</label>
                            <input type="password" name="password" class="form-control form-control-lg" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Confirmer</label>
                            <input type="password" name="password_confirmation" class="form-control form-control-lg" required>
                        </div>
                    </div>

                    <!-- Agency Specific Fields (Hidden by default) -->
                    <div id="agency-fields" style="display: none;">
                        <hr class="my-4">
                        <h6 class="fw-bold mb-3">Informations de l'Agence</h6>
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase">Nom de l'Agence</label>
                            <input type="text" name="agency_name" class="form-control form-control-lg">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase">Identifiant Légal (SIRET/ICE)</label>
                            <input type="text" name="legal_id" class="form-control form-control-lg">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase">Ville</label>
                            <input type="text" name="city" class="form-control form-control-lg">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-dark btn-lg w-100 fw-bold py-3 mb-4 mt-2">CRÉER LE COMPTE</button>

                    <div class="text-center">
                        <p class="text-secondary small mb-0">Vous avez déjà un compte ? <a href="{{ url('/login') }}" class="text-dark fw-bold text-decoration-none">Se connecter ici</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleUser = document.getElementById('role-user');
        const roleAgency = document.getElementById('role-agency');
        const agencyFields = document.getElementById('agency-fields');

        roleUser.addEventListener('change', () => agencyFields.style.display = 'none');
        roleAgency.addEventListener('change', () => agencyFields.style.display = 'block');
    });
</script>
@endpush
@endsection
