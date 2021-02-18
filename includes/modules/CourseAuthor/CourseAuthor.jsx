// External Dependencies
import React, { Component, Fragment } from 'react';

class CourseAuthor extends Component {

    static slug = 'tutor_course_author';

    /**
     * All component inline styling.
     *
     * @since 1.0.0
     * @return array
     */
    static css(props) {
        const additionalCss = [];
        const img_selector = '%%order_class%% .tutor-single-course-avatar a span';
        if (props.image_height) {
            additionalCss.push([{
                selector:    img_selector,
                declaration: `height: ${props.image_height} !important;`,
            }]);
        }
        if (props.image_width) {
            additionalCss.push([{
                selector:    img_selector,
                declaration: `width: ${props.image_width} !important;`,
            }]);
        }

        return additionalCss;
    }

    render() {
        if( this.props.__author == null ) {
            return '';
        }
        return (
        <Fragment>  
            <div className="tutor-single-course-meta tutor-meta-top .tutor-divi-course-author-wrapper">
                <ul>
                    <li className="tutor-single-course-author-meta">
                       
                        <div className="tutor-single-course-avatar">
                            <a href={ this.props.__author.profile_url }> 
                                <img src= { this.props.__author.avatar_url } alt="avatar"/>
                            </a>
                        </div>
                    
                        <div className="tutor-single-course-author-name">
                            <span> By </span>
                            <a href= { this.props.__author.profile_url }>
                                { this.props.__author.author_name }
                            </a>
                        </div>
                    
                    </li>
                </ul>
            </div>        
        </Fragment>

        );
    }
}

export default CourseAuthor;