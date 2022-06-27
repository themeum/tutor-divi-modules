import React from 'react';

export default function Footer(props) {
    const {data} = props
    if(data.show === 'off') {
        return '';
    }
    return(
        <div class="tutor-card-footer" dangerouslySetInnerHTML={{__html: data.course.footer_template}}></div>
    );
}