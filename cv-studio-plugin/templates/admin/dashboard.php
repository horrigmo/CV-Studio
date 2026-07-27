<?php
/**
 * CV Studio admin dashboard template.
 *
 * @package CV_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<div class="wrap cv-studio-admin">
    <header class="cv-studio-admin__header">
        <div>
            <p class="cv-studio-admin__eyebrow"><?php esc_html_e( 'CV Studio', 'cv-studio' ); ?></p>
            <h1><?php esc_html_e( 'Plugin foundation is active', 'cv-studio' ); ?></h1>
            <p class="cv-studio-admin__intro">
                <?php esc_html_e( 'The plugin is installed correctly and the first administration module is running.', 'cv-studio' ); ?>
            </p>
        </div>
        <span class="cv-studio-admin__version">
            <?php echo esc_html( sprintf( __( 'Version %s', 'cv-studio' ), CV_STUDIO_VERSION ) ); ?>
        </span>
    </header>

    <section class="cv-studio-admin__grid" aria-label="<?php esc_attr_e( 'Plugin status', 'cv-studio' ); ?>">
        <article class="cv-studio-admin__card">
            <span class="dashicons dashicons-yes-alt" aria-hidden="true"></span>
            <h2><?php esc_html_e( 'Plugin active', 'cv-studio' ); ?></h2>
            <p><?php esc_html_e( 'WordPress has loaded the CV Studio bootstrap and core classes successfully.', 'cv-studio' ); ?></p>
        </article>

        <article class="cv-studio-admin__card">
            <span class="dashicons dashicons-admin-generic" aria-hidden="true"></span>
            <h2><?php esc_html_e( 'Admin module ready', 'cv-studio' ); ?></h2>
            <p><?php esc_html_e( 'The CV Studio menu and dashboard are registered through the plugin.', 'cv-studio' ); ?></p>
        </article>

        <article class="cv-studio-admin__card">
            <span class="dashicons dashicons-translation" aria-hidden="true"></span>
            <h2><?php esc_html_e( 'Translation-ready', 'cv-studio' ); ?></h2>
            <p><?php esc_html_e( 'The foundation supports a dedicated text domain for future Norwegian and English content.', 'cv-studio' ); ?></p>
        </article>
    </section>

    <section class="cv-studio-admin__next-step">
        <h2><?php esc_html_e( 'Next development step', 'cv-studio' ); ?></h2>
        <p><?php esc_html_e( 'The next sprint can add the CV data model and the first editable profile section without moving presentation logic into the plugin.', 'cv-studio' ); ?></p>
    </section>
</div>
