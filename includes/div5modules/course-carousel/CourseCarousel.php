<?php
/**
 * Divi 5 Course Carousel module.
 *
 * @package TutorLMS\Divi
 */

namespace TutorLMS\Divi\D5\CourseCarousel;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Direct access forbidden.' );
}

use ET\Builder\Framework\DependencyManagement\Interfaces\DependencyInterface;
use ET\Builder\Framework\UserRole\UserRole;
use ET\Builder\Framework\Utility\HTMLUtility;
use ET\Builder\FrontEnd\BlockParser\BlockParserStore;
use ET\Builder\FrontEnd\Module\Style;
use ET\Builder\Packages\Module\Layout\Components\StyleCommon\CommonStyle;
use ET\Builder\Packages\Module\Module;
use ET\Builder\Packages\Module\Options\Element\ElementClassnames;
use ET\Builder\Packages\ModuleLibrary\ModuleRegistration;
use WP_REST_Request;

/**
 * Frontend renderer and REST endpoint for the Divi 5 Course Carousel module.
 */
class CourseCarousel implements DependencyInterface {

	/**
	 * Register the module, conversion helpers, and REST routes.
	 *
	 * @return void
	 */
	public function load() {
		if ( did_action( 'init' ) ) {
			self::register_module();
		} else {
			add_action( 'init', array( self::class, 'register_module' ) );
		}

		add_filter( 'divi.moduleLibrary.conversion.moduleConversionOutline', array( self::class, 'filter_conversion_outline' ), 10, 2 );
		add_filter( 'divi.moduleLibrary.conversion.valueExpansionFunctionMap', array( self::class, 'filter_value_expansion_map' ) );
		add_action( 'rest_api_init', array( self::class, 'register_rest_routes' ) );
	}

	/**
	 * Register the module with Divi 5.
	 *
	 * @return void
	 */
	public static function register_module() {
		ModuleRegistration::register_module(
			__DIR__,
			array(
				'render_callback' => array( self::class, 'render_callback' ),
			)
		);
	}

	/**
	 * Slick asset URLs passed to the Visual Builder script.
	 *
	 * Category and author options come from Course List. Both modules read the same payload.
	 *
	 * @return array
	 */
	public static function visual_builder_data() {
		return array(
			'slick' => array(
				'script' => DTLMS_ASSETS . 'slick/slick.min.js',
				'style'  => DTLMS_ASSETS . 'slick/slick.min.css',
				'theme'  => DTLMS_ASSETS . 'slick/slick-theme.css',
			),
		);
	}

	/**
	 * Convert Divi 4 checkbox strings into selected term or user IDs.
	 *
	 * @param array  $conversion_outline Conversion outline.
	 * @param string $module_name        Module name.
	 * @return array
	 */
	public static function filter_conversion_outline( $conversion_outline, $module_name ) {
		if ( 'tutor-lms/course-carousel' !== $module_name ) {
			return $conversion_outline;
		}

		$conversion_outline['valueExpansionFunctionMap']['category_includes'] = 'tutorCourseCarouselCategoryIncludes';
		$conversion_outline['valueExpansionFunctionMap']['author_includes']   = 'tutorCourseCarouselAuthorIncludes';

		return $conversion_outline;
	}

	/**
	 * Register checkbox conversion callbacks.
	 *
	 * @param array $map Value expansion map.
	 * @return array
	 */
	public static function filter_value_expansion_map( $map ) {
		$map['tutorCourseCarouselCategoryIncludes'] = array( self::class, 'convert_category_includes' );
		$map['tutorCourseCarouselAuthorIncludes']   = array( self::class, 'convert_author_includes' );

		return $map;
	}

	/**
	 * Convert a Divi 4 category checkbox string into category IDs.
	 *
	 * @param string $value Checkbox value.
	 * @return string[]
	 */
	public static function convert_category_includes( $value ) {
		return self::pipe_to_ids( $value, self::available_categories() );
	}

	/**
	 * Convert a Divi 4 author checkbox string into author IDs.
	 *
	 * @param string $value Checkbox value.
	 * @return string[]
	 */
	public static function convert_author_includes( $value ) {
		return self::pipe_to_ids( $value, self::available_authors() );
	}

	/**
	 * Register REST routes used by the Visual Builder.
	 *
	 * @return void
	 */
	public static function register_rest_routes() {
		$args = array();

		foreach ( self::rest_arg_keys() as $key ) {
			$args[ $key ] = array(
				'type'              => 'string',
				'required'          => false,
				'sanitize_callback' => 'sanitize_text_field',
			);
		}

		register_rest_route(
			'tutor-divi/v1',
			'/course-carousel',
			array(
				'methods'             => 'GET',
				'callback'            => array( self::class, 'rest_index' ),
				'permission_callback' => array( self::class, 'rest_permission' ),
				'args'                => $args,
			)
		);
	}

	/**
	 * REST permission callback.
	 *
	 * @return bool
	 */
	public static function rest_permission() {
		if ( class_exists( UserRole::class ) ) {
			return UserRole::can_current_user_use_visual_builder();
		}

		return current_user_can( 'edit_posts' );
	}

	/**
	 * Return the course carousel HTML for Visual Builder.
	 *
	 * @param WP_REST_Request $request REST request.
	 * @return \WP_REST_Response
	 */
	public static function rest_index( WP_REST_Request $request ) {
		$args = array();

		foreach ( self::rest_arg_keys() as $key ) {
			$args[ $key ] = $request->get_param( $key );
		}

		return rest_ensure_response(
			array(
				'html' => self::get_content( $args ),
			)
		);
	}

	/**
	 * Get the course carousel markup.
	 *
	 * Reuses the Divi 4 course carousel template.
	 *
	 * @param array $args Module arguments.
	 * @return string
	 */
	public static function get_content( $args = array() ) {
		if ( ! function_exists( 'tutor' ) || ! function_exists( 'dtlms_get_template' ) ) {
			return '';
		}

		$args = self::template_args( $args );
		ob_start();
		include dtlms_get_template( 'course/course_carousel' );
		return ob_get_clean();
	}

	/**
	 * Query-string keys accepted by the Visual Builder endpoint.
	 *
	 * @return string[]
	 */
	private static function rest_arg_keys() {
		return array(
			'skin',
			'slides_to_show',
			'hover_animation',
			'show_image',
			'image_size',
			'meta_data',
			'rating',
			'avatar',
			'author',
			'difficulty_label',
			'wish_list',
			'show_category',
			'footer',
			'order_by',
			'order',
			'limit',
			'category_includes',
			'author_includes',
			'arrows',
			'dots',
			'transition',
			'center_slides',
			'smooth_scrolling',
			'autoplay',
			'autoplay_speed',
			'infinite_loop',
			'pause_on_hover',
			'dots_alignment',
		);
	}

	/**
	 * Normalize module arguments for the course carousel template.
	 *
	 * @param array $args Raw arguments.
	 * @return array
	 */
	private static function template_args( $args ) {
		$args = wp_parse_args(
			$args,
			array(
				'skin'              => 'classic',
				'slides_to_show'    => '3',
				'hover_animation'   => 'on',
				'show_image'        => 'on',
				'image_size'        => 'medium_large',
				'meta_data'         => 'off',
				'rating'            => 'on',
				'avatar'            => 'on',
				'author'            => 'on',
				'difficulty_label'  => 'off',
				'wish_list'         => 'on',
				'show_category'     => 'off',
				'footer'            => 'on',
				'order_by'          => 'date',
				'order'             => 'DESC',
				'limit'             => '5',
				'category_includes' => '',
				'author_includes'   => '',
				'arrows'            => 'on',
				'dots'              => 'on',
				'transition'        => '600',
				'center_slides'     => 'off',
				'smooth_scrolling'  => 'on',
				'autoplay'          => 'on',
				'autoplay_speed'    => '5000',
				'infinite_loop'     => 'on',
				'pause_on_hover'    => 'on',
				'dots_alignment'    => 'center',
			)
		);

		$args['skin']              = self::one_of( $args['skin'], array( 'classic', 'card', 'stacked', 'overlayed' ), 'classic' );
		$args['slides_to_show']    = self::one_of( (string) $args['slides_to_show'], array( '1', '2', '3' ), '3' );
		$args['image_size']        = self::one_of( $args['image_size'], array( 'thumbnail', 'medium', 'medium_large', 'large', 'full' ), 'medium_large' );
		$args['order_by']          = self::one_of( $args['order_by'], array( 'date', 'title' ), 'date' );
		$args['order']             = self::one_of( $args['order'], array( 'ASC', 'DESC' ), 'DESC' );
		$args['dots_alignment']    = self::one_of( $args['dots_alignment'], array( 'left', 'center', 'right' ), 'center' );
		$args['hover_animation']   = self::toggle( $args['hover_animation'], 'on' );
		$args['show_image']        = self::toggle( $args['show_image'], 'on' );
		$args['meta_data']         = self::toggle( $args['meta_data'], 'off' );
		$args['rating']            = self::toggle( $args['rating'], 'on' );
		$args['avatar']            = self::toggle( $args['avatar'], 'on' );
		$args['author']            = self::toggle( $args['author'], 'on' );
		$args['difficulty_label']  = self::toggle( $args['difficulty_label'], 'off' );
		$args['wish_list']         = self::toggle( $args['wish_list'], 'on' );
		$args['show_category']     = self::toggle( $args['show_category'], 'off' );
		$args['footer']            = self::toggle( $args['footer'], 'on' );
		$args['arrows']            = self::toggle( $args['arrows'], 'on' );
		$args['dots']              = self::toggle( $args['dots'], 'on' );
		$args['center_slides']     = self::toggle( $args['center_slides'], 'off' );
		$args['smooth_scrolling']  = self::toggle( $args['smooth_scrolling'], 'on' );
		$args['autoplay']          = self::toggle( $args['autoplay'], 'on' );
		$args['infinite_loop']     = self::toggle( $args['infinite_loop'], 'on' );
		$args['pause_on_hover']    = self::toggle( $args['pause_on_hover'], 'on' );
		$args['limit']             = self::limit_value( $args['limit'] );
		$args['transition']        = self::number_value( $args['transition'], '600' );
		$args['autoplay_speed']    = self::number_value( $args['autoplay_speed'], '5000' );
		$args['category_includes'] = self::includes_to_pipe( $args['category_includes'], self::available_categories() );
		$args['author_includes']   = self::includes_to_pipe( $args['author_includes'], self::available_authors() );

		return $args;
	}

	/**
	 * Read a desktop attribute value.
	 *
	 * @param array $attr    Attribute array.
	 * @param mixed $default Fallback value.
	 * @return mixed
	 */
	private static function desktop_value( $attr, $default ) {
		if ( ! isset( $attr['desktop']['value'] ) ) {
			return $default;
		}

		$value = $attr['desktop']['value'];

		if ( is_array( $value ) ) {
			return $value;
		}

		if ( is_int( $value ) || is_float( $value ) ) {
			return (string) $value;
		}

		return is_string( $value ) && '' !== $value ? $value : $default;
	}

	/**
	 * Arguments consumed by the course carousel template.
	 *
	 * @param array $attrs Module attributes.
	 * @return array
	 */
	private static function content_args( $attrs ) {
		$content = $attrs['content']['advanced'] ?? array();

		return array(
			'skin'              => self::desktop_value( $content['skin'] ?? array(), 'classic' ),
			'slides_to_show'    => self::desktop_value( $content['slidesToShow'] ?? array(), '3' ),
			'hover_animation'   => self::desktop_value( $content['hoverAnimation'] ?? array(), 'on' ),
			'show_image'        => self::desktop_value( $content['showImage'] ?? array(), 'on' ),
			'image_size'        => self::desktop_value( $content['imageSize'] ?? array(), 'medium_large' ),
			'meta_data'         => self::desktop_value( $content['metaData'] ?? array(), 'off' ),
			'rating'            => self::desktop_value( $content['rating'] ?? array(), 'on' ),
			'avatar'            => self::desktop_value( $content['avatar'] ?? array(), 'on' ),
			'author'            => self::desktop_value( $content['author'] ?? array(), 'on' ),
			'difficulty_label'  => self::desktop_value( $content['difficultyLabel'] ?? array(), 'off' ),
			'wish_list'         => self::desktop_value( $content['wishList'] ?? array(), 'on' ),
			'show_category'     => self::desktop_value( $content['showCategory'] ?? array(), 'off' ),
			'footer'            => self::desktop_value( $content['footer'] ?? array(), 'on' ),
			'order_by'          => self::desktop_value( $content['orderBy'] ?? array(), 'date' ),
			'order'             => self::desktop_value( $content['order'] ?? array(), 'DESC' ),
			'limit'             => self::desktop_value( $content['limit'] ?? array(), '5' ),
			'category_includes' => self::desktop_value( $content['categoryIncludes'] ?? array(), array() ),
			'author_includes'   => self::desktop_value( $content['authorIncludes'] ?? array(), array() ),
			'arrows'            => self::desktop_value( $content['arrows'] ?? array(), 'on' ),
			'dots'              => self::desktop_value( $content['dots'] ?? array(), 'on' ),
			'transition'        => self::desktop_value( $content['transition'] ?? array(), '600' ),
			'center_slides'     => self::desktop_value( $content['centerSlides'] ?? array(), 'off' ),
			'smooth_scrolling'  => self::desktop_value( $content['smoothScrolling'] ?? array(), 'on' ),
			'autoplay'          => self::desktop_value( $content['autoplay'] ?? array(), 'on' ),
			'autoplay_speed'    => self::desktop_value( $content['autoplaySpeed'] ?? array(), '5000' ),
			'infinite_loop'     => self::desktop_value( $content['infiniteLoop'] ?? array(), 'on' ),
			'pause_on_hover'    => self::desktop_value( $content['pauseOnHover'] ?? array(), 'on' ),
			'dots_alignment'    => self::desktop_value( $content['dotsAlignment'] ?? array(), 'center' ),
		);
	}

	/**
	 * Course categories keyed by term ID.
	 *
	 * @return array
	 */
	private static function available_categories() {
		if ( ! function_exists( 'tutor_divi_course_categories' ) ) {
			return array();
		}

		$categories = tutor_divi_course_categories();

		return is_array( $categories ) ? $categories : array();
	}

	/**
	 * Course authors keyed by user ID.
	 *
	 * @return array
	 */
	private static function available_authors() {
		if ( ! function_exists( 'tutor_divi_course_authors' ) ) {
			return array();
		}

		$authors = tutor_divi_course_authors();

		return is_array( $authors ) ? $authors : array();
	}

	/**
	 * Turn selected IDs, or a Divi 4 on/off string, into the template pipe format.
	 *
	 * @param mixed $selected  Selected values.
	 * @param array $available Available items keyed by ID.
	 * @return string
	 */
	private static function includes_to_pipe( $selected, $available ) {
		if ( is_string( $selected ) && false !== strpos( $selected, '|' ) ) {
			return $selected;
		}

		$selected_ids = self::selected_ids( $selected );

		if ( empty( $selected_ids ) || empty( $available ) ) {
			return '';
		}

		ksort( $available );
		$parts = array();

		foreach ( array_keys( $available ) as $id ) {
			$parts[] = in_array( (string) $id, $selected_ids, true ) ? 'on' : 'off';
		}

		return implode( '|', $parts );
	}

	/**
	 * Convert a Divi 4 pipe string into selected IDs.
	 *
	 * @param mixed $value     Checkbox value.
	 * @param array $available Available items keyed by ID.
	 * @return string[]
	 */
	private static function pipe_to_ids( $value, $available ) {
		if ( ! is_string( $value ) || '' === $value || empty( $available ) ) {
			return array();
		}

		ksort( $available );
		$flags = explode( '|', $value );
		$keys  = array_values( array_map( 'strval', array_keys( $available ) ) );
		$ids   = array();

		foreach ( $flags as $index => $flag ) {
			if ( 'on' === $flag && isset( $keys[ $index ] ) ) {
				$ids[] = $keys[ $index ];
			}
		}

		return $ids;
	}

	/**
	 * Normalize selected checkbox values to a list of IDs.
	 *
	 * @param mixed $selected Selected values.
	 * @return string[]
	 */
	private static function selected_ids( $selected ) {
		if ( is_string( $selected ) ) {
			$selected = array_filter( array_map( 'trim', explode( ',', $selected ) ) );
		}

		if ( ! is_array( $selected ) ) {
			return array();
		}

		$ids = array();

		foreach ( $selected as $key => $value ) {
			if ( is_int( $key ) && ( is_string( $value ) || is_numeric( $value ) ) ) {
				$ids[] = (string) $value;
				continue;
			}

			if ( 'on' === $value || true === $value ) {
				$ids[] = (string) $key;
			}
		}

		return $ids;
	}

	/**
	 * Keep a value only when it is one of the allowed options.
	 *
	 * @param mixed  $value   Candidate value.
	 * @param array  $allowed Allowed values.
	 * @param string $default Fallback value.
	 * @return string
	 */
	private static function one_of( $value, $allowed, $default ) {
		$value = is_string( $value ) ? $value : $default;

		return in_array( $value, $allowed, true ) ? $value : $default;
	}

	/**
	 * Normalize a show/hide toggle.
	 *
	 * @param mixed  $value   Candidate value.
	 * @param string $default Fallback value.
	 * @return string
	 */
	private static function toggle( $value, $default ) {
		return self::one_of( $value, array( 'on', 'off' ), $default );
	}

	/**
	 * Normalize the course limit. -1 means every course.
	 *
	 * @param mixed $value Candidate value.
	 * @return string
	 */
	private static function limit_value( $value ) {
		if ( ! is_numeric( $value ) ) {
			return '5';
		}

		$limit = (int) $value;

		if ( $limit < -1 ) {
			return '5';
		}

		return (string) $limit;
	}

	/**
	 * Normalize a non-negative integer setting.
	 *
	 * @param mixed  $value   Candidate value.
	 * @param string $default Fallback value.
	 * @return string
	 */
	private static function number_value( $value, $default ) {
		if ( ! is_numeric( $value ) ) {
			return $default;
		}

		$number = (int) $value;

		if ( $number < 0 ) {
			return $default;
		}

		return (string) $number;
	}

	/**
	 * Render module classnames.
	 *
	 * @param array $args Classname arguments.
	 * @return void
	 */
	public static function module_classnames( $args ) {
		$classnames_instance = $args['classnamesInstance'];
		$attrs               = $args['attrs'];

		$classnames_instance->add(
			ElementClassnames::classnames(
				array(
					'attrs' => $attrs['module']['decoration'] ?? array(),
				)
			)
		);
	}

	/**
	 * Render module script data.
	 *
	 * @param array $args Script data arguments.
	 * @return void
	 */
	public static function module_script_data( $args ) {
		$elements = $args['elements'];

		$elements->script_data(
			array(
				'attrName' => 'module',
			)
		);
	}

	/**
	 * Map a dots alignment value to a flex justification.
	 *
	 * @param string $alignment Alignment value.
	 * @return string
	 */
	private static function dots_justification( $alignment ) {
		if ( 'left' === $alignment ) {
			return 'flex-start';
		}

		if ( 'right' === $alignment ) {
			return 'flex-end';
		}

		return 'center';
	}

	/**
	 * Render module styles.
	 *
	 * @param array $args Style arguments.
	 * @return void
	 */
	public static function module_styles( $args ) {
		$attrs       = $args['attrs'] ?? array();
		$elements    = $args['elements'];
		$settings    = $args['settings'] ?? array();
		$order_class = $args['orderClass'] ?? '';
		$content     = $attrs['content']['advanced'] ?? array();
		$card        = $attrs['card']['advanced'] ?? array();
		$rating      = $attrs['rating']['advanced'] ?? array();

		Style::add(
			array(
				'id'            => $args['id'],
				'name'          => $args['name'],
				'orderIndex'    => $args['orderIndex'],
				'storeInstance' => $args['storeInstance'],
				'styles'        => array(
					$elements->style(
						array(
							'attrName'   => 'module',
							'styleProps' => array(
								'disabledOn' => array(
									'disabledModuleVisibility' => $settings['disabledModuleVisibility'] ?? null,
								),
							),
						)
					),
					$elements->style(
						array(
							'attrName' => 'title',
						)
					),
					$elements->style(
						array(
							'attrName' => 'meta',
						)
					),
					$elements->style(
						array(
							'attrName' => 'category',
						)
					),
					CommonStyle::style(
						array(
							'selector'            => "{$order_class} .tutor-course-thumbnail",
							'attr'                => $content['showImage'] ?? array(
								'desktop' => array(
									'value' => 'on',
								),
							),
							'declarationFunction' => function ( $params ) {
								return 'off' === ( $params['attrValue'] ?? 'on' ) ? 'display: none !important;' : '';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => "{$order_class} .tutor-course-ratings, {$order_class} .tutor-ratings",
							'attr'                => $content['rating'] ?? array(
								'desktop' => array(
									'value' => 'on',
								),
							),
							'declarationFunction' => function ( $params ) {
								return 'off' === ( $params['attrValue'] ?? 'on' ) ? 'display: none !important;' : '';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => "{$order_class} .dtlms-course-duration-meta",
							'attr'                => $content['metaData'] ?? array(
								'desktop' => array(
									'value' => 'off',
								),
							),
							'declarationFunction' => function ( $params ) {
								return 'off' === ( $params['attrValue'] ?? 'off' ) ? 'display: none !important;' : '';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => "{$order_class} .tutor-course-card, {$order_class} .tutor-card",
							'attr'                => $card['backgroundColor'] ?? array(),
							'declarationFunction' => function ( $params ) {
								$color = $params['attrValue'] ?? '';

								return '' !== $color ? sprintf( 'background-color: %1$s;', esc_html( $color ) ) : '';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => "{$order_class} .slick-slide",
							'attr'                => $card['gap'] ?? array(
								'desktop' => array(
									'value' => '15px',
								),
							),
							'declarationFunction' => function ( $params ) {
								$gap = $params['attrValue'] ?? '';

								return '' !== $gap ? sprintf( 'margin-left: %1$s !important; margin-right: %1$s !important;', esc_html( $gap ) ) : '';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => "{$order_class} .tutor-card-body",
							'attr'                => $card['bodyPadding'] ?? array(
								'desktop' => array(
									'value' => '18px',
								),
							),
							'declarationFunction' => function ( $params ) {
								$padding = $params['attrValue'] ?? '';

								return '' !== $padding ? sprintf( 'padding: %1$s !important;', esc_html( $padding ) ) : '';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => "{$order_class} .tutor-ratings-stars span",
							'attr'                => $rating['starColor'] ?? array(),
							'declarationFunction' => function ( $params ) {
								$color = $params['attrValue'] ?? '';

								return '' !== $color ? sprintf( 'color: %1$s;', esc_html( $color ) ) : '';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => "{$order_class} .tutor-ratings-stars span",
							'attr'                => $rating['starSize'] ?? array(
								'desktop' => array(
									'value' => '18px',
								),
							),
							'declarationFunction' => function ( $params ) {
								$size = $params['attrValue'] ?? '';

								return '' !== $size ? sprintf( 'font-size: %1$s;', esc_html( $size ) ) : '';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => "{$order_class} .tutor-ratings-stars span",
							'attr'                => $rating['starGap'] ?? array(),
							'declarationFunction' => function ( $params ) {
								$gap = $params['attrValue'] ?? '';

								return '' !== $gap ? sprintf( 'margin-left: %1$s !important; margin-right: %1$s !important;', esc_html( $gap ) ) : '';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => "{$order_class} .slick-dots",
							'attr'                => $content['dotsAlignment'] ?? array(
								'desktop' => array(
									'value' => 'center',
								),
							),
							'declarationFunction' => function ( $params ) {
								$alignment = self::dots_justification( (string) ( $params['attrValue'] ?? 'center' ) );

								return sprintf( 'display: flex !important; bottom: -50px !important; justify-content: %1$s; column-gap: 5px;', esc_html( $alignment ) );
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => "#et-fb-app {$order_class} .tutor-divi-carousel-main-wrap",
							'attr'                => $content['arrows'] ?? array(
								'desktop' => array(
									'value' => 'on',
								),
							),
							'declarationFunction' => function () {
								return 'position: relative; padding: 0 36px 48px;';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => "#et-fb-app {$order_class} .slick-prev",
							'attr'                => $content['arrows'] ?? array(
								'desktop' => array(
									'value' => 'on',
								),
							),
							'declarationFunction' => function () {
								return 'left: 6px; z-index: 2;';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => "#et-fb-app {$order_class} .slick-next",
							'attr'                => $content['arrows'] ?? array(
								'desktop' => array(
									'value' => 'on',
								),
							),
							'declarationFunction' => function () {
								return 'right: 6px; z-index: 2;';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => "#et-fb-app {$order_class} .slick-prev:before, #et-fb-app {$order_class} .slick-next:before",
							'attr'                => $content['arrows'] ?? array(
								'desktop' => array(
									'value' => 'on',
								),
							),
							'declarationFunction' => function () {
								return 'color: #2c3e50;';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => "#et-fb-app {$order_class} .slick-dots",
							'attr'                => $content['dots'] ?? array(
								'desktop' => array(
									'value' => 'on',
								),
							),
							'declarationFunction' => function () {
								return 'bottom: 12px !important;';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => "{$order_class} .slick-track",
							'attr'                => $content['skin'] ?? array(
								'desktop' => array(
									'value' => 'classic',
								),
							),
							'declarationFunction' => function ( $params ) {
								$skin = $params['attrValue'] ?? 'classic';

								if ( 'classic' !== $skin && 'card' !== $skin ) {
									return '';
								}

								return 'display: flex; flex-direction: row; flex-wrap: nowrap; align-items: stretch;';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => "{$order_class} .tutor-course-card",
							'attr'                => $content['skin'] ?? array(
								'desktop' => array(
									'value' => 'classic',
								),
							),
							'declarationFunction' => function ( $params ) {
								$skin = $params['attrValue'] ?? 'classic';

								if ( 'classic' !== $skin && 'card' !== $skin ) {
									return '';
								}

								return 'display: flex; flex-direction: column; justify-content: space-between; height: 100%;';
							},
						)
					),
				),
			)
		);
	}

	/**
	 * Frontend render callback.
	 *
	 * @param array  $attrs    Module attributes.
	 * @param string $content  Block content.
	 * @param object $block    Parsed block.
	 * @param object $elements Module elements.
	 * @return string
	 */
	public static function render_callback( $attrs, $content, $block, $elements ) {
		if ( function_exists( 'dtlms_enqueue_carousel_assets' ) ) {
			dtlms_enqueue_carousel_assets();
		}

		$output = self::get_content( self::content_args( $attrs ) );

		if ( '' === $output ) {
			return '';
		}

		$parent = BlockParserStore::get_parent( $block->parsed_block['id'], $block->parsed_block['storeInstance'] );

		return Module::render(
			array(
				'orderIndex'          => $block->parsed_block['orderIndex'],
				'storeInstance'       => $block->parsed_block['storeInstance'],
				'attrs'               => $attrs,
				'elements'            => $elements,
				'id'                  => $block->parsed_block['id'],
				'name'                => $block->block_type->name,
				'classnamesFunction'  => array( self::class, 'module_classnames' ),
				'moduleCategory'      => $block->block_type->category,
				'stylesComponent'     => array( self::class, 'module_styles' ),
				'scriptDataComponent' => array( self::class, 'module_script_data' ),
				'parentAttrs'         => is_object( $parent ) ? ( $parent->attrs ?? array() ) : array(),
				'parentId'            => is_object( $parent ) ? ( $parent->id ?? '' ) : '',
				'parentName'          => is_object( $parent ) ? ( $parent->blockName ?? '' ) : '',
				'children'            => array(
					$elements->style_components(
						array(
							'attrName' => 'module',
						)
					),
					HTMLUtility::render(
						array(
							'tag'               => 'div',
							'tagEscaped'        => true,
							'attributes'        => array(
								'class' => 'et_pb_module_inner',
							),
							'childrenSanitizer' => 'et_core_esc_previously',
							'children'          => $output,
						)
					),
				),
			)
		);
	}
}
