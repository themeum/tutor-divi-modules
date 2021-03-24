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
        $title_selector         = '%%order_class%% .tutor-single-course-segment .course-student-rating-title h4';
        $avg_total_selector     = '%%order_class%% .course-avg-rating-wrap .course-avg-rating';
        $avg_text_selector      = '%%order_class%% .course-avg-rating-wrap .tutor-course-avg-rating-total';
        $avg_count_selector     = '%%order_class%% .course-avg-rating-wrap .tutor-course-avg-rating-total > span';
        $this->advanced_fields = array(
            'fonts'     => array(
                'section_title' => array(
                    'css'   => array(
                        'main'          => $title_selector,
                        'tab_slug'      => 'advanced',
                        'toggle_slug'   => 'section_title'
                    )
                ),
                'review_avg_total'    => array(
                    'css'   => array(
                        'main'          => $avg_total_selector,
                        'tab_slug'      => 'advanced',
                        'toggle_slug'   => 'review_avg_total',
                        
                    ),
                    'hide_text_align'   => true
                ), 
                'review_avg_text'    => array(
                    'label' => 'Revie Avg Total',
                    'css'   => array(
                        'main'          => $avg_text_selector,
                        'tab_slug'      => 'advanced',
                        'toggle_slug'   => 'review_avg_text',
                        
                    ),
                    'hide_text_align'   => true
                ), 
                'review_avg_count'    => array(
                   
                    'css'   => array(
                        'main'          => $avg_count_selector,
                        'tab_slug'      => 'advanced',
                        'toggle_slug'   => 'review_avg_count',
                        
                    ),
                    'hide_text_align'   => true
                ), 
                'rating_bar'    => array(
                    'css'   => array(
                        'main'          => '%%order_class%% .course-rating-meter .rating-text-col, %%order_class%% .course-ratings-count-meter-wrap .rating-meter-col',
                        'tab_slug'      => 'advanced',
                        'toggle_slug'   => 'rating_abr',
                    ),
                ), 
                'review_list_author_name'    => array(
                    'css'   => array(
                        'main'          => '%%order_class%% .tutor-review-user-info .review-time-name p a',
                        'tab_slug'      => 'advanced',
                        'toggle_slug'   => 'review_list_author_name',
                    ),
                    'hide_text_align'   => true
                ), 
                'review_list_time'    => array(
                    'css'   => array(
                        'main'          => '%%order_class%% .tutor-review-user-info .review-time-name .review-meta',
                        'tab_slug'      => 'advanced',
                        'toggle_slug'   => 'review_list_time',
                    ),
                    'hide_text_align'   => true
                ), 
                'review_list_comment'    => array(
                    'css'   => array(
                        'main'          => '%%order_class%% .review-content.review-right p',
                        'tab_slug'      => 'advanced',
                        'toggle_slug'   => 'review_list_comment',
                    ),
                ), 
                'review_list_star'    => array(
                    'css'   => array(
                        'main'          => '%%order_class%% .individual-review-rating-wrap .tutor-star-rating-group i',
                        'tab_slug'      => 'advanced',
                        'toggle_slug'   => 'review_list_comment',
                    ),
                    'hide_text_align'   => true
                ), 
            ),
            'background'    => array(
                'css'   => array(
                    'main'  => '%%order_class%% .tutor-review-individual-item .review-avatar a span',
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
							'border_radii'  => '%%order_class%% .review-avatar a img, %%order_class%% .review-avatar a span',
							'border_styles' => '%%order_class%% .review-avatar a img, %%order_class%% .review-avatar a span',

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
            //advanced tab review_list_avatar toggle
            'review_list_avatar_size'   => array(
                'label'         => esc_html__( 'Star Size', 'tutor-divi-modules'),
                'type'          => 'range',
                'default'       => '48px',
                'default_unit'  => 'px',
                'range_settings'    => array(
                    'min'   => '1',
                    'max'   => '200',
                    'step'  => '1'
                ),
                'tab_slug'      => 'advanced',
                'toggle_slug'   => 'review_list_avatar'
            ),  
            //advanced tab review_list toggle
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
                //$review->avatar_url = get_avatar_url( $review->user_id , array('force_default' => true));
                $review->avatar_url = tutils()->get_tutor_avatar( $review->user_id , array('force_default' => true));
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
        //selectors
        $avg_star_selector         = '%%order_class%% .tutor-col-auto .tutor-star-rating-group i';
        $rating_bar_selector       = '%%order_class%% .course-rating-meter .rating-meter-bar';
        $rating_bar_fill_selector  = '%%order_class%% .course-rating-meter .rating-meter-bar .rating-meter-fill-bar';
        $rating_star_selector      = '%%order_class%% .course-rating-meter .rating-meter-col i';

        $review_list_avatar_selector   = '%%order_class%% .review-avatar a span, %%order_class%% .review-avatar a img';
        $review_list_star_selector     = '%%order_class%% .individual-review-rating-wrap .tutor-star-rating-group i';

        //props
        $review_avg_star_color     = $this->props['review_avg_star_color'];
        $review_avg_star_size      = $this->props['review_avg_star_size'];

        $rating_bar_color          = $this->props['rating_bar_color'];
        $rating_bar_fill_color     = $this->props['rating_bar_fill_color'];
        $rating_bar_height         = $this->props['rating_bar_height'];
        $rating_bar_star_color     = $this->props['rating_bar_star_color'];
        $rating_bar_star_size      = $this->props['rating_bar_star_size'];

        $review_list_avatar_size   = $this->props['review_list_avatar_size'];
        $review_list_star_color    = $this->props['review_list_star_color'];
        $review_list_star_size     = $this->props['review_list_star_size'];

        //set style
        if( '' !== $review_avg_star_color ) {
            ET_Builder_Element::set_style(
                $render_slug,
                array(
                    'selector'      => $avg_star_selector,
                    'declaration'   => sprintf(
                        'color: %1$s;',
                        $review_avg_star_color
                    )
                )
            );
        }

        if( '' !== $review_avg_star_size ) {
            ET_Builder_Element::set_style(
                $render_slug,
                array(
                    'selector'      => $avg_star_selector,
                    'declaration'   => sprintf(
                        'font-size: %1$s;',
                        $review_avg_star_size
                    )
                )
            );
        }

        //rating bar
        if( '' !== $rating_bar_color ) {
            ET_Builder_Element::set_style(
                $render_slug,
                array(
                    'selector'      => $rating_bar_selector,
                    'declaration'   => sprintf(
                        'background-color: %1$s !important;',
                        $rating_bar_color
                    )
                )
            );  
        }
        
        if( '' !== $rating_bar_fill_color ) {
            ET_Builder_Element::set_style(
                $render_slug,
                array(
                    'selector'      => $rating_bar_fill_selector,
                    'declaration'   => sprintf(
                        'background-color: %1$s !important;',
                        $rating_bar_fill_color
                    )
                )
            );              
        }

        if( '' !== $rating_bar_height ) {
            ET_Builder_Element::set_style(
                $render_slug,
                array(
                    'selector'      => $rating_bar_selector." , ".$rating_bar_fill_selector,
                    'declaration'   => sprintf(
                        'height: %1$s;',
                        $rating_bar_height
                    )
                )
            );              
        }

        if( '' !== $rating_bar_star_color ) {
            ET_Builder_Element::set_style(
                $render_slug,
                array(
                    'selector'      => $rating_star_selector,
                    'declaration'   => sprintf(
                        'color: %1$s;',
                        $rating_bar_star_color
                    )
                )
            );   
        }

        if( '' !== $rating_bar_star_size ) {
            ET_Builder_Element::set_style(
                $render_slug,
                array(
                    'selector'      => $rating_star_selector,
                    'declaration'   => sprintf(
                        'font-size: %1$s;',
                        $rating_bar_star_size
                    )
                )
            );             
        }

        if('' !== $review_list_avatar_size) {
            ET_Builder_Element::set_style(
                $render_slug,
                array(
                    'selector'      => $review_list_avatar_selector,
                    'declaration'   => sprintf(
                        'width: %1$s;',
                        $review_list_avatar_size
                    )
                )
            );
            ET_Builder_Element::set_style(
                $render_slug,
                array(
                    'selector'      => $review_list_avatar_selector,
                    'declaration'   => sprintf(
                        'height: %1$s;',
                        $review_list_avatar_size
                    )
                )
            );
        }

        if('' !== $review_list_star_color) {
            ET_Builder_Element::set_style(
                $render_slug,
                array(
                    'selector'      => $review_list_star_selector,
                    'declaration'   => sprintf(
                        'color: %1$s;',
                        $review_list_star_color
                    )
                )
            );
        }

        if('' !== $review_list_star_size) {
            ET_Builder_Element::set_style(
                $render_slug,
                array(
                    'selector'      => $review_list_star_selector,
                    'declaration'   => sprintf(
                        'font-size: %1$s;',
                        $review_list_star_size
                    )
                )
            );             
        }
        //set style end

        $output = self::get_content( $this->props );
        if( '' === $output ) {
            return '';
        }

        return $this->_render_module_wrapper( $output, $render_slug );
    }
}
new CourseReviews;