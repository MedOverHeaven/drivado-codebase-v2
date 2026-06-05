<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="DRIVADO - La plateforme de location de voitures premium pour vos trajets quotidiens et de luxe.">
    <title>{{ config('app.name', 'DRIVADO') }} | Location de Voitures Premium</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    
    <!-- Vite: CSS & JS -->
    @vite(['resources/css/index.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <div class="logo-container d-flex align-items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="DRIVADO Logo" class="logo-car-img me-3">
                    <span class="logo-text">DRIVADO</span>
                </div>
            </a>
            <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="bi bi-list fs-1"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Aperçu</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/agencies*') ? 'active' : '' }}" href="{{ route('admin.agencies') }}">Agences</a>
                            </li>
                            <li class="nav-item ms-lg-3">
                                <a class="btn btn-outline-light btn-sm px-3 opacity-75" href="{{ url('/') }}">Voir la Marketplace</a>
                            </li>
                        @elseif(Auth::user()->role === 'agency')
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('agency/dashboard') ? 'active' : '' }}" href="{{ route('agency.dashboard') }}">Tableau de bord</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('agency/vehicles*') ? 'active' : '' }}" href="{{ route('agency.vehicles') }}">Ma Flotte</a>
                            </li>
                            <li class="nav-item ms-lg-3">
                                <a class="btn btn-outline-light btn-sm px-3 opacity-75" href="{{ url('/') }}">Voir la Marketplace</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ url('/') }}">Accueil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('search*') ? 'active' : '' }}" href="{{ url('/search') }}">Flotte</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('how-it-works') ? 'active' : '' }}" href="{{ route('how-it-works') }}">Comment ça marche</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ url('/') }}">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('search*') ? 'active' : '' }}" href="{{ url('/search') }}">Flotte</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('how-it-works') ? 'active' : '' }}" href="{{ route('how-it-works') }}">Comment ça marche</a>
                        </li>
                    @endauth

                    @guest
                        <li class="nav-item ms-lg-4">
                            <a class="nav-link" href="{{ route('login') }}">Se connecter</a>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <a class="btn btn-premium px-4" href="{{ route('register') }}">Rejoindre Drivado</a>
                        </li>
                    @else
                        <li class="nav-item dropdown ms-lg-4">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-2 fs-5"></i>
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 mt-3">
                                <li>
                                    @if(Auth::user()->role === 'admin')
                                        <a class="dropdown-item py-2" href="{{ route('admin.dashboard') }}">Tableau de bord Admin</a>
                                    @elseif(Auth::user()->role === 'agency')
                                        <a class="dropdown-item py-2" href="{{ route('agency.dashboard') }}">Tableau de bord Agence</a>
                                    @else
                                        <a class="dropdown-item py-2" href="#">Mes Réservations</a>
                                    @endif
                                </li>
                                <li><a class="dropdown-item py-2" href="#">Paramètres</a></li>
                                <li><hr class="dropdown-divider opacity-50"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item py-2 text-danger">Se déconnecter</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div class="main-wrapper">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4">
                    <div class="footer-logo d-flex align-items-center mb-4">
                        <div class="logo-container d-flex align-items-center">
                            <img src="{{ asset('images/logo.png') }}" alt="DRIVADO Logo" class="logo-car-img-footer me-3">
                            <span class="logo-text-footer">DRIVADO</span>
                        </div>
                    </div>
                    <p class="text-secondary mb-4">DRIVADO est la première plateforme de mise en relation entre agences de location de voitures et particuliers, dans un environnement sécurisé, professionnel et transparent.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle p-2"><i class="bi bi-facebook fs-5"></i></a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle p-2"><i class="bi bi-instagram fs-5"></i></a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle p-2"><i class="bi bi-twitter-x fs-5"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 offset-lg-1">
                    <h6 class="text-white fw-bold mb-4">Marketplace</h6>
                    <a href="{{ url('/search') }}" class="footer-link">Parcourir la Flotte</a>
                    <a href="#" class="footer-link">Offres Spéciales</a>
                    <a href="#" class="footer-link">Agences Vérifiées</a>
                    <a href="#" class="footer-link">Sécurité & Assurance</a>
                </div>
                <div class="col-lg-2">
                    <h6 class="text-white fw-bold mb-4">Entreprise</h6>
                    <a href="#" class="footer-link">À propos de nous</a>
                    <a href="#" class="footer-link">Politique de confidentialité</a>
                    <a href="#" class="footer-link">Conditions d'utilisation</a>
                    <a href="#" class="footer-link">Contacter le Support</a>
                </div>
                <div class="col-lg-3">
                    <h6 class="text-white fw-bold mb-4">Devenir Partenaire</h6>
                    <p class="text-secondary small mb-4">Êtes-vous une agence de location de voitures ? Touchez des milliers de clients en rejoignant notre plateforme.</p>
                    <a href="{{ route('register') }}" class="btn btn-outline-light w-100 fw-bold">ENREGISTRER L'AGENCE</a>
                </div>
            </div>
            <hr class="my-5 opacity-10">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center text-secondary small">
                <p class="mb-0">&copy; {{ date('Y') }} Plateforme DRIVADO. Tous droits réservés.</p>
                <div class="mt-3 mt-md-0">
                    <span class="me-3">ENSAO MGSI-3 Project</span>
                    <span>v1.0 Premium</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>
