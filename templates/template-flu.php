<?php
/**
 * Template Name: Flu Vaccine Booking (/flu)
 *
 * Ad-landing page for flu vaccine bookings: brand picker (from the `brand`
 * CPT, filtered to brands whose Parent Vaccine links to the Influenza (Flu)
 * Vaccine post), a price calculator using the site-wide charge tiers from
 * Flu Bookings Settings, and an inline booking form that posts straight to
 * wp_flu_bookings (see functions.php section 14) — a separate, lighter-weight
 * flow from the existing /booking CF7 form, so this never touches that one.
 */
get_header();

$flu_vaccine_id = 120; // "Influenza( Flu) Vaccine" — vaccinepk.com/vaccine/flu-vaccine/

$site_settings = pods( 'site_contact_settings' );
$whatsapp      = $site_settings->field( 'whatsapp_number' );
$whatsapp_link = preg_replace( '/[^0-9]/', '', (string) $whatsapp );

$base_charge      = (float) vaccinepk_flu_setting( 'base_service_charge' );
$base_group       = (int) vaccinepk_flu_setting( 'base_group', 4 );
$extra_charge     = (float) vaccinepk_flu_setting( 'extra_person_charges' );

// Every brand whose Parent Vaccine relationship points at the Flu vaccine post.
$all_brands  = get_posts( [ 'post_type' => 'brand', 'post_status' => 'publish', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC' ] );
$flu_brands  = [];
foreach ( $all_brands as $b ) {
    $b_pod   = pods( 'brand', $b->ID );
    $related = $b_pod->field( 'parent_vaccine' );
    if ( ! is_array( $related ) || empty( $related ) ) continue;

    $first      = reset( $related );
    $vaccine_id = is_array( $first ) ? (int) ( $first['ID'] ?? 0 ) : (int) $first;
    if ( $vaccine_id === $flu_vaccine_id ) {
        $flu_brands[] = $b;
    }
}

$default_brand = null;
foreach ( $flu_brands as $b ) {
    if ( get_post_meta( $b->ID, 'availability', true ) ) { $default_brand = $b; break; }
}
if ( ! $default_brand && $flu_brands ) $default_brand = $flu_brands[0];

// Cities for the booking-details city dropdown.
$cities = get_posts( [ 'post_type' => 'city', 'post_status' => 'publish', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC' ] );
?>

<style>
.flu-hero {
    background: linear-gradient(160deg, var(--color-navy) 0%, #0e3446 55%, var(--color-navy) 100%);
    padding: 60px 0 50px; position: relative; overflow: hidden; color: #fff;
}
.flu-hero::before {
    content: ""; position: absolute; top: -50%; right: -10%; width: 500px; height: 500px;
    background: radial-gradient(circle, rgba(201,162,75,0.14) 0%, transparent 70%); border-radius: 50%;
}
.flu-hero h1 { font-family: var(--font-display); font-size: 2.3rem; font-weight: 700; color: var(--color-ivory); margin-bottom: 10px; position: relative; z-index: 1; }
.flu-hero .lead { color: var(--color-sub-on-blue); font-size: 16px; max-width: 55ch; position: relative; z-index: 1; margin-bottom: 20px; }
.flu-hero-badges { display: flex; gap: 8px; flex-wrap: wrap; position: relative; z-index: 1; }
.flu-hero-badge { font-size: 12px; font-weight: 700; padding: 5px 13px; border-radius: 100px; background: rgba(255,255,255,0.1); color: #fff; border: 1px solid rgba(255,255,255,0.18); }

.flu-section { padding: 32px 0; }
.flu-section-label { font-size: 15px; font-weight: 800; letter-spacing: 0.03em; text-transform: uppercase; color: var(--color-blue); margin-bottom: 6px; }
.flu-section h2 { font-family: var(--font-display); font-size: 1.55rem; color: var(--color-ink-strong); margin-bottom: 6px; }
.flu-section > p { color: var(--color-ink); font-size: 14.5px; margin: 0 0 26px; max-width: 62ch; }

.flu-brand-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 22px; }
@media (max-width: 860px) { .flu-brand-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 560px) { .flu-brand-grid { grid-template-columns: 1fr; } }

.flu-brand-card {
    background: #fff; border-radius: 16px; box-shadow: var(--shadow-sm); overflow: hidden;
    position: relative; border: 2px solid transparent; cursor: pointer;
    transition: border-color .2s, box-shadow .2s;
}
.flu-brand-card.is-selected { border-color: var(--color-blue); box-shadow: 0 0 0 2px var(--color-blue), var(--shadow-md); }
.flu-brand-card.is-unavailable { opacity: .6; cursor: not-allowed; }
.flu-brand-img { width: 100%; height: 160px; object-fit: contain; background: linear-gradient(135deg, var(--color-blue-tint), #cfe0e8); padding: 14px; box-sizing: border-box; display: block; }
.flu-brand-avail { position: absolute; top: 12px; right: 12px; padding: 4px 12px; border-radius: 100px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .4px; }
.avail-yes { background: var(--color-green-tint); color: #3f6b26; }
.avail-no { background: #fde8e8; color: #c0392b; }
.flu-brand-body { padding: 18px 20px; }
.flu-brand-body h3 { font-size: 1.05rem; color: var(--color-ink-strong); margin-bottom: 6px; }
.flu-brand-meta { list-style: none; padding: 0; margin: 0 0 12px; font-size: 13px; color: var(--color-ink); }
.flu-brand-meta li { padding: 3px 0; border-bottom: 1px dashed var(--color-sand); display: flex; justify-content: space-between; gap: 8px; }
.flu-brand-meta li:last-child { border: none; }
.flu-brand-meta .label { font-weight: 600; color: var(--color-blue); }
.flu-brand-price { font-size: 1.3rem; font-weight: 800; color: var(--color-gold); font-family: var(--font-display); }
.flu-brand-price .cur { font-size: .72rem; font-weight: 600; color: var(--color-ink); }
.flu-empty-brands { background: var(--color-blue-tint); border-radius: 16px; padding: 30px; text-align: center; color: var(--color-ink); }

.flu-calc-section { background: var(--color-ivory); border-top: 1px solid var(--color-sand); border-bottom: 1px solid var(--color-sand); }
.flu-calc-card { background: #fff; border-radius: 18px; box-shadow: var(--shadow-md); overflow: hidden; }
.flu-calc-grid { display: grid; grid-template-columns: 1fr 340px; }
@media (max-width: 860px) { .flu-calc-grid { grid-template-columns: 1fr; } }
.flu-calc-left { padding: 30px; border-right: 1px solid var(--color-sand); }
@media (max-width: 860px) { .flu-calc-left { border-right: none; border-bottom: 1px solid var(--color-sand); } }
.flu-field-group { margin-bottom: 24px; }
.flu-field-group:last-child { margin-bottom: 0; }
.flu-field-label { display: block; font-size: 13.5px; font-weight: 700; color: var(--color-ink-strong); margin-bottom: 8px; }
.flu-field-hint { font-weight: 400; color: var(--color-label-muted); font-size: 12.5px; }
.flu-selected-chip { display: flex; align-items: center; gap: 10px; background: var(--color-blue-tint); border: 1px solid var(--color-sand); border-radius: 10px; padding: 12px 15px; font-size: 13.5px; color: var(--color-ink); }

.flu-stepper { display: inline-flex; align-items: center; border: 1.5px solid var(--color-sand); border-radius: 10px; overflow: hidden; }
.flu-stepper button { width: 42px; height: 42px; border: none; background: var(--color-blue-tint); color: var(--color-navy); font-size: 19px; font-weight: 700; cursor: pointer; }
.flu-stepper button:hover { background: var(--color-sand); }
.flu-stepper input { width: 60px; text-align: center; border: none; font-size: 16px; font-weight: 700; color: var(--color-ink-strong); background: #fff; height: 42px; }

.flu-tier-table { width: 100%; border-collapse: collapse; margin-top: 12px; font-size: 13px; }
.flu-tier-table th, .flu-tier-table td { text-align: left; padding: 8px 10px; border-bottom: 1px solid var(--color-sand); }
.flu-tier-table th { color: var(--color-label-muted); font-weight: 600; font-size: 11.5px; text-transform: uppercase; letter-spacing: .03em; }
.flu-tier-table tr.active-row { background: var(--color-green-tint); }
.flu-tier-table tr.active-row td { color: #3f6b26; font-weight: 700; }

.flu-info-note { display: flex; gap: 10px; align-items: flex-start; background: var(--color-blue-tint); border-left: 4px solid var(--color-blue); border-radius: 8px; padding: 12px 14px; font-size: 13px; color: var(--color-ink); margin-top: 18px; }

.flu-calc-right { padding: 30px; background: var(--color-ivory); display: flex; flex-direction: column; }
.flu-calc-right h3 { font-family: var(--font-display); font-size: 15px; margin-bottom: 16px; color: var(--color-ink-strong); }
.flu-sum-row { display: flex; justify-content: space-between; font-size: 14px; padding: 9px 0; border-bottom: 1px dashed var(--color-sand); color: var(--color-ink); }
.flu-sum-row .v { font-weight: 700; color: var(--color-ink-strong); }
.flu-sum-total { display: flex; justify-content: space-between; align-items: baseline; margin-top: 16px; padding-top: 16px; border-top: 2px solid var(--color-sand); }
.flu-sum-total .label { font-size: 12.5px; color: var(--color-ink); font-weight: 700; text-transform: uppercase; letter-spacing: .04em; }
.flu-sum-total .amount { font-family: var(--font-display); font-size: 30px; font-weight: 800; color: var(--color-gold); }

.flu-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; font-weight: 700; font-size: 14.5px; padding: 13px 24px; border-radius: 100px; text-decoration: none; white-space: nowrap; border: none; cursor: pointer; transition: transform .15s, box-shadow .15s; }
.flu-btn-gold { background: var(--color-gold); color: var(--color-navy); }
.flu-btn-gold:hover { transform: translateY(-1px); box-shadow: 0 8px 20px rgba(201,162,75,.35); color: var(--color-navy); }
.flu-calc-right .flu-btn { width: 100%; padding: 15px; margin-top: 20px; }
.flu-fine-print { font-size: 11.5px; color: var(--color-label-muted); text-align: center; margin-top: 10px; }

.flu-booking-summary-strip { display: flex; align-items: center; gap: 26px; padding: 16px 24px; background: var(--color-ivory); border-bottom: 1px solid var(--color-sand); flex-wrap: wrap; }
.flu-bss-item { display: flex; flex-direction: column; gap: 2px; }
.flu-bss-item .k { font-size: 10.5px; text-transform: uppercase; letter-spacing: .04em; color: var(--color-label-muted); font-weight: 700; }
.flu-bss-item .v { font-size: 14px; font-weight: 700; color: var(--color-ink-strong); }
.flu-bss-total { margin-left: auto; }
.flu-bss-total .v { color: var(--color-gold); font-family: var(--font-display); font-size: 18px; }
.flu-bss-edit { font-size: 12.5px; font-weight: 700; color: var(--color-blue); text-decoration: none; white-space: nowrap; }

.flu-booking-form { padding: 30px; }
.flu-bf-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 22px; }
@media (max-width: 640px) { .flu-bf-grid { grid-template-columns: 1fr; } }
.flu-bf-input { width: 100%; padding: 12px 14px; border: 2px solid var(--color-sand); border-radius: 8px; font-size: 14.5px; color: var(--color-ink-strong); background: #fff; }
.flu-bf-input:focus-visible { outline: none; border-color: var(--color-blue); box-shadow: 0 0 0 3px rgba(11,92,135,.1); }
.flu-bf-checkbox { display: flex; gap: 10px; align-items: flex-start; font-size: 13px; color: var(--color-ink); margin-bottom: 22px; }
.flu-bf-checkbox input { margin-top: 3px; }
.flu-location-toggle { display: flex; gap: 10px; }
.flu-loc-opt { flex: 1; padding: 12px 16px; border: 2px solid var(--color-sand); border-radius: 8px; background: #fff; color: var(--color-ink-strong); font-size: 14px; font-weight: 600; cursor: pointer; text-align: left; }
.flu-loc-opt.is-selected { border-color: var(--color-blue); background: var(--color-blue-tint); }

.flu-form-msg { padding: 14px 18px; border-radius: 10px; font-size: 14px; margin-top: 16px; display: none; }
.flu-form-msg.is-success { display: block; background: var(--color-green-tint); color: #3f6b26; }
.flu-form-msg.is-error { display: block; background: #fde8e8; color: #c0392b; }

.flu-faq-item { background: #fff; border: 1px solid var(--color-sand); border-radius: 12px; overflow: hidden; margin-bottom: 12px; }
.flu-faq-item summary { padding: 16px 20px; font-weight: 700; cursor: pointer; list-style: none; display: flex; justify-content: space-between; align-items: center; font-size: 14.5px; color: var(--color-ink-strong); }
.flu-faq-item summary::-webkit-details-marker { display: none; }
.flu-faq-item summary::after { content: "+"; font-size: 20px; color: var(--color-blue); font-weight: 400; }
.flu-faq-item[open] summary::after { content: "\2212"; }
.flu-faq-item p { padding: 0 20px 18px; margin: 0; color: var(--color-ink); font-size: 14px; max-width: 68ch; }

.flu-sticky-cta { display: none; position: sticky; bottom: 0; z-index: 20; background: var(--color-navy); padding: 14px 18px; box-shadow: 0 -8px 24px rgba(0,0,0,.2); }
.flu-sticky-cta-inner { display: flex; justify-content: space-between; align-items: center; gap: 12px; max-width: 1100px; margin: 0 auto; }
.flu-sticky-cta .amount { font-family: var(--font-display); font-weight: 800; font-size: 19px; color: #fff; }
.flu-sticky-cta .amount-label { font-size: 11px; color: var(--color-sub-on-blue); }
@media (max-width: 860px) { .flu-sticky-cta { display: block; } }

/* ===== Small phones (mid-range Samsung etc., ~360-412px) =====
   The breakpoints above only reflow columns; below this width the
   desktop type scale, padding, and touch targets are still too small
   for a real phone, so this pass resizes rather than just re-stacks. */
@media (max-width: 480px) {
    .flu-hero { padding: 36px 0 30px; }
    .flu-hero h1 { font-size: 1.55rem; line-height: 1.25; }
    .flu-hero .lead { font-size: 14px; }
    .flu-hero-badge { font-size: 11px; padding: 4px 10px; }

    .flu-section { padding: 22px 0; }
    .flu-section-label { font-size: 14px; }
    .flu-section h2 { font-size: 1.25rem; }
    .flu-section > p { font-size: 13.5px; }

    .flu-brand-card { border-radius: 14px; }
    .flu-brand-img { height: 130px; }
    .flu-brand-body { padding: 14px 16px; }
    .flu-brand-body h3 { font-size: 1rem; }
    .flu-brand-price { font-size: 1.15rem; }
    .flu-brand-avail { font-size: 10px; padding: 3px 9px; top: 9px; right: 9px; }

    .flu-calc-card { border-radius: 14px; }
    .flu-calc-left, .flu-calc-right, .flu-booking-form { padding: 18px 16px; }
    .flu-field-group { margin-bottom: 20px; }
    .flu-selected-chip { font-size: 13px; padding: 11px 13px; }

    /* Steppers are the main tap target on this page — make them thumb-sized. */
    .flu-stepper button { width: 52px; height: 52px; font-size: 22px; }
    .flu-stepper input { width: 70px; height: 52px; font-size: 18px; }

    .flu-tier-table { font-size: 12px; }
    .flu-tier-table th, .flu-tier-table td { padding: 7px 6px; }

    .flu-sum-row { font-size: 13.5px; }
    .flu-sum-total .amount { font-size: 26px; }
    .flu-btn { font-size: 14px; padding: 14px 20px; }
    .flu-calc-right .flu-btn { padding: 16px; }

    .flu-booking-summary-strip { padding: 12px 16px; gap: 16px; }
    .flu-bss-item .v { font-size: 13px; }
    .flu-bss-total .v { font-size: 16px; }

    /* 16px min font-size on inputs stops iOS Safari auto-zooming on focus,
       which otherwise makes the form feel broken on exactly this class of
       device. */
    .flu-bf-input, #fluDateDisplay { font-size: 16px; padding: 13px 14px; }
    .flu-loc-opt { font-size: 13.5px; padding: 13px 14px; }
    .flu-bf-checkbox { font-size: 12.5px; }

    .flu-faq-item summary { font-size: 13.5px; padding: 14px 16px; }
    .flu-faq-item p { font-size: 13.5px; padding: 0 16px 16px; }

    /* Sticky bar is the primary CTA once someone has scrolled past the
       calculator on a phone — give it more presence, not less. */
    .flu-sticky-cta { padding: 12px 14px; }
    .flu-sticky-cta .amount { font-size: 17px; }
    .flu-sticky-cta .flu-btn { padding: 12px 20px; font-size: 13.5px; }
}
</style>

<!-- ================= HERO ================= -->
<section class="flu-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="background:transparent;">
                <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>" style="color:var(--color-sub-on-blue);text-decoration:none;">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page" style="color:#fff;">Flu Vaccine</li>
            </ol>
        </nav>
        <h1><i class="bi bi-shield-fill-plus"></i>&nbsp; Flu Vaccine Booking &amp; Pricing</h1>
        <p class="lead">Every brand in stock this season, its manufacturer and country of origin, and your exact price — calculated instantly below.</p>
        <div class="flu-hero-badges">
            <span class="flu-hero-badge"><i class="bi bi-calendar-event"></i> All ages, 6 months+</span>
            <span class="flu-hero-badge"><i class="bi bi-house-heart"></i> Home or Clinic</span>
        </div>
    </div>
</section>

<!-- ================= BRAND GRID ================= -->
<section class="flu-section">
    <div class="container">
        <div class="flu-section-label">Step 1 — Choose a brand</div>
        <h2>Available flu vaccine brands this season</h2>
        <p>Packaging changes every year — admin marks each brand available or sold out, and it reflects here immediately.</p>

        <?php if ( $flu_brands ) : ?>
        <div class="flu-brand-grid" id="fluBrandGrid">
            <?php foreach ( $flu_brands as $brand ) :
                $thumb        = get_the_post_thumbnail_url( $brand->ID, 'medium' );
                $manufacturer = get_post_meta( $brand->ID, 'manufacturer_name', true );
                $country      = get_post_meta( $brand->ID, 'country', true );
                $price        = (float) get_post_meta( $brand->ID, 'price', true );
                $avail        = get_post_meta( $brand->ID, 'availability', true );
                $avail_bool   = ( $avail === '1' || strtolower( $avail ) === 'yes' || $avail === true );
                $is_default   = $default_brand && $brand->ID === $default_brand->ID;
            ?>
            <div class="flu-brand-card<?php echo $avail_bool ? '' : ' is-unavailable'; ?><?php echo $is_default ? ' is-selected' : ''; ?>"
                 data-brand-id="<?php echo esc_attr( $brand->ID ); ?>"
                 data-brand-name="<?php echo esc_attr( $brand->post_title ); ?>"
                 data-price="<?php echo esc_attr( $price ); ?>"
                 data-avail="<?php echo $avail_bool ? 'yes' : 'no'; ?>"
                 data-manufacturer="<?php echo esc_attr( $manufacturer ); ?>"
                 data-country="<?php echo esc_attr( $country ); ?>">
                <span class="flu-brand-avail <?php echo $avail_bool ? 'avail-yes' : 'avail-no'; ?>"><?php echo $avail_bool ? '✓ Available' : '✗ Unavailable'; ?></span>
                <?php if ( $thumb ) : ?>
                    <img class="flu-brand-img" src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( $brand->post_title ); ?>">
                <?php else : ?>
                    <div class="flu-brand-img" style="display:flex;align-items:center;justify-content:center;"><i class="bi bi-shield-fill-check" style="font-size:2rem;color:var(--color-blue);"></i></div>
                <?php endif; ?>
                <div class="flu-brand-body">
                    <h3><?php echo esc_html( $brand->post_title ); ?></h3>
                    <ul class="flu-brand-meta">
                        <?php if ( $manufacturer ) : ?><li><span class="label">Manufacturer</span><span><?php echo esc_html( $manufacturer ); ?></span></li><?php endif; ?>
                        <?php if ( $country ) : ?><li><span class="label">Made in</span><span><?php echo esc_html( $country ); ?></span></li><?php endif; ?>
                    </ul>
                    <?php if ( $price ) : ?>
                        <div class="flu-brand-price"><span class="cur">PKR</span> <?php echo esc_html( number_format( $price ) ); ?></div>
                    <?php else : ?>
                        <div class="flu-brand-price" style="font-size:.95rem;">Contact Us</div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else : ?>
        <div class="flu-empty-brands">
            <i class="bi bi-hourglass-split" style="font-size:2rem;margin-bottom:10px;display:block;"></i>
            Brand information for this season is being added. Contact us for current pricing and availability.
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ================= CALCULATOR ================= -->
<section class="flu-section flu-calc-section" id="calculator">
    <div class="container">
        <div class="flu-section-label">Step 2 — Your total</div>
        <h2>Price calculator</h2>
        <p>Brand price × number of people, plus one shared vaccination service charge for the whole group.</p>

        <div class="flu-calc-card">
            <div class="flu-calc-grid">
                <div class="flu-calc-left">
                    <div class="flu-field-group">
                        <label class="flu-field-label">Selected brand</label>
                        <div class="flu-selected-chip">
                            <i class="bi bi-check-circle-fill" style="color:var(--color-green);"></i>
                            <span id="fluSelectedBrandLabel">
                                <?php if ( $default_brand ) :
                                    $dm = get_post_meta( $default_brand->ID, 'manufacturer_name', true );
                                    $dc = get_post_meta( $default_brand->ID, 'country', true );
                                    $dp = (float) get_post_meta( $default_brand->ID, 'price', true );
                                ?>
                                    <strong><?php echo esc_html( $default_brand->post_title ); ?></strong> — PKR <?php echo esc_html( number_format( $dp ) ); ?> / dose<?php echo $dm ? ' · ' . esc_html( $dm ) : ''; ?><?php echo $dc ? ' · Made in ' . esc_html( $dc ) : ''; ?>
                                <?php else : ?>
                                    No brand selected yet — choose one above.
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>

                    <div class="flu-field-group">
                        <label class="flu-field-label">Number of people vaccinated together <span class="flu-field-hint">same place, same time</span></label>
                        <div class="flu-stepper">
                            <button type="button" id="fluPeopleMinus" aria-label="Decrease">−</button>
                            <input type="text" id="fluPeopleCount" value="1" inputmode="numeric" aria-label="Number of people">
                            <button type="button" id="fluPeoplePlus" aria-label="Increase">+</button>
                        </div>

                        <table class="flu-tier-table">
                            <thead><tr><th>People</th><th>Service charge</th></tr></thead>
                            <tbody>
                                <tr class="active-row"><td>1 – <?php echo (int) $base_group; ?> people</td><td>PKR <?php echo esc_html( number_format( $base_charge ) ); ?> flat (total, not per person)</td></tr>
                                <tr><td><?php echo (int) $base_group + 1; ?>th person onward</td><td>+ PKR <?php echo esc_html( number_format( $extra_charge ) ); ?> each</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="flu-calc-right">
                    <h3>Your estimate</h3>
                    <div class="flu-sum-row"><span id="fluSumVaccineLabel">Vaccine</span><span class="v" id="fluSumVaccine">PKR 0</span></div>
                    <div class="flu-sum-row"><span>Vaccination service charge</span><span class="v" id="fluSumCharge">PKR 0</span></div>
                    <div class="flu-sum-total">
                        <span class="label">Total</span>
                        <span class="amount" id="fluSumTotal">PKR 0</span>
                    </div>
                    <a href="#your-details" class="flu-btn flu-btn-gold"><i class="bi bi-arrow-down-circle-fill"></i> Continue to Booking</a>
                    <div class="flu-fine-print">No payment now — confirm details below</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================= BOOKING DETAILS ================= -->
<section class="flu-section" id="your-details">
    <div class="container" style="max-width:780px;">
        <div class="flu-section-label">Step 3 — Your details</div>
        <h2>Confirm your booking</h2>
        <p>We'll contact you on WhatsApp to confirm the appointment slot.</p>

        <div class="flu-calc-card">
            <div class="flu-booking-summary-strip">
                <div class="flu-bss-item"><span class="k">Brand</span><span class="v" id="fluBssBrand"><?php echo $default_brand ? esc_html( $default_brand->post_title ) : '—'; ?></span></div>
                <div class="flu-bss-item"><span class="k">People</span><span class="v" id="fluBssPeople">1</span></div>
                <div class="flu-bss-item flu-bss-total"><span class="k">Total</span><span class="v" id="fluBssTotal">PKR 0</span></div>
                <a href="#calculator" class="flu-bss-edit">Edit selection</a>
            </div>

            <form class="flu-booking-form" id="fluBookingForm">
                <div class="flu-bf-grid">
                    <div class="flu-field-group">
                        <label class="flu-field-label">Full name*</label>
                        <input type="text" name="full_name" class="flu-bf-input" placeholder="Enter your full name" required>
                    </div>
                    <div class="flu-field-group">
                        <label class="flu-field-label">WhatsApp number*</label>
                        <input type="tel" name="whatsapp_number" class="flu-bf-input" placeholder="+92 3XX XXXXXXX" required>
                    </div>
                    <div class="flu-field-group">
                        <label class="flu-field-label">Email address*</label>
                        <input type="email" name="email" class="flu-bf-input" placeholder="your@email.com" required>
                    </div>
                    <div class="flu-field-group">
                        <label class="flu-field-label">City*</label>
                        <select name="city_id" class="flu-bf-input" required>
                            <option value="">Select city</option>
                            <?php foreach ( $cities as $city ) : ?>
                                <option value="<?php echo esc_attr( $city->ID ); ?>"><?php echo esc_html( $city->post_title ); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="flu-field-group" style="grid-column:1/-1;">
                        <label class="flu-field-label">Address <span class="flu-field-hint">required for home service</span></label>
                        <input type="text" name="address" class="flu-bf-input" placeholder="House, street, area...">
                    </div>
                    <div class="flu-field-group">
                        <label class="flu-field-label">Preferred date <span class="flu-field-hint">optional</span></label>
                        <input type="text" id="fluDateDisplay" class="flu-bf-input" placeholder="dd/mm/yyyy" inputmode="numeric" autocomplete="off" maxlength="10">
                        <input type="hidden" name="preferred_date" id="fluDateValue">
                    </div>
                    <div class="flu-field-group">
                        <label class="flu-field-label">Preferred time slot <span class="flu-field-hint">optional</span></label>
                        <select name="time_slot" class="flu-bf-input">
                            <option value="">Select time</option>
                            <option>Morning (9AM – 12PM)</option>
                            <option>Afternoon (12PM – 3PM)</option>
                            <option>Evening (3PM – 6PM)</option>
                        </select>
                    </div>
                    <div class="flu-field-group">
                        <label class="flu-field-label">Location*</label>
                        <input type="hidden" name="location_type" id="fluLocationType" value="clinic">
                        <div class="flu-location-toggle">
                            <button type="button" class="flu-loc-opt is-selected" data-loc="clinic">Clinic Visit</button>
                            <button type="button" class="flu-loc-opt" data-loc="home">Home Service</button>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="brand_id" id="fluFormBrandId" value="<?php echo $default_brand ? esc_attr( $default_brand->ID ) : ''; ?>">
                <input type="hidden" name="people_count" id="fluFormPeopleCount" value="1">
                <input type="hidden" name="action" value="submit_flu_booking">
                <input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'vaccination_booking_nonce' ) ); ?>">

                <label class="flu-bf-checkbox">
                    <input type="checkbox" required>
                    <span>I agree to the <a href="<?php echo esc_url( home_url( '/terms' ) ); ?>">terms &amp; conditions</a> and <a href="<?php echo esc_url( home_url( '/privacy' ) ); ?>">privacy policy</a>*</span>
                </label>

                <button type="submit" class="flu-btn flu-btn-gold" style="width:100%;padding:16px;font-size:16px;" id="fluSubmitBtn">
                    Confirm Booking — <span id="fluSubmitTotal">PKR 0</span> <i class="bi bi-arrow-right-circle-fill"></i>
                </button>
                <div class="flu-form-msg" id="fluFormMsg"></div>
                <div class="flu-fine-print">You'll receive a WhatsApp confirmation within a few hours</div>
            </form>
        </div>
    </div>
</section>

<!-- ================= FAQ ================= -->
<section class="flu-section">
    <div class="container" style="max-width:780px;">
        <div class="flu-section-label">Common questions</div>
        <h2>Everything ad visitors ask us</h2>

        <details class="flu-faq-item" open>
            <summary>What does the flu vaccine cost?</summary>
            <p>PKR prices vary by brand — see the cards above for exact per-dose pricing, plus a shared vaccination service charge: PKR <?php echo esc_html( number_format( $base_charge ) ); ?> flat for up to <?php echo (int) $base_group; ?> people vaccinated together, +PKR <?php echo esc_html( number_format( $extra_charge ) ); ?> per additional person. Use the calculator above for your exact total.</p>
        </details>
        <details class="flu-faq-item">
            <summary>Which brands do you carry, and who makes them?</summary>
            <p>See the brand cards above for what's currently in stock, including manufacturer and country of origin. Availability is updated here as soon as it changes.</p>
        </details>
        <details class="flu-faq-item">
            <summary>Is the vaccine given at home or at a clinic?</summary>
            <p>Both — choose clinic visit or home service at checkout. Home service covers the same cities as our other vaccinations.</p>
        </details>
        <details class="flu-faq-item">
            <summary>How many doses does my child need?</summary>
            <p>Children 6 months–8 years getting a flu vaccine for the first time need 2 doses, 4 weeks apart. Our staff will guide you at the visit and schedule the second dose separately when it's due.</p>
        </details>
    </div>
</section>

<!-- ================= STICKY MOBILE CTA ================= -->
<div class="flu-sticky-cta">
    <div class="flu-sticky-cta-inner">
        <div>
            <div class="amount-label">Estimated total</div>
            <div class="amount" id="fluStickyTotal">PKR 0</div>
        </div>
        <a href="#your-details" class="flu-btn flu-btn-gold">Book Now</a>
    </div>
</div>

<script>
(function () {
    var BASE_CHARGE  = <?php echo (float) $base_charge; ?>;
    var BASE_GROUP   = <?php echo (int) $base_group; ?>;
    var EXTRA_CHARGE = <?php echo (float) $extra_charge; ?>;

    var selectedBrand = {
        id: <?php echo $default_brand ? (int) $default_brand->ID : 'null'; ?>,
        name: <?php echo $default_brand ? wp_json_encode( $default_brand->post_title ) : 'null'; ?>,
        price: <?php echo $default_brand ? (float) get_post_meta( $default_brand->ID, 'price', true ) : 0; ?>
    };

    var peopleInput = document.getElementById('fluPeopleCount');

    function fmt(n) { return 'PKR ' + Math.round(n).toLocaleString(); }

    function serviceCharge(people) {
        if (people <= BASE_GROUP) return BASE_CHARGE;
        return BASE_CHARGE + (people - BASE_GROUP) * EXTRA_CHARGE;
    }

    var MAX_PEOPLE = 30;

    function recalc() {
        var people = Math.min(MAX_PEOPLE, Math.max(1, parseInt(peopleInput.value, 10) || 1));
        peopleInput.value = people;

        var vaccineTotal = selectedBrand.price * people;
        var charge = serviceCharge(people);
        var total = vaccineTotal + charge;

        document.getElementById('fluSumVaccineLabel').textContent = 'Vaccine — ' + people + ' × ' + fmt(selectedBrand.price);
        document.getElementById('fluSumVaccine').textContent = fmt(vaccineTotal);
        document.getElementById('fluSumCharge').textContent = fmt(charge);
        document.getElementById('fluSumTotal').textContent = fmt(total);

        document.getElementById('fluBssBrand').textContent = selectedBrand.name || '—';
        document.getElementById('fluBssPeople').textContent = people;
        document.getElementById('fluBssTotal').textContent = fmt(total);
        document.getElementById('fluSubmitTotal').textContent = fmt(total);
        document.getElementById('fluStickyTotal').textContent = fmt(total);
        document.getElementById('fluSelectedBrandLabel').innerHTML = selectedBrand.name
            ? '<strong>' + selectedBrand.name + '</strong> — ' + fmt(selectedBrand.price) + ' / dose'
            : 'No brand selected yet — choose one above.';

        document.getElementById('fluFormBrandId').value = selectedBrand.id || '';
        document.getElementById('fluFormPeopleCount').value = people;
    }

    document.getElementById('fluPeopleMinus').addEventListener('click', function () {
        peopleInput.value = Math.max(1, (parseInt(peopleInput.value, 10) || 1) - 1);
        recalc();
    });
    document.getElementById('fluPeoplePlus').addEventListener('click', function () {
        peopleInput.value = Math.min(MAX_PEOPLE, (parseInt(peopleInput.value, 10) || 1) + 1);
        recalc();
    });
    peopleInput.addEventListener('input', recalc);

    document.querySelectorAll('.flu-brand-card').forEach(function (card) {
        card.addEventListener('click', function () {
            if (card.classList.contains('is-unavailable')) return;
            document.querySelectorAll('.flu-brand-card').forEach(function (c) { c.classList.remove('is-selected'); });
            card.classList.add('is-selected');
            selectedBrand = {
                id: parseInt(card.getAttribute('data-brand-id'), 10),
                name: card.getAttribute('data-brand-name'),
                price: parseFloat(card.getAttribute('data-price')) || 0
            };
            recalc();
        });
    });

    document.querySelectorAll('.flu-loc-opt').forEach(function (opt) {
        opt.addEventListener('click', function () {
            document.querySelectorAll('.flu-loc-opt').forEach(function (o) { o.classList.remove('is-selected'); });
            opt.classList.add('is-selected');
            document.getElementById('fluLocationType').value = opt.getAttribute('data-loc');
        });
    });

    recalc();

    // dd/mm/yyyy display input, kept in sync with a hidden yyyy-mm-dd field
    // (what the server actually receives) — matches the site's other
    // properties, since a native <input type="date"> shows whatever format
    // the visitor's OS/browser locale happens to use.
    (function () {
        var display = document.getElementById('fluDateDisplay');
        var hidden  = document.getElementById('fluDateValue');

        display.addEventListener('input', function () {
            var digits = display.value.replace(/[^\d]/g, '').slice(0, 8);
            var out = digits;
            if (digits.length > 4) out = digits.slice(0, 2) + '/' + digits.slice(2, 4) + '/' + digits.slice(4);
            else if (digits.length > 2) out = digits.slice(0, 2) + '/' + digits.slice(2);
            display.value = out;

            hidden.value = '';
            if (digits.length === 8) {
                var day = parseInt(digits.slice(0, 2), 10);
                var month = parseInt(digits.slice(2, 4), 10);
                var year = parseInt(digits.slice(4, 8), 10);
                var d = new Date(year, month - 1, day);
                var isReal = d.getFullYear() === year && d.getMonth() === month - 1 && d.getDate() === day;
                if (isReal) {
                    hidden.value = year + '-' + String(month).padStart(2, '0') + '-' + String(day).padStart(2, '0');
                    display.setCustomValidity('');
                } else {
                    display.setCustomValidity('Enter a real date as dd/mm/yyyy');
                }
            } else if (digits.length > 0) {
                display.setCustomValidity('Enter the full date as dd/mm/yyyy');
            } else {
                display.setCustomValidity('');
            }
        });
    })();

    var form = document.getElementById('fluBookingForm');
    var msg  = document.getElementById('fluFormMsg');
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        if (!selectedBrand.id) {
            msg.className = 'flu-form-msg is-error';
            msg.textContent = 'Please choose a brand above before booking.';
            return;
        }

        var submitBtn = document.getElementById('fluSubmitBtn');
        submitBtn.disabled = true;
        msg.className = 'flu-form-msg';
        msg.textContent = '';

        var formData = new FormData(form);

        fetch(vaccination_ajax.ajax_url, { method: 'POST', body: formData })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                submitBtn.disabled = false;
                if (data.success) {
                    msg.className = 'flu-form-msg is-success';
                    msg.textContent = "Booking received! We'll contact you on WhatsApp shortly to confirm your appointment.";
                    form.reset();
                } else {
                    msg.className = 'flu-form-msg is-error';
                    msg.textContent = (data.data && data.data.message) || 'Something went wrong. Please try again or WhatsApp us.';
                }
            })
            .catch(function () {
                submitBtn.disabled = false;
                msg.className = 'flu-form-msg is-error';
                msg.textContent = 'Network error — please try again or WhatsApp us.';
            });
    });
})();
</script>

<?php get_footer(); ?>
