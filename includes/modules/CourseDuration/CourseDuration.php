<?php

/**
 * Tutor Course Duration Module for Divi Builder
 * @since 1.0.0
 * @author Themeum<www.themeum.com>
 */

use TutorLMS\Divi\Helper;

class TutorCourseDuration extends ET_Builder_Module {
	// Module slug (also used as shortcode tag)
	public $slug       = 'tutor_course_duration';
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
		$this->name			= esc_html__('Tutor Course Duration', 'tutor-divi-modules');
		$this->icon_path	= plugin_dir_path( __FILE__ ) . 'icon.svg';
		$this->fb_support   = true;
		// Toggle settings
		// Toggles are grouped into array of tab name > toggles > toggle definition
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__('Content', 'tutor-divi-modules'),
				),
			),
		);
		
		$label_selector = '%%order_class%% .tutor-single-course-meta-duration label';
		$value_selector = '%%order_class%% .tutor-single-course-meta-duration span';
		$this->advanced_fields = array(
			'fonts'          => array(
				'label_text' => array(	
					'css'          		=> array(
						'main' 		=> $label_selector,
						'important'	=> 'all'
					),
					'tab_slug'      	=> 'advanced',
					'toggle_slug'   	=> 'duration_label_value_style',
					'sub_toggle'		=> 	'label_subtoggle',
					'hide_text_align'	=> true
				),
				'value_text' => array(
					'css'          		=> array(
						'main' 		=> $value_selector,
						'important'	=> 'all' 
					),
					'tab_slug'      	=> 'advanced',
					'toggle_slug'   	=> 'duration_label_value_style',
					'sub_toggle'		=> 'value_subtoggle',
					'hide_text_align'	=> true
				),
				
			),
			'button'         	=> false,
			'borders'			=> false,
			'box_shadow'		=> false,
			'text'			 	=> false,
			'max_width'			=> false,
			//'margin_padding'	=> false,			
			'background'		=> false,
			'filters'			=> false,
			'animation'			=> false,
			'transform'			=> false			
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
					'default'          => Helper::get_course_default()
				)
			),
			'__duration'	=> array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'TutorCourseDuration',
					'get_duration',
				),
				'computed_depends_on' => array(
					'course'
				),
				'computed_minimum'    => array(
					'course',
				),
			),
			//general settings
			'duration_label'			=> array(
				'label'						=> esc_html__('Label', 'tutor-divi-modules'),
				'type'						=> 'text',
				'toggle_slug'				=> 'main_content',
				'default'					=> esc_html__('Course Duration', 'tutor-divi-modules')
			),
			'duration_layout'			=> array(
				'label'						=> esc_html__('Layout', 'tutor-divi-moduels'),
				'type'						=> 'select',
				'option_category'			=> 'layout',
				'options'					=> array(
					'row'						=> esc_html__('Left', 'tutor-divi-modules'),
					'column' 					=> esc_html__('Up', 'tutor-divi-modules')
				),
				'default'					=> 'row',
				'toggle_slug'				=> 'main_content'
			),
			'duration_alignment'		=> array(
				'label'						=> esc_html__('Alignment', 'tutor-divi-modules'),
				'type'						=> 'text_align',
				'option_category'			=> 'configuration',
				'options'					=> et_builder_get_text_orientation_options( array( 'justified' ) ),
				'toggle_slug'				=> 'main_content'
			),
			'gap'						=> array(
				'label'						=> esc_html__('Gap', 'tutor-divi-modules'),
				'type'						=> 'range',
				'option_category'			=> 'layout',
				'default_unit'				=> 'px',
				'default'					=> '10px',
				'range_settings'			=> array(
					'min'		=> '1',
					'max'		=> '100',
					'step'		=> '1'
				),
				'mobile_options'			=> true,
				'toggle_slug'				=> 'main_content'
			),
			//general settings end

		);

		return $fields;
	}

	/**
	 * get computed value
	 * @since 1.0.0
	 */
	public static function get_duration( $args=[] ) {
		$course 			= Helper::get_course($args);
		$course_duration	= get_tutor_course_duration_context();
		return $course_duration;
	}

	/**
	 * Get the tutor course duration
	 * @since 1.0.0
	 * @return string
	 */
	public static function get_content($args = []) {
		$course = Helper::get_course($args);
		$markup = '';
		if ($course) {
			$course_duration = get_tutor_course_duration_context();
			$disable_course_duration = get_tutor_option('disable_course_duration');
			if (!empty($course_duration) && !$disable_course_duration) {
				$markup 	 = '<div class="tutor-single-course-meta-duration tutor-divi-course-duration">';
				$markup 	.= sprintf( '<label>%s</label>', $args['duration_label'] );
				$markup 	.= sprintf( '<span>%s</span>', $course_duration);
				$markup 	.= '</div>';
			}
		}
		return $markup;
	}

	/**
	 * custom tabs for label & value
	 * @since 1.0.0
	 */
	public function get_settings_modal_toggles () {
		return array(
			'advanced'	=> array(
				'toggles'	=> array(
					'duration_label_value_style'		=> array(
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

		//settings attrs
		$wrapper_selector	= '%%order_class%% .tutor-divi-course-duration';
		$display			= "flex"; //default display:flex
		$layout 			= $this->props['duration_layout'];
		$alignment  		= $this->props['duration_alignment'];
		$gap 				= $this->props['gap'];
		$gap_tablet			= isset($this->props['gap_tablet']) ? $this->props['gap_tablet'] : '';
		$gap_phone			= isset($this->props['gap_phone']) ? $this->props['gap_phone'] : '';

		//set flext alignemnt as per alignment
		if( $alignment === 'left' ) {
			$alignment = 'flex-start';
		}
		elseif( $alignment === 'right' ) {
			$alignment = 'flex-end';
		}
		else {
			$alignment = 'center';
		}

		//set styles
		if( '' !== $display ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $wrapper_selector,
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
					'selector'		=> $wrapper_selector,
					'declaration'	=> sprintf(
						'column-gap: %1$s;',
						esc_html( $gap ) 
					)
				)				
			);
		} elseif ( '' !== $gap && $layout == 'column' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $wrapper_selector,
					'declaration'	=> sprintf(
						'row-gap: %1$s;',
						esc_html( $gap ) 
					)
				)				
			);
		}

		//gaping for tablet
		if( '' !== $gap_tablet && $layout == 'row' ) { 
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $wrapper_selector,
					'declaration'	=> sprintf(
						'column-gap: %1$s;',
						esc_html( $gap_tablet ) 
					),
					'media_query'	=> ET_Builder_Element::get_media_query('max_width_980')
				)				
			);
		} elseif ( '' !== $gap_tablet && $layout == 'column' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $wrapper_selector,
					'declaration'	=> sprintf(
						'row-gap: %1$s;',
						esc_html( $gap_tablet ) 
					)
				)				
			);
		}
		//gaping for phone
		if( '' !== $gap_phone && $layout == 'row' ) { 
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $wrapper_selector,
					'declaration'	=> sprintf(
						'column-gap: %1$s;',
						esc_html( $gap_phone ),
					),
					'media_query'	=> ET_Builder_Element::get_media_query('max_width_767')
				)				
			);
		} elseif ( '' !== $gap_phone && $layout == 'column' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $wrapper_selector,
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
					'selector'		=> $wrapper_selector,
					'declaration'	=> sprintf(
						'flex-direction: %1$s;',
						esc_html( $layout )
					)
				)				
			);
		}
		/**
		 * if layout row set prop justify-content
		 * if layout column set prop align-items
		 */
		if( $layout === 'row' ) {
			if( '' !== $alignment ) { 
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'		=> $wrapper_selector,
						'declaration'	=> sprintf(
							'justify-content: %1$s',
							esc_html( $alignment )
						)
					)				
				);
			}			
		}
		else {
			if( '' !== $alignment ) { 
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'		=> $wrapper_selector,
						'declaration'	=> sprintf(
							'align-items: %1$s',
							esc_html( $alignment )
						)
					)				
				);
			}				
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

new TutorCourseDuration;
