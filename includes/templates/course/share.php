<?php
/**
 * Course Share Template
 *
 * @package DTLMSCourseShare
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$tutor_social_share_icons = tutor_utils()->tutor_social_share_icons();
$enable     = tutor_utils()->get_option( 'enable_course_share' );

if ( ! tutor_utils()->count( $tutor_social_share_icons ) || ! $enable ) {
	return;
}
$course_id 	   = $args['course'];
$share_config  = array(
	'title' => get_the_title(),
	'text'  => get_the_excerpt(),
	'image' => get_tutor_course_thumbnail( 'post-thumbnail', true ),
);
$section_title = $args['popup_section_title'];
$share_title   = $args['popup_share_title'];

?>

<div class="dtlms-course-share">
	<a data-tutor-modal-target="tutor-course-share-opener" href="#" class="tutor-btn tutor-btn-ghost dtlms-course-share-btn">
		<?php if ( 'on' === $args['course_share_icon_show'] ) : ?>
			<span class="dtlms-course-share-icon">
				<span class="tutor-icon-share" area-hidden="true"></span>
			</span>
		<?php endif; ?>
		<?php if ( 'on' === $args['course_share_text_show'] ) : ?>
			<span class="dtlms-course-share-label tutor-ml-8">
				<?php esc_html_e( 'Share', 'tutor-lms-divi-modules' ); ?>
			</span>
		<?php endif; ?>
	</a>
</div>

<div id="tutor-course-share-opener" class="tutor-modal dtlms-course-share-modal">
    <span class="tutor-modal-overlay"></span>
    <div class="tutor-modal-window">
        <div class="tutor-modal-content tutor-modal-content-white">
            <button class="tutor-iconic-btn tutor-modal-close-o" data-tutor-modal-close>
                <span class="tutor-icon-times" area-hidden="true"></span>
            </button>
            <div class="tutor-modal-body">
				<?php if ( '' !== $section_title ) : ?>
				<div class="dtlms-course-share-modal-title tutor-fs-5 tutor-fw-medium tutor-color-black tutor-mb-16">
					<?php echo esc_html( $section_title ); ?>
                </div>
				<?php endif; ?>
                <div class="dtlms-course-share-modal-sub-title tutor-fs-7 tutor-color-secondary tutor-mb-12">
                    <?php esc_html_e( 'Page Link', 'tutor-lms-divi-modules' ) ?>
                </div>
                <div class="tutor-mb-32">
                    <input class="tutor-form-control" value="<?php echo get_permalink( $course_id ); ?>" />
                </div>
                <div>
                    <?php if ( '' !== $share_title ) : ?>
						<div class="dtlms-course-share-modal-link tutor-color-black tutor-fs-6 tutor-fw-medium tutor-mb-16">
							<?php echo esc_html( $share_title ); ?>
						</div>
					<?php endif; ?>
                    <div class="tutor-social-share-wrap" data-social-share-config="<?php echo esc_attr( wp_json_encode( $share_config ) ); ?>">
                        <?php foreach ( $tutor_social_share_icons as $icon ) : ?>
							<button class="tutor-social-share-button <?php echo esc_attr( $icon['share_class'] ); ?>" style="background-color: <?php echo esc_attr( $icon['color'] ); ?>">
								<span class="social-icon">
									<?php
									if ( 'on' === $args['show_social_icon'] ) {
										echo $icon['icon_html'];
									}
									?>
								</span>
								<span>
									<?php
									if ( 'on' === $args['show_social_text'] ) {
										echo esc_html( $icon['text'] );
									}
									?>
								</span>
							</button>
						<?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
