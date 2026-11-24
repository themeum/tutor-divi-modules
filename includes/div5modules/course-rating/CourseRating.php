<?php
/**
 * Divi 5 Course Rating module.
 *
 * @package TutorLMS\Divi
 */

namespace TutorLMS\Divi\D5\CourseRating;

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
 * Frontend renderer and REST endpoints for the Divi 5 Course Rating module.
 */
class CourseRating implements DependencyInterface {

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
			'/course-rating',
			array(
				'methods'             => 'GET',
				'callback'            => array( self::class, 'rest_index' ),
				'permission_callback' => array( self::class, 'rest_permission' ),
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
	 * Return the course rating HTML for Visual Builder.
	 *
	 * @param WP_REST_Request $request REST request.
	 * @return \WP_REST_Response
	 */
	public static function rest_index( WP_REST_Request $request ) {
		unset( $request );

		return rest_ensure_response(
			array(
				'html' => self::get_content(),
			)
		);
	}

	/**
	 * Get the course rating markup.
	 *
	 * Reuses the Divi 4 course rating template.
	 *
	 * @return string
	 */
	public static function get_content() {
		if ( ! function_exists( 'get_tutor_option' ) || ! function_exists( 'dtlms_get_template' ) || ! function_exists( 'tutor_utils' ) ) {
			return '';
		}

		$course = Helper::get_course();

		if ( ! $course || ! get_tutor_option( 'enable_course_review' ) ) {
			wp_reset_postdata();
			return '';
		}

		ob_start();
		include dtlms_get_template( 'course/rating' );
		$html = ob_get_clean();

		wp_reset_postdata();

		return $html;
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
	 * Read a desktop attribute value.
	 *
	 * @param array  $attr    Attribute array.
	 * @param string $default Fallback value.
	 * @return string
	 */
	private static function desktop_value( $attr, $default ) {
		$value = $attr['desktop']['value'] ?? $default;

		if ( is_int( $value ) || is_float( $value ) ) {
			return (string) $value;
		}

		return is_string( $value ) && '' !== $value ? $value : $default;
	}

	/**
	 * Map left/center/right onto a flex alignment value.
	 *
	 * @param string $alignment Alignment value.
	 * @return string
	 */
	private static function flex_alignment( $alignment ) {
		if ( 'center' === $alignment ) {
			return 'center';
		}

		if ( 'right' === $alignment ) {
			return 'flex-end';
		}

		return 'flex-start';
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
		$advanced    = $attrs['content']['advanced'] ?? array();
		$stars       = $attrs['stars']['advanced'] ?? array();
		$layout      = 'column' === self::desktop_value( $advanced['layout'] ?? array(), 'row' ) ? 'column' : 'row';
		$ratings     = "{$order_class} .tutor-ratings";
		$star_group  = "{$order_class} .dtlms-rating-wrapper .tutor-ratings-stars";
		$star_icon   = "{$star_group} span";

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
					$elements->style( array( 'attrName' => 'countText' ) ),
					$elements->style( array( 'attrName' => 'avgText' ) ),
					CommonStyle::style(
						array(
							'selector'            => $ratings,
							'attr'                => $advanced['alignment'] ?? array(
								'desktop' => array(
									'value' => 'left',
								),
							),
							'declarationFunction' => function ( $params ) use ( $layout ) {
								$alignment = self::flex_alignment( $params['attrValue'] ?? 'left' );
								$property  = 'column' === $layout ? 'align-items' : 'justify-content';

								return sprintf(
									'display: flex; flex-direction: %1$s; column-gap: 3px; %2$s: %3$s;',
									esc_html( $layout ),
									$property,
									esc_html( $alignment )
								);
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => $ratings,
							'attr'                => $advanced['gap'] ?? array(),
							'declarationFunction' => function ( $params ) use ( $layout ) {
								$gap = self::css_length( $params['attrValue'] ?? '' );

								if ( '' === $gap ) {
									return '';
								}

								$property = 'column' === $layout ? 'row-gap' : 'column-gap';

								return sprintf( '%1$s: %2$s;', $property, esc_html( $gap ) );
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => $star_group,
							'attr'                => array(
								'desktop' => array(
									'value' => 'row',
								),
							),
							'declarationFunction' => function () {
								return 'display: flex; flex-direction: row;';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => $star_icon,
							'attr'                => $stars['color'] ?? array(
								'desktop' => array(
									'value' => '#ed9700',
								),
							),
							'declarationFunction' => function ( $params ) {
								$color = $params['attrValue'] ?? '#ed9700';

								return '' !== $color ? sprintf( 'color: %1$s;', esc_html( $color ) ) : '';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => $star_icon,
							'attr'                => $stars['size'] ?? array(),
							'declarationFunction' => function ( $params ) {
								$size = self::css_length( $params['attrValue'] ?? '' );

								return '' !== $size ? sprintf( 'font-size: %1$s;', esc_html( $size ) ) : '';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => $star_group,
							'attr'                => $stars['gap'] ?? array(),
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
		$output = self::get_content();

		if ( '' === trim( $output ) ) {
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
