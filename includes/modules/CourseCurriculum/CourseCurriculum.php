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
		// Toggle settings
		// Toggles are grouped into array of tab name > toggles > toggle definition
		$this->settings_modal_toggles = array(
			'general'		=> array(

			),
			'advanced'		=> array(
				'toggles'		=> array(
					'header'		=> array(
						'title'		=> esc_html__( 'Header', 'tutor-divi-modules' )
					),
					'topic_info'	=> array(
						'title'		=> esc_html__( 'Info', 'tutor-divi-modules' )
					),
					'topics'	=> array(
						'title'		=> esc_html__( 'Topics', 'tutor-divi-modules' )
					),
					'lesson'	=> array(
						'title'		=> esc_html__( 'Lesson', 'tutor-divi-modules' )
					),
				)
			)
		);


		// advanced fields config
		$wrapper               		= '%%order_class%% .tutor-course-topics-wrap';
        $topic_icon_selector   		= $wrapper.' .tutor-course-title >span';
        $topic_wrapper_selector 	= $wrapper.' .tutor-course-topics-contents';
		$header_title_selector   	= '%%order_class%% .tutor-course-topics-header-left h4';
		$header_info_selector   	= '%%order_class%% .tutor-course-topics-header-right';
		$lesson_title_selector		= '%%order_class%% .tutor-course-lesson h5 a';
		$lesson_wrapper_selector	= '%%order_class%% .tutor-course-lesson';

		$this->advanced_fields = array(
			'fonts'			=> array(
				'header'		=> array(
					'css'		=> array(
						'main'	=> $header_title_selector
					),
					'hide_text_align'	=> true,
					'tab_slug'			=> 'advanced',
					'toggle_slug'		=> 'header'
				),
				'topic_info'		=> array(
					'css'		=> array(
						'main'	=> $header_info_selector
					),
					'hide_text_align'	=> true,
					'tab_slug'			=> 'advanced',
					'toggle_slug'		=> 'topic_info'
				),
				'topics'		=> array(
					'css'		=> array(
						'main'	=> $topic_wrapper_selector." h4"
					),
					'hide_text_align'	=> true,
					'hide_text_color'	=> true,
					'tab_slug'			=> 'advanced',
					'toggle_slug'		=> 'topics'
				),
				'lesson'		=> array(
					'css'		=> array(
						'main'	=> $lesson_title_selector
					),
					'hide_text_align'	=> true,
					'tab_slug'			=> 'advanced',
					'toggle_slug'		=> 'lesson'
				)
			),
			'borders'		=> array(
				'default'            => array(),
				'topics'              => array(
					'css'             	=> array(
						'main' => array(
							'border_radii'  => $topic_wrapper_selector,
							'border_styles' => $topic_wrapper_selector,

						),
						'important'		=> true
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'topics',
				),
				'lesson'              => array(
					'css'             	=> array(
						'main' => array(
							'border_radii'  => $lesson_wrapper_selector,
							'border_styles' => $lesson_wrapper_selector,
						),
						'important'		=> true
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'lesson',
				),
			)
		);
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
			//general tab content toggle
			'label'     => array(
				'label'           	=> esc_html__( 'Label', 'tutor-divi-modules' ),
				'type'            	=> 'text',
				'default'			=> esc_html__( 'Topics for this course', 'tutor-divi-modules' ),
				'option_category' 	=> 'basic_option',
				'toggle_slug'     	=> 'main_content',
			),
			'collaps_icon' => array(
				'label'             => esc_html__( 'Collaps Icon', 'tutor-divi-modules' ),
				'type'              => 'select_icon',
				'default'			=> ';',
				'class'				=> array( 'et-pb-font-icon' ),
				'option_category'   => 'basic_option',
				'toggle_slug'     	=> 'main_content',		
			),
			'expand_icon' => array(
				'label'             => esc_html__( 'Expand Icon', 'tutor-divi-modules' ),
				'type'              => 'select_icon',
				'default'			=> ':',
				'class'				=> array( 'et-pb-font-icon' ),
				'option_category'   => 'basic_option',
				'toggle_slug'     	=> 'main_content',		
			),
			'icon_position'	=> array(
				'label'				=> esc_html__( 'Icon Position', 'tutor-divi-modules' ),
				'type'				=> 'select',
				'options'			=> array(
					'left'		=> esc_html__( 'Left', 'tutor-divi-modules' ),
					'right'		=> esc_html__( 'Right', 'tutor-divi-modules' ),
				),
				'default'			=> 'left',
				'toggle_slug'     	=> 'main_content',
				'mobile_options'	=> true
			),
			//advanced tab header toggle
			'gap'			=> array(
				'label'				=> esc_html__( 'Gap', 'tutor-divi-modules' ),
				'type'				=> 'range',
				'default'			=> '5px',
				'default_unit'		=> 'px',
				'range_settings'	=> array(
					'min'	=> 0,
					'max'	=> 100,
					'step'	=> 1
				),
				'tab_slug'			=> 'advanced',
				'toggle_slug'		=> 'header',
				'mobile_options'	=> true
			),
			
			//advanced tab topics toggle
			'topic_icon_size'			=> array(
				'label'				=> esc_html__( 'Icon Size', 'tutor-divi-modules' ),
				'type'				=> 'range',
				'default'			=> '18px',
				'default_unit'		=> 'px',
				'range_settings'	=> array(
					'min'	=> 0,
					'max'	=> 100,
					'step'	=> 1
				),
				'tab_slug'			=> 'advanced',
				'toggle_slug'		=> 'topics',
				'mobile_options'	=> true
			),
			'composite_tabbed' => array(
				'label'               => esc_html__( 'Color Settings', 'tutor-divi-modules' ),
				'tab_slug'            => 'advanced',
				'toggle_slug'         => 'topics',
				'type'                => 'composite',
				'composite_type'      => 'default',
				'composite_structure' => array(
					'tab_1' => array(
						'label'    => esc_html( 'Normal', 'tutor-divi-modules' ),
						'controls' => array(
							'icon' => array(
								'label' => esc_html__( 'Icon Color', 'tutor-divi-modules' ),
								'type'  => 'color-alpha',
							),
							'text' => array(
								'label' => esc_html__( 'Text Color', 'tutor-divi-modules' ),
								'type'  => 'color-alpha',
							),
							'background' => array(
								'label' => esc_html__( 'Background Color', 'tutor-divi-modules' ),
								'type'  => 'color-alpha',
							),
						),
					),
					'tab_2' => array(
						'label' => esc_html( 'Active', 'tutor-divi-modules' ),
						'controls' => array(
							'icon' => array(
								'label' => esc_html__( 'Icon Color', 'tutor-divi-modules' ),
								'type'  => 'color-alpha',
							),
							'text' => array(
								'label' => esc_html__( 'Text Color', 'tutor-divi-modules' ),
								'type'  => 'color-alpha',
							),
							'background' => array(
								'label' => esc_html__( 'Background Color', 'tutor-divi-modules' ),
								'type'  => 'color-alpha',
							),
						),
					),
					'tab_3' => array(
						'label' => esc_html( 'Hover', 'tutor-divi-modules' ),
						'controls' => array(
							'icon' => array(
								'label' => esc_html__( 'Icon Color', 'tutor-divi-modules' ),
								'type'  => 'color-alpha',
							),
							'text' => array(
								'label' => esc_html__( 'Text Color', 'tutor-divi-modules' ),
								'type'  => 'color-alpha',
							),
							'background' => array(
								'label' => esc_html__( 'Background Color', 'tutor-divi-modules' ),
								'type'  => 'color-alpha',
							),
						),
					),
				),
			),
			//advanced tab lesson toggles
			'lesson_icon_size'			=> array(
				'label'				=> esc_html__( 'Icon Size', 'tutor-divi-modules' ),
				'type'				=> 'range',
				'default'			=> '18px',
				'default_unit'		=> 'px',
				'range_settings'	=> array(
					'min'	=> 0,
					'max'	=> 100,
					'step'	=> 1
				),
				'tab_slug'			=> 'advanced',
				'toggle_slug'		=> 'lesson',
				'mobile_options'	=> true
			),
			'lesson_icon_color'			=> array(
				'label'				=> esc_html__( 'Icon Color', 'tutor-divi-modules' ),
				'type'				=> 'color-alpha',
				'hover'				=> 'tabs',
				'tab_slug'			=> 'advanced',
				'toggle_slug'		=> 'lesson',
				
			),
			'lesson_info_color'			=> array(
				'label'				=> esc_html__( 'Info Color', 'tutor-divi-modules' ),
				'type'				=> 'color-alpha',
				'hover'				=> 'tabs',
				'tab_slug'			=> 'advanced',
				'toggle_slug'		=> 'lesson',
				
			),
			'lesson_background_color'			=> array(
				'label'				=> esc_html__( 'Background Color', 'tutor-divi-modules' ),
				'type'				=> 'color-alpha',
				'hover'				=> 'tabs',
				'tab_slug'			=> 'advanced',
				'toggle_slug'		=> 'lesson',
				
			),
		);
	}

	/**
	 * computed value
	 * @return string | array course level
	 */
	public static  function get_props( $args = [] ) {
		$course_id				= $args['course'];
		$tutor_lesson_count 	= tutor_utils()->get_lesson_count_by_course($course_id);
		$tutor_course_duration 	= get_tutor_course_duration_context($course_id);
		$is_administrator 		= current_user_can('administrator');
		$is_instructor 			= tutor_utils()->is_instructor_of_this_course( $instructor_id=0, $course_id );

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
						'lesson_count'		=> $tutor_lesson_count,
						'course_duration'	=> $tutor_course_duration,
						'topic'				=> [
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
		//selectors
        $wrapper               		= '%%order_class%% .tutor-course-topics-wrap';
        $topic_icon_selector   		= $wrapper.' .tutor-course-title >span';
		$topic_wrapper				= '%%order_class%% .tutor-course-topics-contents';
        $topic_wrapper_selector 	= $wrapper.' .tutor-course-title';
		$title_selector				= $wrapper. '.tutor-course-title';
		$header_wrapper_selector   	= '%%order_class%% .tutor-course-topics-header';

	
		//props
		$icon_position		= $this->props['icon_position'];
		$topic_icon_size	= $this->props['topic_icon_size'];

		$gap 				= $this->props['gap'];
		$gap_tablet			= isset( $this->props['gap_tablet']) && $this->props['gap_tablet'] !== '' ? $this->props['gap_tablet'] : $gap;
		$gap_phone			= isset( $this->props['gap_phone']) && $this->props['gap_phone'] !== '' ? $this->props['gap_phone'] : $gap;	

		//set styles
		/**
		 * default topic title display flex
		 */
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'		=> $topic_wrapper_selector,
				'declaration'	=> 'display: flex; column-gap: 10px; align-items: center;'
			)
		);
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'		=> $topic_wrapper_selector." h4",
				'declaration'	=> 'padding: 0; margin: 0;'
			)
		);
		//topic styles
		//topic wrapper default border
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'		=> $topic_wrapper,
				'declaration'	=> 'border: 1px solid #DCE4E6;'
			)
		);

		if( $icon_position === 'right' ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $topic_wrapper_selector,
					'declaration'	=> 'justify-content: space-between; flex-direction: row-reverse;'
				)
			);		
		}
		if( '' !== $topic_icon_size ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $topic_icon_selector,
					'declaration'	=> sprintf(
						'font-size: %1$s;',
						$topic_icon_size
					)
				)
			);		
		}
		//header styles
		if($gap) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $header_wrapper_selector,
					'declaration'	=> sprintf(
						'margin-bottom: %1$s;',
						$gap
					)
				)
			);	
		}
		if($gap_tablet) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $header_wrapper_selector,
					'declaration'	=> sprintf(
						'margin-bottom: %1$s ;',
						$gap_tablet
					),
					'media_query'	=> ET_Builder_Element::get_media_query('max_width_980')
				)
			);	
		}
		if($gap_phone) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $header_wrapper_selector,
					'declaration'	=> sprintf(
						'margin-bottom: %1$s ;',
						$gap_phone
					),
					'media_query'	=> ET_Builder_Element::get_media_query('max_width_767')
				)
			);	
		}		
		//set styles end
		$output = self::get_content($this->props);
		// Render empty string if no output is generated to avoid unwanted vertical space.
		if ('' === $output) {
			return '';
		}

		return $this->_render_module_wrapper($output, $render_slug);		
	}
}
new CourseCurriculum;