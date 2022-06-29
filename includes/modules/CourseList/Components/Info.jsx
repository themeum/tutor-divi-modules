import React, {Fragment} from 'react';

export default function Info (props) {
    const {data} = props;
    if (data.meta_data === 'off') {
        return '';
    }
    return(
        <Fragment>
        <div class="tutor-meta dtlms-course-duration-meta tutor-mb-20">
            <div>
                <span class="tutor-meta-icon tutor-icon-user-line" area-hidden="true"></span>
                <span class="tutor-meta-value">{data.args.enroll_count}</span>
            </div>
            <div>
                <span class="tutor-icon-clock-line tutor-meta-icon" area-hidden="true"></span>
                <span class="tutor-meta-value" dangerouslySetInnerHTML={{__html: data.course.course_duration}}></span>
            </div>
        </div>
        </Fragment>
    );
}