<?php
/**
 * Settings Defaults Manager for Magical Addons
 *
 * @package MagicalAddons
 * @since 1.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Magical_Addons_Settings_Defaults
 * 
 * Manages default values for all settings and handles migration
 */
class Magical_Addons_Settings_Defaults {

    /**
     * Constructor
     */
    public function __construct() {
        add_action( 'admin_init', array( $this, 'maybe_update_defaults' ) );
    }

    /**
     * Get default values for free widgets
     *
     * @return array
     */
    public function get_widget_defaults() {
        return array(
            'mg_slider'          => 'on',
            'mg_postgrid'        => 'on',
            'mg_postlist'        => 'on',
            'mg_sec_title'       => 'on',
            'mg_infobox'         => 'on',
            'mg_card'            => 'on',
            'mg_hover_card'      => 'on',
            'mg_pricing_table'   => 'on',
            'mg_tabs'            => 'on',
            'mg_countdown'       => 'on',
            'mg_dual_heading'    => 'on',
            'mg_text_effects'    => 'on',
            'mg_team_members'    => 'on',
            'mg_timeline'        => 'on',
            'mg_accordion'       => 'on',
            'mg_aboutme'         => 'on',
            'mg_progressbar'     => 'on',
            'mg_blockquote'      => 'on',
            'mg_video_card'      => 'on',
            'mg_cf7'             => 'on',
            'mg_wpforms'         => 'on',
            'mg_sharebtn'        => 'on',
            'mg_piechart'        => 'on',
            'mg_img_comparison'  => 'on',
            'mg_imgaccordion'    => 'on',
            'mg_content_reveal'  => 'on',
            'mg_flipbox'         => 'on',
            'mg_dualbtn'         => 'on',
            'mg_iconlist'        => 'on',
            'mg_imgsmooth_scroll' => 'on',
            'mg_infolist'        => 'on',
            'mg_etemplate'       => 'on',
            'mg_scroll_top'      => 'on',
            'mg_site_logo'       => 'on',
            'mg_cattag_list'     => 'on',
            'mg_searchbar'       => 'on',
            'mg_navmenu'         => 'on',
            'mg_data_table'      => 'on',
            'mg_mailchimp'       => 'on',
            'mg_skillbar'        => 'on',
            'mg_project_details' => 'on',
        );
    }

    /**
     * Get default values for pro widgets
     *
     * @return array
     */
    public function get_pro_widget_defaults() {
        return array(
            'mgp_lottie'       => 'on',
            'mgp_hotspot'      => 'on',
            'mgp_filter'       => 'on',
            'mgp_tcarosuel'    => 'on',
            'mgp_counter'      => 'on',
            'mgp_infocarousel' => 'on',
            'mgp_adticker'     => 'on',
            'mgp_photobunch'   => 'on',
            'mgp_barchart'     => 'on',
            'mgp_pdfview'      => 'on',
            'mgp_price_comp'   => 'on',
            'mgp_nav_onepage'  => 'on',
            'mgp_off_canvas'   => 'on',
            'mgp_promobox'     => 'on',
            'mgp_pricemenu'    => 'on',
            'mgp_animatedh'    => 'on',
            'mgp_popup'        => 'on',
            'mgp_ajsearch'     => 'on',
        );
    }

    /**
     * Get default values for header/footer settings
     *
     * @return array
     */
    public function get_header_footer_defaults() {
        return array(
            'mg_header_template' => '',
            'mg_footer_template' => '',
        );
    }

    /**
     * Get default values for extra settings
     *
     * @return array
     */
    public function get_extra_defaults() {
        return array(
            'mg_mailchimp_api' => '',
        );
    }

    /**
     * Get all defaults
     *
     * @return array
     */
    public function get_all_defaults() {
        return array(
            'widgets'      => $this->get_widget_defaults(),
            'proWidgets'   => $this->get_pro_widget_defaults(),
            'headerFooter' => $this->get_header_footer_defaults(),
            'extra'        => $this->get_extra_defaults(),
        );
    }

    /**
     * Check and update defaults if needed
     * 
     * This ensures existing user settings are preserved while new widgets get defaults
     */
    public function maybe_update_defaults() {
        $current_version = get_option( 'magical_addons_settings_version', '0' );
        $new_version = MAGICAL_ADDON_VERSION;

        // Only run if version changed
        if ( version_compare( $current_version, $new_version, '>=' ) ) {
            return;
        }

        $this->merge_widget_defaults();
        $this->merge_pro_widget_defaults();
        $this->merge_header_footer_defaults();
        $this->merge_extra_defaults();

        // Update version
        update_option( 'magical_addons_settings_version', $new_version );
    }

    /**
     * Merge widget defaults with existing settings
     */
    private function merge_widget_defaults() {
        $defaults = $this->get_widget_defaults();
        $existing = get_option( 'magical_addons', array() );
        
        // Ensure $existing is an array
        if ( ! is_array( $existing ) ) {
            $existing = array();
        }

        // Only add new widgets that don't exist in user settings
        $merged = array_merge( $defaults, $existing );

        // Ensure we don't lose any user settings
        foreach ( $existing as $key => $value ) {
            $merged[ $key ] = $value;
        }

        update_option( 'magical_addons', $merged );
    }

    /**
     * Merge pro widget defaults with existing settings
     */
    private function merge_pro_widget_defaults() {
        $defaults = $this->get_pro_widget_defaults();
        $existing = get_option( 'magical_addons_pro', array() );
        
        // Ensure $existing is an array
        if ( ! is_array( $existing ) ) {
            $existing = array();
        }

        $merged = array_merge( $defaults, $existing );

        foreach ( $existing as $key => $value ) {
            $merged[ $key ] = $value;
        }

        update_option( 'magical_addons_pro', $merged );
    }

    /**
     * Merge header/footer defaults with existing settings
     */
    private function merge_header_footer_defaults() {
        $defaults = $this->get_header_footer_defaults();
        $existing = get_option( 'magical_headerfooter', array() );
        
        // Ensure $existing is an array
        if ( ! is_array( $existing ) ) {
            $existing = array();
        }

        $merged = wp_parse_args( $existing, $defaults );

        update_option( 'magical_headerfooter', $merged );
    }

    /**
     * Merge extra defaults with existing settings
     */
    private function merge_extra_defaults() {
        $defaults = $this->get_extra_defaults();
        $existing = get_option( 'magical_extra', array() );
        
        // Ensure $existing is an array
        if ( ! is_array( $existing ) ) {
            $existing = array();
        }

        $merged = wp_parse_args( $existing, $defaults );

        update_option( 'magical_extra', $merged );
    }

    /**
     * Get widget option value with default fallback
     *
     * @param string $key Widget key
     * @param string $default Default value
     * @return string
     */
    public function get_widget_option( $key, $default = 'on' ) {
        $widgets = get_option( 'magical_addons', array() );
        return isset( $widgets[ $key ] ) ? $widgets[ $key ] : $default;
    }

    /**
     * Get pro widget option value with default fallback
     *
     * @param string $key Widget key
     * @param string $default Default value
     * @return string
     */
    public function get_pro_widget_option( $key, $default = 'on' ) {
        $widgets = get_option( 'magical_addons_pro', array() );
        return isset( $widgets[ $key ] ) ? $widgets[ $key ] : $default;
    }

    /**
     * Check if a widget is enabled
     *
     * @param string $key Widget key
     * @return bool
     */
    public function is_widget_enabled( $key ) {
        return $this->get_widget_option( $key, 'on' ) === 'on';
    }

    /**
     * Check if a pro widget is enabled
     *
     * @param string $key Widget key
     * @return bool
     */
    public function is_pro_widget_enabled( $key ) {
        return $this->get_pro_widget_option( $key, 'on' ) === 'on';
    }
}
