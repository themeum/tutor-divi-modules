<?php

/**
 * Tutor Course Title Module for Divi Builder
 *
 * @since 1.0.0
 *
 * @author Themeum<www.themeum.com
 *
 * @package DTLMSCourseTitle
 */

use TutorLMS\Divi\Helper;

defined( 'ABSPATH' ) || exit;

class CourseWishlist extends ET_Builder_Module {
	// Module slug (also used as shortcode tag).
	public $slug = 'tutor_course_wishlist';

	/**
	 * Visual builder support
	 *
	 * @var string
	 */
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
		// Module name & icon.
		$this->name      = esc_html__( 'Tutor Course Wishlist', 'tutor-lms-divi-modules' );
		$this->icon_path = plugin_dir_path( __FILE__ ) . 'icon.svg';

		// Toggle settings
		// Toggles are grouped into array of tab name > toggles > toggle definition.
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Content', 'tutor-lms-divi-modules' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'label_style' => array(
						'title'    => esc_html__( 'Label', 'tutor-lms-divi-modules' ),
						'priority' => 49,
					),
					'icon_style'  => array(
						'title'    => esc_html__( 'Icon', 'tutor-lms-divi-modules' ),
						'priority' => 65,
					),
				),
			),
		);

		$this->advanced_fields = array(
			'fonts'      => array(
				'label_style' => array(
					'label'           => esc_html__( 'Label', 'tutor-lms-divi-modules' ),
					'css'             => array(
						'main' => '%%order_class%% .dtlms-course-wishlist-wrapper a span',
					),
					'header_level'    => array(
						'default' => 'h1',
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'label_style',
					'hide_text_align' => true,
				),
				'icon_style'  => array(
					'label'           => esc_html__( 'Icon', 'tutor-lms-divi-modules' ),
					'css'             => array(
						'main' => '%%order_class%% .dtlms-course-wishlist-wrapper a i',
					),
					'header_level'    => array(
						'default' => 'h1',
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'icon_style',
					'hide_text_align' => true,
				),
			),
			'borders'    => false,
			'button'     => false,
			'text'       => false,
			'max_width'  => false,
			'background' => false,
			'filters'    => false,
			// 'animation'  => false,
			// 'box_shadow' => false,
			// 'transform'  => false,
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
			'course'                    => Helper::get_field(
				array(
					'default'          => Helper::get_course_default(),
					'computed_affects' => array(
						'__wishlist',
					),
				)
			),
			'__wishlist'                => array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'CourseWishlist',
					'get_content',
				),
				'computed_depends_on' => array(
					'course',
					'label',
					'course_wishlist_text_show',
					'course_wishlist_icon_show',
				),
				'computed_minimum'    => array(
					'course',
					'label',
					'course_wishlist_text_show',
					'course_wishlist_icon_show',
				),
			),
			'label'                     => array(
				'label'       => esc_html__( 'Label', 'tutor-lms-divi-modules' ),
				'type'        => 'text',
				'toggle_slug' => 'main_content',
				'default'     => esc_html__( 'Wishlist', 'tutor-lms-divi-modules' ),
			),
			'course_wishlist_text_show' => array(
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
			'course_wishlist_icon_show' => array(
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
			'alignment'                 => array(
				'label'           => esc_html__( 'Alignment', 'tutor-lms-divi-modules' ),
				'type'            => 'text_align',
				'option_category' => 'configuration',
				'options'         => et_builder_get_text_orientation_options( array( 'justified' ) ),
				'default'         => 'left',
				'toggle_slug'     => 'main_content',
				'mobile_options'  => true,
			),
			'space_between'             => array(
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
					'course_wishlist_icon_show' => 'on',
					'course_wishlist_text_show' => 'on',
				),
				'mobile_options'  => true,
			),
		);

		return $fields;
	}

	/**
	 * Get the tutor course Title markup.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public static function get_content( $args = array() ) {
		ob_start();
		?>
		<div class="dtlms-course-wishlist-wrapper">
		<a href="#" class="action-btn tutor-text-regular-body tutor-color-text-primary tutor-bs-d-flex tutor-bs-align-items-center" data-course-id="<?php echo get_the_ID(); ?>">
			<?php if ( 'on' === $args['course_wishlist_icon_show'] ) : ?>
				<i class="tutor-icon-fav-line-filled"></i>
			<?php endif; ?>
			<span>
				<?php
				if ( 'on' === $args['course_wishlist_text_show'] ) {
					echo esc_html( $args['label'] );
				}
				?>
			</span>
		</a>
	</div>
		<?php
		$content = apply_filters( 'dtlms_course_wishlist', ob_get_clean() );
		return $content;
	}

	/**
	 * Render module output
	 *
	 * @since 1.0.0
	 *
	 * @param array  $attrs       List of unprocessed attributes.
	 * @param string $content     Content being processed.
	 * @param string $render_slug Slug of module that is used for rendering output.
	 *
	 * @return string module's rendered output
	 */
	public function render( $attrs, $content, $render_slug ) {
		$wrapper_selector = '%%order_class%% .dtlms-course-wishlist-wrapper a';

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
		// style end.
		$output = self::get_content( $this->props );

		// Render empty string if no output is generated to avoid unwanted vertical space.
		if ( '' === $output ) {
			return '';
		}

		return $this->_render_module_wrapper( $output, $render_slug );
	}
}

new CourseWishlist();
