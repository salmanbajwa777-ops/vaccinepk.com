<?php
/**
 * Vaccine alias search.
 * Spec: VACCINE_ALIAS_SEARCH_SPEC.md (owner's workspace). Mock: vaccine_alias_search_mock.html.
 *
 * Aliases live in the Pods Advanced Content Type `vaccine_alias`
 * (table wp_pods_vaccine_alias; vaccine/brand relationships are in wp_podsrel).
 * Misses live in wp_search_misses (sql/2026-11-25-vaccine-alias-search.sql).
 *
 * Fail-safe: every public entry point returns "no alias hits" on any error,
 * so the existing site search keeps working exactly as before.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'VACCINEPK_ALIAS_CACHE', 'vaccinepk_aliases_v1' );

/* --------------------------------------------------------------------------
   1. Normalizing and kinds
   -------------------------------------------------------------------------- */

/** "Hep-B", "hep b", "HepB" -> "hepb". */
function vaccinepk_alias_key( $s ) {
    return preg_replace( '/[^a-z0-9]/', '', strtolower( trim( (string) $s ) ) );
}

function vaccinepk_alias_kind_labels() {
    return [
        'brand'        => 'Brand',
        'generic'      => 'Generic',
        'abbreviation' => 'Abbreviation',
        'epi'          => 'EPI card name',
        'misspelling'  => 'Misspelling',
        'combination'  => 'Combination',
        'fuzzy'        => 'Close spelling',
    ];
}

/** Pods may hand back the stored key or the label; map both to the key. */
function vaccinepk_alias_kind_key( $value ) {
    if ( is_array( $value ) ) $value = reset( $value );
    $v = strtolower( trim( (string) $value ) );
    foreach ( vaccinepk_alias_kind_labels() as $key => $label ) {
        if ( $v === $key || $v === strtolower( $label ) ) return $key;
    }
    return 'generic';
}

/** First ID out of whatever Pods returns for a single relationship field. */
function vaccinepk_alias_rel_id( $value ) {
    if ( is_array( $value ) ) {
        if ( isset( $value['ID'] ) ) return (int) $value['ID'];
        $value = reset( $value );
        if ( is_array( $value ) ) return isset( $value['ID'] ) ? (int) $value['ID'] : 0;
    }
    return (int) $value;
}

/* --------------------------------------------------------------------------
   2. Loading (cached 12 h; cleared on every alias save/delete)
   -------------------------------------------------------------------------- */

/**
 * @param bool $include_inactive true = every row (used by the starter loader to skip existing pairs).
 * @return array[] rows: id, alias, key, kind, vaccine_id, brand_id, note, active
 */
function vaccinepk_alias_rows( $include_inactive = false ) {
    if ( ! $include_inactive ) {
        $cached = get_transient( VACCINEPK_ALIAS_CACHE );
        if ( is_array( $cached ) ) return $cached;
    }

    $rows = [];
    if ( ! function_exists( 'pods' ) ) return $rows;

    try {
        $params = [ 'limit' => -1 ];
        if ( ! $include_inactive ) $params['where'] = 't.is_active = 1';

        $p = pods( 'vaccine_alias', $params );
        if ( ! $p || ( method_exists( $p, 'valid' ) && ! $p->valid() ) ) return $rows;

        while ( $p->fetch() ) {
            $alias = (string) $p->field( 'name' );
            $key   = vaccinepk_alias_key( $alias );
            $vid   = vaccinepk_alias_rel_id( $p->field( 'vaccine.ID' ) );
            if ( $key === '' || ! $vid ) continue;

            $rows[] = [
                'id'         => (int) $p->id(),
                'alias'      => $alias,
                'key'        => $key,
                'kind'       => vaccinepk_alias_kind_key( $p->field( 'kind' ) ),
                'vaccine_id' => $vid,
                'brand_id'   => vaccinepk_alias_rel_id( $p->field( 'brand.ID' ) ),
                'note'       => trim( (string) $p->field( 'note' ) ),
                'active'     => (int) $p->field( 'is_active' ) === 1,
            ];
        }
    } catch ( \Throwable $e ) {
        return []; // don't cache a failure
    }

    if ( ! $include_inactive ) {
        set_transient( VACCINEPK_ALIAS_CACHE, $rows, 12 * HOUR_IN_SECONDS );
    }
    return $rows;
}

function vaccinepk_alias_flush_cache() {
    delete_transient( VACCINEPK_ALIAS_CACHE );
}

/* --------------------------------------------------------------------------
   3. Matching (spec §4.3, §4.3a)
   -------------------------------------------------------------------------- */

/**
 * @return array {
 *   key:   normalized query,
 *   hits:  [ { row, tier: exact|prefix|contains|fuzzy, score, combo } ] max 8, best first,
 *   multi: number of vaccines the exact term matched (>= 2 shows the blue strip, else 0),
 *   fuzzy_skipped: true when typo matching was skipped because the term has a digit
 * }
 */
function vaccinepk_alias_match( $query ) {
    $q   = vaccinepk_alias_key( $query );
    $len = strlen( $q );
    $out = [ 'key' => $q, 'hits' => [], 'multi' => 0, 'fuzzy_skipped' => false ];
    if ( $len < 2 ) return $out;

    $rows = vaccinepk_alias_rows();
    if ( ! $rows ) return $out;

    $best = []; // vaccine_id => candidate; one result per vaccine
    $consider = function ( $row, $tier, $score ) use ( &$best ) {
        $vid   = $row['vaccine_id'];
        $combo = $row['kind'] === 'combination' ? 1 : 0;
        if ( ! isset( $best[ $vid ] )
            || $score > $best[ $vid ]['score']
            || ( $score === $best[ $vid ]['score'] && $combo < $best[ $vid ]['combo'] ) ) {
            $best[ $vid ] = [ 'row' => $row, 'tier' => $tier, 'score' => $score, 'combo' => $combo ];
        }
    };

    // Exact (any length >= 2)
    $exact_vids = [];
    foreach ( $rows as $r ) {
        if ( $r['key'] === $q ) { $consider( $r, 'exact', 100 ); $exact_vids[ $r['vaccine_id'] ] = true; }
    }

    // EPI dose suffix: "penta1" -> "penta", only when nothing matched exactly.
    if ( ! $exact_vids && $len >= 3 && preg_match( '/^([a-z0-9]*[a-z])([0-4])$/', $q, $m ) ) {
        foreach ( $rows as $r ) {
            if ( $r['key'] === $m[1] ) { $consider( $r, 'exact', 100 ); $exact_vids[ $r['vaccine_id'] ] = true; }
        }
    }

    // Prefix (>= 3) and contains (>= 4)
    if ( $len >= 3 ) {
        foreach ( $rows as $r ) {
            if ( $r['key'] === $q ) continue;
            $pos = strpos( $r['key'], $q );
            if ( $pos === 0 )                       $consider( $r, 'prefix', 80 );
            elseif ( $pos !== false && $len >= 4 )  $consider( $r, 'contains', 60 );
        }
    }

    // Fuzzy: only when nothing else matched, term >= 5, and NO digits on either side
    // (pcv10 vs pcv13 is one edit apart — never suggest across that).
    if ( ! $best && $len >= 5 ) {
        if ( preg_match( '/\d/', $q ) ) {
            $out['fuzzy_skipped'] = true;
        } else {
            $max = $len >= 8 ? 2 : 1;
            foreach ( $rows as $r ) {
                if ( preg_match( '/\d/', $r['key'] ) ) continue;
                if ( abs( strlen( $r['key'] ) - $len ) > $max ) continue;
                $d = levenshtein( $q, $r['key'] );
                if ( $d > 0 && $d <= $max ) $consider( $r, 'fuzzy', 40 - $d );
            }
        }
    }

    // Published vaccines only
    $hits = [];
    foreach ( $best as $vid => $hit ) {
        if ( get_post_status( $vid ) !== 'publish' ) continue;
        $hit['title'] = get_the_title( $vid );
        $hits[] = $hit;
    }

    usort( $hits, function ( $a, $b ) {
        if ( $a['score'] !== $b['score'] ) return $b['score'] - $a['score'];
        if ( $a['combo'] !== $b['combo'] ) return $a['combo'] - $b['combo'];
        return strcasecmp( $a['title'], $b['title'] );
    } );

    $out['hits'] = array_slice( $hits, 0, 8 );

    $published_exact = 0;
    foreach ( $hits as $h ) if ( $h['tier'] === 'exact' ) $published_exact++;
    $out['multi'] = $published_exact >= 2 ? $published_exact : 0;

    return $out;
}

/**
 * Builds the public result items for the alias hits, in the same shape as the
 * existing vaccine results plus meta.matched / meta.note.
 */
function vaccinepk_alias_result_items( $query, $match ) {
    $labels = vaccinepk_alias_kind_labels();
    $items  = [];

    foreach ( $match['hits'] as $hit ) {
        $row = $hit['row'];
        $vid = $row['vaccine_id'];

        $disease = $brand = $availability = $price = '';
        if ( function_exists( 'pods' ) ) {
            $v = pods( 'vaccine', $vid );
            if ( $v && ( ! method_exists( $v, 'exists' ) || $v->exists() ) ) {
                $disease      = $v->field( 'disease_name' );
                $brand        = $v->field( 'vaccine_brand' );
                $availability = $v->field( 'availability' );
                $price        = $v->field( 'price' );
            }
        }

        $fuzzy = $hit['tier'] === 'fuzzy';
        $items[] = [
            'type'  => 'vaccine',
            'title' => $hit['title'],
            'url'   => get_permalink( $vid ),
            'meta'  => [
                'disease'      => is_string( $disease ) ? $disease : '',
                'brand'        => is_string( $brand ) ? $brand : '',
                'availability' => is_string( $availability ) ? $availability : '',
                'price'        => is_scalar( $price ) ? (string) $price : '',
                'matched'      => [
                    'typed' => $query,
                    'alias' => $row['alias'],
                    'kind'  => $fuzzy ? $labels['fuzzy'] : ( $labels[ $row['kind'] ] ?? 'Generic' ),
                    'fuzzy' => $fuzzy,
                ],
                'note'         => $row['note'],
            ],
        ];
    }
    return $items;
}

/* --------------------------------------------------------------------------
   4. Misses (spec §3.2)
   -------------------------------------------------------------------------- */

function vaccinepk_log_search_miss( $query ) {
    $key = vaccinepk_alias_key( $query );
    if ( strlen( $key ) < 3 ) return;

    global $wpdb;
    $table = $wpdb->prefix . 'search_misses';
    $now   = current_time( 'mysql' );

    $suppress = $wpdb->suppress_errors( true ); // table may not exist yet: never break search
    $wpdb->query( $wpdb->prepare(
        "INSERT INTO {$table} (term_key, last_term, hits, first_seen, last_seen, resolved)
         VALUES (%s, %s, 1, %s, %s, 0)
         ON DUPLICATE KEY UPDATE hits = hits + 1, last_term = VALUES(last_term), last_seen = VALUES(last_seen)",
        substr( $key, 0, 100 ),
        mb_substr( $query, 0, 190 ),
        $now,
        $now
    ) );
    $wpdb->suppress_errors( $suppress );
}

/* --------------------------------------------------------------------------
   5. Pods hooks: fill alias_key, resolve matching miss, clear cache
   -------------------------------------------------------------------------- */

add_action( 'pods_api_post_save_pod_item_vaccine_alias', function ( $pieces = null, $is_new = null, $id = 0 ) {
    global $wpdb;
    $id = (int) $id;
    if ( $id ) {
        $table = $wpdb->prefix . 'pods_vaccine_alias';
        $name  = $wpdb->get_var( $wpdb->prepare( "SELECT name FROM {$table} WHERE id = %d", $id ) );
        $key   = vaccinepk_alias_key( $name );
        $wpdb->update( $table, [ 'alias_key' => $key ], [ 'id' => $id ], [ '%s' ], [ '%d' ] );

        if ( $key !== '' ) {
            $suppress = $wpdb->suppress_errors( true );
            $wpdb->update( $wpdb->prefix . 'search_misses', [ 'resolved' => 1 ], [ 'term_key' => $key ], [ '%d' ], [ '%s' ] );
            $wpdb->suppress_errors( $suppress );
        }
    }
    vaccinepk_alias_flush_cache();
}, 10, 3 );

add_action( 'pods_api_post_delete_pod_item_vaccine_alias', 'vaccinepk_alias_flush_cache', 10, 0 );

/* --------------------------------------------------------------------------
   6. Admin: Vaccines -> Search Misses & Test (spec §4.6, mock B)
   -------------------------------------------------------------------------- */

add_action( 'admin_menu', function () {
    add_submenu_page(
        'edit.php?post_type=vaccine',
        'Search Misses & Test',
        'Search Misses & Test',
        'manage_options',
        'vaccinepk-search-misses',
        'vaccinepk_render_search_admin'
    );
} );

function vaccinepk_search_admin_url( $args = [] ) {
    return add_query_arg( $args, admin_url( 'edit.php?post_type=vaccine&page=vaccinepk-search-misses' ) );
}

/** Pods add form for the alias pod; `alias` pre-fills the Alias box (field setting "Set Default Value via Parameter" = alias). */
function vaccinepk_alias_add_url( $term = '' ) {
    $args = [ 'page' => 'pods-manage-vaccine_alias', 'action' => 'add' ];
    if ( $term !== '' ) $args['alias'] = $term;
    return add_query_arg( $args, admin_url( 'admin.php' ) );
}

add_action( 'admin_post_vaccinepk_miss_junk', function () {
    if ( ! current_user_can( 'manage_options' ) ) wp_die( 'Not allowed' );
    check_admin_referer( 'vaccinepk_miss_junk' );
    global $wpdb;
    $key = isset( $_POST['term_key'] ) ? vaccinepk_alias_key( wp_unslash( $_POST['term_key'] ) ) : '';
    if ( $key !== '' ) {
        $wpdb->update( $wpdb->prefix . 'search_misses', [ 'resolved' => 1 ], [ 'term_key' => $key ], [ '%d' ], [ '%s' ] );
    }
    wp_safe_redirect( vaccinepk_search_admin_url( [ 'msg' => 'junk' ] ) );
    exit;
} );

add_action( 'admin_post_vaccinepk_alias_flush', function () {
    if ( ! current_user_can( 'manage_options' ) ) wp_die( 'Not allowed' );
    check_admin_referer( 'vaccinepk_alias_flush' );
    vaccinepk_alias_flush_cache();
    wp_safe_redirect( vaccinepk_search_admin_url( [ 'msg' => 'flushed' ] ) );
    exit;
} );

add_action( 'admin_post_vaccinepk_alias_seed', function () {
    if ( ! current_user_can( 'manage_options' ) ) wp_die( 'Not allowed' );
    check_admin_referer( 'vaccinepk_alias_seed' );
    if ( ! function_exists( 'pods' ) ) wp_die( 'Pods is not active.' );

    @set_time_limit( 300 );
    $seed = require __DIR__ . '/vaccine-alias-seed.php';

    $existing = [];
    foreach ( vaccinepk_alias_rows( true ) as $r ) {
        $existing[ $r['key'] . '|' . $r['vaccine_id'] ] = true;
    }

    $added = $skipped = $failed = 0;
    $pod = pods( 'vaccine_alias' );
    foreach ( $seed as $s ) {
        list( $alias, $kind, $vid, $bid, $note ) = $s;
        $k = vaccinepk_alias_key( $alias ) . '|' . (int) $vid;
        if ( isset( $existing[ $k ] ) || get_post_status( (int) $vid ) === false ) { $skipped++; continue; }

        $data = [
            'name'      => $alias,
            'kind'      => $kind,
            'vaccine'   => (int) $vid,
            'note'      => $note,
            'is_active' => 1,
        ];
        if ( $bid ) $data['brand'] = (int) $bid;

        try {
            $new_id = $pod->add( $data );
            if ( $new_id ) { $added++; $existing[ $k ] = true; } else { $failed++; }
        } catch ( \Throwable $e ) {
            $failed++;
        }
    }

    vaccinepk_alias_flush_cache();
    wp_safe_redirect( vaccinepk_search_admin_url( [ 'msg' => 'seeded', 'a' => $added, 's' => $skipped, 'f' => $failed ] ) );
    exit;
} );

function vaccinepk_render_search_admin() {
    if ( ! current_user_can( 'manage_options' ) ) return;
    global $wpdb;

    $labels = vaccinepk_alias_kind_labels();
    $msg    = isset( $_GET['msg'] ) ? sanitize_key( $_GET['msg'] ) : '';
    $q      = isset( $_GET['q'] ) ? sanitize_text_field( wp_unslash( $_GET['q'] ) ) : '';
    $show   = ( isset( $_GET['show'] ) && $_GET['show'] === 'resolved' ) ? 'resolved' : 'open';

    $misses_table = $wpdb->prefix . 'search_misses';
    $suppress = $wpdb->suppress_errors( true );
    $open_n     = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$misses_table} WHERE resolved = 0" );
    $resolved_n = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$misses_table} WHERE resolved = 1" );
    $misses     = $wpdb->get_results( $wpdb->prepare(
        "SELECT term_key, last_term, hits, last_seen FROM {$misses_table} WHERE resolved = %d ORDER BY hits DESC, last_seen DESC LIMIT 100",
        $show === 'resolved' ? 1 : 0
    ) );
    $misses_error = $wpdb->last_error;
    $wpdb->suppress_errors( $suppress );

    $active_n = count( vaccinepk_alias_rows() );
    ?>
    <div class="wrap">
        <h1>Search Misses &amp; Test</h1>

        <?php if ( $msg === 'seeded' ) : ?>
            <div class="notice notice-success"><p>Starter aliases: <b><?php echo (int) ( $_GET['a'] ?? 0 ); ?></b> added,
                <?php echo (int) ( $_GET['s'] ?? 0 ); ?> skipped (already there),
                <?php echo (int) ( $_GET['f'] ?? 0 ); ?> failed.</p></div>
        <?php elseif ( $msg === 'junk' ) : ?>
            <div class="notice notice-success"><p>Marked as junk.</p></div>
        <?php elseif ( $msg === 'flushed' ) : ?>
            <div class="notice notice-success"><p>Search cache cleared.</p></div>
        <?php endif; ?>

        <!-- Test a search -->
        <div class="card" style="max-width:none">
            <h2>Test a search</h2>
            <p class="description">Shows exactly what the public search returns first for this text, and why. The usual title, disease and article results follow it on the site.</p>
            <form method="get" style="margin:10px 0">
                <input type="hidden" name="post_type" value="vaccine">
                <input type="hidden" name="page" value="vaccinepk-search-misses">
                <input type="text" name="q" value="<?php echo esc_attr( $q ); ?>" class="regular-text" placeholder="e.g. pcv13, DTP, Hexaxin, HB">
                <?php submit_button( 'Test', 'primary', '', false ); ?>
            </form>
            <?php if ( $q !== '' ) :
                $m = vaccinepk_alias_match( $q ); ?>
                <?php if ( $m['hits'] ) : ?>
                    <table class="widefat striped">
                        <thead><tr><th>#</th><th>Vaccine</th><th>Matched alias</th><th>Kind</th><th>How</th><th>Score</th><th>Note</th></tr></thead>
                        <tbody>
                        <?php foreach ( $m['hits'] as $i => $h ) : $r = $h['row']; ?>
                            <tr>
                                <td><?php echo (int) $i + 1; ?></td>
                                <td><a href="<?php echo esc_url( get_permalink( $r['vaccine_id'] ) ); ?>" target="_blank"><?php echo esc_html( $h['title'] ); ?></a></td>
                                <td><?php echo esc_html( $r['alias'] ); ?></td>
                                <td><?php echo esc_html( $labels[ $r['kind'] ] ?? $r['kind'] ); ?></td>
                                <td><?php echo esc_html( ucfirst( $h['tier'] ) ); ?></td>
                                <td><?php echo (int) $h['score']; ?></td>
                                <td><?php echo esc_html( $r['note'] ); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <p><b>No alias match.</b> The public search would show only the usual title, disease and article results<?php echo strlen( $m['key'] ) <= 2 ? ' (none for 2 characters)' : ''; ?>.</p>
                <?php endif; ?>
                <p class="description">
                    Normalized key: <code><?php echo esc_html( $m['key'] ); ?></code>
                    · <?php echo count( $m['hits'] ); ?> alias result(s)
                    <?php if ( $m['multi'] ) echo '· blue strip shown (' . (int) $m['multi'] . ' vaccines)'; ?>
                    <?php if ( $m['fuzzy_skipped'] ) echo '· typo matching skipped (contains a digit)'; ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- Misses -->
        <div class="card" style="max-width:none">
            <h2>Searches with no results</h2>
            <?php if ( $misses_error ) : ?>
                <p style="color:#b32d2e">The misses table isn't readable: <?php echo esc_html( $misses_error ); ?></p>
            <?php else : ?>
                <ul class="subsubsub" style="float:none;margin-bottom:8px">
                    <li><a href="<?php echo esc_url( vaccinepk_search_admin_url( [ 'show' => 'open' ] ) ); ?>" class="<?php echo $show === 'open' ? 'current' : ''; ?>">Open (<?php echo $open_n; ?>)</a> |</li>
                    <li><a href="<?php echo esc_url( vaccinepk_search_admin_url( [ 'show' => 'resolved' ] ) ); ?>" class="<?php echo $show === 'resolved' ? 'current' : ''; ?>">Resolved (<?php echo $resolved_n; ?>)</a></li>
                </ul>
                <?php if ( ! $misses ) : ?>
                    <p>Nothing here yet.</p>
                <?php else : ?>
                    <table class="widefat striped">
                        <thead><tr><th>Typed (last spelling)</th><th>Times</th><th>Last searched</th><th style="width:240px"></th></tr></thead>
                        <tbody>
                        <?php foreach ( $misses as $row ) : ?>
                            <tr>
                                <td><b><?php echo esc_html( $row->last_term ); ?></b></td>
                                <td><?php echo (int) $row->hits; ?></td>
                                <td><?php echo esc_html( mysql2date( 'j M Y, g:i a', $row->last_seen ) ); ?></td>
                                <td>
                                    <?php if ( $show === 'open' ) : ?>
                                        <a class="button button-primary button-small" href="<?php echo esc_url( vaccinepk_alias_add_url( $row->last_term ) ); ?>">Add as alias</a>
                                        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="display:inline">
                                            <input type="hidden" name="action" value="vaccinepk_miss_junk">
                                            <input type="hidden" name="term_key" value="<?php echo esc_attr( $row->term_key ); ?>">
                                            <?php wp_nonce_field( 'vaccinepk_miss_junk' ); ?>
                                            <button class="button button-small" style="color:#b32d2e;border-color:#b32d2e">Mark junk</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <p class="description">"Add as alias" opens the Vaccine Aliases add form with the text filled in. Saving it marks the miss resolved automatically.</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <!-- Starter list + cache -->
        <div class="card" style="max-width:none">
            <h2>Aliases</h2>
            <p>Active aliases in search: <b><?php echo (int) $active_n; ?></b> ·
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=pods-manage-vaccine_alias' ) ); ?>">Manage aliases</a></p>
            <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="display:inline"
                  onsubmit="return confirm('Load the approved starter aliases? Existing ones are skipped, so this is safe to run again.');">
                <input type="hidden" name="action" value="vaccinepk_alias_seed">
                <?php wp_nonce_field( 'vaccinepk_alias_seed' ); ?>
                <?php submit_button( 'Load starter aliases', 'secondary', '', false ); ?>
            </form>
            <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="display:inline;margin-left:8px">
                <input type="hidden" name="action" value="vaccinepk_alias_flush">
                <?php wp_nonce_field( 'vaccinepk_alias_flush' ); ?>
                <?php submit_button( 'Clear search cache', 'secondary', '', false ); ?>
            </form>
        </div>
    </div>
    <?php
}
