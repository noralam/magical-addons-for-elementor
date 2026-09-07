<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Base for single-type documents: offers a "Preview With" setting.
 *
 * @package    Magical_Addons
 * @subpackage Theme_Builder
 */

if ( ! class_exists( 'MgTB_Document_Single_Base' ) ) {

	abstract class MgTB_Document_Single_Base extends MgTB_Document {

		protected static function get_location() {
			return 'single';
		}

		protected static function get_condition_type() {
			return 'singular';
		}

		protected function supports_preview_settings() {
			return true;
		}
	}
}
