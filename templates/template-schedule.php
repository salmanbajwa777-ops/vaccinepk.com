<?php
/**
 * Template Name: Vaccination Schedule Page
 */
get_header();

$stages = function_exists( 'vaccination_centre_schedule_stages' ) ? vaccination_centre_schedule_stages() : [];
?>

<style>
.schedule-hero {
    background: linear-gradient(135deg, #e0f4ff 0%, #cceeff 100%);
    padding: 80px 0 60px;
}
.schedule-timeline { position: relative; padding-left: 30px; }
.schedule-timeline::before {
    content: ""; position: absolute; left: 9px; top: 10px; bottom: 10px; width: 3px;
    background: linear-gradient(180deg, #107fa0, #7bb14f);
}
.schedule-stage {
    position: relative; background: white; border: 1px solid #eef0f2; border-radius: 16px;
    padding: 24px 28px; margin-bottom: 24px; box-shadow: var(--shadow-sm);
}
.schedule-stage::before {
    content: ""; position: absolute; left: -30px; top: 28px; width: 18px; height: 18px;
    border-radius: 50%; background: #107fa0; border: 3px solid white; box-shadow: 0 0 0 2px #107fa0;
}
.schedule-stage h3 { color: #107fa0; font-weight: 700; margin-bottom: 12px; }
.schedule-vaccine-chip {
    display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px;
    border-radius: 50px; background: #f0f9ff; border: 1.5px solid #107fa0;
    color: #107fa0; font-weight: 600; font-size: 0.85rem; text-decoration: none;
    margin: 0 8px 8px 0;
}
.schedule-vaccine-chip:hover { background: #107fa0; color: white; }
.schedule-vaccine-chip.no-link { cursor: default; border-color: #d1d5db; color: #6b7280; }
</style>

<section class="schedule-hero">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb" style="background: transparent;">
                <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>" style="color:#da7215;text-decoration:none;"><i class="bi bi-house-fill"></i> Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Vaccination Schedule</li>
            </ol>
        </nav>
        <h1 class="display-4 fw-bold mb-3" style="color:#107fa0;">Pakistan Vaccination Schedule</h1>
        <p class="lead" style="color:#6b7280;max-width:640px;">The recommended childhood immunization timeline, from birth through 18 months, following EPI guidelines.</p>
    </div>
</section>

<section class="py-5" style="background: white;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="schedule-timeline">
                    <?php foreach ( $stages as $stage ) : ?>
                        <div class="schedule-stage" id="<?php echo esc_attr( $stage['slug'] ); ?>">
                            <h3><?php echo esc_html( $stage['label'] ); ?></h3>
                            <div>
                                <?php foreach ( $stage['vaccines'] as $vaccine_name ) :
                                    $url = function_exists( 'vaccination_centre_find_vaccine_url' )
                                        ? vaccination_centre_find_vaccine_url( $vaccine_name )
                                        : null;
                                ?>
                                    <?php if ( $url ) : ?>
                                        <a href="<?php echo esc_url( $url ); ?>" class="schedule-vaccine-chip">
                                            <i class="bi bi-shield-fill-check"></i> <?php echo esc_html( $vaccine_name ); ?>
                                        </a>
                                    <?php else : ?>
                                        <span class="schedule-vaccine-chip no-link">
                                            <i class="bi bi-shield-fill-check"></i> <?php echo esc_html( $vaccine_name ); ?>
                                        </span>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="text-center mt-5">
                    <a href="<?php echo esc_url( site_url( '/booking' ) ); ?>" class="btn btn-primary btn-lg px-5">
                        <i class="bi bi-calendar-check-fill me-2"></i>Book Your Child's Vaccination
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
