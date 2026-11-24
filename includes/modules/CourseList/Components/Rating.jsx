import React from 'react';

export default function Rating(props) {
    const {data} = props;
    if(data.show === 'off') {
        return '';
    }
    const ratings = [];
    for(let i=1; i < 6; i++) {
        if(data.rating.avg_rating >= i) {
            ratings.push(<span className='tutor-icon-star-bold'></span>)
        } else {
            ratings.push(<span className='tutor-icon-star-line'></span>)
        }
    }
    return(
        <div class="tutor-ratings">
            <div class="tutor-ratings-stars">
                {ratings}
            </div>
            { data.rating.rating_avg === 0 ? '' : <div class="tutor-ratings-average">{data.rating.rating_avg}</div>}
            { data.rating.rating_count === 0 ? '' : <div class="tutor-ratings-count">({data.rating.rating_count})</div>}
        </div>
    );
}