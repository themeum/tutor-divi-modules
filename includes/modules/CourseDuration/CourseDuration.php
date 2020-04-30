<?php

/**
 * Tutor Course Author Module for Divi Builder
 * @since 1.0.0
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

		// Toggle settings
		// Toggles are grouped into array of tab name > toggles > toggle definition
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__('Content', 'tutor-divi-modules'),
				),
			),
		);
		
		$selector = '%%order_class%% .tutor-single-course-meta-duration';
		$this->advanced_fields = array(
			'fonts'          => array(
				'text' => array(
					'css'          => array(
						'main' => $selector,
					),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'text',
				),
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
						'__duration',
					),
				)
			),
			'__duration'	=> array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'TutorCourseDuration',
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
	 * Get the tutor course author
	 *
	 * @return string
	 */
	public static function get_content($args = []) {
		$course = Helper::get_course($args);
		$markup = '';
		if ($course) {
			$course_duration = get_tutor_course_duration_context();
			$disable_course_duration = get_tutor_option('disable_course_duration');
			if (!empty($course_duration) && !$disable_course_duration) {
				$markup = '<div class="tutor-single-course-meta-duration">';
				$markup .= $course_duration;
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

new TutorCourseDuration;
