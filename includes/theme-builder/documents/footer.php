<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MgTB_Document_Footer' ) ) {

	class MgTB_Document_Footer extends MgTB_Document {

		public static function get_type() {
			return 'footer';
		}

		protected static function get_location() {
			return 'footer';
		}

		protected static function get_condition_type() {
			return 'general';
		}

		public static function get_title() {
			return __( 'Footer', 'magical-addons-for-elementor' );
		}

		public static function get_icon() {
			return 'eicon-footer';
		}
	}
}
