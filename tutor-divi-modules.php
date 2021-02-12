<?php
/*
Plugin Name: Tutor LMS Divi Modules
Plugin URI:  https://www.themeum.com/product/tutor-lms/
Description: Divi Modules Integration - Tutor LMS plugin let's you to design your courses, lesson page by Divi Builder.
Version:     1.0.0
Author:      Themeum
Author URI:  https://themeum.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: tutor-divi-modules
Domain Path: /languages

Tutor LMS Divi Modules is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Tutor LMS Divi Modules is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Tutor LMS Divi Modules. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

defined('ABSPATH') || die();

define('DTLMS_VERSION', '1.0.0');
define('DTLMS_FILE__', __FILE__);
define('DTLMS_DIR_PATH', plugin_dir_path(DTLMS_FILE__));
define('DTLMS_DIR_URL', plugin_dir_url(DTLMS_FILE__));
define('DTLMS_ASSETS', trailingslashit(DTLMS_DIR_URL . 'assets'));
/**
 * Environment
 * PROD 
 * DEV
 */
define('DTLMS_ENV', 'DEV');

if ( ! function_exists( 'tudm_initialize_extension' ) ):
/**
 * Creates the extension's main class instance.
 *
 * @since 1.0.0
 */
function tudm_initialize_extension() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/TutorDiviModules.php';
}
add_action( 'divi_extensions_init', 'tudm_initialize_extension' );
endif;
