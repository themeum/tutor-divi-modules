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
		$this->advanced_fields = array(
			'fonts'		=> array(
				'title'		=> array(
					'css'				=> array(
						'main'	=> 'selector'
					),
					'tab_slug'			=> 'advanced',
					'toggle_slug'		=> 'title'
				),
				'tags'	=> array(
					'css'				=> array(
						'main'	=> ''
					),
					'tab_slug'			=> 'advanced',
					'toggle_slug'		=> 'tags',
				),
			),
			'borders'    => array(
				'default'		=> array(
					'css'	=> array(
						'main'	=> array(
							'border_style'	=> '',
							'border_radii'	=> ''
						)
					)
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

		$output = self::get_content($this->props);

		// Render empty string if no output is generated to avoid unwanted vertical space.
		if ('' === $output) {
			return '';
		}

		return $this->_render_module_wrapper($output, $render_slug);
    }

}
new CourseTags;