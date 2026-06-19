<?php
if ( ! defined('ABSPATH') ) exit;

/* ==================== Enqueue Styles & Scripts ==================== */
function vaccination_centre_assets() {

    /* Google Fonts - Poppins */
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap',
        [],
        null
    );

    /* Bootstrap CSS (Cloudflare CDN) */
    wp_enqueue_style(
        'bootstrap',
        'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css',
        [],
        '5.3.2'
    );

    /* Bootstrap Icons (Cloudflare CDN) */
    wp_enqueue_style(
        'bootstrap-icons',
        'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css',
        [],
        '1.11.3'
    );

    /* Main Theme CSS */
    wp_enqueue_style(
        'babymedics-main',
        get_template_directory_uri() . '/assets/css/main.css',
        ['bootstrap', 'bootstrap-icons', 'google-fonts'],
        filemtime(get_template_directory() . '/assets/css/main.css')
    );

    /* Bootstrap JS Bundle (Cloudflare CDN) */
    wp_enqueue_script(
        'bootstrap-js',
        'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js',
        [],
        '5.3.2',
        true
    );

    /* Custom Theme JS (optional) */
    if (file_exists(get_template_directory() . '/assets/js/main.js')) {
        wp_enqueue_script(
            'babymedics-main-js',
            get_template_directory_uri() . '/assets/js/main.js',
            ['jquery'],
            filemtime(get_template_directory() . '/assets/js/main.js'),
            true
        );
    }

    /* Localize script for AJAX */
    wp_localize_script('bootstrap-js', 'vaccination_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('vaccination_booking_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'vaccination_centre_assets');

/* ==================== AJAX: Load Booking Form ==================== */
function load_booking_form_ajax() {

    // Verify nonce for security
    check_ajax_referer('vaccination_booking_nonce', 'nonce');

    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';

    // Map category slugs to CF7 form TITLES
    // ⚠️ Yeh titles exactly wohi honi chahiye jo aapne CF7 mein rakhi hain
    $form_titles = array(
        'child'  => 'Child Vaccine Booking',
        'adult'  => 'Adult Vaccine Booking',
        'flu'    => 'Flu Vaccine Booking',
        'travel' => 'Travel Vaccine Booking',
    );

    if ( ! array_key_exists( $category, $form_titles ) ) {
        echo '<div class="alert alert-warning"><i class="bi bi-exclamation-triangle-fill me-2"></i>Invalid category selected.</div>';
        wp_die();
    }

    // Check if CF7 plugin is active
    if ( ! function_exists('wpcf7_contact_form') ) {
        echo '<div class="alert alert-danger"><i class="bi bi-x-circle-fill me-2"></i>Contact Form 7 plugin is not active. Please activate it from WordPress plugins.</div>';
        wp_die();
    }

    // Find CF7 form by title using WP_Query
    $query = new WP_Query(array(
        'post_type'      => 'wpcf7_contact_form',
        'post_status'    => 'publish',
        'title'          => $form_titles[ $category ],
        'posts_per_page' => 1,
    ));

    // Fallback: if title search fails, try get_posts with name matching
    if ( ! $query->have_posts() ) {
        $all_forms = get_posts(array(
            'post_type'      => 'wpcf7_contact_form',
            'post_status'    => 'publish',
            'numberposts'    => -1,
        ));

        $matched_id = null;
        foreach ( $all_forms as $f ) {
            // Case-insensitive partial match
            if ( stripos( $f->post_title, $form_titles[ $category ] ) !== false ) {
                $matched_id = $f->ID;
                break;
            }
        }

        if ( $matched_id ) {
            $cf7 = wpcf7_contact_form( $matched_id );
            if ( $cf7 ) {
                echo $cf7->form_html();
                wp_die();
            }
        }

        // If still not found, show all available forms for debugging
        $form_list = '';
        foreach ( $all_forms as $f ) {
            $form_list .= '<li><strong>ID:</strong> ' . $f->ID . ' &nbsp;|&nbsp; <strong>Title:</strong> ' . esc_html($f->post_title) . '</li>';
        }

        echo '<div class="alert alert-warning">';
        echo '<h6 class="fw-bold mb-2"><i class="bi bi-exclamation-triangle-fill me-2"></i>Form Not Found</h6>';
        echo '<p class="mb-2">Could not find a form matching: <strong>' . esc_html($form_titles[$category]) . '</strong></p>';
        if ( $form_list ) {
            echo '<p class="mb-1 fw-bold">Available CF7 Forms in your WordPress:</p>';
            echo '<ul class="mb-0">' . $form_list . '</ul>';
            echo '<p class="mt-2 mb-0 text-muted small">Please update the <code>$form_titles</code> array in functions.php to match your exact CF7 form titles.</p>';
        } else {
            echo '<p class="mb-0">No Contact Form 7 forms found. Please create forms in <strong>WordPress Admin → Contact → Add New</strong>.</p>';
        }
        echo '</div>';
        wp_die();
    }

    // Form found via WP_Query
    $post = $query->posts[0];
    $cf7  = wpcf7_contact_form( $post->ID );

    if ( $cf7 ) {
        echo $cf7->form_html();
    } else {
        echo '<div class="alert alert-danger"><i class="bi bi-x-circle-fill me-2"></i>Could not load the form. Please try again.</div>';
    }

    wp_die();
}
add_action('wp_ajax_load_booking_form',        'load_booking_form_ajax');
add_action('wp_ajax_nopriv_load_booking_form', 'load_booking_form_ajax');

/* ==================== AJAX: Vaccine Search ==================== */
function vaccine_search_ajax() {

    check_ajax_referer('vaccination_booking_nonce', 'nonce');

    $query = isset($_POST['query']) ? sanitize_text_field($_POST['query']) : '';

    if ( strlen($query) < 3 ) {
        wp_send_json_error(['message' => 'Query too short']);
        return;
    }

    $params = array(
        'limit'   => 10,
        'where'   => "
            post_title LIKE '%" . esc_sql($query) . "%' OR
            disease_name.meta_value LIKE '%" . esc_sql($query) . "%' OR
            vaccine_brand.meta_value LIKE '%" . esc_sql($query) . "%'
        ",
        'orderby' => 'post_title ASC'
    );

    $vaccines = pods('vaccine', $params);
    $results  = [];

    if ( $vaccines->total() > 0 ) {
        while ( $vaccines->fetch() ) {
            $results[] = array(
                'id'           => $vaccines->id(),
                'title'        => $vaccines->field('post_title'),
                'url'          => get_permalink($vaccines->id()),
                'disease'      => $vaccines->field('disease_name'),
                'brand'        => $vaccines->field('vaccine_brand'),
                'age'          => $vaccines->field('age_requirement'),
                'availability' => $vaccines->field('availability'),
                'price'        => $vaccines->field('price')
            );
        }
    }

    wp_send_json_success(['results' => $results]);
}
add_action('wp_ajax_vaccine_search',        'vaccine_search_ajax');
add_action('wp_ajax_nopriv_vaccine_search', 'vaccine_search_ajax');

/* ==================== Register Vaccines Custom Post Type ==================== */
function vaccination_centre_register_vaccines() {
    $labels = array(
        'name'               => _x('Vaccines', 'Post Type General Name', 'vaccination-centre'),
        'singular_name'      => _x('Vaccine', 'Post Type Singular Name', 'vaccination-centre'),
        'menu_name'          => __('Vaccines', 'vaccination-centre'),
        'name_admin_bar'     => __('Vaccine', 'vaccination-centre'),
        'add_new'            => __('Add New Vaccine', 'vaccination-centre'),
        'add_new_item'       => __('Add New Vaccine', 'vaccination-centre'),
        'new_item'           => __('New Vaccine', 'vaccination-centre'),
        'edit_item'          => __('Edit Vaccine', 'vaccination-centre'),
        'view_item'          => __('View Vaccine', 'vaccination-centre'),
        'all_items'          => __('All Vaccines', 'vaccination-centre'),
        'search_items'       => __('Search Vaccines', 'vaccination-centre'),
        'not_found'          => __('No vaccines found.', 'vaccination-centre'),
        'not_found_in_trash' => __('No vaccines found in Trash.', 'vaccination-centre'),
    );

    $args = array(
        'label'             => __('Vaccines', 'vaccination-centre'),
        'labels'            => $labels,
        'supports'          => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'public'            => true,
        'show_ui'           => true,
        'show_in_menu'      => true,
        'menu_position'     => 5,
        'menu_icon'         => 'dashicons-heart',
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export'        => true,
        'has_archive'       => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest'        => true,
    );

    register_post_type('vaccine', $args);
}
add_action('init', 'vaccination_centre_register_vaccines');

/* ==================== Register Vaccine Categories Taxonomy ==================== */
function vaccination_centre_register_vaccine_categories() {
    $labels = array(
        'name'              => _x('Vaccine Categories', 'taxonomy general name', 'vaccination-centre'),
        'singular_name'     => _x('Vaccine Category', 'taxonomy singular name', 'vaccination-centre'),
        'search_items'      => __('Search Vaccine Categories', 'vaccination-centre'),
        'all_items'         => __('All Vaccine Categories', 'vaccination-centre'),
        'parent_item'       => __('Parent Vaccine Category', 'vaccination-centre'),
        'parent_item_colon' => __('Parent Vaccine Category:', 'vaccination-centre'),
        'edit_item'         => __('Edit Vaccine Category', 'vaccination-centre'),
        'update_item'       => __('Update Vaccine Category', 'vaccination-centre'),
        'add_new_item'      => __('Add New Vaccine Category', 'vaccination-centre'),
        'new_item_name'     => __('New Vaccine Category Name', 'vaccination-centre'),
        'menu_name'         => __('Categories', 'vaccination-centre'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'vaccine-category'),
        'show_in_rest'      => true,
    );

    register_taxonomy('vaccine_category', array('vaccine'), $args);
}
add_action('init', 'vaccination_centre_register_vaccine_categories');

/* ==================== Add Vaccine Meta Boxes ==================== */
function vaccination_centre_vaccine_meta_boxes() {
    add_meta_box(
        'vaccine_details',
        __('Vaccine Details', 'vaccination-centre'),
        'vaccination_centre_vaccine_details_callback',
        'vaccine',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'vaccination_centre_vaccine_meta_boxes');

function vaccination_centre_vaccine_details_callback($post) {
    wp_nonce_field('vaccine_details_nonce', 'vaccine_details_nonce_field');

    $price     = get_post_meta($post->ID, '_vaccine_price', true);
    $age_range = get_post_meta($post->ID, '_vaccine_age_range', true);
    $doses     = get_post_meta($post->ID, '_vaccine_doses', true);
    $interval  = get_post_meta($post->ID, '_vaccine_interval', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="vaccine_price"><?php _e('Price (PKR)', 'vaccination-centre'); ?></label></th>
            <td>
                <input type="text" id="vaccine_price" name="vaccine_price" value="<?php echo esc_attr($price); ?>" class="regular-text">
                <p class="description"><?php _e('Enter vaccine price in Pakistani Rupees', 'vaccination-centre'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="vaccine_age_range"><?php _e('Age Range', 'vaccination-centre'); ?></label></th>
            <td>
                <input type="text" id="vaccine_age_range" name="vaccine_age_range" value="<?php echo esc_attr($age_range); ?>" class="regular-text">
                <p class="description"><?php _e('e.g., Birth to 2 years, 18+ years, All ages', 'vaccination-centre'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="vaccine_doses"><?php _e('Number of Doses', 'vaccination-centre'); ?></label></th>
            <td>
                <input type="number" id="vaccine_doses" name="vaccine_doses" value="<?php echo esc_attr($doses); ?>" min="1" max="10" class="small-text">
                <p class="description"><?php _e('Total doses required', 'vaccination-centre'); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="vaccine_interval"><?php _e('Dose Interval', 'vaccination-centre'); ?></label></th>
            <td>
                <input type="text" id="vaccine_interval" name="vaccine_interval" value="<?php echo esc_attr($interval); ?>" class="regular-text">
                <p class="description"><?php _e('e.g., 4-6 weeks, Annual, Single dose', 'vaccination-centre'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

/* ==================== Save Vaccine Meta Data ==================== */
function vaccination_centre_save_vaccine_meta($post_id) {
    if ( ! isset($_POST['vaccine_details_nonce_field']) ||
         ! wp_verify_nonce($_POST['vaccine_details_nonce_field'], 'vaccine_details_nonce') ) {
        return;
    }

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can('edit_post', $post_id) ) {
        return;
    }

    if ( isset($_POST['vaccine_price']) ) {
        update_post_meta($post_id, '_vaccine_price', sanitize_text_field($_POST['vaccine_price']));
    }

    if ( isset($_POST['vaccine_age_range']) ) {
        update_post_meta($post_id, '_vaccine_age_range', sanitize_text_field($_POST['vaccine_age_range']));
    }

    if ( isset($_POST['vaccine_doses']) ) {
        update_post_meta($post_id, '_vaccine_doses', absint($_POST['vaccine_doses']));
    }

    if ( isset($_POST['vaccine_interval']) ) {
        update_post_meta($post_id, '_vaccine_interval', sanitize_text_field($_POST['vaccine_interval']));
    }
}
add_action('save_post_vaccine', 'vaccination_centre_save_vaccine_meta');

/* ==================== Theme Support ==================== */
function vaccination_centre_theme_support() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);
    add_theme_support('custom-logo', [
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ]);
}
add_action('after_setup_theme', 'vaccination_centre_theme_support');

/* ==================== Navigation Menus ==================== */
function vaccination_centre_menus() {
    register_nav_menus([
        'primary' => __('Primary Menu', 'vaccination-centre'),
        'footer'  => __('Footer Menu', 'vaccination-centre'),
    ]);
}
add_action('init', 'vaccination_centre_menus');

/* ==================== Widget Areas ==================== */
function vaccination_centre_widgets_init() {
    register_sidebar([
        'name'          => __('Footer Widget Area 1', 'vaccination-centre'),
        'id'            => 'footer-1',
        'description'   => __('Appears in the footer area', 'vaccination-centre'),
        'before_widget' => '<div class="footer-widget mb-4">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title fw-bold mb-3">',
        'after_title'   => '</h4>',
    ]);

    register_sidebar([
        'name'          => __('Footer Widget Area 2', 'vaccination-centre'),
        'id'            => 'footer-2',
        'description'   => __('Appears in the footer area', 'vaccination-centre'),
        'before_widget' => '<div class="footer-widget mb-4">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title fw-bold mb-3">',
        'after_title'   => '</h4>',
    ]);
}
add_action('widgets_init', 'vaccination_centre_widgets_init');

/* ==================== Custom Excerpt Length ==================== */
function vaccination_centre_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'vaccination_centre_excerpt_length');

/* ==================== Custom Excerpt More ==================== */
function vaccination_centre_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'vaccination_centre_excerpt_more');

/* ==================== Custom Title Separator ==================== */
function vaccination_centre_document_title_separator($sep) {
    return '|';
}
add_filter('document_title_separator', 'vaccination_centre_document_title_separator');

/* ==================== Remove WordPress Version ==================== */
function vaccination_centre_remove_version() {
    return '';
}
add_filter('the_generator', 'vaccination_centre_remove_version');

/* ==================== Custom Image Sizes ==================== */
function vaccination_centre_image_sizes() {
    add_image_size('hero-image', 1200, 800, true);
    add_image_size('service-thumbnail', 400, 300, true);
    add_image_size('blog-thumbnail', 800, 500, true);
}
add_action('after_setup_theme', 'vaccination_centre_image_sizes');

/* ==================== Pagination ==================== */
function vaccination_centre_pagination() {
    global $wp_query;

    $big = 999999999;

    echo paginate_links([
        'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format'    => '?paged=%#%',
        'current'   => max(1, get_query_var('paged')),
        'total'     => $wp_query->max_num_pages,
        'prev_text' => '<i class="bi bi-arrow-left"></i> Previous',
        'next_text' => 'Next <i class="bi bi-arrow-right"></i>',
        'type'      => 'list',
    ]);
}

/* ==================== Custom Walker for Bootstrap Nav ==================== */
class vaccination_centre_Bootstrap_Nav_Walker extends Walker_Nav_Menu {

    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent  = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes   = empty($item->classes) ? [] : (array) $item->classes;
        $classes[] = 'nav-item';

        if ($args->walker->has_children) {
            $classes[] = 'dropdown';
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $output .= $indent . '<li' . $class_names . '>';

        $atts          = [];
        $atts['href']  = !empty($item->url) ? $item->url : '';
        $atts['class'] = 'nav-link';

        if ($args->walker->has_children) {
            $atts['class']            .= ' dropdown-toggle';
            $atts['data-bs-toggle']    = 'dropdown';
        }

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value       = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output  = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

/* ==================== Security: Disable File Editing ==================== */
if ( ! defined('DISALLOW_FILE_EDIT') ) {
    define('DISALLOW_FILE_EDIT', true);
}

/* ==================== Performance: Remove Emoji Scripts ==================== */
function vaccination_centre_disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init', 'vaccination_centre_disable_emojis');

/* ==================== Reading Time Calculation ==================== */
function vaccination_centre_reading_time() {
    $content      = get_post_field('post_content', get_the_ID());
    $word_count   = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200);

    return $reading_time;
}

/* ==================== Post Views Counter ==================== */
function vaccination_centre_set_post_views($post_id) {
    $count_key = 'post_views_count';
    $count     = get_post_meta($post_id, $count_key, true);

    if ($count == '') {
        $count = 0;
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
    } else {
        $count++;
        update_post_meta($post_id, $count_key, $count);
    }
}

function vaccination_centre_get_post_views($post_id) {
    $count_key = 'post_views_count';
    $count     = get_post_meta($post_id, $count_key, true);

    if ($count == '') {
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
        return '0';
    }

    return number_format_i18n($count);
}

function vaccination_centre_track_post_views() {
    if (is_single()) {
        vaccination_centre_set_post_views(get_the_ID());
    }
}
add_action('wp_head', 'vaccination_centre_track_post_views');


/* ==================== CF7 Dynamic Vaccines Checkboxes ==================== */
/**
 * Usage in CF7 form: [dynamic_vaccines adult]
 * Shows all vaccines as beautiful clickable checkbox cards
 */
function vaccination_centre_cf7_dynamic_vaccines( $tag ) {

    $category_key = '';

    $name = sanitize_key( $tag->name );
    if ( in_array( $name, array( 'adult', 'child', 'flu', 'travel' ) ) ) {
        $category_key = $name;
    }

    if ( empty( $category_key ) ) {
        foreach ( array( 'adult', 'child', 'flu', 'travel' ) as $key ) {
            if ( strpos( $name, $key ) !== false ) {
                $category_key = $key;
                break;
            }
        }
    }

    if ( empty( $category_key ) && ! empty( $tag->options ) ) {
        foreach ( $tag->options as $option ) {
            $opt = sanitize_key( $option );
            if ( in_array( $opt, array( 'adult', 'child', 'flu', 'travel' ) ) ) {
                $category_key = $opt;
                break;
            }
        }
    }

    if ( empty( $category_key ) && ! empty( $tag->values ) ) {
        foreach ( $tag->values as $val ) {
            $v = sanitize_key( $val );
            if ( in_array( $v, array( 'adult', 'child', 'flu', 'travel' ) ) ) {
                $category_key = $v;
                break;
            }
        }
    }

    $slug_map = array(
        'child'  => 'child-vaccines',
        'adult'  => 'adult-vaccines',
        'flu'    => 'flu-vaccines',
        'travel' => 'travel-vaccines',
    );

    $tax_slug = isset( $slug_map[ $category_key ] ) ? $slug_map[ $category_key ] : '';
    $vaccines = array();

    if ( ! empty( $tax_slug ) ) {
        $term = get_term_by( 'slug', $tax_slug, 'vaccine_category' );
        if ( $term && ! is_wp_error( $term ) ) {
            $wq = new WP_Query( array(
                'post_type'      => 'vaccine',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'orderby'        => 'title',
                'order'          => 'ASC',
                'tax_query'      => array(
                    array(
                        'taxonomy'         => 'vaccine_category',
                        'field'            => 'term_id',
                        'terms'            => $term->term_id,
                        'include_children' => false,
                    ),
                ),
            ) );
            $vaccines = $wq->posts;
        }
    }

    // Fallback: manually filter
    if ( empty( $vaccines ) && ! empty( $tax_slug ) ) {
        $all = get_posts( array(
            'post_type'      => 'vaccine',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
        ) );
        foreach ( $all as $v ) {
            $term_slugs = wp_get_post_terms( $v->ID, 'vaccine_category', array( 'fields' => 'slugs' ) );
            if ( in_array( $tax_slug, $term_slugs ) ) {
                $vaccines[] = $v;
            }
        }
    }

    $field_name = esc_attr( $tag->name );
    $unique_id  = 'dv_' . $field_name . '_' . uniqid();

    $html = '<span class="wpcf7-form-control-wrap" data-name="' . $field_name . '">';

    if ( empty( $vaccines ) ) {
        $debug = 'key=' . $category_key . ' slug=' . $tax_slug . ' name=' . $tag->name;
        $html .= '<p style="color:#6b7280;font-size:14px;">No vaccines found (' . esc_html( $debug ) . ')</p>';
        $html .= '</span>';
        return $html;
    }

    // Inject CSS only once per page
    static $css_injected = false;
    if ( ! $css_injected ) {
        $css_injected = true;
        $html .= '
        <style>
        .dv-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 10px;
            margin-top: 6px;
        }
        .dv-item {
            position: relative;
        }
        .dv-item input[type="checkbox"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
            pointer-events: none;
        }
        .dv-label {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            cursor: pointer;
            background: #fff;
            transition: all 0.2s ease;
            user-select: none;
        }
        .dv-label:hover {
            border-color: #107fa0;
            background: #f0f9ff;
            box-shadow: 0 2px 10px rgba(16,127,160,0.12);
            transform: translateY(-1px);
        }
        .dv-item input[type="checkbox"]:checked + .dv-label {
            border-color: #107fa0;
            background: linear-gradient(135deg, #e0f4f9 0%, #e8f5e0 100%);
            box-shadow: 0 3px 16px rgba(16,127,160,0.18);
        }
        .dv-checkbox-box {
            width: 22px;
            height: 22px;
            min-width: 22px;
            border: 2px solid #d1d5db;
            border-radius: 6px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 1px;
            transition: all 0.2s ease;
            font-size: 13px;
            color: transparent;
            font-weight: 700;
        }
        .dv-item input[type="checkbox"]:checked + .dv-label .dv-checkbox-box {
            background: #107fa0;
            border-color: #107fa0;
            color: #fff;
        }
        .dv-info { flex: 1; }
        .dv-vaccine-name {
            font-weight: 600;
            color: #1f2937;
            font-size: 14px;
            line-height: 1.4;
            display: block;
            margin-bottom: 5px;
        }
        .dv-item input[type="checkbox"]:checked + .dv-label .dv-vaccine-name {
            color: #0a5f7a;
        }
        .dv-vaccine-meta {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }
        .dv-price {
            font-size: 13px;
            font-weight: 700;
            color: #107fa0;
        }
        .dv-age {
            font-size: 11px;
            color: #6b7280;
            background: #f3f4f6;
            padding: 2px 8px;
            border-radius: 20px;
        }
        .dv-hint {
            font-size: 12px;
            color: #9ca3af;
            margin-bottom: 10px;
            display: block;
        }
        </style>';
    }

    $html .= '<span class="dv-hint">&#10003; Aik ya zyada vaccines select karein</span>';
    $html .= '<div class="dv-grid" id="' . esc_attr( $unique_id ) . '">';

    foreach ( $vaccines as $vaccine ) {
        $price     = get_post_meta( $vaccine->ID, '_vaccine_price', true );
        $age_range = get_post_meta( $vaccine->ID, '_vaccine_age_range', true );
        $v_name    = esc_attr( $vaccine->post_title );
        $cb_id     = esc_attr( $unique_id . '_' . $vaccine->ID );

        $html .= '<div class="dv-item">';
        $html .= '<input type="checkbox" name="' . $field_name . '[]" id="' . $cb_id . '" value="' . $v_name . '">';
        $html .= '<label class="dv-label" for="' . $cb_id . '">';
        $html .= '<span class="dv-checkbox-box">&#10003;</span>';
        $html .= '<span class="dv-info">';
        $html .= '<span class="dv-vaccine-name">' . esc_html( $vaccine->post_title ) . '</span>';
        $html .= '<span class="dv-vaccine-meta">';
        if ( $price ) {
            $html .= '<span class="dv-price">PKR ' . number_format( (float) $price ) . '</span>';
        }
        if ( $age_range ) {
            $html .= '<span class="dv-age">' . esc_html( $age_range ) . '</span>';
        }
        $html .= '</span>';
        $html .= '</span>';
        $html .= '</label>';
        $html .= '</div>';
    }

    $html .= '</div>'; // end dv-grid

    // ── "Other Vaccine" card ──────────────────────────────────────────────
    $other_cb_id    = esc_attr( $unique_id . '_other' );
    $other_text_id  = esc_attr( $unique_id . '_other_text' );

    $html .= '
    <div class="dv-other-wrap" style="margin-top:10px;">

        <!-- Other checkbox card -->
        <div class="dv-item">
            <input type="checkbox" name="' . $field_name . '[]"
                   id="' . $other_cb_id . '"
                   value="Other"
                   class="dv-other-trigger"
                   data-target="' . $other_text_id . '">
            <label class="dv-label dv-other-label" for="' . $other_cb_id . '"
                   style="border-style:dashed;border-color:#9ca3af;background:#fafafa;">
                <span class="dv-checkbox-box" style="border-color:#9ca3af;">&#10003;</span>
                <span class="dv-info">
                    <span class="dv-vaccine-name" style="color:#6b7280;">
                        &#43; Other Vaccine
                    </span>
                    <span style="font-size:12px;color:#9ca3af;">
                        List mein nahi? Yahan specify karein
                    </span>
                </span>
            </label>
        </div>

        <!-- Hidden text input — visible when Other is checked -->
        <div id="' . $other_text_id . '" class="dv-other-input-wrap"
             style="display:none;margin-top:10px;animation:fadeInDown 0.3s ease;">
            <input type="text"
                   name="' . $field_name . '_other_text"
                   placeholder="e.g. Rabies, Yellow Fever, Meningitis..."
                   style="width:100%;padding:12px 15px;border:2px solid #107fa0;border-radius:8px;
                          font-size:14px;background:#f0f9ff;box-sizing:border-box;font-family:inherit;">
            <p style="font-size:12px;color:#6b7280;margin-top:5px;">
                &#9432; Aap jo vaccine chahte hain uska naam likhein — hum confirm karenge
            </p>
        </div>
    </div>
';
    // ── end "Other Vaccine" ───────────────────────────────────────────────

    $html .= '</span>';

    return $html;
}

// Register the custom CF7 form tag
add_action( 'wpcf7_init', function() {
    if ( function_exists( 'wpcf7_add_form_tag' ) ) {
        wpcf7_add_form_tag(
            array( 'dynamic_vaccines', 'dynamic_vaccines*' ),
            'vaccination_centre_cf7_dynamic_vaccines',
            array( 'name-attr' => true )
        );
    }
} );

/* ==================== CF7: Dynamic Home Service Charge ==================== */
/**
 * Pods settings se home_service_charges fetch karke CF7 radio option dynamically update karta hai
 * CF7 form mein: [radio location default:1 "Clinic Visit" "Home Service (+PKR [home_charge])"]
 * Nahi — hum CF7 form tag ko filter se modify karenge
 */

// Pods se home service charge get karne ka helper
function get_home_service_charge() {
    $charge = 500; // default fallback

    if ( function_exists( 'pods_setting' ) ) {
        $val = pods_setting( 'home_service_charges', 'site_contact_settings' );
        if ( ! empty( $val ) ) {
            $charge = intval( $val );
        }
    } elseif ( function_exists( 'pods' ) ) {
        // Alternative Pods API
        try {
            $settings = pods( 'site_contact_settings', 1 );
            if ( $settings && $settings->exists() ) {
                $val = $settings->field( 'home_service_charges' );
                if ( ! empty( $val ) ) {
                    $charge = intval( $val );
                }
            }
        } catch ( Exception $e ) {
            // fallback to default
        }
    }

    return $charge;
}

// CF7 form HTML render hone se pehle radio options mein dynamic charge inject karo
add_filter( 'wpcf7_form_elements', function( $html ) {
    if ( strpos( $html, 'Home Service' ) !== false ) {
        $charge      = get_home_service_charge();
        $replacement = 'Home Service (+PKR ' . number_format( $charge ) . ')';
        // Replace any variation like "Home Service (+PKR 500)" or "Home Service (+PKR 1,000)"
        $html = preg_replace(
            '/Home Service \(\+PKR[\s]?[\d,]+\)/',
            $replacement,
            $html
        );
    }
    return $html;
} );

/* ==================== CF7: Conditional Address Field (Home Service) ==================== */
add_action( 'wp_footer', function() { ?>
    <style>
    .home-address-wrap {
        display: none;
        margin-top: 14px;
        animation: fadeInDown 0.3s ease;
    }
    .home-address-wrap.visible { display: block; }
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-8px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .home-address-wrap label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }
    .home-address-wrap .address-box {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #107fa0;
        border-radius: 8px;
        font-size: 15px;
        font-family: inherit;
        resize: vertical;
        background: #f0f9ff;
        transition: all 0.3s;
        box-sizing: border-box;
    }
    .home-address-wrap .address-box:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(16,127,160,0.15);
    }
    .home-address-hint {
        font-size: 12px;
        color: #6b7280;
        margin-top: 5px;
    }
    .wpcf7 input[type="file"] {
        width: 100%;
        padding: 10px 14px;
        border: 2px dashed #d1d5db;
        border-radius: 8px;
        background: #fafafa;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.3s;
        box-sizing: border-box;
    }
    .wpcf7 input[type="file"]:hover {
        border-color: #107fa0;
        background: #f0f9ff;
    }
    </style>

    <script>
    function vaccinationInitHomeService() {

        // ── Home Service address logic ────────────────────────────────────
        document.querySelectorAll('input[type="radio"]').forEach(function(radio) {
            if (radio.dataset.hsInit) return;
            radio.dataset.hsInit = '1';

            var listItem = radio.closest('.wpcf7-list-item');
            if (!listItem) return;
            var labelText = listItem.textContent || '';
            if (labelText.indexOf('Home Service') === -1) return;

            var radioName = radio.name;
            var form = radio.closest('#form-container, .wpcf7-form, form');
            if (!form) return;

            var addrWrap = form.querySelector('.home-address-wrap');
            if (!addrWrap) return;

            form.querySelectorAll('input[name="' + radioName + '"]').forEach(function(r) {
                if (r.dataset.hsGroupInit) return;
                r.dataset.hsGroupInit = '1';
                r.addEventListener('change', function() {
                    var selectedItem = form.querySelector('input[name="' + radioName + '"]:checked');
                    if (!selectedItem) return;
                    var selectedLabel = selectedItem.closest('.wpcf7-list-item');
                    var isHome = selectedLabel && selectedLabel.textContent.indexOf('Home Service') !== -1;
                    toggleHomeAddress(addrWrap, isHome);
                });
            });
        });

        // ── Other Vaccine conditional text input ──────────────────────────
        document.querySelectorAll('.dv-other-trigger').forEach(function(cb) {
            if (cb.dataset.otherInit) return;
            cb.dataset.otherInit = '1';

            var targetId = cb.getAttribute('data-target');
            var wrap     = targetId ? document.getElementById(targetId) : null;
            if (!wrap) {
                // fallback: find sibling .dv-other-input-wrap
                wrap = cb.closest('.dv-item') &&
                       cb.closest('.dv-other-wrap') &&
                       cb.closest('.dv-other-wrap').querySelector('.dv-other-input-wrap');
            }
            if (!wrap) return;

            function toggleOther() {
                var inp = wrap.querySelector('input[type="text"]');
                if (cb.checked) {
                    wrap.style.display = 'block';
                    if (inp) inp.focus();
                } else {
                    wrap.style.display = 'none';
                    if (inp) inp.value = '';
                }
            }

            cb.addEventListener('change', toggleOther);
            toggleOther(); // run on init in case already checked
        });
    }

    function toggleHomeAddress(wrap, show) {
        var textarea = wrap.querySelector('textarea');
        if (show) {
            wrap.style.display = 'block';
            wrap.classList.add('visible');
            if (textarea) textarea.setAttribute('required', 'required');
        } else {
            wrap.style.display = 'none';
            wrap.classList.remove('visible');
            if (textarea) { textarea.removeAttribute('required'); textarea.value = ''; }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {

        // Watch #form-container for AJAX-injected CF7 forms
        var formContainer = document.getElementById('form-container');
        if (formContainer) {
            var observer = new MutationObserver(function() {
                setTimeout(vaccinationInitHomeService, 350);
            });
            observer.observe(formContainer, { childList: true, subtree: true });
        }

        // Also fire when Bootstrap modal fully opens
        document.addEventListener('shown.bs.modal', function() {
            setTimeout(vaccinationInitHomeService, 400);
        });

        vaccinationInitHomeService();
    });
    </script>
<?php } );
