<?php
/**
 * Plugin deactivation routines.
 *
 * @package CV_Studio
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CV_Studio_Deactivator {
    public static function deactivate() {
        update_option( 'cv_studio_deactivated_at', current_time( 'mysql' ) );
    }
}
