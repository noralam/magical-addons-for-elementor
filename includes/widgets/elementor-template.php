<?php


use Elementor\Controls_Manager;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class mg_ElementorTemplate extends Widget_Base
{
    use mgProHelpLink;
    /**
     * Get widget name.
     *
     * Retrieve Blank widget name.
     *
     * @return string Widget name.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_name()
    {
        return 'mg_elementor_template';
    }

    /**
     * Get widget title.
     *
     * Retrieve Blank widget title.
     *
     * @return string Widget title.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_title()
    {
        return __('MG Template Insert', 'magical-addons-for-elementor');
    }

    /**
     * Get widget icon.
     *
     * Retrieve Blank widget icon.
     *
     * @return string Widget icon.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_icon()
    {
        return 'eicon-document-file';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the Blank widget belongs to.
     *
     * @return array Widget categories.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_categories()
    {
        return ['magical'];
    }
    public function get_keywords()
    {
        return ['mg', 'elementor', 'template', 'insert', 'page'];
    }


    protected function register_controls()
    {

        // Section: General ----------
        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__('Insert Template', 'magical-addons-for-elementor'),
            ]
        );

        $templates_select = [];

        // Get All Templates
        $templates = get_posts([
            'post_type'   => array('elementor_library'),
            'post_status' => array('publish'),
            'meta_key'       => '_elementor_template_type',
            'meta_value'  => ['page', 'section'],
            'numberposts'  => -1
        ]);

        if (!empty($templates)) {
            foreach ($templates as $template) {
                $templates_select['0'] = esc_html__('Select Saved Template', 'magical-addons-for-elementor');
                $templates_select[$template->ID] = esc_html($template->post_title);
            }
        }

        $this->add_control(
            'select_template',
            [
                'label' => esc_html__('Select Template', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SELECT2,
                'options' => $templates_select,

            ]
        );

        // Restore original Post Data
        wp_reset_postdata();

        $this->end_controls_section(); // End Controls Section
        $this->link_pro_added();
    }


    protected function render()
    {
        // Get Settings
        $settings = $this->get_settings();

        if ('' == $settings['select_template']) {
            echo '<div class="mg-etemplate-not">' . esc_html__('Please select a template for display!! If the template list is empty then you need to add template first!!!') . '</div>';
        } else {
            echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($settings['select_template'], true); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
    }
}
