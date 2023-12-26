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
					'enrolled_text'         => esc_html__( 'Enrolled Text', 'tutor-lms-divi-modules' ),
					'enrolled_icon'         => esc_html__( 'Enrolled Icon', 'tutor-lms-divi-modules' ),
					'enrolled_date'         => esc_html__( 'Enrolled Date', 'tutor-lms-divi-modules' ),
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
						'main' => '%%order_class%% .tutor-card-footer .dtlms-enrollment-meta-label',
					),
					'hide_text_align' => true,
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'enrollment_meta_info',
				),
				'enrollment_meta_info_value' => array(
					'label'           => esc_html__( 'Value', 'tutor-lms-divi-modules' ),
					'css'             => array(
						'main' => '%%order_class%% .tutor-card-footer .dtlms-enrollment-meta-value, %%order_class%% .tutor-card-footer .dtlms-enrollment-meta-value .tutor-meta-value',
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
							'main' => '%%order_class%% .',
						),
					),
					'use_borders'   => false,
					'css'           => array(
						'main' => '%%order_class%% .start-continue-retake-button, %%order_class%% [value=complete_course]',
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
			//'filters'    => false,
			//'animation'  => false,
			//'transform'  => false,
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
					'alignment',
					'btn_width',
					'enrollment_box'
				),
				'computed_minimum'    => array(
					'course',
					'preview_mode',
					'button_size',
					'alignment',
					'btn_width',
					'enrollment_box'
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
			'enrollment_box' => array(
				'label'       => esc_html__( 'Enrollment Box', 'tutor-lms-divi-modules' ),
				'type'        => 'yes_no_button',
				'options'     => array(
					'on'  => esc_html__( 'Show', 'tutor-lms-divi-modules' ),
					'off' => esc_html__( 'Hide', 'tutor-lms-divi-modules' ),
				),
				'default'     => 'on',
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
				'toggle_slug'    => 'enrollment_meta_info',
				'mobile_options' => true,
			),
			'icon_color'   => array(
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
		include dtlms_get_template( 'course.enrolment' );
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
		$wrapper               = '%%order_class%% .tutor-sidebar-card ';

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

		// alignment styles.
		if ( $alignment !== '' ) {
			// button alignment for all button
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector' 		=> '%%order_class%% .dtlms-enroll-btn-width-auto .tutor-card-body',
					'declaration' 	=> sprintf(
						'text-align: %1$s !important;',
						$alignment
					)
				)
			);
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector' 		=> '%%order_class%% .dtlms-enroll-btn-width-auto form',
					'declaration' 	=> sprintf(
						'display: inline-flex !important;'
					),
				)
			);
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector' 		=> '%%order_class%% .tutor-btn',
					'declaration' 	=> sprintf(
						'display: inline-flex !important;'
					),
				)
			);
		}

		if ( $alignment_tablet !== '' ) {
			// enrolled_box style.
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector' 		=> '%%order_class%% .dtlms-enroll-btn-width-auto .tutor-card-body',
					'declaration' 	=> sprintf(
						'text-align: %1$s !important;',
						$alignment_tablet
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector' 		=> '%%order_class%% .dtlms-enroll-btn-width-auto form',
					'declaration' 	=> sprintf(
						'display: inline-flex !important;'
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector' 		=> '%%order_class%% .tutor-btn',
					'declaration' 	=> sprintf(
						'display: inline-flex !important;'
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
					'selector' 		=> '%%order_class%% .dtlms-enroll-btn-width-auto .tutor-card-body',
					'declaration' 	=> sprintf(
						'text-align: %1$s !important;',
						$alignment_phone
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector' 		=> '%%order_class%% .dtlms-enroll-btn-width-auto form',
					'declaration' 	=> sprintf(
						'display: inline-flex !important;'
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector' 		=> '%%order_class%% .tutor-btn',
					'declaration' 	=> sprintf(
						'display: inline-flex !important;'
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		}

		if ( 'enrolled' === $this->props['preview_mode'] || tutor_utils()->is_enrolled( $this->props['course'], get_current_user_id() ) ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '.dtlms-enroll-btn-width-auto .tutor-course-sidebar-card-body:not(.tutor-course-progress-wrapper)',
					'declaration' 	=> 'display: flex; flex-direction: column;', 
				)
			);
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '.dtlms-enroll-btn-align-left .tutor-course-sidebar-card-body:not(.tutor-course-progress-wrapper)',
					'declaration' 	=> 'align-items: flex-start;', 
				)
			);
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '.dtlms-enroll-btn-align-center .tutor-course-sidebar-card-body:not(.tutor-course-progress-wrapper)',
					'declaration' 	=> 'align-items: center;', 
				)
			);
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '.dtlms-enroll-btn-align-right .tutor-course-sidebar-card-body:not(.tutor-course-progress-wrapper)',
					'declaration' 	=> 'align-items: flex-end;',
				)
			);
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '%%order_class%% .dtlms-enroll-btn-width-auto form',
					'declaration' 	=> 'display: flex; flex-direction: column;',
				)
			);
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '%%order_class%% .dtlms-enroll-btn-align-left form, ',
					'declaration' 	=> 'align-items: flex-start;',
				)
			);
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '%%order_class%% .dtlms-enroll-btn-align-right form, ',
					'declaration' 	=> 'align-items: flex-end;',
				)
			);
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '%%order_class%% .dtlms-enroll-btn-align-center form, ',
					'declaration' 	=> 'align-items: center;',
				)
			);
		}

		// btn width.
		if ( $width === 'fill' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-course-sidebar-card-btns, %%order_class%% .tutor-course-sidebar-card-body form',
					'declaration' => 'width: 100%;',
				)
			);
		} elseif ( $width === 'auto' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dtlms-enroll-btn-width-auto .tutor-btn',
					'declaration' => 'width: auto !important; display: inline-flex !important;',
				)
			);
		} else {
			if ( $width !== '' ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    =>  '%%order_class%% button, %%order_class%% .tutor-button, %%order_class%% .start-continue-retake-button',
						'declaration' => sprintf(
							'width: %1$s !important;',
							$width_px
						),
					)
				);
			}
		}
		// button size style.
		if ( $button_size === 'large' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    =>  '%%order_class%% .dtlms-enroll-btn-size-large .tutor-btn',
					'declaration' => 'font-size: 18px; padding: 10px 20px;',
				)
			);
		} elseif ( $button_size === 'small' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    =>  '%%order_class%% .dtlms-enroll-btn-size-small .tutor-btn',
					'declaration' => 'font-size: 14px; padding: 5px 12px;'
				)
			);
		}

		// borders default border style.
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-course-enrollment-box .tutor-btn-enroll,  %%order_class%% .tutor-course-enrollment-box .single_add_to_cart_button.tutor-button, %%order_class%% .tutor-lead-info-btn-group .tutor-button.tutor-success, %%order_class%% .tutor-course-compelte-form-wrap .course-complete-button, %%order_class%% .tutor-lead-info-btn-group .generate-course-gradebook-btn-wrap',
				'declaration' => 'border-style: solid;',
			)
		);

		// purchase icon style.
		if ( '' !== $icon_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => "%%order_class%% .tutor-card-footer .dtlms-enrollment-meta-label",
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
					'selector'    => "%%order_class%% .tutor-card-footer .dtlms-enrollment-meta-label",					'declaration' => sprintf(
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
					'selector'    => "%%order_class%% .tutor-card-footer .dtlms-enrollment-meta-label",
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
		// set styles end

		$output = self::get_content( $this->props );
		if ( '' === $output ) {
			return '';
		}
		return $this->_render_module_wrapper( $output, $render_slug );
	}

}
new CourseEnrollment();

