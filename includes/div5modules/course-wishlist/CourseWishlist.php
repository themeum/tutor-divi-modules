<?php
/**
 * Divi 5 Course Wishlist module.
 *
 * @package TutorLMS\Divi
 */

namespace TutorLMS\Divi\D5\CourseWishlist;

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
use TutorLMS\Divi\Helper;
use WP_REST_Request;

/**
 * Frontend renderer and REST endpoints for the Divi 5 Course Wishlist module.
 */
class CourseWishlist implements DependencyInterface {

	/**
	 * Register the module and REST routes.
	 *
	 * @return void
	 */
	public function load() {
		if ( did_action( 'init' ) ) {
			self::register_module();
		} else {
			add_action( 'init', array( self::class, 'register_module' ) );
		}

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
	 * Register REST routes used by the Visual Builder.
	 *
	 * @return void
	 */
	public static function register_rest_routes() {
		register_rest_route(
			'tutor-divi/v1',
			'/course-wishlist',
			array(
				'methods'             => 'GET',
				'callback'            => array( self::class, 'rest_index' ),
				'permission_callback' => array( self::class, 'rest_permission' ),
				'args'                => array(
					'label'      => array(
						'type'              => 'string',
						'required'          => false,
						'sanitize_callback' => 'sanitize_text_field',
					),
					'show_label' => array(
						'type'     => 'string',
						'required' => false,
					),
					'show_icon'  => array(
						'type'     => 'string',
						'required' => false,
					),
				),
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
	 * Return the course wishlist HTML for Visual Builder.
	 *
	 * @param WP_REST_Request $request REST request.
	 * @return \WP_REST_Response
	 */
	public static function rest_index( WP_REST_Request $request ) {
		return rest_ensure_response(
			array(
				'html' => self::get_content(
					array(
						'label'                     => $request->get_param( 'label' ),
						'course_wishlist_text_show' => $request->get_param( 'show_label' ),
						'course_wishlist_icon_show' => $request->get_param( 'show_icon' ),
					)
				),
			)
		);
	}

	/**
	 * Keep a yes/no value as on or off.
	 *
	 * @param mixed  $value   Raw value.
	 * @param string $default Fallback when the value is empty.
	 * @return string
	 */
	private static function toggle_value( $value, $default = 'on' ) {
		if ( null === $value || '' === $value ) {
			return $default;
		}

		return 'off' === $value ? 'off' : 'on';
	}

	/**
	 * Get the course wishlist markup.
	 *
	 * @param array $args Module arguments.
	 * @return string
	 */
	public static function get_content( $args = array() ) {
		if ( ! function_exists( 'tutor_utils' ) ) {
			return '';
		}

		$args = wp_parse_args(
			$args,
			array(
				'label'                     => 'Wishlist',
				'course_wishlist_text_show' => 'on',
				'course_wishlist_icon_show' => 'on',
			)
		);

		$course = Helper::get_course();

		if ( ! $course ) {
			wp_reset_postdata();
			return '';
		}

		$is_wishlisted = tutor_utils()->is_wishlisted( $course, get_current_user_id() );
		$show_icon     = 'on' === self::toggle_value( $args['course_wishlist_icon_show'] );
		$show_text     = 'on' === self::toggle_value( $args['course_wishlist_text_show'] );
		$icon_class    = $is_wishlisted ? 'tutor-icon-bookmark-bold' : 'tutor-icon-bookmark-line';
		$label         = sanitize_text_field( (string) $args['label'] );
		$icon_html     = $show_icon ? '<i class="tutor-mr-8 ' . esc_attr( $icon_class ) . '"></i>' : '';
		$text_html     = '<span>' . ( $show_text ? esc_html( $label ) : '' ) . '</span>';

		$markup = '<div class="dtlms-course-wishlist-wrapper"><a href="#" class="tutor-btn tutor-btn-ghost tutor-course-wishlist-btn tutor-mr-16" data-course-id="' . esc_attr( (string) $course ) . '">' . $icon_html . $text_html . '</a></div>';

		wp_reset_postdata();

		return apply_filters( 'dtlms_course_wishlist', $markup );
	}

	/**
	 * Append px when a range value is a bare number.
	 *
	 * @param mixed $value Length value.
	 * @return string
	 */
	private static function css_length( $value ) {
		$value = trim( (string) $value );

		if ( '' === $value ) {
			return '';
		}

		return is_numeric( $value ) ? $value . 'px' : $value;
	}

	/**
	 * Map left/center/right onto a flex alignment value.
	 *
	 * @param string $alignment Alignment value.
	 * @return string
	 */
	private static function flex_alignment( $alignment ) {
		if ( 'right' === $alignment ) {
			return 'flex-end';
		}

		if ( 'center' === $alignment ) {
			return 'center';
		}

		return 'flex-start';
	}

	/**
	 * Read a desktop attribute value.
	 *
	 * @param array  $attrs   Module attributes.
	 * @param string $key     Advanced key.
	 * @param string $default Fallback value.
	 * @return string
	 */
	private static function content_value( $attrs, $key, $default ) {
		$value = $attrs['content']['advanced'][ $key ]['desktop']['value'] ?? $default;

		if ( is_int( $value ) || is_float( $value ) ) {
			return (string) $value;
		}

		return is_string( $value ) && '' !== $value ? $value : $default;
	}

	/**
	 * Render module classnames.
	 *
	 * @param array $args Classname arguments.
	 * @return void
	 */
	public static function module_classnames( $args ) {
		$args['classnamesInstance']->add(
			ElementClassnames::classnames(
				array(
					'attrs' => $args['attrs']['module']['decoration'] ?? array(),
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
		$args['elements']->script_data(
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
		$link        = "{$order_class} .dtlms-course-wishlist-wrapper a";
		$advanced    = $attrs['content']['advanced'] ?? array();

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
					$elements->style( array( 'attrName' => 'labelText' ) ),
					$elements->style( array( 'attrName' => 'iconText' ) ),
					CommonStyle::style(
						array(
							'selector'            => $link,
							'attr'                => $advanced['alignment'] ?? array(
								'desktop' => array(
									'value' => 'left',
								),
							),
							'declarationFunction' => function ( $params ) {
								$alignment = self::flex_alignment( $params['attrValue'] ?? 'left' );

								return sprintf(
									'display: flex; align-items: center; justify-content: %1$s;',
									esc_html( $alignment )
								);
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => $link,
							'attr'                => $advanced['spaceBetween'] ?? array(
								'desktop' => array(
									'value' => '2px',
								),
							),
							'declarationFunction' => function ( $params ) {
								$gap = self::css_length( $params['attrValue'] ?? '' );

								return '' !== $gap ? sprintf( 'column-gap: %1$s;', esc_html( $gap ) ) : '';
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
		$output = self::get_content(
			array(
				'label'                     => self::content_value( $attrs, 'label', 'Wishlist' ),
				'course_wishlist_text_show' => self::content_value( $attrs, 'showLabel', 'on' ),
				'course_wishlist_icon_show' => self::content_value( $attrs, 'showIcon', 'on' ),
			)
		);

		if ( '' === trim( (string) $output ) ) {
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
