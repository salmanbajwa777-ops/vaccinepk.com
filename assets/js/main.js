/**
 * VaccinePk shared frontend JS
 * Site-wide search: powers both the header search dropdown (#vaccineSearchInput)
 * and the homepage hero search box (#homeSearchInput). Both wire up via
 * vaccinationCentreInitSearch() with their own input/results/loading element ids
 * but share the same AJAX action, nonce, and result-rendering logic.
 */

/**
 * Fires a non-blocking beacon so a chip click counts toward its search-volume
 * rank (see vaccinepk_get_ranked_chips() in functions.php). Never delays or
 * blocks the link's own navigation.
 */
function vaccinationCentreInitChipTracking() {
    document.querySelectorAll( '.home-chip[data-chip-term]' ).forEach( function ( chip ) {
        chip.addEventListener( 'click', function () {
            const formData = new FormData();
            formData.append( 'action', 'track_chip_click' );
            formData.append( 'nonce', vaccination_ajax.nonce );
            formData.append( 'term', chip.getAttribute( 'data-chip-term' ) );

            if ( navigator.sendBeacon ) {
                navigator.sendBeacon( vaccination_ajax.ajax_url, formData );
            } else {
                fetch( vaccination_ajax.ajax_url, { method: 'POST', credentials: 'same-origin', body: formData, keepalive: true } );
            }
        } );
    } );
}

document.addEventListener( 'DOMContentLoaded', vaccinationCentreInitChipTracking );

function vaccinationCentreTypeBadge( type ) {
    const badges = {
        vaccine: '<span class="search-type-badge type-vaccine">Vaccine</span>',
        disease: '<span class="search-type-badge type-disease">Disease</span>',
        brand:   '<span class="search-type-badge type-brand">Brand</span>',
        city:    '<span class="search-type-badge type-city">City</span>',
        article: '<span class="search-type-badge type-article">Article</span>',
    };
    return badges[ type ] || '';
}

function vaccinationCentreAvailabilityBadge( availability ) {
    const badges = {
        'in_stock':     '<span class="search-result-badge" style="background:#7bb14f;color:#fff;"><i class="bi bi-check-circle-fill"></i> In Stock</span>',
        'out_of_stock': '<span class="search-result-badge" style="background:#dc3545;color:#fff;"><i class="bi bi-x-circle-fill"></i> Out of Stock</span>',
        'coming_soon':  '<span class="search-result-badge" style="background:#ffc107;color:#000;"><i class="bi bi-clock-fill"></i> Coming Soon</span>',
        'yes':          '<span class="search-result-badge" style="background:#7bb14f;color:#fff;"><i class="bi bi-check-circle-fill"></i> Available</span>',
        '1':            '<span class="search-result-badge" style="background:#7bb14f;color:#fff;"><i class="bi bi-check-circle-fill"></i> Available</span>',
    };
    return badges[ availability ] || '';
}

function vaccinationCentreEscapeHtml( text ) {
    const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
    return String( text ).replace( /[&<>"']/g, ( m ) => map[ m ] );
}

/**
 * @param {Object} ids - element ids: { input, results, loading }
 * @param {Object} contact - { phone, whatsapp } for the no-results fallback
 */
function vaccinationCentreInitSearch( ids, contact ) {
    const input   = document.getElementById( ids.input );
    const results = document.getElementById( ids.results );
    const loading = ids.loading ? document.getElementById( ids.loading ) : null;

    if ( ! input || ! results ) return;

    let searchTimeout;

    input.addEventListener( 'keyup', function () {
        const query = this.value.trim();
        clearTimeout( searchTimeout );

        if ( query.length < 3 ) {
            results.innerHTML = '';
            if ( loading ) loading.style.display = 'none';
            return;
        }

        if ( loading ) loading.style.display = 'block';
        results.innerHTML = '';

        searchTimeout = setTimeout( function () {
            performSearch( query );
        }, 500 );
    } );

    function performSearch( query ) {
        const formData = new FormData();
        formData.append( 'action', 'vaccine_search' );
        formData.append( 'nonce', vaccination_ajax.nonce );
        formData.append( 'query', query );

        fetch( vaccination_ajax.ajax_url, {
            method: 'POST',
            credentials: 'same-origin',
            body: formData,
        } )
            .then( ( response ) => response.json() )
            .then( ( data ) => {
                if ( loading ) loading.style.display = 'none';

                if ( data.success && data.data.results.length > 0 ) {
                    displayResults( data.data.results );
                } else {
                    displayNoResults( query );
                }
            } )
            .catch( ( error ) => {
                if ( loading ) loading.style.display = 'none';
                results.innerHTML = '<p class="text-danger text-center">Error occurred. Please try again.</p>';
                console.error( 'Search error:', error );
            } );
    }

    function displayResults( items ) {
        let html = '';

        items.forEach( function ( item ) {
            const meta = item.meta || {};
            const metaBits = [];

            if ( meta.availability ) metaBits.push( vaccinationCentreAvailabilityBadge( meta.availability ) );
            if ( meta.disease ) metaBits.push( `<span class="text-muted">Disease: ${ vaccinationCentreEscapeHtml( meta.disease ) }</span>` );
            if ( meta.brand ) metaBits.push( `<span class="text-muted ms-2">&bull; Brand: ${ vaccinationCentreEscapeHtml( meta.brand ) }</span>` );
            if ( meta.price ) metaBits.push( `<span class="text-muted ms-2">&bull; Rs. ${ vaccinationCentreEscapeHtml( meta.price ) }</span>` );

            html += `
                <a href="${ item.url }" class="search-result-item">
                    <div class="search-result-title">
                        <i class="bi bi-shield-fill-check me-2"></i>${ vaccinationCentreEscapeHtml( item.title ) }
                        ${ vaccinationCentreTypeBadge( item.type ) }
                    </div>
                    <div class="search-result-meta">${ metaBits.join( ' ' ) }</div>
                </a>
            `;
        } );

        results.innerHTML = html;
    }

    function displayNoResults( query ) {
        const phone    = contact && contact.phone ? contact.phone : '';
        const whatsapp = contact && contact.whatsapp ? contact.whatsapp.replace( /[^0-9]/g, '' ) : '';

        results.innerHTML = `
            <div class="no-results">
                <div class="no-results-icon"><i class="bi bi-search"></i></div>
                <h5>No results found for "${ vaccinationCentreEscapeHtml( query ) }"</h5>
                <p class="text-muted">We couldn't find any matches. Contact us for more information:</p>
                <div class="contact-options">
                    <a href="tel:${ phone }" class="contact-btn btn-phone">
                        <i class="bi bi-telephone-fill"></i> Call Us
                    </a>
                    <a href="https://wa.me/${ whatsapp }" target="_blank" class="contact-btn btn-whatsapp">
                        <i class="bi bi-whatsapp"></i> WhatsApp
                    </a>
                </div>
            </div>
        `;
    }
}
