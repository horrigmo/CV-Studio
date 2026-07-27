<?php
/**
 * Default posts template.
 *
 * @package Morten_Portfolio
 */
get_header();
?>
<main id="main-content" class="content-shell">
    <div class="container narrow content-area">
        <?php if ( have_posts() ) : ?>
            <header class="page-header">
                <span class="eyebrow"><?php esc_html_e( 'Innhold', 'morten-portfolio' ); ?></span>
                <h1><?php bloginfo( 'name' ); ?></h1>
            </header>
            <?php while ( have_posts() ) : the_post(); ?>
                <article <?php post_class( 'content-card' ); ?>>
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <?php the_excerpt(); ?>
                </article>
            <?php endwhile; ?>
            <?php the_posts_pagination(); ?>
        <?php else : ?>
            <article class="content-card"><h1><?php esc_html_e( 'Ingen innlegg funnet', 'morten-portfolio' ); ?></h1></article>
        <?php endif; ?>
    </div>
</main>
<?php get_footer(); ?>
