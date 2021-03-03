<?php

/**
 * Tutor Course Requirements Module for Divi Builder
 * @since 1.0.0
 */

use TutorLMS\Divi\Helper;

class TutorCourseRequirements extends ET_Builder_Module {
	// Module slug (also used as shortcode tag)
	public $slug       = 'tutor_course_requirements';
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
		$this->name			= esc_html__('Tutor Course Requirements', 'tutor-divi-modules');
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
		
		$selector = '%%order_class%% .tutor-course-requirements-wrap';
        $title_selector = $selector.' .course-requirements-title h4';
        $text_selector = $selector.' .tutor-course-requirements-items';
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
						'__requirements',
					),
				)
			),
			'__requirements'		=> array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'TutorCourseRequirements',
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
	 * get requirement props
	 */
	public static function get_props( $args = [] ) {
		$course_id		= $args['course'];
		$requirements	= tutor_course_requirements( $course_id );
		$props			= array(
			'requirements'	=> count($requirements) > 0 ? $requirements : 0
		);
		return $materials;
	}

	/**
	 * Get content
	 *
	 * @return string
	 */
	public static function get_content($args = []) {
		$course_id = Helper::get_course($args);
		ob_start();
		if( $course_id ) {
			include_once dtlms_get_template( 'course/requirements' );
		}
		return ob_get_clean;
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

new TutorCourseRequirements;
