<?php
/**
 * Plugin activation routines.
 *
 * @package CV_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CV_Studio_Activator {
    public static function activate() {
        update_option( 'cv_studio_version', CV_STUDIO_VERSION );
        update_option( 'cv_studio_activated_at', current_time( 'mysql' ) );
    }
}
