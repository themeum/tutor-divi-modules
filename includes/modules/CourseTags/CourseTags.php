<?php

/**
 * Tutor Course Author Module for Divi Builder
 * @since 1.0.0
 */

use TutorLMS\Divi\Helper;

class CourseTags extends ET_Builder_Module {

    // Module slug (also used as shortcode tag)
    public $slug        = 'tutor_course_tags';
    public $vb_support  = 'on';

	// Module Credits (Appears at the bottom of the module settings modal)
	protected $module_credits = array(
		'author'     => 'Themeum',
		'author_uri' => 'https://themeum.com',
	);

    public function init() {
        $this->name         = esc_html__( 'Tutor Course Tags', 'tutor-divi-modules' ); 
        $this->icon_path	= plugin_dir_path( __FILE__ ) . 'icon.svg';

		/**
		 * settings toggles
		 * set all the toggles that will show in different tabs
		 */
		$this->settings_modal_toggles = array(
			'general'  => array(

			),
			'advanced'	=> array(
				'toggles'		=> array(
					'title'		=> array(
						'title'		=> esc_html__( 'Section Title', 'tutor-divi-modules' ),
					),
					'tags'		=> array(
						'title'		=> esc_html__( 'Tags', 'tutor-divi-modules' )
					)
				)
			)
		);

		/**
		 * advanced tabs settings
		 */
		$wrapper			= '%%order_class%% .tutor-divi-course-tags-wrapper';
		$tag_title_selector	= $wrapper.' .tutor-segment-title';
		$tags_selector		= $wrapper.' .tutor-course-tags a';

		$this->advanced_fields = array(
			'fonts'		=> array(
				'title'		=> array(
					'css'				=> array(
						'main'	=> $tag_title_selector
					),
					'hide_text_align'	=> true,
					'tab_slug'			=> 'advanced',
					'toggle_slug'		=> 'title'
				),
				'tags'	=> array(
					'css'				=> array(
						'main'	=> $tags_selector
					),
					'hide_text_align'	=> true,
					'tab_slug'			=> 'advanced',
					'toggle_slug'		=> 'tags',
				),
			),

			'borders'    => array(
				'default'            =>  false,
				'tags'				 => array(
					'css'             	=> array(
						'main' => array(
							'border_styles' => '%%order_class%% .tutor-divi-course-tags-wrapper .tutor-course-tags > a',
							'border_radii'  => '%%order_class%% .tutor-divi-course-tags-wrapper .tutor-course-tags > a',
						),
						'important'		=> true
					),	
					'tab_slug'		=> 'advanced',
					'toggle_slug'	=> 'tags'					
				)
			),				
			'margin_padding' => array(
				'css'	=> array(
					'margin'	=> '%%order_class%% .tutor-divi-course-tags-wrapper .tutor-course-tags a',
					'padding'	=> '%%order_class%% .tutor-divi-course-tags-wrapper .tutor-course-tags a',
					'important'	=> 'all'
				),
			),
			'box_shadow' => array(
				'default' => array(
					'css' => array(
						'main' => '%%order_class%% .tutor-divi-course-tags-wrapper .tutor-course-tags a',
					),
				),
			),			
		);
    }

    public function get_fields() {
		return array(
			'course'       	=> Helper::get_field(
				array(
					'default'          => Helper::get_course_default(),
					'computed_affects' => array(
						'__share',
					),
				)
			),
			'__tags'		=> array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'CourseTags',
					'get_props',
				),
				'computed_depends_on' => array(
					'course'
				),
				'computed_minimum'    => array(
					'course',
				),
			),
			//general settings tab main_content toggle			
			'label'     => array(
				'label'           	=> esc_html__( 'Label', 'tutor-divi-modules' ),
				'type'            	=> 'text',
				'default'			=> esc_html__( 'Course Tags', 'tutor-divi-modules'),
				'option_category' 	=> 'basic_option',
				'toggle_slug'     	=> 'main_content',
			),
			//advanced settings tab tags toggle
			'tags_background'	=> array(
				'label'				=> esc_html__( 'Background Color', 'tutor-divi-modules'),
				'type'				=> 'color-alpha',
				'tab_slug'			=> 'advanced',
				'toggle_slug'		=> 'tags',
				'priority'			=> 67,
				'hover'				=> 'tabs'
			)
		);
    }

	/**
	 * computed value
	 * @return string | array course level
	 */
	public static function get_props( $args = [] ) {
		$course_id 	= $args[ 'course' ];
		$tags 		= get_tutor_course_tags( $course_id );
		$props 		= array(
			'tags'	=> $tags
		);
		return $props;
	}

	/**
	 * Get the tutor course author
	 *
	 * @return string
	 */
	public static function get_content($args = []) {
		ob_start();
		include_once dtlms_get_template('course/tags');
		return ob_get_clean();
	}	

    public function render( $attr, $content = null, $render_slug) {
		//selectors 
		$wrapper			= '%%order_class%% .tutor-divi-course-tags-wrapper';
		$tag_title_selector	= $wrapper.' .tutor-segment-title';
		$tags_selector		= $wrapper.' .tutor-course-tags a';
		//props
		$background			= $this->props['tags_background'];
		$background_hover	= isset( $this->props['tags_background__hover'] ) ? $this->props['tags_background__hover'] : $background ;

		//set styles
		if( '' !== $background ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $tags_selector,
					'declaration'	=> sprintf(
						'background-color: %1$s;',
						esc_html( $background )
					) 
				)
			);
		}

		if( '' !== $background_hover ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $tags_selector.':hover',
					'declaration'	=> sprintf(
						'background-color: %1$s;',
						esc_html( $background_hover )
					) 
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
new CourseTags;