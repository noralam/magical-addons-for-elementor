<?php

/**
 * Storefront theme
 */

class mg_Storefront_hfTheme
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
                add_action('storefront_before_header', 'magical_header_output');
            }
        }


        if ($mg_footer_template != 'select') {
            if (!empty($mg_footer_template)) {
                add_action('template_redirect', [$this, 'setup_footer']);
                add_action('storefront_after_footer', 'magical_footer_output');
            }
        }


        if ($mg_header_template != 'select' || $mg_footer_template != 'select') {
            add_action('wp_enqueue_scripts', [$this, 'styles']);
        }
    }

    /**
     * Disable header from the theme.
     */
    public function setup_header()
    {
        for ($priority = 0; $priority < 200; $priority++) {
            remove_all_actions('storefront_header', $priority);
        }
    }

    /**
     * Disable footer from the theme.
     */
    public function setup_footer()
    {
        for ($priority = 0; $priority < 200; $priority++) {
            remove_all_actions('storefront_footer', $priority);
        }
    }

    /**
     * Add inline CSS to hide empty divs for header and footer
     */
    public function styles()
    {
        $mg_header_template = mg_get_header_footer_option('mg_header_template', 'select');
        $mg_footer_template = mg_get_header_footer_option('mg_footer_template', 'select');
        $css = '';

        if ($mg_header_template != 'select') {
            $css .= '.site-header { display: none; }';
        }

        if ($mg_footer_template != 'select') {
            $css .= '.site-footer { display: none; }';
        }

        wp_add_inline_style('storefront-style', $css);
    }
}
mg_Storefront_hfTheme::get_instance();
