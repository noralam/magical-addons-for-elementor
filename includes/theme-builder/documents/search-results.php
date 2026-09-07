<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MgTB_Document_Search_Results' ) ) {

	class MgTB_Document_Search_Results extends MgTB_Document {

		public static function get_type() {
			return 'search-results';
		}

		protected static function get_location() {
			return 'search';
		}

		protected static function get_condition_type() {
			return 'archive';
		}

		public static function get_title() {
			return __( 'Search Results', 'magical-addons-for-elementor' );
		}

		public static function get_icon() {
			return 'eicon-search-results';
		}
	}
}
