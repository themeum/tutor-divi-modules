
import React, {Component, Fragment} from 'react';

class CourseThumbnail extends Component {

    static slug = 'tutor_course_thumbnail';

    thumbnailTemplate(thumbnail) {
        if(thumbnail.has_video) {
            return (
                <source src={thumbnail.url} type="video/mp4"/>
            );
        } else {
            return (<img  src={thumbnail.url} alt="thumbnail"/>);
        }
    }
    render(){
        if( !this.props.__thumbnail) {
            return '';
        }
        console.log(this.props)
        return (
            <Fragment>
                <div className="tutor-divi-course-thumbnail">
                    { this.thumbnailTemplate(this.props.__thumbnail) }
                </div>
            </Fragment>
        );
    }
}

export default CourseThumbnail;