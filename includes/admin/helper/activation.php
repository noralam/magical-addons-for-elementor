<?php
if (!defined('ABSPATH')) {
	exit;
}

class Magcial_Addon_Activation_Class
{

	function __construct()
	{
		add_action('elementor/tracker/send_event', [__CLASS__, 'init']);
	}

	public static function init()
	{
		if (!class_exists('\Magcial_Addon_Cloud_Library') || empty(\Magcial_Addon_Cloud_Library::$plugin_data)) {
			return;
		}

		$remote = \Magcial_Addon_Cloud_Library::$plugin_data["remote_site"];
		$endpoint = \Magcial_Addon_Cloud_Library::$plugin_data["widget"];

		// version update check
		$installed_ver = get_option('mgaddon_version');
		$current_ver   = defined('MAGICAL_ADDON_VERSION') ? MAGICAL_ADDON_VERSION : '1.5.0';

		if (!get_option('mgaddon_ready_items') || ($installed_ver !== $current_ver)) {
			$url = trailingslashit($remote) . 'wp-json/mg/v1/' . $endpoint . '/';
			$response = wp_safe_remote_get($url, ['timeout' => 5]);
			if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
				$library_data = json_decode(wp_remote_retrieve_body($response), true);
				if (!empty($library_data)) {
					update_option('mgaddon_ready_items', $library_data);
				}
			}
			update_option('mgaddon_version', $current_ver);
		}
	}
}

new Magcial_Addon_Activation_Class();
