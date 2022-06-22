<?php $animation_class  = ''; ?>
<div class="tutor-card tutor-course-card tutor-loop-course-container <?php echo $animation_class; ?>">
    <div class="tutor-row tutor-gx-0">
        <div class="tutor-col-lg-4">
            <?php
                // include dtlms_get_template( 'course/list/grid/parts/thumbnail' );
                // include dtlms_get_template( 'course/list/parts/wishlist' );
                // include dtlms_get_template( 'course/list/parts/level' );

                $header_templates = array(
                    DTLMS_TEMPLATES . 'list/grid/parts/thumbnail.php',
                    DTLMS_TEMPLATES . 'list/parts/wishlist.php',
                    DTLMS_TEMPLATES . 'list/parts/level.php',
                );
                foreach ( $header_templates as $template ) {
                    if ( file_exists( $template ) ) {
                        tutor_load_template_from_custom_path(
                            $template,
                            $data,
                            false
                        );
                    } else {
                        echo esc_html( $template ) . __( 'not found', 'tutor-lms-divi-modules' );
                    }
                }
            ?>
        </div>

        <div class="tutor-col-lg-8 tutor-d-flex tutor-flex-column">
            <div class="tutor-card-body">
                <?php
                    // include dtlms_get_template( 'course/list/parts/ratings' );
                    // include dtlms_get_template( 'course/list/parts/title' );
                    // include dtlms_get_template( 'course/list/parts/meta' );
                    // include dtlms_get_template( 'course/list/parts/info' );

                    $body_templates = array(
                        DTLMS_TEMPLATES . 'list/parts/ratings.php',
                        DTLMS_TEMPLATES . 'list/parts/title.php',
                        DTLMS_TEMPLATES . 'list/parts/meta.php',
                        DTLMS_TEMPLATES . 'list/parts/info.php',
                    );
                    foreach ( $body_templates as $template ) {
                        if ( file_exists( $template ) ) {
                            tutor_load_template_from_custom_path(
                                $template,
                                $data,
                                false
                            );
                        } else {
                            echo esc_html( $template ) . __( 'not found', 'tutor-lms-divi-modules' );
                        }
                    }
                ?>
            </div>

            <?php
            //include dtlms_get_template( 'course/list/parts/footer' );
                $footer_template = DTLMS_TEMPLATES . 'list/parts/footer.php';
                if ( file_exists( $footer_template ) ) {
                    tutor_load_template_from_custom_path(
                        $footer_template,
                        $data,
                        false
                    );
                } else {
                    echo esc_html( $footer_template ) . __( 'not found', 'tutor-lms-divi-modules' );
                }
            ?>
        </div>
    </div>
</div>