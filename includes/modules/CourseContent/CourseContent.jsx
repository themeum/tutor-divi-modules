
import React, {Component, Fragment} from 'react';

class CourseContent extends Component {

    static slug = 'tutor_course_content';
    constructor(props) {
        super(props);
        this.state = {
            collapse: false
        }
    }

    static css(props) {
        const additionalCss = [];
        //selectors
        const wrapper                   = '%%order_class%% .dtlms-course-curriculum';
        const topic_wrapper             = '%%order_class%% .tutor-divi-course-topic';
        const topic_title_selector      = '%%order_class%% .tutor-course-title';//
        const topic_icon_selector       = `${wrapper} .tutor-accordion-item-header::after`;
        const lesson_icon_selector      = '%%order_class%% .tutor-courses-lession-list span::before';
        const lesson_wrapper_selector   = '%%order_class%% .tutor-accordion-item-body';
        const lesson_info_selector      = '%%order_class%% .tutor-courses-lession-list .text-regular-caption.tutor-color-text-hints';

        //props
        const topic_icon_size               = props.topic_icon_size;
        const is_responsive_topic_icon_size = props.topic_icon_size_last_edited && props.topic_icon_size_last_edited.startsWith("on");
        const topic_icon_size_tablet        = is_responsive_topic_icon_size && '' !== props.topic_icon_size_tablet ? props.topic_icon_size_tablet: topic_icon_size;
        const topic_icon_size_phone         = is_responsive_topic_icon_size && '' !== props.topic_icon_size_phone ? props.topic_icon_size_phone: topic_icon_size;

        const lesson_icon_size               = props.lesson_icon_size;
        const is_responsive_lesson_icon_size = props.lesson_icon_size_last_edited && props.lesson_icon_size_last_edited.startsWith("on");
        const lesson_icon_size_tablet        = is_responsive_lesson_icon_size && '' !== props.lesson_icon_size_tablet ? props.lesson_icon_size_tablet: lesson_icon_size;
        const lesson_icon_size_phone         = is_responsive_lesson_icon_size && '' !== props.lesson_icon_size_phone ? props.lesson_icon_size_phone: lesson_icon_size;

        //const topic_icon_position   = props.icon_position;
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

        const space_between_topics  = props.space_between_topics;

        // course benefits styles start
        //selectors
        const benefits_wrapper = '%%order_class%% .tutor-course-benefits-wrap';
        const benefits_li_selector = '%%order_class%% ul.tutor-course-benefits-items li';
		const benefits_icon_selector	= "%%order_class%% ul.tutor-course-benefits-items .et-pb-icon";

        //props
        const course_benefits_layout = props.course_benefits_layout;

        const is_responsive_course_benefits_layout = props.course_benefits_layout_last_edited && props.course_benefits_layout_last_edited.startsWith("on");

        const course_benefits_layout_tablet = is_responsive_course_benefits_layout && props.course_benefits_layout_tablet ? props.course_benefits_layout_tablet : course_benefits_layout;

        const course_benefits_layout_phone = is_responsive_course_benefits_layout && props.course_benefits_layout_phone ? props.course_benefits_layout : course_benefits_layout;

        const course_benefits_alignment = props.course_benefits_alignment;
        const is_responsive_course_benefits_alignment = props.course_benefits_alignment_last_edited && props.course_benefits_alignment_last_edited.startsWith("on");

        const course_benefits_alignment_tablet = is_responsive_course_benefits_alignment && props.course_benefits_alignment_tablet ? props.course_benefits_alignment_tablet : course_benefits_alignment;

        const course_benefits_alignment_phone = is_responsive_course_benefits_alignment && props.course_benefits_alignment_phone ? props.course_benefits_alignment_phone : course_benefits_alignment;

        const course_benefits_icon_size = props.course_benefits_icon_size;

        const is_responsive_course_benefits_icon_size = props.course_benefits_icon_size_last_edited && props.course_benefits_icon_size_last_edited.startsWith("on");

        const course_benefits_icon_size_tablet = is_responsive_course_benefits_icon_size && props.course_benefits_icon_size_tablet ? props.course_benefits_icon_size_tablet : course_benefits_icon_size;

        const course_benefits_icon_size_phone = is_responsive_course_benefits_icon_size && props.course_benefits_icon_size_phone ? props.course_benefits_icon_size_phone : course_benefits_icon_size;

        const course_benefits_icon_color = props.course_benefits_icon_color;

        // title gap
        const course_benefits_gap = props.course_benefits_gap;
        const is_responsive_course_benefits_gap = props.course_benefits_gap_last_edited && props.course_benefits_gap_last_edited.startsWith("on");
        const course_benefits_gap_tablet = is_responsive_course_benefits_gap && props.course_benefits_gap_tablet ? props.course_benefits_gap_tablet : course_benefits_gap;

        const course_benefits_gap_phone = is_responsive_course_benefits_gap && props.course_benefits_gap_phone ? props.course_benefits_gap_phone : course_benefits_gap;

        const padding = props.padding;

        const space_between = props.space_between;
        const is_responsive_space = props.space_between_last_edited && props.space_between_last_edited.startsWith("on");
        const space_between_tablet = is_responsive_space && props.space_between_tablet ? props.space_between_tablet : space_between;
        const space_between_phone = is_responsive_space && props.space_between_phone ? props.space_between_phone : space_between;

        const indent = props.indent;
        const is_responsive_indent = props.indent_last_edited && props.indent_last_edited.startsWith("on");
        const indent_tablet = is_responsive_indent && props.indent_tablet ? props.indent_tablet : indent;
        const indent_phone = is_responsive_indent && props.indent_phone ? props.indent_phone : indent;  

        //set styles
        additionalCss.push([
            {
                selector: `${benefits_wrapper} ul`,
                declaration: 'padding: 0;'
            }
        ]);        

        additionalCss.push([
            {
                selector: benefits_li_selector,
                declaration: 'list-style: none; padding: 0; border-style: solid;'
            }
        ]);
        
        //wrapper style
        additionalCss.push([
            {
                selector: benefits_wrapper,
                declaration: 'display: flex; flex-direction: column;'
            }
        ]);

        if(course_benefits_gap) {
            additionalCss.push([
                {
                    selector: benefits_wrapper,
                    declaration: `row-gap: ${course_benefits_gap};`
                }
            ]);            
        }

        if(course_benefits_gap_tablet) {
            additionalCss.push([
                {
                    selector: benefits_wrapper,
                    declaration: `row-gap: ${course_benefits_gap_tablet};`,
                    device: 'tablet'
                }
            ]);            
        }
        if(course_benefits_gap_phone) {
            additionalCss.push([
                {
                    selector: benefits_wrapper,
                    declaration: `row-gap: ${course_benefits_gap_phone};`,
                    device: 'phone'
                }
            ]);            
        }

        //icons style
        if('' !== course_benefits_icon_color) {
            additionalCss.push([
                {
                    selector: benefits_icon_selector,
                    declaration: `color: ${course_benefits_icon_color};`
                }
            ]);            
        }

        additionalCss.push([
            {
                selector: benefits_icon_selector,
                declaration: `font-size: ${course_benefits_icon_size};`
            }
        ]);

        if(course_benefits_icon_size_tablet) {
            additionalCss.push([
                {
                    selector: benefits_icon_selector,
                    declaration: `font-size: ${course_benefits_icon_size_tablet};`,
                    device: 'tablet'
                }
            ]);     
        }

        if(course_benefits_icon_size_phone) {
            additionalCss.push([
                {
                    selector: benefits_icon_selector,
                    declaration: `font-size: ${course_benefits_icon_size_phone};`,
                    device: 'phone'
                }
            ]);     
        }

        //layout
        if(course_benefits_layout) {
            additionalCss.push([
                {
                    selector: benefits_li_selector,
                    declaration: `display: ${course_benefits_layout};`
                }
            ])
        }
        if(course_benefits_layout_tablet) {
            additionalCss.push([
                {
                    selector: benefits_li_selector,
                    declaration: `display: ${course_benefits_layout_tablet};`,
                    device: 'tablet'
                }
            ])
        }
        if(course_benefits_layout_phone) {
            additionalCss.push([
                {
                    selector: benefits_li_selector,
                    declaration: `display: ${course_benefits_layout_phone};`,
                    device: 'phone'
                }
            ])
        }

        if(course_benefits_alignment) {
            additionalCss.push([
                {
                    selector: benefits_wrapper,
                    declaration: `text-align: ${course_benefits_alignment};`
                }
            ])
        }
        if(course_benefits_alignment_tablet) {
            additionalCss.push([
                {
                    selector: benefits_wrapper,
                    declaration: `text-align: ${course_benefits_alignment_tablet};`,
                    device: 'tablet'
                }
            ])
        }
        if(course_benefits_alignment_phone) {
            additionalCss.push([
                {
                    selector: benefits_wrapper,
                    declaration: `text-align: ${course_benefits_alignment_phone};`,
                    device: 'phone'
                }
            ])
        }
        //padding
        if(padding) {
            const split_padding = padding.split("|");
            additionalCss.push([
                {
                    selector: benefits_li_selector,
                    declaration: `padding: ${split_padding[0]} ${split_padding[1]} ${split_padding[2]} ${split_padding[3]};`
                }
            ])
        }
        //space 
        if(space_between) {
            additionalCss.push([
                {
                    selector: `${benefits_li_selector}:not(:last-child)`,
                    declaration: `margin-bottom: ${space_between};`
                }
            ])
        }

        if(space_between_tablet) {
            additionalCss.push([
                {
                    selector: `${benefits_li_selector}:not(:last-child)`,
                    declaration: `margin-bottom: ${space_between_tablet};`,
                    device: 'tablet'
                }
            ])
        }

        if(space_between_phone) {
            additionalCss.push([
                {
                    selector: `${benefits_li_selector}:not(:last-child)`,
                    declaration: `margin-bottom: ${space_between_phone};`,
                    device: 'phone'
                }
            ])
        }
        //text indent
        if(indent) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-course-benefits-wrap .list-item',
                    declaration: `padding-left: ${indent} !important;`
                }
            ])
        }

        if(indent_tablet) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-course-benefits-wrap .list-item',
                    declaration: `padding-left: ${indent_tablet} !important;`,
                    device: 'tablet'
                }
            ])
        }

        if(indent_phone) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-course-benefits-wrap .list-item',
                    declaration: `padding-left: ${indent_phone} !important;`,
                    device: 'phone'
                }
            ])
        }
        // course benefits styles end

        // course instructor styles start
        const course_instructor_layout = props.course_instructor_layout;
        const course_instructor_section_background = props.course_instructor_section_background;
        const course_instructor_bottom_info_star_size = props['course_instructor_bottom_info_star_size'];
        const course_instructor_bottom_info_star_color = props['course_instructor_bottom_info_star_color'];
        if ( course_instructor_layout ) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-instructor-right',
                    declaration: `flex-direction: ${course_instructor_layout};`
                }
            ]);
        }
        if ( course_instructor_section_background ) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-instructor-info-card',
                    declaration: `background-color: ${course_instructor_section_background};`
                }
            ]);
        }
        if ( course_instructor_bottom_info_star_size ) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .single-instructor-bottom .tutor-star-rating-group i',
                    declaration: `font-size: ${course_instructor_bottom_info_star_size};`
                }
            ]);
        }
        if ( course_instructor_bottom_info_star_color ) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .single-instructor-bottom .tutor-star-rating-group i',
                    declaration: `color: ${course_instructor_bottom_info_star_color};`
                }
            ]);
        }
        // course instructor styles end

        //set styles
        /**
         * topic default display flex
         */

        if('' !== space_between_topics) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .dtlms-course-curriculum .tutor-accordion-item',
                    declaration: `margin-bottom: ${space_between_topics};`
                }
            ]);       
        }

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
        // if('left' === topic_icon_position) {
        //     additionalCss.push([
        //         {
        //             selector: topic_icon_selector,
        //             declaration: 'position: inherit !important; padding-left: 20px;'
        //         }
        //     ])            
        // }
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
                    selector: `${wrapper} .tutor-accordion-item-header::after`,
                    declaration: `color: ${topic_icon_color};`
                }
            ])
        }
        if('' !== topic_icon_active_color) {
            additionalCss.push([
                {
                    selector: `${wrapper} .tutor-accordion-item-header.is-active::after`,
                    declaration: `color: ${topic_icon_active_color};`
                }
            ])            
        }
        if('' !== topic_icon_hover_color) {
            additionalCss.push([
                {
                    selector: `${wrapper} .tutor-accordion-item-header.is-active:hover::after`,
                    declaration: `color: ${topic_icon_hover_color};`
                }
            ])            
        }
        //topic title text color styles
        if('' !== topic_text_color) {
            additionalCss.push([
                {
                    selector: `${wrapper} .tutor-accordion-item-header`,
                    declaration: `color: ${topic_text_color};`
                }
            ])
        }
        if('' !== topic_text_active_color) {
            additionalCss.push([
                {
                    selector: `${wrapper} .tutor-accordion-item-header.is-active`,
                    declaration: `color: ${topic_text_active_color};`
                }
            ])            
        }
        if('' !== topic_text_hover_color) {
            additionalCss.push([
                {
                    selector: `${wrapper} .tutor-accordion-item-header:hover`,
                    declaration: `color: ${topic_text_hover_color};`
                }
            ])            
        }
        //topic title background color styles
        if('' !== topic_background_color) {
            additionalCss.push([
                {
                    selector: `${wrapper} .tutor-accordion-item-header`,
                    declaration: `background-color: ${topic_background_color};`
                }
            ])
        }
        if('' !== topic_background_active_color) {
            additionalCss.push([
                {
                    selector: `${wrapper} .tutor-accordion-item-header.is-active`,
                    declaration: `background-color: ${topic_background_active_color};`
                }
            ])            
        }
        if('' !== topic_background_hover_color) {
            additionalCss.push([
                {
                    selector: `${wrapper} .tutor-accordion-item-header:hover`,
                    declaration: `background-color: ${topic_background_hover_color};`
                }
            ])            
        }
        //header gap style
        if(gap) {
            additionalCss.push([
                {
                    selector: "%%order_class%% #tutor-course-details-tab-curriculum .tutor-accordion",
                    declaration: `margin-top: ${gap};`
                }
            ]);            
        }

        if(gap_tablet) {
            additionalCss.push([
                {
                    selector: "%%order_class%% #tutor-course-details-tab-curriculum .tutor-accordion",
                    declaration: `margin-top: ${gap_tablet};`,
                    device: 'tablet'
                }
            ]);            
        }
        if(gap_phone) {
            additionalCss.push([
                {
                    selector: "%%order_class%% #tutor-course-details-tab-curriculum .tutor-accordion",
                    declaration: `margin-top: ${gap_phone};`,
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
        additionalCss.push([
            {
                selector: '%%order_class%% ul.tutor-courses-lession-list',
                declaration: 'padding: 0 !important;'
            }
        ]);
        // review start color
        if ('' !== props.review_avg_star) {
            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-ratingsreviews-ratings-avg .tutor-rating-stars span`,
                    declaration: `color: ${props.review_avg_star};`,
                }
            ]);         
        }      
        if ('' !== props.review_right_star) {
            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-ratingsreviews-ratings-all .tutor-rating-stars span`,
                    declaration: `color: ${props.review_right_star};`,
                }
            ]);         
        }      
        if ('' !== props.review_right_bar_height) {
            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-ratingsreviews-ratings-all .progress-bar`,
                    declaration: `height: ${props.review_right_bar_height};`,
                }
            ]);         
        }      
        if ('' !== props.review_right_bar_color) {
            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-ratingsreviews-ratings-all .progress-bar`,
                    declaration: `background-color: ${props.review_right_bar_color};`,
                }
            ]);         
        }      
        if ('' !== props.review_right_bar_fill_color) {
            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-ratingsreviews-ratings-all .progress-value`,
                    declaration: `background-color: ${props.review_right_bar_fill_color};`,
                }
            ]);         
        }      
        //
        //set styles end
        return additionalCss;
    }

    render(){
        if(!this.props.__content) {
            return ''
        }
        return (
            <Fragment>
                <div className="tutor-wrap dtlms-course-curriculum" dangerouslySetInnerHTML={{__html: this.props.__content}}>
                </div>
            </Fragment>
        );
    }
}

export default CourseContent;