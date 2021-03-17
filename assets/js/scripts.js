/**
 * Tutor Divi Modules
 * course curricle on click toggle icon
 * @since 1.0.0
 */
 const collaps_icon    = document.querySelector("#tutor_divi_col_icon").value;
 const expand_icon     = document.querySelector("#tutor_divi_exp_icon").value;

 let divs = document.querySelectorAll(".tutor-divi-course-topic").forEach((div)=> {
        div.onclick = (e) => {
        let icon =  e.currentTarget.querySelector("#tutor_divi_topic_icon");
        let icon_type = icon.textContent;
            if( icon_type == collaps_icon) {
                icon.textContent = expand_icon;
            
            } else if (icon_type == expand_icon) {
                icon.textContent = collaps_icon;
            }
        }
 });

