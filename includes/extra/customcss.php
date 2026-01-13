<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Magical_Addons_Custom_CSS
{

    public function __construct()
    {
        // Add Custom CSS field in Section, Column, and Widget Advanced Tab
        add_action('elementor/element/section/section_advanced/after_section_end', [$this, 'add_custom_css_control'], 10, 2);
        add_action('elementor/element/column/section_advanced/after_section_end', [$this, 'add_custom_css_control'], 10, 2);
        add_action('elementor/element/common/_section_style/after_section_end', [$this, 'add_custom_css_control'], 10, 2);
        // Add Custom CSS field for Container element
        add_action('elementor/element/container/section_layout/after_section_end', [$this, 'add_custom_css_control'], 10, 2);

        // Output the custom CSS in frontend
        add_action('elementor/frontend/after_enqueue_styles', [$this, 'print_custom_css']);

        // Enqueue JavaScript to update CSS in real-time
        add_action('elementor/editor/after_enqueue_scripts', [$this, 'enqueue_editor_scripts']);

        // Add custom CSS to editor preview
        add_action('elementor/preview/enqueue_styles', [$this, 'print_custom_css_in_editor']);
    }

    // Add Custom CSS Control
    public function add_custom_css_control($element, $args)
    {
        $element->start_controls_section(
            'magical_custom_css_section',
            [
                'label' => __('Magical Custom CSS', 'magical-addons-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
            ]
        );

        $element->add_control(
            'magical_custom_css',
            [
                'label' => __('Custom CSS', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::CODE,
                'language' => 'css',
                'rows' => 10,
                'description' => __('Add your custom CSS for this element. Use "selector" to target this specific element.', 'magical-addons-for-elementor'),
                'render_type' => 'none', // Changed from 'ui' to 'none' to prevent default rendering
                'separator' => 'none',
                'show_label' => true,
            ]
        );

        $element->end_controls_section();
    }

    // Output Custom CSS in the Frontend
    public function print_custom_css()
    {
        if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
            return; // Avoid duplicate output in editor mode
        }

        $post_id = get_the_ID();
        if (!$post_id) return;

        $document = \Elementor\Plugin::$instance->documents->get($post_id);
        if ($document) {
            $elements = $document->get_elements_data();
            if (is_array($elements)) {
                $css = $this->get_custom_css_from_elements($elements);
                if (!empty($css)) {
                    echo '<style id="magical-custom-css">' . wp_strip_all_tags($css) . '</style>';
                }
            }
        }
    }

    // Output Custom CSS in the Editor Preview
    public function print_custom_css_in_editor()
    {
        $post_id = get_the_ID();
        if (!$post_id) return;

        $document = \Elementor\Plugin::$instance->documents->get($post_id);
        if ($document) {
            $elements = $document->get_elements_data();
            if (is_array($elements)) {
                $css = $this->get_custom_css_from_elements($elements);
                if (!empty($css)) {
                    echo '<style id="magical-custom-css-editor">' . wp_strip_all_tags($css) . '</style>';
                }
            }
        }
    }

    // Retrieve Custom CSS from Elements
    private function get_custom_css_from_elements($elements)
    {
        $css = '';

        foreach ($elements as $element) {
            if (isset($element['settings']['magical_custom_css']) && !empty($element['settings']['magical_custom_css'])) {
                $element_css = $element['settings']['magical_custom_css'];

                // Replace 'selector' with the actual element selector
                $element_id = isset($element['id']) ? $element['id'] : '';
                if ($element_id) {
                    $element_css = str_replace('selector', '.elementor-element-' . $element_id, $element_css);
                }

                $css .= $element_css . "\n";
            }

            if (!empty($element['elements'])) {
                $css .= $this->get_custom_css_from_elements($element['elements']);
            }
        }

        return $css;
    }

    // Enqueue JavaScript to Apply CSS Live in Elementor Editor
    public function enqueue_editor_scripts()
    {
        // Add a version timestamp for cache busting during development
        $version = defined('WP_DEBUG') && WP_DEBUG ? time() : MAGICAL_ADDON_VERSION;

        wp_enqueue_script(
            'magical-custom-css-live',
            MAGICAL_ADDON_ASSETS . 'js/custom-csslive.js',
            ['jquery', 'elementor-editor'],
            $version,
            true
        );
    }
}

// Initialize the class
new Magical_Addons_Custom_CSS();
