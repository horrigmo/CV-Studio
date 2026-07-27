<?php
/**
 * Theme setup and asset loading.
 *
 * @package Morten_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function morten_portfolio_setup() {
    load_theme_textdomain( 'morten-portfolio', get_template_directory() . '/languages' );

    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 80,
            'width'       => 80,
            'flex-height' => true,
            'flex-width'  => true,
        )
    );
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'align-wide' );

    register_nav_menus(
        array(
            'primary' => __( 'Hovedmeny', 'morten-portfolio' ),
        )
    );
}
add_action( 'after_setup_theme', 'morten_portfolio_setup' );

function morten_portfolio_asset_version( $relative_path ) {
    $absolute_path = get_template_directory() . $relative_path;

    return file_exists( $absolute_path )
        ? (string) filemtime( $absolute_path )
        : wp_get_theme()->get( 'Version' );
}

function morten_portfolio_assets() {
    wp_enqueue_style(
        'morten-portfolio-main',
        get_template_directory_uri() . '/assets/css/main.css',
        array(),
        morten_portfolio_asset_version( '/assets/css/main.css' )
    );

    if ( is_page_template( 'page-cv.php' ) || is_page( 'cv' ) ) {
        wp_enqueue_style(
            'morten-portfolio-cv',
            get_template_directory_uri() . '/assets/css/cv.css',
            array( 'morten-portfolio-main' ),
            morten_portfolio_asset_version( '/assets/css/cv.css' )
        );

        wp_enqueue_script(
            'morten-portfolio-cv',
            get_template_directory_uri() . '/assets/js/cv.js',
            array(),
            morten_portfolio_asset_version( '/assets/js/cv.js' ),
            array(
                'strategy'  => 'defer',
                'in_footer' => true,
            )
        );

        return;
    }

    wp_enqueue_script(
        'morten-portfolio-app',
        get_template_directory_uri() . '/assets/js/app.js',
        array(),
        morten_portfolio_asset_version( '/assets/js/app.js' ),
        array(
            'strategy'  => 'defer',
            'in_footer' => true,
        )
    );
}
add_action( 'wp_enqueue_scripts', 'morten_portfolio_assets' );

function morten_portfolio_excerpt_length( $length ) {
    return 28;
}
add_filter( 'excerpt_length', 'morten_portfolio_excerpt_length', 999 );

$customizer_file = get_template_directory() . '/inc/customizer.php';
if ( file_exists( $customizer_file ) ) {
    require $customizer_file;
}

$cv_admin_file = get_template_directory() . '/inc/cv-admin.php';
if ( file_exists( $cv_admin_file ) ) {
    require $cv_admin_file;
}

$cv_suite_file = get_template_directory() . '/inc/cv-suite.php';
if ( file_exists( $cv_suite_file ) ) {
    require_once $cv_suite_file;
}
