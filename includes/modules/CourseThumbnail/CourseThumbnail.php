<?php

use TutorLMS\Divi\Helper;

class CourseThumbnail extends ET_Builder_Module {

	public $slug       = 'tutor_course_thumbnail';
	public $vb_support = 'on';

	public function init() {
		$this->name = esc_html__( 'Tutor Course Thumbnail', 'tutor-divi-modules' );
	}

	public function get_fields() {
		return array(
			'course'       	=> Helper::get_field(
				array(
					'default'          => Helper::get_course_default(),
					'computed_affects' => array(
						'__thumbnail',
					),
				)
			),
			'__thumbnail'		=> array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'CourseThumbnail',
					'get_props',
				),
				'computed_depends_on' => array(
					'course'
				),
				'computed_minimum'    => array(
					'course',
				),
			),

		);
	}

	/**
	 * computed value
	 * @return string | array course level
	 */
	public static function get_props( $args = [] ) {
		$course_id 			= $args[ 'course' ];
        $thumbnail          = '' ;
        $has_video          = get_post_meta( $course_id, '_video', true );;
        $source             = '';
        if($has_video['source'] == '-1'){
            $thumbnail = get_the_post_thumbnail_url( $course_id, $size = 'post-thumbnail');

        } else{
            $video = $has_video;
            if($video && '' !== $video['source_youtube']) {
                $thumbnail  = $video['source_youtube'];
                $source     = 'youtube';
            } else if( $video && '' !== $video['source_vimeo']) {
                $thumbnail = $video['source_vimeo'];
                $source     = 'vimeo';
            }           
        }
        $props  = array(
            'url'  => $thumbnail,
            'has_video' => $has_video['source'] == '-1' ? false : true,
            'source'    => $source
        );
        return $props;
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
new CourseThumbnail;