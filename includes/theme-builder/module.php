<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Magical Theme Builder module.
 *
 * Full site templates (header, footer, single, archive, search, 404) built on
 * Elementor library documents with a display-conditions engine inspired by
 * Elementor Pro's architecture. All template data stays in the
 * `elementor_library` CPT using Pro-compatible meta keys, so templates keep
 * working if the site later switches to Elementor Pro.
 *
 * @package    Magical_Addons
 * @subpackage Theme_Builder
 */

if ( ! class_exists( 'MgTB' ) ) {

	final class MgTB {

		const VERSION = '1.0.0';

		const CACHE_OPTION = 'mgtb_conditions_cache';

		const VERSION_OPTION = 'mgtb_version';

		const SETTINGS_OPTION = 'mgtb_settings';

		/**
		 * Singleton instance.
		 *
		 * @var MgTB|null
		 */
		private static $_instance = null;

		/**
		 * Conditions manager.
		 *
		 * @var MgTB_Conditions|null
		 */
		public $conditions = null;

		/**
		 * Conditions cache.
		 *
		 * @var MgTB_Conditions_Cache|null
		 */
		public $cache = null;

		/**
		 * Locations/frontend engine.
		 *
		 * @var MgTB_Locations|null
		 */
		public $locations = null;

		/**
		 * Editor preview manager.
		 *
		 * @var MgTB_Preview|null
		 */
		public $preview = null;

		/**
		 * Get singleton instance.
		 *
		 * @return MgTB
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		private function __construct() {
			$this->include_files();

			$this->conditions = new MgTB_Conditions();
			$this->cache      = new MgTB_Conditions_Cache();
			$this->locations  = new MgTB_Locations();
			$this->preview    = new MgTB_Preview();

			// Elementor integration.
			add_action( 'elementor/documents/register', [ $this, 'register_documents' ] );
			add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );

			// Frontend rendering (dormant when Elementor Pro Theme Builder runs).
			if ( ! self::is_elementor_pro_tb() ) {
				$this->locations->boot();
			}

			// Keep the conditions cache fresh.
			add_action( 'wp_trash_post', [ $this->cache, 'purge' ] );
			add_action( 'untrashed_post', [ $this->cache, 'purge' ] );
			add_action( 'before_delete_post', [ $this->cache, 'purge' ] );
			add_action( 'elementor/document/after_save', [ $this, 'after_document_save' ] );

			// Admin: editor assets + Magical Posts Display dependency notice.
			add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'enqueue_editor_assets' ] );
			add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'enqueue_editor_assets' ] );
			add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_assets' ] );
			add_action( 'admin_notices', [ $this, 'render_dependency_notice' ] );

			// Data migration from the legacy header/footer system.
			add_action( 'admin_init', [ $this, 'maybe_upgrade' ] );

			/**
			 * Fires after the Theme Builder module is initialized.
			 *
			 * @param MgTB $module Module instance.
			 */
			do_action( 'mgtb/init', $this );
		}

		/**
		 * Load module files.
		 */
		private function include_files() {
			$dir = __DIR__ . '/';

			require_once $dir . 'classes/class-tb-conditions-cache.php';
			require_once $dir . 'classes/class-tb-conditions.php';
			require_once $dir . 'classes/class-tb-locations.php';
			require_once $dir . 'classes/class-tb-preview.php';
			require_once $dir . 'classes/class-tb-dependency.php';
			require_once $dir . 'classes/class-tb-layouts.php';
			require_once $dir . 'documents/theme-document.php';

			require_once $dir . 'documents/header.php';
			require_once $dir . 'documents/footer.php';
			require_once $dir . 'documents/single-base.php';
			require_once $dir . 'documents/single-post.php';
			require_once $dir . 'documents/single-page.php';
			require_once $dir . 'documents/archive.php';
			require_once $dir . 'documents/search-results.php';
			require_once $dir . 'documents/error-404.php';

			// Widget class files are required inside register_widgets():
			// Elementor\Widget_Base is only loaded once Elementor boots its
			// widget manager, which happens after plugins_loaded.

			require_once $dir . 'api.php';
		}

		/**
		 * Register theme template document types with Elementor.
		 */
		public function register_documents( $documents_manager ) {
			$types = self::get_document_types();

			/**
			 * Filters the Theme Builder document types.
			 *
			 * @param array $types Document type slug => class name.
			 */
			$types = apply_filters( 'mgtb/document_types', $types );

			foreach ( $types as $type => $class_name ) {
				$documents_manager->register_document_type( $type, $class_name );
			}
		}

		/**
		 * Register the site widgets that have no duplicate in the main plugin.
		 */
		public function register_widgets( $widgets_manager ) {
			$widgets = [
				'MgTB_Widget_Site_Title'   => 'site-title.php',
				'MgTB_Widget_Site_Tagline' => 'site-tagline.php',
				'MgTB_Widget_Breadcrumbs'  => 'breadcrumbs.php',
			];

			/**
			 * Filters the Theme Builder widgets.
			 *
			 * @param array $widgets Widget class name => file name.
			 */
			$widgets = apply_filters( 'mgtb/widgets', $widgets );

			foreach ( $widgets as $class_name => $file ) {
				$path = __DIR__ . '/widgets/' . $file;
				if ( file_exists( $path ) && ! class_exists( $class_name ) ) {
					require_once $path;
				}
				if ( class_exists( $class_name ) ) {
					$widgets_manager->register( new $class_name() );
				}
			}
		}

		/**
		 * Document type slug => class map. Slugs match Elementor Pro where possible.
		 *
		 * @return array
		 */
		public static function get_document_types() {
			return [
				'header'         => 'MgTB_Document_Header',
				'footer'         => 'MgTB_Document_Footer',
				'single-post'    => 'MgTB_Document_Single_Post',
				'single-page'    => 'MgTB_Document_Single_Page',
				'archive'        => 'MgTB_Document_Archive',
				'search-results' => 'MgTB_Document_Search_Results',
				'error-404'      => 'MgTB_Document_Error_404',
			];
		}

		/**
		 * Document type config used by the admin UI and REST API.
		 *
		 * @return array slug => [label, singular, location, icon, default_condition, posts_display_required]
		 */
		public static function get_types_config() {
			return [
				'header'         => [
					'label'        => __( 'Header', 'magical-addons-for-elementor' ),
					'location'     => 'header',
					'icon'         => 'eicon-header',
					'condition'    => 'include/general',
					'pageTemplate' => 'elementor_canvas',
				],
				'footer'         => [
					'label'        => __( 'Footer', 'magical-addons-for-elementor' ),
					'location'     => 'footer',
					'icon'         => 'eicon-footer',
					'condition'    => 'include/general',
					'pageTemplate' => 'elementor_canvas',
				],
				'single-post'    => [
					'label'        => __( 'Single Post', 'magical-addons-for-elementor' ),
					'location'     => 'single',
					'icon'         => 'eicon-single-post',
					'condition'    => 'include/singular/post',
					'needs_posts'  => true,
					'pageTemplate' => 'elementor_header_footer',
				],
				'single-page'    => [
					'label'        => __( 'Single Page', 'magical-addons-for-elementor' ),
					'location'     => 'single',
					'icon'         => 'eicon-single-page',
					'condition'    => 'include/singular/page',
					'pageTemplate' => 'elementor_header_footer',
				],
				'archive'        => [
					'label'        => __( 'Blog / Archive', 'magical-addons-for-elementor' ),
					'location'     => 'archive',
					'icon'         => 'eicon-archive',
					'condition'    => 'include/archive',
					'needs_posts'  => true,
					'pageTemplate' => 'elementor_header_footer',
				],
				'search-results' => [
					'label'        => __( 'Search Results', 'magical-addons-for-elementor' ),
					'location'     => 'search',
					'icon'         => 'eicon-search-results',
					'condition'    => 'include/archive/search',
					'needs_posts'  => true,
					'pageTemplate' => 'elementor_header_footer',
				],
				'error-404'      => [
					'label'        => __( '404 Page', 'magical-addons-for-elementor' ),
					'location'     => 'error-404',
					'icon'         => 'eicon-error-404',
					'condition'    => 'include/singular/not_found404',
					'pageTemplate' => 'elementor_canvas',
				],
			];
		}

		/**
		 * Location of a template type slug.
		 *
		 * @param string $type Document type slug.
		 * @return string Empty when unknown type.
		 */
		public static function get_type_location( $type ) {
			$types = self::get_types_config();
			return isset( $types[ $type ] ) ? $types[ $type ]['location'] : '';
		}

		/**
		 * Default Elementor page template for a template type.
		 *
		 * Header/footer templates edit best on a clean canvas; content
		 * templates default to Elementor Full Width so the theme header and
		 * footer wrap them in previews.
		 *
		 * @param string $type Document type slug.
		 * @return string elementor_canvas|elementor_header_footer|elementor_theme
		 */
		public static function get_default_page_template( $type ) {
			return in_array( $type, [ 'header', 'footer', 'error-404' ], true )
				? 'elementor_canvas'
				: 'elementor_header_footer';
		}

		/**
		 * Theme Builder settings (per-type enable toggles).
		 *
		 * @return array types => slug => bool
		 */
		public static function get_settings() {
			$settings = get_option( self::SETTINGS_OPTION, [] );
			$types    = array_fill_keys( array_keys( self::get_document_types() ), true );

			if ( ! is_array( $settings ) ) {
				$settings = [];
			}

			$saved_types = isset( $settings['types'] ) && is_array( $settings['types'] ) ? $settings['types'] : [];

			return [ 'types' => array_merge( $types, array_intersect_key( $saved_types, $types ) ) ];
		}

		/**
		 * Save Theme Builder settings.
		 *
		 * @param array $settings Raw settings from the REST API.
		 * @return array Saved settings.
		 */
		public static function save_settings( $settings ) {
			$types    = array_fill_keys( array_keys( self::get_document_types() ), true );
			$saved    = self::get_settings();
			$incoming = isset( $settings['types'] ) && is_array( $settings['types'] ) ? $settings['types'] : [];

			foreach ( array_keys( $types ) as $type ) {
				if ( array_key_exists( $type, $incoming ) ) {
					$saved['types'][ $type ] = (bool) rest_sanitize_boolean( $incoming[ $type ] );
				}
			}

			update_option( self::SETTINGS_OPTION, $saved, false );

			return $saved;
		}

		/**
		 * Whether a template's type is enabled in the Theme Builder settings.
		 *
		 * @param int|string $template_id Template post ID or type slug.
		 * @return bool
		 */
		public static function is_template_enabled( $template_id ) {
			$type = is_numeric( $template_id )
				? get_post_meta( (int) $template_id, '_elementor_template_type', true )
				: (string) $template_id;

			$settings = self::get_settings();
			return ! isset( $settings['types'][ $type ] ) || $settings['types'][ $type ];
		}

		/**
		 * Whether Elementor Pro's Theme Builder is handling locations.
		 *
		 * @return bool
		 */
		public static function is_elementor_pro_tb() {
			return defined( 'ELEMENTOR_PRO_VERSION' )
				&& class_exists( 'ElementorPro\Modules\ThemeBuilder\Module' );
		}

		/**
		 * Whether Magical Addons Pro is active.
		 *
		 * @return bool
		 */
		public static function is_pro() {
			return class_exists( 'magicalAddonsProMain' ) && (bool) get_option( 'mgporv_active', false );
		}

		/**
		 * Ensure conditions meta exists after every save of a theme document.
		 *
		 * @param \Elementor\Core\Base\Document $document Saved document.
		 */
		public function after_document_save( $document ) {
			$type = get_post_meta( $document->get_main_id(), '_elementor_template_type', true );
			$config = self::get_types_config();

			if ( ! isset( $config[ $type ] ) ) {
				return;
			}

			// New template without conditions yet: apply the type default.
			$conditions = get_post_meta( $document->get_main_id(), '_elementor_conditions', true );
			if ( '' === $conditions ) {
				update_post_meta( $document->get_main_id(), '_elementor_conditions', [ $config[ $type ]['condition'] ] );
			}

			// Keep a valid page template so the editor preview never inherits
			// the theme layout unexpectedly.
			$page_template = get_post_meta( $document->get_main_id(), '_wp_page_template', true );
			if ( '' === $page_template || 'default' === $page_template ) {
				update_post_meta( $document->get_main_id(), '_wp_page_template', self::get_default_page_template( $type ) );
			}

			$this->cache->purge();
		}

		/**
		 * Editor assets: dependency bar for theme documents.
		 */
		public function enqueue_editor_assets() {
			wp_enqueue_style(
				'mgtb-editor',
				MAGICAL_ADDON_URL . 'assets/css/theme-builder.css',
				[],
				MAGICAL_ADDON_VERSION
			);

			if ( ! wp_script_is( 'mgtb-editor', 'registered' ) && ! wp_script_is( 'mgtb-editor', 'enqueued' ) ) {
				wp_enqueue_script(
					'mgtb-editor',
					MAGICAL_ADDON_URL . 'assets/js/mg-tb-editor.js',
					[ 'jquery' ],
					MAGICAL_ADDON_VERSION,
					true
				);

				wp_localize_script( 'mgtb-editor', 'mgtbEditor', [
					'restUrl'      => esc_url_raw( rest_url( 'magical-addons/v1/' ) ),
					'restNonce'    => wp_create_nonce( 'wp_rest' ),
					'adminUrl'     => admin_url( 'admin.php?page=magical-addons#/theme-builder' ),
					'postsDisplay' => MgTB_Dependency::posts_display_status(),
					'i18n'         => [
						'conditions' => __( 'Set display conditions', 'magical-addons-for-elementor' ),
						'editCond'   => __( 'Edit conditions', 'magical-addons-for-elementor' ),
						'typeLabel'  => __( 'Magical Theme Builder template', 'magical-addons-for-elementor' ),
						'installMpd' => __( 'Install Magical Posts Display for post widgets', 'magical-addons-for-elementor' ),
						'installing' => __( 'Installing…', 'magical-addons-for-elementor' ),
						'activated'  => __( 'Activated! Reloading…', 'magical-addons-for-elementor' ),
						'failed'     => __( 'Installation failed. Please install manually.', 'magical-addons-for-elementor' ),
					],
				] );
			}
		}

		/**
		 * Admin assets for the one-click install button in notices.
		 */
		public function enqueue_admin_assets( $hook ) {
			if ( false === strpos( (string) $hook, 'magical-addons' ) ) {
				return;
			}

			wp_enqueue_style(
				'mgtb-admin',
				MAGICAL_ADDON_URL . 'assets/css/theme-builder.css',
				[],
				MAGICAL_ADDON_VERSION
			);

			wp_enqueue_script(
				'mgtb-admin',
				MAGICAL_ADDON_URL . 'assets/js/mg-tb-admin.js',
				[ 'jquery' ],
				MAGICAL_ADDON_VERSION,
				true
			);

			wp_localize_script( 'mgtb-admin', 'mgtbAdmin', [
				'restUrl'   => esc_url_raw( rest_url( 'magical-addons/v1/' ) ),
				'restNonce' => wp_create_nonce( 'wp_rest' ),
				'i18n'      => [
					'installing' => __( 'Installing Magical Posts Display…', 'magical-addons-for-elementor' ),
					'activating' => __( 'Activating…', 'magical-addons-for-elementor' ),
					'done'       => __( 'Magical Posts Display is active. Reloading…', 'magical-addons-for-elementor' ),
					'failed'     => __( 'Installation failed. Please install the plugin manually.', 'magical-addons-for-elementor' ),
				],
			] );
		}

		/**
		 * Admin notice: install/activate Magical Posts Display for post widgets.
		 */
		public function render_dependency_notice() {
			$screen = get_current_screen();
			if ( ! $screen ) {
				return;
			}

			$is_our_page = false !== strpos( $screen->id, 'magical-addons' );
			if ( ! $is_our_page ) {
				return;
			}

			$status = MgTB_Dependency::posts_display_status();
			if ( 'active' === $status ) {
				return;
			}

			if ( 'installed' === $status ) {
				$message = __( 'Activate Magical Posts Display to use the single post & archive widgets inside your Theme Builder templates.', 'magical-addons-for-elementor' );
				$button  = __( 'Activate Now', 'magical-addons-for-elementor' );
			} else {
				$message = __( 'The Theme Builder needs Magical Posts Display for the single post widgets (Post Title, Content, Featured Image, Meta, Comments and more).', 'magical-addons-for-elementor' );
				$button  = __( 'Install & Activate Magical Posts Display', 'magical-addons-for-elementor' );
			}
			?>
			<div class="notice notice-info mgtb-notice">
				<p><strong><?php esc_html_e( 'Magical Theme Builder', 'magical-addons-for-elementor' ); ?></strong></p>
				<p><?php echo esc_html( $message ); ?></p>
				<p>
					<button type="button" class="button button-primary" id="mgtb-install-mpd" data-status="<?php echo esc_attr( $status ); ?>">
						<?php echo esc_html( $button ); ?>
					</button>
				</p>
			</div>
			<?php
		}

		/**
		 * One-time data migration.
		 */
		public function maybe_upgrade() {
			$version = get_option( self::VERSION_OPTION, '0' );
			if ( version_compare( $version, self::VERSION, '>=' ) ) {
				return;
			}

			// 1. Migrate legacy header/footer selections into display conditions.
			$legacy = get_option( 'magical_headerfooter' );
			if ( is_array( $legacy ) ) {
				foreach ( [ 'mg_header_template' => 'header', 'mg_footer_template' => 'footer' ] as $key => $type ) {
					$template_id = isset( $legacy[ $key ] ) ? absint( $legacy[ $key ] ) : 0;
					if ( $template_id && 'publish' === get_post_status( $template_id ) ) {
						update_post_meta( $template_id, '_elementor_template_type', $type );
						update_post_meta( $template_id, '_elementor_conditions', [ 'include/general' ] );
					}
				}
				delete_option( 'magical_headerfooter' );
				$this->cache->purge();
			}

			// 2. Rename the legacy 'search' template type to 'search-results'.
			$posts = get_posts( [
				'post_type'      => 'elementor_library',
				'post_status'    => 'any',
				'posts_per_page' => -1,
				'meta_key'       => '_elementor_template_type', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				'meta_value'     => 'search', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
				'fields'         => 'ids',
			] );
			foreach ( $posts as $post_id ) {
				update_post_meta( $post_id, '_elementor_template_type', 'search-results' );
			}

			update_option( self::VERSION_OPTION, self::VERSION );
		}
	}
}

/**
 * Theme Builder module bootstrap.
 *
 * @return MgTB
 */
function mg_tb() {
	return MgTB::instance();
}

mg_tb();
