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
require_once MAGICAL_ADDON_PATH . 'includes/extra/conditional-display/condition-display-field.php';
require_once MAGICAL_ADDON_PATH . 'includes/extra/conditional-display/mobile-detect.php';

class Magical_Conditional_Display
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
     * Constructor
     */
    public function __construct()
    {

        // Apply conditions on frontend
        add_action('elementor/frontend/widget/before_render', [$this, 'apply_conditional_display']);
        add_action('elementor/frontend/section/before_render', [$this, 'apply_conditional_display']);
        add_action('elementor/frontend/column/before_render', [$this, 'apply_conditional_display']);
    }





    /**
     * Apply conditional display logic on the frontend
     */
    public function apply_conditional_display($element)
    {
        $settings = $element->get_settings_for_display();

        // Check if conditional display is enabled
        if (empty($settings['mg_conditional_display_enable'])) {
            return;
        }

        $condition = $settings['mg_conditional_display_condition'];
        $action = $settings['mg_conditional_action'];
        $should_display = $this->check_condition($condition, $settings);

        // If action is 'hide', invert the condition
        if ($action === 'hide') {
            $should_display = !$should_display;
        }

        // Hide element if condition is not met
        if (!$should_display) {
            // Store element ID in static array to track which elements should be hidden
            static $elements_to_hide = [];
            $elements_to_hide[$element->get_id()] = true;
            
            // For widgets
            if ($element->get_type() === 'widget') {
                // Add filter only once
                static $widget_filter_added = false;
                if (!$widget_filter_added) {
                    add_filter('elementor/widget/render_content', function($content, $widget) use (&$elements_to_hide) {
                        if (isset($elements_to_hide[$widget->get_id()])) {
                            return ''; // Return empty content
                        }
                        return $content;
                    }, 999, 2);
                    $widget_filter_added = true;
                }
            } 
            // For sections
            elseif ($element->get_type() === 'section') {
                // Add filter only once
                static $section_filter_added = false;
                if (!$section_filter_added) {
                    add_filter('elementor/section/render_content', function($content, $section) use (&$elements_to_hide) {
                        if (isset($elements_to_hide[$section->get_id()])) {
                            return ''; // Return empty content
                        }
                        return $content;
                    }, 999, 2);
                    $section_filter_added = true;
                }
            }
            // For columns
            elseif ($element->get_type() === 'column') {
                // Add filter only once
                static $column_filter_added = false;
                if (!$column_filter_added) {
                    add_filter('elementor/column/render_content', function($content, $column) use (&$elements_to_hide) {
                        if (isset($elements_to_hide[$column->get_id()])) {
                            return ''; // Return empty content
                        }
                        return $content;
                    }, 999, 2);
                    $column_filter_added = true;
                }
            }
            
            // As a fallback, also add CSS to hide the element
            $element->add_render_attribute('_wrapper', 'style', 'display: none !important;');
        }
    }



    /**
     * Check if condition is met
     * @return bool
     */
    private function check_condition($condition, $settings)
    {
        switch ($condition) {
            case 'user_logged_in':
                return is_user_logged_in();

            case 'user_logged_out':
                return !is_user_logged_in();

            case 'user_role':
                if (!is_user_logged_in()) {
                    return false;
                }

                $user = wp_get_current_user();
                $roles = $settings['mg_conditional_user_role'];

                if (empty($roles)) {
                    return false;
                }

                foreach ($roles as $role) {
                    if (in_array($role, $user->roles)) {
                        return true;
                    }
                }
                return false;

            case 'device_type':
                $device = $settings['mg_conditional_device_type'];
                return $this->is_device_type($device);

            case 'day_of_week':
                $days = $settings['mg_conditional_day_of_week'];
                $current_day = gmdate('w', current_time('timestamp', true));

                if (empty($days)) {
                    return false;
                }

                return in_array($current_day, $days);

            case 'recurring_schedule':
                // First check if today is one of the selected days
                $days = $settings['mg_conditional_recurring_days'];
                $current_day = gmdate('w', current_time('timestamp', true));

                if (empty($days) || !in_array($current_day, $days)) {
                    return false;
                }

                // Then check if current time is within the time range
                $start_time = $this->format_time($settings['mg_conditional_recurring_time_start']);
                $end_time = $this->format_time($settings['mg_conditional_recurring_time_end']);

                if (empty($start_time) || empty($end_time)) {
                    return false;
                }

                $current_time = gmdate('H:i', current_time('timestamp', true));
                return ($current_time >= $start_time && $current_time <= $end_time);

            case 'time_of_day':
                $start_time = $this->format_time($settings['mg_conditional_time_start']);
                $end_time = $this->format_time($settings['mg_conditional_time_end']);

                if (empty($start_time) || empty($end_time)) {
                    return false;
                }

                $current_time = current_time('H:i');
                return ($current_time >= $start_time && $current_time <= $end_time);

            case 'date_range':
                $start_date = $this->format_date($settings['mg_conditional_date_start']);
                $end_date = $this->format_date($settings['mg_conditional_date_end']);

                if (empty($start_date) || empty($end_date)) {
                    return false;
                }

                $current_date = current_time('Y-m-d');
                return ($current_date >= $start_date && $current_date <= $end_date);

            case 'post_type':
                $post_types = $settings['mg_conditional_post_type'];
                if (empty($post_types)) {
                    return false;
                }

                return in_array(get_post_type(), $post_types);

            case 'browser_type':
                $browsers = $settings['mg_conditional_browser_type'];
                if (empty($browsers)) {
                    return false;
                }

                // Safely get and sanitize user agent
                $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field(wp_unslash($_SERVER['HTTP_USER_AGENT'])) : '';
                if (empty($user_agent)) {
                    return false;
                }

                foreach ($browsers as $browser) {
                    switch ($browser) {
                        case 'chrome':
                            if (strpos($user_agent, 'Chrome') !== false) return true;
                            break;
                        case 'firefox':
                            if (strpos($user_agent, 'Firefox') !== false) return true;
                            break;
                        case 'safari':
                            if (strpos($user_agent, 'Safari') !== false && strpos($user_agent, 'Chrome') === false) return true;
                            break;
                        case 'edge':
                            if (strpos($user_agent, 'Edg') !== false) return true;
                            break;
                        case 'opera':
                            if (strpos($user_agent, 'OPR') !== false || strpos($user_agent, 'Opera') !== false) return true;
                            break;
                        case 'ie':
                            if (strpos($user_agent, 'MSIE') !== false || strpos($user_agent, 'Trident/') !== false) return true;
                            break;
                    }
                }
                return false;

            case 'url_parameter':
                $param_name = $settings['mg_conditional_url_parameter_name'];
                $param_value = $settings['mg_conditional_url_parameter_value'];

                if (empty($param_name)) {
                    return false;
                }

                // Safely check and get URL parameter
                // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- URL parameters for conditional display don't require nonce verification
                if (!isset($_GET[$param_name])) {
                    return false;
                }

                // Sanitize the parameter value
                // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- URL parameters for conditional display don't require nonce verification
                $get_param_value = sanitize_text_field(wp_unslash($_GET[$param_name]));

                // If a specific value is required, check it
                if (!empty($param_value)) {
                    return $get_param_value === $param_value;
                }

                // Otherwise, just check if parameter exists and has a value
                return !empty($get_param_value);

            case 'referrer_source':
                $referrer = $settings['mg_conditional_referrer_source'];

                if (empty($referrer)) {
                    return false;
                }

                // Safely get and sanitize HTTP referrer
                $http_referrer = isset($_SERVER['HTTP_REFERER']) ? sanitize_url(wp_unslash($_SERVER['HTTP_REFERER'])) : '';

                if (empty($http_referrer)) {
                    return false;
                }

                return strpos($http_referrer, $referrer) !== false;

            default:
                return true;
        }
    }


    /**
     * Format time to H:i format
     * This handles the DATE_TIME picker format
     * 
     * @param string $time Time string from DATE_TIME picker
     * @return string Formatted time in H:i format
     */
    private function format_time($time)
    {
        // If the time is already in H:i format, return it
        if (preg_match('/^\d{2}:\d{2}$/', $time)) {
            return $time;
        }

        // Try to parse the time string
        $timestamp = strtotime($time);
        if ($timestamp === false) {
            return '00:00';
        }

        return gmdate('H:i', $timestamp);
    }

    /**
     * Format date to Y-m-d format
     * This handles the DATE_TIME picker format
     * 
     * @param string $date Date string from DATE_TIME picker
     * @return string Formatted date in Y-m-d format
     */
    private function format_date($date)
    {
        // If the date is already in Y-m-d format, return it
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return $date;
        }

        // Try to parse the date string
        $timestamp = strtotime($date);
        if ($timestamp === false) {
            return gmdate('Y-m-d', current_time('timestamp', true)); // Return current date as fallback
        }

        return gmdate('Y-m-d', $timestamp);
    }

    /**
     * Check device type
     * @return bool
     */
    private function is_device_type($device)
    {
        $detect = new Mobile_Detect();

        switch ($device) {
            case 'desktop':
                return !$detect->isMobile() && !$detect->isTablet();

            case 'tablet':
                return $detect->isTablet();

            case 'mobile':
                return $detect->isMobile() && !$detect->isTablet();

            default:
                return false;
        }
    }
}

// Initialize the class
Magical_Conditional_Display::get_instance();
