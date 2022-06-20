<?php
/**
 * Display Video
 *
 * @since v.2.0.0
 *
 * @author themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/DiviModules
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$video_info = tutor_utils()->get_video_info( $data['course_id'] );
$poster     = tutor_utils()->avalue_dot( 'poster', $video_info );
$poster_url = $poster ? wp_get_attachment_url( $poster ) : '';

do_action( 'tutor_lesson/single/before/video/external_url' );
?>

<?php if ( $video_info ) : ?>
	<div class="tutor-video-player">
		<input type="hidden" id="tutor_video_tracking_information" value="<?php echo esc_attr( json_encode( $jsonData ?? null ) ); ?>">
		<div class="loading-spinner" area-hidden="true"></div>
		<video poster="<?php echo $poster_url; ?>" class="tutorPlayer" playsinline controls >
			<source src="<?php echo tutor_utils()->array_get( 'source_external_url', $video_info ); ?>" type="<?php echo tutor_utils()->avalue_dot( 'type', $video_info ); ?>">
		</video>
	</div>
<?php endif; ?>

<?php do_action( 'tutor_lesson/single/after/video/external_url' ); ?>
