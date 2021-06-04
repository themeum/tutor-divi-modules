<?php

/**
 * Tutor Course Author Module for Divi Builder
 * @since 1.0.0
 * @author Themeum<www.themeum.com>
 */

use TutorLMS\Divi\Helper;

class TutorCourseAuthor extends ET_Builder_Module {
	// Module slug (also used as shortcode tag)
	public $slug       = 'tutor_course_author';
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
		$this->name			= esc_html__('Tutor Course Author', 'tutor-divi-modules');
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
					'author_image' => array(
						'title'    	=> esc_html__('Author Image', 'tutor-divi-modules'),
					),
					'author_label_text' => array(
						'title'    => esc_html__('Author Label', 'tutor-divi-modules'),
					),
					'author_name_text' => array(
						'title'    => esc_html__('Author Name', 'tutor-divi-modules'),
					),
				),
			),
		);
		
		$author_selector = '%%order_class%% .tutor-single-course-author-meta .tutor-single-course-author-name';
		$this->advanced_fields = array(
			'fonts'          => array(
				'author_label_text' => array(
					'label'        		=> esc_html__('Label', 'tutor-divi-modules'),
					'css'          		=> array(
						'main' => $author_selector.' span',
					),
					'hide_line_height'	=> true,
					'hide_text_align'	=> true,
					'tab_slug'     		=> 'advanced',
					'toggle_slug'  		=> 'author_label_text',
				),

				'author_name_text' => array(
					'label'        		=> esc_html__('Name', 'tutor-divi-modules'),
					'css'          		=> array(
						'main' => $author_selector.' a',
					),
					'hide_text_align'	=> true,
					'tab_slug'     		=> 'advanced',
					'toggle_slug'  		=> 'author_name_text',
				),
			),
			'borders'			=> array(
				'default'		=> array(),
				'image_border'	=> array(
					'css'		=> array(
						'main'	=> array(
							'border_radii'	=> "%order_class% .tutor-single-course-avatar a img,%order_class% .tutor-single-course-avatar a span",
							'border_style'	=> "%order_class% .tutor-single-course-avatar a img,%order_class% .tutor-single-course-avatar a span",
						)
					)
				)
			),
            'box_shadow'    => array(
                'default'   => array(
                    'css'   => array(
                        'main'  => "%order_class% .tutor-single-course-avatar a img,%order_class% .tutor-single-course-avatar a span",
                    )
                )
            ),
			'max_width'			=> false,
			//'margin_padding'	=> false,			
			'text'				=> false,
			'background'		=> false,
			'filters'			=> false,
			'animation'			=> false,
			'transform'			=> false			
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
						'__author',
					),
				)
			),
			'__author'		=> array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'TutorCourseAuthor',
					'get_props',
				),
				'computed_depends_on' => array(
					'course'
				),
				'computed_minimum'    => array(
					'course',
				),
			),

			//general settings fields
			'profile_picture'	=> array(
				'label'				=> esc_html__('Profile Picture', 'tutor-divi-modules'),
				'type'				=> 'yes_no_button',
				'option_category'	=> 'configuration',
				'options'			=> array(
					'off'	=> esc_html__('Hide', 'tutor-divi-modules'),
					'on'	=> esc_html__('Show', 'tutor-divi-modules')
				),
				'default_on_front'	=> "on",
				'toggle_slug'		=> 'main_content',	
			),
			'display_name'		=> array(
				'label'				=> esc_html__('Display Name', 'tutor-divi-modules'),
				'type'				=> 'yes_no_button',
				'option_category'	=> 'configuration',
				'options'			=> array(
					'off'	=> esc_html__('Hide', 'tutor-divi-modules'),
					'on'	=> esc_html__('Show', 'tutor-divi-modules')
				),
				'default_on_front'	=> "on",
				'toggle_slug'		=> 'main_content',
			),
			'link'			=> array(
				'label'				=> esc_html__('Link', 'tutor-divi-moduels'),
				'type'				=> 'select',
				'option_category'	=> 'layout',
				'options'			=> array(
					'new'			=> esc_html__('New Window', 'tutor-divi-modules'),
					'same' 			=> esc_html__('Same Window', 'tutor-divi-modules')
				),
				'default'			=> 'new',
				'toggle_slug'		=> 'main_content'
			),
			'layout'			=> array(
				'label'				=> esc_html__('Layout', 'tutor-divi-moduels'),
				'type'				=> 'select',
				'option_category'	=> 'layout',
				'options'			=> array(
					'row'			=> esc_html__('Left', 'tutor-divi-modules'),
					'column' 		=> esc_html__('Up', 'tutor-divi-modules')
				),
				'default'			=> 'row',
				'toggle_slug'		=> 'main_content'
			),
			'author_alignment'	=> array(
				'label'				=> esc_html__('Alignment', 'tutor-divi-modules'),
				'type'				=> 'text_align',
				'option_category'	=> 'configuration',
				'options'			=> et_builder_get_text_orientation_options( array( 'justified' ) ),
				'default'			=> 'left',
				'toggle_slug'		=> 'main_content'
			),
			//general settings end

			//author avatar settings in advanced tab
			'avatar_size'	=> array(
				'label'				=> esc_html__( 'Size', 'tutor-divi-modules' ),
				'type'				=> 'range',
				'option_category'	=> 'layout',
				'default_unit'		=> 'px',
				'default'			=> '25px',
				'range_settings'	=> array(
					'min'	=> '10',
					'max'	=> '100',
					'step'	=> '1'
				),
				'tab_slug'			=> 'advanced',
				'toggle_slug'		=> 'author_image',
				'show_if'			=> array(
					'profile_picture'	=> 'on'
				),
				'mobile_options'	=> true
			),	
			'avatar_gap'	=> array(
				'label'				=> esc_html__( 'Gap', 'tutor-divi-modules' ),
				'type'				=> 'range',
				'option_category'	=> 'layout',
				'default_unit'		=> 'px',
				'default'			=> '5px',
				'range_settings'	=> array(
					'min'	=> '1',
					'max'	=> '100',
					'step'	=> '1'
				),
				'tab_slug'			=> 'advanced',
				'toggle_slug'		=> 'author_image',
				'show_if'			=> array(
					'profile_picture'	=> 'on'
				),
				'mobile_options'	=> true
			),
			//author avatar settings in advanced tab end					
		);

		return $fields;
	}

	/**
	 * get require props
	 * @since 1.0.0
	 * @return array
	*/
	public static function get_props( $args = [] ) {
		$post_id 		= $args[ 'course' ];
		$post 			= get_post( $post_id );
		$author_id 		= $post->post_author;
		$author_name 	= get_the_author_meta('display_name', $author_id);
		$profile_url 	= tutils()->profile_url( $author_id );

		return array(
			'avatar_url'	=> tutils()->get_tutor_avatar($author_id),
			'author_name'	=> $author_name,
			'profile_url'	=> $profile_url
		);
	}

	/**
	 * Get the tutor course content
	 * @since 1.0.0
	 * @return string
	 */
	public static function get_content($args = []) {
		$course = $args['course'];
		ob_start();
		if ($course) {
			include_once dtlms_get_template('course/author');
		}
		return ob_get_clean();
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
		// selectors
		$wrapper			= '%%order_class%% .tutor-single-course-author-meta';
		$img_selector 		= '%%order_class%% .tutor-single-course-avatar a img';
		$level_selector		= '%%order_class%% .tutor-single-course-author-name > spane';
		$name_selector		= '%%order_class%% .tutor-single-course-author-name > a';

		//props
		$display			= 'flex';
		$layout 			= $this->props[ 'layout' ];
		$alignment			= $this->props[ 'author_alignment' ];

		$avatar_size		= $this->props[ 'avatar_size' ];
		$avatar_size_tablet = isset( $this->props[ 'avatar_size_tablet' ] ) ? $this->props[ 'avatar_size_tablet' ] : '' ;
		$avatar_size_phone 	= isset( $this->props[ 'avatar_size_phone' ] ) ? $this->props[ 'avatar_size_phone' ] : '' ;

		$gap				= $this->props[ 'avatar_gap' ];
		$gap_tablet 		= isset( $this->props[ 'avatar_gap_tablet' ] ) ? $this->props[ 'avatar_gap_tablet' ] : '' ;
		$gap_phone 			= isset( $this->props[ 'avatar_gap_phone' ] ) ? $this->props[ 'avatar_gap_phone' ] : '' ;

		$alignment			= ($alignment == 'left' ? 'flex-start ' : ( $alignment == 'center' ? 'center' : 'flex-end' )); 

		if ( '' !== $avatar_size ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => $img_selector,
				'declaration' => sprintf(
					'width: %1$s;',
					esc_html( $avatar_size )
				),
			) );
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => $img_selector,
				'declaration' => sprintf(
					'height: %1$s;',
					esc_html( $avatar_size )
				),
			) );
		}

		if( '' !== $avatar_size_tablet ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => $img_selector,
				'declaration' => sprintf(
					'width: %1$s;',
					esc_html( $avatar_size_tablet )
				),
				'media_query'	=> ET_Builder_Element::get_media_query( 'max_width_980' )
			) );
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => $img_selector,
				'declaration' => sprintf(
					'height: %1$s;',
					esc_html( $avatar_size_tablet )
				),
				'media_query'	=> ET_Builder_Element::get_media_query( 'max_width_980' )
			) );			
		}

		if( '' !== $avatar_size_phone ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => $img_selector,
				'declaration' => sprintf(
					'width: %1$s;',
					esc_html( $avatar_size_phone )
				),
				'media_query'	=> ET_Builder_Element::get_media_query( 'max_width_767' )
			) );
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'    => $img_selector,
				'declaration' => sprintf(
					'height: %1$s;',
					esc_html( $avatar_size_phone )
				),
				'media_query'	=> ET_Builder_Element::get_media_query( 'max_width_767' )
			) );			
		}

		//avatar gap
		if( '' !== $gap && 'row' == $layout) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'		=> $wrapper,
				'declaration'	=> sprintf(
					'column-gap: %1$s;',
					esc_html( $gap )
				)
			));
		}
		if( '' !== $gap && 'column' == $layout) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'		=> $wrapper,
				'declaration'	=> sprintf(
					'row-gap: %1$s;',
					esc_html( $gap )
				)
			));
		}

		if( '' !== $gap_tablet && 'row' == $layout) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'		=> $wrapper,
				'declaration'	=> sprintf(
					'column-gap: %1$s;',
					esc_html( $gap_tablet )
				),
				'media_query'	=> ET_Builder_Element::get_media_query( 'max_width_980' )
			));
		}
		if( '' !== $gap_tablet && 'column' == $layout) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'		=> $wrapper,
				'declaration'	=> sprintf(
					'row-gap: %1$s;',
					esc_html( $gap_tablet )
				),
				'media_query'	=> ET_Builder_Element::get_media_query( 'max_width_980' )
			));
		}

		if( '' !== $gap_phone && 'row' == $layout) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'		=> $wrapper,
				'declaration'	=> sprintf(
					'column-gap: %1$s;',
					esc_html( $gap_phone )
				),
				'media_query'	=> ET_Builder_Element::get_media_query( 'max_width_767' )
			));
		}
		if( '' !== $gap_phone && 'column' == $layout) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'		=> $wrapper,
				'declaration'	=> sprintf(
					'row-gap: %1$s;',
					esc_html( $gap_phone )
				),
				'media_query'	=> ET_Builder_Element::get_media_query( 'max_width_767' )
			));
		}

		ET_Builder_Element::set_style( $render_slug, array(
			'selector'		=> $wrapper,
			'declaration'	=> sprintf(
				'display: %1$s;',
				esc_html( $display ) 
			)
		) );

		if( '' !== $layout ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'		=> $wrapper,
				'declaration'	=> sprintf(
					'flex-direction: %1$s;',
					esc_html( $layout ) 
				)
			) );
		}

		if( $alignment && $layout === 'row' ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'		=> $wrapper,
				'declaration'	=> sprintf(
					'justify-content: %1$s',
					esc_html( $alignment )
				)
			) );	
		} 

		if( $alignment && $layout === 'row' ) {
			ET_Builder_Element::set_style( $render_slug, array(
				'selector'		=> $wrapper,
				'declaration'	=> sprintf(
					'align-items: %1$s',
					esc_html( $alignment )
				)
			) );	
		} 

		$output = self::get_content($this->props);

		// Render empty string if no output is generated to avoid unwanted vertical space.
		if ('' === $output) {
			return '';
		}

		return $this->_render_module_wrapper($output, $render_slug);
	}
}

new TutorCourseAuthor;
