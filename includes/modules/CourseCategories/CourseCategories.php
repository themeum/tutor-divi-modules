<?php

/**
 * Tutor Course Categories Module for Divi Builder
 * @since 1.0.0
 */

use TutorLMS\Divi\Helper;

class TutorCourseCategories extends ET_Builder_Module {
	// Module slug (also used as shortcode tag)
	public $slug       = 'tutor_course_categories';
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
		$this->name			= esc_html__('Tutor Course Categories', 'tutor-divi-modules');
		$this->icon_path	= plugin_dir_path( __FILE__ ) . 'icon.svg';

		// Toggle settings
		// Toggles are grouped into array of tab name > toggles > toggle definition
		$this->settings_modal_toggles = array(
			'general'	=> array(
				'toggles'	=> array(
					'main_content' => esc_html__('Content', 'tutor-divi-modules'),
				),
			),
			// 'advanced'	=> array(
			// 	'toggles'	=> array(
			// 		'normal_style'	=> array(
			// 			'title'			=> esc_html__( 'Normals', 'tutor-divi-modules' )
			// 		),
			// 		'hover_style'	=> array(
			// 			'title'			=> esc_html__( 'Hovers', 'tutor-divi-modules' )
			// 		),
			// 	)
			// )
		);

		$selector = '%%order_class%% .tutor-single-course-meta-categories a';
		$this->advanced_fields = array(
			'fonts'          => array(
				'normal_style' => array(
					'css'          		=> array(
						'main' => $selector,
					),
					'tab_slug'     		=> 'advanced',
					'toggle_slug'  		=> 'normal_hover_style',
					'sub_toggle'		=> 'normal_subtoggle',
					'hide_text_align'	=> true,
					'hide_line_height'	=> true
				),

				'hover_style' => array(
					'css'          => array(
						'main' => $selector,
					),
					'tab_slug'     	=> 'advanced',
					'toggle_slug'  	=> 'normal_hover_style',
					'sub_toggle'	=> 'hover_subtoggle',
					'hide_text_align'	=> true,
					'hide_line_height'	=> true
				),
			),
			'button'			=> false,
			'max_width'			=> false,
			'margin_padding'	=> false,
			'borders'			=> false,
			'text'				=> false
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
						'__categories',
					),
				)
			),
			'__categories'		=> array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'TutorCourseCategories',
					'get_content',
				),
				'computed_depends_on' => array(
					'course'
				),
				'computed_minimum'    => array(
					'course',
				),
			),
			//general tab settings content toggle
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
	 */
	public function get_settings_modal_toggles () {
		return array(
			'advanced'	=> array(
				'toggles'	=> array(
					'normal_hover_style'		=> array(
						'priority'		=> 24,
						'sub_toggles'	=> array(
							'normal_subtoggle'	=> array(
								'name'	=> esc_html__('Normal', 'tutor-divi-modules')
							),
							'hover_subtoggle'	=> array(
								'name'	=> esc_html__('Hover', 'tutor-divi-modules')
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
	 * Get the tutor course author
	 *
	 * @return string
	 */
	public static function get_content($args = []) {
		$course = Helper::get_course($args);
		$markup = '<div class="tutor-single-course-meta-categories">';
		if ($course) {
			$course_categories = get_tutor_course_categories();
			$count = 1;
			foreach ($course_categories as $course_category) {
				$category_name = $course_category->name;
				$comma = count($course_categories) > $count ? ', ' : '';
				$category_link = get_term_link($course_category->term_id);
				$markup .= " <a href='$category_link'>$category_name</a>".$comma;
				$count++;
			}
		}
		$markup .= "</div>";

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

new TutorCourseCategories;
