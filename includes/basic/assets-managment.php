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
        add_action('elementor/frontend/after_enqueue_styles', [__CLASS__, 'frontend_style_register']);

        //  add_action('wp_enqueue_scripts', [__CLASS__, 'frontend_scripts_register']);
        add_action("elementor/frontend/after_enqueue_scripts", [__CLASS__, 'frontend_scripts_register']);
    }

    public static function frontend_style_register()
    {
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
    }
    // script register 
    public static function frontend_scripts_register()
    {
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
            false
        );
        wp_register_script(
            'twentytwenty',
            MAGICAL_ADDON_ASSETS . 'widget-assets/twentytwenty/jquery.twentytwenty.js',
            ['jquery', 'event-move'],
            MAGICAL_ADDON_VERSION,
            false
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
