<?php
/**
 * Single post template.
 *
 * @package Morten_Portfolio
 */
get_header();
?>
<main id="main-content" class="content-shell">
    <div class="container narrow content-area">
        <?php while ( have_posts() ) : the_post(); ?>
            <article <?php post_class( 'content-card content-card--page' ); ?>>
                <header class="page-header"><span class="eyebrow"><?php echo esc_html( get_the_date() ); ?></span><h1><?php the_title(); ?></h1></header>
                <div class="entry-content"><?php the_content(); ?></div>
            </article>
        <?php endwhile; ?>
    </div>
</main>
<?php get_footer(); ?>
