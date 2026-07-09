<?php
/**
 * Archive Template - Diseases Hub
 */
get_header();
?>

<style>
.diseases-hero {
    background: linear-gradient(135deg, #f6f3ec 0%, #efe9db 100%);
    padding: 80px 0 60px;
    position: relative;
    overflow: hidden;
}
.diseases-hero::before {
    content: "";
    position: absolute; top: -50%; right: -10%; width: 500px; height: 500px;
    background: radial-gradient(circle, rgba(11,92,135,0.1) 0%, transparent 70%);
    border-radius: 50%;
}
.disease-card {
    background: #fff; border: 1px solid var(--color-sand); border-radius: 18px;
    padding: 30px; height: 100%; transition: var(--transition);
    text-decoration: none; display: block; color: inherit;
}
.disease-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-lg); color: inherit; }
.disease-card-icon {
    width: 60px; height: 60px; border-radius: 14px; display: flex; align-items: center;
    justify-content: center; font-size: 1.6rem; margin-bottom: 16px;
    background: var(--color-blue-tint); color: var(--color-blue);
}
.disease-card h3 { font-weight: 700; font-size: 1.2rem; margin-bottom: 10px; }
.disease-card p { color: var(--text-light); font-size: 0.92rem; margin-bottom: 0; }
</style>

<section class="diseases-hero">
    <div class="container" style="position: relative; z-index: 1;">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb" style="background: transparent;">
                <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>" style="color:#0b5c87;text-decoration:none;"><i class="bi bi-house-fill"></i> Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Diseases</li>
            </ol>
        </nav>
        <h1 class="display-4 fw-bold mb-3" style="color:#0b5c87;">Disease Library</h1>
        <p class="lead" style="color:#4a575e;max-width:640px;">Evidence-based guidance on symptoms, complications, prevention, and vaccination for diseases common in Pakistan.</p>
    </div>
</section>

<section class="py-5" style="background: white;">
    <div class="container">
        <div class="row g-4">
            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <div class="col-lg-4 col-md-6">
                        <a href="<?php the_permalink(); ?>" class="disease-card">
                            <div class="disease-card-icon"><i class="bi bi-virus2"></i></div>
                            <h3><?php the_title(); ?></h3>
                            <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
                        </a>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <div class="col-12 text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 64px; color: var(--color-sand);"></i>
                    <p class="text-muted mt-3 mb-0">Disease guides are being added. Please check back soon.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
