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
			'label'     => array(
				'label'           => esc_html__( 'Label', 'tutor-divi-modules' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'main_content',
			),
			'collaps_icon' => array(
				'label'             => esc_html__( 'Collaps Icon', 'tutor-divi-modules' ),
				'type'              => 'select_icon',
				'default'			=> 'N',
				'class'				=> array( 'et-pb-font-icon' ),
				'option_category'   => 'basic_option',
				'toggle_slug'     	=> 'main_content',		
			),
			'expand_icon' => array(
				'label'             => esc_html__( 'Expand Icon', 'tutor-divi-modules' ),
				'type'              => 'select_icon',
				'default'			=> 'N',
				'class'				=> array( 'et-pb-font-icon' ),
				'option_category'   => 'basic_option',
				'toggle_slug'     	=> 'main_content',		
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
			$curriculum;
			$topics			= tutor_utils()->get_topics( $args['course'] );
	
			/**
			 * for each topics get lesson & set curriculum
			 */
			if(	!is_null( $topics ) ) {
				foreach( $topics->posts as $topic ) {
					$topic_curriculums	= tutor_utils()->get_course_contents_by_topic( $topic->ID );
					$curriculum 		= [
						'topic'			=> [
							'topic_details'		=> $topic,
							'curriculums'		=> []
						]
					];
					if(!is_null( $topic_curriculums )) {
						foreach( $topic_curriculums->posts as $tc ) {
							$video_info = tutor_utils()->get_video_info( $tc->ID );
							$tc->video_info = $video_info;
							array_push($curriculum['topic']['curriculums'], $tc);
						}
					}
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
	
		$ex_icon	= et_pb_process_font_icon( $args[ 'expand_icon' ] );
		$col_icon	= et_pb_process_font_icon( $args[ 'collaps_icon' ] );
		echo $ex_icon ."<br>";
		echo $col_icon;
		exit;
		$output = self::get_content($this->props);
		// Render empty string if no output is generated to avoid unwanted vertical space.
		if ('' === $output) {
			return '';
		}

		return $this->_render_module_wrapper($output, $render_slug);		
	}
}
new CourseCurriculum;