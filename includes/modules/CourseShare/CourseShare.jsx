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

                            <div className="social-share-wrap tutor-social-share-wrap">
                                <button className="s-facebook">
                                    <i className="tutor-icon-facebook"></i>
                                </button>
                                <button className="s-twitter">
                                    <i className="tutor-icon-twitter"></i>
                                </button>
                                <button className="s-linkedin">
                                    <i className="tutor-icon-linkedin"></i>
                                </button>
                                <button className="s-tumblr">
                                    <i className="tutor-icon-tumblr"></i>
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
        const icon_selector = '%%order_class%% .social-share-wrap i';
        //const label_selector = '%%order_class%% .tutor-social-share > label';

        //props
        const display = 'flex';
        const color = props.color;
        const icon_color = props.icon_color;
        const shape = props.shape;
        const shape_color = props.shape_color;
        const icon_padding = props.icon_padding;
        const icon_hover_color = props.icon_hover_color;
        const shape_hover_color = props.shape_hover_color;

        const icon_size = props.icon_size;
        const is_responsive_icon_size = props.icon_size_last_edited && props.icon_size_last_edited.startsWith('on');
        const icon_size_tablet = is_responsive_icon_size && props.icon_size_tablet ? props.icon_size_tablet : icon_size;
        const icon_size_phone = is_responsive_icon_size && props.icon_size_phone ? props.icon_size_phone : icon_size;

        const icon_spacing = props.icon_spacing;
        const is_responsive_icon_spacing = props.icon_spacing_last_edited && props.icon_spacing_last_edited.startsWith('on');
        const icon_spacing_tablet = is_responsive_icon_spacing && props.icon_spacing_tablet ? props.icon_spacing_tablet : icon_spacing;
        const icon_spacing_phone = is_responsive_icon_spacing && props.icon_spacing_phone ? props.icon_spacing_phone : icon_spacing;

        let icon_border_raidus = props.border_radii_icons.split("|");

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

        /**
         * official social icon
         * set color & background color
         */

        //fb icon style
        additionalCss.push([
            {
                selector: `${icon_wrapper_selector} .tutor-icon-facebook`,
                declaration: `color: #fff; background-color: #3b5998;`
            }
        ]);
        //linkedin icon style
        additionalCss.push([
            {
                selector: `${icon_wrapper_selector} .tutor-icon-linkedin`,
                declaration: `color:#fff;background-color:#0077b5;`
            }
        ]);
        //twitter icon style
        additionalCss.push([
            {
                selector: `${icon_wrapper_selector} .tutor-icon-twitter`,
                declaration: `color:#fff;background-color:#1da1f2;`
            }
        ]);
        //tumblr icon style
        additionalCss.push([
            {
                selector: `${icon_wrapper_selector} .tutor-icon-tumblr`,
                declaration: `color:#fff;background-color:#000;`
            }
        ]);

        //custom color
        if(color === 'custom') {
            if('' !== icon_color) {
                additionalCss.push([
                    {
                        selector: `${icon_wrapper_selector} .tutor-icon-tumblr, ${icon_wrapper_selector} .tutor-icon-facebook, ${icon_wrapper_selector} .tutor-icon-linkedin, ${icon_wrapper_selector} .tutor-icon-twitter`,
                        declaration: `color: ${icon_color} !important;`
                    }
                ]);            
            }
            if('' !== shape_color) {
                additionalCss.push([
                    {
                        selector: `${icon_wrapper_selector} .tutor-icon-tumblr, ${icon_wrapper_selector} .tutor-icon-facebook, ${icon_wrapper_selector} .tutor-icon-linkedin, ${icon_wrapper_selector} .tutor-icon-twitter`,
                        declaration: `background-color: ${shape_color}  !important;`
                    }
                ]);            
            }
        }
        if(icon_padding) {
            additionalCss.push([
                {
                    selector: icon_selector,
                    declaration: `padding: ${icon_padding} !important;`
                }
            ]);            
        }
        //set icon display flex
        additionalCss.push([
            {
                selector: icon_wrapper_selector,
                declaration: `display: flex !important;`
            }
        ]);   
        //icon spacing
        if(icon_spacing) {
            additionalCss.push([
                {
                    selector: icon_wrapper_selector,
                    declaration: `column-gap: ${icon_spacing}!important;`
                }
            ]);              
        }
        if(icon_spacing_tablet) {
            additionalCss.push([
                {
                    selector: icon_wrapper_selector,
                    declaration: `column-gap: ${icon_spacing_tablet}!important;`,
                    device: 'tablet'
                }
            ]);              
        }
        if(icon_spacing_phone) {
            additionalCss.push([
                {
                    selector: icon_wrapper_selector,
                    declaration: `column-gap: ${icon_spacing_phone}!important;`,
                    device: 'phone'
                }
            ]);              
        }

        //icon sizing
        if(icon_size) {
            additionalCss.push([
                {
                    selector: icon_selector,
                    declaration: `font-size: ${icon_size}!important;`
                }
            ]);              
        }
        if(icon_size_tablet) {
            additionalCss.push([
                {
                    selector: icon_selector,
                    declaration: `font-size: ${icon_size_tablet}!important;`,
                    device: 'tablet'
                }
            ]);              
        }
        if(icon_size_phone) {
            additionalCss.push([
                {
                    selector: icon_selector,
                    declaration: `font-size: ${icon_size_phone}!important;`,
                    device: 'phone'
                }
            ]);              
        }

        //icon border raidus 
        if(icon_border_raidus) {
            additionalCss.push([
                {
                    selector: icon_selector,
                    declaration: `border-raidus: ${icon_border_raidus[1]} ${icon_border_raidus[2]} ${icon_border_raidus[3]} ${icon_border_raidus[4]} !important;`
                }
            ]);
        }

        //some space on tutor social icon wrapper
        additionalCss.push([
            {
                selector: '%%order_class%% .tutor-social-share-wrap',
                declaration: 'padding: 20px 0 20px;'
            }
        ]);

        //icon shape style as shape dropdown
        if(shape === 'rounded') {
            additionalCss.push([
                {
                    selector: icon_selector,
                    declaration: 'border-radius: 10%;'
                }
            ]);
        } else if(shape === 'circle') {
            additionalCss.push([
                {
                    selector: icon_selector,
                    declaration: 'border-radius: 100%;'
                }
            ]);            
        } else if(shape === 'square') {
            additionalCss.push([
                {
                    selector: icon_selector,
                    declaration: 'border-radius: none;'
                }
            ]);              
        }

        //icon & shape hover color
        if(icon_hover_color) {
            additionalCss.push([
                {
                    selector: `${icon_selector}:hover`,
                    declaration: `color: ${icon_hover_color} !important;`
                }
            ]);              
        }
        if(shape_hover_color) {
            additionalCss.push([
                {
                    selector: `${icon_selector}:hover`,
                    declaration: `background-color: ${shape_hover_color} !important;`
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