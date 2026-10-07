<?php
/**
 * Divi 5 Course Content module.
 *
 * @package TutorLMS\Divi
 */

namespace TutorLMS\Divi\D5\CourseContent;

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
 * Frontend renderer and REST endpoints for the Divi 5 Course Content module.
 */
class CourseContent implements DependencyInterface {

	/**
	 * Custom curriculum title for the current render.
	 *
	 * @var string
	 */
	private static $topics_label = '';

	/**
	 * Custom reviews title for the current render.
	 *
	 * @var string
	 */
	private static $reviews_label = '';

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
		if ( 'tutor-lms/course-content' !== ( $metadata['name'] ?? '' ) ) {
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
			'/course-content',
			array(
				'methods'             => 'GET',
				'callback'            => array( self::class, 'rest_index' ),
				'permission_callback' => array( self::class, 'rest_permission' ),
				'args'                => array(
					'course'         => array(
						'type'              => 'string',
						'required'          => false,
						'sanitize_callback' => 'sanitize_text_field',
					),
					'benefits_label' => array(
						'type'              => 'string',
						'required'          => false,
						'sanitize_callback' => 'sanitize_text_field',
					),
					'topics_label'   => array(
						'type'              => 'string',
						'required'          => false,
						'sanitize_callback' => 'sanitize_text_field',
					),
					'reviews_label'  => array(
						'type'              => 'string',
						'required'          => false,
						'sanitize_callback' => 'sanitize_text_field',
					),
					'icon_unicode'   => array(
						'type'              => 'string',
						'required'          => false,
						'sanitize_callback' => 'sanitize_text_field',
					),
					'icon_type'      => array(
						'type'              => 'string',
						'required'          => false,
						'sanitize_callback' => 'sanitize_text_field',
					),
					'icon_weight'    => array(
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
	 * Return the course content HTML for Visual Builder.
	 *
	 * @param WP_REST_Request $request REST request.
	 * @return \WP_REST_Response
	 */
	public static function rest_index( WP_REST_Request $request ) {
		$html = self::get_content(
			array(
				'course'               => $request->get_param( 'course' ),
				'benefit_title'        => $request->get_param( 'benefits_label' ),
				'course_topics_label'  => $request->get_param( 'topics_label' ),
				'course_reviews_label' => $request->get_param( 'reviews_label' ),
				'course_benefits_icon' => array(
					'unicode' => $request->get_param( 'icon_unicode' ),
					'type'    => $request->get_param( 'icon_type' ),
					'weight'  => $request->get_param( 'icon_weight' ),
				),
			),
			true
		);

		return rest_ensure_response(
			array(
				'html' => $html,
			)
		);
	}

	/**
	 * Get the course content markup.
	 *
	 * Reuses the Divi 4 course content templates.
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
				'course'               => '',
				'benefit_title'        => '',
				'course_topics_label'  => '',
				'course_reviews_label' => '',
				'course_benefits_icon' => '',
			)
		);

		$course = Helper::get_course( $args );

		if ( ! $course ) {
			return '';
		}

		$args['course']               = $course;
		$args['benefit_title']        = sanitize_text_field( (string) $args['benefit_title'] );
		$args['course_topics_label']  = sanitize_text_field( (string) $args['course_topics_label'] );
		$args['course_reviews_label'] = sanitize_text_field( (string) $args['course_reviews_label'] );
		$args['course_benefits_icon'] = self::icon_character( $args['course_benefits_icon'] );

		self::apply_title_filters( $args );

		$template = $editor ? 'course/content-editor' : 'course/content';

		ob_start();
		include dtlms_get_template( $template );
		$html = ob_get_clean();

		wp_reset_postdata();

		return $html;
	}

	/**
	 * Apply the curriculum and reviews titles for this render.
	 *
	 * @param array $args Module arguments.
	 * @return void
	 */
	private static function apply_title_filters( $args ) {
		self::$topics_label  = $args['course_topics_label'];
		self::$reviews_label = $args['course_reviews_label'];

		remove_filter( 'tutor_course_topics_title', array( self::class, 'filter_topics_title' ) );
		remove_filter( 'tutor_course_reviews_section_title', array( self::class, 'filter_reviews_title' ) );

		if ( '' !== self::$topics_label ) {
			add_filter( 'tutor_course_topics_title', array( self::class, 'filter_topics_title' ) );
		}

		if ( '' !== self::$reviews_label ) {
			add_filter( 'tutor_course_reviews_section_title', array( self::class, 'filter_reviews_title' ) );
		}
	}

	/**
	 * Curriculum title filter.
	 *
	 * @return string
	 */
	public static function filter_topics_title() {
		return self::$topics_label;
	}

	/**
	 * Reviews section title filter.
	 *
	 * @return string
	 */
	public static function filter_reviews_title() {
		return self::$reviews_label;
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
	 * Desktop value, including a Divi 4 hover value stored on the desktop key.
	 *
	 * @param array  $attr    Attribute array.
	 * @param string $default Fallback value.
	 * @return string
	 */
	private static function desktop_value( $attr, $default = '' ) {
		$value = $attr['desktop']['value'] ?? $default;

		if ( is_int( $value ) || is_float( $value ) ) {
			return (string) $value;
		}

		return is_string( $value ) ? $value : $default;
	}

	/**
	 * Selectors used by the module styles.
	 *
	 * @param string $order_class Module order class.
	 * @return array<string, string>
	 */
	private static function selectors( $order_class ) {
		$curriculum = "{$order_class} .dtlms-course-curriculum";
		$reviews    = "{$order_class} #tutor-course-details-tab-reviews";

		return array(
			'curriculum'    => $curriculum,
			'benefits'      => "{$order_class} .tutor-course-details-widget",
			'benefits_list' => "{$order_class} .tutor-course-details-widget-list",
			'benefits_item' => "{$order_class} .tutor-course-details-widget-list li",
			'benefits_icon' => "{$order_class} .tutor-course-details-widget-list .et-pb-icon",
			'benefits_text' => "{$order_class} .tutor-course-details-widget-list .list-item",
			'nav'           => "{$order_class} .tutor-nav",
			'topic_header'  => "{$curriculum} .tutor-accordion-item-header",
			'topic_icon'    => "{$curriculum} .tutor-accordion-item-header::after",
			'topic_item'    => "{$curriculum} .tutor-accordion-item",
			'lesson_icon'   => "{$order_class} .tutor-accordion-item .tutor-course-content-list-item-icon, {$order_class} .tutor-accordion-item .tutor-course-content-list-item-status",
			'lesson_icon_hover' => "{$order_class} .tutor-accordion-item .tutor-course-content-list-item-icon:hover, {$order_class} .tutor-accordion-item .tutor-course-content-list-item-status:hover",
			'lesson_item'   => "{$order_class} .tutor-accordion-item .tutor-course-content-list-item",
			'lesson_info'   => "{$order_class} .tutor-accordion-item .tutor-course-content-list-item-duration",
			'reviews'       => $reviews,
			'rating_bars'   => "{$order_class} .tutor-review-summary-ratings",
		);
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
	 * @param bool   $important Whether to mark the declaration important.
	 * @return array
	 */
	private static function color_style( $selector, $attr, $property = 'color', $important = false ) {
		return CommonStyle::style(
			array(
				'selector'            => $selector,
				'attr'                => $attr,
				'declarationFunction' => function ( $params ) use ( $property, $important ) {
					$color = $params['attrValue'] ?? '';

					if ( ! is_string( $color ) || '' === $color ) {
						return '';
					}

					return sprintf(
						'%1$s: %2$s%3$s;',
						$property,
						esc_html( $color ),
						$important ? ' !important' : ''
					);
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
		$elements = $args['elements'];

		$elements->script_data(
			array(
				'attrName' => 'module',
			)
		);
	}

	/**
	 * Decoration styles generated from module attributes.
	 *
	 * @param object $elements Module elements.
	 * @param array  $settings Style settings.
	 * @return array
	 */
	private static function element_styles( $elements, $settings ) {
		$names  = array(
			'module',
			'about',
			'aboutHeading',
			'aboutText',
			'courseTabs',
			'benefits',
			'benefitsTitle',
			'benefitsList',
			'benefitsText',
			'benefitsIcon',
			'curriculumHeader',
			'topics',
			'topicTitle',
			'lesson',
			'reviewSectionTitle',
			'reviewAvg',
			'reviewAvgText',
			'reviewAvgStar',
			'ratingBar',
			'reviewAuthor',
			'reviewTime',
			'reviewComment',
			'reviewListStar',
			'reviewSummary',
			'review',
			'reviewAvatar',
			'reviewCard',
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
	 * Structural CSS that the Divi 4 module always prints.
	 *
	 * @param array<string, string> $selector Selectors.
	 * @return array
	 */
	private static function structural_styles( $selector ) {
		return array(
			self::fixed_style( $selector['benefits'], 'display: flex; flex-direction: column;' ),
			self::fixed_style( $selector['benefits_list'], 'list-style: none; padding: 0; margin: 0;' ),
			self::fixed_style( $selector['benefits_item'], 'list-style: none; border-style: solid;' ),
			self::fixed_style( $selector['nav'], 'display: flex !important;' ),
			self::fixed_style( "{$selector['curriculum']} .tutor-is-sticky", 'top: 32px !important; position: sticky !important; backdrop-filter: blur(14px) !important; z-index: 1063 !important;' ),
			self::fixed_style( "{$selector['topic_item']} .tutor-course-content-list-item-title a", 'color: inherit !important;' ),
			self::fixed_style( "{$selector['topic_item']} .tutor-course-content-list-item-icon", 'margin-right: 12px !important;' ),
			self::fixed_style( "{$selector['topic_item']} .tutor-course-content-list-item-status", 'margin-left: 20px !important;' ),
			self::fixed_style( $selector['topic_header'], 'transition: background-color 300ms ease-in !important;' ),
			self::fixed_style( $selector['topic_item'], 'border: 1px solid #DCE4E6;' ),
			self::fixed_style( "{$selector['curriculum']} .tutor-course-title", 'display: flex; column-gap: 10px; align-items: center !important;' ),
			self::fixed_style( "{$selector['curriculum']} .tutor-course-title h4", 'padding: 0; margin: 0;' ),
			self::fixed_style( "{$selector['curriculum']} ul.tutor-courses-lession-list", 'padding: 0 !important;' ),
			self::fixed_style( "{$selector['reviews']} .tutor-reviews .tutor-review-list-item .tutor-col-lg-3, {$selector['reviews']} .tutor-reviews .tutor-review-list-item .tutor-col-lg-9", 'padding-left: 12px !important; padding-right: 12px !important;' ),
			self::fixed_style( "{$selector['reviews']} .tutor-ratings-stars span", 'margin-left: 3px !important; margin-right: 3px !important;' ),
			self::fixed_style( "{$selector['reviews']} .tutor-review-summary .tutor-col-lg-auto, {$selector['reviews']} .tutor-review-summary .tutor-col-lg", 'padding-left: 24px !important; padding-right: 24px !important;' ),
			self::fixed_style( "{$selector['reviews']} .tutor-review-summary .tutor-review-summary-average-rating", 'margin-bottom: 20px !important;' ),
		);
	}

	/**
	 * Setting-driven CSS.
	 *
	 * @param array<string, string> $selector Selectors.
	 * @param array                 $attrs    Module attributes.
	 * @return array
	 */
	private static function dynamic_styles( $selector, $attrs ) {
		$content      = $attrs['content']['advanced'] ?? array();
		$layout_attr  = $content['layout'] ?? array(
			'desktop' => array(
				'value' => 'flex',
			),
		);
		$space_attr   = $attrs['benefitsList']['advanced']['spaceBetween'] ?? array(
			'desktop' => array(
				'value' => '10px',
			),
		);
		$benefits     = $selector['benefits'];
		$benefits_list = $selector['benefits_list'];
		$item         = $selector['benefits_item'];
		$icon         = $selector['benefits_icon'];

		return array(
			self::length_style(
				$benefits,
				$attrs['benefitsTitle']['advanced']['gap'] ?? array(
					'desktop' => array(
						'value' => '10px',
					),
				),
				'row-gap'
			),
			CommonStyle::style(
				array(
					'selector'            => $benefits_list,
					'attr'                => $layout_attr,
					'declarationFunction' => function ( $params ) {
						$layout = $params['attrValue'] ?? 'flex';

						if ( 'flex' === $layout ) {
							return 'display: flex !important; flex-wrap: wrap;';
						}

						return sprintf( 'display: %1$s !important;', esc_html( (string) $layout ) );
					},
				)
			),
			CommonStyle::style(
				array(
					'selector'            => $benefits,
					'attr'                => $content['alignment'] ?? array(
						'desktop' => array(
							'value' => 'left',
						),
					),
					'declarationFunction' => function ( $params ) {
						$alignment = $params['attrValue'] ?? '';

						return is_string( $alignment ) && '' !== $alignment ? sprintf( 'text-align: %1$s !important;', esc_html( $alignment ) ) : '';
					},
				)
			),
			CommonStyle::style(
				array(
					'selector'            => $benefits_list,
					'attr'                => $space_attr,
					'declarationFunction' => function ( $params ) use ( $layout_attr ) {
						$space  = self::css_length( $params['attrValue'] ?? '' );
						$layout = self::breakpoint_value( $layout_attr, $params['breakpoint'] ?? 'desktop', 'flex' );

						if ( '' === $space || 'flex' !== $layout ) {
							return '';
						}

						return sprintf( 'column-gap: %1$s;', esc_html( $space ) );
					},
				)
			),
			CommonStyle::style(
				array(
					'selector'            => "{$item}:not(:last-child)",
					'attr'                => $space_attr,
					'declarationFunction' => function ( $params ) use ( $layout_attr ) {
						$space  = self::css_length( $params['attrValue'] ?? '' );
						$layout = self::breakpoint_value( $layout_attr, $params['breakpoint'] ?? 'desktop', 'flex' );

						if ( '' === $space || 'flex' === $layout ) {
							return '';
						}

						$property = 'list' === $layout ? 'margin-bottom' : 'margin-right';

						return sprintf( '%1$s: %2$s !important;', $property, esc_html( $space ) );
					},
				)
			),
			self::length_style(
				$selector['benefits_text'],
				$attrs['benefitsText']['advanced']['indent'] ?? array(
					'desktop' => array(
						'value' => '7px',
					),
				),
				'padding-left',
				true
			),
			self::color_style(
				$icon,
				$attrs['benefitsIcon']['advanced']['color'] ?? array(
					'desktop' => array(
						'value' => '#757c8e',
					),
				),
				'color',
				true
			),
			self::length_style(
				$icon,
				$attrs['benefitsIcon']['advanced']['size'] ?? array(
					'desktop' => array(
						'value' => '0.75rem',
					),
				),
				'font-size',
				true
			),
			CommonStyle::style(
				array(
					'selector'            => $icon,
					'attr'                => $content['icon'] ?? array(),
					'declarationFunction' => function ( $params ) {
						$icon_value = $params['attrValue'] ?? array();

						if ( ! is_array( $icon_value ) || empty( $icon_value['unicode'] ) ) {
							return '';
						}

						$family = ( isset( $icon_value['type'] ) && 'fa' === $icon_value['type'] ) ? 'FontAwesome' : 'ETmodules';
						$weight = isset( $icon_value['weight'] ) ? sprintf( ' font-weight: %1$s;', esc_html( $icon_value['weight'] ) ) : '';

						return sprintf( "font-family: '%1\$s' !important;%2\$s", $family, $weight );
					},
				)
			),
			self::length_style( $selector['nav'], $attrs['courseTabs']['advanced']['gap'] ?? array(), 'column-gap', true ),
			self::length_style(
				$selector['topic_icon'],
				$attrs['topics']['advanced']['iconSize'] ?? array(
					'desktop' => array(
						'value' => '32px',
					),
				),
				'font-size'
			),
			self::color_style( $selector['topic_icon'], $attrs['topics']['advanced']['iconColor'] ?? array() ),
			self::color_style( "{$selector['topic_header']}.is-active::after", $attrs['topics']['advanced']['iconActiveColor'] ?? array() ),
			self::color_style( "{$selector['topic_header']}:hover::after", $attrs['topics']['advanced']['iconHoverColor'] ?? array() ),
			self::color_style( $selector['topic_header'], $attrs['topics']['advanced']['textColor'] ?? array() ),
			self::color_style( "{$selector['topic_header']}.is-active", $attrs['topics']['advanced']['textActiveColor'] ?? array() ),
			self::color_style( "{$selector['topic_header']}:hover", $attrs['topics']['advanced']['textHoverColor'] ?? array() ),
			self::color_style( $selector['topic_header'], $attrs['topics']['advanced']['backgroundColor'] ?? array(), 'background-color' ),
			self::color_style( "{$selector['topic_header']}.is-active", $attrs['topics']['advanced']['backgroundActiveColor'] ?? array(), 'background-color' ),
			self::color_style( "{$selector['topic_header']}:hover", $attrs['topics']['advanced']['backgroundHoverColor'] ?? array(), 'background-color' ),
			self::length_style(
				$selector['topic_item'],
				$attrs['topics']['advanced']['spaceBetween'] ?? array(
					'desktop' => array(
						'value' => '10px',
					),
				),
				'margin-bottom'
			),
			self::length_style(
				$selector['lesson_icon'],
				$attrs['lesson']['advanced']['iconSize'] ?? array(
					'desktop' => array(
						'value' => '18px',
					),
				),
				'font-size'
			),
			self::color_style( $selector['lesson_icon'], $attrs['lesson']['advanced']['iconColor'] ?? array() ),
			self::color_style( $selector['lesson_icon_hover'], $attrs['lesson']['advanced']['iconColorHover'] ?? array() ),
			self::color_style( $selector['lesson_info'], $attrs['lesson']['advanced']['infoColor'] ?? array() ),
			self::color_style( "{$selector['lesson_info']}:hover", $attrs['lesson']['advanced']['infoColorHover'] ?? array() ),
			self::color_style( $selector['lesson_item'], $attrs['lesson']['advanced']['backgroundColor'] ?? array(), 'background-color' ),
			self::color_style( "{$selector['lesson_item']}:hover", $attrs['lesson']['advanced']['backgroundColorHover'] ?? array(), 'background-color' ),
			CommonStyle::style(
				array(
					'selector'            => "{$selector['reviews']} .tutor-review-summary .tutor-col-lg-auto",
					'attr'                => $content['reviewsAlignment'] ?? array(
						'desktop' => array(
							'value' => 'center',
						),
					),
					'declarationFunction' => function ( $params ) {
						$alignment = $params['attrValue'] ?? '';

						return is_string( $alignment ) && '' !== $alignment ? sprintf( 'text-align: %1$s !important;', esc_html( $alignment ) ) : '';
					},
				)
			),
			self::color_style( "{$selector['rating_bars']} .tutor-ratings .tutor-ratings-stars", $attrs['ratingBar']['advanced']['starColor'] ?? array(), 'color', true ),
			self::length_style( "{$selector['rating_bars']} .tutor-ratings-progress-bar", $attrs['ratingBar']['advanced']['height'] ?? array(
				'desktop' => array(
					'value' => '8px',
				),
			), 'height', true ),
			self::color_style( "{$selector['rating_bars']} .tutor-progress-bar", $attrs['ratingBar']['advanced']['barColor'] ?? array(), 'background-color' ),
			self::color_style( "{$selector['rating_bars']} .tutor-ratings-progress-bar .tutor-progress-value", $attrs['ratingBar']['advanced']['fillColor'] ?? array(), 'background-color' ),
			self::color_style(
				"{$selector['reviews']} .tutor-review-summary",
				$attrs['reviewSummary']['advanced']['background'] ?? array(
					'desktop' => array(
						'value' => 'rgb(255,255,255)',
					),
				),
				'background',
				true
			),
			self::color_style(
				"{$selector['reviews']} .tutor-reviews .tutor-review-list-item",
				$attrs['review']['advanced']['background'] ?? array(
					'desktop' => array(
						'value' => 'rgb(255,255,255)',
					),
				),
				'background',
				true
			),
			self::color_style( "{$selector['reviews']} .tutor-reviews .tutor-review-list-item .tutor-ratings-stars", $attrs['review']['advanced']['starColor'] ?? array(), 'color', true ),
			self::color_style( "{$selector['reviews']} .tutor-reviews .tutor-review-list-item .tutor-ratings-stars:hover", $attrs['review']['advanced']['starColorHover'] ?? array(), 'color', true ),
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
		$selector    = self::selectors( $order_class );

		Style::add(
			array(
				'id'            => $args['id'],
				'name'          => $args['name'],
				'orderIndex'    => $args['orderIndex'],
				'storeInstance' => $args['storeInstance'],
				'styles'        => array_merge(
					self::structural_styles( $selector ),
					self::element_styles( $elements, $settings ),
					self::dynamic_styles( $selector, $attrs )
				),
			)
		);
	}

	/**
	 * Read a desktop content value from module attributes.
	 *
	 * @param array  $attrs   Module attributes.
	 * @param string $key     Advanced content key.
	 * @param mixed  $default Fallback value.
	 * @return mixed
	 */
	private static function content_value( $attrs, $key, $default = '' ) {
		return $attrs['content']['advanced'][ $key ]['desktop']['value'] ?? $default;
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
				'course'               => self::content_value( $attrs, 'course' ),
				'benefit_title'        => self::content_value( $attrs, 'benefitsLabel', 'What Will You Learn?' ),
				'course_topics_label'  => self::content_value( $attrs, 'topicsLabel', 'Course Content' ),
				'course_reviews_label' => self::content_value( $attrs, 'reviewsLabel', 'Student Ratings & Reviews' ),
				'course_benefits_icon' => self::content_value( $attrs, 'icon', '' ),
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
