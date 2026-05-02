<?php

/**
 * Line Awesome Icons Integration for Magical Addons
 */
class MGLine_Awesome_Icons
{

    private static $instance = null;

    /**
     * Singleton instance
     */
    public static function get_instance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        // Register and enqueue styles
        add_action('elementor/frontend/after_register_styles', [$this, 'register_styles']);
        add_action('elementor/frontend/after_enqueue_styles', [$this, 'enqueue_styles']);
        add_action('elementor/editor/after_enqueue_styles', [$this, 'enqueue_styles']);

        // Add icons to Elementor
        add_filter('elementor/icons_manager/additional_tabs', [$this, 'add_line_awesome_icons']);
    }



    /**
     * Register styles
     */
    public function register_styles()
    {
        wp_register_style(
            'mg-line-awesome',
            MAGICAL_ADDON_URL . 'assets/css/line-awesome.min.css',
            [],
            '1.3.0'
        );
    }

    /**
     * Enqueue styles
     */
    public function enqueue_styles()
    {
        wp_enqueue_style('mg-line-awesome');
    }


    public function add_line_awesome_icons($tabs)
    {
        $tabs['mg-line-awesome'] = [
            'name'          => 'mg-line-awesome',
            'label'         => esc_html__('Magical Line Icons', 'magical-addons-for-elementor'),
            'url'           => MAGICAL_ADDON_URL . 'assets/css/line-awesome.min.css',
            'enqueue'       => [],
            'prefix'        => 'la-',
            'displayPrefix' => 'la',
            'labelIcon'     => 'la la-icons',
            'ver'           => '1.3.0',
            'fetchJson'     => MAGICAL_ADDON_URL . 'assets/js/line-awesome-las-icons.json',
            'native'        => false,
        ];

        $tabs['mg-line-awesome-brand'] = [
            'name'          => 'mg-line-awesome-brand',
            'label'         => esc_html__('Magical Brand Icons', 'magical-addons-for-elementor'),
            'url'           => MAGICAL_ADDON_URL . 'assets/css/line-awesome.min.css',
            'enqueue'       => [],
            'prefix'        => 'la-',
            'displayPrefix' => 'lab',
            'labelIcon'     => 'la la-asterisk',
            'ver'           => '1.3.0',
            'fetchJson'     => MAGICAL_ADDON_URL . 'assets/js/line-awesome-lab-icons.json',
            'native'        => false,
        ];

        return $tabs;
    }
}

// Initialize
MGLine_Awesome_Icons::get_instance();
