<?php
/**
 * Template Name: Travel Vaccines Page
 */
get_header();

$travel_vaccines = new WP_Query( [
    'post_type'      => 'vaccine',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC',
    'tax_query'      => [ [
        'taxonomy' => 'vaccine_category',
        'field'    => 'slug',
        'terms'    => 'travel-vaccines',
    ] ],
] );
?>

<style>
.travel-hero {
    background: linear-gradient(135deg, #f6f3ec 0%, #efe9db 100%);
    padding: 80px 0 60px;
}
.travel-vaccine-card {
    background: white; border: 1px solid var(--color-sand); border-radius: 18px; padding: 28px;
    height: 100%; transition: var(--transition);
}
.travel-vaccine-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); }
.travel-tags span {
    font-size: 0.7rem; font-weight: 700; background: var(--bg-light); border: 1px solid var(--color-sand);
    color: var(--text-light); padding: 4px 10px; border-radius: 50px; margin: 0 6px 6px 0; display: inline-block;
}
</style>

<section class="travel-hero">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb" style="background: transparent;">
                <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>" style="color:#0b5c87;text-decoration:none;"><i class="bi bi-house-fill"></i> Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Travel Vaccines</li>
            </ol>
        </nav>
        <h1 class="display-4 fw-bold mb-3" style="color:#0b5c87;">Travel Vaccines</h1>
        <p class="lead" style="color:#4a575e;max-width:640px;">Meet entry requirements for pilgrimage (Hajj &amp; Umrah) and international travel, with certified documentation.</p>
        <div class="travel-tags mt-3">
            <span>Yellow Fever</span><span>Hajj</span><span>Umrah</span><span>Typhoid</span><span>Meningococcal</span>
        </div>
    </div>
</section>

<section class="py-5" style="background: white;">
    <div class="container">
        <div class="row g-4">
            <?php if ( $travel_vaccines->have_posts() ) : ?>
                <?php while ( $travel_vaccines->have_posts() ) : $travel_vaccines->the_post();
                    $availability = get_post_meta( get_the_ID(), 'availability', true );
                    $age          = get_post_meta( get_the_ID(), 'age_requirement', true );
                ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="travel-vaccine-card">
                            <h3 class="fw-bold mb-2" style="font-size: 1.15rem;"><?php the_title(); ?></h3>
                            <p class="text-muted small"><?php echo esc_html( wp_trim_words( get_the_excerpt() ?: get_the_content(), 18 ) ); ?></p>
                            <?php if ( $age ) : ?>
                                <p class="small mb-3"><i class="bi bi-calendar-check"></i> <?php echo esc_html( $age ); ?></p>
                            <?php endif; ?>
                            <div class="d-flex gap-2">
                                <a href="<?php the_permalink(); ?>" class="btn btn-primary btn-sm flex-grow-1">Learn More</a>
                                <a href="<?php echo esc_url( site_url( '/booking' ) ); ?>" class="btn btn-outline-primary btn-sm flex-grow-1">Book</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            <?php else : ?>
                <div class="col-12 text-center py-5">
                    <i class="bi bi-airplane" style="font-size: 64px; color: var(--color-sand);"></i>
                    <p class="text-muted mt-3 mb-0">Travel vaccine listings are being added. Please <a href="<?php echo home_url('/contact'); ?>">contact us</a> for current requirements.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
