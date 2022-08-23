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
        /*
        $hide_date = get_option('mg_hide_date');
        if (!empty($hide_date)) {
            $clickhide = round((time() - strtotime($hide_date)) / 24 / 60 / 60);
            if ($clickhide < 7) {
                return;
            }
            echo '$hide_date';
        }

        $install_date = get_option('mg_install_date');
        if (!empty($install_date)) {
            $install_day = round((time() - strtotime($install_date)) / 24 / 60 / 60);
            if ($install_day < 2) {
                return;
            }
            echo '$install_day';
        }
        */
        /*
        if (get_option('mgadinfo6')) {
            return;
        }
    */
        $imgsrc = MAGICAL_ADDON_URL . 'assets/img/magical-logo.png';
        $class = 'eye-notice notice notice-success is-dismissible';
        $message = __('<strong class="gdnews">Big News For You!!! Now Available Magical Addons Pro Version!!!</strong><strong> We are updated Magical Addons with huge premium ready pages, templates, blocks and Premium widgets. Huge features and design are now one click behind.</strong><br> <strong class="upgbtn">  Upgrade Pro, Starting Price only $21!!! limit time offer!!!</strong>', 'magical-addons-for-elementor');
        $url1 = esc_url('https://wpthemespace.com/product/magical-addons-pro/?add-to-cart=7193');
        $url2 = esc_url('https://magic.wpcolors.net/pricing-plan/#mgpricing');

        printf('<div class="%1$s" style="padding:10px 15px 20px;"><img src="%2$s" alt="MG Icons"><div><p>%3$s </p><a target="_blank" class="button button-primary quickbtn" href="%4$s" style="margin-right:10px">' . __('Quick Upgrade', 'magical-addons-for-elementor') . '</a><a target="_blank" class="button button-primary" href="%5$s" style="margin-right:10px">' . __('View All Pricing Plan', 'magical-addons-for-elementor') . '</a><button class="button button-info mgad-dismiss" style="margin-left:10px"><i class="notice-icon dashicons-before dashicons-smiley"></i>' . __('No, Maybe leater', 'magical-addons-for-elementor') . '</button></div></div>', esc_attr($class), esc_url($imgsrc), wp_kses_post($message), $url1, $url2);
    }

    public static function mp_display_admin_info_init()
    {
        if (isset($_GET['mgpdismissed']) && $_GET['mgpdismissed'] == 1) {
            update_option('mg_hide_date', current_time('mysql'));
            delete_option('mgadinfo4');
            update_option('mgadinfo9', 1);
        }
    }
    public static function mgaddons_admin_scripts()
    {
        wp_enqueue_style('mgaddons-admin-info',  MAGICAL_ADDON_URL . 'assets/css/mg-admin-info.css', array(), MAGICAL_ADDON_VERSION, 'all');

        wp_enqueue_script('mgaddons-admin-info',  MAGICAL_ADDON_URL . 'assets/js/mg-admin-info.js', array('jquery'), MAGICAL_ADDON_VERSION, true);
    }
}
madAdminInfo::init();
