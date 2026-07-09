<?php
/**
 * Single Service Template
 * Template for displaying individual Service posts
 */
get_header();

// Initialize Pods
$pod = pods('service', get_the_ID());
?>

<style>
/* Single Service Page Styles */
.single-service-header {
    position: relative;
    padding: 100px 0 60px;
    background: #0a2a38;
    color: white;
    overflow: hidden;
}

.single-service-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" d="M0,224L48,197.3C96,171,192,117,288,112C384,107,480,149,576,154.7C672,160,768,128,864,128C960,128,1056,160,1152,165.3C1248,171,1344,149,1392,138.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
    background-size: cover;
    opacity: 0.3;
}

.service-header-content {
    position: relative;
    z-index: 2;
}

.service-icon-large {
    width: 100px;
    height: 100px;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 48px;
    margin-bottom: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.service-content-wrapper {
    background: white;
    padding: 60px 0;
}

.service-content {
    max-width: 900px;
    margin: 0 auto;
    font-size: 18px;
    line-height: 1.8;
    color: #16232b;
}

.service-content h1,
.service-content h2,
.service-content h3,
.service-content h4,
.service-content h5,
.service-content h6 {
    color: #0b5c87;
    margin-top: 40px;
    margin-bottom: 20px;
    font-weight: 700;
}

.service-content h2 {
    font-size: 32px;
    border-bottom: 3px solid #0b5c87;
    padding-bottom: 10px;
    margin-bottom: 25px;
}

.service-content h3 {
    font-size: 26px;
    color: #0b5c87;
}

.service-content p {
    margin-bottom: 20px;
}

.service-content ul,
.service-content ol {
    margin-bottom: 25px;
    padding-left: 30px;
}

.service-content li {
    margin-bottom: 12px;
    line-height: 1.7;
}

.service-content ul li::marker {
    color: #0b5c87;
    font-size: 1.2em;
}

.service-content ol li::marker {
    color: #0b5c87;
    font-weight: bold;
}

.service-content img {
    max-width: 100%;
    height: auto;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    margin: 30px 0;
}

.service-content blockquote {
    background: #f6f3ec;
    border-left: 5px solid #0b5c87;
    padding: 20px 30px;
    margin: 30px 0;
    font-style: italic;
    color: #4a575e;
    border-radius: 0 10px 10px 0;
}

.service-content a {
    color: #0b5c87;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.service-content a:hover {
    color: #0b5c87;
    text-decoration: underline;
}

.service-content table {
    width: 100%;
    margin: 30px 0;
    border-collapse: collapse;
}

.service-content table th,
.service-content table td {
    padding: 12px 15px;
    border: 1px solid #e7e0d3;
    text-align: left;
}

.service-content table th {
    background: #0b5c87;
    color: white;
    font-weight: 600;
}

.service-content table tr:nth-child(even) {
    background: #f6f3ec;
}

.back-to-home {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: white;
    color: #0b5c87;
    padding: 12px 30px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    margin-top: 30px;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.back-to-home:hover {
    background: #0b5c87;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.cta-box {
    background: #0a2a38;
    color: white;
    padding: 40px;
    border-radius: 20px;
    text-align: center;
    margin-top: 50px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
}

.cta-box h3 {
    color: white !important;
    margin: 0 0 15px 0;
}

.cta-box .btn {
    background: white;
    color: #0b5c87;
    padding: 12px 35px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    display: inline-block;
    margin-top: 15px;
    transition: all 0.3s ease;
}

.cta-box .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

.related-services {
    background: #f6f3ec;
    padding: 60px 0;
}

.related-services h3 {
    text-align: center;
    color: #0b5c87;
    margin-bottom: 40px;
    font-weight: 700;
}

/* Responsive */
@media (max-width: 768px) {
    .single-service-header {
        padding: 60px 0 40px;
    }
    
    .service-icon-large {
        width: 80px;
        height: 80px;
        font-size: 36px;
    }
    
    .service-content {
        font-size: 16px;
    }
    
    .service-content h2 {
        font-size: 26px;
    }
}
</style>

<!-- Service Header Section -->
<section class="single-service-header">
    <div class="container">
        <div class="service-header-content text-center">
            <?php if ($pod->field('service_icon')) : ?>
                <div class="service-icon-large">
                    <i class="<?php echo esc_attr($pod->field('service_icon')); ?>"></i>
                </div>
            <?php endif; ?>
            
            <h1 class="display-4 fw-bold mb-3">
                <?php echo esc_html(get_the_title()); ?>
            </h1>
            
            <?php if ($pod->field('service_description')) : ?>
                <p class="lead" style="font-size: 20px; max-width: 700px; margin: 0 auto; opacity: 0.95;">
                    <?php echo esc_html($pod->field('service_description')); ?>
                </p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Service Content Section -->
<section class="service-content-wrapper">
    <div class="container">
        <div class="service-content">
            <?php
            // Display featured image if available
            if (has_post_thumbnail()) {
                echo '<div class="featured-image mb-4">';
                the_post_thumbnail('large', array('class' => 'img-fluid'));
                echo '</div>';
            }
            
            // Display the main content
            if (have_posts()) :
                while (have_posts()) : the_post();
                    the_content();
                endwhile;
            endif;
            ?>
            
            <!-- Call to Action Box -->
            <div class="cta-box">
                <h3>Ready to Get This Service?</h3>
                <p class="mb-0">Book your appointment now and experience professional vaccination care at home.</p>
                <a href="<?php echo esc_url(home_url('/#appointment')); ?>" class="btn">
                    <i class="bi bi-calendar-check"></i> Book Appointment
                </a>
            </div>
            
            <div class="text-center mt-5">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="back-to-home">
                    <i class="bi bi-arrow-left"></i>
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Related Services Section -->
<section class="related-services">
    <div class="container">
        <h3>Other Services</h3>
        <div class="row g-4">
            <?php
            // Get other services (exclude current)
            $related_services = pods('service', array(
                'limit' => 3,
                'where' => 't.ID != ' . get_the_ID(),
                'orderby' => 'rand()'
            ));
            
            if ($related_services->total() > 0) :
                while ($related_services->fetch()) :
                    $icon = $related_services->field('service_icon');
                    $title = $related_services->field('post_title');
                    $description = $related_services->field('service_description');
                    $permalink = $related_services->field('permalink');
                    ?>
                    <div class="col-lg-4 col-md-6">
                        <a href="<?php echo esc_url($permalink); ?>" class="text-decoration-none">
                            <div class="service-card h-100">
                                <div class="icon">
                                    <i class="<?php echo esc_attr($icon ?: 'bi bi-heart-fill'); ?>"></i>
                                </div>
                                <h4><?php echo esc_html($title); ?></h4>
                                <p><?php echo esc_html($description); ?></p>
                            </div>
                        </a>
                    </div>
                    <?php
                endwhile;
            endif;
            ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
