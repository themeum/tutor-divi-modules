<?php
/**
 * Tutor Course Curriculum Module for Divi Builder
 *
 * @since 1.0.0
 * @author Themeum<www.themeum.com>
 */

use TutorLMS\Divi\Helper;

defined( 'ABSPATH' ) || exit;

class CourseContent extends ET_Builder_Module {

	public $slug       = 'tutor_course_content';
	public $vb_support = 'on';
	protected static $curriculum_title;

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
		$this->name      = esc_html__( 'Tutor Course Content', 'tutor-lms-divi-modules' );
		$this->icon_path = plugin_dir_path( __FILE__ ) . 'icon.svg';
		// Toggle settings
		// Toggles are grouped into array of tab name > toggles > toggle definition
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content'      => esc_html__( 'Course Benefits', 'tutor-lms-divi-modules' ),
					'course_curriculum' => array(
						'title' => esc_html__( 'Course Curriculum', 'tutor-lms-divi-modules' ),
					),
					'course_reviews'    => array(
						'title' => esc_html__( 'Course Reviews', 'tutor-lms-divi-modules' ),
					),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'heading'                   => array(
						'title' => esc_html__( 'About Course', 'tutor-lms-divi-modules' ),
					),
					'short_text'                => array(
						'title' => esc_html__( 'About Course', 'tutor-lms-divi-modules' ),
					),
					// course benefits advanced toggles.
					'course_benefits_title'     => array(
						'title' => esc_html__( 'Course Benefits Title', 'tutor-lms-divi-modules' ),
					),
					'course_benefits_list'      => array(
						'title' => esc_html__( 'Course Benefits List', 'tutor-lms-divi-modules' ),
					),
					'course_benefits_icon'      => array(
						'title' => esc_html__( 'Course Benefits Icon', 'tutor-lms-divi-modules' ),
					),
					'course_benefits_text'      => array(
						'title' => esc_html__( 'Course Benefits Text', 'tutor-lms-divi-modules' ),
					),
					// course benefits advanced toggles end.
					'header'                    => array(
						'title' => esc_html__( 'Curriculum Header', 'tutor-lms-divi-modules' ),
					),
					'topics'                    => array(
						'title' => esc_html__( 'Topics', 'tutor-lms-divi-modules' ),
					),
					'lesson'                    => array(
						'title' => esc_html__( 'Lesson', 'tutor-lms-divi-modules' ),
					),
					'lesson_info'               => array(
						'title' => esc_html__( 'Lesson Info', 'tutor-lms-divi-modules' ),
					),
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

		// advanced fields config
		$wrapper                 = '%%order_class%% .dtlms-course-curriculum';
		$topic_icon_selector     = $wrapper . ' .tutor-accordion-item-header::after';
		$topic_wrapper_selector  = '%%order_class%% .tutor-divi-course-topic';
		$lesson_title_selector   = '%%order_class%% .tutor-course-content-list-item-title a';
		$lesson_wrapper_selector = '%%order_class%% .tutor-course-content-list-item';

		// Reviews selectors.
		$title_selector     = '%%order_class%% .tutor-single-course-segment .course-student-rating-title h4';
		$avg_total_selector = '%%order_class%% .course-avg-rating-wrap .course-avg-rating';
		$avg_text_selector  = '%%order_class%% .course-avg-rating-wrap .tutor-course-avg-rating-total';
		$avg_count_selector = '%%order_class%% .course-avg-rating-wrap .tutor-course-avg-rating-total > span';
		$reviews_wrapper    = '%%order_class%% #tutor-course-details-tab-reviews ';

		/**
		 * Course benefits controls
		 */

		// course benefits controls end.
		$heading_selector      = '%%order_class%% .tutor-showmore-content .text-medium-h6';
		$paragraph_selector    = '%%order_class%% .showmore-text';
		$short_text            = '%%order_class%% .showmore-short-text';
		$this->advanced_fields = array(
			'fonts'          => array(
				'heading'                 => array(
					'css'         => array(
						'main' => $heading_selector,
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'heading',
				),
				'about_text'              => array(
					'css'         => array(
						'main' => $paragraph_selector,
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'about_text',
				),
				'short_text'              => array(
					'css'         => array(
						'main' => $short_text,
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'short_text',
				),
				// course benefit controls.
				'course_benefits_title'   => array(
					'css' => array(
						'main'        => '%%order_class%% .tutor-course-benefits-wrap .tutor-segment-title',
						'tab_slug'    => 'advanced',
						'toggle_slug' => 'course_benefits_title',
					),
				),
				'course_benefits_text'    => array(
					'css'             => array(
						'main'        => '%%order_class%% ul.tutor-course-benefits-items .list-item',
						'tab_slug'    => 'advanced',
						'toggle_slug' => 'course_benefits_text',
					),
					'hide_text_align' => true,
				),
				// course instructor font toggle.
				'course_instructor_title' => array(
					'css'             => array(
						'main' => '%%order_class%% .dtlms-course-instructor-title',
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'course_instructor_title',
					'hide_text_align' => true,
				),
				'instructor_name'         => array(
					'css'             => array(
						'main' => '%%order_class%% .instructor-name-designation-wrapper h3 a',
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'instructor_name',
					'hide_text_align' => true,
				),
				'instructor_designation'  => array(
					'css'             => array(
						'main' => '%%order_class%% .tutor-ins-designation',
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'instructor_designation',
					'hide_text_align' => true,
				),
				'instructor_bio'          => array(
					'css'         => array(
						'main' => '%%order_class%% .instructor-bio',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'instructor_bio',
				),
				// icon
				'bottom_info_label'       => array(
					'css'             => array(
						'main' => '%%order_class%% .courses i, %%order_class%% .students i',
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'bottom_info_label',
					'hide_text_align' => true,
				),
				// text
				'bottom_info_value'       => array(
					'css'             => array(
						'main' => '%%order_class%% .courses .tutor-color-text-subsued, %%order_class%% .students .tutor-color-text-subsued, %%order_class%% .rating-total-meta',
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'bottom_info_value',
					'hide_text_align' => true,
				),
				// course instructor font toggle end.
				'header'                  => array(
					'css'             => array(
						'main' => "$wrapper .tutor-course-topics-header-left .text-medium-h6.tutor-color-text-primary",
					),
					'hide_text_align' => true,
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'header',
				),
				'topics'                  => array(
					'css'             => array(
						'main' => "$wrapper .tutor-accordion-item-header",
					),
					'hide_text_align' => true,
					'hide_text_color' => true,
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'topics',
				),
				'lesson'                  => array(
					'css'             => array(
						'main' => '%%order_class%% .tutor-courses-lession-list li a',
					),
					'hide_text_align' => true,
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'lesson',
					'important'       => true,
				),

				// reviews controls.
				'review_section_title'    => array(
					'css'             => array(
						'main'        => "$reviews_wrapper .tutor-course-topics-header .text-primary",
						'tab_slug'    => 'advanced',
						'toggle_slug' => 'section_title',
					),
					'hide_text_align' => true,
				),
				'review_avg_total'        => array(
					'css'             => array(
						'main'        => "$reviews_wrapper .tutor-ratingsreviews-ratings-avg .text-medium-h1",
						'tab_slug'    => 'advanced',
						'toggle_slug' => 'review_avg_total',

					),
					'hide_text_align' => true,
				),
				'review_avg_star'         => array(
					'css'             => array(
						'main'        => '%%order_class%% .tutor-ratingsreviews-ratings-avg .tutor-ratings .tutor-rating-stars span',
						'tab_slug'    => 'advanced',
						'toggle_slug' => 'review_avg_star',

					),
					'hide_text_align' => true,
				),
				'review_avg_text'         => array(
					'label'           => 'Review Avg Total',
					'css'             => array(
						'main'        => "$reviews_wrapper .tutor-rating-text-part",
						'tab_slug'    => 'advanced',
						'toggle_slug' => 'review_avg_text',

					),
					'hide_text_align' => true,
				),
				'review_avg_count'        => array(

					'css'             => array(
						'main'        => "$reviews_wrapper .tutor-rating-count-part",
						'tab_slug'    => 'advanced',
						'toggle_slug' => 'review_avg_count',

					),
					'hide_text_align' => true,
				),
				'rating_bar'              => array(
					'css' => array(
						'main'        => "$reviews_wrapper .rating-num.color-text-subsued",
						'tab_slug'    => 'advanced',
						'toggle_slug' => 'rating_abr',
					),
				),
				'review_list_author_name' => array(
					'css'             => array(
						'main'        => "$reviews_wrapper .tutor-reviewer-name",
						'tab_slug'    => 'advanced',
						'toggle_slug' => 'review_list_author_name',
					),
					'hide_text_align' => true,
				),
				'review_list_time'        => array(
					'css'             => array(
						'main'        => "$reviews_wrapper .tutor-review-time",
						'tab_slug'    => 'advanced',
						'toggle_slug' => 'review_list_time',
					),
					'hide_text_align' => true,
				),
				'review_list_comment'     => array(
					'css' => array(
						'main'        => "$reviews_wrapper .tutor-review-comment",
						'tab_slug'    => 'advanced',
						'toggle_slug' => 'review_list_comment',
					),
				),
				'review_list_star'        => array(
					'css'             => array(
						'main'        => "$reviews_wrapper .review-list .tutor-rating-stars span ",
						'tab_slug'    => 'advanced',
						'toggle_slug' => 'review_list_comment',
					),
					'hide_text_align' => true,
				),
			),
			'borders'        => array(
				'default'                     => false,
				'course_benefits_list_border' => array(
					'css'         => array(
						'main'      => array(
							'border_radii'  => '%%order_class%% ul.tutor-course-benefits-items li',
							'border_styles' => '%%order_class%% ul.tutor-course-benefits-items li',

						),
						'important' => true,
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'course_benefits_list',
				),
				// course instructor border toggle.
				'instructor_avatar'           => array(
					'css'         => array(
						'main' => array(
							'border_styles' => '%%order_class%% .instructor-avatar a img',
							'border_radii'  => '%%order_class%% .instructor-avatar a img',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'instructor_avatar',
				),
				'section_content'             => array(
					'css'         => array(
						'main'      => array(
							'border_styles' => '%%order_class%% .tutor-instructor-info-card',
							'border_radii'  => '%%order_class%% .tutor-instructor-info-card',
						),
						'important' => 'all',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'course_instructor_section',
				),
				// course instructor border toggle end.

				'topics'                      => array(
					'css'         => array(
						'main'      => array(
							'border_radii'  => $topic_wrapper_selector,
							'border_styles' => $topic_wrapper_selector,

						),
						'important' => true,
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'topics',
				),
				'lesson'                      => array(
					'css'         => array(
						'main'      => array(
							'border_radii'  => '%%order_class%% .tutor-courses-lession-list li:not(:last-child)',
							'border_styles' => '%%order_class%% .tutor-courses-lession-list li:not(:last-child)',
						),
						'important' => true,
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'lesson',
				),
				// reviews border.
				'review_list_avatar'          => array(
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
			),
			'margin_padding' => array(
				'css' => array(
					'main'      => '%%order_class%% .tutor-accordion-item',
					'important' => array( 'custom_padding' ),
				),
			),
			'text'           => false,
			'max_width'      => false,
			// 'animation'      => false,
			// 'transform'      => false,
			'background'     => false,
			// 'filters'        => false,
			// 'box_shadow'     => false,
		);
	}

	public function get_fields() {
		return array(
			'course'                                   => Helper::get_field(
				array(
					'default'          => Helper::get_course_default(),
					'computed_affects' => array(
						'__content',
					),
				)
			),
			'__content'                                => array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'CourseContent',
					'get_edit_template',
				),
				'computed_depends_on' => array(
					'course',
					'course_benefits_label',
					'course_benefits_icon',
					'course_instructor_label',
					'course_topics_label',
					'course_reviews_label',
					'course_instructor_label',
					'profile_picture',
					'display_name',
					'designation',
					'course_instructor_link',
				),
				'computed_minimum'    => array(
					'course',
					'course_benefits_label',
					'course_benefits_icon',
					'course_instructor_label',
					'course_topics_label',
					'course_reviews_label',
					'course',
					'course_benefits_label',
					'course_benefits_icon',
					'course_instructor_label',
					'course_topics_label',
					'course_reviews_label',
					'course_instructor_label',
					'profile_picture',
					'display_name',
					'designation',
					'course_instructor_link',
				),
			),
			// course benefits controls start.
			'course_benefits_label'                    => array(
				'label'           => esc_html__( 'Label', 'tutor-lms-divi-modules' ),
				'type'            => 'text',
				'default'         => esc_html__( 'Course Benefits', 'tutor-lms-divi-modules' ),
				'option_category' => 'basic',
				'toggle_slug'     => 'main_content',

			),
			'course_benefits_layout'                   => array(
				'label'           => esc_html( 'Layout', 'tutor-lms-divi-modules' ),
				'type'            => 'select',
				'options'         => array(
					'list-teim' => esc_html__( 'List', 'tutor-lms-divi-modules' ),
					'inline'    => esc_html__( 'Inline', 'tutor-lms-divi-modules' ),
				),
				'default'         => 'block',
				'option_category' => 'layout',
				'toggle_slug'     => 'main_content',
				'mobile_options'  => true,
			),
			'course_benefits_icon'                     => array(
				'label'           => esc_html__( 'Icon', 'tutor-lms-divi-modules' ),
				'type'            => 'select_icon',
				'default'         => 'N',
				'class'           => array( 'et-pb-font-icon' ),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'main_content',
			),
			'course_benefits_alignment'                => array(
				'label'           => esc_html__( 'Alignment', 'tutor-lms-divi-modules' ),
				'type'            => 'text_align',
				'option_category' => 'configuration',
				'options'         => et_builder_get_text_orientation_options( array( 'justified' ) ),
				'default'         => 'left',
				'toggle_slug'     => 'main_content',
				'mobile_options'  => true,
			),
			// course benefits controls end.

			// course curriculum content controls start.
			'course_topics_label'                      => array(
				'label'           => esc_html__( 'Label', 'tutor-lms-divi-modules' ),
				'type'            => 'text',
				'default'         => esc_html__( 'Course Curriculum', 'tutor-lms-divi-modules' ),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'course_curriculum',
			),
			// 'course_topics_icon_position' => array(
			// 'label'          => esc_html__( 'Icon Position', 'tutor-lms-divi-modules' ),
			// 'type'           => 'select',
			// 'options'        => array(
			// 'left'  => esc_html__( 'Left', 'tutor-lms-divi-modules' ),
			// 'right' => esc_html__( 'Right', 'tutor-lms-divi-modules' ),
			// ),
			// 'default'        => 'right',
			// 'toggle_slug'    => 'course_curriculum',
			// 'mobile_options' => true,
			// ),
			// course curriculum content controls end.

			// course reviews content controls start.
			'course_reviews_label'                     => array(
				'label'       => esc_html__( 'Label', 'tutor-lms-divi-modules' ),
				'type'        => 'text',
				'default'     => esc_html__( 'Student Ratings & Reviews ', 'tutor-lms-divi-modules' ),
				'toggle_slug' => 'course_reviews',
			),
			// course reviews content controls end.

			/**
			 * Course benefits advance controls
			 */
			// advanced tab section title toggles.
			'course_benefits_gap'                      => array(
				'label'          => esc_html__( 'Gap', 'tutor-lms-divi-modules' ),
				'type'           => 'range',
				'default'        => '10',
				'default_unit'   => 'px',
				'range_settings' => array(
					'min'  => -10,
					'max'  => 100,
					'step' => 1,
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'course_benefits_title',
				'mobile_options' => true,
			),
			// advanced tab section list toggles.
			'space_between'                            => array(
				'label'          => esc_html__( 'Space Between', 'tutor-lms-divi-modules' ),
				'type'           => 'range',
				'default'        => '10',
				'default_unit'   => 'px',
				'range_settings' => array(
					'min'  => '-10',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'course_benefits_list',
				'mobile_options' => true,
			),
			'padding'                                  => array(
				'label'           => esc_html__( 'Padding', 'tutor-lms-divi-modules' ),
				'type'            => 'custom_padding',
				'hover'           => 'tabs',
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'course_benefits_list',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
			),
			// advanced tab text toggle
			'course_benefits_icon_color'               => array(
				'label'       => esc_html__( 'Color', 'tutor-lms-divi-modules' ),
				'type'        => 'color-alpha',
				'default'     => '#3e64de',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'course_benefits_icon',
			),
			'course_benefits_icon_size'                => array(
				'label'          => esc_html__( 'Size', 'tutor-lms-divi-modules' ),
				'type'           => 'range',
				'default'        => '18px',
				'default_unit'   => 'px',
				'range_settings' => array(
					'min'  => '-10',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'course_benefits_icon',
				'mobile_options' => true,
			),
			// advanced tab text toggle
			'indent'                                   => array(
				'label'          => esc_html__( 'Text Indent', 'tutor-lms-divi-modules' ),
				'type'           => 'range',
				'default'        => '7px',
				'default_unit'   => 'px',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'course_benefits_text',
				'mobile_options' => true,
			),
			// course benefits advance controls end.

			/**
			 * Course curriculum advance tab controls
			 */
			// advanced tab header toggle
			'gap'                                      => array(
				'label'          => esc_html__( 'Gap', 'tutor-lms-divi-modules' ),
				'type'           => 'range',
				'default'        => '5px',
				'default_unit'   => 'px',
				'range_settings' => array(
					'min'  => 0,
					'max'  => 100,
					'step' => 1,
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'header',
				'mobile_options' => true,
			),

			// advanced tab topics toggle
			'topic_icon_size'                          => array(
				'label'          => esc_html__( 'Icon Size', 'tutor-lms-divi-modules' ),
				'type'           => 'range',
				'default'        => '32',
				'default_unit'   => 'px',
				'range_settings' => array(
					'min'  => 0,
					'max'  => 100,
					'step' => 1,
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'topics',
				'mobile_options' => true,
			),
			'composite_tabbed'                         => array(
				'label'               => esc_html__( 'Color Settings', 'tutor-lms-divi-modules' ),
				'tab_slug'            => 'advanced',
				'toggle_slug'         => 'topics',
				'type'                => 'composite',
				'composite_type'      => 'default',
				'composite_structure' => array(
					'tab_1' => array(
						'label'    => esc_html( 'Normal', 'tutor-lms-divi-modules' ),
						'controls' => array(
							'topic_icon_color'       => array(
								'label' => esc_html__( 'Icon Color', 'tutor-lms-divi-modules' ),
								'type'  => 'color-alpha',
							),
							'topic_text_color'       => array(
								'label' => esc_html__( 'Text Color', 'tutor-lms-divi-modules' ),
								'type'  => 'color-alpha',
							),
							'topic_background_color' => array(
								'label' => esc_html__( 'Background Color', 'tutor-lms-divi-modules' ),
								'type'  => 'color-alpha',
							),
						),
					),
					'tab_2' => array(
						'label'    => esc_html( 'Active', 'tutor-lms-divi-modules' ),
						'controls' => array(
							'topic_icon_active_color' => array(
								'label' => esc_html__( 'Icon Color', 'tutor-lms-divi-modules' ),
								'type'  => 'color-alpha',
							),
							'topic_text_active_color' => array(
								'label' => esc_html__( 'Text Color', 'tutor-lms-divi-modules' ),
								'type'  => 'color-alpha',
							),
							'topic_background_active_color' => array(
								'label' => esc_html__( 'Background Color', 'tutor-lms-divi-modules' ),
								'type'  => 'color-alpha',
							),
						),
					),
					'tab_3' => array(
						'label'    => esc_html( 'Hover', 'tutor-lms-divi-modules' ),
						'controls' => array(
							'topic_icon_hover_color'       => array(
								'label' => esc_html__( 'Icon Color', 'tutor-lms-divi-modules' ),
								'type'  => 'color-alpha',
							),
							'topic_text_hover_color'       => array(
								'label' => esc_html__( 'Text Color', 'tutor-lms-divi-modules' ),
								'type'  => 'color-alpha',
							),
							'topic_background_hover_color' => array(
								'label' => esc_html__( 'Background Color', 'tutor-lms-divi-modules' ),
								'type'  => 'color-alpha',
							),
						),
					),
				),
			),
			// advanced tab lesson toggles
			'lesson_icon_size'                         => array(
				'label'          => esc_html__( 'Icon Size', 'tutor-lms-divi-modules' ),
				'type'           => 'range',
				'default'        => '18px',
				'default_unit'   => 'px',
				'range_settings' => array(
					'min'  => 0,
					'max'  => 100,
					'step' => 1,
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'lesson',
				'mobile_options' => true,
			),
			'lesson_icon_color'                        => array(
				'label'       => esc_html__( 'Icon Color', 'tutor-lms-divi-modules' ),
				'type'        => 'color-alpha',
				'hover'       => 'tabs',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'lesson',

			),
			'lesson_info_color'                        => array(
				'label'       => esc_html__( 'Info Color', 'tutor-lms-divi-modules' ),
				'type'        => 'color-alpha',
				'hover'       => 'tabs',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'lesson',

			),
			'lesson_background_color'                  => array(
				'label'       => esc_html__( 'Background Color', 'tutor-lms-divi-modules' ),
				'type'        => 'color-alpha',
				'hover'       => 'tabs',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'lesson',

			),
			// advanced tab spacing toggle
			'space_between_topics'                     => array(
				'label'          => esc_html__( 'Space Between Topics', 'tutor-lms-divi-modules' ),
				'type'           => 'range',
				'default'        => '10px',
				'default_unit'   => 'px',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'margin_padding',
			),
			// reviews fields.
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
	 * Get the tutor course author
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public static function get_edit_template( $args = array() ) {
		// Filter title.
		if ( isset( $args['course_topics_label'] ) && '' !== $args['course_topics_label'] ) {
			add_filter(
				'tutor_course_topics_title',
				function() use ( $args ) {
					return esc_html( $args['course_topics_label'] );
				}
			);
		}
		if ( isset( $args['course_reviews_label'] ) && '' !== $args['course_reviews_label'] ) {
			add_filter(
				'tutor_course_reviews_section_title',
				function() use ( $args ) {
					return esc_html( $args['course_reviews_label'] );
				}
			);
		}
		ob_start();
		include dtlms_get_template( 'course/content-editor' );
		return ob_get_clean();
	}

	/**
	 * Get the tutor course author
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public static function get_content( $args = array() ) {
		// Filter course topic title.
		if ( isset( $args['course_topics_label'] ) && '' !== $args['course_topics_label'] ) {
			add_filter(
				'tutor_course_topics_title',
				function() use ( $args ) {
					return esc_html( $args['course_topics_label'] );
				}
			);
		}
		if ( isset( $args['course_reviews_label'] ) && '' !== $args['course_reviews_label'] ) {
			add_filter(
				'tutor_course_reviews_section_title',
				function() use ( $args ) {
					return esc_html( $args['course_reviews_label'] );
				}
			);
		}
		ob_start();
		include dtlms_get_template( 'course/content' );
		return ob_get_clean();
	}

	/**
	 * Filter curricle title as per user value
	 *
	 * @return string
	 *
	 * @since v1.0.0
	 */
	public static function update_curriculumn_title() {
		return self::$curriculum_title;
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
	public function render( $unprocessed_props, $content, $render_slug ) {
		// selectors
		$wrapper                 = '%%order_class%% .dtlms-course-curriculum';
		$topic_icon_selector     = $wrapper . ' .tutor-accordion-item-header::after';
		$topic_wrapper           = '%%order_class%% .tutor-divi-course-topic';
		$topics_wrapper          = '%%order_class%% .tutor-divi-course-topic';
		$topic_wrapper_selector  = $wrapper . ' h3';
		$title_selector          = $wrapper . ' h3';
		$header_wrapper_selector = '%%order_class%% .tutor-course-title';
		$header_wrapper_selector = '%%order_class%% .tutor-course-title';

		$lesson_icon_selector    = '%%order_class%% .tutor-course-content-list-item span';
		$lesson_wrapper_selector = '%%order_class%% .tutor-course-content-list-item';
		$lesson_info_selector    = '%%order_class%% .tutor-course-content-list-item-title a';

		// props
		// $icon_position   = sanitize_text_field( $this->props['course_topics_icon_position'] );
		$topic_icon_size = sanitize_text_field( $this->props['topic_icon_size'] );

		$gap        = sanitize_text_field( $this->props['gap'] );
		$gap_tablet = isset( $this->props['gap_tablet'] ) && $this->props['gap_tablet'] !== '' ? sanitize_text_field( $this->props['gap_tablet'] ) : $gap;
		$gap_phone  = isset( $this->props['gap_phone'] ) && $this->props['gap_phone'] !== '' ? sanitize_text_field( $this->props['gap_phone'] ) : $gap;

		$topic_icon_color        = sanitize_text_field( $this->props['topic_icon_color'] );
		$topic_icon_active_color = sanitize_text_field( $this->props['topic_icon_active_color'] );
		$topic_icon_hover_color  = sanitize_text_field( $this->props['topic_icon_hover_color'] );

		$topic_text_color        = sanitize_text_field( $this->props['topic_text_color'] );
		$topic_text_active_color = sanitize_text_field( $this->props['topic_text_active_color'] );
		$topic_text_hover_color  = sanitize_text_field( $this->props['topic_text_hover_color'] );

		$topic_background_color        = sanitize_text_field( $this->props['topic_background_color'] );
		$topic_background_active_color = sanitize_text_field( $this->props['topic_background_active_color'] );
		$topic_background_hover_color  = sanitize_text_field( $this->props['topic_background_hover_color'] );

		$topic_icon_size        = sanitize_text_field( $this->props['topic_icon_size'] );
		$topic_icon_size_tablet = isset( $this->props['topic_icon_size_tablet'] ) && $this->props['topic_icon_size_tablet'] !== '' ? sanitize_text_field( $this->props['topic_icon_size_tablet'] ) : $topic_icon_size;
		$topic_icon_size_phone  = isset( $this->props['topic_icon_size_phone'] ) && $this->props['topic_icon_size_phone'] !== '' ? sanitize_text_field( $this->props['topic_icon_size_phone'] ) : $topic_icon_size;

		$lesson_icon_size        = sanitize_text_field( $this->props['lesson_icon_size'] );
		$lesson_icon_size_tablet = isset( $this->props['lesson_icon_size_tablet'] ) && $this->props['lesson_icon_size_tablet'] !== '' ? sanitize_text_field( $this->props['lesson_icon_size_tablet'] ) : $lesson_icon_size;
		$lesson_icon_size_phone  = isset( $this->props['lesson_icon_size_phone'] ) && $this->props['lesson_icon_size_phone'] !== '' ? sanitize_text_field( $this->props['lesson_icon_size_phone'] ) : $lesson_icon_size;

		$lesson_icon_color       = sanitize_text_field( $this->props['lesson_icon_color'] );
		$lesson_icon_color_hover = isset( $this->props['lesson_icon_color__hover'] ) ? sanitize_text_field( $this->props['lesson_icon_color__hover'] ) : '';

		$lesson_info_color       = sanitize_text_field( $this->props['lesson_info_color'] );
		$lesson_info_color_hover = isset( $this->props['lesson_info_color__hover'] ) ? sanitize_text_field( $this->props['lesson_info_color__hover'] ) : '';

		$lesson_background_color       = sanitize_text_field( $this->props['lesson_background_color'] );
		$lesson_background_color_hover = isset( $this->props['lesson_background_color__hover'] ) ? sanitize_text_field( $this->props['lesson_background_color__hover'] ) : '';

		$space_between_topics = sanitize_text_field( $this->props['space_between_topics'] );

		// course benefits styles start.
		// selectors.
		$benefits_wrapper       = '%%order_class%% .tutor-course-benefits-wrap';
		$benefits_li_selector   = '%%order_class%% ul.tutor-course-benefits-items li';
		$benefits_icon_selector = '%%order_class%% ul.tutor-course-benefits-items .et-pb-icon';
		// props.
		$benefits_icon_size        = sanitize_text_field( $this->props['course_benefits_icon_size'] );
		$benefits_icon_size_tablet = isset( $this->props['course_benefits_icon_size_tablet'] ) && $this->props['course_benefits_icon_size_tablet'] !== '' ? sanitize_text_field( $this->props['course_benefits_icon_size_tablet'] ) : $benefits_icon_size;
		$benefits_icon_size_phone  = isset( $this->props['course_benefits_icon_size_phone'] ) && $this->props['course_benefits_icon_size_phone'] !== '' ? sanitize_text_field( $this->props['course_benefits_icon_size_phone'] ) : $benefits_icon_size;

		$benefits_gap        = $this->props['course_benefits_gap'];
		$benefits_gap_tablet = isset( $this->props['course_benefits_gap_tablet'] ) && $this->props['course_benefits_gap_tablet'] !== '' ? sanitize_text_field( $this->props['course_benefits_gap_tablet'] ) : $benefits_gap;
		$benefits_gap_phone  = isset( $this->props['course_benefits_gap_phone'] ) && $this->props['course_benefits_gap_phone'] !== '' ? sanitize_text_field( $this->props['course_benefits_gap_phone'] ) : $benefits_gap;

		$padding = sanitize_text_field( $this->props['padding'] );

		$benefits_icon_color = sanitize_text_field( $this->props['course_benefits_icon_color'] );

		$benefits_layout        = sanitize_text_field( $this->props['course_benefits_layout'] );
		$benefits_layout_tablet = isset( $this->props['course_benefits_layout_tablet'] ) && '' !== $this->props['course_benefits_layout_tablet'] ? sanitize_text_field( $this->props['course_benefits_layout_tablet'] ) : $benefits_layout;
		$benefits_layout_phone  = isset( $this->props['course_benefits_layout_phone'] ) && '' !== $this->props['course_benefits_layout_phone'] ? sanitize_text_field( $this->props['course_benefits_layout_phone'] ) : $benefits_layout;

		$benefits_alignment        = $this->props['course_benefits_alignment'];
		$benefits_alignment_tablet = isset( $this->props['course_benefits_alignment_tablet'] ) && '' !== $this->props['course_benefits_alignment_tablet'] ? sanitize_text_field( $this->props['course_benefits_alignment_tablet'] ) : $benefits_alignment;
		$benefits_alignment_phone  = isset( $this->props['course_benefits_alignment_phone'] ) && '' !== $this->props['course_benefits_alignment_phone'] ? sanitize_text_field( $this->props['course_benefits_alignment_phone'] ) : $benefits_alignment;

		$space_between = $this->props['space_between'];
		$space_tablet  = isset( $this->props['space_between_tablet'] ) && '' !== $this->props['space_between_tablet'] ? sanitize_text_field( $this->props['space_between_tablet'] ) : $space_between;
		$space_phone   = isset( $this->props['space_between_phone'] ) && '' !== $this->props['space_between_phone'] ? sanitize_text_field( $this->props['space_between_phone'] ) : $space_between;

		$indent        = $this->props['indent'];
		$indent_tablet = isset( $this->props['indent_tablet'] ) && '' !== $this->props['indent_tablet'] ? sanitize_text_field( $this->props['indent_tablet'] ) : $indent;
		$indent_phone  = isset( $this->props['indent_phone'] ) && '' !== $this->props['indent_phone'] ? sanitize_text_field( $this->props['indent_phone'] ) : $indent;

		// set styles
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => $benefits_wrapper . ' ul',
				'declaration' => 'list-style:none; padding: 0px;',
			)
		);
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => $benefits_icon_selector,
				'declaration' => 'font-size: 18px;',
			)
		);

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => $benefits_li_selector,
				'declaration' => 'list-style:none; padding: 0px; border-style: solid;',
			)
		);

		// wrapper style
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => $benefits_wrapper,
				'declaration' => 'display: flex; flex-direction: column;',
			)
		);

		if ( $benefits_gap ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $benefits_wrapper,
					'declaration' => sprintf(
						'row-gap: %1$s;',
						$benefits_gap
					),
				)
			);
		}
		if ( $benefits_gap_tablet ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $benefits_wrapper,
					'declaration' => sprintf(
						'row-gap: %1$s;',
						$benefits_gap_tablet
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);
		}
		if ( $benefits_gap_phone ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $benefits_wrapper,
					'declaration' => sprintf(
						'row-gap: %1$s;',
						$benefits_gap_phone
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		}

		// icons tyle
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => $benefits_icon_selector,
				'declaration' => sprintf(
					'font-size: %1$s !important;',
					$benefits_icon_size
				),
			)
		);

		if ( $benefits_icon_size_tablet ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $benefits_icon_selector,
					'declaration' => sprintf(
						'font-size: %1$s !important;',
						$benefits_icon_size_tablet
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);
		}

		if ( $benefits_icon_size_phone ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $benefits_icon_selector,
					'declaration' => sprintf(
						'font-size: %1$s !important;',
						$benefits_icon_size_phone
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		}

		if ( $benefits_icon_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $benefits_icon_selector,
					'declaration' => sprintf(
						'color: %1$s !important;',
						$benefits_icon_color
					),
				)
			);
		}

		// padding
		if ( $padding ) {
			$paddings = $this->props['padding'];
			$paddings = explode( '|', $paddings );
			if ( is_array( $paddings ) ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => $benefits_li_selector,
						'declaration' => sprintf(
							'padding: %1$s %2$s %3$s %4$s;',
							$paddings[0],
							$paddings[1],
							$paddings[2],
							$paddings[3]
						),
					)
				);
			}
		}

		// layout
		if ( $benefits_layout ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $benefits_li_selector,
					'declaration' => sprintf(
						'display: %1$s !important;',
						$benefits_layout
					),
				)
			);
		}
		if ( $benefits_layout_tablet ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $benefits_li_selector,
					'declaration' => sprintf(
						'display: %1$s !important;',
						$benefits_layout_tablet
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);
		}
		if ( $benefits_layout_phone ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $benefits_li_selector,
					'declaration' => sprintf(
						'display: %1$s !important;',
						$benefits_layout_phone
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		}

		// alignment
		if ( $benefits_alignment ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $benefits_wrapper,
					'declaration' => sprintf(
						'text-align: %1$s !important;',
						$benefits_alignment
					),
				)
			);
		}
		if ( $benefits_alignment_tablet ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $benefits_wrapper,
					'declaration' => sprintf(
						'text-align: %1$s !important;',
						$benefits_alignment_tablet
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);
		}
		if ( $benefits_alignment_phone ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $benefits_wrapper,
					'declaration' => sprintf(
						'text-align: %1$s !important;',
						$benefits_alignment_phone
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		}

		// space between
		if ( $space_between ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $benefits_li_selector . ':not(:last-child)',
					'declaration' => sprintf(
						'margin-bottom: %1$s !important;',
						$space_between
					),
				)
			);
		}

		if ( $space_tablet ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $benefits_li_selector . ':not(:last-child)',
					'declaration' => sprintf(
						'margin-bottom: %1$s !important;',
						$space_tablet
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);
		}
		if ( $space_phone ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $benefits_li_selector . ':not(:last-child)',
					'declaration' => sprintf(
						'margin-bottom: %1$s !important;',
						$space_phone
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		}

		if ( $indent ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $benefits_li_selector . ' .list-item',
					'declaration' => sprintf(
						'padding-left: %1$s !important;',
						$indent
					),
				)
			);
		}

		if ( $indent_tablet ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $benefits_li_selector . ' .list-item',
					'declaration' => sprintf(
						'padding-left: %1$s !important;',
						$indent_tablet
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);
		}
		if ( $indent_phone ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $benefits_li_selector . ' .list-item',
					'declaration' => sprintf(
						'padding-left: %1$s !important;',
						$indent_phone
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		}
		// course benefits styles start end.

		// set styles.

		if ( '' !== $space_between_topics ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dtlms-course-curriculum .tutor-accordion-item',
					'declaration' => sprintf(
						'margin-bottom: %1$s;',
						$space_between_topics
					),
				)
			);
		}

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => $topic_wrapper_selector,
				'declaration' => 'display: flex; column-gap: 10px; align-items: center;',
			)
		);
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => $topic_wrapper_selector . ' h4',
				'declaration' => 'padding: 0; margin: 0;',
			)
		);
		// topic styles
		// topic wrapper default border
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => $topic_wrapper,
				'declaration' => 'border: 1px solid #DCE4E6;',
			)
		);

		// if ( $icon_position === 'left' ) {
		// ET_Builder_Element::set_style(
		// $render_slug,
		// array(
		// 'selector'    => $topic_icon_selector,
		// 'declaration' => 'position: inherit !important; padding-left: 20px;',
		// )
		// );
		// }
		if ( '' !== $topic_icon_size ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $topic_icon_selector,
					'declaration' => sprintf(
						'font-size: %1$s;',
						$topic_icon_size
					),
				)
			);
		}
		if ( '' !== $topic_icon_size_tablet ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $topic_icon_selector,
					'declaration' => sprintf(
						'font-size: %1$s;',
						$topic_icon_size_tablet
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);
		}
		if ( '' !== $topic_icon_size_phone ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $topic_icon_selector,
					'declaration' => sprintf(
						'font-size: %1$s;',
						$topic_icon_size_phone
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		}

		// topic icon,text,background colors

		// topic icon color
		if ( '' !== $topic_icon_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "$wrapper .tutor-accordion-item-header::after",
					'declaration' => sprintf(
						'color: %1$s;',
						$topic_icon_color
					),
				)
			);
		}
		if ( '' !== $topic_icon_active_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "$wrapper .tutor-accordion-item-header.is-active::after",
					'declaration' => sprintf(
						'color: %1$s;',
						$topic_icon_active_color
					),
				)
			);
		}
		if ( '' !== $topic_icon_hover_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "$wrapper .tutor-accordion-item-header:hover:after",
					'declaration' => sprintf(
						'color: %1$s;',
						$topic_icon_hover_color
					),
				)
			);
		}
		// topic title text color styles
		if ( '' !== $topic_text_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "$wrapper .tutor-accordion-item-header",
					'declaration' => sprintf(
						'color: %1$s;',
						$topic_text_color
					),
				)
			);
		}
		if ( '' !== $topic_text_active_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "$wrapper .tutor-accordion-item-header.is-active",
					'declaration' => sprintf(
						'color: %1$s;',
						$topic_text_active_color
					),
				)
			);
		}
		if ( '' !== $topic_text_hover_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "$wrapper .tutor-accordion-item-header.is-active:hover",
					'declaration' => sprintf(
						'color: %1$s;',
						$topic_text_hover_color
					),
				)
			);
		}
		// topic title background color styles
		if ( '' !== $topic_background_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "$wrapper .tutor-accordion-item-header",
					'declaration' => sprintf(
						'background-color: %1$s;',
						$topic_background_color
					),
				)
			);
		}
		if ( '' !== $topic_background_active_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "$wrapper .tutor-accordion-item-header.is-active",
					'declaration' => sprintf(
						'background-color: %1$s;',
						$topic_background_active_color
					),
				)
			);
		}
		if ( '' !== $topic_background_hover_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "$wrapper .tutor-accordion-item-header:hover",
					'declaration' => sprintf(
						'background-color: %1$s;',
						$topic_background_hover_color
					),
				)
			);
		}
		// header styles
		if ( $gap ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% #tutor-course-details-tab-curriculum .tutor-accordion',
					'declaration' => sprintf(
						'margin-top: %1$s !important;',
						$gap
					),
				)
			);
		}
		if ( $gap_tablet ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% #tutor-course-details-tab-curriculum .tutor-accordion',
					'declaration' => sprintf(
						'margin-top: %1$s !important;',
						$gap_tablet
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);
		}
		if ( $gap_phone ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% #tutor-course-details-tab-curriculum .tutor-accordion',
					'declaration' => sprintf(
						'margin-top: %1$s !important;',
						$gap_phone
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		}
		// lesson style

		// ET_Builder_Element::set_style(
		// $render_slug,
		// array(
		// 'selector'      => '%%order_class%% .tutor-course-lesson h5',
		// 'declaration'   => 'display: block !important;'
		// )
		// );
		if ( '' !== $lesson_icon_size ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $lesson_icon_selector,
					'declaration' => sprintf(
						'font-size: %1$s;',
						$lesson_icon_size
					),
				)
			);
		}
		if ( '' !== $lesson_icon_size_tablet ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $lesson_icon_selector,
					'declaration' => sprintf(
						'font-size: %1$s;',
						$lesson_icon_size_tablet
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);
		}
		if ( '' !== $lesson_icon_size_phone ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $lesson_icon_selector,
					'declaration' => sprintf(
						'font-size: %1$s;',
						$lesson_icon_size_phone
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		}
		if ( '' !== $lesson_icon_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $lesson_icon_selector,
					'declaration' => sprintf(
						'color: %1$s;',
						$lesson_icon_color
					),
				)
			);
		}
		if ( '' !== $lesson_icon_color_hover ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $lesson_icon_selector . ':hover',
					'declaration' => sprintf(
						'color: %1$s;',
						$lesson_icon_color_hover
					),
				)
			);
		}
		if ( '' !== $lesson_info_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $lesson_info_selector,
					'declaration' => sprintf(
						'color: %1$s;',
						$lesson_info_color
					),
				)
			);
		}
		if ( '' !== $lesson_info_color_hover ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $lesson_info_selector . ':hover',
					'declaration' => sprintf(
						'color: %1$s;',
						$lesson_info_color_hover
					),
				)
			);
		}
		if ( '' !== $lesson_background_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $lesson_wrapper_selector,
					'declaration' => sprintf(
						'background-color: %1$s;',
						$lesson_background_color
					),
				)
			);
		}
		if ( '' !== $lesson_background_color_hover ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $lesson_wrapper_selector . ':hover',
					'declaration' => sprintf(
						'background-color: %1$s;',
						$lesson_background_color_hover
					),
				)
			);
		}
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% ul.tutor-courses-lession-list',
				'declaration' => 'padding: 0 !important;',
			)
		);
		// review styles start.
		// review star color.
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
		// reviews styles end.
		// set styles end
		$output = self::get_content( $this->props );
		// Render empty string if no output is generated to avoid unwanted vertical space.
		if ( '' === $output ) {
			return '';
		}

		return $this->_render_module_wrapper( $output, $render_slug );
	}
}
new CourseContent();
