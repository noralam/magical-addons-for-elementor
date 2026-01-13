<?php

/**
 * OceanWP theme
 */

class mg_OceanWP_Theme_HF
{
    private static $instance = null;

    /**
     * Instance.
     *
     * @return object Class object.
     */
    public static function get_instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Initiator
     */
    public function __construct()
    {
        add_action('wp', [$this, 'hooks']);
    }

    /**
     * Run all the Actions / Filters.
     */
    public function hooks()
    {
        $mg_header_template = mg_get_header_footer_option('mg_header_template', 'select');
        $mg_footer_template = mg_get_header_footer_option('mg_footer_template', 'select');


        if ($mg_header_template != 'select') {
            if (!empty($mg_header_template)) {
                add_action('template_redirect', [$this, 'setup_header']);
                add_action('ocean_header', 'magical_header_output');
            }
        }


        if ($mg_footer_template != 'select') {
            if (!empty($mg_footer_template)) {
                add_action('template_redirect', [$this, 'setup_footer']);
                add_action('ocean_footer', 'magical_footer_output');
            }
        }
    }

    /**
     * Disable header from the theme.
     */
    public function setup_header()
    {
        remove_action('ocean_top_bar', 'oceanwp_top_bar_template');
        remove_action('ocean_header', 'oceanwp_header_template');
        remove_action('ocean_page_header', 'oceanwp_page_header_template');
    }

    /**
     * Disable footer from the theme.
     */
    public function setup_footer()
    {
        remove_action('ocean_footer', 'oceanwp_footer_template');
    }
}
mg_OceanWP_Theme_HF::get_instance();
