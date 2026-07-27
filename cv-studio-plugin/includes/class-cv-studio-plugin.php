<?php
/**
 * Core plugin bootstrap.
 *
 * @package CV_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CV_Studio_Plugin {
    public function run() {
        $this->load_dependencies();
        $this->register_hooks();
    }

    private function load_dependencies() {
        require_once CV_STUDIO_PATH . 'includes/admin/class-cv-studio-admin.php';
    }

    private function register_hooks() {
        $admin = new CV_Studio_Admin();

        add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
        add_action( 'admin_menu', array( $admin, 'register_menu' ) );
        add_action( 'admin_enqueue_scripts', array( $admin, 'enqueue_assets' ) );
    }

    public function load_textdomain() {
        load_plugin_textdomain(
            'cv-studio',
            false,
            dirname( plugin_basename( CV_STUDIO_FILE ) ) . '/languages'
        );
    }
}
