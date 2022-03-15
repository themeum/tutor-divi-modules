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
$masonry          = $args['masonry'] === 'on' ? 'tutor-divi-masonry' : 'tutor-courses';
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
	?>

	<!-- loop start -->

	<div class=" tutor-divi-courselist-loop-wrap <?php esc_attr_e( $masonry ); ?> tutor-courses-loop-wrap tutor-courses-layout-<?php esc_html_e( $columns ); ?> tutor-divi-courselist-<?php esc_html_e( $skin ); ?>">

		<?php
		while ( $the_query->have_posts() ) :
			$the_query->the_post();
			?>
			<!-- slick-slider-main-wrapper -->

			<div class="tutor-divi-courselist-col tutor-course-col-<?php esc_html_e( $columns ); ?>">
			<?php
				$image_size = $image_size;
				$image_url  = get_tutor_course_thumbnail( $image_size, $url = true );

			?>
			<div class="<?php echo 'stacked' !== $args['skin'] ? 'tutor-course-listing-item ' : ''; ?> tutor-divi-card 
			<?php
			echo $hover_animation == 'on' ? esc_attr( 'hover-animation' ) : '';
			if ( $columns == 1 && $skin != 'overlayed' ) {
				esc_attr_e( ' tutor-divi-courselist-style' );}
			?>
			">

					<!-- header -->
					
					<div class="tutor-course-header ">
						<?php if ( 'on' == $show_image ) : ?>
						<a href="<?php the_permalink(); ?>">
							<img src="<?php echo esc_url( $image_url ); ?>" alt="">
						</a> 
						<?php endif; ?>                              
						<div class="tutor-course-loop-header-meta">
							<?php
							$course_id     = get_the_ID();
							$is_wishlisted = tutor_utils()->is_wishlisted( $course_id );
							$has_wish_list = '';
							if ( $is_wishlisted ) {
								$has_wish_list = 'has-wish-listed';
							}

							$action_class = '';
							if ( is_user_logged_in() ) {
								$action_class = apply_filters( 'tutor_wishlist_btn_class', 'tutor-course-wishlist-btn' );
							} else {
								$action_class = apply_filters( 'tutor_popup_login_class', 'cart-required-login' );
							}
							if ( 'on' === $difficulty_label ) {
								$level = '<span class="tutor-course-loop-level">' . get_tutor_course_level() . '</span>';
								echo wp_kses_post( $level );
							}
							if ( 'on' === $wish_list ) {
								$icon_class = 'tutor-icon-fav-line-filled';
								if ( $has_wish_list ) {
									$icon_class = 'tutor-icon-fav-full-filled';
								}
								?>
									<span class="tutor-d-flex tutor-justify-content-end">
										<a href="javascript:;" class="tutor-course-wishlist-btn save-bookmark-btn tutor-d-flex tutor-align-items-center tutor-justify-content-center" data-course-id="<?php echo esc_attr( $course_id ); ?>">
										<i class="<?php echo esc_attr( $icon_class ); ?>"></i>
									</a>
									</span>
								<?php
							}
							?>
						</div> 

					</div>
				  
					<!--header end-->
					<!-- start loop content wrap -->
					<div class="tutor-divi-courselist-course-container">
						<div class="tutor-loop-course-container">

							<!-- loop rating -->
							<?php if ( 'on' === $rating ) : ?>
								<div class="tutor-loop-rating-wrap">
									<?php
									$course_rating = tutor_utils()->get_course_rating();
									tutor_utils()->star_rating_generator_v2( $course_rating->rating_avg );
									?>
									<span class="tutor-rating-count">
										<?php
										if ( $course_rating->rating_avg > 0 ) {
											echo apply_filters( 'tutor_course_rating_average', esc_html( $course_rating->rating_avg ) );
											echo '<i>(' . apply_filters( 'tutor_course_rating_count', esc_html( $course_rating->rating_count ) ) . ')</i>';
										}
										?>
									</span>
								</div>
							<?php endif; ?>
							<!-- loop title -->
							<div class="tutor-course-loop-title" title="<?php esc_attr( the_title() ); ?>">
								<h2><a class="tutor-text-medium-h5 tutor-color-text-primary" href="<?php echo esc_url( get_the_permalink() ); ?>"><?php esc_html( the_title() ); ?></a></h2>
							</div>

							<!-- loop meta -->
							<?php
							/**
							 * @package TutorLMS/Templates
							 * @version 1.4.3
							 */

							global $post, $authordata;

							$profile_url = tutor_utils()->profile_url( $authordata->ID );
							?>


							<?php if ( 'on' === $meta_data ) : ?>
								<div class="tutor-course-loop-meta">
									<?php
									$course_duration = get_tutor_course_duration_context();
									$course_students = tutor_utils()->count_enrolled_users_by_course();
									?>
									<div class="tutor-single-loop-meta">
										<i class='meta-icon tutor-icon-user-filled tutor-color-text-hints'></i><span><?php esc_html_e( $course_students ); ?></span>
									</div>
									<?php
									if ( ! empty( $course_duration ) ) {
										?>
										<div class="tutor-single-loop-meta">
											<i class='meta-icon tutor-icon-clock-filled tutor-color-text-hints'></i> <span>
											<?php
											echo wp_kses(
												$course_duration,
												array(
													'span',
													'label',
												)
											);
											?>
											</span>
										</div>
									<?php } ?>
								</div>
							<?php endif; ?>

							<!-- update cat meta -->
							<div class="tutor-loop-author tutor-d-flex align-items-center">
								<span class="tutor-single-course-avatar">
									<?php if ( 'on' === $avatar ) : ?>
										<a href="<?php echo esc_url( $profile_url ); ?>"> <?php echo tutor_utils()->get_tutor_avatar( $post->post_author ); ?></a>
									<?php endif; ?>
								</span>
								<div class="tutor-course-lising-category">
									<?php if ( 'on' == $author ) : ?>
										<span class="tutor-single-course-author-name">
											<span class="tutor-color-text-subsued"><?php _e( 'by', 'tutor-lms-divi-modules' ); ?></span>
											<span class="dtlms-author-name tutor-text-medium-caption tutor-color-text-primary"><?php echo get_the_author(); ?></span>
										</span>
									<?php endif; ?>
									<?php
									if ( 'on' === $category ) {

										$course_categories = get_tutor_course_categories();
										if ( is_array( $course_categories ) && count( $course_categories ) > 3 && 'overlayed' === $args['skin'] ) {
											$chunk = array_chunk( $course_categories, 3 );
											if ( count( $chunk ) && isset( $chunk[0] ) ) {
												$course_categories = $chunk[0];
											}
										}
										if ( is_array( $course_categories ) && count( $course_categories ) ) {
											?>
											<span class="tutor-color-text-subsued tutor-course-meta-cat"><?php esc_html_e( 'In', 'tutor-lms-divi-modules' ); ?></span>
											<?php
											foreach ( $course_categories as $course_category ) {
												$category_name = $course_category->name;
												$category_link = get_term_link( $course_category->term_id );
												echo "<a href='" . esc_url( $category_link ) . "'> " . esc_html( $category_name ) . ' </a>';
											}
										}
									}
									?>
								</div>
							</div>
							<!-- update cat meta -->

							<!-- end content wrap -->
						</div>

						<!-- loop footer -->
						<?php if ( 'on' === $footer && ( 'stacked' === $skin || 'overlayed' === $skin ) ) : ?>
							<div class="tutor-course-listing-item-footer has-border tutor-py-15 tutor-px-20 tutor-loop-course-footer tutor-loop-course-footer tutor-divi-courselist-footer">
								<?php
								tutor_course_loop_price()
								?>
							</div>
						<?php endif; ?>    
					</div> <!-- tutor-divi-course-container -->
					<!-- loop footer -->
					<?php if ( 'on' === $footer && ( 'classic' === $skin || 'card' === $skin ) ) : ?>
						<div class="tutor-course-listing-item-footer has-border tutor-py-15 tutor-px-20 tutor-loop-course-footer tutor-loop-course-footer tutor-divi-courselist-footer">
							<?php
							tutor_course_loop_price()
							?>
						</div>
					<?php endif; ?>  

				</div><!--card-end-->
			</div>

			<!-- slick-slider-main-wrapper -->

			<?php
		endwhile;

		?>
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
		<div class="tutor-divi-courselist-pagination">
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

