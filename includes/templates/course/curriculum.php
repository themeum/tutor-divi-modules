<?php
/**
 * Template for displaying single course
 *
 * @since v.1.0.0
 *
 * @author Themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

if ( ! defined( 'ABSPATH' ) )
	exit;

$topics         = tutor_utils()->get_topics( $args['course'] );
$course_id      = $args['course'];
$is_enrolled    = tutor_utils()->is_enrolled($course_id);

//icons props
$collaps_icon 		= et_pb_process_font_icon($args['collaps_icon']); 
$expand_icon 		= et_pb_process_font_icon($args['expand_icon']); 

?>
<input type="hidden" id="tutor_divi_col_icon"  value="<?php echo esc_html($collaps_icon);?>">
<input type="hidden" id="tutor_divi_exp_icon"  value="<?php echo esc_html($expand_icon);?>">
<div class="tutor-wrap">
<?php 

	global $wp_query;
	if (is_user_logged_in()) {

		$is_administrator = current_user_can('administrator');
		$is_instructor = tutor_utils()->is_instructor_of_this_course();
		$course_content_access = (bool) get_tutor_option('course_content_access_for_ia');
		if (tutils()->is_enrolled() || ($course_content_access && ($is_administrator || $is_instructor))) {
			//tutor_course_enrolled_nav();

			if (!empty($wp_query->query_vars['course_subpage'])) {
				$course_subpage = $wp_query->query_vars['course_subpage'];
				if ($course_subpage == 'questions') {
					tutor_course_question_and_answer();
				} else if ($course_subpage == 'announcements') {
					tutor_course_announcements();
				}
				do_action("tutor_course/single/enrolled/{$course_subpage}", get_the_ID());
			}

			do_action('tutor_course/single/enrolled/after/inner-wrap');
		}
	} 
?>
</div>

<?php do_action('tutor_course/single/before/topics'); ?>

<?php 
if (empty($wp_query->query_vars['course_subpage'])) {
if($topics->have_posts()) { ?>
    <div class="tutor-single-course-segment  tutor-course-topics-wrap">

        <div class="tutor-course-topics-header">
            <div class="tutor-course-topics-header-left">
                <h4 class="tutor-segment-title"><?php _e( $args['label'], 'tutor-lms-divi-modules'); ?></h4>
            </div>
            <div class="tutor-course-topics-header-right">
				<?php
				$tutor_lesson_count = tutor_utils()->get_lesson_count_by_course($course_id);
				$tutor_course_duration = get_tutor_course_duration_context($course_id);

				if($tutor_lesson_count) {
					echo "<span> ".esc_html( $tutor_lesson_count )." ";
					_e(' Lessons', 'tutor-lms-divi-modules');
					echo "</span>";
				}
				if($tutor_course_duration){
					echo "<span>".esc_html( $tutor_course_duration )."</span>";
				}
				?>
            </div>
        </div>
        <div class="tutor-course-topics-contents">
			<?php

			$index = 0;

			if ($topics->have_posts()){
				while ($topics->have_posts()){ $topics->the_post();
					$topic_summery = get_the_content();
					$index++;
					?>

                    <div class="tutor-divi-course-topic tutor-topics-in-single-lesson <?php if($index == 1) esc_attr_e( "tutor-active" ); ?>">
                        <div class="tutor-course-title <?php echo $topic_summery ? esc_attr( 'has-summery' ) : ''; ?>">
							
								<span class="et-pb-icon" id="tutor_divi_topic_icon"><?php esc_html_e( $collaps_icon );?></span>
							
                            <h4> 
							
								<?php
								the_title();
								?>
							</h4>
                        </div>

						<?php
						if ($topic_summery){
							?>
							<div class="tutor-topics-summery">
								<?php esc_html_e( $topic_summery ) ; ?>
							</div>
							<?php
						}
						?>
			
                        <div class="tutor-course-lessons" style="<?php echo $index > 1 ? esc_attr( 'display: none' ) : ''; ?>">

							<?php
							$lessons = tutor_utils()->get_course_contents_by_topic(get_the_ID(), -1);

							if ($lessons->have_posts()){
								while ($lessons->have_posts()){ $lessons->the_post();
									global $post;

									$video = tutor_utils()->get_video_info();
								
									$play_time = false;
									if ($video){
										$play_time = $video->playtime;
									}

									$lesson_icon = $play_time ? 'tutor-icon-youtube' : 'tutor-icon-document-alt';

									if ($post->post_type === 'tutor_quiz'){
										$lesson_icon = 'tutor-icon-doubt';
									}
									if ($post->post_type === 'tutor_assignments'){
										$lesson_icon = 'tutor-icon-clipboard';
									}
									?>

                                    <div class="tutor-course-lesson">
                                        <h5>
											<?php
											$lesson_title = '';
											if (has_post_thumbnail()){
												$thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
												$lesson_title .= "<i style='background:url({$thumbnail_url})' class='tutor-lesson-thumbnail-icon $lesson_icon'></i>";
											}else{
												$lesson_title .= "<i class='$lesson_icon'></i>";
											}

											$countdown = '';
											if ($post->post_type === 'tutor_zoom_meeting'){
												$lesson_title = '<i class="zoom-icon"><img src="'.TUTOR_ZOOM()->url . 'assets/images/zoom-icon-grey.svg"></i>';
												
												$zoom_meeting = tutor_zoom_meeting_data($post->ID);
												$countdown = '<div class="tutor-zoom-lesson-countdown tutor-lesson-duration" data-timer="'.$zoom_meeting->countdown_date.'" data-timezone="'.$zoom_meeting->timezone.'"></div>';
											}

											
											// Show clickable content if enrolled
											// Or if it is public and not paid, then show content forcefully
											if ($is_enrolled || (get_post_meta($course_id, '_tutor_is_public_course', true)=='yes' && !tutor_utils()->is_course_purchasable($course_id))){
												$lesson_title .= "<a href='".get_the_permalink()."'> ".get_the_title()." </a>";

												$lesson_title .= $play_time ? "<span class='tutor-lesson-duration'>".tutor_utils()->get_optimized_duration($play_time)."</span>" : '';

												if ($countdown) {
													if ($zoom_meeting->is_expired) {
														$lesson_title .= '<span class="tutor-zoom-label">'.__('Expired', 'tutor-lms-divi-modules').'</span>';
													} else if ($zoom_meeting->is_started) {
														$lesson_title .= '<span class="tutor-zoom-label tutor-zoom-live-label">'.__('Live', 'tutor-lms-divi-modules').'</span>';
													}
													$lesson_title .= $countdown;
												}

												echo wp_kses_post( $lesson_title );
											}else{
												$lesson_title .= get_the_title();
												$lesson_title .= $play_time ? "<span class='tutor-lesson-duration'>".tutor_utils()->get_optimized_duration($play_time)."</span>" : '';
												echo apply_filters('tutor_course/contents/lesson/title', wp_kses_post($lesson_title), get_the_ID());
											}

											?>
                                        </h5>
                                    </div>

									<?php
								}
								$lessons->reset_postdata();
							}
							?>
                        </div>
                    </div>
					<?php
				}
				$topics->reset_postdata();
			}
			?>
        </div>
    </div>
<?php } } ?>

<?php do_action('tutor_course/single/after/topics'); ?>
