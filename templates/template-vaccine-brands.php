<?php
/**
 * Template Name: Vaccine Brands Page
 */
get_header();

$brands = get_posts( [
    'post_type'      => 'brand',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'title',
    'order'          => 'ASC',
] );
?>

<style>
.brands-hero {
    background: linear-gradient(135deg, #e0f4ff 0%, #cceeff 100%);
    padding: 80px 0 60px;
}
.brand-card {
    background: white; border: 1px solid #eef0f2; border-radius: 18px; overflow: hidden;
    height: 100%; transition: var(--transition); text-decoration: none; color: inherit; display: block;
}
.brand-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); color: inherit; }
.brand-card-img { height: 140px; background: var(--bg-light); display: flex; align-items: center; justify-content: center; overflow: hidden; }
.brand-card-img img { width: 100%; height: 100%; object-fit: cover; }
.brand-card-body { padding: 20px; }
.brand-card-body h3 { font-size: 1.05rem; font-weight: 700; margin-bottom: 8px; }
.brand-card-meta { font-size: 0.82rem; color: var(--text-light); }
</style>

<section class="brands-hero">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb" style="background: transparent;">
                <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>" style="color:#da7215;text-decoration:none;"><i class="bi bi-house-fill"></i> Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Vaccine Brands</li>
            </ol>
        </nav>
        <h1 class="display-4 fw-bold mb-3" style="color:#107fa0;">Vaccine Brands</h1>
        <p class="lead" style="color:#6b7280;max-width:640px;">Genuine, imported vaccines from trusted multinational manufacturers, cold-chain protected from arrival to administration.</p>
    </div>
</section>

<section class="py-5" style="background: white;">
    <div class="container">
        <div class="row g-4">
            <?php if ( $brands ) : ?>
                <?php foreach ( $brands as $brand ) :
                    $thumb        = get_the_post_thumbnail_url( $brand->ID, 'medium' );
                    $disease      = get_post_meta( $brand->ID, 'disease', true );
                    $manufacturer = get_post_meta( $brand->ID, 'manufacturer_name', true );
                ?>
                    <div class="col-lg-3 col-md-4 col-6">
                        <a href="<?php echo esc_url( get_permalink( $brand->ID ) ); ?>" class="brand-card">
                            <div class="brand-card-img">
                                <?php if ( $thumb ) : ?>
                                    <img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( $brand->post_title ); ?>">
                                <?php else : ?>
                                    <i class="bi bi-shield-fill-check" style="font-size: 2rem; color: var(--accent-blue);"></i>
                                <?php endif; ?>
                            </div>
                            <div class="brand-card-body">
                                <h3><?php echo esc_html( $brand->post_title ); ?></h3>
                                <?php if ( $disease ) : ?>
                                    <p class="brand-card-meta mb-1"><i class="bi bi-virus"></i> <?php echo esc_html( $disease ); ?></p>
                                <?php endif; ?>
                                <?php if ( $manufacturer ) : ?>
                                    <p class="brand-card-meta mb-0"><i class="bi bi-building"></i> <?php echo esc_html( $manufacturer ); ?></p>
                                <?php endif; ?>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="col-12 text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 64px; color: #e5e7eb;"></i>
                    <p class="text-muted mt-3 mb-0">Brand information is being added. Please check back soon.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
