<?php
/**
 * Tutor Divi Module Helper
 *
 * @package     Divi
 * @sub-package Builder
 * @author      Themeum <www.themeum.com>
 * @copyright   2020 Themeum <www.themeum.com>
 * @version     Release: @1.0.0
 * @since       1.0.0
 */

namespace TutorLMS\Divi;

defined('ABSPATH') || exit;

class Helper {
    /**
     * Get reusable tutor course field definition
     *
     * @since 1.0.0
     *
     * @param array  $attrs Attribute that need to be inserted into field definition.
     *
     * @return array
     */
    public static function get_field($attrs = array()) {

        $default = self::get_course_default();

        $field = array(
            'label'             => esc_html__('Course', 'tutor-lms-divi-modules'),
            'type'              => 'select',
            'option_category'   => 'configuration',
            'description'       => esc_html__('Here you can select the Course.', 'tutor-lms-divi-modules'),
            'toggle_slug'       => 'main_content',
            'options'           => array(
                $default    => get_the_title($default)
            ),
            'default'           => $default,
            'computed_affects'  => array(
                '__course',
            ),
        );

        // Added custom attribute(s).
        if (!empty($attrs)) {
            $field = wp_parse_args($attrs, $field);
        }

        return $field;
    }
    
    /**
     * Gets the Course Id by the given Course prop value.
     *
     * @param string $course_attr
     *
     * @return int
     */
    public static function get_original_course_id($course_attr) {
        if ('current' === $course_attr) {
            $current_post_id = \ET_Builder_Element::get_current_post_id();

            if (et_theme_builder_is_layout_post_type(get_post_type($current_post_id))) {
                // We want to use the latest Course when we are editing a TB layout.
                $course_attr = 'latest';
            }
        }

        if (!in_array($course_attr, array(
            'current',
            'latest',
        )) && false === get_post_status($course_attr)) {
            $course_attr = 'latest';
        }

        if ('current' === $course_attr) {
            $course_id = \ET_Builder_Element::get_current_post_id();
        } else if ('latest' === $course_attr) {
            $courses = self::get_courses();
            if (!empty($courses)) {
                $course_id = self::array_key_first($courses);
            } else {
                return 0;
            }
        } else {
            $course_id = absint($course_attr);
        }

        return $course_id;
    }

    /**
     * Gets first key of array
     *
     * @param string $arr
     *
     * @return int
     */
    public static function array_key_first(array $arr) {
        foreach ($arr as $key => $unused) {
            return $key;
        }
        return NULL;
    }

    /**
     * Gets formatted course id
     *
     * @param string|int
     *
     * @return string
     */
    public static function format_course_id($course_id) {
        return $course_id;
    }

    /**
     * Gets dformatted course id
     *
     * @param string
     *
     * @return string
     */
    public static function dformat_course_id($course_id) {
        $course_id = explode('_', $course_id);
        return $course_id[1];
    }

    /**
     * Load the course for a module and set it as the current post.
     *
     * Uses the module's course attribute when it is a real course. Otherwise
     * uses the course open in Divi, then the latest published course.
     *
     * @param array $args Module arguments. Accepts `course`.
     * @return int|false Course ID, or false when no course can be loaded.
     */
    public static function get_course($args = array()) {
        $args = wp_parse_args(
            $args,
            array(
                'course' => '',
            )
        );

        $course_id = self::resolve_course_id( $args['course'] );

        if ( ! $course_id || ! function_exists( 'tutor' ) ) {
            return false;
        }

        $query = new \WP_Query(
            array(
                'p'              => $course_id,
                'post_type'      => tutor()->course_post_type,
                'post_status'    => array( 'publish', 'draft', 'pending', 'private', 'future' ),
                'posts_per_page' => 1,
            )
        );

        if ( $query->have_posts() ) {
            $query->the_post();
            return $course_id;
        }

        return false;
    }

    /**
     * Get tutor recent courses
     *
     * @since 1.0.0
     * @return array
     */
    public static function get_courses($default = false) {
        $courses = array();
        $current = self::format_course_id('current');

        if ($default && $default === $current) {
            $courses[$current] = esc_html__('This Course', 'tutor-lms-divi-modules');
        }
        $latest = self::format_course_id('latest');
        $courses[$latest] = esc_html__('Latest Course', 'tutor-lms-divi-modules');
        $course_list = get_posts(array(
            'post_type'         => tutor()->course_post_type,
            'post_status'       => 'publish',
            'orderby'           => 'ID',
            'order'             => 'DESC',
        ));
        foreach ($course_list as $course) {
            $course_id = self::format_course_id($course->ID);
            $courses[$course_id] = $course->post_title;
        }
        return $courses;
    }

    /**
     * Get the course default value for the current post type.
     *
     * @return string
     */
    public static function get_course_default() {
        $course_id = self::editing_course_id();

        return $course_id ? $course_id : null;
    }

    /**
     * Course post currently open in Divi, if that post is a Tutor course.
     *
     * @return int
     */
    public static function editing_course_id() {
        if ( ! function_exists( 'tutor' ) ) {
            return 0;
        }

        $course_type = tutor()->course_post_type;

        foreach ( self::current_post_id_candidates() as $post_id ) {
            if ( self::is_course( $post_id, $course_type ) ) {
                return $post_id;
            }
        }

        return 0;
    }

    /**
     * Resolve a Course attribute to a course post ID.
     *
     * A numeric course ID is kept. An empty value, "current", or an invalid ID
     * falls back to the course being viewed, then to the latest published course.
     *
     * @param mixed $course_attr Course attribute value.
     * @return int
     */
    public static function resolve_course_id( $course_attr = '' ) {
        if ( ! function_exists( 'tutor' ) ) {
            return 0;
        }

        $course_type = tutor()->course_post_type;
        $course_id   = absint( $course_attr );

        if ( $course_id && self::is_course( $course_id, $course_type ) ) {
            return $course_id;
        }

        if ( 'latest' !== (string) $course_attr ) {
            $editing_course_id = self::editing_course_id();

            if ( $editing_course_id ) {
                return $editing_course_id;
            }
        }

        $latest = get_posts(
            array(
                'post_type'              => $course_type,
                'post_status'            => 'publish',
                'orderby'                => 'ID',
                'order'                  => 'DESC',
                'posts_per_page'         => 1,
                'fields'                 => 'ids',
                'no_found_rows'          => true,
                'update_post_meta_cache' => false,
                'update_post_term_cache' => false,
            )
        );

        return ! empty( $latest ) ? (int) $latest[0] : 0;
    }

    /**
     * Whether a post is a Tutor course.
     *
     * @param int    $post_id     Post ID.
     * @param string $course_type Course post type.
     * @return bool
     */
    private static function is_course( $post_id, $course_type ) {
        $post_id = absint( $post_id );

        return $post_id && get_post_type( $post_id ) === $course_type && (bool) get_post_status( $post_id );
    }

    /**
     * Post IDs that may be the course currently being edited or viewed.
     *
     * @return int[]
     */
    private static function current_post_id_candidates() {
        $candidates = array();

        foreach ( array( 'et_post_id', 'post', 'post_id' ) as $key ) {
            if ( isset( $_REQUEST[ $key ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
                $candidates[] = absint( wp_unslash( $_REQUEST[ $key ] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            }
        }

        foreach ( array( 'currentPage', 'current_page' ) as $key ) {
            if ( isset( $_REQUEST[ $key ]['id'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
                $candidates[] = absint( wp_unslash( $_REQUEST[ $key ]['id'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            }
        }

        if ( class_exists( '\ET\Builder\VisualBuilder\SettingsData\SettingsDataCallbacks' ) ) {
            $candidates[] = \ET\Builder\VisualBuilder\SettingsData\SettingsDataCallbacks::get_current_post_id();
        }

        if ( class_exists( '\ET_Builder_Element' ) ) {
            $candidates[] = \ET_Builder_Element::get_current_post_id();
        }

        if ( class_exists( '\ET_Post_Stack' ) ) {
            $candidates[] = \ET_Post_Stack::get_main_post_id();
        }

        $candidates[] = self::builder_referer_post_id();
        $candidates[] = get_queried_object_id();
        $candidates[] = get_the_ID();

        $ids = array();

        foreach ( $candidates as $post_id ) {
            $post_id = absint( $post_id );

            if ( $post_id ) {
                $ids[] = $post_id;
            }
        }

        return array_values( array_unique( $ids ) );
    }

    /**
     * Post ID from the Visual Builder request referer.
     *
     * Divi 5 preview requests do not carry the edited post the way Divi 4 AJAX does.
     * The referer is the course or the post editor URL.
     *
     * @return int
     */
    private static function builder_referer_post_id() {
        if ( ! wp_doing_ajax() && ! ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
            return 0;
        }

        $referer = wp_get_referer();

        if ( ! $referer ) {
            return 0;
        }

        $query = array();
        $query_string = wp_parse_url( $referer, PHP_URL_QUERY );

        if ( is_string( $query_string ) ) {
            parse_str( $query_string, $query );
        }

        if ( ! empty( $query['et_post_id'] ) ) {
            return absint( $query['et_post_id'] );
        }

        if ( ! empty( $query['post'] ) ) {
            return absint( $query['post'] );
        }

        return absint( url_to_postid( $referer ) );
    }
}
