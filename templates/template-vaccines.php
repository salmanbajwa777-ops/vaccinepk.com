<?php
/**
 * Template Name: Vaccines Page
 * Description: Vaccines listing page for Vaccination Centre
 * FINAL VERSION - Age column only in Child Vaccines tab
 */
get_header();
?>

<!-- ================= PAGE HEADER ================= -->
<section class="page-header" style="background: linear-gradient(135deg, #fff5eb 0%, #ffe8d5 100%); padding: 80px 0 60px; position: relative; overflow: hidden;">
    <div style="position: absolute; top: -50%; right: -10%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(218, 114, 21, 0.1) 0%, transparent 70%); border-radius: 50%;"></div>
    <div style="position: absolute; bottom: -30%; left: -5%; width: 400px; height: 400px; background: radial-gradient(circle, rgba(123, 177, 79, 0.1) 0%, transparent 70%); border-radius: 50%;"></div>
    
    <div class="container" style="position: relative; z-index: 1;">
        <div class="row">
            <div class="col-lg-10 mx-auto text-center">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb justify-content-center" style="background: transparent;">
                        <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>" style="color: #da7215; text-decoration: none;"><i class="bi bi-house-fill"></i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Our Vaccines</li>
                    </ol>
                </nav>
                <h1 class="display-4 fw-bold mb-3" style="color: #107fa0;">Available Vaccines</h1>
                <p class="lead" style="color: #6b7280;">Browse our comprehensive range of WHO-approved vaccines</p>
            </div>
        </div>
    </div>
</section>

<!-- ================= CATEGORY TABS ================= -->
<section class="py-5" style="background: white;">
    <div class="container">
        
        <!-- Category Navigation -->
        <ul class="nav nav-pills justify-content-center mb-5" id="vaccineTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active px-4 py-2 me-2 mb-2" id="child-vaccines-tab" data-bs-toggle="pill" data-bs-target="#child-vaccines" type="button" role="tab" style="border-radius: 50px;">
                    <i class="bi bi-heart-fill"></i> Child Vaccines
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link px-4 py-2 me-2 mb-2" id="adult-vaccines-tab" data-bs-toggle="pill" data-bs-target="#adult-vaccines" type="button" role="tab" style="border-radius: 50px;">
                    <i class="bi bi-person-fill"></i> Adult Vaccines
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link px-4 py-2 me-2 mb-2" id="flu-vaccines-tab" data-bs-toggle="pill" data-bs-target="#flu-vaccines" type="button" role="tab" style="border-radius: 50px;">
                    <i class="bi bi-shield-fill-plus"></i> Flu Vaccines
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link px-4 py-2 mb-2" id="travel-vaccines-tab" data-bs-toggle="pill" data-bs-target="#travel-vaccines" type="button" role="tab" style="border-radius: 50px;">
                    <i class="bi bi-airplane-fill"></i> Travel Vaccines
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="vaccineTabsContent">
            
            <?php
            // Get all vaccine categories
            $categories = array('child-vaccines', 'adult-vaccines', 'flu-vaccines', 'travel-vaccines');
            $category_names = array(
                'child-vaccines' => 'Child Vaccines',
                'adult-vaccines' => 'Adult Vaccines',
                'flu-vaccines' => 'Flu Vaccines',
                'travel-vaccines' => 'Travel Vaccines'
            );
            
            foreach ($categories as $index => $category_slug) :
                $active_class = ($index === 0) ? 'show active' : '';
                $show_age_column = ($category_slug === 'child-vaccines'); // Only show age for child vaccines
            ?>
            
            <div class="tab-pane fade <?php echo $active_class; ?>" id="<?php echo $category_slug; ?>" role="tabpanel">
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle" style="border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                        <thead style="background: linear-gradient(135deg, #da7215, #d35324); color: white;">
                            <tr>
                                <th class="py-3"><i class="bi bi-heart-pulse"></i> Vaccine</th>
                                <th class="py-3"><i class="bi bi-shield-check"></i> Brand</th>
                                <?php if ($show_age_column) : ?>
                                    <th class="py-3"><i class="bi bi-calendar-event"></i> Age</th>
                                <?php endif; ?>
                                <th class="py-3"><i class="bi bi-check-circle"></i> Availability</th>
                            </tr>
                        </thead>
                        <tbody style="background: white;">
                            <?php
                            // Query vaccines for this category
                            $vaccines_args = array(
                                'post_type' => 'vaccine',
                                'posts_per_page' => -1,
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'vaccine_category',
                                        'field' => 'slug',
                                        'terms' => $category_slug
                                    )
                                ),
                                'orderby' => 'title',
                                'order' => 'ASC'
                            );
                            
                            $vaccines_query = new WP_Query($vaccines_args);
                            
                            if ($vaccines_query->have_posts()) :
                                while ($vaccines_query->have_posts()) : $vaccines_query->the_post();
                                    $disease_name = get_post_meta(get_the_ID(), 'disease_name', true);
                                    $vaccine_brand = get_post_meta(get_the_ID(), 'vaccine_brand', true);
                                    $age_requirement = get_post_meta(get_the_ID(), 'age_requirement', true);
                                    $availability = get_post_meta(get_the_ID(), 'availability', true);
                                    
                                    // Get vaccine content for modal
                                    $vaccine_title = get_the_title();
                                    $vaccine_content = get_the_content();
                                    $vaccine_content = apply_filters('the_content', $vaccine_content);
                                    
                                    // Handle availability badge
                                    $availability_badge = '';
                                    if ($availability === 'in_stock' || $availability === 'yes' || $availability === '1' || $availability === true) {
                                        $availability_badge = '<span class="badge" style="background: #7bb14f; color: white;"><i class="bi bi-check-circle-fill"></i> In Stock</span>';
                                    } elseif ($availability === 'out_of_stock' || $availability === 'no' || $availability === '0' || $availability === false) {
                                        $availability_badge = '<span class="badge bg-danger"><i class="bi bi-x-circle-fill"></i> Out of Stock</span>';
                                    } elseif ($availability === 'coming_soon') {
                                        $availability_badge = '<span class="badge bg-warning text-dark"><i class="bi bi-clock-fill"></i> Coming Soon</span>';
                                    } else {
                                        $availability_badge = '<span class="badge" style="background: #7bb14f; color: white;"><i class="bi bi-check-circle-fill"></i> In Stock</span>';
                                    }
                            ?>
                            <tr class="vaccine-row" style="cursor: pointer;" 
                                onclick="openVaccineModal(this)"
                                data-vaccine-title="<?php echo esc_attr($vaccine_title); ?>"
                                data-vaccine-content='<?php echo htmlspecialchars($vaccine_content, ENT_QUOTES, 'UTF-8'); ?>'>
                                <td class="ps-4 fw-bold"><?php echo esc_html($disease_name); ?></td>
                                
                                <td><?php echo esc_html($vaccine_brand); ?></td>
                                <?php if ($show_age_column) : ?>
                                    <td><?php echo esc_html($age_requirement); ?></td>
                                <?php endif; ?>
                                <td><?php echo $availability_badge; ?></td>
                            </tr>
                            <?php 
                                endwhile;
                                wp_reset_postdata();
                            else :
                                // Calculate colspan based on whether age column is shown
                                $empty_colspan = $show_age_column ? '4' : '3';
                            ?>
                            <tr>
                                <td colspan="<?php echo $empty_colspan; ?>" class="text-center py-5">
                                    <i class="bi bi-inbox" style="font-size: 64px; color: #e5e7eb;"></i>
                                    <p class="text-muted mt-3 mb-0">No vaccines found in this category yet.</p>
                                    <p class="text-muted small">Please check back soon or contact us for more information.</p>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
            </div>
            
            <?php endforeach; ?>
            
        </div>

        <!-- DIRECT BOOKING BUTTON -->
        <div class="text-center mt-5">
            <a href="<?php echo home_url('/booking'); ?>" class="btn btn-lg px-5 py-3" style="background: linear-gradient(135deg, #107fa0 0%, #7bb14f 100%); color: white; border: none; border-radius: 50px; font-weight: 700; font-size: 18px; text-decoration: none; display: inline-block; transition: all 0.3s;">
                <i class="bi bi-calendar-check-fill me-2"></i> Book Your Vaccination Now
            </a>
        </div>

    </div>
</section>

<!-- ================= VACCINE DETAILS MODAL ================= -->
<div class="modal fade" id="vaccineModal" tabindex="-1" aria-labelledby="vaccineModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content" style="border: none; border-radius: 24px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
            
            <!-- Modal Header -->
            <div class="modal-header" style="background: linear-gradient(135deg, #107fa0 0%, #7bb14f 100%); color: white; border: none; padding: 30px;">
                <div class="d-flex align-items-center">
                    <div class="me-3" style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-virus2" style="font-size: 32px;"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-1" id="vaccineModalLabel" style="font-size: 24px;">Vaccine Details</h5>
                        <p class="mb-0 opacity-75 small">Complete information about this vaccine</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="filter: brightness(0) invert(1);"></button>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body" style="padding: 40px; background: #f9fafb;">
                <div id="vaccineContentContainer" class="vaccine-content-wrapper">
                    <!-- Content will be inserted here via JavaScript -->
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer" style="border: none; background: #f9fafb; padding: 20px 40px;">
                <!-- <a href="<?php echo home_url('/booking'); ?>" class="btn btn-lg px-4 py-2 me-2" style="background: linear-gradient(135deg, #da7215, #d35324); color: white; border: none; border-radius: 50px; font-weight: 600;">
                    <i class="bi bi-calendar-check-fill me-2"></i> Book This Vaccine
                </a> -->
                <button type="button" class="btn btn-lg px-4 py-2" data-bs-dismiss="modal" style="background: #e5e7eb; color: #374151; border: none; border-radius: 50px; font-weight: 600;">
                    <i class="bi bi-x-circle me-2"></i> Close
                </button>
            </div>
            
        </div>
    </div>
</div>

<!-- ================= INFO SECTION ================= -->
<section class="py-5" style="background: linear-gradient(135deg, #f0ffe0 0%, #e5ffcc 100%);">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6 text-center">
                <div class="bg-white p-4 rounded-4 shadow-sm">
                    <i class="bi bi-shield-check" style="font-size: 48px; color: #7bb14f;"></i>
                    <h6 class="fw-bold mt-3 mb-2">WHO Approved</h6>
                    <p class="text-muted small mb-0">All vaccines are WHO certified</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="bg-white p-4 rounded-4 shadow-sm">
                    <i class="bi bi-thermometer-snow" style="font-size: 48px; color: #107fa0;"></i>
                    <h6 class="fw-bold mt-3 mb-2">Cold Chain</h6>
                    <p class="text-muted small mb-0">Proper storage maintained</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="bg-white p-4 rounded-4 shadow-sm">
                    <i class="bi bi-house-heart" style="font-size: 48px; color: #da7215;"></i>
                    <h6 class="fw-bold mt-3 mb-2">Home Service</h6>
                    <p class="text-muted small mb-0">Vaccination at your doorstep</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="bg-white p-4 rounded-4 shadow-sm">
                    <i class="bi bi-people" style="font-size: 48px; color: #7bb14f;"></i>
                    <h6 class="fw-bold mt-3 mb-2">Expert Team</h6>
                    <p class="text-muted small mb-0">Qualified medical professionals</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Tab Navigation Styling */
.nav-pills .nav-link {
    background: #f3f4f6;
    color: #6b7280;
    border: 2px solid transparent;
    font-weight: 600;
    transition: all 0.3s;
}

.nav-pills .nav-link:hover {
    background: #e5e7eb;
    transform: translateY(-2px);
}

.nav-pills .nav-link.active {
    background: linear-gradient(135deg, #da7215, #d35324);
    color: white;
    border-color: #da7215;
}

/* Table Row Hover Effect */
.table tbody tr {
    transition: all 0.3s;
}

.table tbody tr.vaccine-row:hover {
    background: linear-gradient(90deg, #fff5eb 0%, #ffe8d5 100%) !important;
    transform: scale(1.01);
    box-shadow: 0 4px 12px rgba(218, 114, 21, 0.15);
}

/* Clickable Row Indicator */
.vaccine-row:hover td {
    color: #da7215;
}

/* Book Now Button Hover */
a.btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(16, 127, 160, 0.4);
}

/* Modal Content Styling */
.vaccine-content-wrapper {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.8;
    color: #1f2937;
}

.vaccine-content-wrapper h1,
.vaccine-content-wrapper h2,
.vaccine-content-wrapper h3,
.vaccine-content-wrapper h4,
.vaccine-content-wrapper h5,
.vaccine-content-wrapper h6 {
    color: #107fa0;
    font-weight: 700;
    margin-top: 24px;
    margin-bottom: 16px;
    line-height: 1.3;
}

.vaccine-content-wrapper h1 {
    font-size: 32px;
    border-bottom: 3px solid #7bb14f;
    padding-bottom: 12px;
}

.vaccine-content-wrapper h2 {
    font-size: 28px;
    border-left: 4px solid #da7215;
    padding-left: 16px;
}

.vaccine-content-wrapper h3 {
    font-size: 24px;
    color: #da7215;
}

.vaccine-content-wrapper h4 {
    font-size: 20px;
    color: #7bb14f;
}

.vaccine-content-wrapper p {
    margin-bottom: 16px;
    font-size: 16px;
    text-align: justify;
}

.vaccine-content-wrapper ul,
.vaccine-content-wrapper ol {
    margin-left: 20px;
    margin-bottom: 20px;
}

.vaccine-content-wrapper ul li,
.vaccine-content-wrapper ol li {
    margin-bottom: 12px;
    padding-left: 8px;
    position: relative;
}

.vaccine-content-wrapper ul li::marker {
    color: #7bb14f;
    font-size: 20px;
}

.vaccine-content-wrapper ol li::marker {
    color: #107fa0;
    font-weight: 700;
}

.vaccine-content-wrapper img {
    max-width: 100%;
    height: auto;
    border-radius: 16px;
    margin: 24px 0;
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    transition: transform 0.3s;
}

.vaccine-content-wrapper img:hover {
    transform: scale(1.02);
}

.vaccine-content-wrapper blockquote {
    background: linear-gradient(135deg, #fff5eb 0%, #ffe8d5 100%);
    border-left: 5px solid #da7215;
    padding: 20px 24px;
    margin: 24px 0;
    border-radius: 8px;
    font-style: italic;
    color: #374151;
}

.vaccine-content-wrapper table {
    width: 100%;
    border-collapse: collapse;
    margin: 24px 0;
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.vaccine-content-wrapper table th {
    background: linear-gradient(135deg, #107fa0, #7bb14f);
    color: white;
    padding: 16px;
    text-align: left;
    font-weight: 600;
}

.vaccine-content-wrapper table td {
    padding: 14px 16px;
    border-bottom: 1px solid #e5e7eb;
}

.vaccine-content-wrapper table tr:last-child td {
    border-bottom: none;
}

.vaccine-content-wrapper table tr:hover {
    background: #f9fafb;
}

.vaccine-content-wrapper strong,
.vaccine-content-wrapper b {
    color: #107fa0;
    font-weight: 700;
}

.vaccine-content-wrapper em,
.vaccine-content-wrapper i {
    color: #da7215;
}

.vaccine-content-wrapper a {
    color: #107fa0;
    text-decoration: underline;
    transition: color 0.3s;
}

.vaccine-content-wrapper a:hover {
    color: #7bb14f;
}

.vaccine-content-wrapper code {
    background: #f3f4f6;
    padding: 2px 8px;
    border-radius: 4px;
    font-family: 'Courier New', monospace;
    color: #da7215;
}

.vaccine-content-wrapper pre {
    background: #1f2937;
    color: #f3f4f6;
    padding: 20px;
    border-radius: 12px;
    overflow-x: auto;
    margin: 24px 0;
}

/* Modal Animation */
.modal.fade .modal-dialog {
    transition: transform 0.4s ease-out;
    transform: scale(0.8);
}

.modal.show .modal-dialog {
    transform: scale(1);
}

/* Responsive Styling */
@media (max-width: 768px) {
    .vaccine-content-wrapper h1 {
        font-size: 26px;
    }
    
    .vaccine-content-wrapper h2 {
        font-size: 22px;
    }
    
    .vaccine-content-wrapper h3 {
        font-size: 20px;
    }
}
</style>

<script>
// Vanilla JavaScript - No jQuery needed
function openVaccineModal(element) {
    // Get data from clicked row
    const vaccineTitle = element.getAttribute('data-vaccine-title');
    const vaccineContent = element.getAttribute('data-vaccine-content');
    
    // Update modal title
    document.getElementById('vaccineModalLabel').innerHTML = '<i class="bi bi-virus2 me-2"></i>' + vaccineTitle;
    
    // Update modal content
    document.getElementById('vaccineContentContainer').innerHTML = vaccineContent;
    
    // Show modal using Bootstrap 5
    const modalElement = document.getElementById('vaccineModal');
    const modal = new bootstrap.Modal(modalElement);
    modal.show();
}

// Debug: Check if script is loading
console.log('Vaccine modal script loaded successfully!');
</script>

<?php get_footer(); ?>
