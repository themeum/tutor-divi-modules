<?php
/**
 * Enrollment editor mode template
 *
 * @package Enrollment Widget
 */

$enrollment_mode = $args['preview_mode'];
$course          = get_post( $args['course'] );
$is_purchasable  = tutor_utils()->is_course_purchasable( $args['course'] );
$is_enable_date  = get_tutor_option( 'enable_course_update_date' );

$tutor_course_sell_by  = apply_filters( 'tutor_course_sell_by', null );

$sidebar_meta = apply_filters(
	'tutor/course/single/sidebar/metadata',
	array(
		array(
			'icon_class' => 'tutor-icon-mortarboard',
			'label'      => __( 'Total Enrolled', 'tutor' ),
			'value'      => tutor_utils()->get_option( 'enable_course_total_enrolled' ) ? tutor_utils()->count_enrolled_users_by_course() : null,
		),
		array(
			'icon_class' => 'tutor-icon-clock-line',
			'label'      => __( 'Duration', 'tutor' ),
			'value'      => get_tutor_option( 'enable_course_duration' ) ? get_tutor_course_duration_context() : null,
		),
		array(
			'icon_class' => 'tutor-icon-refresh-o',
			'label'      => __( 'Last Updated', 'tutor' ),
			'value'      => get_tutor_option( 'enable_course_update_date' ) ? date_i18n( get_option( 'date_format' ), strtotime( get_the_modified_date() ) ) : null,
		),
	),
	$args['course']
);
$button_size  		= '' === $args['button_size'] ? 'medium' : $args['button_size'];
$button_alignment  	= '' === $args['alignment'] ? 'center' : $args['alignment'];
$button_width  		= '' === $args['btn_width'] ? 'fill' : $args['btn_width'];

$login_url = tutor_utils()->get_option( 'enable_tutor_native_login', null, true, true ) ? '' : wp_login_url( tutor()->current_url );
?>
<div class="tutor-card tutor-card-md tutor-sidebar-card dtlms-enroll-btn-width-<?php echo esc_attr( $button_width ); ?> dtlms-enroll-btn-align-<?php echo esc_attr( $button_alignment ); ?> dtlms-enroll-btn-size-<?php echo esc_attr( $button_size ); ?>">
	<!-- Course Entry -->
	<div class="tutor-card-body">
		<?php
		if ( 'enrolled' === $enrollment_mode ) {
			ob_start();

			// Course Info
			$completed_percent   = tutor_utils()->get_course_completed_percent();
			$is_completed_course = tutor_utils()->is_completed_course();
			$retake_course       = tutor_utils()->can_user_retake_course();
			$course_id           = $args['course'];
			$course_progress     = tutor_utils()->get_course_completed_percent( $course_id, 0, true );
			?>

			<?php
			$start_content = '';

			// The user is enrolled anyway. No matter manual, free, purchased, woocommerce, edd, membership
			do_action( 'tutor_course/single/actions_btn_group/before' );

			// Show Start/Continue/Retake Button
			if ( $lesson_url ) {
				$button_class = 'tutor-btn ' .
								( $retake_course ? 'tutor-btn-outline-primary' : 'tutor-btn-primary' ) .
								' tutor-btn-block' .
								( $retake_course ? ' tutor-course-retake-button' : '' );

				// Button identifier class
				$button_identifier = 'start-continue-retake-button';
				$tag               = $retake_course ? 'button' : 'a';
				ob_start();
				?>
					<<?php echo $tag; ?> <?php echo $retake_course ? 'disabled="disabled"' : ''; ?> href="<?php echo esc_url( $lesson_url ); ?>" class="<?php echo esc_attr( $button_class . ' ' . $button_identifier ); ?>" data-course_id="<?php echo esc_attr( $args['course'] ); ?>">
					<?php
					if ( $retake_course ) {
						esc_html_e( 'Retake This Course', 'tutor' );
					} elseif ( $completed_percent <= 0 ) {
						esc_html_e( 'Start Learning', 'tutor' );
					} else {
						esc_html_e( 'Continue Learning', 'tutor' );
					}
					?>
					</<?php echo $tag; ?>>
					<?php
					$start_content = ob_get_clean();
			}
			echo apply_filters( 'tutor_course/single/start/button', $start_content, $args['course'] );

			// Show Course Completion Button.
			
			ob_start();
			?>
				<form method="post" class="tutor-mt-20">
					<?php wp_nonce_field( tutor()->nonce_action, tutor()->nonce ); ?>

					<input type="hidden" value="<?php echo esc_attr( $args['course'] ); ?>" name="course_id"/>
					<input type="hidden" value="tutor_complete_course" name="tutor_action"/>

					<button type="submit" class="tutor-btn tutor-btn-outline-primary tutor-btn-block" name="complete_course_btn" value="complete_course">
						<?php esc_html_e( 'Complete Course', 'tutor' ); ?>
					</button>
				</form>
				<?php echo apply_filters( 'tutor_course/single/complete_form', ob_get_clean() ); ?>
				<?php
					// check if has enrolled date.
					$post_date = is_object( $is_enrolled ) && isset( $is_enrolled->post_date ) ? $is_enrolled->post_date : tutor_get_formated_date( get_option( 'date_format' ), date( 'Y-m-d' ) );
					if ( '' !== $post_date ) :
					?>
					<div class="tutor-fs-7 tutor-color-muted tutor-mt-20 tutor-d-flex dtlms-course-enroll-info-wrapper">
						<span class="tutor-fs-5 tutor-color-success tutor-icon-purchase-mark tutor-mr-8"></span>
						<span class="tutor-enrolled-info-text">
							<?php esc_html_e( 'You enrolled in this course on', 'tutor' ); ?>
							<span class="tutor-fs-7 tutor-fw-bold tutor-color-success tutor-ml-4 tutor-enrolled-info-date">
								<?php
									echo esc_html( tutor_get_formated_date( get_option( 'date_format' ), $post_date ) );
								?>
							</span>
						</span>
					</div>
				<?php endif; ?>
			<?php
			do_action( 'tutor_course/single/actions_btn_group/after' );
			echo apply_filters( 'tutor/course/single/entry-box/is_enrolled', ob_get_clean(), $args['course'] );
		} else {
			// The course enroll options like purchase or free enrolment
			$price = apply_filters( 'get_tutor_course_price', null, $args['course'] );

			if ( tutor_utils()->is_course_fully_booked( null ) ) {
				ob_start();
				?>
					<div class="tutor-alert tutor-warning tutor-mt-28">
						<div class="tutor-alert-text">
							<span class="tutor-icon-circle-info tutor-alert-icon tutor-mr-12" area-hidden="true"></span>
							<span>
								<?php esc_html_e( 'This course is full right now. We limit the number of students to create an optimized and productive group dynamic.', 'tutor' ); ?>
							</span>
						</div>
					</div>
				<?php
				echo apply_filters( 'tutor/course/single/entry-box/fully_booked', ob_get_clean(), $args['course'] );
			} elseif ( $is_purchasable && $price && $tutor_course_sell_by ) {
				// Load template based on monetization option
				$current_course = $args['course'];
				ob_start();
				if ( file_exists( DTLMS_TEMPLATES . 'add-to-cart-' . $tutor_course_sell_by . '.php' ) ) {
					include DTLMS_TEMPLATES . 'add-to-cart-' . $tutor_course_sell_by . '.php';
				} else {
					esc_html_e( $tutor_course_sell_by . ' template not found' );
				}
				
				echo apply_filters( 'tutor/course/single/entry-box/purchasable', ob_get_clean(), $args['course'] );
			} else {
				ob_start();
				?>

					<div class="tutor-course-single-btn-group <?php echo is_user_logged_in() ? '' : 'tutor-course-entry-box-login'; ?>" data-login_url="<?php echo $login_url; ?>">
						<form class="tutor-enrol-course-form" method="post">
							<?php wp_nonce_field( tutor()->nonce_action, tutor()->nonce ); ?>
							<input type="hidden" name="tutor_course_id" value="<?php echo esc_attr( $args['course'] ); ?>">
							<input type="hidden" name="tutor_course_action" value="_tutor_course_enroll_now">
							<button type="submit" class="tutor-btn tutor-btn-primary tutor-btn-lg tutor-btn-block tutor-mt-24 tutor-enroll-course-button">
								<?php esc_html_e( 'Enroll now', 'tutor' ); ?>
							</button>
						</form>
					</div>

					<div class="tutor-fs-7 tutor-color-muted tutor-mt-20 tutor-text-center">
						<?php esc_html_e( 'Free access this course', 'tutor' ); ?>
					</div>
				<?php
				echo apply_filters( 'tutor/course/single/entry-box/free', ob_get_clean(), $args['course'] );
			}
		}

		do_action('tutor_course/single/entry/after', $args['course']);
		?>
	</div>

	<!-- Course Info -->
	<div class="tutor-card-footer">
		<ul class="tutor-ul">
			<?php foreach ( $sidebar_meta as $key => $meta ) : ?>
				<?php
				if ( ! $meta['value'] ) {
					continue;
				}
				?>
				<li class="tutor-d-flex<?php echo $key > 0 ? ' tutor-mt-12' : ''; ?>">
					<span class="<?php echo esc_attr( $meta['icon_class'] ); ?> tutor-color-black tutor-mt-4 tutor-mr-12 dtlms-enrolled-icon" aria-labelledby="<?php echo esc_html( $meta['label'] ); ?>"></span>
					<span class="tutor-fs-6 tutor-color-secondary">
						<?php echo wp_kses_post( $meta['value'] ); ?>
					</span>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>

<?php
if ( ! is_user_logged_in() ) {
	tutor_load_template_from_custom_path( tutor()->path . '/views/modal/login.php' );
}
?>