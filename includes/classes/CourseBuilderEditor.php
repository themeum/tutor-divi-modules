<?php
/**
 * Register Divi as a Tutor course builder editor.
 *
 * These filters must load independently of `divi_extensions_init`.
 * Divi 5 does not fire that hook for plugins that already use Divi 5
 * module hooks, so TutorDiviModules is never constructed on course
 * builder REST requests.
 *
 * @package TutorLMS\Divi
 * @since 4.0.0
 */

namespace TutorLMS\Divi;

defined( 'ABSPATH' ) || exit;

/**
 * Add "Edit with Divi" to the Tutor course builder.
 */
class CourseBuilderEditor {

	/**
	 * Register Tutor course builder filters.
	 *
	 * @since 4.0.0
	 */
	public function __construct() {
		add_filter( 'tutor_course_builder_editor_list', array( $this, 'add_edit_with_divi_button' ), 10, 2 );
		add_filter( 'tutor_course_builder_editor_used', array( $this, 'check_divi_builder' ), 10, 2 );
	}

	/**
	 * Whether Divi is available for course editing.
	 *
	 * @since 4.0.0
	 * @return bool
	 */
	private function is_divi_available() {
		return function_exists( 'et_setup_theme' ) || function_exists( 'et_builder_d5_enabled' );
	}

	/**
	 * Whether the course is currently using the Divi builder.
	 *
	 * @since 4.0.0
	 * @param int $post_id Course ID.
	 * @return bool
	 */
	private function is_divi_used( $post_id ) {
		if ( function_exists( 'et_pb_is_pagebuilder_used' ) ) {
			return (bool) et_pb_is_pagebuilder_used( $post_id );
		}

		return 'on' === get_post_meta( $post_id, '_et_pb_use_builder', true );
	}

	/**
	 * Visual Builder URL for a course.
	 *
	 * @since 4.0.0
	 * @param int  $post_id     Course ID.
	 * @param bool $is_divi_used Whether Divi is already enabled on the course.
	 * @return string
	 */
	private function get_builder_link( $post_id, $is_divi_used ) {
		if ( $is_divi_used && function_exists( 'et_fb_get_vb_url' ) ) {
			return et_fb_get_vb_url( get_permalink( $post_id ) );
		}

		$query_args = $is_divi_used
			? array(
				'et_fb'     => 1,
				'PageSpeed' => 'off',
			)
			: array(
				'et_fb_activation_nonce' => wp_create_nonce( 'et_fb_activation_nonce_' . $post_id ),
			);

		return add_query_arg( $query_args, get_permalink( $post_id ) );
	}

	/**
	 * Add Divi to the course builder editor list.
	 *
	 * @since 4.0.0
	 * @param array $editors Editor list.
	 * @param int   $post_id Course ID.
	 * @return array
	 */
	public function add_edit_with_divi_button( $editors, $post_id ) {
		if ( ! $this->is_divi_available() ) {
			return $editors;
		}

		$is_divi_used    = $this->is_divi_used( $post_id );
		$editors['divi'] = array(
			'name'  => 'divi',
			'label' => __( 'Divi', 'tutor-lms-divi-modules' ),
			'link'  => $this->get_builder_link( $post_id, $is_divi_used ),
		);

		return $editors;
	}

	/**
	 * Mark Divi as the active editor when the course uses the builder.
	 *
	 * @since 4.0.0
	 * @param array $editor  Current editor.
	 * @param int   $post_id Course ID.
	 * @return array
	 */
	public function check_divi_builder( $editor, $post_id ) {
		if ( ! $this->is_divi_available() || ! $this->is_divi_used( $post_id ) ) {
			return $editor;
		}

		return array(
			'name'  => 'divi',
			'label' => __( 'Divi', 'tutor-lms-divi-modules' ),
			'link'  => $this->get_builder_link( $post_id, true ),
		);
	}
}

new CourseBuilderEditor();
