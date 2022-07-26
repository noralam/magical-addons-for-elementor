<?php
if (!defined('ABSPATH')) {
	exit;
}

class Magcial_Addon_Activation_Class
{

	function __construct()
	{

		//	register_activation_hook(MAGICAL_ADDON_ROOT, [__CLASS__, 'init']);
		add_action('elementor/tracker/send_event', [__CLASS__, 'init']);
		add_action('init', [$this, 'init']);
	}

	public static function init()
	{

		$remote = \Magcial_Addon_Cloud_Library::$plugin_data["remote_site"];
		$endpoint = \Magcial_Addon_Cloud_Library::$plugin_data["widget"];
		$remote_page = \Magcial_Addon_Cloud_Library::$plugin_data["remote_page_site"];

		//	$library_data = json_decode(wp_remote_retrieve_body(wp_remote_get($remote . '/wp-json/mg/v1/' . $endpoint . '/')), true);

		/*	
		$page_data = json_decode(wp_remote_retrieve_body(wp_remote_get($remote_page . '/wp-json/wp/v2/mgaddon_pages')), true);
		$library_data['pages'] = $page_data;
		
		$page_data = json_decode(wp_remote_retrieve_body(wp_remote_get('https://thepack.webangon.com/readypages//wp-json/wp/v2/mgaddon_pages')), true);
		$library_data['pages'] = $page_data;
		*/
		// version update
		if (!get_option('mgaddon_ready_items') || (get_option('mgaddon_version') != MAGICAL_ADDON_VERSION)) {
			$library_data = json_decode(wp_remote_retrieve_body(wp_remote_get($remote . '/wp-json/mg/v1/' . $endpoint . '/', ['timeout' => 120])), true);
			if ($library_data) {
				update_option('mgaddon_ready_items', $library_data);
			}
			if (get_option('mgaddon_version') != MAGICAL_ADDON_VERSION) {
				update_option('mgaddon_version', MAGICAL_ADDON_VERSION);
			}
		}
	}
}

new Magcial_Addon_Activation_Class();
