<?php

/**
 * Tutor Course Author Module for Divi Builder
 * @since 1.0.0
 */

use TutorLMS\Divi\Helper;

class CoursePrice extends ET_Builder_Module {

    // Module slug (also used as shortcode tag)
    public $slug        = 'tutor_course_price';
    public $vb_support  = 'on';

	// Module Credits (Appears at the bottom of the module settings modal)
	protected $module_credits = array(
		'author'     => 'Themeum',
		'author_uri' => 'https://themeum.com',
	);

    public function init() {
        $this->name         = esc_html__( 'Tutor Course Price', 'tutor-divi-modules' ); 
        $this->icon_path	= plugin_dir_path( __FILE__ ) . 'icon.svg';

		//settings toggles
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__('Content', 'tutor-divi-modules'),
				),
			),
		);

		$selector 		= '%%order_class%% .price';
		$hover_selector = '%%order_class%% .price:hover';

		$this->advanced_fields = array(
			'fonts'          => array(

				'normal_style' 	=> array(
					'css'          => array(
						'main' => $selector,
					),
					'hide_text_align'	=> true,
					'tab_slug'     		=> 'advanced',
					'toggle_slug'  		=> 'normal_hover_style',
					'sub_toggle'		=> 'normal_subtoggle'
				),

				'hover_style'	=> array(
					'css'			=> array(
						'main'	=> $hover_selector
					),
					'hide_text_align'	=> true,
					'tab_slug'			=> 'advanced',
					'toggle_slug'		=> 'normal_hover_style',
					'sub_toggle'		=> 'hover_subtoggle'
				)

			),
			'button'		=> false,
			'text'			=> false	 
		);
	}

    public function get_fields() {
		return array(
			'course'       	=> Helper::get_field(
				array(
					'default'          => Helper::get_course_default(),
					'computed_affects' => array(
						'__share',
					),
				)
			),
			'__price'		=> array(
				'type'					=> 'computed',
				'computed_callback'		=> array(
					'CoursePrice',
					'get_props'
				),
				'computed_depends_on'	=> array( 'course' ),
				'computed_minimum'		=> array( 'course' ),
			),
			'alignment'		=> array(
				'label'				=> esc_html__('Alignment', 'tutor-divi-modules'),
				'type'				=> 'text_align',
				'option_category'	=> 'configuration',
				'options'			=> et_builder_get_text_orientation_options( array( 'justified' ) ),
				'default'			=> 'left',
				'toggle_slug'		=> 'main_content',
				'mobile_options'	=> true
			),

		);
    }

	/**
	 * custom tabs for label & value
	 */
	public function get_settings_modal_toggles () {
		return array(
			'advanced'	=> array(
				'toggles'	=> array(
					'normal_hover_style'		=> array(
						'priority'		=> 24,
						'sub_toggles'	=> array(
							'normal_subtoggle'	=> array(
								'name'	=> esc_html__('Normal', 'tutor-divi-modules')
							),
							'hover_subtoggle'	=> array(
								'name'	=> esc_html__('Hover', 'tutor-divi-modules')
							),
						),
						'tabbed_subtoggles' => true,
						'title' => esc_html__('Style', 'tutor-divi-modules'),
					),
				)
			)
		);
	}

	/**
	 * computed value
	 * @return string | array course level
	 */
	public static function get_props( $args = [] ) {
		$course_id 		= $args[ 'course' ];
		$price		= tutor_utils()->get_course_price( $course_id );
		$price 		= is_null($price) ? "Free" : $price ;
		$props = [
			'price'	=> $price,
		];

		return $props;
	}	

    public function render( $attr, $content = null, $render_slug) {
		//selectors
		$selector 		= '%%order_class%% .price';

		//props
		$alignment		= $this->props['alignment'];
		$alignment_tablet	= isset( $this->props['alignment_tablet'] ) && '' !== $this->props['alignment_tablet'] ? $this->props['alignment_tablet'] : $alignment;
		$alignment_phone	= isset( $this->props['alignment_phone'] ) && '' !== $this->props['alignment_phone'] ? $this->props['alignment_phone'] : $alignment;	

		//set styles
		if( '' !== $alignment ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $selector,
					'declaration'	=> sprintf(
						'text-align: %1$s;',
						$alignment
					) 
				)
			);
		}
		if( '' !== $alignment_tablet ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $selector,
					'declaration'	=> sprintf(
						'text-align: %1$s;',
						$alignment_tablet
					),
					'media_query'	=> ET_Builder_Element::get_media_query('max_width_980')
				)
			);
		}
		if( '' !== $alignment_phone ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $selector,
					'declaration'	=> sprintf(
						'text-align: %1$s;',
						$alignment_phone
					), 
					'media_query'	=> ET_Builder_Element::get_media_query('max_width_767')
				)
			);
		}

		//set styles end

		$price		= tutor_utils()->get_course_price( $this->props['course']);
		$price 		= is_null($price) ? "Free" : $price ;
		
        $output		= '<div class="price"> '.$price.' </div>';
		return $this->_render_module_wrapper($output, $render_slug);
    }

}
new CoursePrice;