<?php
/**
 * Template Name: Vaccination Booking (Category Page)
 * Description: Dedicated full-page booking form for one vaccination category
 * (child/adult/travel), replacing the homepage popup modal on mobile.
 * The page slug decides which CF7 form loads — see $slug_to_category below.
 */
get_header();

$slug_to_category = [
    'book-child-vaccination'  => 'child',
    'book-adult-vaccination'  => 'adult',
    'book-travel-vaccination' => 'travel',
];

$form_ids = [
    'child'  => 'd12af79',
    'adult'  => 'b9ff7a4',
    'travel' => 'ed84fa1',
];

$category_labels = [
    'child'  => 'Child Vaccination',
    'adult'  => 'Adult Vaccination',
    'travel' => 'Travel Vaccination',
];

$category_icons = [
    'child'  => 'heart-pulse-fill',
    'adult'  => 'person-hearts',
    'travel' => 'airplane-fill',
];

$category_subs = [
    'child'  => 'Complete immunization schedule for infants and children following WHO & EPI guidelines.',
    'adult'  => 'Essential immunizations for adults including boosters and preventive vaccines.',
    'travel' => 'Pre-travel immunizations for domestic and international destinations.',
];

$slug     = get_post_field( 'post_name', get_the_ID() );
$category = $slug_to_category[ $slug ] ?? 'child';
$form_id  = $form_ids[ $category ];
?>

<!-- ================= PAGE HEADER ================= -->
<section class="page-header" style="background: linear-gradient(160deg, var(--color-navy) 0%, #0e3446 55%, var(--color-navy) 100%); padding: 60px 0 40px; position: relative; overflow: hidden;">
    <div style="position: absolute; top: -50%; right: -10%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(201, 162, 75, 0.14) 0%, transparent 70%); border-radius: 50%;"></div>
    <div style="position: absolute; bottom: -30%; left: -5%; width: 400px; height: 400px; background: radial-gradient(circle, rgba(107, 182, 63, 0.12) 0%, transparent 70%); border-radius: 50%;"></div>

    <div class="container" style="position: relative; z-index: 1;">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb justify-content-center" style="background: transparent;">
                        <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>" style="color: var(--color-sub-on-blue); text-decoration: none;"><i class="bi bi-house-fill"></i> Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo home_url( '/booking' ); ?>" style="color: var(--color-sub-on-blue); text-decoration: none;">Book Vaccination</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: var(--color-ivory);"><?php echo esc_html( $category_labels[ $category ] ); ?></li>
                    </ol>
                </nav>
                <div class="mb-3">
                    <i class="bi bi-<?php echo esc_attr( $category_icons[ $category ] ); ?>" style="font-size: 44px; color: var(--color-gold);"></i>
                </div>
                <h1 class="fw-bold mb-3" style="font-family: var(--font-display); font-size: 2rem; color: var(--color-ivory);"><?php echo esc_html( $category_labels[ $category ] ); ?> Booking</h1>
                <p class="mb-0" style="color: var(--color-sub-on-blue); max-width: 56ch; margin-inline: auto;"><?php echo esc_html( $category_subs[ $category ] ); ?></p>
            </div>
        </div>
    </div>
</section>

<!-- ================= BOOKING FORM ================= -->
<section class="py-5" style="background: var(--color-ivory);">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div id="vb-form-wrap">
                    <?php echo do_shortcode( '[contact-form-7 id="' . esc_attr( $form_id ) . '"]' ); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Styles: same field/scrollbar/select treatment already proven on the booking modal -->
<style>
#vb-form-wrap .wpcf7-form {
    background: white;
    padding: 32px;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

#vb-form-wrap .wpcf7-form p {
    margin-bottom: 20px;
}

#vb-form-wrap .wpcf7-form label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #16232b;
}

#vb-form-wrap .wpcf7-form input[type="text"],
#vb-form-wrap .wpcf7-form input[type="email"],
#vb-form-wrap .wpcf7-form input[type="tel"],
#vb-form-wrap .wpcf7-form input[type="date"],
#vb-form-wrap .wpcf7-form textarea,
#vb-form-wrap .wpcf7-form select {
    width: 100%;
    height: 48px;
    padding: 12px 15px;
    border: 2px solid #e7e0d3;
    border-radius: 8px;
    font-size: 15px;
    line-height: 1.4;
    font-family: inherit;
    box-sizing: border-box;
    -webkit-appearance: none;
    appearance: none;
    background-color: #fff;
    transition: all 0.3s;
}

#vb-form-wrap .wpcf7-form select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='%2316232b' d='M4 6l4 4 4-4z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 15px center;
    padding-right: 40px;
}

#vb-form-wrap .wpcf7-form textarea {
    height: auto;
    min-height: 100px;
}

#vb-form-wrap .wpcf7-form input[type="date"]::-webkit-calendar-picker-indicator {
    filter: invert(0.4);
    cursor: pointer;
}

#vb-form-wrap .wpcf7-form input[type="text"]:focus,
#vb-form-wrap .wpcf7-form input[type="email"]:focus,
#vb-form-wrap .wpcf7-form input[type="tel"]:focus,
#vb-form-wrap .wpcf7-form input[type="date"]:focus,
#vb-form-wrap .wpcf7-form textarea:focus,
#vb-form-wrap .wpcf7-form select:focus {
    border-color: #0b5c87;
    outline: none;
    box-shadow: 0 0 0 3px rgba(11, 92, 135, 0.1);
}

#vb-form-wrap .wpcf7-form input[type="submit"] {
    width: 100%;
    background: #0a2a38;
    color: white;
    border: none;
    padding: 15px 40px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

#vb-form-wrap .wpcf7-form input[type="submit"]:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(11, 92, 135, 0.3);
}

#vb-form-wrap .wpcf7-not-valid-tip {
    color: #dc2626;
    font-size: 13px;
    margin-top: 5px;
}

#vb-form-wrap .wpcf7-response-output {
    margin: 20px 0 0 0;
    padding: 15px;
    border-radius: 8px;
    border: 2px solid;
}

#vb-form-wrap .wpcf7-mail-sent-ok {
    border-color: #10b981;
    background-color: #d1fae5;
    color: #065f46;
}

#vb-form-wrap .wpcf7-validation-errors,
#vb-form-wrap .wpcf7-mail-sent-ng {
    border-color: #ef4444;
    background-color: #fee2e2;
    color: #991b1b;
}

@media (max-width: 576px) {
    #vb-form-wrap .wpcf7-form {
        padding: 18px;
    }
}

/* ================= DOB picker: trigger field ================= */
.dob-trigger{
    width: 100%; height: 48px; padding: 12px 15px; border: 2px solid #e7e0d3; border-radius: 8px;
    font-size: 15px; font-family: inherit; background: #fff; color: #16232b; cursor: pointer;
    display: flex; align-items: center; justify-content: space-between; text-align: left;
    transition: all 0.3s; font-variant-numeric: tabular-nums;
}
.dob-trigger:hover { border-color: #0b5c87; }
.dob-trigger.is-open { border-color: #0b5c87; outline: none; box-shadow: 0 0 0 3px rgba(11,92,135,.1); }
.dob-trigger .dob-trigger-ph { color: #9aa4ab; }
.dob-trigger svg { color: #0b5c87; flex-shrink: 0; margin-left: 10px; }

/* ================= DOB picker: dialog ================= */
.dob-backdrop{
    position: fixed; inset: 0; background: rgba(10,20,28,.5); backdrop-filter: blur(2px);
    display: flex; align-items: center; justify-content: center; z-index: 9999;
    opacity: 0; pointer-events: none; transition: opacity .18s; padding: 20px;
}
.dob-backdrop.open { opacity: 1; pointer-events: auto; }
.dob-dialog{
    width: 340px; max-width: 100%; background: #fff; border-radius: 20px;
    box-shadow: 0 20px 50px rgba(10,42,56,.28); overflow: hidden;
    transform: scale(.94) translateY(8px); opacity: 0;
    transition: transform .2s cubic-bezier(.2,.9,.3,1.2), opacity .18s;
}
.dob-backdrop.open .dob-dialog { transform: scale(1) translateY(0); opacity: 1; }
.dob-header{
    background: linear-gradient(155deg, #0a2a38 0%, #0e3446 100%);
    color: #fff; padding: 18px 20px 16px;
}
.dob-header-label{ font-size: 11px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: rgba(255,255,255,.6); margin-bottom: 6px; }
.dob-header-value{ font-size: 24px; font-weight: 700; letter-spacing: -.01em; min-height: 30px; }
.dob-header-value .placeholder{ color: rgba(255,255,255,.4); }
.dob-crumbs{ display: flex; align-items: center; flex-wrap: wrap; gap: 4px; margin-top: 10px; }
.dob-crumb{
    background: none; border: none; color: rgba(255,255,255,.55); font-size: 12.5px; font-weight: 700;
    padding: 2px 4px; cursor: pointer; border-radius: 5px; transition: color .15s, background .15s;
    font-variant-numeric: tabular-nums;
}
.dob-crumb:hover { color: #fff; background: rgba(255,255,255,.12); }
.dob-crumb.current { color: #fff; cursor: default; }
.dob-crumb.current:hover { background: none; }
.dob-crumb-sep{ color: rgba(255,255,255,.35); font-size: 11px; }
.dob-toolbar{ display: flex; align-items: center; gap: 6px; padding: 12px 10px 4px; min-height: 44px; }
.dob-nav-btn{
    width: 34px; height: 34px; border: none; border-radius: 50%; background: transparent;
    color: #16232b; display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: background .15s; flex-shrink: 0;
}
.dob-nav-btn:hover { background: #e8f1f5; }
.dob-nav-btn:disabled { opacity: .3; cursor: default; background: none; }
.dob-toolbar-title{ font-size: 15px; font-weight: 700; color: #16232b; flex: 1; text-align: center; padding-right: 34px; }
.dob-body{ position: relative; min-height: 308px; padding: 0 16px 18px; }
.dob-grid-3{ display: grid; grid-template-columns: repeat(3,1fr); gap: 8px; padding-top: 6px; }
.dob-tile{
    border: none; border-radius: 12px; background: #faf7f0; color: #16232b;
    font-size: 14px; font-weight: 700; padding: 16px 6px; cursor: pointer;
    transition: background .15s, color .15s; font-variant-numeric: tabular-nums; font-family: inherit;
}
.dob-tile:hover:not(:disabled) { background: #e8f1f5; }
.dob-tile:disabled { opacity: .35; cursor: not-allowed; }
.dob-tile .sub{ display: block; font-size: 10.5px; font-weight: 600; color: #9aa4ab; margin-top: 2px; }
.dob-tile.year.is-current-year{ box-shadow: inset 0 0 0 2px #c9a24b; }
.dob-tile.month{ padding: 18px 6px; }
.dob-cal{ padding-top: 2px; }
.dob-weekdays{ display: grid; grid-template-columns: repeat(7,1fr); margin-bottom: 4px; }
.dob-weekdays span{ text-align: center; font-size: 11px; font-weight: 700; color: #9aa4ab; padding: 6px 0; }
.dob-days{ display: grid; grid-template-columns: repeat(7,1fr); row-gap: 2px; }
.dob-day{
    aspect-ratio: 1; display: flex; align-items: center; justify-content: center;
    border: none; background: none; border-radius: 50%; font-size: 13.5px; color: #16232b;
    cursor: pointer; position: relative; font-variant-numeric: tabular-nums; font-family: inherit;
}
.dob-day:hover:not(:disabled):not(.selected) { background: #e8f1f5; }
.dob-day.outside { color: #9aa4ab; opacity: .45; }
.dob-day.today { color: #0b5c87; font-weight: 800; }
.dob-day.today::after{
    content: ""; position: absolute; bottom: 5px; left: 50%; translate: -50% 0;
    width: 4px; height: 4px; border-radius: 50%; background: #c9a24b;
}
.dob-day.selected { background: #0b5c87; color: #fff; font-weight: 700; }
.dob-day:disabled { opacity: .25; cursor: not-allowed; }
.dob-level-enter{ animation: dobLevelIn .18s ease-out; }
@keyframes dobLevelIn{ from{ opacity: 0; transform: translateX(14px); } to{ opacity: 1; transform: translateX(0); } }
.dob-footer{ display: flex; justify-content: flex-end; gap: 8px; padding: 10px 16px 16px; border-top: 1px solid #e7e0d3; }
.dob-btn{
    border: none; background: none; font-weight: 700; font-size: 13.5px; padding: 10px 16px;
    border-radius: 8px; cursor: pointer; transition: background .15s; color: #9aa4ab; font-family: inherit;
}
.dob-btn:hover { background: #e7e0d3; }
.dob-btn.primary { color: #0b5c87; }
.dob-btn.primary:disabled { opacity: .4; cursor: not-allowed; background: none; }
@media (prefers-reduced-motion: reduce) {
    .dob-dialog, .dob-backdrop, .dob-level-enter { transition: none; animation: none; }
}
</style>

<!-- Custom date-of-birth picker: replaces the CF7 form's native <input type="date">
     (a raw OS/browser calendar widget) with a decade → year → month → day drill-down
     dialog matching the site's navy/gold/blue design. Finds the date input generically
     so it keeps working even if the CF7 field is renamed in wp-admin. -->
<script>
(function () {
    var MONTH_NAMES = ["January","February","March","April","May","June","July","August","September","October","November","December"];
    var MONTH_SHORT  = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
    var today = new Date();

    function pad(n) { return n < 10 ? '0' + n : '' + n; }

    function enhanceDateInput(nativeInput) {
        if (nativeInput.dataset.dobEnhanced) return;
        nativeInput.dataset.dobEnhanced = '1';

        var minAttr = nativeInput.getAttribute('min');
        var maxAttr = nativeInput.getAttribute('max');
        var minYear = minAttr ? parseInt(minAttr.slice(0, 4), 10) : today.getFullYear() - 110;
        var maxYear = maxAttr ? parseInt(maxAttr.slice(0, 4), 10) : today.getFullYear();
        var minDecade = Math.floor(minYear / 10) * 10;
        var maxDecade = Math.floor(maxYear / 10) * 10;

        // Hide the native input but keep it in the DOM/tab order untouched for CF7's
        // own validation and submission — the trigger button only drives its value.
        nativeInput.style.position = 'absolute';
        nativeInput.style.opacity = '0';
        nativeInput.style.width = '1px';
        nativeInput.style.height = '1px';
        nativeInput.style.pointerEvents = 'none';
        nativeInput.tabIndex = -1;

        var trigger = document.createElement('button');
        trigger.type = 'button';
        trigger.className = 'dob-trigger';
        trigger.innerHTML = '<span class="dob-trigger-ph">dd/mm/yyyy</span>' +
            '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M3 10h18M8 2v4M16 2v4"/></svg>';
        nativeInput.insertAdjacentElement('afterend', trigger);
        var triggerText = trigger.querySelector('span');

        var backdrop = document.createElement('div');
        backdrop.className = 'dob-backdrop';
        backdrop.innerHTML =
            '<div class="dob-dialog" role="dialog" aria-modal="true" aria-label="Choose date of birth">' +
                '<div class="dob-header">' +
                    '<div class="dob-header-label">Date of birth</div>' +
                    '<div class="dob-header-value"><span class="placeholder">Select a date</span></div>' +
                    '<div class="dob-crumbs"></div>' +
                '</div>' +
                '<div class="dob-toolbar">' +
                    '<button type="button" class="dob-nav-btn" aria-label="Back"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg></button>' +
                    '<div class="dob-toolbar-title">Select decade</div>' +
                '</div>' +
                '<div class="dob-body"></div>' +
                '<div class="dob-footer">' +
                    '<button type="button" class="dob-btn dob-cancel">Cancel</button>' +
                    '<button type="button" class="dob-btn primary dob-ok" disabled>OK</button>' +
                '</div>' +
            '</div>';
        document.body.appendChild(backdrop);

        var headerVal    = backdrop.querySelector('.dob-header-value');
        var crumbsEl      = backdrop.querySelector('.dob-crumbs');
        var toolbarTitle = backdrop.querySelector('.dob-toolbar-title');
        var backBtn      = backdrop.querySelector('.dob-nav-btn');
        var body         = backdrop.querySelector('.dob-body');
        var okBtn        = backdrop.querySelector('.dob-ok');
        var cancelBtn    = backdrop.querySelector('.dob-cancel');

        var state = { level: 'decade', decade: null, year: null, month: null, pending: null, selected: null };

        function parseExisting() {
            var v = nativeInput.value; // native input holds yyyy-mm-dd
            if (!v || !/^\d{4}-\d{2}-\d{2}$/.test(v)) return null;
            var parts = v.split('-');
            return { y: parseInt(parts[0], 10), m: parseInt(parts[1], 10) - 1, d: parseInt(parts[2], 10) };
        }

        function openDialog() {
            var existing = parseExisting();
            if (existing) {
                state.selected = existing;
                state.decade = Math.floor(existing.y / 10) * 10;
                state.year = existing.y;
                state.month = existing.m;
                state.pending = existing;
                state.level = 'day';
            } else {
                state.decade = null; state.year = null; state.month = null;
                state.pending = null;
                state.level = 'decade';
            }
            render();
            backdrop.classList.add('open');
            trigger.classList.add('is-open');
            document.addEventListener('keydown', onKeydown);
        }
        function closeDialog() {
            backdrop.classList.remove('open');
            trigger.classList.remove('is-open');
            document.removeEventListener('keydown', onKeydown);
        }
        function onKeydown(e) {
            if (e.key === 'Escape') closeDialog();
            if (e.key === 'Backspace' && state.level !== 'decade') goBack();
        }
        function goBack() {
            if (state.level === 'year') state.level = 'decade';
            else if (state.level === 'month') state.level = 'year';
            else if (state.level === 'day') state.level = 'month';
            render();
        }

        function renderHeaderValue() {
            if (state.pending) {
                var d = new Date(state.pending.y, state.pending.m, state.pending.d);
                var wd = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'][d.getDay()];
                headerVal.textContent = wd + ', ' + MONTH_SHORT[state.pending.m] + ' ' + state.pending.d + ', ' + state.pending.y;
                okBtn.disabled = false;
            } else {
                headerVal.innerHTML = '<span class="placeholder">Select a date</span>';
                okBtn.disabled = true;
            }
        }

        function renderCrumbs() {
            var parts = [];
            if (state.decade !== null) parts.push({ label: state.decade + 's', level: 'decade' });
            if (state.year !== null && (state.level === 'month' || state.level === 'day')) parts.push({ label: '' + state.year, level: 'year' });
            if (state.month !== null && state.level === 'day') parts.push({ label: MONTH_SHORT[state.month], level: 'month' });
            crumbsEl.innerHTML = '';
            parts.forEach(function (p, i) {
                if (i > 0) {
                    var sep = document.createElement('span');
                    sep.className = 'dob-crumb-sep';
                    sep.textContent = '›';
                    crumbsEl.appendChild(sep);
                }
                var isCurrent = p.level === state.level;
                var btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'dob-crumb' + (isCurrent ? ' current' : '');
                btn.textContent = p.label;
                if (!isCurrent) btn.addEventListener('click', function () { state.level = p.level; render(); });
                crumbsEl.appendChild(btn);
            });
        }

        function renderToolbar() {
            backBtn.disabled = (state.level === 'decade');
            var titles = {
                decade: 'Select decade',
                year: 'Select year',
                month: 'Select month',
                day: state.month !== null ? MONTH_NAMES[state.month] + ' ' + state.year : 'Select day'
            };
            toolbarTitle.textContent = titles[state.level];
        }

        function mountLevel(el) {
            body.innerHTML = '';
            el.classList.add('dob-level-enter');
            body.appendChild(el);
        }

        function renderDecadeLevel() {
            var wrap = document.createElement('div');
            wrap.className = 'dob-grid-3';
            for (var dec = maxDecade; dec >= minDecade; dec -= 10) {
                var lo = Math.max(dec, minYear), hi = Math.min(dec + 9, maxYear);
                var btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'dob-tile';
                btn.innerHTML = dec + 's<span class="sub">' + lo + '–' + hi + '</span>';
                (function (decade) {
                    btn.addEventListener('click', function () { state.decade = decade; state.level = 'year'; render(); });
                })(dec);
                wrap.appendChild(btn);
            }
            mountLevel(wrap);
        }

        function renderYearLevel() {
            var wrap = document.createElement('div');
            wrap.className = 'dob-grid-3';
            var lo = Math.max(state.decade, minYear), hi = Math.min(state.decade + 9, maxYear);
            for (var y = hi; y >= lo; y--) {
                var btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'dob-tile year' + (y === today.getFullYear() ? ' is-current-year' : '');
                btn.textContent = y;
                (function (year) {
                    btn.addEventListener('click', function () { state.year = year; state.level = 'month'; render(); });
                })(y);
                wrap.appendChild(btn);
            }
            mountLevel(wrap);
        }

        function renderMonthLevel() {
            var wrap = document.createElement('div');
            wrap.className = 'dob-grid-3';
            MONTH_SHORT.forEach(function (name, i) {
                var isFuture = state.year === today.getFullYear() && i > today.getMonth();
                var btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'dob-tile month';
                btn.textContent = name;
                btn.disabled = isFuture;
                btn.addEventListener('click', function () { state.month = i; state.level = 'day'; render(); });
                wrap.appendChild(btn);
            });
            mountLevel(wrap);
        }

        function renderDayLevel() {
            var wrap = document.createElement('div');
            wrap.className = 'dob-cal';

            var weekdays = document.createElement('div');
            weekdays.className = 'dob-weekdays';
            ['S','M','T','W','T','F','S'].forEach(function (d) {
                var s = document.createElement('span');
                s.textContent = d;
                weekdays.appendChild(s);
            });
            wrap.appendChild(weekdays);

            var grid = document.createElement('div');
            grid.className = 'dob-days';

            var y = state.year, m = state.month;
            var firstDow = new Date(y, m, 1).getDay();
            var daysInMonth = new Date(y, m + 1, 0).getDate();
            var daysInPrevMonth = new Date(y, m, 0).getDate();

            var cells = [];
            for (var i = firstDow - 1; i >= 0; i--) cells.push({ d: daysInPrevMonth - i, outside: true, dir: -1 });
            for (var d = 1; d <= daysInMonth; d++) cells.push({ d: d, outside: false });
            var trail = 1;
            while (cells.length % 7 !== 0 || cells.length < 42) {
                cells.push({ d: trail++, outside: true, dir: 1 });
                if (cells.length >= 42) break;
            }

            cells.forEach(function (cell) {
                var btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'dob-day' + (cell.outside ? ' outside' : '');
                btn.textContent = cell.d;

                var cy = y, cm = m;
                if (cell.outside) {
                    cm = m + cell.dir;
                    cy = y;
                    if (cm < 0) { cm = 11; cy = y - 1; }
                    if (cm > 11) { cm = 0; cy = y + 1; }
                }

                var cellDate = new Date(cy, cm, cell.d);
                var isFuture = cellDate > today;
                var isToday = cellDate.toDateString() === today.toDateString();
                var isSelected = state.pending && state.pending.y === cy && state.pending.m === cm && state.pending.d === cell.d;

                if (isToday) btn.classList.add('today');
                if (isSelected) btn.classList.add('selected');
                if (isFuture || cy < minYear) btn.disabled = true;

                btn.addEventListener('click', function () {
                    state.pending = { y: cy, m: cm, d: cell.d };
                    if (cell.outside) {
                        state.year = cy; state.month = cm;
                        state.decade = Math.floor(cy / 10) * 10;
                        render();
                    } else {
                        renderHeaderValue();
                        renderCrumbs();
                        grid.querySelectorAll('.dob-day').forEach(function (b) { b.classList.remove('selected'); });
                        btn.classList.add('selected');
                    }
                });
                grid.appendChild(btn);
            });

            wrap.appendChild(grid);
            mountLevel(wrap);
        }

        function render() {
            renderHeaderValue();
            renderCrumbs();
            renderToolbar();
            if (state.level === 'decade') renderDecadeLevel();
            else if (state.level === 'year') renderYearLevel();
            else if (state.level === 'month') renderMonthLevel();
            else renderDayLevel();
        }

        okBtn.addEventListener('click', function () {
            if (!state.pending) return;
            state.selected = state.pending;
            var sel = state.selected;
            triggerText.textContent = pad(sel.d) + '/' + pad(sel.m + 1) + '/' + sel.y;
            triggerText.classList.remove('dob-trigger-ph');
            // Native input keeps yyyy-mm-dd so CF7's own [date] validation/mail-tags still work.
            nativeInput.value = sel.y + '-' + pad(sel.m + 1) + '-' + pad(sel.d);
            nativeInput.dispatchEvent(new Event('change', { bubbles: true }));
            closeDialog();
        });
        cancelBtn.addEventListener('click', closeDialog);
        backBtn.addEventListener('click', goBack);
        backdrop.addEventListener('click', function (e) { if (e.target === backdrop) closeDialog(); });
        trigger.addEventListener('click', openDialog);

        // Pre-fill the trigger if the field already had a value (e.g. browser autofill).
        var pre = parseExisting();
        if (pre) {
            triggerText.textContent = pad(pre.d) + '/' + pad(pre.m + 1) + '/' + pre.y;
            triggerText.classList.remove('dob-trigger-ph');
        }
    }

    function enhanceAll() {
        document.querySelectorAll('#vb-form-wrap input[type="date"]').forEach(enhanceDateInput);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', enhanceAll);
    } else {
        enhanceAll();
    }
    // CF7 can re-render the form (e.g. after a validation error response) — re-scan then too.
    document.addEventListener('wpcf7invalid', enhanceAll);
    document.addEventListener('wpcf7mailsent', enhanceAll);
})();
</script>

<?php get_footer(); ?>
