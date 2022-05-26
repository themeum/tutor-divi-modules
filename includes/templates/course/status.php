<?php
/**
 * Course status template
 */

defined( 'ABSPATH' ) || exit;

do_action( 'tutor_course/single/enrolled/before/lead_info/progress_bar' );
$course_progress = tutor_utils()->get_course_completed_percent( $args['course'], 0, true );
?>
<?php if ( tutor_utils()->get_option( 'enable_course_progress_bar', true, true ) && is_array( $course_progress ) && count( $course_progress ) ) : ?>
	<div class="dtlms-course-progress tutor-course-progress-wrapper tutor-mb-32">
		<span class="dtlms-course-progress-title tutor-color-black tutor-fs-5 tutor-fw-bold tutor-mb-16">
			<?php echo esc_html( $args['course_progress_title'] ); ?>
		</span>
		<div class="list-item-progress">
			<div class="tutor-fs-6 tutor-color-secondary tutor-d-flex tutor-align-center tutor-justify-between">
				<span class="progress-steps">
					<?php echo esc_html( $course_progress['completed_count'] ); ?>/
					<?php echo esc_html( $course_progress['total_count'] ); ?>
				</span>
				<span class="progress-percentage">
					<?php echo esc_html( $course_progress['completed_percent'] . '%' ); ?>
					<?php esc_html_e( 'Complete', 'tutor-lms-divi-modules' ); ?>						
				</span>
			</div>
			<div class="tutor-progress-bar tutor-mt-12" style="--tutor-progress-value: <?php echo esc_attr( $course_progress['completed_percent'] ); ?>%;">
				<span class="tutor-progress-value" area-hidden="true"></span>
			</div>
		</div>
	</div>
<?php endif; ?>
<?php
	do_action( 'tutor_course/single/enrolled/after/lead_info/progress_bar' );
?>
