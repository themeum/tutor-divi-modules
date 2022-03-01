import React ,{ Component, Fragment } from "react";

class CourseTags extends Component {

    static slug = "tutor_course_tags";

    tagTemplate(tags) {
        if(tags.length) {
            const tag = tags.map((tag) => {
                return <a href={tag.slug} dangerouslySetInnerHTML={{__html: tag.name}}></a>
            });
            return tag;
        }
    }

    static css(props) {
        //selectors
        const additionalCss = [];
        const tags_selector		= '%%order_class%% .tutor-course-tags a';

        //props
        const background        = props.tags_background;
        const background_hover  = props.tags_background__hover_enabled && props.tags_background__hover_enabled.startsWith('on') ? props.tags_background__hover : background;

        //set style
        if(background) {
            additionalCss.push([
                {
                    selector: tags_selector,
                    declaration: `background-color: ${background} !important;`
                }
            ]);
        }

        if(background_hover) {
            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-course-tags a:hover`,
                    declaration: `background-color: ${background_hover} !important;`
                }
            ]);        
        }
        // default tag style
        additionalCss.push([
            {
                selector:'%%order_class%% .tutor-course-tags a',
                declaration: 'font-size: 16px;line-height: 26px;text-decoration: none;padding: 7px 23px;border: 1px solid #c0c3cb;color: #5b616f;margin-left: 15px;border-radius: 6px;-webkit-transition: 200ms;transition: 200ms;background-color: #fff;',
            }
        ]);
        return additionalCss;
    }

    render() {
        if(!this.props.__tags) {
            return '';
        }
       
        return (
            <Fragment>
                <div class="tutor-single-course-segment tutor-divi-course-tags-wrapper">
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