<?php
/**
 * Tutor Course Reviews Module for Divi Builder
 * @since 1.0.0
 */

use TutorLMS\Divi\Helper;

class CourseReviews extends ET_Builder_Module {

    //module meta info
    public $slug        = 'tutor-course-reviews';
    public $vb_support  = 'on';

    // Module Credits (Appears at the bottom of the module settings modal)
	protected $module_credits = array(
		'author'     => 'Themeum',
		'author_uri' => 'https://themeum.com',
	);

    public function init() {
        //Module name & icon
        $this->name         = esc_html__( 'Tutor Course Reviews' );
        $this->icon_path	= plugin_dir_path( __FILE__ ) . 'icon.svg';
    }
    //Module fields
    public function get_fields() {
        return array(
            
            'label'         => array(
                'label'         => esc_html__( 'Label', 'tutor-divi-modules' ),
                'type'          => 'text',
                'default'       => esc_html__( 'Stuent Rating & Reviews ', 'tutor-divi-modules' ),
                'toggle_slug'   => 'main_content'
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
    public function render( $attrs, $content = null, $render_slug ) {
        echo "<h2>Course Reviews</h2>";
    }
}
new CourseReviews;
