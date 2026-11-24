<?php
/**
 * Divi 5 Course Duration module.
 *
 * @package TutorLMS\Divi
 */

namespace TutorLMS\Divi\D5\CourseDuration;

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
 * Frontend renderer and REST endpoints for the Divi 5 Course Duration module.
 */
class CourseDuration implements DependencyInterface {

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
			'/course-duration',
			array(
				'methods'             => 'GET',
				'callback'            => array( self::class, 'rest_index' ),
				'permission_callback' => array( self::class, 'rest_permission' ),
				'args'                => array(
					'label' => array(
						'type'              => 'string',
						'required'          => false,
						'sanitize_callback' => 'sanitize_text_field',
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
	 * Return the course duration HTML for Visual Builder.
	 *
	 * @param WP_REST_Request $request REST request.
	 * @return \WP_REST_Response
	 */
	public static function rest_index( WP_REST_Request $request ) {
		return rest_ensure_response(
			array(
				'html' => self::get_content(
					array(
						'label' => $request->get_param( 'label' ),
					)
				),
			)
		);
	}

	/**
	 * Get the course duration markup.
	 *
	 * @param array $args Module arguments.
	 * @return string
	 */
	public static function get_content( $args = array() ) {
		if ( ! function_exists( 'get_tutor_option' ) || ! function_exists( 'get_tutor_course_duration_context' ) ) {
			return '';
		}

		$args = wp_parse_args(
			$args,
			array(
				'label' => '',
			)
		);

		$course = Helper::get_course();

		if ( ! $course || ! get_tutor_option( 'enable_course_duration' ) ) {
			wp_reset_postdata();
			return '';
		}

		$duration = get_tutor_course_duration_context( $course );
		$disabled = get_tutor_option( 'disable_course_duration' );

		wp_reset_postdata();

		if ( empty( $duration ) || $disabled ) {
			return '';
		}

		$label = sanitize_text_field( (string) $args['label'] );

		return sprintf(
			'<div class="tutor-single-course-meta-duration tutor-divi-course-duration"><label class="text-regular-caption tutor-color-text-hints">%1$s</label><span class="text-medium-caption tutor-color-text-primary">%2$s</span></div>',
			esc_html( $label ),
			wp_kses_post( $duration )
		);
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
	 * Read an attribute value at a breakpoint, then desktop.
	 *
	 * @param array  $attr       Attribute array.
	 * @param string $breakpoint Breakpoint name.
	 * @param string $default    Fallback value.
	 * @return string
	 */
	private static function breakpoint_value( $attr, $breakpoint, $default ) {
		foreach ( array( $breakpoint, 'desktop' ) as $device ) {
			if ( ! isset( $attr[ $device ]['value'] ) || '' === $attr[ $device ]['value'] ) {
				continue;
			}

			$value = $attr[ $device ]['value'];

			if ( is_int( $value ) || is_float( $value ) ) {
				return (string) $value;
			}

			if ( is_string( $value ) ) {
				return $value;
			}
		}

		return $default;
	}

	/**
	 * Keep layout values to the two supported directions.
	 *
	 * @param string $layout Layout value.
	 * @return string
	 */
	private static function layout_value( $layout ) {
		return 'column' === $layout ? 'column' : 'row';
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
	 * Attribute that changes whenever layout, alignment, or gap changes.
	 *
	 * @param array $layout_attr    Layout attribute.
	 * @param array $alignment_attr Alignment attribute.
	 * @param array $gap_attr       Gap attribute.
	 * @return array
	 */
	private static function style_driver( $layout_attr, $alignment_attr, $gap_attr ) {
		$driver = array();

		foreach ( array( 'desktop', 'tablet', 'phone' ) as $device ) {
			$driver[ $device ] = array(
				'value' => implode(
					'|',
					array(
						self::layout_value( self::breakpoint_value( $layout_attr, $device, 'row' ) ),
						self::breakpoint_value( $alignment_attr, $device, 'left' ),
						self::css_length( self::breakpoint_value( $gap_attr, $device, '10px' ) ),
					)
				),
			);
		}

		return $driver;
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
		$driver      = self::style_driver(
			$advanced['layout'] ?? array(),
			$advanced['alignment'] ?? array(),
			$advanced['gap'] ?? array()
		);

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
					$elements->style( array( 'attrName' => 'valueText' ) ),
					CommonStyle::style(
						array(
							'selector'            => "{$order_class} .tutor-divi-course-duration",
							'attr'                => $driver,
							'declarationFunction' => function ( $params ) use ( $attrs ) {
								$breakpoint = $params['breakpoint'] ?? 'desktop';
								$advanced   = $attrs['content']['advanced'] ?? array();
								$layout     = self::layout_value( self::breakpoint_value( $advanced['layout'] ?? array(), $breakpoint, 'row' ) );
								$alignment  = self::flex_alignment( self::breakpoint_value( $advanced['alignment'] ?? array(), $breakpoint, 'left' ) );
								$property   = 'column' === $layout ? 'align-items' : 'justify-content';

								return sprintf(
									'display: flex; flex-direction: %1$s; %2$s: %3$s;',
									esc_html( $layout ),
									$property,
									esc_html( $alignment )
								);
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => "{$order_class} .tutor-divi-course-duration",
							'attr'                => $driver,
							'declarationFunction' => function ( $params ) use ( $attrs ) {
								$breakpoint = $params['breakpoint'] ?? 'desktop';
								$advanced   = $attrs['content']['advanced'] ?? array();
								$layout     = self::layout_value( self::breakpoint_value( $advanced['layout'] ?? array(), $breakpoint, 'row' ) );
								$gap        = self::css_length( self::breakpoint_value( $advanced['gap'] ?? array(), $breakpoint, '10px' ) );

								if ( '' === $gap ) {
									return '';
								}

								$property = 'column' === $layout ? 'row-gap' : 'column-gap';

								return sprintf( '%1$s: %2$s;', $property, esc_html( $gap ) );
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
		$content_attrs = $attrs['content']['advanced'] ?? array();
		$output        = self::get_content(
			array(
				'label' => $content_attrs['label']['desktop']['value'] ?? 'Course Duration',
			)
		);

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
