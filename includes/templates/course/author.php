<style>
.tutor-single-course-meta.tutor-meta-top ul li {
    width: 100%;
}
</style>
<?php

global $post;
$disable_course_author = get_tutor_option('disable_course_author');
$profile_url = tutils()->profile_url($post->post_author);

if (!$disable_course_author) { ?>
<div class="tutor-single-course-meta tutor-meta-top">
    <ul>
        <li class="tutor-single-course-author-meta">
            <div class="tutor-single-course-avatar">
                <a href="<?php echo $profile_url; ?>"> <?php echo tutils()->get_tutor_avatar($post->post_author); ?></a>
            </div>
            <div class="tutor-single-course-author-name">
                <span><?php _e('by', 'tutor'); ?></span>
                <a href="<?php echo $profile_url; ?>"><?php echo get_the_author_meta('display_name', $post->post_author); ?></a>
            </div>
        </li>
    </ul>
</div>
<?php } ?>