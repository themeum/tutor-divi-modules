<?php
/**
 * Tabs menu items
 *
 * @package Course Topics
 */
	$course_nav_items = tutor_utils()->course_nav_items();
	add_filter(
		'tutor_default_topics_active_tab',
		function() {
			return 'info';
		}
	);
	?>
<div class="tutor-wrap dtlms-course-curriculum">
		<?php do_action( 'tutor_course/single/before/inner-wrap' ); ?>
		<div class="tutor-default-tab tutor-course-details-tab tutor-tab-has-seemore tutor-mt-30">
			<?php tutor_load_template( 'single.course.enrolled.nav', array( 'course_nav_item' => $course_nav_items ) ); ?>
			<div class="tab-body">
				<?php
				foreach ( $course_nav_items as $key => $subpage ) {
					?>
						<div class="tab-body-item <?php echo esc_attr( 'info' === $key ? 'is-active' : '' ); ?>" id="tutor-course-details-tab-<?php echo esc_attr( $key ); ?>">
						<?php
							$method = $subpage['method'];
						if ( 'info' === $key ) {
							include dtlms_get_template( 'course/benefits' );
							include dtlms_get_template( 'course/instructor' );
						} else {
							if ( is_string( $method ) ) {
								$method();
							} else {
								$_object = $method[0];
								$_method = $method[1];
								$_object->$_method( get_the_ID() );
							}
						}
						?>
						</div>
						<?php
				}
				?>
			</div>
		</div>
		<?php do_action( 'tutor_course/single/after/inner-wrap' ); ?>
</div>

