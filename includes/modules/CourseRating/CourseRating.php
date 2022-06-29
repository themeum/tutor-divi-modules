<?php

/**
 * Tutor Course Rating Module for Divi Builder
 *
 * @since 1.0.0
 *
 * @author Themeum<www.themeum.com>
 *
 * @package DTLMSCourseRatings
 */

use TutorLMS\Divi\Helper;

defined( 'ABSPATH' ) || exit;

class TutorCourseRating extends ET_Builder_Module {
	// Module slug (also used as shortcode tag).
	public $slug       = 'tutor_course_rating';
	public $vb_support = 'on';

	// Module Credits (Appears at the bottom of the module settings modal).
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
		$this->name      = esc_html__( 'Tutor Course Rating', 'tutor-lms-divi-modules' );
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
					'rating_stars' => array(
						'title'    => esc_html__( 'Rating Stars', 'tutor-lms-divi-modules' ),
						'priority' => 49,
					),
				),
			),
		);

		$this->advanced_fields = array(
			'fonts'          => array(
				'count_text' => array(
					'css'             => array(
						'main' => '%%order_class%% .tutor-single-course-rating .tutor-single-rating-count',
					),
					'hide_text_align' => true,
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'rating_stars',
				),
			),
			'background'     => array(
				'settings' => array(
					'color' => 'alpha',
				),
			),
			'margin_padding' => array(
				'css' => array(
					'important' => 'all',
				),
			),
			'text_shadow'    => array(
				'default' => false,
			),
			'button'         => false,
			'text'           => false,
			'max_width'      => false,
			'borders'        => false,
			'background'     => false,
			'filters'        => false,
			'animation'      => false,
			'box_shadow'     => false,
			'transform'      => false,
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
			'course'           => Helper::get_field(
				array(
					'default'          => Helper::get_course_default(),
					'computed_affects' => array(
						'__rating',
					),
				)
			),
			'__rating'         => array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'TutorCourseRating',
					'get_rating',
				),
				'computed_depends_on' => array(
					'course',
				),
				'computed_minimum'    => array(
					'course',
				),
			),
			// content tab controls start.
			'rating_layout'    => array(
				'label'           => esc_html__( 'Layout', 'tutor-divi-moduels' ),
				'type'            => 'select',
				'option_category' => 'layout',
				'options'         => array(
					'row'    => esc_html__( 'Left', 'tutor-lms-divi-modules' ),
					'column' => esc_html__( 'Up', 'tutor-lms-divi-modules' ),
				),
				'default'         => 'row',
				'toggle_slug'     => 'main_content',
			),
			'rating_alignment' => array(
				'label'           => esc_html__( 'Alignment', 'tutor-lms-divi-modules' ),
				'type'            => 'text_align',
				'option_category' => 'configuration',
				'options'         => et_builder_get_text_orientation_options( array( 'justified' ) ),
				'toggle_slug'     => 'main_content',
				'mobile_options'  => true,
			),

			// content tab controls end.
			'star_size'        => array(
				'label'          => esc_html__( 'Star Size', 'tutor-lms-divi-modules' ),
				'type'           => 'range',
				'allowed_units'  => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'default_unit'   => 'px',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'range_settings' => array(
					'min' => 10,
					'max' => 100,
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'rating_stars',
			),
			'star_gap'         => array(
				'label'          => esc_html__( 'Star Gap', 'tutor-lms-divi-modules' ),
				'type'           => 'range',
				'allowed_units'  => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'default_unit'   => 'px',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'range_settings' => array(
					'min' => 0,
					'max' => 100,
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'rating_stars',

			),
			'star_color'       => array(
				'label'       => esc_html__( 'Star Color', 'tutor-lms-divi-modules' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'rating_stars',
			),

		);

		return $fields;
	}

	/**
	 * Get the tutor course author
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public static function get_rating( $args = array() ) {
		$course             = Helper::get_course( $args );
		ob_start();
		if ( $course ) {
			include_once dtlms_get_template( 'course/rating' );
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
	public function render( $attrs, $content, $render_slug ) {
		// Process image size value into style.
		$selector        = '%%order_class%% .dtlms-rating-wrapper';
		$star_icon_group = "$selector .tutor-ratings-stars";
		$star_icon       = "$selector .tutor-ratings-stars i";
		$layout          = $this->props['rating_layout'];
		// prepare alignment props.
		$alignment        = $this->props['rating_alignment'];
		$alignment_tablet = isset( $this->props['rating_alignment_tablet'] ) ? $this->props['rating_alignment_tablet'] : '';
		$alignment_mobile = isset( $this->props['rating_alignment_phone'] ) ? $this->props['rating_alignment_phone'] : '';

		// desktop.
		if ( '' !== $alignment && 'left' === $alignment ) {
			$alignment = 'flex-start';
		}
		if ( '' !== $alignment && 'right' === $alignment ) {
			$alignment = 'flex-end';
		}
		// tablet.
		if ( '' !== $alignment_tablet && 'left' === $alignment_tablet ) {
			$alignment_tablet = 'flex-start';
		}
		if ( '' !== $alignment_tablet && 'right' === $alignment_tablet ) {
			$alignment_tablet = 'flex-end';
		}
		// mobile.
		if ( '' !== $alignment_mobile && 'left' === $alignment_mobile ) {
			$alignment_mobile = 'flex-start';
		}
		if ( '' !== $alignment_mobile && 'right' === $alignment_mobile ) {
			$alignment_mobile = 'flex-end';
		}
		// rating layout.
		if ( '' !== $layout ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-single-course-rating',
					'declaration' => sprintf(
						'display: flex;
						column-gap: 3px;
						flex-direction: %1$s;
						',
						$layout
					),
				)
			);
		}
		// rating alignment.
		if ( 'row' === $layout ) {
			if ( '' !== $alignment ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => '%%order_class%% .tutor-single-course-rating',
						'declaration' => sprintf(
							'justify-content: %1$s;',
							$alignment
						),
					)
				);
			}
			if ( '' !== $alignment_tablet ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => '%%order_class%% .tutor-single-course-rating',
						'declaration' => sprintf(
							'justify-content: %1$s;',
							$alignment_tablet
						),
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
					)
				);
			}
			if ( '' !== $alignment_mobile ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => '%%order_class%% .tutor-single-course-rating',
						'declaration' => sprintf(
							'justify-content: %1$s;',
							$alignment_mobile
						),
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
					)
				);
			}
		}

		if ( 'column' === $layout ) {
			if ( '' !== $alignment ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => '%%order_class%% .tutor-single-course-rating',
						'declaration' => sprintf(
							'align-items: %1$s;',
							$alignment
						),
					)
				);
			}
			if ( '' !== $alignment_tablet ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => '%%order_class%% .tutor-single-course-rating',
						'declaration' => sprintf(
							'align-items: %1$s;',
							$alignment_tablet
						),
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
					)
				);
			}
			if ( '' !== $alignment_mobile ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'    => '%%order_class%% .tutor-single-course-rating',
						'declaration' => sprintf(
							'align-items: %1$s;',
							$alignment_mobile
						),
						'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
					)
				);
			}
		}

		// alignment end.
		
		// default star color.
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'	=> $star_icon,
				'declaration' => 'color: #ed9700;'
			)
		);

		if ( '' !== $this->props['star_size'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $star_icon,
					'declaration' => sprintf(
						'font-size: %1$s !important;',
						esc_html( $this->props['star_size'] )
					),
				)
			);

		}

		if ( '' !== $this->props['star_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $star_icon,
					'declaration' => sprintf(
						'color: %1$s;',
						esc_html( $this->props['star_color'] )
					),
				)
			);
		}

		if ( '' !== $this->props['star_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $star_icon_group,
					'declaration' => sprintf(
						'letter-spacing: %1$s;',
						esc_html( $this->props['star_gap'] )
					),
				)
			);
		}
		// make sure reviews is enable from Tutor settings.
		$output = self::get_rating( $this->props );
		// Render empty string if no output is generated to avoid unwanted vertical space.
		if ( '' === $output ) {
			return '';
		}

		return $this->_render_module_wrapper( $output, $render_slug );
	}
}

new TutorCourseRating();
