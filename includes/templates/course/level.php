<?php
/**
 * Course level template
 */

defined( 'ABSPATH' ) || exit;

global $post;
$disable_course_level = get_tutor_option('disable_course_level');

if ( !$disable_course_level){ ?>
<div class="tutor-single-course-meta tutor-meta-top">
    <ul>
        <li class="tutor-course-level">
            <label><?php _e('Course level:', 'tutor-lms-divi-modules'); ?></label>
            <span>
                <?php echo (get_tutor_course_level()) ? esc_html( get_tutor_course_level() ) : esc_html__('All Levels', 'tutor-lms-divi-modules'); ?>
            </span>
        </li>
    </ul>
</div>
<?php } ?>