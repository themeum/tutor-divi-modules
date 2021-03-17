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
        $topic_wrapper_selector 	= '%%order_class%% .tutor-divi-course-topic';
	
		$topic_title_selector		= $wrapper." .tutor-course-title";
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
			),
			'margin_padding'	=> array()
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
							'topic_icon_color' => array(
								'label' => esc_html__( 'Icon Color', 'tutor-divi-modules' ),
								'type'  => 'color-alpha',
							),
							'topic_text_color' => array(
								'label' => esc_html__( 'Text Color', 'tutor-divi-modules' ),
								'type'  => 'color-alpha',
							),
							'topic_background_color' => array(
								'label' => esc_html__( 'Background Color', 'tutor-divi-modules' ),
								'type'  => 'color-alpha',
							),
						),
					),
					'tab_2' => array(
						'label' => esc_html( 'Active', 'tutor-divi-modules' ),
						'controls' => array(
							'topic_icon_active_color' => array(
								'label' => esc_html__( 'Icon Color', 'tutor-divi-modules' ),
								'type'  => 'color-alpha',
							),
							'topic_text_active_color' => array(
								'label' => esc_html__( 'Text Color', 'tutor-divi-modules' ),
								'type'  => 'color-alpha',
							),
							'topic_background_active_color' => array(
								'label' => esc_html__( 'Background Color', 'tutor-divi-modules' ),
								'type'  => 'color-alpha',
							),
						),
					),
					'tab_3' => array(
						'label' => esc_html( 'Hover', 'tutor-divi-modules' ),
						'controls' => array(
							'topic_icon_hover_color' => array(
								'label' => esc_html__( 'Icon Color', 'tutor-divi-modules' ),
								'type'  => 'color-alpha',
							),
							'topic_text_hover_color' => array(
								'label' => esc_html__( 'Text Color', 'tutor-divi-modules' ),
								'type'  => 'color-alpha',
							),
							'topic_background_hover_color' => array(
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
			//advanced tab spacing toggle
			'space_between_topics'	=> array(
				'label'				=> esc_html__( 'Space Between Topics', 'tutor-divi-modules' ),
				'type'				=> 'range',
				'default'			=> '10px',
				'default_unit'		=> 'px',
				'range_settings'	=> array(
					'min'		=> '0',
					'max'		=> '100',
					'step'		=> '1'
				),
				'tab_slug'			=> 'advanced',
				'toggle_slug'		=> 'margin_padding'
			)
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
			$topics			= tutor_utils()->get_topics( $course_id );
			/**
			 * for each topics get lesson & set curriculum
			 */
			$topics			= tutor_utils()->get_topics( $course_id );
			
			$curriculum 		= [
				'lesson_count'		=> 2,//$tutor_lesson_count,
				'course_duration'	=> 2,//$tutor_course_duration,
				'topics'			=> []
			];
			/**
			 * for each topics get lesson & set curriculum
			 */
			if(	!is_null( $topics ) ) {
				foreach( $topics->posts as $key => $topic ) {
					$topic_curriculums		= tutor_utils()->get_course_contents_by_topic( $topic->ID );
					$topic->curriculums 	= is_null($topic_curriculums) ? [] : $topic_curriculums->posts;
					$curriculum['topics'][] = $topic;
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
		$topic_wrapper				= '%%order_class%% .tutor-divi-course-topic';
		$topics_wrapper            	= '%%order_class%% .tutor-course-topics-contents';
        $topic_wrapper_selector 	= $wrapper.' .tutor-course-title';
		$title_selector				= $wrapper. '.tutor-course-title';
		$header_wrapper_selector   	= '%%order_class%% .tutor-course-topics-header';
		$header_wrapper_selector   = '%%order_class%% .tutor-course-topics-header';
		
		$lesson_icon_selector      = '%%order_class%% .tutor-course-lesson h5 i';
		$lesson_wrapper_selector   = '%%order_class%% .tutor-course-lessons';
		$lesson_info_selector      = '%%order_class%% .tutor-course-lesson .tutor-lesson-duration';
	
		//props
		$icon_position		= $this->props['icon_position'];
		$topic_icon_size	= $this->props['topic_icon_size'];

		$gap 				= $this->props['gap'];
		$gap_tablet			= isset( $this->props['gap_tablet']) && $this->props['gap_tablet'] !== '' ? $this->props['gap_tablet'] : $gap;
		$gap_phone			= isset( $this->props['gap_phone']) && $this->props['gap_phone'] !== '' ? $this->props['gap_phone'] : $gap;	

		$topic_icon_color          = $this->props['topic_icon_color'];
		$topic_icon_active_color   = $this->props['topic_icon_active_color'];
		$topic_icon_hover_color    = $this->props['topic_icon_hover_color'];

		$topic_text_color          = $this->props['topic_text_color'];
		$topic_text_active_color   = $this->props['topic_text_active_color'];
		$topic_text_hover_color    = $this->props['topic_text_hover_color'];

		$topic_background_color          = $this->props['topic_background_color'];
		$topic_background_active_color   = $this->props['topic_background_active_color'];
		$topic_background_hover_color    = $this->props['topic_background_hover_color'];

		$topic_icon_size			= $this->props['topic_icon_size'];
		$topic_icon_size_tablet		= isset($this->props['topic_icon_size_tablet']) && $this->props['topic_icon_size_tablet'] !== '' ? $this->props['topic_icon_size_tablet'] : $topic_icon_size;
		$topic_icon_size_phone		= isset($this->props['topic_icon_size_phone']) && $this->props['topic_icon_size_phone'] !== '' ? $this->props['topic_icon_size_phone'] : $topic_icon_size;

		$lesson_icon_size			= $this->props['lesson_icon_size'];
		$lesson_icon_size_tablet	= isset($this->props['lesson_icon_size_tablet']) && $this->props['lesson_icon_size_tablet'] !== '' ? $this->props['lesson_icon_size_tablet'] : $lesson_icon_size;
		$lesson_icon_size_phone		= isset($this->props['lesson_icon_size_phone']) && $this->props['lesson_icon_size_phone'] !== '' ? $this->props['lesson_icon_size_phone'] : $lesson_icon_size;

        $lesson_icon_color         = $this->props['lesson_icon_color'];
        $lesson_icon_color_hover   = isset( $this->props['lesson_icon_color__hover'] ) ? $this->props['lesson_icon_color__hover'] : '';

        $lesson_info_color         = $this->props['lesson_info_color'];
        $lesson_info_color_hover   = isset( $this->props['lesson_info_color__hover'] ) ? $this->props['lesson_info_color__hover'] : '';

        $lesson_background_color           = $this->props['lesson_background_color'];
        $lesson_background_color_hover     = isset( $this->props['lesson_background_color__hover'] ) ? $this->props['lesson_background_color__hover'] : '';

		$space_between_topics	= $this->props['space_between_topics'];
		//set styles
		/**
		 * default topic title display flex
		 */
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'		=> $topics_wrapper,
				'declaration'	=> 'display: flex; flex-direction: column;'
			)
		);

		if( '' !== $space_between_topics ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $topics_wrapper,
					'declaration'	=> sprintf(
						'row-gap: %1$s;',
						$space_between_topics
					)
				)
			);		
		}

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
		if( '' !== $topic_icon_size_tablet ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $topic_icon_selector,
					'declaration'	=> sprintf(
						'font-size: %1$s;',
						$topic_icon_size_tablet
					),
					'media_query'	=> ET_Builder_Element::get_media_query('max_width_980')
				)
			);		
		}
		if( '' !== $topic_icon_size_phone ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $topic_icon_selector,
					'declaration'	=> sprintf(
						'font-size: %1$s;',
						$topic_icon_size_phone
					),
					'media_query'	=> ET_Builder_Element::get_media_query('max_width_767')
				)
			);		
		}

		//topic icon,text,background colors

        //topic icon color
        if('' !== $topic_icon_color) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $topic_icon_selector,
					'declaration'	=> sprintf(
						'color: %1$s;',
						$topic_icon_color
					)
				)
			);
        }
        if('' !== $topic_icon_active_color) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '%%order_class%% .tutor-divi-course-topic.tutor-active .et-pb-icon',
					'declaration'	=> sprintf(
						'color: %1$s;',
						$topic_icon_active_color
					)
				)
			);			          
        }
        if('' !== $topic_icon_hover_color) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '%%order_class%% .tutor-divi-course-topic .et-pb-icon:hover',
					'declaration'	=> sprintf(
						'color: %1$s;',
						$topic_icon_hover_color
					)
				)
			);				        
        }
        //topic title text color styles
        if('' !== $topic_text_color) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '%%order_class%% .tutor-divi-course-topic .tutor-course-title h4',
					'declaration'	=> sprintf(
						'color: %1$s;',
						$topic_text_color
					)
				)
			);
        }
        if('' !== $topic_text_active_color) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '%%order_class%% .tutor-divi-course-topic.tutor-active .tutor-course-title h4',
					'declaration'	=> sprintf(
						'color: %1$s;',
						$topic_text_active_color
					)
				)
			);           
        }
        if('' !== $topic_text_hover_color) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '%%order_class%% .tutor-divi-course-topic .tutor-course-title h4:hover',
					'declaration'	=> sprintf(
						'color: %1$s;',
						$topic_text_hover_color
					)
				)
			);           
        }
        //topic title background color styles
        if('' !== $topic_background_color) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '%%order_class%% .tutor-divi-course-topic .tutor-course-title',
					'declaration'	=> sprintf(
						'background-color: %1$s;',
						$topic_background_color
					)
				)
			); 
        }
        if('' !== $topic_background_active_color) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '%%order_class%% .tutor-divi-course-topic.tutor-active .tutor-course-title',
					'declaration'	=> sprintf(
						'background-color: %1$s;',
						$topic_background_active_color
					)
				)
			);           
        }
        if('' !== $topic_background_hover_color) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> '%%order_class%% .tutor-divi-course-topic .tutor-course-title:hover',
					'declaration'	=> sprintf(
						'background-color: %1$s;',
						$topic_background_hover_color
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
		//lesson style
		if( '' !== $lesson_icon_size ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $lesson_icon_selector,
					'declaration'	=> sprintf(
						'font-size: %1$s;',
						$lesson_icon_size
					)
				)
			);		
		}
		if( '' !== $lesson_icon_size_tablet ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $lesson_icon_selector,
					'declaration'	=> sprintf(
						'font-size: %1$s;',
						$lesson_icon_size_tablet
					),
					'media_query'	=> ET_Builder_Element::get_media_query('max_width_980')
				)
			);		
		}
		if( '' !== $lesson_icon_size_phone ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $lesson_icon_selector,
					'declaration'	=> sprintf(
						'font-size: %1$s;',
						$lesson_icon_size_phone
					),
					'media_query'	=> ET_Builder_Element::get_media_query('max_width_767')
				)
			);		
		}		
		if( '' !== $lesson_icon_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $lesson_icon_selector,
					'declaration'	=> sprintf(
						'color: %1$s;',
						$lesson_icon_color
					)
				)
			);		
		}		
		if( '' !== $lesson_icon_color_hover ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $lesson_icon_selector.':hover',
					'declaration'	=> sprintf(
						'color: %1$s;',
						$lesson_icon_color_hover
					)
				)
			);		
		}		
		if( '' !== $lesson_info_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $lesson_info_selector,
					'declaration'	=> sprintf(
						'color: %1$s;',
						$lesson_info_color
					)
				)
			);		
		}		
		if( '' !== $lesson_info_color_hover ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $lesson_info_selector.":hover",
					'declaration'	=> sprintf(
						'color: %1$s;',
						$lesson_info_color_hover
					)
				)
			);		
		}	
		if( '' !== $lesson_background_color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $lesson_wrapper_selector,
					'declaration'	=> sprintf(
						'background-color: %1$s;',
						$lesson_background_color
					)
				)
			);		
		}	
		if( '' !== $lesson_background_color_hover ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $lesson_wrapper_selector.":hover",
					'declaration'	=> sprintf(
						'background-color: %1$s;',
						$lesson_background_color_hover
					)
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