<?php

/**
* Tutor Course Instructor Module for Divi Builder
* @since 1.0.0
*/
use TutorLMS\Divi\Helper;
class CourseInstructor extends ET_Builder_Module {

	public $slug       = 'tutor_course_instructor';
	public $vb_support = 'on';

	public function init() {
		$this->name = esc_html__( 'Tutor Course Instructor', 'tutor-divi-modules' );
	}

	public function get_fields() {
		return array(
			'course'       	=> Helper::get_field(
				array(
					'default'          => Helper::get_course_default(),
					'computed_affects' => array(
						'__instructor',
					),
				)
			),
			'__instructor'	=> array(
				'type'					=> 'computed',
				'computed_callback'		=> array(
					'CourseInstructor',
					'get_props'
				),
				'computed_depends_on'	=> array(
					'course'
				),
				'computed_minimum'		=> array(
					'course'
				)
			),
			'label'     => array(
				'label'           => esc_html__( 'Label', 'tutor-divi-modules' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'main_content',
			),

		);
	}

	/**
	 * @param array
	 * @return array | string
	 */
	public static function get_props( $args = [] ) {
		$course_id = $args['course'];
		$instructors	= tutor_utils()->get_instructors_by_course( $course_id );
		if( !is_null( $instructors ) ) {
			foreach( $instructors as $instructor ) {
				$instructor->avatar				= tutils()->get_tutor_avatar( $instructor->ID, $size = 'thumbnail' );
				$instructor->ratings 			= tutils()->get_instructor_ratings( $instructor->ID );
				//$instructor->rating_generate	= tutils()->star_rating_generator($instructor->ratings ? $instructor->ratings->rating_avg : 0);
				$instructor->course_count 		= tutils()->get_course_count_by_instructor( $instructor->ID );
				$instructor->student_count 		= tutils()->get_total_students_by_instructor( $instructor->ID );
			}
		}
		return $instructors;
	}

	/**
	 * @param array
	 * @return template
	 */
	public  static function get_content( $args = [] ) {
		ob_start();
		include_once dtlms_get_template( 'course/instructor' );
		return ob_get_clean();
	}

	public function render( $unprocessed_props, $content = null, $render_slug ) {

		//selectors

		//props

		//set styles
		//set styles end
		$output = self::get_content( $this->props );
		if( '' === $output ) {
			return '';
		}
		return $this->_render_module_wrapper( $output, $render_slug );
	}
}
new CourseInstructor;