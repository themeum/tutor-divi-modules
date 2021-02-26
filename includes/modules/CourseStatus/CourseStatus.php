<?php

/**
 * Tutor Course Author Module for Divi Builder
 * @since 1.0.0
 */

use TutorLMS\Divi\Helper;

class CourseStatus extends ET_Builder_Module {

    // Module slug (also used as shortcode tag)
    public $slug        = 'tutor_course_status';
    public $vb_support  = 'on';

	// Module Credits (Appears at the bottom of the module settings modal)
	protected $module_credits = array(
		'author'     => 'Themeum',
		'author_uri' => 'https://themeum.com',
	);

    public function init() {
        $this->name         = esc_html__( 'Tutor Course Status', 'tutor-divi-modules' ); 
        $this->icon_path	= plugin_dir_path( __FILE__ ) . 'icon.svg';
    }

    public function get_fields() {
		return array(
			'tutor_course_list_heading_new'     => array(
				'label'           => esc_html__( 'Heading', 'tutor-divi-modules' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input your desired heading here.', 'tutor-divi-modules' ),
				'toggle_slug'     => 'main_content',
			),
            'content'     => array(
				'label'           => esc_html__( 'Content', 'tutor-divi-modules' ),
				'type'            => 'tiny_mce',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Content entered here will appear below the heading text.', 'tutor-divi-modules' ),
				'toggle_slug'     => 'main_content',
			),

		);
    }

    public function render( $attr, $content = null, $render_slug) {
        return " course status ";
    }

}
new CourseStatus;