<?php if ( 'yes' === $settings['course_carousel_footer_settings'] ) : ?>
    <div class="tutor-card-footer">
    <?php
        $monitize_by     = tutor_utils()->get_option( 'monetize_by' );
        $is_purchasable  = tutor_utils()->is_course_purchasable();
        if ( 'edd' === $monitize_by && $is_purchasable ) {
            ob_start();
            tutor_load_template( 'single.course.add-to-cart-edd' );
            echo apply_filters( 'tutor/course/single/entry-box/purchasable', ob_get_clean(), get_the_ID() );
        } else {
            tutor_course_loop_price();
        }
    ?>
</div>
<?php endif; ?>