<?php
/**
 * Customizer settings.
 *
 * @package Morten_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function morten_portfolio_sanitize_url_or_path( $value ) {
    $value = trim( (string) $value );
    if ( 0 === strpos( $value, '#' ) || 0 === strpos( $value, '/' ) ) {
        return sanitize_text_field( $value );
    }
    return esc_url_raw( $value );
}

function morten_portfolio_customize_register( $wp_customize ) {
    $wp_customize->add_panel( 'morten_portfolio_content', array(
        'title'       => __( 'Porteføljeinnhold', 'morten-portfolio' ),
        'description' => __( 'Rediger tekst og lenker på forsiden.', 'morten-portfolio' ),
        'priority'    => 30,
    ) );

    $sections = array(
        'hero'       => __( 'Hero', 'morten-portfolio' ),
        'profile'    => __( 'Profil', 'morten-portfolio' ),
        'experience' => __( 'Erfaring', 'morten-portfolio' ),
        'education'  => __( 'Utdanning', 'morten-portfolio' ),
        'contact'    => __( 'Kontakt', 'morten-portfolio' ),
    );

    foreach ( $sections as $id => $title ) {
        $wp_customize->add_section( 'morten_' . $id, array(
            'title' => $title,
            'panel' => 'morten_portfolio_content',
        ) );
    }

    $fields = array(
        array( 'hero_eyebrow', 'morten_hero', __( 'Overtittel', 'morten-portfolio' ), 'Profesjonell profil', 'text' ),
        array( 'hero_title', 'morten_hero', __( 'Hovedtittel', 'morten-portfolio' ), 'Struktur, analyse og', 'text' ),
        array( 'hero_highlight', 'morten_hero', __( 'Uthevet tittel', 'morten-portfolio' ), 'menneskelig forståelse.', 'text' ),
        array( 'hero_lead', 'morten_hero', __( 'Introduksjon', 'morten-portfolio' ), 'Erfaring fra finans, luftfart og kundeservice, kombinert med en bachelorgrad i ledelse. Jeg trives best i roller der kvalitet, ansvar og tydelig kommunikasjon står sentralt.', 'textarea' ),
        array( 'hero_primary_label', 'morten_hero', __( 'Primær knappetekst', 'morten-portfolio' ), 'Se full CV', 'text' ),
        array( 'hero_primary_url', 'morten_hero', __( 'Primær knappelenke', 'morten-portfolio' ), '/cv', 'url_or_path' ),
        array( 'hero_secondary_label', 'morten_hero', __( 'Sekundær knappetekst', 'morten-portfolio' ), 'Ta kontakt', 'text' ),
        array( 'hero_secondary_url', 'morten_hero', __( 'Sekundær knappelenke', 'morten-portfolio' ), '#kontakt', 'url_or_path' ),

        array( 'profile_title', 'morten_profile', __( 'Profiloverskrift', 'morten-portfolio' ), 'En rolig og løsningsorientert tilnærming.', 'text' ),
        array( 'profile_intro', 'morten_profile', __( 'Profiltekst', 'morten-portfolio' ), 'Jeg arbeider strukturert, lærer raskt og tar ansvar for at oppgaver blir fulgt helt i mål.', 'textarea' ),

        array( 'experience_title', 'morten_experience', __( 'Erfaringsoverskrift', 'morten-portfolio' ), 'Arbeidserfaring fra tre tydelige fagområder.', 'text' ),

        array( 'education_title', 'morten_education', __( 'Utdanning', 'morten-portfolio' ), 'Bachelor of Management', 'text' ),
        array( 'education_school', 'morten_education', __( 'Skole', 'morten-portfolio' ), 'Handelshøyskolen BI', 'text' ),
        array( 'education_period', 'morten_education', __( 'Periode', 'morten-portfolio' ), '2018–2022', 'text' ),
        array( 'education_text', 'morten_education', __( 'Beskrivelse', 'morten-portfolio' ), 'Fordypning i ledelse, endringsledelse og økonomi, med fag innen blant annet teamutvikling, coaching, logistikk, finans og digital forretningsforståelse.', 'textarea' ),

        array( 'contact_title', 'morten_contact', __( 'Kontaktoverskrift', 'morten-portfolio' ), 'Ta gjerne kontakt.', 'text' ),
        array( 'contact_text', 'morten_contact', __( 'Kontakttekst', 'morten-portfolio' ), 'Kontaktinformasjon er også tilgjengelig i den fullstendige CV-en.', 'textarea' ),
        array( 'contact_email', 'morten_contact', __( 'E-post', 'morten-portfolio' ), 'morten.hammarstrom@gmail.com', 'email' ),
        array( 'contact_phone', 'morten_contact', __( 'Telefon', 'morten-portfolio' ), '+47 959 15 899', 'text' ),
        array( 'contact_website', 'morten_contact', __( 'Nettside', 'morten-portfolio' ), 'https://hammarstrom.no', 'url' ),
        array( 'contact_website_label', 'morten_contact', __( 'Nettsidetekst', 'morten-portfolio' ), 'hammarstrom.no', 'text' ),
    );

    foreach ( $fields as $field ) {
        list( $id, $section, $label, $default, $type ) = $field;

        $sanitize = 'sanitize_text_field';
        if ( 'textarea' === $type ) {
            $sanitize = 'sanitize_textarea_field';
        } elseif ( 'email' === $type ) {
            $sanitize = 'sanitize_email';
        } elseif ( 'url' === $type ) {
            $sanitize = 'esc_url_raw';
        } elseif ( 'url_or_path' === $type ) {
            $sanitize = 'morten_portfolio_sanitize_url_or_path';
        }

        $wp_customize->add_setting( $id, array(
            'default'           => $default,
            'sanitize_callback' => $sanitize,
            'transport'         => 'refresh',
        ) );

        $wp_customize->add_control( $id, array(
            'section' => $section,
            'label'   => $label,
            'type'    => 'textarea' === $type ? 'textarea' : ( 'url_or_path' === $type ? 'text' : $type ),
        ) );
    }
}
add_action( 'customize_register', 'morten_portfolio_customize_register' );
