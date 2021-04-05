<?php

class CourseCarousel extends ET_Builder_Module {

	public $slug       = 'tutor_course_carousel';
	public $vb_support = 'on';

	// Module Credits (Appears at the bottom of the module settings modal)
	protected $module_credits = array(
		'author'     => 'Themeum',
		'author_uri' => 'https://themeum.com',
	);

	public function init() {
		$this->name         = esc_html__( 'Tutor Course Carousel', 'tutor-divi-modules' );
		$this->icon_path	= plugin_dir_path( __FILE__ ) . 'icon.svg';

		//settings modal toggles
		$this->settings_modal_toggles = array(
			'general'	=> array(
				'toggles'	=> array(
					'layout'		=> esc_html__( 'Layout', 'tutor-divi-modules' ),
					'query'			=> esc_html__( 'Query', 'tutor-divi-modules' ),
					'enroll_button'	=> esc_html__( 'Enroll Button', 'tutor-divi-modules' ),
					'carousel_settings'	=> esc_html__( 'Carousel Settings', 'tutor-divi-modules' )
				)
			),
			'advanced'	=> array(
				'toggles'	=> array(
					'card'		=> esc_html__( 'Card', 'tutor-divi-modules' ),
					'image'		=> esc_html__( 'Image', 'tutor-divi-modules' ),
					'badge'		=> esc_html__( 'Badge', 'tutor-divi-modules' ),
					'avatar'	=> esc_html__( 'Avatar', 'tutor-divi-modules' ),
					'title'		=> esc_html__( 'Title', 'tutor-divi-modules' ),
					'meta'		=> esc_html__( 'Meta', 'tutor-divi-modules' ),
					'category'	=> esc_html__( 'Category', 'tutor-divi-modules' ),
					'rating'	=> esc_html__( 'Rating', 'tutor-divi-modules' ),
					'footer'	=> esc_html__( 'Footer', 'tutor-divi-modules' ),
					'cart_button'	=> esc_html__( 'Cart Button', 'tutor-divi-modules' ),
					'arrows'	=> esc_html__( 'Arrows', 'tutor-divi-modules' ),
					'dots'		=> esc_html__( 'Dots', 'tutor-divi-modules' ),
				),
			)
		);

		//advanced fields configuration
		$this->advanced_fields = array(
			'fonts'	=> array(
				'title'	=> array(
					'css'			=> array(
						'main'	=> 'selector',
					),
					'tab_slug'		=> 'advanced',
					'toggle_slug'	=> 'title' 
				),
				'meta'	=> array(
					'css'			=> array(
						'main'	=> 'selector',
					),
					'tab_slug'		=> 'advanced',
					'toggle_slug'	=> 'meta' 
				),
				'category'	=> array(
					'css'			=> array(
						'main'	=> 'selector',
					),
					'tab_slug'		=> 'advanced',
					'toggle_slug'	=> 'category' 
				),
				'footer'	=> array(
					'css'			=> array(
						'main'	=> 'selector',
					),
					'tab_slug'		=> 'advanced',
					'toggle_slug'	=> 'footer' ,
					'hide_text_align'	=> true
				),
			),
			
			'button'		=> array(
                'cart_button' => array(
                    'label'         => esc_html__( 'Cart Button', 'tutor-divi-modules' ),
                    'box_shadow'    => array(
                        'css'   => array(
                            'main'  => '%%order_class%% .tutor-course-enrollment-box .tutor-btn-enroll'
                        )
                    ),
                    'css'           => array(
                        'main'  => '%%order_class%% .tutor-course-enrollment-box .tutor-btn-enroll'
                    ),
                    //'use_alignment' => false,
                    'tab_slug'      => 'advanced',
                    'toggle_slug'   => 'cart_button' , 
                    'important'     => true
                ),
                'arrows' => array(
                    'label'         => esc_html__( 'Cart Button', 'tutor-divi-modules' ),
                    'box_shadow'    => array(
                        'css'   => array(
                            'main'  => '%%order_class%% .tutor-course-enrollment-box .tutor-btn-enroll'
                        )
                    ),
                    'css'           => array(
                        'main'  => '%%order_class%% .tutor-course-enrollment-box .tutor-btn-enroll'
                    ),
                    //'use_alignment' => false,
                    'tab_slug'      => 'advanced',
                    'toggle_slug'   => 'arrow' , 
                    'important'     => true
                ),
                'dots' => array(
                    'label'         => esc_html__( 'Cart Button', 'tutor-divi-modules' ),
                    'box_shadow'    => array(
                        'css'   => array(
                            'main'  => '%%order_class%% .tutor-course-enrollment-box .tutor-btn-enroll'
                        )
                    ),
                    'css'           => array(
                        'main'  => '%%order_class%% .tutor-course-enrollment-box .tutor-btn-enroll'
                    ),
                    //'use_alignment' => false,
                    'tab_slug'      => 'advanced',
                    'toggle_slug'   => 'dots' , 
                    'important'     => true
                ),
			),
			'borders'		=> array(
				'card'	=> array(
					'css'			=> array(
						'main'	=> array(
							'border_radii'	=> 'selector',
							'border_styles'	=> 'selecotr'
						)
					),
					'tab_slug'		=> 'advanced',
					'toggle_slug'	=> 'card'
				),
				'badge'	=> array(
					'css'			=> array(
						'main'	=> array(
							'border_radii'	=> 'selector',
							'border_styles'	=> 'selecotr'
						)
					),
					'tab_slug'		=> 'advanced',
					'toggle_slug'	=> 'badge'
				),
				'avatar'	=> array(
					'css'			=> array(
						'main'	=> array(
							'border_radii'	=> 'selector',
							'border_styles'	=> 'selecotr'
						)
					),
					'tab_slug'		=> 'advanced',
					'toggle_slug'	=> 'avatar'
				),
			),
			'margin_padding'=> array(

			),
			'background'    => array(
                'css'   => array(
                    'main'  => '%%order_class%%',
                    'important' => true
                ),
                'settings'  => array(
                    'tab_slug'      => 'advanced',
                    'toggle_slug'   => 'image'
                ),
                'use_background_video'  => false
            ),
			'filters' => array(
				'child_filters_target' => array(
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'image',
				),
				'css'                  => array(
					'main' => '%%order_class%%',
				),
			),
			'text'			=> false,
			'max_width'		=> false,
			'filters'		=> false
		);
		

	}

	/**
	 * fields configuration
	 * @since 1.0.0
	 */
	public function get_fields() {
		return array(
			//general tab layout toggle
			'skin'	=> array(
				'label'				=> esc_html__( 'Skin'),
				'type'				=> 'select',
				'options'			=> array(
					'classic'	=> esc_html__( 'Classic', 'tutor-divi-modules' ),
					'card'		=> esc_html__( 'Card', 'tutor-divi-modules' ),
					'stacked'	=> esc_html__( 'Stacked', 'tutor-divi-modules' ),
					'overlayed'	=> esc_html__( 'Overlayed', 'tutor-divi-modules' ),
				),
				'default'			=> 'classic',
				'option_category'	=> 'basic_option',
				'tab_slug'			=> 'general',
				'toggle_slug'		=> 'layout'
			),
			'slides_to_show'	=> array(
				'label'			=> esc_html__( 'Slides to Show', 'tutor-divi-modules' ),
				'type'			=> 'select',
				'description'	=> esc_html__( 'Select -1 for all', 'tutor-divi-modules' ),
				'options'		=> array(
					'5'	=>		 esc_html__( 'Default', 'tutor-divi-modules' ),
					'1'			=> '1',
					'2'			=> '2',
					'3'			=> '3',
					'4'			=> '4',
					'5'			=> '5',
					'6'			=> '6',
					'7'			=> '7',
					'8'			=> '8',
					'9'			=> '9',
					'10'		=> '10',
					-1			=> '-1'
				),
				'default'		=> '5',
				'tab_slug'		=> array(),
				'toggle_slug'	=> array(),
			),
			'hover_animation'	=> array(
				'label'			=> esc_html__( 'Show Animation', 'tutor-divi-modules' ),
				'type'			=> 'yes_no_button',
				'default'		=> 'on',
				'options'		=> array(
					'on'	=> esc_html__( 'Show', 'tutor-divi-modules' ),
					'off'	=> esc_html__( 'Hide', 'tutor-divi-modules' )
				),
				'tab_slug'		=> 'general',
				'toggle_slug'	=> 'layout',
			),
			'show_image'	=> array(
				'label'			=> esc_html__( 'Show Image', 'tutor-divi-modules' ),
				'type'			=> 'yes_no_button',
				'default'		=> 'on',
				'options'		=> array(
					'on'	=> esc_html__( 'Show', 'tutor-divi-modules' ),
					'off'	=> esc_html__( 'Hide', 'tutor-divi-modules' )
				),
				'tab_slug'		=> 'general',
				'toggle_slug'	=> 'layout'
			),
			'image_size'=> array(
				'label'			=> esc_html__( 'Image Size', 'tutor-divi-modules' ),
				'type'			=> 'select',
				'options'		=> array(
					'thumbnail'		=> esc_html__( 'Thumbnail', 'tutor-divi-modules'),
					'medium'		=> esc_html__( 'Medium', 'tutor-divi-modules'),
					'medium_large'	=> esc_html__( 'Medium Large', 'tutor-divi-modules'),
					'large'			=> esc_html__( 'large', 'tutor-divi-modules'),
					'full'			=> esc_html__( 'full', 'tutor-divi-modules'),
				),
				'default'			=> 'medium_large',
				'tab_slug'			=> 'general',
				'toggle_slug'		=> 'layout'
			),
			'meta_data'	=> array(
				'label'			=> esc_html__( 'Meta Data', 'tutor-divi-modules' ),
				'type'			=> 'yes_no_button',
				'default'		=> 'off',
				'options'		=> array(
					'on'	=> esc_html__( 'Show', 'tutor-divi-modules' ),
					'off'	=> esc_html__( 'Hide', 'tutor-divi-modules' )
				),
				'tab_slug'		=> 'general',
				'toggle_slug'	=> 'layout'
			),
			'rating'	=> array(
				'label'			=> esc_html__( 'Rating', 'tutor-divi-modules' ),
				'type'			=> 'yes_no_button',
				'default'		=> 'on',
				'options'		=> array(
					'on'	=> esc_html__( 'Show', 'tutor-divi-modules' ),
					'off'	=> esc_html__( 'Hide', 'tutor-divi-modules' )
				),
				'tab_slug'		=> 'general',
				'toggle_slug'	=> 'layout'
			),
			'avatar'	=> array(
				'label'			=> esc_html__( 'Avatar', 'tutor-divi-modules' ),
				'type'			=> 'yes_no_button',
				'default'		=> 'on',
				'options'		=> array(
					'on'	=> esc_html__( 'Show', 'tutor-divi-modules' ),
					'off'	=> esc_html__( 'Hide', 'tutor-divi-modules' )
				),
				'tab_slug'		=> 'general',
				'toggle_slug'	=> 'layout'
			),
			'difficulty_label'	=> array(
				'label'			=> esc_html__( 'Difficulty Label', 'tutor-divi-modules' ),
				'type'			=> 'yes_no_button',
				'default'		=> 'on',
				'options'		=> array(
					'on'	=> esc_html__( 'Show', 'tutor-divi-modules' ),
					'off'	=> esc_html__( 'Hide', 'tutor-divi-modules' )
				),
				'tab_slug'		=> 'general',
				'toggle_slug'	=> 'layout'
			),
			'wish_list'	=> array(
				'label'			=> esc_html__( 'Wish List', 'tutor-divi-modules' ),
				'type'			=> 'yes_no_button',
				'default'		=> 'on',
				'options'		=> array(
					'on'	=> esc_html__( 'Show', 'tutor-divi-modules' ),
					'off'	=> esc_html__( 'Hide', 'tutor-divi-modules' )
				),
				'tab_slug'		=> 'general',
				'toggle_slug'	=> 'layout'
			),
			'category'	=> array(
				'label'			=> esc_html__( 'Category', 'tutor-divi-modules' ),
				'type'			=> 'yes_no_button',
				'default'		=> 'on',
				'options'		=> array(
					'on'	=> esc_html__( 'Show', 'tutor-divi-modules' ),
					'off'	=> esc_html__( 'Hide', 'tutor-divi-modules' )
				),
				'tab_slug'		=> 'general',
				'toggle_slug'	=> 'layout'
			),
			'footer'	=> array(
				'label'			=> esc_html__( 'Footer', 'tutor-divi-modules' ),
				'type'			=> 'yes_no_button',
				'default'		=> 'on',
				'options'		=> array(
					'on'	=> esc_html__( 'Show', 'tutor-divi-modules' ),
					'off'	=> esc_html__( 'Hide', 'tutor-divi-modules' )
				),
				'tab_slug'		=> 'general',
				'toggle_slug'	=> 'layout'
			),
			//general tab query toggle
			'order_by'	=> array(
				'label'			=> esc_html__( 'Order by', 'tutor-divi-modules' ),
				'type'			=> 'select',
				'options'		=> array(
					'date'		=> esc_html__( 'Date', 'tutor-divi-modules' ),
					'title'		=> esc_html__( 'Title', 'tutor-divi-modules' )
				),
				'default'		=> 'date',
				'tab_slug'		=> 'general', 
				'toggle_slug'	=> 'query',
			),
			'order'	=> array(
				'label'			=> esc_html__( 'Order', 'tutor-divi-modules' ),
				'type'			=> 'select',
				'options'		=> array(
					'DESC'		=> esc_html__( 'DESC', 'tutor-divi-modules' ),
					'ASC'		=> esc_html__( 'ASC', 'tutor-divi-modules' )
				),
				'default'		=> 'DESC',
				'tab_slug'		=> 'general', 
				'toggle_slug'	=> 'query',
			),
			'limit'	=> array(
				'label'			=> esc_html__( 'Limit', 'tutor-divi-modules' ),
				'type'			=> 'text',
				'default'		=> '5',
				'tab_slug'		=> 'general', 
				'toggle_slug'	=> 'query',
			),

			//general tab carosuel_settings toggle
			'arrows'	=> array(
				'label'			=> esc_html__( 'Arrows', 'tutor-divi-modules' ),
				'type'			=> 'yes_no_button',
				'options'		=> array(
					'on'		=> esc_html__( 'Show', 'tutor-divi-modules' ),
					'off'		=> esc_html__( 'Hide', 'tutor-divi-modules' )
				),
				'default'		=> 'on',
				'tab_slug'		=> 'general',
				'toggle_slug'	=> 'carousel_settings'
			),
			'dots'	=> array(
				'label'			=> esc_html__( 'Dots', 'tutor-divi-modules' ),
				'type'			=> 'yes_no_button',
				'options'		=> array(
					'on'		=> esc_html__( 'Show', 'tutor-divi-modules' ),
					'off'		=> esc_html__( 'Hide', 'tutor-divi-modules' )
				),
				'default'		=> 'on',
				'tab_slug'		=> 'general',
				'toggle_slug'	=> 'carousel_settings'
			),
			'transition'	=> array(
				'label'			=> esc_html__( 'Transition Duration', 'tutor-divi-modules' ),
				'type'			=> 'text',
				'default'		=> '600',
				'description'	=> esc_html__( 'Use only numbers for transition', 'tutor-divi-modules'),
				'tab_slug'		=> 'general',
				'toggle_slug'	=> 'carousel_settings'
			),
			'center_slides'	=> array(
				'label'			=> esc_html__( 'Center Slides', 'tutor-divi-modules' ),
				'type'			=> 'yes_no_button',
				'options'		=> array(
					'on'		=> esc_html__( 'Yes', 'tutor-divi-modules' ),
					'off'		=> esc_html__( 'No', 'tutor-divi-modules' )
				),
				'default'		=> 'on',
				'tab_slug'		=> 'general',
				'toggle_slug'	=> 'carousel_settings'
			),
			'smooth_scrolling'	=> array(
				'label'			=> esc_html__( 'Smooth Scrolling', 'tutor-divi-modules' ),
				'type'			=> 'yes_no_button',
				'options'		=> array(
					'on'		=> esc_html__( 'Yes', 'tutor-divi-modules' ),
					'off'		=> esc_html__( 'No', 'tutor-divi-modules' )
				),
				'default'		=> 'on',
				'tab_slug'		=> 'general',
				'toggle_slug'	=> 'carousel_settings'
			),
			'autoplay'	=> array(
				'label'			=> esc_html__( 'Auto Play', 'tutor-divi-modules' ),
				'type'			=> 'yes_no_button',
				'options'		=> array(
					'on'		=> esc_html__( 'Yes', 'tutor-divi-modules' ),
					'off'		=> esc_html__( 'No', 'tutor-divi-modules' )
				),
				'default'		=> 'on',
				'tab_slug'		=> 'general',
				'toggle_slug'	=> 'carousel_settings'
			),
			'autoplay_speed'	=> array(
				'label'			=> esc_html__( 'Auto Play Speed', 'tutor-divi-modules' ),
				'type'			=> 'text',
				'default'		=> '5000',
				'description'	=> esc_html( 'Use only numbers for auto play speed', 'tutor-divi-modules' ),
				'tab_slug'		=> 'general',
				'toggle_slug'	=> 'carousel_settings'
			),
			'infinite_loop'	=> array(
				'label'			=> esc_html__( 'Infinite Loop', 'tutor-divi-modules' ),
				'type'			=> 'yes_no_button',
				'options'		=> array(
					'on'		=> esc_html__( 'Yes', 'tutor-divi-modules' ),
					'off'		=> esc_html__( 'No', 'tutor-divi-modules' )
				),
				'default'		=> 'on',
				'tab_slug'		=> 'general',
				'toggle_slug'	=> 'carousel_settings'
			),
			'paush_on_hover'	=> array(
				'label'			=> esc_html__( 'Paush on Hover', 'tutor-divi-modules' ),
				'type'			=> 'yes_no_button',
				'options'		=> array(
					'on'		=> esc_html__( 'Yes', 'tutor-divi-modules' ),
					'off'		=> esc_html__( 'No', 'tutor-divi-modules' )
				),
				'default'		=> 'on',
				'tab_slug'		=> 'general',
				'toggle_slug'	=> 'carousel_settings'
			),
			//advacned tab card toggle
			'card_background_color'	=> array(
				'label'			=> esc_html__( 'Background Color', 'tutor-divi-modules' ),
				'type'			=> 'color-alpha',
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'card'
			),
			'footer_seperator_color'	=> array(
				'label'			=> esc_html__( 'Footer Seperator Color', 'tutor-divi-modules' ),
				'type'			=> 'color-alpha',
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'card'
			),
			'footer_seperator_width'	=> array(
				'label'			=> esc_html__( 'Footer Seperator Width', 'tutor-divi-modules' ),
				'type'			=> 'range',
				'range_settings'=> array(
					'min'	=> '1',
					'max'	=> '100',
					'step'	=> '1'
				),
				'default'		=> '1px',
				'default_unit'	=> 'px',
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'card'
			),
			'card_custom_padding'	=> array(
				'label'			=> esc_html__( 'Padding', 'tutor-divi-modules'),
				'type'			=> 'custom_padding',
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'card'
			),
			//advanced tab image toggle
			'image_spacing'	=> array(
				'label'			=> esc_html__( 'Spacing', 'tutor-divi-modules' ), 
				'type'			=> 'range',
				'range_settings'=> array(
					'min'	=> '1',
					'max'	=> '100',
					'step'	=> '1'
				), 
				'default_unit'	=> 'px',
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'image'
			),
			//advanced tab badge toggle
			'badge_background_color'	=> array(
				'label'			=> esc_html__( 'Background Color', 'tutor-divi-modules' ),
				'type'			=> 'color-alpha',
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'badge'
			),
			'badge_text_color'	=> array(
				'label'			=> esc_html__( 'Text Color', 'tutor-divi-modules' ),
				'type'			=> 'color-alpha',
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'badge'
			),
			'badge_size'	=> array(
				'label'			=> esc_html__( 'Size', 'tutor-divi-modules' ),
				'type'			=> 'range',
				'range_settings'=> array(
					'min'	=> '1',
					'max'	=> '100',
					'step'	=> '1'
				),
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'badge'
			),
			'badge_margin'	=> array(
				'label'			=> esc_html__( 'Margin', 'tutor-divi-modules' ),
				'type'			=> 'range',
				'range_settings'=> array(
					'min'	=> '1',
					'max'	=> '100',
					'step'	=> '1'
				),
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'badge'
			),
			//advanced tab avatar toggle
			'avatar_size'	=> array(
				'label'			=> esc_html__( 'Avatar Size', 'tutor-divi-modules' ),
				'type'			=> 'range',
				'range_settings'=> array(
					'min'	=> '1',
					'max'	=> '100',
					'step'	=> '1'
				),
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'avatar'
			),
			//advanced tab rating toggle
			'star_color'	=> array(
				'label'			=> esc_html__( 'Star Color', 'tutor-divi-modules'),
				'type'			=> 'color-alpha',
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'rating',
			),
			'star_size'	=> array(
				'label'			=> esc_html__( 'Star Size', 'tutor-divi-modules'),
				'type'			=> 'range',
				'default_unit'	=> 'px',
				'default'		=> '14px',
				'range_settings'=> array(
					'min'	=> '1',
					'max'	=> '100',
					'step'	=> '1'
				),
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'rating',
			),
			'star_gap'	=> array(
				'label'			=> esc_html__( 'Gap', 'tutor-divi-modules'),
				'type'			=> 'range',
				'default_unit'	=> 'px',
				'default'		=> '14px',
				'range_settings'=> array(
					'min'	=> '1',
					'max'	=> '100',
					'step'	=> '1'
				),
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'rating',
			),
			//advanced tab arrows toggle

		);

	}

	/**
	 * Get the tutor course author
	 *
	 * @return string
	 */
	public static function get_content( $args = [] ) {
		ob_start();
		include_once dtlms_get_template('course/course_carousel');
		return ob_get_clean();
	}
	

	public function render( $unprocessed_props, $content = null, $render_slug ) {
		
		$output = self::get_content($this->props);
		// Render empty string if no output is generated to avoid unwanted vertical space.
		if ('' === $output) {
			return '';
		}

		return $this->_render_module_wrapper($output, $render_slug);	
	}
}
new CourseCarousel;