
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
        const nav                       = '%%order_class%% .tutor-nav';

        const about_course            = '%%order_class%% .tutor-course-details-content';
        const heading_selector        = '%%order_class%% .tutor-course-details-content h2';

        const lesson_icon_selector    = '%%order_class%% .tutor-accordion-item .tutor-course-content-list-item-icon, %%order_class%% .tutor-accordion-item .tutor-course-content-list-item-status';
		const lesson_wrapper_selector = '%%order_class%% .tutor-accordion-item .tutor-course-content-list-item';
		const lesson_info_selector    = '%%order_class%% .tutor-accordion-item .tutor-course-content-list-item-duration';
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
        const benefits_wrapper = '%%order_class%% .tutor-course-details-widget';
        const benefits_li_selector = '%%order_class%% .tutor-course-details-widget-list li';
		const benefits_icon_selector	= "%%order_class%% .tutor-course-details-widget-list .et-pb-icon";
        const benefits_title = '%%order_class%% .tutor-course-details-widget .tutor-course-details-widget-title';

        const rating_right_bar_selector = "%%order_class%% .tutor-review-summary-ratings"; 
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

        const course_review_alignment = props.course_reviews_alignment;

        const is_responsive_course_review_alignment = props.course_reviews_alignment_last_edited && props.course_reviews_alignment_last_edited.startsWith('on');

        const course_review_alignment_tablet = is_responsive_course_review_alignment && props.course_review_alignment_tablet ? props.course_review_alignment_tablet : course_review_alignment;

        const course_review_alignment_phone = is_responsive_course_review_alignment && props.course_review_alignment_phone ? props.course_review_alignment_phone : course_review_alignment;


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
        const review_wrapper = '%%order_class%% #tutor-course-details-tab-reviews';

        if ( props.review_star_color ) {
            additionalCss.push([{
                selector: `${review_wrapper} .tutor-reviews .tutor-review-list-item .tutor-ratings-stars`,
                declaration: `color: ${props.review_star_color} !important;`
            }]);
        }

        additionalCss.push([{
            selector: `${review_wrapper} .tutor-reviews .tutor-review-list-item .tutor-review-comment`,
            declaration: 'margin-top: 12px !important;'
        }]);

        additionalCss.push([{
            selector: `${review_wrapper} .tutor-reviews .tutor-review-list-item .tutor-col-lg-3, ${review_wrapper} .tutor-reviews .tutor-review-list-item .tutor-col-lg-9`,
            declaration: 'padding-left: 12px !important; padding-right: 12px !important;'
        }])

        if ( props.review_background_color ) {
            additionalCss.push([{
                selector: `${review_wrapper} .tutor-reviews .tutor-review-list-item`,
                declaration: `background: ${props.review_background_color} !important;`
            }]);
        }

        additionalCss.push([{
            selector: `${review_wrapper} .tutor-ratings-stars span`,
            declaration: 'margin-left: 3px !important; margin-right: 3px !important;'
        }])

        additionalCss.push([{
            selector: `${review_wrapper} .tutor-review-summary .tutor-col-lg-auto`,
            declaration: 'padding-left: 24px !important; padding-right: 24px !important;'
        }]);

        additionalCss.push([{
            selector: `${review_wrapper} .tutor-review-summary .tutor-col-lg`,
            declaration: 'padding-left: 24px !important; padding-right: 24px !important;'
        }]);

        additionalCss.push([{
            selector: `${review_wrapper} .tutor-review-summary .tutor-review-summary-average-rating`,
            declaration: 'margin-bottom: 20px !important;'
        }]);

        additionalCss.push([{
            selector: `${review_wrapper} .tutor-review-summary .tutor-total-rating-count`,
            declaration: 'margin-top: 12px !important;'
        }]);

        additionalCss.push([{
            selector: `${review_wrapper} .tutor-review-summary-rating .tutor-ratings-average`,
            declaration: 'margin-left: 12px !important;'
        }]);

        additionalCss.push([{
            selector: `${review_wrapper} .tutor-review-summary-rating .tutor-col-auto, ${review_wrapper} .tutor-review-summary-rating .tutor-col, ${review_wrapper} .tutor-review-summary-rating .tutor-col-4`,
            declaration: 'padding-right: 12px !important; padding-left: 12px !important;'
        }]);

        if ( props.review_padding ) {
            const review_padding = props.review_padding.split('|');

             additionalCss.push([{
                selector: `${review_wrapper} .tutor-reviews .tutor-review-list-item`,
                declaration: `padding-top: ${review_padding[0]}; padding-right: ${review_padding[1]}; padding-bottom: ${review_padding[2]}; padding-left: ${review_padding[3]};`,
            }]);
        }

        if ( props.rating_bar_margin ) {
            const rating_bar_margin = props.rating_bar_margin.split('|');

             additionalCss.push([{
                selector: `${review_wrapper} .tutor-review-summary-rating`,
                declaration: `margin-top: ${rating_bar_margin[0]} !important; margin-right: ${rating_bar_margin[1]} !important; margin-bottom: ${rating_bar_margin[2]} !important; margin-left: ${rating_bar_margin[3]} !important;`,
            }]);
        }

        if ( props.review_summary_background_color ) {
            additionalCss.push([{
                selector: `${review_wrapper} .tutor-review-summary`,
                declaration: `background: ${props.review_summary_background_color} !important;`
            }]);
        }
        
        if ( props.review_summary_padding ) {
            const review_summary_padding = props.review_summary_padding.split('|');

             additionalCss.push([{
                selector: `${review_wrapper} .tutor-review-summary`,
                declaration: `padding-top: ${review_summary_padding[0]}; padding-right: ${review_summary_padding[1]}; padding-bottom: ${review_summary_padding[2]}; padding-left: ${review_summary_padding[3]};`,
            }]);
            
        }
        if ( props.review_title_margin ) {
            const review_title_margin = props.review_title_margin.split('|');

             additionalCss.push([{
                selector: `${review_wrapper} h3`,
                declaration: `margin-top: ${review_title_margin[0]} !important; margin-right: ${review_title_margin[1]} !important; margin-bottom: ${review_title_margin[2]} !important; margin-left: ${review_title_margin[3]} !important;`,
            }]);
        }

        additionalCss.push([{
            selector: '%%order_class%% .tutor-is-sticky',
            declaration: 'top: 32px !important; position: sticky !important; backdrop-filter: blur(14px) !important; z-index: 1063 !important;',
        }]);


        additionalCss.push([{
            selector: '%%order_class%% .tutor-accordion .tutor-course-content-list-item-title a',
            declaration: 'color: inherit !important;'
        }]);

        additionalCss.push([
            {    
                selector: `${wrapper} .tutor-accordion-item-header`,
                declaration: 'transition: background-color 300ms ease-in !important;'
            }   
        ]);

        additionalCss.push([
            {    
                selector: `%%order_class%% .tutor-accordion-item .tutor-course-content-list-item-icon`,
                declaration: 'margin-right: 12px !important;'
            }   
        ]);

        additionalCss.push([
            {    
                selector: `%%order_class%% .tutor-accordion-item .tutor-course-content-list-item-status`,
                declaration: 'margin-left: 20px !important;'
            }   
        ]);

        additionalCss.push([
            {
                selector: 'h2,h3,h4,h5',
                declaration: 'padding:0 !important;',
            }
        ]);

        if ( props.lesson_padding ) {

             const lesson_padding = props.lesson_padding.split('|');

            additionalCss.push([{
                selector: lesson_wrapper_selector,
                declaration: `padding-top: ${lesson_padding[0]} !important; padding-right: ${lesson_padding[1]} !important; padding-bottom: ${lesson_padding[2]} !important; padding-left: ${lesson_padding[3]} !important;`,
            }]);
        }

        if ( props.course_topics_padding ) {
            
            const course_topics_padding = props.course_topics_padding.split('|');


            additionalCss.push([{
                selector: `${wrapper} .tutor-accordion-item-header`,
                declaration: `padding-top: ${course_topics_padding[0]} !important; padding-right: ${course_topics_padding[1]} !important; padding-bottom: ${course_topics_padding[2]} !important; padding-left: ${course_topics_padding[3]} !important;`,
            }]);
        }

        if ( props.course_content_title_margin ) {
            const course_content_title_margin = props.course_content_title_margin.split('|');

             additionalCss.push([{
                selector: '%%order_class%% .tutor-course-content-title',
                declaration: `margin-top: ${course_content_title_margin[0]} !important; margin-right: ${course_content_title_margin[1]} !important; margin-bottom: ${course_content_title_margin[2]} !important; margin-left: ${course_content_title_margin[3]} !important;`,
            }]);
        }

        if ( props.course_icon_margin ) {
            const course_icon_margin = props.course_icon_margin.split('|');

            additionalCss.push([{
                selector: benefits_icon_selector,
                declaration: `margin-top: ${course_icon_margin[0]}; margin-right: ${course_icon_margin[1]}; margin-bottom: ${course_icon_margin[2]}; margin-left: ${course_icon_margin[3]};`,
            }]);
        }

        if ( props.about_course_margin ) {
            const about_course_margin = props.about_course_margin.split('|');

            additionalCss.push([{
                selector: about_course,
                declaration: `margin-top: ${about_course_margin[0]}; margin-right: ${about_course_margin[1]}; margin-bottom: ${about_course_margin[2]}; margin-left: ${about_course_margin[3]};`,
            }]);
        }

        if ( props.course_benefit_li_margin ) {
             const course_benefit_li_margin = props.course_benefit_li_margin.split('|');

            additionalCss.push([{
                selector: benefits_li_selector,
                declaration: `margin-top: ${course_benefit_li_margin[0]}; margin-right: ${course_benefit_li_margin[1]}; margin-bottom: ${course_benefit_li_margin[2]}; margin-left: ${course_benefit_li_margin[3]};`,
            }]);
        }

        if ( props.course_tab_padding ) {
            const course_tab_padding = props.course_tab_padding.split('|');

            additionalCss.push([{
                selector: '%%order_class%% .tutor-nav .tutor-nav-link',
                declaration: `padding-top: ${course_tab_padding[0]}; padding-right: ${course_tab_padding[1]}; padding-bottom: ${course_tab_padding[2]}; padding-left: ${course_tab_padding[3]};`,
            }]);
        }

        if ( props.course_tab_margin ) {
             const course_tab_margin = props.course_tab_margin.split('|');

            additionalCss.push([{
                selector: '%%order_class%% .tutor-nav .tutor-nav-link',
                declaration: `margin-top: ${course_tab_margin[0]}; margin-right: ${course_tab_margin[1]}; margin-bottom: ${course_tab_margin[2]}; margin-left: ${course_tab_margin[3]};`,
            }]);
        }
        

        if ( props.course_benefit_margin ) {
            const course_benefit_margin = props.course_benefit_margin.split('|');

            additionalCss.push([{
                selector: benefits_wrapper,
                declaration: `margin-top: ${course_benefit_margin[0]}; margin-right: ${course_benefit_margin[1]}; margin-bottom: ${course_benefit_margin[2]}; margin-left: ${course_benefit_margin[3]};`,
            }]);
        }

        if ( props.course_about_heading_margin ) {
            const course_about_heading_margin = props.course_about_heading_margin.split('|');

            additionalCss.push([{
                selector: heading_selector,
                declaration: `margin-top: ${course_about_heading_margin[0]}; margin-right: ${course_about_heading_margin[1]}; margin-bottom: ${course_about_heading_margin[2]}; margin-left: ${course_about_heading_margin[3]};`,
            }]);
        }

        if ( props.course_benefit_title_margin ) {
            const course_benefit_title_margin = props.course_benefit_title_margin.split('|');

            additionalCss.push([{
                selector: benefits_title,
                declaration: `margin-top: ${course_benefit_title_margin[0]}; margin-right: ${course_benefit_title_margin[1]}; margin-bottom: ${course_benefit_title_margin[2]}; margin-left: ${course_benefit_title_margin[3]};`,
            }]);
        }

        // set course content nav styles
        additionalCss.push([
            {
                selector: nav,
                declaration: 'display:flex !important;',
            }
        ]);

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
                    declaration: `display: ${course_benefits_layout} !important;`
                }
            ])
        }
        if(course_benefits_layout_tablet) {
            additionalCss.push([
                {
                    selector: benefits_li_selector,
                    declaration: `display: ${course_benefits_layout_tablet} !important;`,
                    device: 'tablet'
                }
            ])
        }
        if(course_benefits_layout_phone) {
            additionalCss.push([
                {
                    selector: benefits_li_selector,
                    declaration: `display: ${course_benefits_layout_phone} !important;`,
                    device: 'phone'
                }
            ])
        }

        if ( course_review_alignment ) {
            additionalCss.push([
               {
                    selector: `${review_wrapper} .tutor-review-summary .tutor-col-lg-auto`,
                    declaration: `text-align: ${course_review_alignment} !important;`
               }
            ])
        }

        if ( course_review_alignment_tablet ) {
            additionalCss.push([
               {
                    selector: `${review_wrapper} .tutor-review-summary .tutor-col-lg-auto`,
                    declaration: `text-align: ${course_review_alignment_tablet} !important;`,
                    device: 'tablet',
               }
            ])
        }

        if ( course_review_alignment_phone ) {
            additionalCss.push([
               {
                    selector: `${review_wrapper} .tutor-review-summary .tutor-col-lg-auto`,
                    declaration: `text-align: ${course_review_alignment_phone} !important;`,
                    device: 'phone',
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
        // course benefits styles end

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
      
        if ('' !== props.review_right_star) {
            additionalCss.push([
                {
                    selector: `${rating_right_bar_selector} .tutor-ratings .tutor-ratings-stars`,
                    declaration: `color: ${props.review_right_star} !important;`,
                }
            ]);         
        }      
        if ('' !== props.review_right_bar_height) {
            additionalCss.push([
                {
                    selector: `${rating_right_bar_selector} .tutor-ratings-progress-bar`,
                    declaration: `height: ${props.review_right_bar_height} !important;`,
                }
            ]);         
        }      
        if ('' !== props.review_right_bar_color) {
            additionalCss.push([
                {
                    selector: `${rating_right_bar_selector} .tutor-progress-bar`,
                    declaration: `background-color: ${props.review_right_bar_color};`,
                }
            ]);         
        }      
        if ('' !== props.review_right_bar_fill_color) {
            additionalCss.push([
                {
                    selector: `${rating_right_bar_selector} .tutor-ratings-progress-bar .tutor-progress-value`,
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