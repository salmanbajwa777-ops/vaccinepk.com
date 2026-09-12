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

/**
 * Direct read-only lookup against the VaccineAPI MySQL database, used to show a PID
 * summary on this page without going through the .NET HTML landing endpoint.
 * Define these in wp-config.php (never hardcode credentials in a template):
 *   VACCINE_DB_HOST, VACCINE_DB_NAME, VACCINE_DB_USER, VACCINE_DB_PASS
 */
function vc_get_pid_record($child_id) {
    if (!defined('VACCINE_DB_HOST') || !defined('VACCINE_DB_NAME') || !defined('VACCINE_DB_USER') || !defined('VACCINE_DB_PASS')) {
        return null;
    }

    $mysqli = @new mysqli(VACCINE_DB_HOST, VACCINE_DB_USER, VACCINE_DB_PASS, VACCINE_DB_NAME);
    if ($mysqli->connect_errno) {
        return null;
    }

    $stmt = $mysqli->prepare(
        'SELECT c.Id, c.Name, c.FatherName, c.DOB, c.CNIC, c.Nationality,
                cl.Name AS ClinicName, cl.RegNo,
                d.DisplayName AS DoctorName
         FROM childs c
         LEFT JOIN clinics cl ON c.ClinicId = cl.Id
         LEFT JOIN doctors d ON cl.DoctorId = d.Id
         WHERE c.Id = ?
         LIMIT 1'
    );
    $stmt->bind_param('i', $child_id);
    $stmt->execute();
    $record = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    $mysqli->close();

    return $record ?: null;
}

$mr_input = isset($_GET['mr']) ? sanitize_text_field(wp_unslash($_GET['mr'])) : '';
$type_input = isset($_GET['type']) ? sanitize_text_field(wp_unslash($_GET['type'])) : '';
$manual_type = isset($_GET['record_type']) ? sanitize_text_field(wp_unslash($_GET['record_type'])) : 'schedule';
$child_id = 0;
$error_message = '';
$verification_url = '';
$record_type = '';
$pid_record = null;

if ($mr_input !== '') {
    $mr_compact = preg_replace('/\s+/', '', $mr_input);

    if ($type_input === 'pid' || $manual_type === 'pid') {
        // QR-embedded PID lookups pass the raw child ID directly via ?type=pid&mr=.
        // Manual entry may instead use the printed "MR # {yy}{childId}" card value,
        // so strip a leading current-year prefix when present.
        if (preg_match('/^(\d{1,})$/', $mr_compact, $matches)) {
            $raw = $matches[1];
            $year_prefix = date('y');
            if (strpos($raw, $year_prefix) === 0 && strlen($raw) > strlen($year_prefix) + 2) {
                $child_id = (int) substr($raw, strlen($year_prefix));
            } else {
                $child_id = (int) $raw;
            }
            $record_type = 'pid';
        } else {
            $error_message = 'Please enter a valid MR No.';
        }
    } elseif (preg_match('/^(?:\d{2}|\d{4})[-_](\d{3,})$/', $mr_compact, $matches)) {
        // Travel MR is year-prefixed with separator, e.g. 26-16472 or 2026-16472.
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
        } elseif ($record_type === 'pid') {
            $verification_url = sprintf(
                'https://myapi.vaccinepk.com/api/Child/PIDPDF/%d',
                $child_id
            );
            $pid_record = vc_get_pid_record($child_id);
            if (!$pid_record) {
                $error_message = 'No PID record found for this MR No.';
                $verification_url = '';
            }
        } else {
            $verification_url = sprintf(
                'https://myapi.vaccinepk.com/api/Child/%d/Download-Schedule-PDF',
                $child_id
            );
        }
    } elseif ($error_message === '') {
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
.vc-simple-select {
    padding: 11px 12px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    font-size: 15px;
    background: #fff;
}
.vc-simple-summary {
    margin-top: 18px;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 14px 16px;
    background: #f9fafb;
}
.vc-simple-summary h2 {
    margin: 0 0 8px;
    font-size: 17px;
}
.vc-simple-summary table {
    width: 100%;
    border-collapse: collapse;
}
.vc-simple-summary td {
    padding: 4px 0;
    font-size: 14px;
    vertical-align: top;
}
.vc-simple-summary td:first-child {
    color: #6b7280;
    width: 140px;
}
</style>

<div class="vc-simple-verify">
    <div class="vc-simple-card">
        <h1 class="vc-simple-title">Verification</h1>
        <p class="vc-simple-subtitle">Enter MR No to view travel, schedule, or PID verification record.</p>

        <form class="vc-simple-form" method="get" action="">
            <input
                class="vc-simple-input"
                type="text"
                name="mr"
                placeholder="Enter MR No (e.g. 2026-16472 or 16472)"
                value="<?php echo esc_attr($mr_input); ?>"
                required
            >
            <select class="vc-simple-select" name="record_type">
                <option value="schedule" <?php selected($manual_type, 'schedule'); ?>>Schedule</option>
                <option value="pid" <?php selected($manual_type, 'pid'); ?>>PID</option>
            </select>
            <button class="vc-simple-btn" type="submit">Submit</button>
        </form>

        <?php if ($error_message !== '') : ?>
            <p class="vc-simple-error"><?php echo esc_html($error_message); ?></p>
        <?php endif; ?>

        <p class="vc-simple-note">Year-based MR (e.g. 2026-16472) opens travel verification. Raw child ID MR opens schedule verification. For a PID card, select "PID" (or scan its QR code directly).</p>

        <?php if ($pid_record) : ?>
            <div class="vc-simple-summary">
                <h2>Immunization Record</h2>
                <table>
                    <tr><td>Name</td><td><?php echo esc_html($pid_record['Name']); ?></td></tr>
                    <tr><td>Father/Guardian</td><td><?php echo esc_html($pid_record['FatherName']); ?></td></tr>
                    <tr><td>Date of Birth</td><td><?php echo esc_html(date('d-M-Y', strtotime($pid_record['DOB']))); ?></td></tr>
                    <tr><td>Passport/ID</td><td><?php echo esc_html($pid_record['CNIC']); ?></td></tr>
                    <tr><td>Clinic</td><td><?php echo esc_html($pid_record['ClinicName']); ?> (<?php echo esc_html($pid_record['RegNo']); ?>)</td></tr>
                    <tr><td>Doctor</td><td><?php echo esc_html($pid_record['DoctorName']); ?></td></tr>
                </table>
            </div>
        <?php endif; ?>

        <?php if ($verification_url !== '') : ?>
            <div class="vc-simple-result">
                <iframe
                    src="<?php echo esc_url($verification_url); ?>"
                    title="Verification Result"
                    loading="lazy"
                ></iframe>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer();
