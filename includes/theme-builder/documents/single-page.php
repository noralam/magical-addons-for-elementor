<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MgTB_Document_Single_Page' ) ) {

	class MgTB_Document_Single_Page extends MgTB_Document_Single_Base {

		public static function get_type() {
			return 'single-page';
		}

		public static function get_title() {
			return __( 'Single Page', 'magical-addons-for-elementor' );
		}

		public static function get_icon() {
			return 'eicon-single-page';
		}

		public function get_preview_post_type() {
			return 'page';
		}
	}
}
