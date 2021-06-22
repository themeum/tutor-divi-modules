<?php
/**
 * Course enrollment template
 */

defined( 'ABSPATH' ) || exit;

$enroll_icon        = et_pb_process_font_icon($args['enrollment_button_icon']);
$add_to_cart_icon   = et_pb_process_font_icon($args['add_to_cart_button_icon']);
?>
<div hidden="">
    <input type="" id="enroll_button_font_icon" value="<?php esc_html_e($enroll_icon);?>">
    <input type="" id="add_to_cart_button_font_icon" value="<?php esc_html_e($add_to_cart_icon);?>">
</div>

<div class="tutor-course-enrollment-box">
    <?php do_action('tutor_course/single/enroll_box/after_thumbnail'); ?>

    <?php tutor_single_course_add_to_cart(); ?>

</div> <!-- tutor-price-preview-box -->
