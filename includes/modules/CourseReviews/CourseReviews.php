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
            'course'       	=> Helper::get_field(
				array(
					'default'          => Helper::get_course_default(),
					'computed_affects' => array(
						'__reviews',
					),
				)
			),
            '__reviews'     => array(
                'type'                  => 'computed',
                'computed_callback'     => array(
                    'CourseReviews',
                    'get_props'
                ),
                'computed_depends_on'   => array(
                    'course'
                ),
                'computed_minimum'      => array(
                    'course'
                )
            ),
            'label'         => array(
                'label'         => esc_html__( 'Label', 'tutor-divi-modules' ),
                'type'          => 'text',
                'default'       => esc_html__( 'Stuent Rating & Reviews ', 'tutor-divi-modules' ),
                'toggle_slug'   => 'main_content'
            )
        );
    }

    /**
     * get props
     * @return arr
     */
    public static function get_props( $args = [] ) {
        $course_id      = $args['course'];
        $reviews        = tutils()->get_course_reviews( $course_id );
        $rating_summary = tutils()->get_course_rating( $course_id );

        foreach( $reviews as $review) {
            if($review) {
                $review->avatar_url = get_avatar_url( $review->user_id );
            }
        }
        return array(
            'rating_summary'    => $rating_summary,
            'reviews'           => $reviews
        );
    }

    public static function get_content( $args = [] ) {
        $course_id = Helper::get_course($args);
        ob_start();
        if ($course_id) {
			include_once dtlms_get_template('course/reviews');
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
    public function render( $attrs, $content = null, $render_slug ) {

        $output = self::get_content( $this->props );
        if( '' === $output ) {
            return '';
        }

        return $this->_render_module_wrapper( $output, $render_slug );
    }
}
new CourseReviews;
