import React, {Fragment} from 'react';

export default function Meta (props) {
    const {data} = props;

    const avatarTemplate = (show,course) => {
        if(show === 'off') {
            return '';
        }
        return (
            <div>
                <a href="/" class="tutor-d-flex">
                    <div class="tutor-avatar">
                        <div class="tutor-ratio tutor-ratio-1x1">
                            { course.post_thumbnail.includes('placeholder.svg') ?
                                <span class="tutor-avatar-text">
                                    {course.author_name[0].toUpperCase()}
                                </span> : 
                                <img src={course.post_thumbnail} alt={course.author_name}/>
                            } 
                        </div>
                    </div>        
                </a>
            </div>
        );
    }

    const authorTemplate = (show_author, course) => {
        if (show_author === 'off') {
            return '';
        }
        return(
            <div>
                <span class="dtlms-course-author-meta tutor-meta-key">By</span>
                <a class="dtlms-course-author-meta tutor-meta-value" href="http://localhost/tutor-v2/profile/tutor?view=instructor">{` ${course.author_name}`}</a>
            </div>
        );
    }

    if(data.show_avatar === 'off' && data.show_author === 'off') {
        return '';
    }
    return (
        <Fragment>
            <div class="tutor-meta tutor-mt-auto">
                { avatarTemplate(data.show_avatar, data.course) }
                { authorTemplate(data.show_author, data.course) }
            </div>
        </Fragment>
        
    );
}

