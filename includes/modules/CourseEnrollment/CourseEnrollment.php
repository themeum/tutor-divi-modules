<?php

/**
* Tutor Course Enrollment Module for Divi Builder
* @since 1.0.0
* @author Themeum<www.themeum.com>
*/
use TutorLMS\Divi\Helper;

class CourseEnrollment extends ET_Builder_Module {

	// Module slug (also used as shortcode tag)
	public $slug       = 'tutor_course_enrollment';
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
		$this->name			= esc_html__('Tutor Course Enrollment', 'tutor-divi-modules');
		$this->icon_path	= plugin_dir_path( __FILE__ ) . 'icon.svg';

		// Toggle settings
		// Toggles are grouped into array of tab name > toggles > toggle definition 
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content'  => esc_html__( 'Content', 'tutor-divi-modules' ),
					'customize_btn' => esc_html__( 'Button', 'tutor-divi-modules' ),
				),
			),
			'advanced' => array(
                'toggles'   => array(
                    'enrollment_button'     => esc_html__( 'Enroll Button', 'tutor-divi-modules' ),
                    'add_to_cart_button'    => esc_html__( 'Add to Cart Button', 'tutor-divi-modules' ),
                    'start_continue_button' => esc_html__( 'Start/Continue Button', 'tutor-divi-modules' ),
                    'complete_button'       => esc_html__( 'Complete Button', 'tutor-divi-modules' ),
                    'gradebook_button'      => esc_html__( 'Gradebook Button', 'tutor-divi-modules' ),
                    'enrolled_info'         => esc_html__( 'Enrolled Info', 'tutor-divi-modules' ),
                )
			),
   
		);

        //advanced fiedls settings
        $this->advanced_fields = array(
            'fonts'         => array(

                'label_font'    => array(
                    'label'         => esc_html__( 'Label', 'tutor-divi-modules' ),
                    'css'   => array(
                        'main'      => '%%order_class%% .tutor-single-course-segment.tutor-course-enrolled-wrap p',
                    ),
                    'hide_text_align'    => true,
                    'tab_slug'      => 'advanced',
                    'toggle_slug'   => 'enrolled_info'
                ),
                'date_font'    => array(
                    'label'         => esc_html__( 'Date', 'tutor-divi-modules' ),
                    'css'   => array(
                        'main'      => '%%order_class%% .tutor-single-course-segment.tutor-course-enrolled-wrap p span',
                    ),
                    'hide_text_align'    => true,
                    'tab_slug'      => 'advanced',
                    'toggle_slug'   => 'enrolled_info'
                ),
            ),

            'button'        => array(

                'enrollment_button' => array(
                    'label'         => esc_html__( 'Enrollment Button', 'tutor-divi-modules' ),
                    'box_shadow'    => array(
                        'css'   => array(
                            'main'  => '%%order_class%% .tutor-course-enrollment-box .tutor-btn-enroll'
                        )
                    ),
                    'css'           => array(
                        'main'  => '%%order_class%% .tutor-course-enrollment-box .tutor-btn-enroll'
                    ),
                    'use_alignment' => false,
                    'tab_slug'      => 'advanced',
                    'toggle_slug'   => 'enrollment_button' ,
                    'show_if'       => array(
                        'preview_mode'  => 'enrollment'
                    ),  
                    'important'     => true
                ),
                'add_to_cart_button' => array(
                    'label'         => esc_html__( 'Add to Cart Button', 'tutor-divi-modules' ),
                    'box_shadow'    => array(
                        'css'   => array(
                            'main'  => '%%order_class%% .tutor-course-enrollment-box .single_add_to_cart_button.tutor-button'
                        )
                    ),
                    'css'           => array(
                        'main'  => '%%order_class%% .tutor-course-enrollment-box .single_add_to_cart_button.tutor-button'
                    ),
                    'use_alignment' => false,
                    'tab_slug'      => 'advanced',
                    'toggle_slug'   => 'add_to_cart_button' ,
                    'show_if'       => array(
                        'preview_mode'  => 'enrollment'
                    ),
                    'important'     => true  
                ),
                'start_continue_button' => array(
                    'label'         => esc_html__( 'Start/Continue Button', 'tutor-divi-modules' ),
                    'box_shadow'    => array(
                        'css'   => array(
                            'main'  => '%%order_class%% .tutor-lead-info-btn-group .tutor-button.tutor-success'
                        )
                    ),
                    'use_borders'   => false,
                    'css'           => array(
                        'main'  => '%%order_class%% .tutor-lead-info-btn-group .tutor-button.tutor-success'
                    ),
                    'use_alignment' => false,
                    'use_icon'      => false,
                    'tab_slug'      => 'advanced',
                    'toggle_slug'   => 'start_continue_button' ,
                    'important'     => true
                ),
                'complete_button' => array(
                    'label'         => esc_html__( 'Button', 'tutor-divi-modules' ),
                    'box_shadow'    => array(
                        'css'   => array(
                            'main'  => '%%order_class%% .tutor-course-compelte-form-wrap .course-complete-button'
                        )
                    ),
                    'css'           => array(
                        'main'  => '%%order_class%% .tutor-course-compelte-form-wrap .course-complete-button'
                    ),
                    'use_alignment' => false,
                    'tab_slug'      => 'advanced',
                    'toggle_slug'   => 'complete_button',
                    'important'     => true
                ),
                'gradebook_button' => array(
                    'label'         => esc_html__( 'Gradebook Button', 'tutor-divi-modules' ),
                    'box_shadow'    => array(
                        'css'   => array(
                            'main'  => '%%order_class%% .tutor-lead-info-btn-group .generate-course-gradebook-btn-wrap .tutor-button'
                        )
                    ),
                    'css'           => array(
                        'main'  => '%%order_class%% .tutor-lead-info-btn-group .generate-course-gradebook-btn-wrap > .tutor-button'
                    ),
                    'use_alignment' => false,
                    'tab_slug'      => 'advanced',
                    'toggle_slug'   => 'gradebook_button',
                    'important'     => true
                ),
            ),
            'borders'           => false,
            'box_shadow'        => false,
            'text'              => false,
            'max_width'         => false,
            //'margin_padding'  => false,           
            //'background'        => false,
            'filters'           => false,
            'animation'         => false,
            'transform'         => false
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
        return array(
            'course'       	=> Helper::get_field(
				array(
					'default'          => Helper::get_course_default(),
					'computed_affects' => array(
						'__enrollment',
					),
				)
			),
            '__enrollment'  => array(
                'type'          => 'computed',
                'computed_callback' => array(
                    'CourseEnrollment',
                    'get_props'
                ),
                'computed_depends_on'   => array(
                    'course'
                ),
                'computed_minimum'      => array(
                    'course'
                )
            ),
            //general tab main_content toggle
            'preview_mode'      => array(
                'label'             => esc_html__( 'Preview Mode', 'tutor-divi-modules' ),
                'type'              => 'select',
                'options'           => array(
                    'enrollment'  => esc_html__( 'Enrollment', 'tutor-divi-modules' ),
                    'enrolled'    => esc_html__( 'Enrolled', 'tutor-divi-modules' ),
                ),
                'default'           => 'enrollment',
                'toggle_slug'       => 'main_content'
            ),
            //general tab customize_btn toggle
			'alignment'		=> array(
				'label'				=> esc_html__('Alignment', 'tutor-divi-modules'),
				'type'				=> 'text_align',
				'option_category'	=> 'configuration',
				'options'			=> et_builder_get_text_orientation_options( array( 'justified' ) ),
				'default'			=> 'center',
				'toggle_slug'		=> 'customize_btn',
				'mobile_options'	=> true
			),
            'button_size'      => array(
                'label'             => esc_html__( 'Size', 'tutor-divi-modules' ),
                'type'              => 'select',
                'option_category'   => 'basic_option',
                'options'           => array(
                    'small'     => esc_html__( 'Small', 'tutor-divi-modules' ),
                    'medium'    => esc_html__( 'Medium', 'tutor-divi-modules' ),
                    'large'     => esc_html__( 'Large', 'tutor-divi-modules' ),
                ),
                'default'           => 'medium',
                'toggle_slug'       => 'customize_btn'
            ),
            'btn_width'      => array(
                'label'             => esc_html__( 'Width', 'tutor-divi-modules' ),
                'type'              => 'select',
                'option_category'   => 'configuration',
                'options'           => array(
                    'auto'      => esc_html__( 'Auto', 'tutor-divi-modules' ),
                    'fill'      => esc_html__( 'Fill', 'tutor-divi-modules' ),
                    'fixed'     => esc_html__( 'Fixed', 'tutor-divi-modules' ),
                ),
                'default'           => 'fill',
                'toggle_slug'       => 'customize_btn'
            ),
            'width_px'			=> array(
				'label'				=> esc_html__( 'Button Width', 'tutor-divi-modules' ),
				'type'				=> 'range',
				'default'			=> '150px',
				'default_unit'		=> 'px',
				'range_settings'	=> array(
					'min'	=> '1',
					'max'	=> '500',
					'step'	=> '1'
				),
				'tab_slug'			=> 'general',
				'toggle_slug'		=> 'customize_btn',
				
                'show_if'           => array(
                    'btn_width'     => 'fixed'
                )
			),
            //advanced tab enrolled_info toggle
			'icon_size'			=> array(
				'label'				=> esc_html__( 'Icon Size', 'tutor-divi-modules' ),
				'type'				=> 'range',
				'default'			=> '10px',
				'default_unit'		=> 'px',
				'range_settings'	=> array(
					'min'	=> '1',
					'max'	=> '100',
					'step'	=> '1'
				),
				'tab_slug'			=> 'advanced',
				'toggle_slug'		=> 'enrolled_info',
				'mobile_options'	=> true
			),
            'icon_color'    => array(
                'label'         => esc_html__( 'Icon Color', 'tutor-divi-modules' ),
                'type'          => 'color-alpha',
                'tab_slug'      => 'advanced',
                'toggle_slug'   => 'enrolled_info'
            ),

        );
    }
	/**
	 * Get props
     * @since 1.0.0
     * @return bool
	 */
    public static function get_props( $args = [] ) {
        return tutils()->is_course_purchasable($args['course']) ? true : false;
    }

	/**
	 * Get content
	 * @since 1.0.0
	 * @return string
	 */
    public function get_content( $args = [] ) {
        ob_start();
        $is_enrolled = tutils()->is_enrolled();
        $is_administrator = current_user_can('administrator');
        $is_instructor = tutor_utils()->is_instructor_of_this_course();
        $course_content_access = (bool) get_tutor_option('course_content_access_for_ia');
      
        $template = 'enrolment_box';
        if ($is_enrolled || ($course_content_access && ($is_administrator || $is_instructor))) {
            $template = 'enrolled-box';
        } else {
            $template = 'enrolment-box';
        }
        include_once dtlms_get_template  ('course/'.$template);        
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
    public function render ( $attrs, $content = null, $render_slug ) {

        //selectors
        $three_buttons_wrapper = '%%order_class%% .tutor-lead-info-btn-group';
        $enroll_box_selector   = '%%order_class%% .tutor-course-enrollment-box';
        //props
        $alignment              = $this->props['alignment'];
      
        $alignment_tablet       = isset($this->props['alignment_tablet']) && $this->props['alignment_tablet'] !== '' ? $this->props['alignment_tablet'] : $alignment;
        $alignment_phone        = isset($this->props['alignment_phone']) && $this->props['alignment_phone'] !== '' ? $this->props['alignment_phone'] : $alignment;

        $alignment              = ($alignment === 'left' ? 'flex-start' : ($alignment === 'right' ? 'flex-end' : 'center'));
        $alignment_tablet       = ($alignment_tablet === 'left' ? 'flex-start' : ($alignment_tablet === 'right' ? 'flex-end' : 'center'));
        $alignment_phone        = ($alignment_phone === 'left' ? 'flex-start' : ($alignment_phone === 'right' ? 'flex-end' : 'center'));

        $width                  = $this->props['btn_width'];
        $width_px               = $this->props['width_px'];
        $button_size            = $this->props['button_size'];

        $icon_color             = $this->props['icon_color'];
        $icon_size              = $this->props['icon_size'];
        $icon_size_tablet       = isset($this->props['icon_size_tablet']) && $this->props['icon_size_tablet'] !== '' ? $this->props['icon_size_tablet'] : $icon_size;
        $icon_size_phone        = isset($this->props['icon_size_phone']) && $this->props['icon_size_phone'] !== '' ? $this->props['icon_size_phone'] : $icon_size;

        $add_to_cart_button_icon    = $this->props['add_to_cart_button_icon'];
        //btn width

        if( $width === 'fill' ) {
            ET_Builder_Element::set_style(
                $render_slug,
                array(
                    'selector'      => '%%order_class%% #tutor-gradebook-generate-for-course',
                    'declaration'   => 'width: 100%;'
                )
            );            
            //for add to cart button
            ET_Builder_Element::set_style(
                $render_slug,
                array(
                    'selector'      => '%%order_class%% .tutor-course-purchase-box form',
                    'declaration'   => 'width: 100%;'
                )
            );            

            ET_Builder_Element::set_style(
                $render_slug,
                array(
                    'selector'      => '%%order_class%% .single_add_to_cart_button.tutor-button',
                    'declaration'   => 'display: flex; justify-content: center; width:100%;'
                )
            );

        } else if ( $width === 'auto') {
            ET_Builder_Element::set_style(
                $render_slug,
                array(
                    'selector'      => '%%order_class%% .tutor-course-enrollment-box .tutor-button, %%order_class%% .tutor-course-enrollment-box .course-complete-button, %%order_class%% .tutor-course-enrollment-box .tutor-btn-enroll',
                    'declaration'   => 'width: -moz-fit-content !important;'
                )
            );
        } else {
            if( $width !== '') {
                ET_Builder_Element::set_style(
                    $render_slug,
                    array(
                        'selector'      => '%%order_class%% .tutor-course-enrollment-box .tutor-button, %%order_class%% .tutor-course-enrollment-box .course-complete-button, %%order_class%% .tutor-course-enrollment-box, %%order_class%% .tutor-course-enrollment-box .tutor-btn-enroll',
                        'declaration'   => sprintf(
                            'width: %1$s !important;',
                            $width_px
                        )
                    )
                );
            }
        }

        //alignment styles 
       
        if( $alignment !== '' ) {
            //enrolled_box style
            ET_Builder_Element::set_style(
                $render_slug,
                array(
                    'selector'      =>  '%%order_class%% .tutor-course-purchase-box, %%order_class%% .tutor-course-enroll-wrap, %%order_class%% .tutor-course-compelte-form-wrap',
                    'declaration'   => sprintf(
                        'display: flex; justify-content: %1$s;',
                        $alignment
                    )
                )
            );
            //start course button
            ET_Builder_Element::set_style(
                $render_slug,
                array(
                    'selector'      =>  '%%order_class%% .tutor-lead-info-btn-group',
                    'declaration'   => sprintf(
                        'display: flex; flex-direction: column; align-items: %1$s !important;',
                        $alignment
                    )
                )
            );
        }

        if( $alignment_tablet !== '' ) {
            //enrolled_box style
            ET_Builder_Element::set_style(
                $render_slug,
                array(
                    'selector'      =>  '%%order_class%% .tutor-course-purchase-box, %%order_class%% .tutor-course-enroll-wrap, %%order_class%% .tutor-course-compelte-form-wrap',
                    'declaration'   => sprintf(
                        'display: flex; justify-content: %1$s;',
                        $alignment_tablet
                    ),
                    'media_query'   => ET_Builder_Element::get_media_query('max_width_980')
                )
            );
            //start course button
            ET_Builder_Element::set_style(
                $render_slug,
                array(
                    'selector'      =>  '%%order_class%% .tutor-lead-info-btn-group',
                    'declaration'   => sprintf(
                        'display: flex; flex-direction: column; align-items: %1$s !important;',
                        $alignment_tablet
                    ),
                    'media_query'   => ET_Builder_Element::get_media_query('max_width_980')
                )
            );
        }
        if( $alignment_phone !== '' ) {
            //enrolled_box style
            ET_Builder_Element::set_style(
                $render_slug,
                array(
                    'selector'      =>  '%%order_class%% .tutor-course-purchase-box, %%order_class%% .tutor-course-enroll-wrap, %%order_class%% .tutor-course-compelte-form-wrap',
                    'declaration'   => sprintf(
                        'display: flex; justify-content: %1$s;',
                        $alignment_phone
                    ),
                    'media_query'   => ET_Builder_Element::get_media_query('max_width_767')
                )
            );
            //start course button
            ET_Builder_Element::set_style(
                $render_slug,
                array(
                    'selector'      =>  '%%order_class%% .tutor-lead-info-btn-group',
                    'declaration'   => sprintf(
                        'display: flex; flex-direction: column; align-items: %1$s !important;',
                        $alignment_phone
                    ),
                    'media_query'   => ET_Builder_Element::get_media_query('max_width_767')
                )
            );
        }
        //button size style
        if( $button_size === 'small' ) {
            ET_Builder_Element::set_style(
                $render_slug,
                array(
                    'selector'      => "%%order_class%% .single_add_to_cart_button, %%order_class%% .tutor-course-enroll-wrap .tutor-btn, %%order_class%% .tutor-lead-info-btn-group .tutor-button, %%order_class%% .course-complete-button, %%order_class%% .generate-course-gradebook-btn-wrap .tutor-button",
                    'declaration'   => 'padding: 9px 14px !important;'
                )
            );
        } else if( $button_size === 'large' ) {
            ET_Builder_Element::set_style(
                $render_slug,
                array(
                    'selector'      => "%%order_class%% .single_add_to_cart_button, %%order_class%% .tutor-course-enroll-wrap .tutor-btn, %%order_class%% .tutor-lead-info-btn-group .tutor-button, %%order_class%% .course-complete-button, %%order_class%% .generate-course-gradebook-btn-wrap .tutor-button",
                    'declaration'   => 'padding: 18px !important;'
                )
            );
        }

        //boders default border style
        ET_Builder_Element::set_style(
            $render_slug,
            array(
                'selector'      => '%%order_class%% .tutor-course-enrollment-box .tutor-btn-enroll,  %%order_class%% .tutor-course-enrollment-box .single_add_to_cart_button.tutor-button, %%order_class%% .tutor-lead-info-btn-group .tutor-button.tutor-success, %%order_class%% .tutor-course-compelte-form-wrap .course-complete-button, %%order_class%% .tutor-lead-info-btn-group .generate-course-gradebook-btn-wrap',
                'declaration'   => 'border-style: solid;'
            )
        );

        //purchase icon style
        if( $icon_color !== '' ) {
            ET_Builder_Element::set_style(
                $render_slug,
                array(
                    'selector'      => '%%order_class%% .tutor-single-course-segment.tutor-course-enrolled-wrap p >i',
                    'declaration'   => sprintf(
                        'color: %1$s;',
                        $icon_color
                    )
                )
            );
        }

        if( $icon_size !== '' ) {
            ET_Builder_Element::set_style(
                $render_slug,
                array(
                    'selector'      => '%%order_class%% .tutor-single-course-segment.tutor-course-enrolled-wrap p >i',
                    'declaration'   => sprintf(
                        'font-size: %1$s',
                        $icon_size
                    )
                )
            );            
        }

        if( $icon_size_tablet !== '' ) {
            ET_Builder_Element::set_style(
                $render_slug,
                array(
                    'selector'      => '%%order_class%% .tutor-single-course-segment.tutor-course-enrolled-wrap p >i',
                    'declaration'   => sprintf(
                        'font-size: %1$s',
                        $icon_size_tablet
                    ),
                    'media_query'   => ET_Builder_Element::get_media_query('max_width_980')
                )
            );            
        }
        
        if( $icon_size_phone !== '' ) {
            ET_Builder_Element::set_style(
                $render_slug,
                array(
                    'selector'      => '%%order_class%% .tutor-single-course-segment.tutor-course-enrolled-wrap p >i',
                    'declaration'   => sprintf(
                        'font-size: %1$s',
                        $icon_size_phone
                    ),
                    'media_query'   => ET_Builder_Element::get_media_query('max_width_767')
                )
            );            
        }
        if( '' !== $add_to_cart_button_icon ) {
            ET_Builder_Element::set_style(
                $render_slug,
                array(
                    'selector'      => '%%order_class%% i.tutor-icon-shopping-cart:before',
                    'declaration'   => 'content:"" !important ;'
                )
            );
        }
        //set styles end

        $output = self::get_content( $this->props );
        if( '' === $output) {
            return '';
        }
        return $this->_render_module_wrapper( $output, $render_slug );
    }

}
new CourseEnrollment;

