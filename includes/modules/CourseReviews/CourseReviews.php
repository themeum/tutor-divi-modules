<?php

/**
 * Tutor Course Reviews Module for Divi Builder
 *
 * @since 1.0.0
 * @author Themeum<www.themeum.com>
 */

use TutorLMS\Divi\Helper;

defined( 'ABSPATH' ) || exit;

class CourseReviews extends ET_Builder_Module {

	// module meta info
	public $slug       = 'tutor-course-reviews';
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
		$this->name      = esc_html__( 'Tutor Course Reviews' );
		$this->icon_path = plugin_dir_path( __FILE__ ) . 'icon.svg';

		// Toggle settings
		// Toggles are grouped into array of tab name > toggles > toggle definition
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Content', 'tutor-lms-divi-modules' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'review_section_title'      => esc_html__( 'Review Section Title', 'tutor-lms-divi-modules' ),
					'review_avg_total'          => array(
						'title' => esc_html__( 'Review Average Total', 'tutor-lms-divi-modules' ),
					),
					'review_avg_text'           => esc_html__( 'Review Average Text', 'tutor-lms-divi-modules' ),
					'review_avg_count'          => esc_html__( 'Review Average Count', 'tutor-lms-divi-modules' ),
					'review_avg_star'           => esc_html__( 'Review Average Star', 'tutor-lms-divi-modules' ),
					'rating_bar'                => array(
						'title' => esc_html__( 'Right Rating Bar', 'tutor-lms-divi-modules' ),
					),
					'review_list_avatar'        => esc_html__( 'Review List Avatar', 'tutor-lms-divi-modules' ),
					'review_list_author_name'   => esc_html__( 'Review List Author Name', 'tutor-lms-divi-modules' ),
					'review_list_time'          => esc_html__( 'Review List Time', 'tutor-lms-divi-modules' ),
					'review_list_comment'       => esc_html__( 'Review List Comment', 'tutor-lms-divi-modules' ),
					'review_list_star'          => esc_html__( 'Review List Star', 'tutor-lms-divi-modules' ),
				),
			),
		);

		// advanced fields settings
		$reviews_wrapper    = '%%order_class%% #tutor-course-details-tab-reviews';
		$this->advanced_fields = array(
			'fonts'      => array(
				'review_section_title'    => array(
					'css' => array(
						'main'        => "%%order_class%% .tutor-course-topics-header .text-primary",
						'tab_slug'    => 'advanced',
						'toggle_slug' => 'section_title',
					),
                    'hide_text_align'   => true,
				),
				'review_avg_total'        => array(
					'css'             => array(
						'main'        => "%%order_class%% .tutor-ratingsreviews-ratings .tutor-ratingsreviews-ratings-avg .text-medium-h1",
						'tab_slug'    => 'advanced',
						'toggle_slug' => 'review_avg_total',

					),
					'hide_text_align' => true,
				),
				'review_avg_star'        => array(
					'css'             => array(
						'main'        => "%%order_class%% .tutor-ratingsreviews-ratings-avg .tutor-ratings .tutor-rating-stars span",
						'tab_slug'    => 'advanced',
						'toggle_slug' => 'review_avg_star',

					),
					'hide_text_align' => true,
				),
				'review_avg_text'         => array(
					'label'           => 'Review Avg Total',
					'css'             => array(
						'main'        => "%%order_class%% .tutor-rating-text-part",
						'tab_slug'    => 'advanced',
						'toggle_slug' => 'review_avg_text',

					),
					'hide_text_align' => true,
				),
				'review_avg_count'        => array(

					'css'             => array(
						'main'        => "%%order_class%% .tutor-rating-count-part",
						'tab_slug'    => 'advanced',
						'toggle_slug' => 'review_avg_count',

					),
					'hide_text_align' => true,
				),
				'rating_bar'              => array(
					'css' => array(
						'main'        => "%%order_class%% .rating-num.color-text-subsued",
						'tab_slug'    => 'advanced',
						'toggle_slug' => 'rating_bar',
					),
				),
				'review_list_author_name' => array(
					'css'             => array(
						'main'        => "%%order_class%% .tutor-reviewer-name",
						'tab_slug'    => 'advanced',
						'toggle_slug' => 'review_list_author_name',
					),
					'hide_text_align' => true,
				),
				'review_list_time'        => array(
					'css'             => array(
						'main'        => "%%order_class%% .tutor-review-time",
						'tab_slug'    => 'advanced',
						'toggle_slug' => 'review_list_time',
					),
					'hide_text_align' => true,
				),
				'review_list_comment'     => array(
					'css' => array(
						'main'        => "%%order_class%% .tutor-review-comment",
						'tab_slug'    => 'advanced',
						'toggle_slug' => 'review_list_comment',
					),
				),
				'review_list_star'        => array(
					'css'             => array(
						'main'        => "%%order_class%% .review-list .tutor-rating-stars span ",
						'tab_slug'    => 'advanced',
						'toggle_slug' => 'review_list_comment',
					),
					'hide_text_align' => true,
				),
			),
			'background' => array(
				'css'                  => array(
					'main'      => '%%order_class%% .tutor-ratingsreviews',
					'important' => true,
				),
				'use_background_video' => false,
			),
			'borders'    => array(
				'review_list_avatar' => array(
					'css'         => array(
						'main'      => array(
							'border_radii'  => '%%order_class%% .review-list img',
							'border_styles' => '%%order_class%% .review-list img',

						),
						'important' => true,
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'review_list_avatar',
				),
				'section_content'    => array(
					'css'         => array(
						'main'      => array(
							'border_radii'  => '%%order_class%% .tutor-course-reviews-wrap',
							'border_styles' => '%%order_class%% .tutor-course-reviews-wrap',

						),
						'important' => true,
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'section_content',
				),
			),
			'box_shadow' => array(
				'section_background' => array(
					'css'         => array(
						'main' => '%%order_class%% .tutor-ratingsreviews',
					),
				),

			),
			'button'     => false,
			'text'       => false,
			'max_width'  => false,
			'filters'    => false,
			'animation'  => false,
			'transform'  => false,
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
		return array(
			'course'                  => Helper::get_field(
				array(
					'default'          => Helper::get_course_default(),
					'computed_affects' => array(
						'__reviews',
					),
				)
			),
			'__reviews'               => array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'CourseReviews',
					'get_content',
				),
				'computed_depends_on' => array(
					'course',
					'course_reviews_label',
				),
				'computed_minimum'    => array(
					'course',
					'course_reviews_label',
				),
			),
			// general tab main_content toggle.
			'course_reviews_label'                     => array(
				'label'       => esc_html__( 'Label', 'tutor-lms-divi-modules' ),
				'type'        => 'text',
				'default'     => esc_html__( 'Student Ratings & Reviews ', 'tutor-lms-divi-modules' ),
				'toggle_slug' => 'main_content',
			),
			// advanced tab section_content toggle.
			'review_right_star'                        => array(
				'label'       => esc_html__( 'Right Star Color', 'tutor-lms-divi-modules' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'rating_bar',
			),
			'review_right_bar_height'                  => array(
				'label'          => esc_html__( 'Bar Height', 'tutor-lms-divi-modules' ),
				'type'           => 'range',
				'default'        => '8',
				'default_unit'   => 'px',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'rating_bar',
			),
			'review_right_bar_color'                   => array(
				'label'       => esc_html__( 'Bar Color', 'tutor-lms-divi-modules' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'rating_bar',
			),
			'review_right_bar_fill_color'              => array(
				'label'       => esc_html__( 'Bar Fill Color', 'tutor-lms-divi-modules' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'rating_bar',
			),

		);
	}

	/**
	 * get require props
	 *
	 * @since 1.0.0
	 * @return array
	 */
	// public static function get_props( $args = array() ) {
	// 	$course_id      = $args['course'];
	// 	$reviews        = tutils()->get_course_reviews( $course_id );
	// 	$rating_summary = tutils()->get_course_rating( $course_id );
	// 	$count_by_value = $rating_summary->count_by_value;
	// 	foreach ( $reviews as $review ) {
	// 		if ( $review ) {
	// 			// $review->avatar_url = get_avatar_url( $review->user_id , array('force_default' => true));
	// 			$review->avatar_url = tutor_utils()->get_tutor_avatar( $review->user_id, array( 'force_default' => true ) );
	// 		}
	// 	}
	// 	return array(
	// 		'rating_summary' => $rating_summary,
	// 		'reviews'        => $reviews,
	// 		'count_by_value' => $count_by_value,
	// 	);
	// }

	/**
	 * Get the tutor course content
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public static function get_content( $args = array() ) {
		$course_id = Helper::get_course( $args );
		ob_start();
		if ( $course_id ) {
			include dtlms_get_template( 'course/reviews' );
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
		if ( '' !== $this->props['review_right_star'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-ratingsreviews-ratings-all .tutor-rating-stars span',
					'declaration' => sprintf(
						'color: %1$s;',
						$this->props['review_right_star']
					),
				)
			);
		}
		if ( '' !== $this->props['review_right_bar_height'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-ratingsreviews-ratings-all .progress-bar',
					'declaration' => sprintf(
						'height: %1$s;',
						$this->props['review_right_bar_height']
					),
				)
			);
		}
		if ( '' !== $this->props['review_right_bar_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-ratingsreviews-ratings-all .progress-bar',
					'declaration' => sprintf(
						'background-color: %1$s;',
						$this->props['review_right_bar_color']
					),
				)
			);
		}
		if ( '' !== $this->props['review_right_bar_fill_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-ratingsreviews-ratings-all .progress-value',
					'declaration' => sprintf(
						'background-color: %1$s;',
						$this->props['review_right_bar_fill_color']
					),
				)
			);
		}
		// set style end.

		$output = self::get_content( $this->props );
		if ( '' === $output ) {
			return '';
		}

		return $this->_render_module_wrapper( $output, $render_slug );
	}
}
new CourseReviews();
