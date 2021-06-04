<?php

class TutorDiviModules extends DiviExtension {

	/**
	 * The gettext domain for the extension's translations.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $gettext_domain = 'tutor-divi-modules';

	/**
	 * The extension's WP Plugin name.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $name = 'tutor-divi-modules';

	/**
	 * The extension's version
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $version = DTLMS_VERSION;

	/**
	 * TUDM_TutorDiviModules constructor.
	 * load dependecny
	 * load scripts 
	 * load text-domain
	 * @param string $name
	 * @param array  $args
	 */
	public function __construct( $name = 'tutor-divi-modules', $args = array() ) {
		$this->plugin_dir     = plugin_dir_path( __FILE__ );
		$this->plugin_dir_url = plugin_dir_url( $this->plugin_dir );

		parent::__construct( $name, $args );

		$this->load_dependencies();

		add_action('wp_enqueue_scripts', [$this, 'enqueue_divi_styles'], 99);
		add_action('wp_enqueue_scripts', [$this, 'enqueue_divi_scripts'], 99);

		add_action('init', [$this, 'load_textdomain']);
	}

	public function load_dependencies() {
		require_once $this->plugin_dir . 'functions.php';
		require_once $this->plugin_dir . 'classes/Helper.php';
		require_once $this->plugin_dir . 'classes/Template.php';
		require_once $this->plugin_dir . 'classes/Requirements.php';
	}

    public function enqueue_divi_styles(){
		$css_file 	= DTLMS_ENV == 'DEV' ? "css/tutor-divi-style.css" : "css/tutor-divi-style.min.css"; 
		$version	= DTLMS_ENV == 'DEV' ? time() : $this->version;
        wp_enqueue_style(
            'tutor-divi-styles',
            DTLMS_ASSETS . $css_file,
            array(), 
            $version
        );
		wp_enqueue_style(
            'tutor-divi-slick-css',
            'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.css',
            null,
            $this->version
        );      

        wp_enqueue_style(
            'tutor-divi-slick-theme-css',
            'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css',
            null,
            $this->version
        );
    }

    public function enqueue_divi_scripts(){
 		$version = DTLMS_ENV == 'DEV' ? time() : $this->version;
 		$scripts_file = 'js/scripts.js';
		wp_enqueue_script(
			'tutor-divi-scripts',
			DTLMS_ASSETS . $scripts_file,
			array('jquery'),
			$version,
			true
		);
		wp_enqueue_script(
			'tutor-divi-slick',
			'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js',
			array('jquery'),
			$this->version,
			true
		);

    }	

    /**
	 * load plugin text domain
	 * @since 1.0.0
	 * @return void
    */
    public function load_textdomain() {
    	load_plugin_textdomain('tutor-divi-modules', false, DTLMS_DIR_PATH.'languages/' );
    }
}

new TutorDiviModules;

