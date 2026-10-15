<?php
/**
 * Divi 5 Course Instructor module.
 *
 * @package TutorLMS\Divi
 */

namespace TutorLMS\Divi\D5\CourseInstructor;

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
 * Frontend renderer and REST endpoint for the Divi 5 Course Instructor module.
 */
class CourseInstructor implements DependencyInterface {

	/**
	 * Register the module and REST route.
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
			'/course-instructor',
			array(
				'methods'             => 'GET',
				'callback'            => array( self::class, 'rest_index' ),
				'permission_callback' => array( self::class, 'rest_permission' ),
				'args'                => array(
					'label'           => array(
						'type'              => 'string',
						'required'          => false,
						'sanitize_callback' => 'sanitize_text_field',
					),
					'profile_picture' => array(
						'type'              => 'string',
						'required'          => false,
						'sanitize_callback' => 'sanitize_text_field',
					),
					'display_name'    => array(
						'type'              => 'string',
						'required'          => false,
						'sanitize_callback' => 'sanitize_text_field',
					),
					'designation'     => array(
						'type'              => 'string',
						'required'          => false,
						'sanitize_callback' => 'sanitize_text_field',
					),
					'link'            => array(
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
	 * Return the instructor HTML for Visual Builder.
	 *
	 * @param WP_REST_Request $request REST request.
	 * @return \WP_REST_Response
	 */
	public static function rest_index( WP_REST_Request $request ) {
		return rest_ensure_response(
			array(
				'html' => self::get_content(
					array(
						'course_instructor_label' => $request->get_param( 'label' ),
						'profile_picture'         => $request->get_param( 'profile_picture' ),
						'display_name'            => $request->get_param( 'display_name' ),
						'designation'             => $request->get_param( 'designation' ),
						'course_instructor_link'  => $request->get_param( 'link' ),
					)
				),
			)
		);
	}

	/**
	 * Get the course instructor markup.
	 *
	 * Reuses the Divi 4 instructor template.
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
				'course_instructor_label' => __( 'A Course by', 'tutor-lms-divi-modules' ),
				'profile_picture'         => 'on',
				'display_name'            => 'on',
				'designation'             => 'on',
				'course_instructor_link'  => '_blank',
			)
		);

		$course = Helper::get_course();

		if ( ! $course ) {
			wp_reset_postdata();
			return '';
		}

		$args['course']                   = $course;
		$args['course_instructor_label']  = sanitize_text_field( (string) $args['course_instructor_label'] );
		$args['profile_picture']          = 'off' === $args['profile_picture'] ? 'off' : 'on';
		$args['display_name']             = 'off' === $args['display_name'] ? 'off' : 'on';
		$args['designation']              = 'off' === $args['designation'] ? 'off' : 'on';
		$args['course_instructor_link']   = '_blank' === $args['course_instructor_link'] ? '_blank' : 'same';

		ob_start();
		include dtlms_get_template( 'course/instructor' );
		$html = ob_get_clean();

		wp_reset_postdata();

		return $html;
	}

	/**
	 * Color style from an attribute.
	 *
	 * @param string $selector CSS selector.
	 * @param array  $attr     Attribute value.
	 * @param string $property CSS property.
	 * @return array
	 */
	private static function color_style( $selector, $attr, $property ) {
		return CommonStyle::style(
			array(
				'selector'            => $selector,
				'attr'                => $attr,
				'declarationFunction' => function ( $params ) use ( $property ) {
					$color = trim( (string) ( $params['attrValue'] ?? '' ) );

					return '' !== $color ? sprintf( '%1$s: %2$s !important;', $property, esc_html( $color ) ) : '';
				},
			)
		);
	}

	/**
	 * Read a desktop content value.
	 *
	 * @param array  $attrs   Module attributes.
	 * @param string $key     Advanced content key.
	 * @param string $default Fallback value.
	 * @return string
	 */
	private static function content_value( $attrs, $key, $default ) {
		$value = $attrs['content']['advanced'][ $key ]['desktop']['value'] ?? $default;

		return is_scalar( $value ) ? (string) $value : $default;
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
		$elements    = $args['elements'];
		$settings    = $args['settings'] ?? array();
		$attrs       = $args['attrs'] ?? array();
		$order_class = $args['orderClass'] ?? '';
		$avatar_text = "{$order_class} .tutor-avatar-text";
		$styles      = array();

		foreach ( array( 'module', 'title', 'name', 'jobTitle', 'avatar', 'section' ) as $name ) {
			$style_args = array(
				'attrName' => $name,
			);

			if ( 'module' === $name ) {
				$style_args['styleProps'] = array(
					'disabledOn' => array(
						'disabledModuleVisibility' => $settings['disabledModuleVisibility'] ?? null,
					),
				);
			}

			$styles[] = $elements->style( $style_args );
		}

		$styles[] = self::color_style( $avatar_text, $attrs['avatar']['advanced']['backgroundColor'] ?? array(), 'background-color' );
		$styles[] = self::color_style( $avatar_text, $attrs['avatar']['advanced']['textColor'] ?? array(), 'color' );

		Style::add(
			array(
				'id'            => $args['id'],
				'name'          => $args['name'],
				'orderIndex'    => $args['orderIndex'],
				'storeInstance' => $args['storeInstance'],
				'styles'        => $styles,
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
				'course_instructor_label' => self::content_value( $attrs, 'label', 'A Course by' ),
				'profile_picture'         => self::content_value( $attrs, 'profilePicture', 'on' ),
				'display_name'            => self::content_value( $attrs, 'displayName', 'on' ),
				'designation'             => self::content_value( $attrs, 'designation', 'on' ),
				'course_instructor_link'  => self::content_value( $attrs, 'link', '_blank' ),
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
