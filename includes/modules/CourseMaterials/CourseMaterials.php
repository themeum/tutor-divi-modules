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
						'title'    => esc_html__('Title', 'tutor-divi-modules'),
					),
					'icon' => array(
						'title'    => esc_html__('Icon', 'tutor-divi-modules'),
					),
					'text' => array(
						'title'    => esc_html__('Text', 'tutor-divi-modules'),
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
				'icon' => array(
					'css'          => array(
						'main' => $icon_selector,
					),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'icon',
				),
				'text' => array(
					'css'          => array(
						'main' => $text_selector,
					),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'text',
				),
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
					'get_content',
				),
				'computed_depends_on' => array(
					'course'
				),
				'computed_minimum'    => array(
					'course',
				),
			),
		);

		return $fields;
	}

	/**
	 * Get content
	 *
	 * @return string
	 */
	public static function get_content($args = []) {
		$course = Helper::get_course($args);
		$output = '';
		if ($course) {
			$output = tutor_course_material_includes_html(false); //echo false
		}

		return $output;
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

new TutorCourseMaterials;
