<?php
/**
 * Template for displaying course instructors/ instructor
 *
 * @since v.1.0.0
 *
 * @author Themeum
 * @url https://themeum.com
 *
 * @package TutorLMS Divi Module
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'tutor_course/single/enrolled/before/instructors' );
// settings args.
$course_id = isset( $data ) && $data['course_id'] ? $data['course_id'] : $args['course'];
if ( isset( $data['args'] ) ) {
	$args = $data['args'];
}

$label           = $args['course_instructor_label'];
$profile_picture = $args['profile_picture'];
$display_name    = $args['display_name'];
$designation     = $args['designation'];
$tab_target      = $args['course_instructor_link'];
$tab_target      = '_blank' === $tab_target ? $tab_target : '';
$instructors = tutor_utils()->get_instructors_by_course( $course_id );

if ( $instructors && count( $instructors ) ) : ?>
<div class="dtlms-course-instructor-wrapper">
	<div class="tutor-course-details-instructors">
		<h3 class="tutor-fs-6 tutor-fw-medium tutor-color-black tutor-mb-16 dtlms-course-instructor-title">
			<?php echo esc_html( $label ); ?>
		</h3>

		<?php foreach ( $instructors as $key => $instructor ) : ?>
			<div class="tutor-d-flex tutor-align-center<?php echo ( $key != count( $instructors ) - 1 ) ? ' tutor-mb-24' : ''; ?>">
				<?php if ( 'on' === $profile_picture ) : ?>
				<div class="tutor-d-flex instructor-avatar tutor-mr-16">
					<?php echo tutor_utils()->get_tutor_avatar( $instructor->ID, 'md' ); //phpcs:ignore ?>
				</div>
				<?php endif; ?>
				<div>
					<?php if ( 'on' === $display_name ) : ?>
					<a class="tutor-fs-6 tutor-fw-bold tutor-color-black tutor-instructor-name" href="<?php echo esc_url( tutor_utils()->profile_url( $instructor->ID, true ) ); ?>" target="<?php echo esc_attr( $tab_target ); ?>">
						<?php echo esc_html( $instructor->display_name ); ?>
					</a>
					<?php endif; ?>
					<?php if ( ! empty( $instructor->tutor_profile_job_title ) && 'on' === $designation ) : ?>
						<div class="tutor-instructor-designation tutor-fs-7 tutor-color-muted">
							<?php echo esc_html( $instructor->tutor_profile_job_title ); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>
	<?php
endif;

do_action( 'tutor_course/single/enrolled/after/instructors' );
