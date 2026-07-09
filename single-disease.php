<?php
/**
 * Single Disease Template
 */
get_header();

$symptoms      = get_post_meta( get_the_ID(), 'disease_symptoms', true );
$complications = get_post_meta( get_the_ID(), 'disease_complications', true );
$prevention    = get_post_meta( get_the_ID(), 'disease_prevention', true );
$transmission  = get_post_meta( get_the_ID(), 'disease_transmission', true );

// Find vaccines that protect against this disease (free-text match on vaccine.disease_name)
$disease_title  = get_the_title();
$related_vaccines = get_posts( [
    'post_type'      => 'vaccine',
    'post_status'    => 'publish',
    'posts_per_page' => 6,
    'meta_query'     => [ [
        'key'     => 'disease_name',
        'value'   => $disease_title,
        'compare' => 'LIKE',
    ] ],
] );
?>

<style>
.disease-hero {
    background: linear-gradient(135deg, #da7215 0%, #d35324 100%);
    color: white; padding: 60px 0; margin-bottom: 50px;
}
.disease-detail-card {
    background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    padding: 40px; margin-bottom: 30px;
}
.disease-detail-card h2 { color: #da7215; font-weight: 700; margin-bottom: 16px; }
.disease-detail-card p { line-height: 1.8; color: #555; white-space: pre-line; }
.vaccine-chip-link {
    display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px;
    border-radius: 50px; background: #f0f9ff; border: 1.5px solid #107fa0;
    color: #107fa0; font-weight: 600; text-decoration: none; margin: 0 8px 8px 0;
}
.vaccine-chip-link:hover { background: #107fa0; color: white; }
</style>

<section class="disease-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="background: transparent;">
                <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>" style="color:rgba(255,255,255,0.8);text-decoration:none;">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo home_url('/diseases'); ?>" style="color:rgba(255,255,255,0.8);text-decoration:none;">Diseases</a></li>
                <li class="breadcrumb-item active" aria-current="page" style="color:white;"><?php the_title(); ?></li>
            </ol>
        </nav>
        <h1 class="display-4 fw-bold mb-2"><i class="bi bi-virus2 me-3"></i><?php the_title(); ?></h1>
        <p class="lead mb-0">Symptoms, complications, prevention, and vaccination guidance.</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <?php if ( $symptoms ) : ?>
                <div class="disease-detail-card">
                    <h2><i class="bi bi-clipboard2-pulse me-2"></i>Symptoms</h2>
                    <p><?php echo esc_html( $symptoms ); ?></p>
                </div>
                <?php endif; ?>

                <?php if ( $complications ) : ?>
                <div class="disease-detail-card">
                    <h2><i class="bi bi-exclamation-triangle me-2"></i>Complications</h2>
                    <p><?php echo esc_html( $complications ); ?></p>
                </div>
                <?php endif; ?>

                <?php if ( $prevention ) : ?>
                <div class="disease-detail-card">
                    <h2><i class="bi bi-shield-check me-2"></i>Prevention</h2>
                    <p><?php echo esc_html( $prevention ); ?></p>
                </div>
                <?php endif; ?>

                <?php if ( $transmission ) : ?>
                <div class="disease-detail-card">
                    <h2><i class="bi bi-arrow-left-right me-2"></i>Transmission</h2>
                    <p><?php echo esc_html( $transmission ); ?></p>
                </div>
                <?php endif; ?>

                <?php if ( get_the_content() ) : ?>
                <div class="disease-detail-card">
                    <h2><i class="bi bi-info-circle me-2"></i>More Information</h2>
                    <div><?php the_content(); ?></div>
                </div>
                <?php endif; ?>
            </div>

            <div class="col-lg-4">
                <div class="disease-detail-card">
                    <h2 style="font-size: 1.3rem;"><i class="bi bi-shield-fill-check me-2"></i>Vaccination</h2>
                    <?php if ( $related_vaccines ) : ?>
                        <p class="text-muted mb-3">Vaccines that protect against <?php echo esc_html( $disease_title ); ?>:</p>
                        <div>
                            <?php foreach ( $related_vaccines as $v ) : ?>
                                <a href="<?php echo esc_url( get_permalink( $v->ID ) ); ?>" class="vaccine-chip-link">
                                    <i class="bi bi-shield-fill-check"></i> <?php echo esc_html( $v->post_title ); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <p class="text-muted">Contact us to find out which vaccine protects against this disease.</p>
                    <?php endif; ?>
                    <a href="<?php echo esc_url( site_url( '/booking' ) ); ?>" class="btn btn-primary w-100 mt-3">
                        <i class="bi bi-calendar-check-fill me-2"></i>Book Vaccination
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
