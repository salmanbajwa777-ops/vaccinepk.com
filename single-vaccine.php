<?php
/**
 * Template for displaying single vaccine
 */

get_header();

// Get Pods data
$vaccine = pods('vaccine', get_the_ID());
$site_settings = pods('site_contact_settings');

// Vaccine fields
$disease_name = $vaccine->field('disease_name');
$vaccine_brand = $vaccine->field('vaccine_brand');
$age_requirement = $vaccine->field('age_requirement');
$availability = $vaccine->field('availability');
$price = $vaccine->field('price');
$vaccine_description = $vaccine->field('vaccine_description');

// Get vaccine categories
$categories = get_the_terms(get_the_ID(), 'vaccine_category');
$is_child_vaccine = false;
if ($categories && !is_wp_error($categories)) {
    foreach ($categories as $category) {
        if ($category->slug === 'child' || $category->slug === 'child-vaccines') {
            $is_child_vaccine = true;
            break;
        }
    }
}

// Site contact info
$phone = $site_settings->field('phone_number');
$whatsapp = $site_settings->field('whatsapp_number');
$email = $site_settings->field('email_address');

// Availability badge
$availability_badge = '';
switch ($availability) {
    case 'in_stock':
    case 'yes':
    case '1':
        $availability_badge = '<span class="badge" style="background: #7bb14f; color: white; font-size: 14px;"><i class="bi bi-check-circle-fill"></i> In Stock</span>';
        $is_available = true;
        break;
    case 'out_of_stock':
    case 'no':
    case '0':
        $availability_badge = '<span class="badge bg-danger" style="font-size: 14px;"><i class="bi bi-x-circle-fill"></i> Out of Stock</span>';
        $is_available = false;
        break;
    case 'coming_soon':
        $availability_badge = '<span class="badge bg-warning text-dark" style="font-size: 14px;"><i class="bi bi-clock-fill"></i> Coming Soon</span>';
        $is_available = false;
        break;
    default:
        $availability_badge = '<span class="badge bg-secondary" style="font-size: 14px;">Unknown</span>';
        $is_available = false;
}
?>

<style>
.vaccine-hero {
    background: linear-gradient(135deg, #da7215 0%, #d35324 100%);
    color: white;
    padding: 60px 0;
    margin-bottom: 50px;
}

.vaccine-detail-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    padding: 40px;
    margin-bottom: 30px;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 25px;
    margin: 30px 0;
}

.info-item {
    padding: 20px;
    background: #f8f9fa;
    border-radius: 12px;
    border-left: 4px solid #da7215;
}

.info-label {
    font-size: 13px;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
    font-weight: 600;
}

.info-value {
    font-size: 18px;
    font-weight: 700;
    color: #333;
}

.price-tag {
    font-size: 36px;
    font-weight: 800;
    background: linear-gradient(135deg, #da7215, #d35324);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin: 20px 0;
}

.contact-card {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 16px;
    padding: 35px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
}

.contact-buttons {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 25px;
}

.contact-btn {
    padding: 15px 30px;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s;
    font-size: 16px;
}

.contact-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
}

.btn-phone {
    background: #da7215;
    color: white;
}

.btn-whatsapp {
    background: #25D366;
    color: white;
}

.btn-email {
    background: #0066cc;
    color: white;
}

.btn-book {
    background: linear-gradient(135deg, #da7215, #d35324);
    color: white;
    padding: 18px 40px;
    font-size: 18px;
}

.feature-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #da7215, #d35324);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
    margin-bottom: 15px;
}

.breadcrumb {
    background: transparent;
    padding: 15px 0;
    margin-bottom: 0;
}

.breadcrumb-item a {
    color: rgba(255,255,255,0.8);
    text-decoration: none;
}

.breadcrumb-item.active {
    color: white;
}

.description-content {
    line-height: 1.8;
    color: #555;
}

.description-content h2,
.description-content h3 {
    color: #da7215;
    margin-top: 30px;
    margin-bottom: 15px;
}

.description-content ul {
    padding-left: 20px;
}

.description-content li {
    margin-bottom: 10px;
}
</style>

<!-- Hero Section -->
<section class="vaccine-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo home_url('/vaccines'); ?>">Vaccines</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
            </ol>
        </nav>
        
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">
                    <i class="bi bi-shield-fill-check me-3"></i><?php the_title(); ?>
                </h1>
                <p class="lead mb-4">
                    <?php echo $disease_name ? 'Protection against ' . esc_html($disease_name) : 'Professional vaccination service'; ?>
                </p>
                <?php echo $availability_badge; ?>
            </div>
            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                <?php if ($price): ?>
                    <div class="price-tag">Rs. <?php echo number_format($price); ?></div>
                <?php else: ?>
                    <div class="price-tag" style="font-size: 24px;">Contact for Price</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- Vaccine Details Card -->
                <div class="vaccine-detail-card">
                    <h2 class="fw-bold mb-4" style="color: #da7215;">
                        <i class="bi bi-info-circle-fill me-2"></i>Vaccine Information
                    </h2>
                    
                    <div class="info-grid">
                        <?php if ($disease_name): ?>
                        <div class="info-item">
                            <div class="info-label">
                                <i class="bi bi-virus me-1"></i> Protects Against
                            </div>
                            <div class="info-value"><?php echo esc_html($disease_name); ?></div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($vaccine_brand): ?>
                        <div class="info-item">
                            <div class="info-label">
                                <i class="bi bi-award me-1"></i> Brand
                            </div>
                            <div class="info-value"><?php echo esc_html($vaccine_brand); ?></div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if ($age_requirement && $is_child_vaccine): ?>
                        <div class="info-item">
                            <div class="info-label">
                                <i class="bi bi-calendar-check me-1"></i> Age Requirement
                            </div>
                            <div class="info-value"><?php echo esc_html($age_requirement); ?></div>
                        </div>
                        <?php endif; ?>
                        
                        <div class="info-item">
                            <div class="info-label">
                                <i class="bi bi-box-seam me-1"></i> Availability
                            </div>
                            <div class="info-value">
                                <?php 
                                switch ($availability) {
                                    case 'in_stock':
                                    case 'yes':
                                    case '1':
                                        echo '<span style="color: #7bb14f;">Available</span>';
                                        break;
                                    case 'out_of_stock':
                                    case 'no':
                                    case '0':
                                        echo '<span style="color: #dc3545;">Out of Stock</span>';
                                        break;
                                    case 'coming_soon':
                                        echo '<span style="color: #ffc107;">Coming Soon</span>';
                                        break;
                                    default:
                                        echo 'Unknown';
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <?php if ($vaccine_description): ?>
                    <div class="mt-5">
                        <h3 class="fw-bold mb-3" style="color: #da7215;">
                            <i class="bi bi-file-text-fill me-2"></i>Description
                        </h3>
                        <div class="description-content">
                            <?php echo wpautop($vaccine_description); ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (get_the_content()): ?>
                    <div class="mt-5">
                        <h3 class="fw-bold mb-3" style="color: #da7215;">
                            <i class="bi bi-info-circle-fill me-2"></i>Additional Information
                        </h3>
                        <div class="description-content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Why Choose Us -->
                <div class="vaccine-detail-card">
                    <h2 class="fw-bold mb-4" style="color: #da7215;">
                        <i class="bi bi-star-fill me-2"></i>Why Choose Our Service?
                    </h2>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="text-center">
                                <div class="feature-icon mx-auto">
                                    <i class="bi bi-house-heart-fill"></i>
                                </div>
                                <h5 class="fw-bold">Home Service</h5>
                                <p class="text-muted">Convenient vaccination at your doorstep</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="text-center">
                                <div class="feature-icon mx-auto">
                                    <i class="bi bi-shield-check"></i>
                                </div>
                                <h5 class="fw-bold">WHO Approved</h5>
                                <p class="text-muted">Certified and safe vaccines</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="text-center">
                                <div class="feature-icon mx-auto">
                                    <i class="bi bi-person-badge-fill"></i>
                                </div>
                                <h5 class="fw-bold">Expert Staff</h5>
                                <p class="text-muted">Qualified healthcare professionals</p>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="text-center">
                                <div class="feature-icon mx-auto">
                                    <i class="bi bi-clock-history"></i>
                                </div>
                                <h5 class="fw-bold">Follow-up Support</h5>
                                <p class="text-muted">Post-vaccination care and guidance</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Book Now Card -->
                <?php if ($is_available): ?>
                <div class="vaccine-detail-card text-center mb-4">
                    <h4 class="fw-bold mb-3">Ready to Get Vaccinated?</h4>
                    <p class="text-muted mb-4">Book your appointment now for home vaccination service</p>
                    <a href="<?php echo site_url('/booking'); ?>" class="btn btn-book w-100">
                        <i class="bi bi-calendar-check-fill me-2"></i>Go to Booking
                    </a>
                </div>
                <?php endif; ?>

                <!-- Contact Card -->
                <div class="contact-card">
                    <div class="feature-icon mx-auto" style="width: 80px; height: 80px; font-size: 32px;">
                        <i class="bi bi-headset"></i>
                    </div>
                    <h4 class="fw-bold mb-2">Need Help?</h4>
                    <p class="text-muted mb-4">Contact us for more information about this vaccine</p>
                    
                    <div class="contact-buttons">
                        <?php if ($phone): ?>
                        <a href="tel:<?php echo esc_attr($phone); ?>" class="contact-btn btn-phone">
                            <i class="bi bi-telephone-fill"></i> Call Now
                        </a>
                        <?php endif; ?>
                        
                        <?php if ($whatsapp): ?>
                        <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $whatsapp); ?>" target="_blank" class="contact-btn btn-whatsapp">
                            <i class="bi bi-whatsapp"></i> WhatsApp
                        </a>
                        <?php endif; ?>
                        
                        <?php if ($email): ?>
                        <a href="mailto:<?php echo esc_attr($email); ?>" class="contact-btn btn-email">
                            <i class="bi bi-envelope-fill"></i> Email
                        </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Back to Vaccines -->
                <div class="mt-4 text-center">
                    <a href="<?php echo home_url('/booking'); ?>" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left me-2"></i>Back to All Vaccines
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
