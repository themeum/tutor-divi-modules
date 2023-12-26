<?php

/**
 * Tutor Course Price Module for Divi Builder
 *
 * @since 1.0.0
 * @author Themeum<www.themeum.com>
 */

use TutorLMS\Divi\Helper;

defined( 'ABSPATH' ) || exit;

class CoursePrice extends ET_Builder_Module {

	// Module slug (also used as shortcode tag)
	public $slug       = 'tutor_course_price';
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
		$this->name      = esc_html__( 'Tutor Course Price', 'tutor-lms-divi-modules' );
		$this->icon_path = plugin_dir_path( __FILE__ ) . 'icon.svg';

		// settings toggles
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Content', 'tutor-lms-divi-modules' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'course_price'        => esc_html__( 'Course Price', 'tutor-lms-divi-modules' ),
					'course_strike_price' => esc_html__( 'Course Strike Price', 'tutor-lms-divi-modules' ),
				),
			),
		);

		$selector       = '%%order_class%% .tutor-course-sidebar-card-pricing';
		$hover_selector = '%%order_class%% .price:hover';

		$this->advanced_fields = array(
			'fonts'      => array(
				'course_price'        => array(
					// 'label'           => esc_html__( 'Course Price', 'tutor-lms-divi-modules' ),
					'css'         => array(
						'main' => "$selector ins .woocommerce-Price-amount, %%order_class%% .tutor-course-sidebar-card-pricing .edd_price, $selector .woocommerce-Price-amount bdi",
					),
					'hide_text_align' => true,
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'course_price',
				),
				'course_strike_price' => array(
					// 'label'           => esc_html__( 'Text', 'tutor-lms-divi-modules' ),
					'css'             => array(
						'main' => "$selector del .woocommerce-Price-amount",
					),
					'hide_text_align' => true,
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'course_strike_price',
				),
			),
			'button'     => false,
			'text'       => false,
			'borders'    => false,
			'max_width'  => false,
			//'animation'  => false,
			//'transform'  => false,
			//'background' => false,
			//'filters'    => false,
			// 'box_shadow' => false,
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
			'course'    => Helper::get_field(
				array(
					'default'          => Helper::get_course_default(),
					'computed_affects' => array(
						'__price',
					),
				)
			),
			'__price'   => array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'CoursePrice',
					'get_content',
				),
				'computed_depends_on' => array( 'course' ),
				'computed_minimum'    => array( 'course' ),
			),
			'alignment' => array(
				'label'           => esc_html__( 'Alignment', 'tutor-lms-divi-modules' ),
				'type'            => 'text_align',
				'option_category' => 'configuration',
				'options'         => et_builder_get_text_orientation_options( array( 'justified' ) ),
				'default'         => 'left',
				'toggle_slug'     => 'main_content',
				'mobile_options'  => true,
			),

		);
	}

	/**
	 * Computed value.
	 *
	 * @param array $args | settings control.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function get_content( $args = array() ) {
		ob_start();
		$course = $args['course'];
		$price 	= tutor_utils()->get_course_price( $course );
		?>
			<div class="dtlms-course-price">
				<?php if ( $course ) : ?>
					<?php if ( null != $price ) : ?>
						<div class="tutor-course-sidebar-card-pricing tutor-d-flex align-items-end tutor-justify-content-between">
							<div>
								<?php echo tutor_kses_html( $price ); ?>
							</div>
						</div>
					<?php else : ?>
						<div class="tutor-course-sidebar-card-pricing tutor-d-flex align-items-end tutor-justify-content-between">
							<div>
								<span class="tutor-fs-4 tutor-fw-bold tutor-color-black">
									<?php echo esc_html_x( 'Free', 'course price', 'tutor-lms-elementor-addons' ); ?>
								</span>
							</div>
						</div>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Render module output.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $attr | List of unprocessed attributes.
	 * @param string $content | Content being processed.
	 * @param string $render_slug | Slug of module that is used for rendering output.
	 *
	 * @return string module's rendered output
	 */
	public function render( $attr, $content, $render_slug ) {
		// selectors.
		$selector = '%%order_class%% .tutor-course-sidebar-card-pricing';

		// props.
		$alignment        = sanitize_text_field( $this->props['alignment'] );
		$alignment_tablet = isset( $this->props['alignment_tablet'] ) && '' !== $this->props['alignment_tablet'] ? sanitize_text_field( $this->props['alignment_tablet'] ) : $alignment;
		$alignment_phone  = isset( $this->props['alignment_phone'] ) && '' !== $this->props['alignment_phone'] ? sanitize_text_field( $this->props['alignment_phone'] ) : $alignment;

		// set styles.
		if ( '' !== $alignment ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf(
						'display: block !important; text-align: %1$s !important;',
						$alignment
					),
				)
			);
		}
		if ( '' !== $alignment_tablet ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf(
						'display: block !important; text-align: %1$s;',
						$alignment_tablet
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);
		}
		if ( '' !== $alignment_phone ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $selector,
					'declaration' => sprintf(
						'display: block !important; text-align: %1$s;',
						$alignment_phone
					),
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		}

		// set styles end.
		$output = self::get_content( $this->props );
		return $this->_render_module_wrapper( $output, $render_slug );
	}

}
new CoursePrice();
