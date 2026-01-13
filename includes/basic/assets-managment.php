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
            'swiper',
            MAGICAL_ADDON_ASSETS . 'widget-assets/swiper/swiper.min.css',
            [],
            '8.4.5',
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

        // Timeline scroll
        wp_register_style(
            'mg-timeline',
            MAGICAL_ADDON_URL . 'assets/widget-assets/timeline/timeline.min.css',
            [],
            MAGICAL_ADDON_VERSION,
            'all'
        );
        // accordion style
        wp_register_style(
            'mg-accordion',
            MAGICAL_ADDON_URL . 'assets/css/accordion/mg-accordion.css',
            [],
            MAGICAL_ADDON_VERSION,
            'all'
        );
        // Hover card style
        wp_register_style(
            'mg-hover-card',
            MAGICAL_ADDON_URL . 'assets/widget-assets/img-hvr-card/imagehover.min.css',
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
        // Social Share
        wp_register_style(
            'mg-social-share',
            MAGICAL_ADDON_ASSETS . 'widget-assets/social-share/social-share.css',
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
        //tabs style
        wp_register_style(
            'mg-tabs',
            MAGICAL_ADDON_ASSETS . 'widget-assets/mg-tabs/mg-tabs.css',
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
        // timeline JS
        wp_register_script(
            "mg-timeline",
            MAGICAL_ADDON_URL . 'assets/widget-assets/timeline/timeline.min.js',
            array('jquery'),
            '1.0',
            true
        );
        wp_register_script(
            "mg-timeline-active",
            MAGICAL_ADDON_URL . 'assets/widget-assets/timeline/timeline-active.js',
            array('jquery'),
            '1.0',
            true
        );


        // Progressbar JS
        wp_register_script(
            'mg-progressbar-active',
            MAGICAL_ADDON_ASSETS . 'js/progressbar/progressbar-active.js',
            ['jquery'],
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

        // swiper JS
        wp_register_script(
            'swiper-active',
            MAGICAL_ADDON_URL . 'assets/widget-assets/slider/mgs-main.js',
            ['jquery'],
            MAGICAL_ADDON_VERSION,
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
        // image loader
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
        // Sharer JS
        wp_register_script(
            'jquery.waypoints',
            MAGICAL_ADDON_ASSETS . 'js/jquery.waypoints.min.js',
            ['jquery'],
            '4.0.1',
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

        // GSAP Core from CDN
        wp_register_script(
            'gsap',
            'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js',
            [],
            '3.12.5',
            true
        );

        // GSAP ScrollTrigger Plugin
        wp_register_script(
            'gsap-scrolltrigger',
            'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js',
            ['gsap'],
            '3.12.5',
            true
        );

        // GSAP Animations Handler
        wp_register_script(
            'mg-gsap-animations',
            MAGICAL_ADDON_ASSETS . 'js/gsap/mg-gsap-animations.js',
            ['jquery', 'gsap', 'gsap-scrolltrigger'],
            MAGICAL_ADDON_VERSION,
            true
        );
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
