<?php

class CourseList extends ET_Builder_Module {

	public $slug       = 'tutor_course_list';
	public $vb_support = 'on';

	public function init() {
		$this->name = esc_html__( 'Tutor Course List', 'tutor-divi-modules' );
	}

	public function get_fields() {
		return array(
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

	public function render( $unprocessed_props, $content = null, $render_slug ) {
        return sprintf(
            '
            <h1>%s</h1>
            <p>%s</p>
            ', 
            $this->props['tutor_course_list_heading_new'], 
            $this->props['content']
        );
        
	}
}
new CourseList;