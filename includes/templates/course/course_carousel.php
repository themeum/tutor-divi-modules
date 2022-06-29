<?php
/**
 * Course carousel template
 *
 * @package  DTLMSCourseCarousel
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="<?php tutor_container_classes(); ?> tutor-divi-carousel-main-wrap dtlms-course-carousel-loop-wrap">

<!--loading course init-->
<?php

// available categories.
$available_cat = tutor_divi_course_categories();
// sort be key asc order.
ksort( $available_cat );

// user's selected category.
$category_includes = $args['category_includes'];
$category_includes = explode( '|', $category_includes );

$category_terms = tutor_divi_get_user_selected_terms( $available_cat, $category_includes );

$available_author = tutor_divi_course_authors();
ksort( $available_author );

$author_includes     = $args['author_includes'];
$author_includes     = explode( '|', $author_includes );
$selected_author_ids = tutor_divi_get_user_selected_authors( $available_author, $author_includes );

$order_by = sanitize_text_field( $args['order_by'] );
$order    = sanitize_text_field( $args['order'] );
$limit    = sanitize_text_field( $args['limit'] );

// carousel visibility settings
$skin             = $args['skin'];
$slide_to_show    = $args['slides_to_show'];
$hover_animation  = $args['hover_animation'];
$show_image       = $args['show_image'];
$image_size       = $args['image_size'];
$meta_data        = $args['meta_data'];
$rating           = $args['rating'];
$author           = $args['author'];
$avatar           = $args['avatar'];
$difficulty_label = $args['difficulty_label'];
$wish_list        = $args['wish_list'];
$category         = $args['category'];
$footer           = $args['footer'];
?>
<input type="hidden" id="cart_button_font_icon" value="">
<?php
/*
* query arguements
*/
$query_args = array(
	'post_type'      => tutor()->course_post_type,
	'post_status'    => 'publish',
	'posts_per_page' => $limit,
	'order_by'       => $order_by,
	'order'          => $order,
);

if ( count( $selected_author_ids ) > 0 ) {
	$query_args['author__in'] = $selected_author_ids;
}

if ( count( $category_terms ) > 0 ) {
	   $query_args['tax_query'] = array(
		   'relation' => 'AND',
		   array(
			   'taxonomy' => 'course-category',
			   'field'    => 'term_id',
			   'terms'    => $category_terms,
			   'operator' => 'IN',
		   ),
	   );
}

$the_query = new WP_Query( $query_args );

if ( $the_query->have_posts() ) :
	?>

	<!-- loop start -->
	<?php
	$shortcode_arg = isset( $GLOBALS['tutor_shortcode_arg'] ) ? $GLOBALS['tutor_shortcode_arg']['column_per_row'] : null;
	$course_cols    = $shortcode_arg === null ? tutor_utils()->get_option( 'courses_col_per_row', 4 ) : $shortcode_arg;
	$course_cols    = $slide_to_show;
	$layout        = $skin;
	?>
	<!-- loop start -->
	<div class="tutor-divi-slick-responsive dtlms-carousel-loop-wrap tutor-courses tutor-courses-loop-wrap tutor-courses-layout-<?php echo esc_attr( $course_cols ); ?> dtlms-coursel-<?php echo esc_attr( $skin ); ?> dtlms-carousel-dots-<?php echo esc_attr( $args['dots_alignment'] ); ?>">
		<?php
		while ( $the_query->have_posts() ) :
			$the_query->the_post();
			?>
			<div class="<?php tutor_course_loop_col_classes(); ?>">
				<?php
					$template = trailingslashit( DTLMS_TEMPLATES . 'carousel' ) . $layout . '.php';
				if ( file_exists( $template ) ) {
					tutor_load_template_from_custom_path(
						$template,
						$args,
						false
					);
				} else {
					echo esc_html( $template . ' not exist', 'tutor-lms-divi-modules' );
				}
				?>
			</div>
			<?php
			endwhile;
			wp_reset_postdata();
		?>
	</div>
	<!-- loop end -->
	<?php
		else :
			/**
			 * No course found
			 */
			tutor_load_template( 'course-none' );

		endif;
		do_action( 'tutor_course/archive/after_loop' );
		?>
<!--loading course init-->

<!-- handle elementor settings -->
<?php
// carousel settings.
$slides_to_show   = $args['slides_to_show'];
$arrows           = $args['arrows'];
$dots             = $args['dots'];
$transition       = $args['transition'];
$center_slides    = $args['center_slides'];
$smooth_scrolling = $args['smooth_scrolling'];
$autoplay         = $args['autoplay'];
$autoplay_speed   = $args['autoplay_speed'];
$infinite_loop    = $args['infinite_loop'];
$pause_on_hover   = $args['paush_on_hover'];
?>
<div id="tutor_divi_carousel_settings" slides_to_show="<?php echo esc_attr( $slides_to_show ); ?>" arrows="<?php echo esc_attr( $arrows ); ?>" dots="<?php echo esc_attr( $dots ); ?>" transition="<?php echo esc_attr( $transition ); ?>" center_slides="<?php echo esc_attr( $center_slides ); ?>" smooth_scrolling="<?php echo esc_attr( $smooth_scrolling ); ?>" carousel_autoplay="<?php echo esc_attr( $autoplay ); ?>" autoplay_speed="<?php echo esc_attr( $autoplay_speed ); ?>" infinite_loop="<?php echo esc_attr( $infinite_loop ); ?>" pause_on_hover="<?php echo esc_attr( $pause_on_hover ); ?>">

</div>

</div>
