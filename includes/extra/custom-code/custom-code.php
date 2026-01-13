<?php

/**
 * Custom Code Module for Magical Addons for Elementor
 * 
 * @package Magical_Addons
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define constants
if (!defined('MAGICAL_CUSTOM_CODE_PATH')) {
    define('MAGICAL_CUSTOM_CODE_PATH', plugin_dir_path(__FILE__));
}

// Include meta handling
require_once MAGICAL_CUSTOM_CODE_PATH . 'custom-code-meta.php';

class Magical_Custom_Code
{
    private $post_type = 'magical_custom_code';
    private static $instance = null;

    public static function get_instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct()
    {
        // Initialize meta handler
        Magical_Custom_Code_Meta::get_instance();

        add_action('init', array($this, 'register_post_type'));
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));

        // Frontend code output
        add_action('wp_head', array($this, 'output_header_code'));
        add_action('wp_footer', array($this, 'output_footer_code'));
        add_action('wp_body_open', array($this, 'output_body_code'));
    }

    public function register_post_type()
    {
        $labels = array(
            'name'               => __('Custom Code', 'magical-addons-for-elementor'),
            'singular_name'      => __('Custom Code', 'magical-addons-for-elementor'),
            'add_new'            => __('Add New', 'magical-addons-for-elementor'),
            'add_new_item'       => __('Add New Code', 'magical-addons-for-elementor'),
            'edit_item'          => __('Edit Code', 'magical-addons-for-elementor'),
            'new_item'           => __('New Code', 'magical-addons-for-elementor'),
            'all_items'          => __('All Custom Code', 'magical-addons-for-elementor'),
            'view_item'          => __('View Code', 'magical-addons-for-elementor'),
            'search_items'       => __('Search Custom Code', 'magical-addons-for-elementor'),
            'not_found'          => __('No custom code found', 'magical-addons-for-elementor'),
            'not_found_in_trash' => __('No custom code found in trash', 'magical-addons-for-elementor'),
            'parent_item_colon'  => '',
            'menu_name'          => __('Custom Code', 'magical-addons-for-elementor'),
        );

        $args = array(
            'labels'              => $labels,
            'public'              => false,
            'publicly_queryable'  => false,
            'show_ui'             => true,
            'show_in_menu'        => false,
            'query_var'           => true,
            'capability_type'     => 'post',
            'has_archive'         => false,
            'hierarchical'        => false,
            'menu_position'       => null,
            'supports'            => array('title'),
        );

        register_post_type($this->post_type, $args);
    }

    public function add_admin_menu()
    {
        add_submenu_page(
            'magical-addons',
            __('Custom Code', 'magical-addons-for-elementor'),
            __('Custom Code', 'magical-addons-for-elementor'),
            'edit_pages',
            'edit.php?post_type=' . $this->post_type
        );
    }

    public function enqueue_scripts($hook)
    {
        global $post_type;

        if ($this->post_type !== $post_type) {
            return;
        }

        wp_enqueue_style(
            'magical-custom-code',
            MAGICAL_ADDON_URL . 'assets/css/custom-code/custom-code.css',
            array(),
            MAGICAL_ADDON_VERSION
        );

        wp_enqueue_style('code-editor');
        wp_enqueue_script('jshint');
        wp_enqueue_script('htmlhint');
        wp_enqueue_script('csslint');

        $settings = wp_enqueue_code_editor(array('type' => 'text/html'));

        if (false === $settings) {
            return;
        }

        wp_localize_script('jquery', 'magicalCodeEditorSettings', $settings);

        wp_enqueue_script(
            'magical-custom-code-editor',
            MAGICAL_ADDON_URL . 'assets/js/custom-code/custom-code-editor.js',
            array('jquery', 'wp-theme-plugin-editor'),
            MAGICAL_ADDON_VERSION,
            true
        );
    }

    private function get_custom_code_by_location($location)
    {
        $args = array(
            'post_type'      => $this->post_type,
            'posts_per_page' => -1,
            'meta_query'     => array(
                array(
                    'key'   => '_magical_code_status',
                    'value' => 'active',
                ),
                array(
                    'key'   => '_magical_code_location',
                    'value' => sanitize_text_field($location),
                ),
            ),
            'orderby'  => 'meta_value_num',
            'meta_key' => '_magical_code_priority',
            'order'    => 'ASC',
        );

        $custom_code_posts = get_posts($args);
        $output = '';

        if (!empty($custom_code_posts)) {
            foreach ($custom_code_posts as $post) {
                $conditions = get_post_meta($post->ID, '_magical_code_conditions', true);

                if (!$this->check_conditions($conditions)) {
                    continue;
                }

                $code_content = get_post_meta($post->ID, '_magical_code_content', true);
                if (!empty($code_content)) {
                    $code_content = html_entity_decode($code_content, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                    $output .= $code_content . "\n";
                }
            }
        }

        return apply_filters('magical_custom_code_output', $output, $location);
    }

    private function output_code($location)
    {
        echo $this->get_custom_code_by_location($location);
    }

    public function output_header_code()
    {
        $this->output_code('head');
    }

    public function output_body_code()
    {
        $this->output_code('body_open');
    }

    public function output_footer_code()
    {
        $this->output_code('footer');
    }

    private function check_conditions($conditions)
    {
        if (empty($conditions) || !isset($conditions['type'])) {
            return true;
        }

        switch ($conditions['type']) {
            case 'entire_site':
                return true;

            case 'singular':
                if (is_singular() && isset($conditions['singular']) && is_array($conditions['singular'])) {
                    $post_type = get_post_type();
                    return in_array($post_type, $conditions['singular'], true);
                }
                return false;

            case 'archive':
                if (is_archive() && isset($conditions['archive']) && is_array($conditions['archive'])) {
                    if (in_array('category', $conditions['archive'], true) && is_category()) {
                        return true;
                    }
                    if (in_array('tag', $conditions['archive'], true) && is_tag()) {
                        return true;
                    }
                    if (class_exists('WooCommerce')) {
                        if (in_array('product_cat', $conditions['archive'], true) && is_product_category()) {
                            return true;
                        }
                        if (in_array('product_tag', $conditions['archive'], true) && is_product_tag()) {
                            return true;
                        }
                    }
                }
                return false;

            case 'woocommerce':
                if (class_exists('WooCommerce') && isset($conditions['woocommerce']) && is_array($conditions['woocommerce'])) {
                    if (in_array('shop', $conditions['woocommerce'], true) && is_shop()) {
                        return true;
                    }
                    if (in_array('cart', $conditions['woocommerce'], true) && is_cart()) {
                        return true;
                    }
                    if (in_array('checkout', $conditions['woocommerce'], true) && is_checkout()) {
                        return true;
                    }
                    if (in_array('account', $conditions['woocommerce'], true) && is_account_page()) {
                        return true;
                    }
                    if (in_array('thankyou', $conditions['woocommerce'], true) && is_wc_endpoint_url('order-received')) {
                        return true;
                    }
                }
                return false;

            default:
                return true;
        }
    }
}

/**
 * Initialize the Custom Code class
 * 
 * Since this file is loaded during the plugins_loaded hook,
 * we need to initialize directly
 */
function magical_custom_code_init()
{
    Magical_Custom_Code::get_instance();
}

// Initialize immediately since file is loaded after plugins_loaded
magical_custom_code_init();
