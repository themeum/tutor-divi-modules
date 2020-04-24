<?php

/**
 * Tutor Course Title Module for Divi Builder
 * @since 1.0.0
 */

use TutorLMS\Divi\Helper;

class TutorCourseTitle extends ET_Builder_Module {
	/**
	 * Initialize.
	 */
	public function init() {
		$this->name       = esc_html__('Tutor Course Title', 'tutor-divi-modules');
		$this->slug       = 'tutor_course_title';
		$this->vb_support = 'on';

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
					'text_shadow' => '%%order_class%% .et_pb_wc_title',
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

		$this->custom_css_fields = array(
			'title_text' => array(
				'label'    => esc_html__('Title Text', 'tutor-divi-modules'),
				'selector' => '%%order_class%% h1, %%order_class%% h2, %%order_class%% h3, %%order_class%% h4, %%order_class%% h5, %%order_class%% h6',
			),
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_fields() {
		$fields = array(
			'course'       	=> Helper::get_field(
				array(
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
					'course',
					'course_filter'
				),
				'computed_minimum'    => array(
					'course',
				),
			),
		);

		return $fields;
	}

	/**
	 * Gets the Title.
	 *
	 * @param array $args Additional arguments.
	 *
	 * @return string
	 */
	public static function get_title($args = array()) {
		$title = __('Course Title', 'tutor-divi-modules');
		//print_r($args);
		$course = Helper::get_course($args);
		if ($course) {
			$title = get_the_title();
			wp_reset_postdata();
		}
		return $title;
	}

	/**
	 * Gets the tutor course Title markup.
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
	 * Renders the module output.
	 *
	 * @param  array  $attrs       List of attributes.
	 * @param  string $content     Content being processed.
	 * @param  string $render_slug Slug of module that is used for rendering output.
	 *
	 * @return string
	 */
	public function render($attrs, $content = null, $render_slug) {
		Helper::process_background_layout_data($render_slug, $this);

		$this->add_classname($this->get_text_orientation_classname());

		$output = self::get_title_markup();

		// Render empty string if no output is generated to avoid unwanted vertical space.
		if ('' === $output) {
			return '';
		}

		return $this->_render_module_wrapper($output, $render_slug);
	}
}

new TutorCourseTitle();
