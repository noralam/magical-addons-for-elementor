<?php

/**
 *  Magical admin notices
 */
class mgAdminNotice
{

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.6.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '5.6';

	/**
	 * User meta key for GSAP notice dismissal
	 * @var string
	 */
	const GSAP_NOTICE_META_KEY = 'mg_gsap_admin_notice_dismissed';

	/**
	 * User meta key for new dashboard notice dismissal
	 * @var string
	 */
	const NEW_DASHBOARD_NOTICE_META_KEY = 'mg_new_dashboard_notice_dismissed';

	function __construct()
	{
		// Always add the admin notice directly
		add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
		
		// Only check version requirements if Elementor is active
		if (did_action('elementor/loaded')) {
			if (defined('ELEMENTOR_VERSION') && !version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
				add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);
			}
		}
		
		// Check for required PHP version
		if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
			add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
		}

		// GSAP feature notice
		add_action('admin_notices', [$this, 'admin_notice_gsap_feature']);
		add_action('admin_enqueue_scripts', [$this, 'enqueue_gsap_notice_assets']);
		add_action('wp_ajax_mg_dismiss_gsap_notice', [$this, 'ajax_dismiss_gsap_notice']);

		// New dashboard notice
		add_action('admin_notices', [$this, 'admin_notice_new_dashboard']);
		add_action('wp_ajax_mg_dismiss_new_dashboard_notice', [$this, 'ajax_dismiss_new_dashboard_notice']);
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_main_plugin()
	{
		// Only show notice if Elementor is not loaded
		if (did_action('elementor/loaded')) {
			return;
		}
		
		// Process activate parameter with nonce verification
		if (isset($_GET['activate']) && isset($_GET['_wpnonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_GET['_wpnonce'])), 'activate-plugin')) {
			unset($_GET['activate']);
		}

		if (file_exists(WP_PLUGIN_DIR . '/elementor/elementor.php')) {
			$magial_eactive_url = wp_nonce_url('plugins.php?action=activate&plugin=elementor/elementor.php&plugin_status=all&paged=1', 'activate-plugin_elementor/elementor.php');
			$message = sprintf(
				/* translators: 1: Plugin name 2: Elementor 3: Elementor installation link */
				esc_html__('%1$s requires %2$s plugin, which is currently NOT RUNNING  %3$s', 'magical-addons-for-elementor'),
				'<strong>' . esc_html__('Magical Addons For Elementor', 'magical-addons-for-elementor') . '</strong>',
				'<strong>' . esc_html__('Elementor', 'magical-addons-for-elementor') . '</strong>',
				'<a class="button button-primary" style="margin-left:20px" href="' . esc_url($magial_eactive_url) . '">' . esc_html__('Activate Elementor', 'magical-addons-for-elementor') . '</a>'
			);
		} else {
			$magial_einstall_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=elementor'), 'install-plugin_elementor');
			$message = sprintf(
				/* translators: 1: Plugin name 2: Elementor 3: Elementor installation link */
				esc_html__('%1$s requires %2$s plugin, which is currently NOT RUNNING  %3$s', 'magical-addons-for-elementor'),
				'<strong>' . esc_html__('Magical Addons For Elementor', 'magical-addons-for-elementor') . '</strong>',
				'<strong>' . esc_html__('Elementor', 'magical-addons-for-elementor') . '</strong>',
				'<a class="button button-primary" style="margin-left:20px" href="' . esc_url($magial_einstall_url) . '">' . esc_html__('Install Elementor', 'magical-addons-for-elementor') . '</a>'
			);
		}

		printf('<div class="notice notice-warning is-dismissible"><p style="padding: 13px 0">%1$s</p></div>', wp_kses_post($message));
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version()
	{
		// Process activate parameter with nonce verification
		if (isset($_GET['activate']) && isset($_GET['_wpnonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_GET['_wpnonce'])), 'activate-plugin')) {
			unset($_GET['activate']);
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'magical-addons-for-elementor'),
			'<strong>' . esc_html__('Magical addons for elementor', 'magical-addons-for-elementor') . '</strong>',
			'<strong>' . esc_html__('Elementor', 'magical-addons-for-elementor') . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', wp_kses_post($message));
	}
	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version()
	{
		// Process activate parameter with nonce verification
		if (isset($_GET['activate']) && isset($_GET['_wpnonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_GET['_wpnonce'])), 'activate-plugin')) {
			unset($_GET['activate']);
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'magical-addons-for-elementor'),
			'<strong>' . esc_html__('Magical addons for elementor', 'magical-addons-for-elementor') . '</strong>',
			'<strong>' . esc_html__('PHP', 'magical-addons-for-elementor') . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', wp_kses_post($message));
	}

	/**
	 * Enqueue GSAP notice assets
	 *
	 * @since 1.3.15
	 * @access public
	 */
	public function enqueue_gsap_notice_assets()
	{
		$screen = get_current_screen();
		if (!$screen) {
			return;
		}

		// Only load on dashboard and Elementor pages
		if (strpos($screen->id, 'elementor') === false && $screen->id !== 'dashboard') {
			return;
		}

		// Check if already dismissed
		if (get_user_meta(get_current_user_id(), self::GSAP_NOTICE_META_KEY, true)) {
			return;
		}

		// Enqueue admin CSS for notice styling
		wp_enqueue_style(
			'mg-admin-style',
			MAGICAL_ADDON_URL . 'assets/css/mg-admin.css',
			array(),
			MAGICAL_ADDON_VERSION,
			'all'
		);

		wp_enqueue_script(
			'mg-gsap-notice',
			MAGICAL_ADDON_URL . 'assets/js/mg-gsap-notice.js',
			array('jquery'),
			MAGICAL_ADDON_VERSION,
			true
		);

		wp_localize_script('mg-gsap-notice', 'mgGsapNotice', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce'   => wp_create_nonce('mg_gsap_notice_nonce'),
		));
	}

	/**
	 * Display admin notice for GSAP feature
	 *
	 * @since 1.3.15
	 * @access public
	 */
	public function admin_notice_gsap_feature()
	{
		$screen = get_current_screen();
		if (!$screen) {
			return;
		}

		// Only show on dashboard and Elementor pages
		if (strpos($screen->id, 'elementor') === false && $screen->id !== 'dashboard') {
			return;
		}

		// Check if already dismissed
		if (get_user_meta(get_current_user_id(), self::GSAP_NOTICE_META_KEY, true)) {
			return;
		}
		?>
		<div class="notice is-dismissible mg-gsap-admin-notice">
			<p class="mg-gsap-notice-title">
				<span class="mg-gsap-badge"><?php echo esc_html__('✨ New', 'magical-addons-for-elementor'); ?></span>
				<strong><?php echo esc_html__('Magical Addons - GSAP Scroll Animations!', 'magical-addons-for-elementor'); ?></strong>
			</p>
			<p class="mg-gsap-notice-desc">
				<?php 
				printf(
					/* translators: %s: GSAP strong tag */
					esc_html__('Make your website come alive with professional scroll-triggered animations! %s (GreenSock Animation Platform) is the industry-standard animation library used by top websites like Apple, Google, and Nike.', 'magical-addons-for-elementor'),
					'<strong>GSAP</strong>'
				);
				?>
			</p>
			<div class="mg-gsap-features">
				<span class="mg-gsap-feature">
					<?php 
					printf(
						/* translators: %s: animation types in strong tag */
						esc_html__('✨ %s on scroll', 'magical-addons-for-elementor'),
						'<strong>' . esc_html__('Fade, slide, zoom, rotate', 'magical-addons-for-elementor') . '</strong>'
					);
					?>
				</span>
				<span class="mg-gsap-feature">
					<?php 
					printf(
						/* translators: %s: No coding in strong tag */
						esc_html__('🎯 %s required', 'magical-addons-for-elementor'),
						'<strong>' . esc_html__('No coding', 'magical-addons-for-elementor') . '</strong>'
					);
					?>
				</span>
				<span class="mg-gsap-feature">
					<?php 
					printf(
						/* translators: %s: 60fps in strong tag */
						esc_html__('⚡ %s smooth animations', 'magical-addons-for-elementor'),
						'<strong>' . esc_html__('60fps', 'magical-addons-for-elementor') . '</strong>'
					);
					?>
				</span>
			</div>
			<p class="mg-gsap-howto">
				<?php 
				printf(
					/* translators: 1: How to use label, 2: Advanced Tab, 3: Magical GSAP Animation section */
					esc_html__('%1$s Edit any page in Elementor %2$s Select element %2$s %3$s %2$s %4$s section', 'magical-addons-for-elementor'),
					'📍 <em>' . esc_html__('How to use:', 'magical-addons-for-elementor') . '</em>',
					'<span class="mg-gsap-arrow">→</span>',
					'<strong>' . esc_html__('Advanced Tab', 'magical-addons-for-elementor') . '</strong>',
					'<strong>"' . esc_html__('Magical GSAP Animation', 'magical-addons-for-elementor') . '"</strong>'
				);
				?>
			</p>
		</div>
		<?php
	}

	/**
	 * AJAX handler for dismissing GSAP notice
	 *
	 * @since 1.3.15
	 * @access public
	 */
	public function ajax_dismiss_gsap_notice()
	{
		// Verify nonce
		if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'mg_gsap_notice_nonce')) {
			wp_send_json_error(array('message' => esc_html__('Security check failed', 'magical-addons-for-elementor')));
		}

		// Check user capability
		if (!current_user_can('manage_options')) {
			wp_send_json_error(array('message' => esc_html__('Permission denied', 'magical-addons-for-elementor')));
		}

		// Update user meta
		update_user_meta(get_current_user_id(), self::GSAP_NOTICE_META_KEY, true);

		wp_send_json_success();
	}

	/**
	 * Display admin notice for new dashboard
	 *
	 * @since 1.4.0
	 * @access public
	 */
	public function admin_notice_new_dashboard()
	{
		// Don't show on the magical-addons page itself
		$screen = get_current_screen();
		if ($screen && $screen->id === 'toplevel_page_magical-addons') {
			return;
		}

		// Check if already dismissed
		if (get_user_meta(get_current_user_id(), self::NEW_DASHBOARD_NOTICE_META_KEY, true)) {
			return;
		}

		// Only show for users who can manage options
		if (!current_user_can('manage_options')) {
			return;
		}

		$dashboard_url = admin_url('admin.php?page=magical-addons');
		$nonce = wp_create_nonce('mg_new_dashboard_notice_nonce');
		?>
		<div class="notice notice-info mg-new-dashboard-notice is-dismissible" data-nonce="<?php echo esc_attr($nonce); ?>">
			<div style="display: flex; align-items: center; gap: 15px; padding: 10px 0;">
				<span style="font-size: 32px;">🎉</span>
				<div style="flex: 1;">
					<h3 style="margin: 0 0 5px 0; font-size: 16px;">
						<?php esc_html_e('Magical Addons: New Modern Dashboard!', 'magical-addons-for-elementor'); ?>
					</h3>
					<p style="margin: 0; color: #666;">
						<?php esc_html_e("We've completely redesigned the Magical Addons settings panel with a modern, intuitive interface. Enjoy faster navigation, better organization, and a cleaner look!", 'magical-addons-for-elementor'); ?>
					</p>
				</div>
				<a href="<?php echo esc_url($dashboard_url); ?>" class="button button-primary" style="white-space: nowrap;">
					<?php esc_html_e('View New Dashboard', 'magical-addons-for-elementor'); ?>
				</a>
			</div>
		</div>
		<script>
		jQuery(document).ready(function($) {
			$('.mg-new-dashboard-notice').on('click', '.notice-dismiss', function() {
				var nonce = $(this).closest('.mg-new-dashboard-notice').data('nonce');
				$.ajax({
					url: ajaxurl,
					type: 'POST',
					data: {
						action: 'mg_dismiss_new_dashboard_notice',
						nonce: nonce
					}
				});
			});
		});
		</script>
		<?php
	}

	/**
	 * AJAX handler for dismissing new dashboard notice
	 *
	 * @since 1.4.0
	 * @access public
	 */
	public function ajax_dismiss_new_dashboard_notice()
	{
		// Verify nonce
		if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'mg_new_dashboard_notice_nonce')) {
			wp_send_json_error(array('message' => esc_html__('Security check failed', 'magical-addons-for-elementor')));
		}

		// Check user capability
		if (!current_user_can('manage_options')) {
			wp_send_json_error(array('message' => esc_html__('Permission denied', 'magical-addons-for-elementor')));
		}

		// Update user meta
		update_user_meta(get_current_user_id(), self::NEW_DASHBOARD_NOTICE_META_KEY, true);

		wp_send_json_success();
	}
}
