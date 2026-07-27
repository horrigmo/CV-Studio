<?php
/**
 * 404 template.
 *
 * @package Morten_Portfolio
 */
get_header();
?>
<main id="main-content" class="content-shell">
    <div class="container narrow content-area">
        <article class="content-card content-card--page">
            <span class="eyebrow">404</span>
            <h1><?php esc_html_e( 'Siden ble ikke funnet', 'morten-portfolio' ); ?></h1>
            <p><?php esc_html_e( 'Lenken kan være utdatert, eller siden kan ha blitt flyttet.', 'morten-portfolio' ); ?></p>
            <a class="button primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Til forsiden', 'morten-portfolio' ); ?></a>
        </article>
    </div>
</main>
<?php get_footer(); ?>
