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
            'label'             => esc_html__('Course', 'tutor-divi-modules'),
            'type'              => 'select',
            'option_category'   => 'configuration',
            'description'       => esc_html__('Here you can select the Course.', 'tutor-divi-modules'),
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
     * Gets the Course by the value stored in the Course attribute.
     *
     * @param string $maybe_course_id The Value stored in the Course attribute using VB.
     *
     * @return false|Course
     */
    public static function get_course($args = array()) {
        $defaults = array(
            'course' => self::format_course_id('current'),
        );

        $args = wp_parse_args($args, $defaults);
        $arg_course     = $args['course'];
        $course_id      = $arg_course;

        $query = new \WP_Query(array(
            'p' => $course_id,
            'post_type' => tutor()->course_post_type
        ));

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                return true;
            }
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
            $courses[$current] = esc_html__('This Course', 'tutor-divi-modules');
        }
        $latest = self::format_course_id('latest');
        $courses[$latest] = esc_html__('Latest Course', 'tutor-divi-modules');
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
        $post_id   = \ET_Builder_Element::get_current_post_id();
        $post_type = get_post_type($post_id);
        if ($post_type === tutor()->course_post_type) {
            $course = 'current';
        }

        return $post_id;
    }
}
