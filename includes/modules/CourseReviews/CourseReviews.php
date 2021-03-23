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

        // Toggle settings
		// Toggles are grouped into array of tab name > toggles > toggle definition
        $this->settings_modal_toggles = array(
            'general'         => array(
                'toggles'   => array(
                    'main_content'  => esc_html__( 'Content', 'tutor-divi-modules' )
                )
            ),
            'advanced'        => array(
                'toggles'   => array(
                    'section_title'     => esc_html__( 'Section Title', 'tutor-divi-modules' ),
                    
                    'review_avg_total'  => esc_html__( 'Review Average Total', 'tutor-divi-modules' ),
                    'review_avg_text'   => esc_html__( 'Review Average Text', 'tutor-divi-modules' ),
                    'review_avg_count'  => esc_html__( 'Review Average Count', 'tutor-divi-modules' ),
                    'review_avg_star'   => esc_html__( 'Review Average Star', 'tutor-divi-modules' ),
                    'rating_bar'        => esc_html__( 'Right Rating Bar', 'tutor-divi-modules' ),
                    'review_list_avatar'       => esc_html__( 'Review List Avatar', 'tutor-divi-modules' ),
                    'review_list_author_name'  => esc_html__( 'Review List Author Name', 'tutor-divi-modules' ),
                    'review_list_time'       => esc_html__( 'Review List Time', 'tutor-divi-modules' ),
                    'review_list_comment'    => esc_html__( 'Review List Comment', 'tutor-divi-modules' ),
                    'review_list_star'    => esc_html__( 'Review List Star', 'tutor-divi-modules' ),
                ),
            )
        );

        //advanced fields settings
        $title_selector         = '%%order_class%% .tutor-single-course-segment .course-student-rating-title';
        $avg_total_selector     = '%%order_class%% .course-avg-rating-wrap .course-avg-rating';
        $avg_text_selector      = '%%order_class%% .course-avg-rating-wrap .tutor-course-avg-rating-total';
        $avg_count_selector     = '%%order_class%% .course-avg-rating-wrap .tutor-course-avg-rating-total > span';
        $this->advanced_fields = array(
            'fonts'     => array(
                'section_title' => array(
                    'css'   => array(
                        'main'          => 'selector',
                        'tab_slug'      => 'advanced',
                        'toggle_slug'   => 'section_title'
                    )
                ),
                'review_avg_total'    => array(
                    'css'   => array(
                        'main'          => 'selector',
                        'tab_slug'      => 'advanced',
                        'toggle_slug'   => 'review_avg_total',
                    ),
                ), 
                'review_avg_text'    => array(
                    'label' => 'Revie Avg Total',
                    'css'   => array(
                        'main'          => 'selector',
                        'tab_slug'      => 'advanced',
                        'toggle_slug'   => 'review_avg_text',
                    ),
                ), 
                'review_avg_count'    => array(
                   
                    'css'   => array(
                        'main'          => 'selector',
                        'tab_slug'      => 'advanced',
                        'toggle_slug'   => 'review_avg_count',
                    ),
                ), 
                'rating_bar'    => array(
                   
                    'css'   => array(
                        'main'          => 'selector',
                        'tab_slug'      => 'advanced',
                        'toggle_slug'   => 'rating_abr',
                    ),
                ), 
                'review_list_author_name'    => array(
                    'css'   => array(
                        'main'          => 'selector',
                        'tab_slug'      => 'advanced',
                        'toggle_slug'   => 'review_list_author_name',
                    ),
                ), 
                'review_list_time'    => array(
                    'css'   => array(
                        'main'          => 'selector',
                        'tab_slug'      => 'advanced',
                        'toggle_slug'   => 'review_list_time',
                    ),
                ), 
                'review_list_comment'    => array(
                    'css'   => array(
                        'main'          => 'selector',
                        'tab_slug'      => 'advanced',
                        'toggle_slug'   => 'review_list_comment',
                    ),
                ), 
            ),
            'background'    => array(
                'css'   => array(
                    'main'  => 'selector',
                    'important' => true
                ),
                'settings'  => array(
                    'tab_slug'      => 'advanced',
                    'toggle_slug'   => 'review_list_avatar'
                ),
                'use_background_video'  => false
            ),
            'borders'       => array(
                'review_list_avatar' => array(
					'css'             	=> array(
						'main' => array(
							'border_radii'  => '',
							'border_styles' => '',

						),
						'important'		=> true
					),
                    'tab_slug'      => 'advanced',
                    'toggle_slug'   => 'review_list_avatar'
                )
            )
        );
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
            //general tab main_content toggle
            'label'         => array(
                'label'         => esc_html__( 'Label', 'tutor-divi-modules' ),
                'type'          => 'text',
                'default'       => esc_html__( 'Stuent Feedback ', 'tutor-divi-modules' ),
                'toggle_slug'   => 'main_content'
            ),
            //advanced tab review_avg_star toggle
            'review_avg_star_color'   => array(
                'label'         => esc_html__( 'Star Color', 'tutor-divi-modules'),
                'type'          => 'color-alpha',
                'tab_slug'      => 'advanced',
                'toggle_slug'   => 'review_avg_star'
            ),
            'review_avg_star_size'   => array(
                'label'         => esc_html__( 'Star Size', 'tutor-divi-modules'),
                'type'          => 'range',
                'default'       => '14px',
                'default_unit'  => 'px',
                'range_settings'    => array(
                    'min'   => '1',
                    'max'   => '100',
                    'step'  => '1'
                ),
                'tab_slug'      => 'advanced',
                'toggle_slug'   => 'review_avg_star'
            ),
            //advanced tab rating_bar toggle
            'rating_bar_color'          => array(
                'label'         => esc_html__( 'Color', 'tutor-divi-modules'),
                'type'          => 'color-alpha',
                'tab_slug'      => 'advanced',
                'toggle_slug'   => 'rating_bar'
            ),            
            'rating_bar_fill_color'     => array(
                'label'         => esc_html__( 'Fill Color', 'tutor-divi-modules'),
                'type'          => 'color-alpha',
                'tab_slug'      => 'advanced',
                'toggle_slug'   => 'rating_bar'
            ),            
            'rating_bar_height'         => array(
                'label'         => esc_html__( 'Height', 'tutor-divi-modules'),
                'type'          => 'range',
                'default'       => '8px',
                'default_unit'  => 'px',
                'range_settings'    => array(
                    'min'   => '1',
                    'max'   => '100',
                    'step'  => '1'
                ),
                'tab_slug'      => 'advanced',
                'toggle_slug'   => 'rating_bar'
            ),            
            'rating_bar_star_color'     => array(
                'label'         => esc_html__( 'Star Color', 'tutor-divi-modules'),
                'type'          => 'color-alpha',
                'tab_slug'      => 'advanced',
                'toggle_slug'   => 'rating_bar'
            ),            
            'rating_bar_star_size'       => array(
                'label'         => esc_html__( 'Star Size', 'tutor-divi-modules'),
                'type'          => 'range',
                'default'       => '8px',
                'default_unit'  => 'px',
                'range_settings'    => array(
                    'min'   => '1',
                    'max'   => '100',
                    'step'  => '1'
                ),
                'tab_slug'      => 'advanced',
                'toggle_slug'   => 'rating_bar'
            ),     
            //advanced tab review_avg_star toggle
            'review_list_star_color'   => array(
                'label'         => esc_html__( 'Star Color', 'tutor-divi-modules'),
                'type'          => 'color-alpha',
                'tab_slug'      => 'advanced',
                'toggle_slug'   => 'review_list_star'
            ),
            'review_list_star_size'   => array(
                'label'         => esc_html__( 'Star Size', 'tutor-divi-modules'),
                'type'          => 'range',
                'default'       => '14px',
                'default_unit'  => 'px',
                'range_settings'    => array(
                    'min'   => '1',
                    'max'   => '100',
                    'step'  => '1'
                ),
                'tab_slug'      => 'advanced',
                'toggle_slug'   => 'review_list_star'
            ),       

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
