<?php

/**
 * WPForm widget class
 *
 * @package Magical Addons
 */

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

defined('ABSPATH') || die();
class MG_Addon_WPForm extends \Elementor\Widget_Base
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
        return 'mgwpform_widget';
    }
    /**
     * Get widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return __('Mg WPForms', 'magical-addons-for-elementor');
    }

    /**
     * Get widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'eicon-document-file';
    }

    public function get_keywords()
    {
        return ['wpf', 'wpform', 'form', 'contact', 'cf7', 'mg'];
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
     * Register widget content controls
     */
    protected function register_content_controls()
    {

        $this->start_controls_section(
            '_section_wpforms',
            [
                'label' => mg_is_wpforms_activated() ? __('WPForms', 'magical-addons-for-elementor') : __(
                    'Missing Notice',
                    'magical-addons-for-elementor'
                ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        if (!mg_is_wpforms_activated()) {

            $this->add_control(
                '_wpforms_missing_notice',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => sprintf(
                        __('Hello %2$s, looks like %1$s is missing in your site. Please click on the link below and install/activate %1$s. Make sure to refresh this page after installation or activation.', 'magical-addons-for-elementor'),
                        '<a href="' . esc_url(admin_url('plugin-install.php?s=WPForms&tab=search&type=term')) . '" target="_blank" rel="noopener">WPForms</a>',
                        mg_get_current_user_display_name()
                    ),
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-danger',
                ]
            );

            $this->add_control(
                '_wpforms_install',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<a href="' . esc_url(admin_url('plugin-install.php?s=WPForms&tab=search&type=term')) . '" target="_blank" rel="noopener">Click to install or activate WPForms</a>',
                ]
            );
        } else {

            $this->add_control(
                'form_id',
                [
                    'label' => __('Select Your Form', 'magical-addons-for-elementor'),
                    'type' => Controls_Manager::SELECT,
                    'label_block' => true,
                    'options' => ['' => __('Select a WPForm', 'magical-addons-for-elementor')] + \mg_get_wpforms(),
                ]
            );
        }

        $this->end_controls_section();
        $this->link_pro_added();
    }

    /**
     * Register widget style controls
     */
    protected function register_style_controls()
    {
        $this->__fields_style_controls();
        $this->__label_style_controls();
        $this->__submit_style_controls();
    }

    protected function __fields_style_controls()
    {

        $this->start_controls_section(
            '_section_fields_style',
            [
                'label' => __('Form Fields', 'magical-addons-for-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'field_margin',
            [
                'label' => __('Field Spacing', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wpforms-field:not(.wpforms-submit), .wpforms-field-required:not(.wpforms-submit)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'field_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wpforms-field input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpforms-field textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'field_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wpforms-field input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpforms-field textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'field_typography',
                'selector' => '{{WRAPPER}} .wpforms-field input, {{WRAPPER}} .wpforms-field-textarea textarea',
            ]
        );

        $this->add_control(
            'field_textcolor',
            [
                'label' => __('Field Text Color', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpforms-field input, {{WRAPPER}} .wpforms-field-textarea textarea' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'field_placeholder_color',
            [
                'label' => __('Field Placeholder Color', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ::-webkit-input-placeholder'    => 'color: {{VALUE}};',
                    '{{WRAPPER}} ::-moz-placeholder'            => 'color: {{VALUE}};',
                    '{{WRAPPER}} ::-ms-input-placeholder'        => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_field_state');

        $this->start_controls_tab(
            'tab_field_normal',
            [
                'label' => __('Normal State', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'field_border',
                'selector' => '{{WRAPPER}} .wpforms-field input, {{WRAPPER}} .wpforms-field-textarea textarea',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'field_box_shadow',
                'selector' => '{{WRAPPER}} .wpforms-field input, {{WRAPPER}} .wpforms-field-textarea textarea',
            ]
        );

        $this->add_control(
            'field_bg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpforms-field input, {{WRAPPER}} .wpforms-field-textarea textarea' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_field_focus',
            [
                'label' => __('Focus', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'field_focus_border',
                'selector' => '{{WRAPPER}} .wpforms-field input:focus, {{WRAPPER}} .wpforms-field-textarea textarea:focus',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'field_focus_box_shadow',
                'exclude' => [
                    'box_shadow_position',
                ],
                'selector' => '{{WRAPPER}} .wpforms-field input:focus, {{WRAPPER}} .wpforms-field-textarea textarea:focus',
            ]
        );

        $this->add_control(
            'field_focus_bg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpforms-field input:focus, {{WRAPPER}} .wpforms-field-textarea textarea:focus' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function __label_style_controls()
    {

        $this->start_controls_section(
            'wpf-form-label',
            [
                'label' => __('Form Fields Label', 'magical-addons-for-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'label_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wpforms-field-container label.wpforms-field-label' => 'display: inline-block; padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'label_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wpforms-field-container label.wpforms-field-label' => 'display: inline-block; padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'hr3',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'label_typography',
                'selector' => '{{WRAPPER}} .wpforms-field-container label.wpforms-field-label',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sublabel_typography',
                'selector' => '{{WRAPPER}} .wpforms-field-sublabel',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'desc_typography',
                'selector' => '{{WRAPPER}} .wpforms-field-description',
            ]
        );

        $this->add_control(
            'label_color_popover',
            [
                'label' => __('Colors', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'label_off' => __('', 'magical-addons-for-elementor'),
                'label_on' => __('Custom', 'magical-addons-for-elementor'),
                'return_value' => 'yes',
            ]
        );

        $this->start_popover();

        $this->add_control(
            'label_color',
            [
                'label' => __('Label Text Color', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpforms-field-container label.wpforms-field-label' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'label_color_popover' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'requered_label',
            [
                'label' => __('Required Label Color', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpforms-required-label' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'label_color_popover' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'sublabel_color',
            [
                'label' => __('Sub Label Text Color', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpforms-field-sublabel' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'label_color_popover' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'desc_label_color',
            [
                'label' => __('Description Text Color', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpforms-field-description' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'label_color_popover' => 'yes'
                ],
            ]
        );

        $this->end_popover();

        $this->end_controls_section();
    }

    protected function __submit_style_controls()
    {

        $this->start_controls_section(
            'submit',
            [
                'label' => __('Submit Button', 'magical-addons-for-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'submit_btn_width',
            [
                'label' => __('Button Full Width?', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_responsive_control(
            'button_width',
            [
                'label' => __('Button Width', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'condition' => [
                    'submit_btn_width' => 'yes'
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100
                ],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 800,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpforms-submit' => 'display: block; width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'submit_btn_position',
            [
                'label' => __('Button Position', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'condition' => [
                    'submit_btn_width' => '',

                ],
                'desktop_default' => 'left',
                'toggle' => false,
                'prefix_class' => 'mg-form-btn--%s',
                'selectors' => [
                    '{{WRAPPER}} .wpforms-submit-container' => 'text-align: {{Value}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'submit_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wpforms-submit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'submit_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wpforms-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'submit_typography',
                'selector' => '{{WRAPPER}} .wpforms-submit',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'submit_border',
                'selector' => '{{WRAPPER}} .wpforms-form .wpforms-submit-container button[type=submit]',
            ]
        );

        $this->add_control(
            'submit_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wpforms-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'submit_box_shadow',
                'selector' => '{{WRAPPER}} .wpforms-submit',
            ]
        );

        $this->add_control(
            'hr4',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->start_controls_tabs('tabs_button_style');

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => __('Normal', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'submit_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .wpforms-submit' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'submit_bg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpforms-submit' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => __('Hover', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'submit_hover_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpforms-submit:hover, {{WRAPPER}} .wpforms-submit:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'submit_hover_bg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpforms-submit:hover, {{WRAPPER}} .wpforms-submit:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'submit_hover_border_color',
            [
                'label' => __('Border Color', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpforms-submit:hover, {{WRAPPER}} .wpforms-submit:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render()
    {
        if (!mg_is_wpforms_activated()) {
            mg_show_plugin_missing_alert(__('WPForms', 'magical-addons-for-elementor'));
            return;
        }

        $settings = $this->get_settings_for_display();

        if (!empty($settings['form_id'])) {
            echo mg_do_shortcode('wpforms', [
                'id' => $settings['form_id'],
            ]);
        }
    }
}
