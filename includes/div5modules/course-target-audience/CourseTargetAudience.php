<?php
/**
 * Divi 5 Course Target Audience module.
 *
 * @package TutorLMS\Divi
 */

namespace TutorLMS\Divi\D5\CourseTargetAudience;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Direct access forbidden.' );
}

use ET\Builder\Framework\DependencyManagement\Interfaces\DependencyInterface;
use ET\Builder\Framework\UserRole\UserRole;
use ET\Builder\Framework\Utility\HTMLUtility;
use ET\Builder\FrontEnd\BlockParser\BlockParserStore;
use ET\Builder\FrontEnd\Module\Style;
use ET\Builder\Packages\IconLibrary\IconFont\Utils as IconUtils;
use ET\Builder\Packages\Module\Layout\Components\StyleCommon\CommonStyle;
use ET\Builder\Packages\Module\Module;
use ET\Builder\Packages\Module\Options\Element\ElementClassnames;
use ET\Builder\Packages\ModuleLibrary\ModuleRegistration;
use TutorLMS\Divi\Helper;
use WP_REST_Request;

/**
 * Frontend renderer and REST endpoints for the Divi 5 Course Target Audience module.
 */
class CourseTargetAudience implements DependencyInterface {

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
			'/course-target-audience',
			array(
				'methods'             => 'GET',
				'callback'            => array( self::class, 'rest_index' ),
				'permission_callback' => array( self::class, 'rest_permission' ),
				'args'                => array(
					'label'        => array(
						'type'              => 'string',
						'required'          => false,
						'sanitize_callback' => 'sanitize_text_field',
					),
					'icon_unicode' => array(
						'type'              => 'string',
						'required'          => false,
						'sanitize_callback' => 'sanitize_text_field',
					),
					'icon_type'    => array(
						'type'              => 'string',
						'required'          => false,
						'sanitize_callback' => 'sanitize_text_field',
					),
					'icon_weight'  => array(
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
	 * Return the course target audience HTML for Visual Builder.
	 *
	 * @param WP_REST_Request $request REST request.
	 * @return \WP_REST_Response
	 */
	public static function rest_index( WP_REST_Request $request ) {
		$icon = array(
			'unicode' => $request->get_param( 'icon_unicode' ),
			'type'    => $request->get_param( 'icon_type' ),
			'weight'  => $request->get_param( 'icon_weight' ),
		);

		$html = self::get_content(
			array(
				'label' => $request->get_param( 'label' ),
				'icon'  => $icon,
			)
		);

		return rest_ensure_response(
			array(
				'html' => $html,
			)
		);
	}

	/**
	 * Get the course target audience markup.
	 *
	 * Reuses the Divi 4 course target audience template.
	 *
	 * @param array $args Module arguments.
	 * @return string
	 */
	public static function get_content( $args = array() ) {
		if ( ! function_exists( 'tutor_course_target_audience' ) || ! function_exists( 'dtlms_get_template' ) ) {
			return '';
		}

		$args = wp_parse_args(
			$args,
			array(
				'label' => '',
				'icon'  => 'N',
			)
		);

		$course = Helper::get_course();

		if ( ! $course ) {
			wp_reset_postdata();
			return '';
		}

		$icon = $args['icon'];

		if ( is_array( $icon ) && empty( $icon['unicode'] ) ) {
			$icon = 'N';
		}

		if ( '' === $icon || null === $icon ) {
			$icon = 'N';
		}

		$args['course'] = $course;
		$args['label']  = sanitize_text_field( (string) $args['label'] );
		$args['icon']   = self::icon_character( $icon );

		ob_start();
		include dtlms_get_template( 'course/target_audience' );
		$output = ob_get_clean();

		wp_reset_postdata();

		return $output;
	}

	/**
	 * Turn a Divi 5 icon value, or a Divi 4 icon string, into a character.
	 *
	 * @param mixed $icon Icon attribute.
	 * @return string
	 */
	private static function icon_character( $icon ) {
		if ( is_string( $icon ) ) {
			return function_exists( 'et_pb_process_font_icon' ) ? (string) et_pb_process_font_icon( $icon ) : $icon;
		}

		if ( ! is_array( $icon ) || empty( $icon['unicode'] ) ) {
			return '';
		}

		if ( class_exists( IconUtils::class ) ) {
			try {
				$processed = IconUtils::process_font_icon( $icon );

				if ( is_string( $processed ) && '' !== $processed ) {
					return $processed;
				}
			} catch ( \Throwable $exception ) { // phpcs:ignore Generic.CodeAnalysis.EmptyStatement.DetectedCatch
				unset( $exception );
			}
		}

		return html_entity_decode( (string) $icon['unicode'], ENT_QUOTES, 'UTF-8' );
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
	 * @param array  $attr        Attribute array.
	 * @param string $breakpoint  Breakpoint name.
	 * @param string $default     Fallback value.
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
		$wrapper     = "{$order_class} .tutor-course-target-audience-wrap";
		$list        = "{$order_class} .tutor-course-target-audience-items";
		$item        = "{$list} li";
		$icon        = "{$item} .et-pb-icon";
		$layout_attr = $attrs['content']['advanced']['layout'] ?? array(
			'desktop' => array(
				'value' => 'list',
			),
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
					$elements->style(
						array(
							'attrName' => 'title',
						)
					),
					$elements->style(
						array(
							'attrName' => 'audienceText',
						)
					),
					$elements->style(
						array(
							'attrName' => 'list',
						)
					),
					CommonStyle::style(
						array(
							'selector'            => $wrapper,
							'attr'                => array(
								'desktop' => array(
									'value' => 'column',
								),
							),
							'declarationFunction' => function () {
								return 'display: flex; flex-direction: column;';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => $list,
							'attr'                => array(
								'desktop' => array(
									'value' => '0',
								),
							),
							'declarationFunction' => function () {
								return 'padding: 0;';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => $item,
							'attr'                => array(
								'desktop' => array(
									'value' => 'none',
								),
							),
							'declarationFunction' => function () {
								return 'padding: 0; list-style: none; border-style: solid;';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => $wrapper,
							'attr'                => $attrs['title']['advanced']['gap'] ?? array(
								'desktop' => array(
									'value' => '10px',
								),
							),
							'declarationFunction' => function ( $params ) {
								$gap = self::css_length( $params['attrValue'] ?? '' );

								return '' !== $gap ? sprintf( 'row-gap: %1$s;', esc_html( $gap ) ) : '';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => $item,
							'attr'                => $layout_attr,
							'declarationFunction' => function ( $params ) {
								$layout = $params['attrValue'] ?? 'list';

								return '' !== $layout ? sprintf( 'display: %1$s !important;', esc_html( $layout ) ) : '';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => "{$wrapper} .tutor-segment-title, {$wrapper} .tutor-course-target-audience-content",
							'attr'                => $attrs['content']['advanced']['alignment'] ?? array(
								'desktop' => array(
									'value' => 'left',
								),
							),
							'declarationFunction' => function ( $params ) {
								$alignment = $params['attrValue'] ?? '';

								return '' !== $alignment ? sprintf( 'text-align: %1$s !important;', esc_html( $alignment ) ) : '';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => "{$item}:not(:last-child)",
							'attr'                => $attrs['list']['advanced']['spaceBetween'] ?? array(
								'desktop' => array(
									'value' => '10px',
								),
							),
							'declarationFunction' => function ( $params ) use ( $layout_attr ) {
								$space  = self::css_length( $params['attrValue'] ?? '' );
								$layout = self::breakpoint_value( $layout_attr, $params['breakpoint'] ?? 'desktop', 'list' );

								if ( '' === $space ) {
									return '';
								}

								$property = 'list' === $layout ? 'margin-bottom' : 'margin-right';

								return sprintf( '%1$s: %2$s !important;', $property, esc_html( $space ) );
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => "{$item} .list-item",
							'attr'                => $attrs['audienceText']['advanced']['indent'] ?? array(
								'desktop' => array(
									'value' => '7px',
								),
							),
							'declarationFunction' => function ( $params ) {
								$indent = self::css_length( $params['attrValue'] ?? '' );

								return '' !== $indent ? sprintf( 'padding-left: %1$s !important;', esc_html( $indent ) ) : '';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => $icon,
							'attr'                => $attrs['icon']['advanced']['color'] ?? array(),
							'declarationFunction' => function ( $params ) {
								$color = $params['attrValue'] ?? '';

								return '' !== $color ? sprintf( 'color: %1$s !important;', esc_html( $color ) ) : '';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => $icon,
							'attr'                => $attrs['icon']['advanced']['size'] ?? array(
								'desktop' => array(
									'value' => '12px',
								),
							),
							'declarationFunction' => function ( $params ) {
								$size = self::css_length( $params['attrValue'] ?? '' );

								return '' !== $size ? sprintf( 'font-size: %1$s !important;', esc_html( $size ) ) : '';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => $icon,
							'attr'                => $attrs['content']['advanced']['icon'] ?? array(),
							'declarationFunction' => function ( $params ) {
								$icon = $params['attrValue'] ?? array();

								if ( ! is_array( $icon ) || empty( $icon['unicode'] ) ) {
									return '';
								}

								$family = ( isset( $icon['type'] ) && 'fa' === $icon['type'] ) ? 'FontAwesome' : 'ETmodules';
								$weight = isset( $icon['weight'] ) ? sprintf( ' font-weight: %1$s;', esc_html( $icon['weight'] ) ) : '';

								return sprintf( "font-family: '%1\$s' !important;%2\$s", $family, $weight );
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
				'label' => $content_attrs['label']['desktop']['value'] ?? 'Target Audience',
				'icon'  => $content_attrs['icon']['desktop']['value'] ?? '',
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
