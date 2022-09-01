<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Schemes\Typography;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class mg_ScrollTop extends Widget_Base
{
    use mgProHelpLink;
    public function get_name()
    {
        return 'mgscrolltop';
    }

    public function get_title()
    {
        return esc_html__('Mg Back To Top', 'magical-addons-for-elementor');
    }

    public function get_icon()
    {
        return 'eicon-arrow-up';
    }

    public function get_categories()
    {
        return ['magical'];
    }

    public function get_keywords()
    {
        return ['mg', 'back to top', 'scroll', 'scroll to top', 'go top'];
    }

    /**
     * Retrieve the list of scripts the image comparison widget depended on.
     *
     * Used to set scripts dependencies required to run the widget.
     *
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
    public function get_script_depends()
    {
        return [
            'mg-scroll-top',
        ];
    }

    /**
     * Retrieve the list of styles the image comparison widget depended on.
     *
     * Used to set styles dependencies required to run the widget.
     *
     * @access public
     *
     * @return array Widget styles dependencies.
     */
    public function get_style_depends()
    {
        return [
            'mg-scrolltop',
        ];
    }


    protected function register_controls()
    {


        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__('General', 'magical-addons-for-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'button_position',
            [
                'label' => esc_html__('Button Position', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'fixed',
                'label_block' => false,
                'render_type' => 'template',
                'options' => [
                    'fixed' => esc_html__('Fixed', 'magical-addons-for-elementor'),
                    'inline' => esc_html__('Inline', 'magical-addons-for-elementor'),
                ],
                'prefix_class' => 'mg-sct-btn-align-',
            ]
        );

        $this->add_responsive_control(
            'button_position_inline',
            [
                'label' => esc_html__('Inline Position', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'center',
                'label_block' => false,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-sct-wrapper' => 'justify-content: {{VALUE}}',
                ],

                'separator' => 'before',
                'condition' => [
                    'button_position' => 'inline',
                ],
            ]
        );

        $this->add_control(
            'button_position_fixed',
            [
                'label' => esc_html__('Fixed Position', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'right',
                'label_block' => false,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'separator' => 'before',
                'default' => 'right',
                'condition' => [
                    'button_position' => 'fixed',
                ],
                'prefix_class' => 'mg-sct-btn-align-fixed-',
            ]
        );

        $this->add_responsive_control(
            'distance_x_right',
            [
                'label' => esc_html__('Distance Right', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}}.mg-sct-btn-align-fixed-right .mg-sct-btn' => 'right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'button_position' => 'fixed',
                    'button_position_fixed' => 'right',
                ],
            ]
        );
        $this->add_responsive_control(
            'distance_y_right',
            [
                'label' => esc_html__('Distance Bottom', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}}.mg-sct-btn-align-fixed-right .mg-sct-btn' => 'bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'button_position' => 'fixed',
                    'button_position_fixed' => 'right',
                ],
            ]
        );

        $this->add_responsive_control(
            'distance_x_left',
            [
                'label' => esc_html__('Distance Left', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}}.mg-sct-btn-align-fixed-left .mg-sct-btn' => 'left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'button_position' => 'fixed',
                    'button_position_fixed' => 'left',
                ],
            ]
        );

        $this->add_responsive_control(
            'distance_y_left',
            [
                'label' => esc_html__('Distance Bottom', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}}.mg-sct-btn-align-fixed-left .mg-sct-btn' => 'bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'button_position' => 'fixed',
                    'button_position_fixed' => 'left',
                ],
            ]
        );

        $this->add_control(
            'select_icon',
            [
                'label' => esc_html__('Select Icon', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'label_block' => false,
                'default' => [
                    'value' => 'fas fa-chevron-up',
                    'library' => 'fa-solid',
                ],
                'separator' => 'before',
                'recommended' => [
                    'fa-solid' => [
                        'arrow-up',
                        'arrow-circle-up',
                        'chevron-up',
                    ],
                ],
            ]
        );

        $this->add_control(
            'button_txt_show',
            [
                'label' => __('Button Text', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'magical-addons-for-elementor'),
                'label_off' => __('Hide', 'magical-addons-for-elementor'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );


        $this->add_control(
            'icon_layout_select',
            [
                'label' => esc_html__('Icon Align', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'left',
                'label_block' => false,
                'options' => [
                    'top' => esc_html__('Top', 'magical-addons-for-elementor'),
                    'bottom' => esc_html__('Bottom', 'magical-addons-for-elementor'),
                    'right' => esc_html__('Right', 'magical-addons-for-elementor'),
                    'left' => esc_html__('Left', 'magical-addons-for-elementor'),
                ],
                'condition' => [
                    'select_icon[value]!' => '',
                    'button_txt_show' => 'yes',
                ],
                'prefix_class' => 'mg-sct-btn-icon-',
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Text', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => 'Scroll To Top',
                'condition' => [
                    'button_txt_show' => 'yes',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_settings',
            [
                'label' => esc_html__('Settings', 'magical-addons-for-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'animation_type_select',
            [
                'label' => esc_html__('Animation', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'fade',
                'label_block' => false,
                'options' => [
                    'fade' => esc_html__('Fade', 'magical-addons-for-elementor'),
                    'slide' => esc_html__('Slide', 'magical-addons-for-elementor'),
                    'none' => esc_html__('None', 'magical-addons-for-elementor'),
                ],
                'separator' => 'before',
                'condition' => [
                    'button_position' => 'fixed',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_offset',
            [
                'label' => esc_html__('Show after page scroll (px)', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 0,
                'min' => 0,
                'condition' => [
                    'button_position' => 'fixed',
                ],
            ]
        );

        $this->add_control(
            'stt_animation_duration',
            [
                'label' => esc_html__('Show up speed', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 200,
                'min' => 0,
                'condition' => [
                    'button_position' => 'fixed',
                    'animation_type_select!' => 'none',
                ],
            ]
        );
        $this->add_control(
            'stt_animation_duration_top',
            [
                'label' => esc_html__('Scrolling animation Speed', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'default' => 800,
                'min' => 0,
            ]
        );
        $this->end_controls_section();
        $this->link_pro_added();

        // Section Button ------------
        $this->start_controls_section(
            'section_style_button',
            [
                'label' => esc_html__('Button', 'magical-addons-for-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->start_controls_tabs('tabs_stt_button_colors');

        // Normal Tab ------------
        $this->start_controls_tab(
            'tab_stt_button_normal_colors',
            [
                'label' => esc_html__('Normal', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => esc_html__(' Color', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .mg-sct-content' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .mg-sct-icon' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .mg-sct-icon svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'button_bg_color',
                'label' => esc_html__('Background', 'magical-addons-for-elementor'),
                'types' => ['classic', 'gradient', 'video'],
                'default' => '#000',
                'selector' => '{{WRAPPER}} .mg-sct-btn',
            ]
        );




        $this->add_control(
            'button_border_color',
            [
                'label' => esc_html__('Border Color', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#E8E8E8',
                'selectors' => [
                    '{{WRAPPER}} .mg-sct-btn' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
                    'border_switcher' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow',
                'label' => __('Box Shadow', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .mg-sct-btn',
            ]
        );

        $this->end_controls_tab(); // normal tab end

        // Hover Tab -------------
        $this->start_controls_tab(
            'tab_button_hover_colors',
            [
                'label' => esc_html__('Hover', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'button_texte_color_hover',
            [
                'label' => esc_html__('Color', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .mg-sct-btn:hover > .mg-sct-icon' => 'Color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_bg_color_hover',
            [
                'label' => esc_html__('Background', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#264d59',
                'selectors' => [
                    '{{WRAPPER}} .mg-sct-btn:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_border_color_hover',
            [
                'label' => esc_html__('Border Color', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '#E8E8E8',
                'selectors' => [
                    '{{WRAPPER}} .mg-sct-btn:hover' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
                    'border_switcher' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow_hover',
                'label' => __('Box Shadow', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .mg-sct-btn:hover',
            ]
        );

        $this->end_controls_tab(); // hover tab end

        $this->end_controls_tabs(); // End tabs

        $this->add_control(
            'hover_animation_hover_duration',
            [
                'label' => __('Hover Animation Duration', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 5,
                'step' => 0.1,
                'default' => 0.3,
                'selectors' => [
                    '{{WRAPPER}} .mg-sct-btn' => 'transition:  all  {{VALUE}}s ease-in-out 0s;',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'scheme' => Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .mg-sct-content,{{WRAPPER}} .mg-sct-content::after',
                'separator' => 'before',
                'condition' => [
                    'button_txt_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 14,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-sct-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mg-sct-icon svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
                'condition' => [
                    'select_icon[value]!' => '',
                ],
            ]
        );
        $this->add_control(
            'icon_distanz',
            [
                'label' => esc_html__('Icon Distance', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 25,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 18,
                ],
                'selectors' => [
                    '{{WRAPPER}}.mg-sct-btn-icon-top .mg-sct-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.mg-sct-btn-icon-left .mg-sct-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.mg-sct-btn-icon-right .mg-sct-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.mg-sct-btn-icon-bottom .mg-sct-icon' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
                'condition' => [
                    'select_icon[value]!' => '',
                    'button_txt_show' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__('Padding', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default' => [
                    'top' => 15,
                    'right' => 15,
                    'bottom' => 15,
                    'left' => 15,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-sct-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'border_switcher',
            [
                'label' => esc_html__('Border', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
                'return_value' => 'yes',
                'label_block' => false,

            ]
        );

        $this->add_control(
            'button_border_type',
            [
                'label' => esc_html__('Border Type', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => esc_html__('None', 'magical-addons-for-elementor'),
                    'solid' => esc_html__('Solid', 'magical-addons-for-elementor'),
                    'double' => esc_html__('Double', 'magical-addons-for-elementor'),
                    'dotted' => esc_html__('Dotted', 'magical-addons-for-elementor'),
                    'dashed' => esc_html__('Dashed', 'magical-addons-for-elementor'),
                    'groove' => esc_html__('Groove', 'magical-addons-for-elementor'),
                ],
                'default' => 'solid',
                'selectors' => [
                    '{{WRAPPER}} .mg-sct-btn' => 'border-style: {{VALUE}};',
                ],
                'condition' => [
                    'border_switcher' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'border_width',
            [
                'label' => esc_html__('Border Width', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default' => [
                    'top' => 1,
                    'right' => 1,
                    'bottom' => 1,
                    'left' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-sct-btn' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
                'condition' => [
                    'border_switcher' => 'yes',
                    'button_border_type!' => 'none',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => 2,
                    'right' => 2,
                    'bottom' => 2,
                    'left' => 2,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-sct-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'after',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        // Get Settings
        $settings = $this->get_settings();

        // Widget JSON Settings
        $stt_settings = [
            'animation'         => $settings['animation_type_select'],
            'animationOffset'     => $settings['button_offset'],
            'animationDuration' => $settings['stt_animation_duration'],
            'fixed' => $settings['button_position'],
            'scrolAnim' => $settings['stt_animation_duration_top'],

        ];


        echo '<div class="mg-sct-wrapper">';
        echo "<div class='mg-sct-btn' data-settings='" . wp_json_encode($stt_settings) . "'>";

        if ('' !== $settings['select_icon']['value']) {
            echo '<span class="mg-sct-icon">';
            \Elementor\Icons_Manager::render_icon($settings['select_icon']);
            echo '</span>';
        }

        if ('' !== $settings['button_text'] && $settings['button_txt_show'] == 'yes') {
            echo '<div class="mg-sct-content">' .  esc_html($settings['button_text']) . '</div>';
        }

        echo '</div>';
        echo '</div>';
    }
}
