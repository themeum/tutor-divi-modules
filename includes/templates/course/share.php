<?php
/**
 * Course share template
 */

defined( 'ABSPATH' ) || exit;

global $post;
$disable_course_share   = get_tutor_option('disable_course_share');
$label                  = $args['share_label'];
if ( !$disable_course_share){ ?>
<div class="tutor-single-course-meta tutor-meta-top">
    <ul>
        <li class="tutor-social-share">
            <?php if( $label == 'on'): ?>
            <span><?php _e('Share:', 'tutor'); ?></span>
            <?php endif; ?>
            <?php echo tutor_social_share( $echo = false ); ?>
        </li>
    </ul>
</div>
<?php } ?>

