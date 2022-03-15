<?php
/**
 * Enrollment editor mode template
 *
 * @package Enrollment Widget
 */
$tutor_course_sell_by = apply_filters( 'tutor_course_sell_by', null );
$enrollment_mode      = $args['preview_mode'];
$course               = get_post( $args['course'] );

$is_enable_date        = get_tutor_option( 'enable_course_update_date' );
$course_progress       = tutor_utils()->get_course_completed_percent( $args['course'], 0, true );
$is_woocommerce_active = ( class_exists( 'woocommerce' ) ) ? true : false;

$sidebar_meta   = apply_filters(
	'tutor/course/single/sidebar/metadata',
	array(
		array(
			'icon_class' => 'tutor-icon-level-line',
			'label'      => __( 'Level', 'tutor-lms-elementor-addons' ),
			'value'      => get_tutor_course_level( $args['course'] ),
		),
		array(
			'icon_class' => 'tutor-icon-student-line-1',
			'label'      => __( 'Total Enrolled', 'tutor-lms-elementor-addons' ),
			'value'      => tutor_utils()->get_option( 'enable_course_total_enrolled' ) ? tutor_utils()->count_enrolled_users_by_course( $args['course'] ) : null,
		),
		array(
			'icon_class' => 'tutor-icon-clock-filled',
			'label'      => __( 'Duration', 'tutor-lms-elementor-addons' ),
			'value'      => get_tutor_option( 'enable_course_duration' ) ? get_tutor_course_duration_context( $args['course'] ) : null,
		),
		array(
			'icon_class' => 'tutor-icon-refresh-l',
			'label'      => __( 'Last Updated', 'tutor-lms-elementor-addons' ),
			'value'      => get_tutor_option( 'enable_course_update_date' ) ? tutor_get_formated_date( get_option( 'date_format' ), get_the_modified_date( '', $course ) ) : null,
		),
	),
	$args['course']
);
$button_size    = $args['button_size'];
$is_purchasable = tutor_utils()->is_course_purchasable( $args['course'] );
$product_id     = tutor_utils()->get_course_product_id( $args['course'] );
$product        = $product_id && function_exists( 'wc_get_product' ) ? wc_get_product( $product_id ) : false;

?>
<div class="tutor-course-sidebar-card">
	<!-- Course Entry -->
	<div class="tutor-course-sidebar-card-body tutor-p-32 <?php echo ! is_user_logged_in() ? 'tutor-course-entry-box-login' : ''; ?>">

		<?php
			$button_class = 'tutor-is-fullwidth tutor-btn tutor-is-outline tutor-btn-lg tutor-btn-full tutor-is-fullwidth tutor-course-retake-button tutor-mb-10';
		?>
			<?php if ( 'enrolled' === $enrollment_mode ) : ?>
				<?php if ( is_array( $course_progress ) && count( $course_progress ) ) : ?>
					<div class="tutor-course-progress-wrapper tutor-mb-30" style="width: 100%;">
						<span class="tutor-color-text-primary text-medium-h6">
							<?php echo esc_html( $args['course_progress_title'] ); ?>
						</span>
						<div class="list-item-progress tutor-mt-16">
							<div class="text-regular-body color-text-subsued tutor-d-flex tutor-align-items-center tutor-justify-content-between">
								<span class="progress-steps">
									5/10
								</span>
								<span class="progress-percentage"> 
									<?php echo esc_html( $course_progress['completed_percent'] . '%' ); ?>
									<?php esc_html_e( 'Complete', 'tutor' ); ?>
								</span>
							</div>
							<div class="progress-bar tutor-mt-12" style="--progress-value:50%;">
								<span class="progress-value"></span>
							</div>
						</div>
					</div>
				<?php endif; ?>					
				<a href="#" class="<?php echo esc_attr( $button_class ); ?> start-continue-retake-button" data-course_id="<?php echo esc_attr( get_the_ID() ); ?>">
					<?php esc_html_e( 'Continue Learning', 'tutor-lms-divi-modules' ); ?>
				</a>
				<button type="submit" class="tutor-mt-25 tutor-btn tutor-btn-tertiary tutor-is-outline tutor-btn-lg tutor-btn-full" name="complete_course_btn" value="complete_course">
					<?php esc_html_e( ' Complete Course', 'tutor-lms-divi-modules' ); ?>                        
				</button>
			<?php else : ?>	
				<!-- if woocommerce load template from divi modules -->
				<?php if ( $is_purchasable && $product ) : ?>
					<?php if ( 'woocommerce' === $tutor_course_sell_by ) : ?>
						<?php
							tutor_load_template_from_custom_path(
								dtlms_get_template( 'course/add-to-cart-woocommerce' ),
								array( 'product_id' => $product_id ),
								false
							);
						?>
					<?php else : ?>
						<?php tutor_load_template( 'single.course.add-to-cart-' . $tutor_course_sell_by ); ?>
					<?php endif; ?>
				<?php else : ?>
					<div class="tutor-course-sidebar-card-pricing tutor-d-flex align-items-end tutor-justify-content-between">
						<div>
							<span class="text-bold-h4 tutor-color-text-primary"><?php esc_html_e( 'Free', 'tutor-lms-elementor-addons' ); ?></span>
						</div>
					</div>
				<?php endif; ?>

				<form>
					<button type="submit" class="tutor-btn tutor-btn-primary tutor-btn-lg tutor-btn-full tutor-mt-24 tutor-enroll-course-button" name="complete_course_btn" value="complete_course">
						<?php esc_html_e( 'Enroll Course', 'tutor-lms-divi-modules' ); ?>
					</button>
				</form>
			<?php endif; ?>

			<?php if ( 'enrolled' === $enrollment_mode ) : ?>
				<div class="etlms-enrolled-info-wrapper text-regular-caption tutor-color-text-hints tutor-mt-12 tutor-d-flex tutor-justify-content-center">
					<span class="tutor-icon-26 tutor-color-success tutor-icon-purchase-filled tutor-mr-6"></span>
					<span class="tutor-enrolled-info-text">
						<span class="text">
						<?php esc_html_e( 'You enrolled this course on', 'tutor-lms-elementor-addons' ); ?>	
						</span>					
						<span class="text-bold-small tutor-color-success tutor-ml-3 tutor-enrolled-info-date">
						<?php esc_html_e( 'January 31, 2022(Dummy date)', 'tutor-lms-elementor-addons' ); ?>					
						</span>
					</span>
				</div>
			<?php endif; ?>
	</div>
	<!-- Course Info -->
	<div class="tutor-course-sidebar-card-footer tutor-p-32">
		<ul class="tutor-course-sidebar-card-meta-list tutor-m-0 tutor-pl-0">
			<?php foreach ( $sidebar_meta as $meta ) : ?>
				<?php
				if ( ! $meta['value'] ) {
					continue;}
				?>
				<li class="tutor-d-flex tutor-align-items-center tutor-justify-content-between">
					<div class="flex-center">
						<span class="tutor-icon-24 <?php echo $meta['icon_class']; ?> tutor-color-text-primary"></span>
						<span class="text-regular-caption tutor-color-text-hints tutor-ml-4">
							<?php echo esc_html( $meta['label'] ); ?>
						</span>
					</div>
					<div>
						<span class="text-medium-caption tutor-color-text-primary">
							<?php echo wp_kses_post( $meta['value'] ); ?>
						</span>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
