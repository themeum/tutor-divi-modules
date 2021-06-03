<?php
/**
 * Template for displaying course benefits
 *
 * @since v.1.0.0
 *
 * @author Themeum
 * @url https://themeum.com
 *
 *
 * @package Tutor Divi Modules
 */

do_action('tutor_course/single/before/benefits');

/**
 * getting props from settings
 */

$icon = et_pb_process_font_icon( $args[ 'icon' ] );
$course_benefits = tutor_course_benefits( $args['course'] );
if ( empty($course_benefits)){
	return;
}

if (is_array($course_benefits) && count($course_benefits)){
	?>

	<div class="tutor-single-course-segment tutor-course-benefits-wrap">

		<h4 class="tutor-segment-title"><?php esc_html_e( $args['label'] ); ?></h4>
		<div class="tutor-course-benefits-content">
			<ul class="tutor-course-benefits-items">
				<?php
				foreach ($course_benefits as $benefit){
					echo "<li> <span class='et-pb-icon'>".esc_html( $icon )."</span> <span class='list-item'>{$benefit}</span> </li>";
				}
				?>
			</ul>
		</div>
	</div>

<?php } ?>

<?php do_action('tutor_course/single/after/benefits'); ?>