import React from 'react';

export default function Title(props) {
    return(
        <h3 class="tutor-course-name tutor-fs-5 tutor-fw-medium tutor-mb-12" title="<?php the_title( ); ?>">
            <a href="/">
            {props.title}
            </a>
        </h3>
        );
}