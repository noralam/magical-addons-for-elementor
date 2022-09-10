<?php

/**
 *  assets management class for magical elementor 
 * 
 * 
 */


class mgAssetsManagement
{



    public static function init()
    {
        //  add_action('elementor/frontend/after_enqueue_styles', [__CLASS__, 'frontend_style_register']);

        add_action('wp_enqueue_scripts', [__CLASS__, 'frontend_style_register']);
        add_action("elementor/frontend/after_enqueue_scripts", [__CLASS__, 'frontend_scripts_register']);
    }

    public static function frontend_style_register()
    {
        // swiper style
        wp_register_style(
            'mg-swiper',
            MAGICAL_ADDON_ASSETS . 'widget-assets/swiper/swiper.min.css',
            [],
            '8.2.5',
            'all'
        );
        // Paichart JS
        wp_register_style(
            'mgpiechart-css',
            MAGICAL_ADDON_ASSETS . 'widget-assets/pie-chart/jquery.listtopie.css',
            [],
            MAGICAL_ADDON_VERSION,
            'all'
        );
        // image compear
        wp_register_style(
            'twentytwenty-style',
            MAGICAL_ADDON_ASSETS . 'widget-assets/twentytwenty/twentytwenty.css',
            [],
            MAGICAL_ADDON_VERSION,
            'all'
        );
        // image compear
        wp_register_style(
            'mg-imgaccordion',
            MAGICAL_ADDON_ASSETS . 'widget-assets/accordion/img-accordion.css',
            [],
            MAGICAL_ADDON_VERSION,
            'all'
        );
        // image scroll
        wp_register_style(
            'mg-image-scroll',
            MAGICAL_ADDON_ASSETS . 'widget-assets/image-scroll/image-scroll.css',
            [],
            MAGICAL_ADDON_VERSION,
            'all'
        );
        // image scroll
        wp_register_style(
            'mg-info-list',
            MAGICAL_ADDON_ASSETS . 'css/info-list.css',
            [],
            MAGICAL_ADDON_VERSION,
            'all'
        );
        // Scroll top
        wp_register_style(
            'mg-scrolltop',
            MAGICAL_ADDON_ASSETS . 'widget-assets/scroll-top/scroll-top.css',
            [],
            MAGICAL_ADDON_VERSION,
            'all'
        );
        // Scroll top
        wp_register_style(
            'mg-nav-menu',
            MAGICAL_ADDON_ASSETS . 'widget-assets/nav-menu/nav-menu.css',
            [],
            MAGICAL_ADDON_VERSION,
            'all'
        );
        // data table
        wp_register_style(
            'mg-data-table',
            MAGICAL_ADDON_ASSETS . 'css/data-table.css',
            [],
            MAGICAL_ADDON_VERSION,
            'all'
        );
        // 
        wp_register_style(
            'mg-mailchimp',
            MAGICAL_ADDON_ASSETS . 'widget-assets/mailchimp/mailchimp.css',
            [],
            MAGICAL_ADDON_VERSION,
            'all'
        );
        wp_register_style(
            'mg-flipclock',
            MAGICAL_ADDON_ASSETS . 'widget-assets/countdown/flipclock.css',
            [],
            MAGICAL_ADDON_VERSION,
            'all'
        );
    }
    // script register 
    public static function frontend_scripts_register()
    {
        $ajax_url = admin_url('admin-ajax.php');
        $mg_nonce = wp_create_nonce('mgchamp');
        // Count down JS
        wp_register_script(
            "mg-flipclock",
            MAGICAL_ADDON_URL . 'assets/widget-assets/countdown/flipclock.min.js',
            array('jquery'),
            '1.0',
            true
        );
        wp_register_script(
            "mg-flipclock-active",
            MAGICAL_ADDON_URL . 'assets/widget-assets/countdown/countdown-active.js',
            array('jquery'),
            '1.0',
            true
        );
        // Progressbar JS
        wp_register_script(
            'mg-progressbar',
            MAGICAL_ADDON_ASSETS . 'js/progressbar/progressbar.min.js',
            ['jquery', 'elementor-waypoints'],
            '2.0.0',
            true
        );
        // Progressbar JS
        wp_register_script(
            'mg-progressbar-active',
            MAGICAL_ADDON_ASSETS . 'js/progressbar/progressbar-active.js',
            ['jquery', 'elementor-waypoints'],
            '2.0.0',
            true
        );

        // swiper JS
        wp_register_script(
            'mg-swiper',
            MAGICAL_ADDON_ASSETS . 'widget-assets/swiper/swiper.min.js',
            ['jquery'],
            '8.2.5',
            true
        );
        // Sharer JS
        wp_register_script(
            'tooltipster',
            MAGICAL_ADDON_ASSETS . 'js/tooltipstar.min.js',
            ['jquery'],
            MAGICAL_ADDON_VERSION,
            true
        );
        // Sharer JS
        wp_register_script(
            'imagesloaded',
            MAGICAL_ADDON_ASSETS . 'js/images-loaded.js',
            ['jquery'],
            MAGICAL_ADDON_VERSION,
            true
        );
        // Sharer JS
        wp_register_script(
            'sharer-js',
            MAGICAL_ADDON_ASSETS . 'widget-assets/share/sharer.min.js',
            ['jquery'],
            MAGICAL_ADDON_VERSION,
            true
        );
        wp_register_script(
            'snap-svg',
            MAGICAL_ADDON_ASSETS . 'widget-assets/pie-chart/snap.svg-min.js',
            ['jquery'],
            MAGICAL_ADDON_VERSION,
            true
        );
        // Paichart JS
        wp_register_script(
            'mgpiechart',
            MAGICAL_ADDON_ASSETS . 'widget-assets/pie-chart/jquery.listtopie.min.js',
            ['jquery'],
            MAGICAL_ADDON_VERSION,
            false
        );
        wp_register_script(
            'listtopie-active',
            MAGICAL_ADDON_ASSETS . 'widget-assets/pie-chart/listtopie-active.js',
            ['jquery'],
            MAGICAL_ADDON_VERSION,
            false
        );

        wp_register_script(
            'event-move',
            MAGICAL_ADDON_ASSETS . 'widget-assets/twentytwenty/jquery.event.move.js',
            ['jquery'],
            MAGICAL_ADDON_VERSION,
            true
        );
        wp_register_script(
            'twentytwenty',
            MAGICAL_ADDON_ASSETS . 'widget-assets/twentytwenty/jquery.twentytwenty.js',
            ['jquery', 'event-move'],
            MAGICAL_ADDON_VERSION,
            true
        );
        wp_register_script(
            'mg-image-accordion',
            MAGICAL_ADDON_ASSETS . 'widget-assets/accordion/mg-image-accordion.js',
            ['jquery'],
            MAGICAL_ADDON_VERSION,
            true
        );
        wp_register_script(
            'mg-content-reveal',
            MAGICAL_ADDON_ASSETS . 'widget-assets/content-reveal/content-reveal.js',
            ['jquery'],
            MAGICAL_ADDON_VERSION,
            true
        );
        wp_register_script(
            'mg-img-scroll',
            MAGICAL_ADDON_ASSETS . 'widget-assets/image-scroll/image-scroll.js',
            ['jquery'],
            MAGICAL_ADDON_VERSION,
            true
        );
        wp_register_script(
            'mg-scroll-top',
            MAGICAL_ADDON_ASSETS . 'widget-assets/scroll-top/scroll-top.js',
            ['jquery'],
            MAGICAL_ADDON_VERSION,
            true
        );
        wp_register_script(
            'mg-nav-menu',
            MAGICAL_ADDON_ASSETS . 'widget-assets/nav-menu/nav-menu.js',
            ['jquery'],
            MAGICAL_ADDON_VERSION,
            true
        );
        wp_register_script(
            'mg-tabs',
            MAGICAL_ADDON_ASSETS . 'widget-assets/mg-tabs/mg-tabs.js',
            ['jquery'],
            MAGICAL_ADDON_VERSION,
            true
        );
        wp_register_script(
            'mg-skillbars',
            MAGICAL_ADDON_ASSETS . 'widget-assets/skillbars/skillbars.js',
            ['jquery'],
            MAGICAL_ADDON_VERSION,
            true
        );
        wp_register_script(
            'mg-mailchimp',
            MAGICAL_ADDON_ASSETS . 'widget-assets/mailchimp/mailchimp.min.js',
            ['jquery'],
            MAGICAL_ADDON_VERSION,
            true
        );
        wp_localize_script(
            'mg-mailchimp',
            'localize',
            array(
                'ajax_url' => $ajax_url,
                'nonce'    => $mg_nonce,
            )
        );

        /*

        $localize_data = [
            'placeholder_widgets' => [],
            'hasPro'                  => true,
            'editor_nonce'            => wp_create_nonce('ha_editor_nonce'),
            'dark_stylesheet_url'     => '',
            'i18n' => [
                'promotionDialogHeader'     => esc_html__('%s Widget', 'happy-elementor-addons'),
                'promotionDialogMessage'    => esc_html__('Use %s widget with other exclusive pro widgets and 100% unique features to extend your toolbox and build sites faster and better.', 'happy-elementor-addons'),
                'templatesEmptyTitle'       => esc_html__('No Templates Found', 'happy-elementor-addons'),
                'templatesEmptyMessage'     => esc_html__('Try different category or sync for new templates.', 'happy-elementor-addons'),
                'templatesNoResultsTitle'   => esc_html__('No Results Found', 'happy-elementor-addons'),
                'templatesNoResultsMessage' => esc_html__('Please make sure your search is spelled correctly or try a different words.', 'happy-elementor-addons'),
            ],
        ];

        //  if (!ha_has_pro() && ha_is_elementor_version('>=', '2.9.0')) {
        $localize_data['placeholder_widgets'] = mgProWidgets::get_pro_widgets();
        //    }


        wp_localize_script(
            'happy-elementor-addons-editor',
            'HappyAddonsEditor',
            $localize_data
        );
        */
    }

    public static function frontend_scripts_active()
    {
        // Paichart JS
        /*  wp_register_script(
            'easypiechart-active',
            MAGICAL_ADDON_ASSETS . 'widget-assets/pie-chart/piechart-active.js',
            ['jquery', 'easypiechart'],
            MAGICAL_ADDON_VERSION,
            true
        );
        */
    }
}
mgAssetsManagement::init();
