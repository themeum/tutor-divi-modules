<?php

/**
 * Tutor Course Level Module for Divi Builder
 * @since 1.0.0
 * @author Themeum<www.themeum.com>
 */

use TutorLMS\Divi\Helper;

defined( 'ABSPATH' ) || exit;

class TutorCourseLevel extends ET_Builder_Module {
	// Module slug (also used as shortcode tag)
	public $slug       = 'tutor_course_level';
	public $vb_support = 'on';
	public $icon_path;

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
		$this->name			= esc_html__('Tutor Course Level', 'tutor-lms-divi-modules');
		$this->icon_path	= plugin_dir_path( __FILE__ ) . 'icon.svg';

		// Toggle settings
		// Toggles are grouped into array of tab name > toggles > toggle definition
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__('Content', 'tutor-lms-divi-modules'),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'label_text' => array(
						'title'    => esc_html__('Label', 'tutor-lms-divi-modules'),
					),
					'value_text' => array(
						'title'    => esc_html__('Value', 'tutor-lms-divi-modules'),
					),
				),
			),
		);
		
		$wrapper = '%%order_class%% .tutor-course-level';
		$label_selector = '%%order_class%% .tutor-course-level > label';
		$value_selector = '%%order_class%% .tutor-course-level > span';

		$this->advanced_fields = array(
			'fonts'          => array(
				'label_text' => array(
					'label'        => esc_html__('Label', 'tutor-lms-divi-modules'),
					'css'          => array(
						'main' => $label_selector,
					),
					'hide_text_align'	=> true,
					'tab_slug'     		=> 'advanced',
					'toggle_slug'  		=> 'course_level_label_value_style',
					'sub_toggle'		=> 'label_subtoggle'
				),
				'value_text' => array(
					'label'        		=> esc_html__('Name', 'tutor-lms-divi-modules'),
					'css'          		=> array(
						'main' => $value_selector,
					),
					'hide_text_align'	=> true,
					'tab_slug'     		=> 'advanced',
					'toggle_slug'  		=> 'course_level_label_value_style',
					'sub_toggle'		=> 'value_subtoggle'
				),
			),
			'button'		=> false,
            'borders'           => false,
            'box_shadow'        => false,
            'text'              => false,
            'max_width'         => false,
            //'margin_padding'  => false,           
            'background'        => false,
            'filters'           => false,
            'animation'         => false,
            'transform'         => false
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
						'__level',
					),
				)
			),
			'__level'		=> array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'TutorCourseLevel',
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
			'course_level_label'	=> array(
				'label'			=> esc_html__( 'Label', 'tutor-lms-divi-modules' ),
				'type'			=> 'text',
				'default'		=> 'Course Level:',
				'toggle_slug'	=> 'main_content'
			),
			'layout'		=> array(
				'label'				=> esc_html__( 'Layout', 'tutor-lms-divi-modules' ),
				'type'				=> 'select',
				'option_category'	=> 'layout',
				'options'			=> array(
					'row'		=> esc_html__( 'Left', 'tutor-lms-divi-modules' ),
					'column'	=> esc_html__( 'Up', 'tutor-lms-divi-modules' )
				),
				'default'			=> 'row',
				'toggle_slug'		=> 'main_content',
				'mobile_options'	=> true
			),
			'alignment'		=> array(
				'label'				=> esc_html__('Alignment', 'tutor-lms-divi-modules'),
				'type'				=> 'text_align',
				'option_category'	=> 'configuration',
				'options'			=> et_builder_get_text_orientation_options( array( 'justified' ) ),
				'default'			=> 'left',
				'toggle_slug'		=> 'main_content',
				'mobile_options'	=> true
			),
			'gap'			=> array(
				'label'				=> esc_html__( 'Gap', 'tutor-lms-divi-modules' ),
				'type'				=> 'range',
				'option_category'	=> 'layout',
				'default_unit'		=> 'px',
				'default'			=> '5px',
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
					'course_level_label_value_style'		=> array(
						'priority'		=> 24,
						'sub_toggles'	=> array(
							'label_subtoggle'	=> array(
								'name'	=> esc_html__('Label', 'tutor-lms-divi-modules')
							),
							'value_subtoggle'	=> array(
								'name'	=> esc_html__('Value', 'tutor-lms-divi-modules')
							),
						),
						'tabbed_subtoggles' => true,
						'title' => esc_html__('Style', 'tutor-lms-divi-modules'),
					),
				)
			)
		);
	}

	/**
	 * computed value
	 * @return string | array course level
	 */
	public static function get_props( $args = [] ) {
		$course_id = $args['course'];
		$disable_course_level = get_tutor_option('disable_course_level');
		$level = get_tutor_course_level( $course_id ) ? get_tutor_course_level( $course_id ) : __('All Level', 'tutor-lms-divi-modules');
		$props = array(
			'is_disable_level'	=> $disable_course_level,
			'level'				=> $level
		);
		return $props;
	}

	/**
	 * Get the tutor course author
	 *
	 * @return string
	 */
	public static function get_content($args = []) {
		$course = Helper::get_course($args);
		ob_start();
		if ($course) {
			include_once dtlms_get_template('course/level');
		}

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
	public function render($attrs, $content, $render_slug) {
		//selectors
		$wrapper = '%%order_class%% .tutor-course-level';
		$label_selector = '%%order_class%% .tutor-course-level > label';
		$value_selector = '%%order_class%% .tutor-course-level > span';

		//props
		$layout			= sanitize_text_field( $this->props['layout'] );
		$layout_tablet	= isset( $this->props['layout_tablet'] ) && '' !== $this->props['layout_tablet'] ? sanitize_text_field( $this->props['layout_tablet'] ) : $layout;
		$layout_phone	= isset( $this->props['layout_phone'] ) && '' !== $this->props['layout_phone'] ? sanitize_text_field( $this->props['layout_phone'] ) : $layout;

		$alignment		= sanitize_text_field( $this->props['alignment'] );
		if( $alignment === 'left' ) {
			$alignment = 'flex-start';
		} else if( $alignment === 'center') {
			$alignment = 'center';
		} else {
			$alignment = 'flex-end';
		}
		$alignment_tablet	= isset( $this->props['alignment_tablet'] ) && '' !== $this->props['alignment_tablet'] ? sanitize_text_field( $this->props['alignment_tablet'] ) : $alignment;
		$alignment_phone	= isset( $this->props['alignment_phone'] ) && '' !== $this->props['alignment_phone'] ? sanitize_text_field( $this->props['alignment_phone'] ) : $alignment;


		$gap			= sanitize_text_field( $this->props['gap'] );
		$gap_tablet		= isset( $this->props['gap_tablet'] ) && '' !== $this->props['gap_tablet'] ? sanitize_text_field( $this->props['gap_tablet'] ) : $gap;
		$gap_phone		= isset( $this->props['gap_phone'] ) && '' !== $this->props['gap_phone'] ? sanitize_text_field( $this->props['gap_phone'] ) : $gap;

		$display		= 'flex';
		$width			= '100%';
		//set styles
		if( '' !== $display ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $wrapper,
					'declaration'	=> sprintf(
						'display: %1$s; width: %2$s;',
						esc_html($display),
						esc_html($width)
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
					)
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

new TutorCourseLevel;
