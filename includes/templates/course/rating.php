<?php
	$disable = get_tutor_option('disable_course_review');
	if ( ! $disable){
		?>
        <div class="tutor-leadinfo-top-meta tutor-divi-rating-wrapper">
        <span class="tutor-single-course-rating">
            <?php
            $course_rating = tutor_utils()->get_course_rating();
            tutor_utils()->star_rating_generator($course_rating->rating_avg);
            ?>
            <span class="tutor-single-rating-count">
                <?php
                $text = __( 'Ratings', 'tutor-lms-divi-modules' );
                echo $course_rating->rating_avg;
                $count = $course_rating->rating_count." ".$text;
                echo "<i>($count)</i>";

                ?>
            </span>
        </span>
    </div>
<?php } ?>