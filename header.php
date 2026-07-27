<?php
/**
 * Site header.
 *
 * @package Morten_Portfolio
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#main-content"><?php esc_html_e( 'Hopp til innhold', 'morten-portfolio' ); ?></a>
<header class="topbar" id="topbar">
    <div class="container topbar-inner">
        <a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Til forsiden', 'morten-portfolio' ); ?>">
            <?php if ( has_custom_logo() ) : ?>
                <span class="logo-image"><?php the_custom_logo(); ?></span>
            <?php else : ?>
                <span class="logo-mark" aria-hidden="true">MH</span>
            <?php endif; ?>
            <span><?php bloginfo( 'name' ); ?></span>
        </a>

        <button class="menu-button" id="menuButton" type="button" aria-expanded="false" aria-controls="mainNav" aria-label="<?php esc_attr_e( 'Åpne meny', 'morten-portfolio' ); ?>">
            <span></span><span></span><span></span>
        </button>

        <nav class="nav" id="mainNav" aria-label="<?php esc_attr_e( 'Hovedmeny', 'morten-portfolio' ); ?>">
            <?php
            if ( has_nav_menu( 'primary' ) ) {
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'items_wrap'     => '%3$s',
                    'fallback_cb'    => false,
                    'depth'          => 1,
                ) );
            } else {
                ?>
                <a href="<?php echo esc_url( home_url( '/#profil' ) ); ?>"><?php esc_html_e( 'Profil', 'morten-portfolio' ); ?></a>
                <a href="<?php echo esc_url( home_url( '/#erfaring' ) ); ?>"><?php esc_html_e( 'Erfaring', 'morten-portfolio' ); ?></a>
                <a href="<?php echo esc_url( home_url( '/#utdanning' ) ); ?>"><?php esc_html_e( 'Utdanning', 'morten-portfolio' ); ?></a>
                <a href="<?php echo esc_url( home_url( '/#kontakt' ) ); ?>"><?php esc_html_e( 'Kontakt', 'morten-portfolio' ); ?></a>
                <a class="nav-button" href="<?php echo esc_url( home_url( '/cv/' ) ); ?>"><?php esc_html_e( 'Åpne CV', 'morten-portfolio' ); ?></a>
                <?php
            }
            ?>
        </nav>
    </div>
</header>
