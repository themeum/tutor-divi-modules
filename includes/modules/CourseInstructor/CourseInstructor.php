<?php

/**
* Tutor Course Instructor Module for Divi Builder
* @since 1.0.0
* @author Themeum<www.themeum.com>
*/

use TutorLMS\Divi\Helper;

class CourseInstructor extends ET_Builder_Module {

	public $slug       = 'tutor_course_instructor';
	public $vb_support = 'on';

	/**
	 * Module properties initialization
	 *
	 * @since 1.0.0
	 */
	public function init() {
		$this->name = esc_html__( 'Tutor Course Instructor', 'tutor-divi-modules' );
		$this->icon_path	= plugin_dir_path( __FILE__ ) . 'icon.svg';
		//settings modal toggles 
		//define toggles & titles
		$this->settings_modal_toggles = array(
			'general'	=> array(
				'toggles'	=> array(
					'main_content'	=> esc_html__( 'Content', 'tutor-divi-modules' ),
				)
			),
			'advanced'	=> array(
				'toggles'	=> array(
					'section_content'		=> esc_html__( 'Content', 'tutor-divi-modules' ),
					'section_title'			=> esc_html__( 'Section Title', 'tutor-divi-modules' ),
					'instructor_avatar'		=> esc_html__( 'Instructor Avatar', 'tutor-divi-modules' ),
					'instructor_name'		=> esc_html__( 'Instructor Name', 'tutor-divi-modules' ),
					'instructor_designation'=> esc_html__( 'Instructor Designation', 'tutor-divi-modules' ),
					'instructor_bio'		=> esc_html__( 'Instructor Bio', 'tutor-divi-modules' ),
					'bottom_info_star'		=> esc_html__( 'Bottom Info Star', 'tutor-divi-modules' ),
					'bottom_info_label'		=> esc_html__( 'Bottom Info Icon', 'tutor-divi-modules' ),
					'bottom_info_value'		=> esc_html__( 'Bottom Info Text', 'tutor-divi-modules' ),
				),
			)
		);

		//advanced fields configuration
		//define selectors for the advanced fields
		$title_selector			= '%%order_class%% .tutor-segment-title';

		$this->advanced_fields = array(
			'fonts'		=> array(
				'section_title'		=> array(
					'css'		=> array(
						'main'	=> $title_selector,
					),
					'tab_slug'		=> 'advanced',
					'toggle_slug'	=> 'section_title'
				),
				'instructor_name'		=> array(
					'css'		=> array(
						'main'	=> '%%order_class%% .instructor-name h3 a',
					),
					'tab_slug'		=> 'advanced',
					'toggle_slug'	=> 'instructor_name',
					'hide_text_align'	=> true,
				),
				'instructor_designation'	=> array(
					'css'		=> array(
						'main'	=> '%%order_class%% .instructor-name h4',
					),
					'tab_slug'		=> 'advanced',
					'toggle_slug'	=> 'instructor_designation',
					'hide_text_align'	=> true,
				),
				'instructor_bio'	=> array(
					'css'		=> array(
						'main'	=> '%%order_class%% .instructor-bio',
					),
					'tab_slug'		=> 'advanced',
					'toggle_slug'	=> 'instructor_bio'
				),
				//icon
				'bottom_info_label'	=> array(
					'css'		=> array(
						'main'	=> '%%order_class%% .courses i, %%order_class%% .students i, %%order_class%% .rating-digits',
					),
					'tab_slug'		=> 'advanced',
					'toggle_slug'	=> 'bottom_info_label',
					'hide_text_align'	=> true
				),
				//text
				'bottom_info_value'	=> array(
					'css'		=> array(
						'main'	=> '%%order_class%% .courses .tutor-text-mute, %%order_class%% .students .tutor-text-mute, %%order_class%% .rating-total-meta',
					),
					'tab_slug'		=> 'advanced',
					'toggle_slug'	=> 'bottom_info_value',
					'hide_text_align'	=> true
				),
			),
			'borders'		=> array(
				'instructor_avatar'	=> array(
					'css'	=> array(
						'main'	=> array(
							'border_styles'	=> '%%order_class%% .instructor-avatar a span, %%order_class%% .instructor-avatar a img',
							'border_radii'	=> '%%order_class%% .instructor-avatar a span, %%order_class%% .instructor-avatar a img',
						)
					),
					'tab_slug'		=> 'advanced',
					'toggle_slug'	=> 'instructor_avatar' 
				),
				'section_content'	=> array(
					'css'	=> array(
						'main'	=> array(
							'border_styles'	=> '%%order_class%% .tutor-course-instructors-wrap .single-instructor-wrap',
							'border_radii'	=> '%%order_class%% .tutor-course-instructors-wrap .single-instructor-wrap',
						),
						'important'	=> 'all'
					),
					'tab_slug'		=> 'advanced',
					'toggle_slug'	=> 'section_content' 
				)
			),
			'background'    => array(
                'css'   => array(
                    'main'  => '%%order_class%% .instructor-avatar a span',
                    'important' => true
                ),
                'settings'  => array(
                    'tab_slug'      => 'advanced',
                    'toggle_slug'   => 'instructor_avatar'
                ),
                'use_background_video'  => false
            ),
			'text'		=> false
		);
	}

	public function get_fields() {
		return array(
			'course'       	=> Helper::get_field(
				array(
					'default'          => Helper::get_course_default(),
					'computed_affects' => array(
						'__instructor',
					),
				)
			),
			'__instructor'	=> array(
				'type'					=> 'computed',
				'computed_callback'		=> array(
					'CourseInstructor',
					'get_props'
				),
				'computed_depends_on'	=> array(
					'course'
				),
				'computed_minimum'		=> array(
					'course'
				)
			),
			//general tab main_content toggle
			'label'     => array(
				'label'           => esc_html__( 'Label', 'tutor-divi-modules' ),
				'type'            => 'text',
				'default'		  => esc_html__( 'About the Instructors', 'tutor-divi-modules' ),	
				'option_category' => 'basic_option',
				'toggle_slug'     => 'main_content',
			),
			'profile_picture'	=> array(
				'label'			=> esc_html__( 'Profile Picture', 'tutor-divi-modules' ),
				'type'			=> 'yes_no_button',
				'options'		=> array(
					'on'		=> esc_html__( 'Show', 'tutor-divi-modules' ),
					'off'		=> esc_html__( 'Hide', 'tutor-divi-modules' )
				),
				'default'		=> 'on',
				'toggle_slug'	=> 'main_content'
			),
			'display_name'	=> array(
				'label'			=> esc_html__( 'Display Name', 'tutor-divi-modules' ),
				'type'			=> 'yes_no_button',
				'options'		=> array(
					'on'		=> esc_html__( 'Show', 'tutor-divi-modules' ),
					'off'		=> esc_html__( 'Hide', 'tutor-divi-modules' )
				),
				'default'		=> 'on',
				'toggle_slug'	=> 'main_content'
			),
			'designation'	=> array(
				'label'			=> esc_html__( 'Designation', 'tutor-divi-modules' ),
				'type'			=> 'yes_no_button',
				'options'		=> array(
					'on'		=> esc_html__( 'Show', 'tutor-divi-modules' ),
					'off'		=> esc_html__( 'Hide', 'tutor-divi-modules' )
				),
				'default'		=> 'on',
				'toggle_slug'	=> 'main_content'
			),
			'link'	=> array(
				'label'			=> esc_html__( 'Link', 'tutor-divi-modules' ),
				'type'			=> 'select',
				'options'		=> array(
					'_blank'		=> esc_html__( 'New Window', 'tutor-divi-modules' ),
					''		=> esc_html__( 'Same Window', 'tutor-divi-modules' )
				),
				'option_category'	=> 'basic_option',
				'description'	=> esc_html__( 'Link for the Author Name and Image', 'tutor-divi-modules' ),
				'default'		=> 'new',
				'toggle_slug'	=> 'main_content'
			),
			'layout'	=> array(
				'label'			=> esc_html__( 'Layout', 'tutor-divi-modules' ),
				'type'			=> 'select',
				'options'		=> array(
					'row'		=> esc_html__( 'Left', 'tutor-divi-modules' ),
					'column'	=> esc_html__( 'Top', 'tutor-divi-modules' )
				),
				'description'	=> esc_html__( 'Link for the Author Name and Image', 'tutor-divi-modules' ),
				'default'		=> 'row',
				'toggle_slug'	=> 'main_content'
			),
			//advanced tab section_content toggle
			'section_background'=> array(
				'label'			=> esc_html__( 'Background Color', 'tutor-divi-modules' ),
				'type'			=> 'color-alpha',
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'section_content' 
			), 
			//advanced tab instructor_avatar toggle
			'image_size'		=> array(
				'label'				=> esc_html__( 'Image Size', 'tutor-divi-modules' ),
				'type'				=> 'range',
				'default'			=> '48px',
				'default_unit'		=> 'px',
				'range_settings'	=> array(
					'min'	=> '1',
					'max'	=> '200',
					'step'	=> '1'
				),
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'instructor_avatar'
			),
			//advanced tab bottom_info_star toggle
			'star_size'		=> array(
				'label'			=> esc_html__( 'Star Size', 'tutor-divi-modules' ),
				'type'			=> 'range',
				'default'		=> '14px',
				'default_unit'	=> 'px',
				'range_settings'=> array(
					'min'	=> '1',
					'max'	=> '100',
					'step'	=> '1'
				),
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'bottom_info_star'
			),
			'star_color'	=> array(
				'label'			=> esc_html__( 'Star Color', 'tutor-divi-modules' ),
				'type'			=> 'color-alpha',
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'bottom_info_star'
			),
			//advanced tab margin_padding toggle
			'space_between'		=> array(
				'label'			=> esc_html__( 'Space Between', 'tutor-divi-modules' ),
				'type'			=> 'range',
				'default'		=> '10px',
				'default_unit'	=> 'px',
				'range_settings'=> array(
					'min'	=> '1',
					'max'	=> '100',
					'step'	=> '1'
				),
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'margin_padding'
			)
		);
	}

	/**
	 * get require props	
	 * @param array
	 * @return array | string
	 * @since 1.0.0
	 */
	public static function get_props( $args = [] ) {
		$course_id = $args['course'];
		$instructors	= tutor_utils()->get_instructors_by_course( $course_id );
		if( !is_null( $instructors ) ) {
			foreach( $instructors as $instructor ) {
				$instructor->avatar				= tutils()->get_tutor_avatar( $instructor->ID, $size = 'thumbnail' );
				$instructor->ratings 			= tutils()->get_instructor_ratings( $instructor->ID );
				//$instructor->rating_generate	= tutils()->star_rating_generator($instructor->ratings ? $instructor->ratings->rating_avg : 0);
				$instructor->course_count 		= tutils()->get_course_count_by_instructor( $instructor->ID );
				$instructor->student_count 		= tutils()->get_total_students_by_instructor( $instructor->ID );
			}
		}
		return $instructors;
	}

	/**
	 * @param array
	 * @return template
	 * @since 1.0.0
	 */
	public  static function get_content( $args = [] ) {
		ob_start();
		include_once dtlms_get_template( 'course/instructor' );
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
	public function render( $unprocessed_props, $content = null, $render_slug ) {

		//selectors
		$wrapper                   = '%%order_class%% .single-instructor-wrap';
        $tutor_instructor_right    = '%%order_class%% .single-instructor-wrap .tutor-instructor-right';
		$avatar_selector           = '%%order_class%% .instructor-avatar a img, %%order_class%% .instructor-avatar a span';
		$star_selector 			   = '%%order_class%% .tutor-star-rating-group i';

		//props
		$layout 			= $this->props['layout'];
		$image_size			= $this->props['image_size'];

		$star_color  		= $this->props['star_color'];
		$star_size 			= $this->props['star_size'];

		$space_between		= $this->props['space_between'];

		$section_background = $this->props['section_background'];

		//set styles
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'		=> '%%order_class%% #single-course-ratings',
				'declaration'	=> 'display: flex; flex-direction: column;'
			)
		);

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'		=> '%%order_class%% .single-instructor-wrap',
				'declaration'	=> 'margin-bottom: 0px;'
			)
		);

		if( '' !== $space_between ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '%%order_class%% #single-course-ratings',
					'declaration'	=> sprintf(
						'row-gap: %1$s;',
						$space_between
					)
				)
			);
		}

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'		=> '%%order_class%% .single-instructor-wrap .instructor-name',
				'declaration'	=> 'padding-left: 0px;'
			)
		);
		
		//layout
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'		=> $tutor_instructor_right,
				'declaration'	=> sprintf(
					'display: flex; flex-direction: %1$s; gap: 10px 10px;',
					$layout
				)
			)
		);
		//avatar
		if( '' !== $image_size ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $avatar_selector,
					'declaration' 	=> sprintf(
						'width: %1$s; height: %1$s; max-width: %1$s; line-height: %1$s;',
						$image_size
					)
				)
			);
		}

		//star
		if( '' !== $star_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $star_selector,
					'declaration' 	=> sprintf(
						'color: %1$s;',
						$star_color
					)
				)
			);
		}

		if( '' !== $star_size ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $star_selector,
					'declaration' 	=> sprintf(
						'font-size: %1$s;',
						$star_size
					)
				)
			);
		}		

		if( '' !== $section_background ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '%%order_class%% .tutor-course-instructors-wrap .single-instructor-wrap',
					'declaration' 	=> sprintf(
						'background-color: %1$s;',
						$section_background
					)
				)
			);
		}

		//set styles end
		$output = self::get_content( $this->props );
		if( '' === $output ) {
			return '';
		}
		return $this->_render_module_wrapper( $output, $render_slug );
	}
}
new CourseInstructor;