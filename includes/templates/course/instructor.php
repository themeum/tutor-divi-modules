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

do_action('tutor_course/single/enrolled/before/instructors');
//settings args
$course_id			= $args['course'];
$label				= $args['label'];
$profile_picture	= $args['profile_picture'];
$display_name		= $args['display_name'];
$designation		= $args['designation'];
$link				= $args['link'];

$instructors = tutor_utils()->get_instructors_by_course( $course_id );
if ($instructors){
	$count = is_array($instructors) ? count($instructors) : 0;
?>
	<h4 class="tutor-segment-title"><?php  _e( $label, 'tutor-lms-divi-modules' ); ?></h4>

	<div class="tutor-course-instructors-wrap tutor-single-course-segment" id="single-course-ratings">
		<?php
		foreach ($instructors as $instructor){
		    $profile_url = tutor_utils()->profile_url($instructor->ID);
			?>
			<div class="single-instructor-wrap">
				<div class="single-instructor-top">

					<?php if($profile_picture === 'on'): ?>
					<div class="tutor-instructor-left">
						<div class="instructor-avatar">
							<a href="<?php echo esc_url( $profile_url ) ; ?>" target="<?php esc_attr_e( $link ) ;?>">
								<?php echo wp_kses_post( tutor_utils()->get_tutor_avatar($instructor->ID) ); ?>
							</a>
						</div>
					</div>
					<?php endif;?>

                    <div class="tutor-instructor-right">
						
						<div class="instructor-name">
							<?php if($display_name === 'on'): ?>
								<h3>
									<a href="<?php echo esc_url( $profile_url ); ?>" target="<?php esc_attr_e( $link );?>">
										<?php esc_html_e( $instructor->display_name ) ; ?>
									</a> 
								</h3>
							<?php endif;?>
							<?php
								if( $designation === 'on' ) {
									if ( ! empty($instructor->tutor_profile_job_title)){
										echo "<h4>".esc_html( $instructor->tutor_profile_job_title )."</h4>";
									}
								}
							?>
						</div>
						
						<div class="instructor-bio">
							<?php echo wp_kses_post( $instructor->tutor_profile_bio ); ?>
						</div>
                    </div>

				</div>

                <?php
                $instructor_rating = tutor_utils()->get_instructor_ratings($instructor->ID);
                ?>

				<div class="single-instructor-bottom">
					<div class="ratings">
						<span class="rating-generated">
							<?php wp_kses_post( tutor_utils()->star_rating_generator($instructor_rating->rating_avg ) ); ?>
						</span>

						<?php
						echo " <span class='rating-digits'>".esc_html( $instructor_rating->rating_avg )."</span> ";
						echo " <span class='rating-total-meta'>(".esc_html( $instructor_rating->rating_count )." ".esc_html__('ratings', 'tutor-lms-divi-modules').")</span> ";
						?>
					</div>

					<div class="courses">
						<p>
							<i class='tutor-icon-mortarboard'></i>
							<?php esc_html_e( tutor_utils()->get_course_count_by_instructor($instructor->ID) ); ?> <span class="tutor-text-mute"> <?php _e('Courses', 'tutor-lms-divi-modules'); ?></span>
						</p>
					</div>

					<div class="students">
						<?php
						$total_students = tutor_utils()->get_total_students_by_instructor($instructor->ID);
						?>

						<p>
							<i class='tutor-icon-user'></i>
							<?php esc_html_e( $total_students ); ?>
							<span class="tutor-text-mute">  <?php _e('students', 'tutor-lms-divi-modules'); ?></span>
						</p>
					</div>
				</div>
			</div>
			<?php
		}
		?>
	</div>
	<?php
}

do_action('tutor_course/single/enrolled/after/instructors');
