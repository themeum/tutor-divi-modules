<?php

/**
 * Tutor Course Target Audience Module for Divi Builder
 * @since 1.0.0
 * @author Themeum<www.themeum.com>
 */

use TutorLMS\Divi\Helper;

class TutorCourseTargetAudience extends ET_Builder_Module {
	// Module slug (also used as shortcode tag)
	public $slug       = 'tutor_course_target_audience';
	public $vb_support = 'on';

	// Module Credits (Appears at the bottom of the module settings modal)
	protected $module_credits = array(
		'author'     => 'Themeum',
		'author_uri' => 'https://themeum.com',
	);

	/**
	 * Module properties initialization
	 *
	 * @since 1.0.0
	 */
	public function init() {
		// Module name & icon
		$this->name			= esc_html__('Tutor Course Target Audience', 'tutor-divi-modules');
		$this->icon_path	= plugin_dir_path( __FILE__ ) . 'icon.svg';

		// Toggle settings
		// Toggles are grouped into array of tab name > toggles > toggle definition
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__('Content', 'tutor-divi-modules'),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'title' => array(
						'title'		=> esc_html__('Section Title', 'tutor-divi-modules'),
					),
					'list'	=> array(
						'title'		=> esc_html__( 'List', 'tutor-divi-modules' ),
					),
					'icon' => array(
						'title'		=> esc_html__('Icon', 'tutor-divi-modules'),
					),
					'target_aud_text' => array(
						'title'		=> esc_html__('Text', 'tutor-divi-modules'),
					),
				),
			),
		);
		
		$wrapper 		= '%%order_class%% .tutor-course-target-audience-wrap';
		$title_selector	= $wrapper." .tutor-segment-title";
		$li_selector	= $wrapper." li";
		$icon_selector	= $li_selector." .et-pb-icon";
		
		$this->advanced_fields = array(
			'fonts'          => array(
				'title' => array(
					'css'          		=> array(
						'main' => $title_selector,
					),
					'hide_text_align'	=> true,
					'tab_slug'     		=> 'advanced',
					'toggle_slug'  		=> 'title',
				),
				'target_aud_text' => array(
					'css'          		=> array(
						'main' => $li_selector,
					),
					'hide_text_align'	=> true,
					'tab_slug'     		=> 'advanced',
					'toggle_slug'  		=> 'target_aud_text',
				),
			),
			'borders'    => array(
				'default'            => array(),
				'list'              => array(
					'css'             	=> array(
						'main' => array(
							'border_radii'  => $li_selector,//"{$this->main_css_element} .tutor-social-share-wrap i",
							'border_styles' => $li_selector,
						),
						'important'		=> true
					),
					'tab_slug'        => 'advanced',
					'toggle_slug'     => 'list',
				),
			),
			'button'        => false,
			'text'			=> false,
			'max_width'		=> false,
			'background'	=> false,
			'filters'		=> false,
			'animation'		=> false,
			'box_shadow'	=> false,
			'transform'		=> false			
		);
	}

	/**
	 * Module's specific fields
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_fields() {
		$fields = array(
			'course'       	=> Helper::get_field(
				array(
					'default'          => Helper::get_course_default(),
					'computed_affects' => array(
						'__target_audience',
					),
				)
			),
			'__target_audience'		=> array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'TutorCourseTargetAudience',
					'get_props',
				),
				'computed_depends_on' => array(
					'course'
				),
				'computed_minimum'    => array(
					'course',
				),
			),
			//general settings content tab
			'label'		=> array(
				'label'				=> esc_html__( 'Label', 'tutor-divi-modules'),
				'type'				=> 'text',
				'default'			=> esc_html__( 'Target Audience', 'tutor-divi-modules' ),
				'option_category'	=> 'basic',
				'toggle_slug'		=> 'main_content'
	
			),
			'layout'	=> array(
				'label'				=> esc_html( 'Layout', 'tutor-divi-modules' ),
				'type'				=> 'select',
				'options'			=> array(
					'block'			=> esc_html__( 'List', 'tutor-divi-modules' ), 
					'inline-block'	=> esc_html__( 'Inline', 'tutor-divi-modules' ), 
				),
				'default'			=> 'list',
				'option_category'	=> 'layout',
				'toggle_slug'		=> 'main_content',
				'mobile_options'	=> true
			),
			'icon' => array(
				'label'             => esc_html__( 'Icon', 'tutor-divi-modules' ),
				'type'              => 'select_icon',
				'default'			=> 'N',
				'class'				=> array( 'et-pb-font-icon' ),
				'option_category'   => 'basic_option',
				'toggle_slug'     	=> 'main_content',		
			),
			'alignment'		=> array(
				'label'				=> esc_html__('Alignment', 'tutor-divi-modules'),
				'type'				=> 'text_align',
				'option_category'	=> 'configuration',
				'options'			=> et_builder_get_text_orientation_options( array( 'justified' ) ),
				'default'			=> 'left',
				'toggle_slug'		=> 'main_content',
				'mobile_options'	=> true
			),
			//advanced tab section title toggles
			'gap'			=> array(
				'label'				=> esc_html__( 'Gap', 'tutor-divi-modules' ),
				'type'				=> 'range',
				'default'			=> '10',
				'default_unit'		=> 'px',
				'range_settings'	=> array(
					'min'	=> -10,
					'max'	=> 100,
					'step'	=> 1
				),
				'tab_slug'			=> 'advanced',
				'toggle_slug'		=> 'title',
				'mobile_options'	=> true
			),
			//advanced tab section list toggles
			'space_between'	=> array(
				'label'				=> esc_html__( 'Space Between', 'tutor-divi-modules' ),
				'type'				=> 'range',
				'default'			=> '10',
				'default_unit'		=> 'px',
				'range_settings'	=> array(
					'min'	=> '-10',
					'max'	=> '100',
					'step'	=> '1'
				),
				'tab_slug'			=> 'advanced',
				'toggle_slug'		=> 'list',
				'mobile_options'	=> true				
			),
			'padding'		=> array(
				'label'           	=> esc_html__( 'Padding', 'tutor-divi-modules' ),
				'type'            	=> 'custom_padding',
				'hover'           	=> 'tabs',
				'option_category' 	=> 'layout',
				'tab_slug'        	=> 'advanced',
				'toggle_slug'     	=> 'list',
				'allowed_units'   	=> array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
			),
			//advanced tab icon toggle
			'color'			=> array(
				'label'				=> esc_html__( 'Color', 'tutor-divi-modules' ),
				'type'				=> 'color-alpha',
				'tab_slug'			=> 'advanced',
				'toggle_slug'		=> 'icon'
			),
			'size'			=> array(
				'label'				=> esc_html__( 'Size', 'tutor-divi-modules' ),
				'type'				=> 'range',
				'default'			=> '12px',
				'default_unit'		=> 'px',
				'range_settings'	=> array(
					'min'	=> '-10',
					'max'	=> '100',
					'step'	=> '1'
				),
				'tab_slug'			=> 'advanced',
				'toggle_slug'		=> 'icon',
				'mobile_options'	=> true
			),
			//advanced tab text toggle
			'indent'			=> array(
				'label'				=> esc_html__( 'Text Indent', 'tutor-divi-modules' ),
				'type'				=> 'range',
				'default'			=> '7px',
				'default_unit'		=> 'px',
				'range_settings'	=> array(
					'min'	=> '0',
					'max'	=> '100',
					'step'	=> '1'
				),
				'tab_slug'			=> 'advanced',
				'toggle_slug'		=> 'target_aud_text',
				'mobile_options'	=> true
			),
		);

		return $fields;
	}

	/**
	 * get require props
	 * @since 1.0.0
	 * @return string|Number
	 */
	public static function get_props( $args = [] ) {
		$course_id	= $args['course'];
		$target	= tutor_course_target_audience( $course_id );
		$target =  count($target) > 0 ? $target : 0 ;
		return $target;
	}

	/**
	 * Get content
	 * @since 1.0.0
	 * @return string
	 */
	public static function get_content($args = []) {
		$course = Helper::get_course($args);
		$output = '';
		ob_start();

		if ($course) {
			include_once dtlms_get_template( 'course/target_audience' );
			$output = ob_get_clean();
		}

		return $output;
	}

	/**
	 * Render module output
	 *
	 * @since 1.0.0
	 *
	 * @param array  $attrs       List of unprocessed attributes
	 * @param string $content     Content being processed
	 * @param string $render_slug Slug of module that is used for rendering output
	 *
	 * @return string module's rendered output
	 */
	public function render($attrs, $content = null, $render_slug) {
		//selectors
		$wrapper 		= '%%order_class%% .tutor-course-target-audience-wrap';
		$title_selector	= $wrapper." .tutor-segment-title";
		$li_selector	= $wrapper." li";
		$icon_selector	= $li_selector." .et-pb-icon";

		//props
		$size 			= $this->props['size'];
		$size_tablet	= isset( $this->props['size_tablet']) && $this->props['size_tablet'] !== '' ? $this->props['size_tablet'] : $size;
		$size_phone		= isset( $this->props['size_phone']) && $this->props['size_phone'] !== '' ? $this->props['size_phone'] : $size;

		$gap 			= $this->props['gap'];
		$gap_tablet		= isset( $this->props['gap_tablet']) && $this->props['gap_tablet'] !== '' ? $this->props['gap_tablet'] : $gap;
		$gap_phone		= isset( $this->props['gap_phone']) && $this->props['gap_phone'] !== '' ? $this->props['gap_phone'] : $gap;

		$padding		= $this->props[ 'padding' ];

		$color 			= $this->props[ 'color' ];

		$layout			= $this->props[ 'layout' ];
		$layout_tablet 	= isset( $this->props[ 'layout_tablet' ]) && '' !== $this->props[ 'layout_tablet' ] ? $this->props[ 'layout_tablet' ] : $layout;
		$layout_phone 	= isset( $this->props[ 'layout_phone' ]) && '' !== $this->props[ 'layout_phone' ] ? $this->props[ 'layout_phone' ] : $layout;

		$alignment			= $this->props[ 'alignment' ];
		$alignment_tablet 	= isset( $this->props[ 'alignment_tablet' ]) && '' !== $this->props[ 'alignment_tablet' ] ? $this->props[ 'alignment_tablet' ] : $alignment;
		$alignment_phone 	= isset( $this->props[ 'alignment_phone' ]) && '' !== $this->props[ 'alignment_phone' ] ? $this->props[ 'alignment_phone' ] : $alignment;

		$space_between	= $this->props[ 'space_between' ];
		$space_tablet 	= isset( $this->props[ 'space_between_tablet' ]) && '' !== $this->props[ 'space_between_tablet' ] ? $this->props[ 'space_between_tablet' ] : $space_between;
		$space_phone 	= isset( $this->props[ 'space_between_phone' ]) && '' !== $this->props[ 'space_between_phone' ] ? $this->props[ 'space_between_phone' ] : $space_between;

		$indent			= $this->props[ 'indent' ];
		$indent_tablet 	= isset( $this->props[ 'indent_tablet' ]) && '' !== $this->props[ 'indent_tablet' ] ? $this->props[ 'indent_tablet' ] : $indent;
		$indent_phone 	= isset( $this->props[ 'indent_phone' ]) && '' !== $this->props[ 'indent_phone' ] ? $this->props[ 'indent_phone' ] : $indent;


		//set styles
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'		=> $li_selector,
				'declaration'	=> 'padding: 0; list-style:none;'
			)
		);		

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'		=> $wrapper." ul",
				'declaration'	=> 'padding: 0;'
			)
		);

		//wrapper style
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'		=> $wrapper,
				'declaration'	=> 'display: flex; flex-direction: column;'
			)
		);	
		
		if($gap) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $wrapper,
					'declaration'	=> sprintf(
						'row-gap: %1$s;',
						$gap
					)
				)
			);	
		}
		if($gap_tablet) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $wrapper,
					'declaration'	=> sprintf(
						'row-gap: %1$s;',
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
					'selector'		=> $wrapper,
					'declaration'	=> sprintf(
						'row-gap: %1$s;',
						$gap_phone
					),
					'media_query'	=> ET_Builder_Element::get_media_query('max_width_767')
				)
			);	
		}

		//icons tyle
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'		=> $icon_selector,
				'declaration'	=> sprintf(
					'font-size: %1$s !important;',
					$size
				)
			)
		);

		if( $size_tablet ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $icon_selector,
					'declaration'	=> sprintf(
						'font-size: %1$s !important;',
						$size_tablet
					),
					'media_query'	=> ET_Builder_Element::get_media_query( 'max_width_980' )
				)
			);
		}

		if( $size_phone ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $icon_selector,
					'declaration'	=> sprintf(
						'font-size: %1$s !important;',
						$size_phone
					),
					'media_query'	=> ET_Builder_Element::get_media_query( 'max_width_767' )
				)
			);
		}

		if( $color ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $icon_selector,
					'declaration'	=> sprintf(
						'color: %1$s !important;',
						$color
					)
				)
			);
		}

		//padding
		if( $padding ) {
			$paddings	= $this->props[ 'padding' ];
			$paddings	= explode("|",$paddings);	
			if( is_array($paddings) ) {
				ET_Builder_Element::set_style(
					$render_slug,
					array(
						'selector'		=> $li_selector,
						'declaration'	=> sprintf(
							'padding: %1$s %2$s %3$s %4$s;',
							$paddings[0],
							$paddings[1],
							$paddings[2],
							$paddings[3]
						) 
					)
				);
			}
		}

		//layout 
		if( $layout ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $li_selector,
					'declaration'	=> sprintf(
						'display: %1$s !important;',
						$layout
					)
				)
			);	
		}		
		if( $layout_tablet ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $li_selector,
					'declaration'	=> sprintf(
						'display: %1$s !important;',
						$layout_tablet
					),
					'media_query'	=> ET_Builder_Element::get_media_query( 'max_width_980' ) 
				)
			);	
		}		
		if( $layout_phone ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $li_selector,
					'declaration'	=> sprintf(
						'display: %1$s !important;',
						$layout_phone
					),
					'media_query'	=> ET_Builder_Element::get_media_query( 'max_width_767' )
				)
			);	
		}		

		//alignment 
		if( $alignment ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $wrapper." .tutor-segment-title , ". $wrapper. " .tutor-course-target-audience-content",
					'declaration'	=> sprintf(
						'text-align: %1$s !important;',
						$alignment
					)
				)
			);	
		}			
		if( $alignment_tablet ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $wrapper." .tutor-segment-title , ". $wrapper. " .tutor-course-target-audience-content",
					'declaration'	=> sprintf(
						'text-align: %1$s !important;',
						$alignment_tablet
					),
					'media_query'	=> ET_Builder_Element::get_media_query('max_width_980')
				)
			);	
		}			
		if( $alignment_phone ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $wrapper." .tutor-segment-title , ". $wrapper. " .tutor-course-target-audience-content",
					'declaration'	=> sprintf(
						'text-align: %1$s !important;',
						$alignment_phone
					),
					'media_query'	=> ET_Builder_Element::get_media_query('max_width_767')
				)
			);	
		}	
		
		//space between
		if( $space_between ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $li_selector.":not(:last-child)",
					'declaration'	=> sprintf(
						'margin-bottom: %1$s !important;',
						$space_between
					)
				)
			);	
		}	

		if( $space_tablet ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $li_selector.":not(:last-child)",
					'declaration'	=> sprintf(
						'margin-bottom: %1$s !important;',
						$space_tablet
					),
					'media_query'	=> ET_Builder_Element::get_media_query('max_width_980')
				)
			);	
		}			
		if( $space_phone ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $li_selector.":not(:last-child)",
					'declaration'	=> sprintf(
						'margin-bottom: %1$s !important;',
						$space_phone
					),
					'media_query'	=> ET_Builder_Element::get_media_query('max_width_767')
				)
			);	
		}	
		//text indent
		if( $indent ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $li_selector." .list-item",
					'declaration'	=> sprintf(
						'padding-left: %1$s !important;',
						$indent
					)
				)
			);	
		}	

		if( $indent_tablet ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $li_selector." .list-item",
					'declaration'	=> sprintf(
						'padding-left: %1$s !important;',
						$indent_tablet
					),
					'media_query'	=> ET_Builder_Element::get_media_query('max_width_980')
				)
			);	
		}			
		if( $indent_phone ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $li_selector." .list-item",
					'declaration'	=> sprintf(
						'padding-left: %1$s !important;',
						$indent_phone
					),
					'media_query'	=> ET_Builder_Element::get_media_query('max_width_767')
				)
			);	
		}	
		
		$output = self::get_content($this->props);

		// Render empty string if no output is generated to avoid unwanted vertical space.
		if ('' === $output) {
			return '';
		}

		return $this->_render_module_wrapper($output, $render_slug);
	}
}

new TutorCourseTargetAudience;
