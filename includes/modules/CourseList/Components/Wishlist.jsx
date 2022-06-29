import React from 'react';

export default function Wishlist(props) {

    if(props.show === 'off') {
        return ''
    }
    return(
        <div class="tutor-course-bookmark">
            <a href="/" class="tutor-course-wishlist-btn save-bookmark-btn tutor-iconic-btn tutor-iconic-btn-secondary">
                <i class="tutor-icon-bookmark-line"></i>
            </a>
        </div>
    );
}