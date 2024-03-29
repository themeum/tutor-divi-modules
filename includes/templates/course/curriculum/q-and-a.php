<?php
/**
 * Question and answer in single course details tab
 *
 * @since v.1.0.0
 * @author themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */
$disable_qa_for_this_course = get_post_meta( $args['course'], '_tutor_enable_qa', true ) != 'yes';
$enable_q_and_a_on_course = tutor_utils()->get_option('enable_q_and_a_on_course');
if ( !$enable_q_and_a_on_course || $disable_qa_for_this_course == 'yes') {
	tutor_load_template( 'single.course.q_and_a_turned_off' );
	return;
}

do_action('tutor_course/question_and_answer/before');

echo '<h3>'.__('Question & Answer', 'tutor').'</h3>';

// New qna form
tutor_load_template_from_custom_path(tutor()->path . '/views/qna/qna-new.php', array(
    'course_id' => get_the_ID(),
    'context' => 'course-single-qna-single'
), false);

// Previous qna list
$questions = tutor_utils()->get_qa_questions(0, 20);
foreach ($questions as $question) {
    tutor_load_template_from_custom_path(tutor()->path . '/views/qna/qna-single.php', array(
        'question_id' => $question->comment_ID,
        'context' => 'course-single-qna-single'
    ), false);
}

do_action('tutor_course/question_and_answer/after');