<?php
/**
 * Course rating template
 *
 * @package DTlMSCourseRatingTemplate
 */

defined( 'ABSPATH' ) || exit;
$is_enabled_reviews = get_tutor_option( 'enable_course_review' );
if ( $is_enabled_reviews ) :
	?>
<div class="tutor-leadinfo-top-meta dtlms-rating-wrapper">
	<span class="tutor-single-course-rating">
		<?php
		$course_rating = tutor_utils()->get_course_rating();
		tutor_utils()->star_rating_generator( $course_rating->rating_avg );
		?>
		<span class="tutor-single-rating-count">
		<?php
			$text = __( 'Ratings', 'tutor-lms-divi-modules' );
			echo esc_html( $course_rating->rating_avg );
			$count = $course_rating->rating_count . ' ' . $text;
			echo '(' . esc_html( $count ) . ')';
		?>
		</span>
	</span>
</div>
<?php endif; ?>
