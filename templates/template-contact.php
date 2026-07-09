<?php
/**
 * Template Name: Contact Page
 * Description: Contact us page for Vaccination Centre
 */

// Get dynamic site settings
$site_settings = pods( 'site_contact_settings' );

$phone     = $site_settings->field( 'phone_number' ) ?: '+92 333 5196658';
$whatsapp  = $site_settings->field( 'whatsapp_number' ) ?: '+92 333 5196658';
$email     = $site_settings->field( 'email_address' ) ?: 'info@vaccinepk.com';
$address   = $site_settings->field( 'address' ) ?: '2165-F, National Police Foundation, Islamabad';
$facebook  = $site_settings->field( 'facebook_url' );
$instagram = $site_settings->field( 'instagram_url' );

// Format phone numbers for links (remove spaces and dashes)
$phone_link = preg_replace('/[^0-9+]/', '', $phone);
$whatsapp_link = preg_replace('/[^0-9+]/', '', $whatsapp);

get_header();
?>

<!-- ================= PAGE HEADER ================= -->
<section class="page-header" style="background: linear-gradient(135deg, #fff5eb 0%, #ffe8d5 100%); padding: 80px 0 60px; position: relative; overflow: hidden;">
    <div style="position: absolute; top: -50%; right: -10%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(218, 114, 21, 0.1) 0%, transparent 70%); border-radius: 50%;"></div>
    <div style="position: absolute; bottom: -30%; left: -5%; width: 400px; height: 400px; background: radial-gradient(circle, rgba(123, 177, 79, 0.1) 0%, transparent 70%); border-radius: 50%;"></div>
    
    <div class="container" style="position: relative; z-index: 1;">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb justify-content-center" style="background: transparent;">
                        <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>" style="color: #da7215; text-decoration: none;"><i class="bi bi-house-fill"></i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                    </ol>
                </nav>
                <h1 class="display-4 fw-bold mb-3" style="color: #107fa0;">Get In Touch</h1>
                <p class="lead" style="color: #6b7280;">We're here to help. Reach out to us for any queries or to book an appointment.</p>
            </div>
        </div>
    </div>
</section>

<!-- ================= QUICK CONTACT OPTIONS ================= -->
<section class="py-5" style="background: white;">
    <div class="container">
        <div class="row g-4">
            
            <!-- Phone -->
            <div class="col-lg-4 col-md-6">
                <div class="contact-card text-center p-4 h-100" style="background: linear-gradient(135deg, #fff5eb, #ffe8d5); border-radius: 20px; transition: all 0.3s;">
                    <div class="icon-wrapper mb-4" style="width: 80px; height: 80px; margin: 0 auto; background: linear-gradient(135deg, #da7215, #d35324); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(218, 114, 21, 0.3);">
                        <i class="bi bi-telephone-fill" style="font-size: 36px; color: white;"></i>
                    </div>
                    <h5 class="fw-bold mb-3" style="color: #1f2937;">Call Us</h5>
                    <p class="text-muted mb-3">Mon - Sun: 9:00 AM - 8:00 PM</p>
                    <a href="tel:<?php echo esc_attr($phone_link); ?>" class="d-block fw-bold mb-2" style="color: #da7215; text-decoration: none; font-size: 20px;">
                        <?php echo esc_html($phone); ?>
                    </a>
                    <a href="tel:<?php echo esc_attr($phone_link); ?>" class="btn btn-sm" style="background: linear-gradient(135deg, #da7215, #d35324); color: white; border-radius: 50px; padding: 8px 24px;">
                        <i class="bi bi-telephone-fill"></i> Call Now
                    </a>
                </div>
            </div>
            
            <!-- WhatsApp -->
            <div class="col-lg-4 col-md-6">
                <div class="contact-card text-center p-4 h-100" style="background: linear-gradient(135deg, #f0ffe0, #e5ffcc); border-radius: 20px; transition: all 0.3s;">
                    <div class="icon-wrapper mb-4" style="width: 80px; height: 80px; margin: 0 auto; background: linear-gradient(135deg, #7bb14f, #6a9f3e); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(123, 177, 79, 0.3);">
                        <i class="bi bi-whatsapp" style="font-size: 36px; color: white;"></i>
                    </div>
                    <h5 class="fw-bold mb-3" style="color: #1f2937;">WhatsApp</h5>
                    <p class="text-muted mb-3">Quick response, 24/7 available</p>
                    <a href="https://wa.me/<?php echo esc_attr($whatsapp_link); ?>" target="_blank" class="d-block fw-bold mb-2" style="color: #7bb14f; text-decoration: none; font-size: 20px;">
                        <?php echo esc_html($whatsapp); ?>
                    </a>
                    <a href="https://wa.me/<?php echo esc_attr($whatsapp_link); ?>" target="_blank" class="btn btn-sm" style="background: linear-gradient(135deg, #7bb14f, #6a9f3e); color: white; border-radius: 50px; padding: 8px 24px;">
                        <i class="bi bi-whatsapp"></i> Chat Now
                    </a>
                </div>
            </div>
            
            <!-- Email -->
            <div class="col-lg-4 col-md-6">
                <div class="contact-card text-center p-4 h-100" style="background: linear-gradient(135deg, #e0f4ff, #cceeff); border-radius: 20px; transition: all 0.3s;">
                    <div class="icon-wrapper mb-4" style="width: 80px; height: 80px; margin: 0 auto; background: linear-gradient(135deg, #107fa0, #0d6680); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(16, 127, 160, 0.3);">
                        <i class="bi bi-envelope-fill" style="font-size: 36px; color: white;"></i>
                    </div>
                    <h5 class="fw-bold mb-3" style="color: #1f2937;">Email Us</h5>
                    <p class="text-muted mb-3">We'll respond within 24 hours</p>
                    <a href="mailto:<?php echo esc_attr($email); ?>" class="d-block fw-bold mb-2" style="color: #107fa0; text-decoration: none; font-size: 18px; word-break: break-all;">
                        <?php echo esc_html($email); ?>
                    </a>
                    <a href="mailto:<?php echo esc_attr($email); ?>" class="btn btn-sm" style="background: linear-gradient(135deg, #107fa0, #0d6680); color: white; border-radius: 50px; padding: 8px 24px;">
                        <i class="bi bi-envelope-fill"></i> Send Email
                    </a>
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- ================= CONTACT FORM & INFO ================= -->
<section class="py-5" style="background: #f9fafb;">
    <div class="container">
        <div class="row g-5">
            
            <!-- Contact Form -->
            <div class="col-lg-8">
                <div class="bg-white p-5 rounded-4 shadow-sm">
                    <div class="mb-4">
                        <h2 class="fw-bold mb-3" style="color: #107fa0;">Send Us a Message</h2>
                        <p class="text-muted mb-0">Fill out the form below and we'll get back to you as soon as possible.</p>
                    </div>
                    
                    <!-- Contact Form 7 Shortcode -->
                    <?php 
                    // Replace 'CONTACT_FORM_ID' with your actual Contact Form 7 ID
                    echo do_shortcode('[contact-form-7 id="64b0baa" title="Contact form 1_copy"]'); 
                    ?>
                    
                </div>
            </div>
            
            <!-- Contact Info Sidebar -->
            <div class="col-lg-4">
                
                <!-- Office Hours -->
                <div class="bg-white p-4 rounded-4 shadow-sm mb-4">
                    <h5 class="fw-bold mb-4" style="color: #107fa0;">
                        <i class="bi bi-clock-fill" style="color: #da7215;"></i> Office Hours
                    </h5>
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Monday - Friday</span>
                            <span class="text-muted">9:00 AM - 8:00 PM</span>
                        </div>
                    </div>
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Saturday</span>
                            <span class="text-muted">10:00 AM - 6:00 PM</span>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Sunday</span>
                            <span class="text-muted">10:00 AM - 4:00 PM</span>
                        </div>
                    </div>
                    <div class="alert alert-info mt-4 mb-0" style="border-radius: 12px; font-size: 14px;">
                        <i class="bi bi-info-circle-fill"></i> <strong>Emergency?</strong> Call us anytime for urgent vaccination needs.
                    </div>
                </div>
                
                <!-- Service Areas -->
                <div class="bg-white p-4 rounded-4 shadow-sm mb-4">
                    <h5 class="fw-bold mb-4" style="color: #107fa0;">
                        <i class="bi bi-geo-alt-fill" style="color: #7bb14f;"></i> Service Areas
                    </h5>
                    <?php
                $settings = pods('site_contact_settings');
                $service_areas = $settings->field('service_areas');
                ?>

                <ul class="list-unstyled mb-0">
                    <?php if ( ! empty($service_areas) ) : ?>
                        
                        <?php 
                        $total = count($service_areas);
                        $count = 0;
                        foreach ( $service_areas as $area ) : 
                            $count++;
                        ?>

                            <li class="<?php echo ($count != $total) ? 'mb-3 pb-3 border-bottom' : ''; ?>">
                                <i class="bi bi-check-circle-fill" style="color: #7bb14f;"></i> 
                                <span class="ms-2 fw-bold">
                                    <?php 
                                    // Agar simple text repeatable field hai
                                    if ( ! is_array($area) ) {
                                        echo esc_html($area);
                                    } 
                                    // Agar repeatable field ke andar subfield hai
                                    else {
                                        echo esc_html($area['service_area_name']); 
                                        // ↑ Yahan apna actual subfield name confirm karein
                                    }
                                    ?>
                                </span>
                            </li>

                        <?php endforeach; ?>

                    <?php endif; ?>
                </ul>
                </div>


                
                
                <!-- Social Media -->
                <div class="bg-white p-4 rounded-4 shadow-sm">
                    <h5 class="fw-bold mb-4" style="color: #107fa0;">
                        <i class="bi bi-share-fill" style="color: #d35324;"></i> Follow Us
                    </h5>
                    <div class="d-flex gap-3">
                        <?php if ($facebook) : ?>
                        <a href="<?php echo esc_url($facebook); ?>" target="_blank" class="social-icon" style="width: 45px; height: 45px; background: linear-gradient(135deg, #1877f2, #0d5cc4); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; text-decoration: none; font-size: 20px; transition: all 0.3s;">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <?php endif; ?>
                        
                        <?php if ($instagram) : ?>
                        <a href="<?php echo esc_url($instagram); ?>" target="_blank" class="social-icon" style="width: 45px; height: 45px; background: linear-gradient(135deg, #e4405f, #c13584); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; text-decoration: none; font-size: 20px; transition: all 0.3s;">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <?php endif; ?>

                        <?php $tiktok = $site_settings->field( 'tiktok_url' ); if ($tiktok) : ?>
                        <a href="<?php echo esc_url($tiktok); ?>" target="_blank" class="social-icon" style="width: 45px; height: 45px; background: linear-gradient(135deg, #000000, #333333); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; text-decoration: none; font-size: 20px; transition: all 0.3s;">
                            <i class="bi bi-tiktok"></i>
                        </a>
                        <?php endif; ?>

                        <?php $youtube = $site_settings->field( 'youtube_url' ); if ($youtube) : ?>
                        <a href="<?php echo esc_url($youtube); ?>" target="_blank" class="social-icon" style="width: 45px; height: 45px; background: linear-gradient(135deg, #ff0000, #cc0000); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; text-decoration: none; font-size: 20px; transition: all 0.3s;">
                            <i class="bi bi-youtube"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                
            </div>
            
        </div>
    </div>
</section>

<!-- ================= MAP SECTION ================= -->
<section class="py-5" style="background: white;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-3" style="color: #107fa0;">Find Us</h2>
            <p class="text-muted">Our home vaccination service covers major cities in Pakistan</p>
        </div>
        
        <!-- Google Map Embed -->
        <div class="map-container rounded-4 overflow-hidden shadow-lg" style="height: 450px;">
            <iframe
                src="https://www.google.com/maps?q=<?php echo rawurlencode( $address ); ?>&output=embed"
                width="100%"
                height="100%"
                style="border:0;"
                allowfullscreen=""
                loading="lazy">
            </iframe>
        </div>
    </div>
</section>

<!-- ================= FAQ SECTION ================= -->
<section class="py-5" style="background: linear-gradient(135deg, #f0ffe0 0%, #e5ffcc 100%);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-3" style="color: #7bb14f;">Common Questions</h2>
            <p class="text-muted">Quick answers to frequently asked questions</p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <div class="accordion" id="contactFAQ">
                    
                    <!-- FAQ 1 -->
                    <div class="accordion-item mb-3 border-0 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                <i class="bi bi-question-circle-fill me-2" style="color: #7bb14f;"></i>
                                How quickly can you provide home vaccination?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#contactFAQ">
                            <div class="accordion-body">
                                We typically provide home vaccination services within 24-48 hours of booking. For urgent cases, same-day appointments can be arranged subject to availability.
                            </div>
                        </div>
                    </div>
                    
                    <!-- FAQ 2 -->
                    <div class="accordion-item mb-3 border-0 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                <i class="bi bi-question-circle-fill me-2" style="color: #7bb14f;"></i>
                                What areas do you cover?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#contactFAQ">
                            <div class="accordion-body">
                                We currently serve Islamabad, Rawalpindi, Lahore, Multan, Faisalabad, Wah Cantt, and Karachi. We're expanding to more cities soon!
                            </div>
                        </div>
                    </div>
                    
                    <!-- FAQ 3 -->
                    <div class="accordion-item mb-3 border-0 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                <i class="bi bi-question-circle-fill me-2" style="color: #7bb14f;"></i>
                                What payment methods do you accept?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#contactFAQ">
                            <div class="accordion-body">
                                We accept cash on delivery, bank transfers, and online payment through JazzCash, EasyPaisa, and credit/debit cards.
                            </div>
                        </div>
                    </div>
                    
                    <!-- FAQ 4 -->
                    <div class="accordion-item border-0 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                <i class="bi bi-question-circle-fill me-2" style="color: #7bb14f;"></i>
                                Do you provide vaccination cards?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#contactFAQ">
                            <div class="accordion-body">
                                Yes! We provide official vaccination cards with complete documentation. We also send automated SMS and email reminders for upcoming vaccinations.
                            </div>
                        </div>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>
</section>

<!-- ================= CTA SECTION ================= -->
<section class="py-5" style="background: linear-gradient(135deg, #da7215, #d35324);">
    <div class="container">
        <div class="row align-items-center text-white">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <h2 class="fw-bold mb-3">Ready to Book Your Vaccination?</h2>
                <p class="mb-0 fs-5">Don't wait! Protect your family's health with our professional home vaccination service.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="<?php echo home_url('/booking'); ?>" class="btn btn-light btn-lg px-5 fw-bold" style="border-radius: 50px;">
                    Book Now <i class="bi bi-arrow-right-circle-fill ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Styles -->
<style>
.contact-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15) !important;
}

.social-icon:hover {
    transform: translateY(-5px) scale(1.1);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

.accordion-button:not(.collapsed) {
    background: linear-gradient(135deg, #f0ffe0, #e5ffcc);
    color: #1f2937;
}

.accordion-button:focus {
    box-shadow: none;
    border-color: #7bb14f;
}

/* CF7 Form Styling */
.wpcf7 input[type="text"],
.wpcf7 input[type="email"],
.wpcf7 input[type="tel"],
.wpcf7 input[type="url"],
.wpcf7 select,
.wpcf7 textarea {
    width: 100%;
    padding: 14px 18px;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    font-size: 16px;
    transition: all 0.3s;
    background: #f9fafb;
}

.wpcf7 input:focus,
.wpcf7 select:focus,
.wpcf7 textarea:focus {
    border-color: #107fa0;
    background: white;
    outline: none;
    box-shadow: 0 0 0 4px rgba(16, 127, 160, 0.1);
}

.wpcf7 .wpcf7-submit {
    background: linear-gradient(135deg, #7bb14f, #6a9f3e);
    color: white;
    padding: 16px 48px;
    border: none;
    border-radius: 50px;
    font-weight: 700;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 4px 15px rgba(123, 177, 79, 0.3);
}

.wpcf7 .wpcf7-submit:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(123, 177, 79, 0.4);
}

.wpcf7-response-output {
    border-radius: 12px;
    padding: 15px 20px;
    margin-top: 20px;
}
</style>

<?php get_footer(); ?>