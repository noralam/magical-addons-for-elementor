<?php

/**
 * @link              http://wpthemespace.com
 * @since             1.1.0
 * @package           Magical Addons For Elementor
 *
 * @wordpress-plugin
 * Plugin Name:       Magical Addons For Elementor
 * Plugin URI:        
 * Description:       Premium addons for Elementor page builder
 * Version:           1.1.1
 * Author:            Noor alam
 * Author URI:        https://profiles.wordpress.org/nalam-1
 * Elementor tested up to: 3.8
 * Elementor Pro tested up to: 3.7
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       magical-addons-for-elementor
 * Domain Path:       /languages
 */
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * Main Magical Addons For Elementor Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class Magical_Addons_Elementor
{

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The plugin version.
	 */
	const VERSION = '1.1.1';

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
	const MINIMUM_PHP_VERSION = '5.6';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 * @static
	 *
	 * @var Elementor_Test_Extension The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 *
	 * @return Elementor_Test_Extension An instance of the class.
	 */
	public static function instance()
	{

		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct()
	{
		$this->define_main();
		$this->call_main_file();
		//	add_action('activated_plugin', [$this, 'go_welcome_page']);
		add_action('init', [$this, 'i18n']);
		add_action('plugins_loaded', [$this, 'init']);
	}
	/**
	 * Constract define
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function define_main()
	{
		define('MAGICAL_ADDON_VERSION', self::VERSION);
		define('MAGICAL_ADDON_URL', plugin_dir_url(__FILE__));
		define('MAGICAL_ADDON_ASSETS', plugin_dir_url(__FILE__) . '/assets/');
		define('MAGICAL_ADDON_PATH', plugin_dir_path(__FILE__));
		define('MAGICAL_ADDON_ROOT', __FILE__);
	}

	/**
	 * regirect welcome page
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function go_welcome_page($plugin)
	{
		if (plugin_basename(__FILE__) == $plugin) {
			wp_redirect(admin_url('admin.php?page=magical-addons'));
			die();
		}
	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 *
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function i18n()
	{

		load_plugin_textdomain('magical-addons-for-elementor');
	}


	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed load the files required to run the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init()
	{
		$mgadmin_notices = new mgAdminNotice();
		$enque_file = new mgAddonsEnqueueFile();
		// Add Plugin actions
		add_action('elementor/widgets/widgets_registered', [$this, 'init_widgets']);
		add_action('elementor/elements/categories_registered', [$this, 'register_new_category']);
		add_action('elementor/editor/after_enqueue_styles', [$this, 'editor_widget_styles']);
		add_action('elementor/preview/enqueue_styles', [$this, 'editor_preview_widget_styles']);

		// version update
		if (get_option('mgaddon_version') != MAGICAL_ADDON_VERSION) {
			update_option('mgaddon_version', MAGICAL_ADDON_VERSION);
		}
	}

	public function register_new_category($manager)
	{
		$manager->add_category('magical', [
			'title' => esc_html__('Magical Elements', 'magical-addons-for-elementor'),
			'icon' => 'fa fa-magic',
		]);
	}
	function editor_widget_styles()
	{
		wp_enqueue_style('mg-editor-style',  plugins_url('/assets/css/mg-editor-style.css', __FILE__), array(), MAGICAL_ADDON_VERSION, 'all');
	}
	function editor_preview_widget_styles()
	{
		wp_enqueue_style('mg-editor-style',  plugins_url('/assets/css/mg-editor-style-preview.css', __FILE__), array(), MAGICAL_ADDON_VERSION, 'all');
	}


	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init_widgets()
	{

		// Include Widget files
		require_once(__DIR__ . '/includes/magical-init-widgets.php');

		magicalWidgetInit::mg_addons_widget_init();
	}
	/**
	 * Call base file
	 *
	 * Include  files 
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function call_main_file()
	{

		// include file
		require_once(MAGICAL_ADDON_PATH . '/includes/basic/assets-managment.php');
		require_once(MAGICAL_ADDON_PATH . '/includes/functions.php');
		require_once(MAGICAL_ADDON_PATH . '/libs/class.settings-api.php');
		require_once(MAGICAL_ADDON_PATH . '/includes/admin/admin-page.php');
		require_once(MAGICAL_ADDON_PATH . '/includes/btn-icons-class.php');
		/*
		include_once MAGICAL_ADDON_PATH . '/includes/admin/helper/activation.php';
		require_once(MAGICAL_ADDON_PATH . '/libs/lib/index.php');
		*/
	}
}

Magical_Addons_Elementor::instance();
