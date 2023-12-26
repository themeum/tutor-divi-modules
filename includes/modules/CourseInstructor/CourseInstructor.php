<?php

/**
 * Tutor Course Instructor Module for Divi Builder
 *
 * @since 1.0.0
 * @author Themeum<www.themeum.com>
 * @package DTLMS\CourseInstructor
 */

use TutorLMS\Divi\Helper;

defined( 'ABSPATH' ) || exit;

class CourseInstructor extends ET_Builder_Module {

	public $slug       = 'tutor_course_instructor';
	public $vb_support = 'on';
	public $icon_path;
	/**
	 * Module properties initialization
	 *
	 * @since 1.0.0
	 */
	public function init() {
		$this->name      = esc_html__( 'Tutor Course Instructor', 'tutor-lms-divi-modules' );
		$this->icon_path = plugin_dir_path( __FILE__ ) . 'icon.svg';
		// settings modal toggles
		// define toggles & titles
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Content', 'tutor-lms-divi-modules' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'course_instructor_title' => esc_html__( 'Title', 'tutor-lms-divi-modules' ),
					'instructor_name'         => esc_html__( 'Instructor Name', 'tutor-lms-divi-modules' ),
					'instructor_designation'  => esc_html__( 'Instructor Designation', 'tutor-lms-divi-modules' ),
					'instructor_avatar'       => esc_html__( 'Instructor Avatar', 'tutor-lms-divi-modules' ),
				),
			),
		);

		// advanced fields configuration
		// define selectors for the advanced fields
		$title_selector = '%%order_class%% .tutor-segment-title';

		$this->advanced_fields = array(
			'fonts'          => array(
				'course_instructor_title' => array(
					'css'             => array(
						'main' => '%%order_class%% .dtlms-course-instructor-title',
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'course_instructor_title',
					'hide_text_align' => true,
				),
				'instructor_name'         => array(
					'css'             => array(
						'main' => '%%order_class%% .tutor-instructor-name',
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'instructor_name',
					'hide_text_align' => true,
				),
				'instructor_designation'  => array(
					'css'             => array(
						'main' => '%%order_class%% .tutor-instructor-designation',
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'instructor_designation',
					'hide_text_align' => true,
				),
			),
			'borders'        => array(
				'default' => array(
					'css'         => array(
						'main' => array(
							'border_styles' => '%%order_class%% .tutor-course-details-instructors',
							'border_radii'  => '%%order_class%% .tutor-course-details-instructors',
						),
					),
					'tab_slug'    => 'advanced',
				),
				'instructor_avatar' => array(
					'css'         => array(
						'main' => array(
							'border_styles' => '%%order_class%% .tutor-avatar',
							'border_radii'  => '%%order_class%% .tutor-avatar',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'instructor_avatar',
				),
				'section_content'   => array(
					'css'         => array(
						'main'      => array(
							'border_styles' => '%%order_class%% .tutor-course-details-instructors',
							'border_radii'  => '%%order_class%% .tutor-course-details-instructors',
						),
						'important' => 'all',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'course_instructor_section',
				),
			),
			'margin_padding' => array(
				'css' => array(
					'main'      => '%%order_class%% .tutor-course-details-instructors',
					'important' => 'all',
				),
			),
			'text'           => false,
			'max_width'      => false,
			// 'animation'  => false,
			// 'transform'      => false,
			'background'     => array(
				'css'                  => array(
					'main'      => '%%order_class%% .tutor-course-details-instructors',
					'important' => true,
				),
				'use_background_video' => false,
			),
			// 'filters'    => false,
			'box_shadow'     => array(
				'default' => array(
					'css' => array(
						'main' => '%%order_class%% .tutor-course-details-instructors',
					),
				),
			),
		);
	}

	public function get_fields() {
		return array(
			'course'                                    => Helper::get_field(
				array(
					'default'          => Helper::get_course_default(),
					'computed_affects' => array(
						'__instructor',
					),
				)
			),
			'__instructor'                              => array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'CourseInstructor',
					'get_content',
				),
				'computed_depends_on' => array(
					'course',
					'course_instructor_label',
					'profile_picture',
					'display_name',
					'designation',
					'course_instructor_link',
				),
				'computed_minimum'    => array(
					'course',
					'course_instructor_label',
					'profile_picture',
					'display_name',
					'designation',
					'course_instructor_link',
				),
			),
			// general tab main_content toggle.
			'course_instructor_label'                   => array(
				'label'           => esc_html__( 'Label', 'tutor-lms-divi-modules' ),
				'type'            => 'text',
				'default'         => esc_html__( 'A Course by', 'tutor-lms-divi-modules' ),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'main_content',
			),
			'profile_picture'                           => array(
				'label'       => esc_html__( 'Profile Picture', 'tutor-lms-divi-modules' ),
				'type'        => 'yes_no_button',
				'options'     => array(
					'on'  => esc_html__( 'Show', 'tutor-lms-divi-modules' ),
					'off' => esc_html__( 'Hide', 'tutor-lms-divi-modules' ),
				),
				'default'     => 'on',
				'toggle_slug' => 'main_content',
			),
			'display_name'                              => array(
				'label'       => esc_html__( 'Display Name', 'tutor-lms-divi-modules' ),
				'type'        => 'yes_no_button',
				'options'     => array(
					'on'  => esc_html__( 'Show', 'tutor-lms-divi-modules' ),
					'off' => esc_html__( 'Hide', 'tutor-lms-divi-modules' ),
				),
				'default'     => 'on',
				'toggle_slug' => 'main_content',
			),
			'designation'                               => array(
				'label'       => esc_html__( 'Designation', 'tutor-lms-divi-modules' ),
				'type'        => 'yes_no_button',
				'options'     => array(
					'on'  => esc_html__( 'Show', 'tutor-lms-divi-modules' ),
					'off' => esc_html__( 'Hide', 'tutor-lms-divi-modules' ),
				),
				'default'     => 'on',
				'toggle_slug' => 'main_content',
			),
			'course_instructor_link'                    => array(
				'label'           => esc_html__( 'Link', 'tutor-lms-divi-modules' ),
				'type'            => 'select',
				'options'         => array(
					'_blank' => esc_html__( 'New Window', 'tutor-lms-divi-modules' ),
					'same'   => esc_html__( 'Same Window', 'tutor-lms-divi-modules' ),
				),
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Link for the Author Name and Image', 'tutor-lms-divi-modules' ),
				'default'         => '_blank',
				'toggle_slug'     => 'main_content',
			),
			// Avatar section.
			'course_instructor_avatar_background_color' => array(
				'label'       => esc_html__( 'Background Color', 'tutor-lms-divi-modules' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'instructor_avatar',
			),
			'course_instructor_avatar_text_color'       => array(
				'label'       => esc_html__( 'Text Color', 'tutor-lms-divi-modules' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'instructor_avatar',
			),
		);
	}

	/**
	 * @param array
	 * @return template
	 * @since 1.0.0
	 */
	public static function get_content( $args = array() ) {
		ob_start();
		include dtlms_get_template( 'course/instructor' );
		return ob_get_clean();
	}

	/**
	 * Render module output
	 *
	 * @since 1.0.0
	 *
	 * @param array  $unprocessed_props List of unprocessed attributes.
	 * @param string $content     Content being processed.
	 * @param string $render_slug Slug of module that is used for rendering output.
	 *
	 * @return string module's rendered output
	 */
	public function render( $unprocessed_props, $content, $render_slug ) {
		$text_avatar_background = $this->props['course_instructor_avatar_background_color'];
		$avatar_text_color      = $this->props['course_instructor_avatar_text_color'];
		if ( '' !== $text_avatar_background ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-avatar-text',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						$text_avatar_background
					),
				)
			);
		}
		if ( '' !== $avatar_text_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-avatar-text',
					'declaration' => sprintf(
						'color: %1$s !important;',
						$avatar_text_color
					),
				)
			);
		}
		$output = self::get_content( $this->props );
		if ( '' === $output ) {
			return '';
		}
		return $this->_render_module_wrapper( $output, $render_slug );
	}
}
new CourseInstructor();
