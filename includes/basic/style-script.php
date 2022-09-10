<?php

/**
 * Magical addons style and scripts 
 */
class mgAddonsEnqueueFile
{

	function __construct()
	{
		add_action('elementor/frontend/after_enqueue_styles', [$this, 'frontend_widget_styles']);
		add_action("elementor/frontend/after_enqueue_scripts", [$this, 'frontend_assets_scripts']);
		add_action('admin_enqueue_scripts', [$this, 'mgaddons_admin_scripts']);
		// Edit and preview enqueue
		add_action('elementor/preview/enqueue_styles', [$this, 'enqueue_preview_styles']);
	}

	/*
	plugin css
	*/
	function frontend_widget_styles()
	{
		wp_enqueue_style('bootstrap', MAGICAL_ADDON_URL . 'assets/css/bootstrap.min.css', array(), '5.1.3', 'all');
		/*		wp_enqueue_style( 'magical-default-style',  MAGICAL_ADDON_URL.'assets/css/mg-default-style.css', array(), '1.0', 'all');
*/

		//accordion style
		wp_register_style('mg-accordion',  MAGICAL_ADDON_URL . 'assets/css/accordion/mg-accordion.css', array(), MAGICAL_ADDON_VERSION, 'all');
		//image hover card
		wp_register_style('mg-hover-card',  MAGICAL_ADDON_URL . 'assets/widget-assets/img-hvr-card/imagehover.min.css', array(), '1.0', 'all');
		//Timeline style
		wp_register_style('mg-timeline',  MAGICAL_ADDON_URL . 'assets/widget-assets/timeline/timeline.min.css', array(), '1.0', 'all');
		//Timeline style
		wp_register_style('mg-tabs',  MAGICAL_ADDON_URL . 'assets/widget-assets/mg-tabs/mg-tabs.css', array(), MAGICAL_ADDON_VERSION, 'all');
		//Slider style
		//	wp_register_style('swiper',  MAGICAL_ADDON_URL . 'assets/widget-assets/slider/swiper.min.css', array(), '5.3.1', 'all');
		wp_register_style('swiper-style',  MAGICAL_ADDON_URL . 'assets/widget-assets/slider/mgs-style.css', array(), MAGICAL_ADDON_VERSION, 'all');
		//lightbox style
		wp_enqueue_style('venobox',  MAGICAL_ADDON_URL . 'assets/css/venobox.min.css', array(), '1.8.9', 'all');

		//main style
		wp_enqueue_style('mg-style',  MAGICAL_ADDON_URL . 'assets/css/mg-style.css', array(), time(), 'all');
	}

	/*
	plugin js
	*/
	function frontend_assets_scripts()
	{
		wp_enqueue_script("bootstrap", MAGICAL_ADDON_URL . 'assets/js/bootstrap.min.js', array('jquery'), '5.1.3', true);

		//accordion style
		wp_enqueue_script("jquery.beefup", MAGICAL_ADDON_URL . 'assets/widget-assets/accordion/jquery.beefup.min.js', array('jquery'), '1.0', true);

		//Timeline script 
		wp_enqueue_script("mg-timeline", MAGICAL_ADDON_URL . 'assets/widget-assets/timeline/timeline.min.js', array(), '1.0', true);
		wp_enqueue_script("mg-timeline-active", MAGICAL_ADDON_URL . 'assets/widget-assets/timeline/timeline-active.js', array(), '1.0', true);
		// Vinobox lightbox js
		wp_enqueue_script("venobox", MAGICAL_ADDON_URL . 'assets/js/venobox.min.js', array(), '1.8.9', true);
		wp_enqueue_script("venobox-active", MAGICAL_ADDON_URL . 'assets/js/venobox-active.js', array(), MAGICAL_ADDON_VERSION, true);

		//Slider script
		//	wp_enqueue_script("swiper", MAGICAL_ADDON_URL . 'assets/widget-assets/slider/swiper.min.js', array(), '5.3.1', true);
		wp_enqueue_script("swiper-active", MAGICAL_ADDON_URL . 'assets/widget-assets/slider/mgs-main.js', array(), MAGICAL_ADDON_VERSION, true);


		wp_enqueue_script("waypoints", '//cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.js', array('jquery'), time(), false);
	}

	public function mgaddons_admin_scripts()
	{
		global $pagenow;

		if (in_array($pagenow, array('admin.php'))) {

			//wp_enqueue_style('mgaddons-admin-style',  MAGICAL_ADDON_URL.'assets/css/switcher.css', array(), '1.0.5', 'all' );
			wp_enqueue_style('mgaddons-admin-style',  MAGICAL_ADDON_URL . 'assets/css/mg-admin.css', array(), MAGICAL_ADDON_VERSION, 'all');

			/*wp_enqueue_script( 'switcher',  MAGICAL_ADDON_URL.'assets/js/jquery.switcher.min.js', array( 'jquery' ), '2.5.1', false);*/
		}
	}

	/**
	 * Enqueue stylesheets only for preview window
	 * editing mode basically.
	 *
	 * @return void
	 */
	public static function enqueue_preview_styles()
	{

		if (mg_is_wpforms_activated() && defined('WPFORMS_PLUGIN_SLUG')) {
			wp_enqueue_style(
				'magical-addons-wpform',
				plugins_url('/' . WPFORMS_PLUGIN_SLUG . '/assets/css/wpforms-full.css', WPFORMS_PLUGIN_SLUG),
				null,
				MAGICAL_ADDON_VERSION
			);
		}
	}
}
