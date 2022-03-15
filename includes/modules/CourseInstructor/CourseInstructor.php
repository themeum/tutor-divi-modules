<?php

/**
 * Tutor Course Instructor Module for Divi Builder
 *
 * @since 1.0.0
 * @author Themeum<www.themeum.com>
 */

use TutorLMS\Divi\Helper;

defined( 'ABSPATH' ) || exit;

class CourseInstructor extends ET_Builder_Module {

	public $slug       = 'tutor_course_instructor';
	public $vb_support = 'on';

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
					'course_instructor_section' => esc_html__( 'Instructor Section', 'tutor-lms-divi-modules' ),
					'course_instructor_title'   => esc_html__( 'Instructor Section Title', 'tutor-lms-divi-modules' ),
					'instructor_avatar'         => esc_html__( 'Instructor Avatar', 'tutor-lms-divi-modules' ),
					'instructor_name'           => esc_html__( 'Instructor Name', 'tutor-lms-divi-modules' ),
					'instructor_designation'    => esc_html__( 'Instructor Designation', 'tutor-lms-divi-modules' ),
					'instructor_bio'            => esc_html__( 'Instructor Bio', 'tutor-lms-divi-modules' ),
					'bottom_info_star'          => esc_html__( 'Bottom Info Star', 'tutor-lms-divi-modules' ),
					'bottom_info_label'         => esc_html__( 'Bottom Info Icon', 'tutor-lms-divi-modules' ),
					'bottom_info_value'         => esc_html__( 'Bottom Info Text', 'tutor-lms-divi-modules' ),
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
						'main' => '%%order_class%% .instructor-name-designation-wrapper h3 a',
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'instructor_name',
					'hide_text_align' => true,
				),
				'instructor_designation'  => array(
					'css'             => array(
						'main' => '%%order_class%% .tutor-ins-designation',
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'instructor_designation',
					'hide_text_align' => true,
				),
				'instructor_bio'          => array(
					'css'         => array(
						'main' => '%%order_class%% .instructor-bio',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'instructor_bio',
				),
				// icon
				'bottom_info_label'       => array(
					'css'             => array(
						'main' => '%%order_class%% .courses i, %%order_class%% .students i',
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'bottom_info_label',
					'hide_text_align' => true,
				),
				// text
				'bottom_info_value'       => array(
					'css'             => array(
						'main' => '%%order_class%% .courses .tutor-color-text-subsued, %%order_class%% .students .tutor-color-text-subsued, %%order_class%% .rating-total-meta',
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'bottom_info_value',
					'hide_text_align' => true,
				),
			),
			'borders'        => array(
				'instructor_avatar' => array(
					'css'         => array(
						'main' => array(
							'border_styles' => '%%order_class%% .instructor-avatar a img',
							'border_radii'  => '%%order_class%% .instructor-avatar a img',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'instructor_avatar',
				),
				'section_content'   => array(
					'css'         => array(
						'main'      => array(
							'border_styles' => '%%order_class%% .tutor-instructor-info-card',
							'border_radii'  => '%%order_class%% .tutor-instructor-info-card',
						),
						'important' => 'all',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'course_instructor_section',
				),
			),
			'margin_padding' => array(
				'css' => array(
					'main'      => '%%order_class%% .tutor-instructor-info-card',
					'important' => 'all',
				),
			),
			'text'           => false,
			'max_width'      => false,
			// 'animation'  => false,
			//'transform'      => false,
			'background'     => array(
				'css'                  => array(
					'main'      => '%%order_class%% .tutor-instructor-info-card',
					'important' => true,
				),
				'use_background_video' => false,
			),
			// 'filters'    => false,
			'box_shadow' => array(
				'default' => array(
					'css' => array(
						'main' => "%%order_class%% .tutor-instructor-info-card",
					),
				),
			),
		);
	}

	public function get_fields() {
		return array(
			'course'                   => Helper::get_field(
				array(
					'default'          => Helper::get_course_default(),
					'computed_affects' => array(
						'__instructor',
					),
				)
			),
			'__instructor'             => array(
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
			'course_instructor_label'  => array(
				'label'           => esc_html__( 'Label', 'tutor-lms-divi-modules' ),
				'type'            => 'text',
				'default'         => esc_html__( 'About the Instructors', 'tutor-lms-divi-modules' ),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'main_content',
			),
			'profile_picture'          => array(
				'label'       => esc_html__( 'Profile Picture', 'tutor-lms-divi-modules' ),
				'type'        => 'yes_no_button',
				'options'     => array(
					'on'  => esc_html__( 'Show', 'tutor-lms-divi-modules' ),
					'off' => esc_html__( 'Hide', 'tutor-lms-divi-modules' ),
				),
				'default'     => 'on',
				'toggle_slug' => 'main_content',
			),
			'display_name'             => array(
				'label'       => esc_html__( 'Display Name', 'tutor-lms-divi-modules' ),
				'type'        => 'yes_no_button',
				'options'     => array(
					'on'  => esc_html__( 'Show', 'tutor-lms-divi-modules' ),
					'off' => esc_html__( 'Hide', 'tutor-lms-divi-modules' ),
				),
				'default'     => 'on',
				'toggle_slug' => 'main_content',
			),
			'designation'              => array(
				'label'       => esc_html__( 'Designation', 'tutor-lms-divi-modules' ),
				'type'        => 'yes_no_button',
				'options'     => array(
					'on'  => esc_html__( 'Show', 'tutor-lms-divi-modules' ),
					'off' => esc_html__( 'Hide', 'tutor-lms-divi-modules' ),
				),
				'default'     => 'on',
				'toggle_slug' => 'main_content',
			),
			'course_instructor_link'   => array(
				'label'           => esc_html__( 'Link', 'tutor-lms-divi-modules' ),
				'type'            => 'select',
				'options'         => array(
					'_blank' => esc_html__( 'New Window', 'tutor-lms-divi-modules' ),
					''       => esc_html__( 'Same Window', 'tutor-lms-divi-modules' ),
				),
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Link for the Author Name and Image', 'tutor-lms-divi-modules' ),
				'default'         => 'new',
				'toggle_slug'     => 'main_content',
			),
			'course_instructor_layout' => array(
				'label'       => esc_html__( 'Layout', 'tutor-lms-divi-modules' ),
				'type'        => 'select',
				'options'     => array(
					'row'    => esc_html__( 'Left', 'tutor-lms-divi-modules' ),
					'column' => esc_html__( 'Top', 'tutor-lms-divi-modules' ),
				),
				'description' => esc_html__( 'Link for the Author Name and Image', 'tutor-lms-divi-modules' ),
				'default'     => 'row',
				'toggle_slug' => 'main_content',
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
	 * @param array  $attrs       List of unprocessed attributes
	 * @param string $content     Content being processed
	 * @param string $render_slug Slug of module that is used for rendering output
	 *
	 * @return string module's rendered output
	 */
	public function render( $unprocessed_props, $content, $render_slug ) {
		// selectors.
		$course_instructor_layout                 = $this->props['course_instructor_layout'];
		//$course_instructor_bottom_info_star_size  = $this->props['course_instructor_bottom_info_star_size'];
		//$course_instructor_bottom_info_star_color = $this->props['course_instructor_bottom_info_star_color'];
		if ( '' !== $course_instructor_layout ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-instructor-right',
					'declaration' => sprintf(
						'flex-direction: %1$s;',
						$course_instructor_layout
					),
				)
			);
		}

				// default star color.
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'	=> '%%order_class%% .tutor-star-rating-group i',
						'declaration' => 'color: #ed9700 !important;'
					)
				);
		// if ( '' !== $course_instructor_bottom_info_star_color ) {
		// 	ET_Builder_Element::set_style(
		// 		$render_slug,
		// 		array(
		// 			'selector'    => '%%order_class%% .single-instructor-bottom .tutor-star-rating-group i',
		// 			'declaration' => sprintf(
		// 				'color: %1$s;',
		// 				$course_instructor_bottom_info_star_color
		// 			),
		// 		)
		// 	);
		// }
		// if ( '' !== $course_instructor_bottom_info_star_size ) {
		// 	ET_Builder_Element::set_style(
		// 		$render_slug,
		// 		array(
		// 			'selector'    => '%%order_class%% .single-instructor-bottom .tutor-star-rating-group i',
		// 			'declaration' => sprintf(
		// 				'font-size: %1$s;',
		// 				$course_instructor_bottom_info_star_size
		// 			),
		// 		)
		// 	);
		// }

		// course instructor styles end.
		// set styles end
		$output = self::get_content( $this->props );
		if ( '' === $output ) {
			return '';
		}
		return $this->_render_module_wrapper( $output, $render_slug );
	}
}
new CourseInstructor();
