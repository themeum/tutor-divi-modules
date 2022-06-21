<?php $animation_class  = $settings['card_hover_animation'] ? ' etlms-has-hover-animation' : ''; ?>
<div class="tutor-card tutor-course-card tutor-loop-course-container etlms-course-card-classic<?php echo $animation_class; ?>">
    <?php
        include dtlms_get_template( 'course/carousel/parts/thumbnail' );
        include dtlms_get_template( 'course/carousel/parts/wishlist' );
        include dtlms_get_template( 'course/carousel/parts/level' );
    ?>

    <div class="tutor-card-body">
        <?php
            include dtlms_get_template( 'course/carousel/parts/ratings' );
            include dtlms_get_template( 'course/carousel/parts/title' );
            include dtlms_get_template( 'course/carousel/parts/meta' );
            include dtlms_get_template( 'course/carousel/parts/info' );
        ?>
    </div>

    <?php include dtlms_get_template( 'course/carousel/parts/footer' ); ?>
</div>