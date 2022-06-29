<?php if ( 'on' === $data['difficulty_label'] && get_tutor_course_level() ) : ?>
	<span class="tutor-course-difficulty-level">
		<?php echo get_tutor_course_level(); //phpcs:ignore ?>
	</span>
<?php endif; ?>
