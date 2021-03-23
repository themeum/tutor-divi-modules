import React, { Component, Fragment } from 'react';

class CourseReviews extends Component {

    static slug = "tutor-course-reviews";

    static css(props) {
        const additionalCss = [];
        //selectors
        const avg_star_selector = '%%order_class%% .tutor-col-auto .tutor-star-rating-group i';

        //props
        const review_avg_star_color     = props.review_avg_star_color;
        const review_avg_star_size      = props.review_avg_star_size;

        //set styles
        if('' !== review_avg_star_color) {
            additionalCss.push([
                {
                    selector: avg_star_selector,
                    declaration: `color: ${review_avg_star_color};`
                }
            ]);
        }

        if('' !== review_avg_star_size) {
            additionalCss.push([
                {
                    selector: avg_star_selector,
                    declaration: `font-size: ${review_avg_star_size};`
                }
            ]);
        }

        //set styles end
        return additionalCss;
    }

    /**
     * @return total ratings star
     * @param avg_rating
     */
    ratingStars(avg_rating) {
        const ratings = [];
        for(let i=1; i < 6; i++) {
            if(avg_rating >= i) {
                ratings.push(<i className='tutor-icon-star-full'></i>)
            } else {
                ratings.push(<i className='tutor-icon-star-line'></i>)
            }
        }
        return ratings;
    }

    /**
     * show ratings count by value
     * ex: 1 star rating counted 10 times
     * @param count_by_value
     * @return rating meters 
     */
    ratingMeter(count_by_value) {
        
        const rating_meter = Object.entries(count_by_value).map((k,v)=> {
            let width = count_by_value.k ? '100%' : '0%';
            return (<div className="course-rating-meter">
                    <div className="rating-meter-col">{k[0]} <i className="tutor-icon-star-full"></i></div>
                    <div className="rating-meter-col"></div>
                    <div className="rating-meter-col rating-meter-bar-wrap">
                        <div className="rating-meter-bar">
                            <div className="rating-meter-fill-bar" style={{width:width}}></div>
                        </div>
                    </div>
                    <div className="rating-meter-col rating-text-col">
                        {k[1]} rating
                    </div>
                </div>
            )
        })
        return rating_meter;
    }

    timeAgo(comment_date) {
        const date1 = new Date(comment_date);
        const date2 = new Date();
        const diffTime = Math.abs(date2 - date1);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
        
        if(diffDays >= 30) {
            let month = diffDays / 30;
            console.log(`month ${month}`)
                month = Math.ceil(month);
                
                return `${month} months ago`;
        }
        return `${diffDays} days ago` ;
        
    }

    /**
     * 
     * @param {*} reviews 
     * @return student reviews
     */
    reviewList(reviews) {
        const review_template = reviews.map((review) => {
            let class_name = `tutor-review-individual-item tutor-review-${review.comment_ID}`;
            return (
            <div className={class_name}>
                <div className="review-left">
                    <div className="review-avatar">
                        <img src={review.avatar_url} alt="avatar"/>
                    </div>
                    <div className="tutor-review-user-info">
                        <div className="review-time-name">
                            <p> <a href="<?php echo $profile_url; ?>"> { review.comment_author } </a> </p>
                            <p className="review-meta">
                                { this.timeAgo(review.comment_date) }
                            </p>
                        </div>
                        <div className="individual-review-rating-wrap">
                            <div className="tutor-star-rating-group">
                                {this.ratingStars(review.rating_count)}
                            </div> 
                            
                        </div>
                    </div>
    
                </div>
    
                <div className="review-content review-right">
                    { review.comment_content }
                </div>
            </div>
            );
        })
        return review_template;
    }

    template(props) {
        return (
            <div className="tutor-single-course-segment">
                <div className="course-student-rating-title">
                    <h4 className="tutor-segment-title"> { props.label }</h4>
                </div>
                <div className="tutor-course-reviews-wrap">
                    <div className="tutor-course-student-rating-wrap">
                        <div className="course-avg-rating-wrap">
                            <div className="tutor-row tutor-align-items-center">
                                <div className="tutor-col-auto">
                                    <p className="course-avg-rating">
                                        { props.__reviews.rating_summary.rating_avg }
                                    </p>
                                    <div className="tutor-star-rating-group">
                                        { this.ratingStars(props.__reviews.rating_summary.rating_avg) }
                                    </div>
                                    <p className="tutor-course-avg-rating-total">Total <span> { props.__reviews.rating_summary.rating_count } </span> Ratings</p>

                                </div>
                                <div className="tutor-col">
                                    <div className="course-ratings-count-meter-wrap">
                                        { this.ratingMeter(props.__reviews.rating_summary.count_by_value) }
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>


                    <div className="tutor-course-reviews-list">
                        { this.reviewList(props.__reviews.reviews) }
                    </div>

                </div>
            </div>   
        )
    }

    render() {
        if(!this.props.__reviews) {
            return '';
        }
        console.log(this.props);
        return (
            <Fragment>
                { this.template( this.props )}
            </Fragment>
        );
    }
}
export default CourseReviews;