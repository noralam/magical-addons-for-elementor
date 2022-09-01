<?php


class MgAddon_Card_Widget extends \Elementor\Widget_Base
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
        return 'mgcard_widget';
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
        return __('MG Card', 'magical-addons-for-elementor');
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
        return 'eicon-image-box';
    }

    public function get_keywords()
    {
        return ['card', 'image', 'grid', 'box', 'mg'];
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
            'mg_img_section',
            [
                'label' => __('Card Image', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mg_card_img_show',
            [
                'label' => __('Show Image?', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'mg_card_img',
            [
                'label' => __('Choose Image', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => ['mg_card_img_show' => 'yes'],

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'default' => 'medium_large',
                'separator' => 'none',
                'exclude' => [
                    'full',
                    'custom',
                    'large',
                    'shop_catalog',
                    'shop_single',
                    'shop_thumbnail'
                ],
                'condition' => ['mg_card_img_show' => 'yes'],


            ]
        );
        $this->add_control(
            'mg_img_position',
            [
                'label' => __('Image position', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'magical-addons-for-elementor'),
                        'icon' => 'fas fa-arrow-left',
                    ],
                    'top' => [
                        'title' => __('Top', 'magical-addons-for-elementor'),
                        'icon' => 'fas fa-arrow-up',
                    ],
                    'right' => [
                        'title' => __('Right', 'magical-addons-for-elementor'),
                        'icon' => 'fas fa-arrow-right',
                    ],

                ],
                'default' => 'top',
                'toggle' => false,
                'prefix_class' => 'mg-card-img-',
                'style_transfer' => true,
                'condition' => ['mg_card_img_show' => 'yes'],

            ]

        );

        $this->end_controls_section();
        $this->start_controls_section(
            'mg_card_content',
            [
                'label' => __('Card Content', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'mg_card_title',
            [
                'label'       => __('Title', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => __('Enter Card Title', 'magical-addons-for-elementor'),
                'default'     => __('Card Title', 'magical-addons-for-elementor'),
                'label_block'     => true,

            ]
        );
        $this->add_control(
            'mg_card_title_tag',
            [
                'label' => __('Title HTML Tag', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                    'p' => 'p',
                ],
                'default' => 'h2',
            ]
        );

        $this->add_control(
            'mg_card_desc',
            [
                'label'       => __('Description', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'input_type'  => 'text',
                'placeholder' => __('Card description goes here.', 'magical-addons-for-elementor'),
                'default'     => __('dummy text you can edit or remove it. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempo.', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_responsive_control(
            'mg_card_text_align',
            [
                'label' => __('Alignment', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-text-align-right',
                    ],

                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .mg-card-text' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mg_card_badge',
            [
                'label' => __('Badge', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'card_badge_use',
            [
                'label' => __('Use Card Badge?', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'default' => '',
            ]
        );
        $this->add_control(
            'badge_text',
            [
                'label'       => __('Badge Text', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => __('Badge Text', 'magical-addons-for-elementor'),
                'default'     => __('Badge', 'magical-addons-for-elementor'),
                'condition' => [
                    'card_badge_use' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
            'badge_position',
            [
                'label' => __('Badge Position', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left-top' => [
                        'title' => __('Left Top', 'magical-addons-for-elementor'),
                        'icon' => 'fas fa-arrow-up',
                    ],
                    'left-bottom' => [
                        'title' => __('Left Bottom', 'magical-addons-for-elementor'),
                        'icon' => 'fas fa-arrow-down',
                    ],
                    'right-top' => [
                        'title' => __('Right Top', 'magical-addons-for-elementor'),
                        'icon' => 'fas fa-arrow-up',
                    ],
                    'right-bottom' => [
                        'title' => __('Right Bottom', 'magical-addons-for-elementor'),
                        'icon' => 'fas fa-arrow-right',
                    ],

                ],
                'default' => 'right-bottom',
                'condition' => [
                    'card_badge_use' => 'yes',
                ],

            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mg_card_button',
            [
                'label' => __('Button', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mg_card_btn_use',
            [
                'label' => __('Use Card Button?', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mg_card_btn_title',
            [
                'label'       => __('Button Title', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => __('Button Text', 'magical-addons-for-elementor'),
                'default'     => __('Read More', 'magical-addons-for-elementor'),
            ]
        );
        $this->add_control(
            'mg_card_btn_link',
            [
                'label' => __('Button Link', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'magical-addons-for-elementor'),
                'default' => [
                    'url' => '#',
                ],
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'mg_card_usebtn_icon',
            [
                'label' => __('Use icon', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'default' => 'no',
            ]
        );

        $this->add_control(
            'mg_card_btn_selected_icon',
            [
                'label' => __('Choose Icon', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::ICONS,
                /*'default' => [
						'value' => 'fas fa-chevron-right',
						'library' => 'solid',
					],*/
                'condition' => [
                    'mg_card_usebtn_icon' => 'yes',
                ],
            ]
        );





        $this->add_responsive_control(
            'mg_cardbtn_icon_position',
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
                    'mg_card_usebtn_icon' => 'yes',
                ],

            ]
        );
        $this->add_responsive_control(
            'mg_cardbtn_iconspace',
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
                    'mg_card_usebtn_icon' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-card .mg-card-btn i.left,{{WRAPPER}} .mg-card .mg-card-btn .left i' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mg-card .mg-card-btn i.right, {{WRAPPER}} .mg-card .mg-card-btn .right i' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

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
            'mg_card_content_padding',
            [
                'label' => __('Content Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-card-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mg_card_content_margin',
            [
                'label' => __('Content Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-card-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mg_card_content_bg_color',
            [
                'label' => __('Card Background color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_card_content_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mg_card_content_border',
                'selector' => '{{WRAPPER}} .mg-card',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mg_card_content_shadow',
                'selector' => '{{WRAPPER}}.elementor-widget-mgcard_widget .elementor-widget-container'
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'mg_card_img_style',
            [
                'label' => __('Image style', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['mg_card_img_show' => 'yes'],

            ]
        );
        $this->add_responsive_control(
            'image_width_set',
            [
                'label' => __('Width', 'magical-addons-for-elementor'),
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
                    '{{WRAPPER}} .mg-card-img' => 'flex: 0 0 {{SIZE}}{{UNIT}}; max-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.mg-card-img-right .mg-card-text, {{WRAPPER}}.mg-card-img-left .mg-card-text' => 'flex: 0 0 calc(100% - {{SIZE || 50}}{{UNIT}}); max-width: calc(100% - {{SIZE || 50}}{{UNIT}});',
                ],
            ]
        );

        $this->add_control(
            'mg_card_img_auto_height',
            [
                'label' => __('Image auto height', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('On', 'magical-addons-for-elementor'),
                'label_off' => __('Off', 'magical-addons-for-elementor'),
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mg_card_img_height',
            [
                'label' => __('Image Height', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ]
                ],
                'condition' => [
                    'mg_card_img_auto_height!' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-card-img figure img, .mg-card-style2 .card-bg-img img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mg_card_imgbg_height',
            [
                'label' => __('Image div Height', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ]
                ],
                'condition' => [
                    'mg_card_img_auto_height!' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-card-img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mg_card_img_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-card-img figure' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mg_card_img_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-card-img figure' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mg_card_img_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-card-img figure img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->add_control(
            'mg_card_imgbg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mg-card-img' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mg_card_img_border',
                'selector' => '{{WRAPPER}} .mg-card-img figure img',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mg_card_card_details_style',
            [
                'label' => __('Card Title', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mg_card_title_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-card-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mg_card_title_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-card-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mg_card_title_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-card-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_card_title_bgcolor',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-card-title' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_card_descb_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-card-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mg_card_title_typography',
                'selector' => '{{WRAPPER}} .mg-card-title',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mgtm_card_description_style',
            [
                'label' => __('Description', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mg_card_description_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-card-text p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mg_card_description_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-card-text p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mg_card_description_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-card-text p' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_card_description_bgcolor',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-card-text p' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_card_description_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-card-text p' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mg_card_description_typography',
                'selector' => '{{WRAPPER}} .mg-card-text p',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'mgbtn_badge_style',
            [
                'label' => __('Badge', 'magical-addons-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'card_badge_use' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgcard_badge_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} span.mgc-badge' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgcard_badge_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} span.mgc-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mgcard_badge_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} span.mgc-badge' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgcard_badge_bgcolor',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} span.mgc-badge' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgcard_badge_typography',
                'selector' => '{{WRAPPER}} span.mgc-badge',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgcard_badge_border',
                'selector' => '{{WRAPPER}} span.mgc-badge',
            ]
        );

        $this->add_control(
            'mgcard_badge_bradius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} span.mgc-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgcard_badge_bshadow',
                'selector' => '{{WRAPPER}} span.mgc-badge',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'mgbtn_card_style',
            [
                'label' => __('Button', 'magical-addons-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgcard_btn_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-card-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgcard_btn_typography',
                'selector' => '{{WRAPPER}} .mg-card-btn',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgcard_btn_border',
                'selector' => '{{WRAPPER}} .mg-card-btn',
            ]
        );

        $this->add_control(
            'mgcard_btn_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-card-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgcard_btn_box_shadow',
                'selector' => '{{WRAPPER}} .mg-card-btn',
            ]
        );
        $this->add_control(
            'mgcard_button_color',
            [
                'label' => __('Button color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('infobox_btn_tabs');

        $this->start_controls_tab(
            'mgcard_btn_normal_style',
            [
                'label' => __('Normal', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'mgcard_btn_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mg-card-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgcard_btn_bg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-card-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'mgcard_btn_hover_style',
            [
                'label' => __('Hover', 'magical-addons-for-elementor'),
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgcard_btnhover_boxshadow',
                'selector' => '{{WRAPPER}} .mg-card-btn:hover',
            ]
        );

        $this->add_control(
            'mgcard_btn_hcolor',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-card-btn:hover, {{WRAPPER}} .mg-card-btn:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgcard_btn_hbg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-card-btn:hover, {{WRAPPER}} .mg-card-btn:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgcard_btn_hborder_color',
            [
                'label' => __('Border Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'condition' => [
                    'mgcard_btn_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-card-btn:hover, {{WRAPPER}} .mg-card-btn:focus' => 'border-color: {{VALUE}};',
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

        //card name
        $mg_card_title = $this->get_settings('mg_card_title');
        $mg_card_title_tag = $this->get_settings('mg_card_title_tag');
        $this->add_inline_editing_attributes('mg_card_title');
        $this->add_render_attribute('mg_card_title', 'class', 'mg-card-title');
        //description
        $mg_card_img = $this->get_settings('mg_card_img');
        $mg_card_desc = $this->get_settings('mg_card_desc');
        $this->add_inline_editing_attributes('mg_card_desc');





?>
        <div class="mg-card">
            <?php if ($settings['mg_card_img_show'] && ($mg_card_img['url'] || $mg_card_img['id'])) : ?>
                <div class="mg-card-img">
                    <figure>
                        <?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'mg_card_img'); ?>
                    </figure>
                    <?php if ($settings['card_badge_use']) : ?>
                        <span class="mgc-badge mgcb-<?php echo esc_attr($settings['badge_position']); ?>"><?php echo mg_kses_tags($settings['badge_text']); ?></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <div class="mg-card-text">

                <?php
                if ($mg_card_title) :
                    printf(
                        '<%1$s %2$s>%3$s</%1$s>',
                        tag_escape($mg_card_title_tag),
                        $this->get_render_attribute_string('mg_card_title'),
                        mg_kses_tags($mg_card_title)
                    );
                endif;
                ?>
                <?php if ($mg_card_desc) : ?>
                    <p <?php echo $this->get_render_attribute_string('mg_card_desc'); ?>><?php echo wp_kses_post($mg_card_desc); ?></p>
                <?php endif; ?>
                <?php $this->mgbutton_icon(); ?>

            </div>

        </div>



    <?php
    }

    protected function content_template()
    {
    ?>
        <# var iconHTML=elementor.helpers.renderIcon( view, settings.mg_card_btn_selected_icon, { 'aria-hidden' : true }, 'i' , 'object' ), migrated=elementor.helpers.isIconMigrated( settings, 'mg_card_btn_selected_icon' ); view.addInlineEditingAttributes( 'mg_card_title' ); view.addRenderAttribute( 'mg_card_title' , 'class' , 'mg-card-title' ); view.addInlineEditingAttributes( 'mg_card_desc' ); view.addInlineEditingAttributes( 'mg_card_btn_title' , 'none' ); view.addRenderAttribute( 'mg_card_btn_title' , 'class' , 'mg-btn mg-card-btn' ); view.addRenderAttribute( 'mg_card_btn_title' , 'href' , settings.mg_card_btn_link.url ); if ( settings.mg_card_img.url || settings.mg_card_img.id ) { var image={ id: settings.mg_card_img.id, url: settings.mg_card_img.url, size: settings.thumbnail_size, dimension: settings.thumbnail_custom_dimension, model: view.getEditModel() }; var image_url=elementor.imagesManager.getImageUrl( image ); } #>

            <div class="mg-card">
                <# if ( settings.mg_card_img_show &&( settings.mg_card_img.url || settings.mg_card_img.id) ) { #>
                    <div class="mg-card-img">
                        <figure>
                            <img alt="Card Image" src="{{ image_url }}">
                        </figure>
                        <# if(settings.card_badge_use ){ #>
                            <span class="mgc-badge mgcb-{{{ settings.badge_position }}}">{{{ settings.badge_text }}}</span>
                            <# } #>
                    </div>
                    <# } #>
                        <div class="mg-card-text">
                            <# if (settings.mg_card_title) { #>
                                <{{ settings.mg_card_title_tag }} {{{ view.getRenderAttributeString( 'mg_card_title' ) }}}>{{{ settings.mg_card_title }}}</{{ settings.mg_card_title_tag }}>
                                <# } #>


                                    <# if (settings.mg_card_desc) { #>
                                        <p {{{ view.getRenderAttributeString( 'mg_card_desc' ) }}}>{{{ settings.mg_card_desc }}}</p>
                                        <# } #>



                                            <# if (settings.mg_card_btn_use) { #>
                                                <# if (settings.mg_card_usebtn_icon==='yes' ) { #>
                                                    <a {{{ view.getRenderAttributeString( 'mg_card_btn_title' ) }}}>
                                                        <# if (settings.mg_cardbtn_icon_position==='left' ) { #>
                                                            <span class="left">
                                                                {{{ iconHTML.value }}}
                                                            </span>
                                                            <# } #>
                                                                <span>{{{ settings.mg_card_btn_title }}}</span>
                                                                <# if (settings.mg_cardbtn_icon_position==='right' ) { #>
                                                                    <span class="right">
                                                                        {{{ iconHTML.value }}}
                                                                    </span>
                                                                    <# } #>
                                                    </a>
                                                    <# }else{ #>
                                                        <a {{{ view.getRenderAttributeString( 'mg_card_btn_title' ) }}}>{{{ settings.mg_card_btn_title }}}</a>
                                                        <# } #>
                                                            <# } #>
                        </div>

            </div>

    <?php
    }
}
