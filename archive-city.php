<?php
/**
 * Archive Template - Cities We Serve Hub
 */
get_header();
?>

<style>
.cities-hero {
    background: linear-gradient(135deg, #f6f3ec 0%, #efe9db 100%);
    padding: 80px 0 60px;
}
.city-hub-card {
    background: #fff; border: 1px solid var(--color-sand); border-radius: 18px;
    padding: 28px; height: 100%; transition: var(--transition);
    text-decoration: none; display: block; color: inherit;
}
.city-hub-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); color: inherit; }
.city-hub-icon {
    width: 54px; height: 54px; border-radius: 14px; display: flex; align-items: center;
    justify-content: center; font-size: 1.4rem; margin-bottom: 14px;
    background: var(--color-blue-tint); color: var(--color-blue);
}
.city-hub-card h3 { font-weight: 700; font-size: 1.15rem; margin-bottom: 8px; }
.city-hub-card p { color: var(--text-light); font-size: 0.88rem; margin-bottom: 0; }
</style>

<section class="cities-hero">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb" style="background: transparent;">
                <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>" style="color:#0b5c87;text-decoration:none;"><i class="bi bi-house-fill"></i> Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Cities</li>
            </ol>
        </nav>
        <h1 class="display-4 fw-bold mb-3" style="color:#0b5c87;">Cities We Serve</h1>
        <p class="lead" style="color:#4a575e;max-width:640px;">Home and clinic vaccination across Pakistan's major cities.</p>
    </div>
</section>

<section class="py-5" style="background: white;">
    <div class="container">
        <div class="row g-4">
            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post();
                    $response_time = get_post_meta( get_the_ID(), 'city_response_time', true );
                ?>
                    <div class="col-lg-3 col-md-6">
                        <a href="<?php the_permalink(); ?>" class="city-hub-card">
                            <div class="city-hub-icon"><i class="bi bi-geo-alt-fill"></i></div>
                            <h3><?php the_title(); ?></h3>
                            <?php if ( $response_time ) : ?>
                                <p><i class="bi bi-clock"></i> <?php echo esc_html( $response_time ); ?></p>
                            <?php endif; ?>
                        </a>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <div class="col-12 text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 64px; color: var(--color-sand);"></i>
                    <p class="text-muted mt-3 mb-0">City pages are being added. Please check back soon or <a href="<?php echo home_url('/contact'); ?>">contact us</a>.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
