<?php
/**
 * Template Name: Vaccine Pricing Page
 */
get_header();

$site_settings = pods( 'site_contact_settings' );
$whatsapp      = $site_settings->field( 'whatsapp_number' );
$whatsapp_link = preg_replace( '/[^0-9]/', '', (string) $whatsapp );

// Flat charge added to every quote, same figure used across the site's booking flow.
$vaccination_charge = 1800;

$category_tabs = [
    'all'                   => 'All',
    'child-vaccines'        => 'Child Vaccines',
    'adult-vaccines'        => 'Adult Vaccines',
    'travel-vaccines'       => 'Travel Vaccines',
    'flu-vaccines'          => 'Flu Vaccines',
    'special-circumstances' => 'Special Circumstances',
];
?>

<style>
/* ===== PRICING PAGE STYLES ===== */
.vc-pricing-wrap {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px 40px;
  font-family: 'Segoe UI', sans-serif;
}

/* CATEGORY TABS */
.vc-cat-tabs {
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
  justify-content: center;
  margin: 0 0 40px;
}
.vc-cat-tab {
  font-size: 0.85rem;
  font-weight: 700;
  padding: 9px 18px;
  border-radius: 50px;
  border: 1.5px solid #e7e0d3;
  background: #fff;
  color: #4a575e;
  cursor: pointer;
  transition: all .2s ease;
}
.vc-cat-tab:hover { border-color: #0b5c87; color: #0b5c87; }
.vc-cat-tab.active { background: #0a2a38; border-color: #0a2a38; color: #fff; }

/* GROUP HEADING */
.vaccine-group-title {
  font-size: 1.7rem;
  color: #fff;
  background: linear-gradient(135deg, #0a2a38, #0b5c87);
  padding: 12px 25px;
  border-radius: 10px;
  margin: 50px 0 20px;
  display: inline-block;
  letter-spacing: 0.5px;
}
.vaccine-group:first-of-type .vaccine-group-title { margin-top: 0; }

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
  transition: transform 0.3s, box-shadow 0.3s;
  position: relative;
}
.vc-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 12px 35px rgba(0,0,0,0.15);
}
.vc-card-img {
  width: 100%;
  height: 180px;
  object-fit: contain;
  background: linear-gradient(135deg, #eaf2f6, #cfe0e8);
  padding: 10px;
  box-sizing: border-box;
  cursor: pointer;
}
.vc-card-img-placeholder {
  width: 100%;
  height: 160px;
  background: linear-gradient(135deg, #eaf2f6, #cfe0e8);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 3rem;
  cursor: pointer;
}
.vc-card-body {
  padding: 18px;
}
.vc-card-body h3 {
  font-size: 1.1rem;
  color: #0a2a38;
  margin: 0 0 10px;
  font-weight: 700;
  cursor: pointer;
}
.vc-card-meta {
  list-style: none;
  padding: 0;
  margin: 0 0 12px;
  font-size: 0.85rem;
  color: #4a575e;
}
.vc-card-meta li {
  padding: 3px 0;
  border-bottom: 1px dashed #e7e0d3;
}
.vc-card-meta li:last-child { border: none; }
.vc-card-meta li span.label {
  font-weight: 600;
  color: #0b5c87;
  min-width: 90px;
  display: inline-block;
}
.vc-price-tag {
  font-size: 1.4rem;
  font-weight: 800;
  color: #c9a24b;
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
.avail-yes { background: #eaf3e4; color: #5a9c34; }
.avail-no  { background: #fde8e8; color: #c0392b; }

/* SELECT CHECKBOX ON CARD */
.vc-select-row {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 12px 18px;
  border-top: 1px solid #e7e0d3;
  background: #fafaf8;
}
.vc-select-row input[type="checkbox"] {
  width: 20px;
  height: 20px;
  accent-color: #0b5c87;
  cursor: pointer;
  flex-shrink: 0;
}
.vc-select-row label {
  font-size: 0.82rem;
  font-weight: 600;
  color: #4a575e;
  cursor: pointer;
  user-select: none;
}
.vc-card.vc-card-selected {
  box-shadow: 0 0 0 2px #0b5c87, 0 12px 35px rgba(0,0,0,0.15);
}
.vc-card-unavailable .vc-select-row { opacity: 0.5; }
.vc-card-unavailable input[type="checkbox"] { cursor: not-allowed; }

/* ===== STICKY QUOTE BAR ===== */
.vc-quote-bar {
  position: sticky;
  bottom: 0;
  left: 0;
  right: 0;
  background: #0a2a38;
  color: #fff;
  z-index: 500;
  transform: translateY(100%);
  transition: transform 0.3s ease;
  box-shadow: 0 -8px 30px rgba(0,0,0,0.2);
}
.vc-quote-bar.visible { transform: translateY(0); }
.vc-quote-bar-inner {
  max-width: 1200px;
  margin: 0 auto;
  padding: 14px 20px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  flex-wrap: wrap;
}
.vc-quote-left { font-size: 0.85rem; line-height: 1.5; }
.vc-quote-left .vc-quote-count { font-weight: 800; font-size: 0.95rem; }
.vc-quote-left .vc-quote-charge { opacity: 0.72; font-size: 0.76rem; }
.vc-quote-total {
  font-size: 1.3rem;
  font-weight: 800;
  color: #c9a24b;
  white-space: nowrap;
}
.vc-quote-actions { display: flex; gap: 10px; }
.vc-quote-btn {
  background: #c9a24b;
  color: #0a2a38;
  font-weight: 700;
  font-size: 0.85rem;
  border: none;
  border-radius: 50px;
  padding: 12px 24px;
  cursor: pointer;
  white-space: nowrap;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 6px;
}
.vc-quote-clear {
  background: transparent;
  color: rgba(255,255,255,0.75);
  border: 1px solid rgba(255,255,255,0.3);
  font-size: 0.8rem;
  font-weight: 600;
  border-radius: 50px;
  padding: 12px 16px;
  cursor: pointer;
}

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

  overflow-y: auto;
  scrollbar-width: thin;
  scrollbar-color: #0b5c87 #eaf2f6;
}

.vc-modal-box::-webkit-scrollbar { width: 7px; }
.vc-modal-box::-webkit-scrollbar-track { background: #eaf2f6; border-radius: 0 20px 20px 0; }
.vc-modal-box::-webkit-scrollbar-thumb { background: linear-gradient(180deg, #0a2a38, #0b5c87); border-radius: 10px; border: 1px solid #eaf2f6; }
.vc-modal-box::-webkit-scrollbar-thumb:hover { background: linear-gradient(180deg, #0b5c87, #6bb63f); }

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
  color: #4a575e;
  font-size: 1.4rem;
  line-height: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 2px 8px rgba(0,0,0,0.15);
  z-index: 10;
  transition: background 0.2s, color 0.2s;
}
.vc-modal-close:hover { background: #e74c3c; color: #fff; }
.vc-modal-image {
  width: 100%;
  height: 280px;
  object-fit: contain;
  background: linear-gradient(135deg, #eaf2f6, #cfe0e8);
  padding: 16px;
  box-sizing: border-box;
  display: block;
  margin-top: -46px;
}
.vc-modal-image-placeholder {
  width: 100%;
  height: 220px;
  background: linear-gradient(135deg, #eaf2f6, #cfe0e8);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 5rem;
  margin-top: -46px;
}
.vc-modal-content { padding: 24px 28px 32px; }
.vc-modal-content h2 { font-size: 1.7rem; color: #0a2a38; margin: 0 0 6px; }
.vc-modal-vaccine-badge {
  display: inline-block;
  background: #eaf2f6;
  color: #0b5c87;
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
  border-left: 4px solid #0b5c87;
}
.vc-modal-detail-item .d-label {
  font-size: 0.78rem;
  color: #8a959a;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-bottom: 4px;
}
.vc-modal-detail-item .d-value { font-size: 1rem; font-weight: 700; color: #0a2a38; }
.vc-modal-price-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: linear-gradient(135deg, #eaf3e4, #dcedd0);
  border-radius: 12px;
  padding: 16px 20px;
  margin-bottom: 20px;
}
.vc-modal-price-row .mp-label { font-size: 0.95rem; color: #4a575e; }
.vc-modal-price-row .mp-price { font-size: 2rem; font-weight: 800; color: #c9a24b; }
.vc-modal-description {
  color: #4a575e;
  line-height: 1.7;
  font-size: 0.95rem;
  border-top: 1px solid #e7e0d3;
  padding-top: 18px;
}
</style>

<!-- ================= PAGE HEADER ================= -->
<section class="page-header" style="background: linear-gradient(135deg, #f6f3ec 0%, #efe9db 100%); padding: 80px 0 60px; position: relative; overflow: hidden;">
    <div style="position: absolute; top: -50%; right: -10%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(201, 162, 75, 0.12) 0%, transparent 70%); border-radius: 50%;"></div>
    <div style="position: absolute; bottom: -30%; left: -5%; width: 400px; height: 400px; background: radial-gradient(circle, rgba(11, 92, 135, 0.1) 0%, transparent 70%); border-radius: 50%;"></div>

    <div class="container" style="position: relative; z-index: 1;">
        <div class="row">
            <div class="col-lg-10 mx-auto text-center">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb justify-content-center" style="background: transparent;">
                        <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>" style="color: #0b5c87; text-decoration: none;"><i class="bi bi-house-fill"></i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pricing</li>
                    </ol>
                </nav>
                <h1 class="display-4 fw-bold mb-3" style="color: #0b5c87;">Vaccine Pricing &amp; Availability</h1>
                <p class="lead" style="color: #4a575e;">Transparent pricing with no hidden charges. Select vaccines below to calculate your total.</p>
            </div>
        </div>
    </div>
</section>

<div class="vc-pricing-wrap">

  <!-- ================= CATEGORY TABS ================= -->
  <div class="vc-cat-tabs" id="vcCatTabs">
    <?php foreach ( $category_tabs as $slug => $label ) : ?>
      <button type="button" class="vc-cat-tab<?php echo $slug === 'all' ? ' active' : ''; ?>" data-cat="<?php echo esc_attr( $slug ); ?>">
        <?php echo esc_html( $label ); ?>
      </button>
    <?php endforeach; ?>
  </div>

  <?php
  $brands = get_posts( [
      'post_type'      => 'brand',
      'posts_per_page' => -1,
      'post_status'    => 'publish',
      'orderby'        => 'title',
      'order'          => 'ASC',
  ] );

  if ( ! $brands ) {
      echo '<p style="text-align:center;color:#8a959a;">No vaccine data found. Please add brands from the dashboard.</p>';
  } else {
      // Group brands by their parent vaccine's title so cards for the same
      // disease (e.g. two Hepatitis B doses) sit under one heading, same as
      // the page looked before. A brand with no linked vaccine falls back to
      // its own vaccine_name text so nothing silently disappears from the page.
      $grouped = [];
      foreach ( $brands as $brand ) {
          $brand_pod = pods( 'brand', $brand->ID );

          // Pods relationship fields return an array of related item arrays
          // (each with at least 'ID'), or an empty array when nothing is linked.
          $related        = $brand_pod->field( 'parent_vaccine' );
          $parent_vaccine_id = 0;
          if ( is_array( $related ) && ! empty( $related ) ) {
              $first = reset( $related );
              $parent_vaccine_id = is_array( $first ) ? (int) ( $first['ID'] ?? 0 ) : (int) $first;
          }
          $parent_vaccine = $parent_vaccine_id ? get_post( $parent_vaccine_id ) : null;

          $group_label = $parent_vaccine ? $parent_vaccine->post_title : get_post_meta( $brand->ID, 'vaccine_name', true );
          if ( ! $group_label ) $group_label = 'Other';

          // Category comes from the brand's own Categories field when set,
          // else falls back to its parent vaccine's tags, else 'Other' vaccine's own taxonomy.
          $brand_cat_terms = wp_get_post_terms( $brand->ID, 'vaccine_category', [ 'fields' => 'slugs' ] );
          if ( is_wp_error( $brand_cat_terms ) || empty( $brand_cat_terms ) ) {
              $brand_cat_terms = $parent_vaccine
                  ? wp_get_post_terms( $parent_vaccine->ID, 'vaccine_category', [ 'fields' => 'slugs' ] )
                  : [];
              if ( is_wp_error( $brand_cat_terms ) ) $brand_cat_terms = [];
          }

          $grouped[ $group_label ][] = [
              'post'       => $brand,
              'categories' => $brand_cat_terms,
          ];
      }
      ksort( $grouped );

      foreach ( $grouped as $group_label => $cards ) :
  ?>

  <div class="vaccine-group" data-group="<?php echo esc_attr( sanitize_title( $group_label ) ); ?>">
    <div class="vaccine-group-title">💉 <?php echo esc_html( $group_label ); ?></div>
    <div class="vaccine-grid">
      <?php foreach ( $cards as $entry ) :
          $card         = $entry['post'];
          $cats         = $entry['categories'];
          $thumb        = get_the_post_thumbnail_url( $card->ID, 'medium' );
          $disease      = get_post_meta( $card->ID, 'disease', true );
          $manufacturer = get_post_meta( $card->ID, 'manufacturer_name', true );
          $price        = get_post_meta( $card->ID, 'price', true );
          $avail        = get_post_meta( $card->ID, 'availability', true );
          $avail_bool   = ( $avail === '1' || strtolower( $avail ) === 'yes' || $avail === true );
          $full_content = apply_filters( 'the_content', get_post_field( 'post_content', $card->ID ) );
      ?>
      <div class="vc-card<?php echo $avail_bool ? '' : ' vc-card-unavailable'; ?>"
           data-categories="<?php echo esc_attr( implode( ',', $cats ) ); ?>"
           data-id="<?php echo esc_attr( $card->ID ); ?>"
           data-title="<?php echo esc_attr( $card->post_title ); ?>"
           data-vaccine="<?php echo esc_attr( $group_label ); ?>"
           data-disease="<?php echo esc_attr( $disease ); ?>"
           data-manufacturer="<?php echo esc_attr( $manufacturer ); ?>"
           data-price="<?php echo esc_attr( $price ); ?>"
           data-avail="<?php echo $avail_bool ? 'yes' : 'no'; ?>"
           data-thumb="<?php echo esc_attr( $thumb ); ?>"
           data-content="<?php echo esc_attr( $full_content ); ?>"
      >
        <span class="vc-availability <?php echo $avail_bool ? 'avail-yes' : 'avail-no'; ?>">
          <?php echo $avail_bool ? '✓ Available' : '✗ Unavailable'; ?>
        </span>

        <?php if ( $thumb ) : ?>
          <img class="vc-card-img" src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( $card->post_title ); ?>" onclick="vcOpenModal(this.closest('.vc-card'))">
        <?php else : ?>
          <div class="vc-card-img-placeholder" onclick="vcOpenModal(this.closest('.vc-card'))">💉</div>
        <?php endif; ?>

        <div class="vc-card-body">
          <h3 onclick="vcOpenModal(this.closest('.vc-card'))"><?php echo esc_html( $card->post_title ); ?></h3>
          <ul class="vc-card-meta">
            <?php if ( $disease ) : ?>
            <li><span class="label">Disease:</span> <?php echo esc_html( $disease ); ?></li>
            <?php endif; ?>
            <?php if ( $manufacturer ) : ?>
            <li><span class="label">Manufacturer:</span> <?php echo esc_html( $manufacturer ); ?></li>
            <?php endif; ?>
          </ul>
          <?php if ( $price ) : ?>
          <div class="vc-price-tag">
            <span class="currency">PKR </span><?php echo esc_html( number_format( (float) $price ) ); ?>
          </div>
          <?php endif; ?>
        </div>

        <div class="vc-select-row">
          <input type="checkbox" id="vc-select-<?php echo esc_attr( $card->ID ); ?>" class="vc-select-checkbox"
                 <?php disabled( ! $avail_bool ); ?>>
          <label for="vc-select-<?php echo esc_attr( $card->ID ); ?>">
            <?php echo $avail_bool ? 'Add to quote' : 'Currently unavailable'; ?>
          </label>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <?php
      endforeach;
  }
  ?>

</div><!-- .vc-pricing-wrap -->

<!-- ===== STICKY QUOTE BAR ===== -->
<div class="vc-quote-bar" id="vcQuoteBar">
  <div class="vc-quote-bar-inner">
    <div class="vc-quote-left">
      <div class="vc-quote-count"><span id="vcQuoteCount">0</span> vaccine<span id="vcQuotePlural">s</span> selected</div>
      <div class="vc-quote-charge">+ PKR <?php echo esc_html( number_format( $vaccination_charge ) ); ?> home vaccination charge</div>
    </div>
    <div class="vc-quote-total">PKR <span id="vcQuoteTotal">0</span></div>
    <div class="vc-quote-actions">
      <button type="button" class="vc-quote-clear" id="vcQuoteClear">Clear</button>
      <a href="#" target="_blank" class="vc-quote-btn" id="vcQuoteBookBtn">
        <i class="bi bi-whatsapp"></i> Book Selected Vaccines
      </a>
    </div>
  </div>
</div>

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
    </div>

  </div>
</div>

<script>
var VC_VACCINATION_CHARGE = <?php echo (int) $vaccination_charge; ?>;
var VC_WHATSAPP           = '<?php echo esc_js( $whatsapp_link ); ?>';

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
    ? '<span style="color:#5a9c34;font-weight:700;">✓ Available</span>'
    : '<span style="color:#c0392b;font-weight:700;">✗ Not Available</span>';

  document.getElementById('vcModalDetails').innerHTML =
    '<div class="vc-modal-detail-item"><div class="d-label">Disease</div><div class="d-value">' + (disease||'—') + '</div></div>' +
    '<div class="vc-modal-detail-item"><div class="d-label">Manufacturer</div><div class="d-value">' + (manufacturer||'—') + '</div></div>' +
    '<div class="vc-modal-detail-item" style="border-left-color:#6bb63f"><div class="d-label">Availability</div><div class="d-value">' + availHtml + '</div></div>' +
    '<div class="vc-modal-detail-item"><div class="d-label">Vaccine</div><div class="d-value">' + vaccine + '</div></div>';

  var priceNum = parseFloat(price);
  document.getElementById('vcModalPrice').innerHTML = price
    ? '<small style="font-size:1rem;font-weight:500;">PKR </small>' + priceNum.toLocaleString()
    : 'Contact Us';

  document.getElementById('vcModalDesc').innerHTML = content || '';

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

/* ================= CATEGORY FILTER ================= */
document.addEventListener('DOMContentLoaded', function () {
  var tabs  = document.querySelectorAll('.vc-cat-tab');
  var cards = document.querySelectorAll('.vc-card');
  var groups = document.querySelectorAll('.vaccine-group');

  function applyFilter(cat) {
    cards.forEach(function (card) {
      if (cat === 'all') { card.style.display = ''; return; }
      var cardCats = (card.getAttribute('data-categories') || '').split(',');
      card.style.display = cardCats.indexOf(cat) !== -1 ? '' : 'none';
    });

    // Hide a whole group heading if every card inside it is filtered out.
    groups.forEach(function (group) {
      var visibleCards = group.querySelectorAll('.vc-card:not([style*="display: none"])');
      group.style.display = visibleCards.length ? '' : 'none';
    });
  }

  tabs.forEach(function (tab) {
    tab.addEventListener('click', function () {
      tabs.forEach(function (t) { t.classList.remove('active'); });
      tab.classList.add('active');
      applyFilter(tab.getAttribute('data-cat'));
    });
  });

  /* ================= QUOTE BUILDER ================= */
  var quoteBar   = document.getElementById('vcQuoteBar');
  var countEl    = document.getElementById('vcQuoteCount');
  var pluralEl   = document.getElementById('vcQuotePlural');
  var totalEl    = document.getElementById('vcQuoteTotal');
  var clearBtn   = document.getElementById('vcQuoteClear');
  var bookBtn    = document.getElementById('vcQuoteBookBtn');
  var checkboxes = document.querySelectorAll('.vc-select-checkbox');

  function selectedCards() {
    var selected = [];
    checkboxes.forEach(function (cb) {
      if (cb.checked) selected.push(cb.closest('.vc-card'));
    });
    return selected;
  }

  function updateQuote() {
    var selected = selectedCards();
    var total = 0;

    selected.forEach(function (card) {
      var price = parseFloat(card.getAttribute('data-price'));
      if (!isNaN(price)) total += price;
      card.classList.add('vc-card-selected');
    });
    cards.forEach(function (card) {
      if (selected.indexOf(card) === -1) card.classList.remove('vc-card-selected');
    });

    if (selected.length > 0) total += VC_VACCINATION_CHARGE;

    countEl.textContent = selected.length;
    pluralEl.textContent = selected.length === 1 ? '' : 's';
    totalEl.textContent = total.toLocaleString();

    quoteBar.classList.toggle('visible', selected.length > 0);

    if (selected.length > 0) {
      var lines = selected.map(function (card) {
        var price = parseFloat(card.getAttribute('data-price'));
        var priceText = !isNaN(price) ? 'PKR ' + price.toLocaleString() : 'Contact for price';
        return '- ' + card.getAttribute('data-title') + ' (' + card.getAttribute('data-vaccine') + ') - ' + priceText;
      });
      var message = 'Hi! I would like to book the following vaccines:\n\n' +
        lines.join('\n') +
        '\n\n+ PKR ' + VC_VACCINATION_CHARGE.toLocaleString() + ' home vaccination charge' +
        '\nTotal: PKR ' + total.toLocaleString();
      bookBtn.href = 'https://wa.me/' + VC_WHATSAPP + '?text=' + encodeURIComponent(message);
    } else {
      bookBtn.href = '#';
    }
  }

  checkboxes.forEach(function (cb) {
    cb.addEventListener('change', updateQuote);
  });

  clearBtn.addEventListener('click', function () {
    checkboxes.forEach(function (cb) { cb.checked = false; });
    updateQuote();
  });
});
</script>

<?php get_footer(); ?>
