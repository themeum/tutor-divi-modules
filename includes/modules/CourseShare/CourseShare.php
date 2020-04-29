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

		$selector = '%%order_class%% .tutor-single-course-meta .tutor-social-share';
        $icon_selector = $selector.' .tutor-social-share-wrap button';
		$this->advanced_fields = array(
			'fonts'          => array(
				'label' => array(
					'label'        => esc_html__('Label', 'tutor-divi-modules'),
					'css'          => array(
						'main'	=> $selector.' span',
					),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'label',
				),
				'icons' => array(
					'label'        => esc_html__('Icons', 'tutor-divi-modules'),
					'css'          => array(
						'main' 			=> $icon_selector,
						'hover' 		=> $icon_selector.':hover',
					),
					'options' => array(
						'background_layout' => array(
							'default_on_front' => 'light',
							'hover' => 'tabs',
						),
					),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'icons',
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
						'__level',
					),
				)
			),
			'__share'		=> array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'TutorCourseShare',
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

		$output = self::get_content($this->props);

		// Render empty string if no output is generated to avoid unwanted vertical space.
		if ('' === $output) {
			return '';
		}

		return $this->_render_module_wrapper($output, $render_slug);
	}
}

new TutorCourseShare;
