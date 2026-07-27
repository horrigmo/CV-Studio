<?php
/**
 * Structured CV content management.
 *
 * @package Morten_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function morten_portfolio_register_cv_content_types() {
    $types = array(
        'cv_experience' => array(
            'singular' => __( 'Arbeidserfaring', 'morten-portfolio' ),
            'plural'   => __( 'Arbeidserfaring', 'morten-portfolio' ),
            'icon'     => 'dashicons-portfolio',
        ),
        'cv_education' => array(
            'singular' => __( 'Utdanning', 'morten-portfolio' ),
            'plural'   => __( 'Utdanning', 'morten-portfolio' ),
            'icon'     => 'dashicons-welcome-learn-more',
        ),
        'cv_course' => array(
            'singular' => __( 'Kurs og øvrig erfaring', 'morten-portfolio' ),
            'plural'   => __( 'Kurs og øvrig erfaring', 'morten-portfolio' ),
            'icon'     => 'dashicons-awards',
        ),
    );

    foreach ( $types as $post_type => $labels ) {
        register_post_type(
            $post_type,
            array(
                'labels' => array(
                    'name'          => $labels['plural'],
                    'singular_name' => $labels['singular'],
                    'add_new_item'  => sprintf( __( 'Legg til %s', 'morten-portfolio' ), strtolower( $labels['singular'] ) ),
                    'edit_item'     => sprintf( __( 'Rediger %s', 'morten-portfolio' ), strtolower( $labels['singular'] ) ),
                ),
                'public'              => false,
                'show_ui'             => true,
                'show_in_menu'        => 'morten-cv-settings',
                'show_in_rest'        => false,
                'supports'            => array( 'title', 'editor', 'page-attributes' ),
                'menu_icon'           => $labels['icon'],
                'capability_type'      => 'post',
                'map_meta_cap'         => true,
                'exclude_from_search'  => true,
                'publicly_queryable'   => false,
            )
        );
    }
}
add_action( 'init', 'morten_portfolio_register_cv_content_types' );

function morten_portfolio_cv_meta_boxes() {
    foreach ( array( 'cv_experience', 'cv_education', 'cv_course' ) as $post_type ) {
        add_meta_box(
            'morten_cv_details',
            __( 'CV-detaljer', 'morten-portfolio' ),
            'morten_portfolio_cv_meta_box_callback',
            $post_type,
            'normal',
            'high'
        );
    }
}
add_action( 'add_meta_boxes', 'morten_portfolio_cv_meta_boxes' );

function morten_portfolio_cv_meta_box_callback( $post ) {
    wp_nonce_field( 'morten_cv_save_meta', 'morten_cv_meta_nonce' );

    $period  = get_post_meta( $post->ID, '_morten_cv_period', true );
    $company = get_post_meta( $post->ID, '_morten_cv_company', true );
    ?>
    <p>
        <label for="morten_cv_period"><strong><?php esc_html_e( 'Periode', 'morten-portfolio' ); ?></strong></label><br>
        <input type="text" id="morten_cv_period" name="morten_cv_period" class="widefat" value="<?php echo esc_attr( $period ); ?>" placeholder="Mars 2018–Mars 2026">
    </p>
    <?php if ( 'cv_experience' === $post->post_type ) : ?>
        <p>
            <label for="morten_cv_company"><strong><?php esc_html_e( 'Arbeidsgiver / virksomhet', 'morten-portfolio' ); ?></strong></label><br>
            <input type="text" id="morten_cv_company" name="morten_cv_company" class="widefat" value="<?php echo esc_attr( $company ); ?>" placeholder="EnterCard">
        </p>
        <p class="description"><?php esc_html_e( 'Bruk tittelfeltet til stillingstittel. Opprett ett innlegg per rolle. Bruk «Rekkefølge» under Sideattributter for å styre visningsrekkefølgen.', 'morten-portfolio' ); ?></p>
    <?php else : ?>
        <p class="description"><?php esc_html_e( 'Bruk tittelfeltet til utdanning eller kurs. Bruk «Rekkefølge» under Sideattributter for å styre visningsrekkefølgen.', 'morten-portfolio' ); ?></p>
    <?php endif; ?>
    <?php
}

function morten_portfolio_save_cv_meta( $post_id ) {
    if ( ! isset( $_POST['morten_cv_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['morten_cv_meta_nonce'] ) ), 'morten_cv_save_meta' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['morten_cv_period'] ) ) {
        update_post_meta( $post_id, '_morten_cv_period', sanitize_text_field( wp_unslash( $_POST['morten_cv_period'] ) ) );
    }

    if ( isset( $_POST['morten_cv_company'] ) ) {
        update_post_meta( $post_id, '_morten_cv_company', sanitize_text_field( wp_unslash( $_POST['morten_cv_company'] ) ) );
    }
}
add_action( 'save_post', 'morten_portfolio_save_cv_meta' );

function morten_portfolio_cv_admin_menu() {
    add_menu_page(
        __( 'CV', 'morten-portfolio' ),
        __( 'CV', 'morten-portfolio' ),
        'edit_pages',
        'morten-cv-settings',
        'morten_portfolio_cv_settings_page',
        'dashicons-id-alt',
        26
    );

    add_submenu_page(
        'morten-cv-settings',
        __( 'CV-innstillinger', 'morten-portfolio' ),
        __( 'CV-innstillinger', 'morten-portfolio' ),
        'manage_options',
        'morten-cv-settings',
        'morten_portfolio_cv_settings_page'
    );
}
add_action( 'admin_menu', 'morten_portfolio_cv_admin_menu' );

function morten_portfolio_cv_register_settings() {
    register_setting(
        'morten_cv_settings_group',
        'morten_cv_settings',
        array(
            'type'              => 'array',
            'sanitize_callback' => 'morten_portfolio_sanitize_cv_settings',
            'default'           => array(),
        )
    );
}
add_action( 'admin_init', 'morten_portfolio_cv_register_settings' );

function morten_portfolio_sanitize_cv_settings( $input ) {
    $clean = array();
    $clean['portrait_id'] = isset( $input['portrait_id'] ) ? absint( $input['portrait_id'] ) : 0;
    $clean['multilingual_enabled'] = ! empty( $input['multilingual_enabled'] ) ? 1 : 0;
    $clean['pdf_style'] = isset( $input['pdf_style'] ) && in_array( $input['pdf_style'], array('modern','executive','minimal'), true ) ? sanitize_key( $input['pdf_style'] ) : 'modern';
    $text_fields = array( 'name','headline','address','phone','email','website','references','digital_cv_label','digital_cv_url','headline_en','references_en','digital_cv_label_en' );
    foreach ( $text_fields as $field ) if ( isset( $input[$field] ) ) $clean[$field] = 'email' === $field ? sanitize_email( $input[$field] ) : sanitize_text_field( $input[$field] );
    foreach ( array('short_facts','qualifications','languages','short_facts_en','qualifications_en','languages_en') as $field ) if ( isset( $input[$field] ) ) $clean[$field] = sanitize_textarea_field( $input[$field] );
    return $clean;
}

function morten_portfolio_cv_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $settings = wp_parse_args( get_option( 'morten_cv_settings', array() ), morten_portfolio_cv_default_settings() );
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'CV-innstillinger', 'morten-portfolio' ); ?></h1>
        <p><?php esc_html_e( 'Profilbildet velges her. Arbeidserfaring, utdanning og kurs administreres i undermenyene.', 'morten-portfolio' ); ?></p>
        <form method="post" action="options.php">
            <?php settings_fields( 'morten_cv_settings_group' ); ?>
            <table class="form-table" role="presentation">
                <?php morten_portfolio_cv_portrait_row( isset( $settings['portrait_id'] ) ? (int) $settings['portrait_id'] : 0 ); ?>
                <?php morten_portfolio_cv_setting_row( 'name', __( 'Navn', 'morten-portfolio' ), $settings['name'] ); ?>
                <?php morten_portfolio_cv_setting_row( 'headline', __( 'Overskrift / profesjonell tittel', 'morten-portfolio' ), $settings['headline'] ); ?>
                <?php morten_portfolio_cv_setting_row( 'address', __( 'Adresse', 'morten-portfolio' ), $settings['address'] ); ?>
                <?php morten_portfolio_cv_setting_row( 'phone', __( 'Telefon', 'morten-portfolio' ), $settings['phone'] ); ?>
                <?php morten_portfolio_cv_setting_row( 'email', __( 'E-post', 'morten-portfolio' ), $settings['email'], 'email' ); ?>
                <?php morten_portfolio_cv_setting_row( 'website', __( 'Nettside', 'morten-portfolio' ), $settings['website'] ); ?>
                <?php morten_portfolio_cv_setting_row( 'short_facts', __( 'Kort fortalt', 'morten-portfolio' ), $settings['short_facts'], 'textarea', __( 'Ett punkt per linje.', 'morten-portfolio' ) ); ?>
                <?php morten_portfolio_cv_setting_row( 'qualifications', __( 'Nøkkelkvalifikasjoner', 'morten-portfolio' ), $settings['qualifications'], 'textarea', __( 'Ett punkt per linje.', 'morten-portfolio' ) ); ?>
                <?php morten_portfolio_cv_setting_row( 'languages', __( 'Språk', 'morten-portfolio' ), $settings['languages'], 'textarea', __( 'Ett språk per linje i formatet: Norsk|100', 'morten-portfolio' ) ); ?>
                <?php morten_portfolio_cv_setting_row( 'references', __( 'Referanser', 'morten-portfolio' ), $settings['references'] ); ?>
                <?php morten_portfolio_cv_setting_row( 'digital_cv_label', __( 'Digital CV – etikett', 'morten-portfolio' ), $settings['digital_cv_label'] ); ?>
                <?php morten_portfolio_cv_setting_row( 'digital_cv_url', __( 'Digital CV – adresse', 'morten-portfolio' ), $settings['digital_cv_url'] ); ?>
                <tr><th scope="row">PDF-stil</th><td><select name="morten_cv_settings[pdf_style]"><option value="modern" <?php selected($settings['pdf_style'] ?? 'modern','modern'); ?>>Modern</option><option value="executive" <?php selected($settings['pdf_style'] ?? '','executive'); ?>>Executive</option><option value="minimal" <?php selected($settings['pdf_style'] ?? '','minimal'); ?>>Minimal</option></select></td></tr>
                <tr><th scope="row">Flerspråklig CV</th><td><label><input type="checkbox" name="morten_cv_settings[multilingual_enabled]" value="1" <?php checked(!empty($settings['multilingual_enabled'])); ?>> Aktiver språkvalg (norsk og engelsk)</label><p class="description">Når dette er av, skjules språkvelgeren og engelsk URL videresendes til norsk CV. Engelske tekster beholdes lagret.</p></td></tr>
                <tr class="mcv-english-settings"><th scope="row">Engelsk CV</th><td>
                <?php morten_portfolio_cv_setting_row( 'headline_en', 'Headline', $settings['headline_en'] ?? 'Curriculum vitae' ); ?>
                <?php morten_portfolio_cv_setting_row( 'short_facts_en', 'Short profile', $settings['short_facts_en'] ?? '', 'textarea', 'One item per line.' ); ?>
                <?php morten_portfolio_cv_setting_row( 'qualifications_en', 'Key qualifications', $settings['qualifications_en'] ?? '', 'textarea', 'One item per line.' ); ?>
                <?php morten_portfolio_cv_setting_row( 'languages_en', 'Languages', $settings['languages_en'] ?? '', 'textarea', 'Language|100' ); ?>
                <?php morten_portfolio_cv_setting_row( 'references_en', 'References', $settings['references_en'] ?? 'Available on request.' ); ?>
                <?php morten_portfolio_cv_setting_row( 'digital_cv_label_en', 'Digital CV label', $settings['digital_cv_label_en'] ?? 'Digital CV' ); ?>
                </td></tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}



function morten_portfolio_cv_portrait_row( $attachment_id ) {
    $image_url = $attachment_id ? wp_get_attachment_image_url( $attachment_id, 'medium' ) : '';
    ?>
    <tr>
        <th scope="row"><?php esc_html_e( 'Profilbilde', 'morten-portfolio' ); ?></th>
        <td>
            <div id="morten-cv-portrait-preview" style="margin-bottom:12px;">
                <?php if ( $image_url ) : ?>
                    <img src="<?php echo esc_url( $image_url ); ?>" alt="" style="display:block;width:150px;height:150px;object-fit:cover;border-radius:50%;border:1px solid #dcdcde;">
                <?php else : ?>
                    <div style="display:grid;place-items:center;width:150px;height:150px;border-radius:50%;background:#eef1e7;border:1px solid #dcdcde;color:#4f5a3b;font-size:34px;font-weight:700;">MH</div>
                <?php endif; ?>
            </div>

            <input type="hidden" id="morten_cv_portrait_id" name="morten_cv_settings[portrait_id]" value="<?php echo esc_attr( $attachment_id ); ?>">

            <button type="button" class="button" id="morten-cv-select-portrait">
                <?php echo $attachment_id ? esc_html__( 'Bytt bilde', 'morten-portfolio' ) : esc_html__( 'Velg bilde', 'morten-portfolio' ); ?>
            </button>
            <button type="button" class="button button-link-delete" id="morten-cv-remove-portrait" <?php echo $attachment_id ? '' : 'style="display:none;"'; ?>>
                <?php esc_html_e( 'Fjern bilde', 'morten-portfolio' ); ?>
            </button>
            <p class="description"><?php esc_html_e( 'Velg et portrettbilde fra mediebiblioteket. Et kvadratisk bilde gir best resultat.', 'morten-portfolio' ); ?></p>
        </td>
    </tr>
    <?php
}

function morten_portfolio_cv_admin_assets( $hook_suffix ) {
    $is_cv_settings = 'toplevel_page_morten-cv-settings' === $hook_suffix;

    if ( ! $is_cv_settings && isset( $_GET['page'] ) ) {
        $is_cv_settings = 'morten-cv-settings' === sanitize_key( wp_unslash( $_GET['page'] ) );
    }

    if ( ! $is_cv_settings ) {
        return;
    }

    wp_enqueue_media();
    wp_enqueue_script( 'jquery' );

    $script = <<<'JS'
(function($) {
    'use strict';

    $(function() {
        var frame;
        var $input = $('#morten_cv_portrait_id');
        var $preview = $('#morten-cv-portrait-preview');
        var $remove = $('#morten-cv-remove-portrait');
        var $select = $('#morten-cv-select-portrait');

        if (!$select.length) {
            return;
        }

        $select.on('click', function(event) {
            event.preventDefault();

            if (typeof wp === 'undefined' || !wp.media) {
                window.alert('Mediebiblioteket kunne ikke lastes. Oppdater siden og prøv igjen.');
                return;
            }

            if (frame) {
                frame.open();
                return;
            }

            frame = wp.media({
                title: 'Velg profilbilde',
                button: { text: 'Bruk dette bildet' },
                library: { type: 'image' },
                multiple: false
            });

            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                var url = attachment.sizes && attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url;

                $input.val(attachment.id).trigger('change');
                $preview.html('<img src="' + url + '" alt="" style="display:block;width:150px;height:150px;object-fit:cover;border-radius:50%;border:1px solid #dcdcde;">');
                $select.text('Bytt bilde');
                $remove.show();
            });

            frame.open();
        });

        $remove.on('click', function(event) {
            event.preventDefault();
            $input.val('').trigger('change');
            $preview.html('<div style="display:grid;place-items:center;width:150px;height:150px;border-radius:50%;background:#eef1e7;border:1px solid #dcdcde;color:#4f5a3b;font-size:34px;font-weight:700;">MH</div>');
            $select.text('Velg bilde');
            $remove.hide();
        });
    });
})(jQuery);
JS;

    wp_add_inline_script( 'jquery', $script, 'after' );
}
add_action( 'admin_enqueue_scripts', 'morten_portfolio_cv_admin_assets' );

function morten_portfolio_cv_setting_row( $key, $label, $value, $type = 'text', $description = '' ) {
    ?>
    <tr>
        <th scope="row"><label for="morten_cv_<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label></th>
        <td>
            <?php if ( 'textarea' === $type ) : ?>
                <textarea id="morten_cv_<?php echo esc_attr( $key ); ?>" name="morten_cv_settings[<?php echo esc_attr( $key ); ?>]" rows="6" class="large-text"><?php echo esc_textarea( $value ); ?></textarea>
            <?php else : ?>
                <input id="morten_cv_<?php echo esc_attr( $key ); ?>" name="morten_cv_settings[<?php echo esc_attr( $key ); ?>]" type="<?php echo esc_attr( $type ); ?>" value="<?php echo esc_attr( $value ); ?>" class="regular-text">
            <?php endif; ?>
            <?php if ( $description ) : ?><p class="description"><?php echo esc_html( $description ); ?></p><?php endif; ?>
        </td>
    </tr>
    <?php
}

function morten_portfolio_cv_default_settings() {
    return array(
        'portrait_id'      => 0,
        'name'             => 'Morten Hammarstrøm',
        'headline'         => 'Curriculum vitae',
        'address'          => 'Norddalsheia 57, 4641 Søgne',
        'phone'            => '+47 959 15 899',
        'email'            => 'morten.hammarstrom@gmail.com',
        'website'          => 'hammarstrom.no',
        'short_facts'      => "44 år (f. 1982)\nEmigrert nordlending\nSamboer med Dag Alexander og katten Ella\nReiseglad med forkjærlighet for Hellas og Thailand\nEngasjert i trening og fysisk aktivitet\nMotiveres av å bidra til andres utvikling og trivsel",
        'qualifications'   => "Effektiv og nøyaktig\nTrives i hektiske og utfordrende arbeidsmiljøer\nPedagogisk, ærlig og fleksibel\nStrukturert, ryddig og målrettet\nHardtarbeidende med høy arbeidsmoral\nOptimistisk tilnærming og høy gjennomføringsevne",
        'languages'        => "Norsk|100\nEngelsk|100\nSvensk|80\nDansk|50",
        'references'       => 'Tilgjengelige på forespørsel.',
        'digital_cv_label' => 'Digital CV',
        'digital_cv_url'   => 'hammarstrom.no/cv',
    );
}

function morten_portfolio_cv_get_settings() {
    return wp_parse_args( get_option( 'morten_cv_settings', array() ), morten_portfolio_cv_default_settings() );
}

function morten_portfolio_cv_lines( $value ) {
    return array_values( array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) $value ) ) ) );
}

function morten_portfolio_seed_cv_content() {
    if ( get_option( 'morten_portfolio_cv_seeded' ) ) {
        return;
    }

    update_option( 'morten_cv_settings', morten_portfolio_cv_default_settings() );

    $cv_page = get_page_by_path( 'cv' );
    if ( ! $cv_page ) {
        $page_id = wp_insert_post(
            array(
                'post_title'   => 'CV',
                'post_name'    => 'cv',
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'page_template'=> 'page-cv.php',
            )
        );
        if ( $page_id && ! is_wp_error( $page_id ) ) {
            update_post_meta( $page_id, '_wp_page_template', 'page-cv.php' );
        }
    }

    $items = require get_template_directory() . '/inc/cv-data.php';

    $order = 0;
    foreach ( $items['experience'] as $group ) {
        foreach ( $group['roles'] as $role ) {
            $post_id = wp_insert_post(
                array(
                    'post_type'    => 'cv_experience',
                    'post_status'  => 'publish',
                    'post_title'   => $role['title'],
                    'post_content' => isset( $role['description'] ) ? $role['description'] : '',
                    'menu_order'   => $order++,
                )
            );
            if ( $post_id && ! is_wp_error( $post_id ) ) {
                update_post_meta( $post_id, '_morten_cv_company', $group['company'] );
                update_post_meta( $post_id, '_morten_cv_period', $group['period'] );
            }
        }
    }

    foreach ( array( 'education' => 'cv_education', 'courses' => 'cv_course' ) as $source => $post_type ) {
        $order = 0;
        foreach ( $items[ $source ] as $item ) {
            $post_id = wp_insert_post(
                array(
                    'post_type'    => $post_type,
                    'post_status'  => 'publish',
                    'post_title'   => $item['title'],
                    'post_content' => isset( $item['description'] ) ? $item['description'] : '',
                    'menu_order'   => $order++,
                )
            );
            if ( $post_id && ! is_wp_error( $post_id ) ) {
                update_post_meta( $post_id, '_morten_cv_period', $item['period'] );
            }
        }
    }

    update_option( 'morten_portfolio_cv_seeded', 1 );
}
add_action( 'after_switch_theme', 'morten_portfolio_seed_cv_content' );
