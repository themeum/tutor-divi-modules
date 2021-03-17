<?php

use TutorLMS\Divi\Helper;

class CourseThumbnail extends ET_Builder_Module {

	public $slug       = 'tutor_course_thumbnail';
	public $vb_support = 'on';

	public function init() {
		$this->name = esc_html__( 'Tutor Course Thumbnail', 'tutor-divi-modules' );

        $wrapper 				= '%%order_class%% .tutor-divi-course-thumbnail';
        $this->advanced_fields = array(
            'fonts'     => false,
            'text'      => array(
                'css'   => array(
                    'main'  => $wrapper
                )
            ),
            'borders'   => array(
                'default'   => array(
                    'css'       => array(
                        'main'  => array(
                            'border_radii'     => $wrapper,
                            'border_styles'    => $wrapper
                        )
                    )
                )
            ),
            'box_shadow'    => array(
                'default'   => array(
                    'css'   => array(
                        'main'  => $wrapper
                    )
                )
            ),
            'max_width' => array(
                'css'   => array(
                    'module_alignment'  => $wrapper
                )
            )
        );
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
        $has_video          = get_post_meta( $course_id, '_video', true );
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

    public static function get_content( $args = []) {
        ob_start();
        if ($args['course']) {
    
            echo "<div class='tutor-divi-course-thumbnail'>";
            if(tutils()->has_video_in_single()){
                tutor_course_video();
            } else{
                get_tutor_course_thumbnail();
            }
            echo '</div>';
        }
       return ob_get_clean();
    }

	public function render( $unprocessed_props, $content = null, $render_slug ) {
        $output = self::get_content( $this->props );
        return $this->_render_module_wrapper( $output, $render_slug );
	}
}
new CourseThumbnail;