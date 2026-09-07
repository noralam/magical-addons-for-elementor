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

        // Theme Builder: templates list & create.
        register_rest_route( self::NAMESPACE, '/theme-builder/templates', array(
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array( $this, 'get_tb_templates' ),
                'permission_callback' => array( $this, 'permissions_check' ),
            ),
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array( $this, 'create_tb_template' ),
                'permission_callback' => array( $this, 'permissions_check' ),
            ),
        ) );

        // Theme Builder: delete a template.
        register_rest_route( self::NAMESPACE, '/theme-builder/templates/(?P<id>\d+)', array(
            'methods'             => WP_REST_Server::DELETABLE,
            'callback'            => array( $this, 'delete_tb_template' ),
            'permission_callback' => array( $this, 'permissions_check' ),
            'args'                => array(
                'id' => array(
                    'validate_callback' => function ( $param ) {
                        return is_numeric( $param );
                    },
                    'sanitize_callback' => 'absint',
                ),
            ),
        ) );

        // Theme Builder: conditions config tree for the admin UI.
        register_rest_route( self::NAMESPACE, '/theme-builder/conditions', array(
            'methods'             => WP_REST_Server::READABLE,
            'callback'            => array( $this, 'get_tb_conditions_config' ),
            'permission_callback' => array( $this, 'permissions_check' ),
        ) );

        // Theme Builder: save a template's conditions.
        register_rest_route( self::NAMESPACE, '/theme-builder/templates/(?P<id>\d+)/conditions', array(
            'methods'             => WP_REST_Server::CREATABLE,
            'callback'            => array( $this, 'save_tb_conditions' ),
            'permission_callback' => array( $this, 'permissions_check' ),
            'args'                => array(
                'id' => array(
                    'validate_callback' => function ( $param ) {
                        return is_numeric( $param );
                    },
                    'sanitize_callback' => 'absint',
                ),
            ),
        ) );

        // Theme Builder: status (dependency banner data).
        register_rest_route( self::NAMESPACE, '/theme-builder/status', array(
            'methods'             => WP_REST_Server::READABLE,
            'callback'            => array( $this, 'get_tb_status' ),
            'permission_callback' => array( $this, 'permissions_check' ),
        ) );

        // Theme Builder: starter layouts for a template type.
        register_rest_route( self::NAMESPACE, '/theme-builder/layouts/(?P<type>[a-z0-9\-]+)', array(
            'methods'             => WP_REST_Server::READABLE,
            'callback'            => array( $this, 'get_tb_layouts' ),
            'permission_callback' => array( $this, 'permissions_check' ),
        ) );

        // Theme Builder: settings (per-type enable toggles).
        register_rest_route( self::NAMESPACE, '/theme-builder/settings', array(
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array( $this, 'get_tb_settings' ),
                'permission_callback' => array( $this, 'permissions_check' ),
            ),
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array( $this, 'save_tb_settings' ),
                'permission_callback' => array( $this, 'permissions_check' ),
            ),
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

        $extra = get_option( 'magical_extra', array() );
        $extra = wp_parse_args( $extra, $defaults->get_extra_defaults() );

        $role_manager = get_option( 'magical_role_manager', array() );

        return rest_ensure_response( array(
            'widgets'      => $widgets,
            'proWidgets'   => $pro_widgets,
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

        // Save pro widgets (requires active pro license)
        if ( isset( $params['proWidgets'] ) && is_array( $params['proWidgets'] ) ) {
            if ( get_option( 'mgporv_active', false ) ) {
                $pro_widgets = $this->sanitize_widget_settings( $params['proWidgets'] );
                update_option( 'magical_addons_pro', $pro_widgets );
            }
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
            if ( get_option( 'mgporv_active', false ) ) {
                $pro_widgets = $this->sanitize_widget_settings( $params['proWidgets'] );
                update_option( 'magical_addons_pro', $pro_widgets );
            }
        }

        return rest_ensure_response( array(
            'success' => true,
            'message' => __( 'Widget settings saved.', 'magical-addons-for-elementor' ),
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

    /**
     * Whether the Theme Builder module is loaded.
     *
     * @return bool
     */
    private function tb_ready() {
        return function_exists( 'mg_tb' ) && class_exists( 'MgTB' );
    }

    /**
     * Get all Theme Builder templates.
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
    public function get_tb_templates( $request ) {
        $templates = array();

        if ( ! did_action( 'elementor/loaded' ) || ! $this->tb_ready() ) {
            return rest_ensure_response( $templates );
        }

        $types = MgTB::get_document_types();

        $posts = get_posts( array(
            'post_type'      => 'elementor_library',
            'posts_per_page' => -1,
            'post_status'    => array( 'publish', 'draft' ),
            'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
                array(
                    'key'     => '_elementor_template_type',
                    'value'   => array_keys( $types ),
                    'compare' => 'IN',
                ),
            ),
        ) );

        $config = MgTB::get_types_config();
        $conditions_manager = mg_tb()->conditions;

        foreach ( $posts as $post ) {
            $type = get_post_meta( $post->ID, '_elementor_template_type', true );
            if ( ! isset( $config[ $type ] ) ) {
                continue;
            }

            $conditions = get_post_meta( $post->ID, '_elementor_conditions', true );
            $conditions = is_array( $conditions ) ? array_values( $conditions ) : array();

            $instances = array();
            foreach ( $conditions as $condition ) {
                $instances[] = $conditions_manager->get_condition_label( $condition );
            }

            $document   = \Elementor\Plugin::instance()->documents->get( $post->ID );
            $preview_url = home_url( '/' );

            $templates[] = array(
                'id'          => (int) $post->ID,
                'title'       => $post->post_title,
                'type'        => $type,
                'typeLabel'   => $config[ $type ]['label'],
                'status'      => $post->post_status,
                'conditions'  => $conditions,
                'instances'   => $instances,
                'layout'      => get_post_meta( $post->ID, '_mgtb_layout', true ),
                'pageTemplate' => get_post_meta( $post->ID, '_wp_page_template', true ),
                'editUrl'     => admin_url( 'post.php?post=' . $post->ID . '&action=elementor' ),
                'previewUrl'  => $document ? mg_tb()->preview->get_preview_url( $document ) : $preview_url,
                'date'        => get_the_date( 'Y-m-d', $post ),
            );
        }

        return rest_ensure_response( $templates );
    }

    /**
     * Create a new Theme Builder template.
     *
     * Accepts title, type, an optional starter layout id and an optional
     * Elementor page template (canvas / full width / theme default).
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response|WP_Error
     */
    public function create_tb_template( $request ) {
        $params = $request->get_json_params();

        $title = isset( $params['title'] ) ? sanitize_text_field( $params['title'] ) : '';
        $type  = isset( $params['type'] ) ? sanitize_key( $params['type'] ) : '';
        $layout = isset( $params['layout'] ) ? sanitize_text_field( $params['layout'] ) : 'custom';
        $page_template = isset( $params['pageTemplate'] ) ? sanitize_text_field( $params['pageTemplate'] ) : '';

        if ( empty( $title ) ) {
            return new WP_Error(
                'invalid_title',
                __( 'Template title is required.', 'magical-addons-for-elementor' ),
                array( 'status' => 400 )
            );
        }

        $config = $this->tb_ready() ? MgTB::get_types_config() : array();
        if ( ! isset( $config[ $type ] ) ) {
            return new WP_Error(
                'invalid_type',
                __( 'Invalid template type.', 'magical-addons-for-elementor' ),
                array( 'status' => 400 )
            );
        }

        if ( ! did_action( 'elementor/loaded' ) ) {
            return new WP_Error(
                'elementor_not_loaded',
                __( 'Elementor is not active.', 'magical-addons-for-elementor' ),
                array( 'status' => 500 )
            );
        }

        // Free version limit: only 1 template allowed per template type.
        if ( ! MgTB::is_pro() ) {
            $existing_templates = get_posts( array(
                'post_type'      => 'elementor_library',
                'posts_per_page' => 1,
                'post_status'    => array( 'publish', 'draft' ),
                'fields'         => 'ids',
                'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
                    array(
                        'key'     => '_elementor_template_type',
                        'value'   => $type,
                        'compare' => '=',
                    ),
                ),
            ) );

            if ( ! empty( $existing_templates ) ) {
                return new WP_Error(
                    'pro_required',
                    sprintf(
                        /* translators: %s: template type label */
                        __( 'You can only create 1 %s template in the free version. Upgrade to Pro for unlimited templates.', 'magical-addons-for-elementor' ),
                        $config[ $type ]['label']
                    ),
                    array( 'status' => 403 )
                );
            }
        }

        // Page template: canvas / full width / theme default.
        $valid_templates = array( 'elementor_canvas', 'elementor_header_footer', 'elementor_theme' );
        if ( '' === $page_template || 'default' === $page_template ) {
            $page_template = 'elementor_theme';
        }
        if ( ! in_array( $page_template, $valid_templates, true ) ) {
            $page_template = MgTB::get_default_page_template( $type );
        }

        // Layout must belong to the requested type.
        if ( 'custom' !== $layout ) {
            $layout_def = MgTB_Layouts::get_layout( $layout );
            if ( ! $layout_def || $layout_def['type'] !== $type ) {
                $layout = 'custom';
            }
        }

        $post_id = wp_insert_post( array(
            'post_title'  => $title,
            'post_type'   => 'elementor_library',
            'post_status' => 'publish',
        ) );

        if ( is_wp_error( $post_id ) ) {
            return $post_id;
        }

        update_post_meta( $post_id, '_elementor_template_type', $type );
        update_post_meta( $post_id, '_elementor_conditions', array( $config[ $type ]['condition'] ) );
        update_post_meta( $post_id, '_wp_page_template', $page_template );
        update_post_meta( $post_id, '_elementor_edit_mode', 'builder' );

        if ( 'custom' !== $layout ) {
            MgTB_Layouts::import( $post_id, $layout );
        }

        if ( $this->tb_ready() ) {
            mg_tb()->cache->purge();
        }

        return rest_ensure_response( array(
            'id'        => (int) $post_id,
            'title'     => $title,
            'type'      => $type,
            'typeLabel' => $config[ $type ]['label'],
            'layout'    => $layout,
            'status'    => 'publish',
            'editUrl'   => admin_url( 'post.php?post=' . $post_id . '&action=elementor' ),
        ) );
    }

    /**
     * Starter layouts for a template type ("Custom Layout" first).
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
    public function get_tb_layouts( $request ) {
        if ( ! $this->tb_ready() ) {
            return rest_ensure_response( array() );
        }

        $type = sanitize_key( $request->get_param( 'type' ) );
        $config = MgTB::get_types_config();

        if ( ! isset( $config[ $type ] ) ) {
            return new WP_Error(
                'invalid_type',
                __( 'Invalid template type.', 'magical-addons-for-elementor' ),
                array( 'status' => 400 )
            );
        }

        return rest_ensure_response( MgTB_Layouts::get_by_type( $type ) );
    }

    /**
     * Theme Builder settings (per-type enable toggles).
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
    public function get_tb_settings( $request ) {
        if ( ! $this->tb_ready() ) {
            return rest_ensure_response( array( 'types' => array() ) );
        }

        return rest_ensure_response( MgTB::get_settings() );
    }

    /**
     * Save Theme Builder settings.
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
    public function save_tb_settings( $request ) {
        if ( ! $this->tb_ready() ) {
            return new WP_Error(
                'module_missing',
                __( 'Theme Builder module is not loaded.', 'magical-addons-for-elementor' ),
                array( 'status' => 500 )
            );
        }

        $params = $request->get_json_params();
        $settings = MgTB::save_settings( is_array( $params ) ? $params : array() );

        return rest_ensure_response( array(
            'success' => true,
            'settings' => $settings,
            'message' => __( 'Settings saved.', 'magical-addons-for-elementor' ),
        ) );
    }

    /**
     * Delete a Theme Builder template.
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response|WP_Error
     */
    public function delete_tb_template( $request ) {
        $id = $request->get_param( 'id' );

        $post = get_post( $id );
        if ( ! $post || 'elementor_library' !== $post->post_type ) {
            return new WP_Error(
                'not_found',
                __( 'Template not found.', 'magical-addons-for-elementor' ),
                array( 'status' => 404 )
            );
        }

        $deleted = wp_delete_post( $id, true );
        if ( ! $deleted ) {
            return new WP_Error(
                'delete_failed',
                __( 'Failed to delete template.', 'magical-addons-for-elementor' ),
                array( 'status' => 500 )
            );
        }

        if ( $this->tb_ready() ) {
            mg_tb()->cache->purge();
        }

        return rest_ensure_response( array(
            'success' => true,
            'message' => __( 'Template deleted.', 'magical-addons-for-elementor' ),
        ) );
    }

    /**
     * Conditions tree configuration for the admin UI.
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
    public function get_tb_conditions_config( $request ) {
        if ( ! $this->tb_ready() ) {
            return rest_ensure_response( array( 'groups' => array() ) );
        }

        $tree   = mg_tb()->conditions->get_tree();
        $groups = array();

        foreach ( $tree as $name => $node ) {
            $subs = array();
			foreach ( $node['subs'] as $sub_name => $sub ) {
				$subs[] = array(
					'name'       => $sub_name,
					'label'      => $sub['label'],
					'supportsId' => isset( $sub['supports_id'] ) ? $sub['supports_id'] : '',
				);
			}

            $groups[] = array(
                'name'  => $name,
                'label' => $node['label'],
                'subs'  => $subs,
            );
        }

        return rest_ensure_response( array(
            'groups'    => $groups,
            'conflicts' => mg_tb()->conditions->get_conflicts(),
        ) );
    }

    /**
     * Save the display conditions of a template.
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response|WP_Error
     */
    public function save_tb_conditions( $request ) {
        if ( ! $this->tb_ready() ) {
            return new WP_Error(
                'module_missing',
                __( 'Theme Builder module is not loaded.', 'magical-addons-for-elementor' ),
                array( 'status' => 500 )
            );
        }

        // Custom display conditions require Pro.
        if ( ! MgTB::is_pro() ) {
            return new WP_Error(
                'pro_required',
                __( 'Custom display conditions are available in Magical Addons Pro.', 'magical-addons-for-elementor' ),
                array( 'status' => 403 )
            );
        }

        $id = absint( $request->get_param( 'id' ) );
        $post = get_post( $id );

        if ( ! $post || 'elementor_library' !== $post->post_type ) {
            return new WP_Error(
                'not_found',
                __( 'Template not found.', 'magical-addons-for-elementor' ),
                array( 'status' => 404 )
            );
        }

        $params     = $request->get_json_params();
        $conditions = isset( $params['conditions'] ) && is_array( $params['conditions'] ) ? $params['conditions'] : array();

        // Accept raw strings ("include/singular/post/12") or row objects from the UI.
        $clean = array();
        foreach ( $conditions as $condition ) {
            if ( is_array( $condition ) ) {
                $type     = ( isset( $condition['type'] ) && 'exclude' === $condition['type'] ) ? 'exclude' : 'include';
                $name     = isset( $condition['name'] ) ? sanitize_key( $condition['name'] ) : '';
                $sub_name = isset( $condition['subName'] ) ? sanitize_key( $condition['subName'] ) : '';
                $sub_id   = isset( $condition['subId'] ) ? absint( $condition['subId'] ) : 0;

                if ( '' === $name ) {
                    continue;
                }

                $string = $type . '/' . $name;
                if ( $sub_name ) {
                    $string .= '/' . $sub_name;
                    if ( $sub_id ) {
                        $string .= '/' . $sub_id;
                    }
                }
                $clean[] = $string;
           	} elseif ( is_string( $condition ) ) {
                $condition = sanitize_text_field( $condition );
                if ( preg_match( '/^(include|exclude)\/[a-z0-9_\-]+(\/[a-z0-9_\-]+)?(\/\d+)?$/i', $condition ) ) {
                    $clean[] = $condition;
                }
            }
        }

        if ( empty( $clean ) ) {
            delete_post_meta( $id, '_elementor_conditions' );
        } else {
            update_post_meta( $id, '_elementor_conditions', array_values( array_unique( $clean ) ) );
        }

        mg_tb()->cache->purge();

        $instances = array();
        foreach ( $clean as $condition ) {
            $instances[] = mg_tb()->conditions->get_condition_label( $condition );
        }

        return rest_ensure_response( array(
            'success'    => true,
            'conditions' => array_values( array_unique( $clean ) ),
            'instances'  => $instances,
            'conflicts'  => mg_tb()->conditions->get_conflicts(),
            'message'    => __( 'Display conditions saved.', 'magical-addons-for-elementor' ),
        ) );
    }

    /**
     * Theme Builder status for the admin UI banner.
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
    public function get_tb_status( $request ) {
        $status = array(
            'elementorActive'  => did_action( 'elementor/loaded' ) > 0,
            'elementorProTB'   => $this->tb_ready() && MgTB::is_elementor_pro_tb(),
            'postsDisplay'     => $this->tb_ready() ? MgTB_Dependency::posts_display_status() : 'not-installed',
            'types'            => $this->tb_ready() ? MgTB::get_types_config() : array(),
            'counts'           => array(),
            'settings'         => $this->tb_ready() ? MgTB::get_settings() : array( 'types' => array() ),
            'isPro'            => $this->tb_ready() ? MgTB::is_pro() : false,
            'proUrl'           => 'https://wpthemespace.com/product/magical-addons-pro/',
        );

        if ( $status['elementorActive'] && $this->tb_ready() ) {
            $counts = array_fill_keys( array_keys( MgTB::get_document_types() ), 0 );
            $posts  = get_posts( array(
                'post_type'      => 'elementor_library',
                'posts_per_page' => -1,
                'post_status'    => array( 'publish', 'draft' ),
                'fields'         => 'ids',
                'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
                    array(
                        'key'     => '_elementor_template_type',
                        'value'   => array_keys( MgTB::get_document_types() ),
                        'compare' => 'IN',
                    ),
                ),
            ) );

            foreach ( $posts as $post_id ) {
                $type = get_post_meta( $post_id, '_elementor_template_type', true );
                if ( isset( $counts[ $type ] ) ) {
                    $counts[ $type ]++;
                }
            }

            $status['counts'] = $counts;
        }

        return rest_ensure_response( $status );
    }
}
