
import React, {Component, Fragment} from 'react';
import ReactPlayer from "react-player"

class CourseThumbnail extends Component {

    static slug = 'tutor_course_thumbnail';

    thumbnailTemplate(thumbnail) {
        if(thumbnail.has_video) {
            return (
                <ReactPlayer url={thumbnail.url} controls='true' width='100%'/>
            );
        } else {
            return (<img  src={thumbnail.url} alt="thumbnail"/>);
        }
    }
    render(){
        if( !this.props.__thumbnail) {
            return '';
        }
 
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