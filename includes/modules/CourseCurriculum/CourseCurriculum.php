<?php
/**
 * Tutor Course Curriculum Module for Divi Builder
 * @since 1.0.0
 */
use TutorLMS\Divi\Helper;
class CourseCurriculum extends ET_Builder_Module {

	public $slug       = 'tutor_course_curriculum';
	public $vb_support = 'on';

	public function init() {
		$this->name = esc_html__( 'Tutor Course Curriculum', 'tutor-divi-modules' );
	}

	public function get_fields() {
		return array(
			'course'       	=> Helper::get_field(
				array(
					'default'          => Helper::get_course_default(),
					'computed_affects' => array(
						'__curriculum',
					),
				)
			),
			'__curriculum'	=> array(
				'type'					=> 'computed',
				'computed_callback'		=> array(
					'CourseCurriculum',
					'get_props'
				),
				'computed_depends_on'	=> array(
					'course'
				),
				'computed_minimum'		=> array(
					'course'
				)
			),
			'tutor_course_list_heading_new'     => array(
				'label'           => esc_html__( 'Heading', 'tutor-divi-modules' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input your desired heading here.', 'tutor-divi-modules' ),
				'toggle_slug'     => 'main_content',
			),
            'content'     => array(
				'label'           => esc_html__( 'Content', 'tutor-divi-modules' ),
				'type'            => 'tiny_mce',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Content entered here will appear below the heading text.', 'tutor-divi-modules' ),
				'toggle_slug'     => 'main_content',
			),

		);
	}

	/**
	 * computed value
	 * @return string | array course level
	 */
	public static  function get_props( $args = [] ) {
		$course_id			= $args['course'];
		$is_administrator 	= current_user_can('administrator');
		$is_instructor 		= tutor_utils()->is_instructor_of_this_course( $instructor_id=0, $course_id );

		if( $is_administrator || $is_instructor ) {
			$curriculum		= [];
			$topics			= tutor_utils()->get_topics( $course_id );
	
			/**
			 * for each topics get lesson & set curriculum
			 */
			if(	!is_null( $topics ) ) {
				foreach( $topics->posts as $topic ) {
					$topic_curriculums	= tutor_utils()->get_course_contents_by_topic( $topic->ID );
					$curriculum[] 		= [
						'topic'			=> [
							'topic_details'		=> $topic,
							'curriculums'		=> is_null( $topic_curriculums ) ? '' : $topic_curriculums->posts
						]
					   ];
				  }
			}
			return $curriculum;
		}
		return false;
	}

	/**
	 * Get the tutor course author
	 *
	 * @return string
	 */
	public static function get_content( $args = [] ) {
		ob_start();
		include_once dtlms_get_template('course/curriculum');
		return ob_get_clean();
	}

	public function render( $unprocessed_props, $content = null, $render_slug ) {
		$output = self::get_content($this->props);
		// Render empty string if no output is generated to avoid unwanted vertical space.
		if ('' === $output) {
			return '';
		}

		return $this->_render_module_wrapper($output, $render_slug);		
	}
}
new CourseCurriculum;