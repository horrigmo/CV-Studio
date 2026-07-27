<?php
/** Manual multilingual CV suite. */
if ( ! defined( 'ABSPATH' ) ) exit;

function morten_cv_multilingual_enabled() {
    $s = morten_portfolio_cv_get_settings();
    return ! empty( $s['multilingual_enabled'] );
}

function morten_cv_language() {
    if ( ! morten_cv_multilingual_enabled() ) return 'no';
    $lang = get_query_var( 'cv_lang' );
    if ( ! $lang && isset( $_GET['lang'] ) ) $lang = sanitize_key( wp_unslash( $_GET['lang'] ) );
    return 'en' === $lang ? 'en' : 'no';
}
function morten_cv_is_english() { return 'en' === morten_cv_language(); }
function morten_cv_label( $no, $en ) { return morten_cv_is_english() ? $en : $no; }
function morten_cv_setting( $key, $default = '' ) {
    $s = morten_portfolio_cv_get_settings();
    if ( morten_cv_is_english() && isset( $s[ $key . '_en' ] ) && '' !== trim( (string) $s[ $key . '_en' ] ) ) return $s[ $key . '_en' ];
    return isset( $s[ $key ] ) ? $s[ $key ] : $default;
}
function morten_cv_post_value( $post_id, $field, $fallback = '' ) {
    if ( morten_cv_is_english() ) {
        $v = get_post_meta( $post_id, '_morten_cv_' . $field . '_en', true );
        if ( '' !== trim( (string) $v ) ) return $v;
    }
    if ( 'title' === $field ) return get_the_title( $post_id );
    if ( 'content' === $field ) return get_post_field( 'post_content', $post_id );
    $v = get_post_meta( $post_id, '_morten_cv_' . $field, true );
    return '' !== (string) $v ? $v : $fallback;
}
function morten_cv_style() {
    $s = morten_portfolio_cv_get_settings();
    $style = $s['pdf_style'] ?? 'modern';
    return in_array( $style, array( 'modern', 'executive', 'minimal' ), true ) ? $style : 'modern';
}
function morten_cv_url( $lang = 'no' ) {
    $base = home_url( '/cv/' );
    return 'en' === $lang && morten_cv_multilingual_enabled() ? home_url( '/cv/en/' ) : $base;
}

add_action( 'init', function() {
    add_rewrite_rule( '^cv/en/?$', 'index.php?pagename=cv&cv_lang=en', 'top' );
    add_rewrite_tag( '%cv_lang%', '([^&]+)' );
} );
add_filter( 'query_vars', function( $vars ) { $vars[] = 'cv_lang'; return $vars; } );
add_action( 'after_switch_theme', function() { flush_rewrite_rules(); } );

add_action( 'add_meta_boxes', function() {
    foreach ( array( 'cv_experience', 'cv_education', 'cv_course' ) as $pt ) {
        add_meta_box( 'morten_cv_languages', __( 'Språkversjoner', 'morten-portfolio' ), 'morten_cv_language_meta_box', $pt, 'normal', 'high' );
    }
}, 20 );

function morten_cv_language_meta_box( $post ) {
    wp_nonce_field( 'morten_cv_save_languages', 'morten_cv_languages_nonce' );
    $title_en   = get_post_meta( $post->ID, '_morten_cv_title_en', true );
    $company_en = get_post_meta( $post->ID, '_morten_cv_company_en', true );
    $period_en  = get_post_meta( $post->ID, '_morten_cv_period_en', true );
    $content_en = get_post_meta( $post->ID, '_morten_cv_content_en', true );
    $complete = trim( $title_en ) && trim( $period_en ) && ( 'cv_experience' !== $post->post_type || trim( $company_en ) );
    ?>
    <style>
    .mcv-tabs{display:flex;gap:6px;border-bottom:1px solid #dcdcde;margin-bottom:18px}.mcv-tab{border:1px solid #dcdcde;border-bottom:0;background:#f6f7f7;padding:9px 14px;cursor:pointer;border-radius:4px 4px 0 0}.mcv-tab.is-active{background:#fff;font-weight:600;margin-bottom:-1px}.mcv-panel{display:none}.mcv-panel.is-active{display:block}.mcv-copy{margin:0 0 14px}.mcv-status{display:inline-flex;align-items:center;gap:6px;margin-left:8px;font-size:12px}.mcv-dot{width:8px;height:8px;border-radius:50%;background:#dba617}.mcv-status.is-complete .mcv-dot{background:#00a32a}
    </style>
    <div class="mcv-tabs" role="tablist">
        <button type="button" class="mcv-tab is-active" data-panel="mcv-no">🇳🇴 Norsk</button>
        <button type="button" class="mcv-tab" data-panel="mcv-en">🇬🇧 English <span class="mcv-status <?php echo $complete ? 'is-complete' : ''; ?>"><span class="mcv-dot"></span><?php echo $complete ? 'Complete' : 'Missing fields'; ?></span></button>
    </div>
    <div id="mcv-no" class="mcv-panel is-active">
        <p class="description">Norsk tittel og beskrivelse redigeres i WordPress-feltene over. Periode og arbeidsgiver redigeres i boksen «CV-detaljer».</p>
    </div>
    <div id="mcv-en" class="mcv-panel">
        <p class="mcv-copy"><button type="button" class="button" id="mcv-copy-no">Copy Norwegian text</button></p>
        <p><label><strong>Job title</strong></label><input class="widefat" id="mcv-title-en" name="morten_cv_title_en" value="<?php echo esc_attr( $title_en ); ?>"></p>
        <?php if ( 'cv_experience' === $post->post_type ) : ?><p><label><strong>Employer</strong></label><input class="widefat" id="mcv-company-en" name="morten_cv_company_en" value="<?php echo esc_attr( $company_en ); ?>"></p><?php endif; ?>
        <p><label><strong>Period</strong></label><input class="widefat" id="mcv-period-en" name="morten_cv_period_en" value="<?php echo esc_attr( $period_en ); ?>"></p>
        <p><label><strong>Description</strong></label><textarea class="widefat" rows="8" id="mcv-content-en" name="morten_cv_content_en"><?php echo esc_textarea( $content_en ); ?></textarea></p>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded',function(){
      document.querySelectorAll('.mcv-tab').forEach(function(btn){btn.addEventListener('click',function(){document.querySelectorAll('.mcv-tab').forEach(b=>b.classList.remove('is-active'));document.querySelectorAll('.mcv-panel').forEach(p=>p.classList.remove('is-active'));btn.classList.add('is-active');document.getElementById(btn.dataset.panel).classList.add('is-active');});});
      var copy=document.getElementById('mcv-copy-no'); if(copy) copy.addEventListener('click',function(){
        var title=document.getElementById('title'); var editor=document.getElementById('content'); var period=document.getElementById('morten_cv_period'); var company=document.getElementById('morten_cv_company');
        if(title && !document.getElementById('mcv-title-en').value) document.getElementById('mcv-title-en').value=title.value;
        if(period && !document.getElementById('mcv-period-en').value) document.getElementById('mcv-period-en').value=period.value;
        if(company && document.getElementById('mcv-company-en') && !document.getElementById('mcv-company-en').value) document.getElementById('mcv-company-en').value=company.value;
        if(!document.getElementById('mcv-content-en').value){ var content=''; if(window.tinymce && tinymce.get('content')) content=tinymce.get('content').getContent(); else if(editor) content=editor.value; document.getElementById('mcv-content-en').value=content; }
      });
    });
    </script>
    <?php
}

add_action( 'save_post', function( $post_id ) {
    if ( empty( $_POST['morten_cv_languages_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['morten_cv_languages_nonce'] ) ), 'morten_cv_save_languages' ) ) return;
    if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) return;
    foreach ( array( 'title_en', 'company_en', 'period_en' ) as $field ) {
        if ( isset( $_POST[ 'morten_cv_' . $field ] ) ) update_post_meta( $post_id, '_morten_cv_' . $field, sanitize_text_field( wp_unslash( $_POST[ 'morten_cv_' . $field ] ) ) );
    }
    if ( isset( $_POST['morten_cv_content_en'] ) ) update_post_meta( $post_id, '_morten_cv_content_en', wp_kses_post( wp_unslash( $_POST['morten_cv_content_en'] ) ) );
} );

add_action( 'admin_menu', function() { add_submenu_page( 'morten-cv-settings', 'CV-kvalitet', 'CV-kvalitet', 'edit_pages', 'morten-cv-quality', 'morten_cv_quality_page' ); } );
function morten_cv_quality_page() {
    if ( ! current_user_can( 'edit_pages' ) ) return;
    $warnings = array(); $count = 0; $translated = 0;
    foreach ( array( 'cv_experience', 'cv_education', 'cv_course' ) as $pt ) {
        foreach ( get_posts( array( 'post_type' => $pt, 'numberposts' => -1, 'post_status' => 'publish' ) ) as $p ) {
            $count++;
            $period = get_post_meta( $p->ID, '_morten_cv_period', true );
            if ( ! $period ) $warnings[] = "{$p->post_title}: mangler periode.";
            if ( ! trim( wp_strip_all_tags( $p->post_content ) ) ) $warnings[] = "{$p->post_title}: mangler beskrivelse.";
            if ( 'cv_experience' === $pt && ! get_post_meta( $p->ID, '_morten_cv_company', true ) ) $warnings[] = "{$p->post_title}: mangler arbeidsgiver.";
            if ( trim( get_post_meta( $p->ID, '_morten_cv_title_en', true ) ) ) $translated++;
        }
    }
    $score = max( 0, 100 - count( $warnings ) * 5 );
    $translation_pct = $count ? round( $translated / $count * 100 ) : 0;
    echo '<div class="wrap"><h1>CV-kvalitet</h1><div class="notice notice-info"><p><strong>Kvalitetsscore: ' . esc_html( $score ) . '/100</strong> · Engelsk ferdigstilt: ' . esc_html( $translation_pct ) . '%</p></div>';
    if ( ! $warnings ) echo '<div class="notice notice-success"><p>Ingen åpenbare kvalitetsavvik funnet.</p></div>'; else { echo '<h2>Anbefalte forbedringer</h2><ul style="list-style:disc;padding-left:22px">'; foreach ( $warnings as $w ) echo '<li>' . esc_html( $w ) . '</li>'; echo '</ul>'; }
    echo '</div>';
}
