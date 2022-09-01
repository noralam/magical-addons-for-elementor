<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Class PP_Config.
 */
class mgProWidgets
{
    function __construct()
    {

        add_filter('elementor/editor/localize_settings', [$this, 'get_promotion_widgets']);
        add_action('elementor/editor/after_enqueue_scripts', [$this, 'editor_scripts']);
        //   add_action('elementor/preview/enqueue_styles', [$this, 'editor_preview_widget_styles']);
    }

    function editor_scripts()
    {
        wp_enqueue_script("mgadmin-el-editor", MAGICAL_ADDON_URL . 'assets/js/el-editor.js', array('jquery'), '5.1.3', true);
    }

    public function get_promotion_widgets($config)
    {

        $promotion_widgets = [];

        if (isset($config['promotionWidgets'])) {
            $promotion_widgets = $config['promotionWidgets'];
        }

        $pro_widgets = $this::get_pro_widgets();

        $combine_array = array_merge($promotion_widgets, $pro_widgets);

        $config['promotionWidgets'] = $combine_array;

        return $config;
    }



    /**
     * Get Widget List.
     *
     * @since 1.2.9.4
     *
     * @return array The Widget List.
     */
    public static function get_pro_widgets()
    {
        $pro_widgets = [
            [
                'name'       => 'mgbar_chart',
                'title'      => __('Mg Bar Chart', 'magical-addons-pro'),
                'categories' => '["magical-pro"]',
                'keywords'   => ['chart', 'bar', 'statistic', 'graph'],
                'icon'       => 'eicon-align-end-v',
            ],
            [
                'name'       => 'mgpadvancefilter',
                'title'      => __('Portfolio/Filter Gallery', 'magical-addons-pro'),
                'categories' => '["magical-pro"]',
                'keywords'   => ['mg', 'works', 'portfolio', 'gallery', 'filter'],
                'icon'       => 'eicon-filter',
            ],
            [
                'name'       => 'mgaploti_animation',
                'title'      => __('Mg Lottie Animations', 'magical-addons-pro'),
                'categories' => '["magical-pro"]',
                'keywords'   => ['mg', 'lottie', 'animation', 'animations', 'svg'],
                'icon'       => 'eicon-lottie',
            ],
            [
                'name'       => 'mginfoboxcarousel',
                'title'      => __('InfoBox Carousel', 'magical-addons-pro'),
                'categories' => '["magical-pro"]',
                'keywords'   => ['mg', 'info', 'carousel', 'slider', 'infobox'],
                'icon'       => 'eicon-posts-ticker',
            ],
            [
                'name'       => 'mgptesticarousel',
                'title'      => __('Testimonial Carousel', 'magical-addons-pro'),
                'categories' => '["magical-pro"]',
                'keywords'   => ['mg', 'review', 'carousel', 'feedback', 'testimonial'],
                'icon'       => 'eicon-form-vertical',
            ],
            [
                'name'       => 'mgpromobox',
                'title'      => __('Mg Promo Box', 'magical-addons-pro'),
                'categories' => '["magical-pro"]',
                'keywords'   => ['mg', 'promo', 'promo box', 'box', 'number box'],
                'icon'       => 'eicon-product-upsell',
            ],
            [
                'name'       => 'mgpricemenu',
                'title'      => __('MG Price Menu', 'magical-addons-pro'),
                'categories' => '["magical-pro"]',
                'keywords'   => ['price', 'list', 'menu', 'mg'],
                'icon'       => 'eicon-price-list',
            ],
            [
                'name'       => 'mgprophotobunch',
                'title'      => __('Photo Bunch', 'magical-addons-pro'),
                'categories' => '["magical-pro"]',
                'keywords'   => ['price', 'list', 'menu', 'mg'],
                'icon'       => 'eicon-price-list',
            ],
            [
                'name'       => 'mgppdfview',
                'title'      => __('Mg PDF View', 'magical-addons-pro'),
                'categories' => '["magical-pro"]',
                'keywords'   => ['mg', 'pdf', 'document', 'docs', 'file'],
                'icon'       => 'eicon-document-file',
            ],
            [
                'name'       => 'mgpro_onepagenav',
                'title'      => __('Mg One Page Nav', 'magical-addons-pro'),
                'categories' => '["magical-pro"]',
                'keywords'   => ['mg', 'nav', 'navigation', 'menu', 'one page nav'],
                'icon'       => 'eicon-navigation-vertical',
            ],
            [
                'name'       => 'mgpro_offcanvas',
                'title'      => __('Mg Off Canvas', 'magical-addons-pro'),
                'categories' => '["magical-pro"]',
                'keywords'   => ['mg', 'off', 'canvas', 'menu', 'widget'],
                'icon'       => 'eicon-kit-parts',
            ],
            [
                'name'       => 'mgpro_modal',
                'title'      => __('Mg Modal/Popup', 'magical-addons-pro'),
                'categories' => '["magical-pro"]',
                'keywords'   => ['mg', 'modal', 'popup', 'click', 'ads'],
                'icon'       => 'eicon-click',
            ],
            [
                'name'       => 'mgpro_hotspots',
                'title'      => __('Mg Image Hotspots', 'magical-addons-pro'),
                'categories' => '["magical-pro"]',
                'keywords'   => ['mg', 'hotspots', 'hotspot', 'image', 'animations'],
                'icon'       => 'eicon-image-hotspot',
            ],
            [
                'name'       => 'mgprocounter',
                'title'      => __('Mg Counter', 'magical-addons-pro'),
                'categories' => '["magical-pro"]',
                'keywords'   => ['mg', 'counter', 'counter up', 'funfact', 'number counter'],
                'icon'       => 'eicon-counter',
            ],
            [
                'name'       => 'mgcontentswitcher',
                'title'      => __('Mg Content Switcher', 'magical-addons-pro'),
                'categories' => '["magical-pro"]',
                'keywords'   => ['mg', 'content', 'switcher', 'toggle', 'tab'],
                'icon'       => 'eicon-post-navigation',
            ],
            [
                'name'       => 'mgcontentswitcher',
                'title'      => __('Mg Price comparison', 'magical-addons-pro'),
                'categories' => '["magical-pro"]',
                'keywords'   => ['mg', 'comparison table', 'table', 'compare'],
                'icon'       => 'eicon-justify-center-h',
            ],
            [
                'name'       => 'mganimated_heading',
                'title'      => __('Mg Animated Heading', 'magical-addons-pro'),
                'categories' => '["magical-pro"]',
                'keywords'   => ['mg', 'animated', 'heading', 'title', 'typing'],
                'icon'       => 'eicon-heading',
            ],
            [
                'name'       => 'mgp_search',
                'title'      => __('Ajax Search', 'magical-addons-pro'),
                'categories' => '["magical-pro"]',
                'keywords'   => ['ajax', 'search', 'search icon', 'mgp'],
                'icon'       => 'eicon-search-results',
            ],
            [
                'name'       => 'mgproticker',
                'title'      => __('Advanced Ticker', 'magical-addons-pro'),
                'categories' => '["magical-pro"]',
                'keywords'   => ['mg', 'ticker', 'news', 'post', 'content'],
                'icon'       => 'eicon-posts-ticker',
            ]

        ];



        return $pro_widgets;
    }
}
$mgadmin_notices = new mgProWidgets();
