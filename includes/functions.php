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
			$term_id = is_object( $term ) ? ( $term->term_id ?? 0 ) : ( $term['term_id'] ?? 0 );
			$name    = is_object( $term ) ? ( $term->name ?? '' ) : ( $term['name'] ?? '' );

			if ( $term_id ) {
				$course_categories[ $term_id ] = $name;
			}
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

/**
 * Enqueue Slick.
 *
 * Called from the Course Carousel render callback, so the files load only when
 * that module is rendered.
 *
 * @since 4.0.0
 * @return void
 */
if ( ! function_exists( 'dtlms_enqueue_carousel_assets' ) ) {
	function dtlms_enqueue_carousel_assets() {
		wp_enqueue_style(
			'tutor-divi-slick-css',
			DTLMS_ASSETS . 'slick/slick.min.css',
			array(),
			DTLMS_VERSION
		);
		wp_enqueue_style(
			'tutor-divi-slick-theme-css',
			DTLMS_ASSETS . 'slick/slick-theme.css',
			array(),
			DTLMS_VERSION
		);
		wp_enqueue_script(
			'tutor-divi-slick',
			DTLMS_ASSETS . 'slick/slick.min.js',
			array( 'jquery' ),
			DTLMS_VERSION,
			true
		);

		if ( wp_script_is( 'tutor-divi-scripts', 'registered' ) ) {
			global $wp_scripts;

			$deps = $wp_scripts->registered['tutor-divi-scripts']->deps;

			if ( ! in_array( 'tutor-divi-slick', $deps, true ) ) {
				$wp_scripts->registered['tutor-divi-scripts']->deps[] = 'tutor-divi-slick';
			}
		}

		// Module render runs after wp_head, so print the stylesheets in the body.
		if ( did_action( 'wp_print_styles' ) ) {
			wp_print_styles(
				array(
					'tutor-divi-slick-css',
					'tutor-divi-slick-theme-css',
				)
			);
		}
	}
}
