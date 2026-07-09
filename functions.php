<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/* ==========================================================================
   1. ENQUEUE STYLES & SCRIPTS
   ========================================================================== */
function vaccination_centre_assets() {

    wp_enqueue_style( 'google-fonts',
        'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Ubuntu:wght@500;700&display=swap',
        [], null );

    wp_enqueue_style( 'bootstrap',
        'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css',
        [], '5.3.2' );

    wp_enqueue_style( 'bootstrap-icons',
        'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css',
        [], '1.11.3' );

    wp_enqueue_style( 'babymedics-main',
        get_template_directory_uri() . '/assets/css/main.css',
        [ 'bootstrap', 'bootstrap-icons', 'google-fonts' ],
        filemtime( get_template_directory() . '/assets/css/main.css' ) );

    wp_enqueue_script( 'bootstrap-js',
        'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js',
        [], '5.3.2', true );

    if ( file_exists( get_template_directory() . '/assets/js/main.js' ) ) {
        wp_enqueue_script( 'babymedics-main-js',
            get_template_directory_uri() . '/assets/js/main.js',
            [ 'jquery' ],
            filemtime( get_template_directory() . '/assets/js/main.js' ),
            true );
    }

    // AJAX vars available globally in JS
    wp_localize_script( 'bootstrap-js', 'vaccination_ajax', [
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'vaccination_booking_nonce' ),
    ] );
}
add_action( 'wp_enqueue_scripts', 'vaccination_centre_assets' );


/* ==========================================================================
   2. AJAX: LOAD BOOKING FORM (called from template-booking.php JS)
   ========================================================================== */
function load_booking_form_ajax() {

    check_ajax_referer( 'vaccination_booking_nonce', 'nonce' );

    $category = isset( $_POST['category'] ) ? sanitize_text_field( $_POST['category'] ) : '';

    $form_titles = [
        'child'  => 'Child Vaccine Booking',
        'adult'  => 'Adult Vaccine Booking',
        'flu'    => 'Flu Vaccine Booking',
        'travel' => 'Travel Vaccine Booking',
    ];

    if ( ! array_key_exists( $category, $form_titles ) ) {
        echo '<div class="alert alert-warning">Invalid category.</div>';
        wp_die();
    }

    if ( ! function_exists( 'wpcf7_contact_form' ) ) {
        echo '<div class="alert alert-danger">Contact Form 7 plugin is not active.</div>';
        wp_die();
    }

    // Find form by title
    $query = new WP_Query( [
        'post_type'      => 'wpcf7_contact_form',
        'post_status'    => 'publish',
        'title'          => $form_titles[ $category ],
        'posts_per_page' => 1,
    ] );

    $form_id = null;

    if ( $query->have_posts() ) {
        $form_id = $query->posts[0]->ID;
    } else {
        // Fallback: partial title match
        $all = get_posts( [ 'post_type' => 'wpcf7_contact_form', 'post_status' => 'publish', 'numberposts' => -1 ] );
        foreach ( $all as $f ) {
            if ( stripos( $f->post_title, $form_titles[ $category ] ) !== false ) {
                $form_id = $f->ID;
                break;
            }
        }
    }

    if ( ! $form_id ) {
        // Show available forms to help debug
        $all   = get_posts( [ 'post_type' => 'wpcf7_contact_form', 'post_status' => 'publish', 'numberposts' => -1 ] );
        $list  = implode( ', ', array_map( fn( $f ) => '"' . $f->post_title . '" (ID:' . $f->ID . ')', $all ) );
        echo '<div class="alert alert-warning"><strong>Form not found.</strong><br>Looking for: <em>' . esc_html( $form_titles[ $category ] ) . '</em><br>Available: ' . esc_html( $list ) . '</div>';
        wp_die();
    }

    $cf7 = wpcf7_contact_form( $form_id );
    if ( $cf7 ) {
        echo $cf7->form_html();
    } else {
        echo '<div class="alert alert-danger">Could not load form.</div>';
    }

    wp_die();
}
add_action( 'wp_ajax_load_booking_form',        'load_booking_form_ajax' );
add_action( 'wp_ajax_nopriv_load_booking_form', 'load_booking_form_ajax' );


/* ==========================================================================
   3. AJAX: VACCINE SEARCH (for search bar if used)
   ========================================================================== */
function vaccine_search_ajax() {

    check_ajax_referer( 'vaccination_booking_nonce', 'nonce' );

    $query = isset( $_POST['query'] ) ? sanitize_text_field( $_POST['query'] ) : '';
    if ( strlen( $query ) < 3 ) {
        wp_send_json_error( [ 'message' => 'Query too short' ] );
        return;
    }

    $params = [
        'limit'   => 10,
        'where'   => "post_title LIKE '%" . esc_sql( $query ) . "%'",
        'orderby' => 'post_title ASC',
    ];

    $vaccines = pods( 'vaccine', $params );
    $results  = [];

    if ( $vaccines->total() > 0 ) {
        while ( $vaccines->fetch() ) {
            $results[] = [
                'id'    => $vaccines->id(),
                'title' => $vaccines->field( 'post_title' ),
                'url'   => get_permalink( $vaccines->id() ),
                'price' => $vaccines->field( 'price' ),
            ];
        }
    }

    wp_send_json_success( [ 'results' => $results ] );
}
add_action( 'wp_ajax_vaccine_search',        'vaccine_search_ajax' );
add_action( 'wp_ajax_nopriv_vaccine_search', 'vaccine_search_ajax' );


/* ==========================================================================
   4. CF7 CUSTOM TAG: [dynamic_vaccines category]
      Renders vaccine checkboxes + "Other Vaccine" card dynamically
   ========================================================================== */
function vaccination_centre_cf7_dynamic_vaccines( $tag ) {

    // Detect category from tag name or options
    $category_key = '';
    $name         = sanitize_key( $tag->name );

    foreach ( [ 'adult', 'child', 'flu', 'travel' ] as $key ) {
        if ( $name === $key || strpos( $name, $key ) !== false ) {
            $category_key = $key; break;
        }
    }
    if ( empty( $category_key ) ) {
        foreach ( array_merge( (array) $tag->options, (array) $tag->values ) as $v ) {
            if ( in_array( sanitize_key( $v ), [ 'adult', 'child', 'flu', 'travel' ] ) ) {
                $category_key = sanitize_key( $v ); break;
            }
        }
    }

    $slug_map = [
        'child'  => 'child-vaccines',
        'adult'  => 'adult-vaccines',
        'flu'    => 'flu-vaccines',
        'travel' => 'travel-vaccines',
    ];
    $tax_slug = $slug_map[ $category_key ] ?? '';
    $vaccines = [];

    if ( $tax_slug ) {
        $term = get_term_by( 'slug', $tax_slug, 'vaccine_category' );
        if ( $term && ! is_wp_error( $term ) ) {
            $wq = new WP_Query( [
                'post_type'      => 'vaccine',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'orderby'        => 'title',
                'order'          => 'ASC',
                'tax_query'      => [ [
                    'taxonomy'         => 'vaccine_category',
                    'field'            => 'term_id',
                    'terms'            => $term->term_id,
                    'include_children' => false,
                ] ],
            ] );
            $vaccines = $wq->posts;
        }

        // Fallback: manual filter
        if ( empty( $vaccines ) ) {
            foreach ( get_posts( [ 'post_type' => 'vaccine', 'post_status' => 'publish', 'posts_per_page' => -1 ] ) as $v ) {
                $slugs = wp_get_post_terms( $v->ID, 'vaccine_category', [ 'fields' => 'slugs' ] );
                if ( in_array( $tax_slug, $slugs ) ) $vaccines[] = $v;
            }
        }
    }

    $field_name = esc_attr( $tag->name );
    $uid        = 'dv_' . $field_name . '_' . uniqid();

    // ── CSS (injected once per page) ──────────────────────────────────────
    static $css_done = false;
    $html = '';
    if ( ! $css_done ) {
        $css_done = true;
        $html .= '<style>
        .dv-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:10px;margin-top:6px}
        .dv-item{position:relative}
        .dv-item input[type="checkbox"]{position:absolute;opacity:0;width:0;height:0;pointer-events:none}
        .dv-label{display:flex;align-items:flex-start;gap:12px;padding:14px 16px;border:2px solid #e5e7eb;
            border-radius:12px;cursor:pointer;background:#fff;transition:all .2s ease;user-select:none}
        .dv-label:hover{border-color:#107fa0;background:#f0f9ff;box-shadow:0 2px 10px rgba(16,127,160,.12);transform:translateY(-1px)}
        .dv-item input[type="checkbox"]:checked+.dv-label{border-color:#107fa0;
            background:linear-gradient(135deg,#e0f4f9 0%,#e8f5e0 100%);box-shadow:0 3px 16px rgba(16,127,160,.18)}
        .dv-checkbox-box{width:22px;height:22px;min-width:22px;border:2px solid #d1d5db;border-radius:6px;
            background:#fff;display:flex;align-items:center;justify-content:center;margin-top:1px;
            transition:all .2s ease;font-size:13px;color:transparent;font-weight:700}
        .dv-item input[type="checkbox"]:checked+.dv-label .dv-checkbox-box{background:#107fa0;border-color:#107fa0;color:#fff}
        .dv-info{flex:1}
        .dv-vaccine-name{font-weight:600;color:#1f2937;font-size:14px;line-height:1.4;display:block;margin-bottom:5px}
        .dv-item input[type="checkbox"]:checked+.dv-label .dv-vaccine-name{color:#0a5f7a}
        .dv-vaccine-meta{display:flex;align-items:center;gap:6px;flex-wrap:wrap}
        .dv-price{font-size:13px;font-weight:700;color:#107fa0}
        .dv-age{font-size:11px;color:#6b7280;background:#f3f4f6;padding:2px 8px;border-radius:20px}
        .dv-hint{font-size:12px;color:#9ca3af;margin-bottom:10px;display:block}
        .dv-other-input-wrap{display:none;margin-top:10px}
        .dv-other-input-wrap input[type="text"]{width:100%;padding:12px 15px;border:2px solid #107fa0;
            border-radius:8px;font-size:14px;background:#f0f9ff;box-sizing:border-box;font-family:inherit}
        @keyframes fadeInDown{from{opacity:0;transform:translateY(-8px)}to{opacity:1;transform:translateY(0)}}
        </style>';
    }

    if ( empty( $vaccines ) ) {
        $html .= '<span class="wpcf7-form-control-wrap" data-name="' . $field_name . '">';
        $html .= '<p style="color:#6b7280;font-size:14px;">No vaccines found (slug: ' . esc_html( $tax_slug ) . ')</p>';
        $html .= '</span>';
        return $html;
    }

    $html .= '<span class="wpcf7-form-control-wrap" data-name="' . $field_name . '">';
    $html .= '<span class="dv-hint">&#10003; Select one or more vaccines</span>';
    $html .= '<div class="dv-grid" id="' . esc_attr( $uid ) . '">';

    foreach ( $vaccines as $vaccine ) {
        $price     = get_post_meta( $vaccine->ID, '_vaccine_price', true );
        $age_range = get_post_meta( $vaccine->ID, '_vaccine_age_range', true );
        $v_name    = esc_attr( $vaccine->post_title );
        $cb_id     = esc_attr( $uid . '_' . $vaccine->ID );

        $html .= '<div class="dv-item">';
        $html .= '<input type="checkbox" name="' . $field_name . '[]" id="' . $cb_id . '" value="' . $v_name . '">';
        $html .= '<label class="dv-label" for="' . $cb_id . '">';
        $html .= '<span class="dv-checkbox-box">&#10003;</span>';
        $html .= '<span class="dv-info"><span class="dv-vaccine-name">' . esc_html( $vaccine->post_title ) . '</span>';
        $html .= '<span class="dv-vaccine-meta">';
        if ( $price )     $html .= '<span class="dv-price">PKR ' . number_format( (float) $price ) . '</span>';
        if ( $age_range ) $html .= '<span class="dv-age">' . esc_html( $age_range ) . '</span>';
        $html .= '</span></span></label></div>';
    }

    $html .= '</div>'; // end dv-grid

    // ── Other Vaccine card ─────────────────────────────────────────────────
    $other_cb_id   = esc_attr( $uid . '_other' );
    $other_wrap_id = esc_attr( $uid . '_other_wrap' );

    $html .= '<div class="dv-other-wrap" style="margin-top:10px;">';
    $html .= '<div class="dv-item">';
    $html .= '<input type="checkbox" name="' . $field_name . '[]" id="' . $other_cb_id . '" value="Other" class="dv-other-trigger" data-target="' . $other_wrap_id . '">';
    $html .= '<label class="dv-label" for="' . $other_cb_id . '" style="border-style:dashed;border-color:#9ca3af;background:#fafafa;">';
    $html .= '<span class="dv-checkbox-box" style="border-color:#9ca3af;">&#10003;</span>';
    $html .= '<span class="dv-info"><span class="dv-vaccine-name" style="color:#6b7280;">&#43; Other Vaccine</span>';
    $html .= '<span style="font-size:12px;color:#9ca3af;display:block;">Not in the list? Specify here</span></span>';
    $html .= '</label></div>';

    $html .= '<div id="' . $other_wrap_id . '" class="dv-other-input-wrap">';
    $html .= '<input type="text" name="' . $field_name . '_other_text" placeholder="e.g. Rabies, Yellow Fever, Meningitis...">';
    $html .= '<p style="font-size:12px;color:#6b7280;margin-top:5px;">&#9432; Write the vaccine name — we will confirm availability</p>';
    $html .= '</div>';
    $html .= '</div>'; // end dv-other-wrap

    $html .= '</span>'; // end wpcf7-form-control-wrap
    return $html;
}

add_action( 'wpcf7_init', function () {
    if ( function_exists( 'wpcf7_add_form_tag' ) ) {
        wpcf7_add_form_tag(
            [ 'dynamic_vaccines', 'dynamic_vaccines*' ],
            'vaccination_centre_cf7_dynamic_vaccines',
            [ 'name-attr' => true ]
        );
    }
} );




/* ==========================================================================
   6. FRONTEND JS: Conditional fields (Home address + Other vaccine toggle)
      Runs after AJAX form injection via MutationObserver
   ========================================================================== */
add_action( 'wp_footer', function () { ?>
<style>
/* Home address conditional wrap */
.home-address-wrap{display:none;margin-top:14px;animation:fadeInDown .3s ease}
.home-address-wrap.visible{display:block}
.home-address-wrap label{display:block;font-weight:600;color:#374151;margin-bottom:8px}
.home-address-wrap .address-box{width:100%;padding:12px 15px;border:2px solid #107fa0;border-radius:8px;
    font-size:15px;font-family:inherit;resize:vertical;background:#f0f9ff;transition:all .3s;box-sizing:border-box}
.home-address-wrap .address-box:focus{outline:none;box-shadow:0 0 0 3px rgba(16,127,160,.15)}
.home-address-hint{font-size:12px;color:#6b7280;margin-top:5px}
/* File upload */
.wpcf7 input[type="file"]{width:100%;padding:10px 14px;border:2px dashed #d1d5db;border-radius:8px;
    background:#fafafa;cursor:pointer;font-size:14px;transition:all .3s;box-sizing:border-box}
.wpcf7 input[type="file"]:hover{border-color:#107fa0;background:#f0f9ff}
</style>

<script>
function vaccinationInitForms() {

    /* ── 1. Home Service → show address textarea ── */
    document.querySelectorAll('input[type="radio"]').forEach(function(radio) {
        if (radio.dataset.hsInit) return;
        radio.dataset.hsInit = '1';

        var listItem = radio.closest('.wpcf7-list-item');
        if (!listItem || listItem.textContent.indexOf('Home Service') === -1) return;

        var form      = radio.closest('#form-container, .wpcf7-form, form');
        var addrWrap  = form && form.querySelector('.home-address-wrap');
        if (!form || !addrWrap) return;

        var radioName = radio.name;
        form.querySelectorAll('input[name="' + radioName + '"]').forEach(function(r) {
            if (r.dataset.hsGroupInit) return;
            r.dataset.hsGroupInit = '1';
            r.addEventListener('change', function() {
                var checked = form.querySelector('input[name="' + radioName + '"]:checked');
                var label   = checked && checked.closest('.wpcf7-list-item');
                var isHome  = label && label.textContent.indexOf('Home Service') !== -1;
                var ta      = addrWrap.querySelector('textarea');
                if (isHome) {
                    addrWrap.style.display = 'block';
                    addrWrap.classList.add('visible');
                    if (ta) ta.setAttribute('required','required');
                } else {
                    addrWrap.style.display = 'none';
                    addrWrap.classList.remove('visible');
                    if (ta) { ta.removeAttribute('required'); ta.value = ''; }
                }
            });
        });
    });

    /* ── 2. Other Vaccine checkbox → show text input ── */
    document.querySelectorAll('.dv-other-trigger').forEach(function(cb) {
        if (cb.dataset.otherInit) return;
        cb.dataset.otherInit = '1';

        var targetId = cb.getAttribute('data-target');
        var wrap     = targetId ? document.getElementById(targetId) : null;
        if (!wrap) return;

        cb.addEventListener('change', function() {
            var inp = wrap.querySelector('input[type="text"]');
            if (cb.checked) {
                wrap.style.display = 'block';
                wrap.style.animation = 'fadeInDown .3s ease';
                if (inp) inp.focus();
            } else {
                wrap.style.display = 'none';
                if (inp) inp.value = '';
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', function() {

    // Watch form-container for AJAX-injected forms
    var fc = document.getElementById('form-container');
    if (fc) {
        new MutationObserver(function() {
            setTimeout(vaccinationInitForms, 350);
        }).observe(fc, { childList: true, subtree: true });
    }

    // Bootstrap modal shown event
    document.addEventListener('shown.bs.modal', function() {
        setTimeout(vaccinationInitForms, 400);
    });

    vaccinationInitForms();
});
</script>
<?php } );


/* ==========================================================================
   7. REGISTER VACCINES CUSTOM POST TYPE
   ========================================================================== */
function vaccination_centre_register_vaccines() {
    register_post_type( 'vaccine', [
        'label'    => __( 'Vaccines', 'vaccination-centre' ),
        'labels'   => [
            'name'          => _x( 'Vaccines', 'Post Type General Name', 'vaccination-centre' ),
            'singular_name' => _x( 'Vaccine', 'Post Type Singular Name', 'vaccination-centre' ),
            'menu_name'     => __( 'Vaccines', 'vaccination-centre' ),
            'add_new_item'  => __( 'Add New Vaccine', 'vaccination-centre' ),
            'edit_item'     => __( 'Edit Vaccine', 'vaccination-centre' ),
            'not_found'     => __( 'No vaccines found.', 'vaccination-centre' ),
        ],
        'supports'            => [ 'title', 'editor', 'thumbnail', 'custom-fields' ],
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-heart',
        'has_archive'         => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest'        => true,
    ] );
}
add_action( 'init', 'vaccination_centre_register_vaccines' );


/* ==========================================================================
   8. REGISTER VACCINE CATEGORIES TAXONOMY
   ========================================================================== */
function vaccination_centre_register_vaccine_categories() {
    register_taxonomy( 'vaccine_category', [ 'vaccine' ], [
        'hierarchical'      => true,
        'labels'            => [
            'name'          => _x( 'Vaccine Categories', 'taxonomy general name', 'vaccination-centre' ),
            'singular_name' => _x( 'Vaccine Category', 'taxonomy singular name', 'vaccination-centre' ),
            'menu_name'     => __( 'Categories', 'vaccination-centre' ),
        ],
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => [ 'slug' => 'vaccine-category' ],
        'show_in_rest'      => true,
    ] );
}
add_action( 'init', 'vaccination_centre_register_vaccine_categories' );


/* ==========================================================================
   9. VACCINE META BOXES (Price, Age Range, Doses, Interval)
   ========================================================================== */
add_action( 'add_meta_boxes', function () {
    add_meta_box( 'vaccine_details', __( 'Vaccine Details', 'vaccination-centre' ),
        'vaccination_centre_vaccine_details_callback', 'vaccine', 'normal', 'high' );
} );

function vaccination_centre_vaccine_details_callback( $post ) {
    wp_nonce_field( 'vaccine_details_nonce', 'vaccine_details_nonce_field' );
    $price     = get_post_meta( $post->ID, '_vaccine_price', true );
    $age_range = get_post_meta( $post->ID, '_vaccine_age_range', true );
    $doses     = get_post_meta( $post->ID, '_vaccine_doses', true );
    $interval  = get_post_meta( $post->ID, '_vaccine_interval', true );
    ?>
    <table class="form-table">
        <tr>
            <th><label for="vaccine_price"><?php _e( 'Price (PKR)', 'vaccination-centre' ); ?></label></th>
            <td>
                <input type="text" id="vaccine_price" name="vaccine_price" value="<?php echo esc_attr( $price ); ?>" class="regular-text">
                <p class="description"><?php _e( 'Enter vaccine price in Pakistani Rupees', 'vaccination-centre' ); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="vaccine_age_range"><?php _e( 'Age Range', 'vaccination-centre' ); ?></label></th>
            <td>
                <input type="text" id="vaccine_age_range" name="vaccine_age_range" value="<?php echo esc_attr( $age_range ); ?>" class="regular-text">
                <p class="description"><?php _e( 'e.g., Birth to 2 years, 18+ years, All ages', 'vaccination-centre' ); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="vaccine_doses"><?php _e( 'Number of Doses', 'vaccination-centre' ); ?></label></th>
            <td>
                <input type="number" id="vaccine_doses" name="vaccine_doses" value="<?php echo esc_attr( $doses ); ?>" min="1" max="10" class="small-text">
            </td>
        </tr>
        <tr>
            <th><label for="vaccine_interval"><?php _e( 'Dose Interval', 'vaccination-centre' ); ?></label></th>
            <td>
                <input type="text" id="vaccine_interval" name="vaccine_interval" value="<?php echo esc_attr( $interval ); ?>" class="regular-text">
                <p class="description"><?php _e( 'e.g., 4-6 weeks, Annual, Single dose', 'vaccination-centre' ); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

add_action( 'save_post_vaccine', function ( $post_id ) {
    if ( ! isset( $_POST['vaccine_details_nonce_field'] ) ||
         ! wp_verify_nonce( $_POST['vaccine_details_nonce_field'], 'vaccine_details_nonce' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $fields = [ 'vaccine_price' => '_vaccine_price', 'vaccine_age_range' => '_vaccine_age_range',
                'vaccine_interval' => '_vaccine_interval' ];
    foreach ( $fields as $post_key => $meta_key ) {
        if ( isset( $_POST[ $post_key ] ) )
            update_post_meta( $post_id, $meta_key, sanitize_text_field( $_POST[ $post_key ] ) );
    }
    if ( isset( $_POST['vaccine_doses'] ) )
        update_post_meta( $post_id, '_vaccine_doses', absint( $_POST['vaccine_doses'] ) );
} );


/* ==========================================================================
   10. THEME SETUP
   ========================================================================== */
add_action( 'after_setup_theme', function () {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ] );
    add_theme_support( 'custom-logo', [ 'height' => 100, 'width' => 400, 'flex-height' => true, 'flex-width' => true ] );
} );

add_action( 'init', function () {
    register_nav_menus( [ 'primary' => __( 'Primary Menu', 'vaccination-centre' ), 'footer' => __( 'Footer Menu', 'vaccination-centre' ) ] );
} );

add_action( 'after_setup_theme', function () {
    add_image_size( 'hero-image', 1200, 800, true );
    add_image_size( 'service-thumbnail', 400, 300, true );
    add_image_size( 'blog-thumbnail', 800, 500, true );
} );


/* ==========================================================================
   11. WIDGET AREAS
   ========================================================================== */
add_action( 'widgets_init', function () {
    $shared = [ 'before_widget' => '<div class="footer-widget mb-4">', 'after_widget' => '</div>',
                'before_title'  => '<h4 class="widget-title fw-bold mb-3">', 'after_title' => '</h4>' ];
    register_sidebar( array_merge( $shared, [ 'name' => __( 'Footer Widget Area 1', 'vaccination-centre' ), 'id' => 'footer-1', 'description' => __( 'Appears in the footer area', 'vaccination-centre' ) ] ) );
    register_sidebar( array_merge( $shared, [ 'name' => __( 'Footer Widget Area 2', 'vaccination-centre' ), 'id' => 'footer-2', 'description' => __( 'Appears in the footer area', 'vaccination-centre' ) ] ) );
} );


/* ==========================================================================
   12. MISC HELPERS
   ========================================================================== */
add_filter( 'excerpt_length',            fn() => 30 );
add_filter( 'excerpt_more',              fn() => '...' );
add_filter( 'document_title_separator',  fn() => '|' );
add_filter( 'the_generator',             fn() => '' );

// Disable emoji scripts for performance
add_action( 'init', function () {
    remove_action( 'wp_head',             'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles',     'print_emoji_styles' );
    remove_action( 'admin_print_styles',  'print_emoji_styles' );
    remove_filter( 'the_content_feed',    'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss',    'wp_staticize_emoji' );
    remove_filter( 'wp_mail',             'wp_staticize_emoji_for_email' );
} );

// Disable file editing from admin
if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) define( 'DISALLOW_FILE_EDIT', true );

// Reading time helper
function vaccination_centre_reading_time() {
    return ceil( str_word_count( strip_tags( get_post_field( 'post_content', get_the_ID() ) ) ) / 200 );
}

// Post views counter
function vaccination_centre_set_post_views( $post_id ) {
    $count = get_post_meta( $post_id, 'post_views_count', true );
    $count = $count === '' ? 0 : (int) $count + 1;
    update_post_meta( $post_id, 'post_views_count', $count );
}
function vaccination_centre_get_post_views( $post_id ) {
    $count = get_post_meta( $post_id, 'post_views_count', true );
    return $count === '' ? '0' : number_format_i18n( (int) $count );
}
add_action( 'wp_head', function () {
    if ( is_single() ) vaccination_centre_set_post_views( get_the_ID() );
} );

// Bootstrap Nav Walker
class vaccination_centre_Bootstrap_Nav_Walker extends Walker_Nav_Menu {
    function start_lvl( &$output, $depth = 0, $args = null ) {
        $output .= "\n" . str_repeat( "\t", $depth ) . "<ul class=\"dropdown-menu\">\n";
    }
    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $classes   = (array) ( $item->classes ?? [] );
        $classes[] = 'nav-item';
        if ( $args->walker->has_children ) $classes[] = 'dropdown';
        $class_str = esc_attr( implode( ' ', array_filter( apply_filters( 'nav_menu_css_class', $classes, $item, $args ) ) ) );

        $output .= str_repeat( "\t", $depth ) . '<li class="' . $class_str . '">';

        $atts = [ 'href' => $item->url ?? '', 'class' => 'nav-link' ];
        if ( $args->walker->has_children ) { $atts['class'] .= ' dropdown-toggle'; $atts['data-bs-toggle'] = 'dropdown'; }
        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

        $attr_str = '';
        foreach ( $atts as $k => $v ) {
            if ( $v ) $attr_str .= ' ' . $k . '="' . ( $k === 'href' ? esc_url( $v ) : esc_attr( $v ) ) . '"';
        }

        $output .= apply_filters( 'walker_nav_menu_start_el',
            $args->before . '<a' . $attr_str . '>' . $args->link_before .
            apply_filters( 'the_title', $item->title, $item->ID ) .
            $args->link_after . '</a>' . $args->after,
            $item, $depth, $args );
    }
}

// Pagination helper
function vaccination_centre_pagination() {
    global $wp_query;
    $big = 999999999;
    echo paginate_links( [
        'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format'    => '?paged=%#%',
        'current'   => max( 1, get_query_var( 'paged' ) ),
        'total'     => $wp_query->max_num_pages,
        'prev_text' => '<i class="bi bi-arrow-left"></i> Previous',
        'next_text' => 'Next <i class="bi bi-arrow-right"></i>',
        'type'      => 'list',
    ] );
}
