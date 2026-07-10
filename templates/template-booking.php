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
                <div class="booking-category-card" data-category="child" style="cursor: pointer; position: relative; border-radius: 24px; overflow: hidden; height: 400px; box-shadow: 0 15px 50px rgba(0,0,0,0.15); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
                    <img src="https://images.unsplash.com/photo-1612277795421-9bc7706a4a34?auto=format&fit=crop&w=1000&q=80" 
                         alt="Child Vaccination" 
                         style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s;">
                    <div class="card-overlay" style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(10, 24, 32, 0.92) 0%, rgba(10, 24, 32, 0.55) 35%, rgba(10, 24, 32, 0.05) 65%, rgba(10, 24, 32, 0) 100%); display: flex; flex-direction: column; justify-content: flex-end; padding: 40px;">
                        <div class="text-white">
                            <div class="mb-4">
                                <i class="bi bi-heart-pulse-fill" style="font-size: 64px; opacity: 0.9;"></i>
                            </div>
                            <h2 class="fw-bold mb-3 display-6" style="text-shadow: 0 2px 14px rgba(0,0,0,0.45);">Child Vaccination</h2>
                            <p class="mb-4 fs-5" style="opacity: 0.95; text-shadow: 0 1px 8px rgba(0,0,0,0.4);">Complete immunization schedule for infants and children following WHO & EPI guidelines.</p>
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
                    <div class="pulse-indicator" style="position: absolute; top: 30px; right: 30px; width: 20px; height: 20px; background: #6bb63f; border-radius: 50%; animation: pulse 2s infinite;"></div>
                </div>
            </div>

            <!-- Adult Vaccination Card -->
            <div class="col-lg-6">
                <div class="booking-category-card" data-category="adult" style="cursor: pointer; position: relative; border-radius: 24px; overflow: hidden; height: 400px; box-shadow: 0 15px 50px rgba(0,0,0,0.15); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
                    <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=1000&q=80" 
                         alt="Adult Vaccination" 
                         style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s;">
                    <div class="card-overlay" style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(10, 24, 32, 0.92) 0%, rgba(10, 24, 32, 0.55) 35%, rgba(10, 24, 32, 0.05) 65%, rgba(10, 24, 32, 0) 100%); display: flex; flex-direction: column; justify-content: flex-end; padding: 40px;">
                        <div class="text-white">
                            <div class="mb-4">
                                <i class="bi bi-person-hearts" style="font-size: 64px; opacity: 0.9;"></i>
                            </div>
                            <h2 class="fw-bold mb-3 display-6" style="text-shadow: 0 2px 14px rgba(0,0,0,0.45);">Adult Vaccination</h2>
                            <p class="mb-4 fs-5" style="opacity: 0.95; text-shadow: 0 1px 8px rgba(0,0,0,0.4);">Essential immunizations for adults including boosters and preventive vaccines.</p>
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
                    <div class="pulse-indicator" style="position: absolute; top: 30px; right: 30px; width: 20px; height: 20px; background: #6bb63f; border-radius: 50%; animation: pulse 2s infinite;"></div>
                </div>
            </div>

            <!-- Flu Vaccination Card -->
            <div class="col-lg-6">
                <div class="booking-category-card" data-category="flu" style="cursor: pointer; position: relative; border-radius: 24px; overflow: hidden; height: 400px; box-shadow: 0 15px 50px rgba(0,0,0,0.15); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
                    <img src="https://images.unsplash.com/photo-1584820927498-cfe5211fd8bf?auto=format&fit=crop&w=1000&q=80" 
                         alt="Flu Vaccination" 
                         style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s;">
                    <div class="card-overlay" style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(10, 24, 32, 0.92) 0%, rgba(10, 24, 32, 0.55) 35%, rgba(10, 24, 32, 0.05) 65%, rgba(10, 24, 32, 0) 100%); display: flex; flex-direction: column; justify-content: flex-end; padding: 40px;">
                        <div class="text-white">
                            <div class="mb-4">
                                <i class="bi bi-shield-fill-plus" style="font-size: 64px; opacity: 0.9;"></i>
                            </div>
                            <h2 class="fw-bold mb-3 display-6" style="text-shadow: 0 2px 14px rgba(0,0,0,0.45);">Flu Vaccination</h2>
                            <p class="mb-4 fs-5" style="opacity: 0.95; text-shadow: 0 1px 8px rgba(0,0,0,0.4);">Seasonal flu protection for all ages. Protect yourself and your loved ones.</p>
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
                    <div class="pulse-indicator" style="position: absolute; top: 30px; right: 30px; width: 20px; height: 20px; background: #6bb63f; border-radius: 50%; animation: pulse 2s infinite;"></div>
                </div>
            </div>

            <!-- Travel Vaccination Card -->
            <div class="col-lg-6">
                <div class="booking-category-card" data-category="travel" style="cursor: pointer; position: relative; border-radius: 24px; overflow: hidden; height: 400px; box-shadow: 0 15px 50px rgba(0,0,0,0.15); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
                    <img src="https://images.unsplash.com/photo-1436491865332-7a61a109cc05?auto=format&fit=crop&w=1000&q=80" 
                         alt="Travel Vaccination" 
                         style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s;">
                    <div class="card-overlay" style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(10, 24, 32, 0.92) 0%, rgba(10, 24, 32, 0.55) 35%, rgba(10, 24, 32, 0.05) 65%, rgba(10, 24, 32, 0) 100%); display: flex; flex-direction: column; justify-content: flex-end; padding: 40px;">
                        <div class="text-white">
                            <div class="mb-4">
                                <i class="bi bi-airplane-fill" style="font-size: 64px; opacity: 0.9;"></i>
                            </div>
                            <h2 class="fw-bold mb-3 display-6" style="text-shadow: 0 2px 14px rgba(0,0,0,0.45);">Travel Vaccination</h2>
                            <p class="mb-4 fs-5" style="opacity: 0.95; text-shadow: 0 1px 8px rgba(0,0,0,0.4);">Pre-travel immunizations for domestic and international destinations.</p>
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
                    <div class="pulse-indicator" style="position: absolute; top: 30px; right: 30px; width: 20px; height: 20px; background: #6bb63f; border-radius: 50%; animation: pulse 2s infinite;"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================= BOOKING FORM MODAL ================= -->
<div class="modal fade" id="bookingFormModal" tabindex="-1" aria-labelledby="bookingFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border: none; border-radius: 20px; overflow: hidden;">
            <div class="modal-header" style="background: #0a2a38; color: white; border: none; padding: 30px;">
                <div>
                    <h3 class="modal-title fw-bold mb-1" id="formCategoryTitle">
                        <i class="bi bi-clipboard2-pulse-fill me-2"></i>
                        Child Vaccination Booking
                    </h3>
                    <p class="mb-0 opacity-75 small">Complete the form below to schedule your appointment</p>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 40px; background: #f6f3ec;">
                <div id="form-container">
                    <!-- Form will be loaded here via AJAX -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Handle category card clicks
    document.querySelectorAll('.booking-category-card').forEach(card => {
        card.addEventListener('click', function() {
            const category = this.getAttribute('data-category');
            loadBookingForm(category);
            
            const formModal = new bootstrap.Modal(document.getElementById('bookingFormModal'));
            formModal.show();
        });
        
        // Enhanced hover effects
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-15px) scale(1.02)';
            this.style.boxShadow = '0 25px 70px rgba(0,0,0,0.25)';
            const img = this.querySelector('img');
            if (img) img.style.transform = 'scale(1.15) rotate(2deg)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.boxShadow = '0 15px 50px rgba(0,0,0,0.15)';
            const img = this.querySelector('img');
            if (img) img.style.transform = 'scale(1) rotate(0deg)';
        });
    });
    
    function loadBookingForm(category) {
        const formContainer = document.getElementById('form-container');
        const formTitle = document.getElementById('formCategoryTitle');
        
        const categoryTitles = {
            'child': 'Child Vaccination Booking',
            'adult': 'Adult Vaccination Booking',
            'flu': 'Flu Vaccination Booking',
            'travel': 'Travel Vaccination Booking'
        };
        
        const categoryIcons = {
            'child': 'heart-pulse-fill',
            'adult': 'person-hearts',
            'flu': 'shield-fill-plus',
            'travel': 'airplane-fill'
        };
        
        formTitle.innerHTML = `<i class="bi bi-${categoryIcons[category]} me-2"></i>${categoryTitles[category]}`;
        
        // Show loading spinner
        formContainer.innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-success" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-4 text-muted fw-bold">Loading your booking form...</p>
            </div>
        `;
        
        // Load form via WordPress AJAX (admin-ajax.php) — proper WordPress context
        const formData = new FormData();
        formData.append('action', 'load_booking_form');
        formData.append('nonce', vaccination_ajax.nonce);
        formData.append('category', category);

        fetch(vaccination_ajax.ajax_url, {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(html => {
                formContainer.innerHTML = html;
                
                // Reinitialize Contact Form 7 if needed
                if (typeof wpcf7 !== 'undefined') {
                    formContainer.querySelectorAll('.wpcf7-form').forEach(form => {
                        wpcf7.init(form);
                    });
                }
            })
            .catch(error => {
                console.error('Error loading form:', error);
                formContainer.innerHTML = `
                    <div class="alert alert-danger">
                        <h6 class="fw-bold mb-2"><i class="bi bi-exclamation-triangle-fill"></i> Error Loading Form</h6>
                        <p class="mb-3">We couldn't load the booking form. Please try again or contact us directly.</p>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="tel:+923335196658" class="btn btn-primary btn-sm">
                                <i class="bi bi-telephone-fill"></i> Call +92 333 5196658
                            </a>
                            <a href="https://wa.me/923335196658?text=I want to book ${categoryTitles[category]}" class="btn btn-success btn-sm" target="_blank">
                                <i class="bi bi-whatsapp"></i> WhatsApp
                            </a>
                            <a href="mailto:info@vaccinepk.com?subject=${categoryTitles[category]}" class="btn btn-secondary btn-sm">
                                <i class="bi bi-envelope-fill"></i> Email
                            </a>
                        </div>
                    </div>
                `;
            });
    }
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
    will-change: transform;
}

.booking-category-card .card-overlay {
    transition: background 0.4s;
}

.booking-category-card:hover .card-overlay {
    background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.5) 50%, rgba(0,0,0,0.1) 100%) !important;
}

.spinner-border {
    border-width: 0.3rem;
}

/* Contact Form 7 Styling */
#form-container .wpcf7-form {
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

#form-container .wpcf7-form p {
    margin-bottom: 20px;
}

#form-container .wpcf7-form label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #16232b;
}

#form-container .wpcf7-form input[type="text"],
#form-container .wpcf7-form input[type="email"],
#form-container .wpcf7-form input[type="tel"],
#form-container .wpcf7-form input[type="date"],
#form-container .wpcf7-form textarea,
#form-container .wpcf7-form select {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #e7e0d3;
    border-radius: 8px;
    font-size: 15px;
    transition: all 0.3s;
}

#form-container .wpcf7-form input[type="text"]:focus,
#form-container .wpcf7-form input[type="email"]:focus,
#form-container .wpcf7-form input[type="tel"]:focus,
#form-container .wpcf7-form input[type="date"]:focus,
#form-container .wpcf7-form textarea:focus,
#form-container .wpcf7-form select:focus {
    border-color: #0b5c87;
    outline: none;
    box-shadow: 0 0 0 3px rgba(11, 92, 135, 0.1);
}

#form-container .wpcf7-form input[type="submit"] {
    background: #0a2a38;
    color: white;
    border: none;
    padding: 15px 40px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

#form-container .wpcf7-form input[type="submit"]:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(11, 92, 135, 0.3);
}

#form-container .wpcf7-not-valid-tip {
    color: #dc2626;
    font-size: 13px;
    margin-top: 5px;
}

#form-container .wpcf7-response-output {
    margin: 20px 0 0 0;
    padding: 15px;
    border-radius: 8px;
    border: 2px solid;
}

#form-container .wpcf7-mail-sent-ok {
    border-color: #10b981;
    background-color: #d1fae5;
    color: #065f46;
}

#form-container .wpcf7-validation-errors,
#form-container .wpcf7-mail-sent-ng {
    border-color: #ef4444;
    background-color: #fee2e2;
    color: #991b1b;
}
</style>

<?php get_footer(); ?>
