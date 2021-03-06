<?php
/**
 * Course status template
 */

defined( 'ABSPATH' ) || exit;

$completed_count    = tutor_utils()->get_course_completed_percent();
$display_percent    = $args['display_percent'];
do_action('tutor_course/single/enrolled/before/lead_info/progress_bar');
?>

<div class="tutor-course-status">
    <h4 class="tutor-segment-title"><?php _e($args['status_label'], 'tutor-lms-divi-modules'); ?></h4>
    <div class="tutor-progress-bar-wrap">
        <div class="tutor-progress-bar">
            <div class="tutor-progress-filled" style="--tutor-progress-left: <?php esc_html_e( $completed_count.'%;' ); ?>"></div>
        </div>
        <?php if( $display_percent == 'on' ) : ;?>
            <span class="tutor-progress-percent"><?php esc_attr_e( $completed_count ); ?>% <?php _e(' Complete', 'tutor-lms-divi-modules')?></span>
        <?php endif; ?>
    </div>
</div>

<?php
    do_action('tutor_course/single/enrolled/after/lead_info/progress_bar');
?>