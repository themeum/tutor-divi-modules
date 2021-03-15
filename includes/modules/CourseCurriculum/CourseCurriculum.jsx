
import React, {Component, Fragment} from 'react';

class CourseCurriculum extends Component {

    static slug = 'tutor_course_curriculum';
    constructor(props) {
        super(props);
        this.state = {
            collapse: true
        }
    }

    static css(props) {
        const additionalCss = [];
        //selectors
        const wrapper                   = '%%order_class%% .tutor-course-topics-wrap';
        const topic_wrapper             = '%%order_class%% .tutor-course-topics-contents';
        const topic_wrapper_selector    = '%%order_class%% .tutor-course-title';
        const topic_icon_selector       = `${wrapper} .tutor-course-title >span`;
        const header_wrapper_selector   = '%%order_class%% .tutor-course-topics-header';

        //props
        const topic_icon_size       = props.topic_icon_size;
        const topic_icon_position   = props.icon_position;
        const gap                   = props.gap;
        const is_responsive_gap     = props.gap_last_edited && props.gap_last_edited.startsWith("on");
        const gap_tablet            = is_responsive_gap && props.gap_tablet ? props.gap_tablet : gap;
        const gap_phone             = is_responsive_gap && props.gap_phone ? props.gap_phone : gap;
        //set styles
        /**
         * topic default display flex
         */
        additionalCss.push([
            {
                selector: topic_wrapper_selector,
                declaration: `display: flex; align-items: center; column-gap: 10px;`
            }
        ]);
        additionalCss.push([
            {
                selector: `${topic_wrapper_selector} h4`,
                declaration: `padding: 0; margin: 0;`
            }
        ]);
        if('right' === topic_icon_position) {
            additionalCss.push([
                {
                    selector: topic_wrapper_selector,
                    declaration: 'justify-content: space-between; flex-direction: row-reverse;'
                }
            ])            
        }
        //topic style
        //default border for topic wrapper
        additionalCss.push([
            {
                selector: topic_wrapper,
                declaration: 'border: 1px solid #DCE4E6;'
            }
        ]);
        if('' !== topic_icon_size) {
            additionalCss.push([
                {
                    selector: topic_icon_selector,
                    declaration: `font-size: ${topic_icon_size};`
                }
            ])
        }
        //header gap style
        if(gap) {
            additionalCss.push([
                {
                    selector: header_wrapper_selector,
                    declaration: `margin-bottom: ${gap};`
                }
            ]);            
        }

        if(gap_tablet) {
            additionalCss.push([
                {
                    selector: header_wrapper_selector,
                    declaration: `margin-bottom: ${gap_tablet};`,
                    device: 'tablet'
                }
            ]);            
        }
        if(gap_phone) {
            additionalCss.push([
                {
                    selector: header_wrapper_selector,
                    declaration: `margin-bottom: ${gap_phone};`,
                    device: 'phone'
                }
            ]);            
        }        
        //set styles end
        return additionalCss;
    }

    iconTemplate(collaps_icon, expand_icon) {
        const utils = window.ET_Builder.API.Utils;
        const ex_icon = utils.processFontIcon(expand_icon);
        const col_icon = utils.processFontIcon(collaps_icon);
        if(this.state.collapse) {
            return <span className="et-pb-icon"> {col_icon}</span>
        }
        return <span className="et-pb-icon"> {ex_icon}</span> 
    }

    topicTemplate(curriculums,collaps_icon,expand_icon) {

        let topic = curriculums.map((curriculum)=>{
            return (
            <Fragment>
                <div className="tutor-course-title has-summery">
                    
                    { this.iconTemplate(collaps_icon, expand_icon) }
                   
                    <h4> { curriculum.topic.topic_details.post_title }</h4>
                </div>
                { this.curriculumTemplate(curriculum.topic.curriculums) }
            </Fragment>
            );
        }) 
        return topic;
    }

    curriculumTemplate(curriculums) {
        
        let c = curriculums.map((curriculum) => {
            let icon = curriculum.video_info ? 'tutor-icon-youtube' : 'tutor-icon-document-alt';
            if(curriculum.post_type === 'tutor_quiz') {
                icon = 'tutor-icon-doubt';
            } else if(curriculum.post_type === 'tutor_assignments') {
                icon = 'tutor-icon-clipboard';
            }   
            return(
                <div className="tutor-course-lessons">
                    <div className="tutor-course-lesson">
                        <h5>
                            <i className={ icon }></i>
                            <a href="/">{ curriculum.post_title }</a>
                            <span className="tutor-lesson-duration">
                                { curriculum.video_info ? curriculum.video_info.playtime : '' }
                            </span>
                        </h5>
                    </div>
                </div>
            );
        })
        return c;
    }

    render(){
        if(!this.props.__curriculum) {
            return ''
        }
        console.log(this.props)
        return (
            <Fragment>
                <div className="tutor-wrap">

                    <div className="course-enrolled-nav-wrap">
                        <nav className="course-enrolled-nav">
                            <ul>
                                <li className="active">
                                    <a href="/">Course Page</a>
                                </li>
                                <li className="">
                                    <a href="/">Q&A</a>
                                </li>
                                <li className="">
                                    <a href="/">Announcements</a>
                                </li>
                                <li className="">
                                    <a href="/">Gradebook</a>
                                </li>
                                <li className="">
                                    <a href="/">Resources</a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                </div>

                <div className="tutor-single-course-segment  tutor-course-topics-wrap">

                    <div className="tutor-course-topics-header">
                        <div className="tutor-course-topics-header-left">
                            <h4 className="tutor-segment-title">
                                { this.props.label }
                            </h4>
                        </div>
                        <div className="tutor-course-topics-header-right">
                            <span>{ this.props.__curriculum.lesson_count } Lessons</span>
                            <span>{ this.props.__curriculum.course_duration }</span>
                        </div>
                    </div>

                    <div className="tutor-course-topics-contents">
                        <div className="tutor-divi-course-topic tutor-topics-in-single-lesson tutor-active">
                            { this.topicTemplate( Array(this.props.__curriculum),this.props.collaps_icon, this.props.expand_icon) }
                        </div>
                    </div>

                </div>

            </Fragment>
        );
    }
}

export default CourseCurriculum;