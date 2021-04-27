<?php
/**
 * Template for displaying course Material Includes assets
 *
 * @since v.1.0.0
 *
 * @author Themeum
 * @url https://themeum.com
 */


do_action('tutor_course/single/before/material_includes');

$materials = tutor_course_material_includes();
/**
 * get icon from setttings
 */
$icon = et_pb_process_font_icon( $args[ 'icon' ] );

if ( empty($materials)){
	return;
}

if (is_array($materials) && count($materials)){
	?>

	<div class="tutor-single-course-segment  tutor-course-material-includes-wrap">
        <h4 class="tutor-segment-title"><?php esc_html_e( $args['label'] ); ?></h4>
		<div class="tutor-course-target-audience-content">
			<ul class="tutor-course-target-audience-items">
				<?php
				foreach ($materials as $material){
					echo "<li> <span class='et-pb-icon'> ".esc_html($icon)." </span> <span class='list-item'> {$material} </span> </li>";
				}
				?>
			</ul>
		</div>
	</div>

<?php } ?>

<?php do_action('tutor_course/single/after/material_includes'); ?>

