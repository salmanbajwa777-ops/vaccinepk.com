<?php
/**
 * Template Name: Vaccination Schedule Page
 *
 * Immunization schedule with an EPI-covered vs. private-only breakdown.
 * Data source: vaccinepk_immunization_schedule_data() in functions.php.
 */
get_header();

$age_groups = function_exists( 'vaccinepk_immunization_schedule_data' ) ? vaccinepk_immunization_schedule_data() : [];

$total     = 0;
$epi_count = 0;
foreach ( $age_groups as $group ) {
    foreach ( $group['vaccines'] as $v ) {
        $total++;
        if ( ! empty( $v['epi'] ) ) $epi_count++;
    }
}
?>

<style>
.isched-wrap { max-width: 920px; margin: 0 auto; padding: 0 24px; }

.isched-hero {
    background: linear-gradient(160deg, var(--color-navy) 0%, #0e3446 55%, var(--color-navy) 100%);
    color: var(--color-white);
    padding: 56px 0 44px;
}
.isched-hero h1 { font-size: 2rem; font-weight: 700; line-height: 1.25; margin: 0 0 12px; max-width: 620px; }
.isched-hero p { font-size: 1rem; line-height: 1.6; color: var(--color-ink-on-navy); max-width: 560px; margin: 0 0 24px; }

.isched-stats { display: flex; gap: 14px; flex-wrap: wrap; }
.isched-stat {
    background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.14);
    border-radius: 12px; padding: 14px 20px; min-width: 160px;
}
.isched-stat .n { font-size: 1.5rem; font-weight: 700; color: var(--color-white); }
.isched-stat .l { font-size: .8rem; color: var(--color-ink-on-navy); margin-top: 2px; }

.isched-controls {
    display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap;
    gap: 12px; margin: 32px 0 16px;
}
.isched-filters { display: flex; flex-wrap: wrap; gap: 8px; }
.isched-fbtn {
    border: 1.5px solid var(--color-sand); background: var(--color-white); color: var(--color-ink);
    font-size: .82rem; font-weight: 600; padding: 7px 16px; border-radius: 50px; cursor: pointer;
    transition: all .2s ease;
}
.isched-fbtn:hover { border-color: var(--color-blue); color: var(--color-blue); }
.isched-fbtn.active { background: var(--color-navy); color: var(--color-white); border-color: var(--color-navy); }

.isched-legend { display: flex; gap: 18px; font-size: .8rem; color: var(--color-ink); }
.isched-legend .dot { display: inline-block; width: 8px; height: 8px; border-radius: 50%; margin-right: 6px; }
.isched-legend .dot.epi { background: var(--color-green); }
.isched-legend .dot.gap { background: var(--color-gold); }

.isched-table {
    background: var(--color-white); border: 1px solid var(--color-sand);
    border-radius: 14px; overflow: hidden; margin-bottom: 36px; box-shadow: var(--shadow-sm);
}
.isched-agehead {
    background: var(--color-ivory); padding: 11px 22px; font-size: .8rem; font-weight: 700;
    color: var(--color-navy); border-top: 1px solid var(--color-sand); letter-spacing: .02em;
}
.isched-agehead:first-child { border-top: none; }

.isched-row {
    display: grid; grid-template-columns: 1fr 1fr 120px; gap: 10px; align-items: center;
    padding: 12px 22px; border-top: 1px solid var(--color-sand);
}
.isched-row .name { font-weight: 600; color: var(--color-ink-strong); font-size: .92rem; }
.isched-row .disease { font-size: .8rem; color: var(--color-label-muted); }
.isched-row .badge {
    font-size: .75rem; font-weight: 700; border-radius: 50px; padding: 5px 12px; text-align: center;
}
.isched-row .badge.epi { background: var(--color-green-tint); color: #1e6b3d; }
.isched-row .badge.gap { background: #fcefdc; color: #8a5a0b; }

.isched-cta {
    background: var(--color-blue-tint); border: 1px solid var(--color-sand); border-radius: 14px;
    padding: 24px 28px; margin-bottom: 48px; display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 16px;
}
.isched-cta h3 { margin: 0 0 4px; font-size: 1.05rem; color: var(--color-navy); }
.isched-cta p { margin: 0; font-size: .88rem; color: var(--color-ink); }
.isched-cta .btn {
    background: var(--color-navy); color: var(--color-white); border: none; padding: 12px 24px;
    border-radius: 8px; font-size: .9rem; font-weight: 600; text-decoration: none; white-space: nowrap;
}
.isched-cta .btn:hover { background: var(--color-blue); color: var(--color-white); }

@media (max-width: 600px) {
    .isched-row { grid-template-columns: 1fr auto; }
    .isched-row .disease { display: none; }
}
</style>

<div class="isched-hero">
  <div class="isched-wrap">
    <h1>Your child's immunization schedule — and what govt. EPI doesn't cover</h1>
    <p>Pakistan's Expanded Programme on Immunization (EPI) provides a core set of vaccines free at government centers. This schedule shows every recommended vaccine for kids living in Pakistan, and marks exactly where EPI leaves gaps.</p>
    <div class="isched-stats">
      <div class="isched-stat">
        <div class="n"><?php echo esc_html( $epi_count ); ?> of <?php echo esc_html( $total ); ?></div>
        <div class="l">vaccines covered by govt EPI</div>
      </div>
      <div class="isched-stat">
        <div class="n"><?php echo esc_html( $total - $epi_count ); ?></div>
        <div class="l">only available privately</div>
      </div>
    </div>
  </div>
</div>

<div class="isched-wrap">
  <div class="isched-controls">
    <div class="isched-filters">
      <button class="isched-fbtn active" data-f="all">All vaccines</button>
      <button class="isched-fbtn" data-f="epi">EPI only</button>
      <button class="isched-fbtn" data-f="gap">Gaps only</button>
    </div>
    <div class="isched-legend">
      <span><span class="dot epi"></span>Covered by EPI</span>
      <span><span class="dot gap"></span>Not in EPI</span>
    </div>
  </div>

  <div class="isched-table">
    <?php foreach ( $age_groups as $group ) : ?>
      <div class="isched-agehead" id="<?php echo esc_attr( $group['slug'] ); ?>"><?php echo esc_html( $group['label'] ); ?></div>
      <?php foreach ( $group['vaccines'] as $v ) :
          $is_epi = ! empty( $v['epi'] );
      ?>
        <div class="isched-row" data-epi="<?php echo $is_epi ? 'epi' : 'gap'; ?>">
          <span class="name"><?php echo esc_html( $v['name'] ); ?></span>
          <span class="disease"><?php echo esc_html( $v['disease'] ); ?></span>
          <span class="badge <?php echo $is_epi ? 'epi' : 'gap'; ?>">
            <?php echo $is_epi ? 'In EPI' : 'Not in EPI'; ?>
          </span>
        </div>
      <?php endforeach; ?>
    <?php endforeach; ?>
  </div>

  <div class="isched-cta">
    <div>
      <h3>Cover the gaps in one visit</h3>
      <p>Book a home appointment for any vaccine EPI doesn't provide.</p>
    </div>
    <a href="<?php echo esc_url( site_url( '/booking' ) ); ?>" class="btn">Book now</a>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.isched-fbtn').forEach(function (btn) {
    btn.addEventListener('click', function () {
      document.querySelectorAll('.isched-fbtn').forEach(function (b) { b.classList.remove('active'); });
      btn.classList.add('active');
      var f = btn.dataset.f;

      document.querySelectorAll('.isched-row').forEach(function (row) {
        row.style.display = (f === 'all' || row.dataset.epi === f) ? '' : 'none';
      });

      document.querySelectorAll('.isched-agehead').forEach(function (head) {
        var hasVisible = false;
        var el = head.nextElementSibling;
        while (el && !el.classList.contains('isched-agehead')) {
          if (el.style.display !== 'none') hasVisible = true;
          el = el.nextElementSibling;
        }
        head.style.display = hasVisible ? '' : 'none';
      });
    });
  });
});
</script>

<?php get_footer(); ?>
