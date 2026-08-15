<?php
/**
 * Template Name: Vaccines Page
 * Flat list of every vaccine, each showing its linked brands (photo,
 * price, availability) with a link through to the vaccine's own page
 * for the full description. No category tabs — category shows as a
 * tag on each entry instead, since a single vaccine can span more
 * than one category (e.g. Hepatitis B is both Child and Adult).
 */
get_header();

$vaccines_query = new WP_Query( [
    'post_type'      => 'vaccine',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC',
] );

// Every brand grouped by its Parent Vaccine relationship, same lookup
// pattern as single-vaccine.php and /pricing.
$all_brands       = get_posts( [ 'post_type' => 'brand', 'post_status' => 'publish', 'posts_per_page' => -1 ] );
$brands_by_vaccine = [];
foreach ( $all_brands as $b ) {
    $b_pod   = pods( 'brand', $b->ID );
    $related = $b_pod->field( 'parent_vaccine' );
    if ( ! is_array( $related ) || empty( $related ) ) continue;

    $first      = reset( $related );
    $vaccine_id = is_array( $first ) ? (int) ( $first['ID'] ?? 0 ) : (int) $first;
    if ( ! $vaccine_id ) continue;

    $brands_by_vaccine[ $vaccine_id ][] = $b;
}
?>

<!-- ================= PAGE HEADER ================= -->
<section class="page-header" style="background: linear-gradient(135deg, #f6f3ec 0%, #efe9db 100%); padding: 80px 0 60px; position: relative; overflow: hidden;">
    <div style="position: absolute; top: -50%; right: -10%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(201, 162, 75, 0.12) 0%, transparent 70%); border-radius: 50%;"></div>
    <div style="position: absolute; bottom: -30%; left: -5%; width: 400px; height: 400px; background: radial-gradient(circle, rgba(11, 92, 135, 0.1) 0%, transparent 70%); border-radius: 50%;"></div>

    <div class="container" style="position: relative; z-index: 1;">
        <div class="row">
            <div class="col-lg-10 mx-auto text-center">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb justify-content-center" style="background: transparent;">
                        <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>" style="color: #0b5c87; text-decoration: none;"><i class="bi bi-house-fill"></i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Our Vaccines</li>
                    </ol>
                </nav>
                <h1 class="display-4 fw-bold mb-3" style="color: #0b5c87;">Available Vaccines</h1>
                <p class="lead" style="color: #4a575e;">Browse our comprehensive range of WHO-approved vaccines</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5" style="background: white;">
    <div class="container" style="max-width: 1100px;">

        <?php if ( $vaccines_query->have_posts() ) : ?>

            <?php while ( $vaccines_query->have_posts() ) : $vaccines_query->the_post();
                $vaccine_id   = get_the_ID();
                $disease_name = get_post_meta( $vaccine_id, 'disease_name', true );
                $cat_terms    = get_the_terms( $vaccine_id, 'vaccine_category' );
                $cat_labels   = ( $cat_terms && ! is_wp_error( $cat_terms ) ) ? wp_list_pluck( $cat_terms, 'name' ) : [];
                $brands       = $brands_by_vaccine[ $vaccine_id ] ?? [];
            ?>

            <div class="qv-entry">
                <div class="qv-entry-head">
                    <div>
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <?php if ( $disease_name ) : ?><p class="qv-disease"><?php echo esc_html( $disease_name ); ?></p><?php endif; ?>
                    </div>
                    <?php if ( $cat_labels ) : ?>
                    <div class="qv-tags">
                        <?php foreach ( $cat_labels as $label ) : ?>
                            <span class="qv-tag"><?php echo esc_html( $label ); ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <?php if ( $brands ) : ?>
                <div class="qv-brand-row">
                    <?php foreach ( $brands as $brand ) :
                        $thumb      = get_the_post_thumbnail_url( $brand->ID, 'medium' );
                        $price      = get_post_meta( $brand->ID, 'price', true );
                        $avail      = get_post_meta( $brand->ID, 'availability', true );
                        $avail_bool = ( $avail === '1' || strtolower( $avail ) === 'yes' || $avail === true );
                    ?>
                    <div class="qv-brand<?php echo $avail_bool ? '' : ' qv-brand-oos'; ?>">
                        <div class="qv-brand-img">
                            <?php if ( $thumb ) : ?>
                                <img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( $brand->post_title ); ?>">
                            <?php else : ?>
                                <i class="bi bi-shield-fill-check"></i>
                            <?php endif; ?>
                        </div>
                        <div class="qv-brand-name"><?php echo esc_html( $brand->post_title ); ?></div>
                        <div class="qv-brand-bottom">
                            <?php if ( $price ) : ?>
                                <span class="qv-brand-price">PKR <?php echo esc_html( number_format( (float) $price ) ); ?></span>
                            <?php endif; ?>
                            <span class="qv-brand-avail <?php echo $avail_bool ? 'yes' : 'no'; ?>"><?php echo $avail_bool ? '✓' : '✗'; ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else : ?>
                <p class="qv-no-brands">Brand information is being added.</p>
                <?php endif; ?>

                <a href="<?php the_permalink(); ?>" class="qv-details-link">
                    View details &amp; description <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <?php endwhile; wp_reset_postdata(); ?>

        <?php else : ?>
            <div class="text-center py-5">
                <i class="bi bi-inbox" style="font-size: 64px; color: #e7e0d3;"></i>
                <p class="text-muted mt-3 mb-0">Vaccines are being added. Please check back soon.</p>
            </div>
        <?php endif; ?>

        <!-- DIRECT BOOKING BUTTON -->
        <div class="text-center mt-5">
            <a href="<?php echo home_url('/booking'); ?>" class="btn btn-lg px-5 py-3" style="background: #c9a24b; color: #0a2a38; border: none; border-radius: 50px; font-weight: 700; font-size: 18px; text-decoration: none; display: inline-block; transition: all 0.3s;">
                <i class="bi bi-calendar-check-fill me-2"></i> Book Your Vaccination Now
            </a>
        </div>

    </div>
</section>

<!-- ================= INFO SECTION ================= -->
<section class="py-5" style="background: linear-gradient(135deg, #f6f3ec 0%, #eef3ea 100%);">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6 text-center">
                <div class="bg-white p-4 rounded-4 shadow-sm">
                    <i class="bi bi-shield-check" style="font-size: 48px; color: #7bb14f;"></i>
                    <h6 class="fw-bold mt-3 mb-2">WHO Approved</h6>
                    <p class="text-muted small mb-0">All vaccines are WHO certified</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="bg-white p-4 rounded-4 shadow-sm">
                    <i class="bi bi-thermometer-snow" style="font-size: 48px; color: #0b5c87;"></i>
                    <h6 class="fw-bold mt-3 mb-2">Cold Chain</h6>
                    <p class="text-muted small mb-0">Proper storage maintained</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="bg-white p-4 rounded-4 shadow-sm">
                    <i class="bi bi-house-heart" style="font-size: 48px; color: #0b5c87;"></i>
                    <h6 class="fw-bold mt-3 mb-2">Home Service</h6>
                    <p class="text-muted small mb-0">Vaccination at your doorstep</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="bg-white p-4 rounded-4 shadow-sm">
                    <i class="bi bi-people" style="font-size: 48px; color: #0b5c87;"></i>
                    <h6 class="fw-bold mt-3 mb-2">Expert Team</h6>
                    <p class="text-muted small mb-0">Qualified medical professionals</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.qv-entry {
    border-bottom: 1px solid #e7e0d3;
    padding: 32px 0;
}
.qv-entry:first-of-type { padding-top: 0; }
.qv-entry-head {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 16px;
}
.qv-entry-head h2 { font-size: 1.4rem; margin: 0 0 4px; }
.qv-entry-head h2 a { color: #0a2a38; text-decoration: none; }
.qv-entry-head h2 a:hover { color: #0b5c87; }
.qv-disease { margin: 0; color: #4a575e; font-size: 13.5px; }
.qv-tags { display: flex; gap: 6px; flex-wrap: wrap; }
.qv-tag {
    font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 100px;
    background: #eaf2f6; color: #0b5c87; white-space: nowrap;
}

.qv-brand-row { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 14px; }
.qv-brand {
    width: 130px; background: #fff; border: 1px solid #e7e0d3; border-radius: 12px;
    overflow: hidden; text-align: center;
}
.qv-brand-img {
    height: 90px; background: linear-gradient(135deg, #eaf2f6, #cfe0e8);
    display: flex; align-items: center; justify-content: center; padding: 6px;
}
.qv-brand-img img { width: 100%; height: 100%; object-fit: contain; }
.qv-brand-img i { font-size: 1.5rem; color: #0b5c87; }
.qv-brand-name { font-size: 11.5px; font-weight: 700; padding: 8px 8px 4px; color: #16232b; }
.qv-brand-bottom { display: flex; align-items: center; justify-content: space-between; padding: 0 8px 10px; gap: 4px; }
.qv-brand-price { font-size: 11px; font-weight: 700; color: #c9a24b; }
.qv-brand-avail { font-size: 12px; font-weight: 800; }
.qv-brand-avail.yes { color: #5a9c34; }
.qv-brand-avail.no { color: #c0392b; }
.qv-brand-oos { opacity: 0.6; }
.qv-brand-oos .qv-brand-img img { filter: grayscale(1); }

.qv-no-brands { font-size: 13.5px; color: #8a959a; margin-bottom: 14px; }

.qv-details-link {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 13.5px; font-weight: 700; color: #0b5c87; text-decoration: none;
}
.qv-details-link:hover { color: #0a2a38; }
</style>

<?php get_footer(); ?>
