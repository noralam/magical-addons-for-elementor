<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MgTB_Document_Error_404' ) ) {

	class MgTB_Document_Error_404 extends MgTB_Document {

		public static function get_type() {
			return 'error-404';
		}

		protected static function get_location() {
			return 'error-404';
		}

		protected static function get_condition_type() {
			return 'singular';
		}

		public static function get_title() {
			return __( '404 Page', 'magical-addons-for-elementor' );
		}

		public static function get_icon() {
			return 'eicon-error-404';
		}
	}
}
