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
use TutorLMS\Divi\D5\CourseAuthor\CourseAuthor;
use TutorLMS\Divi\D5\CourseBenefits\CourseBenefits;
use TutorLMS\Divi\D5\CourseCarousel\CourseCarousel;
use TutorLMS\Divi\D5\CourseCategories\CourseCategories;
use TutorLMS\Divi\D5\CourseContent\CourseContent;
use TutorLMS\Divi\D5\CourseCurriculum\CourseCurriculum;
use TutorLMS\Divi\D5\CourseDuration\CourseDuration;
use TutorLMS\Divi\D5\CourseEnrollment\CourseEnrollment;
use TutorLMS\Divi\D5\CourseInstructor\CourseInstructor;
use TutorLMS\Divi\D5\CourseLastUpdate\CourseLastUpdate;
use TutorLMS\Divi\D5\CourseLevel\CourseLevel;
use TutorLMS\Divi\D5\CourseMaterials\CourseMaterials;
use TutorLMS\Divi\D5\CoursePrice\CoursePrice;
use TutorLMS\Divi\D5\CoursePurchase\CoursePurchase;
use TutorLMS\Divi\D5\CourseList\CourseList;
use TutorLMS\Divi\D5\CourseTitle\CourseTitle;

require_once __DIR__ . '/course-title/CourseTitle.php';
require_once __DIR__ . '/course-about/CourseAbout.php';
require_once __DIR__ . '/course-author/CourseAuthor.php';
require_once __DIR__ . '/course-list/CourseList.php';
require_once __DIR__ . '/course-carousel/CourseCarousel.php';
require_once __DIR__ . '/course-benefits/CourseBenefits.php';
require_once __DIR__ . '/course-categories/CourseCategories.php';
require_once __DIR__ . '/course-content/CourseContent.php';
require_once __DIR__ . '/course-curriculum/CourseCurriculum.php';
require_once __DIR__ . '/course-duration/CourseDuration.php';
require_once __DIR__ . '/course-enrollment/CourseEnrollment.php';
require_once __DIR__ . '/course-instructor/CourseInstructor.php';
require_once __DIR__ . '/course-last-update/CourseLastUpdate.php';
require_once __DIR__ . '/course-level/CourseLevel.php';
require_once __DIR__ . '/course-materials/CourseMaterials.php';
require_once __DIR__ . '/course-price/CoursePrice.php';
require_once __DIR__ . '/course-purchase/CoursePurchase.php';

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
	$dependency_tree->add_dependency( new CourseAuthor() );
	$dependency_tree->add_dependency( new CourseList() );
	$dependency_tree->add_dependency( new CourseCarousel() );
	$dependency_tree->add_dependency( new CourseBenefits() );
	$dependency_tree->add_dependency( new CourseCategories() );
	$dependency_tree->add_dependency( new CourseContent() );
	$dependency_tree->add_dependency( new CourseCurriculum() );
	$dependency_tree->add_dependency( new CourseDuration() );
	$dependency_tree->add_dependency( new CourseEnrollment() );
	$dependency_tree->add_dependency( new CourseInstructor() );
	$dependency_tree->add_dependency( new CourseLastUpdate() );
	$dependency_tree->add_dependency( new CourseLevel() );
	$dependency_tree->add_dependency( new CourseMaterials() );
	$dependency_tree->add_dependency( new CoursePrice() );
	$dependency_tree->add_dependency( new CoursePurchase() );
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

	$script_dependencies = array(
		'divi-vendor-react',
		'jquery',
		'divi-data',
		'divi-module',
		'divi-module-library',
		'divi-rest',
		'divi-vendor-wp-hooks',
	);

	\ET\Builder\VisualBuilder\Assets\PackageBuildManager::register_package_build(
		array(
			'name'    => 'tutor-lms-divi-5-visual-builder',
			'version' => DTLMS_VERSION,
			'script'  => array(
				'src'                => DTLMS_DIR_URL . 'includes/div5modules/build/tutor-lms-divi-5.js',
				'deps'               => $script_dependencies,
				'enqueue_top_window' => false,
				'enqueue_app_window' => true,
				'data_app_window'    => array_merge(
					CourseList::visual_builder_data(),
					CourseCarousel::visual_builder_data(),
				),
			),
		)
	);
}
add_action( 'divi_visual_builder_assets_before_enqueue_scripts', 'dtlms_d5_enqueue_visual_builder_assets' );

/**
 * Enqueue front-end assets.
 *
 * Divi 5 skips divi_extensions_init when this plugin registers Divi 5 modules,
 * so TutorDiviModules never runs and never enqueues these files.
 *
 * @since 4.0.0
 * @return void
 */
function dtlms_enqueue_frontend_assets() {
	if ( class_exists( 'TutorDiviModules', false ) || ! defined( 'TUTOR_VERSION' ) ) {
		return;
	}

	$version  = 'DEV' === DTLMS_ENV ? time() : DTLMS_VERSION;
	$css_file = 'DEV' === DTLMS_ENV ? 'css/tutor-divi-style.css' : 'css/tutor-divi-style.min.css';

	wp_enqueue_style(
		'tutor-divi-styles',
		DTLMS_ASSETS . $css_file,
		array(),
		$version
	);

	wp_enqueue_script(
		'tutor-divi-scripts',
		DTLMS_ASSETS . 'js/scripts.js',
		array( 'jquery' ),
		DTLMS_VERSION,
		true
	);

	$inline_data = array(
		'is_divi_builder' => isset( $_GET['et_fb'] ) ? sanitize_text_field( wp_unslash( $_GET['et_fb'] ) ) : false,
	);

	wp_add_inline_script( 'tutor-divi-scripts', 'const dtlmsData = ' . wp_json_encode( $inline_data ), 'before' );
}
add_action( 'wp_enqueue_scripts', 'dtlms_enqueue_frontend_assets', 99 );
