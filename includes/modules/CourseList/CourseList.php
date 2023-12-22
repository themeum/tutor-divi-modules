<?php
/**
 * Course List Module | Tutor Divi Modules
 *
 * @since 1.0.0
 * @author Themeum<www.themeum.com>
 * @package TutorDiviModules\CourseList
 */

use SebastianBergmann\Environment\Console;
use TutorLMS\Divi\Helper;

defined( 'ABSPATH' ) || exit;

/**
 * Course List controls
 */
class CourseList extends ET_Builder_Module {

	/**
	 * Course List slug
	 *
	 * @var $slug
	 */
	public $slug = 'tutor_course_list';

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
		$this->name      = esc_html__( 'Tutor Course List', 'tutor-lms-divi-modules' );
		$this->icon_path = plugin_dir_path( __FILE__ ) . 'icon.svg';
		$wrapper         = '%%order_class%% .tutor-divi-courselist-main-wrap';
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
					'layout'              => esc_html__( 'Layout', 'tutor-lms-divi-modules' ),
					'query'               => esc_html__( 'Query', 'tutor-lms-divi-modules' ),
					'enroll_button'       => esc_html__( 'Enroll Button', 'tutor-lms-divi-modules' ),
					'pagination_settings' => esc_html__( 'Pagination', 'tutor-lms-divi-modules' ),

				),
			),
			'advanced' => array(
				'toggles' => array(
					'layout_styles'     => esc_html__( 'Layout', 'tutor-lms-divi-modules' ),
					'card'              => esc_html__( 'Card', 'tutor-lms-divi-modules' ),
					'image'             => esc_html__( 'Image', 'tutor-lms-divi-modules' ),
					'badge'             => esc_html__( 'Badge', 'tutor-lms-divi-modules' ),
					'avatar'            => esc_html__( 'Avatar', 'tutor-lms-divi-modules' ),
					'title'             => esc_html__( 'Title', 'tutor-lms-divi-modules' ),
					'meta'              => esc_html__( 'Meta', 'tutor-lms-divi-modules' ),
					'category'          => esc_html__( 'Category', 'tutor-lms-divi-modules' ),
					'rating'            => esc_html__( 'Rating', 'tutor-lms-divi-modules' ),
					'footer'            => esc_html__( 'Footer', 'tutor-lms-divi-modules' ),
					'pagination_styles' => esc_html__( 'Pagination', 'tutor-lms-divi-modules' ),
				),
			),
		);

		// advanced fields configuration.
		$this->advanced_fields = array(
			'fonts'          => array(
				'title'      => array(
					'css'             => array(
						'main' => $course_title_selector,
					),
					'hide_text_align' => true,
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'title',
				),
				'meta'       => array(
					'css'             => array(
						'main' => $meta_selector,
					),
					'hide_text_align' => true,
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'meta',
				),
				'category'   => array(
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
				'pagination' => array(
					'css'             => array(
						'main'      => '%%order_class%% .tutor-divi-courselist-pagination',
						'important' => 'all',
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'pagination_styles',
					'hide_text_color' => true,
				),

			),

			'button'         => array(
				'enroll_course_button' => array(
					'label'          => esc_html__( 'Enroll Course/ Continue Learning/ Start Learning/ Download Certificate Button', 'tutor-lms-divi-modules' ),
					'box_shadow'     => array(
						'css' => array(
							'main' => '%%order_class%% .list-item-button a:not(.add_to_cart_button)',
						),
					),
					'css'            => array(
						'main' => '%%order_class%% .list-item-button a:not(.add_to_cart_button)',
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
				'add_to_cart_button' => array(
					'label'          => esc_html__( 'Add to cart button', 'tutor-lms-divi-modules' ),
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
			),
			'borders'        => array(
				'default'    => false,
				'card'       => array(
					'css'         => array(
						'main'      => array(
							'border_radii'  => '%%order_class%% .dtlms-course-list-col > .tutor-card, %%order_class%% .dtlms-course-list-col .dtlms-course-card-inner > .tutor-card-body',
							'border_styles' => '%%order_class%% .dtlms-course-list-col > .tutor-card, %%order_class%% .dtlms-course-list-col .dtlms-course-card-inner > .tutor-card-body',
						),
						'important' => true,
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'card',

				),
				'badge'      => array(
					'css'         => array(
						'main' => array(
							'border_radii'  => $badge_selector,
							'border_styles' => $badge_selector,
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'badge',
				),
				'avatar'     => array(
					'css'         => array(
						'main' => array(
							'border_radii'  => $avatar_selector,
							'border_styles' => $avatar_selector,
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'avatar',
				),
				'pagination' => array(
					'css'         => array(
						'main'      => array(
							'border_radii'  => '%%order_class%% .tutor-divi-courselist-pagination span,%%order_class%% .tutor-divi-courselist-pagination a',
							'border_styles' => '%%order_class%% .tutor-divi-courselist-pagination span,%%order_class%% .tutor-divi-courselist-pagination a',
						),
						'important' => true,
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'pagination_styles',
				),
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
			'box_shadow'     => false,
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
			'columns'                => array(
				'label'       => esc_html__( 'Columns', 'tutor-lms-divi-modules' ),
				'type'        => 'select',
				'description' => esc_html__( 'No: of slides that will display on desktop view', 'tutor-lms-divi-modules' ),
				'options'     => array(
					'2' => '2',
					'3' => '3',
					'4' => '4',
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
			// 'masonry'                => array(
			// 	'label'       => esc_html__( 'Masonry', 'tutor-lms-divi-modules' ),
			// 	'type'        => 'yes_no_button',
			// 	'default'     => 'off',
			// 	'options'     => array(
			// 		'on'  => esc_html__( 'Yes', 'tutor-lms-divi-modules' ),
			// 		'off' => esc_html__( 'No', 'tutor-lms-divi-modules' ),
			// 	),
			// 	'tab_slug'    => 'general',
			// 	'toggle_slug' => 'layout',
			// ),
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
			'pagination'             => array(
				'label'       => esc_html__( 'Pagination', 'tutor-lms-divi-modules' ),
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
				'default'     => '6',
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
			'author_includes'        => array(
				'label'       => esc_html__( 'Author', 'tutor-lms-divi-modules' ),
				'type'        => 'multiple_checkboxes',
				'options'     => tutor_divi_course_authors(),
				'description' => esc_html__( 'Leave checkboxes unchecked to select all', 'tutor-lms-divi-modules' ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'query',
			),          // general tab pagination toggle.
			'pagination_type'        => array(
				'label'       => esc_html__( 'Pagination Type', 'tutor-lms-divi-modules' ),
				'type'        => 'select',
				'default'     => 'prev_next',
				'options'     => array(
					'prev_next' => esc_html__( 'Prev/Next with Numbers', 'tutor-lms-divi-modules' ),
					'numbers'   => esc_html__( 'Only Numbers', 'tutor-lms-divi-modules' ),
				),
				'tab_slug'    => 'general',
				'toggle_slug' => 'pagination_settings',
			),
			'prev_level'             => array(
				'label'       => esc_html__( 'Prev Level', 'tutor-lms-divi-modules' ),
				'type'        => 'text',
				'default'     => esc_html__( 'Previous', 'tutor-lms-divi-modules' ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'pagination_settings',
				'show_if'     => array(
					'pagination_type' => 'prev_next',
				),
			),
			'next_level'             => array(
				'label'       => esc_html__( 'Next Level', 'tutor-lms-divi-modules' ),
				'type'        => 'text',
				'default'     => esc_html__( 'Next', 'tutor-lms-divi-modules' ),
				'tab_slug'    => 'general',
				'toggle_slug' => 'pagination_settings',
				'show_if'     => array(
					'pagination_type' => 'prev_next',
				),
			),
			// advanced tab layout_styles toggle.
			'columns_gap'            => array(
				'label'          => esc_html__( 'Columns Gap', 'tutor-lms-divi-modules' ),
				'type'           => 'range',
				'default_unit'   => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'layout_styles',
			),
			'rows_gap'               => array(
				'label'          => esc_html__( 'Rows Gap', 'tutor-lms-divi-modules' ),
				'type'           => 'range',
				'default_unit'   => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'layout_styles',
			),
			// advacned tab card toggle.
			'card_background_color'  => array(
				'label'       => esc_html__( 'Background Color', 'tutor-lms-divi-modules' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'card',
			),
			'footer_seperator_color' => array(
				'label'       => esc_html__( 'Footer Seperator Color', 'tutor-lms-divi-modules' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'card',
			),
			'footer_seperator_width' => array(
				'label'          => esc_html__( 'Footer Seperator Width', 'tutor-lms-divi-modules' ),
				'type'           => 'range',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'default_unit'   => 'px',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'card',
			),
			'card_custom_padding'    => array(
				'label'          => esc_html__( 'Padding', 'tutor-lms-divi-modules' ),
				'type'           => 'range',
				'defaunt_unit'   => 'px',
				'default'        => '0px',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'card',
			),
			// advanced tab image toggle.
			'image_spacing'          => array(
				'label'          => esc_html__( 'Spacing', 'tutor-lms-divi-modules' ),
				'type'           => 'range',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'default_unit'   => 'px',
				'default'        => '0px',
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'image',
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
			// computed.
			'__courses'              => array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'CourseList',
					'get_props',
				),
				'computed_depends_on' => array(
					'limit',
					'order_by',
					'order',
					'category_includes',
					'author_includes',
					'image_size',
					'pagination_type',
					'prev_level',
					'next_level',
				),
				'computed_minimum'    => array(
					'limit',
					'order_by',
					'order',
					'category_includes',
					'author_includes',
					'image_size',
					'pagination_type',
					'prev_level',
					'next_level',
				),
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
				'type'           => 'range',
				'default_unit'   => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'footer',
			),
			// pagination_styles toggle.
			'pagination_composite'   => array(
				'label'               => esc_html__( 'Text Color', 'tutor-lms-divi-modules' ),
				'type'                => 'composite',
				'composite_type'      => 'default',
				'composite_structure' => array(
					'tab1' => array(
						'label'    => esc_html__( 'Normal', 'tutor-lms-divi-modules' ),
						'controls' => array(
							'pagination_normal_color' => array(
								'label' => esc_html__( 'Color', 'tutor-lms-divi-modules' ),
								'type'  => 'color-alpha',
							),
							'pagination_normal_back'  => array(
								'label' => esc_html__( 'Background Color', 'tutor-lms-divi-modules' ),
								'type'  => 'color-alpha',
							),
						),
					),
					'tab2' => array(
						'label'    => esc_html__( 'Hover', 'tutor-lms-divi-modules' ),
						'controls' => array(
							'pagination_hover_color' => array(
								'label' => esc_html__( 'Color', 'tutor-lms-divi-modules' ),
								'type'  => 'color-alpha',
							),
							'pagination_hover_back'  => array(
								'label' => esc_html__( 'Background Color', 'tutor-lms-divi-modules' ),
								'type'  => 'color-alpha',
							),
						),
					),
					'tab3' => array(
						'label'    => esc_html__( 'Active', 'tutor-lms-divi-modules' ),
						'controls' => array(
							'pagination_active_color' => array(
								'label' => esc_html__( 'Color', 'tutor-lms-divi-modules' ),
								'type'  => 'color-alpha',
							),
							'pagination_active_back'  => array(
								'label' => esc_html__( 'Background Color', 'tutor-lms-divi-modules' ),
								'type'  => 'color-alpha',
							),
						),
					),
				),
				'tab_slug'            => 'advanced',
				'toggle_slug'         => 'pagination_styles',
			),
			'pagination_padding'     => array(
				'label'          => esc_html__( 'Padding', 'tutor-lms-divi-modules' ),
				'type'           => 'range',
				'default_unit'   => 'px',
				'range_settings' => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'pagination_styles',
			),

		);

	}

	/**
	 * Get require props
	 *
	 * @since 1.0.0
	 * @return mixed array | bool
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
		$query_args          = array(
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

				$post->author_avatar = tutor_utils()->get_tutor_avatar( $post->post_author, array( 'force_default' => true ) );

				$post->course_duration = get_tutor_course_duration_context( $post->ID );

				$post->enroll_count = tutor_utils()->count_enrolled_users_by_course( $post->ID );

				$post->author_name = get_the_author_meta( 'display_name', $post->post_author );

				$post->course_rating = tutils()->get_course_rating( $post->ID );

				$post->course_price          = tutils()->get_course_price( $post->ID );
				$post->is_course_purchasable = tutils()->is_course_purchasable( $post->ID );

				$post->loop_price = self::get_course_price( $post->ID );

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
					$tutor_course_sell_by = apply_filters( 'tutor_course_sell_by', null );
					if ( $tutor_course_sell_by ) {
						$template = trailingslashit( DTLMS_TEMPLATES . 'loop' ) . 'course-price-' . $tutor_course_sell_by . '.php';
					} else {
						$template = trailingslashit( DTLMS_TEMPLATES . 'loop' ) . 'course-price.php';
					}
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

			$big             = 999999999;
			$pagination_args = array(
				'base'      => str_replace( $big, '%#%', esc_url( site_url( 'courses/page/' . $big ) ) ),
				'format'    => '?paged=%#%',
				'total'     => $query->max_num_pages,
				'current'   => max( 1, get_query_var( 'paged' ) ),
				'end_size'  => sanitize_text_field( $args['limit'] ),
				'prev_next' => $args['pagination_type'] === 'numbers' ? false : true,
				'prev_text' => __( sanitize_text_field( $args['prev_level'] ), 'tutor-lms-divi-modules' ),
				'next_text' => __( 'Next', 'tutor-lms-divi-modules' ),
			);
			return array(
				'courses'    => $courses,
				'pagination' => paginate_links( $pagination_args ),
			);
			wp_reset_postdata();
		} else {
			return false;
		}

	}

	/**
	 * Get tutor course product price
	 *
	 * @since 1.0.0
	 *
	 * @param int $course_id  course id.
	 *
	 * @return array
	 */
	public static function get_course_price( $course_id ) {
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
	 * Get the tutor course author
	 *
	 * @param array $args  array of args.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function get_content( $args = array() ) {
		ob_start();
		include dtlms_get_template( 'course/course_list' );
		return ob_get_clean();
	}

	/**
	 * Render module output
	 *
	 * @since 1.0.0
	 *
	 * @param array  $unprocessed_props       List of unprocessed attributes.
	 * @param string $content     Content being processed.
	 * @param string $render_slug Slug of module that is used for rendering output.
	 *
	 * @return string module's rendered output
	 */
	public function render( $unprocessed_props, $content, $render_slug ) {
		// selectors.
		$wrapper         = '%%order_class%% .tutor-divi-courselist-main-wrap';
		$card_selector   = $wrapper . ' .dtlms-course-list-col > .tutor-card';
		$footer_selector = $wrapper . ' .tutor-card-footer:not(.tutor-no-border)';
		$badge_selector  = $wrapper . ' .tutor-course-difficulty-level';
		$avatar_selector = $wrapper . ' .tutor-avatar';

		$star_selector         = $wrapper . ' .tutor-ratings-stars span';
		$star_wrapper_selector = $wrapper . ' .tutor-loop-rating-wrap .tutor-rating-stars';
		$cart_button_selector  = $wrapper . ' .tutor-loop-cart-btn-wrap a';

		$pagination_selector        = '%%order_class%% .tutor-divi-courselist-pagination .page-numbers';
		$pagination_active_selector = '%%order_class%% .tutor-divi-courselist-pagination .page-numbers.current';

		$thumbnail_selector = '%%order_class%% .tutor-course-thumbnail img';
		// props.
		$skin                  = sanitize_text_field( $this->props['skin'] );
		$hover_animation       = sanitize_text_field( $this->props['hover_animation'] );
		$card_background_color = sanitize_text_field( $this->props['card_background_color'] );

		$footer_seperator_width = sanitize_text_field( $this->props['footer_seperator_width'] );
		$footer_seperator_color = sanitize_text_field( $this->props['footer_seperator_color'] );

		$card_custom_padding = sanitize_text_field( $this->props['card_custom_padding'] );

		$image_spacing = sanitize_text_field( $this->props['image_spacing'] );

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

		$pagination_normal_color = sanitize_text_field( $this->props['pagination_normal_color'] );
		$pagination_normal_back  = sanitize_text_field( $this->props['pagination_normal_back'] );
		$pagination_hover_color  = sanitize_text_field( $this->props['pagination_hover_color'] );
		$pagination_hover_back   = sanitize_text_field( $this->props['pagination_hover_back'] );
		$pagination_active_color = sanitize_text_field( $this->props['pagination_active_color'] );
		$pagination_active_back  = sanitize_text_field( $this->props['pagination_active_back'] );
		$pagination_padding      = sanitize_text_field( $this->props['pagination_padding'] );

		$columns_gap = sanitize_text_field( $this->props['columns_gap'] );
		$rows_gap    = sanitize_text_field( $this->props['rows_gap'] );

		// set styles.
		// default margin for hover animation.
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% 
					.tutor-divi-card.hover-animation',
				'declaration' => 'margin-top: 7px;',
			)
		);
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .list-item-price .price',
				'declaration' => 'display: flex; align-items: center; gap: 4px;',
			)
		);
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-course-header',
				'declaration' => 'border-radius: 10px;',
			)
		);
		// make list item equal height.
		if ( 'classic' === $skin || 'card' === $skin ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-divi-courselist-classic .tutor-divi-card,%%order_class%% .tutor-divi-courselist-card .tutor-divi-card',
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
						height: 100%;',
				)
			);
		}

		// classic.
		if ( $skin === 'classic' ) {

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-divi-courselist-classic .tutor-divi-card:hover',
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
					'selector'    => '%%order_class%% .tutor-divi-courselist-card .tutor-divi-card',
					'declaration' => '-webkit-box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.08);
						        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.08);overflow: hidden;',
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-divi-courselist-card .tutor-divi-card:hover',
					'declaration' => '-webkit-box-shadow:0px 24px 34px -5px rgba(0, 0, 0, 0.1);
	      				box-shadow:0px 24px 34px -5px rgba(0, 0, 0, 0.1);',
				)
			);
		}

		if ( $skin === 'stacked' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-divi-courselist-stacked .tutor-course-header',
					'declaration' => 'overflow: hidden; z-index: 1;',
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-divi-courselist-stacked .tutor-divi-card',
					'declaration' => 'overflow: visible !important;',
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-divi-courselist-stacked .tutor-divi-courselist-course-container',
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
					'selector'    => '%%order_class%% .tutor-divi-courselist-stacked .tutor-divi-courselist-course-container:hover',
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
					'selector'    => '%%order_class%% .tutor-divi-courselist-overlayed .tutor-divi-card',
					'declaration' => 'background-size: cover;
						background-repeat: no-repeat;
						position: relative;
						height: 300px;
						overflow: hidden;
						',
				)
			);

			// set befault overlay.
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-divi-courselist-overlayed .tutor-divi-card:before',
					'declaration' => '	background-image: -o-linear-gradient(top, rgba(0, 0, 0, 0.0001) 0%, #000000 100%);
						background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(0, 0, 0, 0.0001)), to(#000000));
						background-image: linear-gradient(180deg, rgba(0, 0, 0, 0.0001) 0%, #000000 100%);;
						
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
					'selector'    => '%%order_class%% .tutor-divi-courselist-overlayed .tutor-course-header',
					'declaration' => 'z-index: 2;
						height: 100%;',
				)
			);

			// container style.
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-divi-courselist-overlayed .tutor-divi-courselist-course-container',
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
					'selector'    => '%%order_class%% .tutor-divi-card .tutor-rating-count,
                        %%order_class%% .tutor-divi-card .tutor-course-loop-title h2 a,
                        %%order_class%% .tutor-divi-card .tutor-course-loop-meta,
                        %%order_class%% .tutor-divi-card .tutor-loop-author>div a,
                        %%order_class%% .tutor-divi-card .etlms-loop-cart-btn-wrap a,
                        %%order_class%% .tutor-divi-card .price, %%order_class%% .tutor-loop-cart-btn-wrap a, %%order_class%% .tutor-loop-cart-btn-wrap a:before',
					'declaration' => 'color: #fff !important;',
				)
			);
			// hover overlayed.
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-divi-courselist-overlayed .tutor-divi-card:hover',
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

		if ( '' !== $footer_seperator_width ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $footer_selector,
					'declaration' => sprintf(
						'border-top: %1$s; border-style: solid;',
						$footer_seperator_width
					),
				)
			);
		}

		if ( '' !== $footer_seperator_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $card_selector,
					'declaration' => sprintf(
						'border-color: %1$s;',
						$footer_seperator_color
					),
				)
			);
		}

		if ( '' !== $card_custom_padding ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $card_selector,
					'declaration' => sprintf(
						'padding: %1$s;',
						$card_custom_padding
					),
				)
			);
		}

		// card hover animation.
		if ( 'on' == $hover_animation ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-divi-card.hover-animation',
					'declaration' => 'position: relative; top: 0; z-index: 99; transition: top .5s',
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-divi-card.hover-animation:hover',
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

		// image toggles.
		if ( '' !== $image_spacing ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $thumbnail_selector,
					'declaration' => sprintf(
						'padding: %1$s;',
						$image_spacing
					),
				)
			);
		}

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
					'selector'    => $star_wrapper_selector,
					'declaration' => sprintf(
						'column-gap: %1$s;',
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

		if ( '' !== $footer_padding ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $footer_selector,
					'declaration' => sprintf(
						'padding: %1$s;',
						$footer_padding
					),
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

		// single column style.
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-divi-courselist-style',
				'declaration' => 'display: -webkit-box !important;display: -ms-flexbox !important;display: flex !important;-webkit-box-orient: horizontal !important;-webkit-box-direction: normal !important;-ms-flex-direction: row !important;flex-direction: row !important;-ms-flex-wrap: nowrap !important;flex-wrap: nowrap !important;height: 255px;',
				'media_query' => ET_Builder_Element::get_media_query( 'min_width_768' ),
			)
		);

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-divi-courselist-style .tutor-course-header',
				'declaration' => 'max-width: 40%;-webkit-box-flex: 0 !important;-ms-flex: 0 0 40% !important;flex: 0 0 40% !important;height: 255px;',
				'media_query' => ET_Builder_Element::get_media_query( 'min_width_768' ),
			)
		);

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-divi-courselist-style .tutor-divi-courselist-course-container',
				'declaration' => 'max-width: 60%;-webkit-box-flex: 0 !important;-ms-flex: 0 0 60% !important;flex: 0 0 60% !important;display: -webkit-box;display: -ms-flexbox;display: flex;-webkit-box-orient: vertical;-webkit-box-direction: normal;-ms-flex-direction: column;flex-direction: column;',
				'media_query' => ET_Builder_Element::get_media_query( 'min_width_768' ),
			)
		);

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-divi-courselist-style .tutor-divi-courselist-footer',
				'declaration' => 'margin-top: auto;',
				'media_query' => ET_Builder_Element::get_media_query( 'min_width_768' ),
			)
		);

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-divi-courselist-stacked .tutor-divi-courselist-style .tutor-divi-courselist-course-container',
				'declaration' => 'margin: auto 0 auto -42px;',
				'media_query' => ET_Builder_Element::get_media_query( 'min_width_768' ),
			)
		);

		// pagination_styles toggle.
		// pagination default align center.
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-divi-courselist-pagination',
				'declaration' => 'text-align: center;',
			)
		);

		if ( '' !== $pagination_padding ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $pagination_selector,
					'declaration' => sprintf(
						'padding: %1$s;',
						$pagination_padding
					),
				)
			);
		}

		if ( '' !== $pagination_normal_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $pagination_selector,
					'declaration' => sprintf(
						'color: %1$s;',
						$pagination_normal_color
					),
				)
			);
		}

		if ( '' !== $pagination_normal_back ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $pagination_selector,
					'declaration' => sprintf(
						'background-color: %1$s;',
						$pagination_normal_back
					),
				)
			);
		}

		if ( '' !== $pagination_hover_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $pagination_selector . ':hover',
					'declaration' => sprintf(
						'color: %1$s;',
						$pagination_hover_color
					),
				)
			);
		}

		if ( '' !== $pagination_hover_back ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $pagination_selector . ':hover',
					'declaration' => sprintf(
						'background-color: %1$s;',
						$pagination_hover_back
					),
				)
			);
		}

		if ( '' !== $pagination_active_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $pagination_active_selector,
					'declaration' => sprintf(
						'color: %1$s;',
						$pagination_active_color
					),
				)
			);
		}

		if ( '' !== $pagination_active_back ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => $pagination_active_selector,
					'declaration' => sprintf(
						'background-color: %1$s;',
						$pagination_active_back
					),
				)
			);
		}

		// masonry styles.
		// if ( $this->props['masonry'] === 'on' ) {
		// 	ET_Builder_Element::set_style(
		// 		$render_slug,
		// 		array(
		// 			'selector'    => '%%order_class%% .tutor-divi-masonry.tutor-courses-layout-2',
		// 			'declaration' => '-webkit-column-count: 2;
		// 				-moz-column-count: 2;
		// 				column-count: 2;
		// 				-webkit-column-gap: 10px;
		// 				-moz-column-gap: 10px;
		// 				column-gap: 10px;',
		// 		)
		// 	);

		// 	ET_Builder_Element::set_style(
		// 		$render_slug,
		// 		array(
		// 			'selector'    => '%%order_class%% .tutor-divi-masonry.tutor-courses-layout-3',
		// 			'declaration' => '-webkit-column-count: 3;
		// 				-moz-column-count: 3;
		// 				column-count: 3;
		// 				-webkit-column-gap: 10px;
		// 				-moz-column-gap: 10px;
		// 				column-gap: 10px;',
		// 		)
		// 	);

		// 	ET_Builder_Element::set_style(
		// 		$render_slug,
		// 		array(
		// 			'selector'    => '%%order_class%% .tutor-divi-masonry.tutor-courses-layout-4',
		// 			'declaration' => '-webkit-column-count: 4;
		// 				-moz-column-count: 4;
		// 				column-count: 4;
		// 				-webkit-column-gap: 10px;
		// 				-moz-column-gap: 10px;
		// 				column-gap: 10px;',
		// 		)
		// 	);

		// 	ET_Builder_Element::set_style(
		// 		$render_slug,
		// 		array(
		// 			'selector'    => '%%order_class%% .tutor-divi-masonry.tutor-courses-layout-5',
		// 			'declaration' => '-webkit-column-count: 5;
		// 				-moz-column-count: 5;
		// 				column-count: 5;
		// 				-webkit-column-gap: 10px;
		// 				-moz-column-gap: 10px;
		// 				column-gap: 10px;',
		// 		)
		// 	);

		// 	ET_Builder_Element::set_style(
		// 		$render_slug,
		// 		array(
		// 			'selector'    => '%%order_class%% .tutor-divi-masonry .tutor-divi-courselist-col',
		// 			'declaration' => 'display: inline-block;width: auto;position: relative;top: 5px;',
		// 		)
		// 	);

		// 	ET_Builder_Element::set_style(
		// 		$render_slug,
		// 		array(
		// 			'selector'    => '%%order_class%% .tutor-divi-masonry.tutor-divi-courselist-overlayed .tutor-divi-card',
		// 			'declaration' => 'height: auto !important;min-height: 180px;',
		// 		)
		// 	);
		// }

		// layout_styles.
		if ( '' !== $columns_gap ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-grid',
					'declaration' => sprintf(
						'grid-column-gap: %1$s !important;',
						$columns_gap
					),
				)
			);
		}

		if ( '' !== $rows_gap ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .tutor-grid',
					'declaration' => sprintf(
						'grid-row-gap: %1$s !important;',
						$rows_gap
					),
				)
			);
		}
		// filter.
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-course-header a img',
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
				'selector'    => '.tutor_course_list_0,.tutor_course_list_1,.tutor_course_list_2,.tutor_course_list_3,.tutor_course_list_4,.tutor_course_list_5,.tutor_course_list_6',
				'declaration' => 'filter: none !important;',
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

		// author avatar cat gap.
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-loop-author.tutor-d-flex',
				'declaration' => 'gap: 5px;',
			)
		);

		// 1 col style.
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-course-col-1 .tutor-course-header a img',
				'declaration' => 'min-height: 300px; height: auto;',
			)
		);
		// min height for stacked container.
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-courses-layout-2.tutor-divi-courselist-stacked .tutor-divi-courselist-course-container, %%order_class%% .tutor-courses-layout-3.tutor-divi-courselist-stacked .tutor-divi-courselist-course-container',
				'declaration' => 'min-height: 320px !important;',
			)
		);
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'    => '%%order_class%% .tutor-courses-layout-1 .tutor-divi-courselist-stacked .tutor-loop-course-container',
				'declaration' => 'padding: 10px;',
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
new CourseList();
