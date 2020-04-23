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
		$template_location = trailingslashit( $template_dir ) . "templates/{$template}.php";
		return apply_filters( 'dtlms_get_template_path', $template_location, $template );
	}
}
