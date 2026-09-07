<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MgTB_Document_Archive' ) ) {

	class MgTB_Document_Archive extends MgTB_Document {

		public static function get_type() {
			return 'archive';
		}

		protected static function get_location() {
			return 'archive';
		}

		protected static function get_condition_type() {
			return 'archive';
		}

		public static function get_title() {
			return __( 'Blog / Archive', 'magical-addons-for-elementor' );
		}

		public static function get_icon() {
			return 'eicon-archive';
		}
	}
}
