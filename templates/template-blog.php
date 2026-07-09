<?php
add_action('wp_footer', function () {
    ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const errorPage = document.getElementById("error-page");
            if (errorPage) {
                errorPage.removeAttribute("id");
            }
        });
    </script>
    <?php
});
?>


<?php
/**
 * Template Name: Blog Page
 * Description: Blog listing page template for BabyMedics
 */
get_header();
?>

<!-- ================= PAGE HEADER ================= -->
<section class="page-header" style="background: linear-gradient(160deg, var(--color-navy) 0%, #0e3446 55%, var(--color-navy) 100%); padding: 80px 0 60px; position: relative; overflow: hidden;">
    <div style="position: absolute; top: -50%; right: -10%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(201, 162, 75, 0.14) 0%, transparent 70%); border-radius: 50%;"></div>
    <div style="position: absolute; bottom: -30%; left: -5%; width: 400px; height: 400px; background: radial-gradient(circle, rgba(107, 182, 63, 0.12) 0%, transparent 70%); border-radius: 50%;"></div>

    <div class="container" style="position: relative; z-index: 1;">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb justify-content-center" style="background: transparent;">
                        <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>" style="color: var(--color-sub-on-blue); text-decoration: none;"><i class="bi bi-house-fill"></i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: var(--color-ivory);">Blog</li>
                    </ol>
                </nav>
                <h1 class="display-4 fw-bold mb-3" style="color: var(--color-ivory);">Health & Vaccination Blog</h1>
                <p class="lead" style="color: var(--color-sub-on-blue);">Expert insights, tips, and updates on child health and vaccination</p>
            </div>
        </div>
    </div>
</section>

<!-- ================= FEATURED POST ================= -->
<?php
// Get the latest featured post
$featured_args = array(
    'posts_per_page' => 1,
    'meta_query' => array(
        array(
            'key' => 'featured_post',
            'value' => '1',
            'compare' => '='
        )
    )
);
$featured_query = new WP_Query($featured_args);

if ($featured_query->have_posts()) : 
    while ($featured_query->have_posts()) : $featured_query->the_post();
?>
<section class="py-5" style="background: white;">
    <div class="container">
        <div class="mb-4">
            <span class="badge" style="background: var(--color-gold); color: var(--color-navy); padding: 8px 16px; border-radius: 50px;">
                <i class="bi bi-star-fill"></i> Featured Post
            </span>
        </div>
        <div class="row g-4 align-items-center">
            <div class="col-lg-6">
                <?php if (has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('large', array('class' => 'img-fluid rounded-4 shadow-lg', 'style' => 'width: 100%; height: 400px; object-fit: cover;')); ?>
                    </a>
                <?php else : ?>
                    <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=800&q=80" alt="Featured Post" class="img-fluid rounded-4 shadow-lg" style="width: 100%; height: 400px; object-fit: cover;">
                <?php endif; ?>
            </div>
            <div class="col-lg-6">
                <div class="mb-3">
                    <?php
                    $categories = get_the_category();
                    if (!empty($categories)) {
                        echo '<span class="badge me-2" style="background: var(--color-blue); color: white;">' . esc_html($categories[0]->name) . '</span>';
                    }
                    ?>
                    <span class="text-muted small">
                        <i class="bi bi-calendar3"></i> <?php echo get_the_date('F j, Y'); ?>
                    </span>
                </div>
                <h2 class="fw-bold mb-3">
                    <a href="<?php the_permalink(); ?>" style="color: var(--color-ink-strong); text-decoration: none;">
                        <?php the_title(); ?>
                    </a>
                </h2>
                <p class="text-muted mb-4" style="line-height: 1.8;">
                    <?php echo wp_trim_words(get_the_excerpt(), 30); ?>
                </p>
                <div class="d-flex align-items-center mb-4">
                    <?php echo get_avatar(get_the_author_meta('ID'), 40, '', '', array('class' => 'rounded-circle me-3')); ?>
                    <div>
                        <p class="mb-0 fw-bold small"><?php the_author(); ?></p>
                        <p class="mb-0 text-muted small"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago'; ?></p>
                    </div>
                </div>
                <a href="<?php the_permalink(); ?>" class="btn btn-primary">
                    Read Full Article <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>
<?php 
    endwhile;
    wp_reset_postdata();
endif;
?>

<!-- ================= BLOG POSTS GRID ================= -->
<section class="py-5" style="background: #f9fafb;">
    <div class="container">
        
        <!-- Categories Filter -->
        <div class="mb-5">
            <div class="d-flex flex-wrap gap-2 justify-content-center">
                <a href="<?php echo get_permalink(); ?>" class="btn btn-sm <?php echo !isset($_GET['category']) ? 'btn-primary' : 'btn-outline-secondary'; ?>" style="border-radius: 50px;">
                    All Posts
                </a>
                <?php
                $categories = get_categories(array('hide_empty' => true));
                foreach ($categories as $category) {
                    $active = (isset($_GET['category']) && $_GET['category'] == $category->slug) ? 'btn-primary' : 'btn-outline-secondary';
                    echo '<a href="' . add_query_arg('category', $category->slug) . '" class="btn btn-sm ' . $active . '" style="border-radius: 50px;">' . $category->name . '</a>';
                }
                ?>
            </div>
        </div>

        <div class="row g-4">
            <?php
            // Pagination
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            
            // Build query args
            $blog_args = array(
                'post_type' => 'post',
                'posts_per_page' => 9,
                'paged' => $paged,
                'post_status' => 'publish',
            );
            
            // Add category filter if set
            if (isset($_GET['category'])) {
                $blog_args['category_name'] = sanitize_text_field($_GET['category']);
            }
            
            // Exclude featured post
            if (isset($featured_query) && $featured_query->have_posts()) {
                $blog_args['post__not_in'] = wp_list_pluck($featured_query->posts, 'ID');
            }
            
            $blog_query = new WP_Query($blog_args);
            
            if ($blog_query->have_posts()) :
                while ($blog_query->have_posts()) : $blog_query->the_post();
            ?>
            
            <div class="col-lg-4 col-md-6">
                <article class="blog-card bg-white rounded-4 shadow-sm overflow-hidden h-100" style="transition: all 0.3s; border: 1px solid rgba(0,0,0,0.05);">
                    <!-- Post Thumbnail -->
                    <div class="position-relative" style="height: 250px; overflow: hidden;">
                        <a href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium_large', array('class' => 'w-100 h-100', 'style' => 'object-fit: cover; transition: transform 0.3s;')); ?>
                            <?php else : ?>
                                <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=800&q=80" alt="<?php the_title(); ?>" class="w-100 h-100" style="object-fit: cover; transition: transform 0.3s;">
                            <?php endif; ?>
                        </a>
                        
                        <!-- Category Badge -->
                        <div class="position-absolute top-0 start-0 m-3">
                            <?php
                            $categories = get_the_category();
                            if (!empty($categories)) {
                                echo '<span class="badge" style="background: var(--color-blue); color: white;">' . esc_html($categories[0]->name) . '</span>';
                            }
                            ?>
                        </div>
                    </div>
                    
                    <!-- Post Content -->
                    <div class="p-4">
                        <!-- Meta Info -->
                        <div class="mb-3 d-flex align-items-center text-muted small">
                            <span class="me-3">
                                <i class="bi bi-calendar3"></i> <?php echo get_the_date('M j, Y'); ?>
                            </span>
                            <span>
                                <i class="bi bi-clock"></i> <?php echo vaccination_centre_reading_time(); ?> min read
                            </span>
                        </div>
                        
                        <!-- Title -->
                        <h5 class="fw-bold mb-3">
                            <a href="<?php the_permalink(); ?>" style="color: var(--color-ink-strong); text-decoration: none;">
                                <?php the_title(); ?>
                            </a>
                        </h5>
                        
                        <!-- Excerpt -->
                        <p class="text-muted small mb-3" style="line-height: 1.6;">
                            <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                        </p>
                        
                        <!-- Author & Read More -->
                        <div class="d-flex align-items-center justify-content-between pt-3" style="border-top: 1px solid #f3f4f6;">
                            <div class="d-flex align-items-center">
                                <?php echo get_avatar(get_the_author_meta('ID'), 32, '', '', array('class' => 'rounded-circle me-2')); ?>
                                <span class="small text-muted"><?php the_author(); ?></span>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="text-decoration-none small fw-bold" style="color: var(--color-blue);">
                                Read More <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </article>
            </div>
            
            <?php 
                endwhile;
            else :
            ?>
            
            <!-- No Posts Found -->
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 64px; color: #d1d5db;"></i>
                    <h3 class="mt-4 mb-2">No Posts Found</h3>
                    <p class="text-muted">Try adjusting your filters or check back later for new content.</p>
                </div>
            </div>
            
            <?php endif; ?>
        </div>
        
        <!-- Pagination -->
        <?php if ($blog_query->max_num_pages > 1) : ?>
        <div class="mt-5">
            <nav aria-label="Blog pagination">
                <ul class="pagination justify-content-center">
                    <?php
                    $big = 999999999;
                    echo paginate_links(array(
                        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                        'format' => '?paged=%#%',
                        'current' => max(1, $paged),
                        'total' => $blog_query->max_num_pages,
                        'prev_text' => '<i class="bi bi-chevron-left"></i>',
                        'next_text' => '<i class="bi bi-chevron-right"></i>',
                        'type' => 'list',
                        'before_page_number' => '<span class="pagination-number">',
                        'after_page_number' => '</span>'
                    ));
                    ?>
                </ul>
            </nav>
        </div>
        <?php endif; ?>
        
        <?php wp_reset_postdata(); ?>
        
    </div>
</section>

<!-- ================= NEWSLETTER SECTION ================= -->
<section class="py-5" style="background: var(--color-blue-tint);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="mb-4">
                    <i class="bi bi-envelope-heart-fill" style="font-size: 64px; color: var(--color-blue);"></i>
                </div>
                <h2 class="fw-bold mb-3" style="color: var(--color-navy);">Stay Updated with Health Tips</h2>
                <p class="text-muted mb-4">Subscribe to our newsletter for the latest vaccination updates, health tips, and expert advice.</p>
                
                <form class="row g-3 justify-content-center" action="#" method="post">
                    <div class="col-md-6">
                        <input type="email" class="form-control form-control-lg" placeholder="Enter your email address" required style="border-radius: 50px; border: 2px solid #d1d5db;">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary btn-lg px-4" style="border-radius: 50px;">
                            Subscribe <i class="bi bi-send-fill"></i>
                        </button>
                    </div>
                </form>
                
                <p class="small text-muted mt-3 mb-0">
                    <i class="bi bi-shield-check"></i> We respect your privacy. Unsubscribe at any time.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ================= CTA SECTION ================= -->
<section class="py-5" style="background: linear-gradient(135deg, var(--color-blue), var(--color-navy));">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 text-white mb-4 mb-lg-0">
                <h2 class="fw-bold mb-3">Need Vaccination Services?</h2>
                <p class="mb-0" style="font-size: 18px;">Book your home vaccination appointment and protect your family's health today.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="<?php echo home_url('/contact'); ?>" class="btn px-5" style="background: var(--color-gold); color: var(--color-navy); border-radius: 999px; font-weight: 600; padding: 12px 28px; text-decoration: none; display: inline-block;">
                    Book Now <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Blog Card Hover Effect -->
<style>
.blog-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15) !important;
}

.blog-card:hover img {
    transform: scale(1.1);
}

.pagination .page-numbers {
    display: inline-block;
    padding: 10px 16px;
    margin: 0 4px;
    border-radius: 8px;
    color: var(--color-ink);
    text-decoration: none;
    border: 1px solid var(--color-sand);
    background: white;
    transition: all 0.3s;
}

.pagination .page-numbers:hover,
.pagination .page-numbers.current {
    background: var(--color-blue);
    color: white;
    border-color: var(--color-blue);
}

.pagination .prev,
.pagination .next {
    font-weight: bold;
}
</style>

<?php get_footer(); ?>