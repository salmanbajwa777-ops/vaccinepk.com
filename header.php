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
                            <li><a href="' . home_url('/about') . '">About</a></li>
                            <li><a href="' . home_url('/vaccines') . '">Vaccines</a></li>
                            <li><a href="' . home_url('/contact') . '">Contact</a></li>
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
                
                <a href="<?php echo esc_url( site_url( '/booking' ) ); ?>" class="btn btn-primary">
                    Book Now
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

<!-- Search Styles -->
<style>
.search-dropdown {
    background: white;
    border-top: 1px solid #e0e0e0;
    padding: 20px 0;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
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
    border: 1px solid #e0e0e0;
}

#vaccineSearchInput:focus {
    border-color: #da7215;
    box-shadow: 0 0 0 0.2rem rgba(218, 114, 21, 0.25);
    outline: none;
}

.search-results {
    max-height: 400px;
    overflow-y: auto;
}

.search-result-item {
    padding: 15px;
    border-bottom: 1px solid #f0f0f0;
    transition: all 0.2s;
    cursor: pointer;
    text-decoration: none;
    display: block;
    color: inherit;
}

.search-result-item:hover {
    background: #f8f9fa;
    transform: translateX(5px);
}

.search-result-item:last-child {
    border-bottom: none;
}

.search-result-title {
    font-weight: 600;
    color: #da7215;
    margin-bottom: 5px;
}

.search-result-meta {
    font-size: 14px;
    color: #666;
}

.search-result-badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 12px;
    font-size: 12px;
    margin-right: 8px;
}

.no-results {
    text-align: center;
    padding: 40px 20px;
}

.no-results-icon {
    font-size: 48px;
    color: #ddd;
    margin-bottom: 15px;
}

.contact-options {
    display: flex;
    gap: 15px;
    justify-content: center;
    margin-top: 20px;
    flex-wrap: wrap;
}

.contact-btn {
    padding: 10px 20px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s;
}

.contact-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.btn-phone {
    background: #da7215;
    color: white;
}

.btn-whatsapp {
    background: #25D366;
    color: white;
}

header.scrolled {
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
</style>

<!-- Search JavaScript - Vanilla JS -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    let searchTimeout;
    const searchInput = document.getElementById('vaccineSearchInput');
    const searchResults = document.getElementById('searchResults');
    const searchLoading = document.getElementById('searchLoading');
    const searchDropdown = document.getElementById('searchDropdown');
    const searchToggleBtn = document.getElementById('searchToggleBtn');
    const searchCloseBtn = document.getElementById('searchCloseBtn');

    // Toggle search dropdown
    searchToggleBtn.addEventListener('click', function() {
        if (searchDropdown.style.display === 'none') {
            searchDropdown.style.display = 'block';
            searchInput.focus();
        } else {
            searchDropdown.style.display = 'none';
            searchInput.value = '';
            searchResults.innerHTML = '';
        }
    });

    // Close search dropdown
    searchCloseBtn.addEventListener('click', function() {
        searchDropdown.style.display = 'none';
        searchInput.value = '';
        searchResults.innerHTML = '';
    });

    // Close on escape key
    document.addEventListener('keyup', function(e) {
        if (e.key === 'Escape' && searchDropdown.style.display === 'block') {
            searchDropdown.style.display = 'none';
            searchInput.value = '';
            searchResults.innerHTML = '';
        }
    });

    // Live search
    searchInput.addEventListener('keyup', function() {
        const query = this.value.trim();

        // Clear previous timeout
        clearTimeout(searchTimeout);

        // Clear results if query is less than 3 characters
        if (query.length < 3) {
            searchResults.innerHTML = '';
            return;
        }

        // Show loading
        searchLoading.style.display = 'block';
        searchResults.innerHTML = '';

        // Debounce search
        searchTimeout = setTimeout(function() {
            performSearch(query);
        }, 500);
    });

    function performSearch(query) {
        const formData = new FormData();
        formData.append('action', 'vaccine_search');
        formData.append('nonce', vaccination_ajax.nonce);
        formData.append('query', query);

        fetch(vaccination_ajax.ajax_url, {
            method: 'POST',
            credentials: 'same-origin',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            searchLoading.style.display = 'none';
            
            if (data.success && data.data.results.length > 0) {
                displayResults(data.data.results);
            } else {
                displayNoResults(query);
            }
        })
        .catch(error => {
            searchLoading.style.display = 'none';
            searchResults.innerHTML = '<p class="text-danger text-center">Error occurred. Please try again.</p>';
            console.error('Search error:', error);
        });
    }

    function displayResults(results) {
        let html = '';
        
        results.forEach(function(item) {
            const availabilityBadge = getAvailabilityBadge(item.availability);
            
            html += `
                <a href="${item.url}" class="search-result-item">
                    <div class="search-result-title">
                        <i class="bi bi-shield-fill-check me-2"></i>${item.title}
                    </div>
                    <div class="search-result-meta">
                        ${availabilityBadge}
                        ${item.disease ? `<span class="text-muted">Disease: ${item.disease}</span>` : ''}
                        ${item.brand ? `<span class="text-muted ms-2">• Brand: ${item.brand}</span>` : ''}
                        ${item.price ? `<span class="text-muted ms-2">• Rs. ${item.price}</span>` : ''}
                    </div>
                </a>
            `;
        });
        
        searchResults.innerHTML = html;
    }

    function displayNoResults(query) {
        const phone = '<?php echo esc_js($phone); ?>';
        const whatsapp = '<?php echo esc_js($whatsapp); ?>';
        
        const html = `
            <div class="no-results">
                <div class="no-results-icon">
                    <i class="bi bi-search"></i>
                </div>
                <h5>No results found for "${escapeHtml(query)}"</h5>
                <p class="text-muted">We couldn't find any vaccines matching your search.</p>
                <p class="fw-bold">Contact us for more information:</p>
                <div class="contact-options">
                    <a href="tel:${phone}" class="contact-btn btn-phone">
                        <i class="bi bi-telephone-fill"></i> Call Us
                    </a>
                    <a href="https://wa.me/${whatsapp.replace(/[^0-9]/g, '')}" target="_blank" class="contact-btn btn-whatsapp">
                        <i class="bi bi-whatsapp"></i> WhatsApp
                    </a>
                </div>
            </div>
        `;
        
        searchResults.innerHTML = html;
    }

    function getAvailabilityBadge(availability) {
        const badges = {
            'in_stock': '<span class="search-result-badge" style="background: #7bb14f; color: white;"><i class="bi bi-check-circle-fill"></i> In Stock</span>',
            'out_of_stock': '<span class="search-result-badge" style="background: #dc3545; color: white;"><i class="bi bi-x-circle-fill"></i> Out of Stock</span>',
            'coming_soon': '<span class="search-result-badge" style="background: #ffc107; color: #000;"><i class="bi bi-clock-fill"></i> Coming Soon</span>',
            'yes': '<span class="search-result-badge" style="background: #7bb14f; color: white;"><i class="bi bi-check-circle-fill"></i> Available</span>',
            '1': '<span class="search-result-badge" style="background: #7bb14f; color: white;"><i class="bi bi-check-circle-fill"></i> Available</span>'
        };
        
        return badges[availability] || '';
    }

    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }
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
