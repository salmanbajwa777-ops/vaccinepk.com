<?php
/**
 * Single Post Template
 */
get_header();

while (have_posts()) : the_post();
?>

<!-- ================= POST HEADER ================= -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <section class="post-header" style="background: linear-gradient(160deg, var(--color-navy) 0%, #0e3446 55%, var(--color-navy) 100%); padding: 80px 0 60px; position: relative; overflow: hidden;">
        <div style="position: absolute; top: -50%; right: -10%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(201, 162, 75, 0.14) 0%, transparent 70%); border-radius: 50%;"></div>

        <div class="container" style="position: relative; z-index: 1;">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb" style="background: transparent;">
                            <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>" style="color: var(--color-sub-on-blue); text-decoration: none;"><i class="bi bi-house-fill"></i> Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" style="color: var(--color-sub-on-blue); text-decoration: none;">Blog</a></li>
                            <li class="breadcrumb-item active" aria-current="page" style="color: var(--color-ivory);"><?php the_title(); ?></li>
                        </ol>
                    </nav>

                    <!-- Categories -->
                    <div class="mb-3">
                        <?php
                        $categories = get_the_category();
                        if (!empty($categories)) {
                            foreach ($categories as $category) {
                                echo '<span class="badge me-2" style="background: var(--color-blue); color: white;">' . esc_html($category->name) . '</span>';
                            }
                        }
                        ?>
                    </div>

                    <!-- Post Title -->
                    <h1 class="display-5 fw-bold mb-4" style="color: var(--color-ivory);"><?php the_title(); ?></h1>

                    <!-- Meta Info -->
                    <div class="d-flex flex-wrap align-items-center gap-4" style="color: var(--color-sub-on-blue);">
                        <div class="d-flex align-items-center">
                            <?php echo get_avatar(get_the_author_meta('ID'), 48, '', '', array('class' => 'rounded-circle me-3')); ?>
                            <div>
                                <p class="mb-0 fw-bold" style="color: var(--color-ivory);"><?php the_author(); ?></p>
                                <p class="mb-0 small"><?php the_author_meta('description') ? wp_trim_words(get_the_author_meta('description'), 8) : 'Author'; ?></p>
                            </div>
                        </div>
                        <div>
                            <i class="bi bi-calendar3"></i> <?php echo get_the_date('F j, Y'); ?>
                        </div>
                        <div>
                            <i class="bi bi-clock"></i> <?php echo vaccination_centre_reading_time(); ?> min read
                        </div>
                        <div>
                            <i class="bi bi-eye"></i> <?php echo vaccination_centre_get_post_views(get_the_ID()); ?> views
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= FEATURED IMAGE ================= -->
    <?php if (has_post_thumbnail()) : ?>
    <section class="py-5" style="background: white;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <?php the_post_thumbnail('large', array('class' => 'img-fluid rounded-4 shadow-lg w-100', 'style' => 'height: 500px; object-fit: cover;')); ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ================= POST CONTENT ================= -->
    <section class="py-5" style="background: #f9fafb;">
        <div class="container">
            <div class="row justify-content-center">
                
                <!-- Main Content -->
                <div class="col-lg-8">
                    <div class="bg-white p-5 rounded-4 shadow-sm" style="line-height: 1.8; font-size: 18px; color: var(--color-ink);">
                        <?php the_content(); ?>
                        
                        <?php
                        wp_link_pages(array(
                            'before' => '<div class="page-links mt-4"><span class="page-links-title">Pages:</span>',
                            'after'  => '</div>',
                            'link_before' => '<span>',
                            'link_after'  => '</span>',
                        ));
                        ?>
                    </div>
                    
                    <!-- Tags -->
                    <?php
                    $tags = get_the_tags();
                    if ($tags) :
                    ?>
                    <div class="mt-4 p-4 bg-white rounded-4 shadow-sm">
                        <h6 class="fw-bold mb-3"><i class="bi bi-tags-fill" style="color: var(--color-blue);"></i> Tags:</h6>
                        <div class="d-flex flex-wrap gap-2">
                            <?php foreach ($tags as $tag) : ?>
                                <a href="<?php echo get_tag_link($tag->term_id); ?>" class="badge" style="background: #f3f4f6; color: #6b7280; text-decoration: none; padding: 8px 16px; border-radius: 50px; font-weight: 500;">
                                    #<?php echo $tag->name; ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Share Buttons -->
                    <div class="mt-4 p-4 bg-white rounded-4 shadow-sm">
                        <h6 class="fw-bold mb-3"><i class="bi bi-share-fill" style="color: var(--color-blue);"></i> Share this article:</h6>
                        <div class="d-flex gap-3">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="btn btn-outline-primary" style="border-radius: 50px;">
                                <i class="bi bi-facebook"></i> Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="btn btn-outline-info" style="border-radius: 50px;">
                                <i class="bi bi-twitter"></i> Twitter
                            </a>
                            <a href="https://wa.me/?text=<?php echo urlencode(get_the_title() . ' ' . get_permalink()); ?>" target="_blank" class="btn btn-outline-success" style="border-radius: 50px;">
                                <i class="bi bi-whatsapp"></i> WhatsApp
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink()); ?>&title=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="btn btn-outline-primary" style="border-radius: 50px;">
                                <i class="bi bi-linkedin"></i> LinkedIn
                            </a>
                        </div>
                    </div>
                    
                    <!-- Author Bio -->
                    <div class="mt-4 p-4 bg-white rounded-4 shadow-sm">
                        <div class="d-flex align-items-start">
                            <div class="me-4">
                                <?php echo get_avatar(get_the_author_meta('ID'), 100, '', '', array('class' => 'rounded-circle')); ?>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fw-bold mb-2">About <?php the_author(); ?></h5>
                                <p class="text-muted mb-3">
                                    <?php 
                                    $author_bio = get_the_author_meta('description');
                                    echo $author_bio ? $author_bio : 'Healthcare professional and writer passionate about child health and vaccination awareness.';
                                    ?>
                                </p>
                                <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="text-decoration-none fw-bold" style="color: var(--color-blue);">
                                    View all posts by <?php the_author(); ?> <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Comments -->
                    <?php
                    if (comments_open() || get_comments_number()) :
                    ?>
                    <div class="mt-4 p-4 bg-white rounded-4 shadow-sm">
                        <?php comments_template(); ?>
                    </div>
                    <?php endif; ?>
                    
                </div>
                
                <!-- Sidebar -->
                <div class="col-lg-4">
                    
                    <!-- Search Widget -->
                    <div class="bg-white p-4 rounded-4 shadow-sm mb-4">
                        <h6 class="fw-bold mb-3"><i class="bi bi-search"></i> Search</h6>
                        <form role="search" method="get" action="<?php echo home_url('/'); ?>">
                            <div class="input-group">
                                <input type="search" class="form-control" placeholder="Search articles..." name="s" value="<?php echo get_search_query(); ?>">
                                <button class="btn btn-primary" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Categories Widget -->
                    <div class="bg-white p-4 rounded-4 shadow-sm mb-4">
                        <h6 class="fw-bold mb-3"><i class="bi bi-folder-fill" style="color: var(--color-blue);"></i> Categories</h6>
                        <ul class="list-unstyled mb-0">
                            <?php
                            $categories = get_categories(array('hide_empty' => true));
                            foreach ($categories as $category) {
                                echo '<li class="mb-2">
                                    <a href="' . get_category_link($category->term_id) . '" class="text-decoration-none text-muted d-flex justify-content-between align-items-center">
                                        <span>' . $category->name . '</span>
                                        <span class="badge rounded-pill" style="background: #f3f4f6; color: #6b7280;">' . $category->count . '</span>
                                    </a>
                                </li>';
                            }
                            ?>
                        </ul>
                    </div>
                    
                    <!-- Recent Posts Widget -->
                    <div class="bg-white p-4 rounded-4 shadow-sm mb-4">
                        <h6 class="fw-bold mb-3"><i class="bi bi-clock-history" style="color: var(--color-blue);"></i> Recent Posts</h6>
                        <?php
                        $recent_posts = new WP_Query(array(
                            'posts_per_page' => 5,
                            'post__not_in' => array(get_the_ID())
                        ));
                        
                        if ($recent_posts->have_posts()) :
                            echo '<ul class="list-unstyled mb-0">';
                            while ($recent_posts->have_posts()) : $recent_posts->the_post();
                        ?>
                            <li class="mb-3 pb-3 border-bottom">
                                <a href="<?php the_permalink(); ?>" class="text-decoration-none">
                                    <h6 class="fw-bold mb-1 small" style="color: var(--color-ink-strong);"><?php the_title(); ?></h6>
                                    <p class="text-muted small mb-0">
                                        <i class="bi bi-calendar3"></i> <?php echo get_the_date('M j, Y'); ?>
                                    </p>
                                </a>
                            </li>
                        <?php
                            endwhile;
                            echo '</ul>';
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>
                    
                    <!-- Tags Widget -->
                    <div class="bg-white p-4 rounded-4 shadow-sm mb-4">
                        <h6 class="fw-bold mb-3"><i class="bi bi-tags-fill" style="color: var(--color-blue);"></i> Popular Tags</h6>
                        <div class="d-flex flex-wrap gap-2">
                            <?php
                            $tags = get_tags(array('orderby' => 'count', 'order' => 'DESC', 'number' => 15));
                            foreach ($tags as $tag) {
                                echo '<a href="' . get_tag_link($tag->term_id) . '" class="badge" style="background: #f3f4f6; color: #6b7280; text-decoration: none; padding: 8px 12px; border-radius: 50px; font-weight: 500;">' . $tag->name . '</a>';
                            }
                            ?>
                        </div>
                    </div>
                    
                    <!-- CTA Widget -->
                    <div class="rounded-4 shadow-sm overflow-hidden" style="background: linear-gradient(135deg, var(--color-blue), var(--color-navy));">
                        <div class="p-4 text-white text-center">
                            <i class="bi bi-heart-pulse-fill" style="font-size: 48px; opacity: 0.9;"></i>
                            <h6 class="fw-bold mt-3 mb-2">Need Vaccination?</h6>
                            <p class="small mb-3">Book your home vaccination service today</p>
                            <a href="<?php echo home_url('/contact'); ?>" class="btn btn-light btn-sm w-100">
                                Book Now <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </section>

    <!-- ================= RELATED POSTS ================= -->
    <?php
    $categories = get_the_category();
    if ($categories) {
        $category_ids = array();
        foreach ($categories as $category) {
            $category_ids[] = $category->term_id;
        }
        
        $related_args = array(
            'category__in' => $category_ids,
            'post__not_in' => array(get_the_ID()),
            'posts_per_page' => 3,
            'orderby' => 'rand'
        );
        
        $related_posts = new WP_Query($related_args);
        
        if ($related_posts->have_posts()) :
    ?>
    <section class="py-5" style="background: white;">
        <div class="container">
            <h3 class="fw-bold mb-4 text-center" style="color: var(--color-navy);">Related Articles</h3>
            <div class="row g-4">
                <?php while ($related_posts->have_posts()) : $related_posts->the_post(); ?>
                <div class="col-lg-4 col-md-6">
                    <div class="bg-white rounded-4 shadow-sm overflow-hidden h-100">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium', array('class' => 'w-100', 'style' => 'height: 200px; object-fit: cover;')); ?>
                            </a>
                        <?php endif; ?>
                        <div class="p-4">
                            <h6 class="fw-bold mb-2">
                                <a href="<?php the_permalink(); ?>" style="color: var(--color-ink-strong); text-decoration: none;">
                                    <?php the_title(); ?>
                                </a>
                            </h6>
                            <p class="text-muted small mb-3"><?php echo wp_trim_words(get_the_excerpt(), 12); ?></p>
                            <a href="<?php the_permalink(); ?>" class="text-decoration-none small fw-bold" style="color: var(--color-blue);">
                                Read More <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
    <?php
        endif;
        wp_reset_postdata();
    }
    ?>

</article>

<?php
endwhile;
get_footer();
?>