<?php if ( 'on' === $data['wish_list'] ) : ?>
<div class="tutor-course-bookmark">
    <?php
        $is_wish_listed = tutor_utils()->is_wishlisted( get_the_ID() );
        
        $action_class = '';
        if ( is_user_logged_in() ) {
            $action_class = apply_filters('tutor_wishlist_btn_class', 'tutor-course-wishlist-btn');
        } else {
            $action_class = apply_filters('tutor_popup_login_class', 'cart-required-login');
        }
        
        echo '<span class="'. esc_attr( $action_class ) .' save-bookmark-btn tutor-iconic-btn tutor-iconic-btn-secondary" data-course-id="'. esc_attr( get_the_ID() ) .'" role="button">
            <i class="' . ( $is_wish_listed ? 'tutor-icon-bookmark-bold' : 'tutor-icon-bookmark-line') . '"></i>
        </span>';
    ?>
</div>
<?php endif; ?>