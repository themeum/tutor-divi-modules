<?php

/**
 * Tutor Course Author Module for Divi Builder
 * @since 1.0.0
 */

use TutorLMS\Divi\Helper;

class TutorCourseShare extends ET_Builder_Module {
	// Module slug (also used as shortcode tag)
	public $slug       = 'tutor_course_share';
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
		$this->name			= esc_html__('Tutor Course Share', 'tutor-divi-modules');
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
					'label' => array(
						'title'    => esc_html__('Label', 'tutor-divi-modules'),
					),
					'icons' => array(
						'title'    => esc_html__('Icons', 'tutor-divi-modules'),
					),
				),
			),
		);

        $wrapper 				= '%%order_class%% .tutor-social-share';
        $icon_wrapper_selector	= '%%order_class%% .tutor-social-share-wrap';
		$icon_selector   		= '%%order_class%% .tutor-social-share-wrap button i';
		$button_selector		= '%%order_class%% .tutor-social-share-wrap button';
        $label_selector			= '%%order_class%% .tutor-social-share > label';

		$this->advanced_fields = array(
			'fonts'				=> array(
				'label' => array(
					'label'        		=> esc_html__('Label', 'tutor-divi-modules'),
					'css'          		=> array(
						'main'	=> $label_selector,
					),
					'tab_slug'     		=> 'advanced',
					'toggle_slug'  		=> 'label',
					'hide_text_align'	=> true,
				),
			),
			'borders'    => array(
				'default_unit'		=> 'px',	
				'default'            => array(),
				'image'              => array(
					'css'             => array(
						'main' => array(
							'border_radii'  => $icon_selector,
							'border_styles' => $icon_selector,
						),
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'icons',
				),
			),	
				
			'text'				=> false,
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
						'__share',
					),
				)
			),
			'__share'		=> array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'TutorCourseShare',
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
			'share_label'	=> array(
				'label'				=> esc_html__('Label', 'tutor-divi-modules'),
				'type'				=> 'yes_no_button',
				'option_category'	=> 'configuration',
				'options'			=> array(
					'off'	=> esc_html__('Hide', 'tutor-divi-modules'),
					'on'	=> esc_html__('Show', 'tutor-divi-modules')
				),
				'default_on_front'	=> "on",
				'toggle_slug'		=> 'main_content',	
			),
			'shape'			=> array(
				'label'				=> esc_html__( 'Shape', 'tutor-divi-modules' ),
				'type'				=> 'select',
				'options'			=> array(
					'rounded'	=> esc_html__( 'Rounded', 'tutor-divi-modules' ),
					'circle'	=> esc_html__( 'Circle', 'tutor-divi-modules' ),
					'square'	=> esc_html__( 'Square', 'tutor-divi-modules' ),
				),
				'default'			=> 'rounded',
				'option_category'	=> 'layout',
				'toggle_slug'		=> 'main_content'
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

			//advanced tab icon settings
			'color'			=> array(
				'label'				=> esc_html__( 'Color', 'tutor-divi-modules' ),
				'type'				=> 'select',
				'options'			=> array(
					'official'	=> esc_html__( 'Official Color', 'tutor-divi-modules' ),
					'custom'	=> esc_html__( 'Custom', 'tutor-divi-modules' )
				),
				'default'			=> 'official',
				'tab_slug'			=> 'advanced',
				'toggle_slug'		=> 'icons'
			),
			'icon_color'	=> array(
				'label'				=> esc_html__( 'Icon Color', 'tutor-divi-modules' ),
				'type'				=> 'color-alpha',
				'tab_slug'			=> 'advanced',
				'toggle_slug'		=> 'icons',
				'show_if'			=> array(
					'color'		=> 'custom'
				)
			),
			'shape_color'	=> array(
				'label'				=> esc_html__( 'Shape Color', 'tutor-divi-modules' ),
				'type'				=> 'color-alpha',
				'tab_slug'			=> 'advanced',
				'toggle_slug'		=> 'icons',
				'show_if'			=> array(
					'color'		=> 'custom'
				)				
			),
			'icon_size'		=> array(
				'label'				=> esc_html__( 'Icon Size', 'tutor-divi-modules' ),
				'type'				=> 'range',
				'default_unit'		=> 'px',
				'default'			=> '14',
				'range_settings'	=> array(
					'min'	=> 1,
					'max'	=> 100,
					'step'	=> 1
				),
				'tab_slug'			=> 'advanced',
				'toggle_slug'		=> 'icons',			
			),
			'icon_padding'	=> array(
				'label'			=> esc_html__( 'Padding', 'tutor-divi-modules' ),
				'type'			=> 'custom_padding',
				'default'		=> '10|10|10|10',
				'default_unit'	=> 'px',
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'icons'
			),
			'icon_spacing'		=> array(
				'label'				=> esc_html__( 'Spacing', 'tutor-divi-modules' ),
				'type'				=> 'range',
				'default_unit'		=> 'px',
				'default'			=> '14',
				'range_settings'	=> array(
					'min'	=> 1,
					'max'	=> 100,
					'step'	=> 1
				),
				'tab_slug'			=> 'advanced',
				'toggle_slug'		=> 'icons',	
				'mobile_options'	=> true		
			),
		);

		return $fields;
	}

	/**
	 * computed value
	 * @return string | array course level
	 */
	public static function get_props( $args = [] ) {
		$course_id 			= $args[ 'course' ];
		$is_enable_share	= get_tutor_option('disable_course_share');
		$share_icons		= tutils()->tutor_social_share_icons();

		$props = [
			'is_enable_share'	=> $is_enable_share,
			'social_icon'		=> $share_icons
		];

		return $props;
	}

	/**
	 * Get the tutor course author
	 *
	 * @return string
	 */
	public static function get_content($args = []) {
		ob_start();
		include_once dtlms_get_template('course/share');
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
        $wrapper 				= '%%order_class%% .tutor-social-share';
        $icon_wrapper_selector	= '%%order_class%% .social-share-wrap';
        $label_selector			= '%%order_class%% .tutor-social-share > label';
		
		//props

		//set styles
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'		=> $wrapper,
				'declaration'	=> 'display:flex;column-gap: 10px;'
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

new TutorCourseShare;
