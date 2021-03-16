
import React, {Component, Fragment} from 'react';
class CourseCurriculum extends Component {

    static slug = 'tutor_course_curriculum';
    constructor(props) {
        super(props);
        this.state = {
            collapse: false
        }
    }

    static css(props) {
        const additionalCss = [];
        //selectors
        const wrapper                   = '%%order_class%% .tutor-course-topics-wrap';
        const topic_wrapper             = '%%order_class%% .tutor-divi-course-topic';
        const topic_title_selector      = '%%order_class%% .tutor-course-title';//
        const topic_icon_selector       = `${wrapper} .tutor-course-title >span`;
        const header_wrapper_selector   = '%%order_class%% .tutor-course-topics-header';
        const lesson_icon_selector      = '%%order_class%% .tutor-course-lesson h5 i';
        const lesson_wrapper_selector   = '%%order_class%% .tutor-course-lessons';
        const lesson_info_selector      = '%%order_class%% .tutor-course-lesson .tutor-lesson-duration';
      

        //props
        const topic_icon_size               = props.topic_icon_size;
        const is_responsive_topic_icon_size = props.topic_icon_size_last_edited && props.topic_icon_size_last_edited.startsWith("on");
        const topic_icon_size_tablet        = is_responsive_topic_icon_size && '' !== props.topic_icon_size_tablet ? props.topic_icon_size_tablet: topic_icon_size;
        const topic_icon_size_phone         = is_responsive_topic_icon_size && '' !== props.topic_icon_size_phone ? props.topic_icon_size_phone: topic_icon_size;

        const lesson_icon_size               = props.lesson_icon_size;
        const is_responsive_lesson_icon_size = props.lesson_icon_size_last_edited && props.lesson_icon_size_last_edited.startsWith("on");
        const lesson_icon_size_tablet        = is_responsive_lesson_icon_size && '' !== props.lesson_icon_size_tablet ? props.lesson_icon_size_tablet: lesson_icon_size;
        const lesson_icon_size_phone         = is_responsive_lesson_icon_size && '' !== props.lesson_icon_size_phone ? props.lesson_icon_size_phone: lesson_icon_size;

        const topic_icon_position   = props.icon_position;
        const gap                   = props.gap;
        const is_responsive_gap     = props.gap_last_edited && props.gap_last_edited.startsWith("on");
        const gap_tablet            = is_responsive_gap && props.gap_tablet ? props.gap_tablet : gap;
        const gap_phone             = is_responsive_gap && props.gap_phone ? props.gap_phone : gap;

        const topic_icon_color          = props.topic_icon_color;
        const topic_icon_active_color   = props.topic_icon_active_color;
        const topic_icon_hover_color    = props.topic_icon_hover_color;

        const topic_text_color          = props.topic_text_color;
        const topic_text_active_color   = props.topic_text_active_color;
        const topic_text_hover_color    = props.topic_text_hover_color;

        const topic_background_color          = props.topic_background_color;
        const topic_background_active_color   = props.topic_background_active_color;
        const topic_background_hover_color    = props.topic_background_hover_color;

        const lesson_icon_color         = props.lesson_icon_color;
        const lesson_icon_color_hover   = props.lesson_icon_color__hover;

        const lesson_info_color         = props.lesson_info_color;
        const lesson_info_color_hover   = props.lesson_info_color__hover;

        const lesson_background_color           = props.lesson_background_color;
        const lesson_background_color_hover     = props.lesson_background_color__hover;


        //set styles
        /**
         * topic default display flex
         */
        additionalCss.push([
            {
                selector: topic_title_selector,
                declaration: `display: flex; align-items: center; column-gap: 10px;`
            }
        ]);
        additionalCss.push([
            {
                selector: `${topic_title_selector} h4`,
                declaration: `padding: 0; margin: 0;`
            }
        ]);
        if('right' === topic_icon_position) {
            additionalCss.push([
                {
                    selector: topic_title_selector,
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
        if('' !== topic_icon_size_tablet) {
            additionalCss.push([
                {
                    selector: topic_icon_selector,
                    declaration: `font-size: ${topic_icon_size_tablet};`,
                    device: 'tablet'
                }
            ])
        }
        if('' !== topic_icon_size_phone) {
            additionalCss.push([
                {
                    selector: topic_icon_selector,
                    declaration: `font-size: ${topic_icon_size_phone};`,
                    device: 'phone'
                }
            ])
        }
        //topic icon,text,background colors

        //topic icon color
        if('' !== topic_icon_color) {
            additionalCss.push([
                {
                    selector: topic_icon_selector,
                    declaration: `color: ${topic_icon_color};`
                }
            ])
        }
        if('' !== topic_icon_active_color) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-divi-course-topic.tutor-active .et-pb-icon',
                    declaration: `color: ${topic_icon_active_color};`
                }
            ])            
        }
        if('' !== topic_icon_hover_color) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-divi-course-topic .et-pb-icon:hover',
                    declaration: `color: ${topic_icon_hover_color};`
                }
            ])            
        }
        //topic title text color styles
        if('' !== topic_text_color) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-divi-course-topic .tutor-course-title h4',
                    declaration: `color: ${topic_text_color};`
                }
            ])
        }
        if('' !== topic_text_active_color) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-divi-course-topic.tutor-active .tutor-course-title h4',
                    declaration: `color: ${topic_text_active_color};`
                }
            ])            
        }
        if('' !== topic_text_hover_color) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-divi-course-topic .tutor-course-title h4:hover',
                    declaration: `color: ${topic_text_hover_color};`
                }
            ])            
        }
        //topic title background color styles
        if('' !== topic_background_color) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-divi-course-topic .tutor-course-title',
                    declaration: `background-color: ${topic_background_color};`
                }
            ])
        }
        if('' !== topic_background_active_color) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-divi-course-topic.tutor-active .tutor-course-title',
                    declaration: `background-color: ${topic_background_active_color};`
                }
            ])            
        }
        if('' !== topic_background_hover_color) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-divi-course-topic .tutor-course-title:hover',
                    declaration: `background-color: ${topic_background_hover_color};`
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
        //lesson styles
        //lesson icon
        if('' !== lesson_icon_size) {
            additionalCss.push([
                {
                    selector: lesson_icon_selector,
                    declaration: `font-size: ${lesson_icon_size};`
                }
            ])
        }
        if('' !== lesson_icon_size_tablet) {
            additionalCss.push([
                {
                    selector: lesson_icon_selector,
                    declaration: `font-size: ${lesson_icon_size_tablet};`,
                    device: 'tablet'
                }
            ])
        }
        if('' !== lesson_icon_size_phone) {
            additionalCss.push([
                {
                    selector: lesson_icon_selector,
                    declaration: `font-size: ${lesson_icon_size_phone};`,
                    device: 'phone'
                }
            ])
        }  
        //lesson color styles   
        if('' !== lesson_icon_color) {
            additionalCss.push([
                {
                    selector: lesson_icon_selector,
                    declaration: `color: ${lesson_icon_color};`,
                }
            ])
        }          
        if('' !== lesson_icon_color_hover) {
            additionalCss.push([
                {
                    selector: `${lesson_icon_selector}:hover`,
                    declaration: `color: ${lesson_icon_color_hover};`,
                }
            ])
        }     
        if('' !== lesson_info_color) {
            additionalCss.push([
                {
                    selector: lesson_info_selector,
                    declaration: `color: ${lesson_info_color};`,
                }
            ])
        }      
        if('' !== lesson_info_color_hover) {
            additionalCss.push([
                {
                    selector: `${lesson_info_selector}:hover`,
                    declaration: `color: ${lesson_info_color_hover};`,
                }
            ])
        }      
        if('' !== lesson_background_color) {
            additionalCss.push([
                {
                    selector: lesson_wrapper_selector,
                    declaration: `background-color: ${lesson_background_color};`,
                }
            ])
        }      
        if('' !== lesson_background_color_hover) {
            additionalCss.push([
                {
                    selector: `${lesson_wrapper_selector}:hover`,
                    declaration: `background-color: ${lesson_background_color_hover};`,
                }
            ])
        }      
        //set styles end
        return additionalCss;
    }

    handleCurriculumToggle(event) {
        console.log(this.classList)
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

    topicTemplate(topics,collaps_icon,expand_icon) {
        let topic = topics.map((topic)=>{
            return (
            <Fragment>
                <div className="tutor-divi-course-topic tutor-topics-in-single-lesson" onClick={(e)=> {
                    const utils = window.ET_Builder.API.Utils;
                    const ex_icon = utils.processFontIcon(expand_icon);
                    const col_icon = utils.processFontIcon(collaps_icon);
                    e.currentTarget.classList.toggle('tutor-active');
                    let div = e.currentTarget.querySelector(".tutor-course-lessons"); 
                    let icondiv = e.currentTarget.querySelector(".et-pb-icon");
                    if(div.style.display !== 'none') {
                        div.style.display = 'none';
                    } else {
                        div.style.display = 'block';
                    }  
                
                    if(icondiv.textContent === ex_icon) {
                        icondiv.textContent = String(col_icon);
                    } else {
                        icondiv.textContent = String(ex_icon);
                    }
            }
                }
                    
                    >
                    <div className="tutor-course-title has-summery">
                        
                        { this.iconTemplate(collaps_icon, expand_icon) }
                    
                        <h4> { topic.post_title }</h4>
                    </div>
                    <div className="tutor-course-lessons">
                        { this.curriculumTemplate(topic.curriculums) }
                    </div>
                 </div>
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
                <div className="tutor-course-lesson">
                <h5>
                    <i className={ icon }></i>
                    <a href="/">{ curriculum.post_title }</a>
                    <span className="tutor-lesson-duration">
                        { curriculum.video_info ? curriculum.video_info.playtime : '' }
                    </span>
                </h5>
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
                        { this.topicTemplate( this.props.__curriculum.topics,this.props.collaps_icon, this.props.expand_icon) }
                    </div>

                </div>

            </Fragment>
        );
    }
}

export default CourseCurriculum;