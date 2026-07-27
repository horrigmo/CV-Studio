<?php
/**
 * Cleanup performed when CV Studio is deleted from WordPress.
 *
 * @package CV_Studio
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

delete_option( 'cv_studio_version' );
delete_option( 'cv_studio_activated_at' );
delete_option( 'cv_studio_deactivated_at' );
