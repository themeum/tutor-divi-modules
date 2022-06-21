<?php $animation_class  = 'elementor-animation-' . $settings['course_list_card_hover_animation'] . $settings['card_hover_animation'] ? ' dtlms-has-hover-animation' : ''; ?>
<div class="tutor-course-card dtlms-course-card-overlay <?php echo $animation_class; ?>">
    <?php
        include dtlms_get_template( 'course/list/grid/parts/thumbnail' );
    ?>

    <div class="tutor-card tutor-loop-course-container">
        <div class="tutor-card-body">
            <?php
                include dtlms_get_template( 'course/list/parts/ratings' );
                include dtlms_get_template( 'course/list/parts/title' );
                include dtlms_get_template( 'course/list/parts/meta' );
                include dtlms_get_template( 'course/list/parts/info' );
            ?>
        </div>

        <?php include dtlms_get_template( 'course/list/parts/footer' ); ?>
    </div>
</div>