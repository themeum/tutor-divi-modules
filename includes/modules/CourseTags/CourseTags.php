<?php

/**
 * Tutor Course Author Module for Divi Builder
 * @since 1.0.0
 */

use TutorLMS\Divi\Helper;

class CourseTags extends ET_Builder_Module {

    // Module slug (also used as shortcode tag)
    public $slug        = 'tutor_course_tags';
    public $vb_support  = 'on';

	// Module Credits (Appears at the bottom of the module settings modal)
	protected $module_credits = array(
		'author'     => 'Themeum',
		'author_uri' => 'https://themeum.com',
	);

    public function init() {
        $this->name         = esc_html__( 'Tutor Course Tags', 'tutor-divi-modules' ); 
        $this->icon_path	= plugin_dir_path( __FILE__ ) . 'icon.svg';

		/**
		 * settings toggles
		 * set all the toggles that will show in different tabs
		 */
		$this->settings_modal_toggles = array(
			'general'  => array(

			),
			'advanced'	=> array(
				'toggles'		=> array(
					'title'		=> array(
						'title'		=> esc_html__( 'Section Title', 'tutor-divi-modules' ),
					),
					'tags'		=> array(
						'title'		=> esc_html__( 'Tags', 'tutor-divi-modules' )
					)
				)
			)
		);

		/**
		 * advanced tabs settings
		 */
		$this->advanced_fields = array(
			'fonts'		=> array(
				'title'		=> array(
					'css'				=> array(
						'main'	=> 'selector'
					),
					'tab_slug'			=> 'advanced',
					'toggle_slug'		=> 'title'
				),
				'tags'	=> array(
					'css'				=> array(
						'main'	=> ''
					),
					'tab_slug'			=> 'advanced',
					'toggle_slug'		=> 'tags',
				),
			),
			'borders'    => array(
				'default'		=> array(
					'css'	=> array(
						'main'	=> array(
							'border_style'	=> '',
							'border_radii'	=> ''
						)
					)
				),
			),
		
		);
    }

    public function get_fields() {
		return array(
			'label'     => array(
				'label'           	=> esc_html__( 'Label', 'tutor-divi-modules' ),
				'type'            	=> 'text',
				'option_category' 	=> 'basic_option',
				'toggle_slug'     	=> 'main_content',
			),
		);
    }

    public function render( $attr, $content = null, $render_slug) {
        return " course tags ";
    }

}
new CourseTags;