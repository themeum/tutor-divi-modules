<?php
/**
 * Course author template
 */

defined( 'ABSPATH' ) || exit;

$disable_course_author = get_tutor_option( 'disable_course_author' );
$post                  = get_post( $course );
$profile_url           = tutils()->profile_url( $post->post_author, true );
$link                  = $args['link'];
$course                = $args['course'];

if ( ! $disable_course_author ) : ?>

<div class="tutor-single-course-meta tutor-meta-top ">
	<ul>
		<li class="tutor-single-course-author-meta tutor-align-center">
			<?php if ( 'on' === $args['profile_picture'] ) : ?>
			<div class="tutor-single-course-avatar tutor-d-flex">
				<a href="<?php echo esc_url( $profile_url ); ?>" target="<?php echo $link == 'new' ? esc_html( '_blank' ) : ''; ?>" class="tutor-p-0"> 
				<?php
					echo wp_kses(
						tutor_utils()->get_tutor_avatar( get_the_author_meta( 'ID' ) ),
						tutor_utils()->allowed_avatar_tags()
					);
				?>
				</a>
			</div>
			<?php endif; ?>
			<?php if ( 'on' === $args['display_name'] ) : ?>
			<div class="tutor-single-course-author-name">
				<span><?php _e( 'By', 'tutor-lms-divi-modules' ); ?></span>
				<a href="<?php echo esc_url( $profile_url ); ?>" target="<?php echo $link == 'new' ? esc_html( '_blank' ) : ''; ?>"><?php echo get_the_author_meta( 'display_name', $post->post_author ); ?></a>
			</div>
			<?php endif; ?>
		</li>
	</ul>
</div>
<?php endif; ?>
