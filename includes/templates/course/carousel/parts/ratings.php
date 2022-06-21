<?php if ( 'yes' === $settings['course_carousel_rating_settings'] ) : ?>
<div class="tutor-course-ratings tutor-mb-8">
    <div class="tutor-ratings">
        <div class="tutor-ratings-stars">
            <?php
                $course_rating = tutor_utils()->get_course_rating();
                tutor_utils()->star_rating_generator_course($course_rating->rating_avg);
            ?>
        </div>

        <?php if ($course_rating->rating_avg > 0) : ?>
            <div class="tutor-ratings-average"><?php echo apply_filters('tutor_course_rating_average', $course_rating->rating_avg); ?></div>
            <div class="tutor-ratings-count">(<?php echo $course_rating->rating_count > 0 ? $course_rating->rating_count : 0; ?>)</div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>