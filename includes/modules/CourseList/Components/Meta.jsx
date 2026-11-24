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
            <>
                <span class="dtlms-course-author-meta tutor-meta-key">By</span>
                <a class="dtlms-course-author-meta tutor-meta-value" href="http://localhost/tutor-v2/profile/tutor?view=instructor">{` ${course.author_name}`}</a>
            </>
        );
    }

    const categoryTemplate = (show_category, categories, show_author, course) => {
        const author = authorTemplate(show_author,course);
        
        if (show_category === 'off' ||  !categories.length ) {
            return (<div>
                {author}
            </div>);
        }
        const cats = categories.map((category,idx) => {
            return (
                <>
                    <a href='/' className='dtlms-course-category-meta tutor-meta-value' id={category.term_id} tabIndex={0}>{category.name}</a>
                    { idx !== categories.length - 1 ? ', ' : ''}
                </>
            );
        });
        return(
            <div>
                {author}
                <span class="tutor-meta-key"> In </span>
                {cats}
            </div>
        );
    }

    if(data.show_avatar === 'off' && data.show_author === 'off') {
        return '';
    }
    return (
        <Fragment>
            <div class="tutor-meta tutor-mt-auto dtlms-author-category-meta">
                { avatarTemplate(data.avatar, data.course) }
                { categoryTemplate(data.category, data.course.course_category, data.author, data.course) }
            </div>
        </Fragment>
        
    );
}

