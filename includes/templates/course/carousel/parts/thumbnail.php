<?php if ( 'yes' == $settings['course_carousel_image'] ) : ?>
    <?php
        $image_size = isset( $settings['course_carousel_image_size'] ) ? $settings['course_carousel_image_size'] : 'medium_large';
        $image_url  = get_tutor_course_thumbnail( $image_size, $url = true );
    ?>
    <div class="tutor-course-thumbnail">
        <a href="<?php the_permalink(); ?>" class="tutor-d-block">
            <div class="tutor-ratio tutor-ratio-<?php echo esc_attr( isset( $settings['course_list_skin'] ) && 'overlayed' === $settings['course_list_skin'] ? '1x1' : '16x9' ); ?>">
                <img class="tutor-card-image-top" src="<?php echo esc_url( $image_url ); ?>" alt="<?php the_title(); ?>" loading="lazy">
            </div>
        </a>
    </div>
<?php endif; ?>