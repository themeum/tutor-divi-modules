<?php $animation_class  = 'elementor-animation-' . $settings['course_list_card_hover_animation'] . $settings['card_hover_animation'] ? ' dtlms-has-hover-animation' : ''; ?>
<div class="tutor-card tutor-course-card tutor-loop-course-container dtlms-course-card-classic <?php echo $animation_class; ?>">
    <div class="tutor-row tutor-gx-0">
        <div class="tutor-col-lg-4">
            <?php
                include dtlms_get_template( 'course/list/grid/parts/thumbnail' );
                include dtlms_get_template( 'course/list/parts/wishlist' );
                include dtlms_get_template( 'course/list/parts/level' );
            ?>
        </div>

        <div class="tutor-col-lg-8 tutor-d-flex tutor-flex-column">
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
</div>