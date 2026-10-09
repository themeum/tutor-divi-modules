<?php
/**
 * Divi 5 Course Tags module.
 *
 * @package TutorLMS\Divi
 */

namespace TutorLMS\Divi\D5\CourseTags;

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
 * Frontend renderer and REST endpoints for the Divi 5 Course Tags module.
 */
class CourseTags implements DependencyInterface {

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
			'/course-tags',
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
	 * Return the course tags HTML for Visual Builder.
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
	 * Get the course tags markup.
	 *
	 * Reuses the Divi 4 course tags template.
	 *
	 * @param array $args Module arguments.
	 * @return string
	 */
	public static function get_content( $args = array() ) {
		if ( ! function_exists( 'get_tutor_course_tags' ) || ! function_exists( 'dtlms_get_template' ) ) {
			return '';
		}

		$args = wp_parse_args(
			$args,
			array(
				'label' => 'Course Tags',
			)
		);

		$course = Helper::get_course();

		if ( ! $course ) {
			wp_reset_postdata();
			return '';
		}

		$args['course'] = $course;
		$args['label']  = sanitize_text_field( (string) $args['label'] );

		ob_start();
		include dtlms_get_template( 'course/tags' );
		$output = ob_get_clean();

		wp_reset_postdata();

		return $output;
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
	 * @param array  $attrs   Module attributes.
	 * @param string $group   Attribute group.
	 * @param string $key     Advanced key.
	 * @param string $default Fallback value.
	 * @return string
	 */
	private static function content_value( $attrs, $group, $key, $default ) {
		$value = $attrs[ $group ]['advanced'][ $key ]['desktop']['value'] ?? $default;

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
		$wrapper     = "{$order_class} .tutor-divi-course-tags-wrapper";
		$title       = "{$wrapper} .tutor-segment-title";
		$link        = "{$wrapper} .tutor-tag-list a";

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
					$elements->style( array( 'attrName' => 'title' ) ),
					$elements->style( array( 'attrName' => 'tags' ) ),
					$elements->style( array( 'attrName' => 'list' ) ),
					CommonStyle::style(
						array(
							'selector'            => $link,
							'attr'                => array(
								'desktop' => array(
									'value' => 'tag',
								),
							),
							'declarationFunction' => function () {
								return 'font-size: 16px; line-height: 26px; text-decoration: none; padding: 7px 23px; border: 1px solid #c0c3cb; color: #5b616f; border-radius: 6px; transition: 200ms;';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => $title,
							'attr'                => $attrs['title']['advanced']['gap'] ?? array(
								'desktop' => array(
									'value' => '10px',
								),
							),
							'declarationFunction' => function ( $params ) {
								$gap = self::css_length( $params['attrValue'] ?? '' );

								return '' !== $gap ? sprintf( 'margin-bottom: %1$s;', esc_html( $gap ) ) : '';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => $link,
							'attr'                => $attrs['tags']['advanced']['background'] ?? array(),
							'declarationFunction' => function ( $params ) {
								$color = $params['attrValue'] ?? '';

								return '' !== $color ? sprintf( 'background-color: %1$s;', esc_html( $color ) ) : '';
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
				'label' => self::content_value( $attrs, 'content', 'label', 'Course Tags' ),
			)
		);

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
