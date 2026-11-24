import React ,{ Component, Fragment } from "react";

class CourseTags extends Component {

    static slug = "tutor_course_tags";

    tagTemplate(tags) {
        if(tags.length) {
            const tag = tags.map((tag) => {
                return (
                    <li>
                        <a href={tag.slug} dangerouslySetInnerHTML={{__html: tag.name}}></a>
                    </li>
                )
            });
            return tag;
        }
    }

    static css(props) {
        //selectors
        const additionalCss = [];
        const tags_selector		= '%%order_class%% .tutor-tag-list a';
        const tag_list = '%%order_class%% .tutor-tag-list';
        const wrapper = '%%order_class%% .tutor-divi-course-tags-wrapper';
        const tag_title_selector = `${wrapper} .tutor-segment-title`;

        //props
        const background        = props.tags_background;
        const background_hover  = props.tags_background__hover_enabled && props.tags_background__hover_enabled.startsWith('on') ? props.tags_background__hover : background;

        const gap = props.gap;
        const is_responsive_gap = props.gap_last_edited && props.gap_last_edited.startsWith("on");
        const gap_tablet = is_responsive_gap && props.gap_tablet ? props.gap_tablet : gap;
        const gap_phone = is_responsive_gap && props.gap_phone ? props.gap_phone : gap;

         if ( props.tags_margin ) {
            const tags_margin = props.tags_margin.split('|');
            const tags_margin_last_edited = props.tags_margin_last_edited;
            const tags_margin_responsive_active = tags_margin_last_edited && tags_margin_last_edited.startsWith('on');

            additionalCss.push([{
                selector: tag_list,
                declaration: `margin-top: ${tags_margin[0]}; margin-right: ${tags_margin[1]}; margin-bottom: ${tags_margin[2]}; margin-left: ${tags_margin[3]};`,
            }]);


            if ( props.tags_margin_tablet && '' !==  props.tags_margin_tablet && tags_margin_responsive_active ) {

                const tags_margin_tablet = props.tags_margin_tablet.split('|');

                 additionalCss.push([{
                    selector: tag_list,
                    declaration: `margin-top: ${tags_margin_tablet[0]}; margin-right: ${tags_margin_tablet[1]}; margin-bottom: ${tags_margin_tablet[2]}; margin-left: ${tags_margin_tablet[3]};`,
                    device: 'tablet'
                }]);
            }

             if ( props.tags_margin_phone && '' !==  props.tags_margin_phone && tags_margin_responsive_active ) {

                const tags_margin_phone = props.tags_margin_phone.split('|');

                 additionalCss.push([{
                    selector: tag_list,
                    declaration: `margin-top: ${tags_margin_phone[0]}; margin-right: ${tags_margin_phone[1]}; margin-bottom: ${tags_margin_phone[2]}; margin-left: ${tags_margin_phone[3]};`,
                    device: 'phone'
                }]);
            }

        }

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
                    selector: `%%order_class%% .tutor-tag-list a:hover`,
                    declaration: `background-color: ${background_hover} !important;`
                }
            ]);        
        }
        // default tag style
        additionalCss.push([
            {
                selector:'%%order_class%% .tutor-tag-list a',
                declaration: 'font-size: 16px;line-height: 26px;text-decoration: none;padding: 7px 23px;border: 1px solid #c0c3cb;color: #5b616f;border-radius: 6px;-webkit-transition: 200ms;transition: 200ms;background-color: #fff;',
            }
        ]);


        if(gap) {
            additionalCss.push([
                {
                    selector: tag_title_selector,
                    declaration: `margin-bottom: ${gap};`
                }
            ]);            
        }

        if(gap_tablet) {
            additionalCss.push([
                {
                    selector: tag_title_selector,
                    declaration: `margin-bottom: ${gap_tablet};`,
                    device: 'tablet'
                }
            ]);            
        }
        if(gap_phone) {
            additionalCss.push([
                {
                    selector: tag_title_selector,
                    declaration: `margin-bottom: ${gap_phone};`,
                    device: 'phone'
                }
            ]);            
        }

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
                    <ul class="tutor-tag-list">
                        { this.tagTemplate(this.props.__tags.tags) }
                    </ul>
                </div>
            </Fragment>            
        );
    }
}
export default CourseTags;