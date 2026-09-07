<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Frontend rendering engine for the Magical Theme Builder.
 *
 * Two mechanisms (mirroring Elementor Pro):
 *  - Header/Footer: hook get_header/get_footer, print our own HTML shell and
 *    discard the theme's header.php/footer.php output via output buffering.
 *  - Single/Archive/Search/404: take over template_include (a FILTER) and
 *    render the matched template in a full-width layout.
 *
 * @package    Magical_Addons
 * @subpackage Theme_Builder
 */

if ( ! class_exists( 'MgTB_Locations' ) ) {

	class MgTB_Locations {

		/**
		 * Matched template IDs per location for this request.
		 *
		 * @var array
		 */
		private $matched = [];

		/**
		 * Location being rendered as the page template (single/archive/...).
		 *
		 * @var string|null
		 */
		private $current_location = null;

		/**
		 * Register the frontend hooks.
		 */
		public function boot() {
			add_filter( 'template_include', [ $this, 'template_include' ], 12 );
			add_action( 'wp', [ $this, 'setup_header_footer' ], 20 );
			add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ], 5 );
			add_filter( 'body_class', [ $this, 'filter_body_class' ] );
		}

		/**
		 * Detect the location of the current request.
		 *
		 * @return string|null
		 */
		public static function detect_location() {
			if ( is_singular() && ! is_embed() ) {
				return 'single';
			}
			if ( is_search() ) {
				return 'search';
			}
			if ( is_404() ) {
				return 'error-404';
			}
			if ( is_archive() || is_home() ) {
				return 'archive';
			}

			return null;
		}

		/**
		 * Memoized winning template ID for a location in this request.
		 *
		 * @param string $location Location name.
		 * @return int|null
		 */
		public function get_matched_id( $location ) {
			if ( ! array_key_exists( $location, $this->matched ) ) {
				$this->matched[ $location ] = mg_tb()->conditions->get_template_id_for_location( $location );
			}

			return $this->matched[ $location ];
		}

		/**
		 * Whether a document is a publish theme template.
		 *
		 * @param \Elementor\Core\Base\Document $document Document.
		 * @return bool
		 */
		private function is_document_active( $document ) {
			return $document && 'publish' === get_post_status( $document->get_main_id() );
		}

		/**
		 * Print every template assigned to a location (first match only).
		 *
		 * @param string $location Location name.
		 * @return bool Whether a template was printed.
		 */
		public function do_location( $location ) {
			$template_id = $this->get_matched_id( $location );

			if ( ! $template_id ) {
				return false;
			}

			$document = \Elementor\Plugin::instance()->documents->get( $template_id );
			if ( ! $this->is_document_active( $document ) ) {
				return false;
			}

			/**
			 * Fires before a location is printed.
			 *
			 * @param string $location    Location name.
			 * @param int    $template_id Template post ID.
			 */
			do_action( 'mgtb/before_do_location', $location, $template_id );

			printf(
				'<div class="mgtb-location mgtb-location-%s">',
				esc_attr( $location )
			);

			$document->print_content();

			echo '</div>';

			/**
			 * Fires after a location is printed.
			 *
			 * @param string $location    Location name.
			 * @param int    $template_id Template post ID.
			 */
			do_action( 'mgtb/after_do_location', $location, $template_id );

			return true;
		}

		/**
		 * Whether a location has a matching template.
		 *
		 * @param string $location     Location name.
		 * @param bool   $check_match  Also evaluate conditions (vs only existence).
		 * @return bool
		 */
		public function location_exists( $location, $check_match = true ) {
			if ( ! $check_match ) {
				return (bool) mg_tb()->cache->get( $location );
			}

			return (bool) $this->get_matched_id( $location );
		}

		/**
		 * Hook get_header/get_footer when header/footer templates match.
		 */
		public function setup_header_footer() {
			if ( is_admin() || wp_doing_ajax() || wp_doing_cron() ) {
				return;
			}

			// Never replace the header/footer inside the Elementor editor preview.
			if ( \Elementor\Plugin::instance()->preview->is_preview_mode() ) {
				return;
			}

			if ( $this->get_matched_id( 'header' ) ) {
				add_action( 'get_header', [ $this, 'override_header' ], 1 );
			}

			if ( $this->get_matched_id( 'footer' ) ) {
				add_action( 'get_footer', [ $this, 'override_footer' ], 1 );
			}
		}

		/**
		 * Replace the theme header with our HTML shell + header location.
		 */
		public function override_header() {
			// Stop every other get_header callback (including later copies of ours).
			remove_all_actions( 'get_header' );

			require __DIR__ . '/../views/theme-support-header.php';

			// Run the theme's header.php only for its side effects; discard output.
			remove_all_actions( 'wp_head' );
			ob_start();
			locate_template( 'header.php', true );
			ob_end_clean();
		}

		/**
		 * Replace the theme footer with our footer location + HTML closing.
		 */
		public function override_footer() {
			remove_all_actions( 'get_footer' );

			require __DIR__ . '/../views/theme-support-footer.php';

			// Run the theme's footer.php only for its side effects; discard output.
			remove_all_actions( 'wp_footer' );
			remove_all_actions( 'wp_print_footer_scripts' );
			ob_start();
			locate_template( 'footer.php', true );
			ob_end_clean();
		}

		/**
		 * Take over the page template for single/archive/search/404 locations.
		 *
		 * @param string $template Resolved template path.
		 * @return string
		 */
		public function template_include( $template ) {
			if ( is_admin() || wp_doing_ajax() || wp_doing_cron() ) {
				return $template;
			}

			// Elementor renders its own library documents (editor preview/save).
			if ( is_singular( 'elementor_library' ) ) {
				return $template;
			}

			$location = self::detect_location();
			if ( ! $location ) {
				return $template;
			}

			$template_id = $this->get_matched_id( $location );
			if ( ! $template_id ) {
				return $template;
			}

			$document = \Elementor\Plugin::instance()->documents->get( $template_id );
			if ( ! $this->is_document_active( $document ) ) {
				return $template;
			}

			/**
			 * Filters whether to override the theme template for the location.
			 *
			 * @param bool   $override     Whether to override.
			 * @param string $location     Location name.
			 * @param int    $template_id  Template post ID.
			 */
			if ( ! apply_filters( 'mgtb/override_location', true, $location, $template_id ) ) {
				return $template;
			}

			$this->current_location = $location;

			/**
			 * Fires when a location takes over the page template.
			 *
			 * @param string $location    Location name.
			 * @param int    $template_id Template post ID.
			 */
			do_action( 'mgtb/location_template', $location, $template_id );

			return __DIR__ . '/../views/location-template.php';
		}

		/**
		 * The location being rendered as page template.
		 *
		 * @return string|null
		 */
		public function get_current_location() {
			return $this->current_location;
		}

		/**
		 * Enqueue the Elementor Post CSS of every matched template.
		 */
		public function enqueue_styles() {
			foreach ( [ 'header', 'footer', 'single', 'archive', 'search', 'error-404' ] as $location ) {
				$template_id = $this->get_matched_id( $location );
				if ( $template_id && class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
					$css_file = new \Elementor\Core\Files\CSS\Post( $template_id );
					$css_file->enqueue();
				}
			}
		}

		/**
		 * Body classes for styling hooks.
		 */
		public function filter_body_class( $classes ) {
			foreach ( [ 'header', 'footer' ] as $location ) {
				if ( $this->get_matched_id( $location ) ) {
					$classes[] = 'mgtb-has-' . $location;
				}
			}

			if ( $this->current_location ) {
				$classes[] = 'mgtb-template-' . $this->current_location;
			}

			return $classes;
		}
	}
}
