<?php

/**
 * Tutor Course Total Enrollment Module for Divi Builder
 * @since 1.0.0
 * @author Themeum<www.themeum.com>
 */

use TutorLMS\Divi\Helper;

class TutorCourseTotalEnroll extends ET_Builder_Module {
	// Module slug (also used as shortcode tag)
	public $slug       = 'tutor_course_total_enroll';
	public $vb_support = 'on';

	// Module Credits (Appears at the bottom of the module settings modal)
	protected $module_credits = array(
		'author'     => 'Themeum',
		'author_uri' => 'https://themeum.com',
	);

	/**
	 * Module properties initialization
	 *
	 * @since 1.0.0
	 */
	public function init() {
		// Module name & icon
		$this->name			= esc_html__('Tutor Course Total Enroll', 'tutor-divi-modules');
		$this->icon_path	= plugin_dir_path( __FILE__ ) . 'icon.svg';

		// Toggle settings
		// Toggles are grouped into array of tab name > toggles > toggle definition
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__('Content', 'tutor-divi-modules'),
				),
			),
		);
		
		$wrapper 		= '%%order_class%% .tutor-single-course-meta-total-enroll';
		$label_selector = '%%order_class%% .tutor-single-course-meta-total-enroll > label';
		$value_selector = '%%order_class%% .tutor-single-course-meta-total-enroll > span';

		$this->advanced_fields = array(
			'fonts'          => array(

				'label_text' 	=> array(
					'css'          => array(
						'main' => $label_selector,
					),
					'hide_text_align'	=> true,
					'tab_slug'     		=> 'advanced',
					'toggle_slug'  		=> 'total_enroll_label_value_style',
					'sub_toggle'		=> 'label_subtoggle'
				),

				'value_text'	=> array(
					'css'			=> array(
						'main'	=> $value_selector
					),
					'hide_text_align'	=> true,
					'tab_slug'			=> 'advanced',
					'toggle_slug'		=> 'total_enroll_label_value_style',
					'sub_toggle'		=> 'value_subtoggle'
				)

			),
			'borders'       => false,
			'button'        => false,
			'text'			=> false,
			'max_width'		=> false,
			'background'	=> false,
			'filters'		=> false,
			'animation'		=> false,
			'box_shadow'	=> false,
			'transform'		=> false	 
		);
	}

	/**
	 * Module's specific fields
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_fields() {
		$fields = array(
			'course'       	=> Helper::get_field(
				array(
					'default'          => Helper::get_course_default(),
					'computed_affects' => array(
						'__totalenroll',
					),
				)
			),
			'__totalenroll' => array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'TutorCourseTotalEnroll',
					'get_props',
				),
				'computed_depends_on' => array(
					'course'
				),
				'computed_minimum'    => array(
					'course',
				),
			),
			//general tab settings content toggle
			'enroll_label'	=> array(
				'label'			=> esc_html__( 'Label', 'tutor-divi-modules' ),
				'type'			=> 'text',
				'default'		=> 'Enrolled:',
				'toggle_slug'	=> 'main_content'
			),
			'layout'		=> array(
				'label'				=> esc_html__( 'Layout', 'tutor-divi-modules' ),
				'type'				=> 'select',
				'option_category'	=> 'layout',
				'options'			=> array(
					'row'		=> esc_html__( 'Left', 'tutor-divi-modules' ),
					'column'	=> esc_html__( 'Up', 'tutor-divi-modules' )
				),
				'default'			=> 'row',
				'toggle_slug'		=> 'main_content',
				'mobile_options'	=> true
			),
			'alignment'		=> array(
				'label'				=> esc_html__('Alignment', 'tutor-divi-modules'),
				'type'				=> 'text_align',
				'option_category'	=> 'configuration',
				'options'			=> et_builder_get_text_orientation_options( array( 'justified' ) ),
				'default'			=> 'left',
				'toggle_slug'		=> 'main_content',
				'mobile_options'	=> true
			),
			'gap'			=> array(
				'label'				=> esc_html__( 'Gap', 'tutor-divi-modules' ),
				'type'				=> 'range',
				'option_category'	=> 'layout',
				'default_unit'		=> 'px',
				'default'			=> '5',
				'range_settings'	=> array(
					'min'		=> '1',
					'max'		=> '100',
					'step'		=> '1'
				),
				'toggle_slug'		=> 'main_content',
				'mobile_options'	=> true
			),
			
		);

		return $fields;
	}

	/**
	 * custom tabs for label & value
	 * @since 1.0.0
	 * @return array
	 */
	public function get_settings_modal_toggles () {
		return array(
			'advanced'	=> array(
				'toggles'	=> array(
					'total_enroll_label_value_style'		=> array(
						'priority'		=> 24,
						'sub_toggles'	=> array(
							'label_subtoggle'	=> array(
								'name'	=> esc_html__('Label', 'tutor-divi-modules')
							),
							'value_subtoggle'	=> array(
								'name'	=> esc_html__('Value', 'tutor-divi-modules')
							),
						),
						'tabbed_subtoggles' => true,
						'title' => esc_html__('Style', 'tutor-divi-modules'),
					),
				)
			)
		);
	}

	/**
	 * return dependent props for total enroll
	 * @since 1.0.0
	 * @return int
	 */
	public  static function get_props( $args=[] ) {
		$course_id = $args['course'];
		$total_enrolled = (int) tutor_utils()->count_enrolled_users_by_course( $course_id );
		return $total_enrolled;
	}

	/**
	 * Get the tutor course author
	 * @since 1.0.0
	 * @return string
	 */
	public static function get_content($args = []) {
		$course = $args['course'];
		$markup = '';
		if ($course) {
			$total_enrolled = (int) tutor_utils()->count_enrolled_users_by_course( );
			$disable_total_enrolled = get_tutor_option('disable_course_total_enrolled');
			if (!$disable_total_enrolled) {
				$markup = '<div class="tutor-single-course-meta-total-enroll">';
				$markup .= sprintf( '<label>%1$s</label>' , $args['enroll_label'] );
				$markup .= sprintf( '<span>%1$s</span>' , $total_enrolled );
				$markup .= '</div>';
			}
		}
		return $markup;
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
	public function render($attrs, $content = null, $render_slug) {
		//selectors
		$wrapper = '%%order_class%% .tutor-single-course-meta-total-enroll';
		$label_selector = '%%order_class%% .tutor-single-course-meta-total-enroll > label';
		$value_selector = '%%order_class%% .tutor-single-course-meta-total-enroll > span';

		//props
		$layout			= $this->props['layout'];
		$layout_tablet	= isset( $this->props['layout_tablet'] ) && '' !== $this->props['layout_tablet'] ? $this->props['layout_tablet'] : $layout;
		$layout_phone	= isset( $this->props['layout_phone'] ) && '' !== $this->props['layout_phone'] ? $this->props['layout_phone'] : $layout;


		$alignment		= $this->props['alignment'];
		if( $alignment === 'left' ) {
			$alignment = 'flex-start';
		} else if( $alignment === 'center') {
			$alignment = 'center';
		} else {
			$alignment = 'flex-end';
		}

		$alignment_tablet	= isset( $this->props['alignment_tablet'] ) && '' !== $this->props['alignment_tablet'] ? $this->props['alignment_tablet'] : $alignment;
		$alignment_phone	= isset( $this->props['alignment_phone'] ) && '' !== $this->props['alignment_phone'] ? $this->props['alignment_phone'] : $alignment;

		$gap			= $this->props['gap'];
		$gap_tablet		= isset( $this->props['gap_tablet'] ) && '' !== $this->props['gap_tablet'] ? $this->props['gap_tablet'] : $gap;
		$gap_phone		= isset( $this->props['gap_phone'] ) && '' !== $this->props['gap_phone'] ? $this->props['gap_phone'] : $gap;

		$display		= 'flex';

		//set styles
		if( '' !== $display ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $wrapper,
					'declaration'	=> sprintf(
						'display: %1$s;',
						esc_html($display)
					)
				)
			);			
		}
		//gaping for desktop
		if( '' !== $gap && $layout == 'row' ) { 
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $wrapper,
					'declaration'	=> sprintf(
						'column-gap: %1$s;',
						esc_html( $gap ) 
					)
				)				
			);
		} 
		if ( '' !== $gap && $layout == 'column' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $wrapper,
					'declaration'	=> sprintf(
						'row-gap: %1$s;',
						esc_html( $gap ) 
					)
				)				
			);
		}

		//gaping for tablet
		if( '' !== $gap_tablet && $layout_tablet == 'row' ) { 
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $wrapper,
					'declaration'	=> sprintf(
						'column-gap: %1$s;',
						esc_html( $gap_tablet ) 
					),
					'media_query'	=> ET_Builder_Element::get_media_query('max_width_980')
				)				
			);
		} 
		if ( '' !== $gap_tablet && $layout_tablet == 'column' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $wrapper,
					'declaration'	=> sprintf(
						'row-gap: %1$s;',
						esc_html( $gap_tablet ) 
					),
					'media_query'	=> ET_Builder_Element::get_media_query('max_width_980')
				)				
			);
		}
		//gaping for phone
		if( '' !== $gap_phone && $layout_phone == 'row' ) { 
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $wrapper,
					'declaration'	=> sprintf(
						'column-gap: %1$s;',
						esc_html( $gap_phone ),
					),
					'media_query'	=> ET_Builder_Element::get_media_query('max_width_767')
				)				
			);
		} 
		if ( '' !== $gap_phone && $layout_phone == 'column' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $wrapper,
					'declaration'	=> sprintf(
						'row-gap: %1$s;',
						esc_html( $gap_phone ) 
					),
					'media_query'	=> ET_Builder_Element::get_media_query('max_width_767')
				)				
			);
		}

		//layout style
		if( '' !== $layout ) { 
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $wrapper,
					'declaration'	=> sprintf(
						'flex-direction: %1$s;',
						esc_html( $layout )
					)
				)				
			);
		}
		if( '' !== $layout_tablet ) { 
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $wrapper,
					'declaration'	=> sprintf(
						'flex-direction: %1$s;',
						esc_html( $layout_tablet )
					),
					'media_query'	=> ET_Builder_Element::get_media_query('max_width_980')
				)				
			);
		}
		if( '' !== $layout_phone ) { 
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $wrapper,
					'declaration'	=> sprintf(
						'flex-direction: %1$s;',
						esc_html( $layout_phone )
					),
					'media_query'	=> ET_Builder_Element::get_media_query('max_width_767')
				)				
			);
		}

		/**
		 * if layout row set prop justify-content
		 * if layout column set prop align-items
		 */
		if( '' !== $alignment && $layout === 'row' ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'		=> $wrapper,
						'declaration'	=> sprintf(
							'justify-content: %1$s;',
							esc_html( $alignment )
						)
					)				
				);
		}
		if( '' !== $alignment && $layout === 'column' ) { 
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $wrapper,
					'declaration'	=> sprintf(
						'align-items: %1$s;',
						esc_html( $alignment )
					)
				)				
			);
		}	
		
		if( '' !== $alignment_tablet && $layout_tablet === 'row' ) { 
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $wrapper,
					'declaration'	=> sprintf(
						'justify-content: %1$s;',
						esc_html( $alignment_tablet )
					),
					'media_query'	=> ET_Builder_Element::get_media_query('max_width_980')
				)				
			);
		}
		if( '' !== $alignment_tablet && $layout_tablet === 'column' ) { 
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $wrapper,
					'declaration'	=> sprintf(
						'align-items: %1$s;',
						esc_html( $alignment_tablet )
					),
					'media_query'	=> ET_Builder_Element::get_media_query('max_width_980')
				)				
			);
		}

		if( '' !== $alignment_phone && $layout_phone === 'row' ) { 
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $wrapper,
					'declaration'	=> sprintf(
						'justify-content: %1$s;',
						esc_html( $alignment_phone )
					),
					'media_query'	=> ET_Builder_Element::get_media_query('max_width_767')
				)				
			);
		}
		if( '' !== $alignment_phone && $layout_phone === 'column' ) { 
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $wrapper,
					'declaration'	=> sprintf(
						'align-items: %1$s;',
						esc_html( $alignment_phone )
					),
					'media_query'	=> ET_Builder_Element::get_media_query('max_width_767')
				)				
			);
		}
		
		//set styles end

		$output = self::get_content($this->props);

		// Render empty string if no output is generated to avoid unwanted vertical space.
		if ('' === $output) {
			return '';
		}

		return $this->_render_module_wrapper($output, $render_slug);
	}
}

new TutorCourseTotalEnroll;
