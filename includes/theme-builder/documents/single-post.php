<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'MgTB_Document_Single_Post' ) ) {

	class MgTB_Document_Single_Post extends MgTB_Document_Single_Base {

		public static function get_type() {
			return 'single-post';
		}

		public static function get_title() {
			return __( 'Single Post', 'magical-addons-for-elementor' );
		}

		public static function get_icon() {
			return 'eicon-single-post';
		}

		public function get_preview_post_type() {
			return 'post';
		}
	}
}
