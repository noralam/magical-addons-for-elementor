<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Magical Posts Display dependency for the Magical Theme Builder.
 *
 * The single post / archive theme widgets live in the Magical Posts Display
 * plugin; the Theme Builder surfaces a one-click install/activate notice and
 * REST status for the admin UI.
 *
 * @package    Magical_Addons
 * @subpackage Theme_Builder
 */

if ( ! class_exists( 'MgTB_Dependency' ) ) {

	class MgTB_Dependency {

		const SLUG       = 'magical-posts-display';
		const PLUGIN_FILE = 'magical-posts-display/magical-posts-display.php';

		/**
		 * Magical Posts Display status: active | installed | not-installed.
		 *
		 * @return string
		 */
		public static function posts_display_status() {
			if ( ! function_exists( 'is_plugin_active' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}

			if ( class_exists( 'magicalPostDisplay' )
				|| ( function_exists( 'is_plugin_active' ) && is_plugin_active( self::PLUGIN_FILE ) ) ) {
				return 'active';
			}

			if ( file_exists( WP_PLUGIN_DIR . '/' . self::PLUGIN_FILE ) ) {
				return 'installed';
			}

			return 'not-installed';
		}

		/**
		 * Whether the post widgets are available.
		 *
		 * @return bool
		 */
		public static function posts_display_active() {
			return 'active' === self::posts_display_status();
		}
	}
}
