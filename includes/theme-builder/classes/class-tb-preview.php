<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Editor preview support for the Magical Theme Builder.
 *
 * Theme templates (single post, archive, ...) are edited as library posts,
 * but the theme widgets (post title, content, meta...) need a real query.
 * While the editor preview renders such a document we switch the global
 * query to the site's first real post/page — and to generated private demo
 * content when the site has none — so widgets always render something
 * meaningful to design with.
 *
 * @package    Magical_Addons
 * @subpackage Theme_Builder
 */

if ( ! class_exists( 'MgTB_Preview' ) ) {

	class MgTB_Preview {

		const DEMO_OPTION = 'mgtb_demo_content';

		/**
		 * Whether the query is already switched for this request.
		 *
		 * @var bool
		 */
		private $switched = false;

		/**
		 * Constructor.
		 */
		public function __construct() {
			// Switch the global query around the element rendering of a theme
			// document in the editor, so widgets that read the current post
			// (title, content, meta, archive loop...) render the preview
			// content instead of the library post itself. Covers both the
			// editor's render_widget ajax (edit mode) and full renders.
			add_action( 'elementor/frontend/before_get_builder_content', [ $this, 'start_preview_query' ], 10, 1 );
			add_action( 'elementor/frontend/get_builder_content', [ $this, 'end_preview_query' ], 10, 1 );
		}

		/**
		 * Whether the current request renders elements inside the editor
		 * (preview iframe or the editor's server-side widget render ajax).
		 *
		 * @return bool
		 */
		private function is_editor_render_context() {
			$plugin = \Elementor\Plugin::instance();
			return $plugin->preview->is_preview_mode()
				|| ( $plugin->editor && $plugin->editor->is_edit_mode() );
		}

		/**
		 * Whether a document type needs a real content query while previewing.
		 *
		 * @param string $type Template type slug.
		 * @return bool
		 */
		private function type_needs_query( $type ) {
			return in_array( $type, [ 'single-post', 'single-page', 'archive', 'search-results', 'error-404' ], true );
		}

		/**
		 * Switch the query before the editor renders a theme document.
		 *
		 * @param \Elementor\Core\Base\Document $document Document being rendered.
		 */
		public function start_preview_query( $document ) {
			if ( $this->switched || ! $this->is_editor_render_context() ) {
				return;
			}

			$type = get_post_meta( $document->get_main_id(), '_elementor_template_type', true );
			if ( ! isset( MgTB::get_types_config()[ $type ] ) || ! $this->type_needs_query( $type ) ) {
				return;
			}

			$args = $this->get_preview_args( $document );
			if ( empty( $args ) ) {
				return;
			}

			\Elementor\Plugin::instance()->db->switch_to_query( $args, true );
			$this->switched = true;
		}

		/**
		 * Restore the query after the preview rendered a theme document.
		 */
		public function end_preview_query() {
			if ( ! $this->switched ) {
				return;
			}

			\ELEMENTOR\Plugin::instance()->db->restore_current_query();
			$this->switched = false;
		}

		/**
		 * Query args for previewing a document: the newest real post/page,
		 * or generated demo content when the site has none.
		 *
		 * @param \Elementor\Core\Base\Document $document Document.
		 * @return array WP_Query args.
		 */
		public function get_preview_args( $document ) {
			$type     = get_post_meta( $document->get_main_id(), '_elementor_template_type', true );
			$settings = $document->get_settings();

			switch ( $type ) {
				case 'single-post':
					$args = [ 'post_type' => 'post', 'posts_per_page' => 1, 'post_status' => 'publish' ];
					if ( ! empty( $settings['preview_id'] ) ) {
						$args['p'] = absint( $settings['preview_id'] );
						unset( $args['post_type'], $args['posts_per_page'] );
						return $args;
					}
					return $this->with_demo_fallback( $args, 'post' );

				case 'single-page':
					$args = [ 'post_type' => 'page', 'posts_per_page' => 1, 'post_status' => 'publish' ];
					if ( ! empty( $settings['preview_id'] ) ) {
						$args['page_id'] = absint( $settings['preview_id'] );
						unset( $args['post_type'], $args['posts_per_page'] );
						return $args;
					}
					return $this->with_demo_fallback( $args, 'page' );

				case 'archive':
				case 'search-results':
				case 'error-404':
				default:
					$args = [ 'post_type' => 'post', 'posts_per_page' => 6, 'post_status' => 'publish' ];
					return $this->with_demo_fallback( $args, 'post' );
			}
		}

		/**
		 * Use demo content when the real query has nothing to show.
		 *
		 * @param array  $args      Query args.
		 * @param string $post_type Post type the query targets.
		 * @return array
		 */
		private function with_demo_fallback( $args, $post_type ) {
			$has_content = get_posts( [
				'post_type'      => $post_type,
				'post_status'    => 'publish',
				'posts_per_page' => 1,
				'fields'         => 'ids',
			] );

			if ( ! empty( $has_content ) ) {
				return $args;
			}

			$demo = $this->ensure_demo_content();

			if ( 'page' === $post_type ) {
				return ! empty( $demo['page'] )
					? [ 'page_id' => $demo['page'], 'post_type' => 'page' ]
					: $args;
			}

			return ! empty( $demo['posts'] )
				? [ 'post_type' => 'post', 'post__in' => $demo['posts'], 'posts_per_page' => 6, 'post_status' => 'private' ]
				: $args;
		}

		/**
		 * Create (once) private demo posts and a demo page so previews and
		 * layout design always have realistic content, even on a fresh site.
		 *
		 * @return array { posts: int[], page: int }
		 */
		public function ensure_demo_content() {
			$demo = get_option( self::DEMO_OPTION );
			if ( is_array( $demo ) && ! empty( $demo['posts'] ) ) {
				// Skip demo posts that were deleted since the set was created.
				$valid = get_posts( [
					'post_type'      => 'post',
					'post__in'       => (array) $demo['posts'],
					'post_status'    => 'private',
					'posts_per_page' => -1,
					'fields'         => 'ids',
				] );

				if ( ! empty( $valid ) ) {
					return [ 'posts' => array_map( 'intval', $valid ), 'page' => (int) $demo['page'] ];
				}
			}

			$posts = [];

			$articles = [
				[
					'title'   => __( 'Welcome to Your New Theme', 'magical-addons-for-elementor' ),
					'excerpt' => __( 'This sample post shows how your single post design renders with real content while you build it.', 'magical-addons-for-elementor' ),
				],
				[
					'title'   => __( 'Design Beautiful Layouts Faster', 'magical-addons-for-elementor' ),
					'excerpt' => __( 'Drop in widgets, tweak the typography and watch the design come together in the live preview.', 'magical-addons-for-elementor' ),
				],
				[
					'title'   => __( 'Tips for a Better Blog', 'magical-addons-for-elementor' ),
					'excerpt' => __( 'A great layout guides the eye: a clear title, scannable meta, generous spacing and readable line lengths.', 'magical-addons-for-elementor' ),
				],
			];

			foreach ( $articles as $article ) {
				$post_id = wp_insert_post( [
					'post_title'   => $article['title'],
					'post_excerpt' => $article['excerpt'],
					'post_content' => $this->demo_post_body(),
					'post_status'  => 'private',
					'post_type'    => 'post',
				] );

				if ( $post_id && ! is_wp_error( $post_id ) ) {
					update_post_meta( $post_id, '_mgtb_demo_content', 1 );
					$posts[] = (int) $post_id;
				}
			}

			$page_id = wp_insert_post( [
				'post_title'  => __( 'Sample Page', 'magical-addons-for-elementor' ),
				'post_content' => $this->demo_page_body(),
				'post_status' => 'private',
				'post_type'   => 'page',
			] );
			if ( $page_id && ! is_wp_error( $page_id ) ) {
				update_post_meta( $page_id, '_mgtb_demo_content', 1 );
			}

			$demo = [
				'posts' => $posts,
				'page'  => $page_id && ! is_wp_error( $page_id ) ? (int) $page_id : 0,
			];
			update_option( self::DEMO_OPTION, $demo, false );

			/**
			 * Fires after demo preview content is generated.
			 *
			 * @param array $demo { posts: int[], page: int }
			 */
			do_action( 'mgtb/demo_content_created', $demo );

			return $demo;
		}

		/**
		 * Rich demo body for the demo posts.
		 *
		 * @return string
		 */
		private function demo_post_body() {
			return "<p>" . __( 'This paragraph is sample content generated by the Magical Theme Builder so your template design always has realistic text to work with. Replace or remove it once your site has real posts.', 'magical-addons-for-elementor' ) . "</p>\n"
				. "<h2>" . __( 'A section heading', 'magical-addons-for-elementor' ) . "</h2>\n"
				. "<p>" . __( 'Good design is invisible. When a layout feels effortless to read, every decision — spacing, hierarchy, measure — is doing its job quietly in the background.', 'magical-addons-for-elementor' ) . "</p>\n"
				. "<blockquote><p>" . __( 'Design is not just what it looks like and feels like. Design is how it works.', 'magical-addons-for-elementor' ) . "</p></blockquote>\n"
				. "<h2>" . __( 'What you can do next', 'magical-addons-for-elementor' ) . "</h2>\n"
				. "<ul><li>" . __( 'Style the typography of this template', 'magical-addons-for-elementor' ) . "</li><li>" . __( 'Adjust the spacing between elements', 'magical-addons-for-elementor' ) . "</li><li>" . __( 'Add more widgets from the panel on the left', 'magical-addons-for-elementor' ) . "</li></ul>\n"
				. "<p>" . __( 'Publish the template when it looks right, and it will apply everywhere its display conditions match.', 'magical-addons-for-elementor' ) . "</p>";
		}

		/**
		 * Rich demo body for the demo page.
		 *
		 * @return string
		 */
		private function demo_page_body() {
			return "<p>" . __( 'This is a sample page generated so your single page template has content to design with. It stays private and never appears on your live site.', 'magical-addons-for-elementor' ) . "</p>\n"
				. "<h2>" . __( 'About this page', 'magical-addons-for-elementor' ) . "</h2>\n"
				. "<p>" . __( 'Swap this demo for your real pages at any time — the template keeps working, only the preview content changes.', 'magical-addons-for-elementor' ) . "</p>";
		}

		/**
		 * Run a callback with the query switched to the document preview.
		 *
		 * Used by the theme documents' get_content/get_elements_raw_data/
		 * render_element overrides; the editor's render_widget ajax lands in
		 * render_element, which is where widget HTML is produced while editing.
		 *
		 * @param \Elementor\Core\Base\Document $document Document.
		 * @param callable                      $callback Callback returning content.
		 * @return mixed
		 */
		public function wrap( $document, $callback ) {
			if ( ! $this->is_editor_render_context() || $this->switched ) {
				return call_user_func( $callback );
			}

			$type = get_post_meta( $document->get_main_id(), '_elementor_template_type', true );
			if ( ! isset( MgTB::get_types_config()[ $type ] ) || ! $this->type_needs_query( $type ) ) {
				return call_user_func( $callback );
			}

			$args = $this->get_preview_args( $document );

			\Elementor\Plugin::instance()->db->switch_to_query( $args, true );
			$this->switched = true;

			try {
				$result = call_user_func( $callback );
			} finally {
				\ELEMENTOR\Plugin::instance()->db->restore_current_query();
				$this->switched = false;
			}

			return $result;
		}

		/**
		 * Frontend preview URL for the editor "Preview" button.
		 *
		 * @param \Elementor\Core\Base\Document $document Document.
		 * @return string
		 */
		public function get_preview_url( $document ) {
			$type   = get_post_meta( $document->get_main_id(), '_elementor_template_type', true );
			

			switch ( $type ) {
				case 'single-post':
					$latest = get_posts( [ 'post_type' => 'post', 'posts_per_page' => 1, 'fields' => 'ids', 'post_status' => 'publish' ] );
					$base   = $latest ? get_permalink( $latest[0] ) : home_url( '/' );
					break;

				case 'single-page':
					$latest = get_posts( [ 'post_type' => 'page', 'posts_per_page' => 1, 'fields' => 'ids', 'post_status' => 'publish' ] );
					$base   = $latest ? get_permalink( $latest[0] ) : home_url( '/' );
					break;

				case 'search-results':
					$base = home_url( '/?s=' . rawurlencode( __( 'welcome', 'magical-addons-for-elementor' ) ) );
					break;

				case 'error-404':
					$base = home_url( '/mgtb-404-preview' );
					break;

				case 'archive':
				default:
					$base = home_url( '/' );
					break;
			}

			return add_query_arg( 'mgtb_preview_id', $document->get_main_id(), $base );
		}
	}
}
