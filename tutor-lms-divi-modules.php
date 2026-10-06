<?php
/*
Plugin Name: Tutor LMS Divi Modules
Description: Easily design your courses and lessons on Divi builder with Tutor LMS
Version:     4.0.0
Author:      Themeum
Author URI:  https://themeum.com
Requires at least: 5.3
Tested up to: 7.0.0
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Text Domain: tutor-lms-divi-modules
Domain Path: /languages
*/

defined( 'ABSPATH' ) || die();

define( 'DTLMS_VERSION', '4.0.0' );
define( 'DTLMS_FILE__', __FILE__ );
define( 'DTLMS_DIR_PATH', plugin_dir_path( DTLMS_FILE__ ) );
define( 'DTLMS_DIR_URL', plugin_dir_url( DTLMS_FILE__ ) );
define( 'DTLMS_ASSETS', trailingslashit( DTLMS_DIR_URL . 'assets' ) );
define( 'DTLMS_TEMPLATES', trailingslashit( DTLMS_DIR_PATH . 'includes/templates/course/' ) );

/**
 * Tutor LMS Divi Modules dependency on Tutor core
 *
 * Define Tutor core version on that Tutor LMS Divi Modules is dependent to run,
 * without require version, it will show admin notice to install require core version.
 *
 * @since v2.0.0
 */
define( 'DTLMS_TUTOR_CORE_REQ_VERSION', '4.0.0' );

/**
 * Environment
 * PROD
 * DEV
 */
define( 'DTLMS_ENV', 'PROD' );

/**
 * Whether Divi 5 is the active builder.
 *
 * @since 4.0.0
 * @return bool
 */
function dtlms_is_divi5() {
	return function_exists( 'et_builder_d5_enabled' ) && et_builder_d5_enabled();
}

/**
 * Load Divi 5 module files.
 *
 * Divi 5 classes are not available at plugin load time, so this runs on Divi 5 hooks.
 *
 * @since 4.0.0
 * @return void
 */
function dtlms_load_divi5_modules() {
	static $loaded = false;

	if ( $loaded ) {
		return;
	}

	if ( ! dtlms_is_divi5() ) {
		return;
	}

	if ( ! defined( 'TUTOR_VERSION' ) ) {
		return;
	}

	require_once DTLMS_DIR_PATH . 'includes/functions.php';
	require_once DTLMS_DIR_PATH . 'includes/classes/Helper.php';
	require_once DTLMS_DIR_PATH . 'includes/div5modules/index.php';

	$loaded = true;
}

/**
 * Register Divi 5 modules when the Divi 5 module library boots.
 *
 * This action only fires when Divi 5 is active.
 *
 * @since 4.0.0
 * @param object $dependency_tree Divi 5 module dependency tree.
 * @return void
 */
function dtlms_initialize_divi5_modules( $dependency_tree ) {
	dtlms_load_divi5_modules();

	if ( function_exists( 'dtlms_d5_register_modules' ) ) {
		dtlms_d5_register_modules( $dependency_tree );
	}
}
add_action( 'divi_module_library_modules_dependency_tree', 'dtlms_initialize_divi5_modules' );

/**
 * Ensure Divi 5 files are loaded before Visual Builder assets enqueue.
 *
 * @since 4.0.0
 * @return void
 */
function dtlms_load_divi5_visual_builder_assets() {
	dtlms_load_divi5_modules();
}
add_action( 'divi_visual_builder_assets_before_enqueue_scripts', 'dtlms_load_divi5_visual_builder_assets', 0 );

/**
 * Register "Edit with Divi" in the Tutor course builder.
 *
 * This cannot wait for `divi_extensions_init`. Divi 5 skips that hook
 * when this plugin already uses Divi 5 module hooks.
 *
 * @since 4.0.0
 * @return void
 */
function dtlms_register_course_builder_editor() {
	if ( ! defined( 'TUTOR_VERSION' ) ) {
		return;
	}

	require_once DTLMS_DIR_PATH . 'includes/classes/CourseBuilderEditor.php';
}
add_action( 'init', 'dtlms_register_course_builder_editor' );

if ( ! function_exists( 'tudm_initialize_extension' ) ) :
	/**
	 * Creates the extension's main class instance.
	 *
	 * @since 1.0.0
	 */
	function tudm_initialize_extension() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/classes/Dependency.php';
		require_once plugin_dir_path( __FILE__ ) . 'includes/TutorDiviModules.php';
	}

	/**
	 * Load plugin text domain.
 	 *
	 * @since 1.0.0
	 */
	add_action( 'init', 'tutor_divi_textdomain' );
	if ( ! function_exists( 'tutor_divi_textdomain' ) ) {
		function tutor_divi_textdomain() {
			load_plugin_textdomain( 'tutor-lms-divi-modules', false, dirname( plugin_basename( __FILE__ ) . '/languages' ) );
		}
	}

	add_action( 'divi_extensions_init', 'tudm_initialize_extension' );
endif;

