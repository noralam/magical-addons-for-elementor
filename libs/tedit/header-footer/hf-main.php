<?php

/**
 * Magical Addons Header Footer output
 */
if ('astra' === get_template()) {
    require_once(MAGICAL_ADDON_PATH . '/libs/tedit/header-footer/theme/astra-hf.php');
    return;
} elseif ('generatepress' === get_template()) {
    require_once(MAGICAL_ADDON_PATH . '/libs/tedit/header-footer/theme/generatepress-hf.php');
    return;
} elseif ('oceanwp' === get_template()) {
    require_once(MAGICAL_ADDON_PATH . '/libs/tedit/header-footer/theme/oceanwp-hf.php');
    return;
} elseif ('storefront' === get_template()) {
    require_once(MAGICAL_ADDON_PATH . '/libs/tedit/header-footer/theme/storefront-hf.php');
    return;
}

class mg_hf_main
{

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
                // Replace header.php template.
                add_action('get_header', [$this, 'override_header']);

                // Add our header.
                add_action('magical_header', 'magical_header_output');
            }
        }


        if ($mg_footer_template != 'select') {
            if (!empty($mg_footer_template)) {
                // Replace footer.php template.
                add_action('get_footer', [$this, 'override_footer']);

                // Add our footer.
                add_action('magical_footer', 'magical_footer_output');
            }
        }
    }

    /**
     * Function for overriding the header.
     */
    public function override_header()
    {
        require MAGICAL_ADDON_PATH . 'libs/tedit/header-footer/header.php';

        $templates = [];
        $templates[] = 'header.php';

        // Avoid running wp_head hooks again
        remove_all_actions('wp_head');
        ob_start();
        locate_template($templates, true);
        ob_get_clean();
    }

    /**
     * Function for overriding the footer.
     */
    public function override_footer()
    {
        require MAGICAL_ADDON_PATH . 'libs/tedit/header-footer/footer.php';
        $templates   = [];
        $templates[] = 'footer.php';
        // Avoid running wp_footer hooks again.
        ob_start();
        locate_template($templates, true);
        ob_get_clean();
    }
}

new mg_hf_main();
