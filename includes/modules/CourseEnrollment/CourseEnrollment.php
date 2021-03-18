<?php

/**
* Tutor Course Enrollment Module for Divi Builder
* @since 1.0.0
*/
use TutorLMS\Divi\Helper;

class CourseEnrollment extends ET_Builder_Module {

	// Module slug (also used as shortcode tag)
	public $slug       = 'tutor_course_enrollment';
	public $vb_support = 'on';

	// Module Credits (Appears at the bottom of the module settings modal)
	protected $module_credits = array(
		'author'     => 'Themeum',
		'author_uri' => 'https://themeum.com',
	);

    public function init() {
		// Module name & icon
		$this->name			= esc_html__('Tutor Course Enrollment', 'tutor-divi-modules');
		$this->icon_path	= plugin_dir_path( __FILE__ ) . 'icon.svg';

		// Toggle settings
		// Toggles are grouped into array of tab name > toggles > toggle definition 
        $this->settings_modal_toggles = array();

        //advanced fiedls settings
        $this->advanced_fields = array(

        );
    }

    public function get_fields() {
        return array(
            'text'  => array(
                'label'             => esc_html__( 'Label', 'tutor-divi-modules' ),
                'type'              => 'text',
                'toggle_slug'       => 'main_content'
            )
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
    public function render ( $attrs, $content = null, $render_slug ) {
        $output = "hello";
        $this->_render_module_wrapper( $output, $render_slug );
    }

}
new CourseEnrollment;

