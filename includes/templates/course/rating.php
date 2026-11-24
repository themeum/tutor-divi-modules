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
	<?php
		$course_rating = tutor_utils()->get_course_rating();
		tutor_utils()->star_rating_generator_v2( $course_rating->rating_avg, $course_rating->rating_count, true );
	?>
</div>
<?php endif; ?>
