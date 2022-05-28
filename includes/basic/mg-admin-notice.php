<?php 

/**
 *  Magical admin notices
 */
class mgAdminNotice{

		/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.6.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.0';
	
	function __construct(){
		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}
		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

	}


	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		
		if ( file_exists( WP_PLUGIN_DIR . '/elementor/elementor.php' ) ) {
				$magial_eactive_url = wp_nonce_url( 'plugins.php?action=activate&plugin=elementor/elementor.php&plugin_status=all&paged=1', 'activate-plugin_elementor/elementor.php' );
					$message = sprintf(
			        /* translators: 1: Plugin name 2: Elementor 3: Elementor installation link */
			        esc_html__( '%1$s requires %2$s plugin, which is currently NOT RUNNING  %3$s', 'magical-addons-for-elementor' ),
			        '<strong>' . esc_html__( 'Magical Addons For Elementor', 'magical-addons-for-elementor' ) . '</strong>',
			        '<strong>' . esc_html__( 'Elementor', 'magical-addons-for-elementor' ) . '</strong>',
			        '<a class="button button-primary" style="margin-left:20px" href="'.$magial_eactive_url.'">' . __( 'Activate Elementor', 'magical-addons-for-elementor' ) . '</a>'

			    );

			} else {

				$magial_einstall_url =  wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
					$message = sprintf(
			        /* translators: 1: Plugin name 2: Elementor 3: Elementor installation link */
			        esc_html__( '%1$s requires %2$s plugin, which is currently NOT RUNNING  %3$s', 'magical-addons-for-elementor' ),
			        '<strong>' . esc_html__( 'Magical Addons For Elementor', 'magical-addons-for-elementor' ) . '</strong>',
			        '<strong>' . esc_html__( 'Elementor', 'magical-addons-for-elementor' ) . '</strong>',
			        '<a class="button button-primary" style="margin-left:20px" href="'.$magial_einstall_url.'">' . __( 'Install Elementor', 'magical-addons-for-elementor' ) . '</a>'

			    );
			
			}



    printf( '<div class="notice notice-warning is-dismissible"><p style="padding: 13px 0">%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
		/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'magical-addons-for-elementor' ),
			'<strong>' . esc_html__( 'Magical addons for elementor', 'magical-addons-for-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'magical-addons-for-elementor' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}
	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
		/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'magical-addons-for-elementor' ),
			'<strong>' . esc_html__( 'Magical addons for elementor', 'magical-addons-for-elementor' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'magical-addons-for-elementor' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}




}