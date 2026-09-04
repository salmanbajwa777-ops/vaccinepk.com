<?php
/**
 * Template Name: Book Vaccination
 * Description: Standalone booking page with category selection
 */
get_header();
?>

<!-- ================= PAGE HEADER ================= -->
<section class="page-header" style="background: linear-gradient(160deg, var(--color-navy) 0%, #0e3446 55%, var(--color-navy) 100%); padding: 80px 0 60px; position: relative; overflow: hidden;">
    <div style="position: absolute; top: -50%; right: -10%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(201, 162, 75, 0.14) 0%, transparent 70%); border-radius: 50%;"></div>
    <div style="position: absolute; bottom: -30%; left: -5%; width: 400px; height: 400px; background: radial-gradient(circle, rgba(107, 182, 63, 0.12) 0%, transparent 70%); border-radius: 50%;"></div>

    <div class="container" style="position: relative; z-index: 1;">
        <div class="row">
            <div class="col-lg-10 mx-auto text-center">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb justify-content-center" style="background: transparent;">
                        <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>" style="color: var(--color-sub-on-blue); text-decoration: none;"><i class="bi bi-house-fill"></i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: var(--color-ivory);">Book Vaccination</li>
                    </ol>
                </nav>
                <h1 class="display-4 fw-bold mb-3" style="color: var(--color-ivory);">Book Your Vaccination</h1>
                <p class="lead" style="color: var(--color-sub-on-blue);">Choose your vaccination category and schedule an appointment</p>
            </div>
        </div>
    </div>
</section>

<!-- ================= CATEGORY SELECTION CARDS ================= -->
<section class="py-5" style="background: white;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold" style="color: var(--color-navy);">Select Vaccination Service</h2>
            <p class="text-muted">Click on a category to book your appointment</p>
        </div>
        
        <div class="row g-4">
            <!-- Child Vaccination Card -->
            <div class="col-lg-6">
                <div class="booking-category-card" data-category="child">
                    <div class="card-photo">
                        <img src="https://images.unsplash.com/photo-1612277795421-9bc7706a4a34?auto=format&fit=crop&w=1000&q=80"
                             alt="Child Vaccination">
                        <div class="pulse-indicator"></div>
                        <i class="bi bi-heart-pulse-fill card-icon"></i>
                    </div>
                    <div class="card-plate">
                        <h2 class="fw-bold mb-3 display-6">Child Vaccination</h2>
                        <p class="mb-4 fs-5">Complete immunization schedule for infants and children following WHO & EPI guidelines.</p>
                        <div class="d-flex flex-wrap gap-3 mb-4">
                            <span class="badge bg-white text-dark px-3 py-2"><i class="bi bi-calendar-event"></i> Birth to 18 years</span>
                            <span class="badge bg-white text-dark px-3 py-2"><i class="bi bi-house-heart"></i> Home service available</span>
                            <span class="badge bg-white text-dark px-3 py-2"><i class="bi bi-shield-check"></i> WHO compliant</span>
                        </div>
                        <button class="btn btn-lg px-5 fw-bold" style="border-radius: 50px; background: #c9a24b; color: #0a2a38;">
                            Book Child Vaccination <i class="bi bi-arrow-right-circle-fill ms-2"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Adult Vaccination Card -->
            <div class="col-lg-6">
                <div class="booking-category-card" data-category="adult">
                    <div class="card-photo">
                        <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=1000&q=80"
                             alt="Adult Vaccination">
                        <div class="pulse-indicator"></div>
                        <i class="bi bi-person-hearts card-icon"></i>
                    </div>
                    <div class="card-plate">
                        <h2 class="fw-bold mb-3 display-6">Adult Vaccination</h2>
                        <p class="mb-4 fs-5">Essential immunizations for adults including boosters and preventive vaccines.</p>
                        <div class="d-flex flex-wrap gap-3 mb-4">
                            <span class="badge bg-white text-dark px-3 py-2"><i class="bi bi-people"></i> 18+ years</span>
                            <span class="badge bg-white text-dark px-3 py-2"><i class="bi bi-clipboard2-pulse"></i> Health screening</span>
                            <span class="badge bg-white text-dark px-3 py-2"><i class="bi bi-award"></i> Expert care</span>
                        </div>
                        <button class="btn btn-lg px-5 fw-bold" style="border-radius: 50px; background: #c9a24b; color: #0a2a38;">
                            Book Adult Vaccination <i class="bi bi-arrow-right-circle-fill ms-2"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Flu Vaccination Card -->
            <div class="col-lg-6">
                <div class="booking-category-card" data-category="flu">
                    <div class="card-photo">
                        <img src="https://images.unsplash.com/photo-1584820927498-cfe5211fd8bf?auto=format&fit=crop&w=1000&q=80"
                             alt="Flu Vaccination">
                        <div class="pulse-indicator"></div>
                        <i class="bi bi-shield-fill-plus card-icon"></i>
                    </div>
                    <div class="card-plate">
                        <h2 class="fw-bold mb-3 display-6">Flu Vaccination</h2>
                        <p class="mb-4 fs-5">Seasonal flu protection for all ages. Protect yourself and your loved ones.</p>
                        <div class="d-flex flex-wrap gap-3 mb-4">
                            <span class="badge bg-white text-dark px-3 py-2"><i class="bi bi-circle"></i> All ages</span>
                            <span class="badge bg-white text-dark px-3 py-2"><i class="bi bi-calendar3"></i> Annual dose</span>
                            <span class="badge bg-white text-dark px-3 py-2"><i class="bi bi-star"></i> Quick service</span>
                        </div>
                        <button class="btn btn-lg px-5 fw-bold" style="border-radius: 50px; background: #c9a24b; color: #0a2a38;">
                            Book Flu Vaccination <i class="bi bi-arrow-right-circle-fill ms-2"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Travel Vaccination Card -->
            <div class="col-lg-6">
                <div class="booking-category-card" data-category="travel">
                    <div class="card-photo">
                        <img src="https://images.unsplash.com/photo-1436491865332-7a61a109cc05?auto=format&fit=crop&w=1000&q=80"
                             alt="Travel Vaccination">
                        <div class="pulse-indicator"></div>
                        <i class="bi bi-airplane-fill card-icon"></i>
                    </div>
                    <div class="card-plate">
                        <h2 class="fw-bold mb-3 display-6">Travel Vaccination</h2>
                        <p class="mb-4 fs-5">Pre-travel immunizations for domestic and international destinations.</p>
                        <div class="d-flex flex-wrap gap-3 mb-4">
                            <span class="badge bg-white text-dark px-3 py-2"><i class="bi bi-globe"></i> All destinations</span>
                            <span class="badge bg-white text-dark px-3 py-2"><i class="bi bi-file-earmark-medical"></i> Verified</span>
                            <span class="badge bg-white text-dark px-3 py-2"><i class="bi bi-clock"></i> Same day service</span>
                        </div>
                        <button class="btn btn-lg px-5 fw-bold" style="border-radius: 50px; background: #c9a24b; color: #0a2a38;">
                            Book Travel Vaccination <i class="bi bi-arrow-right-circle-fill ms-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Handle category card clicks — navigate to each category's own booking page
    const categoryUrls = {
        'child':  '<?php echo home_url( '/book-child-vaccination' ); ?>',
        'adult':  '<?php echo home_url( '/book-adult-vaccination' ); ?>',
        'flu':    '<?php echo home_url( '/flu' ); ?>',
        'travel': '<?php echo home_url( '/book-travel-vaccination' ); ?>'
    };

    document.querySelectorAll('.booking-category-card').forEach(card => {
        card.addEventListener('click', function() {
            const category = this.getAttribute('data-category');
            if (categoryUrls[category]) {
                window.location.href = categoryUrls[category];
            }
        });
        
        // Enhanced hover effects
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px)';
            this.style.boxShadow = '0 25px 70px rgba(10,42,56,0.28)';
            const img = this.querySelector('img');
            if (img) img.style.transform = 'scale(1.08)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 15px 50px rgba(10,42,56,0.15)';
            const img = this.querySelector('img');
            if (img) img.style.transform = 'scale(1)';
        });
    });
});
</script>

<!-- Styles -->
<style>
@keyframes pulse {
    0%, 100% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.5);
        opacity: 0.5;
    }
}

.booking-category-card {
    cursor: pointer;
    display: flex;
    flex-direction: column;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 15px 50px rgba(10, 42, 56, 0.15);
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    will-change: transform;
    height: 100%;
}

.booking-category-card .card-photo {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.booking-category-card .card-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s;
}

.booking-category-card .card-icon {
    position: absolute;
    bottom: 16px;
    left: 20px;
    font-size: 40px;
    color: #fff;
    opacity: 0.95;
    text-shadow: 0 2px 10px rgba(10, 24, 32, 0.5);
}

.booking-category-card .pulse-indicator {
    position: absolute;
    top: 20px;
    right: 20px;
    width: 14px;
    height: 14px;
    background: #6bb63f;
    border-radius: 50%;
    box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.5);
    animation: pulse 2s infinite;
}

.booking-category-card .card-plate {
    flex: 1;
    background: var(--color-navy, #0a2a38);
    color: #fff;
    padding: 32px 40px 36px;
    display: flex;
    flex-direction: column;
}

.booking-category-card .card-plate .display-6 {
    color: #fff;
}

.booking-category-card .card-plate p {
    color: rgba(246, 243, 236, 0.82);
}

@media (max-width: 576px) {
    .booking-category-card .card-photo {
        height: 160px;
    }

    .booking-category-card .card-plate {
        padding: 24px;
    }

    .booking-category-card .display-6 {
        font-size: 1.5rem !important;
    }

    .booking-category-card .fs-5 {
        font-size: 0.95rem !important;
    }

    .booking-category-card .card-icon {
        font-size: 32px;
    }

    .booking-category-card .badge {
        font-size: 0.75rem !important;
    }

    .booking-category-card .btn-lg {
        padding: 10px 24px !important;
        font-size: 0.95rem !important;
    }
}
</style>

<?php get_footer(); ?>
