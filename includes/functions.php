<?php

/**
 * @param null $template
 *
 * @return mixed|void
 *
 * @since v.1.0.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'dtlms_get_template' ) ) {
	function dtlms_get_template( $template = null ) {
		$template = str_replace( '.', DIRECTORY_SEPARATOR, $template );

		$template_dir      = apply_filters( 'dtlms_template_dir', DTLMS_DIR_PATH );
		$template_location = trailingslashit( $template_dir ) . "includes/templates/{$template}.php";
		return apply_filters( 'dtlms_get_template_path', $template_location, $template );
	}
}

/**
 * get available category terms
 *
 * @since 1.0.0
*/
if ( ! function_exists( 'tutor_divi_course_categories' ) ) {
	function tutor_divi_course_categories() {
		$course_categories      = array();
		$course_categories_term = tutils()->get_course_categories_term();
		foreach ( $course_categories_term as $term ) {
			$course_categories[ $term->term_id ] = $term->name;
		}

		return $course_categories;
	}
}

/**
 * get available authors
 *
 * @since 1.0.0
*/
if ( ! function_exists( 'tutor_divi_course_authors' ) ) {
	function tutor_divi_course_authors() {
		$course_authors = array();
		$authors        = get_users( array( 'role__in' => array( 'author', tutor()->instructor_role ) ) );
		foreach ( $authors as $author ) {
			$course_authors[ $author->ID ] = $author->display_name;
		}

		return $course_authors;
	}
}

/**
 * get user's selected terms by comparing available category
 * and category includes by the user
 * comparison by the both array keys($available_cat, $category_includes)
 *
 * @param $available_cat array
 * @param $category_includes array
 * @since 1.0.0
*/

if ( ! function_exists( 'tutor_divi_get_user_selected_terms' ) ) {
	function tutor_divi_get_user_selected_terms( $available_cat, $category_includes ) {
		// filter only selected cat keys
		$includes_keys = array_filter(
			$category_includes,
			function( $cat ) {
				if ( $cat === 'on' ) {
					return $cat;
				}
			}
		);
		// available terms
		$available_terms = array_keys( $available_cat );
		$selected_terms  = array();

		// push user's selected terms
		foreach ( $includes_keys as $key => $value ) {
			array_push( $selected_terms, $available_terms[ $key ] );
		}

		// return implode(',', $selected_terms);
		return $selected_terms;
	}
}

if ( ! function_exists( 'tutor_divi_get_user_selected_authors' ) ) {
	function tutor_divi_get_user_selected_authors( $available_author, $author_includes ) {
		$available_author_ids = array_keys( $available_author );
		$selected_authors     = array_filter(
			$author_includes,
			function( $author ) {
				if ( $author == 'on' ) {
					return $author;
				}
			}
		);

		$selected_author_ids = array();
		foreach ( $selected_authors as $k => $v ) {
			array_push( $selected_author_ids, $available_author_ids[ $k ] );
		}
		return $selected_author_ids;
	}
}
