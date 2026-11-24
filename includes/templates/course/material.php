<?php
/**
 * Template for displaying course Material Includes assets
 *
 * @since v.1.0.0
 *
 * @author Themeum
 * @url https://themeum.com
 */

defined( 'ABSPATH' ) || exit;

do_action( 'tutor_course/single/before/material_includes' );

$materials = tutor_course_material_includes( $args['course'] );
/**
 * Get icon from setttings.
 */
$icon = et_pb_process_font_icon( $args['icon'] );

if ( empty( $materials ) ) {
	return;
}

if ( is_array( $materials ) && count( $materials ) ) {
	?>

	<div class="tutor-course-details-widget">
		<h3 class="tutor-course-details-widget-title tutor-fs-5 tutor-color-black tutor-fw-bold tutor-mb-16"><?php echo esc_html( $args['label'] ); ?></h3>
		<ul class="tutor-course-details-widget-list tutor-fs-6 tutor-color-black">
			<?php foreach ( $materials as $material ): ?>
				<li class="tutor-d-flex tutor-mb-12 tutor-align-center">
					<?php if ( empty( $icon ) ): ?>
					<span class="tutor-icon-bullet-point et-pb-icon tutor-color-muted tutor-mt-2 tutor-mr-8 tutor-fs-8" area-hidden="true"></span>
					<?php else: ?>
					<span class="et-pb-icon tutor-color-muted tutor-mt-2 tutor-mr-8 tutor-fs-8" area-hidden="true"> <?php echo esc_html( $icon ) ?></span>
					<?php endif; ?>
					<span class="list-item"><?php echo esc_html( $material ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>

<?php } ?>

<?php do_action( 'tutor_course/single/after/material_includes' ); ?>
