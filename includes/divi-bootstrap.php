<?php
/**
 * Divi 5 bootstrap.
 *
 * Loaded from the plugin entry file. Divi 5 skips `divi_extensions_init`
 * once this plugin registers Divi 5 modules, so these hooks cannot wait
 * for TutorDiviModules.
 *
 * @package TutorLMS\Divi
 */

defined( 'ABSPATH' ) || exit;

/**
 * Whether Divi 5 is the active builder.
 *
 * @since 4.0.1
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
 * @since 4.0.1
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
 * @since 4.0.1
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
 * @since 4.0.1
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
 * @since 4.0.1
 * @return void
 */
function dtlms_register_course_builder_editor() {
	if ( ! defined( 'TUTOR_VERSION' ) ) {
		return;
	}

	require_once DTLMS_DIR_PATH . 'includes/classes/CourseBuilderEditor.php';
}
add_action( 'init', 'dtlms_register_course_builder_editor' );

/**
 * Replace Tutor's single course template when the course uses Divi 5.
 *
 * Divi 5 skips `divi_extensions_init`, so TutorDiviModules never loads and
 * the template override in Template.php never runs. The imported layout then
 * stays nested inside Tutor's default course details markup.
 *
 * @since 4.0.1
 * @return void
 */
function dtlms_load_single_course_template() {
	if ( ! defined( 'TUTOR_VERSION' ) || ! dtlms_is_divi5() ) {
		return;
	}

	if ( class_exists( 'TutorLMS\\Divi\\Template', false ) ) {
		return;
	}

	require_once DTLMS_DIR_PATH . 'includes/functions.php';
	require_once DTLMS_DIR_PATH . 'includes/classes/Template.php';
}
add_action( 'init', 'dtlms_load_single_course_template' );
