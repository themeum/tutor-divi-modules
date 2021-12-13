<?php

/**
 * Tutor Course Enrollment Module for Divi Builder
 *
 * @since 1.0.0
 * @author Themeum<www.themeum.com>
 */
use TutorLMS\Divi\Helper;

defined( 'ABSPATH' ) || exit;

class CourseEnrollment extends ET_Builder_Module {

	// Module slug (also used as shortcode tag)
	public $slug       = 'tutor_course_enrollment';
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
		// Module name & icon.
		$this->name      = esc_html__( 'Tutor Course Enrollment', 'tutor-lms-divi-modules' );
		$this->icon_path = plugin_dir_path( __FILE__ ) . 'icon.svg';

		// Toggle settings
		// Toggles are grouped into array of tab name > toggles > toggle definition.
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content'  => esc_html__( 'Content', 'tutor-lms-divi-modules' ),
					'customize_btn' => esc_html__( 'Button', 'tutor-lms-divi-modules' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'enrollment_button'     => esc_html__( 'Enroll Button', 'tutor-lms-divi-modules' ),
					'add_to_cart_button'    => esc_html__( 'Add to Cart Button', 'tutor-lms-divi-modules' ),
					'start_continue_button' => esc_html__( 'Start/Continue/Retake Button', 'tutor-lms-divi-modules' ),
					'complete_course_btn'   => esc_html__( 'Complete Course Button', 'tutor-lms-divi-modules' ),
					'enrolled_info'         => esc_html__( 'Enrolled Info', 'tutor-lms-divi-modules' ),
					// course status toggles.
					'status_title'          => esc_html__( 'Status Title', 'tutor-lms-divi-modules' ),
					'progress_bar'          => esc_html__( 'Progress Bar', 'tutor-lms-divi-modules' ),
					'status_text'           => esc_html__( 'Progress Text', 'tutor-lms-divi-modules' ),
				),
			),
		);

		// advanced fiedls settings.
		$this->advanced_fields = array(
			'fonts'      => array(

				'label_font' => array(
					'label'           => esc_html__( 'Label', 'tutor-lms-divi-modules' ),
					'css'             => array(
						'main' => '%%order_class%% .tutor-course-sidebar-card-footer span.text-regular-caption',
					),
					'hide_text_align' => true,
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'enrolled_info',
				),
				'text_font'  => array(
					'label'           => esc_html__( 'Text', 'tutor-lms-divi-modules' ),
					'css'             => array(
						'main' => '%%order_class%% .tutor-course-sidebar-card-footer span.text-medium-h6',
					),
					'hide_text_align' => true,
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'enrolled_info',
				),
				'status_title'  => array(
					'label'           => esc_html__( 'Status Title', 'tutor-lms-divi-modules' ),
					'css'             => array(
						'main' => '%%order_class%% .tutor-course-progress-wrapper .color-text-primary',
					),
					'hide_text_align' => true,
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'status_title',
				),
				'status_text'  => array(
					'label'           => esc_html__( 'Status Text', 'tutor-lms-divi-modules' ),
					'css'             => array(
						'main' => '%%order_class%% .progress-steps, %%order_class%% .progress-percentage'
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
							'main' => '%%order_class%% .tutor-enroll-course-button',
						),
					),
					'css'           => array(
						'main' => '%%order_class%% .tutor-enroll-course-button',
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
							'main' => '%%order_class%% .tutor-btn:not(.tutor-is-outline).tutor-btn-primary.tutor-add-to-cart-button',
						),
					),
					'css'           => array(
						'main' => '%%order_class%% .tutor-btn:not(.tutor-is-outline).tutor-btn-primary.tutor-add-to-cart-button',
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
							'main' => '%%order_class%% .',
						),
					),
					'use_borders'   => false,
					'css'           => array(
						'main' => '%%order_class%% .start-continue-retake-button',
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
							'main' => '%%order_class%% .',
						),
					),
					'use_borders'   => false,
					'css'           => array(
						'main' => '%%order_class%% .tutor-btn[name="complete_course_btn"]',
					),
					'use_alignment' => false,
					'use_icon'      => false,
					'tab_slug'      => 'advanced',
					'toggle_slug'   => 'complete_course_btn',
					'important'     => true,
					'hide_icon'     => true,
				),
			),
			'borders'    => false,
			'box_shadow' => false,
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
			'course'       => Helper::get_field(
				array(
					'default'          => Helper::get_course_default(),
					'computed_affects' => array(
						'__enrollment',
					),
				)
			),
			'__enrollment' => array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'CourseEnrollment',
					'get_edit_template',
				),
				'computed_depends_on' => array(
					'course',
					'preview_mode',
					'button_size',
				),
				'computed_minimum'    => array(
					'course',
				),
			),
			// general tab main_content toggle.
			'preview_mode' => array(
				'label'       => esc_html__( 'Preview Mode', 'tutor-lms-divi-modules' ),
				'type'        => 'select',
				'options'     => array(
					'enrollment' => esc_html__( 'Enrollment', 'tutor-lms-divi-modules' ),
					'enrolled'   => esc_html__( 'Enrolled', 'tutor-lms-divi-modules' ),
				),
				'default'     => 'enrollment',
				'toggle_slug' => 'main_content',
			),
			// general tab customize_btn toggle.
			'alignment'    => array(
				'label'           => esc_html__( 'Alignment', 'tutor-lms-divi-modules' ),
				'type'            => 'text_align',
				'option_category' => 'configuration',
				'options'         => et_builder_get_text_orientation_options( array( 'justified' ) ),
				'default'         => 'center',
				'toggle_slug'     => 'customize_btn',
				'mobile_options'  => true,
			),
			'button_size'  => array(
				'label'           => esc_html__( 'Size', 'tutor-lms-divi-modules' ),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options'         => array(
					'small'  => esc_html__( 'Small', 'tutor-lms-divi-modules' ),
					'medium' => esc_html__( 'Medium', 'tutor-lms-divi-modules' ),
					'large'  => esc_html__( 'Large', 'tutor-lms-divi-modules' ),
				),
				'default'         => 'medium',
				'toggle_slug'     => 'customize_btn',
			),
			'btn_width'    => array(
				'label'           => esc_html__( 'Width', 'tutor-lms-divi-modules' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'auto'  => esc_html__( 'Auto', 'tutor-lms-divi-modules' ),
					'fill'  => esc_html__( 'Fill', 'tutor-lms-divi-modules' ),
					'fixed' => esc_html__( 'Fixed', 'tutor-lms-divi-modules' ),
				),
				'default'         => 'fill',
				'toggle_slug'     => 'customize_btn',
			),
			'width_px'     => array(
				'label'          => esc_html__( 'Button Width', 'tutor-lms-divi-modules' ),
				'type'           => 'range',
				'default'        => '150px',
				'default_unit'   => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '500',
					'step' => '1',
				),
				'tab_slug'       => 'general',
				'toggle_slug'    => 'customize_btn',

				'show_if'        => array(
					'btn_width' => 'fixed',
				),
			),
			// general tab course status controls.
			'status_label' => array(
				'label'           => esc_html__( 'Label', 'tutor-lms-divi-modules' ),
				'type'            => 'text',
				'default'         => esc_html__( 'Course Status', 'tutor-lms-divi-modules' ),
				'option_category' => 'basic_option',
				'tab_slug'     	=> 'general',
				'toggle_slug'	=> 'main_content',
				'show_if'         => array(
					'preview_mode' => 'enrolled',
				),
			),

			// advanced tab enrolled_info toggle.
			'icon_size'    => array(
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
				'toggle_slug'    => 'enrolled_info',
				'mobile_options' => true,
			),
			'icon_color'   => array(
				'label'       => esc_html__( 'Icon Color', 'tutor-lms-divi-modules' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'enrolled_info',
			),
			// advanced tab course status controls.
						//progress bar advanced tab
			'bar_color'			=> array(
				'label'			=> esc_html__( 'Color', 'tutor-lms-divi-modules'),
				'type'			=> 'color-alpha',
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'progress_bar'
			),
			'bar_background'	=> array(
				'label'			=> esc_html__( 'Background Color', 'tutor-lms-divi-modules'),
				'type'			=> 'color-alpha',
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'progress_bar'
			),
			'bar_height'		=> array(
				'label'			=> esc_html__( 'Height', 'tutor-lms-divi-modules'),
				'type'			=> 'range',
				'default_unit'	=> 'px',
				'default'		=> '15',
				'range_settings'=> array(
					'min'	=> 1,
					'max'	=> 100,
					'step'	=> 1
				),
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'progress_bar'				
			),
			'bar_radius'		=> array(
				'label'			=> esc_html__( 'Border Radius', 'tutor-lms-divi-modules'),
				'type'			=> 'range',
				'default_unit'	=> 'px',
				'default'		=> '30',
				'range_settings'=> array(
					'min'	=> 1,
					'max'	=> 100,
					'step'	=> 1
				),
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'progress_bar'				
			),
			'gap'		=> array(
				'label'			=> esc_html__( 'Gap', 'tutor-lms-divi-modules'),
				'type'			=> 'range',
				'default_unit'	=> 'px',
				'default'		=> '10',
				'range_settings'=> array(
					'min'	=> 1,
					'max'	=> 100,
					'step'	=> 1
				),
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'progress_bar',
				'mobile_options'=> true				
			),
			// progress bar advanced tab.
			'bar_color'			=> array(
				'label'			=> esc_html__( 'Color', 'tutor-lms-divi-modules'),
				'type'			=> 'color-alpha',
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'progress_bar'
			),
			'bar_background'	=> array(
				'label'			=> esc_html__( 'Background Color', 'tutor-lms-divi-modules'),
				'type'			=> 'color-alpha',
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'progress_bar'
			),
			'bar_height'		=> array(
				'label'			=> esc_html__( 'Height', 'tutor-lms-divi-modules'),
				'type'			=> 'range',
				'default_unit'	=> 'px',
				'default'		=> '15',
				'range_settings'=> array(
					'min'	=> 1,
					'max'	=> 100,
					'step'	=> 1
				),
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'progress_bar'				
			),
			'bar_radius'		=> array(
				'label'			=> esc_html__( 'Border Radius', 'tutor-lms-divi-modules'),
				'type'			=> 'range',
				'default_unit'	=> 'px',
				'default'		=> '30',
				'range_settings'=> array(
					'min'	=> 1,
					'max'	=> 100,
					'step'	=> 1
				),
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'progress_bar'				
			),
			'gap'		=> array(
				'label'			=> esc_html__( 'Gap', 'tutor-lms-divi-modules'),
				'type'			=> 'range',
				'default_unit'	=> 'px',
				'default'		=> '10',
				'range_settings'=> array(
					'min'	=> 1,
					'max'	=> 100,
					'step'	=> 1
				),
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'progress_bar',
				'mobile_options'=> true				
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
			include dtlms_get_template( 'course/enrolment-editor' );
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
		include tutor()->path . 'templates/single/course/course-entry-box.php';
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

		// selectors
		$three_buttons_wrapper = '%%order_class%% .tutor-lead-info-btn-group';
		$enroll_box_selector   = '%%order_class%% .tutor-course-enrollment-box';
		$wrapper               = '%%order_class%% .tutor-course-sidebar-card';

		// props
		$alignment = sanitize_text_field( $this->props['alignment'] );

		$alignment_tablet = isset( $this->props['alignment_tablet'] ) && $this->props['alignment_tablet'] !== '' ? sanitize_text_field( $this->props['alignment_tablet'] ) : $alignment;
		$alignment_phone  = isset( $this->props['alignment_phone'] ) && $this->props['alignment_phone'] !== '' ? sanitize_text_field( $this->props['alignment_phone'] ) : $alignment;

		$alignment        = ( $alignment === 'left' ? 'flex-start' : ( $alignment === 'right' ? 'flex-end' : 'center' ) );
		$alignment_tablet = ( $alignment_tablet === 'left' ? 'flex-start' : ( $alignment_tablet === 'right' ? 'flex-end' : 'center' ) );
		$alignment_phone  = ( $alignment_phone === 'left' ? 'flex-start' : ( $alignment_phone === 'right' ? 'flex-end' : 'center' ) );

		$width       = sanitize_text_field( $this->props['btn_width'] );
		$width_px    = sanitize_text_field( $this->props['width_px'] );
		$button_size = sanitize_text_field( $this->props['button_size'] );

		$icon_color       = sanitize_text_field( $this->props['icon_color'] );
		$icon_size        = sanitize_text_field( $this->props['icon_size'] );
		$icon_size_tablet = isset( $this->props['icon_size_tablet'] ) && $this->props['icon_size_tablet'] !== '' ? sanitize_text_field( $this->props['icon_size_tablet'] ) : $icon_size;
		$icon_size_phone  = isset( $this->props['icon_size_phone'] ) && $this->props['icon_size_phone'] !== '' ? sanitize_text_field( $this->props['icon_size_phone'] ) : $icon_size;

		// Apply default css.
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => $wrapper . ' .tutor-course-sidebar-card-body.tutor-p-30',
				'declaration' => sprintf(
					'display:flex; flex-direction: column; row-gap: 10px;',
					$alignment
				),
			)
		);
		// alignment styles.
		if ( $alignment !== '' ) {
			// button alignment for all button
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $wrapper . ' .tutor-course-sidebar-card-body.tutor-p-30',
					'declaration' => sprintf(
						'align-items: %1$s;',
						$alignment
					),
				)
			);
		}

		if ( $alignment_tablet !== '' ) {
			// enrolled_box style.
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $wrapper . ' .tutor-course-sidebar-card-body.tutor-p-30',
					'declaration' => sprintf(
						'align-items: %1$s;',
						$alignment_tablet
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);
		}
		if ( $alignment_phone !== '' ) {
			// enrolled_box style.
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $wrapper . ' .tutor-course-sidebar-card-body.tutor-p-30',
					'declaration' => sprintf(
						'align-items: %1$s;',
						$alignment
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		}
		// btn width.
		if ( $width === 'fill' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "$wrapper .tutor-course-sidebar-card-btns, $wrapper .tutor-course-sidebar-card-body form",
					'declaration' => 'width: 100%;',
				)
			);
		} elseif ( $width === 'auto' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $wrapper . ' .tutor-btn',
					'declaration' => 'width: auto !important;',
				)
			);
		} else {
			if ( $width !== '' ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => $wrapper . ' .tutor-btn',
						'declaration' => sprintf(
							'width: %1$s !important;',
							$width_px
						),
					)
				);
			}
		}
		// button size style.
		if ( $button_size === 'small' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $wrapper . ' .tutor-btn',
					'declaration' => 'padding: 9px 14px !important;',
				)
			);
		} elseif ( $button_size === 'large' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $wrapper . ' .tutor-btn',
					'declaration' => 'padding: 18px !important;',
				)
			);
		}

		// boders default border style
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
					'selector'    => "$course_info_wrapper span.tutor-icon-24",
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
					'selector'    => "$course_info_wrapper span.tutor-icon-24",
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
					'selector'    => "$course_info_wrapper span.tutor-icon-24",
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
					'selector'    => "$course_info_wrapper span.tutor-icon-24",
					'declaration' => sprintf(
						'font-size: %1$s',
						$icon_size_phone
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		}

		// button icon
		// add to cart button icon
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-course-enrollment-box .single_add_to_cart_button.tutor-button:after',
				'declaration' => 'content: attr(data-icon);
                font-family: "ETmodules" !important;',
			)
		);
		// enroll now button icon
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-course-enrollment-box .tutor-btn-enroll:after',
				'declaration' => 'content: attr(data-icon);
                font-family: "ETmodules" !important;',
			)
		);
		// start continue butto icon
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-lead-info-btn-group .tutor-button.tutor-success:after',
				'declaration' => 'content: attr(data-icon);
                font-family: "ETmodules" !important;',
			)
		);
		// complete button icon
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-course-compelte-form-wrap .course-complete-button:after',
				'declaration' => 'content: attr(data-icon);
                font-family: "ETmodules" !important;',
			)
		);
		// grade book button
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-lead-info-btn-group .generate-course-gradebook-btn-wrap > .tutor-button:after',
				'declaration' => 'content: attr(data-icon);
                font-family: "ETmodules" !important;',
			)
		);

		// set styles end

		$output = self::get_content( $this->props );
		if ( '' === $output ) {
			return '';
		}
		return $this->_render_module_wrapper( $output, $render_slug );
	}

}
new CourseEnrollment();

