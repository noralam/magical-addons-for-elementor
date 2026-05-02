<?php

/**
 * GeneratePress theme
 */

class mg_GeneratePress_Theme_HF
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
                add_action('generate_header', 'magical_header_output');
            }
        }


        if ($mg_footer_template != 'select') {
            if (!empty($mg_footer_template)) {
                add_action('template_redirect', [$this, 'setup_footer']);
                add_action('generate_footer', 'magical_footer_output');
            }
        }
    }


    /**
     * Disable header from the theme.
     */
    public function setup_header()
    {
        remove_action('generate_header', 'generate_construct_header');
    }

    /**
     * Disable footer from the theme.
     */
    public function setup_footer()
    {
        remove_action('generate_footer', 'generate_construct_footer_widgets', 5);
        remove_action('generate_footer', 'generate_construct_footer');
    }
}
mg_GeneratePress_Theme_HF::get_instance();
