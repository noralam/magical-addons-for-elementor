<?php

/**
 * Magical Addons Role Manager with Tabs and Accordions
 * 
 * Adds role management capabilities for Elementor similar to Elementor Pro
 * with a tabbed interface for different user roles
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Main class for the Role Manager functionality
 */
class Magical_Elementor_Role_Manager
{
    /**
     * Define capabilities structure
     * 
     * @var array
     */
    private $wp_capabilities = [
        'free_caps' => [],
        'pro_caps' => [] // Pro capabilities will include WooCommerce capabilities when active
    ];

    /**
     * User roles array
     * 
     * @var array
     */
    private $user_roles = [];

    /**
     * Pro status cache
     * 
     * @var bool|null
     */
    private $is_pro = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Initialize default capabilities
        $this->set_default_capabilities();

        add_action('init', [$this, 'load_caps']);
        // Removed: add_action('admin_menu', [$this, 'register_admin_menu'], 50);
        // Role Manager is now integrated into the React admin panel
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('wp_ajax_magical_save_role_manager', [$this, 'save_role_settings']);
    }

    /**
     * Check if WooCommerce is active
     * 
     * @return bool True if WooCommerce is active
     */
    private function is_woocommerce_active()
    {
        return class_exists('WooCommerce');
    }

    /**
     * Check if premium version is active
     * 
     * @return bool Pro status
     */
    private function get_pro_status()
    {
        if ($this->is_pro === null) {
            $this->is_pro = (bool) get_option('mgporv_active', false);
        }
        return $this->is_pro;
    }

    /**
     * Load capabilities with translations
     */
    public function load_caps()
    {
        // Initialize capabilities with translations
        $this->wp_capabilities['free_caps'] = [
            'publish_posts' => __('Publish Posts', 'magical-addons-for-elementor'),
            'publish_pages' => __('Publish Pages', 'magical-addons-for-elementor'),
        ];

        $this->wp_capabilities['pro_caps'] = [
            'edit_posts' => __('Edit Posts', 'magical-addons-for-elementor'),
            'edit_pages' => __('Edit Pages', 'magical-addons-for-elementor'),
            'upload_files' => __('Upload Files', 'magical-addons-for-elementor'),
        ];

        // Add WooCommerce capabilities to pro_caps when WooCommerce is active
        if ($this->is_woocommerce_active()) {
            $this->wp_capabilities['pro_caps'] = array_merge($this->wp_capabilities['pro_caps'], [
                'manage_woocommerce' => __('Manage WooCommerce', 'magical-addons-for-elementor'),
                'edit_products' => __('Edit Products', 'magical-addons-for-elementor'),
                'edit_published_products' => __('Edit Published Products', 'magical-addons-for-elementor'),
                'publish_products' => __('Publish Products', 'magical-addons-for-elementor'),
                'read_private_products' => __('Read Private Products', 'magical-addons-for-elementor'),
                'view_woocommerce_reports' => __('View WooCommerce Reports', 'magical-addons-for-elementor'),
            ]);
        }

        // Initialize user roles with translations
        $this->user_roles = [
            'editor' => __('Editor', 'magical-addons-for-elementor'),
            'author' => __('Author', 'magical-addons-for-elementor'),
            'contributor' => __('Contributor', 'magical-addons-for-elementor'),
            'subscriber' => __('Subscriber', 'magical-addons-for-elementor'),
        ];
    }

    /**
     * Set default WordPress capabilities for roles
     */
    private function set_default_capabilities()
    {
        static $defaults_checked = false;

        // Only check once per request
        if ($defaults_checked) {
            return;
        }
        $defaults_checked = true;

        // Only set defaults if it hasn't been done before
        if (get_option('magical_role_manager_defaults_set')) {
            return;
        }

        // Editor Role
        $editor = get_role('editor');
        if ($editor) {
            $editor->add_cap('publish_posts');
            $editor->add_cap('publish_pages');
            if ($this->get_pro_status()) {
                $editor->add_cap('edit_posts');
                $editor->add_cap('edit_pages');
                $editor->add_cap('upload_files');
            }
        }

        // Author Role
        $author = get_role('author');
        if ($author) {
            $author->add_cap('publish_posts');
            if ($this->get_pro_status()) {
                $author->add_cap('edit_posts');
                $author->add_cap('upload_files');
            }
        }

        // Mark as initialized
        update_option('magical_role_manager_defaults_set', true);
    }

    /**
     * Register the admin menu
     */
    public function register_admin_menu()
    {
        add_submenu_page(
            'magical-addons', // Parent menu slug
            __('Role Manager', 'magical-addons-for-elementor'), // Page title
            __('Role Manager', 'magical-addons-for-elementor'), // Menu title
            'manage_options', // Capability
            'magical-role-manager', // Menu slug
            [$this, 'render_role_manager_page'] // Callback function
        );
    }

    /**
     * Enqueue necessary scripts
     * 
     * @param string $hook Current admin page hook
     */
    public function enqueue_scripts($hook)
    {
        if ('magical-addons_page_magical-role-manager' !== $hook) {
            return;
        }

        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-tabs');

        wp_enqueue_style(
            'magical-role-manager',
            MAGICAL_ADDON_ASSETS . 'widget-assets/role-manager/role-manager.css',
            [],
            '1.0.1'
        );

        wp_enqueue_script(
            'magical-role-manager',
            MAGICAL_ADDON_ASSETS . 'widget-assets/role-manager/role-manager.js',
            ['jquery', 'jquery-ui-tabs'],
            '1.0.1',
            true
        );

        wp_localize_script(
            'magical-role-manager',
            'MagicalRoleManager',
            [
                'nonce' => wp_create_nonce('magical_role_manager_nonce'),
                'ajaxurl' => admin_url('admin-ajax.php'),
                'saveSuccess' => __('Role Manager settings updated successfully.', 'magical-addons-for-elementor'),
                'saveError' => __('Error saving settings. Please try again.', 'magical-addons-for-elementor'),
            ]
        );
    }

    /**
     * Get role object by role key
     * 
     * @param string $role_key Role key
     * @return WP_Role|null Role object or null if not found
     */
    private function get_role_object($role_key)
    {
        global $wp_roles;

        if (!isset($wp_roles)) {
            $wp_roles = new WP_Roles();
        }

        return get_role($role_key);
    }

    /**
     * Checks if a capability is valid within our defined capability sets
     * 
     * @param string $cap_key The capability key to check
     * @return bool True if capability exists in our defined sets
     */
    private function is_valid_capability($cap_key)
    {
        return isset($this->wp_capabilities['free_caps'][$cap_key]) ||
            isset($this->wp_capabilities['pro_caps'][$cap_key]);
    }

    /**
     * Save role settings via AJAX
     */
    public function save_role_settings()
    {
        try {
            // Verify nonce and capability in one check
            if (!check_ajax_referer('magical_role_manager_nonce', 'nonce', false) || !current_user_can('manage_options')) {
                wp_send_json_error(['message' => esc_html__('Security check failed', 'magical-addons-for-elementor')]);
                return;
            }

            // Sanitize and validate roles data
            $roles_json = isset($_POST['roles']) ? sanitize_text_field(wp_unslash($_POST['roles'])) : '';

            if (empty($roles_json)) {
                wp_send_json_error(['message' => esc_html__('No role data received', 'magical-addons-for-elementor')]);
                return;
            }

            $roles_data = json_decode($roles_json, true);

            // Validate JSON data
            if (json_last_error() !== JSON_ERROR_NONE || !is_array($roles_data)) {
                wp_send_json_error(['message' => esc_html__('Invalid data format', 'magical-addons-for-elementor')]);
                return;
            }

            $updated_roles = [];
            $mgporv_active = $this->get_pro_status();

            foreach ($roles_data as $role_key => $capabilities) {
                // Sanitize role key
                $role_key = sanitize_key($role_key);
                $role = $this->get_role_object($role_key);

                if (!$role || !array_key_exists($role_key, $this->user_roles)) {
                    continue;
                }

                $updated_roles[] = $role_key;

                // Remove all managed capabilities
                foreach ($this->wp_capabilities['free_caps'] as $cap_key => $cap_title) {
                    $role->remove_cap($cap_key);
                }

                foreach ($this->wp_capabilities['pro_caps'] as $cap_key => $cap_title) {
                    $role->remove_cap($cap_key);
                }

                // Add selected capabilities
                foreach ($capabilities as $cap_key => $enabled) {
                    // Validate capability
                    if (!$this->is_valid_capability($cap_key)) {
                        continue;
                    }

                    $is_pro_cap = isset($this->wp_capabilities['pro_caps'][$cap_key]);

                    if ($enabled && (!$is_pro_cap || ($is_pro_cap && $mgporv_active))) {
                        $role->add_cap($cap_key);
                    }
                }
            }

            wp_send_json_success([
                'message' => esc_html__('Role Manager settings updated successfully.', 'magical-addons-for-elementor'),
                'updated_roles' => array_map('esc_html', $updated_roles)
            ]);
        } catch (Exception $e) {
            wp_send_json_error([
                'message' => esc_html__('An error occurred: ', 'magical-addons-for-elementor') . esc_html($e->getMessage())
            ]);
        }
    }

    /**
     * Render the tabs navigation
     */
    private function render_role_tabs_navigation()
    {
?>
        <ul class="magical-tabs-nav">
            <?php foreach ($this->user_roles as $role_key => $role_name) : ?>
                <li><a href="#tab-<?php echo esc_attr($role_key); ?>"><?php echo esc_html($role_name); ?></a></li>
            <?php endforeach; ?>
        </ul>
    <?php
    }

    /**
     * Render a role tab content
     * 
     * @param string $role_key Role key
     * @param string $role_name Role name
     * @param WP_Role $role_obj Role object
     * @param bool $mgporv_active Pro status
     */
    private function render_role_tab_content($role_key, $role_name, $role_obj, $mgporv_active)
    {
    ?>
        <div id="tab-<?php echo esc_attr($role_key); ?>" class="magical-tab-content">

            <h2><?php echo sprintf(
                // translators: %s is the role name (e.g., Administrator, Editor, etc.)
                esc_html__('%s Capabilities', 'magical-addons-for-elementor'), 
                esc_html($role_name)
            ); ?></h2>

            <table class="form-table">
                <tbody>
                    <?php
                    // Render free capabilities
                    foreach ($this->wp_capabilities['free_caps'] as $wp_cap => $wp_cap_title) :
                        $has_wp_cap = $role_obj && $role_obj->has_cap($wp_cap);
                    ?>
                        <tr>
                            <th scope="row">
                                <label for="<?php echo esc_attr("{$role_key}_{$wp_cap}"); ?>">
                                    <?php echo esc_html($wp_cap_title); ?>
                                </label>
                            </th>
                            <td>
                                <label class="magical-switch">
                                    <input type="checkbox"
                                        id="<?php echo esc_attr("{$role_key}_{$wp_cap}"); ?>"
                                        name="roles[<?php echo esc_attr($role_key); ?>][<?php echo esc_attr($wp_cap); ?>]"
                                        value="1"
                                        <?php checked($has_wp_cap); ?>>
                                    <span class="magic-slider"></span>
                                </label>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php
                    // Render pro capabilities
                    foreach ($this->wp_capabilities['pro_caps'] as $wp_cap => $wp_cap_title) :
                        $has_wp_cap = $role_obj && $role_obj->has_cap($wp_cap);
                    ?>
                        <tr class="<?php echo !$mgporv_active ? 'pro-feature' : ''; ?>">
                            <th scope="row">
                                <label for="<?php echo esc_attr("{$role_key}_{$wp_cap}"); ?>">
                                    <?php echo esc_html($wp_cap_title); ?>
                                    <?php if (!$mgporv_active) : ?>
                                        <span class="pro-badge"><?php esc_html_e('Pro', 'magical-addons-for-elementor'); ?></span>
                                    <?php endif; ?>
                                </label>
                            </th>
                            <td>
                                <label class="magical-switch">
                                    <input type="checkbox"
                                        id="<?php echo esc_attr("{$role_key}_{$wp_cap}"); ?>"
                                        name="roles[<?php echo esc_attr($role_key); ?>][<?php echo esc_attr($wp_cap); ?>]"
                                        value="1"
                                        <?php checked($has_wp_cap); ?>
                                        <?php echo !$mgporv_active ? 'disabled' : ''; ?>>
                                    <span class="magic-slider"></span>
                                </label>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php
    }

    /**
     * Render the role manager page
     */
    public function render_role_manager_page()
    {
        // Verify user capability
        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('You do not have sufficient permissions to access this page.', 'magical-addons-for-elementor'));
        }

        $mgporv_active = $this->get_pro_status();
        $success_message = '';

        // Verify nonce and process form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!check_admin_referer('magical_role_manager_nonce', 'magical_role_manager_nonce')) {
                wp_die(esc_html__('Security check failed', 'magical-addons-for-elementor'));
            }

            $success_message = '<div class="notice notice-success is-dismissible"><p>' .
                esc_html__('Role Manager settings updated successfully.', 'magical-addons-for-elementor') .
                '</p></div>';
        }

        // Sanitize GET parameter
        $updated = isset($_GET['updated']) ? sanitize_text_field(wp_unslash($_GET['updated'])) : '';
        if ($updated === '1') {
            $success_message = '<div class="notice notice-success is-dismissible"><p>' .
                esc_html__('Role Manager settings updated successfully.', 'magical-addons-for-elementor') .
                '</p></div>';
        }
    ?>
        <div class="wrap magical-role-manager">
            <h1><?php echo esc_html__('Role Manager', 'magical-addons-for-elementor'); ?></h1>

            <div class="magical-role-manager-wrapper">
                <div class="magical-role-manager-content">
                    <form id="magical-role-manager-form" method="post">
                        <?php wp_nonce_field('magical_role_manager_nonce', 'magical_role_manager_nonce'); ?>
                        <div class="magical-tabs">
                            <?php $this->render_role_tabs_navigation(); ?>

                            <?php
                            foreach ($this->user_roles as $role_key => $role_name) :
                                $role_obj = $this->get_role_object($role_key);
                                $this->render_role_tab_content($role_key, $role_name, $role_obj, $mgporv_active);
                            endforeach;
                            ?>
                        </div>

                        <div class="magical-role-submit">
                            <button type="submit" class="button button-primary"><?php echo esc_html__('Save Changes', 'magical-addons-for-elementor'); ?></button>
                            <span class="spinner"></span>
                        </div>
                    </form>

                    <div id="magical-role-manager-message" class="notice hidden"></div>

                    <?php
                    if (!empty($success_message)) {
                        echo wp_kses_post($success_message);
                    }
                    ?>
                </div>

                <?php if (!$mgporv_active) : ?>
                    <div class="magical-role-manager-sidebar">
                        <div class="magical-pro-notice">
                            <p><?php esc_html_e('Unlock advanced Role Manager features with Magical Addons Pro:', 'magical-addons-for-elementor'); ?></p>
                            <ul>
                                <li><?php esc_html_e('• Edit Posts & Pages Management', 'magical-addons-for-elementor'); ?></li>
                                <li><?php esc_html_e('• File Upload Permissions', 'magical-addons-for-elementor'); ?></li>
                                <li><?php esc_html_e('• Advanced Role Controls', 'magical-addons-for-elementor'); ?></li>
                                <li><?php esc_html_e('• WooCommerce Products Management', 'magical-addons-for-elementor'); ?></li>
                                <li><?php esc_html_e('• WooCommerce Reports Access', 'magical-addons-for-elementor'); ?></li>
                                <li><?php esc_html_e('• Product Publishing Controls', 'magical-addons-for-elementor'); ?></li>
                            </ul>
                            <a href="https://magic.wpcolors.net/pricing-plan/#mgpricing" target="_blank" class="magical-upgrade-button">
                                <?php esc_html_e('Upgrade to Pro', 'magical-addons-for-elementor'); ?>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
<?php
    }
}

/**
 * Initialize the Role Manager
 * 
 * Since this file is loaded during the plugins_loaded hook,
 * we need to initialize directly or use a later hook
 */
function magical_initialize_role_manager()
{
    new Magical_Elementor_Role_Manager();
}

// Initialize immediately since file is loaded after plugins_loaded
// Check if we're in admin before initializing
if (is_admin()) {
    magical_initialize_role_manager();
}
