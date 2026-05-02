<?php

/**
 * weDevs Settings API wrapper class
 *
 * @version 1.3 (27-Sep-2016)
 *
 * @author Tareq Hasan <tareq@weDevs.com>
 * @link https://tareq.co Tareq Hasan
 * @example example/oop-example.php How to use the class
 */
if (!class_exists('WeDevs_Settings_API')) :
    class WeDevs_Settings_API
    {

        /**
         * settings sections array
         *
         * @var array
         */
        protected $settings_sections = array();

        /**
         * Settings fields array
         *
         * @var array
         */
        protected $settings_fields = array();

        public function __construct()
        {
            add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
        }

        /**
         * Enqueue scripts and styles
         */
        function admin_enqueue_scripts()
        {
            wp_enqueue_style('wp-color-picker');

            wp_enqueue_media();
            wp_enqueue_script('wp-color-picker');
            wp_enqueue_script('jquery');
        }

        /**
         * Set settings sections
         *
         * @param array   $sections setting sections array
         */
        function set_sections($sections)
        {
            $this->settings_sections = $sections;

            return $this;
        }

        /**
         * Add a single section
         *
         * @param array   $section
         */
        function add_section($section)
        {
            $this->settings_sections[] = $section;

            return $this;
        }

        /**
         * Set settings fields
         *
         * @param array   $fields settings fields array
         */
        function set_fields($fields)
        {
            $this->settings_fields = $fields;

            return $this;
        }

        function add_field($section, $field)
        {
            $defaults = array(
                'name'  => '',
                'label' => '',
                'desc'  => '',
                'type'  => 'text'
            );

            $arg = wp_parse_args($field, $defaults);
            $this->settings_fields[$section][] = $arg;

            return $this;
        }

        /**
         * Initialize and registers the settings sections and fileds to WordPress
         *
         * Usually this should be called at `admin_init` hook.
         *
         * This function gets the initiated settings sections and fields. Then
         * registers them to WordPress and ready for use.
         */
        function admin_init()
        {
            //register settings sections
            foreach ($this->settings_sections as $section) {
                if (false == get_option($section['id'])) {
                    add_option($section['id']);
                }

                if (isset($section['desc']) && !empty($section['desc'])) {
                    $section['desc'] = '<div class="inside">' . $section['desc'] . '</div>';
                    $callback = function () use ($section) {
                        echo str_replace('"', '\"', $section['desc']);
                    };
                } else if (isset($section['callback'])) {
                    $callback = $section['callback'];
                } else {
                    $callback = null;
                }

                add_settings_section($section['id'], $section['title'], $callback, $section['id']);
            }

            //register settings fields
            foreach ($this->settings_fields as $section => $field) {
                foreach ($field as $option) {

                    $name = $option['name'];
                    $type = isset($option['type']) ? $option['type'] : 'text';
                    $label = isset($option['label']) ? $option['label'] : '';
                    $callback = isset($option['callback']) ? $option['callback'] : array($this, 'callback_' . $type);

                    $args = array(
                        'id'                => $name,
                        'class'             => isset($option['class']) ? $option['class'] : $name,
                        'label_for'         => "{$section}[{$name}]",
                        'desc'              => isset($option['desc']) ? $option['desc'] : '',
                        'name'              => $label,
                        'section'           => $section,
                        'size'              => isset($option['size']) ? $option['size'] : null,
                        'options'           => isset($option['options']) ? $option['options'] : '',
                        'std'               => isset($option['default']) ? $option['default'] : '',
                        'sanitize_callback' => isset($option['sanitize_callback']) ? $option['sanitize_callback'] : '',
                        'type'              => $type,
                        'placeholder'       => isset($option['placeholder']) ? $option['placeholder'] : '',
                        'min'               => isset($option['min']) ? $option['min'] : '',
                        'max'               => isset($option['max']) ? $option['max'] : '',
                        'step'              => isset($option['step']) ? $option['step'] : '',
                    );

                    add_settings_field("{$section}[{$name}]", $label, $callback, $section, $section, $args);
                }
            }

            // creates our settings in the options table
            foreach ($this->settings_sections as $section) {
                register_setting($section['id'], $section['id'], array($this, 'sanitize_options'));
            }
        }

        /**
         * Get field description for display
         *
         * @param array   $args settings field args
         */
        public function get_field_description($args)
        {
            if (!empty($args['desc'])) {
                $desc = sprintf('<p class="description">%s</p>', $args['desc']);
            } else {
                $desc = '';
            }

            return $desc;
        }

        /**
         * Displays a text field for a settings field
         *
         * @param array   $args settings field args
         */
        function callback_text($args)
        {

            $value       = esc_attr($this->get_option($args['id'], $args['section'], $args['std']));
            $size        = isset($args['size']) && !is_null($args['size']) ? $args['size'] : 'regular';
            $type        = isset($args['type']) ? $args['type'] : 'text';
            $placeholder = empty($args['placeholder']) ? '' : ' placeholder="' . esc_attr($args['placeholder']) . '"';

            $html        = sprintf('<input type="%1$s" class="%2$s-text" id="%3$s[%4$s]" name="%3$s[%4$s]" value="%5$s"%6$s/>', $type, $size, $args['section'], $args['id'], $value, $placeholder);
            $html       .= wp_kses_post($this->get_field_description($args));

            echo $html;
        }

        /**
         * Displays a url field for a settings field
         *
         * @param array   $args settings field args
         */
        function callback_url($args)
        {
            $this->callback_text($args);
        }

        /**
         * Displays a number field for a settings field
         *
         * @param array   $args settings field args
         */
        function callback_number($args)
        {
            $value       = esc_attr($this->get_option($args['id'], $args['section'], $args['std']));
            $size        = isset($args['size']) && !is_null($args['size']) ? $args['size'] : 'regular';
            $type        = isset($args['type']) ? $args['type'] : 'number';
            $placeholder = empty($args['placeholder']) ? '' : ' placeholder="' . $args['placeholder'] . '"';
            $min         = ($args['min'] == '') ? '' : ' min="' . $args['min'] . '"';
            $max         = ($args['max'] == '') ? '' : ' max="' . $args['max'] . '"';
            $step        = ($args['step'] == '') ? '' : ' step="' . $args['step'] . '"';

            $html        = sprintf('<input type="%1$s" class="%2$s-number" id="%3$s[%4$s]" name="%3$s[%4$s]" value="%5$s"%6$s%7$s%8$s%9$s/>', $type, $size, $args['section'], $args['id'], $value, $placeholder, $min, $max, $step);
            $html       .= esc_html($this->get_field_description($args));

            echo $html;
        }



        function callback_checkbox($args)
        {
            $value   = esc_attr($this->get_option($args['id'], $args['section'], $args['std']));
            $section = esc_attr($args['section']);
            $id      = esc_attr($args['id']);
            $desc    = isset($args['desc']) ? wp_kses_post($args['desc']) : '';

            $html  = '<fieldset>';
            $html .= sprintf('<label for="wpuf-%1$s[%2$s]">', $section, $id);
            $html .= sprintf('<input type="hidden" name="%1$s[%2$s]" value="off" />', $section, $id);
            $html .= sprintf(
                '<input type="checkbox" class="checkbox" id="wpuf-%1$s[%2$s]" name="%1$s[%2$s]" value="on" %3$s />',
                $section,
                $id,
                checked($value, 'on', false)
            );
            $html .= '<div class="switch"></div>';
            $html .= $desc;
            $html .= '</label>';
            $html .= '</fieldset>';

            echo $html;
        }



        /**
         * Displays a multicheckbox for a settings field
         *
         * @param array   $args settings field args
         */
        function callback_multicheck($args)
        {
            $value   = $this->get_option($args['id'], $args['section'], $args['std']);
            $section = esc_attr($args['section']);
            $id      = esc_attr($args['id']);

            $html  = '<fieldset>';
            $html .= sprintf('<input type="hidden" name="%1$s[%2$s]" value="" />', $section, $id);

            foreach ($args['options'] as $key => $label) {
                $key_escaped   = esc_attr($key);
                $label_escaped = esc_html($label); // or wp_kses_post() if label has HTML

                $checked = isset($value[$key]) ? $value[$key] : '0';

                $html .= sprintf('<label for="wpuf-%1$s[%2$s][%3$s]">', $section, $id, $key_escaped);
                $html .= sprintf(
                    '<input type="checkbox" class="checkbox" id="wpuf-%1$s[%2$s][%3$s]" name="%1$s[%2$s][%3$s]" value="%3$s" %4$s />',
                    $section,
                    $id,
                    $key_escaped,
                    checked($checked, $key, false)
                );
                $html .= $label_escaped . '</label><br>';
            }

            $html .= wp_kses_post($this->get_field_description($args));
            $html .= '</fieldset>';

            echo $html;
        }


        /**
         * Displays a radio button for a settings field
         *
         * @param array   $args settings field args
         */
        function callback_radio($args)
        {
            $value   = $this->get_option($args['id'], $args['section'], $args['std']);
            $section = esc_attr($args['section']);
            $id      = esc_attr($args['id']);

            $html  = '<fieldset>';

            foreach ($args['options'] as $key => $label) {
                $key_escaped   = esc_attr($key);
                $label_escaped = esc_html($label); // Use wp_kses_post() if label has allowed HTML

                $html .= sprintf('<label for="wpuf-%1$s[%2$s][%3$s]">', $section, $id, $key_escaped);
                $html .= sprintf(
                    '<input type="radio" class="radio" id="wpuf-%1$s[%2$s][%3$s]" name="%1$s[%2$s]" value="%3$s" %4$s />',
                    $section,
                    $id,
                    $key_escaped,
                    checked($value, $key, false)
                );
                $html .= $label_escaped . '</label><br>';
            }

            $html .= wp_kses_post($this->get_field_description($args));
            $html .= '</fieldset>';

            echo $html;
        }


        /**
         * Displays a selectbox for a settings field
         *
         * @param array   $args settings field args
         */
        function callback_select($args)
        {
            $value   = esc_attr($this->get_option($args['id'], $args['section'], $args['std']));
            $size    = isset($args['size']) && !is_null($args['size']) ? esc_attr($args['size']) : 'regular';
            $section = esc_attr($args['section']);
            $id      = esc_attr($args['id']);

            $html = sprintf('<select class="%1$s" name="%2$s[%3$s]" id="%2$s[%3$s]">', $size, $section, $id);

            foreach ($args['options'] as $key => $label) {
                $key_escaped   = esc_attr($key);
                $label_escaped = esc_html($label); // use wp_kses_post($label) if label contains safe HTML

                $html .= sprintf('<option value="%s"%s>%s</option>', $key_escaped, selected($value, $key, false), $label_escaped);
            }

            $html .= '</select>';
            $html .= wp_kses_post($this->get_field_description($args));

            echo $html;
        }


        /**
         * Displays a textarea for a settings field
         *
         * @param array   $args settings field args
         */
        function callback_textarea($args)
        {
            // Retrieve and sanitize the value from the options
            $value = esc_textarea($this->get_option($args['id'], $args['section'], $args['std']));

            // Validate and set the size attribute
            $size = isset($args['size']) && !is_null($args['size']) ? sanitize_key($args['size']) : 'regular';

            // Sanitize and set the placeholder attribute if it exists
            $placeholder = '';
            if (!empty($args['placeholder'])) {
                $placeholder = ' placeholder="' . esc_attr($args['placeholder']) . '"';
            }

            // Generate the HTML for the textarea element
            $html = sprintf(
                '<textarea rows="5" cols="55" class="%1$s-text" id="%2$s[%3$s]" name="%2$s[%3$s]"%4$s>%5$s</textarea>',
                esc_attr($size), // Ensure the size is safe for use in a class attribute
                esc_attr($args['section']), // Sanitize the section name
                esc_attr($args['id']), // Sanitize the ID
                $placeholder, // Placeholder is already sanitized above
                $value // Value is already sanitized using esc_textarea
            );

            // Append the field description, ensuring it is sanitized as well
            $html .= $this->get_field_description($args);

            // Output the sanitized HTML
            echo $html;
        }

        /**
         * Displays the html for a settings field
         *
         * @param array   $args settings field args
         * @return string
         */
        function callback_html($args)
        {
            echo wp_kses_post($this->get_field_description($args));
        }

        /**
         * Displays a rich text textarea for a settings field
         *
         * @param array   $args settings field args
         */
        function callback_wysiwyg($args)
        {
            // Retrieve and sanitize the value from the options
            $value = $this->get_option($args['id'], $args['section'], $args['std']);

            // Validate and sanitize the size attribute
            $size = isset($args['size']) && !is_null($args['size']) ? sanitize_text_field($args['size']) : '500px';

            // Ensure the size is safe for use in inline styles
            $size = esc_attr($size);

            // Output the opening div with sanitized inline style
            echo '<div style="max-width: ' . $size . ';">';

            // Set up the default editor settings
            $editor_settings = array(
                'teeny'         => true,
                'textarea_name' => esc_attr($args['section']) . '[' . esc_attr($args['id']) . ']',
                'textarea_rows' => 10,
            );

            // Merge custom options if provided
            if (isset($args['options']) && is_array($args['options'])) {
                $editor_settings = array_merge($editor_settings, $args['options']);
            }

            // Generate a sanitized ID for the editor
            $editor_id = esc_attr($args['section']) . '-' . esc_attr($args['id']);

            // Render the WordPress WYSIWYG editor
            wp_editor(wp_kses_post($value), $editor_id, $editor_settings);

            // Close the div
            echo '</div>';

            // Append the field description, ensuring it is sanitized
            echo $this->get_field_description($args);
        }

        /**
         * Displays a file upload field for a settings field
         *
         * @param array   $args settings field args
         */
        function callback_file($args)
        {
            // Get the option value and escape it for use in an attribute
            $value = esc_attr($this->get_option($args['id'], $args['section'], $args['std']));

            // Determine size class, sanitize as a CSS class (only allow certain values)
            $allowed_sizes = ['small', 'regular', 'large'];
            $size = (isset($args['size']) && in_array($args['size'], $allowed_sizes, true)) ? $args['size'] : 'regular';

            // Sanitize section and id for use in HTML attributes (allow only alphanumeric, underscores, hyphens)
            $section = sanitize_key($args['section']);
            $id = sanitize_key($args['id']);

            // Sanitize button label for safe HTML output (allow translation)
            $label = isset($args['options']['button_label']) ? esc_html__($args['options']['button_label'],'magical-addons-for-elementor') : esc_html__('Choose File','magical-addons-for-elementor');

            // Compose the input name and id attribute
            $input_name = sprintf('%s[%s]', $section, $id);
            $input_id = $input_name; // Using same for id attribute, safe after sanitize_key

            // Build HTML safely
            $html  = sprintf(
                '<input type="text" class="%1$s-text wpsa-url" id="%2$s" name="%3$s" value="%4$s" />',
                esc_attr($size),
                esc_attr($input_id),
                esc_attr($input_name),
                $value
            );

            $html .= sprintf(
                '<input type="button" class="button wpsa-browse" value="%s" />',
                $label
            );

            $html .= $this->get_field_description($args);

            echo wp_kses_post($html);
        }


        /**
         * Displays a password field for a settings field
         *
         * @param array   $args settings field args
         */
        function callback_password($args)
        {
            // Get the option value and escape it for use in an attribute
            $value = esc_attr($this->get_option($args['id'], $args['section'], $args['std']));

            // Define allowed sizes and sanitize size input
            $allowed_sizes = ['small', 'regular', 'large'];
            $size = (isset($args['size']) && in_array($args['size'], $allowed_sizes, true)) ? $args['size'] : 'regular';

            // Sanitize section and id keys for safe use in HTML attributes
            $section = sanitize_key($args['section']);
            $id = sanitize_key($args['id']);

            // Compose input name and id attributes
            $input_name = sprintf('%s[%s]', $section, $id);
            $input_id = $input_name; // Using same for id attribute, safe after sanitize_key

            // Build the HTML input field safely
            $html  = sprintf(
                '<input type="password" class="%1$s-text" id="%2$s" name="%3$s" value="%4$s" />',
                esc_attr($size),
                esc_attr($input_id),
                esc_attr($input_name),
                $value
            );

            // Append the field description (assumed safe)
            $html .= $this->get_field_description($args);

            echo wp_kses_post($html);
        }


        /**
         * Displays a color picker field for a settings field
         *
         * @param array   $args settings field args
         */
        function callback_color($args)
        {
            // Get the option value and escape it for HTML attribute
            $value = esc_attr($this->get_option($args['id'], $args['section'], $args['std']));

            // Sanitize and validate size value (allow only certain values)
            $allowed_sizes = ['small', 'regular', 'large'];
            $size = (isset($args['size']) && in_array($args['size'], $allowed_sizes, true)) ? $args['size'] : 'regular';

            // Sanitize section and id keys for safe use in HTML attributes
            $section = sanitize_key($args['section']);
            $id = sanitize_key($args['id']);

            // Sanitize default color - allow only hex colors (e.g. #ffffff)
            $default_color = isset($args['std']) ? sanitize_hex_color($args['std']) : '';

            // Compose input name and id attributes
            $input_name = sprintf('%s[%s]', $section, $id);
            $input_id = $input_name; // safe after sanitize_key

            // Build the HTML input field safely
            $html = sprintf(
                '<input type="text" class="%1$s-text wp-color-picker-field" id="%2$s" name="%3$s" value="%4$s" data-default-color="%5$s" />',
                esc_attr($size),
                esc_attr($input_id),
                esc_attr($input_name),
                $value,
                esc_attr($default_color)
            );

            // Append the field description (assumed safe)
            $html .= $this->get_field_description($args);

            echo wp_kses_post($html);
        }



        /**
         * Displays a select box for creating the pages select box
         *
         * @param array   $args settings field args
         */
        function callback_pages($args)
        {
            // Get selected page ID and sanitize as integer
            $selected = absint($this->get_option($args['id'], $args['section'], $args['std']));

            // Sanitize section and ID keys
            $section = sanitize_key($args['section']);
            $id = sanitize_key($args['id']);

            // Prepare dropdown arguments with proper escaping for each element
            $dropdown_args = array(
                'selected'          => absint($selected),
                'name'              => esc_attr($section . '[' . $id . ']'),
                'id'                => esc_attr($section . '-' . $id),
                'echo'              => 0,
                'show_option_none'  => esc_html__('Select a page','magical-addons-for-elementor'),
                'option_none_value' => ''
            );

            // Generate dropdown HTML
            $html = wp_dropdown_pages($dropdown_args);

            // Escape the field description HTML
            $html .= wp_kses_post($this->get_field_description($args));

            echo wp_kses_post($html);
        }



        /**
         * Sanitize callback for Settings API
         *
         * @return mixed
         */
        function sanitize_options($options)
        {
            // Return early if empty
            if (empty($options) || !is_array($options)) {
                return array();
            }

            foreach ($options as $option_slug => $option_value) {
                // Sanitize the option slug/key first
                $option_slug = sanitize_key($option_slug);

                // Get registered sanitization callback
                $sanitize_callback = $this->get_sanitize_callback($option_slug);

                if ($sanitize_callback) {
                    // Verify callback is valid and callable
                    if (is_callable($sanitize_callback)) {
                        $options[$option_slug] = call_user_func($sanitize_callback, $option_value);
                    } else {
                        // Fallback to basic sanitization if invalid callback
                        $options[$option_slug] = $this->sanitize_fallback($option_value);
                    }
                } else {
                    // Apply default sanitization if no callback specified
                    $options[$option_slug] = $this->sanitize_fallback($option_value);
                }
            }

            return $options;
        }

        // Add this helper method to your class
        protected function sanitize_fallback($value)
        {
            if (is_array($value)) {
                return array_map(array($this, 'sanitize_fallback'), $value);
            }

            return sanitize_text_field($value);
        }


        /**
         * Get sanitization callback for given option slug
         *
         * @param string $slug option slug
         *
         * @return mixed string or bool false
         */
        function get_sanitize_callback($slug = '')
        {
            if (empty($slug)) {
                return false;
            }

            // Iterate over registered fields and see if we can find proper callback
            foreach ($this->settings_fields as $section => $options) {
                foreach ($options as $option) {
                    if ($option['name'] != $slug) {
                        continue;
                    }

                    // Return the callback name
                    return isset($option['sanitize_callback']) && is_callable($option['sanitize_callback']) ? $option['sanitize_callback'] : false;
                }
            }

            return false;
        }

        /**
         * Get the value of a settings field
         *
         * @param string  $option  settings field name
         * @param string  $section the section name this field belongs to
         * @param string  $default default text if it's not found
         * @return string
         */
        function get_option($option, $section, $default = '')
        {

            $options = get_option($section);

            if (isset($options[$option])) {
                return $options[$option];
            }

            return $default;
        }

        /**
         * Show navigations as tab
         *
         * Shows all the settings section labels as tab
         */
        function show_navigation()
        {
            // Return early if no sections or only one section
            if (!is_array($this->settings_sections) || count($this->settings_sections) <= 1) {
                return;
            }

            $html = '<h2 class="nav-tab-wrapper">';

            foreach ($this->settings_sections as $tab) {
                // Skip if tab data is invalid
                if (!isset($tab['id']) || !isset($tab['title'])) {
                    continue;
                }

                // Sanitize tab ID and title
                $tab_id = isset($tab['id']) ? sanitize_html_class($tab['id']) : '';
                $tab_title = isset($tab['title']) ? esc_html($tab['title']) : '';

                // Only output if we have valid data
                if ($tab_id && $tab_title) {
                    $html .= sprintf(
                        '<a href="#%1$s" class="nav-tab" id="%1$s-tab">%2$s</a>',
                        $tab_id,
                        $tab_title
                    );
                }
            }

            $html .= '</h2>';

            echo $html;
        }


        /**
         * Show the section settings forms
         *
         * This function displays every sections in a different form
         */

        function show_forms()
        {
            // Verify settings sections exist and is array
            if (!is_array($this->settings_sections) || empty($this->settings_sections)) {
                return;
            }

            echo '<div class="metabox-holder">';

            foreach ($this->settings_sections as $form) {
                // Skip invalid forms missing required ID
                if (!isset($form['id']) || empty($form['id'])) {
                    continue;
                }

                // Sanitize form ID for HTML attributes
                $form_id = sanitize_key($form['id']);

                // Output form container
                echo sprintf(
                    '<div id="%s" class="group" style="display: none;">',
                    esc_attr($form_id)
                );

                // Start form
                echo '<form method="post" action="options.php">';

                // Action hook (sanitized hook name)
                do_action('wsa_form_top_' . $form_id, $form);

                // WordPress settings API functions
                settings_fields($form_id);
                do_settings_sections($form_id);

                // Action hook (sanitized hook name)
                do_action('wsa_form_bottom_' . $form_id, $form);

                // Submit button if fields exist
                if (!empty($this->settings_fields[$form_id])) {
                    echo '<div style="padding-left: 10px">';
                    submit_button();
                    echo '</div>';
                }

                echo '</form></div>';
            }

            echo '</div>';

            // Output JavaScript
            $this->script();
        }


        /**
         * Tabbable JavaScript codes & Initiate Color Picker
         *
         * This code uses localstorage for displaying active tabs
         */
        function script()
        {
?>
            <script>
                jQuery(document).ready(function($) {
                    //Initiate Color Picker
                    $('.wp-color-picker-field').wpColorPicker();

                    // Switches option sections
                    $('.group').hide();
                    var activetab = '';
                    if (typeof(localStorage) != 'undefined') {
                        activetab = localStorage.getItem("activetab");
                    }

                    //if url has section id as hash then set it as active or override the current local storage value
                    if (window.location.hash) {
                        activetab = window.location.hash;
                        if (typeof(localStorage) != 'undefined') {
                            localStorage.setItem("activetab", activetab);
                        }
                    }

                    if (activetab != '' && $(activetab).length) {
                        $(activetab).fadeIn();
                    } else {
                        $('.group:first').fadeIn();
                    }
                    $('.group .collapsed').each(function() {
                        $(this).find('input:checked').parent().parent().parent().nextAll().each(
                            function() {
                                if ($(this).hasClass('last')) {
                                    $(this).removeClass('hidden');
                                    return false;
                                }
                                $(this).filter('.hidden').removeClass('hidden');
                            });
                    });

                    if (activetab != '' && $(activetab + '-tab').length) {
                        $(activetab + '-tab').addClass('nav-tab-active');
                    } else {
                        $('.nav-tab-wrapper a:first').addClass('nav-tab-active');
                    }
                    $('.nav-tab-wrapper a').click(function(evt) {
                        $('.nav-tab-wrapper a').removeClass('nav-tab-active');
                        $(this).addClass('nav-tab-active').blur();
                        var clicked_group = $(this).attr('href');
                        if (typeof(localStorage) != 'undefined') {
                            localStorage.setItem("activetab", $(this).attr('href'));
                        }
                        $('.group').hide();
                        $(clicked_group).fadeIn();
                        evt.preventDefault();
                    });

                    $('.wpsa-browse').on('click', function(event) {
                        event.preventDefault();

                        var self = $(this);

                        // Create the media frame.
                        var file_frame = wp.media.frames.file_frame = wp.media({
                            title: self.data('uploader_title'),
                            button: {
                                text: self.data('uploader_button_text'),
                            },
                            multiple: false
                        });

                        file_frame.on('select', function() {
                            attachment = file_frame.state().get('selection').first().toJSON();
                            self.prev('.wpsa-url').val(attachment.url).change();
                        });

                        // Finally, open the modal
                        file_frame.open();
                    });
                });
            </script>
            <?php
            $this->_style_fix();
        }

        function _style_fix()
        {
            global $wp_version;

            if (version_compare($wp_version, '3.8', '<=')) :
            ?>
                <style type="text/css">
                    /** WordPress 3.8 Fix **/
                    .form-table th {
                        padding: 20px 10px;
                    }

                    #wpbody-content .metabox-holder {
                        padding-top: 5px;
                    }
                </style>
<?php
            endif;
        }
    }

endif;
