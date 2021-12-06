<?php

/**
 * Tutor Course Price Module for Divi Builder
 * @since 1.0.0
 * @author Themeum<www.themeum.com>
 */

use TutorLMS\Divi\Helper;

defined( 'ABSPATH' ) || exit;

class CoursePrice extends ET_Builder_Module {

    // Module slug (also used as shortcode tag)
    public $slug        = 'tutor_course_price';
    public $vb_support  = 'on';

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
        $this->name         = esc_html__( 'Tutor Course Price', 'tutor-lms-divi-modules' ); 
        $this->icon_path	= plugin_dir_path( __FILE__ ) . 'icon.svg';

		//settings toggles
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__('Content', 'tutor-lms-divi-modules'),
				),
			)
		);

		$selector 		= '%%order_class%% .price >ins, %%order_class%% .price > span' ;
		$hover_selector = '%%order_class%% .price:hover';

		$this->advanced_fields = array(
			'fonts'          => array(

				'normal_style' 	=> array(
					'css'          => array(
						'main' => $selector,
					),
					'hide_text_align'	=> true,
					'tab_slug'     		=> 'advanced',
					
				),

			),
			'button'			=> false,
			'text'				=> false,
			'borders'			=> false,
			'max_width'			=> false,
			'animation'			=> false,
			'transform'			=> false,
			//'background'		=> false,
			'filters'			=> false,
			'box_shadow'		=> false					 
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
						'__share',
					),
				)
			),
			'__price'		=> array(
				'type'					=> 'computed',
				'computed_callback'		=> array(
					'CoursePrice',
					'get_props'
				),
				'computed_depends_on'	=> array( 'course' ),
				'computed_minimum'		=> array( 'course' ),
			),
			'alignment'		=> array(
				'label'				=> esc_html__('Alignment', 'tutor-lms-divi-modules'),
				'type'				=> 'text_align',
				'option_category'	=> 'configuration',
				'options'			=> et_builder_get_text_orientation_options( array( 'justified' ) ),
				'default'			=> 'left',
				'toggle_slug'		=> 'main_content',
				'mobile_options'	=> true
			),

		);
    }


	/**
	 * computed value
	 * @since 1.0.0
	 * @return string | array course level
	 */
	public static function get_props( $args = [] ) {
		$course_id 	= $args[ 'course' ];
		$price		= tutor_utils()->get_raw_course_price( $course_id );
		return $price ? $price : 'Free' ;
	}	

	/**
	 * computed value
	 * @since 1.0.0
	 * @return string
	 */
	public static function get_content() {
		ob_start();
		tutor_course_price() ;
		$price 		= ob_get_clean(); 	
		$content = '<div class="tutor-divi-course-price"><div class="price"><span>'.$price.'</span></div></div>';
		return $content;	
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
    public function render( $attr, $content, $render_slug) {
		//selectors
		$selector 		= '%%order_class%% .price .price';

		//props
		$alignment		= sanitize_text_field( $this->props['alignment'] );
		$alignment_tablet	= isset( $this->props['alignment_tablet'] ) && '' !== $this->props['alignment_tablet'] ? sanitize_text_field( $this->props['alignment_tablet'] ) : $alignment;
		$alignment_phone	= isset( $this->props['alignment_phone'] ) && '' !== $this->props['alignment_phone'] ? sanitize_text_field( $this->props['alignment_phone'] ) : $alignment;	

		if( 'left' === $alignment) {
			$alignment = 'flex-end';
		} else if ( 'right' === $alignment ) {
			$alignment = 'flex-start';
		}		

		if( 'left' === $alignment_tablet) {
			$alignment_tablet = 'flex-end';
		} else if ( 'right' === $alignment_tablet ) {
			$alignment_tablet = 'flex-start';
		}		

		if( 'left' === $alignment_phone) {
			$alignment_phone = 'flex-end';
		} else if ( 'right' === $alignment_phone ) {
			$alignment_phone = 'flex-start';
		}

		//set styles

		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'		=> $selector,
				'declaration'	=> 'display: flex; flex-direction: row-reverse;'
			)
		);		

		if( '' !== $alignment ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $selector,
					'declaration'	=> sprintf(
						'justify-content: %1$s;',
						$alignment
					) 
				)
			);
		}
		if( '' !== $alignment_tablet ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $selector,
					'declaration'	=> sprintf(
						'justify-content: %1$s;',
						$alignment_tablet
					),
					'media_query'	=> ET_Builder_Element::get_media_query('max_width_980')
				)
			);
		}
		if( '' !== $alignment_phone ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'		=> $selector,
					'declaration'	=> sprintf(
						'justify-content: %1$s;',
						$alignment_phone
					), 
					'media_query'	=> ET_Builder_Element::get_media_query('max_width_767')
				)
			);
		}
		
		ET_Builder_Element::set_style(
			$render_slug,
			array(
				'selector'		=> '%%order_class%% .price del span bdi span, %%order_class%% .price del span bdi',
				'declaration'	=> 'font-size: 14px !important;'
			)			
		);

		//set styles end
		$output 	= self::get_content();
		return $this->_render_module_wrapper($output, $render_slug);
    }

}
new CoursePrice;