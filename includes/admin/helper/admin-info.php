<?php

/**
 * Admin info and review notice for Magical Addons For Elementor plugin
 */

class madAdminInfo
{
    private static $review_url = 'https://wordpress.org/support/plugin/magical-addons-for-elementor/reviews/#new-post';

    public static function init()
    {
        add_action('admin_notices', [__CLASS__, 'display_review_notice']);
        add_action('admin_notices', [__CLASS__, 'display_sales_notice']);
        add_action('init', [__CLASS__, 'handle_notice_dismiss']);
        add_action('admin_enqueue_scripts', [__CLASS__, 'mgaddons_admin_scripts']);
        add_action('wp_ajax_magical_dismiss_review', [__CLASS__, 'dismiss_review_notice']);
    }

    /**
     * Display sales-focused admin notice with highlighted features
     *
     * @since 1.4.2
     */
    public static function display_sales_notice()
    {
        $hide_date = get_option('mg_sales_notice_dismissed');
        if (!empty($hide_date)) {
            $clickhide = round((time() - strtotime($hide_date)) / 24 / 60 / 60);
            if ($clickhide < 25) {
                return;
            }
        }
/* 
        $install_date = get_option('mg_install_date');
        if (!empty($install_date)) {
            $install_day = round((time() - strtotime($install_date)) / 24 / 60 / 60);
            if ($install_day < 3) {
                return;
            }
        } */

        $pro_link = 'https://wpthemespace.com/product/magical-addons-pro/?add-to-cart=7193';
        $details_link = 'https://wpthemespace.com/product/magical-addons-pro/';
        $dismiss_url = wp_nonce_url(add_query_arg('mg_sales_dismiss', '1'), 'mg_dismiss_sales_notice');
        ?>
        <div class="mg-sales-notice">
            <div class="mg-sales-inner">
                <div class="mg-sales-badge"><?php esc_html_e('NEW', 'magical-addons-for-elementor'); ?></div>
                <div class="mg-sales-content">
                    <h3 class="mg-sales-title">
                        <?php esc_html_e('Magical Addons Pro — Unlock Advanced Elementor Features!', 'magical-addons-for-elementor'); ?>
                    </h3>
                    <p class="mg-sales-desc">
                        <?php esc_html_e('Take your Elementor pages to the next level with Anything Carousel, GSAP Scroll Animations, 50+ Pro Widgets, and more — starting at just $21!', 'magical-addons-for-elementor'); ?>
                    </p>
                    <div class="mg-sales-features">
                        <span class="mg-sales-feature">
                            <span class="mg-sales-feature-icon">🎠</span>
                            <?php esc_html_e('New Anything Carousel', 'magical-addons-for-elementor'); ?>
                        </span>
                        <span class="mg-sales-feature">
                            <span class="mg-sales-feature-icon">✨</span>
                            <?php esc_html_e('GSAP Animations', 'magical-addons-for-elementor'); ?>
                        </span>
                        <span class="mg-sales-feature">
                            <span class="mg-sales-feature-icon">🧩</span>
                            <?php esc_html_e('50+ Pro Widgets', 'magical-addons-for-elementor'); ?>
                        </span>
                        <span class="mg-sales-feature">
                            <span class="mg-sales-feature-icon">🎨</span>
                            <?php esc_html_e('Custom CSS & Code', 'magical-addons-for-elementor'); ?>
                        </span>
                        <span class="mg-sales-feature">
                            <span class="mg-sales-feature-icon">⚡</span>
                            <?php esc_html_e('Priority Support', 'magical-addons-for-elementor'); ?>
                        </span>
                    </div>
                    <div class="mg-sales-actions">
                        <a href="<?php echo esc_url($pro_link); ?>" class="mg-sales-btn mg-sales-btn-primary" target="_blank">
                            <?php esc_html_e('Upgrade to Pro — $21', 'magical-addons-for-elementor'); ?>
                            <span class="mg-sales-btn-arrow">→</span>
                        </a>
                        <a href="<?php echo esc_url($details_link); ?>" class="mg-sales-btn mg-sales-btn-secondary" target="_blank">
                            <?php esc_html_e('View Details', 'magical-addons-for-elementor'); ?>
                        </a>
                        <a href="<?php echo esc_url($dismiss_url); ?>" class="mg-sales-btn mg-sales-btn-dismiss">
                            <?php esc_html_e('Dismiss', 'magical-addons-for-elementor'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Handle notice dismissal via URL param
     *
     * @since 1.4.2
     */
    public static function handle_notice_dismiss()
    {
        // Legacy dismiss
        if (isset($_GET['mgpdismissed']) && $_GET['mgpdismissed'] == 1 && isset($_GET['_wpnonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_GET['_wpnonce'])), 'mg_dismiss_notice')) {
            update_option('mg_info_text_date2', current_time('mysql'));
        }
        // Sales notice dismiss
        if (isset($_GET['mg_sales_dismiss']) && $_GET['mg_sales_dismiss'] == 1 && isset($_GET['_wpnonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_GET['_wpnonce'])), 'mg_dismiss_sales_notice')) {
            update_option('mg_sales_notice_dismissed', current_time('mysql'));
        }
    }

    public static function display_review_notice()
    {
        // Check if notice is dismissed
        if (get_option('magical_review_notice_dismissed')) {
            return;
        }

        // Show notice after 7 days of installation
        $install_date = get_option('mg_install_date');
        if (!empty($install_date)) {
            $install_day = round((time() - strtotime($install_date)) / 24 / 60 / 60);
            if ($install_day < 7) {
                return;
            }
        }
    ?>
        <div class="notice notice-info magical-review-notice">
            <div class="magical-review-notice-inner">
                <div class="magical-review-notice-icon">
                    <img src="<?php echo esc_url(MAGICAL_ADDON_URL . 'assets/img/magical-logo.png'); ?>" alt="<?php esc_html_e('Magical Addons', 'magical-addons-for-elementor'); ?>">
                </div>
                <div class="magical-review-notice-content">
                    <h3><?php esc_html_e('Enjoying Magical Addons?', 'magical-addons-for-elementor'); ?></h3>
                    <p>
                        <?php esc_html_e('Thank you for choosing Magical Addons! We\'ve recently added exciting features like Free Custom CSS, Conditional Content Display, and Custom Code integration. If you\'re enjoying our plugin, would you mind taking a moment to leave a 5-star review? Your support helps us continue developing new features and improvements!', 'magical-addons-for-elementor'); ?>
                    </p>
                    <div class="magical-review-notice-actions">
                        <a href="<?php echo esc_url(self::$review_url); ?>" class="button button-primary" target="_blank">
                            <?php esc_html_e('Leave a Review', 'magical-addons-for-elementor'); ?>
                        </a>
                        <button class="button button-secondary magical-dismiss-review-notice">
                            <?php esc_html_e('Already Did', 'magical-addons-for-elementor'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }

    public static function dismiss_review_notice()
    {
        // Verify nonce for security
        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'magical_review_nonce')) {
            wp_die('Security check failed');
        }

        if (!current_user_can('manage_options')) {
            wp_die();
        }

        update_option('magical_review_notice_dismissed', true);
        wp_die();
    }

    public static function mgaddons_admin_scripts()
    {
        wp_enqueue_style('mgaddons-admin-info', MAGICAL_ADDON_URL . 'assets/css/mg-admin-info.css', array(), MAGICAL_ADDON_VERSION, 'all');
        wp_enqueue_script('mgaddons-admin-info', MAGICAL_ADDON_URL . 'assets/js/mg-admin-info.js', array('jquery'), MAGICAL_ADDON_VERSION, true);

        // Add AJAX URL for review notice
        wp_localize_script('mgaddons-admin-info', 'magicalAdminInfo', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('magical_review_nonce')
        ));
    }
}

madAdminInfo::init();
