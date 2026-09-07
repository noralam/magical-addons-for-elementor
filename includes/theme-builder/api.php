<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Public theme builder API for themes and other plugins.
 *
 * @package Magical_Addons
 */

if ( ! function_exists( 'mg_tb_do_location' ) ) {

	/**
	 * Print the theme templates assigned to a location.
	 *
	 * Themes can call this in their templates (e.g. in header.php) to
	 * cooperate with the Magical Theme Builder.
	 *
	 * @param string $location Location: header|footer|single|archive|search|error-404.
	 * @return bool True when a template was printed.
	 */
	function mg_tb_do_location( $location ) {
		if ( ! function_exists( 'mg_tb' ) || ! class_exists( 'MgTB_Locations' ) ) {
			return false;
		}

		$locations = mg_tb()->locations;
		if ( ! $locations ) {
			return false;
		}

		return $locations->do_location( $location );
	}
}

if ( ! function_exists( 'mg_tb_location_exists' ) ) {

	/**
	 * Whether a location has a matching template.
	 *
	 * @param string $location    Location name.
	 * @param bool   $check_match Evaluate conditions against the current query.
	 * @return bool
	 */
	function mg_tb_location_exists( $location, $check_match = true ) {
		if ( ! function_exists( 'mg_tb' ) || ! class_exists( 'MgTB_Locations' ) ) {
			return false;
		}

		$locations = mg_tb()->locations;
		if ( ! $locations ) {
			return false;
		}

		return $locations->location_exists( $location, $check_match );
	}
}

if ( ! function_exists( 'mg_tb_render_template' ) ) {

	/**
	 * Render any Elementor template by ID (echo).
	 *
	 * @param int  $template_id Template post ID.
	 * @param bool $with_css    Include inline CSS.
	 */
	function mg_tb_render_template( $template_id, $with_css = true ) {
		$template_id = absint( $template_id );
		if ( ! $template_id || ! did_action( 'elementor/loaded' ) ) {
			return;
		}

		echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $template_id, $with_css ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
