<?php
/**
 * Template for displaying course requirements
 *
 * @since v.1.0.0
 *
 * @author Themeum
 * @url https://themeum.com
 *
 * @package Tutor Divi Modules
 */


do_action('tutor_course/single/before/requirements');

$course_requirements = tutor_course_requirements( $args['course'] );
$icon = et_pb_process_font_icon( $args[ 'icon' ] );
if ( empty($course_requirements)){
	return;
}

if (is_array($course_requirements) && count($course_requirements)){
	?>

	<div class="tutor-single-course-segment  tutor-course-requirements-wrap">
	
		<h4 class="tutor-segment-title">
			<?php esc_html_e( $args['label'] );?>
		</h4>
		<div class="tutor-course-requirements-content">
			<ul class="tutor-course-requirements-items tutor-custom-list-style">
				<?php
				foreach ($course_requirements as $requirement){
					echo "<li> <span class='et-pb-icon'> ".esc_html($icon)." </span> <span class='list-item'> {$requirement} </span> </li>";
				}
				?>
			</ul>
		</div>

	</div>

<?php } ?>

<?php do_action('tutor_course/single/after/requirements'); ?>