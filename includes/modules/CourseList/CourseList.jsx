
import React, {Component, Fragment} from 'react';


class CourseList extends Component {

    static slug = 'tutor_course_list';

    static css(props) {
        const additionalCss = [];

        //selectors
        const wrapper               = "%%order_class%% .tutor-divi-courselist-main-wrap";
        const card_selector         = `${wrapper} .tutor-divi-card`;
        const footer_selector       = `${wrapper} .tutor-loop-course-footer`;
        const badge_selector        = `${wrapper} .tutor-course-loop-level`;
        const avatar_selector       = `%%order_class%% .tutor-single-course-avatar a img, %%order_class%% .tutor-single-course-avatar a span, %%order_class%% .tutor-single-course-avatar .tutor-text-avatar, %%order_class%% .tutor-single-course-avatar img`;
        const star_selector         = `${wrapper} .tutor-loop-rating-wrap .tutor-rating-stars span`;
        const star_wrapper_selector = `${wrapper} .tutor-loop-rating-wrap .tutor-rating-stars`;
        const cart_button_selector  = `${wrapper} .tutor-loop-cart-btn-wrap a`;
        const arrows_selector       = '%%order_class%% .slick-prev:before, %%order_class%% .slick-next:before';
        const dots_wrapper_selector = '%%order_class%% .slick-dots';

        const pagination_selector   = '%%order_class%% .tutor-divi-courselist-pagination span,%%order_class%% .tutor-divi-courselist-pagination a'
        const pagination_active_selector   = '%%order_class%% .tutor-divi-courselist-pagination .current';

        //props
        const skin                      = props.skin;
        const hover_animation           = props.hover_animation;
        const card_background_color     = props.card_background_color;

        const footer_seperator_width    = props.footer_seperator_width
        const footer_seperator_color    = props.footer_seperator_color

        const card_custom_padding       = props.card_custom_padding;

        const image_spacing             = props.image_spacing;

        const badge_background_color    = props.badge_background_color;
        const badge_text_color          = props.badge_text_color;
        const badge_margin              = props.badge_margin;
        const badge_size                = props.badge_size;

        const avatar_size               = props.avatar_size;

        const star_color                = props.star_color;
        const star_size                 = props.star_size;
        const star_gap                  = props.star_gap;

        const footer_background         = props.footer_background;
        const footer_padding            = props.footer_padding;

        let dots_alignment              = props.dots_alignment;
        const dots_space                = props.dots_space;

        const arrows_padding            = props.arrows_padding;

        const pagination_normal_color   = props.pagination_normal_color;
        const pagination_normal_back    = props.pagination_normal_back;        
        const pagination_hover_color    = props.pagination_hover_color;
        const pagination_hover_back     = props.pagination_hover_back;       
        const pagination_active_color   = props.pagination_active_color;
        const pagination_active_back    = props.pagination_active_back;
        const pagination_padding        = props.pagination_padding;

        const columns_gap               = props.columns_gap;
        const rows_gap                  = props.rows_gap;

        //set styles
        //default margin for hover animation
            additionalCss.push([
                {
                    selector: `%%order_class%% 
                        .tutor-divi-card.hover-animation`,
                    declaration: `margin-top: 7px;`
                }
            ]);

        //card hover animation
        if(hover_animation === 'on') {
            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-divi-card.hover-animation`,
					declaration: `position: relative; top: 0; z-index: 99; transition: top .5s;`
                }
            ]);
            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-divi-card.hover-animation:hover`,
					declaration: `top: -5px;`
                }
            ]);
        }

        //card toogle style
        //prepare header for background overlay & css filters
        additionalCss.push([
            {
                selector: '%%order_class%% .tutor-divi-courselist-classic .tutor-course-header:before,%%order_class%% .tutor-divi-courselist-card .tutor-course-header:before, %%order_class%% .tutor-divi-courselist-stacked .tutor-course-header:before',
                declaration: 'width: 100%;height: 100%; position: absolute;content: "";z-index: 2;'  
            }
        ]);
        if('' !== card_background_color) {
            additionalCss.push([
                {
                    selector: card_selector,
                    declaration: `background-color: ${card_background_color};`
                }
            ]);
        }

        if('' !== footer_seperator_width) {
            additionalCss.push([
                {
                    selector: footer_selector,
                    declaration: `border-top: ${footer_seperator_width} solid;`
                }
            ]);
        }

        if('' !== footer_seperator_color) {
            additionalCss.push([
                {
                    selector: footer_selector,
                    declaration: `color: ${footer_seperator_color};`
                }
            ]);
        }

        if('' !== card_custom_padding) {
            additionalCss.push([
                {
                    selector: card_selector,
                    declaration: `padding: ${card_custom_padding};`
                }
            ]);
        }
        //make list item equal height
        if('classic' === skin || 'card' === skin) {
        	additionalCss.push([
        		{
        			selector: `%%order_class%% .tutor-divi-courselist-classic .tutor-divi-card, %%order_class%% .tutor-divi-courselist-card .tutor-divi-card`,
        			declaration: 'display: -webkit-box;display: -ms-flexbox; display: flex;-webkit-box-orient: vertical;-webkit-box-direction: normal;-ms-flex-direction: column;flex-direction: column;-webkit-box-pack: justify;-ms-flex-pack: justify;justify-content: space-between;height: 100%;'
        		}
        	]);
        }

        //card layout styles
        //classic style
        if(skin === 'classic') {
            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-divi-courselist-classic .tutor-divi-card`,
                    declaration: `border-radius: 8px;
                        border: 1px solid #EBEBEB;
                        overflow: hidden;`
                }
            ]);            

            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-divi-courselist-classic .tutor-divi-card:hover`,
                    declaration: `-webkit-box-shadow: 0px 5px 2px #ebebeb;
                        box-shadow: 0px 5px 2px #ebebeb;`
                }
            ]);
        }

        //card style
        if(skin === 'card') {
            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-divi-courselist-card .tutor-divi-card`,
                    declaration: `
                        -webkit-box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.08);
                                box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.08);
                        border-radius: 8px;
                        overflow: hidden;`
                }  
            ]);

            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-divi-courselist-card .tutor-divi-card:hover`,
                    declaration: `-webkit-box-shadow:0px 24px 34px -5px rgba(0, 0, 0, 0.1);
                        box-shadow:0px 24px 34px -5px rgba(0, 0, 0, 0.1);`
                }
            ]);

        }

        //stacked style
        if(skin === 'stacked') {
            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-divi-courselist-stacked .tutor-course-header`,
                    declaration: `border-radius: 10px;
                        overflow: hidden; z-index: 1;`                    
                }
            ]);

            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-divi-courselist-stacked .tutor-divi-card`,
                    declaration: `overflow: visible !important;`  
                }
            ]);

            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-divi-courselist-stacked .tutor-divi-courselist-course-container`,
                    declaration: `z-index: 99;
                        margin-top: -80px;
                        background: white;
                        width: 80%;
                        margin-left: auto;
                        margin-right: auto;
                        position: relative;
                        border-radius: 10px;
                        -webkit-box-shadow: 0px 34px 28px -20px rgba(0, 0, 0, 0.15);
                                box-shadow: 0px 34px 28px -20px rgba(0, 0, 0, 0.15);`                    
                }
            ]);

            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-divi-courselist-stacked .tutor-divi-courselist-course-container:hover`,
                    declaration: `-webkit-box-shadow: 0px 54px 58px -20px rgba(0, 0, 0, 0.15);
                        box-shadow: 0px 54px 58px -20px rgba(0, 0, 0, 0.15);`
                }
            ]);
        }   
        //overlayed style
        if(skin === 'overlayed') {
            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-divi-courselist-overlayed .tutor-divi-card`,
                    declaration: `background-size: cover;
                        background-repeat: no-repeat;
                        border-radius: 20px;
                        position: relative;
                        height: 300px;
                        overflow: hidden;`
                }
            ]);            

            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-divi-courselist-overlayed .tutor-divi-card:before`,
                    declaration: `background-image: -o-linear-gradient(top, rgba(0, 0, 0, 0.0001) 0%, #000000 100%);
                        background-image: -webkit-gradient(linear, left top, left bottom, from(rgba(0, 0, 0, 0.0001)), to(#000000));
                        background-image: linear-gradient(180deg, rgba(0, 0, 0, 0.0001) 0%, #000000 100%) !important;
                        
                        position: absolute;
                        content: "";
                        left: 0;
                        top: 0;
                        bottom: 0;
                        right: 0;
                        z-index: 3;
                        -webkit-transition: .4s;
                        -o-transition: .4s;
                        transition: .4s;`
                }
            ]);            

            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-divi-courselist-overlayed .tutor-course-header`,
                    declaration: `z-index: 2;
                        height: 100%;`
                }
            ]);            

            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-divi-courselist-overlayed .tutor-divi-courselist-course-container`,
                    declaration: `position: absolute;
                        z-index: 99;
                        width: 100%;
                        bottom:0 !important;`
                }
            ]);            

            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-divi-card .tutor-rating-count,
                        %%order_class%% .tutor-divi-card .tutor-course-loop-title h2 a,
                        %%order_class%% .tutor-divi-card .tutor-course-loop-meta,
                        %%order_class%% .tutor-divi-card .tutor-loop-author>div a,
                        %%order_class%% .tutor-divi-card .etlms-loop-cart-btn-wrap a,
                        %%order_class%% .tutor-divi-card .price, %%order_class%% .tutor-loop-cart-btn-wrap a, %%order_class%% .tutor-loop-cart-btn-wrap a:before`,
                    declaration: `color: #fff !important;` 
                }
            ]);            

            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-divi-courselist-overlayed .tutor-divi-card:hover`,
                    declaration: `-webkit-box-shadow: 0px 8px 28px 0px #d0d0d0;
                        box-shadow: 0px 8px 28px 0px #d0d0d0;` 
                }
            ]);            

        } 
        //card layouts style end

        //image toggle
        if('' !== image_spacing) {
            additionalCss.push([
                {
                    selector: `%%order_class%% .tutor-course-header a img`,
                    declaration: `padding: ${image_spacing};`
                }
            ]);
        }

        //badge toggle
        if('' !== badge_background_color) {
            additionalCss.push([
                {
                    selector: badge_selector,
                    declaration: `background-color: ${badge_background_color};`
                }
            ]);
        }        

        if('' !== badge_text_color) {
            additionalCss.push([
                {
                    selector: badge_selector,
                    declaration: `color: ${badge_text_color};`
                }
            ]);
        }        

        if('' !== badge_margin) {
            additionalCss.push([
                {
                    selector: badge_selector,
                    declaration: `margin: ${badge_margin};`
                }
            ]);
        }        

        if('' !== badge_size) {
            additionalCss.push([
                {
                    selector: badge_selector,
                    declaration: `width: ${badge_size};`
                }
            ]);
        }
        if('' !== avatar_size) {
            additionalCss.push([
                {
                    selector: avatar_selector,
                    declaration: `width: ${avatar_size};height: ${avatar_size}; line-height: ${avatar_size};`
                }
            ]);
        }
        //avatar toggle

        //rating toggle
        additionalCss.push([
            {
                selector: star_wrapper_selector,
                declaration: `display: flex;`
            }
        ]);

        if('' !== star_color) {
            additionalCss.push([
                {
                    selector: star_selector,
                    declaration: `color: ${star_color};`
                }
            ]);
        }        

        if('' !== star_size) {
            additionalCss.push([
                {
                    selector: star_selector,
                    declaration: `font-size: ${star_size};`
                }
            ]);
        }        

        if('' !== star_gap) {
            additionalCss.push([
                {
                    selector: star_wrapper_selector,
                    declaration: `column-gap: ${star_gap};`
                }
            ]);
        }

        //footer toggle
        if('' !== footer_background) {
            additionalCss.push([
                {
                    selector: footer_selector,
                    declaration: `background-color: ${footer_background};`
                }
            ]);
        }

        if('' !== footer_padding) {
            additionalCss.push([
                {
                    selector: footer_selector,
                    declaration: `padding: ${footer_padding};`
                }
            ]);
        }
        //cart button toggle
        additionalCss.push([
            {
                selector: cart_button_selector,
                declaration: 'border-style: solid;'
            }
        ]);

        //arrows toggle
        //arrows default color #000
        additionalCss.push([
            {
                selector: arrows_selector,
                declaration: 'color: #000;'
            }
        ]);

        if('' !== arrows_padding) {
            additionalCss.push([
                {
                    selector: arrows_selector,
                    declaration: `padding: ${arrows_padding};`
                }
            ])
        }

        //dots toggle
        if(dots_alignment === 'left') {
            dots_alignment = 'flex-start';
        } else if( dots_alignment === 'right') {
            dots_alignment = 'flex-end';
        }
        additionalCss.push([
            {
                selector: dots_wrapper_selector,
                declaration: `display:flex !important; justify-content: ${dots_alignment}; column-gap: ${dots_space};`
            }
        ]);

      	//single column style
      	additionalCss.push([
	      	{
	      		selector: '%%order_class%% .tutor-divi-courselist-style',
	      		declaration: 'display: -webkit-box !important;display: -ms-flexbox !important;display: flex !important;-webkit-box-orient: horizontal !important;-webkit-box-direction: normal !important;-ms-flex-direction: row !important;flex-direction: row !important;-ms-flex-wrap: nowrap !important;flex-wrap: nowrap !important;height: 255px;'
	      	}
      	]);      	

      	additionalCss.push([
	      	{
	      		selector: '%%order_class%% .tutor-divi-courselist-style .tutor-course-header',
	      		declaration: 'max-width: 40%;-webkit-box-flex: 0 !important;-ms-flex: 0 0 40% !important;flex: 0 0 40% !important;height: 255px;'
	      	}
      	]);      	

      	additionalCss.push([
	      	{
	      		selector: '%%order_class%% .tutor-divi-courselist-style .tutor-divi-courselist-course-container',
	      		declaration: 'max-width: 60%;-webkit-box-flex: 0 !important;-ms-flex: 0 0 60% !important;flex: 0 0 60% !important;display: -webkit-box;display: -ms-flexbox;display: flex;-webkit-box-orient: vertical;-webkit-box-direction: normal;-ms-flex-direction: column;flex-direction: column;'
	      	}
      	]);      	

      	additionalCss.push([
	      	{
	      		selector: '%%order_class%% .tutor-divi-courselist-style .tutor-divi-courselist-footer',
	      		declaration: 'margin-top: auto;'
	      	}
      	]);      	

      	additionalCss.push([
	      	{
	      		selector: '%%order_class%% .tutor-divi-courselist-stacked .tutor-divi-courselist-style .tutor-divi-courselist-course-container',
	      		declaration: 'margin: auto 0 auto -42px;'
	      	}
      	]);

        //pagination_styles toggle
        //pagination default style center
        additionalCss.push([
            {
                selector: '%%order_class%% .tutor-divi-courselist-pagination',
                declaration: 'text-align:center;'
            }
        ]);
        if('' !== pagination_padding) {
            additionalCss.push([
                {
                    selector: pagination_selector,
                    declaration: `padding: ${pagination_padding};`
                }
            ]);
        }

        if('' !== pagination_normal_color) {
            additionalCss.push([
                {
                    selector: pagination_selector,
                    declaration: `color: ${pagination_normal_color};`
                }
            ]);
        }        

        if('' !== pagination_normal_back) {
            additionalCss.push([
                {
                    selector: pagination_selector,
                    declaration: `background-color: ${pagination_normal_back};`
                }
            ]);
        }        

        if('' !== pagination_hover_color) {
            additionalCss.push([
                {
                    selector: `${pagination_selector}:hover`,
                    declaration: `color: ${pagination_hover_color};`
                }
            ]);
        }        

        if('' !== pagination_hover_back) {
            additionalCss.push([
                {
                    selector: `${pagination_selector}:hover`,
                    declaration: `background-color: ${pagination_hover_back};`
                }
            ]);
        }

        if('' !== pagination_active_color) {
            additionalCss.push([
                {
                    selector: pagination_active_selector,
                    declaration: `color: ${pagination_active_color} !important;`
                }
            ]);
        }        

        if('' !== pagination_active_back) {
            additionalCss.push([
                {
                    selector: pagination_active_selector,
                    declaration: `background-color: ${pagination_active_back} !important;`
                }
            ]);
        } 

        //masonry styles 
        if(props.masonry === 'on') {
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-divi-masonry.tutor-courses-layout-2',
                    declaration: '-webkit-column-count: 2;-moz-column-count: 2;column-count: 2;-webkit-column-gap: 10px;-moz-column-gap: 10px;column-gap: 10px;'
                }
            ]);          

            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-divi-masonry.tutor-courses-layout-3',
                    declaration: '-webkit-column-count: 3 ;-moz-column-count: 3 ;column-count: 3 ;-webkit-column-gap: 10px;-moz-column-gap: 10px;column-gap: 10px;'
                }
            ]);        

            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-divi-masonry.tutor-courses-layout-4',
                    declaration: '-webkit-column-count: 4;-moz-column-count: 4;column-count: 4;-webkit-column-gap: 10px;-moz-column-gap: 10px;column-gap: 10px;'
                }
            ]);         

            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-divi-masonry.tutor-courses-layout-5',
                    declaration: '-webkit-column-count: 5;-moz-column-count: 5;column-count: 5;-webkit-column-gap: 10px;-moz-column-gap: 10px;column-gap: 10px;'
                }
            ]);         

            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-divi-masonry .tutor-divi-courselist-col',
                    declaration: 'display: inline-block;width: auto;position: relative;top: 5px;'
                }
            ]);        

            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-divi-masonry.tutor-divi-courselist-overlayed .tutor-divi-card',
                    declaration: 'height: auto !important;min-height: 180px;'
                }
            ]);             
        }

        //layout_styles toggle
        if('' !== columns_gap) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-divi-courselist-col',
                    declaration: `padding: 0 ${columns_gap};`
                }
            ]);
        }        

        if('' !== rows_gap) {
            additionalCss.push([
                {
                    selector: '%%order_class%% .tutor-divi-courselist-col',
                    declaration: `margin-bottom: ${rows_gap};`
                }
            ]);
        }
        //filter
        additionalCss.push([
            {
                selector: '%%order_class%% .tutor-course-header a img',
                declaration: `filter: hue-rotate(${props.child_filter_hue_rotate}) saturate(${props.child_filter_saturate}) brightness(${props.child_filter_brightness}) invert(${props.child_filter_invert}) sepia(${props.child_filter_sepia}) opacity(${props.child_filter_opacity}) blur(${props.child_filter_blur}) contrast(${props.child_filter_contrast});`
            },
            {
                selector: '%%order_class%% .tutor-loop-cart-btn-wrap a::before',
                declaration: 'content: "" ',
            },
            {
                selector: '%%order_class%% .list-item-price .price',
                declaration: 'display: flex;',
            }
        ]);
        //set styles end
        return additionalCss;
    }
    /**
     * @return total ratings star
     * @param avg_rating
     */
    ratingStars(show,avg_rating) {
        if(show === 'off') {
            return '';
        }
        const ratings = [];
        for(let i=1; i < 6; i++) {
            if(avg_rating >= i) {
                ratings.push(<span className='tutor-icon-star-full-filled'></span>)
            } else {
                ratings.push(<span className='tutor-icon-star-line-filled'></span>)
            }
        }
        return ratings;
    }

    thumbnailTemplate(show,course) {
        if(show === 'off') {
            return '';
        }
        return (
        <a href="/">
            <img src={course.post_thumbnail} alt="thumbnail"/>
        </a> 
        );
    }

    levelTemplate(show,level) {
        if(show === 'off') {
            return ''
        }
        return (
            <span className="tutor-course-loop-level">{level}</span>
        );
    }
    metaTemplate(show,course) {
        if(show === 'off') {
            return '';
        }
        return (
            <Fragment>
                <div className="tutor-single-loop-meta">
                    <i className='meta-icon tutor-icon-user-filled tutor-color-text-hints'></i>
                    <span> {course.enroll_count} </span>
                </div>
                <div className="tutor-single-loop-meta">
                    <i className='meta-icon tutor-icon-clock-filled tutor-color-text-hints'></i> 
                    <span dangerouslySetInnerHTML={{__html: course.course_duration}}></span>
                </div>
            </Fragment>
            
        );
    }
    
    avatarTemplate(show,avatar) {
        if(show === 'off') {
            return '';
        }
        return (
            <div className="tutor-single-course-avatar" dangerouslySetInnerHTML={{__html: avatar}}>
                                            
            </div>
        );
    }

    wishlistTemplate(show) {
        if(show === 'off') {
            return ''
        }
        return(
        <span className="tutor-course-wishlist">
            <span className="tutor-icon-fav-line-filled tutor-course-wishlist-btn  "></span> 
        </span>
        );
    }

    categoryTemplate(show,course_cat) {
        if(show === 'off') {
            return '';
        }
        const categories = course_cat.map((category) => {
            return (
                <a href="/">{ category.name }</a>
            );
        })
        return categories
    }

    footerButtonText(is_enrolled, course) {
        if(is_enrolled) {
            return 'Continue Course';
        } 
        if(course.loop_price.regular_price !== '' && course.loop_price.regular_price !== 'Free' ) {
            return 'Add to Cart';
        } else {
            return 'Get Enrolled';
        }
    }

    /**
     * 
     * @param {*} props 
     * @returns course template
     */
    courseTemplate(props) {
    	const hover_animation 	= props.hover_animation === 'on' ? 'hover-animation' : '';
    	const single_style		= props.columns === '1' ? 'tutor-divi-courselist-style' : '';

        const courses 			= props.__courses.courses.map((course) => {
            return (
            <div className={`tutor-course-col-${this.props.columns} tutor-divi-courselist-col`}>
                <div className={`tutor-divi-card ${hover_animation} ${single_style}`}>

                        <div className="tutor-course-header ">
                             { this.thumbnailTemplate(props.show_image,course) }                       
                            <div className="tutor-course-loop-header-meta">
                                    { this.levelTemplate(props.difficulty_label, course.course_level) }
                                    { this.wishlistTemplate(props.wish_list)}
                            </div> 
                        </div>
                    
                        <div className="tutor-divi-courselist-course-container">
                            <div className="tutor-loop-course-container">

                                <div className="tutor-loop-rating-wrap">
                                    <div className="tutor-ratings">
                                        <div className="tutor-rating-stars">
                                            {this.ratingStars(props.rating, course.course_rating.rating_avg)}
                                        </div>
                                    </div>
                                </div>
                            
                                <div className="tutor-course-loop-title">
                                    <h2>
                                        <a href="/">
                                            {course.post_title}
                                        </a>
                                    </h2>
                                </div>
                            
                                <div className="tutor-course-loop-meta">
                                    { this.metaTemplate(props.meta_data,course) }
                                </div>

                                <div className="tutor-loop-author list-item-author tutor-bs-d-flex tutor-bs-align-items-center tutor-mt-30">
                                    { this.avatarTemplate(props.avatar,course.author_avatar) }
                                    <div className='tutor-course-meta text-regular-caption tutor-color-text-subsued'>
                                        <span className="tutor-single-course-author-name tutor-course-meta-name">
                                            <a href="/">By {course.author_name}</a>
                                        </span>
                                        <span className="tutor-course-lising-category">
                                            { course.course_category.length ? <span className='tutor-course-meta-cat'> In </span> : '' }
                                            { this.categoryTemplate(props.category,course.course_category) }
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="tutor-loop-course-footer tutor-divi-courselist-footer" dangerouslySetInnerHTML={{__html: course.footer_template}}>

                            </div>
                        </div> 

                </div>
            </div>    
                             
            );
        })
        return courses;
    }

    paginationTemplate(show, pagination_links) {
    	if(show === 'on') {
    		return (
		        <div className="tutor-divi-courselist-pagination" dangerouslySetInnerHTML={{__html:pagination_links}}>

		        </div> 
    		);
    	}
   		return '';
    }

    render(){
        if(!this.props.__courses) {
            return '';
        }
        const masonry = this.props.masonry === 'on' ? 'tutor-divi-masonry' : 'tutor-courses';
        return (
        <Fragment>

            <div className="tutor-courses-wrap tutor-container tutor-divi-courselist-main-wrap">

                <div className={`tutor-divi-courselist-loop-wrap ${masonry} tutor-courses-loop-wrap tutor-courses-layout-${this.props.columns} tutor-divi-courselist-${this.props.skin}`} id="tutor-divi-slick-responsive">
                    { this.courseTemplate( this.props) }

                </div>  

                { this.paginationTemplate(this.props.pagination, this.props.__courses.pagination) }    

            </div>

        </Fragment>
        );
    }
}

export default CourseList;