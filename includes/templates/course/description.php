<?php
/**
 * Course description
 */

defined( 'ABSPATH' ) || exit;

do_action('tutor_course/single/before/content');
global $post;
?>

<div class="tutor-single-course-segment tutor-divi-course-description">
    <div class="course-content-title">
        <h4 class="tutor-segment-title"><?php esc_html_e($args['label'], 'tutor-lms-elementor-addons'); ?></h4>
    </div>
    <div class="tutor-course-content-content">
        <?php the_content(); ?>
    </div>
</div>

<?php do_action('tutor_course/single/after/content'); ?>