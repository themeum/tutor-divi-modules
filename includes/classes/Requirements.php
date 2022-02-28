<?php
/**
 * Tutor Divi Modules package
 * check plugin requirements/dependency
 *
 * @since 1.0.0
 * @author Themeum <www.themeum.com>
 */

namespace TutorLMS\Divi;

defined( 'ABSPATH' ) || exit;

class Requirements {

	/**
	 * trigger require hooks on class init
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		add_action( 'admin_init', array( $this, 'check_plugin_dependency' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 99 );
	}

	/**
	 * check dependency
	 *
	 * @since 1.0.0
	 */
	public function check_plugin_dependency() {
		if ( ! defined( 'TUTOR_VERSION' ) ) {
			// Required Tutor Message
			add_action( 'admin_notices', array( $this, 'required_tutor_lms' ) );
		} else {
			$dependency = new Dependency;
			if ( ! $dependency->is_tutor_core_has_req_verion() ) {
				add_action( 'admin_notices', array( $dependency, 'show_admin_notice' ) );
			}
		}
	}

	/**
	 * generate admin notice
	 *
	 * @since 1.0.0
	 */
	public function required_tutor_lms() {
		include_once dtlms_get_template( 'admin_notice' );
	}

	/**
	 * Enqueue admin styles
	 *
	 * @since 1.0.0
	 */
	public function admin_enqueue_scripts() {
		wp_enqueue_style(
			'tutor-divi-admin-notice-min-css',
			DTLMS_ASSETS . 'css/admin_notice.min.css',
			null,
			DTLMS_VERSION
		);

	}

}

new Requirements();
