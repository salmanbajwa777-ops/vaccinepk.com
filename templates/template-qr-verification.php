<?php
/**
 * Template Name: QR Verification Page
 * Template Post Type: page
 *
 * Minimal travel verification page:
 * - Enter MR No
 * - Submit
 * - Display existing verification output (same as QR flow)
 *
 * @package VaccinationCentre
 */

get_header();

$mr_input = isset($_GET['mr']) ? sanitize_text_field(wp_unslash($_GET['mr'])) : '';
$child_id = 0;
$error_message = '';
$verification_url = '';
$record_type = '';

if ($mr_input !== '') {
    $mr_compact = preg_replace('/\s+/', '', $mr_input);

    // Travel MR is year-prefixed with separator, e.g. 26-16472 or 2026-16472.
    if (preg_match('/^(?:\d{2}|\d{4})[-_](\d{3,})$/', $mr_compact, $matches)) {
        $child_id = (int) $matches[1];
        $record_type = 'travel';
    } elseif (preg_match('/^(\d{1,})$/', $mr_compact, $matches)) {
        // Schedule MR in PDF is now raw child ID.
        $child_id = (int) $matches[1];
        $record_type = 'schedule';
    } elseif (preg_match('/(\d{3,})$/', $mr_compact, $matches)) {
        // Fallback: extract trailing ID and treat as schedule lookup.
        $child_id = (int) $matches[1];
        $record_type = 'schedule';
    }

    if ($child_id > 0) {
        if ($record_type === 'travel') {
            $verification_url = sprintf(
                'https://myapi.vaccinepk.com/api/Child/Travel-PDF-Download/%d',
                $child_id
            );
        } else {
            $verification_url = sprintf(
                'https://myapi.vaccinepk.com/api/Child/%d/Download-Schedule-PDF',
                $child_id
            );
        }
    } else {
        $error_message = 'Please enter a valid MR No.';
    }
}
?>

<style>
.vc-simple-verify {
    max-width: 920px;
    margin: 40px auto;
    padding: 0 16px;
    font-family: Arial, sans-serif;
}
.vc-simple-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 20px;
}
.vc-simple-title {
    margin: 0 0 8px;
    font-size: 26px;
}
.vc-simple-subtitle {
    margin: 0 0 16px;
    color: #6b7280;
}
.vc-simple-form {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 12px;
}
.vc-simple-input {
    flex: 1;
    min-width: 240px;
    padding: 11px 12px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    font-size: 15px;
}
.vc-simple-btn {
    padding: 11px 16px;
    border: 0;
    border-radius: 8px;
    background: #0b4f6c;
    color: #fff;
    font-weight: 600;
    cursor: pointer;
}
.vc-simple-error {
    color: #b91c1c;
    margin: 8px 0 0;
}
.vc-simple-note {
    color: #6b7280;
    font-size: 13px;
    margin-top: 6px;
}
.vc-simple-result {
    margin-top: 18px;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    overflow: hidden;
    background: #fff;
}
.vc-simple-result iframe {
    width: 100%;
    height: 860px;
    border: 0;
}
</style>

<div class="vc-simple-verify">
    <div class="vc-simple-card">
        <h1 class="vc-simple-title">Verification</h1>
        <p class="vc-simple-subtitle">Enter MR No to view travel or schedule verification record.</p>

        <form class="vc-simple-form" method="get" action="">
            <input
                class="vc-simple-input"
                type="text"
                name="mr"
                placeholder="Enter MR No (e.g. 2026-16472 or 16472)"
                value="<?php echo esc_attr($mr_input); ?>"
                required
            >
            <button class="vc-simple-btn" type="submit">Submit</button>
        </form>

        <?php if ($error_message !== '') : ?>
            <p class="vc-simple-error"><?php echo esc_html($error_message); ?></p>
        <?php endif; ?>

        <p class="vc-simple-note">Year-based MR (e.g. 2026-16472) opens travel verification. Raw child ID MR (e.g. 16472) opens schedule verification.</p>

        <?php if ($verification_url !== '') : ?>
            <div class="vc-simple-result">
                <iframe
                    src="<?php echo esc_url($verification_url); ?>"
                    title="Travel Verification Result"
                    loading="lazy"
                ></iframe>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer();
