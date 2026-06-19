<?php
/**
 * Template Name: Vaccine Pricing Page
 */
get_header(); ?>

<style>
/* ===== PRICING PAGE STYLES ===== */
.vc-pricing-wrap {
  max-width: 1200px;
  margin: 60px auto;
  padding: 0 20px;
  font-family: 'Segoe UI', sans-serif;
}
.vc-pricing-wrap h1.page-title {
  text-align: center;
  font-size: 2.5rem;
  color: #1a3c5e;
  margin-bottom: 10px;
}
.vc-pricing-wrap .subtitle {
  text-align: center;
  color: #666;
  margin-bottom: 50px;
  font-size: 1.1rem;
}

/* GROUP HEADING */
.vaccine-group-title {
  font-size: 1.7rem;
  color: #fff;
  background: linear-gradient(135deg, #1a3c5e, #2980b9);
  padding: 12px 25px;
  border-radius: 10px;
  margin: 50px 0 20px;
  display: inline-block;
  letter-spacing: 0.5px;
}

/* GRID */
.vaccine-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 25px;
  margin-bottom: 20px;
}
@media (max-width: 900px) { .vaccine-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 580px) { .vaccine-grid { grid-template-columns: 1fr; } }

/* CARD */
.vc-card {
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  overflow: hidden;
  cursor: pointer;
  transition: transform 0.3s, box-shadow 0.3s;
  position: relative;
}
.vc-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 12px 35px rgba(0,0,0,0.15);
}
.vc-card-img {
  width: 100%;
  height: 160px;
  object-fit: cover;
}
.vc-card-img-placeholder {
  width: 100%;
  height: 160px;
  background: linear-gradient(135deg, #e8f4fd, #b8d9f0);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 3rem;
}
.vc-card-body {
  padding: 18px;
}
.vc-card-body h3 {
  font-size: 1.1rem;
  color: #1a3c5e;
  margin: 0 0 10px;
  font-weight: 700;
}
.vc-card-meta {
  list-style: none;
  padding: 0;
  margin: 0 0 12px;
  font-size: 0.85rem;
  color: #555;
}
.vc-card-meta li {
  padding: 3px 0;
  border-bottom: 1px dashed #eee;
}
.vc-card-meta li:last-child { border: none; }
.vc-card-meta li span.label {
  font-weight: 600;
  color: #2980b9;
  min-width: 90px;
  display: inline-block;
}
.vc-price-tag {
  font-size: 1.4rem;
  font-weight: 800;
  color: #27ae60;
  margin-top: 10px;
}
.vc-price-tag .currency { font-size: 0.9rem; font-weight: 500; }
.vc-availability {
  position: absolute;
  top: 12px;
  right: 12px;
  padding: 4px 12px;
  border-radius: 50px;
  font-size: 0.75rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}
.avail-yes { background: #d4efdf; color: #1e8449; }
.avail-no  { background: #fde8e8; color: #c0392b; }

/* ===== MODAL ===== */
.vc-modal-overlay {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.65);
  z-index: 99999;
  align-items: center;
  justify-content: center;
  padding: 20px;
}
.vc-modal-overlay.active { display: flex; }

.vc-modal-box {
  background: #fff;
  border-radius: 20px;
  max-width: 620px;
  width: 100%;
  overflow: hidden;
  animation: modalSlide 0.35s ease;
  position: relative;
  max-height: 88vh;

  /* Custom scrollbar — theme colors */
  overflow-y: auto;
  scrollbar-width: thin;
  scrollbar-color: #2980b9 #e8f4fd;
}

/* Webkit custom scrollbar (Chrome, Safari, Edge) */
.vc-modal-box::-webkit-scrollbar {
  width: 7px;
}
.vc-modal-box::-webkit-scrollbar-track {
  background: #e8f4fd;
  border-radius: 0 20px 20px 0;
}
.vc-modal-box::-webkit-scrollbar-thumb {
  background: linear-gradient(180deg, #1a3c5e, #2980b9);
  border-radius: 10px;
  border: 1px solid #e8f4fd;
}
.vc-modal-box::-webkit-scrollbar-thumb:hover {
  background: linear-gradient(180deg, #2980b9, #27ae60);
}

@keyframes modalSlide {
  from { transform: translateY(40px); opacity: 0; }
  to   { transform: translateY(0); opacity: 1; }
}
.vc-modal-close {
  position: sticky;
  top: 12px;
  float: right;
  margin: 12px 14px 0 0;
  width: 34px;
  height: 34px;
  background: rgba(255,255,255,0.92);
  border: none;
  border-radius: 50%;
  cursor: pointer;
  color: #555;
  font-size: 1.4rem;
  line-height: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 2px 8px rgba(0,0,0,0.15);
  z-index: 10;
  transition: background 0.2s, color 0.2s;
}
.vc-modal-close:hover {
  background: #e74c3c;
  color: #fff;
}
.vc-modal-image {
  width: 100%;
  height: 250px;
  object-fit: cover;
  display: block;
  margin-top: -46px; /* slide under the sticky close btn */
}
.vc-modal-image-placeholder {
  width: 100%;
  height: 220px;
  background: linear-gradient(135deg, #e8f4fd, #b8d9f0);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 5rem;
  margin-top: -46px;
}
.vc-modal-content {
  padding: 24px 28px 32px;
}
.vc-modal-content h2 {
  font-size: 1.7rem;
  color: #1a3c5e;
  margin: 0 0 6px;
}
.vc-modal-vaccine-badge {
  display: inline-block;
  background: #eaf4fb;
  color: #2980b9;
  padding: 4px 14px;
  border-radius: 20px;
  font-size: 0.85rem;
  font-weight: 600;
  margin-bottom: 20px;
}
.vc-modal-details {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 14px;
  margin-bottom: 20px;
}
.vc-modal-detail-item {
  background: #f8fafc;
  border-radius: 10px;
  padding: 12px 15px;
  border-left: 4px solid #2980b9;
}
.vc-modal-detail-item .d-label {
  font-size: 0.78rem;
  color: #888;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-bottom: 4px;
}
.vc-modal-detail-item .d-value {
  font-size: 1rem;
  font-weight: 700;
  color: #1a3c5e;
}
.vc-modal-price-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: linear-gradient(135deg, #f0fff4, #d5f5e3);
  border-radius: 12px;
  padding: 16px 20px;
  margin-bottom: 20px;
}
.vc-modal-price-row .mp-label { font-size: 0.95rem; color: #555; }
.vc-modal-price-row .mp-price { font-size: 2rem; font-weight: 800; color: #27ae60; }
.vc-modal-description {
  color: #666;
  line-height: 1.7;
  font-size: 0.95rem;
  border-top: 1px solid #eee;
  padding-top: 18px;
}
</style>

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
                        <li class="breadcrumb-item active" aria-current="page">Pricing</li>
                    </ol>
                </nav>
                <h1 class="display-4 fw-bold mb-3" style="color: #107fa0;">Vaccine Pricing & Availability</h1>
                <p class="lead" style="color: #6b7280;">Transparent pricing with no hidden charges. Select vaccines to calculate total cost.</p>
            </div>
        </div>
    </div>
</section>

<div class="vc-pricing-wrap">
  <!-- <h1 class="page-title">Vaccine Pricing & Availability</h1>
  <p class="subtitle">Browse all available vaccines by name. Click any card for full details.</p> -->

  <?php
  $brands = get_posts([
    'post_type'      => 'brand',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'meta_value',
    'meta_key'       => 'vaccine_name',
    'order'          => 'ASC',
  ]);

  if ( ! $brands ) {
    echo '<p style="text-align:center;color:#888;">No vaccine data found. Please add brands from the dashboard.</p>';
  } else {
    $grouped = [];
    foreach ( $brands as $brand ) {
      $vaccine = get_post_meta( $brand->ID, 'vaccine_name', true );
      if ( ! $vaccine ) $vaccine = 'Other';
      $grouped[$vaccine][] = $brand;
    }
    ksort($grouped);

    foreach ( $grouped as $vaccine_name => $cards ) :
  ?>

  <div class="vaccine-group">
    <div class="vaccine-group-title">💉 <?php echo esc_html($vaccine_name); ?></div>
    <div class="vaccine-grid">
      <?php foreach ( $cards as $card ) :
        $thumb        = get_the_post_thumbnail_url( $card->ID, 'medium' );
        $disease      = get_post_meta( $card->ID, 'disease', true );
        $manufacturer = get_post_meta( $card->ID, 'manufacturer_name', true );
        $price        = get_post_meta( $card->ID, 'price', true );
        $avail        = get_post_meta( $card->ID, 'availability', true );
        $avail_bool   = ( $avail === '1' || strtolower($avail) === 'yes' || $avail === true );
        $full_content = apply_filters('the_content', get_post_field('post_content', $card->ID));
      ?>
      <div class="vc-card"
           data-title="<?php echo esc_attr($card->post_title); ?>"
           data-vaccine="<?php echo esc_attr($vaccine_name); ?>"
           data-disease="<?php echo esc_attr($disease); ?>"
           data-manufacturer="<?php echo esc_attr($manufacturer); ?>"
           data-price="<?php echo esc_attr($price); ?>"
           data-avail="<?php echo $avail_bool ? 'yes' : 'no'; ?>"
           data-thumb="<?php echo esc_attr($thumb); ?>"
           data-content="<?php echo esc_attr($full_content); ?>"
           onclick="vcOpenModal(this)"
      >
        <span class="vc-availability <?php echo $avail_bool ? 'avail-yes' : 'avail-no'; ?>">
          <?php echo $avail_bool ? '✓ Available' : '✗ Unavailable'; ?>
        </span>

        <?php if ( $thumb ) : ?>
          <img class="vc-card-img" src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($card->post_title); ?>">
        <?php else : ?>
          <div class="vc-card-img-placeholder">💉</div>
        <?php endif; ?>

        <div class="vc-card-body">
          <h3><?php echo esc_html($card->post_title); ?></h3>
          <ul class="vc-card-meta">
            <?php if ($disease) : ?>
            <li><span class="label">Disease:</span> <?php echo esc_html($disease); ?></li>
            <?php endif; ?>
            <?php if ($manufacturer) : ?>
            <li><span class="label">Manufacturer:</span> <?php echo esc_html($manufacturer); ?></li>
            <?php endif; ?>
          </ul>
          <?php if ($price) : ?>
          <div class="vc-price-tag">
            <span class="currency">PKR </span><?php echo esc_html(number_format((float)$price)); ?>
          </div>
          <?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <?php endforeach;
  }
  ?>

</div><!-- .vc-pricing-wrap -->

<!-- ===== MODAL ===== -->
<div class="vc-modal-overlay" id="vcModal" onclick="vcCloseModal(event)">
  <div class="vc-modal-box">

    <button class="vc-modal-close" onclick="vcCloseModalDirect()">&times;</button>

    <div id="vcModalImageWrap"></div>

    <div class="vc-modal-content">
      <h2 id="vcModalTitle"></h2>
      <div id="vcModalVaccineBadge" class="vc-modal-vaccine-badge"></div>
      <div class="vc-modal-details" id="vcModalDetails"></div>
      <div class="vc-modal-price-row">
        <span class="mp-label">💰 Price</span>
        <span class="mp-price" id="vcModalPrice"></span>
      </div>
      <div class="vc-modal-description" id="vcModalDesc"></div>
      <!-- Book Now button removed as requested -->
    </div>

  </div>
</div>

<script>
function vcOpenModal(el) {
  var title        = el.getAttribute('data-title');
  var vaccine      = el.getAttribute('data-vaccine');
  var disease      = el.getAttribute('data-disease');
  var manufacturer = el.getAttribute('data-manufacturer');
  var price        = el.getAttribute('data-price');
  var avail        = el.getAttribute('data-avail');
  var thumb        = el.getAttribute('data-thumb');
  var content      = el.getAttribute('data-content');

  document.getElementById('vcModalTitle').textContent = title;
  document.getElementById('vcModalVaccineBadge').textContent = '💉 ' + vaccine;

  var imgWrap = document.getElementById('vcModalImageWrap');
  if (thumb) {
    imgWrap.innerHTML = '<img class="vc-modal-image" src="' + thumb + '" alt="' + title + '">';
  } else {
    imgWrap.innerHTML = '<div class="vc-modal-image-placeholder">💉</div>';
  }

  var availHtml = avail === 'yes'
    ? '<span style="color:#1e8449;font-weight:700;">✓ Available</span>'
    : '<span style="color:#c0392b;font-weight:700;">✗ Not Available</span>';

  document.getElementById('vcModalDetails').innerHTML =
    '<div class="vc-modal-detail-item"><div class="d-label">Disease</div><div class="d-value">' + (disease||'—') + '</div></div>' +
    '<div class="vc-modal-detail-item"><div class="d-label">Manufacturer</div><div class="d-value">' + (manufacturer||'—') + '</div></div>' +
    '<div class="vc-modal-detail-item" style="border-left-color:#27ae60"><div class="d-label">Availability</div><div class="d-value">' + availHtml + '</div></div>' +
    '<div class="vc-modal-detail-item"><div class="d-label">Vaccine</div><div class="d-value">' + vaccine + '</div></div>';

  var priceNum = parseFloat(price);
  document.getElementById('vcModalPrice').innerHTML = price
    ? '<small style="font-size:1rem;font-weight:500;">PKR </small>' + priceNum.toLocaleString()
    : 'Contact Us';

  document.getElementById('vcModalDesc').innerHTML = content || '';

  // Reset scroll to top on open
  document.querySelector('.vc-modal-box').scrollTop = 0;

  document.getElementById('vcModal').classList.add('active');
  document.body.style.overflow = 'hidden';
}

function vcCloseModal(e) {
  if (e.target === document.getElementById('vcModal')) vcCloseModalDirect();
}
function vcCloseModalDirect() {
  document.getElementById('vcModal').classList.remove('active');
  document.body.style.overflow = '';
}
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') vcCloseModalDirect();
});
</script>

<?php get_footer(); ?>