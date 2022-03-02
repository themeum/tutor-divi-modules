<?php
/**
 * Check dependency
 *
 * @package DTLMSDependency
 *
 * @since v2.0.0
 */

namespace TutorLMS\Divi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Manage Tutor LMS Divi Modules dependency on Tutor Core
 *
 * @since v2.0.0
 */
class Dependency {

	/**
	 * Register hooks
	 *
	 * @since v2.0.0
	 */
	public function show_admin_notice() {
		?>
			<div class="notice notice-error etlms-install-notice">
				<div class="dtlms-install-notice-inner" style="display:flex; justify-content: space-between; align-items: center; padding-top: 10px">
					<div>
						<div class="tutor-bs-d-flex align-items-center" style="column-gap: 10px;" style="display:flex; align-items: center;">
							<div class="etlms-install-notice-icon">
                                <img src="<?php esc_attr_e( DTLMS_ASSETS . 'images/tutor-divi-logo.png' ); ?>" alt="Tutor Divi Modules Logo">
							</div>
							<div class="etlms-install-notice-content">
								<h2 style="margin-bottom: 5px">
									<i class="tutor-icon-warning-f" style="color:#ffb200;"></i> <?php esc_html_e( 'WARNING: YOU NEED TO INSTALL THE REQUIRED TUTOR LMS VERSION', 'tutor-lms-divi-modules' ); ?></h2>
								<p style="margin-bottom: 5px">
						<?php
							esc_html_e(
								'It seems you have installed the wrong version Of Tutor LMS. For a smoother Tutor LMS experience, you need to install minimum ' . DTLMS_TUTOR_CORE_REQ_VERSION . ' version.
                                    ',
								'tutor-lms-divi-modules'
							);
						?>
								</p>
								<p style="color: #757C8E;">
									<?php esc_html_e( 'Note: Tutor LMS Divi Modules will be installed but you will not be able to avail any of its’ features as well specific Tutor LMS add-ons.', 'tutor-lms-divi-modules' ); ?>
								</p>
							</div>
						</div>
					</div>
					<div class="etlms-install-notice-button">
						<a  class="button button-primary install-dtlms-dependency-plugin-button" data-slug="tutor" href="https://github.com/themeum/tutor/releases/tag/v2.0.0-beta" target="_blank"><?php esc_html_e( 'Upgrade Tutor LMS' ); ?></a>
					</div>
				</div>
			</div>
				<?php
	}

	/**
	 * Check whether Tutor core has required version installed
	 *
	 * @return bool | if has return true otherwise false
	 *
	 * @since v2.0.0
	 */
	public function is_tutor_core_has_req_verion(): bool {
		$file_path              = WP_PLUGIN_DIR . '/tutor/tutor.php';
		$plugin_data            = get_file_data(
			$file_path,
			array(
				'Version' => 'Version',
			)
		);
		$tutor_version          = $plugin_data['Version'];
		$tutor_core_req_version = DTLMS_TUTOR_CORE_REQ_VERSION;
		$is_compatible          = version_compare( $tutor_version, $tutor_core_req_version, '>=' );
		return $is_compatible ? true : false;
	}

	/**
	 * Check if Tutor file is available
	 *
	 * @return boolean
	 */
	public function is_tutor_file_available(): bool {
		return file_exists( WP_PLUGIN_DIR . '/tutor/tutor.php' );
	}
}
