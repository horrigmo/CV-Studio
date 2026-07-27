<?php
/**
 * WordPress admin functionality.
 *
 * @package CV_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CV_Studio_Admin {
    const PAGE_SLUG = 'cv-studio';

    public function register_menu() {
        add_menu_page(
            __( 'CV Studio', 'cv-studio' ),
            __( 'CV Studio', 'cv-studio' ),
            'manage_options',
            self::PAGE_SLUG,
            array( $this, 'render_dashboard' ),
            'dashicons-id-alt',
            58
        );
    }

    public function enqueue_assets( $hook_suffix ) {
        if ( 'toplevel_page_' . self::PAGE_SLUG !== $hook_suffix ) {
            return;
        }

        wp_enqueue_style(
            'cv-studio-admin',
            CV_STUDIO_URL . 'assets/css/admin.css',
            array(),
            CV_STUDIO_VERSION
        );
    }

    public function render_dashboard() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'You do not have permission to access this page.', 'cv-studio' ) );
        }

        $template = CV_STUDIO_PATH . 'templates/admin/dashboard.php';

        if ( file_exists( $template ) ) {
            include $template;
            return;
        }

        echo '<div class="wrap"><h1>' . esc_html__( 'CV Studio', 'cv-studio' ) . '</h1></div>';
    }
}
