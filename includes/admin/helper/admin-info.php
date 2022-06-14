<?php

/**
 * 
 *  Admin info for Magical Addons For Elementor plugin
 * 
 * 
 * 
 */

class madAdminInfo
{
    public static function init()
    {

        add_action('admin_notices', [__CLASS__, 'mp_display_admin_info']);
        add_action('init', [__CLASS__, 'mp_display_admin_info_init']);
        add_action('admin_enqueue_scripts', [__CLASS__, 'mgaddons_admin_scripts']);
    }



    public static function mp_display_admin_info()
    {
        global $pagenow;
        if (get_option('mgadinfo3')) {
            return;
        }

        $imgsrc = MAGICAL_ADDON_URL . 'assets/img/magical-logo.png';
        $class = 'eye-notice notice notice-success is-dismissible';
        $message = __('<strong>Hello! Thanks a lot For using <b>Magical Addons For Elementor.</b></strong><br>We\'ve added new 20+ Advanced Elementor widgets last few days and we will add templates and sections library soon!!! Could you please do us a <b>big favor</b> and give it a <b>5-star</b> rating on WordPress? This would boost our motivation and help other users make a comfortable decision while choosing the <b>Magical Addons</b> ', 'magical-addons-for-elementor');
        $url1 = esc_url('https://wordpress.org/support/plugin/magical-addons-for-elementor/reviews/?filter=5');

        printf('<div class="%1$s" style="padding:10px 15px 20px;"><img src="%2$s" alt="MG Icons"><div><p>%3$s </p><a target="_blank" class="button button-primary" href="%4$s" style="margin-right:10px">' . __('Yes, you deserve it', 'magical-addons-for-elementor') . '</a><button class="button button-info mgad-dismiss" style="margin-left:10px">' . __('No, Maybe later', 'magical-addons-for-elementor') . '</button><button class="button button-info mgad-dismiss" style="margin-left:10px"><i class="notice-icon dashicons-before dashicons-smiley"></i>' . __('I already did', 'magical-addons-for-elementor') . '</button></div></div>', esc_attr($class), esc_url($imgsrc), wp_kses_post($message), $url1);
    }

    public static function mp_display_admin_info_init()
    {
        if (isset($_GET['mgpdismissed']) && $_GET['mgpdismissed'] == 1) {
            //  delete_option('mgadinfo3');
            update_option('mgadinfo3', 1);
        }
    }
    public static function mgaddons_admin_scripts()
    {
        wp_enqueue_style('mgaddons-admin-info',  MAGICAL_ADDON_URL . 'assets/css/mg-admin-info.css', array(), '1.0.5', 'all');

        wp_enqueue_script('mgaddons-admin-info',  MAGICAL_ADDON_URL . 'assets/js/mg-admin-info.js', array('jquery'), MAGICAL_ADDON_VERSION, true);
    }
}
if (!get_option('mgadinfo3')) {
    madAdminInfo::init();
}
