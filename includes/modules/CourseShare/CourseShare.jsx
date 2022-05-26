// External Dependencies
import React, { Component } from "react";

class CourseShare extends Component {
  static slug = "tutor_course_share";

  static css(props) {
    const additionalCss = [];

    //selectors
    const wrapper_selector = "%%order_class%% .dtlms-course-share a";
    //const label_selector = '%%order_class%% .tutor-social-share > label';
    const display = "flex";

    let alignment = props.alignment ? props.alignment : 'left';
    const is_responsive_alignment = props.alignment_last_edited && props.alignment_last_edited.startsWith("on");
    const alignment_tablet = is_responsive_alignment && props.alignment_tablet ? props.alignment_tablet : alignment;
    const alignment_phone = is_responsive_alignment && props.alignment_phone ? props.alignment_phone : alignment;

    const space_between = props.space_between;
    const is_responsive = props.space_between_last_edited && props.space_between_last_edited.startsWith("on");
    const space_between_tablet = is_responsive && props.space_between_tablet ? props.space_between_tablet : space_between;
    const space_between_phone = is_responsive && props.space_between_phone ? props.space_between_phone : space_between;
    /**
     * set flex alignment as per default alignment
     * left,right,center | flext-start, fext-end, center
     */
    if (alignment === "left") {
      alignment = "flex-start";
    } else if (alignment === "right") {
      alignment = "flex-end";
    } else {
      alignment = "center";
    }
    if (display) {
      additionalCss.push([
        {
          selector: wrapper_selector,
          declaration: `display: ${display}; align-items: center;`,
        },
      ]);
    }

    if (alignment) {
        additionalCss.push([
            {
                selector: wrapper_selector,
                declaration: `justify-content: ${alignment};`
            }
        ]);
    }
    if (alignment_tablet) {
        additionalCss.push([
            {
                selector: wrapper_selector,
                declaration: `justify-content: ${alignment_tablet};`,
                device: 'tablet',
            }
        ]);
    }
    if (alignment_phone) {
        additionalCss.push([
            {
                selector: wrapper_selector,
                declaration: `justify-content: ${alignment_phone};`,
                device: 'phone'
            }
        ]);
    }

    if (space_between) {
      additionalCss.push([
        {
          selector: wrapper_selector,
          declaration: `column-gap: ${space_between};`
        },
      ]);
    }

    if (space_between_tablet) {
      additionalCss.push([
        {
          selector: wrapper_selector,
          declaration: `column-gap: ${space_between_tablet};`,
          device: "tablet",
        },
      ]);
    }
    if (space_between_phone) {
      additionalCss.push([
        {
          selector: wrapper_selector,
          declaration: `column-gap: ${space_between_phone};`,
          device: "phone",
        },
      ]);
    }
    const social_icon_background = props.social_icon_background;
    const close_button_color = props.close_button_color;
    const close_button_size = props.close_button_size;

    if (social_icon_background) {
      additionalCss.push([
        {
          selector: '%%order_class%% .tutor-social-share-button',
          declaration: `background-color: ${social_icon_background};`
        }
      ]);
    }
    if (close_button_color) {
      additionalCss.push([
        {
          selector: '%%order_class%% .tutor-iconic-btn',
          declaration: `color: ${close_button_color} !important;`
        }
      ]);
    }
    if (close_button_size) {
      additionalCss.push([
        {
          selector: '%%order_class%% .tutor-iconic-btn',
          declaration: `font-size: ${close_button_size} !important;`
        }
      ]);
    }
    //set styles end
    return additionalCss;
  }

  render() {
    if (!this.props.__share) {
      return "";
    }
    return <div dangerouslySetInnerHTML={{ __html: this.props.__share }}></div>;
  }
}

export default CourseShare;
