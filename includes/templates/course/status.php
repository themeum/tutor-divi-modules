<?php
/**
 * Course status template
 */

defined( 'ABSPATH' ) || exit;

do_action( 'tutor_course/single/enrolled/before/lead_info/progress_bar' );
$course_progress = tutor_utils()->get_course_completed_percent( $args['course'], 0, true );

?>

<?php if ( tutor_utils()->get_option( 'enable_course_progress_bar', true, true ) && is_array( $course_progress ) && count( $course_progress ) ) : ?>
	<div class="tutor-course-progress-wrapper tutor-mb-30" style="width: 100%;">
		<span class="tutor-color-text-primary tutor-text-medium-h6">
			<?php echo esc_html( $args['course_progress_title'], 'tutor-lms-divi-modules' ); ?>
		</span>
		<div class="list-item-progress tutor-mt-16">
			<div class="text-regular-body tutor-color-text-subsued tutor-d-flex tutor-align-items-center tutor-justify-content-between">
				<span class="progress-steps">
					<?php echo esc_html( $course_progress['completed_count'] ); ?>/
					<?php echo esc_html( $course_progress['total_count'] ); ?>
				</span>
				<span class="progress-percentage"> 
					<?php echo esc_html( $course_progress['completed_percent'] . '%' ); ?>
					<?php esc_html_e( 'Complete', 'tutor-lms-divi-modules' ); ?>
				</span>
			</div>
			<div class="progress-bar tutor-mt-10" style="--progress-value:<?php echo esc_attr( $course_progress['completed_percent'] ); ?>%;">
				<span class="progress-value"></span>
			</div>
		</div>
	</div>
<?php endif; ?>
<?php
	do_action( 'tutor_course/single/enrolled/after/lead_info/progress_bar' );
?>
