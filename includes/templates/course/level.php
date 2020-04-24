<style>
.tutor-single-course-meta.tutor-meta-top ul li {
    width: 100%;
}
</style>
<?php

global $post;
$disable_course_level = get_tutor_option('disable_course_level');

if ( !$disable_course_level){ ?>
<div class="tutor-single-course-meta tutor-meta-top">
    <ul>
        <li class="tutor-course-level">
            <strong><?php _e('Course level:', 'tutor'); ?></strong>
            <?php echo (get_tutor_course_level()) ? get_tutor_course_level() : __('All Levels', 'tutor'); ?>
        </li>
    </ul>
</div>
<?php } ?>