<?php

/**
 * Astra theme
 */

class mg_Astra_Theme_HF
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
                add_action('astra_header', 'magical_header_output');
            }
        }


        if ($mg_footer_template != 'select') {
            if (!empty($mg_footer_template)) {
                add_action('template_redirect', [$this, 'setup_footer']);
                add_action('astra_footer', 'magical_footer_output');
            }
        }
    }



    /**
     * Disable header from the theme.
     */
    public function setup_header()
    {
        remove_action('astra_header', 'astra_header_markup');

        // Remove the new header builder action.
        if (class_exists('Astra_Builder_Helper') && Astra_Builder_Helper::$is_header_footer_builder_active) {
            remove_action('astra_header', [Astra_Builder_Header::get_instance(), 'prepare_header_builder_markup']);
        }
    }

    /**
     * Disable footer from the theme.
     */
    public function setup_footer()
    {
        remove_action('astra_footer', 'astra_footer_markup');

        // Remove the new footer builder action.
        if (class_exists('Astra_Builder_Helper') && Astra_Builder_Helper::$is_header_footer_builder_active) {
            remove_action('astra_footer', [Astra_Builder_Footer::get_instance(), 'footer_markup']);
        }
    }
}
mg_Astra_Theme_HF::get_instance();
