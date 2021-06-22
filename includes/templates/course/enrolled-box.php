<?php
/**
 * Course enrolled box template
 */

defined( 'ABSPATH' ) || exit;

global $wp_query;
$editor_mode = false;
?>
<style>
.tutor-course-enrollment-box {
    margin-bottom: 20px;
}
.tutor-lead-info-btn-group {
    margin: 0 -20px;
    border-bottom: 0px;
}
.tutor-course-enrolled-wrap {
    margin: 0 !important;
}
</style>
<?php
    $start_continue_icon    = et_pb_process_font_icon($args['start_continue_button_icon']);
    $complete_icon          = et_pb_process_font_icon($args['complete_button_icon']);
    $gradebook_icon         = et_pb_process_font_icon($args['gradebook_button_icon']);
?>
<div hidden="">
    <input type="" id="start_continue_button_icon" value="<?php esc_html_e($start_continue_icon);?>">
    <input type="" id="complete_button_icon" value="<?php esc_html_e($complete_icon);?>">
    <input type="" id="gradebook_button_icon" value="<?php esc_html_e($gradebook_icon);?>">
</div>
<div class="tutor-course-enrollment-box">
    <div class="tutor-lead-info-btn-group">
	    <?php do_action('tutor_course/single/actions_btn_group/before'); ?>

        <?php
        if ( $wp_query->query['post_type'] !== 'lesson') {
            $lesson_url = tutor_utils()->get_course_first_lesson();
            $completed_lessons = tutor_utils()->get_completed_lesson_count_by_course();
            if ( $editor_mode || $lesson_url ) { ?>
                <a href="<?php echo $lesson_url; ?>" class="tutor-button tutor-success">
                    <?php
                        if($completed_lessons){
                            _e( 'Continue to lesson', 'tutor' );
                        }else{
                            _e( 'Start Course', 'tutor' );
                        }
                    ?>
                </a>
            <?php }
        }
        ?>
        <?php tutor_course_mark_complete_html(); ?>

        <?php do_action('tutor_course/single/actions_btn_group/after'); ?>
    </div>

    <div class="tutor-single-course-segment  tutor-course-enrolled-wrap">
        <p>
            <i class="tutor-icon-purchase"></i>
            <?php
                $enrolled = tutor_utils()->is_enrolled();
                $enrolled_date = ($editor_mode) ? date('Y-m-d') : $enrolled->post_date;
                echo sprintf(__('You have been enrolled on %s.', 'tutor'),  "<span>". date_i18n(get_option('date_format'), strtotime($enrolled_date)
                    )."</span>"  );
                ?>
        </p>
        <?php do_action('tutor_enrolled_box_after') ?>

    </div>

</div> <!-- tutor-price-preview-box -->

