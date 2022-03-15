<?php
/**
 * Tutor Course Status Module for Divi Builder
 *
 * @since 1.0.0
 * @author Themeum<www.themeum.com>
 */

use TutorLMS\Divi\Helper;

defined( 'ABSPATH' ) || exit;

class CourseStatus extends ET_Builder_Module {

	// Module slug (also used as shortcode tag)
	public $slug       = 'tutor_course_status';
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
		$this->name      = esc_html__( 'Tutor Course Status', 'tutor-lms-divi-modules' );
		$this->icon_path = plugin_dir_path( __FILE__ ) . 'icon.svg';

		// toggles settings (content tab)
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Content', 'tutor-lms-divi-modules' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'status_title'          => esc_html__( 'Progress Title', 'tutor-lms-divi-modules' ),
					'progress_bar'          => esc_html__( 'Progress Bar', 'tutor-lms-divi-modules' ),
					'status_text'           => esc_html__( 'Progress Text', 'tutor-lms-divi-modules' ),
				),
			),
		);

		// advanced fields settings (design tab)
		$label_selector = '%%order_class%% .tutor-course-status .tutor-segment-title';
		$text_selector  = '%%order_class%% .tutor-course-status .tutor-progress-percent';

		$this->advanced_fields = array(
			'fonts'     => array(
				'status_title'               => array(
					'label'           => esc_html__( 'Status Title', 'tutor-lms-divi-modules' ),
					'css'             => array(
						'main' => '%%order_class%% .tutor-course-progress-wrapper .tutor-color-text-primary',
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
			'button'    => false,
			'text'      => false,
			'max_width' => false,
			//'borders'   => false,
			// 'background' => false,
			// 'filters'    => false,
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
		return array(
			'course'                => Helper::get_field(
				array(
					'default'          => Helper::get_course_default(),
					'computed_affects' => array(
						'__course_progress',
					),
				)
			),
			'__course_progress'     => array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'CourseStatus',
					'get_edit_content',
				),
				'computed_depends_on' => array( 'course', 'course_progress_title' ),
				'computed_minimum'    => array( 'course', 'course_progress_title' ),
			),
			'course_progress_title' => array(
				'label'           => esc_html__( 'Progress Title', 'tutor-lms-divi-modules' ),
				'type'            => 'text',
				'default'         => esc_html__( 'Course Progress', 'tutor-lms-divi-modules' ),
				'option_category' => 'basic_option',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'main_content',
			),

			// progress bar advanced tab.
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
	 * Editing template just for mocking main template with dummy data
	 *
	 * @return string  template markup
	 */
	public static function get_edit_content( $args = array() ) {
		ob_start();
		if ( isset( $args['course'] ) ) :
			?>
			<div class="tutor-course-progress-wrapper tutor-mb-30" style="width: 100%;">
				<span class="tutor-color-text-primary tutor-text-medium-h6">
					<?php echo esc_html( $args['course_progress_title'], 'tutor-lms-divi-modules' ); ?>
				</span>
				<div class="list-item-progress tutor-mt-16">
					<div class="text-regular-body tutor-color-text-subsued tutor-d-flex tutor-align-items-center tutor-justify-content-between">
						<span class="progress-steps">
							5/10
						</span>
						<span class="progress-percentage"> 
							50%
							<?php esc_html_e( 'Complete', 'tutor-lms-divi-modules' ); ?>
						</span>
					</div>
					<div class="progress-bar tutor-mt-10" style="--progress-value:50%;">
						<span class="progress-value"></span>
					</div>
				</div>
			</div>
			<?php
		endif;
		return ob_get_clean();
	}
	/**
	 * Get the tutor course author
	 *
	 * @return string
	 */
	public static function get_content( $args = array() ) {
		ob_start();
		include_once dtlms_get_template( 'course/status' );
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
		// set style.
		if ( '' !== $this->props['bar_height'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .list-item-progress .progress-bar',
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
					'selector'    => '%%order_class%% .list-item-progress .progress-bar',
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
					'selector'    => '%%order_class%% .list-item-progress .progress-bar',
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
					'selector'    => '%%order_class%% .list-item-progress .progress-bar .progress-value',
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
					'selector'    => '%%order_class%% .list-item-progress .progress-bar .progress-value',
					'declaration' => sprintf(
						'margin-top: %1$s;',
						$this->props['bar_gap']
					),
				),
			);
		}

		// set style end.
		$output = self::get_content( $this->props );

		// Render empty string if no output is generated to avoid unwanted vertical space.
		if ( '' === $output ) {
			return '';
		}
		return $this->_render_module_wrapper( $output, $render_slug );
	}

}
new CourseStatus();
