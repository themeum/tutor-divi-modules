<?php
/**
 * Modules loader
 */

defined( 'ABSPATH' ) || exit;

use \TutorLMS\Divi\Dependency;

require_once DTLMS_DIR_PATH . 'includes/classes/Dependency.php';

$dependency = new Dependency();

if ( ! class_exists( 'ET_Builder_Element' ) || ! defined( 'TUTOR_VERSION' ) ) {
	return;
}

if ( $dependency->is_tutor_file_available() ) {
	if ( ! $dependency->is_tutor_core_has_req_verion() ) {
		add_action( 'admin_notices', array( $dependency, 'show_admin_notice' ) );
		return;
	}
}

$module_files = glob( __DIR__ . '/modules/*/*.php' );

// Load custom Divi Builder modules
foreach ( (array) $module_files as $module_file ) {
	if ( $module_file && preg_match( "/\/modules\/\b([^\/]+)\/\\1\.php$/", $module_file ) ) {
		require_once $module_file;
	}
}
