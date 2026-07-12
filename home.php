<?php
/**
 * Home Page Template - VaccinePk
 * Full information-architecture redesign: knowledge-first homepage
 * (search -> vaccines -> diseases -> schedules -> articles -> compare ->
 * prices -> book), establishing VaccinePk as Pakistan's vaccine knowledge
 * authority while keeping home vaccination booking as the primary conversion.
 */
get_header();

$site_settings = pods( 'site_contact_settings' );
$phone         = $site_settings->field( 'phone_number' );
$whatsapp      = $site_settings->field( 'whatsapp_number' );

$schedule_stages = function_exists( 'vaccination_centre_schedule_stages' ) ? vaccination_centre_schedule_stages() : [];

// Site logo mark, used as the fallback image for cards with no product photo
// (instead of a generic Bootstrap shield icon).
$vaccinepk_logo_url = '';
if ( has_custom_logo() ) {
    $logo_id            = get_theme_mod( 'custom_logo' );
    $vaccinepk_logo_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'medium' ) : '';
}

// ---- Section 2: Knowledge Categories ----
$knowledge_categories = [
    [ 'icon' => 'bi-shield-fill-check',   'title' => 'Vaccines',            'url' => home_url( '/vaccines' ) ],
    [ 'icon' => 'bi-virus2',              'title' => 'Diseases',            'url' => home_url( '/diseases' ) ],
    [ 'icon' => 'bi-calendar2-week-fill', 'title' => 'Vaccination Schedule', 'url' => home_url( '/vaccination-schedule' ) ],
    [ 'icon' => 'bi-emoji-smile-fill',    'title' => 'Children',            'url' => home_url( '/vaccines#child-vaccines' ) ],
    [ 'icon' => 'bi-person-fill',         'title' => 'Adults',              'url' => home_url( '/vaccines#adult-vaccines' ) ],
    [ 'icon' => 'bi-heart-pulse-fill',    'title' => 'Pregnancy',           'url' => home_url( '/vaccines#adult-vaccines' ) ],
    [ 'icon' => 'bi-airplane-fill',       'title' => 'Travel',              'url' => home_url( '/travel-vaccines' ) ],
    [ 'icon' => 'bi-award-fill',          'title' => 'Vaccine Brands',      'url' => home_url( '/vaccine-brands' ) ],
    [ 'icon' => 'bi-patch-question-fill', 'title' => 'FAQs',                'url' => home_url( '/#homepage-faqs' ) ],
    [ 'icon' => 'bi-book-half',           'title' => 'Knowledge Centre',    'url' => home_url( '/knowledge-centre' ) ],
];

// ---- Section 4: Featured Knowledge (evergreen topics; link only if a matching post exists) ----
$featured_knowledge_topics = [
    'Complete HPV Vaccine Guide',
    'Can Vaccines Be Delayed?',
    'Adult Vaccination Guide',
    'Flu Vaccine Guide',
    'Difference Between PCV10 and PCV13',
    'Travel Vaccines Explained',
    'Pregnancy Vaccines',
    'Childhood Immunization Guide',
];
$featured_knowledge = [];
foreach ( $featured_knowledge_topics as $topic ) {
    $topic_posts = get_posts( [ 'post_type' => 'post', 'post_status' => 'publish', 'title' => $topic, 'posts_per_page' => 1 ] );
    $match = $topic_posts ? $topic_posts[0] : null;
    $featured_knowledge[] = [
        'title' => $topic,
        'post'  => $match,
    ];
}

// ---- Section 5: Interactive Tools (placeholders) ----
$interactive_tools = [
    [ 'icon' => 'bi-calculator-fill',   'title' => 'Baby Vaccine Due Calculator', 'desc' => 'Find out which vaccines your baby is due for, by date of birth.' ],
    [ 'icon' => 'bi-person-check-fill', 'title' => 'Adult Vaccine Finder',        'desc' => 'Discover which vaccines are recommended for your age and lifestyle.' ],
    [ 'icon' => 'bi-airplane-fill',     'title' => 'Travel Vaccine Advisor',      'desc' => 'Get vaccine recommendations based on your destination.' ],
    [ 'icon' => 'bi-clock-history',     'title' => 'Missed Vaccine Planner',      'desc' => 'Catch up safely on any vaccines that were missed or delayed.' ],
    [ 'icon' => 'bi-heart-pulse-fill',  'title' => 'Pregnancy Vaccine Checker',   'desc' => 'See which vaccines are recommended during each trimester.' ],
];

// ---- Section 9: Why VaccinePk ----
$why_vaccinepk = [
    [ 'icon' => 'bi-mortarboard-fill',   'title' => 'Doctor Led' ],
    [ 'icon' => 'bi-shield-check',       'title' => 'WHO Guidelines' ],
    [ 'icon' => 'bi-thermometer-snow',   'title' => 'Cold Chain Protected' ],
    [ 'icon' => 'bi-box-seam-fill',      'title' => 'Imported Genuine Vaccines' ],
    [ 'icon' => 'bi-file-earmark-medical-fill', 'title' => 'Digital Records' ],
    [ 'icon' => 'bi-house-heart-fill',   'title' => 'Home Vaccination' ],
    [ 'icon' => 'bi-building-fill',      'title' => 'Corporate Vaccination' ],
    [ 'icon' => 'bi-people-fill',        'title' => 'Experienced Team' ],
];

// ---- Section 10: Testimonials (static; photo/video fields left for future use) ----
$testimonials = [
    [ 'name' => 'Sana K.',  'loc' => 'Lahore',     'avatar' => null, 'video_url' => null,
      'text' => "The nurse arrived on time, explained every vaccine on my son's card, and even helped us fill gaps we didn't know existed." ],
    [ 'name' => 'Ahmed R.', 'loc' => 'Islamabad',  'avatar' => null, 'video_url' => null,
      'text' => 'Booked our Umrah vaccines two days before travel. Got the official certificate the same visit — completely stress-free.' ],
    [ 'name' => 'Fatima N.','loc' => 'Karachi',    'avatar' => null, 'video_url' => null,
      'text' => 'As a working parent, home vaccination has been a lifesaver. Reminders come right on schedule via SMS.' ],
];

// ---- Section 11: Cities We Serve ----
$fallback_cities = [ 'Islamabad', 'Rawalpindi', 'Lahore', 'Karachi', 'Faisalabad', 'Multan', 'Sialkot', 'Abbottabad' ];
$city_posts_query = new WP_Query( [ 'post_type' => 'city', 'post_status' => 'publish', 'posts_per_page' => 8, 'orderby' => 'title', 'order' => 'ASC' ] );

// ---- Section 12: FAQs (12 to start; architecture is just a foreach, scales to hundreds via a future faq CPT) ----
$homepage_faqs = [
    [ 'q' => 'What vaccines do you provide?', 'a' => 'We provide all childhood vaccines as per the EPI schedule including BCG, Hepatitis B, DPT, Polio, Measles, MMR, plus Pneumococcal, Rotavirus, and Flu vaccines for adults and children.' ],
    [ 'q' => 'Are vaccines safe for my child?', 'a' => 'Yes. All our vaccines are sourced from trusted multinational manufacturers, with proper cold chain maintained from arrival to administration.' ],
    [ 'q' => 'How quickly can you provide home vaccination?', 'a' => 'We typically provide home vaccination within 24-48 hours of booking. Emergency appointments can be arranged the same day, subject to availability.' ],
    [ 'q' => 'What are your service charges?', 'a' => 'Pricing varies by vaccine and brand. Visit our Prices page or contact us with your child\'s vaccination card for an exact quote.' ],
    [ 'q' => 'Do you provide vaccination cards?', 'a' => 'Yes, we provide official vaccination cards with complete documentation, plus automated SMS and email reminders for upcoming doses.' ],
    [ 'q' => 'Can vaccines be delayed if my child is sick?', 'a' => 'Minor illnesses like a common cold usually don\'t require delaying a vaccine — but always tell our team about any symptoms before the appointment.' ],
    [ 'q' => 'Do you offer travel and Hajj/Umrah vaccines?', 'a' => 'Yes, including Meningococcal (ACWY), Yellow Fever, Typhoid, and other travel-specific vaccines with certified documentation.' ],
    [ 'q' => 'Is home vaccination as safe as a clinic visit?', 'a' => 'Yes. Our certified nurses carry WHO-standard cold chain equipment and follow the same safety protocols as an in-clinic visit.' ],
    [ 'q' => 'What age groups do you vaccinate?', 'a' => 'We serve newborns, children, adults, and seniors, with age-specific schedules for each group.' ],
    [ 'q' => 'Do you serve corporate and school vaccination drives?', 'a' => 'Yes, we run on-site immunization drives for businesses, schools, and hospitals with bulk scheduling and reporting.' ],
    [ 'q' => 'How do I know which vaccines my baby is due for?', 'a' => 'Use our Vaccination Schedule page or the Baby Vaccine Due Calculator to see what\'s due based on date of birth.' ],
    [ 'q' => 'Which cities do you serve?', 'a' => 'We currently serve Islamabad, Rawalpindi, Lahore, Karachi, Faisalabad, Multan, Sialkot, Abbottabad, and more cities are being added.' ],
];
?>

<!-- ================= SECTION 1: HERO + SEARCH + STATS ================= -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-6 col-md-12">
                <span class="badge-custom">Know Before You Go</span>
                <h1>
                    Pakistan's Most Trusted
                    <span>Vaccine &amp; Vaccination Resource</span>
                </h1>
                <p>
                    Evidence-based vaccine guidance, vaccination schedules, disease prevention, vaccine availability, pricing, and premium home vaccination services across Pakistan.
                </p>

                <!-- Intelligent Search -->
                <div class="home-search-wrap mb-3">
                    <div class="input-group input-group-lg home-search-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" class="form-control border-start-0 ps-0" id="homeSearchInput"
                               placeholder="Search vaccines, diseases, schedules, brands or FAQs..." autocomplete="off">
                    </div>
                    <div id="homeSearchLoading" class="text-center py-3" style="display:none;">
                        <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
                    </div>
                    <div id="homeSearchResults" class="search-results home-search-results"></div>
                </div>

                <!-- Quick Chips — ranked by real 7-day search/click volume, see vaccinepk_get_ranked_chips() -->
                <div class="home-search-chips mb-4">
                    <?php foreach ( vaccinepk_get_ranked_chips( 7 ) as $chip ) : ?>
                        <a href="<?php echo esc_url( home_url( '/vaccines?s=' . urlencode( $chip['term'] ) ) ); ?>"
                           class="home-chip<?php echo $chip['is_top'] ? ' home-chip-top' : ''; ?>"
                           data-chip-term="<?php echo esc_attr( $chip['term'] ); ?>">
                            <span class="home-chip-rank"><?php echo (int) $chip['rank']; ?></span>
                            <?php echo esc_html( $chip['term'] ); ?>
                            <?php if ( $chip['trending'] ) : ?>
                                <svg class="home-chip-trend" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true"><polyline points="3,17 10,10 14,14 21,6"/><polyline points="15,6 21,6 21,12"/></svg>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                    <a href="<?php echo esc_url( home_url( '/vaccines' ) ); ?>" class="home-chip home-chip-more">
                        More
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true"><polyline points="9,6 15,12 9,18"/></svg>
                    </a>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 text-center mt-5 mt-lg-0">
                <div class="hero-image-wrap">
                    <img
                        src="https://images.unsplash.com/photo-1612277795421-9bc7706a4a34?auto=format&fit=crop&w=1200&q=80"
                        alt="Premium home vaccination service"
                        class="img-fluid hero-image"
                        loading="eager"
                    >
                    <div class="hero-trust-badge">
                        <span class="htb-num">800K+</span>
                        <span class="htb-label">Vaccines Administered</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Credibility Metrics -->
        <div class="row g-0 hero-stats-grid mt-5">
            <div class="col-lg-3 col-md-3 col-6 hero-stat-cell">
                <div class="hero-stat-num">800,000+</div><div class="hero-stat-lbl">Vaccines Administered</div>
            </div>
            <div class="col-lg-3 col-md-3 col-6 hero-stat-cell">
                <div class="hero-stat-num">1.5M+</div><div class="hero-stat-lbl">Vaccination Reminders</div>
            </div>
            <div class="col-lg-3 col-md-3 col-6 hero-stat-cell">
                <div class="hero-stat-num">9+</div><div class="hero-stat-lbl">Cities Served</div>
            </div>
            <div class="col-lg-3 col-md-3 col-6 hero-stat-cell">
                <div class="hero-stat-num">10+ yrs</div><div class="hero-stat-lbl">Years Experience</div>
            </div>
        </div>
    </div>
</section>

<!-- ================= SECTION 2: KNOWLEDGE CATEGORIES ================= -->
<section class="py-5" style="background: white;">
    <div class="container">
        <div class="text-center mb-5">
            <h2>Explore Vaccine Knowledge</h2>
            <p class="section-subtitle">Pakistan's largest collection of vaccine and vaccination information — start anywhere.</p>
        </div>
        <div class="row g-4">
            <?php foreach ( $knowledge_categories as $cat ) : ?>
                <div class="col-lg-2 col-md-3 col-6">
                    <a href="<?php echo esc_url( $cat['url'] ); ?>" class="knowledge-cat-card">
                        <div class="knowledge-cat-icon"><i class="bi <?php echo esc_attr( $cat['icon'] ); ?>"></i></div>
                        <h6><?php echo esc_html( $cat['title'] ); ?></h6>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ================= SECTION 3: MOST SEARCHED VACCINES ================= -->
<section class="py-5" style="background: var(--bg-light);">
    <div class="container">
        <div class="text-center mb-5">
            <h2>Most Searched Vaccines</h2>
            <p class="section-subtitle">Each vaccine links to a dedicated page with dosage, eligibility, and side-effect guidance.</p>
        </div>
        <div class="row g-4">
            <?php
            // Most Searched Vaccines: curated list, one representative brand per vaccine.
            // Brand-selection logic (cheapest/most relevant of multiple brands) is a
            // separate future task — for now we take the first published brand found
            // for each vaccine name as the representative.
            $msv_order = [
                'Vaxapox',
                'Prevenar',
                'Hexaxim',
                'Rotarix',
                'MMR',
                'Boostrix',
                'Meningococcal',
                'Typhoid',
                'Yellow Fever',
            ];

            $all_brands = get_posts( [
                'post_type'      => 'brand',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
            ] );

            // Group brand posts by their vaccine_name meta so we can match against
            // $msv_order using a loose (case-insensitive, partial) match — the
            // pricing page's vaccine_name values don't necessarily match these
            // display labels exactly (e.g. "Typhoid TCV" vs "Typhoid").
            $brands_by_vaccine = [];
            foreach ( $all_brands as $b ) {
                $vname = get_post_meta( $b->ID, 'vaccine_name', true );
                if ( ! $vname ) continue;
                $brands_by_vaccine[ $vname ][] = $b;
            }

            // Known alias pairs where the pricing page's vaccine_name doesn't share
            // any substring with the homepage display label.
            $msv_aliases = [
                'Meningococcal' => 'Men-ACYW135',
                'Yellow Fever'  => 'Stamaril',
            ];

            $msv_cards = [];
            foreach ( $msv_order as $label ) {
                $match_key = null;
                $aliases   = array_filter( [ $label, $msv_aliases[ $label ] ?? null ] );
                foreach ( $brands_by_vaccine as $vname => $vbrands ) {
                    foreach ( $aliases as $needle ) {
                        if ( strcasecmp( $vname, $needle ) === 0 || stripos( $vname, $needle ) !== false || stripos( $needle, $vname ) !== false ) {
                            $match_key = $vname;
                            break 2;
                        }
                    }
                }

                $rep          = $match_key ? $brands_by_vaccine[ $match_key ][0] : null;
                $thumb        = $rep ? get_the_post_thumbnail_url( $rep->ID, 'medium' ) : false;
                $avail_raw    = $rep ? get_post_meta( $rep->ID, 'availability', true ) : '';
                $is_available = ( $avail_raw === '1' || strtolower( $avail_raw ) === 'yes' || $avail_raw === true );
                $description  = $rep ? wp_trim_words( get_post_field( 'post_content', $rep->ID ), 12 ) : '';
                $disease      = $rep ? get_post_meta( $rep->ID, 'disease', true ) : '';
                $permalink    = $rep ? get_permalink( $rep->ID ) : site_url( '/pricing' );

                $msv_cards[] = [
                    'label'       => $label,
                    'thumb'       => $thumb,
                    'available'   => $rep ? $is_available : false,
                    'has_data'    => (bool) $rep,
                    'description' => $description,
                    'age'         => $disease,
                    'permalink'   => $permalink,
                ];
            }

            foreach ( $msv_cards as $card ) :
                // "Out of stock" only applies once we have real brand data saying so.
                // A vaccine with no matched brand record is unknown, not in-stock —
                // treat it the same as out-of-stock visually rather than claim availability.
                $out_of_stock = ! $card['has_data'] || ! $card['available'];
                $card_classes = 'vsv-card' . ( $out_of_stock ? ' vsv-card-oos' : '' );
                ?>
                <div class="col-lg-3 col-md-6">
                    <div class="<?php echo esc_attr( $card_classes ); ?>">
                        <div class="vsv-card-img">
                            <?php if ( $card['thumb'] ) : ?>
                                <img src="<?php echo esc_url( $card['thumb'] ); ?>" alt="<?php echo esc_attr( $card['label'] ); ?>">
                            <?php elseif ( $vaccinepk_logo_url ) : ?>
                                <img src="<?php echo esc_url( $vaccinepk_logo_url ); ?>" alt="<?php echo esc_attr( $card['label'] ); ?>" class="vsv-fallback-logo">
                            <?php else : ?>
                                <i class="bi bi-shield-fill-check"></i>
                            <?php endif; ?>
                            <?php if ( $out_of_stock ) : ?>
                                <span class="vsv-badge vsv-badge-out"><?php echo $card['has_data'] ? 'Out of Stock' : 'Coming Soon'; ?></span>
                            <?php else : ?>
                                <span class="vsv-badge vsv-badge-in">In Stock</span>
                            <?php endif; ?>
                        </div>
                        <div class="vsv-card-body">
                            <h6><?php echo esc_html( $card['label'] ); ?></h6>
                            <?php if ( $card['description'] ) : ?><p><?php echo esc_html( $card['description'] ); ?></p><?php endif; ?>
                            <?php if ( $card['age'] ) : ?><p class="vsv-age"><i class="bi bi-calendar-check"></i> <?php echo esc_html( $card['age'] ); ?></p><?php endif; ?>
                            <div class="vsv-actions">
                                <a href="<?php echo esc_url( $card['permalink'] ); ?>" class="vsv-learn">Learn More</a>
                                <?php if ( $out_of_stock ) : ?>
                                    <span class="vsv-book vsv-book-disabled" aria-disabled="true">Book</span>
                                <?php else : ?>
                                    <a href="<?php echo esc_url( site_url( '/booking' ) ); ?>" class="vsv-book">Book</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            endforeach;
            ?>
        </div>
    </div>
</section>

<!-- ================= SECTION 4: FEATURED KNOWLEDGE ================= -->
<section class="py-5" style="background: white;">
    <div class="container">
        <div class="text-center mb-5">
            <h2>Featured Knowledge</h2>
            <p class="section-subtitle">Evergreen, doctor-reviewed guides on vaccines and vaccination.</p>
        </div>
        <div class="row g-4">
            <?php foreach ( $featured_knowledge as $fk ) :
                $has_post = ! empty( $fk['post'] );
                $url      = $has_post ? get_permalink( $fk['post']->ID ) : '';
                ?>
                <div class="col-lg-3 col-md-6">
                    <?php if ( $has_post ) : ?>
                        <a href="<?php echo esc_url( $url ); ?>" class="fk-card">
                    <?php else : ?>
                        <div class="fk-card fk-card-soon">
                    <?php endif; ?>
                        <div class="fk-card-body">
                            <span class="fk-badge"><i class="bi bi-patch-check-fill"></i> Doctor Reviewed</span>
                            <h6><?php echo esc_html( $fk['title'] ); ?></h6>
                            <div class="fk-meta">
                                <?php if ( $has_post ) : ?>
                                    <span><i class="bi bi-clock"></i> <?php echo vaccination_centre_reading_time_for( $fk['post']->ID ); ?> min read</span>
                                    <span><i class="bi bi-calendar3"></i> <?php echo esc_html( get_the_modified_date( 'M j, Y', $fk['post']->ID ) ); ?></span>
                                <?php else : ?>
                                    <span class="fk-soon"><i class="bi bi-hourglass-split"></i> Coming Soon</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php echo $has_post ? '</a>' : '</div>'; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <a href="<?php echo esc_url( home_url( '/knowledge-centre' ) ); ?>" class="btn btn-outline-primary">Visit Knowledge Centre</a>
        </div>
    </div>
</section>

<!-- ================= SECTION 5: INTERACTIVE TOOLS ================= -->
<section class="py-5" style="background: var(--bg-light);">
    <div class="container">
        <div class="text-center mb-5">
            <h2>Interactive Tools</h2>
            <p class="section-subtitle">Practical tools to help you plan vaccinations for your whole family.</p>
        </div>
        <div class="row g-4">
            <?php foreach ( $interactive_tools as $tool ) : ?>
                <div class="col-lg-2 col-md-4 col-6">
                    <div class="tool-card">
                        <div class="tool-icon"><i class="bi <?php echo esc_attr( $tool['icon'] ); ?>"></i></div>
                        <h6><?php echo esc_html( $tool['title'] ); ?></h6>
                        <p><?php echo esc_html( $tool['desc'] ); ?></p>
                        <span class="tool-soon">Coming Soon</span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ================= SECTION 6: PAKISTAN VACCINATION SCHEDULE ================= -->
<section class="py-5" style="background: white;">
    <div class="container">
        <div class="text-center mb-5">
            <h2>Pakistan Vaccination Schedule</h2>
            <p class="section-subtitle">The recommended childhood immunization timeline, from birth through 18 months.</p>
        </div>
        <div class="schedule-strip">
            <?php foreach ( $schedule_stages as $stage ) : ?>
                <a href="<?php echo esc_url( home_url( '/vaccination-schedule#' . $stage['slug'] ) ); ?>" class="schedule-strip-item">
                    <span class="schedule-strip-dot"></span>
                    <span class="schedule-strip-label"><?php echo esc_html( $stage['label'] ); ?></span>
                </a>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <a href="<?php echo esc_url( home_url( '/vaccination-schedule' ) ); ?>" class="btn btn-primary">View Full Schedule</a>
        </div>
    </div>
</section>

<!-- ================= SECTION 7: DISEASE LIBRARY ================= -->
<section class="py-5" style="background: var(--bg-light);">
    <div class="container">
        <div class="text-center mb-5">
            <h2>Disease Library</h2>
            <p class="section-subtitle">Symptoms, complications, prevention, and vaccination for common diseases in Pakistan.</p>
        </div>
        <div class="row g-4">
            <?php
            $disease_query = new WP_Query( [ 'post_type' => 'disease', 'post_status' => 'publish', 'posts_per_page' => 9, 'orderby' => 'title', 'order' => 'ASC' ] );

            if ( $disease_query->have_posts() ) :
                while ( $disease_query->have_posts() ) : $disease_query->the_post();
                    ?>
                    <div class="col-lg-4 col-md-6">
                        <a href="<?php the_permalink(); ?>" class="disease-lib-card">
                            <div class="disease-lib-icon"><i class="bi bi-virus2"></i></div>
                            <h6><?php the_title(); ?></h6>
                            <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 14 ) ); ?></p>
                        </a>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            else :
                ?>
                <div class="col-12 text-center">
                    <p class="text-muted">Disease guides are being added. <a href="<?php echo esc_url( home_url( '/diseases' ) ); ?>">Visit the Disease Library</a> to check back soon.</p>
                </div>
                <?php
            endif;
            ?>
        </div>
    </div>
</section>

<!-- ================= SECTION 8: VACCINE BRANDS ================= -->
<section class="py-5" style="background: white;">
    <div class="container">
        <div class="text-center mb-5">
            <h2>Vaccine Brands</h2>
            <p class="section-subtitle">Genuine, imported vaccines from trusted multinational manufacturers.</p>
        </div>
        <div class="row g-4">
            <?php
            $brand_posts = get_posts( [ 'post_type' => 'brand', 'post_status' => 'publish', 'posts_per_page' => 8, 'orderby' => 'title', 'order' => 'ASC' ] );

            if ( $brand_posts ) :
                foreach ( $brand_posts as $brand ) :
                    $thumb = get_the_post_thumbnail_url( $brand->ID, 'medium' );
                    ?>
                    <div class="col-lg-3 col-md-4 col-6">
                        <a href="<?php echo esc_url( get_permalink( $brand->ID ) ); ?>" class="brand-home-card">
                            <div class="brand-home-img">
                                <?php if ( $thumb ) : ?>
                                    <img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( $brand->post_title ); ?>">
                                <?php elseif ( $vaccinepk_logo_url ) : ?>
                                    <img src="<?php echo esc_url( $vaccinepk_logo_url ); ?>" alt="<?php echo esc_attr( $brand->post_title ); ?>" class="brand-home-fallback-logo">
                                <?php else : ?>
                                    <i class="bi bi-shield-fill-check"></i>
                                <?php endif; ?>
                            </div>
                            <h6><?php echo esc_html( $brand->post_title ); ?></h6>
                        </a>
                    </div>
                    <?php
                endforeach;
            else :
                ?>
                <div class="col-12 text-center"><p class="text-muted">Brand information is being added.</p></div>
                <?php
            endif;
            ?>
        </div>
        <div class="text-center mt-4">
            <a href="<?php echo esc_url( home_url( '/vaccine-brands' ) ); ?>" class="btn btn-outline-primary">View All Brands</a>
        </div>
    </div>
</section>

<!-- ================= SECTION 9: WHY VACCINEPK ================= -->
<section class="stats-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge-custom" style="background:rgba(107,182,63,0.15);color:var(--color-green);">Why VaccinePk</span>
            <h2 style="color:#fff;">Trusted at a National Scale</h2>
        </div>
        <div class="row g-3">
            <?php foreach ( $why_vaccinepk as $item ) : ?>
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="why-card">
                        <i class="bi <?php echo esc_attr( $item['icon'] ); ?>"></i>
                        <span><?php echo esc_html( $item['title'] ); ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ================= SECTION 10: TESTIMONIALS ================= -->
<section class="py-5" style="background: var(--bg-light);">
    <div class="container">
        <div class="text-center mb-5">
            <h2>What Families Are Saying</h2>
            <p class="section-subtitle">Real feedback from families we've served across Pakistan — see more on Google Reviews.</p>
        </div>
        <div class="row g-4">
            <?php foreach ( $testimonials as $t ) : ?>
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card">
                        <div class="testimonial-stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                        <p>"<?php echo esc_html( $t['text'] ); ?>"</p>
                        <div class="testimonial-who">
                            <div class="testimonial-avatar"><?php echo esc_html( mb_substr( $t['name'], 0, 1 ) ); ?></div>
                            <div><div class="testimonial-name"><?php echo esc_html( $t['name'] ); ?></div><div class="testimonial-loc"><?php echo esc_html( $t['loc'] ); ?></div></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ================= SECTION 11: CITIES WE SERVE ================= -->
<section class="py-5" style="background: white;">
    <div class="container">
        <div class="text-center mb-5">
            <h2>Cities We Serve</h2>
            <p class="section-subtitle">Partner clinics and home-visit coverage across Pakistan's major cities.</p>
        </div>
        <div class="row g-3">
            <?php if ( $city_posts_query->have_posts() ) : ?>
                <?php while ( $city_posts_query->have_posts() ) : $city_posts_query->the_post(); ?>
                    <div class="col-lg-3 col-md-4 col-6">
                        <a href="<?php the_permalink(); ?>" class="city-home-chip">
                            <i class="bi bi-geo-alt-fill"></i> <?php the_title(); ?>
                        </a>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            <?php else : ?>
                <?php foreach ( $fallback_cities as $city ) : ?>
                    <div class="col-lg-3 col-md-4 col-6">
                        <span class="city-home-chip city-home-chip-static">
                            <i class="bi bi-geo-alt-fill"></i> <?php echo esc_html( $city ); ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ================= SECTION 12: FAQ ================= -->
<section class="faq-section" id="homepage-faqs">
    <div class="container">
        <h2 class="text-center mb-5">Frequently Asked Questions</h2>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="homeFaqAccordion">
                    <?php foreach ( $homepage_faqs as $i => $faq ) : ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqHeading<?php echo $i; ?>">
                                <button class="accordion-button <?php echo $i > 0 ? 'collapsed' : ''; ?>" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#faqCollapse<?php echo $i; ?>"
                                        aria-expanded="<?php echo $i === 0 ? 'true' : 'false'; ?>" aria-controls="faqCollapse<?php echo $i; ?>">
                                    <?php echo esc_html( $faq['q'] ); ?>
                                </button>
                            </h2>
                            <div id="faqCollapse<?php echo $i; ?>" class="accordion-collapse collapse <?php echo $i === 0 ? 'show' : ''; ?>"
                                 aria-labelledby="faqHeading<?php echo $i; ?>" data-bs-parent="#homeFaqAccordion">
                                <div class="accordion-body"><?php echo esc_html( $faq['a'] ); ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================= SECTION 13: FINAL CTA ================= -->
<section class="py-5" id="appointment" style="background: var(--color-navy);">
    <div class="container text-center">
        <h2 class="fw-bold mb-3" style="color: var(--color-ivory);">Book Your Vaccination</h2>
        <p class="mb-4" style="font-size: 18px; opacity: 0.95; color: var(--color-ink-on-navy);">Or speak with our vaccination team — we'll help you find the right vaccines for your family.</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="<?php echo esc_url( site_url( '/booking' ) ); ?>" class="btn btn-lg px-5" style="background: var(--color-gold); color: var(--color-navy); border-radius: 999px; font-weight: 700; text-decoration: none;">
                <i class="bi bi-calendar-check-fill"></i> Book Your Vaccination
            </a>
            <a href="tel:<?php echo esc_attr( $phone ); ?>" class="btn btn-outline-light btn-lg px-5" style="border-radius: 999px;">
                <i class="bi bi-telephone-fill"></i> Speak With Our Team
            </a>
        </div>
    </div>
</section>

<style>
/* ---- hero additions ---- */
.hero-image-wrap { position: relative; }
.hero-trust-badge {
    position: absolute; bottom: -20px; left: 20px;
    background: white; border-radius: 16px; box-shadow: var(--shadow-lg);
    padding: 16px 20px; display: inline-flex; flex-direction: column; align-items: flex-start; gap: 2px;
}
.htb-num { font-size: 1.3rem; font-weight: 800; color: var(--accent-blue); line-height: 1; }
.htb-label { font-size: 0.76rem; color: var(--text-light); font-weight: 600; }

/* ---- home search ---- */
.home-search-wrap { max-width: 560px; }
.home-search-group { border-radius: 50px; overflow: hidden; box-shadow: var(--shadow-md); }
.home-search-group .input-group-text, .home-search-group .form-control { border: none; padding: 16px 18px; font-size: 1rem; }
.home-search-group .form-control:focus { box-shadow: none; }
.home-search-results { position: relative; z-index: 5; margin-top: 8px; max-height: 360px; overflow-y: auto; }
.home-search-results:not(:empty) { background: white; border-radius: 16px; box-shadow: var(--shadow-lg); padding: 10px; }
.home-search-chips { display: flex; flex-wrap: wrap; gap: 8px; }
.home-chip {
    font-size: 0.82rem; font-weight: 700; padding: 7px 16px; border-radius: 50px;
    background: white; border: 1.5px solid var(--color-sand); color: var(--text-dark); text-decoration: none;
}
.home-chip:hover { border-color: var(--primary-gradient-start); color: var(--primary-gradient-start); }

.hero-stats-grid { border-radius: 20px; overflow: hidden; background: white; box-shadow: var(--shadow-md); }
.hero-stat-cell { padding: 24px 16px; text-align: center; border: 1px solid var(--color-sand); }
.hero-stat-num { font-size: 1.8rem; font-weight: 800; color: var(--accent-blue); line-height: 1; margin-bottom: 6px; }
.hero-stat-lbl { font-size: 0.82rem; color: var(--text-light); font-weight: 600; }

/* ---- knowledge categories ---- */
.knowledge-cat-card {
    display: block; text-align: center; background: white; border: 1px solid var(--color-sand); border-radius: 16px;
    padding: 22px 12px; text-decoration: none; color: inherit; height: 100%; transition: var(--transition);
}
.knowledge-cat-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); color: inherit; border-color: transparent; }
.knowledge-cat-icon {
    width: 48px; height: 48px; margin: 0 auto 12px; border-radius: 12px; background: var(--color-blue-tint);
    color: var(--color-blue); display: flex; align-items: center; justify-content: center; font-size: 1.3rem;
}
.knowledge-cat-card h6 { font-weight: 700; font-size: 0.85rem; margin: 0; }

/* ---- most searched vaccines ---- */
.vsv-card { background: white; border: 1px solid var(--color-sand); border-radius: 16px; overflow: hidden; height: 100%; transition: var(--transition); }
.vsv-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); }
.vsv-card-img { position: relative; height: 140px; background: var(--bg-light); display: flex; align-items: center; justify-content: center; }
.vsv-card-img img { width: 100%; height: 100%; object-fit: cover; }
.vsv-card-img i { font-size: 2rem; color: var(--accent-blue); }
.vsv-badge { position: absolute; top: 10px; right: 10px; font-size: 0.68rem; font-weight: 700; padding: 3px 10px; border-radius: 50px; }
.vsv-badge-in { background: var(--color-green); color: white; }
.vsv-badge-out { background: #dc3545; color: white; }
.vsv-badge-soon { background: #ffc107; color: #000; }
.vsv-card-body { padding: 18px; }
.vsv-card-body h6 { font-weight: 700; margin-bottom: 6px; }
.vsv-card-body p { font-size: 0.82rem; color: var(--text-light); min-height: 38px; }
.vsv-age { font-size: 0.76rem; color: var(--text-light); margin-bottom: 10px; }
.vsv-actions { display: flex; gap: 8px; }
.vsv-actions a { flex: 1; text-align: center; font-size: 0.78rem; font-weight: 700; padding: 9px 10px; border-radius: 50px; text-decoration: none; }
.vsv-learn { background: var(--primary-gradient-start); color: white; }
.vsv-learn:hover { background: var(--primary-gradient-end); color: white; }
.vsv-book { border: 1.5px solid var(--color-sand); color: var(--text-light); }
.vsv-book:hover { border-color: var(--accent-blue); color: var(--accent-blue); }

/* ---- featured knowledge ---- */
.fk-card { display: block; background: white; border: 1px solid var(--color-sand); border-radius: 16px; text-decoration: none; color: inherit; height: 100%; transition: var(--transition); }
.fk-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); color: inherit; }
.fk-card-soon { opacity: 0.7; }
.fk-card-body { padding: 20px; }
.fk-badge { display: inline-flex; align-items: center; gap: 5px; font-size: 0.7rem; font-weight: 700; color: var(--color-blue); background: var(--color-blue-tint); padding: 4px 10px; border-radius: 50px; margin-bottom: 12px; }
.fk-card-body h6 { font-weight: 700; margin-bottom: 10px; }
.fk-meta { display: flex; gap: 10px; flex-wrap: wrap; font-size: 0.74rem; color: var(--text-light); }
.fk-soon { color: var(--color-label-muted); font-weight: 700; }

/* ---- interactive tools ---- */
.tool-card { background: white; border: 1px solid var(--color-sand); border-radius: 16px; padding: 24px 16px; text-align: center; height: 100%; }
.tool-icon { width: 50px; height: 50px; margin: 0 auto 14px; border-radius: 12px; background: var(--color-blue-tint); color: var(--color-blue); display: flex; align-items: center; justify-content: center; font-size: 1.3rem; }
.tool-card h6 { font-weight: 700; font-size: 0.88rem; margin-bottom: 8px; }
.tool-card p { font-size: 0.76rem; color: var(--text-light); min-height: 50px; }
.tool-soon { display: inline-block; font-size: 0.7rem; font-weight: 700; color: var(--color-label-muted); background: var(--color-sand); padding: 4px 10px; border-radius: 50px; }

/* ---- schedule strip ---- */
.schedule-strip { display: flex; gap: 14px; overflow-x: auto; padding: 10px 4px 20px; }
.schedule-strip-item { flex: 0 0 auto; display: flex; flex-direction: column; align-items: center; gap: 8px; text-decoration: none; min-width: 90px; }
.schedule-strip-dot { width: 16px; height: 16px; border-radius: 50%; background: var(--color-blue); }
.schedule-strip-label { font-size: 0.8rem; font-weight: 700; color: var(--text-dark); text-align: center; }
.schedule-strip-item:hover .schedule-strip-label { color: var(--accent-blue); }

/* ---- disease library ---- */
.disease-lib-card { display: block; background: white; border: 1px solid var(--color-sand); border-radius: 16px; padding: 26px; text-decoration: none; color: inherit; height: 100%; transition: var(--transition); }
.disease-lib-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); color: inherit; }
.disease-lib-icon { width: 50px; height: 50px; border-radius: 12px; background: var(--color-blue-tint); color: var(--color-blue); display: flex; align-items: center; justify-content: center; font-size: 1.3rem; margin-bottom: 14px; }
.disease-lib-card h6 { font-weight: 700; margin-bottom: 8px; }
.disease-lib-card p { font-size: 0.82rem; color: var(--text-light); margin: 0; }

/* ---- brand cards ---- */
.brand-home-card { display: block; text-align: center; background: white; border: 1px solid var(--color-sand); border-radius: 16px; padding: 20px; text-decoration: none; color: inherit; transition: var(--transition); }
.brand-home-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); color: inherit; }
.brand-home-img { height: 90px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; }
.brand-home-img img { max-height: 90px; max-width: 100%; object-fit: contain; }
.brand-home-img i { font-size: 2rem; color: var(--accent-blue); }
.brand-home-card h6 { font-weight: 700; font-size: 0.88rem; margin: 0; }

/* ---- why vaccinepk ---- */
.why-card { display: flex; align-items: center; gap: 12px; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08); border-radius: 14px; padding: 16px; height: 100%; }
.why-card i { font-size: 1.3rem; color: var(--color-sub-on-blue); }
.why-card span { font-weight: 700; color: white; font-size: 0.86rem; }

/* ---- cities ---- */
.city-home-chip { display: flex; align-items: center; gap: 8px; justify-content: center; background: white; border: 1px solid var(--color-sand); border-radius: 12px; padding: 16px; font-weight: 700; text-decoration: none; color: var(--text-dark); transition: var(--transition); }
.city-home-chip:hover { border-color: var(--accent-blue); color: var(--accent-blue); }
.city-home-chip-static { color: var(--text-light); cursor: default; }
.city-home-chip i { color: var(--accent-blue); }

/* ---- faq accordion ---- */
.accordion-item { border: none; margin-bottom: 14px; border-radius: 14px !important; overflow: hidden; box-shadow: var(--shadow-sm); }
.accordion-button { font-weight: 700; color: var(--text-dark); }
.accordion-button:not(.collapsed) { background: var(--color-blue-tint); color: var(--color-blue); box-shadow: none; }
.accordion-button:focus { box-shadow: none; }

@media (max-width: 991px) {
    .hero-trust-badge { position: static; margin-top: 16px; display: inline-flex; }
}
@media (max-width: 768px) {
    section.py-5 { padding: 60px 0 !important; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof vaccinationCentreInitSearch === 'function') {
        vaccinationCentreInitSearch(
            { input: 'homeSearchInput', results: 'homeSearchResults', loading: 'homeSearchLoading' },
            { phone: '<?php echo esc_js( $phone ); ?>', whatsapp: '<?php echo esc_js( $whatsapp ); ?>' }
        );
    }
});
</script>

<?php get_footer(); ?>
