<?php
/**
 * Template Name: About Page
 * Description: About Us page template for Vaccine.Pk
 */
get_header();
?>

<!-- ================= PAGE HEADER ================= -->
<section class="page-header" style="background: linear-gradient(160deg, var(--color-navy) 0%, #0e3446 55%, var(--color-navy) 100%); padding: 80px 0 60px; position: relative; overflow: hidden;">
    <div style="position: absolute; top: -50%; right: -10%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(201, 162, 75, 0.14) 0%, transparent 70%); border-radius: 50%;"></div>
    <div style="position: absolute; bottom: -30%; left: -5%; width: 400px; height: 400px; background: radial-gradient(circle, rgba(107, 182, 63, 0.12) 0%, transparent 70%); border-radius: 50%;"></div>

    <div class="container" style="position: relative; z-index: 1;">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb justify-content-center" style="background: transparent;">
                        <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>" style="color: var(--color-sub-on-blue); text-decoration: none;"><i class="bi bi-house-fill"></i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: var(--color-ivory);">About Us</li>
                    </ol>
                </nav>
                <h1 class="display-4 fw-bold mb-3" style="color: var(--color-ivory);">About Vaccine.Pk</h1>
                <p class="lead" style="color: var(--color-sub-on-blue);">Your trusted partner in home vaccination services</p>
            </div>
        </div>
    </div>
</section>

<!-- ================= OUR STORY ================= -->
<section class="py-5" style="background: white;">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="badge-custom"><i class="bi bi-heart-pulse-fill"></i> Our Story</span>
                <h2 class="fw-bold mb-4" style="color: var(--color-navy);">Bringing Healthcare to Your Doorstep</h2>
                <p class="text-muted mb-4" style="line-height: 1.8;">
                    Vaccine.Pk was founded with a simple yet powerful mission: to make vaccination accessible,
                    convenient, and stress-free for families across Pakistan. We understand that visiting hospitals 
                    or clinics with young children can be challenging, especially in today's fast-paced world.
                </p>
                <p class="text-muted mb-4" style="line-height: 1.8;">
                    Our team of qualified healthcare professionals brings years of experience in pediatric care 
                    and immunization. We are committed to providing WHO-compliant vaccination services in the 
                    comfort and safety of your home.
                </p>
                <div class="d-flex gap-4 mt-4">
                    <div>
                        <h3 class="fw-bold mb-0" style="color: var(--color-gold);">800K+</h3>
                        <p class="text-muted mb-0">Happy Families</p>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0" style="color: var(--color-blue);">800,000+</h3>
                        <p class="text-muted mb-0">Vaccines Administered</p>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0" style="color: var(--color-green);">100%</h3>
                        <p class="text-muted mb-0">Safety Record</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <img 
                    src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=800&q=80" 
                    alt="Healthcare Professional" 
                    class="img-fluid rounded-4 shadow-lg"
                    style="position: relative;"
                >
            </div>
        </div>
    </div>
</section>

<!-- ================= OUR MISSION & VISION ================= -->
<section class="py-5" style="background: var(--color-blue-tint);">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="bg-white p-5 rounded-4 shadow h-100">
                    <div class="mb-4">
                        <div style="width: 70px; height: 70px; background: linear-gradient(135deg, var(--color-blue), var(--color-navy)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 32px;">
                            <i class="bi bi-bullseye"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold mb-4" style="color: var(--color-navy);">Our Mission</h3>
                    <p class="text-muted mb-3" style="line-height: 1.8;">
                        To provide accessible, reliable, and high-quality home vaccination services that protect
                        children and adults from preventable diseases, while ensuring convenience and peace of mind
                        for families.
                    </p>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="bi bi-check-circle-fill" style="color: var(--color-green);"></i> Deliver WHO-standard vaccines</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill" style="color: var(--color-green);"></i> Maintain highest safety protocols</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill" style="color: var(--color-green);"></i> Provide expert medical guidance</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill" style="color: var(--color-green);"></i> Ensure convenient home service</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="bg-white p-5 rounded-4 shadow h-100">
                    <div class="mb-4">
                        <div style="width: 70px; height: 70px; background: linear-gradient(135deg, var(--color-navy), var(--color-ink-strong)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 32px;">
                            <i class="bi bi-eye-fill"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold mb-4" style="color: var(--color-navy);">Our Vision</h3>
                    <p class="text-muted mb-3" style="line-height: 1.8;">
                        To become Pakistan's leading home healthcare service provider, ensuring every child and
                        adult has access to timely, safe, and professional vaccination services, contributing to
                        a healthier nation.
                    </p>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="bi bi-star-fill" style="color: var(--color-blue);"></i> Expand services nationwide</li>
                        <li class="mb-2"><i class="bi bi-star-fill" style="color: var(--color-blue);"></i> Partner with healthcare organizations</li>
                        <li class="mb-2"><i class="bi bi-star-fill" style="color: var(--color-blue);"></i> Innovate healthcare delivery</li>
                        <li class="mb-2"><i class="bi bi-star-fill" style="color: var(--color-blue);"></i> Raise vaccination awareness</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================= OUR VALUES ================= -->
<section class="py-5" style="background: white;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold" style="color: var(--color-navy);">Our Core Values</h2>
            <p class="text-muted">The principles that guide everything we do</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="text-center p-4">
                    <div class="mb-3">
                        <div style="width: 80px; height: 80px; background: var(--color-green-tint); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; color: var(--color-green); font-size: 36px;">
                            <i class="bi bi-shield-fill-check"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-3">Safety First</h5>
                    <p class="text-muted small">Strict adherence to international safety standards and WHO guidelines</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="text-center p-4">
                    <div class="mb-3">
                        <div style="width: 80px; height: 80px; background: var(--color-blue-tint); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; color: var(--color-blue); font-size: 36px;">
                            <i class="bi bi-hand-thumbs-up-fill"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-3">Trust & Integrity</h5>
                    <p class="text-muted small">Building lasting relationships through honest and transparent service</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="text-center p-4">
                    <div class="mb-3">
                        <div style="width: 80px; height: 80px; background: var(--color-blue-tint); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; color: var(--color-navy); font-size: 36px;">
                            <i class="bi bi-award-fill"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-3">Excellence</h5>
                    <p class="text-muted small">Committed to delivering the highest quality of care and service</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="text-center p-4">
                    <div class="mb-3">
                        <div style="width: 80px; height: 80px; background: var(--color-green-tint); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; color: var(--color-green); font-size: 36px;">
                            <i class="bi bi-heart-fill"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-3">Compassion</h5>
                    <p class="text-muted small">Caring for families with empathy, respect, and understanding</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================= WHY CHOOSE US ================= -->
<section class="py-5" style="background: var(--color-ivory);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold" style="color: var(--color-navy);">Why Families Trust Vaccine.Pk</h2>
            <p class="text-muted">What makes us different from traditional vaccination services</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="bg-white p-4 rounded-4 shadow-sm h-100">
                    <div class="d-flex align-items-start mb-3">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--color-blue), var(--color-navy)); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; flex-shrink: 0;">
                            <i class="bi bi-house-heart-fill"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="fw-bold mb-2">Home Convenience</h5>
                            <p class="text-muted small mb-0">No need to travel to clinics. We come to you at your preferred time.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="bg-white p-4 rounded-4 shadow-sm h-100">
                    <div class="d-flex align-items-start mb-3">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--color-navy), var(--color-ink-strong)); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; flex-shrink: 0;">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="fw-bold mb-2">Expert Team</h5>
                            <p class="text-muted small mb-0">Qualified doctors and nurses with specialized pediatric training.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="bg-white p-4 rounded-4 shadow-sm h-100">
                    <div class="d-flex align-items-start mb-3">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--color-green), #57a02e); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; flex-shrink: 0;">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="fw-bold mb-2">Authentic Vaccines</h5>
                            <p class="text-muted small mb-0">Sourced from GSK, Pfizer, Sanofi, Merck with proper cold chain.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="bg-white p-4 rounded-4 shadow-sm h-100">
                    <div class="d-flex align-items-start mb-3">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--color-blue), var(--color-navy)); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; flex-shrink: 0;">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="fw-bold mb-2">Quick Service</h5>
                            <p class="text-muted small mb-0">Appointments within 24-48 hours. Emergency bookings available.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="bg-white p-4 rounded-4 shadow-sm h-100">
                    <div class="d-flex align-items-start mb-3">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--color-navy), var(--color-ink-strong)); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; flex-shrink: 0;">
                            <i class="bi bi-bell-fill"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="fw-bold mb-2">Smart Reminders</h5>
                            <p class="text-muted small mb-0">Automated SMS and email alerts for upcoming vaccinations.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="bg-white p-4 rounded-4 shadow-sm h-100">
                    <div class="d-flex align-items-start mb-3">
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--color-blue), var(--color-navy)); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; flex-shrink: 0;">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                        <div class="ms-3">
                            <h5 class="fw-bold mb-2">Transparent Pricing</h5>
                            <p class="text-muted small mb-0">Clear pricing with no hidden charges. Free consultation included.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================= OUR TEAM (Dynamic via Pods CPT) ================= -->
<section class="py-5" style="background: white;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold" style="color: var(--color-navy);">Meet Our Team</h2>
            <p class="text-muted">Dedicated healthcare professionals committed to your family's health</p>
        </div>

        <?php
        // ── Badge colour cycle (matches site palette) ─────────────────────
        $badge_gradients = [
            'linear-gradient(135deg, #0B5C87, #0A2A38)',
            'linear-gradient(135deg, #0A2A38, #16232B)',
            'linear-gradient(135deg, #0B5C87, #0A2A38)',
            'linear-gradient(135deg, #0A2A38, #16232B)',
        ];

        // ── Placeholder avatar (shown when no featured image is set) ──────
        $placeholder = 'https://ui-avatars.com/api/?background=EAF2F6&color=0B5C87&size=400&bold=true&name=';

        // ── Query the 'team' custom post type ─────────────────────────────
        $team_query = new WP_Query( [
            'post_type'      => 'team',
            'post_status'    => 'publish',
            'posts_per_page' => -1,           // show all team members
            'orderby'        => 'menu_order', // respect manual ordering if set
            'order'          => 'ASC',
        ] );

        if ( $team_query->have_posts() ) :
            $col_index = 0;
        ?>
        <div class="row g-4 justify-content-center">

            <?php while ( $team_query->have_posts() ) : $team_query->the_post();

                // ── Data ──────────────────────────────────────────────────
                $doctor_name   = get_the_title();

                // Featured image — try large first, fall back to medium, then placeholder
                if ( has_post_thumbnail() ) {
                    $img_src = get_the_post_thumbnail_url( get_the_ID(), 'large' )
                             ?: get_the_post_thumbnail_url( get_the_ID(), 'medium' );
                } else {
                    $img_src = $placeholder . urlencode( $doctor_name );
                }

                // Pods meta fields — get_post_meta works for all Pods field types
                // Try both with and without leading underscore (some Pods versions prefix)
                $designation   = get_post_meta( get_the_ID(), 'designation',   true );
                $qualification = get_post_meta( get_the_ID(), 'qualification', true );

                // Fallback: query via pods() API if standard meta is empty
                if ( ( empty( $designation ) || empty( $qualification ) ) && function_exists( 'pods' ) ) {
                    $pod = pods( 'team', get_the_ID() );
                    if ( $pod ) {
                        if ( empty( $designation ) )   $designation   = $pod->field( 'designation' );
                        if ( empty( $qualification ) ) $qualification = $pod->field( 'qualification' );
                    }
                }

                // Pick badge colour cyclically
                $badge_style = $badge_gradients[ $col_index % count( $badge_gradients ) ];
                $col_index++;
            ?>

            <div class="col-lg-3 col-md-6 col-sm-10">
                <div class="text-center vc-team-card">

                    <!-- Doctor Photo -->
                    <div class="mb-3 position-relative vc-team-img-wrap" style="display: inline-block;">
                        <img
                            src="<?php echo esc_url( $img_src ); ?>"
                            alt="<?php echo esc_attr( $doctor_name ); ?>"
                            class="img-fluid rounded-circle"
                            style="width: 200px; height: 200px; object-fit: cover; border: 5px solid #fff; box-shadow: 0 10px 30px rgba(0,0,0,0.12);"
                            loading="lazy"
                        >
                        <!-- Online indicator dot -->
                        <span style="
                            position: absolute;
                            bottom: 12px;
                            right: 12px;
                            width: 16px;
                            height: 16px;
                            background: var(--color-green);
                            border: 3px solid #fff;
                            border-radius: 50%;
                            display: block;
                        " title="Active"></span>
                    </div>

                    <!-- Name -->
                    <h5 class="fw-bold mb-1" style="color: var(--color-navy);">
                        <?php echo esc_html( $doctor_name ); ?>
                    </h5>

                    <!-- Designation -->
                    <?php if ( ! empty( $designation ) ) : ?>
                        <p class="text-muted small mb-2" style="line-height: 1.4;">
                            <?php echo esc_html( $designation ); ?>
                        </p>
                    <?php endif; ?>

                    <!-- Qualification badge -->
                    <?php if ( ! empty( $qualification ) ) : ?>
                        <div>
                            <span class="badge" style="background: <?php echo $badge_style; ?>; color: white; font-size: 11px; padding: 5px 10px; border-radius: 20px;">
                                <?php echo esc_html( $qualification ); ?>
                            </span>
                        </div>
                    <?php endif; ?>

                </div><!-- /.vc-team-card -->
            </div>

            <?php endwhile; wp_reset_postdata(); ?>

        </div><!-- /.row -->

        <?php else : ?>

            <!-- No team members published yet -->
            <div class="text-center py-5">
                <i class="bi bi-people" style="font-size: 56px; color: #d1d5db;"></i>
                <p class="text-muted mt-3 mb-0">No team members found.</p>
                <?php if ( current_user_can( 'edit_posts' ) ) : ?>
                    <a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=team' ) ); ?>" class="btn btn-sm btn-outline-primary mt-3">
                        <i class="bi bi-plus-circle"></i> Add Team Member
                    </a>
                <?php endif; ?>
            </div>

        <?php endif; ?>

    </div>
</section>

<style>
/* ── Team card hover lift ──────────────────────────────────── */
.vc-team-card {
    transition: transform .25s ease;
}
.vc-team-card:hover {
    transform: translateY(-6px);
}
.vc-team-img-wrap img {
    transition: box-shadow .25s ease;
}
.vc-team-card:hover .vc-team-img-wrap img {
    box-shadow: 0 18px 42px rgba(10,42,56,.22) !important;
}
</style>

<!-- ================= CERTIFICATIONS ================= -->
<section class="py-5" style="background: var(--color-blue-tint);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold" style="color: var(--color-navy);">Certifications & Compliance</h2>
            <p class="text-muted">Recognized and approved by leading health authorities</p>
        </div>

        <div class="row g-4 align-items-center justify-content-center">
            <div class="col-lg-3 col-md-4 col-6 text-center">
                <div class="bg-white p-4 rounded-4 shadow-sm">
                    <i class="bi bi-shield-fill-check" style="font-size: 48px; color: var(--color-green);"></i>
                    <h6 class="fw-bold mt-3 mb-0">WHO Approved</h6>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-6 text-center">
                <div class="bg-white p-4 rounded-4 shadow-sm">
                    <i class="bi bi-hospital" style="font-size: 48px; color: var(--color-blue);"></i>
                    <h6 class="fw-bold mt-3 mb-0">Ministry of Health</h6>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-6 text-center">
                <div class="bg-white p-4 rounded-4 shadow-sm">
                    <i class="bi bi-award-fill" style="font-size: 48px; color: var(--color-navy);"></i>
                    <h6 class="fw-bold mt-3 mb-0">ISO Certified</h6>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-6 text-center">
                <div class="bg-white p-4 rounded-4 shadow-sm">
                    <i class="bi bi-patch-check-fill" style="font-size: 48px; color: var(--color-green);"></i>
                    <h6 class="fw-bold mt-3 mb-0">EPI Compliant</h6>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================= CTA SECTION ================= -->
<section class="py-5" style="background: linear-gradient(135deg, var(--color-blue), var(--color-navy));">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 text-white mb-4 mb-lg-0">
                <h2 class="fw-bold mb-3">Ready to Experience Vaccine.Pk?</h2>
                <p class="mb-0" style="font-size: 18px;">Join thousands of families who trust us for their vaccination needs. Book your first appointment today!</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="<?php echo home_url('/contact'); ?>" class="btn px-5" style="background: var(--color-gold); color: var(--color-navy); border-radius: 999px; font-weight: 600; padding: 12px 28px; text-decoration: none; display: inline-block;">
                    Get Started <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>