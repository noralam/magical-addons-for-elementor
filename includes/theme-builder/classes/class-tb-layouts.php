<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Starter layouts for the Magical Theme Builder.
 *
 * Every template type ships with ready-made Elementor structures (flexbox
 * containers + widgets) so the "Add New" wizard can pre-build a template the
 * same way the Magical Products Display wizard does. Structures live as JSON
 * files in includes/theme-builder/layouts/{type}/{layout-id}.json and contain
 * no demo data — the widgets render live site content.
 *
 * @package    Magical_Addons
 * @subpackage Theme_Builder
 */

if ( ! class_exists( 'MgTB_Layouts' ) ) {

	class MgTB_Layouts {

		/**
		 * All layout definitions, keyed by template type.
		 *
		 * READY LAYOUTS ARE CURRENTLY DISABLED — the wizard offers only the
		 * "Custom Layout" card. To ship ready-made layouts in a future
		 * release, un-comment the entries below (or add new ones with the
		 * same shape: id, name, description, category, preview) and make
		 * sure a matching Elementor structure exists in
		 * includes/theme-builder/layouts/{type}/{id}.json — the structure
		 * files for every commented layout are still in place, so nothing
		 * else needs to be rebuilt.
		 *
		 * @return array
		 */
		public static function get_all() {
			$layouts = [
				'header'         => [
					/*
					[
						'id'          => 'header-classic',
						'name'        => __( 'Classic Header', 'magical-addons-for-elementor' ),
						'description' => __( 'Logo on the left, menu in the middle, search on the right.', 'magical-addons-for-elementor' ),
						'category'    => 'basic',
						'preview'     => 'header-classic',
					],
					[
						'id'          => 'header-centered',
						'name'        => __( 'Centered Header', 'magical-addons-for-elementor' ),
						'description' => __( 'Centered logo and tagline with the menu underneath.', 'magical-addons-for-elementor' ),
						'category'    => 'modern',
						'preview'     => 'header-centered',
					],
					[
						'id'          => 'header-cta',
						'name'        => __( 'Header with Button', 'magical-addons-for-elementor' ),
						'description' => __( 'Logo, menu and a call-to-action button.', 'magical-addons-for-elementor' ),
						'category'    => 'modern',
						'preview'     => 'header-cta',
					],
					*/
				],
				'footer'         => [
					/*
					[
						'id'          => 'footer-minimal',
						'name'        => __( 'Minimal Footer', 'magical-addons-for-elementor' ),
						'description' => __( 'Centered logo, tagline and social icons.', 'magical-addons-for-elementor' ),
						'category'    => 'basic',
						'preview'     => 'footer-minimal',
					],
					[
						'id'          => 'footer-columns',
						'name'        => __( 'Three Columns', 'magical-addons-for-elementor' ),
						'description' => __( 'Brand column with social icons, quick links and a search column, plus a copyright bar.', 'magical-addons-for-elementor' ),
						'category'    => 'modern',
						'preview'     => 'footer-columns',
					],
					[
						'id'          => 'footer-bar',
						'name'        => __( 'Copyright Bar', 'magical-addons-for-elementor' ),
						'description' => __( 'Slim bar with the logo and copyright note.', 'magical-addons-for-elementor' ),
						'category'    => 'basic',
						'preview'     => 'footer-bar',
					],
					*/
				],
				'single-post'    => [
					/*
					[
						'id'          => 'single-post-classic',
						'name'        => __( 'Classic Layout', 'magical-addons-for-elementor' ),
						'description' => __( 'Title, meta, featured image, content and post navigation.', 'magical-addons-for-elementor' ),
						'category'    => 'basic',
						'preview'     => 'single-classic',
					],
					[
						'id'          => 'single-post-full',
						'name'        => __( 'Full Featured', 'magical-addons-for-elementor' ),
						'description' => __( 'Everything: hero image, title, meta, content, author box and comments.', 'magical-addons-for-elementor' ),
						'category'    => 'modern',
						'preview'     => 'single-full',
					],
					[
						'id'          => 'single-post-sidebar-right',
						'name'        => __( 'Right Sidebar', 'magical-addons-for-elementor' ),
						'description' => __( 'Content column with a sidebar on the right.', 'magical-addons-for-elementor' ),
						'category'    => 'sidebar',
						'preview'     => 'sidebar-right',
					],
					[
						'id'          => 'single-post-sidebar-left',
						'name'        => __( 'Left Sidebar', 'magical-addons-for-elementor' ),
						'description' => __( 'Sidebar on the left, content column on the right.', 'magical-addons-for-elementor' ),
						'category'    => 'sidebar',
						'preview'     => 'sidebar-left',
					],
					*/
				],
				'single-page'    => [
					/*
					[
						'id'          => 'single-page-classic',
						'name'        => __( 'Classic Layout', 'magical-addons-for-elementor' ),
						'description' => __( 'Page title above the page content.', 'magical-addons-for-elementor' ),
						'category'    => 'basic',
						'preview'     => 'single-classic',
					],
					[
						'id'          => 'single-page-full',
						'name'        => __( 'Full Width Content', 'magical-addons-for-elementor' ),
						'description' => __( 'Just the page content, edge to edge.', 'magical-addons-for-elementor' ),
						'category'    => 'modern',
						'preview'     => 'single-full',
					],
					*/
				],
				'archive'        => [
					/*
					[
						'id'          => 'archive-grid',
						'name'        => __( 'Grid Layout', 'magical-addons-for-elementor' ),
						'description' => __( 'Archive title above a three-column posts grid.', 'magical-addons-for-elementor' ),
						'category'    => 'basic',
						'preview'     => 'archive-grid',
					],
					[
						'id'          => 'archive-list',
						'name'        => __( 'List Layout', 'magical-addons-for-elementor' ),
						'description' => __( 'Archive title above a single-column post list.', 'magical-addons-for-elementor' ),
						'category'    => 'basic',
						'preview'     => 'archive-list',
					],
					[
						'id'          => 'archive-sidebar-right',
						'name'        => __( 'With Right Sidebar', 'magical-addons-for-elementor' ),
						'description' => __( 'Posts grid with a sidebar on the right.', 'magical-addons-for-elementor' ),
						'category'    => 'sidebar',
						'preview'     => 'sidebar-right',
					],
					[
						'id'          => 'archive-sidebar-left',
						'name'        => __( 'With Left Sidebar', 'magical-addons-for-elementor' ),
						'description' => __( 'Sidebar on the left, posts grid on the right.', 'magical-addons-for-elementor' ),
						'category'    => 'sidebar',
						'preview'     => 'sidebar-left',
					],
					*/
				],
				'search-results' => [
					/*
					[
						'id'          => 'search-list',
						'name'        => __( 'Classic List', 'magical-addons-for-elementor' ),
						'description' => __( 'Search title above a single-column results list.', 'magical-addons-for-elementor' ),
						'category'    => 'basic',
						'preview'     => 'archive-list',
					],
					[
						'id'          => 'search-grid',
						'name'        => __( 'Grid Layout', 'magical-addons-for-elementor' ),
						'description' => __( 'Search title above a two-column results grid.', 'magical-addons-for-elementor' ),
						'category'    => 'modern',
						'preview'     => 'archive-grid',
					],
					*/
				],
				'error-404'      => [
					/*
					[
						'id'          => '404-classic',
						'name'        => __( 'Classic 404', 'magical-addons-for-elementor' ),
						'description' => __( 'Big 404 heading, message and a home button.', 'magical-addons-for-elementor' ),
						'category'    => 'basic',
						'preview'     => '404-classic',
					],
					[
						'id'          => '404-search',
						'name'        => __( '404 with Search', 'magical-addons-for-elementor' ),
						'description' => __( 'Centered message with a search box to help visitors.', 'magical-addons-for-elementor' ),
						'category'    => 'modern',
						'preview'     => '404-search',
					],
					*/
				],
			];

			/**
			 * Filters the Theme Builder starter layouts.
			 *
			 * @param array $layouts Layout definitions by template type.
			 */
			return apply_filters( 'mgtb/layouts', $layouts );
		}

		/**
		 * Layout definitions for one template type, "Custom Layout" first.
		 *
		 * @param string $type Template type slug.
		 * @return array
		 */
		public static function get_by_type( $type ) {
			$all      = self::get_all();
			$defaults = [
				'id'          => 'custom',
				'name'        => __( 'Custom Layout', 'magical-addons-for-elementor' ),
				'description' => __( 'Start from a blank canvas and build it your way.', 'magical-addons-for-elementor' ),
				'category'    => 'basic',
				'preview'     => 'custom',
				'is_custom'   => true,
			];

			$layouts = isset( $all[ $type ] ) ? $all[ $type ] : [];

			return array_merge( [ $defaults ], $layouts );
		}

		/**
		 * A single layout definition.
		 *
		 * @param string $layout_id Layout ID.
		 * @return array|null
		 */
		public static function get_layout( $layout_id ) {
			foreach ( self::get_all() as $type => $layouts ) {
				foreach ( $layouts as $layout ) {
					if ( $layout['id'] === $layout_id ) {
						$layout['type'] = $type;
						return $layout;
					}
				}
			}
			return null;
		}

		/**
		 * The Elementor structure of a layout.
		 *
		 * @param string $layout_id Layout ID.
		 * @return array|null
		 */
		public static function get_structure( $layout_id ) {
			$layout = self::get_layout( $layout_id );
			if ( ! $layout ) {
				return null;
			}

			$file = __DIR__ . '/../layouts/' . $layout['type'] . '/' . $layout_id . '.json';
			if ( ! file_exists( $file ) ) {
				return null;
			}

			$structure = json_decode( (string) file_get_contents( $file ), true ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
			return is_array( $structure ) ? $structure : null;
		}

		/**
		 * Import a layout structure into a template: fresh element IDs, then
		 * save it as the template's Elementor data.
		 *
		 * @param int    $template_id Template post ID.
		 * @param string $layout_id   Layout ID.
		 * @return bool
		 */
		public static function import( $template_id, $layout_id ) {
			$structure = self::get_structure( $layout_id );
			if ( null === $structure ) {
				return false;
			}

			$structure = self::regenerate_ids( $structure );

			update_post_meta( $template_id, '_elementor_data', wp_slash( wp_json_encode( $structure ) ) );
			update_post_meta( $template_id, '_elementor_edit_mode', 'builder' );
			update_post_meta( $template_id, '_elementor_version', ELEMENTOR_VERSION );
			update_post_meta( $template_id, '_mgtb_layout', $layout_id );

			// Let Elementor regenerate the template CSS.
			if ( class_exists( '\Elementor\Plugin' ) && isset( \Elementor\Plugin::instance()->files_manager ) ) {
				\ELEMENTOR\Plugin::instance()->files_manager->clear_cache();
			}

			/**
			 * Fires after a starter layout is imported into a template.
			 *
			 * @param int    $template_id Template post ID.
			 * @param string $layout_id   Layout ID.
			 */
			do_action( 'mgtb/layout_imported', $template_id, $layout_id );

			return true;
		}

		/**
		 * Give every element of a structure a fresh unique ID.
		 *
		 * @param array $elements Elements tree.
		 * @return array
		 */
		private static function regenerate_ids( $elements ) {
			foreach ( $elements as $index => $element ) {
				if ( ! is_array( $element ) ) {
					continue;
				}

				$elements[ $index ]['id'] = substr( md5( uniqid( '', true ) ), 0, 7 );

				if ( ! empty( $element['elements'] ) && is_array( $element['elements'] ) ) {
					$elements[ $index ]['elements'] = self::regenerate_ids( $element['elements'] );
				}
			}

			return $elements;
		}
	}
}
