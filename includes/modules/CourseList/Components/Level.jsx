import React from 'react';

export default function Level(props) {
    const {data} = props;
    if(data.show === 'off') {
        return ''
    }
    return (
        <span class="tutor-course-difficulty-level">
            {data.level}
        </span>
    );
}