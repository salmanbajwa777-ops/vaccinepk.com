<?php
/**
 * Template for displaying single vaccine
 *
 * Shows every brand linked to this vaccine (via the brand pod's
 * Parent Vaccine relationship field) with its own photo/price/
 * availability, followed by the vaccine's own write-up.
 */

get_header();

$vaccine       = pods( 'vaccine', get_the_ID() );
$site_settings = pods( 'site_contact_settings' );

$disease_name         = $vaccine->field( 'disease_name' );
$vaccine_description  = $vaccine->field( 'vaccine_description' );

$phone     = $site_settings->field( 'phone_number' );
$whatsapp  = $site_settings->field( 'whatsapp_number' );
$email     = $site_settings->field( 'email_address' );
$whatsapp_link = preg_replace( '/[^0-9]/', '', (string) $whatsapp );

// Category badges, same taxonomy used across /pricing and /vaccines.
$categories      = get_the_terms( get_the_ID(), 'vaccine_category' );
$category_labels = [];
if ( $categories && ! is_wp_error( $categories ) ) {
    foreach ( $categories as $cat ) {
        $category_labels[] = $cat->name;
    }
}

// Every brand whose Parent Vaccine relationship points at this vaccine post.
$all_brands   = get_posts( [ 'post_type' => 'brand', 'post_status' => 'publish', 'posts_per_page' => -1 ] );
$linked_brands = [];
foreach ( $all_brands as $b ) {
    $b_pod   = pods( 'brand', $b->ID );
    $related = $b_pod->field( 'parent_vaccine' );
    if ( ! is_array( $related ) || empty( $related ) ) continue;

    $first      = reset( $related );
    $vaccine_id = is_array( $first ) ? (int) ( $first['ID'] ?? 0 ) : (int) $first;
    if ( $vaccine_id === get_the_ID() ) {
        $linked_brands[] = $b;
    }
}

$any_brand_available = false;
foreach ( $linked_brands as $b ) {
    $a = get_post_meta( $b->ID, 'availability', true );
    if ( $a === '1' || strtolower( $a ) === 'yes' || $a === true ) {
        $any_brand_available = true;
        break;
    }
}
?>

<style>
.vd-hero {
    background: var(--color-navy, #0a2a38);
    color: #fff;
    padding: 50px 0 44px;
}
.vd-hero .breadcrumb { background: transparent; padding: 0 0 20px; margin: 0; }
.vd-hero .breadcrumb-item a { color: var(--color-sub-on-blue, #b9d2de); text-decoration: none; }
.vd-hero .breadcrumb-item.active { color: #fff; }
.vd-hero h1 { font-family: var(--font-display, "Saira", system-ui, sans-serif); font-size: 2.1rem; font-weight: 700; color: #fff; margin: 0 0 8px; }
.vd-hero p { margin: 0; color: var(--color-sub-on-blue, #b9d2de); max-width: 60ch; font-size: 15px; }
.vd-hero-badges { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 14px; }
.vd-hero-badge {
    font-size: 12px; font-weight: 700; padding: 5px 12px; border-radius: 100px;
    background: rgba(255,255,255,0.1); color: #fff; border: 1px solid rgba(255,255,255,0.18);
}

.vd-section-label {
    font-size: 12px; font-weight: 700; letter-spacing: 0.06em; text-transform: uppercase;
    color: var(--color-blue, #0b5c87); margin-bottom: 8px;
}
.vd-section-head h2 { font-family: var(--font-display, "Saira", system-ui, sans-serif); font-size: 1.5rem; margin: 0 0 6px; color: var(--color-ink-strong, #16232b); }
.vd-section-head p { margin: 0 0 26px; color: var(--color-ink, #4a575e); font-size: 14.5px; }

.vd-brand-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 56px; }
@media (max-width: 700px) { .vd-brand-grid { grid-template-columns: 1fr; } }

.vd-brand-card {
    background: #fff; border: 1px solid var(--color-sand, #e7e0d3); border-radius: 16px;
    overflow: hidden; display: flex; box-shadow: 0 6px 16px -10px rgba(10,42,56,0.35);
}
.vd-brand-img {
    width: 160px; flex-shrink: 0; background: linear-gradient(135deg, var(--color-blue-tint, #eaf2f6), #cfe0e8);
    display: flex; align-items: center; justify-content: center; padding: 12px;
}
.vd-brand-img img { width: 100%; height: 100%; object-fit: contain; max-height: 130px; }
.vd-brand-img i { font-size: 2rem; color: var(--color-blue, #0b5c87); }
.vd-brand-info { flex: 1; padding: 18px 20px; display: flex; flex-direction: column; min-width: 0; }
.vd-brand-info h3 { font-size: 1.05rem; margin: 0 0 4px; color: var(--color-ink-strong, #16232b); }
.vd-brand-meta { font-size: 12.5px; color: var(--color-label-muted, #8a959a); margin-bottom: 10px; }
.vd-brand-bottom { margin-top: auto; display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-wrap: wrap; }
.vd-brand-price { font-size: 1.2rem; font-weight: 800; color: var(--color-gold, #c9a24b); font-family: var(--font-display, "Saira", system-ui, sans-serif); }
.vd-brand-price .cur { font-size: 0.7rem; font-weight: 600; color: var(--color-ink, #4a575e); }
.vd-avail { font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 100px; display: inline-flex; align-items: center; gap: 4px; white-space: nowrap; }
.vd-avail.yes { background: var(--color-green-tint, #eaf3e4); color: #4a7d2e; }
.vd-avail.no { background: #fde8e8; color: #c0392b; }
.vd-brand-card.is-unavailable { opacity: 0.72; }
.vd-brand-card.is-unavailable .vd-brand-img img { filter: grayscale(1); }

.vd-content {
    background: #fff; border: 1px solid var(--color-sand, #e7e0d3); border-radius: 16px;
    padding: 36px 40px; box-shadow: 0 6px 16px -10px rgba(10,42,56,0.35); margin-bottom: 40px;
}
.vd-content h2 { font-family: var(--font-display, "Saira", system-ui, sans-serif); font-size: 1.4rem; margin: 0 0 22px; color: var(--color-ink-strong, #16232b); }
.vd-content-body { max-width: 68ch; line-height: 1.8; color: var(--color-ink, #4a575e); }
.vd-content-body h2, .vd-content-body h3 { color: var(--color-blue, #0b5c87); margin-top: 26px; margin-bottom: 12px; }
.vd-content-body p { margin: 0 0 14px; font-size: 15px; }
.vd-content-body ul, .vd-content-body ol { margin: 0 0 14px; padding-left: 20px; }
.vd-content-body li { margin-bottom: 6px; font-size: 15px; }

.vd-cta {
    background: var(--color-navy, #0a2a38); border-radius: 18px; padding: 32px 36px;
    display: flex; align-items: center; justify-content: space-between; gap: 20px; flex-wrap: wrap;
    margin-bottom: 40px;
}
.vd-cta-text h3 { font-family: var(--font-display, "Saira", system-ui, sans-serif); color: #fff; font-size: 1.2rem; margin: 0 0 4px; }
.vd-cta-text p { color: var(--color-sub-on-blue, #b9d2de); margin: 0; font-size: 13.5px; }
.vd-cta-actions { display: flex; gap: 10px; flex-wrap: wrap; }
.vd-btn {
    display: inline-flex; align-items: center; gap: 8px; font-weight: 700; font-size: 14px;
    padding: 12px 22px; border-radius: 100px; text-decoration: none; white-space: nowrap; border: none; cursor: pointer;
}
.vd-btn-gold { background: var(--color-gold, #c9a24b); color: var(--color-navy, #0a2a38); }
.vd-btn-outline { background: transparent; color: #fff; border: 1.5px solid rgba(255,255,255,0.35); }

.vd-empty-brands {
    background: var(--color-blue-tint, #eaf2f6); border-radius: 16px; padding: 30px; text-align: center;
    color: var(--color-ink, #4a575e); margin-bottom: 40px;
}

@media (max-width: 560px) {
    .vd-brand-card { flex-direction: column; }
    .vd-brand-img { width: 100%; height: 140px; }
    .vd-content { padding: 26px 22px; }
    .vd-cta { flex-direction: column; align-items: flex-start; }
}
</style>

<!-- Hero -->
<section class="vd-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo home_url( '/vaccines' ); ?>">Vaccines</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
            </ol>
        </nav>

        <h1><?php the_title(); ?></h1>
        <p><?php echo $disease_name ? 'Protection against ' . esc_html( $disease_name ) : 'Professional vaccination service'; ?></p>

        <?php if ( $category_labels ) : ?>
        <div class="vd-hero-badges">
            <?php foreach ( $category_labels as $label ) : ?>
                <span class="vd-hero-badge"><?php echo esc_html( $label ); ?></span>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<div class="container" style="max-width: 1100px; padding-top: 44px; padding-bottom: 20px;">

    <!-- Available Brands -->
    <div class="vd-section-head">
        <div class="vd-section-label">Available Brands</div>
        <?php if ( $linked_brands ) : ?>
            <h2>Choose from <?php echo count( $linked_brands ); ?> brand<?php echo count( $linked_brands ) === 1 ? '' : 's'; ?></h2>
            <p>Prices and availability update as our stock changes — every brand protects against the same disease.</p>
        <?php endif; ?>
    </div>

    <?php if ( $linked_brands ) : ?>
    <div class="vd-brand-grid">
        <?php foreach ( $linked_brands as $brand ) :
            $thumb        = get_the_post_thumbnail_url( $brand->ID, 'medium' );
            $manufacturer = get_post_meta( $brand->ID, 'manufacturer_name', true );
            $price        = get_post_meta( $brand->ID, 'price', true );
            $avail        = get_post_meta( $brand->ID, 'availability', true );
            $avail_bool   = ( $avail === '1' || strtolower( $avail ) === 'yes' || $avail === true );
        ?>
        <div class="vd-brand-card<?php echo $avail_bool ? '' : ' is-unavailable'; ?>">
            <div class="vd-brand-img">
                <?php if ( $thumb ) : ?>
                    <img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( $brand->post_title ); ?>">
                <?php else : ?>
                    <i class="bi bi-shield-fill-check"></i>
                <?php endif; ?>
            </div>
            <div class="vd-brand-info">
                <h3><?php echo esc_html( $brand->post_title ); ?></h3>
                <?php if ( $manufacturer ) : ?><div class="vd-brand-meta"><?php echo esc_html( $manufacturer ); ?></div><?php endif; ?>
                <div class="vd-brand-bottom">
                    <?php if ( $price ) : ?>
                        <div class="vd-brand-price"><span class="cur">PKR</span> <?php echo esc_html( number_format( (float) $price ) ); ?></div>
                    <?php else : ?>
                        <div class="vd-brand-price" style="font-size:0.95rem;">Contact Us</div>
                    <?php endif; ?>
                    <span class="vd-avail <?php echo $avail_bool ? 'yes' : 'no'; ?>">
                        <?php echo $avail_bool ? '✓ Available' : '✗ Unavailable'; ?>
                    </span>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else : ?>
    <div class="vd-empty-brands">
        <i class="bi bi-hourglass-split" style="font-size: 2rem; margin-bottom: 10px; display: block;"></i>
        Brand information for this vaccine is being added. Contact us for current pricing and availability.
    </div>
    <?php endif; ?>

    <!-- About this vaccine -->
    <?php if ( $vaccine_description || get_the_content() ) : ?>
    <div class="vd-content">
        <h2>About <?php the_title(); ?></h2>
        <div class="vd-content-body">
            <?php if ( $vaccine_description ) : ?>
                <?php echo wpautop( $vaccine_description ); ?>
            <?php endif; ?>
            <?php if ( get_the_content() ) : ?>
                <?php the_content(); ?>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- CTA -->
    <div class="vd-cta">
        <div class="vd-cta-text">
            <h3>Ready to book, or still deciding?</h3>
            <p>Our team can confirm the right brand and schedule for you.</p>
        </div>
        <div class="vd-cta-actions">
            <?php if ( $whatsapp_link ) : ?>
            <a href="https://wa.me/<?php echo esc_attr( $whatsapp_link ); ?>?text=<?php echo esc_attr( 'Hi! I have a question about ' . get_the_title() . '.' ); ?>" target="_blank" class="vd-btn vd-btn-outline">
                <i class="bi bi-whatsapp"></i> Ask a Question on WhatsApp
            </a>
            <?php endif; ?>
            <?php if ( $any_brand_available ) : ?>
            <a href="<?php echo esc_url( site_url( '/booking' ) ); ?>" class="vd-btn vd-btn-gold">
                <i class="bi bi-calendar-check-fill"></i> Book This Vaccine
            </a>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php get_footer(); ?>
