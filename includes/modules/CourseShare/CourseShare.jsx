// External Dependencies
import React, { Component, Fragment } from 'react';

class CourseShare extends Component {

    static slug = 'tutor_course_share';
    
    labelTemplate(props) {
        if(props.share_label === 'off') {
            return '';
        }
        return (
            <label>
                Share:
            </label>
        );
    }

    template(props) {
        
        if(!props.__share.is_enable_share) {
            return (
                <div>
                    <div className="tutor-single-course-meta tutor-meta-top">
                    <ul>
                        <li className="tutor-social-share">

                            { this.labelTemplate(props) }

                            <div className="social-share-wrap">
                                <button className="s-facebook">
                                    <i className="tutor-icon-facebook"></i>
                                </button>
                                <button className="s-linkedin">
                                    <i className="tutor-icon-linkedin"></i>
                                </button>
                                <button className="s-tumblr">
                                    <i className="tutor-icon-tumblr"></i>
                                </button>
                                <button className="s-twitter">
                                    <i className="tutor-icon-twitter"></i>
                                </button>
                            </div>
                        </li>
                    </ul>
                    </div>
                </div>
            );
        } else {
            return '';
        }
    }

    static css(props) {
        const additionalCss = [];

        //selectors
        const wrapper = '%%order_class%% .tutor-social-share';
        const icon_wrapper_selector = '%%order_class%% .social-share-wrap';
        const label_selector = '%%order_class%% .tutor-social-share > label';

        //props
        const display = 'flex';
        let alignment = props.alignment;

        if(alignment === 'left') {
            alignment = 'flex-start';
        } else if(alignment === 'center') {
            alignment = 'center';
        } else if(alignment === 'right') {
            alignment = 'flex-end';
        } else {
            alignment = 'flex-start';
        }

        let is_responsive_alignment = props.alignment_last_edited && props.alignment_last_edited.startsWith('on');

        let alignment_tablet = is_responsive_alignment ? props.alignment_tablet : alignment;
        if(alignment_tablet === 'left') {
            alignment_tablet = 'flex-start';
        } else if(alignment_tablet === 'center') {
            alignment_tablet = 'center';
        } else if(alignment_tablet === 'right') {
            alignment_tablet = 'flex-end';
        } else {
            alignment_tablet = 'flex-start';
        }

        let alignment_phone = is_responsive_alignment ? props.alignment_phone : alignment;
        if(alignment_phone === 'left') {
            alignment_phone = 'flex-start';
        } else if(alignment_phone === 'center') {
            alignment_phone = 'center';
        } else if(alignment_phone === 'right') {
            alignment_phone = 'flex-end';
        } else {
            alignment_phone = 'flex-start';
        }
        
        //set styles 
        additionalCss.push([
            {
                selector: wrapper,
                declaration: `display: ${display};`
            }
        ]);
        
        additionalCss.push([
            {
                selector: wrapper,
                declaration: `column-gap: 10px;`
            }
        ]);

        if(alignment) {
            additionalCss.push([
                {
                    selector: wrapper,
                    declaration: `justify-content: ${alignment};`
                }
            ]);            
        }

        if(alignment_tablet) {
            additionalCss.push([
                {
                    selector: wrapper,
                    declaration: `justify-content: ${alignment_tablet};`,
                    device: 'tablet'
                }
            ]);            
        }
        if(alignment_phone) {
            additionalCss.push([
                {
                    selector: wrapper,
                    declaration: `justify-content: ${alignment_phone};`,
                    device: 'phone'
                }
            ]);            
        }
        //set styles end
        return additionalCss;
    }

    render() {
        
        if(!this.props.__share) {
            return '' ;
        }
        return (
            <Fragment>
                { this.template(this.props) }
            </Fragment>
        );
    }
}

export default CourseShare;