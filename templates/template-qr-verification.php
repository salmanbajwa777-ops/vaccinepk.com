<?php
/**
 * Template Name: QR Verification Page
 * Template Post Type: page
 *
 * Verification landing for Dr. Salman's QR codes:
 *   /verify/                    -> choose "Verify Vaccination Status" or "Verify Invoice"
 *   /verify/?type=vaccination   -> blank MR form (Schedule / Custom / Travel / PID QR codes)
 *   /verify/?type=invoice       -> blank Invoice No form (invoice QR code)
 * QR codes never prefill a number; the visitor types it and presses "Verify Now".
 *
 * @package VaccinationCentre
 */

get_header();

if (!defined('VC_VERIFY_API')) {
    define('VC_VERIFY_API', 'https://myapi.vaccinationcentre.com/api/Child/');
}

$mr_input   = isset($_GET['mr']) ? sanitize_text_field(wp_unslash($_GET['mr'])) : '';
$inv_input  = isset($_GET['inv']) ? sanitize_text_field(wp_unslash($_GET['inv'])) : '';
$type_input = isset($_GET['type']) ? sanitize_text_field(wp_unslash($_GET['type'])) : '';

// Legacy ?type=pid links (old PID cards) behave as a vaccination lookup.
$view = 'landing';
if ($type_input === 'invoice' || $inv_input !== '') {
    $view = 'invoice';
} elseif ($type_input === 'vaccination' || $type_input === 'pid' || $mr_input !== '') {
    $view = 'vaccination';
}

$error_message = '';
$record = null;
$invoice_url = '';

if ($mr_input !== '') {
    $resp = wp_remote_get(VC_VERIFY_API . 'VerifyRecord?mr=' . rawurlencode($mr_input), array('timeout' => 12));
    $code = is_wp_error($resp) ? 0 : (int) wp_remote_retrieve_response_code($resp);
    $data = $code ? json_decode(wp_remote_retrieve_body($resp), true) : null;
    if ($code === 200 && is_array($data)) {
        $record = array_change_key_case($data, CASE_LOWER);
    } elseif ($code === 404 && is_array($data) && !empty($data['message'])) {
        $error_message = $data['message'];
    } else {
        $error_message = 'Verification is temporarily unavailable. Please try again shortly.';
    }
}

if ($inv_input !== '') {
    $inv_compact = preg_replace('/\s+/', '', $inv_input);
    if (preg_match('/^[A-Za-z0-9_\-]{1,40}$/', $inv_compact)) {
        $api_url = VC_VERIFY_API . 'invoice/' . rawurlencode($inv_compact) . '/invoice-file';
        $resp = wp_remote_get($api_url, array('timeout' => 10, 'limit_response_size' => 2048));
        if (!is_wp_error($resp) && (int) wp_remote_retrieve_response_code($resp) === 200) {
            $invoice_url = $api_url;
        } else {
            $error_message = 'No invoice found for this Invoice No.';
        }
    } else {
        $error_message = 'Please enter a valid Invoice No.';
    }
}

$hero_title = 'VERIFY';
$hero_sub   = $view === 'invoice' ? 'Invoice' : ($view === 'vaccination' ? 'Patient Immunization Record' : 'Vaccination &amp; Invoice');
?>

<style>
.vc-vhero { background: linear-gradient(rgba(11,31,42,.86), rgba(11,31,42,.86)), #24485a; color: #fff; text-align: center; padding: 64px 16px 56px; }
.vc-vhero h1 { margin: 0; font-size: clamp(40px, 8vw, 80px); letter-spacing: .02em; color: #fff; }
.vc-vhero p { margin: 10px 0 0; color: #3d8fb0; font-weight: 700; font-size: clamp(18px, 3vw, 30px); }
.vc-vwrap { max-width: 900px; margin: 48px auto; padding: 0 16px; font-family: inherit; color: #111827; }
.vc-vbar { border: 1px solid #e5e7eb; background: #fafafa; border-radius: 6px 6px 0 0; padding: 18px 20px; }
.vc-vbar.solo { border-radius: 6px; }
.vc-vbar p { margin: 0 0 12px; color: #374151; }
.vc-vform { display: flex; gap: 10px; flex-wrap: wrap; margin: 0; }
.vc-vinput { flex: 1; min-width: 200px; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 16px; background: #fff; }
.vc-vbtn { padding: 12px 22px; border: 0; border-radius: 8px; background: #3d8fb0; color: #fff; font-weight: 700; font-size: 16px; cursor: pointer; }
.vc-vchoices { display: flex; gap: 12px; flex-wrap: wrap; }
.vc-vchoice { flex: 1; min-width: 200px; padding: 22px 16px; text-align: center; text-decoration: none; border: 1px solid #cbd5e1; border-radius: 10px; background: #fff; color: #0b4f6c; font-weight: 700; }
.vc-vback { margin: 0 0 10px; font-size: 14px; }
.vc-vback a { color: #3d8fb0; text-decoration: none; }
.vc-verr { border: 1px solid #e5e7eb; border-top: 0; padding: 20px; color: #7f1d1d; background: #fef2f2; border-radius: 0 0 6px 6px; }
table.vc-rec { width: 100%; border-collapse: collapse; border: 1px solid #e5e7eb; border-top: 0; }
.vc-rec > tbody > tr > th, .vc-rec > tbody > tr > td { padding: 14px; border-top: 1px solid #e5e7eb; text-align: left; vertical-align: top; font-size: 15px; background: transparent; }
.vc-rec > tbody > tr:nth-child(odd) > * { background: #fafafa; }
.vc-rec > tbody > tr > th { width: 190px; font-weight: 700; }
.vc-rec td.vc-status { background: #9ad667 !important; color: #1f3d0b; font-weight: 600; }
.vc-rec td.vc-status.none { background: #f8b4b4 !important; color: #7f1d1d; }
.vc-vscroll { overflow-x: auto; }
table.vc-vt { border-collapse: collapse; width: 100%; min-width: 640px; }
.vc-vt th, .vc-vt td { border: 1px solid #d1d5db; padding: 10px 12px; font-size: 14px; background: #fff; text-align: left; }
.vc-vfoot { color: #6b7280; font-size: 14px; margin: 12px 0; }
.vc-vfoot a { color: #3d8fb0; }
.vc-vresult { margin-top: 18px; border: 1px solid #e5e7eb; border-radius: 10px; overflow: hidden; }
.vc-vresult iframe { width: 100%; height: 860px; border: 0; }

/* Phones (e.g. Samsung 360-412px): stack fields, one card per dose, no sideways scroll */
@media (max-width: 640px) {
    .vc-vhero { padding: 36px 12px; }
    .vc-vwrap { margin: 24px auto; }
    .vc-vform { flex-direction: column; }
    .vc-vinput, .vc-vbtn { width: 100%; min-height: 48px; }
    .vc-rec > tbody > tr { display: block; }
    .vc-rec > tbody > tr > th, .vc-rec > tbody > tr > td { display: block; width: auto; padding: 10px 14px; border-top: 0; }
    .vc-rec > tbody > tr > th { padding-bottom: 0; font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: .04em; }
    .vc-rec > tbody > tr { border-top: 1px solid #e5e7eb; }
    .vc-vscroll { overflow: visible; }
    table.vc-vt, .vc-vt tbody, .vc-vt tr, .vc-vt td { display: block; width: 100%; min-width: 0; }
    .vc-vt thead { display: none; }
    .vc-vt tr { border: 1px solid #d1d5db; border-radius: 8px; margin-bottom: 10px; overflow: hidden; background: #fff; }
    .vc-vt td { border: 0; border-top: 1px solid #f0f0f0; padding: 8px 12px; display: flex; justify-content: space-between; gap: 12px; text-align: right; }
    .vc-vt td::before { content: attr(data-label); color: #6b7280; text-align: left; flex: 0 0 40%; }
    .vc-vt td:first-child { border-top: 0; background: #f3f8fb; font-weight: 700; text-align: left; }
    .vc-vt td:first-child::before { display: none; }
    .vc-vt td.vc-given { font-weight: 700; color: #0b4f6c; }
}
</style>

<div class="vc-vhero"><h1><?php echo esc_html($hero_title); ?></h1><p><?php echo $hero_sub; ?></p></div>

<div class="vc-vwrap">

<?php if ($view === 'landing') : ?>
    <div class="vc-vbar solo">
        <p>What would you like to verify?</p>
        <div class="vc-vchoices">
            <a class="vc-vchoice" href="?type=vaccination">Verify Vaccination Status</a>
            <a class="vc-vchoice" href="?type=invoice">Verify Invoice</a>
        </div>
    </div>

<?php elseif ($view === 'invoice') : ?>
    <p class="vc-vback"><a href="?">&larr; Back</a></p>
    <div class="vc-vbar<?php echo ($error_message === '' && $invoice_url === '') ? ' solo' : ''; ?>">
        <form class="vc-vform" method="get" action="">
            <input type="hidden" name="type" value="invoice">
            <input class="vc-vinput" type="text" name="inv" placeholder="Enter Invoice No" value="<?php echo esc_attr($inv_input); ?>" required>
            <button class="vc-vbtn" type="submit">Verify Now</button>
        </form>
    </div>
    <?php if ($error_message !== '') : ?><div class="vc-verr"><?php echo esc_html($error_message); ?></div><?php endif; ?>
    <?php if ($invoice_url !== '') : ?>
        <div class="vc-vresult"><iframe src="<?php echo esc_url($invoice_url); ?>" title="Invoice Verification Result" loading="lazy"></iframe></div>
    <?php endif; ?>

<?php else : ?>
    <p class="vc-vback"><a href="?">&larr; Back</a></p>
    <div class="vc-vbar<?php echo ($error_message === '' && !$record) ? ' solo' : ''; ?>">
        <form class="vc-vform" method="get" action="">
            <input type="hidden" name="type" value="vaccination">
            <input class="vc-vinput" type="text" name="mr" inputmode="text" placeholder="Enter MR No" value="<?php echo esc_attr($mr_input); ?>" required>
            <button class="vc-vbtn" type="submit">Verify Now</button>
        </form>
    </div>
    <?php if ($error_message !== '') : ?><div class="vc-verr"><?php echo esc_html($error_message); ?></div><?php endif; ?>

    <?php if ($record) :
        $vaccinated = isset($record['status']) && $record['status'] === 'Vaccinated';
        $vaccines = (isset($record['vaccines']) && is_array($record['vaccines'])) ? $record['vaccines'] : array();
    ?>
        <table class="vc-rec"><tbody>
            <tr><th>Status</th><td class="vc-status<?php echo $vaccinated ? '' : ' none'; ?>"><?php echo esc_html($record['status']); ?></td></tr>
            <tr><th>MR No.</th><td><?php echo esc_html($record['mrno']); ?></td></tr>
            <tr><th>Name</th><td><?php echo esc_html($record['name']); ?></td></tr>
            <tr><th>S/D/W/o</th><td><?php echo esc_html($record['fathername']); ?></td></tr>
            <tr><th>Passport</th><td><?php echo esc_html($record['passport']); ?></td></tr>
            <tr><th>City</th><td><?php echo esc_html($record['city']); ?></td></tr>
            <tr><th>Vaccines</th><td>
                <?php if ($vaccines) : ?>
                <div class="vc-vscroll"><table class="vc-vt">
                    <thead><tr><th>Vaccine</th><th>Brand</th><th>Manufacturer</th><th>Batch/Lot</th><th>Date Given</th><th>Validity</th></tr></thead>
                    <tbody>
                    <?php foreach ($vaccines as $v) :
                        $v = array_change_key_case((array) $v, CASE_LOWER); ?>
                        <tr>
                            <td data-label="Vaccine"><?php echo esc_html($v['vaccine']); ?></td>
                            <td data-label="Brand"><?php echo esc_html($v['brand']); ?></td>
                            <td data-label="Manufacturer"><?php echo esc_html($v['manufacturer']); ?></td>
                            <td data-label="Batch/Lot"><?php echo esc_html($v['batchlot']); ?></td>
                            <td data-label="Date Given" class="vc-given"><?php echo esc_html($v['dategiven']); ?></td>
                            <td data-label="Validity"><?php echo esc_html($v['validity']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table></div>
                <?php else : ?>No vaccines recorded.<?php endif; ?>
            </td></tr>
            <tr><th>Physician/Doctor</th><td><?php echo esc_html($record['doctor']); ?></td></tr>
            <tr><th>Center</th><td><?php echo esc_html($record['center']); ?></td></tr>
        </tbody></table>
        <p class="vc-vfoot">If there are &lsquo;no results found&rsquo; please enter a correct / new <a href="?type=vaccination">MR number again.</a></p>
    <?php endif; ?>
<?php endif; ?>

</div>

<?php get_footer();
