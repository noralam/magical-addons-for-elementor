<?php

use Elementor\Group_Control_Image_Size;


class BkProjectDetails extends \Elementor\Widget_Base
{

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
        return 'bk_project_details_widget';
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
        return __('MG Project Details', 'magical-addons-for-elementor');
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
        return 'eicon-editor-list-ul';
    }
    public function get_keywords()
    {
        return ['details', 'project', 'project-details', 'magical', 'bk'];
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

    /**
     * Register Blank widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls()
    {

        $this->register_content_controls();
        $this->register_style_controls();
    }

    /**
     * Register Blank widget content ontrols.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    function register_content_controls()
    {

        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'magical-addons-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'project_label',
            [
                'label' => __('Label', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Clients', 'magical-addons-for-elementor'),
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'project_value',
            [
                'label' => __('Value', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Jarosław Sokołowski', 'magical-addons-for-elementor'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'project_items',
            [
                'label' => __('Project Items', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'project_label' => __('Clients', 'magical-addons-for-elementor'),
                        'project_value' => __('Jarosław Sokołowski', 'magical-addons-for-elementor'),
                    ],
                    [
                        'project_label' => __('Date', 'magical-addons-for-elementor'),
                        'project_value' => __('9 September, 2024', 'magical-addons-for-elementor'),
                    ],
                    [
                        'project_label' => __('Category', 'magical-addons-for-elementor'),
                        'project_value' => __('Personal, Consulting', 'magical-addons-for-elementor'),
                    ],
                ],
                'title_field' => '{{{ project_label }}}',
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Register Blank widget style ontrols.
     *
     * Adds different input fields in the style tab to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_style_controls()
    {


        $this->start_controls_section(
            'section_project_details_style',
            [
                'label' => __('Basic Style', 'magical-addons-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Start Tab Control for Normal and Hover
        $this->start_controls_tabs('tabs_project_details_style');

        // Normal Tab
        $this->start_controls_tab(
            'tab_project_details_normal',
            [
                'label' => __('Normal', 'magical-addons-for-elementor'),
            ]
        );

        // Padding control
        $this->add_control(
            'project_details_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .project-details' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Margin control
        $this->add_control(
            'project_details_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .project-details' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Background color control
        $this->add_control(
            'project_details_background',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .project-details' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Border control
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'project_details_border',
                'label' => __('Border', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .project-details',
            ]
        );

        // Border radius control
        $this->add_control(
            'project_details_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .project-details' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Box shadow control
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'project_details_box_shadow',
                'label' => __('Box Shadow', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .project-details',
            ]
        );

        // End Normal Tab
        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab(
            'tab_project_details_hover',
            [
                'label' => __('Hover', 'magical-addons-for-elementor'),
            ]
        );

        // Background color on hover
        $this->add_control(
            'project_details_background_hover',
            [
                'label' => __('Background Color (Hover)', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .project-details:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Border on hover
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'project_details_border_hover',
                'label' => __('Border (Hover)', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .project-details:hover',
            ]
        );

        // Border radius on hover
        $this->add_control(
            'project_details_border_radius_hover',
            [
                'label' => __('Border Radius (Hover)', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .project-details:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Box shadow on hover
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'project_details_box_shadow_hover',
                'label' => __('Box Shadow (Hover)', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .project-details:hover',
            ]
        );

        // End Hover Tab
        $this->end_controls_tab();

        // End Tabs
        $this->end_controls_tabs();

        // End section
        $this->end_controls_section();


        // Start style section for "project-item"
        $this->start_controls_section(
            'section_project_item_style',
            [
                'label' => __('Project Item', 'magical-addons-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Start Tabs for Normal and Hover
        $this->start_controls_tabs('tabs_project_item_style');

        // Normal Tab
        $this->start_controls_tab(
            'tab_project_item_normal',
            [
                'label' => __('Normal', 'magical-addons-for-elementor'),
            ]
        );

        // Padding control for Normal state
        $this->add_control(
            'project_item_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .project-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Margin control for Normal state
        $this->add_control(
            'project_item_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .project-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Background color control for Normal state
        $this->add_control(
            'project_item_background',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .project-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Border control for Normal state
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'project_item_border',
                'label' => __('Border', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .project-item',
            ]
        );

        // Border radius control for Normal state
        $this->add_control(
            'project_item_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .project-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Box shadow control for Normal state
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'project_item_box_shadow',
                'label' => __('Box Shadow', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .project-item',
            ]
        );

        // End Normal Tab
        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab(
            'tab_project_item_hover',
            [
                'label' => __('Hover', 'magical-addons-for-elementor'),
            ]
        );

        // Background color control for Hover state
        $this->add_control(
            'project_item_background_hover',
            [
                'label' => __('Background Color (Hover)', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .project-item:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Border control for Hover state
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'project_item_border_hover',
                'label' => __('Border (Hover)', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .project-item:hover',
            ]
        );

        // Border radius control for Hover state
        $this->add_control(
            'project_item_border_radius_hover',
            [
                'label' => __('Border Radius (Hover)', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .project-item:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Box shadow control for Hover state
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'project_item_box_shadow_hover',
                'label' => __('Box Shadow (Hover)', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .project-item:hover',
            ]
        );

        // End Hover Tab
        $this->end_controls_tab();

        // End Tabs
        $this->end_controls_tabs();

        // End section
        $this->end_controls_section();

        $this->start_controls_section(
            'section_project_label_style',
            [
                'label' => __('Project Label', 'magical-addons-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Start Tabs for Normal and Hover
        $this->start_controls_tabs('tabs_project_label_style');

        // Normal Tab
        $this->start_controls_tab(
            'tab_project_label_normal',
            [
                'label' => __('Normal', 'magical-addons-for-elementor'),
            ]
        );

        // Padding control for Normal state
        $this->add_control(
            'project_label_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .project-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Margin control for Normal state
        $this->add_control(
            'project_label_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .project-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Text color control for Normal state
        $this->add_control(
            'project_label_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .project-label' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Background color control for Normal state
        $this->add_control(
            'project_label_background',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .project-label' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Typography control for Normal state
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'project_label_typography',
                'label' => __('Typography', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .project-label',
            ]
        );

        // End Normal Tab
        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab(
            'tab_project_label_hover',
            [
                'label' => __('Hover', 'magical-addons-for-elementor'),
            ]
        );

        // Text color control for Hover state
        $this->add_control(
            'project_label_color_hover',
            [
                'label' => __('Text Color (Hover)', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .project-label:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Background color control for Hover state
        $this->add_control(
            'project_label_background_hover',
            [
                'label' => __('Background Color (Hover)', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .project-label:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Typography control for Hover state
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'project_label_typography_hover',
                'label' => __('Typography (Hover)', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .project-label:hover',
            ]
        );

        // End Hover Tab
        $this->end_controls_tab();

        // End Tabs
        $this->end_controls_tabs();

        // End section
        $this->end_controls_section();

        // Start style section for "colon"
        $this->start_controls_section(
            'section_colon_style',
            [
                'label' => __('Colon', 'magical-addons-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Start Tabs for Normal and Hover
        $this->start_controls_tabs('tabs_colon_style');

        // Normal Tab
        $this->start_controls_tab(
            'tab_colon_normal',
            [
                'label' => __('Normal', 'magical-addons-for-elementor'),
            ]
        );

        // Padding control for Normal state
        $this->add_control(
            'colon_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .colon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Margin control for Normal state
        $this->add_control(
            'colon_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .colon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Text color control for Normal state
        $this->add_control(
            'colon_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .colon' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Background color control for Normal state
        $this->add_control(
            'colon_background',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .colon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Typography control for Normal state
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'colon_typography',
                'label' => __('Typography', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .colon',
            ]
        );

        // End Normal Tab
        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab(
            'tab_colon_hover',
            [
                'label' => __('Hover', 'magical-addons-for-elementor'),
            ]
        );

        // Text color control for Hover state
        $this->add_control(
            'colon_color_hover',
            [
                'label' => __('Text Color (Hover)', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .colon:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Background color control for Hover state
        $this->add_control(
            'colon_background_hover',
            [
                'label' => __('Background Color (Hover)', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .colon:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Typography control for Hover state
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'colon_typography_hover',
                'label' => __('Typography (Hover)', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .colon:hover',
            ]
        );

        // End Hover Tab
        $this->end_controls_tab();

        // End Tabs
        $this->end_controls_tabs();

        // End section
        $this->end_controls_section();

        // Start style section for "project-value"
        $this->start_controls_section(
            'section_project_value_style',
            [
                'label' => __('Project Value', 'magical-addons-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Start Tabs for Normal and Hover
        $this->start_controls_tabs('tabs_project_value_style');

        // Normal Tab
        $this->start_controls_tab(
            'tab_project_value_normal',
            [
                'label' => __('Normal', 'magical-addons-for-elementor'),
            ]
        );

        // Padding control for Normal state
        $this->add_control(
            'project_value_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .project-value' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Margin control for Normal state
        $this->add_control(
            'project_value_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .project-value' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Text color control for Normal state
        $this->add_control(
            'project_value_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .project-value' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Background color control for Normal state
        $this->add_control(
            'project_value_background',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .project-value' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Typography control for Normal state
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'project_value_typography',
                'label' => __('Typography', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .project-value',
            ]
        );

        // End Normal Tab
        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab(
            'tab_project_value_hover',
            [
                'label' => __('Hover', 'magical-addons-for-elementor'),
            ]
        );

        // Text color control for Hover state
        $this->add_control(
            'project_value_color_hover',
            [
                'label' => __('Text Color (Hover)', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .project-value:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Background color control for Hover state
        $this->add_control(
            'project_value_background_hover',
            [
                'label' => __('Background Color (Hover)', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .project-value:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Typography control for Hover state
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'project_value_typography_hover',
                'label' => __('Typography (Hover)', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .project-value:hover',
            ]
        );

        // End Hover Tab
        $this->end_controls_tab();

        // End Tabs
        $this->end_controls_tabs();

        // End section
        $this->end_controls_section();
    }

    /**
     * Render Blank widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        if (! empty($settings['project_items'])) : ?>
            <div class="project-details">
                <?php foreach ($settings['project_items'] as $item) : ?>
                    <div class="project-item">
                        <span class="project-label"><?php echo esc_html($item['project_label']); ?></span>
                        <span class="colon">:</span>
                        <span class="project-value"><?php echo esc_html($item['project_value']); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif;
    }

    protected function content_template()
    {
        ?>
        <# if ( settings.project_items.length ) { #>
            <div class="project-details">
                <# _.each( settings.project_items, function( item ) { #>
                    <div class="project-item">
                        <span class="project-label">{{{ item.project_label }}}</span>
                        <span class="colon">:</span>
                        <span class="project-value">{{{ item.project_value }}}</span>
                    </div>
                    <# }); #>
            </div>
            <# } #>
        <?php
    }
}
