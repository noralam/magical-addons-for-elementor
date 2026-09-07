<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Display conditions engine for the Magical Theme Builder.
 *
 * Conditions are stored per template as Pro-compatible strings:
 *   "{include|exclude}/{name}/{sub_name?}/{sub_id?}"
 * e.g. "include/general", "include/singular/post",
 *      "include/singular/post/123" (specific post),
 *      "include/archive/category/5" (specific category term).
 *
 * Matching order is decided by specificity: the lower the score, the more
 * specific the condition, and the most specific template wins the location.
 *
 * @package    Magical_Addons
 * @subpackage Theme_Builder
 */

if ( ! class_exists( 'MgTB_Conditions' ) ) {

	class MgTB_Conditions {

		/**
		 * Condition registry tree, built lazily (post types differ per site).
		 *
		 * @var array|null
		 */
		private $tree = null;

		/**
		 * Build the condition tree.
		 *
		 * @return array name => config
		 */
		public function get_tree() {
			if ( null !== $this->tree ) {
				return $this->tree;
			}

			$tree = [
				'general' => [
					'label'    => __( 'Entire Site', 'magical-addons-for-elementor' ),
					'priority' => 100,
					'check'    => '__return_true',
					'subs'     => [],
				],
			];

			$subs_singular = [
				'front-page' => [
					'label'    => __( 'Front Page', 'magical-addons-for-elementor' ),
					'priority' => 30,
					'check'    => [ $this, 'check_front_page' ],
				],
				'in-category' => [
					'label'       => __( 'In Category', 'magical-addons-for-elementor' ),
					'priority'    => 45,
					'check'       => [ $this, 'check_in_category' ],
					'supports_id' => 'term',
				],
				'by-author' => [
					'label'       => __( 'By Author', 'magical-addons-for-elementor' ),
					'priority'    => 50,
					'check'       => [ $this, 'check_by_author' ],
					'supports_id' => 'author',
				],
				'not_found404' => [
					'label'    => __( '404 Page', 'magical-addons-for-elementor' ),
					'priority' => 55,
					'check'    => [ $this, 'check_404' ],
				],
			];

			// One condition per public post type, under singular.
			$post_types = get_post_types( [ 'public' => true ], 'objects' );
			foreach ( $post_types as $post_type ) {
				$subs_singular[ $post_type->name ] = [
					'label'       => $post_type->labels->singular_name,
					'priority'    => 40,
					'check'       => function ( $args ) use ( $post_type ) {
						return is_singular( $post_type->name ) && $this->check_queried_id( $args );
					},
					'supports_id' => 'post',
				];
			}

			$tree['singular'] = [
				'label'    => __( 'Singular', 'magical-addons-for-elementor' ),
				'priority' => 60,
				'check'    => [ $this, 'check_singular' ],
				'subs'     => $subs_singular,
			];

			$subs_archive = [
				'category' => [
					'label'       => __( 'Category Archive', 'magical-addons-for-elementor' ),
					'priority'    => 60,
					'check'       => [ $this, 'check_category_archive' ],
					'supports_id' => 'term',
				],
				'post_tag' => [
					'label'       => __( 'Tag Archive', 'magical-addons-for-elementor' ),
					'priority'    => 60,
					'check'       => [ $this, 'check_tag_archive' ],
					'supports_id' => 'term',
				],
				'author' => [
					'label'       => __( 'Author Archive', 'magical-addons-for-elementor' ),
					'priority'    => 70,
					'check'       => [ $this, 'check_author_archive' ],
					'supports_id' => 'author',
				],
				'date' => [
					'label'    => __( 'Date Archive', 'magical-addons-for-elementor' ),
					'priority' => 70,
					'check'    => [ $this, 'check_date_archive' ],
				],
				'search' => [
					'label'    => __( 'Search Results', 'magical-addons-for-elementor' ),
					'priority' => 70,
					'check'    => [ $this, 'check_search' ],
				],
			];

			// Post type archives (e.g. is_post_type_archive('product'); the blog
			// page is is_home() for the 'post' type).
			foreach ( $post_types as $post_type ) {
				if ( 'attachment' === $post_type->name ) {
					continue;
				}
				$is_post = ( 'post' === $post_type->name );
				if ( ! $post_type->has_archive && ! $is_post ) {
					continue;
				}
				$subs_archive[ 'pta-' . $post_type->name ] = [
					'label'    => sprintf( /* translators: %s: post type name */ __( '%s Archive', 'magical-addons-for-elementor' ), $post_type->labels->singular_name ),
					'priority' => 65,
					'check'    => function () use ( $post_type, $is_post ) {
						return $is_post ? is_home() : is_post_type_archive( $post_type->name );
					},
				];
			}

			// Custom public taxonomies.
			$taxonomies = get_taxonomies( [ 'public' => true, '_builtin' => false ], 'objects' );
			foreach ( $taxonomies as $taxonomy ) {
				$subs_archive[ 'tax-' . $taxonomy->name ] = [
					'label'       => sprintf( /* translators: %s: taxonomy name */ __( '%s Archive', 'magical-addons-for-elementor' ), $taxonomy->labels->singular_name ),
					'priority'    => 60,
					'check'       => function ( $args ) use ( $taxonomy ) {
						return is_tax( $taxonomy->name, empty( $args['sub_id'] ) ? '' : (int) $args['sub_id'] );
					},
					'supports_id' => 'term',
				];
			}

			$tree['archive'] = [
				'label'    => __( 'Archives', 'magical-addons-for-elementor' ),
				'priority' => 80,
				'check'    => [ $this, 'check_archive' ],
				'subs'     => $subs_archive,
			];

			/**
			 * Filters the conditions tree.
			 *
			 * @param array           $tree      Condition tree.
			 * @param MgTB_Conditions $conditions Conditions manager.
			 */
			$this->tree = apply_filters( 'mgtb/conditions_tree', $tree, $this );

			return $this->tree;
		}

		/**
		 * Singular checks.
		 */
		public function check_singular() {
			return is_singular() && ! is_embed();
		}

		public function check_front_page() {
			return is_front_page();
		}

		public function check_404() {
			return is_404();
		}

		public function check_in_category( $args ) {
			if ( ! is_singular() ) {
				return false;
			}
			$post_id = get_queried_object_id();
			if ( ! $post_id ) {
				return false;
			}
			if ( empty( $args['sub_id'] ) ) {
				return has_category( '', $post_id );
			}
			return has_category( (int) $args['sub_id'], $post_id );
		}

		public function check_by_author( $args ) {
			if ( ! is_singular() ) {
				return false;
			}
			$post = get_post( get_queried_object_id() );
			if ( ! $post ) {
				return false;
			}
			if ( empty( $args['sub_id'] ) ) {
				return true;
			}
			return (int) $post->post_author === (int) $args['sub_id'];
		}

		/**
		 * Specific post check helper.
		 */
		public function check_queried_id( $args ) {
			if ( empty( $args['sub_id'] ) ) {
				return true;
			}
			return (int) get_queried_object_id() === (int) $args['sub_id'];
		}

		/**
		 * Archive checks.
		 */
		public function check_archive() {
			return is_archive() || is_home() || is_search();
		}

		public function check_category_archive( $args ) {
			return is_category( empty( $args['sub_id'] ) ? '' : (int) $args['sub_id'] );
		}

		public function check_tag_archive( $args ) {
			return is_tag( empty( $args['sub_id'] ) ? '' : (int) $args['sub_id'] );
		}

		public function check_author_archive( $args ) {
			if ( ! is_author() ) {
				return false;
			}
			if ( empty( $args['sub_id'] ) ) {
				return true;
			}
			return (int) get_queried_object_id() === (int) $args['sub_id'];
		}

		public function check_date_archive() {
			return is_date();
		}

		public function check_search() {
			return is_search();
		}

		/**
		 * Parse a condition string into its parts.
		 *
		 * @param string $condition Condition string.
		 * @return array [type, name, sub_name, sub_id]
		 */
		public function parse_condition( $condition ) {
			$parts = array_pad( explode( '/', (string) $condition ), 4, '' );

			return [
				'type'     => ( 'exclude' === $parts[0] ) ? 'exclude' : 'include',
				'name'     => sanitize_key( $parts[1] ),
				'sub_name' => sanitize_key( $parts[2] ),
				'sub_id'   => trim( $parts[3] ),
			];
		}

		/**
		 * Evaluate one parsed condition against the current query.
		 *
		 * @param array $parsed Parsed condition.
		 * @return bool
		 */
		public function check_condition( $parsed ) {
			$tree = $this->get_tree();

			if ( empty( $parsed['name'] ) || ! isset( $tree[ $parsed['name'] ] ) ) {
				return false;
			}

			$node = $tree[ $parsed['name'] ];

			// Plain condition (e.g. include/general, include/singular).
			if ( empty( $parsed['sub_name'] ) ) {
				return is_callable( $node['check'] ) ? (bool) call_user_func( $node['check'], [] ) : false;
			}

			// Sub condition (e.g. include/singular/post, include/archive/category/5).
			if ( ! isset( $node['subs'][ $parsed['sub_name'] ] ) ) {
				return false;
			}

			$sub  = $node['subs'][ $parsed['sub_name'] ];
			$args = [
				'sub_name' => $parsed['sub_name'],
				'sub_id'   => $parsed['sub_id'],
			];

			return is_callable( $sub['check'] ) ? (bool) call_user_func( $sub['check'], $args ) : false;
		}

		/**
		 * Specificity score of one matched condition (lower = wins).
		 *
		 * @param array $parsed Parsed condition.
		 * @return int
		 */
		public function get_condition_priority( $parsed ) {
			$tree = $this->get_tree();

			if ( ! isset( $tree[ $parsed['name'] ] ) ) {
				return 1000;
			}

			$node     = $tree[ $parsed['name'] ];
			$priority = $node['priority'];

			if ( ! empty( $parsed['sub_name'] ) ) {
				if ( isset( $node['subs'][ $parsed['sub_name'] ] ) ) {
					$priority = min( $priority, $node['subs'][ $parsed['sub_name'] ]['priority'] ) - 10;
				} else {
					$priority -= 10;
				}

				if ( '' !== $parsed['sub_id'] ) {
					$priority -= 10;
				}
			}

			return $priority;
		}

		/**
		 * Evaluate a template's full condition list against the current query.
		 *
		 * Returns the match score, or null when the template does not apply.
		 *
		 * @param array $conditions List of condition strings.
		 * @return int|null
		 */
		public function evaluate( $conditions ) {
			$includes = [];
			$excludes = [];

			foreach ( (array) $conditions as $condition ) {
				$parsed = $this->parse_condition( $condition );
				if ( 'exclude' === $parsed['type'] ) {
					$excludes[] = $parsed;
				} else {
					$includes[] = $parsed;
				}
			}

			foreach ( $excludes as $exclude ) {
				if ( $this->check_condition( $exclude ) ) {
					return null;
				}
			}

			if ( empty( $includes ) ) {
				return 100; // Only excludes: applies everywhere except excluded.
			}

			$scores = [];
			$matched = false;
			foreach ( $includes as $include ) {
				if ( $this->check_condition( $include ) ) {
					$matched  = true;
					$scores[] = $this->get_condition_priority( $include );
				}
			}

			if ( ! $matched ) {
				return null;
			}

			return min( $scores );
		}

		/**
		 * Matching template IDs for a location, best (most specific) first.
		 *
		 * @param string $location Location name.
		 * @return int[] Template IDs.
		 */
		public function get_template_ids_for_location( $location ) {
			// Forced preview from the admin "Preview" action.
			if ( isset( $_GET['mgtb_preview_id'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				$preview_id = absint( wp_unslash( $_GET['mgtb_preview_id'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				if ( $preview_id ) {
					$type = get_post_meta( $preview_id, '_elementor_template_type', true );
					if ( MgTB::get_type_location( $type ) === $location && 'publish' === get_post_status( $preview_id ) ) {
						return [ $preview_id ];
					}
				}
			}

			$by_location = mg_tb()->cache->get( $location );

			$scores = [];
			foreach ( $by_location as $template_id => $conditions ) {
				if ( ! MgTB::is_template_enabled( (int) $template_id ) ) {
					continue;
				}

				$score = $this->evaluate( $conditions );
				if ( null !== $score ) {
					$scores[ (int) $template_id ] = $score;
				}
			}

			// Most specific condition wins; equal specificity favors the
			// newest template so a freshly created one beats older leftovers.
			uasort(
				$scores,
				function ( $a, $b ) {
					return $a <=> $b;
				}
			);
			$sorted = [];
			foreach ( $scores as $template_id => $score ) {
				$sorted[] = [ 'id' => (int) $template_id, 'score' => $score ];
			}
			usort(
				$sorted,
				function ( $a, $b ) {
					if ( $a['score'] === $b['score'] ) {
						return $b['id'] <=> $a['id'];
					}
					return $a['score'] <=> $b['score'];
				}
			);
			$template_ids = wp_list_pluck( $sorted, 'id' );

			/**
			 * Filters the matching template IDs for a location.
			 *
			 * @param int[]  $template_ids Sorted template IDs.
			 * @param string $location     Location name.
			 */
			return apply_filters( 'mgtb/template_ids_for_location', $template_ids, $location );
		}

		/**
		 * The single winning template ID for a location, if any.
		 *
		 * @param string $location Location name.
		 * @return int|null
		 */
		public function get_template_id_for_location( $location ) {
			$ids = $this->get_template_ids_for_location( $location );
			return $ids ? $ids[0] : null;
		}

		/**
		 * Detect templates that share identical include conditions per location.
		 *
		 * @return array location => [ condition => [ template ids ] ]
		 */
		public function get_conflicts() {
			$conflicts = [];
			$all       = mg_tb()->cache->get_all();

			foreach ( $all as $location => $templates ) {
				foreach ( $templates as $template_id => $conditions ) {
					foreach ( (array) $conditions as $condition ) {
						$parsed = $this->parse_condition( $condition );
						if ( 'include' !== $parsed['type'] ) {
							continue;
						}
						$conflicts[ $location ][ $condition ][] = (int) $template_id;
					}
				}
			}

			foreach ( $conflicts as $location => $conditions ) {
				foreach ( $conditions as $condition => $ids ) {
					if ( count( array_unique( $ids ) ) > 1 ) {
						$conflicts[ $location ][ $condition ] = array_values( array_unique( $ids ) );
					} else {
						unset( $conflicts[ $location ][ $condition ] );
					}
				}
				if ( empty( $conflicts[ $location ] ) ) {
					unset( $conflicts[ $location ] );
				}
			}

			return $conflicts;
		}

		/**
		 * Human readable label for a condition string (admin table chips).
		 *
		 * @param string $condition Condition string.
		 * @return string
		 */
		public function get_condition_label( $condition ) {
			$parsed = $this->parse_condition( $condition );
			$tree   = $this->get_tree();

			$prefix = ( 'exclude' === $parsed['type'] )
				? __( 'Exclude:', 'magical-addons-for-elementor' ) . ' '
				: '';

			if ( empty( $parsed['name'] ) || ! isset( $tree[ $parsed['name'] ] ) ) {
				return $prefix . $condition;
			}

			$node  = $tree[ $parsed['name'] ];
			$label = $node['label'];

			if ( ! empty( $parsed['sub_name'] ) ) {
				if ( isset( $node['subs'][ $parsed['sub_name'] ] ) ) {
					$sub  = $node['subs'][ $parsed['sub_name'] ];
					$label .= ' › ' . $sub['label'];

					if ( '' !== $parsed['sub_id'] ) {
						$label .= ': ' . $this->get_sub_id_label( (int) $parsed['sub_id'], isset( $sub['supports_id'] ) ? $sub['supports_id'] : '' );
					}
				} else {
					$label .= ' › ' . str_replace( [ '-', '_' ], ' ', $parsed['sub_name'] );
					if ( '' !== $parsed['sub_id'] ) {
						$label .= ' #' . $parsed['sub_id'];
					}
				}
			}

			return $prefix . $label;
		}

		/**
		 * Label for a sub_id value by its supports_id type.
		 *
		 * @param int    $sub_id      Sub id.
		 * @param string $supports_id One of post|term|author|''.
		 * @return string
		 */
		private function get_sub_id_label( $sub_id, $supports_id ) {
			switch ( $supports_id ) {
				case 'post':
					$title = get_the_title( $sub_id );
					return $title ? $title : (string) $sub_id;

				case 'term':
					$term = get_term( $sub_id );
					return ( $term && ! is_wp_error( $term ) ) ? $term->name : (string) $sub_id;

				case 'author':
					$user = get_userdata( $sub_id );
					return $user ? $user->display_name : (string) $sub_id;
			}

			return '#' . $sub_id;
		}
	}
}
