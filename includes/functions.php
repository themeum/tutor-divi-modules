<?php

/**
 * @param null $template
 *
 * @return mixed|void
 *
 * @since v.1.0.0
 */
if (!function_exists( 'dtlms_get_template' )) {
	function dtlms_get_template( $template = null ) {
		$template = str_replace( '.', DIRECTORY_SEPARATOR, $template );

		$template_dir = apply_filters( 'dtlms_template_dir', DTLMS_DIR_PATH );
		$template_location = trailingslashit( $template_dir ) . "includes/templates/{$template}.php";
		return apply_filters( 'dtlms_get_template_path', $template_location, $template );
	}
}

if (!function_exists('tutor_div_course_categories')) {
	function tutor_div_course_categories() {
		$course_categories = [];
		$course_categories_term = tutils()->get_course_categories_term();
		foreach ($course_categories_term as $term) {
			$course_categories[$term->term_id] = $term->name;
		}

		return $course_categories;
	}
}

if (!function_exists('tutor_divi_course_authors')) {
	function tutor_divi_course_authors() {
		$course_authors = [];
		$authors = get_users(['role__in' => ['author', tutor()->instructor_role]]);
		foreach ( $authors as $author ) {
			$course_authors[$author->ID] = $author->display_name;
		}

		return $course_authors;
	}
}