<?php
/**
 * Tutor Course Enrollment Module for Divi Builder
 *
 * @since 1.0.0
 * @author Themeum<www.themeum.com>
 * @package  DTLMS\CoursePurchase
 */

use TutorLMS\Divi\Helper;

defined( 'ABSPATH' ) || exit;

class CoursePurchase extends ET_Builder_Module {

	// Module slug (also used as shortcode tag)
	public $slug       = 'tutor_course_purchase';
	public $vb_support = 'on';
	public $icon_path;
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
		// Module name & icon.
		$this->name      = esc_html__( 'Tutor Course Purchase', 'tutor-lms-divi-modules' );
		$this->icon_path = plugin_dir_path( __FILE__ ) . 'icon.svg';

		// Toggle settings
		// Toggles are grouped into array of tab name > toggles > toggle definition.
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content'  => esc_html__( 'Content', 'tutor-lms-divi-modules' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'enrollment_button'     => esc_html__( 'Enroll Button', 'tutor-lms-divi-modules' ),
					'add_to_cart_button'    => esc_html__( 'Add to Cart Button', 'tutor-lms-divi-modules' ),
					'start_continue_button' => esc_html__( 'Start/Continue/Retake Button', 'tutor-lms-divi-modules' ),
					'complete_course_btn'   => esc_html__( 'Complete Course Button', 'tutor-lms-divi-modules' ),
					'enrolled_text'         => esc_html__( 'Enrolled Text', 'tutor-lms-divi-modules' ),
					'enrolled_icon'         => esc_html__( 'Enrolled Icon', 'tutor-lms-divi-modules' ),
					'enrolled_date'         => esc_html__( 'Enrolled Date', 'tutor-lms-divi-modules' ),
					// course price advanced toggle.
					'course_price'          => esc_html__( 'Course Price', 'tutor-lms-divi-modules' ),
					'course_strike_price'   => esc_html__( 'Course Strike Price', 'tutor-lms-divi-modules' ),
					// course status toggles.
					'status_title'          => esc_html__( 'Progress Title', 'tutor-lms-divi-modules' ),
					'progress_bar'          => esc_html__( 'Progress Bar', 'tutor-lms-divi-modules' ),
					'status_text'           => esc_html__( 'Progress Text', 'tutor-lms-divi-modules' ),
					'enrollment_meta_info'  => esc_html__( 'Meta Info', 'tutor-lms-divi-modules' ),
				),
			),
		);

		// advanced fiedls settings.
		$this->advanced_fields = array(
			'fonts'      => array(
				'enrolled_date'              => array(
					// 'label'           => esc_html__( 'Text', 'tutor-lms-divi-modules' ),
					'css'             => array(
						'main' => '%%order_class%% .tutor-enrolled-info-date',
					),
					'hide_text_align' => true,
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'enrolled_date',
				),
				'enrollment_meta_info_label' => array(
					'label'           => esc_html__( 'Label', 'tutor-lms-divi-modules' ),
					'css'             => array(
						'main' =>  "%%order_class%% .tutor-card-footer .dtlms-enrollment-meta-label",
					),
					'hide_text_align' => true,
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'enrollment_meta_info',
				),
				'enrollment_meta_info_value' => array(
					'label'           => esc_html__( 'Value', 'tutor-lms-divi-modules' ),
					'css'             => array(
						'main' =>  "%%order_class%% .tutor-card-footer .dtlms-enrollment-meta-value, %%order_class%% .tutor-card-footer .dtlms-enrollment-meta-value .tutor-meta-value",
					),
					'hide_text_align' => true,
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'enrollment_meta_info',
				),
				'enrolled_text'            => array(
					'label'           => esc_html__( 'Value', 'tutor-lms-divi-modules' ),
					'css'             => array(
						'main' => '%%order_class%% .tutor-enrolled-info-text',
					),
					'hide_text_align' => true,
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'enrolled_text',
				),
				// course price font toggle.
				'course_price'               => array(
					// 'label'           => esc_html__( 'Course Price', 'tutor-lms-divi-modules' ),
					'css'             => array(
						'main' => '%%order_class%% .tutor-course-sidebar-card-pricing .tutor-color-black, %%order_class%% .tutor-course-single-pricing > .tutor-color-black',
					),
					'hide_text_align' => true,
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'course_price',
				),
				'course_strike_price'        => array(
					// 'label'           => esc_html__( 'Text', 'tutor-lms-divi-modules' ),
					'css'             => array(
						'main' => '%%order_class%% .tutor-course-sidebar-card-pricing del',
					),
					'hide_text_align' => true,
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'course_strike_price',
				),
				'status_title'               => array(
					'label'           => esc_html__( 'Status Title', 'tutor-lms-divi-modules' ),
					'css'             => array(
						'main' => '%%order_class%% .dtlms-course-progress',
					),
					'hide_text_align' => true,
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'status_title',
				),
				'status_text'                => array(
					'label'           => esc_html__( 'Status Text', 'tutor-lms-divi-modules' ),
					'css'             => array(
						'main' => '%%order_class%% .progress-steps, %%order_class%% .progress-percentage',
					),
					'hide_text_align' => true,
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'status_text',
				),
			),

			'button'     => array(
				'enrollment_button'     => array(
					'label'         => esc_html__( 'Enrollment Button', 'tutor-lms-divi-modules' ),
					'box_shadow'    => array(
						'css' => array(
							'main' => '%%order_class%% .tutor-course-sidebar-card-body .tutor-enroll-course-button',
						),
					),
					'css'           => array(
						'main' => '%%order_class%% .tutor-course-sidebar-card-body .tutor-enroll-course-button',
					),
					'use_alignment' => false,
					'tab_slug'      => 'advanced',
					'toggle_slug'   => 'enrollment_button',
					'show_if'       => array(
						'preview_mode' => 'enrollment',
					),
					'important'     => true,
					'hide_icon'     => true,
				),
				'add_to_cart_button'    => array(
					'label'         => esc_html__( 'Add to Cart Button', 'tutor-lms-divi-modules' ),
					'box_shadow'    => array(
						'css' => array(
							'main' => '%%order_class%% .tutor-btn-primary.tutor-add-to-cart-button',
						),
					),
					'css'           => array(
						'main' => '%%order_class%% .tutor-btn-primary.tutor-add-to-cart-button',
					),
					'use_alignment' => false,
					'tab_slug'      => 'advanced',
					'toggle_slug'   => 'add_to_cart_button',
					'show_if'       => array(
						'preview_mode' => 'enrollment',
					),
					'important'     => true,
					'hide_icon'     => true,
				),
				'start_continue_button' => array(
					'label'         => esc_html__( 'Start/Continue/Retake Button', 'tutor-lms-divi-modules' ),
					'box_shadow'    => array(
						'css' => array(
							'main' => '%%order_class%% .tutor-card .start-continue-retake-button',
						),
					),
					'use_borders'   => false,
					'css'           => array(
						'main' => '%%order_class%% .tutor-card .start-continue-retake-button',
					),
					'use_alignment' => false,
					'use_icon'      => false,
					'tab_slug'      => 'advanced',
					'toggle_slug'   => 'start_continue_button',
					'important'     => true,
					'hide_icon'     => true,
				),
				'complete_course_btn'   => array(
					'label'         => esc_html__( 'Complete Course Button', 'tutor-lms-divi-modules' ),
					'box_shadow'    => array(
						'css' => array(
							'main' => '%%order_class%% .tutor-card [name=complete_course_btn]',
						),
					),
					'use_borders'   => false,
					'css'           => array(
						'main' => '%%order_class%% .tutor-card [name=complete_course_btn]',
					),
					'use_alignment' => false,
					'use_icon'      => false,
					'tab_slug'      => 'advanced',
					'toggle_slug'   => 'complete_course_btn',
					'important'     => true,
					'hide_icon'     => true,
				),
			),
			'borders'    => array(
				'default' => array(
					'css'      => array(
						'main' => array(
							'border_styles' => "%%order_class%% .tutor-sidebar-card",
							'border_radii'  => "%%order_class%% .tutor-sidebar-card",
						),
					),
				),
			),
			'box_shadow' => array(
				'default' => array(
					'css' => array(
						'main' => "%%order_class%% .tutor-sidebar-card",
					),
				),
			),
			'text'       => false,
			'max_width'  => false,
			// 'margin_padding'  => false,
			// 'background'        => false,
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
			'course'                => Helper::get_field(
				array(
					'default'          => Helper::get_course_default(),
					'computed_affects' => array(
						'__enrollment',
					),
				)
			),
			'__enrollment'          => array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'CoursePurchase',
					'get_edit_template',
				),
				'computed_depends_on' => array(
					'course',
					'preview_mode',
					'course_progress_title',
					'course_purchase_enrolment_box',
				),
				'computed_minimum'    => array(
					'course',
					'preview_mode',
					'course_progress_title',
					'course_purchase_enrolment_box',
				),
			),
			// general tab main_content toggle.
			'enrollment_box_background' => array(
				'label'       => esc_html__( 'Enrollment Box', 'tutor-lms-divi-modules' ),
				'type'        => 'color-alpha',
				'default' 	  => '#F4F6F9',
				'toggle_slug' => 'main_content',
			),
			'preview_mode'          => array(
				'label'       => esc_html__( 'Preview Mode', 'tutor-lms-divi-modules' ),
				'type'        => 'select',
				'options'     => array(
					'enrollment' => esc_html__( 'Enrollment', 'tutor-lms-divi-modules' ),
					'enrolled'   => esc_html__( 'Enrolled', 'tutor-lms-divi-modules' ),
				),
				'default'     => 'enrollment',
				'toggle_slug' => 'main_content',
			),
			'course_purchase_enrolment_box' 	=> array(
				'label'       => esc_html__( 'Enrollment Box', 'tutor-lms-divi-modules' ),
				'type'        => 'yes_no_button',
				'options'     => array(
					'on'  => esc_html__( 'Show', 'tutor-lms-divi-modules' ),
					'off' => esc_html__( 'Hide', 'tutor-lms-divi-modules' ),
				),
				'default'     => 'on',
				'toggle_slug' => 'main_content',
			),
			// general tab course status controls.
			'course_progress_title' => array(
				'label'           => esc_html__( 'Progress Title', 'tutor-lms-divi-modules' ),
				'type'            => 'text',
				'default'         => esc_html__( 'Course Progress', 'tutor-lms-divi-modules' ),
				'option_category' => 'basic_option',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'main_content',
			),

			// advanced tab enrolled_info toggle.
			'icon_size'             => array(
				'label'          => esc_html__( 'Icon Size', 'tutor-lms-divi-modules' ),
				'type'           => 'range',
				'default'        => '24px',
				'default_unit'   => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'enrollment_meta_info',
				'mobile_options' => true,
			),
			'icon_color'            => array(
				'label'       => esc_html__( 'Icon Color', 'tutor-lms-divi-modules' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'enrollment_meta_info',
			),
			'enrolled_icon_size'    => array(
				'label'          => esc_html__( 'Icon Size', 'tutor-lms-divi-modules' ),
				'type'           => 'range',
				'default'        => '24px',
				'default_unit'   => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'enrolled_icon',
				'mobile_options' => true,
			),
			'enrolled_icon_color'   => array(
				'label'       => esc_html__( 'Icon Color', 'tutor-lms-divi-modules' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'enrolled_icon',
			),
			// advanced tab course status controls.
						// progress bar advanced tab
			'bar_color'             => array(
				'label'       => esc_html__( 'Color', 'tutor-lms-divi-modules' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'progress_bar',
			),
			'bar_background'        => array(
				'label'       => esc_html__( 'Background Color', 'tutor-lms-divi-modules' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'progress_bar',
			),
			'bar_height'            => array(
				'label'          => esc_html__( 'Height', 'tutor-lms-divi-modules' ),
				'type'           => 'range',
				'default_unit'   => 'px',
				'default'        => '7',
				'range_settings' => array(
					'min'  => 1,
					'max'  => 100,
					'step' => 1,
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'progress_bar',
			),
			'bar_radius'            => array(
				'label'          => esc_html__( 'Border Radius', 'tutor-lms-divi-modules' ),
				'type'           => 'range',
				'default_unit'   => 'px',
				'default'        => '30',
				'range_settings' => array(
					'min'  => 1,
					'max'  => 100,
					'step' => 1,
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'progress_bar',
			),
			'bar_gap'               => array(
				'label'          => esc_html__( 'Gap', 'tutor-lms-divi-modules' ),
				'type'           => 'range',
				'default_unit'   => 'px',
				'default'        => '10',
				'range_settings' => array(
					'min'  => 1,
					'max'  => 100,
					'step' => 1,
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'progress_bar',
			),
		);
	}
	/**
	 * Get props
	 *
	 * @since 1.0.0
	 * @return bool
	 */
	public static function get_edit_template( $args = array() ) {
		if ( isset( $args['course'] ) ) {
			ob_start();
			include dtlms_get_template( 'course/purchase-editor' );
			return apply_filters( 'dtlms_enrolment_editor_template', ob_get_clean() );
		}
	}

	/**
	 * Get content
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_content( $args = array() ) {
		ob_start();
		include dtlms_get_template( 'course/purchase' );
		return apply_filters( 'dtlms_enrollment_template', ob_get_clean() );
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
	public function render( $attrs, $content, $render_slug ) {

		// selectors.
		$three_buttons_wrapper = '%%order_class%% .tutor-lead-info-btn-group';
		$enroll_box_selector   = '%%order_class%% .tutor-course-enrollment-box';
		$wrapper               = '%%order_class%% .tutor-course-sidebar-card';

		// props.

		$icon_color       = sanitize_text_field( $this->props['icon_color'] );
		$icon_size        = sanitize_text_field( $this->props['icon_size'] );
		$icon_size_tablet = isset( $this->props['icon_size_tablet'] ) && $this->props['icon_size_tablet'] !== '' ? sanitize_text_field( $this->props['icon_size_tablet'] ) : $icon_size;
		$icon_size_phone  = isset( $this->props['icon_size_phone'] ) && $this->props['icon_size_phone'] !== '' ? sanitize_text_field( $this->props['icon_size_phone'] ) : $icon_size;

		$enrollment_box_background = $this->props['enrollment_box_background'];

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-card-body',
				'declaration' => sprintf(
					'background-color: %1$s;',
					$enrollment_box_background
				),
			)
		);
		// Borders default border style.
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-course-enrollment-box .tutor-btn-enroll,  %%order_class%% .tutor-course-enrollment-box .single_add_to_cart_button.tutor-button, %%order_class%% .tutor-lead-info-btn-group .tutor-button.tutor-success, %%order_class%% .tutor-course-compelte-form-wrap .course-complete-button, %%order_class%% .tutor-lead-info-btn-group .generate-course-gradebook-btn-wrap',
				'declaration' => 'border-style: solid;',
			)
		);

		// purchase icon style
		$course_info_wrapper = '%%order_class%% .tutor-course-sidebar-card-footer';
		if ( $icon_color !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    =>  "%%order_class%% .tutor-card-footer .dtlms-enrollment-meta-label",
					'declaration' => sprintf(
						'color: %1$s;',
						$icon_color
					),
				)
			);
		}

		if ( $icon_size !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "%%order_class%% .tutor-card-footer .dtlms-enrollment-meta-label",
					'declaration' => sprintf(
						'font-size: %1$s',
						$icon_size
					),
				)
			);
		}

		if ( $icon_size_tablet !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    =>  "%%order_class%% .tutor-card-footer .dtlms-enrollment-meta-label",
					'declaration' => sprintf(
						'font-size: %1$s',
						$icon_size_tablet
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);
		}

		if ( $icon_size_phone !== '' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    =>  "%%order_class%% .tutor-card-footer .dtlms-enrollment-meta-label",
					'declaration' => sprintf(
						'font-size: %1$s',
						$icon_size_phone
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		}
		$enrolled_icon_color = $this->props['enrolled_icon_color'];
		$enrolled_icon_size  = $this->props['enrolled_icon_size'];
		if ( '' !== $enrolled_icon_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-icon-purchase-mark',
					'declaration' => sprintf(
						'color: %1$s;',
						$enrolled_icon_color
					),
				)
			);
		}
		if ( '' !== $enrolled_icon_size ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-icon-purchase-mark',
					'declaration' => sprintf(
						'font-size: %1$s;',
						$enrolled_icon_size
					),
				)
			);
		}

		// button icon
		// add to cart button icon.
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-course-enrollment-box .single_add_to_cart_button.tutor-button:after',
				'declaration' => 'content: attr(data-icon);
                font-family: "ETmodules" !important;',
			)
		);
		// enroll now button icon.
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-course-enrollment-box .tutor-btn-enroll:after',
				'declaration' => 'content: attr(data-icon);
                font-family: "ETmodules" !important;',
			)
		);
		// start continue butto icon.
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-lead-info-btn-group .tutor-button.tutor-success:after',
				'declaration' => 'content: attr(data-icon);
                font-family: "ETmodules" !important;',
			)
		);
		// complete button icon.
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-course-compelte-form-wrap .course-complete-button:after',
				'declaration' => 'content: attr(data-icon);
                font-family: "ETmodules" !important;',
			)
		);
		// grade book button.
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-lead-info-btn-group .generate-course-gradebook-btn-wrap > .tutor-button:after',
				'declaration' => 'content: attr(data-icon);
                font-family: "ETmodules" !important;',
			)
		);

		// progress bar styles start.
		if ( '' !== $this->props['bar_height'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-progress-bar',
					'declaration' => sprintf(
						'height: %1$s;',
						$this->props['bar_height']
					),
				),
			);
		}
		if ( '' !== $this->props['bar_radius'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-progress-bar',
					'declaration' => sprintf(
						'border-radius: %1$s !important;',
						$this->props['bar_radius']
					),
				),
			);
		}
		if ( '' !== $this->props['bar_background'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-progress-bar',
					'declaration' => sprintf(
						'background-color: %1$s;',
						$this->props['bar_background']
					),
				),
			);
		}
		if ( '' !== $this->props['bar_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-progress-value',
					'declaration' => sprintf(
						'background-color: %1$s;',
						$this->props['bar_color']
					),
				),
			);
		}
		if ( '' !== $this->props['bar_gap'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-progress-bar',
					'declaration' => sprintf(
						'margin-top: %1$s;',
						$this->props['bar_gap']
					),
				),
			);
		}

		// progress bar styles start end.

		// set styles end

		$output = self::get_content( $this->props );
		if ( '' === $output ) {
			return '';
		}
		return $this->_render_module_wrapper( $output, $render_slug );
	}

}
new CoursePurchase();

