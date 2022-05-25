<?php
/**
 * Enrollment editor mode template
 *
 * @package Enrollment Widget
 */

$enrollment_mode       = $args['preview_mode'];
$course_id             = $args['course'];
$is_enrolled           = apply_filters( 'tutor_alter_enroll_status', tutor_utils()->is_enrolled() );
$lesson_url            = tutor_utils()->get_course_first_lesson();
$is_administrator      = tutor_utils()->has_user_role( 'administrator' );
$is_instructor         = tutor_utils()->is_instructor_of_this_course();
$course_content_access = (bool) get_tutor_option( 'course_content_access_for_ia' );
$is_privileged_user    = $course_content_access && ( $is_administrator || $is_instructor );
$tutor_course_sell_by  = apply_filters( 'tutor_course_sell_by', null );
$is_public             = get_post_meta( $course_id, '_tutor_is_public_course', true ) == 'yes';

// Monetization info.
$monetize_by              = tutor_utils()->get_option( 'monetize_by' );
$is_purchasable           = tutor_utils()->is_course_purchasable( $course_id );

// Get login url if.
$is_tutor_login_disabled = ! tutor_utils()->get_option( 'enable_tutor_native_login', null, true, true );
$auth_url                = $is_tutor_login_disabled ? ( isset( $_SERVER['REQUEST_SCHEME'] ) ? wp_login_url( $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ) : '' ) : '';
$default_meta = array(
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
);

// Add level if enabled
if( tutor_utils()->get_option( 'enable_course_level', true, true ) ) {
	array_unshift( $default_meta, array(
		'icon_class' => 'tutor-icon-level',
		'label'      => __( 'Level', 'tutor' ),
		'value'      => get_tutor_course_level( $course_id ),
	) );
}

// Right sidebar meta data
$sidebar_meta = apply_filters('tutor/course/single/sidebar/metadata', $default_meta, $course_id );
$login_url = tutor_utils()->get_option( 'enable_tutor_native_login', null, true, true ) ? '' : wp_login_url( tutor()->current_url );

?>

<div class="tutor-card tutor-card-md tutor-sidebar-card">
	<!-- Course Entry -->
	<div class="tutor-card-body">
		<?php
		if ( 'enrolled' === $enrollment_mode ) {
			// Course Info
			$completed_percent   = tutor_utils()->get_course_completed_percent( $args['course'] );
			$is_completed_course = tutor_utils()->is_completed_course( $args['course'] );
			$retake_course       = tutor_utils()->can_user_retake_course();
			$course_id           = $args['course'];
			$course_progress     = tutor_utils()->get_course_completed_percent( $course_id, 0, true );
			?>
			<!-- course progress -->
			<?php if ( tutor_utils()->get_option( 'enable_course_progress_bar', true, true ) && is_array( $course_progress ) && count( $course_progress ) ) : ?>
				<div class="tutor-course-progress-wrapper tutor-mb-32">
					<h3 class="tutor-color-black tutor-fs-5 tutor-fw-bold tutor-mb-16 dtlms-course-progress">
						<?php echo esc_html( $args['course_progress_title'] ); ?>
					</h3>
					<div class="list-item-progress">
						<div class="tutor-fs-6 tutor-color-secondary tutor-d-flex tutor-align-items-center tutor-justify-between">
							<span class="progress-steps">
								5/10
							</span>
							<span class="progress-percentage">
								50%
								<?php esc_html_e( 'Complete', 'tutor' ); ?>
							</span>
						</div>
						<div class="tutor-progress-bar tutor-mt-12" style="--tutor-progress-value:50%;">
							<span class="tutor-progress-value" area-hidden="true"></span>
						</div>
					</div>
				</div>
			<?php endif; ?>
			<?php
			$start_content = '';

			// The user is enrolled anyway. No matter manual, free, purchased, woocommerce, edd, membership
			do_action( 'tutor_course/single/actions_btn_group/before' );

			// Show Start/Continue/Retake Button
			$button_class = 'tutor-btn ' .
							( $retake_course ? 'tutor-btn-outline-primary' : 'tutor-btn-primary' ) .
							' tutor-btn-block' .
							( $retake_course ? ' tutor-course-retake-button' : '' );

			// Button identifier class
			$button_identifier = 'start-continue-retake-button';
			$tag               = $retake_course ? 'button' : 'a';
			ob_start();
			?>
			<a href="#" class="<?php echo esc_attr( $button_class ); ?> start-continue-retake-button" data-course_id="<?php echo esc_attr( $course_id ); ?>">
					<?php esc_html_e( 'Start Learning', 'tutor-lms-divi-modules' ); ?>
			</a>

			<a href="#" class="tutor-btn tutor-btn-primary tutor-btn-block tutor-mt-20 tutor-btn-view-certificate">
				<?php _e('View Certificate', 'tutor-lms-divi-modules'); ?>
			</a>
			<?php
			echo apply_filters( 'tutor_course/single/start/button', $start_content, $course_id );

			// Show Course Completion Button.
			ob_start();
			?>
			<form method="post" class="tutor-mt-20">
				<?php wp_nonce_field( tutor()->nonce_action, tutor()->nonce ); ?>

				<input type="hidden" value="<?php echo esc_attr( $course_id ); ?>" name="course_id"/>
				<input type="hidden" value="tutor_complete_course" name="tutor_action"/>

				<button type="submit" class="tutor-btn tutor-btn-outline-primary tutor-btn-block" name="complete_course_btn" value="complete_course">
					<?php esc_html_e( 'Complete Course', 'tutor' ); ?>
				</button>
			</form>
			<?php
			echo apply_filters( 'tutor_course/single/complete_form', ob_get_clean() );
			?>
				<?php
					// check if has enrolled date.
					$post_date = is_object( $is_enrolled ) && isset( $is_enrolled->post_date ) ? $is_enrolled->post_date : tutor_get_formated_date( get_option( 'date_format' ), date( 'Y-m-d' ) );
					if ( '' !== $post_date ) :
					?>
					<div class="tutor-fs-7 tutor-color-muted tutor-mt-20 tutor-d-flex dtlms-enrolled-info-wrapper">
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
			echo apply_filters( 'tutor/course/single/entry-box/is_enrolled', ob_get_clean(), $course_id );
		} else {
			// The course enroll options like purchase or free enrolment
			$price = apply_filters( 'get_tutor_course_price', null, $course_id );
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
				echo apply_filters( 'tutor/course/single/entry-box/fully_booked', ob_get_clean(), $course_id );
			} elseif ( $is_purchasable && $price && $tutor_course_sell_by ) {
				// Load template based on monetization option
				ob_start();
				$template = DTLMS_TEMPLATES . 'price/add-to-cart-' . $tutor_course_sell_by . '.php';
				if ( file_exists( $template ) ) {
					include DTLMS_TEMPLATES . 'price/add-to-cart-' . $tutor_course_sell_by . '.php';
				}
				echo apply_filters( 'tutor/course/single/entry-box/purchasable', ob_get_clean(), $course_id );
			} else {
				ob_start();
				?>
					<div class="tutor-course-single-pricing">
						<span class="tutor-fs-4 tutor-fw-bold tutor-color-black">
							<?php esc_html_e( 'Free', 'tutor' ); ?>
						</span>
					</div>

					<div class="tutor-course-single-btn-group <?php echo is_user_logged_in() ? '' : 'tutor-course-entry-box-login'; ?>" data-login_url="<?php echo $login_url; ?>">
						<form class="tutor-enrol-course-form" method="post">
							<?php wp_nonce_field( tutor()->nonce_action, tutor()->nonce ); ?>
							<input type="hidden" name="tutor_course_id" value="<?php echo esc_attr( $course_id ); ?>">
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
				echo apply_filters( 'tutor/course/single/entry-box/free', ob_get_clean(), $course_id );
			}
		}

		do_action('tutor_course/single/entry/after', $course_id);
		?>
	</div>

	<!-- Course Info -->
	<?php if ( 'on' === $args['course_purchase_enrolment_box']) : ?>
	<div class="tutor-card-footer">
		<ul class="tutor-ul">
			<?php foreach ( $sidebar_meta as $key => $meta ) : ?>
				<?php
				if ( ! $meta['value'] ) {
					continue;
				}
				?>
				<li class="tutor-row tutor-align-items-center<?php echo $key > 0 ? ' tutor-mt-12' : ''; ?>">
					<div class="tutor-col-6">
						<span class="<?php echo esc_attr( $meta['icon_class'] ); ?> tutor-color-black dtlms-enrolled-icon"></span>
						<span class="tutor-fs-7 tutor-color-muted tutor-ml-8 dtlms-enrollment-meta-label">
							<?php echo esc_html( $meta['label'] ); ?>
						</span>
					</div>
					<div class="tutor-col-6">
						<span class="tutor-fs-7 tutor-fw-medium tutor-color-black dtlms-enrollment-meta-value">
							<?php echo wp_kses_post( $meta['value'] ); ?>
						</span>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php endif; ?>
</div>

<?php
if ( ! is_user_logged_in() ) {
	tutor_load_template_from_custom_path( tutor()->path . '/views/modal/login.php' );
}
?>
