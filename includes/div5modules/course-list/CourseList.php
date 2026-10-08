<?php
/**
 * Divi 5 Course List module.
 *
 * @package TutorLMS\Divi
 */

namespace TutorLMS\Divi\D5\CourseList;

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
 * Frontend renderer and REST endpoints for the Divi 5 Course List module.
 */
class CourseList implements DependencyInterface {

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
	 * Category and author options passed to the Visual Builder script.
	 *
	 * @return array
	 */
	public static function visual_builder_data() {
		return array(
			'categories' => self::checkbox_options( self::available_categories() ),
			'authors'    => self::checkbox_options( self::available_authors() ),
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
		if ( 'tutor-lms/course-list' !== $module_name ) {
			return $conversion_outline;
		}

		$conversion_outline['valueExpansionFunctionMap']['category_includes'] = 'tutorCourseListCategoryIncludes';
		$conversion_outline['valueExpansionFunctionMap']['author_includes']   = 'tutorCourseListAuthorIncludes';

		return $conversion_outline;
	}

	/**
	 * Register checkbox conversion callbacks.
	 *
	 * @param array $map Value expansion map.
	 * @return array
	 */
	public static function filter_value_expansion_map( $map ) {
		$map['tutorCourseListCategoryIncludes'] = array( self::class, 'convert_category_includes' );
		$map['tutorCourseListAuthorIncludes']   = array( self::class, 'convert_author_includes' );

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
			'/course-list',
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
	 * Return the course list HTML for Visual Builder.
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
	 * Get the course list markup.
	 *
	 * Reuses the Divi 4 course list template.
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
		include dtlms_get_template( 'course/course_list' );
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
			'columns',
			'hover_animation',
			'image_size',
			'avatar',
			'author',
			'difficulty_label',
			'wish_list',
			'show_category',
			'footer',
			'pagination',
			'order_by',
			'order',
			'limit',
			'category_includes',
			'author_includes',
			'pagination_type',
			'prev_level',
			'next_level',
		);
	}

	/**
	 * Normalize module arguments for the course list template.
	 *
	 * @param array $args Raw arguments.
	 * @return array
	 */
	private static function template_args( $args ) {
		$args = wp_parse_args(
			$args,
			array(
				'skin'              => 'classic',
				'columns'           => '3',
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
				'pagination'        => 'on',
				'order_by'          => 'date',
				'order'             => 'DESC',
				'limit'             => '6',
				'category_includes' => '',
				'author_includes'   => '',
				'pagination_type'   => 'prev_next',
				'prev_level'        => __( 'Previous', 'tutor-lms-divi-modules' ),
				'next_level'        => __( 'Next', 'tutor-lms-divi-modules' ),
			)
		);

		$args['skin']             = self::one_of( $args['skin'], array( 'classic', 'card', 'stacked', 'overlayed' ), 'classic' );
		$args['columns']          = self::one_of( (string) $args['columns'], array( '2', '3', '4' ), '3' );
		$args['image_size']       = self::one_of( $args['image_size'], array( 'thumbnail', 'medium', 'medium_large', 'large', 'full' ), 'medium_large' );
		$args['order_by']         = self::one_of( $args['order_by'], array( 'date', 'title' ), 'date' );
		$args['order']            = self::one_of( $args['order'], array( 'ASC', 'DESC' ), 'DESC' );
		$args['pagination_type']  = self::one_of( $args['pagination_type'], array( 'prev_next', 'numbers' ), 'prev_next' );
		$args['hover_animation']  = self::toggle( $args['hover_animation'], 'on' );
		$args['show_image']       = self::toggle( $args['show_image'], 'on' );
		$args['meta_data']        = self::toggle( $args['meta_data'], 'off' );
		$args['rating']           = self::toggle( $args['rating'], 'on' );
		$args['avatar']           = self::toggle( $args['avatar'], 'on' );
		$args['author']           = self::toggle( $args['author'], 'on' );
		$args['difficulty_label'] = self::toggle( $args['difficulty_label'], 'off' );
		$args['wish_list']        = self::toggle( $args['wish_list'], 'on' );
		$args['show_category']    = self::toggle( $args['show_category'], 'off' );
		$args['footer']           = self::toggle( $args['footer'], 'on' );
		$args['pagination']       = self::toggle( $args['pagination'], 'on' );
		$args['limit']            = self::limit_value( $args['limit'] );
		$args['prev_level']       = sanitize_text_field( (string) $args['prev_level'] );
		$args['next_level']       = sanitize_text_field( (string) $args['next_level'] );
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
	 * Arguments consumed by the course list template.
	 *
	 * @param array $attrs Module attributes.
	 * @return array
	 */
	private static function content_args( $attrs ) {
		$content = $attrs['content']['advanced'] ?? array();

		return array(
			'skin'              => self::desktop_value( $content['skin'] ?? array(), 'classic' ),
			'columns'           => self::desktop_value( $content['columns'] ?? array(), '3' ),
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
			'pagination'        => self::desktop_value( $content['pagination'] ?? array(), 'on' ),
			'order_by'          => self::desktop_value( $content['orderBy'] ?? array(), 'date' ),
			'order'             => self::desktop_value( $content['order'] ?? array(), 'DESC' ),
			'limit'             => self::desktop_value( $content['limit'] ?? array(), '6' ),
			'category_includes' => self::desktop_value( $content['categoryIncludes'] ?? array(), array() ),
			'author_includes'   => self::desktop_value( $content['authorIncludes'] ?? array(), array() ),
			'pagination_type'   => self::desktop_value( $content['paginationType'] ?? array(), 'prev_next' ),
			'prev_level'        => self::desktop_value( $content['prevLabel'] ?? array(), __( 'Previous', 'tutor-lms-divi-modules' ) ),
			'next_level'        => self::desktop_value( $content['nextLabel'] ?? array(), __( 'Next', 'tutor-lms-divi-modules' ) ),
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
	 * Checkbox options for a Divi checkboxes field.
	 *
	 * @param array $items ID to label map.
	 * @return array
	 */
	private static function checkbox_options( $items ) {
		$options = array();

		foreach ( $items as $id => $label ) {
			$options[] = array(
				'value' => (string) $id,
				'label' => (string) $label,
			);
		}

		return $options;
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
			return '6';
		}

		$limit = (int) $value;

		if ( $limit < -1 ) {
			return '6';
		}

		return (string) $limit;
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
							'selector'            => "{$order_class} .tutor-grid",
							'attr'                => $attrs['layout']['advanced']['columnsGap'] ?? array(),
							'declarationFunction' => function ( $params ) {
								$gap = $params['attrValue'] ?? '';

								return '' !== $gap ? sprintf( 'grid-column-gap: %1$s !important;', esc_html( $gap ) ) : '';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => "{$order_class} .tutor-grid",
							'attr'                => $attrs['layout']['advanced']['rowsGap'] ?? array(),
							'declarationFunction' => function ( $params ) {
								$gap = $params['attrValue'] ?? '';

								return '' !== $gap ? sprintf( 'grid-row-gap: %1$s !important;', esc_html( $gap ) ) : '';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => "{$order_class} .tutor-course-card, {$order_class} .dtlms-course-list-col .dtlms-course-card-inner",
							'attr'                => $attrs['card']['advanced']['backgroundColor'] ?? array(),
							'declarationFunction' => function ( $params ) {
								$color = $params['attrValue'] ?? '';

								return '' !== $color ? sprintf( 'background-color: %1$s;', esc_html( $color ) ) : '';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => "{$order_class} .tutor-ratings-stars span",
							'attr'                => $attrs['rating']['advanced']['starColor'] ?? array(),
							'declarationFunction' => function ( $params ) {
								$color = $params['attrValue'] ?? '';

								return '' !== $color ? sprintf( 'color: %1$s;', esc_html( $color ) ) : '';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => "{$order_class} .tutor-ratings-stars span",
							'attr'                => $attrs['rating']['advanced']['starSize'] ?? array(
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
