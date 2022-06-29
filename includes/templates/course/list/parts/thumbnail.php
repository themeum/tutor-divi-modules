<?php
    $image_size = isset( $data['image_size'] ) ? $data['image_size'] : 'medium_large';
    $image_url  = get_tutor_course_thumbnail( $image_size, $url = true );
?>
<div class="tutor-course-thumbnail">
    <a href="<?php the_permalink(); ?>" class="tutor-d-block">
        <div class="tutor-ratio tutor-ratio-<?php echo $data['skin'] == 'overlayed' ? '1x1' : '16x9'; ?>">
            <img class="tutor-card-image-top" src="<?php echo $image_url; ?>" alt="<?php the_title(); ?>" loading="lazy">
        </div>
    </a>
</div>