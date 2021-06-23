<?php
/**
 * Admin notice
 */

defined( 'ABSPATH' ) || exit;

$tutor_basename = 'tutor/tutor.php';
$source_file = WP_PLUGIN_DIR . '/' . $tutor_basename;

$action = $button_txt = $button_class = '';
if (file_exists($source_file) && !is_plugin_active($tutor_basename)) {
    $action = 'activate_tutor_free';
    $button_txt = __('Activate Tutor LMS', 'tutor-lms-divi-modules');
} elseif ( !file_exists($source_file) ) {
    $action = 'install_tutor_plugin';
    $button_txt = __('Install Tutor LMS', 'tutor-lms-divi-modules');
    $button_class = 'install-etlms-dependency-plugin-button';
}
if( $action ):
?>
<div class="notice notice-error dtlms-install-notice">
    <div class="dtlms-install-notice-inner">
        <div class="dtlms-install-notice-icon">
            <img src="<?php esc_attr_e( DTLMS_ASSETS . 'images/tutor-divi-logo.png' ); ?>" alt="Tutor Divi Modules Logo">
        </div>
        <div class="dtlms-install-notice-content">
            <h2><?php _e('Thanks for using Tutor Divi Modules', 'tutor-lms-divi-modules'); ?></h2>
            <p><?php echo sprintf(__('To use Tutor Divi Modules, you must have <a href="%s" target="_blank">Tutor LMS</a> Free installed and activated', 'tutor-lms-divi-modules'), esc_url('https://wordpress.org/plugins/tutor/')); ?></p>
            <a href="https://www.themeum.com/product/tutor-lms/" target="_blank"><?php _e('Learn more about Tutor LMS', 'tutor-lms-divi-modules'); ?></a>
        </div>
        <div class="dtlms-install-notice-button">
            <a  class="button button-primary <?php esc_attr_e( $button_class ); ?>" data-slug="tutor" href="<?php esc_attr_e( add_query_arg(array('action' => $action), admin_url()) ); ?>"><?php  echo esc_html( $button_txt ); ?></a>
        </div>
    </div>
   
</div>

<?php endif;?>