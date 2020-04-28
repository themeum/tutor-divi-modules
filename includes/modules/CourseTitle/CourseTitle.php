<?php

/**
 * Tutor Course Title Module for Divi Builder
 * @since 1.0.0
 */

use TutorLMS\Divi\Helper;

class TutorCourseTitle extends ET_Builder_Module {
	// Module slug (also used as shortcode tag)
	public $slug       = 'tutor_course_title';

	// Visual Builder support (off|partial|on)
	// - on:      you need to provide JS component for visual builder to render your content
	//            dynamically in visual builder
	// - partial: you don't need to provide JS component for visual builder to render your content
	//            divi will generate blank placeholder for your module instead
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
		$this->name			= esc_html__('Tutor Course Title', 'tutor-divi-modules');
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
					'header' => array(
						'title'    => esc_html__('Title Text', 'tutor-divi-modules'),
						'priority' => 49,
					),
					'width'  => array(
						'title'    => esc_html__('Sizing', 'tutor-divi-modules'),
						'priority' => 65,
					),
				),
			),
		);

		$this->advanced_fields = array(
			'fonts'          => array(
				'header' => array(
					'label'        => esc_html__('Title', 'tutor-divi-modules'),
					'css'          => array(
						'main' => '%%order_class%% h1, %%order_class%% h2, %%order_class%% h3, %%order_class%% h4, %%order_class%% h5, %%order_class%% h6',
					),
					'header_level' => array(
						'default' => 'h1',
					),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'header',
				),
			),
			'background'     => array(
				'settings' => array(
					'color' => 'alpha',
				),
			),
			'margin_padding' => array(
				'css' => array(
					'important' => 'all',
				),
			),
			'text'           => array(
				'use_background_layout' => true,
				'use_text_orientation'  => false,
				'css'                   => array(
					'text_shadow' => '%%order_class%% .tutor-course-title',
				),
				'options'               => array(
					'background_layout' => array(
						'default_on_front' => 'light',
						'hover'            => 'tabs',
					),
				),
				'toggle_slug'           => 'header',
			),
			'text_shadow'    => array(
				// Don't add text-shadow fields since they already are via font-options.
				'default' => false,
			),
			'button'         => false,
		);
	}

	/**
	 * Module's specific fields
	 *
	 *
	 * The following modules are automatically added regardless being defined or not:
	 *   Tabs     | Toggles          | Fields
	 *   --------- ------------------ -------------
	 *   Content  | Admin Label      | Admin Label
	 *   Advanced | CSS ID & Classes | CSS ID
	 *   Advanced | CSS ID & Classes | CSS Class
	 *   Advanced | Custom CSS       | Before
	 *   Advanced | Custom CSS       | Main Element
	 *   Advanced | Custom CSS       | After
	 *   Advanced | Visibility       | Disable On
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
						'__title',
					),
				)
			),
			'__title'      	=> array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'TutorCourseTitle',
					'get_title',
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
	 * Get the Title.
	 *
	 * @param array $args Additional arguments.
	 *
	 * @return string
	 */
	public static function get_title($args = array()) {
		$title = __('Course Title', 'tutor-divi-modules');
		$course = Helper::get_course($args);
		if ($course) {
			$title = get_the_title();
		}
		return $title;
	}

	/**
	 * Get the tutor course Title markup.
	 *
	 * @return string
	 */
	protected function get_title_markup() {
		$header_level  = $this->props['header_level'];
		$course_title = self::get_title($this->props);

		return sprintf(
			'<%1$s class="tutor-course-title">%2$s</%1$s>',
			et_pb_process_header_level($header_level, 'h1'),
			et_core_esc_previously($course_title)
		);
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

		$output = self::get_title_markup();

		// Render empty string if no output is generated to avoid unwanted vertical space.
		if ('' === $output) {
			return '';
		}

		return $this->_render_module_wrapper($output, $render_slug);
	}
}

new TutorCourseTitle;
