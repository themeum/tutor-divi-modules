<style>
.tutor-single-course-meta.tutor-meta-top ul li {
    width: 100%;
}
</style>
<?php

global $post;
$disable_course_share = get_tutor_option('disable_course_share');

if ( !$disable_course_share){ ?>
<div class="tutor-single-course-meta tutor-meta-top">
    <ul>
        <li class="tutor-social-share">
            <span><?php _e('Share:', 'tutor'); ?></span>
            <?php tutor_social_share(); ?>
        </li>
    </ul>
</div>
<?php } ?>