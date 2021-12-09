<?php
/**
 * Tutor Course Curriculum Module for Divi Builder
 *
 * @since 1.0.0
 * @author Themeum<www.themeum.com>
 */

use TutorLMS\Divi\Helper;

defined( 'ABSPATH' ) || exit;

class CourseCurriculum extends ET_Builder_Module {

	public $slug       = 'tutor_course_curriculum';
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
		$this->name      = esc_html__( 'Tutor Course Curriculum', 'tutor-lms-divi-modules' );
		$this->icon_path = plugin_dir_path( __FILE__ ) . 'icon.svg';
		// Toggle settings
		// Toggles are grouped into array of tab name > toggles > toggle definition
		$this->settings_modal_toggles = array(
			'general'  => array(),
			'advanced' => array(
				'toggles' => array(
					'header'                  => array(
						'title' => esc_html__( 'Curriculum Header', 'tutor-lms-divi-modules' ),
					),
					'topics'                  => array(
						'title' => esc_html__( 'Topics', 'tutor-lms-divi-modules' ),
					),
					'lesson'                  => array(
						'title' => esc_html__( 'Lesson', 'tutor-lms-divi-modules' ),
					),
					'lesson_info'             => array(
						'title' => esc_html__( 'Lesson Info', 'tutor-lms-divi-modules' ),
					),
					'review_section_title'    => esc_html__( 'Review Section Title', 'tutor-lms-divi-modules' ),
					'review_avg_total'        => esc_html__( 'Review Average Total', 'tutor-lms-divi-modules' ),
					'review_avg_text'         => esc_html__( 'Review Average Text', 'tutor-lms-divi-modules' ),
					'review_avg_count'        => esc_html__( 'Review Average Count', 'tutor-lms-divi-modules' ),
					'review_avg_star'         => esc_html__( 'Review Average Star', 'tutor-lms-divi-modules' ),
					'rating_bar'              => esc_html__( 'Right Rating Bar', 'tutor-lms-divi-modules' ),
					'review_list_avatar'      => esc_html__( 'Review List Avatar', 'tutor-lms-divi-modules' ),
					'review_list_author_name' => esc_html__( 'Review List Author Name', 'tutor-lms-divi-modules' ),
					'review_list_time'        => esc_html__( 'Review List Time', 'tutor-lms-divi-modules' ),
					'review_list_comment'     => esc_html__( 'Review List Comment', 'tutor-lms-divi-modules' ),
					'review_list_star'        => esc_html__( 'Review List Star', 'tutor-lms-divi-modules' ),
				),
			),
		);

		// advanced fields config
		$wrapper                 = '%%order_class%% .dtlms-course-curriculum';
		$topic_icon_selector     = $wrapper . ' .tutor-course-title >span';
		$topic_wrapper_selector  = '%%order_class%% .tutor-accordion-item';
		$lesson_title_selector   = '%%order_class%% .tutor-courses-lession-list .text-regular-body.color-text-primary';
		$lesson_wrapper_selector = '%%order_class%% .tutor-accordion-item-body';

		// Reviews selectors.
        $title_selector         = '%%order_class%% .tutor-single-course-segment .course-student-rating-title h4';
        $avg_total_selector     = '%%order_class%% .course-avg-rating-wrap .course-avg-rating';
        $avg_text_selector      = '%%order_class%% .course-avg-rating-wrap .tutor-course-avg-rating-total';
        $avg_count_selector     = '%%order_class%% .course-avg-rating-wrap .tutor-course-avg-rating-total > span';
		
		$this->advanced_fields = array(
			'fonts'          => array(
				'header'                  => array(
					'css'             => array(
						'main' => "$wrapper .tutor-course-topics-header-left .text-medium-h6.color-text-primary",
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
						'main' => '%%order_class%% .lesson-preview-title',
					),
					'hide_text_align' => true,
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'lesson',
					'important'       => true,
				),

				// reviews controls.
				'review_section_title'    => array(
					'css' => array(
						'main'        => $title_selector,
						'tab_slug'    => 'advanced',
						'toggle_slug' => 'section_title',
					),
				),
				'review_avg_total'        => array(
					'css'             => array(
						'main'        => $avg_total_selector,
						'tab_slug'    => 'advanced',
						'toggle_slug' => 'review_avg_total',

					),
					'hide_text_align' => true,
				),
				'review_avg_text'         => array(
					'label'           => 'Review Avg Total',
					'css'             => array(
						'main'        => $avg_text_selector,
						'tab_slug'    => 'advanced',
						'toggle_slug' => 'review_avg_text',

					),
					'hide_text_align' => true,
				),
				'review_avg_count'        => array(

					'css'             => array(
						'main'        => $avg_count_selector,
						'tab_slug'    => 'advanced',
						'toggle_slug' => 'review_avg_count',

					),
					'hide_text_align' => true,
				),
				'rating_bar'              => array(
					'css' => array(
						'main'        => '%%order_class%% .course-rating-meter .rating-text-col, %%order_class%% .course-ratings-count-meter-wrap .rating-meter-col',
						'tab_slug'    => 'advanced',
						'toggle_slug' => 'rating_abr',
					),
				),
				'review_list_author_name' => array(
					'css'             => array(
						'main'        => '%%order_class%% .tutor-review-user-info .review-time-name p a',
						'tab_slug'    => 'advanced',
						'toggle_slug' => 'review_list_author_name',
					),
					'hide_text_align' => true,
				),
				'review_list_time'        => array(
					'css'             => array(
						'main'        => '%%order_class%% .tutor-review-user-info .review-time-name .review-meta',
						'tab_slug'    => 'advanced',
						'toggle_slug' => 'review_list_time',
					),
					'hide_text_align' => true,
				),
				'review_list_comment'     => array(
					'css' => array(
						'main'        => '%%order_class%% .review-content.review-right p',
						'tab_slug'    => 'advanced',
						'toggle_slug' => 'review_list_comment',
					),
				),
				'review_list_star'        => array(
					'css'             => array(
						'main'        => '%%order_class%% .individual-review-rating-wrap .tutor-star-rating-group i',
						'tab_slug'    => 'advanced',
						'toggle_slug' => 'review_list_comment',
					),
					'hide_text_align' => true,
				),
			),
			'borders'        => array(
				'default' => false,
				'topics'  => array(
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
				'lesson'  => array(
					'css'         => array(
						'main'      => array(
							'border_radii'  => $lesson_wrapper_selector,
							'border_styles' => $lesson_wrapper_selector,
						),
						'important' => true,
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'lesson',
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
			'animation'      => false,
			'transform'      => false,
			'background'     => false,
			'filters'        => false,
			'box_shadow'     => false,
		);
	}

	public function get_fields() {
		return array(
			'course'                  => Helper::get_field(
				array(
					'default'          => Helper::get_course_default(),
					'computed_affects' => array(
						'__curriculum',
					),
				)
			),
			'__curriculum'            => array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'CourseCurriculum',
					'get_content',
				),
				'computed_depends_on' => array(
					'course',
					'label',
				),
				'computed_minimum'    => array(
					'course',
				),
			),
			// general tab content toggle
			'label'                   => array(
				'label'           => esc_html__( 'Label', 'tutor-lms-divi-modules' ),
				'type'            => 'text',
				'default'         => esc_html__( 'Topics for this course', 'tutor-lms-divi-modules' ),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'main_content',
			),
			'icon_position'           => array(
				'label'          => esc_html__( 'Icon Position', 'tutor-lms-divi-modules' ),
				'type'           => 'select',
				'options'        => array(
					'left'  => esc_html__( 'Left', 'tutor-lms-divi-modules' ),
					'right' => esc_html__( 'Right', 'tutor-lms-divi-modules' ),
				),
				'default'        => 'right',
				'toggle_slug'    => 'main_content',
				'mobile_options' => true,
			),
			// advanced tab header toggle
			'gap'                     => array(
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
			'topic_icon_size'         => array(
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
			'composite_tabbed'        => array(
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
			'lesson_icon_size'        => array(
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
			'lesson_icon_color'       => array(
				'label'       => esc_html__( 'Icon Color', 'tutor-lms-divi-modules' ),
				'type'        => 'color-alpha',
				'hover'       => 'tabs',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'lesson',

			),
			'lesson_info_color'       => array(
				'label'       => esc_html__( 'Info Color', 'tutor-lms-divi-modules' ),
				'type'        => 'color-alpha',
				'hover'       => 'tabs',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'lesson',

			),
			'lesson_background_color' => array(
				'label'       => esc_html__( 'Background Color', 'tutor-lms-divi-modules' ),
				'type'        => 'color-alpha',
				'hover'       => 'tabs',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'lesson',

			),
			// advanced tab spacing toggle
			'space_between_topics'    => array(
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
		);
	}


	/**
	 * Get the tutor course author
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public static function get_content( $args = array() ) {
		if ( isset( $args['label'] ) ) {
			self::$curriculum_title = $args['label'];
			add_filter( 'tutor_course_topics_title', array( __CLASS__, 'update_curriculumn_title' ) );
		}
		ob_start();
		include_once dtlms_get_template( 'course/curriculum' );
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
		$topics_wrapper          = '%%order_class%% .tutor-course-topics-contents';
		$topic_wrapper_selector  = $wrapper . ' .tutor-course-title';
		$title_selector          = $wrapper . '.tutor-course-title';
		$header_wrapper_selector = '%%order_class%% .tutor-course-topics-header';
		$header_wrapper_selector = '%%order_class%% .tutor-course-topics-header';

		$lesson_icon_selector    = '%%order_class%% .tutor-courses-lession-list span::before';
		$lesson_wrapper_selector = '%%order_class%% .tutor-accordion-item-body';
		$lesson_info_selector    = '%%order_class%% .tutor-courses-lession-list .text-regular-caption.color-text-hints';

		// props
		$icon_position   = sanitize_text_field( $this->props['icon_position'] );
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

		if ( $icon_position === 'left' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $topic_icon_selector,
					'declaration' => 'position: inherit !important; padding-left: 20px;',
				)
			);
		}
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
					'selector'    => "$wrapper .tutor-course-topics-header-left .text-medium-h6.color-text-primary",
					'declaration' => sprintf(
						'margin-bottom: %1$s;',
						$gap
					),
				)
			);
		}
		if ( $gap_tablet ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "$wrapper .tutor-course-topics-header-left .text-medium-h6.color-text-primary",
					'declaration' => sprintf(
						'margin-bottom: %1$s ;',
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
					'selector'    => "$wrapper .tutor-course-topics-header-left .text-medium-h6.color-text-primary",
					'declaration' => sprintf(
						'margin-bottom: %1$s ;',
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

		// set styles end
		$output = self::get_content( $this->props );
		// Render empty string if no output is generated to avoid unwanted vertical space.
		if ( '' === $output ) {
			return '';
		}

		return $this->_render_module_wrapper( $output, $render_slug );
	}
}
new CourseCurriculum();
