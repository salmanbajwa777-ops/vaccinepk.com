<?php
/**
 * Template Name: Vaccination Booking (Category Page)
 * Description: Dedicated full-page booking form for one vaccination category
 * (child/adult/travel), replacing the homepage popup modal on mobile.
 * The page slug decides which CF7 form loads — see $slug_to_category below.
 */
get_header();

$slug_to_category = [
    'book-child-vaccination'  => 'child',
    'book-adult-vaccination'  => 'adult',
    'book-travel-vaccination' => 'travel',
];

$form_ids = [
    'child'  => 'd12af79',
    'adult'  => 'b9ff7a4',
    'travel' => 'ed84fa1',
];

$category_labels = [
    'child'  => 'Child Vaccination',
    'adult'  => 'Adult Vaccination',
    'travel' => 'Travel Vaccination',
];

$category_icons = [
    'child'  => 'heart-pulse-fill',
    'adult'  => 'person-hearts',
    'travel' => 'airplane-fill',
];

$category_subs = [
    'child'  => 'Complete immunization schedule for infants and children following WHO & EPI guidelines.',
    'adult'  => 'Essential immunizations for adults including boosters and preventive vaccines.',
    'travel' => 'Pre-travel immunizations for domestic and international destinations.',
];

$slug     = get_post_field( 'post_name', get_the_ID() );
$category = $slug_to_category[ $slug ] ?? 'child';
$form_id  = $form_ids[ $category ];
?>

<!-- ================= PAGE HEADER ================= -->
<section class="page-header" style="background: linear-gradient(160deg, var(--color-navy) 0%, #0e3446 55%, var(--color-navy) 100%); padding: 60px 0 40px; position: relative; overflow: hidden;">
    <div style="position: absolute; top: -50%; right: -10%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(201, 162, 75, 0.14) 0%, transparent 70%); border-radius: 50%;"></div>
    <div style="position: absolute; bottom: -30%; left: -5%; width: 400px; height: 400px; background: radial-gradient(circle, rgba(107, 182, 63, 0.12) 0%, transparent 70%); border-radius: 50%;"></div>

    <div class="container" style="position: relative; z-index: 1;">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb justify-content-center" style="background: transparent;">
                        <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>" style="color: var(--color-sub-on-blue); text-decoration: none;"><i class="bi bi-house-fill"></i> Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo home_url( '/booking' ); ?>" style="color: var(--color-sub-on-blue); text-decoration: none;">Book Vaccination</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: var(--color-ivory);"><?php echo esc_html( $category_labels[ $category ] ); ?></li>
                    </ol>
                </nav>
                <div class="mb-3">
                    <i class="bi bi-<?php echo esc_attr( $category_icons[ $category ] ); ?>" style="font-size: 44px; color: var(--color-gold);"></i>
                </div>
                <h1 class="fw-bold mb-3" style="font-family: var(--font-display); font-size: 2rem; color: var(--color-ivory);"><?php echo esc_html( $category_labels[ $category ] ); ?> Booking</h1>
                <p class="mb-0" style="color: var(--color-sub-on-blue); max-width: 56ch; margin-inline: auto;"><?php echo esc_html( $category_subs[ $category ] ); ?></p>
            </div>
        </div>
    </div>
</section>

<!-- ================= BOOKING FORM ================= -->
<section class="py-5" style="background: var(--color-ivory);">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div id="vb-form-wrap">
                    <?php echo do_shortcode( '[contact-form-7 id="' . esc_attr( $form_id ) . '"]' ); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Styles: same field/scrollbar/select treatment already proven on the booking modal -->
<style>
#vb-form-wrap .wpcf7-form {
    background: white;
    padding: 32px;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

#vb-form-wrap .wpcf7-form p {
    margin-bottom: 20px;
}

#vb-form-wrap .wpcf7-form label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #16232b;
}

#vb-form-wrap .wpcf7-form input[type="text"],
#vb-form-wrap .wpcf7-form input[type="email"],
#vb-form-wrap .wpcf7-form input[type="tel"],
#vb-form-wrap .wpcf7-form input[type="date"],
#vb-form-wrap .wpcf7-form textarea,
#vb-form-wrap .wpcf7-form select {
    width: 100%;
    height: 48px;
    padding: 12px 15px;
    border: 2px solid #e7e0d3;
    border-radius: 8px;
    font-size: 15px;
    line-height: 1.4;
    font-family: inherit;
    box-sizing: border-box;
    -webkit-appearance: none;
    appearance: none;
    background-color: #fff;
    transition: all 0.3s;
}

#vb-form-wrap .wpcf7-form select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='%2316232b' d='M4 6l4 4 4-4z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 15px center;
    padding-right: 40px;
}

#vb-form-wrap .wpcf7-form textarea {
    height: auto;
    min-height: 100px;
}

#vb-form-wrap .wpcf7-form input[type="date"]::-webkit-calendar-picker-indicator {
    filter: invert(0.4);
    cursor: pointer;
}

#vb-form-wrap .wpcf7-form input[type="text"]:focus,
#vb-form-wrap .wpcf7-form input[type="email"]:focus,
#vb-form-wrap .wpcf7-form input[type="tel"]:focus,
#vb-form-wrap .wpcf7-form input[type="date"]:focus,
#vb-form-wrap .wpcf7-form textarea:focus,
#vb-form-wrap .wpcf7-form select:focus {
    border-color: #0b5c87;
    outline: none;
    box-shadow: 0 0 0 3px rgba(11, 92, 135, 0.1);
}

#vb-form-wrap .wpcf7-form input[type="submit"] {
    width: 100%;
    background: #0a2a38;
    color: white;
    border: none;
    padding: 15px 40px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

#vb-form-wrap .wpcf7-form input[type="submit"]:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(11, 92, 135, 0.3);
}

#vb-form-wrap .wpcf7-not-valid-tip {
    color: #dc2626;
    font-size: 13px;
    margin-top: 5px;
}

#vb-form-wrap .wpcf7-response-output {
    margin: 20px 0 0 0;
    padding: 15px;
    border-radius: 8px;
    border: 2px solid;
}

#vb-form-wrap .wpcf7-mail-sent-ok {
    border-color: #10b981;
    background-color: #d1fae5;
    color: #065f46;
}

#vb-form-wrap .wpcf7-validation-errors,
#vb-form-wrap .wpcf7-mail-sent-ng {
    border-color: #ef4444;
    background-color: #fee2e2;
    color: #991b1b;
}

@media (max-width: 576px) {
    #vb-form-wrap .wpcf7-form {
        padding: 18px;
    }
}
</style>

<?php get_footer(); ?>
