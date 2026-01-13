<?php

/**
 * Magical Addons Conditional Display
 * 
 * Adds conditional display functionality to Elementor widgets
 */

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

class Magical_Conditional_Display_field
{
    /**
     * Instance of the class
     * @var Magical_Conditional_Display
     */
    private static $instance = null;

    /**
     * Get instance of the class
     */
    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    /**
     * Class constructor
     */
    public function __construct()
    {
        // Add conditional controls to all widget types
        add_action('elementor/element/common/_section_style/after_section_end', [$this, 'register_controls']);

        // Add to sections and columns
        add_action('elementor/element/section/section_advanced/after_section_end', [$this, 'register_controls']);
        add_action('elementor/element/column/section_advanced/after_section_end', [$this, 'register_controls']);
    }

    /**
     * Register controls for conditional display
     */
    public function register_controls($element)
    {
        // Check if pro version is active
        $mgporv_active = get_option('mgporv_active', false);

        $element->start_controls_section(
            'mg_section_conditional_display',
            [
                'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
                'label' => __('Magical Conditional Display', 'magical-addons-for-elementor'),
            ]
        );

        $element->add_control(
            'mg_conditional_display_enable',
            [
                'label' => __('Enable Conditional Display', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'separator' => 'before',
            ]
        );

        $element->add_control(
            'mg_conditional_display_notice',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => __('Note: Conditions are applied on the frontend only.', 'magical-addons-for-elementor'),
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                'condition' => [
                    'mg_conditional_display_enable' => 'yes',
                ],
            ]
        );

        // Free version options
        $free_options = [
            'user_logged_in' => __('User is logged in', 'magical-addons-for-elementor'),
            'user_logged_out' => __('User is logged out', 'magical-addons-for-elementor'),
            'device_type' => __('Device type is', 'magical-addons-for-elementor'),
        ];

        // Pro version options
        $pro_options = [
            'user_role' => __('User has specific role', 'magical-addons-for-elementor') . ' <i class="eicon-lock"></i>',
            'day_of_week' => __('Day of week is', 'magical-addons-for-elementor') . ' <i class="eicon-lock"></i>',
            'time_of_day' => __('Time is between', 'magical-addons-for-elementor') . ' <i class="eicon-lock"></i>',
            'date_range' => __('Date is between', 'magical-addons-for-elementor') . ' <i class="eicon-lock"></i>',
            'recurring_schedule' => __('Recurring schedule', 'magical-addons-for-elementor') . ' <i class="eicon-lock"></i>',
            'post_type' => __('Current post type is', 'magical-addons-for-elementor') . ' <i class="eicon-lock"></i>',
            'browser_type' => __('Browser is', 'magical-addons-for-elementor') . ' <i class="eicon-lock"></i>',
            'url_parameter' => __('URL parameter exists', 'magical-addons-for-elementor') . ' <i class="eicon-lock"></i>',
            'referrer_source' => __('Visitor came from', 'magical-addons-for-elementor') . ' <i class="eicon-lock"></i>',
        ];

        // Combine options based on pro status
        $all_options = $free_options;
        if ($mgporv_active) {
            $all_options = array_merge($free_options, array_map(function ($option) {
                // Remove lock icon for pro users
                return str_replace(' <i class="eicon-lock"></i>', '', $option);
            }, $pro_options));
        } else {
            $all_options = array_merge($free_options, $pro_options);
        }

        $element->add_control(
            'mg_conditional_display_condition',
            [
                'label' => __('Display When', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'user_logged_in',
                'options' => $all_options,
                'condition' => [
                    'mg_conditional_display_enable' => 'yes',
                ],
            ]
        );

        // Add pro version notice if not active
        // Add reference to the CSS file instead of inline styles
        if (!$mgporv_active) {
            $element->add_control(
                'mg_conditional_pro_notice',
                [
                    'type' => \Elementor\Controls_Manager::RAW_HTML,
                    'raw' => '<div style="text-align:center;padding:10px;background-color:#f7f7f7;border-left:3px solid #ed4b82;">
                                <p style="margin-bottom:5px;"><strong>' . __('This is a PRO feature', 'magical-addons-for-elementor') . '</strong></p>
                                <p>' . __('Upgrade to Magical Addons PRO version to unlock all conditional display options', 'magical-addons-for-elementor') . '</p>
                                <a href="https://wpthemespace.com/product/magical-addons-pro/" target="_blank" class="elementor-button elementor-button-success" style="margin-top:10px;">
                                    ' . __('Upgrade to PRO', 'magical-addons-for-elementor') . '
                                </a>
                            </div>',
                    'content_classes' => 'mg-pro-notice',
                    'condition' => [
                        'mg_conditional_display_enable' => 'yes',
                        'mg_conditional_display_condition' => array_keys($pro_options),
                    ],
                ]
            );
        }

        // User Role condition
        $element->add_control(
            'mg_conditional_user_role',
            [
                'label' => __('Select Role', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => $this->get_user_roles(),
                'multiple' => true,
                'condition' => [
                    'mg_conditional_display_enable' => 'yes',
                    'mg_conditional_display_condition' => 'user_role',
                ],
                'classes' => !$mgporv_active ? 'mg-pro-control' : '',
            ]
        );

        // Rest of the controls remain the same, just add the 'classes' => !$mgporv_active ? 'mg-pro-control' : '', 
        // to each pro control's condition array

        // Device type condition (free feature)
        $element->add_control(
            'mg_conditional_device_type',
            [
                'label' => __('Select Device', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'mobile',
                'options' => [
                    'desktop' => __('Desktop', 'magical-addons-for-elementor'),
                    'tablet' => __('Tablet', 'magical-addons-for-elementor'),
                    'mobile' => __('Mobile', 'magical-addons-for-elementor'),
                ],
                'condition' => [
                    'mg_conditional_display_enable' => 'yes',
                    'mg_conditional_display_condition' => 'device_type',
                ],
            ]
        );

        // Day of week condition (pro feature)
        $element->add_control(
            'mg_conditional_day_of_week',
            [
                'label' => __('Select Days', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => [
                    '1' => __('Monday', 'magical-addons-for-elementor'),
                    '2' => __('Tuesday', 'magical-addons-for-elementor'),
                    '3' => __('Wednesday', 'magical-addons-for-elementor'),
                    '4' => __('Thursday', 'magical-addons-for-elementor'),
                    '5' => __('Friday', 'magical-addons-for-elementor'),
                    '6' => __('Saturday', 'magical-addons-for-elementor'),
                    '0' => __('Sunday', 'magical-addons-for-elementor'),
                ],
                'multiple' => true,
                'condition' => [
                    'mg_conditional_display_enable' => 'yes',
                    'mg_conditional_display_condition' => 'day_of_week',
                ],
                'classes' => !$mgporv_active ? 'mg-pro-control' : '',
            ]
        );
        // Time of day condition - Improved with DATE_TIME picker
        $element->add_control(
            'mg_conditional_time_start',
            [
                'label' => __('Start Time', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DATE_TIME,
                'default' => '09:00',
                'picker_options' => [
                    'enableTime' => true,
                    'noCalendar' => true,
                    'dateFormat' => 'H:i',
                    'time_24hr' => true,
                ],
                'condition' => [
                    'mg_conditional_display_enable' => 'yes',
                    'mg_conditional_display_condition' => 'time_of_day',
                ],
                'classes' => !$mgporv_active ? 'mg-pro-control' : '',
            ]
        );

        $element->add_control(
            'mg_conditional_time_end',
            [
                'label' => __('End Time', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DATE_TIME,
                'default' => '17:00',
                'picker_options' => [
                    'enableTime' => true,
                    'noCalendar' => true,
                    'dateFormat' => 'H:i',
                    'time_24hr' => true,
                ],
                'condition' => [
                    'mg_conditional_display_enable' => 'yes',
                    'mg_conditional_display_condition' => 'time_of_day',
                ],
                'classes' => !$mgporv_active ? 'mg-pro-control' : '',
            ]
        );

        // Date Range condition
        $element->add_control(
            'mg_conditional_date_start',
            [
                'label' => __('Start Date', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DATE_TIME,
                'default' => gmdate('Y-m-d'),
                'picker_options' => [
                    'enableTime' => false,
                    'dateFormat' => 'Y-m-d',
                ],
                'condition' => [
                    'mg_conditional_display_enable' => 'yes',
                    'mg_conditional_display_condition' => 'date_range',
                ],
                'classes' => !$mgporv_active ? 'mg-pro-control' : '',
            ]
        );

        $element->add_control(
            'mg_conditional_date_end',
            [
                'label' => __('End Date', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DATE_TIME,
                'default' => gmdate('Y-m-d', strtotime('+7 days')),
                'picker_options' => [
                    'enableTime' => false,
                    'dateFormat' => 'Y-m-d',
                ],
                'condition' => [
                    'mg_conditional_display_enable' => 'yes',
                    'mg_conditional_display_condition' => 'date_range',
                ],
                'classes' => !$mgporv_active ? 'mg-pro-control' : '',
            ]
        );

        // Recurring Schedule condition
        $element->add_control(
            'mg_conditional_recurring_days',
            [
                'label' => __('Select Days', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => [
                    '1' => __('Monday', 'magical-addons-for-elementor'),
                    '2' => __('Tuesday', 'magical-addons-for-elementor'),
                    '3' => __('Wednesday', 'magical-addons-for-elementor'),
                    '4' => __('Thursday', 'magical-addons-for-elementor'),
                    '5' => __('Friday', 'magical-addons-for-elementor'),
                    '6' => __('Saturday', 'magical-addons-for-elementor'),
                    '0' => __('Sunday', 'magical-addons-for-elementor'),
                ],
                'multiple' => true,
                'condition' => [
                    'mg_conditional_display_enable' => 'yes',
                    'mg_conditional_display_condition' => 'recurring_schedule',
                ],
                'classes' => !$mgporv_active ? 'mg-pro-control' : '',
            ]
        );

        $element->add_control(
            'mg_conditional_recurring_time_start',
            [
                'label' => __('Start Time', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DATE_TIME,
                'default' => '09:00',
                'picker_options' => [
                    'enableTime' => true,
                    'noCalendar' => true,
                    'dateFormat' => 'H:i',
                    'time_24hr' => true,
                ],
                'condition' => [
                    'mg_conditional_display_enable' => 'yes',
                    'mg_conditional_display_condition' => 'recurring_schedule',
                ],
                'classes' => !$mgporv_active ? 'mg-pro-control' : '',
            ]
        );

        $element->add_control(
            'mg_conditional_recurring_time_end',
            [
                'label' => __('End Time', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DATE_TIME,
                'default' => '17:00',
                'picker_options' => [
                    'enableTime' => true,
                    'noCalendar' => true,
                    'dateFormat' => 'H:i',
                    'time_24hr' => true,
                ],
                'condition' => [
                    'mg_conditional_display_enable' => 'yes',
                    'mg_conditional_display_condition' => 'recurring_schedule',
                ],
                'classes' => !$mgporv_active ? 'mg-pro-control' : '',
            ]
        );

        // Post Type condition
        $element->add_control(
            'mg_conditional_post_type',
            [
                'label' => __('Select Post Type', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => $this->get_post_types(),
                'multiple' => true,
                'condition' => [
                    'mg_conditional_display_enable' => 'yes',
                    'mg_conditional_display_condition' => 'post_type',
                ],
                'classes' => !$mgporv_active ? 'mg-pro-control' : '',
            ]
        );

        // Browser Type condition
        $element->add_control(
            'mg_conditional_browser_type',
            [
                'label' => __('Select Browser', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'options' => [
                    'chrome' => __('Chrome', 'magical-addons-for-elementor'),
                    'firefox' => __('Firefox', 'magical-addons-for-elementor'),
                    'safari' => __('Safari', 'magical-addons-for-elementor'),
                    'edge' => __('Edge', 'magical-addons-for-elementor'),
                    'opera' => __('Opera', 'magical-addons-for-elementor'),
                    'ie' => __('Internet Explorer', 'magical-addons-for-elementor'),
                ],
                'multiple' => true,
                'condition' => [
                    'mg_conditional_display_enable' => 'yes',
                    'mg_conditional_display_condition' => 'browser_type',
                ],
                'classes' => !$mgporv_active ? 'mg-pro-control' : '',
            ]
        );

        // URL Parameter condition
        $element->add_control(
            'mg_conditional_url_parameter_name',
            [
                'label' => __('Parameter Name', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => 'param',
                'condition' => [
                    'mg_conditional_display_enable' => 'yes',
                    'mg_conditional_display_condition' => 'url_parameter',
                ],
                'classes' => !$mgporv_active ? 'mg-pro-control' : '',
            ]
        );

        $element->add_control(
            'mg_conditional_url_parameter_value',
            [
                'label' => __('Parameter Value (optional)', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => 'value',
                'description' => __('Leave empty to check for parameter existence only', 'magical-addons-for-elementor'),
                'condition' => [
                    'mg_conditional_display_enable' => 'yes',
                    'mg_conditional_display_condition' => 'url_parameter',
                ],
                'classes' => !$mgporv_active ? 'mg-pro-control' : '',
            ]
        );

        // Referrer Source condition
        $element->add_control(
            'mg_conditional_referrer_source',
            [
                'label' => __('Referrer URL contains', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => 'google.com',
                'condition' => [
                    'mg_conditional_display_enable' => 'yes',
                    'mg_conditional_display_condition' => 'referrer_source',
                ],
                'classes' => !$mgporv_active ? 'mg-pro-control' : '',
            ]
        );


        $element->add_control(
            'mg_conditional_action',
            [
                'label' => __('Action', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'show',
                'options' => [
                    'show' => __('Show Element', 'magical-addons-for-elementor'),
                    'hide' => __('Hide Element', 'magical-addons-for-elementor'),
                ],
                'condition' => [
                    'mg_conditional_display_enable' => 'yes',
                ],
            ]
        );



        $element->end_controls_section();
    }


    /**
     * Get all user roles
     * @return array
     */
    private function get_user_roles()
    {
        global $wp_roles;
        $roles = [];

        if (!isset($wp_roles)) {
            $wp_roles = new WP_Roles();
        }

        foreach ($wp_roles->roles as $role_key => $role) {
            $roles[$role_key] = $role['name'];
        }

        return $roles;
    }

    /**
     * Get all public post types
     * @return array
     */
    private function get_post_types()
    {
        $post_types = [];
        $args = [
            'public' => true,
        ];

        $types = get_post_types($args, 'objects');

        foreach ($types as $type) {
            $post_types[$type->name] = $type->label;
        }

        return $post_types;
    }
}


// Initialize the class
Magical_Conditional_Display_field::get_instance();
