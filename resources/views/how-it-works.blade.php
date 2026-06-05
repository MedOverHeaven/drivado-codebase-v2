@extends('layouts.main')

@section('content')
<!-- Hero Section -->
<section class="how-it-works-hero position-relative overflow-hidden" style="background: var(--primary-black); padding: 12rem 0 8rem;">
    <!-- Large Background Shield -->
    <div class="position-absolute top-50 start-50 translate-middle d-none d-lg-block" style="margin-left: -480px; opacity: 0.05; z-index: 0;">
        <i class="bi bi-shield-check" style="font-size: 15rem; color: white;"></i>
    </div>

    <div class="container position-relative z-1 text-center text-white">
        <div class="mb-4">
            <span class="badge rounded-pill bg-white text-dark fw-bold px-3 py-2 animate__animated animate__fadeInDown">TRANSPARENT & SÉCURISÉ</span>
        </div>
        <h1 class="hero-title mb-4 animate__animated animate__fadeInUp" style="font-size: 4rem;">La Location <br><span class="text-secondary">Remarquable.</span></h1>
        <p class="lead mb-0 opacity-75 animate__animated animate__fadeInUp animate__delay-1s mx-auto" style="max-width: 600px;">Tout ce que vous devez savoir sur l'expérience Drivado, de la découverte à la route.</p>
    </div>
</section>

<!-- Process for Renters -->
<section class="py-5 bg-white">
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="text-uppercase fw-bold text-secondary small letter-spacing-2">Le Voyage</span>
                <h2 class="section-title mb-4">Comment Louer un Véhicule</h2>
                <p class="text-secondary mb-5">Notre plateforme vous connecte avec les meilleures agences locales d'Oujda. Voici comment vous pouvez prendre le volant de votre prochaine voiture préférée.</p>
                
                <div class="d-flex gap-4 mb-5 animate__animated animate__fadeInLeft">
                    <div class="flex-shrink-0">
                        <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center fw-bold" style="width: 50px; height: 50px; font-size: 1.25rem;">1</div>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-2">Rechercher & Comparer</h5>
                        <p class="text-secondary mb-0">Explorez notre flotte exclusive de véhicules de luxe et quotidiens. Utilisez des filtres avancés pour trouver la correspondance parfaite pour vos besoins et votre budget.</p>
                    </div>
                </div>

                <div class="d-flex gap-4 mb-5 animate__animated animate__fadeInLeft">
                    <div class="flex-shrink-0">
                        <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center fw-bold" style="width: 50px; height: 50px; font-size: 1.25rem;">2</div>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-2">Sécurisez Votre Réservation</h5>
                        <p class="text-secondary mb-0">Sélectionnez vos dates et réservez instantanément. Notre plateforme gère la coordination avec l'agence, garantissant que votre véhicule est prêt quand vous l'êtes.</p>
                    </div>
                </div>

                <div class="d-flex gap-4 animate__animated animate__fadeInLeft">
                    <div class="flex-shrink-0">
                        <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center fw-bold" style="width: 50px; height: 50px; font-size: 1.25rem;">3</div>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-2">Récupérer & Conduire</h5>
                        <p class="text-secondary mb-0">Recevez immédiatement les coordonnées de l'agence et sa localisation précise. Rencontrez le représentant, vérifiez la voiture et profitez de votre trajet.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&q=80&w=1000" class="img-fluid rounded-5 shadow-lg" alt="Renting experience">
                    <div class="position-absolute bottom-0 start-0 m-4 p-4 bg-white rounded-4 shadow-lg d-none d-md-block animate__animated animate__fadeInUp">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-success text-white rounded-circle p-2"><i class="bi bi-shield-lock-fill fs-4"></i></div>
                            <div>
                                <h6 class="fw-bold mb-0">100% Sécurisé</h6>
                                <p class="small text-secondary mb-0">Paiements & Agences Vérifiés</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- For Agencies Section -->
<section class="py-5 bg-soft-gray">
    <div class="container py-5">
        <div class="row align-items-center g-5 flex-row-reverse">
            <div class="col-lg-6">
                <span class="text-uppercase fw-bold text-secondary small letter-spacing-2">Partenaire Drivado</span>
                <h2 class="section-title mb-4">Développez Votre Agence de Location</h2>
                <p class="text-secondary mb-5">Drivado est plus qu'une simple plateforme ; c'est un moteur de croissance pour votre entreprise locale. Touchez des milliers de clients et gérez votre flotte avec des outils professionnels.</p>
                
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card border-0 p-4 rounded-4 shadow-sm h-100">
                            <i class="bi bi-graph-up-arrow text-primary fs-2 mb-3"></i>
                            <h6 class="fw-bold mb-2">Visibilité Accrue</h6>
                            <p class="small text-secondary mb-0">Ne vous souciez plus du marketing. Nous présentons votre flotte chaque jour à des clients qualifiés.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 p-4 rounded-4 shadow-sm h-100">
                            <i class="bi bi-laptop text-primary fs-2 mb-3"></i>
                            <h6 class="fw-bold mb-2">Gestion de Flotte</h6>
                            <p class="small text-secondary mb-0">Un tableau de bord dédié pour gérer vos disponibilités, vos tarifs et vos réservations en temps réel.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 p-4 rounded-4 shadow-sm h-100">
                            <i class="bi bi-cash-stack text-primary fs-2 mb-3"></i>
                            <h6 class="fw-bold mb-2">Paiements Automatisés</h6>
                            <p class="small text-secondary mb-0">Recevez vos paiements directement et en toute sécurité. Plus besoin de courir après les factures ou de gérer les risques.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 p-4 rounded-4 shadow-sm h-100">
                            <i class="bi bi-star text-primary fs-2 mb-3"></i>
                            <h6 class="fw-bold mb-2">Réputation Vérifiée</h6>
                            <p class="small text-secondary mb-0">Instaurez la confiance grâce à notre système d'avis vérifiés et obtenez le badge 'Drivado de Confiance'.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <div class="bg-dark text-white p-5 rounded-5 shadow-lg position-relative overflow-hidden">
                    <div class="position-relative z-1">
                        <h3 class="fw-bold mb-4">Commencez Dès Aujourd'hui</h3>
                        <p class="opacity-75 mb-5">Il faut moins de 10 minutes pour enregistrer votre agence et lister votre premier véhicule.</p>
                        <a href="{{ route('register') }}" class="btn btn-premium px-5 py-3 fw-bold">REJOINDRE EN TANT QU'AGENCE</a>
                    </div>
                    
                    <i class="bi bi-shop position-absolute" style="font-size: 12rem; transform: rotate(-20deg); bottom: -2rem; right: -2rem; opacity: 0.05; z-index: 0;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5 bg-white">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="section-title">Questions Fréquentes</h2>
            <p class="text-secondary mx-auto" style="max-width: 500px;">Tout ce que vous devez savoir sur les politiques de la plateforme.</p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion accordion-flush" id="faqAccordion">
                    <div class="accordion-item border-bottom py-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold fs-5 bg-white shadow-none text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                De quels documents ai-je besoin pour louer ?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-secondary">
                                Vous aurez généralement besoin d'un permis de conduire valide (d'au moins 2 ans), d'une carte d'identité nationale ou d'un passeport, et d'une carte bancaire pour le dépôt de garantie. Les exigences peuvent varier légèrement d'une agence à l'autre.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-bottom py-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold fs-5 bg-white shadow-none text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                L'assurance est-elle incluse dans le prix ?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-secondary">
                                Tous les tarifs affichés incluent l'assurance responsabilité civile de base. De nombreuses agences proposent des garanties complémentaires optionnelles (CDW, protection contre le vol) lors de la prise en charge du véhicule.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-bottom py-3">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold fs-5 bg-white shadow-none text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Comment fonctionnent les frais de plateforme ?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-secondary">
                                Drivado prélève une commission transparente de 10 % sur le sous-total de la réservation. Ces frais couvrent la protection de la plateforme, le traitement sécurisé des paiements et l'assistance client 24h/24.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<style>
    .letter-spacing-2 { letter-spacing: 2px; }
    .bg-soft-gray { background-color: var(--soft-gray); }
    .accordion-button:after {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23212529'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
    }

</style>
@endpush
@endsection
