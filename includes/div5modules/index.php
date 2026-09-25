<?php
/**
 * Divi 5 module bootstrap.
 *
 * Loaded only when Divi 5 is active.
 *
 * @package TutorLMS\Divi
 */

defined( 'ABSPATH' ) || exit;

use TutorLMS\Divi\D5\CourseAbout\CourseAbout;
use TutorLMS\Divi\D5\CourseTitle\CourseTitle;
use TutorLMS\Divi\Helper;

require_once __DIR__ . '/course-title/CourseTitle.php';
require_once __DIR__ . '/course-about/CourseAbout.php';

/**
 * Inject published course options into Divi 5 Course select fields.
 *
 * @param array $metadata Module metadata.
 * @return array
 */
function dtlms_d5_inject_course_field_options( $metadata ) {
	$module_names = array( 'tutor-lms/course-title', 'tutor-lms/course-about' );

	if ( empty( $metadata['name'] ) || ! in_array( $metadata['name'], $module_names, true ) ) {
		return $metadata;
	}

	if ( ! class_exists( Helper::class ) ) {
		return $metadata;
	}

	$options = array();

	foreach ( Helper::get_courses() as $course_id => $label ) {
		if ( ! is_numeric( $course_id ) ) {
			continue;
		}

		$options[ (string) $course_id ] = array(
			'label' => $label,
		);
	}

	if ( empty( $options ) ) {
		return $metadata;
	}

	$metadata['attributes']['content']['settings']['advanced']['course']['item']['component']['props']['options'] = $options;

	return $metadata;
}
add_filter( 'block_type_metadata', 'dtlms_d5_inject_course_field_options' );

/**
 * Default the Course field to the current course when editing a course.
 *
 * @param array $defaults Default attributes.
 * @return array
 */
function dtlms_d5_default_course_attributes( $defaults ) {
	if ( ! class_exists( Helper::class ) ) {
		return $defaults;
	}

	$course_id = Helper::get_course_default();

	if ( $course_id ) {
		$defaults['content']['advanced']['course']['desktop']['value'] = (string) $course_id;
	}

	return $defaults;
}
add_filter( 'divi_module_library_module_default_attributes_tutor-lms/course-title', 'dtlms_d5_default_course_attributes' );
add_filter( 'divi_module_library_module_default_attributes_tutor-lms/course-about', 'dtlms_d5_default_course_attributes' );

/**
 * Register Divi 5 modules with the module library dependency tree.
 *
 * Called from the plugin bootstrap when Divi 5 is active.
 *
 * @param object $dependency_tree Divi 5 dependency tree.
 * @return void
 */
function dtlms_d5_register_modules( $dependency_tree ) {
	$dependency_tree->add_dependency( new CourseTitle() );
	$dependency_tree->add_dependency( new CourseAbout() );
}

/**
 * Enqueue Divi 5 Visual Builder assets.
 *
 * @return void
 */
function dtlms_d5_enqueue_visual_builder_assets() {
	if ( ! function_exists( 'et_core_is_fb_enabled' ) || ! et_core_is_fb_enabled() ) {
		return;
	}

	if ( ! function_exists( 'et_builder_d5_enabled' ) || ! et_builder_d5_enabled() ) {
		return;
	}

	$script_path = __DIR__ . '/build/tutor-lms-divi-5.js';

	if ( ! file_exists( $script_path ) ) {
		return;
	}

	\ET\Builder\VisualBuilder\Assets\PackageBuildManager::register_package_build(
		array(
			'name'    => 'tutor-lms-divi-5-visual-builder',
			'version' => DTLMS_VERSION,
			'script'  => array(
				'src'                => DTLMS_DIR_URL . 'includes/div5modules/build/tutor-lms-divi-5.js',
				'deps'               => array(
					'divi-vendor-react',
					'jquery',
					'divi-module',
					'divi-module-library',
					'divi-rest',
					'divi-vendor-wp-hooks',
				),
				'enqueue_top_window' => false,
				'enqueue_app_window' => true,
			),
		)
	);
}
add_action( 'divi_visual_builder_assets_before_enqueue_scripts', 'dtlms_d5_enqueue_visual_builder_assets' );
