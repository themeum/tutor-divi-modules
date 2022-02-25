// External Dependencies
import React, { Component } from "react";

class CourseWishlist extends Component {
  static slug = "tutor_course_wishlist";

  static css(props) {
      const additionalCss = [];
      const wrapper_selector = "%%order_class%% .dtlms-course-wishlist-wrapper a";
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

      return additionalCss;
  }

  render() {
    if (!this.props.__wishlist) {
      return "";
    }
    return(<div dangerouslySetInnerHTML={{ __html: this.props.__wishlist }}></div>);
  }
}

export default CourseWishlist;
