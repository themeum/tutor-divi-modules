<?php

/**
 * Tutor Course Author Module for Divi Builder
 * @since 1.0.0
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
					'tab_slug'     	=> 'advanced',
					'toggle_slug'  	=> 'total_enroll_label_value_style',
					'sub_toggle'	=> 'label_subtoggle'
				),

				'value_text'	=> array(
					'css'			=> array(
						'main'	=> $value_selector
					),
					'tab_slug'		=> 'advanced',
					'toggle_slug'	=> 'total_enroll_label_value_style',
					'sub_toggle'	=> 'value_subtoggle'
				)

			),
			'button'         => false,
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
	 */
	public function get_props( $args=[] ) {
		$course_id = $args['course'];
		$total_enrolled = (int) tutor_utils()->count_enrolled_users_by_course();
		return $total_enrolled;
	}

	/**
	 * Get the tutor course author
	 *
	 * @return string
	 */
	public static function get_content($args = []) {
		$course = Helper::get_course($args);
		$markup = '';
		if ($course) {
			$total_enrolled = (int) tutor_utils()->count_enrolled_users_by_course();
			$disable_total_enrolled = get_tutor_option('disable_course_total_enrolled');
			if (!$disable_total_enrolled) {
				$markup = '<div class="tutor-single-course-meta-total-enroll">';
				$marup  .= sprintf( '<label>%1$s</label>' , $args['enroll_label'] );
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

		$output = self::get_content($this->props);

		// Render empty string if no output is generated to avoid unwanted vertical space.
		if ('' === $output) {
			return '';
		}

		return $this->_render_module_wrapper($output, $render_slug);
	}
}

new TutorCourseTotalEnroll;
