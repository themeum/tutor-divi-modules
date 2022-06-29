<?php
/**
 * Course list template
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="<?php tutor_container_classes(); ?> tutor-divi-courselist-main-wrap">

<!--loading course init-->
<?php

// available categories
$available_cat = tutor_divi_course_categories();
// sort be key asc order
ksort( $available_cat );

// user's selected category
$category_includes = $args['category_includes'];
$category_includes = explode( '|', $category_includes );

$category_terms = tutor_divi_get_user_selected_terms( $available_cat, $category_includes );

$available_author = tutor_divi_course_authors();
ksort( $available_author );

$author_includes     = $args['author_includes'];
$author_includes     = explode( '|', $author_includes );
$selected_author_ids = tutor_divi_get_user_selected_authors( $available_author, $author_includes );
// sanitizing fields befor push into query

$order_by = sanitize_text_field( $args['order_by'] );
$order    = sanitize_text_field( $args['order'] );
$limit    = sanitize_text_field( $args['limit'] );

// carousel visibility settings
$skin             = $args['skin'];
$columns          = $args['columns'];
$hover_animation  = $args['hover_animation'];
$show_image       = $args['show_image'];
$image_size       = $args['image_size'];
$meta_data        = $args['meta_data'];
$rating           = $args['rating'];
$avatar           = $args['avatar'];
$author           = $args['author'];
$difficulty_label = $args['difficulty_label'];
$wish_list        = $args['wish_list'];
$category         = $args['category'];
$footer           = $args['footer'];
$pagination       = $args['pagination'];
$pagination_type  = $args['pagination_type'];
$prev_text        = isset( $args['prev_level'] ) ? $args['prev_level'] : __( 'Previous', 'tutor-lms-divi-modules' );
$next_text        = isset( $args['next_level'] ) ? $args['next_level'] : __( 'Next', 'tutor-lms-divi-modules' );
//$masonry          = $args['masonry'] === 'on' ? 'tutor-divi-masonry' : 'tutor-courses';

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
	'paged'          => max( 1, esc_html( isset( $_GET['current_page'] ) ? $_GET['current_page'] : 0 ) ),
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
	$layout = ' ' !== $skin ? $skin : 'card';
	$path = $columns > 1 ? 'list' : 'list/grid';
	?>

	<!-- loop start -->
	<div class="dtlms-course-list-loop-wrap tutor-course-list tutor-grid tutor-grid-<?php echo esc_attr( $columns ); ?>">
		<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
			<div class="dtlms-course-list-col">
				<?php
					$template = DTLMS_TEMPLATES . $path . '/' . $layout . '.php';
					if ( file_exists( $template ) ) {
						tutor_load_template_from_custom_path(
							$template,
							$args,
							false
						);
					} else {
						echo esc_html( $template ) . __( ' not exist', 'tutor-lms-divi-modules' );
					}
				?>
			</div>
		<?php endwhile; ?>
	</div>
	<!-- loop end -->

	<!--pagniation start-->
	<!--check if pagniation on-->
	<?php if ( 'on' === $pagination ) : ?>
		<?php
			$big             = 999999999;// unlike int.
			$pagniation_args = array(
				// 'base'      => str_replace( $big, '%#%', esc_url( site_url( 'courses/page/' . $big ) ) ),
				'format'    => '?current_page=%#%',
				'total'     => $the_query->max_num_pages,
				'current'   => max( 1, esc_html( isset( $_GET['current_page'] ) ? $_GET['current_page'] : 0 ) ),
				'end_size'  => sanitize_text_field( $limit ),
				'prev_next' => $pagination_type === 'numbers' ? false : true,
				'prev_text' => __( sanitize_text_field( $prev_text ), 'tutor-lms-divi-modules' ),
				'next_text' => __( sanitize_text_field( $next_text ), 'tutor-lms-divi-modules' ),
			);
			?>
		<div class="tutor-divi-courselist-pagination tutor-mt-32">
			<?php echo paginate_links( $pagniation_args ); ?>
		</div>
	<?php endif; ?>
	<!--pagniation start end-->
	<?php
	wp_reset_postdata();
else :

	/**
	 * No course found
	 */
	tutor_load_template( 'course-none' );

endif;

do_action( 'tutor_course/archive/after_loop' );
?>
<!--loading course init-->

</div>

