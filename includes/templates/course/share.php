<?php
global $post;
$disable_course_share   = get_tutor_option('disable_course_share');
$label                  = $args['share_label'];
if ( !$disable_course_share){ ?>
<div class="tutor-single-course-meta tutor-meta-top">
    <ul>
        <?php if( version_compare( tutor()->version, '1.9.1' ) > '1.9.1' ) : ?>
            <li class="tutor-social-share">
                <?php tutor_social_share(); ?>
            </li>
        <?php else : ?>
            <li class="tutor-social-share">
                <?php if( $label == 'on'): ?>
                <span><?php _e('Share:', 'tutor'); ?></span>
                <?php endif; ?>
                <?php tutor_social_share(); ?>
            </li>
        <?php endif;?>
    </ul>
</div>
<?php } ?>

