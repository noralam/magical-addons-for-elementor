<?php

/**
 * Custom Code Meta Handling
 * 
 * @package Magical_Addons
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class Magical_Custom_Code_Meta
{
    private static $instance = null;
    private $nonce_action = 'magical_custom_code_nonce_action';
    private $nonce_name = 'magical_custom_code_nonce';
    private $post_type = 'magical_custom_code';

    public static function get_instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct()
    {
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post', array($this, 'save_meta'));
    }

    public function add_meta_boxes()
    {
        add_meta_box(
            'magical_custom_code_settings',
            __('Code Settings', 'magical-addons-for-elementor'),
            array($this, 'render_settings_meta_box'),
            $this->post_type,
            'normal',
            'high'
        );

        add_meta_box(
            'magical_custom_code_editor',
            __('Code Editor', 'magical-addons-for-elementor'),
            array($this, 'render_editor_meta_box'),
            $this->post_type,
            'normal',
            'high'
        );

        add_meta_box(
            'magical_custom_code_conditions',
            __('Display Conditions', 'magical-addons-for-elementor'),
            array($this, 'render_conditions_meta_box'),
            $this->post_type,
            'side',
            'default'
        );
    }

    public function render_settings_meta_box($post)
    {
        wp_nonce_field($this->nonce_action, $this->nonce_name);

        $location = get_post_meta($post->ID, '_magical_code_location', true);
        $priority = get_post_meta($post->ID, '_magical_code_priority', true);
        $mgporv_active = get_option('mgporv_active', false);

        if (empty($priority)) {
            $priority = 10;
        }
        ?>
        <div class="magical-code-settings-wrapper">
            <div class="magical-code-setting">
                <label for="magical_code_location"><?php esc_html_e('Location:', 'magical-addons-for-elementor'); ?></label>
                <select id="magical_code_location" name="magical_code_location">
                    <option value="head" <?php selected($location, 'head'); ?>><?php esc_html_e('<head>', 'magical-addons-for-elementor'); ?></option>
                    <option value="body_open" <?php selected($location, 'body_open'); ?>><?php esc_html_e('After <body> tag', 'magical-addons-for-elementor'); ?></option>
                    <option value="footer" <?php selected($location, 'footer'); ?>><?php esc_html_e('Footer', 'magical-addons-for-elementor'); ?></option>
                </select>
            </div>

            <div class="magical-code-setting">
                <label for="magical_code_priority">
                    <?php esc_html_e('Priority:', 'magical-addons-for-elementor'); ?>
                    <?php if (!$mgporv_active) : ?>
                        <span class="pro-badge"><?php esc_html_e('Pro', 'magical-addons-for-elementor'); ?></span>
                    <?php endif; ?>
                </label>
                <input type="number" 
                    id="magical_code_priority" 
                    name="magical_code_priority" 
                    value="<?php echo esc_attr($priority); ?>" 
                    min="1" 
                    max="100"
                    <?php echo !$mgporv_active ? 'readonly' : ''; ?>>
                <span class="description"><?php esc_html_e('Lower numbers execute earlier', 'magical-addons-for-elementor'); ?></span>
            </div>
        </div>
        <?php
    }

    public function render_editor_meta_box($post)
    {
        $code_content = get_post_meta($post->ID, '_magical_code_content', true);
        $code_content = html_entity_decode($code_content, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        ?>
        <div class="magical-code-editor-wrapper">
            <div id="magical-code-editor" style="height: 350px; width: 100%; border: 1px solid #ddd;"></div>
            <textarea name="magical_code_content" id="magical_code_content" style="display: none;"><?php echo esc_textarea($code_content); ?></textarea>
        </div>
        <?php
    }

    public function render_conditions_meta_box($post)
    {
        $conditions = get_post_meta($post->ID, '_magical_code_conditions', true);
        $status = get_post_meta($post->ID, '_magical_code_status', true);
        $mgporv_active = get_option('mgporv_active', false);

        if (empty($status)) {
            $status = 'active';
        }

        // Add Pro upgrade notice
        if (!$mgporv_active) {
            ?>
            <div class="magical-pro-notice">
                <p><?php esc_html_e('Unlock advanced features with Magical Addons Pro:', 'magical-addons-for-elementor'); ?></p>
                <ul>
                    <li><?php esc_html_e('• Custom Priority Control', 'magical-addons-for-elementor'); ?></li>
                    <li><?php esc_html_e('• Advanced Display Conditions', 'magical-addons-for-elementor'); ?></li>
                    <li><?php esc_html_e('• Singular & Archive Options', 'magical-addons-for-elementor'); ?></li>
                </ul>
                <a href="https://magic.wpcolors.net/pricing-plan/#mgpricing" target="_blank" class="magical-upgrade-button">
                    <?php esc_html_e('Upgrade to Pro', 'magical-addons-for-elementor'); ?>
                </a>
            </div>
        <?php
        }
        ?>
        <div class="magical-code-status">
            <label for="magical_code_status">
                <?php esc_html_e('Status:', 'magical-addons-for-elementor'); ?>
                <?php if (!$mgporv_active) : ?>
                    <span class="pro-badge"><?php esc_html_e('Pro', 'magical-addons-for-elementor'); ?></span>
                <?php endif; ?>
            </label>
            <select id="magical_code_status" name="magical_code_status" <?php echo !$mgporv_active ? 'disabled' : ''; ?>>
                <option value="active" <?php selected($status, 'active'); ?>><?php esc_html_e('Active', 'magical-addons-for-elementor'); ?></option>
                <option value="inactive" <?php selected($status, 'inactive'); ?>><?php esc_html_e('Inactive', 'magical-addons-for-elementor'); ?></option>
            </select>
        </div>

        <!-- Rest of your conditions meta box code -->
        <?php
        include_once MAGICAL_CUSTOM_CODE_PATH . 'views/conditions-meta-box.php';
    }

    public function save_meta($post_id)
    {
        if (!isset($_POST[$this->nonce_name])) {
            return $post_id;
        }

        $mgporv_active = get_option('mgporv_active', false);

        if (!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST[$this->nonce_name])), $this->nonce_action)) {
            return $post_id;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        if (!isset($_POST['post_type']) || $this->post_type !== sanitize_text_field(wp_unslash($_POST['post_type']))) {
            return $post_id;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        // Save location
        if (isset($_POST['magical_code_location'])) {
            update_post_meta($post_id, '_magical_code_location', sanitize_text_field(wp_unslash($_POST['magical_code_location'])));
        }

        // Save priority - only if pro is active
        if ($mgporv_active && isset($_POST['magical_code_priority'])) {
            update_post_meta($post_id, '_magical_code_priority', absint(wp_unslash($_POST['magical_code_priority'])));
        }

        // Save code content
        if (isset($_POST['magical_code_content'])) {
            update_post_meta($post_id, '_magical_code_content', wp_unslash($_POST['magical_code_content']));
        }

        // Save conditions - restrict in free version
        if (isset($_POST['magical_code_conditions']) && is_array($_POST['magical_code_conditions'])) {
            $conditions = wp_unslash($_POST['magical_code_conditions']);
            
            if (!$mgporv_active) {
                $conditions['type'] = 'entire_site';
                unset($conditions['singular']);
                unset($conditions['archive']);
                unset($conditions['woocommerce']);
            }
            
            $sanitized_conditions = $this->sanitize_array_recursive($conditions);
            update_post_meta($post_id, '_magical_code_conditions', $sanitized_conditions);
        }

        // Save status - only if pro is active
        if ($mgporv_active && isset($_POST['magical_code_status'])) {
            update_post_meta($post_id, '_magical_code_status', sanitize_text_field(wp_unslash($_POST['magical_code_status'])));
        }
    }

    private function sanitize_array_recursive($array)
    {
        foreach ($array as $key => &$value) {
            if (is_array($value)) {
                $value = $this->sanitize_array_recursive($value);
            } else {
                $value = sanitize_text_field($value);
            }
        }
        return $array;
    }
}
