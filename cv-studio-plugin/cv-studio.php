<?php
/**
 * Plugin Name: CV Studio
 * Plugin URI: https://github.com/horrigmo/CV-Studio
 * Description: Professional CV management for WordPress.
 * Version: 0.1.0
 * Author: Dag Alexander Horrigmo
 * Text Domain: cv-studio
 * Domain Path: /languages
 * Requires at least: 6.4
 * Requires PHP: 8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'CV_STUDIO_VERSION', '0.1.0' );
define( 'CV_STUDIO_FILE', __FILE__ );
define( 'CV_STUDIO_PATH', plugin_dir_path( __FILE__ ) );
define( 'CV_STUDIO_URL', plugin_dir_url( __FILE__ ) );

require_once CV_STUDIO_PATH . 'includes/class-cv-studio-activator.php';
require_once CV_STUDIO_PATH . 'includes/class-cv-studio-deactivator.php';
require_once CV_STUDIO_PATH . 'includes/class-cv-studio-plugin.php';

register_activation_hook( __FILE__, array( 'CV_Studio_Activator', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'CV_Studio_Deactivator', 'deactivate' ) );

function cv_studio_run() {
    $plugin = new CV_Studio_Plugin();
    $plugin->run();
}

cv_studio_run();
