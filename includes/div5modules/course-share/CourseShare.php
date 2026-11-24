<?php
/**
 * Divi 5 Course Share module.
 *
 * @package TutorLMS\Divi
 */

namespace TutorLMS\Divi\D5\CourseShare;

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
 * Frontend renderer and REST endpoints for the Divi 5 Course Share module.
 */
class CourseShare implements DependencyInterface {

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
			'/course-share',
			array(
				'methods'             => 'GET',
				'callback'            => array( self::class, 'rest_index' ),
				'permission_callback' => array( self::class, 'rest_permission' ),
				'args'                => array(
					'show_label'          => array(
						'type'     => 'string',
						'required' => false,
					),
					'show_icon'           => array(
						'type'     => 'string',
						'required' => false,
					),
					'section_title'       => array(
						'type'              => 'string',
						'required'          => false,
						'sanitize_callback' => 'sanitize_text_field',
					),
					'share_title'         => array(
						'type'              => 'string',
						'required'          => false,
						'sanitize_callback' => 'sanitize_text_field',
					),
					'show_social_icon'    => array(
						'type'     => 'string',
						'required' => false,
					),
					'show_social_text'    => array(
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
	 * Return the course share HTML for Visual Builder.
	 *
	 * @param WP_REST_Request $request REST request.
	 * @return \WP_REST_Response
	 */
	public static function rest_index( WP_REST_Request $request ) {
		return rest_ensure_response(
			array(
				'html' => self::get_content(
					array(
						'course_share_text_show' => $request->get_param( 'show_label' ),
						'course_share_icon_show' => $request->get_param( 'show_icon' ),
						'popup_section_title'    => $request->get_param( 'section_title' ),
						'popup_share_title'      => $request->get_param( 'share_title' ),
						'show_social_icon'       => $request->get_param( 'show_social_icon' ),
						'show_social_text'       => $request->get_param( 'show_social_text' ),
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
	 * Get the course share markup.
	 *
	 * Reuses the Divi 4 course share template.
	 *
	 * @param array $args Module arguments.
	 * @return string
	 */
	public static function get_content( $args = array() ) {
		if ( ! function_exists( 'tutor_utils' ) || ! function_exists( 'dtlms_get_template' ) ) {
			return '';
		}

		$icons = tutor_utils()->tutor_social_share_icons();

		if ( ! tutor_utils()->get_option( 'enable_course_share' ) || ! tutor_utils()->count( $icons ) ) {
			return '';
		}

		$args = wp_parse_args(
			$args,
			array(
				'course_share_text_show' => 'on',
				'course_share_icon_show' => 'on',
				'popup_section_title'    => 'Share Course',
				'popup_share_title'      => 'Share Course',
				'show_social_icon'       => 'on',
				'show_social_text'       => 'on',
			)
		);

		$course = Helper::get_course();

		if ( ! $course ) {
			wp_reset_postdata();
			return '';
		}

		$args['course']                  = $course;
		$args['course_share_text_show']  = self::toggle_value( $args['course_share_text_show'] );
		$args['course_share_icon_show']  = self::toggle_value( $args['course_share_icon_show'] );
		$args['show_social_icon']        = self::toggle_value( $args['show_social_icon'] );
		$args['show_social_text']        = self::toggle_value( $args['show_social_text'] );
		$args['popup_section_title']     = sanitize_text_field( (string) $args['popup_section_title'] );
		$args['popup_share_title']       = sanitize_text_field( (string) $args['popup_share_title'] );

		ob_start();
		include dtlms_get_template( 'course/share' );
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
		$link        = "{$order_class} .dtlms-course-share a";
		$advanced    = $attrs['content']['advanced'] ?? array();
		$social      = $attrs['social']['advanced'] ?? array();
		$close       = $attrs['close']['advanced'] ?? array();

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
					$elements->style( array( 'attrName' => 'shareLabel' ) ),
					$elements->style( array( 'attrName' => 'shareIcon' ) ),
					$elements->style( array( 'attrName' => 'popupTitle' ) ),
					$elements->style( array( 'attrName' => 'popupShareTitle' ) ),
					$elements->style( array( 'attrName' => 'shareInput' ) ),
					$elements->style( array( 'attrName' => 'shareLinkTitle' ) ),
					$elements->style( array( 'attrName' => 'socialIcon' ) ),
					$elements->style( array( 'attrName' => 'socialText' ) ),
					$elements->style( array( 'attrName' => 'social' ) ),
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
					CommonStyle::style(
						array(
							'selector'            => "{$order_class} .tutor-social-share-button",
							'attr'                => $social['background'] ?? array(),
							'declarationFunction' => function ( $params ) {
								$color = $params['attrValue'] ?? '';

								return '' !== $color ? sprintf( 'background-color: %1$s;', esc_html( $color ) ) : '';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => "{$order_class} .tutor-iconic-btn",
							'attr'                => $close['color'] ?? array(),
							'declarationFunction' => function ( $params ) {
								$color = $params['attrValue'] ?? '';

								return '' !== $color ? sprintf( 'color: %1$s !important;', esc_html( $color ) ) : '';
							},
						)
					),
					CommonStyle::style(
						array(
							'selector'            => "{$order_class} .tutor-iconic-btn",
							'attr'                => $close['size'] ?? array(
								'desktop' => array(
									'value' => '30px',
								),
							),
							'declarationFunction' => function ( $params ) {
								$size = self::css_length( $params['attrValue'] ?? '' );

								return '' !== $size ? sprintf( 'font-size: %1$s !important;', esc_html( $size ) ) : '';
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
				'course_share_text_show' => self::content_value( $attrs, 'content', 'showLabel', 'on' ),
				'course_share_icon_show' => self::content_value( $attrs, 'content', 'showIcon', 'on' ),
				'popup_section_title'    => self::content_value( $attrs, 'popup', 'sectionTitle', 'Share Course' ),
				'popup_share_title'      => self::content_value( $attrs, 'popup', 'shareTitle', 'Share Course' ),
				'show_social_icon'       => self::content_value( $attrs, 'popup', 'showSocialIcon', 'on' ),
				'show_social_text'       => self::content_value( $attrs, 'popup', 'showSocialText', 'on' ),
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
