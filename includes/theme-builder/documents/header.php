<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MgTB_Document_Header' ) ) {

	class MgTB_Document_Header extends MgTB_Document {

		public static function get_type() {
			return 'header';
		}

		protected static function get_location() {
			return 'header';
		}

		protected static function get_condition_type() {
			return 'general';
		}

		public static function get_title() {
			return __( 'Header', 'magical-addons-for-elementor' );
		}

		public static function get_icon() {
			return 'eicon-header';
		}
	}
}
