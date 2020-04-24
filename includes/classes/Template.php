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
    }

    /**
     * Load Single Course Divi Template
     * @param $template
     * @since v.1.0.0
     */
    public function single_course_template($template) {
        global $wp_query;

        if ($wp_query->is_single && !empty($wp_query->query_vars['post_type']) && $wp_query->query_vars['post_type'] === tutor()->course_post_type) {
            
            $is_page_builder_used = et_pb_is_pagebuilder_used(get_the_ID());
            
            if ($is_page_builder_used) {
                $template = dtlms_get_template('single-course');
            }
        }
        return $template;
    }
}

new Template;
