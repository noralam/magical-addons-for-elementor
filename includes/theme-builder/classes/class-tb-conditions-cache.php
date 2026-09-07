<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Conditions cache for the Magical Theme Builder.
 *
 * Stores all published theme templates grouped by location in a single
 * option, so the frontend engine never needs extra queries per request.
 *
 * Shape: [ location ][ post_id ] => [ condition, condition, ... ]
 *
 * @package    Magical_Addons
 * @subpackage Theme_Builder
 */

if ( ! class_exists( 'MgTB_Conditions_Cache' ) ) {

	class MgTB_Conditions_Cache {

		/**
		 * Cached data.
		 *
		 * @var array|null
		 */
		private $cache = null;

		/**
		 * Get all cached conditions, regenerating when empty.
		 *
		 * @return array
		 */
		public function get_all() {
			if ( null === $this->cache ) {
				$this->cache = get_option( MgTB::CACHE_OPTION, null );

				if ( ! is_array( $this->cache ) ) {
					$this->cache = $this->regenerate();
				}
			}

			return $this->cache;
		}

		/**
		 * Get conditions for one location.
		 *
		 * @param string $location Location name.
		 * @return array post_id => conditions list.
		 */
		public function get( $location ) {
			$all = $this->get_all();
			return isset( $all[ $location ] ) ? $all[ $location ] : [];
		}

		/**
		 * Rebuild the cache from published templates.
		 *
		 * @return array
		 */
		public function regenerate() {
			global $wpdb;

			$types   = array_keys( MgTB::get_document_types() );
			$in      = "'" . implode( "','", array_map( 'esc_sql', $types ) ) . "'";
			$cache   = [];

			$rows = $wpdb->get_results(
				"SELECT p.ID AS id, pm_type.meta_value AS type, pm_cond.meta_value AS conditions
				FROM {$wpdb->posts} AS p
				INNER JOIN {$wpdb->postmeta} AS pm_type ON p.ID = pm_type.post_id AND pm_type.meta_key = '_elementor_template_type'
				INNER JOIN {$wpdb->postmeta} AS pm_cond ON p.ID = pm_cond.post_id AND pm_cond.meta_key = '_elementor_conditions'
				WHERE p.post_type = 'elementor_library'
				AND p.post_status = 'publish'
				AND pm_type.meta_value IN ({$in})
				AND pm_cond.meta_value != ''",
				ARRAY_A
			);

			foreach ( (array) $rows as $row ) {
				$location = MgTB::get_type_location( $row['type'] );
				if ( ! $location ) {
					continue;
				}

				$conditions = maybe_unserialize( $row['conditions'] );
				if ( ! is_array( $conditions ) || empty( $conditions ) ) {
					continue;
				}

				$cache[ $location ][ (int) $row['id'] ] = array_values( array_filter( array_map( 'strval', $conditions ) ) );
			}

			update_option( MgTB::CACHE_OPTION, $cache, false );
			$this->cache = $cache;

			return $cache;
		}

		/**
		 * Drop the cache so it regenerates on next use.
		 */
		public function purge() {
			$this->cache = null;
			delete_option( MgTB::CACHE_OPTION );
		}
	}
}
