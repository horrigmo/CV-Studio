<?php
/** Generic structured CV section. */
if ( empty( $args['post_type'] ) || empty( $args['title'] ) ) {
    return;
}

$query = new WP_Query(
    array(
        'post_type'      => $args['post_type'],
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
        'order'          => 'ASC',
    )
);

if ( ! $query->have_posts() ) {
    return;
}

$is_experience = 'cv_experience' === $args['post_type'];
?>
<section class="cv-section<?php echo $is_experience ? ' cv-section-experience' : ''; ?>">
    <h2><?php echo esc_html( $args['title'] ); ?></h2>

    <?php if ( $is_experience ) : ?>
        <?php
        $groups = array();
        while ( $query->have_posts() ) {
            $query->the_post();
            $company = trim( (string) morten_cv_post_value( get_the_ID(), 'company' ) );
            $key     = $company ? sanitize_title( $company ) : 'uten-arbeidsgiver-' . get_the_ID();

            if ( ! isset( $groups[ $key ] ) ) {
                $groups[ $key ] = array(
                    'company' => $company,
                    'roles'   => array(),
                );
            }

            $groups[ $key ]['roles'][] = array(
                'title'   => morten_cv_post_value( get_the_ID(), 'title' ),
                'period'  => (string) morten_cv_post_value( get_the_ID(), 'period' ),
                'content' => apply_filters( 'the_content', morten_cv_post_value( get_the_ID(), 'content' ) ),
            );
        }
        ?>

        <div class="cv-employer-timeline">
            <?php foreach ( $groups as $group ) : ?>
                <?php
                $role_count   = count( $group['roles'] );
                $group_class  = 'cv-employer-group';
                $group_class .= $role_count > 1 ? ' has-multiple-roles' : '';
                $group_class .= $role_count <= 2 ? ' cv-employer-group-compact' : '';
                ?>
                <section class="<?php echo esc_attr( $group_class ); ?>">
                    <?php if ( $group['company'] ) : ?>
                        <h3 class="cv-employer-name"><?php echo esc_html( $group['company'] ); ?></h3>
                    <?php endif; ?>

                    <div class="cv-role-list">
                        <?php foreach ( $group['roles'] as $role ) : ?>
                            <article class="cv-role-entry">
                                <div class="cv-role-marker" aria-hidden="true"></div>
                                <div class="cv-entry-head">
                                    <h4><?php echo esc_html( $role['title'] ); ?></h4>
                                    <?php if ( $role['period'] ) : ?>
                                        <p class="cv-entry-period"><?php echo esc_html( $role['period'] ); ?></p>
                                    <?php endif; ?>
                                </div>
                                <?php if ( trim( wp_strip_all_tags( $role['content'] ) ) ) : ?>
                                    <div class="cv-entry-content"><?php echo wp_kses_post( $role['content'] ); ?></div>
                                <?php endif; ?>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <div class="cv-timeline">
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                <?php $period = morten_cv_post_value( get_the_ID(), 'period' ); $company = morten_cv_post_value( get_the_ID(), 'company' ); ?>
                <article class="cv-entry">
                    <div class="cv-entry-marker" aria-hidden="true"></div>
                    <div class="cv-entry-head">
                        <div>
                            <h3><?php echo esc_html( morten_cv_post_value( get_the_ID(), 'title' ) ); ?></h3>
                            <?php if ( $company ) : ?><p class="cv-entry-company"><?php echo esc_html( $company ); ?></p><?php endif; ?>
                        </div>
                        <?php if ( $period ) : ?><p class="cv-entry-period"><?php echo esc_html( $period ); ?></p><?php endif; ?>
                    </div>
                    <?php $translated_content=morten_cv_post_value(get_the_ID(),'content'); if(trim($translated_content)): ?><div class="cv-entry-content"><?php echo wp_kses_post(apply_filters('the_content',$translated_content)); ?></div><?php endif; ?>
                </article>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
</section>
<?php wp_reset_postdata(); ?>
