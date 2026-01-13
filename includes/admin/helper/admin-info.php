<?php

/**
 * Admin info and review notice for Magical Addons For Elementor plugin
 */

class madAdminInfo
{
    private static $review_url = 'https://wordpress.org/support/plugin/magical-addons-for-elementor/reviews/#new-post';

    public static function init()
    {
        add_action('admin_notices', [__CLASS__, 'mp_display_admin_info']);
        add_action('admin_notices', [__CLASS__, 'display_review_notice']);
        add_action('admin_notices', [__CLASS__, 'display_features_notice']); // Add this line
        add_action('init', [__CLASS__, 'mp_display_admin_info_init']);
        add_action('admin_enqueue_scripts', [__CLASS__, 'mgaddons_admin_scripts']);
        add_action('wp_ajax_magical_dismiss_review', [__CLASS__, 'dismiss_review_notice']);
    }

    static function mp_display_admin_info_output()
    {

?>
        <div class="mgadin-hero">
            <div class="mge-info-content">
                <div class="mge-info-hello">
                    <?php
                    $addons_name = esc_html__('Magical Addons, ', 'magical-addons-for-elementor');
                    $current_user = wp_get_current_user();

                    $pro_link = esc_url('https://wpthemespace.com/product/magical-addons-pro/?add-to-cart=7193');
                    $pricing_link = esc_url('https://wpthemespace.com/product/magical-addons-pro/');

                    esc_html_e('Hello, ', 'magical-addons-for-elementor');
                    echo esc_html($current_user->display_name);
                    ?>

                    <?php esc_html_e('👋🏻', 'magical-addons-for-elementor'); ?>
                </div>
                <div class="mge-info-desc">
                    <div><?php printf(esc_html__('Thank you for choosing Magical Addons! ✨ We\'re excited to share that our Pro version is now available, loaded with advanced features to take your web design to the next level. Plus, our library keeps growing, so you’ll always have the latest and best tools at your fingertips🔥', 'magical-addons-for-elementor'), esc_html($addons_name)); ?></div>
                    <div class="mge-offer"><?php printf(esc_html__('Upgrade to Magical Addons Pro today and unlock endless possibilities—all for just $21! 🚀', 'magical-addons-for-elementor'), esc_html($addons_name)); ?></div>
                </div>
                <div class="mge-info-actions">
                    <a href="<?php echo esc_url($pro_link); ?>" target="_blank" class="button button-primary upgrade-btn">
                        <?php esc_html_e('Upgrade Now', 'magical-addons-for-elementor'); ?>
                    </a>
                    <a href="<?php echo esc_url($pricing_link); ?>" target="_blank" class="button button-primary demo-btn">
                        <?php esc_html_e('View Details', 'magical-addons-for-elementor'); ?>
                    </a>
                    <a href="<?php echo esc_url(add_query_arg(array('mgpdismissed' => '1', '_wpnonce' => wp_create_nonce('mg_dismiss_notice')))); ?>" class="button button-info mgad-dismiss"><?php esc_html_e('Dismiss this notice', 'magical-addons-for-elementor') ?></a>
                </div>
            </div>

        </div>
    <?php
    }




    public static function mp_display_admin_info()
    {

        $hide_date = get_option('mg_info_text_date2');
        if (!empty($hide_date)) {
            $clickhide = round((time() - strtotime($hide_date)) / 24 / 60 / 60);
            if ($clickhide < 25) {
                return;
            }
        }

        $install_date = get_option('mg_install_date');
        if (!empty($install_date)) {
            $install_day = round((time() - strtotime($install_date)) / 24 / 60 / 60);
            if ($install_day < 5) {
                return;
            }
        }
    ?>
        <div class="mgadin-notice notice notice-success mgadin-theme-dashboard mgadin-theme-dashboard-notice mge is-dismissible meis-dismissible">
            <?php madAdminInfo::mp_display_admin_info_output(); ?>
        </div>

    <?php


    }

    public static function mp_display_admin_info_init()
    {
        // Verify nonce for security
        if (isset($_GET['mgpdismissed']) && $_GET['mgpdismissed'] == 1 && isset($_GET['_wpnonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_GET['_wpnonce'])), 'mg_dismiss_notice')) {
            update_option('mg_info_text_date2', current_time('mysql'));
        }
        if (isset($_GET['tinfohide']) && $_GET['tinfohide'] == 1 && isset($_GET['_wpnonce']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_GET['_wpnonce'])), 'mg_dismiss_notice')) {
            update_option('mg_hide_tinfo1', current_time('mysql'));
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

    // Add this new method
    public static function display_features_notice()
    {
        // Check if notice is dismissed
        if (get_option('magical_features_notice_dismissed2')) {
            return;
        }

        // Show notice after 2 days of installation
        $install_date = get_option('mg_install_date');
        if (!empty($install_date)) {
            $install_day = round((time() - strtotime($install_date)) / 24 / 60 / 60);
            if ($install_day < 2) {
                return;
            }
        }
    ?>
        <div class="notice notice-info magical-features-notice is-dismissible">
            <div class="magical-notice-inner" style="padding-bottom:20px">
                <h3><?php esc_html_e('🎉 New Features in Magical Addons!', 'magical-addons-for-elementor'); ?></h3>
                <p>
                    <?php esc_html_e('We\'ve added powerful new features to enhance your Elementor experience:', 'magical-addons-for-elementor'); ?>
                </p>
                <ul style="list-style-type: disc; margin-left: 20px;">
                    <li><?php esc_html_e('✨ Role Manager: Control user permissions for different Elementor features', 'magical-addons-for-elementor'); ?></li>
                    <li><?php esc_html_e('🎨 Custom Code Integration: Add custom CSS and JavaScript easily', 'magical-addons-for-elementor'); ?></li>
                </ul>
                <div class="magical-notice-actions" style="margin-top: 15px;">
                    <a href="<?php echo esc_url(admin_url('admin.php?page=magical-role-manager')); ?>" class="button button-primary">
                        <?php esc_html_e('View Role Manager', 'magical-addons-for-elementor'); ?>
                    </a>
                    <a href="<?php echo esc_url(admin_url('/post-new.php?post_type=magical_custom_code')); ?>" class="button button-secondary">
                        <?php esc_html_e('View Custom Code', 'magical-addons-for-elementor'); ?>
                    </a>
                    <button class="button button-link magical-dismiss-features-notice" style="margin-left: 10px;">
                        <?php esc_html_e('Dismiss', 'magical-addons-for-elementor'); ?>
                    </button>
                </div>
            </div>
        </div>
<?php
    }

    // Modify the dismiss_review_notice method to handle both notices
    public static function dismiss_review_notice()
    {
        // Verify nonce for security
        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'magical_review_nonce')) {
            wp_die('Security check failed');
        }

        if (!current_user_can('manage_options')) {
            wp_die();
        }

        $notice_type = isset($_POST['notice_type']) ? sanitize_text_field(wp_unslash($_POST['notice_type'])) : 'review';

        if ($notice_type === 'features') {
            update_option('magical_features_notice_dismissed2', true);
        } else {
            update_option('magical_review_notice_dismissed', true);
        }
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
