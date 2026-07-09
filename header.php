<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Professional vaccination services for children and adults. Safe, convenient, and WHO-compliant immunization at your doorstep.">
<?php wp_head(); ?>
</head>
<?php
$site_settings = pods( 'site_contact_settings' );

$phone     = $site_settings->field( 'phone_number' );
$whatsapp  = $site_settings->field( 'whatsapp_number' );
$email     = $site_settings->field( 'email_address' );
$address   = $site_settings->field( 'address' );
$facebook  = $site_settings->field( 'facebook_url' );
$instagram = $site_settings->field( 'instagram_url' );
?>

<body <?php body_class(); ?>>

<header class="bg-white shadow-sm sticky-top" id="mainHeader">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center py-3">
            
            <div class="site-brand-link">
                <div class="site-logo">
                    <?php
                    if ( has_custom_logo() ) {
                        the_custom_logo();
                    }
                    ?>
                </div>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-title">Vaccine.Pk</a>
            </div>


            
            <!-- Desktop Navigation -->
            <nav class="d-none d-lg-block">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'nav align-items-center',
                    'fallback_cb' => function() {
                        echo '<ul class="nav align-items-center">
                            <li><a href="' . home_url() . '">Home</a></li>
                            <li><a href="' . home_url('/vaccines') . '">Vaccines</a></li>
                            <li><a href="' . home_url('/diseases') . '">Diseases</a></li>
                            <li><a href="' . home_url('/vaccination-schedule') . '">Schedules</a></li>
                            <li><a href="' . home_url('/knowledge-centre') . '">Knowledge Centre</a></li>
                            <li><a href="' . home_url('/travel-vaccines') . '">Travel</a></li>
                            <li><a href="' . home_url('/cities') . '">Cities</a></li>
                            <li><a href="' . home_url('/pricing') . '">Prices</a></li>
                            <li><a href="' . home_url('/about') . '">About</a></li>
                        </ul>';
                    }
                ]);
                ?>
            </nav>
            
            <!-- CTA Buttons with Search -->
            <div class="d-flex align-items-center gap-3">
                <!--<a href="tel:<?php echo esc_attr($phone); ?>" class="d-none d-md-inline-block text-decoration-none" style="color: #da7215; font-weight: 600;">-->
                <!--    <i class="bi bi-telephone-fill"></i> <?php echo esc_html($phone); ?>    -->
                <!--</a>-->
                
                <!-- Search Button -->
                <button type="button" class="btn btn-outline-primary" id="searchToggleBtn" aria-label="Search">
                    <i class="bi bi-search"></i>
                </button>

                <!-- Login Button -->
                <button type="button" class="btn btn-outline-primary" id="loginToggleBtn" data-bs-toggle="modal" data-bs-target="#loginModal">
                    <i class="bi bi-person-circle"></i> Login
                </button>

                <a href="<?php echo esc_url( site_url( '/booking' ) ); ?>" class="btn btn-primary">
                    Book Vaccination
                </a>
            </div>
            
        </div>

        <!-- Search Dropdown -->
        <div id="searchDropdown" class="search-dropdown" style="display: none;">
            <div class="search-container">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input 
                        style="padding-left: 10px !important"
                        type="text" 
                        class="form-control border-start-0 ps-0" 
                        id="vaccineSearchInput" 
                        placeholder="Search vaccines, diseases, or brands..."
                        autocomplete="off"
                    >
                    <button type="button" class="btn-close ms-2" id="searchCloseBtn" aria-label="Close"></button>
                </div>
                
                <!-- Search Results -->
                <div id="searchResults" class="search-results mt-3"></div>
                
                <!-- Loading Spinner -->
                <div id="searchLoading" class="text-center py-3" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2 pb-4">
                <p class="text-muted mb-4">Choose how you'd like to log in.</p>
                <div class="d-grid gap-3">
                    <a href="#" class="login-option-btn" data-login-type="doctor">
                        <i class="bi bi-file-medical"></i>
                        <span>Doctor Login</span>
                    </a>
                    <a href="#" class="login-option-btn" data-login-type="client">
                        <i class="bi bi-person"></i>
                        <span>Client Login</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search Styles -->
<style>
.search-dropdown {
    background: white;
    border-top: 1px solid var(--color-sand);
    padding: 20px 0;
    box-shadow: 0 8px 24px -10px rgba(10,42,56,0.25);
    animation: slideDown 0.3s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.search-container {
    max-width: 800px;
    margin: 0 auto;
}

#vaccineSearchInput {
    font-size: 16px;
    padding: 12px;
    border: 1px solid var(--color-sand);
}

#vaccineSearchInput:focus {
    border-color: var(--color-blue);
    box-shadow: 0 0 0 0.2rem rgba(11, 92, 135, 0.18);
    outline: none;
}

.search-results {
    max-height: 400px;
    overflow-y: auto;
}

/* Shared .search-result-item / .no-results / .contact-btn styles now live in
   assets/css/main.css since header + homepage search share the same result
   markup (rendered by assets/js/main.js). */

header.scrolled {
    box-shadow: 0 4px 20px -6px rgba(10,42,56,0.28);
}

/* Login Modal */
.login-option-btn {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px 18px;
    border: 1px solid var(--color-sand);
    border-radius: 10px;
    color: var(--color-blue, #0b5c87);
    text-decoration: none;
    font-weight: 600;
    transition: border-color 0.2s ease, background 0.2s ease;
}

.login-option-btn i {
    font-size: 1.25rem;
}

.login-option-btn:hover {
    border-color: var(--color-blue, #0b5c87);
    background: rgba(11, 92, 135, 0.06);
    color: var(--color-blue, #0b5c87);
}
</style>

<!-- Search + header scroll JS - shared render logic lives in assets/js/main.js -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchDropdown  = document.getElementById('searchDropdown');
    const searchToggleBtn = document.getElementById('searchToggleBtn');
    const searchCloseBtn  = document.getElementById('searchCloseBtn');
    const searchInput     = document.getElementById('vaccineSearchInput');
    const searchResults   = document.getElementById('searchResults');

    if (typeof vaccinationCentreInitSearch === 'function') {
        vaccinationCentreInitSearch(
            { input: 'vaccineSearchInput', results: 'searchResults', loading: 'searchLoading' },
            { phone: '<?php echo esc_js($phone); ?>', whatsapp: '<?php echo esc_js($whatsapp); ?>' }
        );
    }

    function closeSearch() {
        searchDropdown.style.display = 'none';
        searchInput.value = '';
        searchResults.innerHTML = '';
    }

    searchToggleBtn.addEventListener('click', function() {
        if (searchDropdown.style.display === 'none') {
            searchDropdown.style.display = 'block';
            searchInput.focus();
        } else {
            closeSearch();
        }
    });

    searchCloseBtn.addEventListener('click', closeSearch);

    // Login modal option clicks - destinations TBD
    document.querySelectorAll('.login-option-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Login clicked:', btn.dataset.loginType);
        });
    });

    document.addEventListener('keyup', function(e) {
        if (e.key === 'Escape' && searchDropdown.style.display === 'block') {
            closeSearch();
        }
    });
});

// Header scroll effect
window.addEventListener('scroll', function() {
    const header = document.getElementById('mainHeader');
    if (window.scrollY > 50) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});
</script>
