<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

//mgdb_img_height ,,  Image Height Not worrking

class MgAddon_Dual_Button extends \Elementor\Widget_Base
{
    use mgGlobalButton;
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
        return 'mg_dual_button_widget';
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
        return __('MG Dual Button', 'magical-addons-for-elementor');
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
        return 'eicon-dual-button';
    }

    public function get_keywords()
    {
        return ['dual', 'button', 'dual button', 'mg dual', 'mg'];
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
            'mg_db_button_styles',
            [
                'label' => __('Button Style', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mg_db_styles',
            [
                'label' => __('Select Style', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'style1' => __('Style One', 'magical-addons-for-elementor'),
                    'style2' => __('Style Two', 'magical-addons-for-elementor'),

                ],
                'default' => 'style1',

            ]

        );

        $this->add_control(
            'mg_db_show_btn_joint',
            [
                'label' => __('Show Dual BTN Connector?', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'default' => 'yes',
                'condition' => [
                    'mg_db_styles' => 'style1',
                ],
            ]
        );
        $this->add_control(
            'mg_db_btn_con_title',
            [
                'label'       => __('Connector Text', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => __('Connector Text', 'magical-addons-for-elementor'),
                'default'     => __('OR', 'magical-addons-for-elementor'),
                'condition' => [
                    'mg_db_show_btn_joint' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgdb_btn_content_align',
            [
                'label' => __('Button Alignment', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __('Left', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => __('Right', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-text-align-right',
                    ],

                ],
                'default' => 'flex-start',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .mg-db-btn' => 'justify-content: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();



        $this->start_controls_section(
            'mg_db_button',
            [
                'label' => __('Button', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'mg_db_btn_use',
            [
                'label' => __('Use Button?', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mg_db_btn_title',
            [
                'label'       => __('Button Title', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => __('Button Text', 'magical-addons-for-elementor'),
                'default'     => __('VIEW DEALS', 'magical-addons-for-elementor'),
                'condition' => [
                    'mg_db_btn_use' => 'yes',
                ],
            ]
        );




        $this->add_control(
            'mg_db_btn_link',
            [
                'label' => __('Button Link', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'magical-addons-for-elementor'),
                'default' => [
                    'url' => '#',
                ],
                'separator' => 'before',
                'condition' => [
                    'mg_db_btn_use' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'mg_db_usebtn_icon',
            [
                'label' => __('Use icon', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'default' => 'yes',
                'condition' => [
                    'mg_db_btn_use' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'mg_db_btn_selected_icon',
            [
                'label' => __('Choose Icon', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-long-arrow-alt-right',
                    'library' => 'solid',
                ],
                'condition' => [
                    'mg_db_usebtn_icon' => 'yes',
                    'mg_db_btn_use' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mg_flipbtn_icon_position',
            [
                'label' => __('Button Icon Position', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'magical-addons-for-elementor'),
                        'icon' => 'fas fa-arrow-left',
                    ],
                    'right' => [
                        'title' => __('Right', 'magical-addons-for-elementor'),
                        'icon' => 'fas fa-arrow-right',
                    ],

                ],
                'default' => 'right',
                'condition' => [
                    'mg_db_usebtn_icon' => 'yes',
                    'mg_db_btn_use' => 'yes',
                ],

            ]
        );

        $this->start_controls_tabs('mgdb_container');

        $this->start_controls_tab(
            'mgdb_btn_normal_style',
            [
                'label' => __('Normal', 'magical-addons-for-elementor'),

                'condition' => [
                    'mg_db_usebtn_icon' => 'yes',
                    'mg_db_btn_use' => 'yes',
                ],
            ]
        );


        $this->add_responsive_control(
            'mg_flipbtn_iconspace',
            [
                'label' => __('Icon Spacing', 'magical-addons-for-elementor'),
                'type' => Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],

                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 3,
                ],
                'condition' => [
                    'mg_db_usebtn_icon' => 'yes',
                    'mg_db_btn_use' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-dual-btn .left i' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mg-dual-btn .right i' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();


        $this->start_controls_tab(
            'mgdb_btn_hover_style',
            [
                'label' => __('Hover', 'magical-addons-for-elementor'),

                'condition' => [
                    'mg_db_usebtn_icon' => 'yes',
                    'mg_db_btn_use' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mg_flipbtn_hover_iconspace',
            [
                'label' => __('Icon Spacing', 'magical-addons-for-elementor'),
                'type' => Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],

                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 5,
                ],
                'condition' => [
                    'mg_db_usebtn_icon' => 'yes',
                    'mg_db_btn_use' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-dual-btn:hover .left i' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mg-dual-btn:hover .right i' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();


        $this->end_controls_section();



        $this->start_controls_section(
            'mg_db_button2',
            [
                'label' => __('2nd Button', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mg_db_btn2_use',
            [
                'label' => __('Use Button?', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mg_db_btn2_title',
            [
                'label'       => __('Button Title', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => __('Button Text', 'magical-addons-for-elementor'),
                'default'     => __('VIEW DEALS', 'magical-addons-for-elementor'),
                'condition' => [
                    'mg_db_btn2_use' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mg_db_btn2_link',
            [
                'label' => __('Button Link', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'magical-addons-for-elementor'),
                'default' => [
                    'url' => '#',
                ],
                'condition' => [
                    'mg_db_btn2_use' => 'yes',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'mg_db_usebtn2_icon',
            [
                'label' => __('Use icon', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'default' => 'yes',
                'condition' => [
                    'mg_db_btn2_use' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'mg_db_btn2_selected_icon',
            [
                'label' => __('Choose Icon', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-long-arrow-alt-right',
                    'library' => 'solid',
                ],
                'condition' => [
                    'mg_db_usebtn2_icon' => 'yes',
                    'mg_db_btn2_use' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mg_flipbtn2_icon_position',
            [
                'label' => __('Button Icon Position', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'magical-addons-for-elementor'),
                        'icon' => 'fas fa-arrow-left',
                    ],
                    'right' => [
                        'title' => __('Right', 'magical-addons-for-elementor'),
                        'icon' => 'fas fa-arrow-right',
                    ],

                ],
                'default' => 'right',
                'condition' => [
                    'mg_db_usebtn2_icon' => 'yes',
                    'mg_db_btn2_use' => 'yes',
                ],
            ]
        );

        $this->start_controls_tabs('mgdb2_container');

        $this->start_controls_tab(
            'mgdb_btn2_normal_style',
            [
                'label' => __('Normal', 'magical-addons-for-elementor'),
                'condition' => [
                    'mg_db_btn2_use' => 'yes',
                ],
            ]
        );


        $this->add_responsive_control(
            'mg_flipbtn2_iconspace',
            [
                'label' => __('Icon Spacing', 'magical-addons-for-elementor'),
                'type' => Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],

                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 3,
                ],
                'condition' => [
                    'mg_db_usebtn2_icon' => 'yes',
                    'mg_db_btn2_use' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-dual-btn2 .left i' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mg-dual-btn2 .right i' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();


        $this->start_controls_tab(
            'mgdb_btn2_hover_style',
            [
                'label' => __('Hover', 'magical-addons-for-elementor'),
                'condition' => [
                    'mg_db_btn2_use' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mg_flipbtn2_hover_iconspace',
            [
                'label' => __('Icon Spacing', 'magical-addons-for-elementor'),
                'type' => Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],

                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 5,
                ],
                'condition' => [
                    'mg_db_usebtn2_icon' => 'yes',
                    'mg_db_btn2_use' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}}  .mg-dual-btn2:hover .left i' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mg-dual-btn2:hover .right i' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();


        $this->end_controls_section();
        $this->link_pro_added();
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
            'mg_card_basic_style',
            [
                'label' => __('Basic style', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgdb_content_padding',
            [
                'label' => __('Content Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-db-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgdb_content_margin',
            [
                'label' => __('Content Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-db-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgdb_content_bg_color',
                'label' => esc_html__('Background', 'magical-addons-for-elementor'),
                'types' => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .mg-db-btn',
            ]
        );

        $this->add_control(
            'mgdb_content_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-db-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgdb_content_border',
                'selector' => '{{WRAPPER}} .mg-db-btn',
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgdb_block_shadow',
                'exclude' => [
                    'box_shadow_position',
                ],
                'selector' => '{{WRAPPER}} .mg-db-btn',
            ]
        );

        $this->end_controls_section();



        $this->start_controls_section(
            'mgcal_bas_style',
            [
                'label' => __('Background Overly', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mg_background_overlay',
                'selector' => '{{WRAPPER}} .mg-db-btn:before',
            ]
        );

        $this->add_control(
            'mg_background_overlay_opacity',
            [
                'label' => __('Opacity', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => .5,
                ],
                'range' => [
                    'px' => [
                        'max' => 1,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-db-btn:before' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'mg_overly_css_filters',
                'selector' => '{{WRAPPER}} .mg-db-btn:before',
            ]
        );

        $this->end_controls_section();





        $this->start_controls_section(
            'mg_db_conn',
            [
                'label' => __('Button Connector', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );



        $this->add_responsive_control(
            'mg_db_conn_top',
            [
                'label' => esc_html__('Top', 'magical-addons-for-elementor'),
                'type' =>  \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'desktop_default' => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-db-btn.style-one span.mg-joint-btn' => 'top: {{SIZE}}{{UNIT}} !important;',

                ],
            ]
        );

        $this->add_responsive_control(
            'mg_db_conn_right',
            [
                'label' => esc_html__('Right', 'magical-addons-for-elementor'),
                'type' =>  \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'desktop_default' => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'range' => [
                    '%' => [
                        'max' => 100,
                    ],
                ],

                'selectors' => [
                    '{{WRAPPER}} .mg-db-btn.style-one span.mg-joint-btn' => 'right: {{SIZE}}{{UNIT}} !important;',

                ],
            ]
        );

        $this->add_responsive_control(
            'mg_db_conn_width',
            [
                'label' => esc_html__('Width', 'magical-addons-for-elementor'),
                'type' =>  \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ]
                ],

                'default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-db-btn.style-one span.mg-joint-btn' => 'width: {{SIZE}}{{UNIT}} !important;',

                ],
            ]
        );

        $this->add_control(
            'mg_dual_con_height',
            [
                'label' => esc_html__('Height', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-db-btn.style-one span.mg-joint-btn' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_control(
            'mg_db_conn_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-db-btn.style-one span.mg-joint-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mg_db_conn_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mg-db-btn.style-one span.mg-joint-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mg_db_conn_bg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-db-btn.style-one span.mg-joint-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mg_db_conn_typography',
                'selector' => '{{WRAPPER}} .mg-db-btn.style-one span.mg-joint-btn',
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_4,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mg_db_conn_border',
                'selector' => '{{WRAPPER}} .mg-db-btn.style-one span.mg-joint-btn',
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mg_db_conn_box_shadow',
                'selector' => '{{WRAPPER}} .mg-db-btn.style-one span.mg-joint-btn',
            ]
        );







        $this->end_controls_section();



        $this->start_controls_section(
            'mgbtn_card_style',
            [
                'label' => __('Button', 'magical-addons-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'mg_db_btn_use' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgflip_btn_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} a.mg-dual-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgflip_btn_typography',
                'selector' => '{{WRAPPER}} a.mg-dual-btn',
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_4,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgflip_btn_border',
                'selector' => '{{WRAPPER}} a.mg-dual-btn',
            ]
        );

        $this->add_control(
            'mgflip_btn_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} a.mg-dual-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgflip_btn_box_shadow',
                'selector' => '{{WRAPPER}} a.mg-dual-btn',
            ]
        );
        $this->add_control(
            'mgflip_button_color',
            [
                'label' => __('Button color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('infobox_btn_tabs');

        $this->start_controls_tab(
            'mgflip_btn_normal_style',
            [
                'label' => __('Normal', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'mgflip_btn_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} a.mg-dual-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgflip_btn_bg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.mg-dual-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'mgflip_btn_hover_style',
            [
                'label' => __('Hover', 'magical-addons-for-elementor'),
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgflip_btnhover_boxshadow',
                'selector' => '{{WRAPPER}} a.mg-dual-btn:hover',
            ]
        );

        $this->add_control(
            'mgflip_btn_hcolor',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.mg-dual-btn:hover, {{WRAPPER}} a.mg-dual-btn:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgflip_btn_hbg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.mg-dual-btn:hover, {{WRAPPER}} a.mg-dual-btn:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgflip_btn_hborder_color',
            [
                'label' => __('Border Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'condition' => [
                    'mgflip_btn_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} a.mg-dual-btn:hover, {{WRAPPER}} a.mg-dual-btn:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();



        $this->start_controls_section(
            'mg_btn2_card_style',
            [
                'label' => __('2nd Button', 'magical-addons-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'mg_db_btn2_use' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgflip_btn2_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-dual-btn2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgflip_btn2_typography',
                'selector' => '{{WRAPPER}} .mg-dual-btn2',
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_4,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgflip_btn2_border',
                'selector' => '{{WRAPPER}} .mg-dual-btn2',
            ]
        );

        $this->add_control(
            'mgflip_btn2_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-dual-btn2' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgflip_btn2_box_shadow',
                'selector' => '{{WRAPPER}} .mg-dual-btn2',
            ]
        );
        $this->add_control(
            'mgflip_button2_color',
            [
                'label' => __('Button color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('infobox_btn2_tabs');

        $this->start_controls_tab(
            'mgflip_btn2_normal_style',
            [
                'label' => __('Normal', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'mgflip_btn2_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mg-dual-btn2' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgflip_btn2_bg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-dual-btn2' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'mgflip_btn2_hover_style',
            [
                'label' => __('Hover', 'magical-addons-for-elementor'),
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgflip_btnhover2_boxshadow',
                'selector' => '{{WRAPPER}} .mg-dual-btn2:hover',
            ]
        );

        $this->add_control(
            'mgflip_btn2_hcolor',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-dual-btn2:hover, {{WRAPPER}} .mg-dual-btn2:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgflip_btn2_hbg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-dual-btn2:hover, {{WRAPPER}} .mg-dual-btn2:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgflip_btn2_hborder_color',
            [
                'label' => __('Border Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'condition' => [
                    'mgflip_btn_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-dual-btn2:hover, {{WRAPPER}} .mg-dual-btn2:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();
        $this->end_controls_tabs();

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
        $mg_db_styles = $settings['mg_db_styles'];
        if ($mg_db_styles == 'style1') {
            $this->mgdb_style_base_one($settings);
        } else {
            $this->mgdb_style_base_two($settings);
        }
    }


    public function mgdb_style_base_one($settings)
    {

        // Btn item    
        $mg_db_btn_use = $settings['mg_db_btn_use'];
        $mg_db_btn2_use = $settings['mg_db_btn2_use'];


?>


        <div class="mg-db-btn style-one">
            <?php
            if ($mg_db_btn_use && $mg_db_btn_use) {
                $this->mgf_button($settings, 1);
            }
            if ($mg_db_btn2_use && $mg_db_btn2_use) {
                $this->mgf_button($settings, 2);
            }
            ?>
        </div>



    <?php
    }


    public function mgdb_style_base_two($settings)
    {


        // Btn item    
        $mg_db_btn_use = $settings['mg_db_btn_use'];
        $mg_db_btn2_use = $settings['mg_db_btn2_use'];


    ?>

        <div class="mg-db-btn style-two">
            <?php
            if ($mg_db_btn_use && $mg_db_btn_use) {
                $this->mgf_button($settings, 1);
            }
            if ($mg_db_btn2_use && $mg_db_btn2_use) {
                $this->mgf_button($settings, 2);
            }
            ?>
        </div>



        <?php
    }



    protected function content_template()
    {
    }

    public function mgf_button($settings, $btn = 1)
    {
        if ($btn == 1) {
            $mg_flipbtn_icon_position = $settings['mg_flipbtn_icon_position'];
            $mg_db_usebtn_icon = $settings['mg_db_usebtn_icon'];
            $mg_db_usebtn2_icon = '';
            $mg_db_btn_title = $settings['mg_db_btn_title'];
            $mg_db_btn_con_title = $settings['mg_db_btn_con_title'];
            $mg_db_btn_link = $settings['mg_db_btn_link'];
            $mg_db_btn_selected_icon = $settings['mg_db_btn_selected_icon'];
            $this->add_inline_editing_attributes('mg_db_btn_title', 'none');
            $this->add_render_attribute('mg_db_btn_title', 'class', 'mg-dual-btn');

            $this->add_render_attribute('mg_db_btn_title', 'href', esc_url($mg_db_btn_link['url']));
            if (!empty($mg_db_btn_link['is_external'])) {
                $this->add_render_attribute('mg_db_btn_title', 'target', '_blank');
            }
            if (!empty($mg_db_btn_link['nofollow'])) {
                $this->set_render_attribute('mg_db_btn_title', 'rel', 'nofollow');
            }
            $btn_attr =  $this->get_render_attribute_string('mg_db_btn_title');
        } else {
            $mg_flipbtn_icon_position = $settings['mg_flipbtn2_icon_position'];
            $mg_db_usebtn2_icon = $settings['mg_db_usebtn2_icon'];
            $mg_db_usebtn_icon = '';
            $mg_db_btn_title = $settings['mg_db_btn2_title'];
            $mg_db_btn_con_title = $settings['mg_db_btn_con_title'];
            $mg_db_btn_link = $settings['mg_db_btn2_link'];
            $mg_db_btn_selected_icon = $settings['mg_db_btn2_selected_icon'];

            $this->add_inline_editing_attributes('mg_db_btn2_title', 'none');

            $this->add_render_attribute('mg_db_btn2_title', 'class', 'mg-dual-btn2');
            $this->add_render_attribute('mg_db_btn2_title', 'href', esc_url($mg_db_btn_link['url']));
            if (!empty($mg_db_btn_link['is_external'])) {
                $this->add_render_attribute('mg_db_btn2_title', 'target', '_blank');
            }
            if (!empty($mg_db_btn_link['nofollow'])) {
                $this->set_render_attribute('mg_db_btn2_title', 'rel', 'nofollow');
            }
            $btn_attr =  $this->get_render_attribute_string('mg_db_btn2_title');
        }




        if (($mg_db_usebtn_icon == 'yes' && $btn == 1) || ($mg_db_usebtn2_icon == 'yes' && $btn == 2)) :
        ?>
            <div class="mg-dual-btn-one">
                <a <?php echo $btn_attr; ?>>
                    <?php if ($mg_flipbtn_icon_position == 'left') : ?>
                        <span class="left"><?php \Elementor\Icons_Manager::render_icon($mg_db_btn_selected_icon); ?></span>

                    <?php endif; ?>
                    <span><?php echo mg_kses_tags($mg_db_btn_title); ?></span>
                    <?php if ($mg_flipbtn_icon_position == 'right') : ?>
                        <span class="right"><?php \Elementor\Icons_Manager::render_icon($mg_db_btn_selected_icon); ?></span>
                    <?php endif; ?>
                </a>

                <?php if ($btn == 1 && 'yes' === $settings['mg_db_show_btn_joint']) : ?>
                    <span class="mg-joint-btn"><?php echo mg_kses_tags($mg_db_btn_con_title); ?></span>
                <?php endif; ?>
            </div>
        <?php else : ?>
            <a <?php echo $btn_attr; ?>><?php echo  mg_kses_tags($mg_db_btn_title); ?></a>
            <?php if ($btn == 1 && 'yes' === $settings['mg_db_show_btn_joint']) : ?>
                <span class="mg-joint-btn"><?php echo mg_kses_tags($mg_db_btn_con_title); ?></span>
            <?php endif; ?>

        <?php endif; ?>
<?php

    }
}
