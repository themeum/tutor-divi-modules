<?php
    $course_duration = get_tutor_course_duration_context();
    $course_students = tutor_utils()->count_enrolled_users_by_course();
?>
<?php if ( 'yes' === $settings['course_carousel_meta_data'] && ( !empty( $course_students ) || !empty( $course_duration ) )) : ?>
<div class="tutor-meta etlms-course-duration-meta tutor-mb-20">
    <?php if( !empty( $course_students ) ) : ?>
        <div>
            <span class="tutor-meta-icon tutor-icon-user-line" area-hidden="true"></span>
            <span class="tutor-meta-value"><?php echo esc_html( $course_students ); ?></span>
        </div>
    <?php endif; ?>

    <?php if( !empty( $course_duration ) ) : ?>
        <div>
            <span class="tutor-icon-clock-line tutor-meta-icon" area-hidden="true"></span>
            <span class="tutor-meta-value"><?php echo tutor_utils()->clean_html_content( $course_duration ); ?></span>
        </div>
    <?php endif; ?>
</div>
<?php endif; ?>