<?php
/**
 * REST API Controller for Magical Addons Admin
 *
 * @package MagicalAddons
 * @since 1.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Magical_Addons_REST_API
 * 
 * Handles all REST API endpoints for the React admin panel
 */
class Magical_Addons_REST_API {

    /**
     * API namespace
     *
     * @var string
     */
    const NAMESPACE = 'magical-addons/v1';

    /**
     * Settings defaults instance
     *
     * @var Magical_Addons_Settings_Defaults
     */
    private $defaults;

    /**
     * Constructor
     */
    public function __construct() {
        add_action( 'rest_api_init', array( $this, 'register_routes' ) );
    }

    /**
     * Set defaults instance
     *
     * @param Magical_Addons_Settings_Defaults $defaults
     */
    public function set_defaults( $defaults ) {
        $this->defaults = $defaults;
    }

    /**
     * Register REST API routes
     */
    public function register_routes() {
        // Settings endpoints
        register_rest_route( self::NAMESPACE, '/settings', array(
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array( $this, 'get_settings' ),
                'permission_callback' => array( $this, 'permissions_check' ),
            ),
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array( $this, 'save_settings' ),
                'permission_callback' => array( $this, 'permissions_check' ),
            ),
        ) );

        // Widgets endpoints
        register_rest_route( self::NAMESPACE, '/widgets', array(
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array( $this, 'get_widgets' ),
                'permission_callback' => array( $this, 'permissions_check' ),
            ),
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array( $this, 'save_widgets' ),
                'permission_callback' => array( $this, 'permissions_check' ),
            ),
        ) );

        // Templates endpoint
        register_rest_route( self::NAMESPACE, '/templates', array(
            'methods'             => WP_REST_Server::READABLE,
            'callback'            => array( $this, 'get_templates' ),
            'permission_callback' => array( $this, 'permissions_check' ),
        ) );

        // Role manager endpoints
        register_rest_route( self::NAMESPACE, '/role-manager', array(
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array( $this, 'get_role_manager' ),
                'permission_callback' => array( $this, 'permissions_check' ),
            ),
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array( $this, 'save_role_manager' ),
                'permission_callback' => array( $this, 'permissions_check' ),
            ),
        ) );

        // Plugin status endpoint
        register_rest_route( self::NAMESPACE, '/plugins-status', array(
            'methods'             => WP_REST_Server::CREATABLE,
            'callback'            => array( $this, 'get_plugins_status' ),
            'permission_callback' => array( $this, 'permissions_check' ),
        ) );

        // Install plugin endpoint
        register_rest_route( self::NAMESPACE, '/install-plugin', array(
            'methods'             => WP_REST_Server::CREATABLE,
            'callback'            => array( $this, 'install_plugin' ),
            'permission_callback' => array( $this, 'install_plugins_check' ),
        ) );

        // Activate plugin endpoint
        register_rest_route( self::NAMESPACE, '/activate-plugin', array(
            'methods'             => WP_REST_Server::CREATABLE,
            'callback'            => array( $this, 'activate_plugin' ),
            'permission_callback' => array( $this, 'activate_plugins_check' ),
        ) );
    }

    /**
     * Check if user has permission to access endpoints
     *
     * @return bool|WP_Error
     */
    public function permissions_check() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return new WP_Error(
                'rest_forbidden',
                __( 'You do not have permission to access this resource.', 'magical-addons-for-elementor' ),
                array( 'status' => 403 )
            );
        }
        return true;
    }

    /**
     * Get all settings
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
    public function get_settings( $request ) {
        $defaults = $this->get_defaults_instance();

        $widgets = get_option( 'magical_addons', array() );
        $widgets = wp_parse_args( $widgets, $defaults->get_widget_defaults() );

        $pro_widgets = get_option( 'magical_addons_pro', array() );
        $pro_widgets = wp_parse_args( $pro_widgets, $defaults->get_pro_widget_defaults() );

        $header_footer = get_option( 'magical_headerfooter', array() );
        $header_footer = wp_parse_args( $header_footer, $defaults->get_header_footer_defaults() );

        $extra = get_option( 'magical_extra', array() );
        $extra = wp_parse_args( $extra, $defaults->get_extra_defaults() );

        $role_manager = get_option( 'magical_role_manager', array() );

        return rest_ensure_response( array(
            'widgets'      => $widgets,
            'proWidgets'   => $pro_widgets,
            'headerFooter' => $header_footer,
            'extra'        => $extra,
            'roleManager'  => $role_manager,
        ) );
    }

    /**
     * Save all settings
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response|WP_Error
     */
    public function save_settings( $request ) {
        $params = $request->get_json_params();

        // Save widgets
        if ( isset( $params['widgets'] ) && is_array( $params['widgets'] ) ) {
            $widgets = $this->sanitize_widget_settings( $params['widgets'] );
            update_option( 'magical_addons', $widgets );
        }

        // Save pro widgets
        if ( isset( $params['proWidgets'] ) && is_array( $params['proWidgets'] ) ) {
            $pro_widgets = $this->sanitize_widget_settings( $params['proWidgets'] );
            update_option( 'magical_addons_pro', $pro_widgets );
        }

        // Save header/footer settings
        if ( isset( $params['headerFooter'] ) && is_array( $params['headerFooter'] ) ) {
            $header_footer = $this->sanitize_header_footer_settings( $params['headerFooter'] );
            update_option( 'magical_headerfooter', $header_footer );
        }

        // Save extra settings
        if ( isset( $params['extra'] ) && is_array( $params['extra'] ) ) {
            $extra = $this->sanitize_extra_settings( $params['extra'] );
            update_option( 'magical_extra', $extra );
        }

        return rest_ensure_response( array(
            'success' => true,
            'message' => __( 'Settings saved successfully.', 'magical-addons-for-elementor' ),
        ) );
    }

    /**
     * Get widgets settings
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
    public function get_widgets( $request ) {
        $defaults = $this->get_defaults_instance();

        $widgets = get_option( 'magical_addons', array() );
        $widgets = wp_parse_args( $widgets, $defaults->get_widget_defaults() );

        $pro_widgets = get_option( 'magical_addons_pro', array() );
        $pro_widgets = wp_parse_args( $pro_widgets, $defaults->get_pro_widget_defaults() );

        return rest_ensure_response( array(
            'widgets'    => $widgets,
            'proWidgets' => $pro_widgets,
        ) );
    }

    /**
     * Save widgets settings
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
    public function save_widgets( $request ) {
        $params = $request->get_json_params();

        if ( isset( $params['widgets'] ) && is_array( $params['widgets'] ) ) {
            $widgets = $this->sanitize_widget_settings( $params['widgets'] );
            update_option( 'magical_addons', $widgets );
        }

        if ( isset( $params['proWidgets'] ) && is_array( $params['proWidgets'] ) ) {
            $pro_widgets = $this->sanitize_widget_settings( $params['proWidgets'] );
            update_option( 'magical_addons_pro', $pro_widgets );
        }

        return rest_ensure_response( array(
            'success' => true,
            'message' => __( 'Widget settings saved.', 'magical-addons-for-elementor' ),
        ) );
    }

    /**
     * Get Elementor templates for header/footer
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
    public function get_templates( $request ) {
        $headers = array();
        $footers = array();

        // Check if Elementor is active
        if ( did_action( 'elementor/loaded' ) ) {
            $templates = get_posts( array(
                'post_type'      => 'elementor_library',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'meta_query'     => array(
                    array(
                        'key'     => '_elementor_template_type',
                        'value'   => array( 'header', 'footer', 'section' ),
                        'compare' => 'IN',
                    ),
                ),
            ) );

            foreach ( $templates as $template ) {
                $type = get_post_meta( $template->ID, '_elementor_template_type', true );
                $item = array(
                    'id'    => $template->ID,
                    'title' => $template->post_title,
                );

                if ( $type === 'header' || $type === 'section' ) {
                    $headers[] = $item;
                }
                if ( $type === 'footer' || $type === 'section' ) {
                    $footers[] = $item;
                }
            }
        }

        return rest_ensure_response( array(
            'headers' => $headers,
            'footers' => $footers,
        ) );
    }

    /**
     * Get role manager settings
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
    public function get_role_manager( $request ) {
        $role_manager = get_option( 'magical_role_manager', array() );
        $roles = $this->get_editable_roles();

        return rest_ensure_response( array(
            'roleManager' => $role_manager,
            'roles'       => $roles,
        ) );
    }

    /**
     * Save role manager settings
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
    public function save_role_manager( $request ) {
        $params = $request->get_json_params();

        if ( isset( $params['roleManager'] ) && is_array( $params['roleManager'] ) ) {
            $role_manager = $this->sanitize_role_manager_settings( $params['roleManager'] );
            update_option( 'magical_role_manager', $role_manager );
        }

        return rest_ensure_response( array(
            'success' => true,
            'message' => __( 'Role manager settings saved.', 'magical-addons-for-elementor' ),
        ) );
    }

    /**
     * Get editable roles
     *
     * @return array
     */
    private function get_editable_roles() {
        $wp_roles = wp_roles();
        $roles = array();

        foreach ( $wp_roles->roles as $role_key => $role ) {
            $roles[ $role_key ] = translate_user_role( $role['name'] );
        }

        return $roles;
    }

    /**
     * Get defaults instance
     *
     * @return Magical_Addons_Settings_Defaults
     */
    private function get_defaults_instance() {
        if ( ! $this->defaults ) {
            if ( class_exists( 'Magical_Addons_Settings_Defaults' ) ) {
                $this->defaults = new Magical_Addons_Settings_Defaults();
            }
        }
        return $this->defaults;
    }

    /**
     * Sanitize widget settings
     *
     * @param array $settings
     * @return array
     */
    private function sanitize_widget_settings( $settings ) {
        $sanitized = array();
        foreach ( $settings as $key => $value ) {
            $key = sanitize_key( $key );
            $sanitized[ $key ] = in_array( $value, array( 'on', 'off' ), true ) ? $value : 'on';
        }
        return $sanitized;
    }

    /**
     * Sanitize header/footer settings
     *
     * @param array $settings
     * @return array
     */
    private function sanitize_header_footer_settings( $settings ) {
        $sanitized = array();
        
        if ( isset( $settings['mg_header_template'] ) ) {
            $sanitized['mg_header_template'] = absint( $settings['mg_header_template'] );
        }
        
        if ( isset( $settings['mg_footer_template'] ) ) {
            $sanitized['mg_footer_template'] = absint( $settings['mg_footer_template'] );
        }

        return $sanitized;
    }

    /**
     * Sanitize extra settings
     *
     * @param array $settings
     * @return array
     */
    private function sanitize_extra_settings( $settings ) {
        $sanitized = array();
        
        if ( isset( $settings['mg_mailchimp_api'] ) ) {
            $sanitized['mg_mailchimp_api'] = sanitize_text_field( $settings['mg_mailchimp_api'] );
        }

        return $sanitized;
    }

    /**
     * Sanitize role manager settings
     *
     * @param array $settings
     * @return array
     */
    private function sanitize_role_manager_settings( $settings ) {
        $sanitized = array();
        $valid_roles = array_keys( $this->get_editable_roles() );

        foreach ( $settings as $role => $features ) {
            $role = sanitize_key( $role );
            if ( ! in_array( $role, $valid_roles, true ) ) {
                continue;
            }

            $sanitized[ $role ] = array();
            if ( is_array( $features ) ) {
                foreach ( $features as $feature => $enabled ) {
                    $feature = sanitize_key( $feature );
                    $sanitized[ $role ][ $feature ] = (bool) $enabled;
                }
            }
        }

        return $sanitized;
    }

    /**
     * Check if user can install plugins
     *
     * @return bool|WP_Error
     */
    public function install_plugins_check() {
        if ( ! current_user_can( 'install_plugins' ) ) {
            return new WP_Error(
                'rest_forbidden',
                __( 'You do not have permission to install plugins.', 'magical-addons-for-elementor' ),
                array( 'status' => 403 )
            );
        }
        return true;
    }

    /**
     * Check if user can activate plugins
     *
     * @return bool|WP_Error
     */
    public function activate_plugins_check() {
        if ( ! current_user_can( 'activate_plugins' ) ) {
            return new WP_Error(
                'rest_forbidden',
                __( 'You do not have permission to activate plugins.', 'magical-addons-for-elementor' ),
                array( 'status' => 403 )
            );
        }
        return true;
    }

    /**
     * Get plugins status
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
    public function get_plugins_status( $request ) {
        $plugins = $request->get_param( 'plugins' );
        
        if ( ! is_array( $plugins ) ) {
            return new WP_Error(
                'invalid_params',
                __( 'Invalid plugins parameter.', 'magical-addons-for-elementor' ),
                array( 'status' => 400 )
            );
        }

        // Get all installed plugins
        if ( ! function_exists( 'get_plugins' ) ) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        
        $installed_plugins = get_plugins();
        $statuses = array();

        foreach ( $plugins as $slug ) {
            $slug = sanitize_file_name( $slug );
            $plugin_file = $this->get_plugin_file_from_slug( $slug, $installed_plugins );
            
            if ( $plugin_file ) {
                if ( is_plugin_active( $plugin_file ) ) {
                    $statuses[ $slug ] = 'active';
                } else {
                    $statuses[ $slug ] = 'installed';
                }
            } else {
                $statuses[ $slug ] = 'not-installed';
            }
        }

        return rest_ensure_response( array(
            'success'  => true,
            'statuses' => $statuses,
        ) );
    }

    /**
     * Install a plugin from WordPress.org
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
    public function install_plugin( $request ) {
        $slug = sanitize_file_name( $request->get_param( 'slug' ) );
        
        if ( empty( $slug ) ) {
            return new WP_Error(
                'invalid_slug',
                __( 'Invalid plugin slug.', 'magical-addons-for-elementor' ),
                array( 'status' => 400 )
            );
        }

        // Check if already installed
        if ( ! function_exists( 'get_plugins' ) ) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        
        $installed_plugins = get_plugins();
        $plugin_file = $this->get_plugin_file_from_slug( $slug, $installed_plugins );
        
        if ( $plugin_file ) {
            return rest_ensure_response( array(
                'success' => true,
                'message' => __( 'Plugin is already installed.', 'magical-addons-for-elementor' ),
            ) );
        }

        // Include required files for installation
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/misc.php';
        require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        require_once ABSPATH . 'wp-admin/includes/plugin-install.php';

        // Get plugin info from WordPress.org
        $api = plugins_api( 'plugin_information', array(
            'slug'   => $slug,
            'fields' => array(
                'short_description' => false,
                'sections'          => false,
                'requires'          => false,
                'rating'            => false,
                'ratings'           => false,
                'downloaded'        => false,
                'last_updated'      => false,
                'added'             => false,
                'tags'              => false,
                'compatibility'     => false,
                'homepage'          => false,
                'donate_link'       => false,
            ),
        ) );

        if ( is_wp_error( $api ) ) {
            return new WP_Error(
                'plugin_not_found',
                __( 'Plugin not found on WordPress.org.', 'magical-addons-for-elementor' ),
                array( 'status' => 404 )
            );
        }

        // Install the plugin using quiet skin to avoid output
        $skin = new Automatic_Upgrader_Skin();
        $upgrader = new Plugin_Upgrader( $skin );
        $result = $upgrader->install( $api->download_link );

        if ( is_wp_error( $result ) ) {
            return new WP_Error(
                'install_failed',
                $result->get_error_message(),
                array( 'status' => 500 )
            );
        }

        if ( ! $result ) {
            return new WP_Error(
                'install_failed',
                __( 'Plugin installation failed.', 'magical-addons-for-elementor' ),
                array( 'status' => 500 )
            );
        }

        // Auto-activate if requested
        $activate = $request->get_param( 'activate' );
        if ( $activate ) {
            // Refresh installed plugins list
            $installed_plugins = get_plugins();
            $plugin_file = $this->get_plugin_file_from_slug( $slug, $installed_plugins );
            
            if ( $plugin_file ) {
                $activation_result = activate_plugin( $plugin_file );
                
                if ( is_wp_error( $activation_result ) ) {
                    return rest_ensure_response( array(
                        'success' => true,
                        'message' => __( 'Plugin installed but activation failed.', 'magical-addons-for-elementor' ),
                        'activated' => false,
                    ) );
                }
                
                return rest_ensure_response( array(
                    'success' => true,
                    'message' => __( 'Plugin installed and activated successfully.', 'magical-addons-for-elementor' ),
                    'activated' => true,
                ) );
            }
        }

        return rest_ensure_response( array(
            'success' => true,
            'message' => __( 'Plugin installed successfully.', 'magical-addons-for-elementor' ),
        ) );
    }

    /**
     * Activate a plugin
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
    public function activate_plugin( $request ) {
        $slug = sanitize_file_name( $request->get_param( 'slug' ) );
        
        if ( empty( $slug ) ) {
            return new WP_Error(
                'invalid_slug',
                __( 'Invalid plugin slug.', 'magical-addons-for-elementor' ),
                array( 'status' => 400 )
            );
        }

        if ( ! function_exists( 'get_plugins' ) ) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        
        $installed_plugins = get_plugins();
        $plugin_file = $this->get_plugin_file_from_slug( $slug, $installed_plugins );
        
        if ( ! $plugin_file ) {
            return new WP_Error(
                'plugin_not_installed',
                __( 'Plugin is not installed.', 'magical-addons-for-elementor' ),
                array( 'status' => 400 )
            );
        }

        if ( is_plugin_active( $plugin_file ) ) {
            return rest_ensure_response( array(
                'success' => true,
                'message' => __( 'Plugin is already active.', 'magical-addons-for-elementor' ),
            ) );
        }

        $result = activate_plugin( $plugin_file );

        if ( is_wp_error( $result ) ) {
            return new WP_Error(
                'activation_failed',
                $result->get_error_message(),
                array( 'status' => 500 )
            );
        }

        return rest_ensure_response( array(
            'success' => true,
            'message' => __( 'Plugin activated successfully.', 'magical-addons-for-elementor' ),
        ) );
    }

    /**
     * Get plugin file from slug
     *
     * @param string $slug Plugin slug
     * @param array $installed_plugins List of installed plugins
     * @return string|false Plugin file path or false if not found
     */
    private function get_plugin_file_from_slug( $slug, $installed_plugins ) {
        foreach ( $installed_plugins as $plugin_file => $plugin_data ) {
            // Check if the plugin directory matches the slug
            $plugin_dir = dirname( $plugin_file );
            if ( $plugin_dir === $slug || $plugin_file === $slug . '.php' ) {
                return $plugin_file;
            }
        }
        return false;
    }
}
