<?php
/**
 * Modules loader
 */

defined( 'ABSPATH' ) || exit;

use \TutorLMS\Divi\Dependency;

$dependency = new Dependency();

if ( ! class_exists( 'ET_Builder_Element' ) || ! defined( 'TUTOR_VERSION' ) ) {
	return;
}

if ( $dependency->is_tutor_file_available() ) {
	if ( ! $dependency->is_tutor_core_has_req_verion() ) {
		return;
	}
}

$module_files = glob( __DIR__ . '/modules/*/*.php' );

// Modules that have a Divi 5 implementation should not load their Divi 4 class when Divi 5 is active.
$d5_replaced_modules = array();
if ( function_exists( 'dtlms_is_divi5' ) && dtlms_is_divi5() ) {
	$d5_replaced_modules = array(
		'CourseTitle',
		'CourseAbout',
	);
}

// Load custom Divi Builder modules
foreach ( (array) $module_files as $module_file ) {
	if ( $module_file && preg_match( "/\/modules\/\b([^\/]+)\/\\1\.php$/", $module_file, $matches ) ) {
		if ( in_array( $matches[1], $d5_replaced_modules, true ) ) {
			continue;
		}

		require_once $module_file;
	}
}
