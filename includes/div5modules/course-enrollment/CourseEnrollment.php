<?php
/**
 * Divi 5 Course Enrollment module.
 *
 * @package TutorLMS\Divi
 */

namespace TutorLMS\Divi\D5\CourseEnrollment;

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
 * Frontend renderer and REST endpoint for the Divi 5 Course Enrollment module.
 */
class CourseEnrollment implements DependencyInterface {

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
			'/course-enrollment',
			array(
				'methods'             => 'GET',
				'callback'            => array( self::class, 'rest_index' ),
				'permission_callback' => array( self::class, 'rest_permission' ),
				'args'                => array(
					'preview_mode'   => array(
						'type'              => 'string',
						'required'          => false,
						'sanitize_callback' => 'sanitize_text_field',
					),
					'enrollment_box' => array(
						'type'              => 'string',
						'required'          => false,
						'sanitize_callback' => 'sanitize_text_field',
					),
					'button_size'    => array(
						'type'              => 'string',
						'required'          => false,
						'sanitize_callback' => 'sanitize_text_field',
					),
					'alignment'      => array(
						'type'              => 'string',
						'required'          => false,
						'sanitize_callback' => 'sanitize_text_field',
					),
					'btn_width'      => array(
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
	 * Return the enrollment HTML for Visual Builder.
	 *
	 * @param WP_REST_Request $request REST request.
	 * @return \WP_REST_Response
	 */
	public static function rest_index( WP_REST_Request $request ) {
		return rest_ensure_response(
			array(
				'html' => self::get_content(
					array(
						'preview_mode'   => $request->get_param( 'preview_mode' ),
						'enrollment_box' => $request->get_param( 'enrollment_box' ),
						'button_size'    => $request->get_param( 'button_size' ),
						'alignment'      => $request->get_param( 'alignment' ),
						'btn_width'      => $request->get_param( 'btn_width' ),
					),
					true
				),
			)
		);
	}

	/**
	 * Get the enrollment markup.
	 *
	 * Reuses the Divi 4 enrollment templates.
	 *
	 * @param array $args   Module arguments.
	 * @param bool  $editor Whether to render the Visual Builder template.
	 * @return string
	 */
	public static function get_content( $args = array(), $editor = false ) {
		if ( ! function_exists( 'dtlms_get_template' ) || ! function_exists( 'tutor_utils' ) ) {
			return '';
		}

		$args = wp_parse_args(
			$args,
			array(
				'preview_mode'   => 'enrollment',
				'enrollment_box' => 'on',
				'button_size'    => 'medium',
				'alignment'      => 'center',
				'btn_width'      => 'fill',
			)
		);

		$course = Helper::get_course();

		if ( ! $course ) {
			wp_reset_postdata();
			return '';
		}

		$args['course']         = $course;
		$args['preview_mode']   = self::one_of( $args['preview_mode'], array( 'enrollment', 'enrolled' ), 'enrollment' );
		$args['enrollment_box'] = 'off' === $args['enrollment_box'] ? 'off' : 'on';
		$args['button_size']    = self::one_of( $args['button_size'], array( 'small', 'medium', 'large' ), 'medium' );
		$args['alignment']      = self::one_of( $args['alignment'], array( 'left', 'center', 'right' ), 'center' );
		$args['btn_width']      = self::one_of( $args['btn_width'], array( 'auto', 'fill', 'fixed' ), 'fill' );

		$template = $editor ? 'course/enrolment-editor' : 'course/enrolment';

		ob_start();
		include dtlms_get_template( $template );
		$html = ob_get_clean();

		wp_reset_postdata();

		return $html;
	}

	/**
	 * Keep a value only when it is one of the allowed options.
	 *
	 * @param mixed  $value   Candidate value.
	 * @param array  $allowed Allowed values.
	 * @param string $default Fallback value.
	 * @return string
	 */
	private static function one_of( $value, $allowed, $default ) {
		$value = sanitize_text_field( (string) $value );

		return in_array( $value, $allowed, true ) ? $value : $default;
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
	 * @param string $selector CSS selector.
	 * @param array  $attr     Attribute value.
	 * @param string $property CSS property.
	 * @return array
	 */
	private static function length_style( $selector, $attr, $property ) {
		return CommonStyle::style(
			array(
				'selector'            => $selector,
				'attr'                => $attr,
				'declarationFunction' => function ( $params ) use ( $property ) {
					$length = self::css_length( $params['attrValue'] ?? '' );

					return '' !== $length ? sprintf( '%1$s: %2$s !important;', $property, esc_html( $length ) ) : '';
				},
			)
		);
	}

	/**
	 * Color style from an attribute.
	 *
	 * @param string $selector CSS selector.
	 * @param array  $attr     Attribute value.
	 * @param string $property CSS property.
	 * @return array
	 */
	private static function color_style( $selector, $attr, $property = 'color' ) {
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
	 * Decoration styles handled by Divi.
	 *
	 * @param object $elements Module elements.
	 * @param array  $settings Style settings.
	 * @return array
	 */
	private static function element_styles( $elements, $settings ) {
		$names  = array(
			'module',
			'pricing',
			'planFeatureIcon',
			'planFeature',
			'subscriptionTitle',
			'subscriptionPrice',
			'subscriptionPeriod',
			'progressTitle',
			'progressBar',
			'expireIcon',
			'expireValue',
			'expireLabel',
			'expire',
			'enrolledDate',
			'monetization',
			'metaLabel',
			'metaValue',
			'meta',
			'enrolledText',
			'enrolledInfo',
			'enrollButton',
			'buyNowButton',
			'addToCartButton',
			'startButton',
			'completeButton',
			'card',
			'cardBody',
			'cardInfo',
			'courseAlert',
			'subscriptionPlan',
			'planFeatureList',
		);
		$styles = array();

		foreach ( $names as $name ) {
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

		return $styles;
	}

	/**
	 * CSS that the Divi 4 module always prints.
	 *
	 * @param string $order_class Module order class.
	 * @return array
	 */
	private static function structural_styles( $order_class ) {
		$card = "{$order_class} .tutor-sidebar-card";

		return array(
			self::fixed_style( "{$order_class} .tutor-card-body.tutor-p-30", 'display: flex; flex-direction: column; row-gap: 10px;' ),
			self::fixed_style( "{$order_class} .enrolment-expire-info .tutor-ml-4", 'margin-left: 4px !important;' ),
			self::fixed_style( "{$order_class} .tutor-form-check-input", 'appearance: none !important;' ),
			self::fixed_style( "{$order_class} .tutor-btn.tutor-d-none", 'display: none !important;' ),
			self::fixed_style( "{$order_class} .tutor-btn", 'display: inline-flex !important;' ),
			self::fixed_style( "{$order_class} .dtlms-enroll-btn-width-auto form", 'display: inline-flex !important;' ),
			self::fixed_style( "{$order_class} .dtlms-enroll-btn-width-auto .tutor-course-sidebar-card-body:not(.tutor-course-progress-wrapper)", 'display: flex; flex-direction: column;' ),
			self::fixed_style( "{$order_class} .dtlms-enroll-btn-align-left .tutor-course-sidebar-card-body:not(.tutor-course-progress-wrapper), {$order_class} .dtlms-enroll-btn-align-left form", 'align-items: flex-start;' ),
			self::fixed_style( "{$order_class} .dtlms-enroll-btn-align-center .tutor-course-sidebar-card-body:not(.tutor-course-progress-wrapper), {$order_class} .dtlms-enroll-btn-align-center form", 'align-items: center;' ),
			self::fixed_style( "{$order_class} .dtlms-enroll-btn-align-right .tutor-course-sidebar-card-body:not(.tutor-course-progress-wrapper), {$order_class} .dtlms-enroll-btn-align-right form", 'align-items: flex-end;' ),
			self::fixed_style( "{$order_class} .dtlms-enroll-btn-width-fill .tutor-course-sidebar-card-btns, {$order_class} .dtlms-enroll-btn-width-fill .tutor-course-sidebar-card-body form", 'width: 100%;' ),
			self::fixed_style( "{$order_class} .dtlms-enroll-btn-width-auto .tutor-btn", 'width: auto !important; display: inline-flex !important;' ),
			self::fixed_style( "{$order_class} .dtlms-enroll-btn-size-large .tutor-btn", 'font-size: 18px; padding: 10px 20px;' ),
			self::fixed_style( "{$order_class} .dtlms-enroll-btn-size-small .tutor-btn", 'font-size: 14px; padding: 5px 12px;' ),
			self::fixed_style( "{$order_class} .tutor-card-body a", 'line-height: inherit; padding-bottom: 8px !important;' ),
			self::fixed_style( "{$order_class} .tutor-plan-feature-item", 'display: flex; align-items: center;' ),
			self::fixed_style( "{$order_class} .tutor-subscription-plan-wrapper", 'display: flex; flex-direction: column;' ),
			self::fixed_style( "{$order_class} .tutor-course-subscription-plan", 'display: block;' ),
			self::fixed_style( "{$order_class} .tutor-plan-feature-list", 'display: flex; flex-direction: column;' ),
			self::fixed_style( "{$order_class} .tutor-alert .tutor-alert-text", 'display: flex;' ),
			self::fixed_style( "{$card} .tutor-card-body", 'display: flex; flex-direction: column; row-gap: 10px;' ),
		);
	}

	/**
	 * Setting-driven CSS.
	 *
	 * @param string $order_class Module order class.
	 * @param array  $attrs       Module attributes.
	 * @return array
	 */
	private static function dynamic_styles( $order_class, $attrs ) {
		$content = $attrs['content']['advanced'] ?? array();

		return array(
			self::length_style(
				"{$order_class} .dtlms-enroll-btn-width-fixed button, {$order_class} .dtlms-enroll-btn-width-fixed .tutor-button, {$order_class} .dtlms-enroll-btn-width-fixed .start-continue-retake-button",
				$content['widthPx'] ?? array(),
				'width'
			),
			CommonStyle::style(
				array(
					'selector'            => "{$order_class} .dtlms-enroll-btn-width-auto .tutor-card-body",
					'attr'                => $content['alignment'] ?? array(),
					'declarationFunction' => function ( $params ) {
						$alignment = self::one_of( $params['attrValue'] ?? '', array( 'left', 'center', 'right' ), 'center' );

						return sprintf( 'text-align: %1$s !important;', esc_html( $alignment ) );
					},
				)
			),
			self::length_style( "{$order_class} .tutor-card", $attrs['card']['advanced']['gap'] ?? array(), 'row-gap' ),
			self::length_style( "{$order_class} .tutor-card-footer .dtlms-enrollment-meta-label", $attrs['meta']['advanced']['iconSize'] ?? array(), 'font-size' ),
			self::color_style( "{$order_class} .tutor-card-footer .dtlms-enrollment-meta-label", $attrs['meta']['advanced']['iconColor'] ?? array() ),
			self::length_style( "{$order_class} .tutor-icon-purchase-mark", $attrs['enrolledIcon']['advanced']['size'] ?? array(), 'font-size' ),
			self::color_style( "{$order_class} .tutor-icon-purchase-mark", $attrs['enrolledIcon']['advanced']['color'] ?? array() ),
			self::color_style( "{$order_class} .tutor-card .tutor-card-body", $attrs['cardBody']['advanced']['backgroundColor'] ?? array(), 'background-color' ),
			self::color_style( "{$order_class} .tutor-course-progress-wrapper .tutor-progress-bar", $attrs['progress']['advanced']['barBackground'] ?? array(), 'background-color' ),
			self::length_style( "{$order_class} .dtlms-course-enroll-info-wrapper", $attrs['enrolledInfo']['advanced']['gap'] ?? array(), 'column-gap' ),
			self::color_style( "{$order_class} .tutor-alert", $attrs['courseAlert']['advanced']['backgroundColor'] ?? array(), 'background-color' ),
			self::length_style( "{$order_class} .tutor-alert .tutor-alert-text", $attrs['courseAlert']['advanced']['gap'] ?? array(), 'column-gap' ),
			self::color_style( "{$order_class} .tutor-alert-icon", $attrs['courseAlert']['advanced']['iconColor'] ?? array() ),
			self::length_style( "{$order_class} .tutor-subscription-plan-wrapper", $attrs['subscription']['advanced']['gap'] ?? array(), 'gap' ),
			self::color_style( "{$order_class} .tutor-course-subscription-plan", $attrs['subscriptionPlan']['advanced']['backgroundColor'] ?? array(), 'background-color' ),
			self::length_style( "{$order_class} .tutor-plan-feature-list", $attrs['planFeatureList']['advanced']['gap'] ?? array(), 'gap' ),
			self::length_style( "{$order_class} .tutor-plan-feature-item", $attrs['planFeature']['advanced']['gap'] ?? array(), 'gap' ),
			self::color_style( "{$order_class} .tutor-plan-feature-item i", $attrs['planFeatureIcon']['advanced']['color'] ?? array() ),
		);
	}

	/**
	 * Render module styles.
	 *
	 * @param array $args Style arguments.
	 * @return void
	 */
	public static function module_styles( $args ) {
		$order_class = $args['orderClass'] ?? '';

		Style::add(
			array(
				'id'            => $args['id'],
				'name'          => $args['name'],
				'orderIndex'    => $args['orderIndex'],
				'storeInstance' => $args['storeInstance'],
				'styles'        => array_merge(
					self::element_styles( $args['elements'], $args['settings'] ?? array() ),
					self::structural_styles( $order_class ),
					self::dynamic_styles( $order_class, $args['attrs'] ?? array() )
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
				'preview_mode'   => self::content_value( $attrs, 'previewMode', 'enrollment' ),
				'enrollment_box' => self::content_value( $attrs, 'enrollmentBox', 'on' ),
				'button_size'    => self::content_value( $attrs, 'buttonSize', 'medium' ),
				'alignment'      => self::content_value( $attrs, 'alignment', 'center' ),
				'btn_width'      => self::content_value( $attrs, 'btnWidth', 'fill' ),
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
