<?php

/**
 * Tutor Course Share Module for Divi Builder
 *
 * @package  DTLMSCourseShare
 * @since 1.0.0
 * @author Themeum<www.themeum.com>
 */

use TutorLMS\Divi\Helper;

defined( 'ABSPATH' ) || exit;

class TutorCourseShare extends ET_Builder_Module {
	// Module slug (also used as shortcode tag)
	public $slug       = 'tutor_course_share';
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
		$this->name      = esc_html__( 'Tutor Course Share', 'tutor-lms-divi-modules' );
		$this->icon_path = plugin_dir_path( __FILE__ ) . 'icon.svg';

		// Toggle settings
		// Toggles are grouped into array of tab name > toggles > toggle definition.
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Content', 'tutor-lms-divi-modules' ),
					'share_popup'  => esc_html__( 'Share Popup', 'tutor-lms-divi-modules' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'label'               => array(
						'title' => esc_html__( 'Share Label & Icon', 'tutor-lms-divi-modules' ),
					),
					'popup_section_title' => array(
						'title' => esc_html__( 'Popup Section Title', 'tutor-lms-divi-modules' ),
					),
					'popup_share_title'   => array(
						'title' => esc_html__( 'Popup Share Title', 'tutor-lms-divi-modules' ),
					),
					'popup_share_link'    => array(
						'title' => esc_html__( 'Popup Share Link', 'tutor-lms-divi-modules' ),
					),
					'social_buttons'      => array(
						'title' => esc_html__( 'Social Buttons', 'tutor-lms-divi-modules' ),
					),
					'close_button'        => array(
						'title' => esc_html__( 'Close Button', 'tutor-lms-divi-modules' ),
					),
				),
			),
		);

		$wrapper       = '%%order_class%% .dtlms-course-share a';
		$popup_wrapper = '%%order_class%% .tutor-modal-body.etlms-course-share-popup';

		$this->advanced_fields = array(
			'fonts'      => array(
				'share_label'            => array(
					'label'           => esc_html__( 'Share Label', 'tutor-lms-divi-modules' ),
					'css'             => array(
						'main' => "%%order_class%% .tutor-icon-share",
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'label',
					'hide_text_align' => true,
				),
				'share_icon'             => array(
					'label'           => esc_html__( 'Share Icon', 'tutor-lms-divi-modules' ),
					'css'             => array(
						'main' => "%%order_class%% .dtlms-course-share-label",
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'label',
					'hide_text_align' => true,
				),
				'popup_section_title'    => array(
					'label'           => esc_html__( 'Popup Section Title', 'tutor-lms-divi-modules' ),
					'css'             => array(
						'main' => "%%order_class%% .dtlms-course-share-modal-title",
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'popup_section_title',
					'hide_text_align' => true,
				),
				'popup_share_title'      => array(
					'label'           => esc_html__( 'Popup Share Title', 'tutor-lms-divi-modules' ),
					'css'             => array(
						'main' => "%%order_class%% .dtlms-course-share-modal-link",
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'popup_share_title',
					'hide_text_align' => true,
				),
				'popup_share_link'       => array(
					'label'           => esc_html__( 'Popup Share Input', 'tutor-lms-divi-modules' ),
					'css'             => array(
						'main' => "%%order_class%% .tutor-modal-body .tutor-form-control",
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'popup_share_link',
					'hide_text_align' => true,
				),
				'popup_share_link_title' => array(
					'label'           => esc_html__( 'Popup Share Link Title', 'tutor-lms-divi-modules' ),
					'css'             => array(
						'main' => "%%order_class%% .dtlms-course-share-modal-sub-title",
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'popup_share_link',
					'hide_text_align' => true,
				),
				'social_buttons_icon'    => array(
					'label'           => esc_html__( 'Icon', 'tutor-lms-divi-modules' ),
					'css'             => array(
						'main' => "%%order_class%% .tutor-social-share-button .social-icon",
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'social_buttons',
					'hide_text_align' => true,
				),
				'social_buttons_text'    => array(
					'label'           => esc_html__( 'Text', 'tutor-lms-divi-modules' ),
					'css'             => array(
						'main' => "%%order_class%% .tutor-social-share-button span:nth-child(2)",
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'social_buttons',
					'hide_text_align' => true,
				),
			),
			'background' => array(
				'label'                => esc_html__( 'Popup Background', 'tutor-lms-divi-modules' ),
				'css'                  => array(
					'main'      => '%%order_class%% .tutor-modal-content-white',
					'important' => true,
				),
				'settings'             => array(
					'tab_slug' => 'advanced',
				),
				'use_background_video' => false,
			),
			'button'     => false,
			'borders'    => array(
				'default' => array(
					'label_prefix' => esc_html__( 'Popup', 'et_builder' ),
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .tutor-modal-content-white',
							'border_styles' => '%%order_class%% .tutor-modal-content-white',
						),
					),
					'tab_slug'     => 'advanced',
				),
				'link_input_border'     => array(
					'label_prefix' => esc_html__( 'Input', 'et_builder' ),
					'css'          => array(
						'main' => array(
							'border_radii'  => "%%order_class%% .tutor-modal-body .tutor-form-control",
							'border_styles' => "$popup_wrapper input",
						),
					),
					'important'    => true,
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'popup_share_link',
				),
				'social_buttons_border' => array(
					'css'         => array(
						'main' => array(
							'border_radii'  => "%%order_class%% .tutor-social-share-button",
							'border_styles' => "%%order_class%% .tutor-social-share-button",
						),
					),
					'important'   => true,
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'social_buttons',
				),
			),
			'text'       => false,
			'max_width'  => false,

			// 'filters'     => false,
			// 'animation'       => false,
			// 'box_shadow'  => false,
			// 'transform'       => false
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
		$fields = array(
			'course'                 => Helper::get_field(
				array(
					'default'          => Helper::get_course_default(),
					'computed_affects' => array(
						'__share',
					),
				)
			),
			'__share'                => array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'TutorCourseShare',
					'get_content',
				),
				'computed_depends_on' => array(
					'course',
					'label',
					'course_share_text_show',
					'course_share_icon_show',
					'popup_section_title',
					'popup_share_title',
					'show_social_icon',
					'show_social_text',
				),
				'computed_minimum'    => array(
					'course',
					'label',
					'course_share_text_show',
					'course_share_icon_show',
					'popup_section_title',
					'popup_share_title',
					'show_social_icon',
					'show_social_text',
				),
			),
			// general settings tab main_content toggle
			'label'                  => array(
				'label'       => esc_html__( 'Label', 'tutor-lms-divi-modules' ),
				'type'        => 'text',
				'toggle_slug' => 'main_content',
				'default'     => esc_html__( 'Share', 'tutor-lms-divi-modules' ),
			),
			'course_share_text_show' => array(
				'label'            => esc_html__( 'Show Label', 'tutor-lms-divi-modules' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'off' => esc_html__( 'Hide', 'tutor-lms-divi-modules' ),
					'on'  => esc_html__( 'Show', 'tutor-lms-divi-modules' ),
				),
				'default_on_front' => 'on',
				'toggle_slug'      => 'main_content',
			),
			'course_share_icon_show' => array(
				'label'            => esc_html__( 'Show Icon', 'tutor-lms-divi-modules' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'off' => esc_html__( 'Hide', 'tutor-lms-divi-modules' ),
					'on'  => esc_html__( 'Show', 'tutor-lms-divi-modules' ),
				),
				'default_on_front' => 'on',
				'toggle_slug'      => 'main_content',
			),
			'alignment'              => array(
				'label'           => esc_html__( 'Alignment', 'tutor-lms-divi-modules' ),
				'type'            => 'text_align',
				'option_category' => 'configuration',
				'options'         => et_builder_get_text_orientation_options( array( 'justified' ) ),
				'default'         => 'left',
				'toggle_slug'     => 'main_content',
				'mobile_options'  => true,
			),
			'space_between'          => array(
				'label'           => esc_html__( 'Space Between', 'tutor-lms-divi-modules' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'default_unit'    => 'px',
				'default'         => '2px',
				'range_settings'  => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'toggle_slug'     => 'main_content',
				'show_if'         => array(
					'course_share_icon_show' => 'on',
					'course_share_text_show' => 'on',
				),
				'mobile_options'  => true,
			),
			// share popup content controls.
			'popup_section_title'    => array(
				'label'       => esc_html__( 'Section', 'tutor-lms-divi-modules' ),
				'type'        => 'text',
				'toggle_slug' => 'share_popup',
				'default'     => esc_html__( 'Share Course', 'tutor-lms-divi-modules' ),
			),
			'popup_share_title'      => array(
				'label'       => esc_html__( 'Share Title', 'tutor-lms-divi-modules' ),
				'type'        => 'text',
				'toggle_slug' => 'share_popup',
				'default'     => esc_html__( 'Share Course', 'tutor-lms-divi-modules' ),
			),
			'show_social_icon'       => array(
				'label'            => esc_html__( 'Social Icon', 'tutor-lms-divi-modules' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'off' => esc_html__( 'Hide', 'tutor-lms-divi-modules' ),
					'on'  => esc_html__( 'Show', 'tutor-lms-divi-modules' ),
				),
				'default_on_front' => 'on',
				'toggle_slug'      => 'share_popup',
			),
			'show_social_text'       => array(
				'label'            => esc_html__( 'Social Text', 'tutor-lms-divi-modules' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'off' => esc_html__( 'Hide', 'tutor-lms-divi-modules' ),
					'on'  => esc_html__( 'Show', 'tutor-lms-divi-modules' ),
				),
				'default_on_front' => 'on',
				'toggle_slug'      => 'share_popup',
			),
			'social_icon_background' => array(
				'label'       => esc_html__( 'Background Color', 'tutor-lms-divi-modules' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'social_buttons',
			),
			'close_button_color'     => array(
				'label'       => esc_html__( 'Color', 'tutor-lms-divi-modules' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'close_button',
			),
			'close_button_size'      => array(
				'label'           => esc_html__( 'Size', 'tutor-lms-divi-modules' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'default_unit'    => 'px',
				'default'         => '30px',
				'range_settings'  => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'close_button',
			),
		);

		return $fields;
	}

	/**
	 * computed value
	 *
	 * @return string | array course level
	 */
	public static function get_props( $args = array() ) {
		$course_id       = $args['course'];
		$is_enable_share = get_tutor_option( 'disable_course_share' );
		$share_icons     = tutils()->tutor_social_share_icons();

		$props = array(
			'is_enable_share' => $is_enable_share,
			'social_icon'     => $share_icons,
		);

		return $props;
	}

	/**
	 * Get the tutor course author
	 *
	 * @return string
	 */
	public static function get_content( $args = array() ) {
		ob_start();
		include_once dtlms_get_template( 'course/share' );
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
	public function render( $attrs, $content, $render_slug ) {
		$wrapper_selector = '%%order_class%% .dtlms-course-share a';

		$alignment        = $this->props['alignment'];
		$alignment_tablet = isset( $this->props['alignment_tablet'] ) ? $this->props['alignment_tablet'] : $alignment;
		$alignment_phone  = isset( $this->props['alignment_phone'] ) ? $this->props['alignment_phone'] : $alignment;

		$space_between        = $this->props['space_between'];
		$space_between_tablet = isset( $this->props['space_between_tablet'] ) ? $this->props['space_between_tablet'] : $space_between;
		$space_between_phone  = isset( $this->props['space_between_phone'] ) ? $this->props['space_between_phone'] : $space_between;

		// style .
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => $wrapper_selector,
				'declaration' => 'display: flex; align-items: center;',
			)
		);

		if ( $alignment ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $wrapper_selector,
					'declaration' => sprintf(
						'justify-content: %1$s;',
						$alignment
					),
				)
			);
		}
		if ( $alignment_tablet ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $wrapper_selector,
					'declaration' => sprintf(
						'justify-content: %1$s;',
						$alignment_tablet
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);
		}
		if ( $alignment_phone ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $wrapper_selector,
					'declaration' => sprintf(
						'justify-content: %1$s;',
						$alignment_phone
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		}

		if ( $space_between ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $wrapper_selector,
					'declaration' => sprintf(
						'column-gap: %1$s;',
						$space_between
					),
				)
			);
		}
		if ( $space_between_tablet ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $wrapper_selector,
					'declaration' => sprintf(
						'column-gap: %1$s;',
						$space_between_tablet
					),
				)
			);
		}
		if ( $space_between_phone ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $wrapper_selector,
					'declaration' => sprintf(
						'column-gap: %1$s;',
						$space_between_phone
					),
				)
			);
		}
		$social_icon_background = $this->props['social_icon_background'];
		$close_button_color     = $this->props['close_button_color'];
		$close_button_size      = $this->props['close_button_size'];

		if ( $social_icon_background ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-social-share-button',
					'declaration' => sprintf(
						'background-color: %1$s;',
						$social_icon_background
					),
				)
			);
		}
		if ( $close_button_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-iconic-btn',
					'declaration' => sprintf(
						'color: %1$s !important;',
						$close_button_color
					),
				)
			);
		}
		if ( $close_button_size ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-iconic-btn',
					'declaration' => sprintf(
						'font-size: %1$s !important;',
						$close_button_size
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

new TutorCourseShare();
