// External Dependencies
import React, { Component, Fragment } from 'react';

class CourseCategories extends Component {

    static slug = 'tutor_course_categories';

    categories(categories) {
        const cat = categories.map( (category) => {
            return <a href={category.term_link}> { category.name } </a>
        });
        return cat;
    }
     
    render() {
        if(!this.props.__categories) {
            return '';
        }
        return (
            <Fragment>
                <div className="tutor-single-course-meta-categories">
                       { this.categories(this.props.__categories) }
                </div>
            </Fragment>
        );
    }
}

export default CourseCategories;