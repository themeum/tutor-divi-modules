import React, {Fragment} from 'react';

export default function Meta (props) {
    const {data} = props;
    const avatarTemplate = (show,course) => {
        if(show === 'off') {
            return '';
        }
        return (
            <div>
                <a href="/" class="tutor-d-flex" dangerouslySetInnerHTML={{__html: course.author_avatar}}>
                            
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

    const categoryTemplate = (show_category, categories) => {
        console.dir(categories)
        if (show_category === 'off' || ! categories.length ) {
            return '';
        }
        const cats = categories.map((category) => {
            return (
                <a href='/' id={category.term_id}>{category.name}</a>
            );
        });
        return(
            <div>
                <span class="dtlms-course-category-meta tutor-meta-key">In </span>
                {cats}
            </div>
        );
    }

    if(data.show_avatar === 'off' && data.show_author === 'off') {
        return '';
    }
    return (
        <Fragment>
            <div class="tutor-meta tutor-mt-auto">
                { avatarTemplate(data.avatar, data.course) }
                { authorTemplate(data.author, data.course) }
                { categoryTemplate(data.category, data.course.course_category) }
            </div>
        </Fragment>
        
    );
}

