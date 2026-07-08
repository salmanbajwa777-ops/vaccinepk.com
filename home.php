<?php
/**
 * Home Page Template - VaccinationCentre
 * Dynamic version with Pods CPT Integration
 */
get_header();
?>

<?php
$site_settings = pods( 'site_contact_settings' );

$phone     = $site_settings->field( 'phone_number' );
$whatsapp  = $site_settings->field( 'whatsapp_number' );
?>

<!-- ================= HERO SECTION ================= -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-6 col-md-12">
                <span class="badge-custom">Premium Vaccination Services</span>
                <h1>
                    Protect Your Family With 
                    <span>Safe Vaccination</span>
                </h1>
                <p>
                    We provide trusted home vaccination services to keep you and your family healthy and protected from serious diseases. Expert care, right at your doorstep.
                </p>
                
                <!-- Main Action Buttons -->
                <div class="d-flex gap-3 flex-wrap mb-4">
                    <a href="#appointment" class="btn btn-primary">
                        <i class="bi bi-calendar-check"></i> Book Appointment
                    </a>
                    <a href="tel:<?php echo esc_attr($phone); ?>" class="btn btn-outline-primary">
                        <i class="bi bi-telephone-fill"></i> <?php echo esc_html($phone); ?>
                    </a>
                </div>

                <!-- Login Buttons Section -->
                <div class="login-buttons-container">
                    <p class="mb-2 fw-semibold" style="color: #6b7280; font-size: 14px;">
                        <i class="bi bi-person-circle"></i> Quick Access Portals
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="https://doctor.vaccinepk.com" target="_blank" class="login-btn doctor-login">
                            <i class="bi bi-heart-pulse-fill"></i>
                            <span>Doctor Login</span>
                            <i class="bi bi-box-arrow-up-right ms-1" style="font-size: 12px;"></i>
                        </a>
                        <a href="https://client.vaccinepk.com" target="_blank" class="login-btn client-login">
                            <i class="bi bi-person-badge-fill"></i>
                            <span>Client Login</span>
                            <i class="bi bi-box-arrow-up-right ms-1" style="font-size: 12px;"></i>
                        </a>
                    </div>
                </div>

            </div>

            <div class="col-lg-6 col-md-12 text-center mt-5 mt-lg-0">
                <img
                    src="https://images.unsplash.com/photo-1612277795421-9bc7706a4a34?auto=format&fit=crop&w=1200&q=80"
                    alt="Child Vaccination Service"
                    class="img-fluid hero-image"
                >
            </div>

        </div>
    </div>
</section>

<!-- ================= FEATURES HIGHLIGHT (DYNAMIC - RED BOX) ================= -->
<section class="py-5" style="background: white;">
    <div class="container">
        <div class="row text-center g-4">
            <?php
            // Query Features from Pods
            $features = pods('feature', array(
                'limit' => 3,
                'orderby' => 'menu_order, post_title',
                'order' => 'ASC'
            ));
            
            if ($features->total() > 0) {
                while ($features->fetch()) {
                    $icon = $features->field('feature_icon');
                    $title = $features->field('post_title');
                    $description = $features->field('feature_description');
                    $permalink = $features->field('permalink');
                    ?>
                    <div class="col-md-4">
                        <a href="<?php echo esc_url($permalink); ?>" class="feature-box-link">
                            <div class="feature-box">
                                <div class="feature-icon">
                                    <i class="<?php echo esc_attr($icon ?: 'bi bi-star-fill'); ?>"></i>
                                </div>
                                <h5 class="fw-bold"><?php echo esc_html($title); ?></h5>
                                <p class="text-muted mb-0"><?php echo esc_html($description); ?></p>
                            </div>
                        </a>
                    </div>
                    <?php
                }
            } else {
                // Fallback if no features exist
                ?>
                <div class="col-12">
                    <p class="text-muted">No features available. Please add features from the admin panel.</p>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</section>

<!-- ================= SERVICES (DYNAMIC - GREEN BOX) ================= -->
<section class="services-section">
    <div class="container">
        
        <div class="text-center mb-5">
            <h2>Our Vaccination Services</h2>
            <p class="section-subtitle">
                Comprehensive immunization solutions for children and adults with expert medical care
            </p>
        </div>

        <div class="row g-4">
            <?php
            // Query Services from Pods
            $services = pods('service', array(
                'limit' => -1,
                'orderby' => 'menu_order, post_title',
                'order' => 'ASC'
            ));
            
            if ($services->total() > 0) {
                while ($services->fetch()) {
                    $icon = $services->field('service_icon');
                    $title = $services->field('post_title');
                    $description = $services->field('service_description');
                    $permalink = $services->field('permalink');
                    ?>
                    <div class="col-lg-4 col-md-6">
                        <a href="<?php echo esc_url($permalink); ?>" class="service-card-link">
                            <div class="service-card">
                                <div class="icon">
                                    <i class="<?php echo esc_attr($icon ?: 'bi bi-heart-fill'); ?>"></i>
                                </div>
                                <h4><?php echo esc_html($title); ?></h4>
                                <p><?php echo esc_html($description); ?></p>
                            </div>
                        </a>
                    </div>
                    <?php
                }
            } else {
                // Fallback if no services exist
                ?>
                <div class="col-12">
                    <p class="text-muted text-center">No services available. Please add services from the admin panel.</p>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</section>

<!-- ================= WHY CHOOSE US ================= -->
<section class="py-5" style="background: linear-gradient(135deg, #f0ffe0 0%, #e5ffcc 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="fw-bold mb-4" style="color: #7bb14f;">Why Choose Vaccination Centre?</h2>
                <div class="mb-4">
                    <h5 class="fw-bold"><i class="bi bi-trophy-fill text-warning"></i> Multinational Vaccine Sources</h5>
                    <p class="text-muted">All vaccines sourced from GSK, Pfizer, Sanofi, Merck, and other trusted multinational companies.</p>
                </div>
                <div class="mb-4">
                    <h5 class="fw-bold"><i class="bi bi-clock-fill" style="color: #da7215;"></i> 24-48 Hour Service</h5>
                    <p class="text-muted">Quick appointments with professional service at your preferred time and location.</p>
                </div>
                <div class="mb-4">
                    <h5 class="fw-bold"><i class="bi bi-phone-fill" style="color: #107fa0;"></i> Post-Vaccination Support</h5>
                    <p class="text-muted">Complete follow-up care with SMS and email reminders for next vaccines.</p>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img 
                    src="https://images.unsplash.com/photo-1581594693702-fbdc51b2763b?auto=format&fit=crop&w=800&q=80" 
                    alt="Professional Medical Care" 
                    class="img-fluid rounded-4 shadow-lg"
                    style="max-width: 450px;"
                >
            </div>
        </div>
    </div>
</section>

<!-- ================= HOW IT WORKS ================= -->
<section class="py-5" style="background: white;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold" style="color: #107fa0;">How It Works</h2>
            <p class="text-muted">Simple steps to get your child vaccinated</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-3 text-center">
                <div class="mb-3">
                    <div class="feature-icon mx-auto">
                        <span style="font-size: 28px; font-weight: bold;">1</span>
                    </div>
                </div>
                <h5 class="fw-bold">Check Schedule</h5>
                <p class="text-muted">Review your child's vaccination schedule or get free consultation</p>
            </div>
            
            <div class="col-md-3 text-center">
                <div class="mb-3">
                    <div class="feature-icon mx-auto">
                        <span style="font-size: 28px; font-weight: bold;">2</span>
                    </div>
                </div>
                <h5 class="fw-bold">Book Online</h5>
                <p class="text-muted">Choose your preferred date and time slot for vaccination</p>
            </div>
            
            <div class="col-md-3 text-center">
                <div class="mb-3">
                    <div class="feature-icon mx-auto">
                        <span style="font-size: 28px; font-weight: bold;">3</span>
                    </div>
                </div>
                <h5 class="fw-bold">Stay Ready</h5>
                <p class="text-muted">Keep your child comfortable at home before the visit</p>
            </div>
            
            <div class="col-md-3 text-center">
                <div class="mb-3">
                    <div class="feature-icon mx-auto">
                        <span style="font-size: 28px; font-weight: bold;">4</span>
                    </div>
                </div>
                <h5 class="fw-bold">Get Vaccinated</h5>
                <p class="text-muted">Our expert staff administers vaccines safely at your home</p>
            </div>
        </div>
    </div>
</section>

<!-- ================= APPOINTMENT ================= -->
<section id="appointment" class="appointment-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2>Book Your Appointment Today</h2>
                <p>Schedule your child's vaccination with ease and convenience</p>

                <div class="bg-white p-5 rounded-4 shadow-lg mt-4">
                    <!-- Replace with your actual Contact Form 7 shortcode -->
                    <!--<?php echo do_shortcode('[contact-form-7 id="4d62594" title="Appointment Booking Form"]'); ?>-->
                    
                    <!-- Alternative: Simple contact info if form plugin not installed -->
                    <div class="contact-options mt-4">
                        <!--<p class="mb-3"><strong>Or contact us directly:</strong></p>-->
                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                            <a href="tel:<?php echo esc_attr($phone); ?>" class="btn btn-primary">
                                <i class="bi bi-telephone-fill"></i> Call <?php echo esc_html($phone); ?>
                            </a>
                            <a href="https://wa.me/<?php echo esc_attr($whatsapp); ?>" class="btn btn-outline-primary" target="_blank">
                                <i class="bi bi-whatsapp"></i> WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================= FAQ SECTION ================= -->
<section class="faq-section">
    <div class="container">
        <h2 class="text-center mb-5">Frequently Asked Questions</h2>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <div class="faq-card">
                    <h5><i class="bi bi-patch-question-fill" style="color: #7bb14f;"></i> What vaccines do you provide?</h5>
                    <p>We provide all childhood vaccines as per EPI schedule including BCG, Hepatitis B, DPT, Polio, Measles, MMR, and additional vaccines like Pneumococcal, Rotavirus, and Flu vaccines.</p>
                </div>

                <div class="faq-card">
                    <h5><i class="bi bi-shield-check" style="color: #7bb14f;"></i> Are vaccines safe for my child?</h5>
                    <p>Yes, all our vaccines are sourced from WHO-approved multinational companies like GSK, Pfizer, Sanofi, and Merck. We maintain proper cold chain and follow strict safety protocols.</p>
                </div>

                <div class="faq-card">
                    <h5><i class="bi bi-clock-history" style="color: #7bb14f;"></i> How quickly can you provide home vaccination?</h5>
                    <p>We typically provide home vaccination services within 24-48 hours of booking. Emergency appointments can be arranged on the same day subject to availability.</p>
                </div>

                <div class="faq-card">
                    <h5><i class="bi bi-currency-dollar" style="color: #7bb14f;"></i> What are your service charges?</h5>
                    <p>Different vaccines have different prices. Contact us with your child's vaccination card for a free quote. We offer competitive pricing with complete transparency.</p>
                </div>

                <div class="faq-card">
                    <h5><i class="bi bi-card-checklist" style="color: #7bb14f;"></i> Do you provide vaccination cards?</h5>
                    <p>Yes, we provide official vaccination cards with complete documentation. We also send automated reminders for upcoming vaccines via SMS and email.</p>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- ================= CTA SECTION ================= -->
<section class="py-5" style="background: linear-gradient(135deg, #7bb14f, #6a9f3e);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 text-white mb-4 mb-lg-0">
                <h2 class="fw-bold mb-3">Ready to Protect Your Child?</h2>
                <p class="mb-0" style="font-size: 18px;">Book your home vaccination appointment now and ensure your child's health and safety.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="#appointment" class="btn btn-light btn-lg px-5">
                    Book Now <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>



<style>
/* Login Buttons Styling */
.login-buttons-container {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 2px solid rgba(123, 177, 79, 0.2);
}

.login-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 15px;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 2px solid transparent;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.login-btn i:first-child {
    font-size: 18px;
}

/* Doctor Login Button */
.doctor-login {
    background: linear-gradient(135deg, #107fa0 0%, #0d6580 100%);
    color: white;
    border-color: #107fa0;
}

.doctor-login:hover {
    background: linear-gradient(135deg, #0d6580 0%, #0a4f64 100%);
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(16, 127, 160, 0.3);
    color: white;
}

/* Client Login Button */
.client-login {
    background: linear-gradient(135deg, #7bb14f 0%, #6a9f3e 100%);
    color: white;
    border-color: #7bb14f;
}

.client-login:hover {
    background: linear-gradient(135deg, #6a9f3e 0%, #5a8d2e 100%);
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(123, 177, 79, 0.3);
    color: white;
}

/* Responsive Design */
@media (max-width: 768px) {
    .login-btn {
        padding: 10px 20px;
        font-size: 14px;
    }
    
    .login-buttons-container {
        margin-top: 15px;
        padding-top: 15px;
    }
}

/* Animation for external link icon */
.login-btn:hover .bi-box-arrow-up-right {
    transform: translate(2px, -2px);
}
</style>

<?php get_footer(); ?>
