<?php
/**
 * Divi 5 Course Author module.
 *
 * @package TutorLMS\Divi
 */

namespace TutorLMS\Divi\D5\CourseAuthor;

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
 * Frontend renderer and REST endpoints for the Divi 5 Course Author module.
 */
class CourseAuthor implements DependencyInterface {

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
			'/course-author',
			array(
				'methods'             => 'GET',
				'callback'            => array( self::class, 'rest_index' ),
				'permission_callback' => array( self::class, 'rest_permission' ),
				'args'                => array(
					'course'          => array(
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
	 * Return the course author HTML for Visual Builder.
	 *
	 * @param WP_REST_Request $request REST request.
	 * @return \WP_REST_Response
	 */
	public static function rest_index( WP_REST_Request $request ) {
		$html = self::get_content(
			array(
				'course'          => $request->get_param( 'course' ),
				'profile_picture' => $request->get_param( 'profile_picture' ),
				'display_name'    => $request->get_param( 'display_name' ),
				'link'            => $request->get_param( 'link' ),
			)
		);

		return rest_ensure_response(
			array(
				'html' => $html,
			)
		);
	}

	/**
	 * Get the course author markup.
	 *
	 * Mirrors the Divi 4 TutorCourseAuthor::get_content() behavior.
	 *
	 * @param array $args Module arguments.
	 * @return string
	 */
	public static function get_content( $args = array() ) {
		$is_enabled = function_exists( 'tutor_utils' ) ? tutor_utils()->get_option( 'enable_course_author', false ) : false;

		if ( ! $is_enabled ) {
			return '';
		}

		$args = wp_parse_args(
			$args,
			array(
				'course'          => '',
				'profile_picture' => 'on',
				'display_name'    => 'on',
				'link'            => 'new',
			)
		);

		$course = Helper::get_course( $args );
		ob_start();

		if ( $course ) {
			$args['course'] = $course;
			include dtlms_get_template( 'course/author' );
		}

		return ob_get_clean();
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
			$value = (string) $value;
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
		$wrapper     = "{$order_class} .tutor-single-course-author-meta";
		$avatar      = "{$order_class} .tutor-avatar, {$order_class} .tutor-avatar img";
		$layout      = self::desktop_value( $attrs['content']['advanced']['layout'] ?? array(), 'row' );
		$alignment   = self::flex_alignment( self::desktop_value( $attrs['content']['advanced']['alignment'] ?? array(), 'left' ) );

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
							'attrName' => 'authorLabel',
						)
					),
					$elements->style(
						array(
							'attrName' => 'authorName',
						)
					),
					$elements->style(
						array(
							'attrName' => 'avatar',
						)
					),
					CommonStyle::style(
						array(
							'selector'            => "{$order_class} .tutor-single-course-meta li.tutor-single-course-author-meta",
							'attr'                => array(
								'desktop' => array(
									'value' => 'none',
								),
							),
							'declarationFunction' => function () {
								return 'list-style: none;';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => "{$order_class} ul",
							'attr'                => array(
								'desktop' => array(
									'value' => '0',
								),
							),
							'declarationFunction' => function () {
								return 'padding: 0 !important;';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => "{$wrapper} a",
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
							'selector'            => $wrapper,
							'attr'                => $attrs['content']['advanced']['layout'] ?? array(
								'desktop' => array(
									'value' => 'row',
								),
							),
							'declarationFunction' => function ( $params ) use ( $alignment ) {
								$direction = ( $params['attrValue'] ?? 'row' ) === 'column' ? 'column' : 'row';
								$property  = 'column' === $direction ? 'align-items' : 'justify-content';

								return sprintf(
									'display: flex !important; flex-direction: %1$s !important; %2$s: %3$s !important;',
									$direction,
									$property,
									$alignment
								);
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => $avatar,
							'attr'                => $attrs['avatar']['advanced']['size'] ?? array(
								'desktop' => array(
									'value' => '25px',
								),
							),
							'declarationFunction' => function ( $params ) {
								$size = $params['attrValue'] ?? '';

								if ( '' === $size ) {
									return '';
								}

								return sprintf( 'width: %1$s !important; height: %1$s !important;', esc_html( $size ) );
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => "{$order_class} .tutor-single-course-avatar .tutor-text-avatar",
							'attr'                => $attrs['avatar']['advanced']['size'] ?? array(
								'desktop' => array(
									'value' => '25px',
								),
							),
							'declarationFunction' => function ( $params ) {
								$size = $params['attrValue'] ?? '';

								if ( '' === $size ) {
									return '';
								}

								return sprintf( 'line-height: %1$s; text-align: center;', esc_html( $size ) );
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => $wrapper,
							'attr'                => $attrs['avatar']['advanced']['gap'] ?? array(
								'desktop' => array(
									'value' => '5px',
								),
							),
							'declarationFunction' => function ( $params ) use ( $layout ) {
								$gap = $params['attrValue'] ?? '';

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
							'selector'            => $avatar,
							'attr'                => $attrs['avatar']['advanced']['borderRadius'] ?? array(
								'desktop' => array(
									'value' => '100px',
								),
							),
							'declarationFunction' => function ( $params ) {
								$radius = $params['attrValue'] ?? '';

								if ( '' === $radius ) {
									return '';
								}

								return sprintf( 'border-radius: %1$s;', esc_html( $radius ) );
							},
						)
					),
				),
			)
		);
	}

	/**
	 * Content arguments used by the author template.
	 *
	 * @param array $attrs Module attributes.
	 * @return array
	 */
	private static function content_args( $attrs ) {
		$content = $attrs['content']['advanced'] ?? array();

		return array(
			'course'          => self::desktop_value( $content['course'] ?? array(), '' ),
			'profile_picture' => self::desktop_value( $content['profilePicture'] ?? array(), 'on' ),
			'display_name'    => self::desktop_value( $content['displayName'] ?? array(), 'on' ),
			'link'            => self::desktop_value( $content['link'] ?? array(), 'new' ),
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
