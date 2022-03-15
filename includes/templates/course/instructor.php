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
$course_id       = isset( $data ) && $data['course_id'] ? $data['course_id'] : $args['course'];
if ( isset( $data['args'] ) ) {
	$args = $data['args'];
}

$label           = $args['course_instructor_label'];
$profile_picture = $args['profile_picture'];
$display_name    = $args['display_name'];
$designation     = $args['designation'];
$link            = $args['course_instructor_link'];

$instructors = tutor_utils()->get_instructors_by_course( $course_id );
if ( $instructors ) {
	$count = is_array( $instructors ) ? count( $instructors ) : 0;
	?>
	<div class="tutor-mt-32">
		<div class="tutor-color-text-primary tutor-text-medium-h6 tutor-mb-32">
			<span class="dtlms-course-instructor-title  tutor-segment-title"><?php echo esc_html( $label ); ?></span>
		</div>
		
		<div class="tutor-instructor-info-card tutor-mb-16 etlms-course-instructors-wrap" id="single-course-ratings">
			<?php
			foreach ( $instructors as $instructor ) {
				$profile_url = tutor_utils()->profile_url( $instructor->ID );
				?>
				<div class="single-instructor-wrap tutor-mb-0" style="border: none; margin-bottom: 0px;">
					<div class="single-instructor-top">

						<?php if ( $profile_picture === 'on' ) : ?>
						<div class="tutor-instructor-left">
							<div class="instructor-avatar">
								<a href="<?php echo esc_url( $profile_url ); ?>" target="<?php esc_attr_e( $link ); ?>">
									<?php echo get_avatar( $instructor->ID ); ?>
								</a>
							</div>
						</div>
						<?php endif; ?>

						<div class="tutor-instructor-right tutor-d-flex justify-content-between">
							<div class="instructor-name-designation-wrapper" style="flex: 0 0 30%;">
								<?php if ( $display_name === 'on' ) : ?>
									<h3>
										<a href="<?php echo esc_url( $profile_url ); ?>" target="<?php esc_attr_e( $link ); ?>">
											<?php esc_html_e( $instructor->display_name ); ?>
										</a> 
									</h3>
								<?php endif; ?>
								<?php
								if ( $designation === 'on' ) {
									if ( ! empty( $instructor->tutor_profile_job_title ) ) {
										echo '<p class="tutor-ins-designation tutor-text-regular-caption tutor-color-text-hints tutor-mt-3">' . esc_html( $instructor->tutor_profile_job_title ) . '</p>';
									}
								}
								?>
							</div>
							
							<div class="instructor-bio tutor-ins-summary tutor-text-regular-body text-subsued tutor-mt-18">
								<?php echo esc_textarea( $instructor->tutor_profile_bio ); ?>
							</div>
						</div>

					</div>

					<?php
					$instructor_rating = tutor_utils()->get_instructor_ratings( $instructor->ID );
					?>

					<div class="single-instructor-bottom">
						<div class="ratings tutor-d-flex">
							<span class="rating-generated">
								<?php wp_kses_post( tutor_utils()->star_rating_generator( $instructor_rating->rating_avg ) ); ?>
							</span>

							<?php
							echo " <span class='rating-digits tutor-rating-text tutor-text-regular-body tutor-color-text-subsued'>" . esc_html( $instructor_rating->rating_avg ) . '</span> ';
							echo " <span class='rating-total-meta tutor-rating-text tutor-text-regular-body tutor-color-text-subsued'>(" . esc_html( $instructor_rating->rating_count ) . ' ' . esc_html__( 'ratings', 'tutor-lms-divi-modules' ) . ')</span> ';
							?>
						</div>

						<div class="courses">
							<p>
								<i class='tutor-icon-30 tutor-icon-user-filled'></i>
								<?php esc_html_e( tutor_utils()->get_course_count_by_instructor( $instructor->ID ) ); ?> <span class="text-regular-caption tutor-color-text-subsued"> <?php _e( 'Courses', 'tutor-lms-divi-modules' ); ?></span>
							</p>
						</div>

						<div class="students">
							<?php
							$total_students = tutor_utils()->get_total_students_by_instructor( $instructor->ID );
							?>

							<p>
								<i class='tutor-icon-30 tutor-icon-mortarboard-line'></i>
								<?php esc_html_e( $total_students ); ?>
								<span class="text-regular-caption tutor-color-text-subsued">  <?php _e( 'students', 'tutor-lms-divi-modules' ); ?></span>
							</p>
						</div>
					</div>
				</div>
				<?php
			}
			?>
		</div>
	</div>
	<?php
}

do_action( 'tutor_course/single/enrolled/after/instructors' );
