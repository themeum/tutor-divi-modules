<?php
/**
 * Course Carousel Module | Tutor Divi Modules
 * @since 1.0.0
 * @author Themeum<www.themeum.com>
*/

use TutorLMS\Divi\Helper;

class CourseCarousel extends ET_Builder_Module {

	public $slug       	= 'tutor_course_carousel';
	public $vb_support 	= 'on';

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
					'css'				=> array(
						'main'	=> '%%order_class%% .tutor-course-loop-title h2 a',
					),
					'hide_text_align'	=> true,
					'tab_slug'			=> 'advanced',
					'toggle_slug'		=> 'title'
				),
				'meta'	=> array(
					'css'				=> array(
						'main'	=> '%%order_class%% .tutor-single-loop-meta i,%%order_class%% .tutor-single-loop-meta span',
					),
					'hide_text_align'	=> true,
					'tab_slug'			=> 'advanced',
					'toggle_slug'		=> 'meta' 
				),
				'category'	=> array(
					'css'				=> array(
						'main'	=> '%%order_class%% .tutor-course-lising-category a',
					),
					'hide_text_align'	=> true,
					'tab_slug'			=> 'advanced',
					'toggle_slug'		=> 'category' 
				),
				'footer'	=> array(
					'css'				=> array(
						'main'	=> '%%order_class%% .tutor-divi-carousel-main-wrap .price',
					),
					'tab_slug'				=> 'advanced',
					'toggle_slug'			=> 'footer' ,
					'hide_text_align'		=> true,
					
				),
				'arrows'	=> array(
					'css'				=> array(
						'main'	=> '%%order_class%% .slick-prev:before, %%order_class%% .slick-next:before',
					),
					'tab_slug'				=> 'advanced',
					'toggle_slug'			=> 'arrows' ,
					'hide_text_align'		=> true,
					'hide_letter_spacing'	=> true,
				),				
				'dots'	=> array(
					'css'				=> array(
						'main'	=> '%%order_class%% .slick-dots li button:before',
					),
					'tab_slug'				=> 'advanced',
					'toggle_slug'			=> 'dots' ,
					'hide_text_align'		=> true,
					'hide_letter_spacing'	=> true,
				),
			),
			
			'button'		=> array(
                'cart_button' => array(
                    'label'         => esc_html__( 'Cart Button', 'tutor-divi-modules' ),
                    'box_shadow'    => array(
                        'css'   => array(
                            'main'  => '%%order_class%% .tutor-loop-cart-btn-wrap a'
                        )
                    ),
                    'css'           => array(
                        'main'  => '%%order_class%% .tutor-loop-cart-btn-wrap a'
                    ),
					'margin_padding' => array(
						'css' => array(
							'important' => 'all',
						),
					),
                    //'use_alignment' => false,
                    'tab_slug'      => 'advanced',
                    'toggle_slug'   => 'cart_button' , 
                    'important'     => true
                ),

			),
			'borders'		=> array(
				'default'	=> array(),
				'card'	=> array(
					'css'			=> array(
						'main'	=> array(
							'border_radii'	=> "%%order_class%% .tutor-divi-carousel-classic .tutor-divi-card,%%order_class%% .tutor-divi-carousel-card .tutor-divi-card,%%order_class%% .tutor-divi-carousel-overlayed .tutor-divi-card,%%order_class%% .tutor-divi-carousel-stacked .tutor-divi-carousel-course-container",
							'border_styles'	=> "%%order_class%% .tutor-divi-carousel-classic .tutor-divi-card,%%order_class%% .tutor-divi-carousel-card .tutor-divi-card,%%order_class%% .tutor-divi-carousel-overlayed .tutor-divi-card,%%order_class%% .tutor-divi-carousel-stacked .tutor-divi-carousel-course-container"
						),
						'important'	=> 'all'
					),
					'tab_slug'		=> 'advanced',
					'toggle_slug'	=> 'card',
					
				),
				'badge'	=> array(
					'css'			=> array(
						'main'	=> array(
							'border_radii'	=> '%%order_class%% .tutor-divi-carousel-main-wrap .tutor-course-loop-level',
							'border_styles'	=> '%%order_class%% .tutor-divi-carousel-main-wrap .tutor-course-loop-level',
						)
					),
					'tab_slug'		=> 'advanced',
					'toggle_slug'	=> 'badge'
				),
				'avatar'	=> array(
					'css'			=> array(
						'main'	=> array(
							'border_radii'	=> '%%order_class%% .tutor-single-course-avatar a img, %%order_class%% .tutor-single-course-avatar a span',
							'border_styles'	=> '%%order_class%% .tutor-single-course-avatar a img, %%order_class%% .tutor-single-course-avatar a span'
						)
					),
					'tab_slug'		=> 'advanced',
					'toggle_slug'	=> 'avatar'
				),
				'arrows'	=> array(
					'css'	=> array(
						'main'	=> array(
							'border_radii'	=> '%%order_class%% .slick-prev:before, %%order_class%% .slick-next:before',
							'border_styles'	=> '%%order_class%% .slick-prev:before, %%order_class%% .slick-next:before'
						),
						'important'	=> true
					),
					'tab_slug'		=> 'advanced',
					'toggle_slug'	=> 'arrows'
				)
			),
			'margin_padding'=> array(

			),
			'background'    => array(
                'css'   => array(
                    'main'  => '%%order_class%% .tutor-divi-carousel-classic .tutor-course-header:before,%%order_class%% .tutor-divi-carousel-card .tutor-course-header:before,%%order_class%% .tutor-divi-carousel-stacked .tutor-course-header:before,%%order_class%% .tutor-divi-carousel-overlayed .tutor-divi-card:before',
                    'important' => true
                ),
                'settings'  => array(
                    'tab_slug'      => 'advanced',
                    'toggle_slug'   => 'image'
                ),
                'use_background_video'  => false
            ),
			'filters' => array(
				'css'                  => array(
					'main' => '%%order_class%% .tutor-course-header a img',
				),
			),
			'text'			=> false,
			'max_width'		=> false,
			'transform'		=> false
			
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
				'description'	=> esc_html__( 'No: of slides that will display on desktop view', 'tutor-divi-modules' ),
				'options'		=> array(
					'3'	=>		 esc_html__( 'Default', 'tutor-divi-modules' ),
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
				'default'		=> '3',
				'tab_slug'		=> 'general',
				'toggle_slug'	=> 'layout',
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
				'description'	=> esc_html__( 'Input -1 for all courses', 'tutor-divi-modules'),
				'default'		=> '5',
				'tab_slug'		=> 'general', 
				'toggle_slug'	=> 'query',
			),
			'category_includes'	=> array(
				'label'			=> esc_html__( 'Category', 'tutor-divi-modules' ),
				'type'			=> 'multiple_checkboxes',
				'options'		=> tutor_divi_course_categories(),
				'description'	=> esc_html__( 'Leave checkboxes unchecked to select all', 'tutor-divi-modules'),
				'tab_slug'		=> 'general',
				'toggle_slug'	=> 'query'
			),			
			'author_includes'	=> array(
				'label'			=> esc_html__( 'Author', 'tutor-divi-modules' ),
				'type'			=> 'multiple_checkboxes',
				'options'		=> tutor_divi_course_authors(),
				'description'	=> esc_html__( 'Leave checkboxes unchecked to select all', 'tutor-divi-modules'),
				'tab_slug'		=> 'general',
				'toggle_slug'	=> 'query'
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
				'default'		=> 'off',
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
				'type'			=> 'range',
				'defaunt_unit'	=> 'px',
				'default'		=> '0px',
				'range_settings'=> array(
					'min'	=> '0',
					'max'	=> '100',
					'step'	=> '1'
				),
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
				'default'		=> '0px',
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
				'default_unit'	=> 'px',
				'range_settings'=> array(
					'min'	=> '1',
					'max'	=> '300',
					'step'	=> '1'
				),
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'badge'
			),
			'badge_margin'	=> array(
				'label'			=> esc_html__( 'Margin', 'tutor-divi-modules' ),
				'type'			=> 'range',
				'default_unit'	=> 'px',
				'default'		=> '0px',
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
				'default_unit'	=> 'px',
				'range_settings'=> array(
					'min'	=> '1',
					'max'	=> '200',
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
				'range_settings'=> array(
					'min'	=> '1',
					'max'	=> '100',
					'step'	=> '1'
				),
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'rating',
			),
			//computed
			'__courses'	=> array(
				'type'				=> 'computed',
				'computed_callback'	=> array(
					'CourseCarousel',
					'get_props'
				),
				'computed_depends_on'	=> array(
					'category_includes',
					'author_includes',
					'limit',
					'order_by',
					'order',
					'image_size'
				),
				'computed_minimum'		=> array(
					'category_includes',
					'author_includes',
					'limit',
					'order_by',
					'order',
					'image_size'					
				)
			),
			//advanced tab footer toggle
			'footer_background'	=> array(
				'label'			=> esc_html__( 'Background Color', 'tutor-divi-modules' ),
				'type'			=> 'color-alpha',
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'footer'
			),
			'footer_padding'	=> array(
				'label'			=> esc_html__( 'Padding', 'tutor-divi-modules' ),
				'type'			=> 'range',
				'default_unit'	=> 'px',
				'range_settings'=> array(
					'min'	=> '1',
					'max'	=> '100',
					'step'	=> '1'
				),
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'footer'
			),
			//arrows toggle
			'arrows_padding'	=> array(
				'label'			=> esc_html__( 'Padding', 'tutor-divi-modules' ),
				'type'			=> 'range',
				'default_unit'	=> 'px',
				'range_settings'=> array(
					'min'	=> '1',
					'max'	=> '100',
					'step'	=> '1'
				),
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'arrows',
				'priority' => 100,
			),

			//dots toggle
			'dots_alignment'	=> array(
				'label'			=> esc_html__( 'Alignment', 'tutor-divi-modules' ),
				'type'			=> 'text_align',
				'options'		=> et_builder_get_text_orientation_options( array('justified') ),
				'default'		=> 'center',
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'dots'	
			),				

			'dots_space'	=> array(
				'label'			=> esc_html__( 'Space Between', 'tutor-divi-modules' ),
				'type'			=> 'range',
				'default'		=> '5px',
				'default_unit'	=> 'px',
				'range_settings'=> array(
					'min'	=> '0',
					'max'	=> '100',
					'step'	=> '1'
				),
				'tab_slug'		=> 'advanced',
				'toggle_slug'	=> 'dots'	
			),	

		);

	}

	/**
	 * @return array of courses
	 * @return false if course not found
	 */
	public static function get_props( $args = [] ) {
		$post_type		= tutor()->course_post_type;
		$post_status	= 'publish';
		$limit			= isset($args['limit']) ? $args['limit'] : -1;
		$order_by		= isset($args['order_by']) ? $args['order_by'] : 'date';
		$order			= isset($args['order']) ? $args['order'] : 'DESC';
		$image_size		= isset($args['image_size']) ? $args['image_size'] : 'medium_large';

		//available categories
		$available_cat      = tutor_divi_course_categories();
		//sort be key asc order
		ksort($available_cat);

		//user's selected category
		$category_includes  = $args['category_includes'];
		$category_includes  = explode('|', $category_includes);

		$category_terms     = tutor_divi_get_user_selected_terms( $available_cat, $category_includes );

		$available_author   = tutor_divi_course_authors();
		ksort($available_author);

		$author_includes        = $args['author_includes'];
		$author_includes        = explode('|', $author_includes);
		$selected_author_ids    = tutor_divi_get_user_selected_authors($available_author, $author_includes);

		$query_args	= array(
			'post_type'         => $post_type,
			'post_status'       => $post_status,
			'posts_per_page'    => sanitize_text_field( $limit ),
			'order_by'          => sanitize_text_field( $order_by ),
			'order'             => sanitize_text_field( $order )
		);

		if( count($selected_author_ids) > 0) {
		    $query_args['author__in']    = $selected_author_ids;
		}

		if( count($category_terms) > 0 ) {
		       $query_args['tax_query'] = array(
		        'relation' => 'AND',
		        array(
		            'taxonomy' => 'course-category',
		            'field'    => 'term_id',
		            'terms'    => $category_terms,
		            'operator' => 'IN',
		        ),
		    );    
		}

		$courses = [];

		$query	= new WP_Query( $query_args );

		if($query->have_posts()) {
		
			//get all required post contents
			foreach($query->posts as $post) {

				$thumbnail = get_the_post_thumbnail_url( $post->ID, $image_size) ? get_the_post_thumbnail_url( $post->ID, $image_size) : get_tutor_course_thumbnail($image_size, $url = true);
				
				$category = wp_get_post_terms($post->ID,'course-category');
	
				$tag = wp_get_post_terms($post->ID,'course-tag');
					
				$post->course_level		= get_tutor_course_level( $post->ID );
				
				$post->course_category	= $category;
				
				$post->course_tag 		= $tag;
			
				$post->post_thumbnail	= $thumbnail ;
				
				$post->author_avatar	= tutor_utils()->get_tutor_avatar( $post->post_author , array('force_default' => true) );

				$post->course_duration 	= get_tutor_course_duration_context( $post->ID );

				$post->enroll_count 	= tutor_utils()->count_enrolled_users_by_course( $post->ID );

				$post->author_name		= get_the_author_meta('display_name', $post->post_author);

				$post->course_rating	= tutils()->get_course_rating( $post->ID );

				$post->loop_price		= self::get_course_price( $post->ID );

				$post->woo_price_html	= self::get_price_html( $post->ID );

				$post->woo_currency		= get_woocommerce_currency_symbol();

				$post->is_enrolled		= tutils()->is_enrolled($post->ID , get_current_user_id() );

				array_push($courses, $post);
	
			}
			wp_reset_postdata();
			return $courses;
		} else {
			return false;
		}
		
	}

	/**
	 * Get tutor course product price
	 * @return array
	 * @since 1.0.0
	 */
	static function get_course_price( $course_id ) {
		$product_id = tutor_utils()->get_course_product_id( $course_id );
		$product    = wc_get_product( $product_id );
		$price 		= $product ? $product->get_regular_price() : __( 'Free', 'tutor-divi-modules' ) ;	
		$sale_price = $product ? $product->get_sale_price() : '' ;
		return array(
			'regular_price'		=> $price, 
			'sale_price'		=> $sale_price
		);
	} 

	static function get_price_html( $course_id ) {
		$product_id = tutor_utils()->get_course_product_id( $course_id );
		$product    = wc_get_product( $product_id );
		$price 		= $product ? $product->get_price_html() : __( 'Free', 'tutor-divi-modules' ) ;	
		return $price;
	} 

	/**
	 * Get the tutor course author
	 *
	 * @return string
	 */
	public static function get_content( $args = [] ) {
		ob_start();
		include dtlms_get_template('course/course_carousel');
		return ob_get_clean();
	}
	

	public function render( $unprocessed_props, $content = null, $render_slug ) {
		//selectors
		$wrapper			= "%%order_class%% .tutor-divi-carousel-main-wrap";
		$card_selector		= $wrapper." .tutor-divi-card";
		$footer_selector	= $wrapper." .tutor-loop-course-footer";
		$badge_selector		= $wrapper." .tutor-course-loop-level";
		$avatar_selector    = $wrapper." .tutor-single-course-avatar a img," .$wrapper." .tutor-single-course-avatar a span";

		$star_selector         	= $wrapper.' .tutor-star-rating-group i';
        $star_wrapper_selector 	= $wrapper.' .tutor-star-rating-group';
		$cart_button_selector	= $wrapper.' .tutor-loop-cart-btn-wrap a';
		$arrows_selector		= '%%order_class%% .slick-prev:before, %%order_class%% .slick-next:before';
		$dots_wrapper_selector	= '%%order_class%% .slick-dots';

		//props
		$skin 						= $this->props['skin'];
		$hover_animation			= $this->props['hover_animation'];
		$card_background_color		= $this->props['card_background_color'];

		$footer_seperator_width		= $this->props['footer_seperator_width'];
		$footer_seperator_color		= $this->props['footer_seperator_color'];

		$card_custom_padding		= $this->props['card_custom_padding'];

		$image_spacing				= $this->props['image_spacing'];

		$badge_background_color		= $this->props['badge_background_color'];
		$badge_text_color			= $this->props['badge_text_color'];
		$badge_size					= $this->props['badge_size'];
		$badge_margin				= $this->props['badge_margin'];

		$avatar_size				= $this->props['avatar_size'];

		$star_color					= $this->props['star_color'];
		$star_size					= $this->props['star_size'];
		$star_gap					= $this->props['star_gap'];

		$footer_background			= $this->props['footer_background'];
		$footer_padding				= $this->props['footer_padding'];

		$dots_alignment				= $this->props['dots_alignment'];
		$dots_space					= $this->props['dots_space'];

		$arrows_padding				= $this->props['arrows_padding'];

		//set styles
		//margin for hover animation
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'		=> '%%order_class%%
					.tutor-divi-card.hover-animation',
					'declaration'	=> 'margin-top: 7px;'
			)
		);		
		//make carousel item equal height
		if( $skin === 'classic' || $skin === 'card' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '%%order_class%% .slick-track',
					'declaration'	=> 'display: -ms-flexbox;
					    display: -webkit-flex;
					    display: flex;
					    -webkit-flex-direction: row;
					    -ms-flex-direction: row;
					    flex-direction: row;
					    -webkit-flex-wrap: nowrap;
					    -ms-flex-wrap: nowrap;
					    flex-wrap: nowrap;
					    -webkit-justify-content: space-between;
					    -ms-flex-pack: justify;
					    justify-content: space-between;
					    -webkit-align-content: stretch;
					    -ms-flex-line-pack: stretch;
					    align-content: stretch;
					    -webkit-align-items: stretch;
					    -ms-flex-align: stretch;
					    align-items: stretch;
						'
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '%%order_class%% .slick-slide',
					'declaration'	=> 'height: inherit !important;'
				)
			);			

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '%%order_class%% .tutor-divi-card',
					'declaration'	=> 'display: flex; flex-direction: column; justify-content: space-between; height: 100%;'
				)
			);
		}

		//classic
		if( $skin === 'classic') {		

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '%%order_class%% .tutor-divi-carousel-classic .tutor-divi-card:hover',
					'declaration'	=> '-webkit-box-shadow: 0px 5px 2px #ebebeb;
	        			box-shadow: 0px 5px 2px #ebebeb;'
				)
			);
		}
		//card style
		if( $skin === 'card' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '%%order_class%% .tutor-divi-carousel-card .tutor-divi-card',
					'declaration'	=> 'display: -webkit-box;
						display: -ms-flexbox;
						display: flex;
						-webkit-box-orient: vertical;
						-webkit-box-direction: normal;
						    -ms-flex-direction: column;
						        flex-direction: column;
						-webkit-box-pack: justify;
						    -ms-flex-pack: justify;
						        justify-content: space-between;
						height: 100%;
						-webkit-box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.08);
						        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.08);
						overflow: hidden;'
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '%%order_class%% .tutor-divi-carousel-card .tutor-divi-card:hover',
					'declaration'	=> '-webkit-box-shadow:0px 24px 34px -5px rgba(0, 0, 0, 0.1);
	      				box-shadow:0px 24px 34px -5px rgba(0, 0, 0, 0.1);'
				)
			);
		}		

		if( $skin === 'stacked' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '%%order_class%% .tutor-divi-carousel-stacked .tutor-course-header',
					'declaration'	=> 'overflow: hidden; z-index: 1;'
				)
			);			

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '%%order_class%% .tutor-divi-carousel-stacked .tutor-divi-card',
					'declaration'	=> 'overflow: visible !important;'
				)
			);			

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '%%order_class%% .tutor-divi-carousel-stacked .tutor-divi-carousel-course-container',
					'declaration'	=> 'z-index: 99;
						margin-top: -80px;
						background: white;
						width: 80%;
						margin-left: auto;
						margin-right: auto;
						position: relative;
						border-radius: 10px;
						-webkit-box-shadow: 0px 34px 28px -20px rgba(0, 0, 0, 0.15);
						        box-shadow: 0px 34px 28px -20px rgba(0, 0, 0, 0.15);'
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '%%order_class%% .tutor-divi-carousel-stacked .tutor-divi-carousel-course-container:hover',
					'declaration'	=> '-webkit-box-shadow: 0px 54px 58px -20px rgba(0, 0, 0, 0.15);
	        			box-shadow: 0px 54px 58px -20px rgba(0, 0, 0, 0.15);'
				)
			);
		}		


		if( $skin === 'overlayed' ) {

			//style container
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '%%order_class%% .tutor-divi-carousel-overlayed .tutor-divi-card',
					'declaration'	=> 'background-size: cover;
						background-repeat: no-repeat;
						position: relative;
						height: 300px;
						overflow: hidden;
						'
				)
			);			

			//set befault overlay
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '%%order_class%% .tutor-divi-carousel-overlayed .tutor-divi-card:before',
					'declaration'	=> '	background-image: -o-linear-gradient(top, rgba(0, 0, 0, 0.0001) 0%, #000000 100%);
						background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(0, 0, 0, 0.0001)), to(#000000));
						background-image: linear-gradient(180deg, rgba(0, 0, 0, 0.0001) 0%, #000000 100%) ;
						
						position: absolute;
					    content: "";
					    left: 0;
					    top: 0;
					    bottom: 0;
					    right: 0;
					    z-index: 3;
					    -webkit-transition: .4s;
					    -o-transition: .4s;
					    transition: .4s;	'
				)
			);	

			//card header style
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '%%order_class%% .tutor-divi-carousel-overlayed .tutor-course-header',
					'declaration'	=> 'z-index: 2;
						height: 100%;'
				)
			);				

			//container style
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '%%order_class%% .tutor-divi-carousel-overlayed .tutor-divi-carousel-course-container',
					'declaration'	=> 'position: absolute;
						z-index: 99;
						width: 100%;
						bottom:0 !important;'
				)
			);	

			//all text style for overlayed 	
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '%%order_class%% .tutor-divi-card .tutor-rating-count,
                        %%order_class%% .tutor-divi-card .tutor-course-loop-title h2 a,
                        %%order_class%% .tutor-divi-card .tutor-course-loop-meta,
                        %%order_class%% .tutor-divi-card .tutor-loop-author>div a,
                        %%order_class%% .tutor-divi-card .etlms-loop-cart-btn-wrap a,
                        %%order_class%% .tutor-divi-card .price, %%order_class%% .tutor-loop-cart-btn-wrap a, %%order_class%% .tutor-loop-cart-btn-wrap a:before ',
					'declaration'	=> 'color: #fff !important;'
				)
			);
			//hover overlayed
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '%%order_class%% .tutor-divi-carousel-overlayed .tutor-divi-card:hover',
					'declaration'	=> '-webkit-box-shadow: 0px 8px 28px 0px #d0d0d0;
	        			box-shadow: 0px 8px 28px 0px #d0d0d0;'
				)
			);
		}
		//skin layout styles end

		//card style
		if( '' !== $card_background_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $card_selector,
					'declaration'	=> sprintf(
						'background-color: %1$s;',
						$card_background_color
					)
				)
			);
		}		

		if( '' !== $footer_seperator_width ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $footer_selector,
					'declaration'	=> sprintf(
						'border-top: %1$s; border-style: solid;',
						$footer_seperator_width
					)
				)
			);
		}		

		if( '' !== $footer_seperator_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $card_selector,
					'declaration'	=> sprintf(
						'border-color: %1$s;',
						$footer_seperator_color
					)
				)
			);
		}

		if( '' !== $card_custom_padding ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $card_selector,
					'declaration'	=> sprintf(
						'padding: %1$s;',
						$card_custom_padding
					)
				)
			);
		}

		//card hover animation
		if( 'on' == $hover_animation ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '%%order_class%% .tutor-divi-card.hover-animation',
					'declaration'	=> 'position: relative; top: 0; z-index: 99; transition: top .5s'
				)
			);		

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '%%order_class%% .tutor-divi-card.hover-animation:hover',
					'declaration'	=> 'top: -5px;'
				)
			);
		}
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'		=> '#test h3',
				'declaration'	=> 'color: red;'
			)
		);

		//image toggles
		if( '' !== $image_spacing ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '%%order_class%% .tutor-course-header a img',
					'declaration'	=> sprintf(
						'padding: %1$s;',
						$image_spacing
					)
				)
			);
		}

		//badge toggle
		if( '' !== $badge_background_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $badge_selector,
					'declaration'	=> sprintf(
						'background-color: %1$s;',
						$badge_background_color
					)
				)
			);
		}		

		if( '' !== $badge_text_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $badge_selector,
					'declaration'	=> sprintf(
						'color: %1$s;',
						$badge_text_color
					)
				)
			);
		}		

		if( '' !== $badge_margin ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $badge_selector,
					'declaration'	=> sprintf(
						'margin: %1$s;',
						$badge_margin
					)
				)
			);
		}		

		if( '' !== $badge_size ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $badge_selector,
					'declaration'	=> sprintf(
						'width: %1$s;',
						$badge_size
					)
				)
			);
		}

		//avatar toggle
		if( '' !== $avatar_size ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $avatar_selector,
					'declaration'	=> sprintf(
						'width: %1$s;height: %1$s;',
						$avatar_size
					)
				)
			);
		}	

		//rating toggle
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'		=> $star_wrapper_selector,
				'declaration'	=> 'display: flex;'
			)
		);

		if( '' !== $star_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $star_selector,
					'declaration'	=> sprintf(
						'color: %1$s;',
						$star_color
					)
				)
			);
		}			

		if( '' !== $star_size ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $star_selector,
					'declaration'	=> sprintf(
						'font-size: %1$s;',
						$star_size
					)
				)
			);
		}			

		if( '' !== $star_gap ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $star_wrapper_selector,
					'declaration'	=> sprintf(
						'column-gap: %1$s;',
						$star_gap
					)
				)
			);
		}
		
		//footer toggle
		if( '' !== $footer_background ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $footer_selector,
					'declaration'	=> sprintf(
						'background-color: %1$s;',
						$footer_background
					)
				)
			);
		}

		if( '' !== $footer_padding ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $footer_selector,
					'declaration'	=> sprintf(
						'padding: %1$s;',
						$footer_padding
					)
				)
			);
		}

		if( '' !== $footer_background ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $footer_selector,
					'declaration'	=> sprintf(
						'background-color: %1$s;',
						$footer_background
					)
				)
			);
		}

		//cart button toggle
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'		=> $cart_button_selector,
				'declaration'	=> 'border-style: solid;'
			)
		);

		//arrows toggle
		//default arrow color #000
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'		=> $arrows_selector,
				'declaration'	=> 'color: #000;'
			)
		);

		if( '' !== $arrows_padding ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $arrows_selector,
					'declaration'	=> sprintf(
						'padding: %1$s;',
						$arrows_padding
					)	
				)
			);			
		}

		//dots toggle
		if( 'left' === $dots_alignment ) {
			$dots_alignment = 'flex-start';
		} else if( 'right' === $dots_alignment ) {
			$dots_alignment = 'flex-end';
		}
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'		=> $dots_wrapper_selector,
				'declaration'	=> sprintf(
					'display: flex !important; justify-content: %1$s; column-gap: %2$s;',
					$dots_alignment,
					$dots_space
				) 
			)
		);
		//add padding if thumbnail hide
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'		=> '%%order_class%% .hide-thumbnail .tutor-divi-carousel-course-container',
				'declaration'	=> 'padding-top: 30px;'
			)
		);
		//filter
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'		=> '%%order_class%% .tutor-course-header a img',
				'declaration'	=> sprintf(
					'filter: hue-rotate(%1$s) saturate(%2$s) brightness(%3$s) invert(%4$s) sepia(%5$s) opacity(%6$s) blur(%7$s) contrast(%8$s);',
					$this->props['filter_hue_rotate'],
					$this->props['filter_saturate'],
					$this->props['filter_brightness'],
					$this->props['filter_invert'],
					$this->props['filter_sepia'],
					$this->props['filter_opacity'],
					$this->props['filter_blur'],
					$this->props['filter_contrast']
				)
			)
		);
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'		=> '.tutor_course_carousel_0,.tutor_course_carousel_1,.tutor_course_carousel_2,.tutor_course_carousel_3,.tutor_course_carousel_4,.tutor_course_carousel_5,.tutor_course_carousel_6',
				'declaration'	=> 'filter: none !important;'
			)
		);		
		//set styles end

		$output = self::get_content($this->props);
		// Render empty string if no output is generated to avoid unwanted vertical space.
		if ('' === $output) {
			return '';
		}

		return $this->_render_module_wrapper($output, $render_slug);	
	}
}
new CourseCarousel;