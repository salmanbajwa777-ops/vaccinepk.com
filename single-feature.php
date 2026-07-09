<?php
/**
 * Single Feature Template
 * Template for displaying individual Feature posts
 */
get_header();

// Initialize Pods
$pod = pods('feature', get_the_ID());
?>

<style>
/* Single Feature Page Styles */
.single-feature-header {
    position: relative;
    padding: 100px 0 60px;
    background: #0a2a38;
    color: white;
    overflow: hidden;
}

.single-feature-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,165.3C1248,171,1344,149,1392,138.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
    background-size: cover;
    opacity: 0.3;
}

.feature-header-content {
    position: relative;
    z-index: 2;
}

.feature-icon-large {
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

.feature-content-wrapper {
    background: white;
    padding: 60px 0;
}

.feature-content {
    max-width: 900px;
    margin: 0 auto;
    font-size: 18px;
    line-height: 1.8;
    color: #16232b;
}

.feature-content h1,
.feature-content h2,
.feature-content h3,
.feature-content h4,
.feature-content h5,
.feature-content h6 {
    color: #0b5c87;
    margin-top: 40px;
    margin-bottom: 20px;
    font-weight: 700;
}

.feature-content h2 {
    font-size: 32px;
    border-bottom: 3px solid #0b5c87;
    padding-bottom: 10px;
    margin-bottom: 25px;
}

.feature-content h3 {
    font-size: 26px;
    color: #0b5c87;
}

.feature-content p {
    margin-bottom: 20px;
}

.feature-content ul,
.feature-content ol {
    margin-bottom: 25px;
    padding-left: 30px;
}

.feature-content li {
    margin-bottom: 12px;
    line-height: 1.7;
}

.feature-content ul li::marker {
    color: #0b5c87;
    font-size: 1.2em;
}

.feature-content ol li::marker {
    color: #0b5c87;
    font-weight: bold;
}

.feature-content img {
    max-width: 100%;
    height: auto;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    margin: 30px 0;
}

.feature-content blockquote {
    background: #f6f3ec;
    border-left: 5px solid #0b5c87;
    padding: 20px 30px;
    margin: 30px 0;
    font-style: italic;
    color: #4a575e;
    border-radius: 0 10px 10px 0;
}

.feature-content a {
    color: #0b5c87;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.feature-content a:hover {
    color: #0b5c87;
    text-decoration: underline;
}

.feature-content table {
    width: 100%;
    margin: 30px 0;
    border-collapse: collapse;
}

.feature-content table th,
.feature-content table td {
    padding: 12px 15px;
    border: 1px solid #e7e0d3;
    text-align: left;
}

.feature-content table th {
    background: #0b5c87;
    color: white;
    font-weight: 600;
}

.feature-content table tr:nth-child(even) {
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

.related-features {
    background: #f6f3ec;
    padding: 60px 0;
}

.related-features h3 {
    text-align: center;
    color: #0b5c87;
    margin-bottom: 40px;
    font-weight: 700;
}

/* Responsive */
@media (max-width: 768px) {
    .single-feature-header {
        padding: 60px 0 40px;
    }
    
    .feature-icon-large {
        width: 80px;
        height: 80px;
        font-size: 36px;
    }
    
    .feature-content {
        font-size: 16px;
    }
    
    .feature-content h2 {
        font-size: 26px;
    }
}
</style>

<!-- Feature Header Section -->
<section class="single-feature-header">
    <div class="container">
        <div class="feature-header-content text-center">
            <?php if ($pod->field('feature_icon')) : ?>
                <div class="feature-icon-large">
                    <i class="<?php echo esc_attr($pod->field('feature_icon')); ?>"></i>
                </div>
            <?php endif; ?>
            
            <h1 class="display-4 fw-bold mb-3">
                <?php echo esc_html(get_the_title()); ?>
            </h1>
            
            <?php if ($pod->field('feature_description')) : ?>
                <p class="lead" style="font-size: 20px; max-width: 700px; margin: 0 auto; opacity: 0.95;">
                    <?php echo esc_html($pod->field('feature_description')); ?>
                </p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Feature Content Section -->
<section class="feature-content-wrapper">
    <div class="container">
        <div class="feature-content">
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
            
            <div class="text-center mt-5">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="back-to-home">
                    <i class="bi bi-arrow-left"></i>
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Related Features Section -->
<section class="related-features">
    <div class="container">
        <h3>Other Features</h3>
        <div class="row g-4">
            <?php
            // Get other features (exclude current)
            $related_features = pods('feature', array(
                'limit' => 3,
                'where' => 't.ID != ' . get_the_ID(),
                'orderby' => 'rand()'
            ));
            
            if ($related_features->total() > 0) :
                while ($related_features->fetch()) :
                    $icon = $related_features->field('feature_icon');
                    $title = $related_features->field('post_title');
                    $description = $related_features->field('feature_description');
                    $permalink = $related_features->field('permalink');
                    ?>
                    <div class="col-md-4">
                        <a href="<?php echo esc_url($permalink); ?>" class="text-decoration-none">
                            <div class="feature-box h-100">
                                <div class="feature-icon">
                                    <i class="<?php echo esc_attr($icon ?: 'bi bi-star-fill'); ?>"></i>
                                </div>
                                <h5 class="fw-bold"><?php echo esc_html($title); ?></h5>
                                <p class="text-muted mb-0"><?php echo esc_html($description); ?></p>
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
