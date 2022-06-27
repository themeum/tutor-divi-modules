import React from 'react';

export default function Thumbnail(props) {
    const {data} = props;
    if(data.show === 'off') {
        return '';
    }
    return (
        <div className="tutor-course-thumbnail">
            <a href='/' className="tutor-d-block">
                <div className={`tutor-ratio tutor-ratio-${data.course.skin === 'overlayed' ? 'overlayed' : '1x1'}`}>
                    <img src={data.course.post_thumbnail} className="tutor-card-image-top" loading="lazy" alt="" />
                </div>
            </a>
        </div>
    );
}
