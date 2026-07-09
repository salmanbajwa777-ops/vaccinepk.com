<?php
/**
 * Home Page Template - VaccinePk
 * Redesigned homepage. Dynamic sections still use Pods CPT Integration.
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
                <span class="badge-custom">Pakistan's Vaccination Platform</span>
                <h1>
                    Pakistan's Trusted
                    <span>Vaccination Platform</span>
                </h1>
                <p>
                    Home vaccination, clinic vaccination, and evidence-based vaccine guidance — all in one trusted platform.
                </p>

                <ul class="hero-trust-list list-unstyled mb-4">
                    <li><i class="bi bi-check-circle-fill"></i> Genuine Vaccines</li>
                    <li><i class="bi bi-check-circle-fill"></i> WHO Standard Cold Chain</li>
                    <li><i class="bi bi-check-circle-fill"></i> Qualified Healthcare Professionals</li>
                </ul>

                <!-- Main Action Buttons -->
                <div class="d-flex gap-3 flex-wrap mb-4">
                    <a href="#appointment" class="btn btn-primary">
                        <i class="bi bi-house-heart-fill"></i> Book Home Visit
                    </a>
                    <a href="#appointment" class="btn btn-outline-primary">
                        <i class="bi bi-hospital"></i> Book Clinic Visit
                    </a>
                </div>

                <div class="d-flex gap-4 flex-wrap mb-4">
                    <a href="https://wa.me/<?php echo esc_attr( $whatsapp ); ?>" target="_blank" class="hero-link-secondary">
                        <i class="bi bi-whatsapp"></i> WhatsApp
                    </a>
                    <a href="tel:<?php echo esc_attr( $phone ); ?>" class="hero-link-secondary">
                        <i class="bi bi-telephone-fill"></i> Call Now
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
                <div class="hero-image-wrap">
                    <img
                        src="https://images.unsplash.com/photo-1612277795421-9bc7706a4a34?auto=format&fit=crop&w=1200&q=80"
                        alt="Child Vaccination Service"
                        class="img-fluid hero-image"
                    >
                    <div class="hero-trust-badge">
                        <span class="htb-num">800K+</span>
                        <span class="htb-label">Families Trust<br>VaccinePk</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ================= QUICK SERVICE SELECTION ================= -->
<section class="py-5" style="background: white;">
    <div class="container">
        <div class="text-center mb-5">
            <h2>How Can We Help Today?</h2>
            <p class="section-subtitle">Choose the service that fits your family, your business, or your travel plans.</p>
        </div>
        <div class="row g-4">

            <div class="col-lg-3 col-md-6">
                <div class="quick-service-card">
                    <div class="quick-service-icon" style="background:rgba(123,177,79,0.12);color:#7bb14f;"><i class="bi bi-house-heart-fill"></i></div>
                    <h5>Home Vaccination</h5>
                    <p>Certified nurses bring WHO-standard vaccines to your doorstep, with cold chain maintained door to door.</p>
                    <a href="#appointment" class="quick-service-link">Book Now <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="quick-service-card">
                    <div class="quick-service-icon" style="background:rgba(16,127,160,0.12);color:#107fa0;"><i class="bi bi-hospital"></i></div>
                    <h5>Clinic Vaccination</h5>
                    <p>Visit a partner clinic across major cities for walk-in and scheduled immunization.</p>
                    <a href="#clinics" class="quick-service-link">Find Clinic <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="quick-service-card">
                    <div class="quick-service-icon" style="background:rgba(218,114,21,0.12);color:#da7215;"><i class="bi bi-airplane-fill"></i></div>
                    <h5>Travel Vaccination</h5>
                    <div class="quick-service-tags">
                        <span>Yellow Fever</span><span>Hajj</span><span>Umrah</span><span>Typhoid</span>
                    </div>
                    <p>Meet entry requirements for pilgrimage and international travel with certified documentation.</p>
                    <a href="<?php echo esc_url( home_url( '/vaccines' ) ); ?>#travel" class="quick-service-link">Learn More <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="quick-service-card">
                    <div class="quick-service-icon" style="background:rgba(31,41,55,0.08);color:#1f2937;"><i class="bi bi-building-fill"></i></div>
                    <h5>Corporate Vaccination</h5>
                    <div class="quick-service-tags">
                        <span>Businesses</span><span>Schools</span><span>Hospitals</span>
                    </div>
                    <p>On-site immunization drives for organizations, with bulk scheduling and reporting.</p>
                    <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="quick-service-link">Request Quote <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ================= WHY VACCINEPK / STATS ================= -->
<section class="stats-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge-custom" style="background:rgba(123,177,79,0.15);color:#7bb14f;">Why VaccinePk</span>
            <h2 style="color:#fff;">Trusted at a National Scale</h2>
            <p class="section-subtitle" style="color:rgba(255,255,255,0.65);">A decade of protecting Pakistani families with genuine vaccines and licensed care.</p>
        </div>
        <div class="row g-0 stats-grid">
            <div class="col-lg-4 col-md-4 col-6 stat-cell"><div class="stat-num">800,000+</div><div class="stat-lbl">Vaccines Administered</div></div>
            <div class="col-lg-4 col-md-4 col-6 stat-cell"><div class="stat-num">1.5M+</div><div class="stat-lbl">Reminders Sent</div></div>
            <div class="col-lg-4 col-md-4 col-6 stat-cell"><div class="stat-num">10+ yrs</div><div class="stat-lbl">Years Experience</div></div>
            <div class="col-lg-4 col-md-4 col-6 stat-cell"><div class="stat-num">WHO</div><div class="stat-lbl">Standard Cold Chain</div></div>
            <div class="col-lg-4 col-md-4 col-6 stat-cell"><div class="stat-num">100%</div><div class="stat-lbl">Genuine Vaccines</div></div>
            <div class="col-lg-4 col-md-4 col-6 stat-cell"><div class="stat-num">Licensed</div><div class="stat-lbl">Healthcare Professionals</div></div>
        </div>
    </div>
</section>

<!-- ================= FEATURES (DYNAMIC - Pods: feature) ================= -->
<section class="py-5" style="background: white;">
    <div class="container">
        <div class="row text-center g-4">
            <?php
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

<!-- ================= SERVICES (DYNAMIC - Pods: service) ================= -->
<section class="services-section">
    <div class="container">

        <div class="text-center mb-5">
            <h2>Care Designed Around Your Life</h2>
            <p class="section-subtitle">
                From newborns to grandparents, at home or in clinic — one platform for every vaccination need.
            </p>
        </div>

        <div class="row g-4">
            <?php
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

<!-- ================= POPULAR VACCINES (DYNAMIC - Pods: vaccine) ================= -->
<section class="py-5" style="background: var(--bg-light);">
    <div class="container">
        <div class="text-center mb-5">
            <h2>Find Your Vaccine</h2>
            <p class="section-subtitle">Each vaccine links to a dedicated page with dosage, eligibility, and side-effect guidance.</p>
        </div>
        <div class="vaccine-rail">
            <?php
            $popular_vaccines = pods( 'vaccine', array(
                'limit'   => 10,
                'orderby' => 'menu_order, post_title',
                'order'   => 'ASC',
            ) );

            if ( $popular_vaccines->total() > 0 ) {
                while ( $popular_vaccines->fetch() ) {
                    $v_title       = $popular_vaccines->field( 'post_title' );
                    $v_description = $popular_vaccines->field( 'vaccine_description' );
                    $v_price       = $popular_vaccines->field( 'price' );
                    $v_permalink   = $popular_vaccines->field( 'permalink' );
                    ?>
                    <div class="vaccine-rail-card">
                        <div class="vaccine-rail-icon"><i class="bi bi-shield-fill-check"></i></div>
                        <h6><?php echo esc_html( $v_title ); ?></h6>
                        <p><?php echo esc_html( wp_trim_words( $v_description, 12 ) ); ?></p>
                        <div class="vaccine-rail-actions">
                            <a href="<?php echo esc_url( $v_permalink ); ?>" class="va-learn">Learn More</a>
                            <a href="#appointment" class="va-book">Book</a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <p class="text-muted">No vaccines available yet. Please add vaccines from the admin panel.</p>
                <?php
            }
            ?>
        </div>
    </div>
</section>

<!-- ================= FIND A CLINIC ================= -->
<section id="clinics" class="py-5" style="background: white;">
    <div class="container">
        <div class="text-center mb-5">
            <h2>Vaccination Centres Near You</h2>
            <p class="section-subtitle">Partner clinics across Pakistan's major cities, with more locations added regularly.</p>
        </div>
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <div class="row g-3">
                    <?php foreach ( [ 'Islamabad', 'Rawalpindi', 'Lahore', 'Karachi', 'Multan', 'Faisalabad', 'Sialkot', 'Peshawar', 'Abbottabad' ] as $city ) : ?>
                    <div class="col-md-4 col-6">
                        <div class="city-chip">
                            <span class="city-name"><?php echo esc_html( $city ); ?></span>
                            <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="city-link">Find Clinic <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="map-placeholder">
                    <i class="bi bi-geo-alt-fill map-icon"></i>
                    <span class="map-label">Map Preview</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================= WHY CHOOSE US ================= -->
<section class="py-5" style="background: linear-gradient(135deg, #f0ffe0 0%, #e5ffcc 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="fw-bold mb-4" style="color: #7bb14f;">Why Choose VaccinePk?</h2>
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

<!-- ================= EDUCATION HUB (DYNAMIC - WP posts) ================= -->
<section class="py-5" style="background: var(--bg-light);">
    <div class="container">
        <div class="text-center mb-5">
            <h2>Learn. Stay Protected.</h2>
            <p class="section-subtitle">Evidence-based vaccine information for the Pakistani public.</p>
        </div>
        <div class="row g-4">
            <?php
            $edu_posts = new WP_Query( [
                'post_type'      => 'post',
                'post_status'    => 'publish',
                'posts_per_page' => 4,
            ] );

            if ( $edu_posts->have_posts() ) :
                while ( $edu_posts->have_posts() ) : $edu_posts->the_post();
                ?>
                <div class="col-lg-3 col-md-6">
                    <a href="<?php the_permalink(); ?>" class="article-card-link">
                        <div class="article-card">
                            <div class="article-card-image">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( 'blog-thumbnail' ); ?>
                                <?php else : ?>
                                    <i class="bi bi-file-earmark-medical-fill"></i>
                                <?php endif; ?>
                            </div>
                            <div class="article-card-body">
                                <h6><?php the_title(); ?></h6>
                                <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 14 ) ); ?></p>
                                <span class="article-meta"><?php echo vaccination_centre_reading_time(); ?> min read</span>
                            </div>
                        </div>
                    </a>
                </div>
                <?php
                endwhile;
                wp_reset_postdata();
            else :
                ?>
                <div class="col-12">
                    <p class="text-muted text-center">No articles published yet.</p>
                </div>
                <?php
            endif;
            ?>
        </div>
        <div class="text-center mt-4">
            <a href="<?php echo esc_url( home_url( '/blog' ) ); ?>" class="btn btn-outline-primary">View All Articles</a>
        </div>
    </div>
</section>

<!-- ================= HOW IT WORKS ================= -->
<section class="py-5" style="background: white;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold" style="color: #107fa0;">Five Simple Steps</h2>
            <p class="text-muted">From booking to your digital vaccination record — in one visit.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-3 text-center">
                <div class="mb-3">
                    <div class="feature-icon mx-auto">
                        <span style="font-size: 28px; font-weight: bold;">1</span>
                    </div>
                </div>
                <h5 class="fw-bold">Book Online</h5>
                <p class="text-muted">Choose a time that works for your family</p>
            </div>

            <div class="col-md-3 text-center">
                <div class="mb-3">
                    <div class="feature-icon mx-auto">
                        <span style="font-size: 28px; font-weight: bold;">2</span>
                    </div>
                </div>
                <h5 class="fw-bold">Home or Clinic</h5>
                <p class="text-muted">Pick the setting that's most convenient</p>
            </div>

            <div class="col-md-3 text-center">
                <div class="mb-3">
                    <div class="feature-icon mx-auto">
                        <span style="font-size: 28px; font-weight: bold;">3</span>
                    </div>
                </div>
                <h5 class="fw-bold">Confirmation</h5>
                <p class="text-muted">Get a confirmed slot within the hour</p>
            </div>

            <div class="col-md-3 text-center">
                <div class="mb-3">
                    <div class="feature-icon mx-auto">
                        <span style="font-size: 28px; font-weight: bold;">4</span>
                    </div>
                </div>
                <h5 class="fw-bold">Vaccination</h5>
                <p class="text-muted">Administered by licensed professionals</p>
            </div>
        </div>
    </div>
</section>

<!-- ================= TRUST / TESTIMONIALS ================= -->
<section class="py-5" style="background: var(--bg-light);">
    <div class="container">
        <div class="text-center mb-5">
            <h2>What Families Are Saying</h2>
            <p class="section-subtitle">Real feedback from families we've served across Pakistan.</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="testimonial-card">
                    <div class="testimonial-stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                    <p>"The nurse arrived on time, explained every vaccine on my son's card, and even helped us fill gaps we didn't know existed."</p>
                    <div class="testimonial-who"><div class="testimonial-avatar">S.</div><div><div class="testimonial-name">Sana K.</div><div class="testimonial-loc">Lahore</div></div></div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="testimonial-card">
                    <div class="testimonial-stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                    <p>"Booked our Umrah vaccines two days before travel. Got the official certificate the same visit — completely stress-free."</p>
                    <div class="testimonial-who"><div class="testimonial-avatar">A.</div><div><div class="testimonial-name">Ahmed R.</div><div class="testimonial-loc">Islamabad</div></div></div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="testimonial-card">
                    <div class="testimonial-stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                    <p>"As a working parent, home vaccination has been a lifesaver. Reminders come right on schedule via SMS."</p>
                    <div class="testimonial-who"><div class="testimonial-avatar">F.</div><div><div class="testimonial-name">Fatima N.</div><div class="testimonial-loc">Karachi</div></div></div>
                </div>
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

                    <div class="contact-options mt-4">
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
                <h2 class="fw-bold mb-3">Ready to Get Vaccinated?</h2>
                <p class="mb-0" style="font-size: 18px;">Book your appointment in less than one minute.</p>
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

.login-btn:hover .bi-box-arrow-up-right {
    transform: translate(2px, -2px);
}

/* ---- hero additions ---- */
.hero-trust-list { display: flex; flex-direction: column; gap: 10px; }
.hero-trust-list li { font-weight: 600; color: var(--text-dark); }
.hero-trust-list i { color: #7bb14f; margin-right: 8px; }
.hero-link-secondary { font-weight: 600; color: var(--text-light); text-decoration: none; }
.hero-link-secondary:hover { color: var(--primary-gradient-start); }
.hero-image-wrap { position: relative; }
.hero-trust-badge {
    position: absolute; bottom: -20px; left: 20px;
    background: white; border-radius: 16px; box-shadow: var(--shadow-lg);
    padding: 16px 20px; display: inline-flex; align-items: center; gap: 12px;
    max-width: 220px; text-align: left;
}
.htb-num { font-size: 1.3rem; font-weight: 800; color: var(--accent-blue); line-height: 1; }
.htb-label { font-size: 0.76rem; color: var(--text-light); font-weight: 600; line-height: 1.3; }

/* ---- quick service cards ---- */
.quick-service-card {
    background: white; border: 1px solid #eef0f2; border-radius: 18px;
    padding: 32px 24px; height: 100%; transition: var(--transition);
}
.quick-service-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); border-color: transparent; }
.quick-service-icon {
    width: 54px; height: 54px; border-radius: 14px; display: flex; align-items: center;
    justify-content: center; font-size: 1.4rem; margin-bottom: 16px;
}
.quick-service-card h5 { font-weight: 700; margin-bottom: 10px; }
.quick-service-card p { color: var(--text-light); font-size: 0.9rem; }
.quick-service-tags { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 10px; }
.quick-service-tags span {
    font-size: 0.7rem; font-weight: 700; background: var(--bg-light); border: 1px solid #eef0f2;
    color: var(--text-light); padding: 4px 9px; border-radius: 50px;
}
.quick-service-link { font-weight: 700; font-size: 0.88rem; color: var(--accent-blue); text-decoration: none; }
.quick-service-link:hover { color: var(--primary-gradient-start); }

/* ---- stats ---- */
.stats-section { background: linear-gradient(180deg, #1f2937 0%, #0f1620 100%); }
.stats-grid { border-radius: 20px; overflow: hidden; background: rgba(255,255,255,0.08); }
.stat-cell { background: rgba(255,255,255,0.03); padding: 32px 20px; text-align: center; border: 1px solid rgba(255,255,255,0.05); }
.stat-num { font-size: 2rem; font-weight: 800; color: #fff; line-height: 1; margin-bottom: 8px; }
.stat-lbl { font-size: 0.85rem; color: rgba(255,255,255,0.6); font-weight: 600; }
.badge-custom { display: inline-block; padding: 6px 16px; border-radius: 50px; font-size: 0.8rem; font-weight: 700; margin-bottom: 14px; }

/* ---- vaccine rail ---- */
.vaccine-rail { display: flex; gap: 20px; overflow-x: auto; padding-bottom: 14px; }
.vaccine-rail-card {
    flex: 0 0 230px; background: white; border: 1px solid #eef0f2; border-radius: 16px;
    padding: 20px; transition: var(--transition);
}
.vaccine-rail-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-md); }
.vaccine-rail-icon { color: var(--accent-blue); font-size: 1.6rem; margin-bottom: 10px; }
.vaccine-rail-card h6 { font-weight: 700; margin-bottom: 6px; }
.vaccine-rail-card p { font-size: 0.82rem; color: var(--text-light); min-height: 40px; }
.vaccine-rail-actions { display: flex; gap: 8px; margin-top: 10px; }
.vaccine-rail-actions a { flex: 1; text-align: center; font-size: 0.76rem; font-weight: 700; padding: 8px 10px; border-radius: 50px; text-decoration: none; }
.va-learn { border: 1.5px solid #eef0f2; color: var(--text-light); }
.va-learn:hover { border-color: var(--accent-blue); color: var(--accent-blue); }
.va-book { background: var(--accent-blue); color: white; }
.va-book:hover { background: #0d6580; color: white; }

/* ---- clinics ---- */
.city-chip { background: white; border: 1px solid #eef0f2; border-radius: 12px; padding: 14px; display: flex; flex-direction: column; gap: 6px; height: 100%; }
.city-name { font-weight: 700; }
.city-link { font-size: 0.8rem; font-weight: 600; color: var(--accent-blue); text-decoration: none; }
.map-placeholder {
    height: 100%; min-height: 260px; border-radius: 18px; background: var(--bg-light);
    border: 1px dashed #d7dde3; display: flex; flex-direction: column; align-items: center;
    justify-content: center; gap: 10px; color: var(--text-light);
}
.map-icon { font-size: 2.2rem; color: var(--accent-blue); }
.map-label { font-size: 0.85rem; font-weight: 600; }

/* ---- education hub cards ---- */
.article-card-link { text-decoration: none; color: inherit; }
.article-card { background: white; border: 1px solid #eef0f2; border-radius: 16px; overflow: hidden; transition: var(--transition); height: 100%; }
.article-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-md); }
.article-card-image { height: 130px; background: var(--bg-light); display: flex; align-items: center; justify-content: center; font-size: 2rem; color: var(--accent-blue); overflow: hidden; }
.article-card-image img { width: 100%; height: 100%; object-fit: cover; }
.article-card-body { padding: 18px 20px; }
.article-card-body h6 { font-weight: 700; margin-bottom: 8px; }
.article-card-body p { font-size: 0.82rem; color: var(--text-light); margin-bottom: 10px; }
.article-meta { font-size: 0.75rem; color: var(--text-light); font-weight: 600; }

/* ---- testimonials ---- */
.testimonial-card { background: white; border: 1px solid #eef0f2; border-radius: 16px; padding: 26px; height: 100%; }
.testimonial-stars { color: #f0a83c; margin-bottom: 12px; }
.testimonial-card p { font-style: italic; color: var(--text-dark); margin-bottom: 16px; }
.testimonial-who { display: flex; align-items: center; gap: 12px; }
.testimonial-avatar { width: 36px; height: 36px; border-radius: 50%; background: var(--bg-light); color: var(--accent-blue); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem; }
.testimonial-name { font-weight: 700; font-size: 0.85rem; }
.testimonial-loc { font-size: 0.75rem; color: var(--text-light); }

@media (max-width: 991px) {
    .hero-trust-badge { position: static; margin-top: 16px; display: inline-flex; }
}
</style>

<?php get_footer(); ?>
