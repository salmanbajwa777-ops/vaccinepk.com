<?php
/**
 * Booking Forms AJAX Handler
 * This file loads Contact Form 7 forms based on category
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    // Load WordPress if accessed directly
    require_once('../../../wp-load.php');
}

// Get category from URL parameter
$category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : 'adult';

// Map categories to Contact Form 7 form IDs
$form_ids = array(
    'child'  => 'd12af79',  // Child Vaccine Booking
    'adult'  => 'b9ff7a4',  // Adult Vaccine Booking
    'flu'    => '4bddbb7',  // Flu Vaccine Booking
    'travel' => 'ed84fa1'   // Travel Vaccine Booking
);

// Check if category exists
if (isset($form_ids[$category])) {
    // Output the Contact Form 7 shortcode
    echo do_shortcode('[contact-form-7 id="' . $form_ids[$category] . '"]');
} else {
    // Invalid category
    echo '<div class="alert alert-danger">
        <h6 class="fw-bold mb-2"><i class="bi bi-exclamation-triangle-fill"></i> Invalid Category</h6>
        <p class="mb-0">The selected vaccination category is not valid. Please try again.</p>
    </div>';
}
?>
