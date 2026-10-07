<?php
/**
 * Divi 5 Course Categories module.
 *
 * @package TutorLMS\Divi
 */

namespace TutorLMS\Divi\D5\CourseCategories;

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
 * Frontend renderer and REST endpoints for the Divi 5 Course Categories module.
 */
class CourseCategories implements DependencyInterface {

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

		add_filter( 'block_type_metadata', array( self::class, 'filter_block_metadata' ) );
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
	 * Fill the course select on the registered block metadata.
	 *
	 * @param array $metadata Block metadata.
	 * @return array
	 */
	public static function filter_block_metadata( $metadata ) {
		if ( 'tutor-lms/course-categories' !== ( $metadata['name'] ?? '' ) ) {
			return $metadata;
		}

		$options = array();

		foreach ( self::course_choices() as $course ) {
			$options[ $course['value'] ] = array(
				'label' => $course['label'],
			);
		}

		$metadata['attributes']['content']['settings']['advanced']['course']['item']['component']['props']['options'] = $options;

		return $metadata;
	}

	/**
	 * Register REST routes used by the Visual Builder.
	 *
	 * @return void
	 */
	public static function register_rest_routes() {
		register_rest_route(
			'tutor-divi/v1',
			'/course-categories',
			array(
				'methods'             => 'GET',
				'callback'            => array( self::class, 'rest_index' ),
				'permission_callback' => array( self::class, 'rest_permission' ),
				'args'                => array(
					'course' => array(
						'type'              => 'string',
						'required'          => false,
						'sanitize_callback' => 'sanitize_text_field',
					),
					'label'  => array(
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
	 * Return the course categories HTML for Visual Builder.
	 *
	 * @param WP_REST_Request $request REST request.
	 * @return \WP_REST_Response
	 */
	public static function rest_index( WP_REST_Request $request ) {
		$html = self::get_content(
			array(
				'course' => $request->get_param( 'course' ),
				'label'  => $request->get_param( 'label' ),
			)
		);

		return rest_ensure_response(
			array(
				'html' => $html,
			)
		);
	}

	/**
	 * Get the course categories markup.
	 *
	 * @param array $args Module arguments.
	 * @return string
	 */
	public static function get_content( $args = array() ) {
		$args = wp_parse_args(
			$args,
			array(
				'course' => '',
				'label'  => __( 'Categories:', 'tutor-lms-divi-modules' ),
			)
		);

		$label  = sanitize_text_field( (string) $args['label'] );
		$course = Helper::get_course( $args );
		$links  = '';

		if ( '' === $label ) {
			$label = __( 'Categories:', 'tutor-lms-divi-modules' );
		}

		if ( $course && function_exists( 'get_tutor_course_categories' ) ) {
			$categories = get_tutor_course_categories( $course );

			if ( is_array( $categories ) && count( $categories ) ) {
				$items = array();

				foreach ( $categories as $category ) {
					$term_link = get_term_link( $category );

					if ( is_wp_error( $term_link ) ) {
						continue;
					}

					$items[] = '<a href="' . esc_url( $term_link ) . '">' . esc_html( $category->name ) . '</a>';
				}

				$links = implode( ', ', $items );
			} else {
				$label = __( 'Uncategorized', 'tutor-lms-divi-modules' );
			}
		}

		return '<div class="tutor-single-course-meta-categories tutor-course-details-category tutor-meta tutor-course-details-info">' . esc_html( $label ) . '<div>' . $links . '</div></div>';
	}

	/**
	 * Course select choices.
	 *
	 * @return array<int, array{value: string, label: string}>
	 */
	private static function course_choices() {
		if ( ! class_exists( Helper::class ) || ! function_exists( 'tutor' ) ) {
			return array();
		}

		$choices = array();

		foreach ( Helper::get_courses() as $id => $label ) {
			$choices[] = array(
				'value' => (string) $id,
				'label' => wp_strip_all_tags( (string) $label ),
			);
		}

		return $choices;
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
	 * Divi emits a style rule for each breakpoint on this attribute, so tablet
	 * and phone stay in sync when only one of the three settings is customized.
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
						self::css_length( self::breakpoint_value( $gap_attr, $device, '5px' ) ),
					)
				),
			);
		}

		return $driver;
	}

	/**
	 * Flex layout declaration for one breakpoint.
	 *
	 * @param array $params Style callback params.
	 * @param array $attrs  Module attributes.
	 * @return string
	 */
	private static function layout_declaration( $params, $attrs ) {
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
	}

	/**
	 * Gap declaration for one breakpoint.
	 *
	 * Row layout uses column-gap. Column layout uses row-gap.
	 *
	 * @param array $params Style callback params.
	 * @param array $attrs  Module attributes.
	 * @return string
	 */
	private static function gap_declaration( $params, $attrs ) {
		$breakpoint = $params['breakpoint'] ?? 'desktop';
		$advanced   = $attrs['content']['advanced'] ?? array();
		$layout     = self::layout_value( self::breakpoint_value( $advanced['layout'] ?? array(), $breakpoint, 'row' ) );
		$gap        = self::css_length( self::breakpoint_value( $advanced['gap'] ?? array(), $breakpoint, '5px' ) );

		if ( '' === $gap ) {
			return '';
		}

		$property = 'column' === $layout ? 'row-gap' : 'column-gap';

		return sprintf( '%1$s: %2$s;', $property, esc_html( $gap ) );
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
		$wrapper     = "{$order_class} .tutor-single-course-meta-categories";
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
					$elements->style(
						array(
							'attrName' => 'categoryLink',
						)
					),
					$elements->style(
						array(
							'attrName' => 'categoryLinkHover',
						)
					),
					CommonStyle::style(
						array(
							'selector'            => $wrapper,
							'attr'                => $driver,
							'declarationFunction' => function ( $params ) use ( $attrs ) {
								return self::layout_declaration( $params, $attrs );
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => $wrapper,
							'attr'                => $driver,
							'declarationFunction' => function ( $params ) use ( $attrs ) {
								return self::gap_declaration( $params, $attrs );
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
				'course' => $content_attrs['course']['desktop']['value'] ?? '',
				'label'  => $content_attrs['label']['desktop']['value'] ?? '',
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
