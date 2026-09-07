<?php

/**
 * Admin info and sales notice for Magical Addons For Elementor plugin
 */

class madAdminInfo
{
    const NOTICE_DISMISSED_META_KEY = 'mg_bundle_sales_notice_dismissed';

    public static function init()
    {
        add_action('admin_notices', [__CLASS__, 'display_sales_notice']);
        add_action('init', [__CLASS__, 'handle_notice_dismiss']);
        add_action('admin_enqueue_scripts', [__CLASS__, 'mgaddons_admin_scripts']);
        add_action('wp_ajax_magical_dismiss_sales_notice', [__CLASS__, 'ajax_dismiss_sales_notice']);
    }

    /**
     * Display sales-focused admin notice with Theme Builder & 2-in-1 Bundle offer
     *
     * @since 1.4.2
     */
    public static function display_sales_notice()
    {
        // 1. Hide notice ONLY if BOTH Magical Addons Pro AND Magical Posts Display Pro are active
        $has_addons_pro = class_exists('magicalAddonsProMain');
        $has_posts_pro  = class_exists('magicalPostDisplayPro') || (function_exists('mp_display_check_main_ok') && mp_display_check_main_ok());

        // শুধুমাত্র দোনোটা অ্যাক্টিভ থাকলেই কেবল নোটিশটা হাইড হবে; ১টা অ্যাক্টিভ থাকলেও দেখাবে
        if ($has_addons_pro && $has_posts_pro) {
            return;
        }

        // 2. Check if notice was dismissed by current user within last 25 days (reappears every 25 days)
        $user_id = get_current_user_id();
        if ($user_id) {
            $hide_time = get_user_meta($user_id, self::NOTICE_DISMISSED_META_KEY, true);
            if (!empty($hide_time)) {
                $dismissed_timestamp = is_numeric($hide_time) ? (int)$hide_time : strtotime($hide_time);
                $days_passed = round((time() - $dismissed_timestamp) / (24 * 60 * 60));
                if ($days_passed < 25) {
                    return;
                }
            }
        }

        $bundle_link        = 'https://wpthemespace.com/product/magical-addons-and-posts-display-pro-bundle';
        $theme_builder_link = admin_url('admin.php?page=magical-addons#/theme-builder');
        $dismiss_url        = wp_nonce_url(add_query_arg('mg_bundle_dismiss', '1'), 'mg_dismiss_bundle_notice');
        ?>
        <div class="notice mg-sales-notice is-dismissible">
            <div class="mg-sales-inner">
                <div class="mg-sales-header">
                    <div class="mg-sales-badges">
                        <span class="mg-sales-badge mg-sales-badge-new">
                            <span class="mg-sales-badge-icon">🚀</span> <?php esc_html_e('NEW: THEME BUILDER', 'magical-addons-for-elementor'); ?>
                        </span>
                        <span class="mg-sales-badge mg-sales-badge-deal">
                            <?php esc_html_e('🔥 SPECIAL 2-IN-1 BUNDLE', 'magical-addons-for-elementor'); ?>
                        </span>
                    </div>
                    <div class="mg-sales-pricing">
                        <span class="mg-sales-original-price"><del>$58</del></span>
                        <span class="mg-sales-current-price">$29</span>
                        <span class="mg-sales-save-tag"><?php esc_html_e('50% OFF', 'magical-addons-for-elementor'); ?></span>
                    </div>
                </div>

                <div class="mg-sales-content">
                    <h3 class="mg-sales-title">
                        <?php esc_html_e('Magical Theme Builder is Live! Get Magical Addons Pro + Magical Posts Display Pro for Just $29', 'magical-addons-for-elementor'); ?>
                    </h3>
                    <p class="mg-sales-desc">
                        <?php esc_html_e('Design unlimited Headers, Footers, Single Post & Archive templates with our brand-new Theme Builder. Supercharge your Elementor workflow with 70+ Pro Widgets, Anything Carousel, GSAP Animations, Post Grids, and more — both Pro plugins bundled together for only $29!', 'magical-addons-for-elementor'); ?>
                    </p>
                    <div class="mg-sales-features">
                        <span class="mg-sales-feature">
                            <span class="mg-sales-feature-icon">🎨</span>
                            <strong><?php esc_html_e('Theme Builder', 'magical-addons-for-elementor'); ?></strong>&nbsp;<?php esc_html_e('(Header, Footer, Single Post & Archive)', 'magical-addons-for-elementor'); ?>
                        </span>
                        <span class="mg-sales-feature">
                            <span class="mg-sales-feature-icon">🧩</span>
                            <?php esc_html_e('70+ Pro Elementor Widgets', 'magical-addons-for-elementor'); ?>
                        </span>
                        <span class="mg-sales-feature">
                            <span class="mg-sales-feature-icon">📰</span>
                            <?php esc_html_e('Advanced Post Displays & Grids', 'magical-addons-for-elementor'); ?>
                        </span>
                        <span class="mg-sales-feature">
                            <span class="mg-sales-feature-icon">🎠</span>
                            <?php esc_html_e('Anything Carousel & Sliders', 'magical-addons-for-elementor'); ?>
                        </span>
                        <span class="mg-sales-feature">
                            <span class="mg-sales-feature-icon">✨</span>
                            <?php esc_html_e('GSAP Scroll Animations', 'magical-addons-for-elementor'); ?>
                        </span>
                        <span class="mg-sales-feature">
                            <span class="mg-sales-feature-icon">⚡</span>
                            <?php esc_html_e('1 Year Updates & Priority Support', 'magical-addons-for-elementor'); ?>
                        </span>
                    </div>
                    <div class="mg-sales-actions">
                        <a href="<?php echo esc_url($bundle_link); ?>" class="mg-sales-btn mg-sales-btn-primary" target="_blank">
                            <?php esc_html_e('Get Both Plugins for $29', 'magical-addons-for-elementor'); ?>
                            <span class="mg-sales-btn-arrow">→</span>
                        </a>
                        <a href="<?php echo esc_url($theme_builder_link); ?>" class="mg-sales-btn mg-sales-btn-secondary">
                            <?php esc_html_e('Explore Theme Builder', 'magical-addons-for-elementor'); ?>
                        </a>
                        <a href="<?php echo esc_url($dismiss_url); ?>" class="mg-sales-btn mg-sales-btn-dismiss mg-sales-dismiss-btn">
                            <?php esc_html_e('Dismiss Now', 'magical-addons-for-elementor'); ?>
                        </a>
                    </div>
                </div>
            </div>
            <button type="button" class="notice-dismiss mg-sales-dismiss-btn"><span class="screen-reader-text"><?php esc_html_e('Dismiss this notice.', 'magical-addons-for-elementor'); ?></span></button>
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
        if (isset($_GET['mg_bundle_dismiss']) && $_GET['mg_bundle_dismiss'] == 1 && isset($_GET['_wpnonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_GET['_wpnonce'])), 'mg_dismiss_bundle_notice')) {
            $user_id = get_current_user_id();
            if ($user_id) {
                update_user_meta($user_id, self::NOTICE_DISMISSED_META_KEY, time());
            }
        }
    }

    /**
     * AJAX handler for sales notice dismissal
     */
    public static function ajax_dismiss_sales_notice()
    {
        check_ajax_referer('mg_bundle_notice_nonce', 'nonce');

        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => esc_html__('Permission denied', 'magical-addons-for-elementor')));
        }

        $user_id = get_current_user_id();
        if ($user_id) {
            update_user_meta($user_id, self::NOTICE_DISMISSED_META_KEY, time());
        }
        wp_send_json_success();
    }

    public static function mgaddons_admin_scripts()
    {
        wp_enqueue_style('mgaddons-admin-info', MAGICAL_ADDON_URL . 'assets/css/mg-admin-info.css', array(), MAGICAL_ADDON_VERSION, 'all');
        wp_enqueue_script('mgaddons-admin-info', MAGICAL_ADDON_URL . 'assets/js/mg-admin-info.js', array('jquery'), MAGICAL_ADDON_VERSION, true);

        // Add AJAX URL & nonce for sales notice
        wp_localize_script('mgaddons-admin-info', 'magicalAdminInfo', array(
            'ajaxurl'     => admin_url('admin-ajax.php'),
            'sales_nonce' => wp_create_nonce('mg_bundle_notice_nonce'),
        ));
    }
}

madAdminInfo::init();
