<?php
global $post, $authordata;
$profile_url        = tutor_utils()->profile_url( $authordata->ID, true );
$course_categories  = get_tutor_course_categories();
$show_avatar 		= $data['avatar'] === 'on' ;
$show_author 		= $data['author'] === 'on';
$show_categories 	= $data['show_category'] === 'on';
var_dump( $show_categories );
?>

<?php if ( $show_avatar || $show_author || $show_categories ) : ?>
<div class="tutor-meta tutor-mt-auto">
    <?php if ( $show_avatar ) : ?>
    <div>
        <a href="<?php echo $profile_url; ?>" class="tutor-d-flex">
            <?php echo tutor_utils()->get_tutor_avatar( $post->post_author ); ?>
        </a>
    </div>
    <?php endif; ?>

    <div>
        <?php if ( $show_author ) : ?>
        <span class="dtlms-course-author-meta tutor-meta-key"><?php esc_html_e('By', 'tutor') ?></span>
        <a class="dtlms-course-author-meta tutor-meta-value" href="<?php echo $profile_url; ?>"><?php esc_html_e(get_the_author()); ?></a>
        <?php endif; ?>

        <?php if( $show_categories && ( !empty( $course_categories ) && is_array( $course_categories ) && count( $course_categories ) ) ) : ?>
            <span class="dtlms-course-category-meta tutor-meta-key"><?php esc_html_e('In', 'tutor'); ?></span>
            <?php
                $category_links = array();
                foreach ( $course_categories as $course_category ) :
                    $category_name = $course_category->name;
                    $category_link = get_term_link($course_category->term_id);
                    $category_links[] = wp_sprintf( '<a class="dtlms-course-category-meta tutor-meta-value" href="%1$s">%2$s</a>', esc_url( $category_link ), esc_html( $category_name ) );
                endforeach;
                echo implode(', ', $category_links);
            ?>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>