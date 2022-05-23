// External Dependencies
import React, { Component, Fragment } from "react";

class CourseAuthor extends Component {
  static slug = "tutor_course_author";

  /**
   * All component inline styling.
   *
   * @since 1.0.0
   * @return array
   */
  static css(props) {
    const additionalCss = [];
    const wrapper = "%%order_class%% .tutor-single-course-author-meta";
    const img_selector =
      "%%order_class%% .tutor-avatar, %%order_class%% .tutor-avatar img";
    //const label_selector = '%%order_class%% .tutor-single-course-author-name > span';
    //const name_selector = '%%order_class%% .tutor-single-course-author-name > a';

    const display = "flex";
    const layout = props.layout;
    let alignment = props.author_alignment;

    const avatar_size = props.avatar_size;
    const is_responsive_avatar_size =
      props.avatar_size_last_edited &&
      props.avatar_size_last_edited.startsWith("on");
    const avatar_size_tablet =
      is_responsive_avatar_size && props.avatar_size_tablet
        ? props.avatar_size_tablet
        : avatar_size;
    const avatar_size_phone =
      is_responsive_avatar_size && props.avatar_size_phone
        ? props.avatar_size_phone
        : avatar_size;

    const gap = props.avatar_gap;
    const is_responsive_gap =
      props.avatar_gap_last_edited &&
      props.avatar_gap_last_edited.startsWith("on");
    const gap_tablet =
      is_responsive_gap && props.avatar_gap_tablet
        ? props.avatar_gap_tablet
        : gap;
    const gap_phone =
      is_responsive_gap && props.avatar_gap_phone
        ? props.avatar_gap_phone
        : gap;

    /**
     * set alignment property as per align
     */

    if (alignment === "left") {
      alignment = "flex-start";
    } else if (alignment === "center") {
      alignment = "center";
    } else {
      alignment = "flex-end";
    }

    additionalCss.push([
      {
        selector: wrapper,
        declaration: `display: ${display};`,
      },
    ]);

    if (avatar_size) {
      additionalCss.push([
        {
          selector: img_selector,
          declaration: `height: ${avatar_size};`,
        },
      ]);
      additionalCss.push([
        {
          selector: img_selector,
          declaration: `width: ${avatar_size};`,
        },
        {
          selector:
            "%%order_class%% .tutor-single-course-avatar .tutor-text-avatar",
          declaration: `line-height: ${avatar_size}; text-align: center;`,
        },
      ]);
    }
    additionalCss.push([
      {
        selector:
          "%%order_class%% .tutor-single-course-avatar .tutor-text-avatar",
        declaration: `line-height: ${avatar_size}; text-align: center;`,
      },
    ]);
    if (avatar_size_tablet) {
      additionalCss.push([
        {
          selector: img_selector,
          declaration: `height: ${avatar_size_tablet};`,
          device: "tablet",
        },
      ]);
      additionalCss.push([
        {
          selector: img_selector,
          declaration: `width: ${avatar_size_tablet};`,
          device: "tablet",
        },
      ]);
    }
    if (avatar_size_phone) {
      additionalCss.push([
        {
          selector: img_selector,
          declaration: `height: ${avatar_size_phone};`,
          device: "phone",
        },
      ]);
      additionalCss.push([
        {
          selector: img_selector,
          declaration: `width: ${avatar_size_phone};`,
          device: "phone",
        },
      ]);
    }

    if (layout) {
      additionalCss.push([
        {
          selector: wrapper,
          declaration: `flex-direction: ${layout} !important;`,
        },
      ]);
    }

    if ("" !== alignment && layout === "row") {
      additionalCss.push([
        {
          selector: wrapper,
          declaration: `justify-content: ${alignment} !important;`,
        },
      ]);
    }

    if ("" !== alignment && layout === "column") {
      additionalCss.push([
        {
          selector: wrapper,
          declaration: `align-items: ${alignment} !important;`,
        },
      ]);
    }

    if (gap) {
      additionalCss.push([
        {
          selector: wrapper,
          declaration:
            layout === "row" ? `column-gap: ${gap};` : `row-gap: ${gap};`,
        },
      ]);
    }

    if (gap_tablet) {
      additionalCss.push([
        {
          selector: wrapper,
          declaration:
            layout === "row"
              ? `column-gap: ${gap_tablet};`
              : `row-gap: ${gap_tablet};`,
          device: "tablet",
        },
      ]);
    }

    if (gap_phone) {
      additionalCss.push([
        {
          selector: wrapper,
          declaration:
            layout === "row"
              ? `column-gap: ${gap_phone};`
              : `row-gap: ${gap_phone};`,
          device: "phone",
        },
      ]);
    }

    return additionalCss;
  }

  authorAvatar(props) {
    //conditionally render
    if (props.profile_picture === "on") {
      return (
        <div className="tutor-single-course-avatar">
          <a
            href={this.props.__author.profile_url}
            dangerouslySetInnerHTML={{ __html: props.__author.avatar_url }}
          ></a>
        </div>
      );
    }
  }

  authorName(props) {
    //conditionally render
    if (props.display_name === "on") {
      return (
        <div className="tutor-single-course-author-name">
          <span> By </span>
          <a href={this.props.__author.profile_url}>
            {this.props.__author.author_name}
          </a>
        </div>
      );
    }
  }

  render() {
    if (this.props.__author == null) {
      return "";
    }
    return (
      <Fragment>
        <div className="tutor-single-course-meta tutor-meta-top">
          <ul>
            <li className="tutor-single-course-author-meta">
              {this.authorAvatar(this.props)}
              {this.authorName(this.props)}
            </li>
          </ul>
        </div>
      </Fragment>
    );
  }
}

export default CourseAuthor;
