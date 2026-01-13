<?php

/**
 * @link              http://wpthemespace.com
 * @since             1.1.0
 * @package           Magical Addons For Elementor
 *
 * @wordpress-plugin
 * Plugin Name:       Magical Addons For Elementor
 * Plugin URI:        https://wpthemespace.com/product/magical-addons-pro/
 * Description:       Premium addons for Elementor page builder
 * Version:           1.4.0
 * Author:            Noor alam
 * Author URI:        https://wpthemespace.com/
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
	const VERSION = '1.4.0';

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
		// Define constants first
		$this->define_main();

		// Load basic files that don't require Elementor
		$this->load_basic_files();

		// Setup WordPress hooks
		$this->setup_hooks();

		// Check if Elementor is loaded before proceeding with Elementor-dependent features
		if (!did_action('elementor/loaded')) {
			return;
		}

		// Load Elementor-dependent files and initialize
		add_action('plugins_loaded', [$this, 'init']);
	}

	/**
	 * Load plugin textdomain
	 * 
	 * @since 1.3.7
	 * @access public
	 */
	public function load_plugin_textdomain()
	{
		load_plugin_textdomain('magical-addons-for-elementor', false, dirname(plugin_basename(__FILE__)) . '/languages');
	}

	/**
	 * Setup WordPress hooks
	 * 
	 * @since 1.3.9
	 * @access private
	 */
	private function setup_hooks()
	{
		// Load text domain at init hook to prevent "too early" errors in WP 6.7+
		add_action('init', [$this, 'load_plugin_textdomain']);

		// Add admin links
		add_filter('plugin_action_links_' . plugin_basename(__FILE__), [$this, 'admin_adminpro_link']);

		// Uncomment if needed for welcome page redirect
		// add_action('activated_plugin', [$this, 'go_welcome_page']);
	}

	/**
	 * Load basic files that don't require Elementor
	 * 
	 * @since 1.3.9
	 * @access private
	 */
	private function load_basic_files()
	{
		// Admin notice - load this first and unconditionally
		require_once(MAGICAL_ADDON_PATH . '/includes/basic/mg-admin-notice.php');
		
		// Initialize admin notice
		new mgAdminNotice();
	}

	/**
	 * Constract define
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function define_main()
	{
		if (!defined('MAGICAL_ADDON_VERSION')) {
			define('MAGICAL_ADDON_VERSION', (defined('WP_DEBUG') && WP_DEBUG) ? time() : self::VERSION);
		}

		if (!defined('MAGICAL_ADDON_URL')) {
			define('MAGICAL_ADDON_URL', plugin_dir_url(__FILE__));
		}

		if (!defined('MAGICAL_ADDON_ASSETS')) {
			define('MAGICAL_ADDON_ASSETS', plugin_dir_url(__FILE__) . 'assets/'); // Removed extra slash
		}

		if (!defined('MAGICAL_ADDON_PATH')) {
			define('MAGICAL_ADDON_PATH', plugin_dir_path(__FILE__));
		}

		if (!defined('MAGICAL_ADDON_ROOT')) {
			define('MAGICAL_ADDON_ROOT', __FILE__);
		}
	}





	/**
	 * Redirect to welcome page on plugin activation
	 * 
	 * @since 1.0.0
	 * @access public
	 * 
	 * @param string $plugin Plugin basename
	 */
	public function go_welcome_page($plugin)
	{
		if (plugin_basename(__FILE__) == $plugin) {
			wp_redirect(admin_url('admin.php?page=magical-addons'));
			die();
		}
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
		// Load all Elementor-dependent files
		$this->load_elementor_files();

		// Initialize classes
		$this->initialize_classes();

		// Setup Elementor hooks
		$this->setup_elementor_hooks();

		// Set plugin activation options
		$this->set_plugin_options();
	}

	/**
	 * Initialize required classes
	 * 
	 * @since 1.3.9
	 * @access private
	 */
	private function initialize_classes()
	{
		$enque_file = new mgAddonsEnqueueFile();
		$widget_init = new magicalWidgetInit();
		
		// Initialize REST API and Settings Defaults for React admin
		new Magical_Addons_REST_API();
		new Magical_Addons_Settings_Defaults();
	}

	/**
	 * Setup Elementor-specific hooks
	 * 
	 * @since 1.3.9
	 * @access private
	 */
	private function setup_elementor_hooks()
	{
		// Add Plugin actions
		add_action('elementor/elements/categories_registered', [$this, 'register_new_category']);
		add_action('elementor/editor/after_enqueue_styles', [$this, 'editor_widget_styles']);
		add_action('elementor/preview/enqueue_styles', [$this, 'editor_preview_widget_styles']);
	}

	/**
	 * Set plugin activation and installation options
	 * 
	 * @since 1.3.9
	 * @access private
	 */
	private function set_plugin_options()
	{
		$is_plugin_activated = get_option('mg_plugin_activated');
		if ('yes' !== $is_plugin_activated) {
			update_option('mg_plugin_activated', 'yes');
		}

		$mg_install_date = get_option('mg_install_date');
		if (empty($mg_install_date)) {
			update_option('mg_install_date', current_time('mysql'));
		}
	}

	/**
	 * Register new Elementor categories
	 * 
	 * @since 1.0.0
	 * @access public
	 * 
	 * @param object $elements_manager Elementor elements manager
	 */
	public function register_new_category($elements_manager)
	{
		$elements_manager->add_category('magical', [
			'title' => esc_html__('Magical Elements', 'magical-addons-for-elementor'),
			'icon' => 'fa fa-magic',
		]);
		$elements_manager->add_category('magical-pro', [
			'title' => esc_html__('Magical Pro Addons', 'magical-addons-for-elementor'),
			'icon' => 'fa fa-magic',
		]);

		$categories = $elements_manager->get_categories();

		// Define the desired order of the first few categories
		$first_categories = ['layout', 'basic', 'magical'];

		// Reorder the categories
		$ordered_keys = array_reduce(
			array_keys($categories),
			function ($carry, $key) use ($first_categories) {
				if (in_array($key, $first_categories)) {
					// If the category is in our $first_categories array, 
					// add it to the beginning of $carry in the order it appears in $first_categories
					$index = array_search($key, $first_categories);
					array_splice($carry, $index, 0, [$key]);
				} else {
					// For all other categories, add them to the end of $carry
					$carry[] = $key;
				}
				return $carry;
			},
			[]
		);

		// Create the reordered categories array
		$reordered_categories = [];
		foreach ($ordered_keys as $key) {
			if (isset($categories[$key])) {
				$reordered_categories[$key] = $categories[$key];
			}
		}

		// Replace the original categories with the reordered ones
		$reflection = new ReflectionClass($elements_manager);
		$property = $reflection->getProperty('categories');
		$property->setAccessible(true);
		$property->setValue($elements_manager, $reordered_categories);
	}




	/**
	 * Enqueue editor widget styles
	 * 
	 * @since 1.0.0
	 * @access public
	 */
	public function editor_widget_styles()
	{
		wp_enqueue_style('mg-editor-style',  plugins_url('/assets/css/mg-editor-style.css', __FILE__), array(), MAGICAL_ADDON_VERSION, 'all');
	}

	/**
	 * Enqueue editor preview widget styles
	 * 
	 * @since 1.0.0
	 * @access public
	 */
	public function editor_preview_widget_styles()
	{
		wp_enqueue_style('mg-editor-prev-style',  plugins_url('/assets/css/mg-editor-style-preview.css', __FILE__), array(), MAGICAL_ADDON_VERSION, 'all');
	}


	/**
	 * Load Elementor-dependent files
	 *
	 * Include files that require Elementor to be loaded
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function load_elementor_files()
	{
		// Core widget initialization
		require_once(MAGICAL_ADDON_PATH . '/includes/magical-init-widgets.php');

		// Basic functionality
		require_once(MAGICAL_ADDON_PATH . '/includes/basic/assets-managment.php');
		require_once(MAGICAL_ADDON_PATH . '/includes/functions.php');

		// Libraries and settings
		require_once(MAGICAL_ADDON_PATH . '/libs/class.settings-api.php');
		require_once(MAGICAL_ADDON_PATH . '/libs/lib/index.php');

		// Admin functionality
		require_once(MAGICAL_ADDON_PATH . '/includes/admin/admin-page.php');
		require_once(MAGICAL_ADDON_PATH . '/includes/admin/class-rest-api.php');
		require_once(MAGICAL_ADDON_PATH . '/includes/admin/class-settings-defaults.php');
		include_once MAGICAL_ADDON_PATH . '/includes/admin/helper/activation.php';

		// Icons and buttons
		require_once(MAGICAL_ADDON_PATH . '/includes/btn-icons-class.php');
		require_once(MAGICAL_ADDON_PATH . '/includes/lions-icons.php');

		// Theme builder and header/footer
		require_once(MAGICAL_ADDON_PATH . '/libs/tedit/header-footer/hf-main.php');

		// Extra features
		require_once MAGICAL_ADDON_PATH . 'includes/extra/conditional-display/conditional-display.php';
		require_once MAGICAL_ADDON_PATH . 'includes/extra/custom-code/custom-code.php';
		require_once MAGICAL_ADDON_PATH . 'includes/extra/custom-attribute.php';
		require_once MAGICAL_ADDON_PATH . 'includes/extra/role-manager/role-manager.php';

		//gsap animations
		require_once MAGICAL_ADDON_PATH . 'includes/extra/gsap-animations/gsap-animations.php';
		// Pro widgets (if not already loaded)
		if (!class_exists('magicalAddonsProMain')) {
			include_once MAGICAL_ADDON_PATH . '/includes/admin/helper/admin-info.php';
			require_once(MAGICAL_ADDON_PATH . '/includes/pro-widgets.php');
		}

	

		// Commented out tools - uncomment if needed
		/* require_once(MAGICAL_ADDON_PATH . '/libs/tools/generate-icons-json.php'); */
	}
	/**
	 * Add admin pro upgrade link
	 * 
	 * @since 1.0.0
	 * @access public
	 * 
	 * @param array $links Plugin action links
	 * @return array Modified plugin action links
	 */
	public function admin_adminpro_link($links)
	{
		$newlink = sprintf("<a target='_blank' href='%s'><span style='color:red;font-weight:bold'>%s</span></a>", esc_url('https://magic.wpcolors.net/pricing-plan/#mgpricing'), __('Upgrade Now', 'magical-addons-for-elementor'));
		if (!class_exists('magicalAddonsProMain')) {
			$links[] = $newlink;
		}
		return $links;
	}
}

Magical_Addons_Elementor::instance();
