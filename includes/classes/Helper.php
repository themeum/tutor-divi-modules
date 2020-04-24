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
            'options'           => self::get_courses($default),
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
    public function array_key_first(array $arr) {
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
        return '_'.$course_id;
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
        $arg_course = self::dformat_course_id($args['course']);
        $course_id = self::get_original_course_id($arg_course);

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
        if ($default && $default == 'current') {
            $current = self::format_course_id('current');
            $courses[$current] = esc_html__('This Course', 'tutor-divi-modules');
        }
        $latest = self::format_course_id('latest');
        $courses[$latest] = esc_html__('Latest Course', 'tutor-divi-modules');
        $course_list = get_posts(array(
            'post_type'         => tutor()->course_post_type,
            'post_status'       => 'publish',
            'posts_per_page'    => 10,
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
        $post_id   = et_core_page_resource_get_the_ID();
        $post_id   = $post_id ? $post_id : (int) et_()->array_get($_POST, 'current_page.id');
        $post_type = get_post_type($post_id);

        if ('course' === $post_type || et_theme_builder_is_layout_post_type($post_type)) {
            return 'current';
        }

        return 'latest';
    }

    /**
     * Filters the $outer_wrapper_attrs.
     * Adds 'data-background-layout' and 'data-background-layout-hover' attributes if needed.
     *
     * @since 1.0.0
     *
     * @param array              $outer_wrapper_attrs Key value pairs of outer wrapper attributes.
     * @param ET_Builder_Element $this_class          Module's class.
     *
     * @return array filtered $outer_wrapper_attrs.
     */
    public static function maybe_add_background_layout_data($outer_wrapper_attrs, $this_class) {
        $background_layout               = et_()->array_get($this_class->props, 'background_layout', '');
        $background_layout_hover         = et_pb_hover_options()->get_value('background_layout', $this_class->props, 'light');
        $background_layout_hover_enabled = et_pb_hover_options()->is_enabled('background_layout', $this_class->props);

        if ($background_layout_hover_enabled) {
            $outer_wrapper_attrs['data-background-layout']       = esc_attr($background_layout);
            $outer_wrapper_attrs['data-background-layout-hover'] = esc_attr($background_layout_hover);
        }

        return $outer_wrapper_attrs;
    }

    /**
     * Processes the Background Layout options for Tutor Modules.
     * Adds Background Layout related classes.
     * Adds Filter for $outer_wrapper_attrs, so required data attributes can be added for specific modules.
     *
     * @since 1.0.0
     *
     * @param string             $render_slug Module's render slug.
     * @param ET_Builder_Element $this_class  Module's class.
     *
     * @return void.
     */
    public static function process_background_layout_data($render_slug, $this_class) {
        $background_layout        = et_()->array_get($this_class->props, 'background_layout', '');
        $background_layout_values = et_pb_responsive_options()->get_property_values($this_class->props, 'background_layout');
        $background_layout_tablet = et_()->array_get($background_layout_values, 'tablet', '');
        $background_layout_phone  = et_()->array_get($background_layout_values, 'phone', '');

        $this_class->add_classname("et_pb_bg_layout_{$background_layout}");

        if (!empty($background_layout_tablet)) {
            $this_class->add_classname("et_pb_bg_layout_{$background_layout_tablet}_tablet");
        }

        if (!empty($background_layout_phone)) {
            $this_class->add_classname("et_pb_bg_layout_{$background_layout_phone}_phone");
        }

        add_filter("et_builder_module_{$render_slug}_outer_wrapper_attrs", array('\TutorLMS\Divi\Helper', 'maybe_add_background_layout_data'), 10, 2);
    }
}
