<?php
/**
 * Template for displaying course benefits
 *
 * @since v.1.0.0
 *
 * @author Themeum
 * @url https://themeum.com
 *
 * @package Tutor Divi Modules
 */

defined( 'ABSPATH' ) || exit;

do_action( 'tutor_course/single/before/benefits' );

/**
 * getting props from settings
 */
$icon            = et_pb_process_font_icon( $args['course_benefits_icon'] );
$course_benefits = tutor_course_benefits( $args['course'] );
if ( empty( $course_benefits ) ) {
	return;
}

if ( is_array( $course_benefits ) && count( $course_benefits ) ) {
	?>

	<div class="tutor-single-course-segment tutor-course-benefits-wrap tutor-mt-32 tutor-mb-12">

		<div class="tutor-segment-title tutor-color-text-primary tutor-text-medium-h6">
			<span>
			<?php echo esc_html( $args['course_benefits_label'] ); ?>
			</span>
		</div>
		<div class="tutor-divi-course-benefits-content">
			<ul class="tutor-course-benefits-items">
				<?php
				foreach ( $course_benefits as $benefit ) {
					echo "<li class='tutor-color-text-primary tutor-text-regular-body tutor-mb-10'> <span class='et-pb-icon'>" . esc_html( $icon ) . "</span> <span class='list-item'>" . esc_html( $benefit ) . '</span> </li>';
				}
				?>
			</ul>
		</div>
	</div>

<?php } ?>

<?php do_action( 'tutor_course/single/after/benefits' ); ?>
