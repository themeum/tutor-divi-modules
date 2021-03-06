<?php
/**
 * Course about template
 */

defined( 'ABSPATH' ) || exit;

$excerpt = tutor_get_the_excerpt();
$disable_about = get_tutor_option('disable_course_about');
if (!empty($excerpt) && ! $disable_about) {
    ?>
    <div class="tutor-course-summery">
        <h4  class="tutor-segment-title"><?php esc_html_e('About Course', 'tutor-lms-divi-modules') ?></h4>
        <p>
            <?php esc_html_e( $excerpt ); ?>
        </p>
    </div>
    <?php
} ?>