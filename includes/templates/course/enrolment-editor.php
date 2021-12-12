<?php
/**
 * Enrollment editor mode template
 *
 * @package Enrollment Widget
 */

$tutor_course_sell_by = apply_filters( 'tutor_course_sell_by', null );
$enrollment_mode      = $args['preview_mode'];
$course               = get_post( $args['course'] );
$is_enable_date       = get_tutor_option( 'enable_course_update_date' );
$sidebar_meta         = apply_filters(
	'tutor/course/single/sidebar/metadata',
	array(
		array(
			'icon_class' => 'ttr-level-line',
			'label'      => __( 'Level', 'tutor-lms-divi-modules' ),
			'value'      => get_tutor_course_level( $course->ID ),
		),
		array(
			'icon_class' => 'ttr-student-line-1',
			'label'      => __( 'Total Enrolled', 'tutor-lms-divi-modules' ),
			'value'      => tutor_utils()->get_option( 'enable_course_total_enrolled' ) ? tutor_utils()->count_enrolled_users_by_course( $course->ID ) : null,
		),
		array(
			'icon_class' => 'ttr-clock-filled',
			'label'      => __( 'Duration', 'tutor-lms-divi-modules' ),
			'value'      => get_tutor_option( 'enable_course_duration' ) ? get_tutor_course_duration_context( $course->ID ) : '',
		),
		array(
			'icon_class' => 'ttr-refresh-l',
			'label'      => __( 'Last Updated', 'tutor-lms-divi-modules' ),
			'value'      => $is_enable_date && isset( $course->post_modified ) && '' !== $course->post_modified ? tutor_get_formated_date( get_option( 'date_format' ), $course->post_modified ) : '',
		),
	),
	get_the_ID()
);
$button_size          = $args['button_size'];
$product_id           = tutor_utils()->get_course_product_id( $args['course'] );
$product              = wc_get_product( $product_id );
?>
<div class="tutor-course-sidebar-card">
	<!-- Course Entry -->
	<div class="tutor-course-sidebar-card-body tutor-p-30 <?php echo ! is_user_logged_in() ? 'tutor-course-entry-box-login' : ''; ?>">

		<?php
			$button_class = 'tutor-is-fullwidth tutor-btn tutor-is-outline tutor-btn-lg tutor-btn-full tutor-is-fullwidth tutor-course-retake-button tutor-mb-10';
		?>
			<?php if ( 'enrolled' === $enrollment_mode ) : ?>
			<a href="#" class="<?php echo esc_attr( $button_class ); ?> start-continue-retake-button" data-course_id="<?php echo esc_attr( get_the_ID() ); ?>">
				<?php esc_html_e( 'Continue Learning', 'tutor-lms-divi-modules' ); ?>
			</a>
			<button type="submit" class="tutor-mt-25 tutor-btn tutor-btn-tertiary tutor-is-outline tutor-btn-lg tutor-btn-full" name="complete_course_btn" value="complete_course">
				<?php esc_html_e( ' Complete Course', 'tutor-lms-divi-modules' ); ?>                        
			</button>
			<?php else : ?>
				<div>
					<?php tutor_load_template( 'single.course.add-to-cart-' . $tutor_course_sell_by ); ?>
				</div>

				<button type="submit" class="tutor-btn tutor-btn-primary tutor-btn-lg tutor-btn-full tutor-mt-24 tutor-enroll-course-button" name="complete_course_btn" value="complete_course">
					<?php esc_html_e( 'Enroll Course', 'tutor-lms-divi-modules' ); ?>
				</button>
				<button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>"  class="tutor-btn tutor-btn-icon tutor-btn-primary tutor-btn-lg tutor-btn-full tutor-mt-24 tutor-add-to-cart-button">
					<span class="btn-icon ttr-cart-filled"></span>
					<span><?php echo esc_html( $product->single_add_to_cart_text() ); ?></span>
				</button>
			<?php endif; ?>
	</div>
	<!-- Course Info -->
	<?php if ( 'enrolled' === $enrollment_mode ) : ?>
	<div class="tutor-course-sidebar-card-footer tutor-p-30">
		<ul class="tutor-course-sidebar-card-meta-list tutor-m-0 tutor-pl-0">
			<?php foreach ( $sidebar_meta as $meta ) : ?>
				<?php
				if ( ! $meta['value'] ) {
					continue;}
				?>
				<li class="tutor-bs-d-flex tutor-bs-align-items-center tutor-bs-justify-content-between">
					<div class="flex-center">
						<span class="tutor-icon-24 <?php echo $meta['icon_class']; ?> color-text-primary"></span>
						<span class="text-regular-caption color-text-hints tutor-ml-5">
							<?php echo esc_html( $meta['label'] ); ?>
						</span>
					</div>
					<div>
						<span class="text-medium-caption color-text-primary">
							<?php echo wp_kses_post( $meta['value'] ); ?>
						</span>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>	
	<?php endif; ?>
</div>
