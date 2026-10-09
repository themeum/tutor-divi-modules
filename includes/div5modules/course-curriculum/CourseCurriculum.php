<?php
/**
 * Divi 5 Course Curriculum module.
 *
 * @package TutorLMS\Divi
 */

namespace TutorLMS\Divi\D5\CourseCurriculum;

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
 * Frontend renderer and REST endpoints for the Divi 5 Course Curriculum module.
 */
class CourseCurriculum implements DependencyInterface {

	/**
	 * Custom curriculum title for the current render.
	 *
	 * @var string
	 */
	private static $label = '';

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
			'/course-curriculum',
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
	 * Return the curriculum HTML for Visual Builder.
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
	 * Get the course curriculum markup.
	 *
	 * Reuses the Divi 4 curriculum template.
	 *
	 * @param array $args Module arguments.
	 * @return string
	 */
	public static function get_content( $args = array() ) {
		if ( ! function_exists( 'dtlms_get_template' ) || ! function_exists( 'tutor_utils' ) ) {
			return '';
		}

		$args = wp_parse_args(
			$args,
			array(
				'label' => '',
			)
		);

		$course = Helper::get_course();

		if ( ! $course ) {
			return '';
		}

		$args['course'] = $course;
		$args['label']  = sanitize_text_field( (string) $args['label'] );

		self::$label = $args['label'];
		remove_filter( 'tutor_course_topics_title', array( self::class, 'filter_title' ) );

		if ( '' !== self::$label ) {
			add_filter( 'tutor_course_topics_title', array( self::class, 'filter_title' ) );
		}

		ob_start();
		include dtlms_get_template( 'course/curriculum' );
		$html = ob_get_clean();

		wp_reset_postdata();

		return $html;
	}

	/**
	 * Curriculum title filter.
	 *
	 * @return string
	 */
	public static function filter_title() {
		return self::$label;
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
	 * A style declaration that does not depend on a setting.
	 *
	 * @param string $selector    CSS selector.
	 * @param string $declaration CSS declaration.
	 * @return array
	 */
	private static function fixed_style( $selector, $declaration ) {
		return CommonStyle::style(
			array(
				'selector'            => $selector,
				'attr'                => array(
					'desktop' => array(
						'value' => '1',
					),
				),
				'declarationFunction' => function () use ( $declaration ) {
					return $declaration;
				},
			)
		);
	}

	/**
	 * Length style from a responsive attribute.
	 *
	 * @param string $selector  CSS selector.
	 * @param array  $attr      Attribute value.
	 * @param string $property  CSS property.
	 * @param bool   $important Whether to mark the declaration important.
	 * @return array
	 */
	private static function length_style( $selector, $attr, $property, $important = false ) {
		return CommonStyle::style(
			array(
				'selector'            => $selector,
				'attr'                => $attr,
				'declarationFunction' => function ( $params ) use ( $property, $important ) {
					$length = self::css_length( $params['attrValue'] ?? '' );

					if ( '' === $length ) {
						return '';
					}

					return sprintf(
						'%1$s: %2$s%3$s;',
						$property,
						esc_html( $length ),
						$important ? ' !important' : ''
					);
				},
			)
		);
	}

	/**
	 * Color style from an attribute.
	 *
	 * @param string $selector  CSS selector.
	 * @param array  $attr      Attribute value.
	 * @param string $property  CSS property.
	 * @return array
	 */
	private static function color_style( $selector, $attr, $property = 'color' ) {
		return CommonStyle::style(
			array(
				'selector'            => $selector,
				'attr'                => $attr,
				'declarationFunction' => function ( $params ) use ( $property ) {
					$color = $params['attrValue'] ?? '';

					if ( ! is_string( $color ) || '' === $color ) {
						return '';
					}

					return sprintf( '%1$s: %2$s;', $property, esc_html( $color ) );
				},
			)
		);
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
		$wrapper     = "{$order_class} .dtlms-course-curriculum";
		$header      = "{$wrapper} .tutor-accordion-item-header";
		$icon        = "{$header}::after";
		$topic       = "{$wrapper} .tutor-accordion-item";
		$lesson_icon = "{$order_class} .tutor-accordion-item .tutor-course-content-list-item-icon, {$order_class} .tutor-accordion-item .tutor-course-content-list-item-status";
		$lesson_icon_hover = "{$order_class} .tutor-accordion-item .tutor-course-content-list-item-icon:hover, {$order_class} .tutor-accordion-item .tutor-course-content-list-item-status:hover";
		$lesson      = "{$order_class} .tutor-accordion-item .tutor-course-content-list-item";
		$lesson_info = "{$order_class} .tutor-accordion-item .tutor-course-content-list-item-duration";
		$content     = $attrs['content']['advanced'] ?? array();
		$topics      = $attrs['topics']['advanced'] ?? array();
		$lesson_attr = $attrs['lesson']['advanced'] ?? array();

		Style::add(
			array(
				'id'            => $args['id'],
				'name'          => $args['name'],
				'orderIndex'    => $args['orderIndex'],
				'storeInstance' => $args['storeInstance'],
				'styles'        => array(
					self::fixed_style( $header, 'display: flex; align-items: center; column-gap: 10px;' ),
					self::fixed_style( $topic, 'border: 1px solid #DCE4E6;' ),
					self::fixed_style( "{$order_class} ul.tutor-courses-lession-list", 'padding: 0 !important;' ),
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
					$elements->style( array( 'attrName' => 'header' ) ),
					$elements->style( array( 'attrName' => 'topics' ) ),
					$elements->style( array( 'attrName' => 'lesson' ) ),
					self::length_style(
						"{$wrapper} .tutor-course-content-title",
						$attrs['header']['advanced']['gap'] ?? array(
							'desktop' => array(
								'value' => '5px',
							),
						),
						'margin-top',
						true
					),
					CommonStyle::style(
						array(
							'selector'            => $icon,
							'attr'                => $content['iconPosition'] ?? array(
								'desktop' => array(
									'value' => 'right',
								),
							),
							'declarationFunction' => function ( $params ) {
								return 'left' === ( $params['attrValue'] ?? '' ) ? 'position: inherit !important; padding-left: 20px;' : '';
							},
						)
					),
					self::length_style(
						$icon,
						$topics['iconSize'] ?? array(
							'desktop' => array(
								'value' => '32px',
							),
						),
						'font-size'
					),
					self::color_style( $icon, $topics['iconColor'] ?? array() ),
					self::color_style( "{$header}.is-active::after", $topics['iconActiveColor'] ?? array() ),
					self::color_style( "{$header}:hover::after", $topics['iconHoverColor'] ?? array() ),
					self::color_style( $header, $topics['textColor'] ?? array() ),
					self::color_style( "{$header}.is-active", $topics['textActiveColor'] ?? array() ),
					self::color_style( "{$header}.is-active:hover", $topics['textHoverColor'] ?? array() ),
					self::color_style( $header, $topics['backgroundColor'] ?? array(), 'background-color' ),
					self::color_style( "{$header}.is-active", $topics['backgroundActiveColor'] ?? array(), 'background-color' ),
					self::color_style( "{$header}:hover", $topics['backgroundHoverColor'] ?? array(), 'background-color' ),
					self::length_style(
						$topic,
						$topics['spaceBetween'] ?? array(
							'desktop' => array(
								'value' => '10px',
							),
						),
						'margin-bottom'
					),
					self::length_style(
						$lesson_icon,
						$lesson_attr['iconSize'] ?? array(
							'desktop' => array(
								'value' => '18px',
							),
						),
						'font-size'
					),
					self::color_style( $lesson_icon, $lesson_attr['iconColor'] ?? array() ),
					self::color_style( $lesson_icon_hover, $lesson_attr['iconColorHover'] ?? array() ),
					self::color_style( $lesson_info, $lesson_attr['infoColor'] ?? array() ),
					self::color_style( "{$lesson_info}:hover", $lesson_attr['infoColorHover'] ?? array() ),
					self::color_style( $lesson, $lesson_attr['backgroundColor'] ?? array(), 'background-color' ),
					self::color_style( "{$lesson}:hover", $lesson_attr['backgroundColorHover'] ?? array(), 'background-color' ),
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
				'label' => $content_attrs['label']['desktop']['value'] ?? 'Course Content',
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
