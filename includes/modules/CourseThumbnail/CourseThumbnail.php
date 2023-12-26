<?php

/**
 * Tutor Course Thumbnail Module for Divi Builder
 *
 * @since 1.0.0
 * @author Themeum<www.themeum.com>
 */

use TutorLMS\Divi\Helper;

defined( 'ABSPATH' ) || exit;

class CourseThumbnail extends ET_Builder_Module {

	public $slug       = 'tutor_course_thumbnail';
	public $vb_support = 'on';
	public $icon_path;

	/**
	 * Module properties initialization
	 *
	 * @since 1.0.0
	 */
	public function init() {
		$this->name            = esc_html__( 'Tutor Course Thumbnail', 'tutor-lms-divi-modules' );
		$this->icon_path       = plugin_dir_path( __FILE__ ) . 'icon.svg';
		$wrapper               = '%%order_class%% .tutor-divi-course-thumbnail';
		$this->advanced_fields = array(
			'fonts'      => false,
			'text'       => array(
				'css' => array(
					'main' => $wrapper,
				),
			),
			'borders'    => array(
				'default' => array(
					'css' => array(
						'main' => array(
							'border_radii'  => $wrapper,
							'border_styles' => $wrapper,
						),
					),
				),
			),
			'box_shadow' => array(
				'default' => array(
					'css' => array(
						'main' => $wrapper,
					),
				),
			),
			'max_width'  => array(
				'css' => array(
					'module_alignment' => $wrapper,
				),
			),
			'text'       => false,
			'button'     => false,
			'background' => false,
			'filters'    => false,
			'animation'  => false,
		);
	}

	/**
	 * Module's specific fields
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_fields() {
		return array(
			'course'      => Helper::get_field(
				array(
					'default'          => Helper::get_course_default(),
					'computed_affects' => array(
						'__thumbnail',
					),
				)
			),
			'__thumbnail' => array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'CourseThumbnail',
					'get_props',
				),
				'computed_depends_on' => array(
					'course',
				),
				'computed_minimum'    => array(
					'course',
				),
			),

		);
	}

	/**
	 * get require props
	 *
	 * @since 1.0.0
	 * @return string | array
	 */
	public static function get_props( $args = array() ) {
		$course_id = $args['course'];
		$content   = '';
		$has_video = true; // (bool) tutor_utils()->has_video_in_single( $course_id );
		$video     = tutor_utils()->get_video( $course_id );
		if ( $video && tutor_utils()->array_get( 'source', $video ) !== '-1' ) {
			$not_empty = ! empty( $video['source_video_id'] ) ||
				! empty( $video['source_external_url'] ) ||
				! empty( $video['source_youtube'] ) ||
				! empty( $video['source_vimeo'] ) ||
				! empty( $video['source_embedded'] ) ||
				! empty( $video['source_shortcode'] );
			$has_video = $not_empty ? $video : false;
		}
		if ( false === $has_video ) {
			$post_thumbnail_id = (int) get_post_thumbnail_id( $course_id );
			$place_holder_url  = tutor()->url . 'assets/images/placeholder.svg';
			$size              = apply_filters( 'tutor_course_thumbnail_size', 'post-thumbnail', $course_id );
			$thumb_url         = $post_thumbnail_id ? wp_get_attachment_image_url( $post_thumbnail_id, $size ) : $place_holder_url;
			ob_start();
			echo '<div class="tutor-course-thumbnail">
                <img src="' . esc_url( $thumb_url ) . '" />
            </div>';
			$content = ob_get_clean();
		} else {
			$template = trailingslashit( DTLMS_TEMPLATES . 'video' ) . 'video.php';
			if ( file_exists( $template ) ) {
				ob_start();
				tutor_load_template_from_custom_path(
					$template,
					array( 'course_id' => $course_id )
				);
				$content = ob_get_clean();
			}
		}
		return $content;
	}

	/**
	 * Get the tutor course content
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public static function get_content( $args = array() ) {
		ob_start();
		if ( $args['course'] ) {

			echo "<div class='tutor-divi-course-thumbnail'>";
			if ( tutils()->has_video_in_single() ) {
				tutor_course_video();
			} else {
				get_tutor_course_thumbnail();
			}
			echo '</div>';
		}
		return ob_get_clean();
	}

	/**
	 * Render module output
	 *
	 * @since 1.0.0
	 *
	 * @param array  $attrs       List of unprocessed attributes
	 * @param string $content     Content being processed
	 * @param string $render_slug Slug of module that is used for rendering output
	 *
	 * @return string module's rendered output
	 */
	public function render( $unprocessed_props, $content, $render_slug ) {
		$output = self::get_content( $this->props );
		return $this->_render_module_wrapper( $output, $render_slug );
	}
}

new CourseThumbnail();
