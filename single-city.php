<?php
/**
 * Single City Template
 */
get_header();

$areas         = get_post_meta( get_the_ID(), 'city_areas_covered', true );
$response_time = get_post_meta( get_the_ID(), 'city_response_time', true );
$address       = get_post_meta( get_the_ID(), 'city_clinic_address', true );

$site_settings = pods( 'site_contact_settings' );
$phone         = $site_settings->field( 'phone_number' );
$whatsapp      = $site_settings->field( 'whatsapp_number' );
?>

<style>
.city-hero {
    background: var(--color-navy);
    color: white; padding: 60px 0; margin-bottom: 50px;
}
.city-detail-card {
    background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(10,42,56,0.08);
    padding: 40px; margin-bottom: 30px;
}
.city-detail-card h2 { color: var(--color-blue); font-weight: 700; margin-bottom: 16px; }
</style>

<section class="city-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="background: transparent;">
                <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>" style="color:rgba(255,255,255,0.8);text-decoration:none;">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo home_url('/cities'); ?>" style="color:rgba(255,255,255,0.8);text-decoration:none;">Cities</a></li>
                <li class="breadcrumb-item active" aria-current="page" style="color:white;"><?php the_title(); ?></li>
            </ol>
        </nav>
        <h1 class="display-4 fw-bold mb-2"><i class="bi bi-geo-alt-fill me-3"></i>Vaccination Services in <?php the_title(); ?></h1>
        <?php if ( $response_time ) : ?>
            <p class="lead mb-0"><i class="bi bi-clock"></i> Typical response time: <?php echo esc_html( $response_time ); ?></p>
        <?php endif; ?>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <?php if ( $areas ) : ?>
                <div class="city-detail-card">
                    <h2><i class="bi bi-map me-2"></i>Areas Covered</h2>
                    <p class="text-muted"><?php echo esc_html( $areas ); ?></p>
                </div>
                <?php endif; ?>

                <?php if ( $address ) : ?>
                <div class="city-detail-card">
                    <h2><i class="bi bi-building me-2"></i>Clinic Address</h2>
                    <p class="text-muted"><?php echo esc_html( $address ); ?></p>
                </div>
                <?php endif; ?>

                <?php if ( get_the_content() ) : ?>
                <div class="city-detail-card">
                    <h2><i class="bi bi-info-circle me-2"></i>More Information</h2>
                    <div><?php the_content(); ?></div>
                </div>
                <?php endif; ?>
            </div>

            <div class="col-lg-4">
                <div class="city-detail-card text-center">
                    <h2 style="font-size: 1.3rem;">Book in <?php the_title(); ?></h2>
                    <p class="text-muted mb-4">Home and clinic vaccination available.</p>
                    <div class="d-flex flex-column gap-2">
                        <a href="<?php echo esc_url( site_url( '/booking' ) ); ?>" class="btn btn-primary">
                            <i class="bi bi-calendar-check-fill me-2"></i>Book Now
                        </a>
                        <?php if ( $phone ) : ?>
                        <a href="tel:<?php echo esc_attr( $phone ); ?>" class="btn btn-outline-primary">
                            <i class="bi bi-telephone-fill me-2"></i>Call <?php echo esc_html( $phone ); ?>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
