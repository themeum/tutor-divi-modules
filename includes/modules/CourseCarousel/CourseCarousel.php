<?php
/**
 * Course Carousel Module | Tutor Divi Modules
 *
 * @since 1.0.0
 * @author Themeum<www.themeum.com>
 * @package TutorDiviModules\CourseCarousel
 */

defined( 'ABSPATH' ) || exit;

/**
 * Course Carousel Modules
 */
class CourseCarousel extends ET_Builder_Module {

	/**
	 * Course List slug
	 *
	 * @var $slug
	 */
	public $slug = 'tutor_course_carousel';

	/**
	 * Visual Builder support
	 *
	 * @var $vb_support
	 */
	public $vb_support = 'on';
	public $icon_path;
	/**
	 * Module Credits (Appears at the bottom of the module settings modal)
	 *
	 * @var $module_credits
	 */
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
		$this->name      = esc_html__( 'Tutor Course Carousel', 'tutor-lms-divi-modules' );
		$this->icon_path = plugin_dir_path( __FILE__ ) . 'icon.svg';
		$wrapper         = '%%order_class%% .dtlms-carousel-loop-wrap';
		$badge_selector  = $wrapper . ' .tutor-course-difficulty-level';
		$avatar_selector = $wrapper . ' .tutor-avatar';
		$course_title_selector = $wrapper . ' .tutor-course-name';
		$meta_selector = "$wrapper .tutor-meta.dtlms-course-duration-meta .tutor-meta-icon, $wrapper .tutor-meta.dtlms-course-duration-meta .tutor-meta-level, $wrapper .tutor-meta.dtlms-course-duration-meta .tutor-meta-value ";
		$category_selector  = $wrapper .' .dtlms-course-category-meta';
		$add_to_cart_button = '%%order_class%% .tutor-btn.add_to_cart_button';
		// settings modal toggles.
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'layout'            => esc_html__( 'Layout', 'tutor-lms-divi-modules' ),
					'query'             => esc_html__( 'Query', 'tutor-lms-divi-modules' ),
					'enroll_button'     => esc_html__( 'Enroll Button', 'tutor-lms-divi-modules' ),
					'carousel_settings' => esc_html__( 'Carousel Settings', 'tutor-lms-divi-modules' ),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'card'        => esc_html__( 'Card', 'tutor-lms-divi-modules' ),
					'image'       => esc_html__( 'Image', 'tutor-lms-divi-modules' ),
					'badge'       => esc_html__( 'Badge', 'tutor-lms-divi-modules' ),
					'avatar'      => esc_html__( 'Avatar', 'tutor-lms-divi-modules' ),
					'title'       => esc_html__( 'Title', 'tutor-lms-divi-modules' ),
					'meta'        => esc_html__( 'Meta', 'tutor-lms-divi-modules' ),
					'category'    => esc_html__( 'Category', 'tutor-lms-divi-modules' ),
					'rating'      => esc_html__( 'Rating', 'tutor-lms-divi-modules' ),
					'footer'      => esc_html__( 'Footer', 'tutor-lms-divi-modules' ),
					'cart_button' => esc_html__( 'Cart Button', 'tutor-lms-divi-modules' ),
					'arrows'      => esc_html__( 'Arrows', 'tutor-lms-divi-modules' ),
					'dots'        => esc_html__( 'Dots', 'tutor-lms-divi-modules' ),
					'card_body'   => esc_html__( 'Card Body', 'tutor-lms-divi-modules' ),
					'bookmark'    => esc_html__( 'Bookmark', 'tutor-lms-divi-modules' )
				),
			),
		);

		// advanced fields configuration.

		$this->advanced_fields = array(
			'fonts'          => array(
				'card_title'    => array(
					'css'             => array(
						'main' => $course_title_selector,
						'important' => true
					),
					'hide_text_align' => true,
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'title',
				),
				'meta'     => array(
					'css'             => array(
						'main' => $meta_selector,
					),
					'hide_text_align' => true,
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'meta',
				),
				'category' => array(
					'css'             => array(
						'main' => $category_selector,
					),
					'hide_text_align' => true,
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'category',
				),
				'footer'     => array(
					'label'           => esc_html( 'Price', 'tutor-lms-divi-modules' ),
					'css'             => array(
						'main' => '%%order_class%% ins .woocommerce-Price-amount',
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'footer',
					'hide_text_align' => true,
				),
				'footer_sale_price'     => array(
					'label'           => esc_html( 'Sell Price', 'tutor-lms-divi-modules' ),
					'css'             => array(
						'main' => '%%order_class%% del .woocommerce-Price-amount',
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'footer',
					'hide_text_align' => true,
				),
				'arrows'   => array(
					'css'                 => array(
						'main' => '%%order_class%% .slick-prev:before, %%order_class%% .slick-next:before',
					),
					'tab_slug'            => 'advanced',
					'toggle_slug'         => 'arrows',
					'hide_text_align'     => true,
					'hide_letter_spacing' => true,
				),
				'dots'     => array(
					'css'                 => array(
						'main' => '%%order_class%% .slick-dots li button:before',
					),
					'tab_slug'            => 'advanced',
					'toggle_slug'         => 'dots',
					'hide_text_align'     => true,
					'hide_letter_spacing' => true,
				),
				'bookmark' => array(
					'css'                 => array(
						'main' => '%%order_class%% .tutor-course-bookmark i:before',
					),
					'tab_slug'            => 'advanced',
					'toggle_slug'         => 'bookmark',
					'hide_text_align'     => true,
					'hide_letter_spacing' => true,
				)
			),

			'button'         => array(
				'add_to_cart_button'   => array(
					'label'          => esc_html__( 'Add to Cart Button', 'tutor-lms-divi-modules' ),
					'box_shadow'     => array(
						'css' => array(
							'main' => $add_to_cart_button,
						),
					),
					'css'            => array(
						'main' => $add_to_cart_button,
					),
					'margin_padding' => array(
						'css' => array(
							'important' => 'all',
						),
					),
					'use_alignment'  => false,
					'hide_icon'      => true,
					'tab_slug'       => 'advanced',
					'toggle_slug'    => 'footer',
					'important'      => true,
				),
				'enroll_course_button' => array(
					'label'          => esc_html__( 'Enroll Course/ Continue Learning/ Start Learning/ Download Certificate Button', 'tutor-lms-divi-modules' ),
					'box_shadow'     => array(
						'css' => array(
							'main' => '%%order_class%% .tutor-card-footer .tutor-btn',
						),
					),
					'css'            => array(
						'main' => '%%order_class%% .tutor-card-footer .tutor-btn',
					),
					'margin_padding' => array(
						'css' => array(
							'important' => 'all',
						),
					),
					'use_alignment'  => false,
					'hide_icon'      => true,
					'tab_slug'       => 'advanced',
					'toggle_slug'    => 'footer',
					'important'      => true,
				),
			),
			'borders'        => array(
				'default' => array(),
				'card'    => array(
					'css'         => array(
						'main'      => array(
							'border_radii'  => $wrapper . ' .tutor-course-card',
							'border_styles' => $wrapper . ' .tutor-course-card',
						),
						'important' => 'all',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'card',

				),
				'card_body'    => array(
					'css'         => array(
						'main'      => array(
							'border_radii'  => $wrapper . ' .tutor-course-card .tutor-card-body',
							'border_styles' => $wrapper . ' .tutor-course-card .tutor-card-body',
						),
						'important' => 'all',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'card',
					'label_prefix' => 'Card Body'
				),
				'badge'   => array(
					'css'         => array(
						'main' => array(
							'border_radii'  => $badge_selector,
							'border_styles' => $badge_selector,
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'badge',
				),
				'avatar'  => array(
					'css'         => array(
						'main' => array(
							'border_radii'  => $avatar_selector,
							'border_styles' => $avatar_selector,
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'avatar',
				),
				'arrows'  => array(
					'css'         => array(
						'main'      => array(
							'border_radii'  => '%%order_class%% .slick-prev:before, %%order_class%% .slick-next:before',
							'border_styles' => '%%order_class%% .slick-prev:before, %%order_class%% .slick-next:before',
						),
						'important' => true,
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'arrows',
				),
				'footer_border' => array(
					'css'         => array(
						'main'      => array(
							'border_radii'  => '%%order_class%% .tutor-card-footer:not(.tutor-btn)',
							'border_styles' => '%%order_class%% .tutor-card-footer:not(.tutor-btn)',
						),
						'important' => true,
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'footer',
					'label_prefix'=> 'Footer',
				),
				'enroll_course_button_border' => array(
					'css'         => array(
						'main'      => array(
							'border_radii'  => '%%order_class%% .tutor-card-footer .tutor-btn',
							'border_styles' => '%%order_class%% .tutor-card-footer .tutor-btn',
						),
						'important' => true,
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'footer',
					'label_prefix'=> 'Button',
				),
				'bookmark_border' => array(
					'css'         => array(
						'main'      => array(
							'border_radii'  => '%%order_class%% .tutor-course-bookmark',
							'border_styles' => '%%order_class%% .tutor-course-bookmark',
						),
						'important' => true,
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'bookmark',
				)
			),
			'margin_padding' => array(),
			'background'     => array(
				'css'                  => array(
					'main'      => '%%order_class%% .tutor-course-thumbnail img',
					'important' => true,
				),
				'settings'             => array(
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'image',
				),
				'use_background_video' => false,
			),
			'filters'        => array(
				'css' => array(
					'main' => '%%order_class%% .tutor-course-thumbnail img',
				),
			),
			'text'           => false,
			'max_width'      => false,
			'transform'      => false,
			// 'button'      => false

		);

	}

	/**
	 * Fields configuration
	 *
	 * @since 1.0.0
	 */
	public function get_fields() {
		return array(
			// general tab layout toggle.
			'skin'                   => array(
				'label'           => esc_html__( 'Skin' ),
				'type'            => 'select',
				'options'         => array(
					'classic'   => esc_html__( 'Classic', 'tutor-lms-divi-modules' ),
					'card'      => esc_html__( 'Card', 'tutor-lms-divi-modules' ),
					'stacked'   => esc_html__( 'Stacked', 'tutor-lms-divi-modules' ),
					'overlayed' => esc_html__( 'Overlayed', 'tutor-lms-divi-modules' ),
				),
				'default'         => 'classic',
				'option_category' => 'basic_option',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'layout',
			),
			'slides_to_show'         => array(
				'label'       => esc_html__( 'Slides to Show', 'tutor-lms-divi-modules' ),
				'type'        => 'select',
				'description' => esc_html__( 'No: of slides that will display on desktop view', 'tutor-lms-divi-modules' ),
				'options'     => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
				),
				'default'     => '3',
				'tab_slug'    => 'general',
				'toggle_slug' => 'layout',
			),
			'hover_animation'        => array(
				'label'       => esc_html__( 'Show Animation', 'tutor-lms-divi-modules' ),
				'type'        => 'yes_no_button',
				'default'     => 'on',
				'options'     => array(
					'on'  => esc_html__( 'Show', 'tutor-lms-divi-modules' ),
					'off' => esc_html__( 'Hide', 'tutor-lms-divi-modules' ),
				),
				'tab_slug'    => 'general',
				'toggle_slug' => 'layout',
			),
			'show_image'             => array(
				'label'       => esc_html__( 'Show Image', 'tutor-lms-divi-modules' ),
				'type'        => 'yes_no_button',
				'default'     => 'on',
				'options'     => array(
					'on'  => esc_html__( 'Show', 'tutor-lms-divi-modules' ),
					'off' => esc_html__( 'Hide', 'tutor-lms-divi-modules' ),
				),
				'tab_slug'    => 'general',
				'toggle_slug' => 'layout',
			),
			'image_size'             => array(
				'label'       => esc_html__( 'Image Size', 'tutor-lms-divi-modules' ),
				'type'        => 'select',
				'options'     => array(
					'thumbnail'    => esc_html__( 'Thumbnail', 'tutor-lms-divi-modules' ),
					'medium'       => esc_html__( 'Medium', 'tutor-lms-divi-modules' ),
					'medium_large' => esc_html__( 'Medium Large', 'tutor-lms-divi-modules' ),
					'large'        => esc_html__( 'large', 'tutor-lms-divi-modules' ),
					'full'         => esc_html__( 'full', 'tutor-lms-divi-modules' ),
				),
				'default'     => 'medium_large',
				'tab_slug'    => 'general',
				'toggle_slug' => 'layout',
			),
			'meta_data'              => array(
				'label'       => esc_html__( 'Meta Data', 'tutor-lms-divi-modules' ),
				'type'        => 'yes_no_button',
				'default'     => 'off',
				'options'     => array(
					'on'  => esc_html__( 'Show', 'tutor-lms-divi-modules' ),
					'off' => esc_html__( 'Hide', 'tutor-lms-divi-modules' ),
				),
				'tab_slug'    => 'general',
				'toggle_slug' => 'layout',
			),
			'meta_margin'           => array(
				'label'          => esc_html__( 'Margin', 'tutor-lms-divi-modules' ),
				'type'           => 'custom_margin',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'meta',
				'mobile_options' => true,
			),
			'rating'                 => array(
				'label'       => esc_html__( 'Rating', 'tutor-lms-divi-modules' ),
				'type'        => 'yes_no_button',
				'default'     => 'on',
				'options'     => array(
					'on'  => esc_html__( 'Show', 'tutor-lms-divi-modules' ),
					'off' => esc_html__( 'Hide', 'tutor-lms-divi-modules' ),
				),
				'tab_slug'    => 'general',
				'toggle_slug' => 'layout',
			),
			'avatar'                 => array(
				'label'       => esc_html__( 'Avatar', 'tutor-lms-divi-modules' ),
				'type'        => 'yes_no_button',
				'default'     => 'on',
				'options'     => array(
					'on'  => esc_html__( 'Show', 'tutor-lms-divi-modules' ),
					'off' => esc_html__( 'Hide', 'tutor-lms-divi-modules' ),
				),
				'tab_slug'    => 'general',
				'toggle_slug' => 'layout',
			),
			'author'                 => array(
				'label'       => esc_html__( 'Author', 'tutor-lms-divi-modules' ),
				'type'        => 'yes_no_button',
				'default'     => 'on',
				'options'     => array(
					'on'  => esc_html__( 'Show', 'tutor-lms-divi-modules' ),
					'off' => esc_html__( 'Hide', 'tutor-lms-divi-modules' ),
				),
				'tab_slug'    => 'general',
				'toggle_slug' => 'layout',
			),
			'difficulty_label'       => array(
				'label'       => esc_html__( 'Difficulty Label', 'tutor-lms-divi-modules' ),
				'type'        => 'yes_no_button',
				'default'     => 'off',
				'options'     => array(
					'on'  => esc_html__( 'Show', 'tutor-lms-divi-modules' ),
					'off' => esc_html__( 'Hide', 'tutor-lms-divi-modules' ),
				),
				'tab_slug'    => 'general',
				'toggle_slug' => 'layout',
			),
			'wish_list'              => array(
				'label'       => esc_html__( 'Wish List', 'tutor-lms-divi-modules' ),
				'type'        => 'yes_no_button',
				'default'     => 'on',
				'options'     => array(
					'on'  => esc_html__( 'Show', 'tutor-lms-divi-modules' ),
					'off' => esc_html__( 'Hide', 'tutor-lms-divi-modules' ),
				),
				'tab_slug'    => 'general',
				'toggle_slug' => 'layout',
			),
			'show_category'               => array(
				'label'       => esc_html__( 'Category', 'tutor-lms-divi-modules' ),
				'type'        => 'yes_no_button',
				'default'     => 'off',
				'options'     => array(
					'on'  => esc_html__( 'Show', 'tutor-lms-divi-modules' ),
					'off' => esc_html__( 'Hide', 'tutor-lms-divi-modules' ),
				),
				'tab_slug'    => 'general',
				'toggle_slug' => 'layout',
			),
			'footer'                 => array(
				'label'       => esc_html__( 'Footer', 'tutor-lms-divi-modules' ),
				'type'        => 'yes_no_button',
				'default'     => 'on',
				'options'     => array(
					'on'  => esc_html__( 'Show', 'tutor-lms-divi-modules' ),
					'off' => esc_html__( 'Hide', 'tutor-lms-divi-modules' ),
				),
				'tab_slug'    => 'general',
				'toggle_slug' => 'layout',
			),
			// general tab query toggle.
			'order_by'               => array(
				'label'       => esc_html__( 'Order by', 'tutor-lms-divi-modules' ),
				'type'        => 'select',
				'options'     => array(
					'date'  => esc_html__( 'Date', 'tutor-lms-divi-modules' ),
					'title' => esc_html__( 'Title', 'tutor-lms-divi-modules' ),
				),
				'default'     => 'date',
				'tab_slug'    => 'general',
				'toggle_slug' => 'query',
			),
			'order'                  => array(
				'label'       => esc_html__( 'Order', 'tutor-lms-divi-modules' ),
				'type'        => 'select',
				'options'     => array(
					'DESC' => esc_html__( 'DESC', 'tutor-lms-divi-modules' ),
					'ASC'  => esc_html__( 'ASC', 'tutor-lms-divi-modules' ),
				),
				'default'     => 'DESC',
				'tab_slug'    => 'general',
				'toggle_slug' => 'query',
			),
			'limit'                  => array(
				'label'       => esc_html__( 'Limit', 'tutor-lms-divi-modules' ),
				'type'        => 'text',
				'description' => esc_html__( 'Input -1 for all courses', 'tutor-lms-divi-modules' ),
				'default'     => '5',
				'tab_slug'    => 'general',
				'toggle_slug' => 'query',
			),
			'category_includes'      => array(
				'label'       => esc_html__( 'Category', 'tutor-lms-divi-modules' ),
				'type'        => 'multiple_checkboxes',
				'options'     => tutor_divi_course_categories(),
				'description' => esc_html__( 'Leave checkboxes unchecked to select all', 'tutor-lms-divi-modules' ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'query',
			),
			'category_margin'        => array(
				'label'          => esc_html__( 'Margin', 'tutor-lms-divi-modules' ),
				'type'           => 'custom_margin',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'category',
				'mobile_options' => true,
			),
			'author_includes'        => array(
				'label'       => esc_html__( 'Author', 'tutor-lms-divi-modules' ),
				'type'        => 'multiple_checkboxes',
				'options'     => tutor_divi_course_authors(),
				'description' => esc_html__( 'Leave checkboxes unchecked to select all', 'tutor-lms-divi-modules' ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'query',
			),

			// general tab carousel_settings toggle.
			'arrows'                 => array(
				'label'       => esc_html__( 'Arrows', 'tutor-lms-divi-modules' ),
				'type'        => 'yes_no_button',
				'options'     => array(
					'on'  => esc_html__( 'Show', 'tutor-lms-divi-modules' ),
					'off' => esc_html__( 'Hide', 'tutor-lms-divi-modules' ),
				),
				'default'     => 'on',
				'tab_slug'    => 'general',
				'toggle_slug' => 'carousel_settings',
			),
			'dots'                   => array(
				'label'       => esc_html__( 'Dots', 'tutor-lms-divi-modules' ),
				'type'        => 'yes_no_button',
				'options'     => array(
					'on'  => esc_html__( 'Show', 'tutor-lms-divi-modules' ),
					'off' => esc_html__( 'Hide', 'tutor-lms-divi-modules' ),
				),
				'default'     => 'on',
				'tab_slug'    => 'general',
				'toggle_slug' => 'carousel_settings',
			),
			'transition'             => array(
				'label'       => esc_html__( 'Transition Duration', 'tutor-lms-divi-modules' ),
				'type'        => 'text',
				'default'     => '600',
				'description' => esc_html__( 'Use only numbers for transition', 'tutor-lms-divi-modules' ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'carousel_settings',
			),
			'center_slides'          => array(
				'label'       => esc_html__( 'Center Slides', 'tutor-lms-divi-modules' ),
				'type'        => 'yes_no_button',
				'options'     => array(
					'on'  => esc_html__( 'Yes', 'tutor-lms-divi-modules' ),
					'off' => esc_html__( 'No', 'tutor-lms-divi-modules' ),
				),
				'default'     => 'off',
				'tab_slug'    => 'general',
				'toggle_slug' => 'carousel_settings',
			),
			'smooth_scrolling'       => array(
				'label'       => esc_html__( 'Smooth Scrolling', 'tutor-lms-divi-modules' ),
				'type'        => 'yes_no_button',
				'options'     => array(
					'on'  => esc_html__( 'Yes', 'tutor-lms-divi-modules' ),
					'off' => esc_html__( 'No', 'tutor-lms-divi-modules' ),
				),
				'default'     => 'on',
				'tab_slug'    => 'general',
				'toggle_slug' => 'carousel_settings',
			),
			'autoplay'               => array(
				'label'       => esc_html__( 'Auto Play', 'tutor-lms-divi-modules' ),
				'type'        => 'yes_no_button',
				'options'     => array(
					'on'  => esc_html__( 'Yes', 'tutor-lms-divi-modules' ),
					'off' => esc_html__( 'No', 'tutor-lms-divi-modules' ),
				),
				'default'     => 'on',
				'tab_slug'    => 'general',
				'toggle_slug' => 'carousel_settings',
			),
			'autoplay_speed'         => array(
				'label'       => esc_html__( 'Auto Play Speed', 'tutor-lms-divi-modules' ),
				'type'        => 'text',
				'default'     => '5000',
				'description' => esc_html( 'Use only numbers for auto play speed', 'tutor-lms-divi-modules' ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'carousel_settings',
			),
			'infinite_loop'          => array(
				'label'       => esc_html__( 'Infinite Loop', 'tutor-lms-divi-modules' ),
				'type'        => 'yes_no_button',
				'options'     => array(
					'on'  => esc_html__( 'Yes', 'tutor-lms-divi-modules' ),
					'off' => esc_html__( 'No', 'tutor-lms-divi-modules' ),
				),
				'default'     => 'on',
				'tab_slug'    => 'general',
				'toggle_slug' => 'carousel_settings',
			),
			'pause_on_hover'         => array(
				'label'       => esc_html__( 'Pause on Hover', 'tutor-lms-divi-modules' ),
				'type'        => 'yes_no_button',
				'options'     => array(
					'on'  => esc_html__( 'Yes', 'tutor-lms-divi-modules' ),
					'off' => esc_html__( 'No', 'tutor-lms-divi-modules' ),
				),
				'default'     => 'on',
				'tab_slug'    => 'general',
				'toggle_slug' => 'carousel_settings',
			),
			// bookmark toggle.
			'bookmark_background_color' => array(
				'label'       => esc_html__( 'Background Color', 'tutor-lms-divi-modules' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'bookmark',
			),
			// advanced tab card toggle.
			'card_background_color'  => array(
				'label'       => esc_html__( 'Background Color', 'tutor-lms-divi-modules' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'card',
			),
			'card_custom_padding'    => array(
				'label'          => esc_html__( 'Body Padding', 'tutor-lms-divi-modules' ),
				'type'           => 'range',
				'default_unit'   => 'px',
				'default'        => '18px',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'card',
			),
			'card_gap'             => array(
				'label'          => esc_html__( 'Card Gap', 'tutor-lms-divi-modules' ),
				'type'           => 'range',
				'default_unit'   => 'px',
				'default'        => '15px',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'card',
			),
			'title_margin'          => array(
				'label'          => esc_html__( 'Title Margin', 'tutor-lms-divi-modules' ),
				'type'           => 'custom_margin',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'title',
				'mobile_options' => true,
			),
			// advanced tab badge toggle.
			'badge_background_color' => array(
				'label'       => esc_html__( 'Background Color', 'tutor-lms-divi-modules' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'badge',
			),
			'badge_text_color'       => array(
				'label'       => esc_html__( 'Text Color', 'tutor-lms-divi-modules' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'badge',
			),
			'badge_size'             => array(
				'label'          => esc_html__( 'Size', 'tutor-lms-divi-modules' ),
				'type'           => 'range',
				'default_unit'   => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '300',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'badge',
			),
			'badge_margin'           => array(
				'label'          => esc_html__( 'Margin', 'tutor-lms-divi-modules' ),
				'type'           => 'range',
				'default_unit'   => 'px',
				'default'        => '0px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'badge',
			),
			// advanced tab avatar toggle.
			'avatar_size'            => array(
				'label'          => esc_html__( 'Avatar Size', 'tutor-lms-divi-modules' ),
				'type'           => 'range',
				'default_unit'   => 'px',
				'default'        => '34px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '200',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'avatar',
			),
			// advanced tab rating toggle.
			'star_color'             => array(
				'label'       => esc_html__( 'Star Color', 'tutor-lms-divi-modules' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'rating',
			),
			'star_size'              => array(
				'label'          => esc_html__( 'Star Size', 'tutor-lms-divi-modules' ),
				'type'           => 'range',
				'default_unit'   => 'px',
				'default'        => '18px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'rating',
			),
			'star_gap'               => array(
				'label'          => esc_html__( 'Gap', 'tutor-lms-divi-modules' ),
				'type'           => 'range',
				'default_unit'   => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'rating',
			),
			'rating_margin'         => array(
				'label'          => esc_html__( 'Margin', 'tutor-lms-divi-modules' ),
				'type'           => 'custom_margin',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'rating',
				'mobile_options' => true,
			),
			// advanced tab footer toggle.
			'footer_background'      => array(
				'label'       => esc_html__( 'Background Color', 'tutor-lms-divi-modules' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'footer',
			),
			'footer_padding'         => array(
				'label'          => esc_html__( 'Padding', 'tutor-lms-divi-modules' ),
				'type'           => 'custom_padding',
				'mobile_options' => true,
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'footer',
			),
			// arrows toggle.
			'arrows_padding'         => array(
				'label'          => esc_html__( 'Padding', 'tutor-lms-divi-modules' ),
				'type'           => 'range',
				'default_unit'   => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'arrows',
				'priority'       => 100,
			),

			// dots toggle.
			'dots_alignment'         => array(
				'label'       => esc_html__( 'Alignment', 'tutor-lms-divi-modules' ),
				'type'        => 'text_align',
				'options'     => et_builder_get_text_orientation_options( array( 'justified' ) ),
				'default'     => 'center',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'dots',
			),
			'dots_space'             => array(
				'label'          => esc_html__( 'Space Between', 'tutor-lms-divi-modules' ),
				'type'           => 'range',
				'default'        => '5px',
				'default_unit'   => 'px',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'dots',
			),
			'card_body_margin'   => array(
				'label'          => esc_html__( 'Margin', 'tutor-lms-divi-modules' ),
				'type'           => 'custom_margin',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'card_body',
				'mobile_options' => true,
			),
			// computed.
			'__courses'              => array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'CourseCarousel',
					'get_props',
				),
				'computed_depends_on' => array(
					'category_includes',
					'author_includes',
					'limit',
					'order_by',
					'order',
					'image_size',
				),
				'computed_minimum'    => array(
					'category_includes',
					'author_includes',
					'limit',
					'order_by',
					'order',
					'image_size',
				),
			),
		);

	}

	/**
	 * Get course props through computed property
	 *
	 * @param array $args  dependent args.
	 *
	 * @return mixed
	 */
	public static function get_props( $args = array() ) {
		$post_type   = tutor()->course_post_type;
		$post_status = 'publish';
		$limit       = isset( $args['limit'] ) ? sanitize_text_field( $args['limit'] ) : -1;
		$order_by    = isset( $args['order_by'] ) ? sanitize_text_field( $args['order_by'] ) : 'date';
		$order       = isset( $args['order'] ) ? sanitize_text_field( $args['order'] ) : 'DESC';
		$image_size  = isset( $args['image_size'] ) ? sanitize_text_field( $args['image_size'] ) : 'medium_large';

		// available categories.
		$available_cat = tutor_divi_course_categories();
		// sort be key asc order.
		ksort( $available_cat );

		// user's selected category.
		$category_includes = $args['category_includes'];
		$category_includes = explode( '|', $category_includes );

		$category_terms = tutor_divi_get_user_selected_terms( $available_cat, $category_includes );

		$available_author = tutor_divi_course_authors();
		ksort( $available_author );

		$author_includes     = $args['author_includes'];
		$author_includes     = explode( '|', $author_includes );
		$selected_author_ids = tutor_divi_get_user_selected_authors( $available_author, $author_includes );

		$query_args = array(
			'post_type'      => $post_type,
			'post_status'    => $post_status,
			'posts_per_page' => sanitize_text_field( $limit ),
			'order_by'       => sanitize_text_field( $order_by ),
			'order'          => sanitize_text_field( $order ),
		);

		if ( count( $selected_author_ids ) > 0 ) {
			$query_args['author__in'] = $selected_author_ids;
		}

		if ( count( $category_terms ) > 0 ) {
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

		$courses         = array();
		$currency_symbol = function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol() : '$';
		$query           = new WP_Query( $query_args );

		if ( $query->have_posts() ) {

			// get all required post contents.
			foreach ( $query->posts as $post ) {
				$post->currency_symbol = $currency_symbol;
				$thumbnail             = get_the_post_thumbnail_url( $post->ID, $image_size ) ? get_the_post_thumbnail_url( $post->ID, $image_size ) : get_tutor_course_thumbnail( $image_size, $url = true );

				$category = wp_get_post_terms( $post->ID, 'course-category' );

				$tag = wp_get_post_terms( $post->ID, 'course-tag' );

				$post->course_level = get_tutor_course_level( $post->ID );

				$post->course_category = $category;

				$post->course_tag = $tag;

				$post->post_thumbnail = $thumbnail;

				$post->author_avatar = tutor_utils()->get_tutor_avatar( $post->post_author );

				$post->course_duration = get_tutor_course_duration_context( $post->ID );

				$post->enroll_count = tutor_utils()->count_enrolled_users_by_course( $post->ID );

				$post->author_name = get_the_author_meta( 'display_name', $post->post_author );

				$post->course_rating = tutils()->get_course_rating( $post->ID );

				$post->loop_price = self::get_course_price( $post->ID );

				$post->woo_price_html = self::get_price_html( $post->ID );

				$post->woo_currency = function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol() : '';

				$post->is_enrolled = tutils()->is_enrolled( $post->ID, get_current_user_id() );
				// prepare footer.
				$template = '';
				ob_start();
				$can_continue = tutor_utils()->is_enrolled( $post->ID ) || get_post_meta( $post->ID, '_tutor_is_public_course', true ) == 'yes';
				// Check for further access type like course content access settings.
				if ( ! $can_continue ) {
					$can_continue = tutor_utils()->has_user_course_content_access( get_current_user_id(), $post->ID );
				}
				if ( $can_continue ) {
					$template = trailingslashit( DTLMS_TEMPLATES . 'loop' ) . 'course-continue.php';
				} elseif ( tutor_utils()->is_course_added_to_cart( $post->ID ) ) {
					$template = trailingslashit( DTLMS_TEMPLATES . 'loop' ) . 'course-in-cart.php';
				} elseif ( tutor_utils()->is_enrolled( $post->ID ) ) {
					$template = trailingslashit( DTLMS_TEMPLATES . 'loop' ) . 'course-continue.php';
				} else {
					$template = trailingslashit( DTLMS_TEMPLATES . 'loop' ) . 'course-price.php';
				}
				if ( file_exists( $template ) ) {
					tutor_load_template_from_custom_path(
						$template,
						array( 'course_id' => $post->ID ),
						false
					);
				} else {
					echo esc_html( $template . ' file not exists', 'tutor-lms-divi-modules' );
				}
				$footer_template       = apply_filters( 'tutor_course_loop_price', ob_get_clean() );
				$post->footer_template = $footer_template;
				// prepare footer end.
				array_push( $courses, $post );

			}
			wp_reset_postdata();
			return $courses;
		} else {
			return false;
		}

	}

	/**
	 * Get tutor course product price
	 *
	 * @return array
	 * @since 1.0.0
	 */
	static function get_course_price( $course_id ) {
		$product_id = tutor_utils()->get_course_product_id( $course_id );
		$product    = function_exists( 'wc_get_product' ) ? wc_get_product( $product_id ) : false;
		$price      = $product ? $product->get_regular_price() : __( 'Free', 'tutor-lms-divi-modules' );
		$sale_price = $product ? $product->get_sale_price() : '';
		return array(
			'regular_price' => $price,
			'sale_price'    => $sale_price,
		);
	}

	/**
	 * Get course price
	 *
	 * @param int $course_id  tutor course id.
	 *
	 * @return string  price html
	 */
	public static function get_price_html( $course_id ) {
		$product_id = tutor_utils()->get_course_product_id( $course_id );
		$product    = function_exists( 'wc_get_product' ) ? wc_get_product( $product_id ) : false;
		$price      = $product ? $product->get_price_html() : __( 'Free', 'tutor-lms-divi-modules' );
		return $price;
	}

	/**
	 * Get the tutor course author
	 *
	 * @param array $args  modules args.
	 *
	 * @return string
	 */
	public static function get_content( $args = array() ) {
		ob_start();
		include dtlms_get_template( 'course/course_carousel' );
		return ob_get_clean();
	}


	/**
	 * Rend template on the frontend
	 *
	 * @param array  $unprocessed_props  module props.
	 * @param string $content  template content.
	 * @param string $render_slug module slug.
	 */
	public function render( $unprocessed_props, $content, $render_slug ) {
		// selectors.
		$wrapper            = '%%order_class%% .dtlms-carousel-loop-wrap';
		$card_selector      = $wrapper . ' .tutor-card';
		$card_body_selector = $wrapper . ' .tutor-card-body';
		$footer_selector    = $wrapper . ' .tutor-card-footer:not(.tutor-no-border)';
		$badge_selector     = $wrapper . ' .tutor-course-difficulty-level';
		$avatar_selector    = $wrapper . ' .tutor-avatar';

		$star_selector         = $wrapper . ' .tutor-ratings-stars span';
		$star_wrapper_selector = $wrapper . ' .tutor-ratings-stars';
		$cart_button_selector  = $wrapper . ' .tutor-loop-cart-btn-wrap a';
		$arrows_selector       = '%%order_class%% .slick-prev:before, %%order_class%% .slick-next:before';
		$dots_wrapper_selector = '%%order_class%% .slick-dots';
		$thumbnail_selector    = '%%order_class%% .tutor-course-thumbnail img';
		// props.
		$skin                  = sanitize_text_field( $this->props['skin'] );
		$hover_animation       = sanitize_text_field( $this->props['hover_animation'] );
		$card_background_color = sanitize_text_field( $this->props['card_background_color'] );

		$card_custom_padding = sanitize_text_field( $this->props['card_custom_padding'] );


		$badge_background_color = sanitize_text_field( $this->props['badge_background_color'] );
		$badge_text_color       = sanitize_text_field( $this->props['badge_text_color'] );
		$badge_size             = sanitize_text_field( $this->props['badge_size'] );
		$badge_margin           = sanitize_text_field( $this->props['badge_margin'] );

		$avatar_size = sanitize_text_field( $this->props['avatar_size'] );

		$star_color = sanitize_text_field( $this->props['star_color'] );
		$star_size  = sanitize_text_field( $this->props['star_size'] );
		$star_gap   = sanitize_text_field( $this->props['star_gap'] );

		$footer_background = sanitize_text_field( $this->props['footer_background'] );
		$footer_padding    = sanitize_text_field( $this->props['footer_padding'] );

		$dots_alignment = sanitize_text_field( $this->props['dots_alignment'] );
		$dots_space     = sanitize_text_field( $this->props['dots_space'] );

		$arrows_padding = sanitize_text_field( $this->props['arrows_padding'] );


		$card_body_margin = sanitize_text_field( $this->props['card_body_margin'] );

		$rating_margin   = sanitize_text_field( $this->props['rating_margin'] );

		$title_margin    = sanitize_text_field( $this->props['title_margin'] );

		$meta_margin     = sanitize_text_field( $this->props['meta_margin'] );

		$category_margin = sanitize_text_field( $this->props['category_margin'] );

		if ( '' !== $category_margin && '|||' !== $category_margin ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector' => $wrapper . ' .dtlms-author-category-meta',
					'declaration' => sprintf(
						'margin-top: %1$s !important;margin-right:%2$s !important;margin-bottom:%3$s !important;margin-left:%4$s !important;',
						esc_attr( et_pb_get_spacing( $category_margin, 'top', '0px' ) ),
						esc_attr( et_pb_get_spacing( $category_margin, 'right', '0px' ) ),
						esc_attr( et_pb_get_spacing( $category_margin, 'bottom', '0px' ) ),
						esc_attr( et_pb_get_spacing( $category_margin, 'left', '0px' ) ),
					)
				)
			);
		}

		if ( '' !== $meta_margin && '|||' !== $meta_margin ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector' => $wrapper . ' .dtlms-course-duration-meta',
					'declaration' => sprintf(
						'margin-top: %1$s !important;margin-right:%2$s !important;margin-bottom:%3$s !important;margin-left:%4$s !important;',
						esc_attr( et_pb_get_spacing( $meta_margin, 'top', '0px' ) ),
						esc_attr( et_pb_get_spacing( $meta_margin, 'right', '0px' ) ),
						esc_attr( et_pb_get_spacing( $meta_margin, 'bottom', '0px' ) ),
						esc_attr( et_pb_get_spacing( $meta_margin, 'left', '0px' ) ),
					)
				)
			);
		}
		

		if ( '' !== $title_margin && '|||' !== $title_margin ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector' => $wrapper . ' .tutor-course-name',
					'declaration' => sprintf(
						'margin-top: %1$s !important;margin-right:%2$s !important;margin-bottom:%3$s !important;margin-left:%4$s !important;',
						esc_attr( et_pb_get_spacing( $title_margin, 'top', '0px' ) ),
						esc_attr( et_pb_get_spacing( $title_margin, 'right', '0px' ) ),
						esc_attr( et_pb_get_spacing( $title_margin, 'bottom', '0px' ) ),
						esc_attr( et_pb_get_spacing( $title_margin, 'left', '0px' ) ),
					)
				)
			);
		}


		if ( '' !== $rating_margin && '|||' !== $rating_margin ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector' => $wrapper . ' .tutor-ratings',
					'declaration' => sprintf(
						'margin-top: %1$s !important;margin-right:%2$s !important;margin-bottom:%3$s !important;margin-left:%4$s !important;',
						esc_attr( et_pb_get_spacing( $rating_margin, 'top', '0px' ) ),
						esc_attr( et_pb_get_spacing( $rating_margin, 'right', '0px' ) ),
						esc_attr( et_pb_get_spacing( $rating_margin, 'bottom', '0px' ) ),
						esc_attr( et_pb_get_spacing( $rating_margin, 'left', '0px' ) ),
					)
				)
			);
		}
 
	
		if ( '' !== $card_body_margin && '|||' !== $card_body_margin ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector' => $card_body_selector,
					'declaration' => sprintf(
						'margin-top: %1$s !important;margin-right:%2$s !important;margin-bottom:%3$s !important;margin-left:%4$s !important;',
						esc_attr( et_pb_get_spacing( $card_body_margin, 'top', '0px' ) ),
						esc_attr( et_pb_get_spacing( $card_body_margin, 'right', '0px' ) ),
						esc_attr( et_pb_get_spacing( $card_body_margin, 'bottom', '0px' ) ),
						esc_attr( et_pb_get_spacing( $card_body_margin, 'left', '0px' ) ),
					)
				)
			);
		}

		// set styles
		if ( '' !== $this->props['card_gap'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .slick-slide',
					'declaration' => sprintf(
						'margin-left: %1$s !important; margin-right: %2$s !important;',
						$this->props['card_gap'],
						$this->props['card_gap']
					),
				)
			);
		}

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-course-thumbnail .tutor-ratio-16x9',
				'declaration' => 'padding-top: 56.25% !important;'
			)
		);

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => $footer_selector . ' .list-item-price .price',
				'declaration' => 'flex-direction: column;'
			)
		);

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => $thumbnail_selector,
				'declaration' => 'height: 100% !important; max-width: 100% !important; display: block !important;'
			)
		);
		// margin for hover animation.
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%%
					.tutor-course-card.dtlms-has-hover-animation',
				'declaration' => 'margin-top: 7px;',
			)
		);
		// make carousel item equal height.
		if ( $skin === 'classic' || $skin === 'card' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .slick-track',
					'declaration' => 'display: -ms-flexbox;
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
						',
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .slick-slide',
					'declaration' => 'height: inherit !important;',
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-course-card',
					'declaration' => 'display: flex; flex-direction: column; justify-content: space-between; height: 100%;',
				)
			);
		}

		// classic.
		if ( $skin === 'classic' ) {

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-course-card:hover',
					'declaration' => '-webkit-box-shadow: 0px 5px 2px #ebebeb;
	        			box-shadow: 0px 5px 2px #ebebeb;',
				)
			);
		}
		// card style.
		if ( $skin === 'card' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dtlms-course-card',
					'declaration' => 'display: -webkit-box;
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
						overflow: hidden;',
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dtlms-course-card:hover',
					'declaration' => '-webkit-box-shadow:0px 24px 34px -5px rgba(0, 0, 0, 0.1);
	      				box-shadow:0px 24px 34px -5px rgba(0, 0, 0, 0.1);',
				)
			);
		}

		if ( $skin === 'stacked' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dtlms-course-card-stacked .tutor-course-thumbnail',
					'declaration' => 'overflow: hidden; z-index: 1;',
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dtlms-course-card-stacked',
					'declaration' => 'overflow: visible !important;',
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dtlms-course-card-stacked .tutor-card-body',
					'declaration' => 'z-index: 99;
						margin-top: -80px;
						background: white;
						width: 80%;
						margin-left: auto;
						margin-right: auto;
						position: relative;
						border-radius: 10px;
						-webkit-box-shadow: 0px 34px 28px -20px rgba(0, 0, 0, 0.15);
						        box-shadow: 0px 34px 28px -20px rgba(0, 0, 0, 0.15);',
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dtlms-course-card-stacked .tutor-card-body:hover',
					'declaration' => '-webkit-box-shadow: 0px 54px 58px -20px rgba(0, 0, 0, 0.15);
	        			box-shadow: 0px 54px 58px -20px rgba(0, 0, 0, 0.15);',
				)
			);
		}

		if ( $skin === 'overlayed' ) {

			// style container.
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dtlms-course-card-overlay',
					'declaration' => 'background-size: cover;
						background-repeat: no-repeat;
						position: relative;
						height: 300px;
						overflow: hidden;
						',
				)
			);

			// set default overlay.
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dtlms-course-card-overlay:before',
					'declaration' => '	background-image: -o-linear-gradient(top, rgba(0, 0, 0, 0.0001) 0%, #000000 100%);
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
					    transition: .4s;	',
				)
			);

			// card header style.
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dtlms-course-card-overlay .tutor-course-thumbnail',
					'declaration' => 'z-index: 2;
						height: 100%;',
				)
			);

			// container style.
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dtlms-course-card-overlay .tutor-card-body',
					'declaration' => 'position: absolute;
						z-index: 99;
						width: 100%;
						bottom:0 !important;',
				)
			);

			// all text style for overlayed.
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-course-card .tutor-rating-count,
                        %%order_class%% .tutor-course-card .tutor-course-loop-title h2 a,
                        %%order_class%% .tutor-course-card .tutor-course-loop-meta,
                        %%order_class%% .tutor-course-card .tutor-loop-author>div a,
                        %%order_class%% .tutor-course-card .etlms-loop-cart-btn-wrap a,
                        %%order_class%% .tutor-course-card .price, %%order_class%% .tutor-loop-cart-btn-wrap a, %%order_class%% .tutor-loop-cart-btn-wrap a:before ',
					'declaration' => 'color: #fff !important;',
				)
			);
			// hover overlayed.
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dtlms-course-card-overlay:hover',
					'declaration' => '-webkit-box-shadow: 0px 8px 28px 0px #d0d0d0;
	        			box-shadow: 0px 8px 28px 0px #d0d0d0;',
				)
			);
		}
		// skin layout styles end.

		// card style.
		if ( '' !== $card_background_color && ( 'classic' === $skin || 'card' === $skin || 'overlayed' === $skin ) ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $card_selector,
					'declaration' => sprintf(
						'background-color: %1$s;',
						$card_background_color
					),
				)
			);
		}
		if ( '' !== $card_background_color && 'stacked' === $skin ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dtlms-course-list-col .dtlms-course-card-inner',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						$card_background_color
					),
				)
			);
		}

		if ( '' !== $card_custom_padding ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $card_body_selector,
					'declaration' => sprintf(
						'padding: %1$s !important;',
						$card_custom_padding
					),
				)
			);
		}

		if ( '' !== $this->props['bookmark_background_color'] ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-course-bookmark',
					'declaration' => sprintf(
						'background-color: %1$s !important;',
						$this->props['bookmark_background_color']
					),
				)
			);
		}

		// card hover animation.
		if ( 'on' == $hover_animation ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-course-card.dtlms-has-hover-animation',
					'declaration' => 'position: relative; top: 0; z-index: 99; transition: top .5s',
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-course-card.dtlms-has-hover-animation:hover',
					'declaration' => 'top: -5px;',
				)
			);
		}
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '#test h3',
				'declaration' => 'color: red;',
			)
		);

		// badge toggle.
		if ( '' !== $badge_background_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $badge_selector,
					'declaration' => sprintf(
						'background-color: %1$s;',
						$badge_background_color
					),
				)
			);
		}

		if ( '' !== $badge_text_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $badge_selector,
					'declaration' => sprintf(
						'color: %1$s;',
						$badge_text_color
					),
				)
			);
		}

		if ( '' !== $badge_margin ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $badge_selector,
					'declaration' => sprintf(
						'margin: %1$s;',
						$badge_margin
					),
				)
			);
		}

		if ( '' !== $badge_size ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $badge_selector,
					'declaration' => sprintf(
						'width: %1$s;',
						$badge_size
					),
				)
			);
		}

		// avatar toggle.
		if ( '' !== $avatar_size ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $avatar_selector,
					'declaration' => sprintf(
						'width: %1$s;height: %1$s; line-height: %1$s;',
						$avatar_size
					),
				)
			);
		}

		// rating toggle.
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => $star_wrapper_selector,
				'declaration' => 'display: flex;',
			)
		);

		if ( '' !== $star_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $star_selector,
					'declaration' => sprintf(
						'color: %1$s;',
						$star_color
					),
				)
			);
		}

		if ( '' !== $star_size ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $star_selector,
					'declaration' => sprintf(
						'font-size: %1$s;',
						$star_size
					),
				)
			);
		}

		if ( '' !== $star_gap ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $star_selector,
					'declaration' => sprintf(
						'margin-left: %1$s !important;margin-right: %2$s !important;',
						$star_gap,
						$star_gap
					),
				)
			);
		}

		if ( '' !== $star_gap ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $star_wrapper_selector,
					'declaration' => sprintf(
						'margin-left: -%1$s !important;margin-right: -%2$s !important;',
						$star_gap,
						$star_gap
					),
				)
			);
		}

		// footer toggle.
		if ( '' !== $footer_background ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $footer_selector,
					'declaration' => sprintf(
						'background-color: %1$s;',
						$footer_background
					),
				)
			);
		}

		if ( '' !== $footer_padding && '|||' !== $footer_padding ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector' => $wrapper . ' .tutor-card-footer',
					'declaration' => sprintf(
						'padding-top: %1$s !important;padding-right:%2$s !important;padding-bottom:%3$s !important;padding-left:%4$s !important;',
						esc_attr( et_pb_get_spacing( $footer_padding, 'top', '0px' ) ),
						esc_attr( et_pb_get_spacing( $footer_padding, 'right', '0px' ) ),
						esc_attr( et_pb_get_spacing( $footer_padding, 'bottom', '0px' ) ),
						esc_attr( et_pb_get_spacing( $footer_padding, 'left', '0px' ) ),
					)
				)
			);
		}

		if ( '' !== $footer_background ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $footer_selector,
					'declaration' => sprintf(
						'background-color: %1$s;',
						$footer_background
					),
				)
			);
		}

		// cart button toggle.
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => $cart_button_selector,
				'declaration' => 'border-style: solid;',
			)
		);

		// arrows toggle
		// default arrow color #000.
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => $arrows_selector,
				'declaration' => 'color: #000;',
			)
		);

		if ( '' !== $arrows_padding ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $arrows_selector,
					'declaration' => sprintf(
						'padding: %1$s;',
						$arrows_padding
					),
				)
			);
		}

		// dots toggle.
		if ( 'left' === $dots_alignment ) {
			$dots_alignment = 'flex-start';
		} elseif ( 'right' === $dots_alignment ) {
			$dots_alignment = 'flex-end';
		}
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => $dots_wrapper_selector,
				'declaration' => sprintf(
					'display: flex !important; bottom: -50px !important; justify-content: %1$s; column-gap: %2$s;',
					$dots_alignment,
					$dots_space
				),
			)
		);
		// add padding if thumbnail hide.
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .hide-thumbnail .tutor-card-body',
				'declaration' => 'padding-top: 30px;',
			)
		);
		// filter.
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-course-thumbnail a img',
				'declaration' => sprintf(
					'filter: hue-rotate(%1$s) saturate(%2$s) brightness(%3$s) invert(%4$s) sepia(%5$s) opacity(%6$s) blur(%7$s) contrast(%8$s);',
					sanitize_text_field( $this->props['filter_hue_rotate'] ),
					sanitize_text_field( $this->props['filter_saturate'] ),
					sanitize_text_field( $this->props['filter_brightness'] ),
					sanitize_text_field( $this->props['filter_invert'] ),
					sanitize_text_field( $this->props['filter_sepia'] ),
					sanitize_text_field( $this->props['filter_opacity'] ),
					sanitize_text_field( $this->props['filter_blur'] ),
					sanitize_text_field( $this->props['filter_contrast'] )
				),
			)
		);
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '.tutor_course_carousel_0,.tutor_course_carousel_1,.tutor_course_carousel_2,.tutor_course_carousel_3,.tutor_course_carousel_4,.tutor_course_carousel_5,.tutor_course_carousel_6',
				'declaration' => 'filter: none !important;',
			)
		);
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .list-item-price .price',
				'declaration' => 'display: flex;',
			)
		);
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-course-listing-item-footer',
				'declaration' => 'border-left: none; border-right: none; border-bottom: none;',
			)
		);

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-color-text-primary',
				'declaration' => 'color: #212327;',
			)
		);
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-color-text-subsued',
				'declaration' => 'color: #5b616f;',
			)
		);
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-course-loop-header-meta .tutor-course-wishlist-btn',
				'declaration' => 'color: #fff;',
			)
		);
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-course-loop-header-meta .tutor-course-wishlist-btn',
				'declaration' => 'border-radius: 50%; background-color: rgba(33,35,39,0.4); padding: 10px; width: 38px;
				height: 38px; line-height: 38px;',
			)
		);
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-course-loop-header-meta .tutor-course-wishlist-btn:hover',
				'declaration' => 'background-color: #3e64de;',
			)
		);
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-loop-author.tutor-bs-d-flex.align-items-center',
				'declaration' => 'gap: 10px;',
			)
		);
		// min height for stacked container.
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-courses-layout-2.dtlms-course-card-stacked .tutor-card-body, %%order_class%% .tutor-courses-layout-3.dtlms-course-card-stacked .tutor-card-body',
				'declaration' => 'min-height: 320px;',
			)
		);

		// set styles end.

		$output = self::get_content( $this->props );
		// Render empty string if no output is generated to avoid unwanted vertical space.
		if ( '' === $output ) {
			return '';
		}

		return $this->_render_module_wrapper( $output, $render_slug );
	}
}
new CourseCarousel();
