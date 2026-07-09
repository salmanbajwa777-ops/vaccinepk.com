<?php
/**
 * Template Name: Knowledge Centre Page
 * The SEO-facing front door to VaccinePk's evergreen articles (same `post`
 * content as the Blog template), framed around evidence-based authority
 * rather than a chronological blog feed.
 */
get_header();

$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

$articles_query = new WP_Query( [
    'post_type'      => 'post',
    'posts_per_page' => 9,
    'paged'          => $paged,
    'post_status'    => 'publish',
] );
?>

<style>
.knowledge-hero {
    background: linear-gradient(135deg, #f6f3ec 0%, #efe9db 100%);
    padding: 80px 0 60px;
}
.kc-card {
    background: white; border: 1px solid var(--color-sand); border-radius: 18px; overflow: hidden;
    height: 100%; transition: var(--transition);
}
.kc-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); }
.kc-card-image { height: 170px; background: var(--bg-light); overflow: hidden; }
.kc-card-image img { width: 100%; height: 100%; object-fit: cover; }
.kc-card-body { padding: 22px; }
.kc-card-body h3 { font-size: 1.1rem; font-weight: 700; margin-bottom: 10px; }
.kc-card-meta { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; font-size: 0.8rem; color: var(--text-light); margin-bottom: 10px; }
.kc-reviewed-badge {
    display: inline-flex; align-items: center; gap: 5px; font-size: 0.72rem; font-weight: 700;
    color: var(--color-blue); background: var(--color-blue-tint); padding: 4px 10px; border-radius: 50px;
}
</style>

<section class="knowledge-hero">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb" style="background: transparent;">
                <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>" style="color:#0b5c87;text-decoration:none;"><i class="bi bi-house-fill"></i> Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Knowledge Centre</li>
            </ol>
        </nav>
        <h1 class="display-4 fw-bold mb-3" style="color:#0b5c87;">Vaccine Knowledge Centre</h1>
        <p class="lead" style="color:#4a575e;max-width:680px;">Evidence-based, doctor-reviewed guidance on vaccines, diseases, and immunization — Pakistan's largest vaccine knowledge resource.</p>
    </div>
</section>

<section class="py-5" style="background: white;">
    <div class="container">
        <div class="row g-4">
            <?php if ( $articles_query->have_posts() ) : ?>
                <?php while ( $articles_query->have_posts() ) : $articles_query->the_post(); ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="kc-card">
                            <a href="<?php the_permalink(); ?>" class="kc-card-image d-block">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( 'medium_large' ); ?>
                                <?php else : ?>
                                    <div class="d-flex align-items-center justify-content-center h-100">
                                        <i class="bi bi-file-earmark-medical-fill" style="font-size: 2.2rem; color: var(--accent-blue);"></i>
                                    </div>
                                <?php endif; ?>
                            </a>
                            <div class="kc-card-body">
                                <div class="kc-card-meta">
                                    <span><i class="bi bi-clock"></i> <?php echo vaccination_centre_reading_time(); ?> min read</span>
                                    <span><i class="bi bi-calendar3"></i> Updated <?php echo get_the_modified_date( 'M j, Y' ); ?></span>
                                </div>
                                <span class="kc-reviewed-badge mb-2 d-inline-flex"><i class="bi bi-patch-check-fill"></i> Doctor Reviewed</span>
                                <h3><a href="<?php the_permalink(); ?>" style="color:#16232b;text-decoration:none;"><?php the_title(); ?></a></h3>
                                <p class="text-muted small mb-0"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 16 ) ); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            <?php else : ?>
                <div class="col-12 text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 64px; color: var(--color-sand);"></i>
                    <p class="text-muted mt-3 mb-0">Articles are being added. Please check back soon.</p>
                </div>
            <?php endif; ?>
        </div>

        <?php if ( $articles_query->max_num_pages > 1 ) : ?>
        <div class="mt-5">
            <nav aria-label="Knowledge Centre pagination">
                <ul class="pagination justify-content-center">
                    <?php
                    $big = 999999999;
                    echo paginate_links( [
                        'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                        'format'    => '?paged=%#%',
                        'current'   => max( 1, $paged ),
                        'total'     => $articles_query->max_num_pages,
                        'prev_text' => '<i class="bi bi-chevron-left"></i>',
                        'next_text' => '<i class="bi bi-chevron-right"></i>',
                        'type'      => 'list',
                    ] );
                    ?>
                </ul>
            </nav>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
