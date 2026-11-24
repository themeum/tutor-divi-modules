<?php

/**
 * Tutor Course Tags Module for Divi Builder
 *
 * @since 1.0.0
 * @author Themeum<www.themeum.com>
 */

use TutorLMS\Divi\Helper;

defined( 'ABSPATH' ) || exit;

class CourseTags extends ET_Builder_Module {

	// Module slug (also used as shortcode tag)
	public $slug       = 'tutor_course_tags';
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
		$this->name      = esc_html__( 'Tutor Course Tags', 'tutor-lms-divi-modules' );
		$this->icon_path = plugin_dir_path( __FILE__ ) . 'icon.svg';

		/**
		 * settings toggles
		 * set all the toggles that will show in different tabs
		 */
		$this->settings_modal_toggles = array(
			'general'  => array(),
			'advanced' => array(
				'toggles' => array(
					'title' => array(
						'title' => esc_html__( 'Section Title', 'tutor-lms-divi-modules' ),
					),
					'tags'  => array(
						'title' => esc_html__( 'Tags', 'tutor-lms-divi-modules' ),
					),
				),
			),
		);

		/**
		 * advanced tabs settings
		 */
		$wrapper            = '%%order_class%% .tutor-divi-course-tags-wrapper';
		$tag_title_selector = $wrapper . ' .tutor-segment-title';
		$tags_selector      = $wrapper . ' .tutor-tag-list a';

		$this->advanced_fields = array(
			'fonts'          => array(
				'title' => array(
					'css'             => array(
						'main' => $tag_title_selector,
					),
					'hide_text_align' => true,
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'title',
				),
				'tags'  => array(
					'css'             => array(
						'main' => $tags_selector,
					),
					'hide_text_align' => true,
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'tags',
				),
			),

			'borders'        => array(
				'default' => false,
				'tags'    => array(
					'css'         => array(
						'main'      => array(
							'border_styles' => '%%order_class%% .tutor-divi-course-tags-wrapper .tutor-tag-list > a',
							'border_radii'  => '%%order_class%% .tutor-divi-course-tags-wrapper .tutor-tag-list > a',
						),
						'important' => true,
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'tags',
				),
			),
			'margin_padding' => array(
				'css' => array(
					'margin'    => '%%order_class%% .tutor-divi-course-tags-wrapper .tutor-tag-list a',
					'padding'   => '%%order_class%% .tutor-divi-course-tags-wrapper .tutor-tag-list a',
					'important' => 'all',
				),
			),
			'box_shadow'     => array(
				'default' => array(
					'css' => array(
						'main' => '%%order_class%% .tutor-divi-course-tags-wrapper .tutor-tag-list a',
					),
				),
			),
			'background'     => false,
			'text'           => false,
			'max_width'      => false,
			'transform'      => false,
			'animation'      => false,
			'filters'        => false,
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
			'course'          => Helper::get_field(
				array(
					'default'          => Helper::get_course_default(),
					'computed_affects' => array(
						'__share',
					),
				)
			),
			'__tags'          => array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'CourseTags',
					'get_props',
				),
				'computed_depends_on' => array(
					'course',
				),
				'computed_minimum'    => array(
					'course',
				),
			),
			// general settings tab main_content toggle
			'label'           => array(
				'label'           => esc_html__( 'Label', 'tutor-lms-divi-modules' ),
				'type'            => 'text',
				'default'         => esc_html__( 'Course Tags', 'tutor-lms-divi-modules' ),
				'option_category' => 'basic_option',
				'toggle_slug'     => 'main_content',
			),
			// advanced tab section title toggles
			'gap'            => array(
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
				'toggle_slug'    => 'title',
				'mobile_options' => true,
			),
			// advanced settings tab tags toggle
			'tags_background' => array(
				'label'       => esc_html__( 'Background Color', 'tutor-lms-divi-modules' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tags',
				'priority'    => 67,
				'hover'       => 'tabs',
			),
			'tags_margin'     => array(
				'label'          => esc_html__( 'Margin', 'tutor-lms-divi-modules' ),
				'type'           => 'custom_margin',  
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'tags',
				'mobile_options' => true,
			)
		);
	}

	/**
	 * get require props
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public static function get_props( $args = array() ) {
		$course_id = $args['course'];
		$tags      = get_tutor_course_tags( $course_id );
		$props     = array(
			'tags' => $tags,
		);
		return $props;
	}

	/**
	 * Get the tutor course author
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public static function get_content( $args = array() ) {
		ob_start();
		include_once dtlms_get_template( 'course/tags' );
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
	public function render( $attr, $content, $render_slug ) {
		// selectors
		$wrapper            = '%%order_class%% .tutor-divi-course-tags-wrapper';
		$tag_title_selector = $wrapper . ' .tutor-segment-title';
		$tag_list           = $wrapper . ' .tutor-tag-list';
		$tags_selector      = $wrapper . ' .tutor-tag-list a';
		// props
		$background       = sanitize_text_field( $this->props['tags_background'] );
		$background_hover = isset( $this->props['tags_background__hover'] ) ? sanitize_text_field( $this->props['tags_background__hover'] ) : $background;

		$gap        = sanitize_text_field( $this->props['gap'] );
		$gap_tablet = isset( $this->props['gap_tablet'] ) && $this->props['gap_tablet'] !== '' ? sanitize_text_field( $this->props['gap_tablet'] ) : $gap;
		$gap_phone  = isset( $this->props['gap_phone'] ) && $this->props['gap_phone'] !== '' ? sanitize_text_field( $this->props['gap_phone'] ) : $gap;

		$tags_margin        = sanitize_text_field( $this->props['tags_margin'] );
		$tags_margin_tablet = isset( $this->props['tags_margin_tablet'] ) && $this->props['tags_margin_tablet'] !== '' ? sanitize_text_field( $this->props['tags_margin_tablet'] ) : $tags_margin;
		$tags_margin_phone  = isset( $this->props['tags_margin_phone'] ) && $this->props['tags_margin_phone'] !== '' ? sanitize_text_field( $this->props['tags_margin_phone'] ) : $tags_margin;
		
		if ( '' !== $tags_margin && '|||' !== $tags_margin ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector' => $tag_list,
					'declaration' => sprintf(
						'margin-top: %1$s;margin-right:%2$s;margin-bottom:%3$s;margin-left:%4$s;',
						esc_attr( et_pb_get_spacing( $tags_margin, 'top', '0px' ) ),
						esc_attr( et_pb_get_spacing( $tags_margin, 'right', '0px' ) ),
						esc_attr( et_pb_get_spacing( $tags_margin, 'bottom', '0px' ) ),
						esc_attr( et_pb_get_spacing( $tags_margin, 'left', '0px' ) ),
					)
				)
			);
		}

		if ( '' !== $tags_margin_tablet && '|||' !== $tags_margin_tablet ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector' => $tag_list,
					'declaration' => sprintf(
						'margin-top: %1$s;margin-right:%2$s;margin-bottom:%3$s;margin-left:%4$s;',
						esc_attr( et_pb_get_spacing( $tags_margin_tablet, 'top', '0px' ) ),
						esc_attr( et_pb_get_spacing( $tags_margin_tablet, 'right', '0px' ) ),
						esc_attr( et_pb_get_spacing( $tags_margin_tablet, 'bottom', '0px' ) ),
						esc_attr( et_pb_get_spacing( $tags_margin_tablet, 'left', '0px' ) ),
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);
		} 

		if ( '' !== $tags_margin_phone && '|||' !== $tags_margin_phone ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector' => $tag_list,
					'declaration' => sprintf(
						'margin-top: %1$s;margin-right:%2$s;margin-bottom:%3$s;margin-left:%4$s;',
						esc_attr( et_pb_get_spacing( $tags_margin_phone, 'top', '0px' ) ),
						esc_attr( et_pb_get_spacing( $tags_margin_phone, 'right', '0px' ) ),
						esc_attr( et_pb_get_spacing( $tags_margin_phone, 'bottom', '0px' ) ),
						esc_attr( et_pb_get_spacing( $tags_margin_phone, 'left', '0px' ) ),
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		} 
		// set styles
		if ( '' !== $background ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $tags_selector,
					'declaration' => sprintf(
						'background-color: %1$s;',
						esc_html( $background )
					),
				)
			);
		}

		if ( '' !== $background_hover ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $tags_selector . ':hover',
					'declaration' => sprintf(
						'background-color: %1$s;',
						esc_html( $background_hover )
					),
				)
			);
		}

		if ( $gap ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $tag_title_selector,
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
					'selector'    => $tag_title_selector,
					'declaration' => sprintf(
						'margin-bottom: %1$s;',
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
					'selector'    => $tag_title_selector,
					'declaration' => sprintf(
						'margin-bottom: %1$s;',
						$gap_phone
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		}
		// tags style as tutor.
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-tag-list a',
				'declaration' => 'font-size: 16px;
				line-height: 26px;
				text-decoration: none;
				padding: 7px 23px;
				border: 1px solid #c0c3cb;
				color: #5b616f;
				border-radius: 6px;
				-webkit-transition: 200ms;
				transition: 200ms;',
			)
		);
		// set styles end

		$output = self::get_content( $this->props );

		// Render empty string if no output is generated to avoid unwanted vertical space.
		if ( '' === $output ) {
			return '';
		}

		return $this->_render_module_wrapper( $output, $render_slug );
	}

}
new CourseTags();
