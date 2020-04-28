<?php

/**
 * Tutor Course Author Module for Divi Builder
 * @since 1.0.0
 */

use TutorLMS\Divi\Helper;

class TutorCourseAuthor extends ET_Builder_Module {
	// Module slug (also used as shortcode tag)
	public $slug       = 'tutor_course_author';
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
		$this->name			= esc_html__('Tutor Course Author', 'tutor-divi-modules');
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
					'author_image' => array(
						'title'    => esc_html__('Author Image', 'tutor-divi-modules'),
					),
					'author_label_text' => array(
						'title'    => esc_html__('Author Label', 'tutor-divi-modules'),
					),
					'author_name_text' => array(
						'title'    => esc_html__('Author Name', 'tutor-divi-modules'),
					),
				),
			),
		);
		
		$author_selector = '%%order_class%% .tutor-single-course-author-meta .tutor-single-course-author-name';
		$this->advanced_fields = array(
			'fonts'          => array(
				'author_label_text' => array(
					'label'        => esc_html__('Label', 'tutor-divi-modules'),
					'css'          => array(
						'main' => $author_selector.' span',
					),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'author_label_text',
				),
				'author_name_text' => array(
					'label'        => esc_html__('Name', 'tutor-divi-modules'),
					'css'          => array(
						'main' => $author_selector.' a',
					),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'author_name_text',
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
						'__author',
					),
				)
			),
			'__author'		=> array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'TutorCourseAuthor',
					'get_the_author',
				),
				'computed_depends_on' => array(
					'course'
				),
				'computed_minimum'    => array(
					'course',
				),
			),
			'image_height' => array(
				'label'           => esc_html__( 'Height', 'tutor-divi-modules' ),
				'type'            => 'range',
				'range_settings'  => array(
					'min'	=> 10,
					'max'	=> 100,
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'author_image',
			),
			'image_width' => array(
				'label'           => esc_html__( 'Width', 'tutor-divi-modules' ),
				'type'            => 'range',
				'range_settings'  => array(
					'min'	=> 10,
					'max'	=> 100,
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'author_image',
			),
		);

		return $fields;
	}

	/**
	 * Get the tutor course author
	 *
	 * @return string
	 */
	public static function get_the_author($args = []) {
		$course = Helper::get_course($args);
		ob_start();
		if ($course) {
			include_once dtlms_get_template('course/author');
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

		// Process image size value into style
		$img_selector = '%%order_class%% .tutor-single-course-avatar a span';
		if ( '' !== $this->props['image_height'] ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => $img_selector,
				'declaration' => sprintf(
					'height: %1$s;',
					esc_html( $this->props['image_height'] )
				),
			) );

		}
		if ( '' !== $this->props['image_width'] ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => $img_selector,
				'declaration' => sprintf(
					'width: %1$s;',
					esc_html( $this->props['image_width'] )
				),
			) );
		}

		$output = self::get_the_author($this->props);

		// Render empty string if no output is generated to avoid unwanted vertical space.
		if ('' === $output) {
			return '';
		}

		return $this->_render_module_wrapper($output, $render_slug);
	}
}

new TutorCourseAuthor;
