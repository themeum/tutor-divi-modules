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
					'footer'	=> esc_html__( 'Footer', 'tutor-divi-modules' ),
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
			),
			'text'			=> false,
			'button'		=> false,
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
				'option_category'	=> 'basic_option',
				'tab_slug'			=> 'general',
				'toggle_slug'		=> 'layout'
			),
			'slide_to_show'	=> array(
				'label'			=> esc_html__( 'Slides to Show', 'tutor-divi-modules' ),
				'type'			=> 'select',
				'options'		=> array(
					'default'	=> esc_html__( 'Default', 'tutor-divi-modules' ),
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
				),
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
					'desc'		=> esc_html__( 'DESC', 'tutor-divi-modules' ),
					'asc'		=> esc_html__( 'ASC', 'tutor-divi-modules' )
				),
				'default'		=> 'desc',
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
			//general tab enroll_button toggle
			'enroll_btn_align'	=> array(
				'label'				=> esc_html__('Alignment', 'tutor-divi-modules'),
				'type'				=> 'text_align',
				'option_category'	=> 'configuration',
				'options'			=> et_builder_get_text_orientation_options( array( 'justified' ) ),
				'default'			=> 'left',
				'tab_slug'			=> 'general',
				'toggle_slug'		=> 'enroll_button',
				'mobile_options'	=> true
			),
			'button_type'	=> array(
				'label'		=> esc_html__( 'Button Type', 'tutor-divi-modules' ),
				'type'		=> 'select',
				'options'	=> array(
					'default'		=> esc_html__( 'Default', 'tutor-divi-modules' ),
					'default_cart'	=> esc_html__( 'Default with Cart', 'tutor-divi-modules' ),
					'text'			=> esc_html__( 'Text', 'tutor-divi-modules' ),
					'text_cart'		=> esc_html__( 'Text with Cart', 'tutor-divi-modules' ),
				),
				'tab_slug'		=> 'general',
				'toggle_slug'	=> 'enroll_button',
			),
			'enroll_btn_icon' => array(
				'label'             => esc_html__( 'Icon', 'tutor-divi-modules' ),
				'type'              => 'select_icon',
				'default'			=> 'N',
				'class'				=> array( 'et-pb-font-icon' ),
				'option_category'   => 'basic_option',
				'tab_slug'			=> 'general',
				'toggle_slug'     	=> 'enroll_button',	
				'show_if'			=> array(
					'button_type'	=> array('default_cart', 'text_cart')
				)	
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
			'background_color'	=> array(
				'label'			=> esc_html__( 'Label', 'tutor-divi-modules' ),
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
		);

	}

	public function render( $unprocessed_props, $content = null, $render_slug ) {
        return sprintf(
            '
            <h1>%s</h1>
            <p>%s</p>
            ', 
            $this->props['tutor_course_carousel_heading'], 
            $this->props['content']
        );
        
	}
}
new CourseCarousel;