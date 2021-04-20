<?php

/**
 * Tutor Course Author Module for Divi Builder
 * @since 1.0.0
 */

use TutorLMS\Divi\Helper;

class CourseStatus extends ET_Builder_Module {

    // Module slug (also used as shortcode tag)
    public $slug        = 'tutor_course_status';
    public $vb_support  = 'on';

	// Module Credits (Appears at the bottom of the module settings modal)
	protected $module_credits = array(
		'author'     => 'Themeum',
		'author_uri' => 'https://themeum.com',
	);

    public function init() {
        $this->name         = esc_html__( 'Tutor Course Status', 'tutor-divi-modules' ); 
        $this->icon_path	= plugin_dir_path( __FILE__ ) . 'icon.svg';

		//toggles settings (content tab)
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__('Content', 'tutor-divi-modules'),
				),
			),
			'advanced'	=> array(
				'toggles'	=> array(
					'section_title'	=> array(
						'title'	=> esc_html__( 'Section Title', 'tutor-divi-modules')
					),
					'progress_bar'	=> array(
						'title'	=> esc_html__( 'Progress Bar', 'tutor-divi-modules')
					),
					'progress_text'	=> array(
						'title'	=> esc_html__( 'Progress Text', 'tutor-divi-modules')
					),
				)
			)
		);

		//advanced fields settings (design tab)
		$label_selector		= '%%order_class%% .tutor-course-status .tutor-segment-title';
		$text_selector		= '%%order_class%% .tutor-course-status .tutor-progress-percent';

		$this->advanced_fields = array (
			'fonts'		=> array(
				'label'				=> array(
					'label'			=> esc_html__( 'Section Title', 'tutor-divi-modules'),
					'css'			=> array(
						'main'	=> $label_selector
					),
					'tab_slug'		=> 'advanced',
					'toggle_slug'	=> 'section_title'
				),
				'progress_text'		=> array(
					'label'			=> esc_html__( 'Progress Text', 'tutor-divi-modules'),
					'css'			=> array(
						'main'	=> $text_selector
					),
					'hide_text_align'	=> true,
					'tab_slug'		=> 'advanced',
					'toggle_slug'	=> 'progress_text'
				),
			),
			'button'	=> false
		);
    }

    public function get_fields() {
		return array(
			'status_label'    	=> array(
				'label'				=> esc_html__( 'Label', 'tutor-divi-modules' ),
				'type'            	=> 'text',
				'default'			=> esc_html__( 'Course Status', 'tutor-divi-modules' ),
				'option_category' 	=> 'basic_option',
				'toggle_slug'     	=> 'main_content',
			),
            'display_percent'	=> array(
				'label'				=> esc_html__( 'Dispaly Percent', 'tutor-divi-modules' ),
				'type'            	=> 'yes_no_button',
				'options'			=> array(
					'on'	=> esc_html__( 'Show', 'tutor-divi-modules' ),
					'off'	=> esc_html__( 'Hide', 'tutor-divi-modules' ),
				),
				'default'			=> 'on',
				'option_category' 	=> 'basic_option',
				'toggle_slug'     	=> 'main_content',
			),
			'position'			=> array(
				'label'				=> esc_html__( 'Position', 'tutor-divi-modules'),
				'type'				=> 'select',
				'options'			=> array(
					'inside'	=> esc_html__( 'Inside', 'tutor-divi-modules' ),
					'outside'	=> esc_html__( 'Outside', 'tutor-divi-modules' ),
					'on_top'	=> esc_html__( 'On Top', 'tutor-divi-modules' ),
				),
				'default'			=> 'outside',
				'toggle_slug'		=> 'main_content'
			),

			//progress bar advanced tab
			'bar_color'			=> array(
				'label'			=> esc_html__( 'Color', 'tutor-divi-modules'),
				'type'			=> 'color-alpha',
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'progress_bar'
			),
			'bar_background'	=> array(
				'label'			=> esc_html__( 'Background Color', 'tutor-divi-modules'),
				'type'			=> 'color-alpha',
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'progress_bar'
			),
			'bar_height'		=> array(
				'label'			=> esc_html__( 'Height', 'tutor-divi-modules'),
				'type'			=> 'range',
				'default_unit'	=> 'px',
				'default'		=> '15',
				'range_settings'=> array(
					'min'	=> 1,
					'max'	=> 100,
					'step'	=> 1
				),
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'progress_bar'				
			),
			'bar_radius'		=> array(
				'label'			=> esc_html__( 'Border Radius', 'tutor-divi-modules'),
				'type'			=> 'range',
				'default_unit'	=> 'px',
				'default'		=> '30',
				'range_settings'=> array(
					'min'	=> 1,
					'max'	=> 100,
					'step'	=> 1
				),
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'progress_bar'				
			),
			'gap'		=> array(
				'label'			=> esc_html__( 'Gap', 'tutor-divi-modules'),
				'type'			=> 'range',
				'default_unit'	=> 'px',
				'default'		=> '10',
				'range_settings'=> array(
					'min'	=> 1,
					'max'	=> 100,
					'step'	=> 1
				),
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'progress_bar',
				'mobile_options'=> true				
			),

		);
    }
	/**
	 * Get the tutor course author
	 *
	 * @return string
	 */
	public static function get_content($args = []) {
		ob_start();
		include_once dtlms_get_template('course/status');
		return ob_get_clean();
	}

	/**
	 * @return template
	 */
    public function render( $attr, $content = null, $render_slug) {
        //selectors
		$wrapper				= '%%order_class%% .tutor-course-status';
        $progress_bar_wrap		= '%%order_class%% .tutor-progress-bar-wrap';
        $progress_bar_selector	= '%%order_class%% .tutor-progress-bar';
        $progress_fill_selector = '%%order_class%% .tutor-progress-bar .tutor-progress-filled';
        $text_selector			= '%%order_class%% .tutor-progress-percent';

        //props
        $position				= $this->props[ 'position' ];
        $bar_color				= $this->props[ 'bar_color' ];
        $bar_background			= $this->props[ 'bar_background' ];
        $bar_height				= $this->props[ 'bar_height' ];
        $bar_radius				= $this->props[ 'bar_radius' ];

		$gap					= $this->props['gap'];
		$gap_tablet				= isset( $this->props['gap_tablet'] ) && '' !== $this->props['gap_tablet'] ? $this->props['gap_tablet'] : $gap;
		$gap_phone				= isset( $this->props['gap_phone'] ) && '' !== $this->props['gap_phone'] ? $this->props['gap_phone'] : $gap;

		//set style
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'		=> $progress_fill_selector.':after',
				'declaration'	=> 'content: none;'
			)
		);		
		if( '' !== $position && $position === 'inside' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $text_selector,
					'declaration'	=> 'position: absolute; left: 50%;'
				)
			);
		}

		if( '' !== $position && $position === 'on_top' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $progress_bar_wrap,
					'declaration'	=> 'dislay: flex; flex-direction: column-reverse;'
				)
			);
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $text_selector,
					'declaration'	=> 'align-self: flex-end;'
				)
			);
		}

		if( '' !== $bar_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $progress_fill_selector,
					'declaration'	=> sprintf(
						'background-color: %1$s;',
						$bar_color
					)
				)
			);
		}

		if( '' !== $bar_background ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $progress_bar_selector,
					'declaration'	=> sprintf(
						'background-color: %1$s;',
						$bar_background
					)
				)
			);
		}

		if( '' !== $bar_height ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $progress_bar_selector,
					'declaration'	=> sprintf(
						'height: %1$s;',
						$bar_height
					)
				)
			);
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $progress_fill_selector,
					'declaration'	=> sprintf(
						'height: %1$s;',
						$bar_height
					)
				)
			);
		}

		if( '' !== $bar_radius ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $progress_bar_selector,
					'declaration'	=> sprintf(
						'border-radius: %1$s;',
						$bar_radius
					)
				)
			);
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $progress_fill_selector,
					'declaration'	=> sprintf(
						'border-radius: %1$s;',
						$bar_radius
					)
				)
			);
		}

		//gap style
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'		=> $wrapper,
				'declaration'	=> 'display: flex; flex-direction: column;'
			)				
		);

		if ( '' !== $gap ) {
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
		if ( '' !== $gap_tablet ) {
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
		if ( '' !== $gap_phone ) {
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
		//set style end
		$output = self::get_content($this->props);

		// Render empty string if no output is generated to avoid unwanted vertical space.
		if ('' === $output) {
			return '';
		}

		return $this->_render_module_wrapper($output, $render_slug);
    }

}
new CourseStatus;