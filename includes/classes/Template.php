<?php
/**
 * TutorLMS Divi Template Hooks
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

class Template {

    public function __construct() {
        add_filter('template_include', [$this, 'single_course_template'], 100);
        add_action('tutor_elementor_single_course_content', [$this, 'single_course_content'], 5);
    }

    /**
     * Load Single Course Elementor Template
     * @param $template
     * @since v.1.0.0
     */
    public function single_course_template($template) {
        global $wp_query, $post;

        if (!post_type_supports(tutor()->course_post_type, 'elementor')) {
            return $template;
        }

        if ($wp_query->is_single && !empty($wp_query->query_vars['post_type']) && $wp_query->query_vars['post_type'] === tutor()->course_post_type) {

            $document = Plugin::$instance->documents->get($post->ID);
            $built_with_elementor = $document && $document->is_built_with_elementor();
            $template_id = $this->template_id;

            /**
             * If not exists any specific template tutor single page or not elementor document, then return default System Template
             * @since v.1.0.0
             */
            if (!$template_id && !$built_with_elementor) {
                return $template;
            }

            $student_must_login_to_view_course = tutor_utils()->get_option('student_must_login_to_view_course');
            if ($student_must_login_to_view_course) {
                if (!is_user_logged_in()) {
                    return tutor_get_template('login');
                }
            }

            $template = etlms_get_template('single-course-fullwidth');
            $template_slug = get_page_template_slug($template_id);
            if ($template_slug === 'elementor_canvas') {
                $template = etlms_get_template('single-course-canvas');
            }

            return $template;
        }
        return $template;
    }

    /**
     * Load Single Course Elementor Content
     * @param $post
     * @since v.1.0.0
     */
    public function single_course_content($post) {
        $document = Plugin::$instance->documents->get($post->ID);

        if ($document && $document->is_built_with_elementor()) {
            echo the_content();
            return;
        }

        $template_id = $this->template_id;
        if ($template_id) {
            echo Plugin::instance()->frontend->get_builder_content_for_display($template_id);
        } else {
            echo '<h1>Mark a page/template as Tutor Single course from Elementor Page Settings</h1>';
        }
    }
}

new Template;
