import React ,{ Component, Fragment } from "react";

class CourseTags extends Component {

    static slug = "tutor_course_tags";

    tagTemplate(tags) {
        if(tags.length) {
            const tag = tags.map((tag) => {
                return <a href={tag.slug}>{ tag.name }</a>
            });
            return tag;
        }
    }

    render() {
        if(!this.props.__tags) {
            return '';
        }
     
        return (
            <Fragment>
                <div class="tutor-single-course-segment">
                    <div class="course-benefits-title">
                        <h4 class="tutor-segment-title"> { this.props.label } </h4>
                    </div>
                    <div class="tutor-course-tags">
                        { this.tagTemplate(this.props.__tags.tags) }
                    </div>
                </div>
            </Fragment>            
        );
    }
}
export default CourseTags;