<?php

/**
 * Tutor Course Materials Module for Divi Builder
 * @since 1.0.0
 */

use TutorLMS\Divi\Helper;

class TutorCourseMaterials extends ET_Builder_Module {
	// Module slug (also used as shortcode tag)
	public $slug       = 'tutor_course_materials';
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
		$this->name			= esc_html__('Tutor Course Materials', 'tutor-divi-modules');
		$this->icon_path	= plugin_dir_path( __FILE__ ) . 'icon.svg';

		// Toggle settings
		// Toggles are grouped into array of tab name > toggles > toggle definition
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__('Content', 'tutor-divi-modules'),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'title' => array(
						'title'		=> esc_html__('Section Title', 'tutor-divi-modules'),
					),
					'list'	=> array(
						'title'		=> esc_html__( 'List', 'tutor-divi-modules' ),
					),
					'icon' => array(
						'title'		=> esc_html__('Icon', 'tutor-divi-modules'),
					),
					'text' => array(
						'title'		=> esc_html__('Text', 'tutor-divi-modules'),
					),
				),
			),
		);
		
		$selector = '%%order_class%% .tutor-course-material-includes-wrap';
        $title_selector = $selector.' h4.tutor-segment-title';
        $text_selector = $selector.' .tutor-course-target-audience-items';
		$icon_selector = $text_selector.' li:before';
		
		$this->advanced_fields = array(
			'fonts'          => array(
				'title' => array(
					'css'          => array(
						'main' => $title_selector,
					),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'title',
				),
				'text' => array(
					'css'          => array(
						'main' => $text_selector,
					),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'text',
				),
			),
			'borders'	=> array(
				'list'			=> array(
					'css'			=> '',
					'tab_slug'		=> 'advanced',
					'toggle_slug'	=> 'list'
				)
			),

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
						'__materials',
					),
				)
			),
			'__materials'		=> array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'TutorCourseMaterials',
					'get_props',
				),
				'computed_depends_on' => array(
					'course'
				),
				'computed_minimum'    => array(
					'course',
				),
			),
			//general settings content tab
			'label'		=> array(
				'label'				=> esc_html__( 'Material Label', 'tutor-divi-modules'),
				'type'				=> 'text',
				'default'			=> esc_html__( 'Material Includes', 'tutor-divi-modules' ),
				'option_category'	=> 'basic',
				'toggle_slug'		=> 'main_content'
	
			),
			'layout'	=> array(
				'label'				=> esc_html( 'Layout', 'tutor-divi-modules' ),
				'type'				=> 'select',
				'options'			=> array(
					'list'		=> esc_html__( 'List', 'tutor-divi-modules' ), 
					'inline'	=> esc_html__( 'Inline', 'tutor-divi-modules' ), 
				),
				'default'			=> 'list',
				'option_category'	=> 'layout',
				'toggle_slug'		=> 'main_content',
				'mobile_options'	=> true
			),
			'icon' => array(
				'label'             => esc_html__( 'Icon', 'tutor-divi-modules' ),
				'type'              => 'select_icon',
				'default'			=> 'N',
				'class'				=> array( 'et-pb-font-icon' ),
				'option_category'   => 'basic_option',
				'toggle_slug'     	=> 'main_content',		
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
			//advanced tab section title toggles
			'gap'			=> array(
				'label'				=> esc_html__( 'Gap', 'tutor-divi-modules' ),
				'type'				=> 'range',
				'default'			=> '10',
				'default_unit'		=> 'px',
				'range_settings'	=> array(
					'min'	=> 1,
					'max'	=> 100,
					'step'	=> 1
				),
				'tab_slug'			=> 'advanced',
				'toggle_slug'		=> 'title',
				'mobile_options'	=> true
			),
			//advanced tab section list toggles
			'space_between'	=> array(
				'label'				=> esc_html__( 'Space Between', 'tutor-divi-modules' ),
				'type'				=> 'range',
				'default'			=> '10',
				'default_unit'		=> 'px',
				'range_settings'	=> array(
					'min'	=> 1,
					'max'	=> 100,
					'step'	=> 1
				),
				'tab_slug'			=> 'advanced',
				'toggle_slug'		=> 'list',
				'mobile_options'	=> true				
			),
			'padding'		=> array(
				'label'           	=> esc_html__( 'Padding', 'tutor-divi-modules' ),
				'type'            	=> 'custom_padding',
				'hover'           	=> 'tabs',
				'option_category' 	=> 'layout',
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'list',
				'allowed_units'   	=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
			),
			//advanced tab text toggle
			'color'			=> array(
				'label'				=> esc_html__( 'Color', 'tutor-divi-modules' ),
				'type'				=> 'color-alpha',
				'tab_slug'			=> 'advanced',
				'toggle_slug'		=> 'icon'
			),
			'size'			=> array(
				'label'				=> esc_html__( 'Size', 'tutor-divi-modules' ),
				'type'				=> 'range',
				'default'			=> '12',
				'default_unit'		=> 'px',
				'range_settings'	=> array(
					'min'	=> '1',
					'max'	=> '100',
					'step'	=> '1'
				),
				'tab_slug'			=> 'advanced',
				'toggle_slug'		=> 'icon',
				'mobile_option'		=> true
			),

		);

		return $fields;
	}
	
	/**
	 * get material props
	 */
	public static function get_props( $args = [] ) {
		$course_id	= $args['course'];
		$materials	= tutor_course_material_includes( $course_id );
		$props		= array(
			'materials'	=> $materials
		);
		return $materials;
	}

	/**
	 * Get content
	 *
	 * @return string
	 */
	public static function get_content($args = []) {
		$course = Helper::get_course($args);

		ob_start();
		if( $course ) {
			include_once ( dtlms_get_template('course/material') );
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
	public function render($attrs, $content = null, $render_slug) {
		//selectors
		$wrapper			= '%%order_class%% .tutor-course-material-includes-wrap';
		$li_selector		= $wrapper." li";

		//props

		//set styles
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'		=> $li_selector."::before",
				'declaration'	=> 'content: none;'
			)
		);

		//set styles end

		$output = self::get_content($this->props);

		// Render empty string if no output is generated to avoid unwanted vertical space.
		if ('' === $output) {
			return '';
		}

		return $this->_render_module_wrapper($output, $render_slug);

	}
}

new TutorCourseMaterials;
