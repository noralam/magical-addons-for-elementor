<?php


class MgAddon_Pricing_Table extends \Elementor\Widget_Base
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
        return 'mgpricing_widget';
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
        return __('MG Pricing Table', 'magical-addons-for-elementor');
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
        return 'eicon-table-of-contents';
    }

    public function get_keywords()
    {
        return ['pricing', 'price', 'table', 'mg'];
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
            'mg_pr_icon_section',
            [
                'label' => __('Icon or Image', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mg_pr_use_icon',
            [
                'label' => __('Show Icon or image?', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'default' => 'no',
            ]
        );
        $this->add_control(
            'mg_pr_main_icon_position',
            [
                'label' => __('Icon position', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'magical-addons-for-elementor'),
                        'icon' => 'fas fa-arrow-left',
                    ],
                    'top' => [
                        'title' => __('Top', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'magical-addons-for-elementor'),
                        'icon' => 'fas fa-arrow-right',
                    ],

                ],
                'default' => 'top',
                'toggle' => false,
                'condition' => [
                    'mg_pr_use_icon' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'mg_pr_icon_type',
            [
                'label' => __('Icon Type', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'icon' => [
                        'title' => __('Icon', 'magical-addons-for-elementor'),
                        'icon' => 'fas fa-info',
                    ],
                    'image' => [
                        'title' => __('Image', 'magical-addons-for-elementor'),
                        'icon' => 'far fa-image',
                    ],

                ],
                'default' => 'icon',
                'toggle' => true,
                'condition' => [
                    'mg_pr_use_icon' => 'yes',
                ],
            ]
        );


        $this->add_control(
            'mg_pr_type_selected_icon',
            [
                'label' => __('Choose Icon', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'mg_pr_use_icon' => 'yes',
                    'mg_pr_icon_type' => 'icon',
                ],

            ]
        );


        $this->add_control(
            'mg_pr_type_image',
            [
                'label' => __('Choose Image', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'mg_pr_use_icon' => 'yes',
                    'mg_pr_icon_type' => 'image',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'mg_pr_thumbnail',
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
                'condition' => [
                    'mg_pr_use_icon' => 'yes',
                    'mg_pr_icon_type' => 'image'
                ]
            ]
        );
        $this->add_control(
            'mgpr_icon_posotion',
            [
                'label' => __('Icon OR Image Position', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'top' => [
                        'title' => __('top', 'magical-addons-for-elementor'),
                        'icon' => 'fas fa-arrow-up',
                    ],
                    'middle' => [
                        'title' => __('middle', 'magical-addons-for-elementor'),
                        'icon' => 'fas fa-arrow-down',
                    ],

                ],
                'default' => 'top',
                'condition' => [
                    'mg_pr_use_icon' => 'yes',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'mg_pr_section_title',
            [
                'label' => __('Title', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'mg_pr_title',
            [
                'label'       => __('Pricing title ', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => __('Plane Name', 'magical-addons-for-elementor'),
                'default'     => __('Standard', 'magical-addons-for-elementor'),
                'label_block'     => true,

            ]
        );
        $this->add_control(
            'mg_pr_title_tag',
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
        $this->add_responsive_control(
            'mg_pr_title_align',
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
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} h2.mg-pricing-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'mg_pr_desc_section',
            [
                'label' => __('Description', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mg_pr_desc',
            [
                'label'       => __('Description', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'input_type'  => 'text',
                'placeholder' => __('Pricing description goes here.', 'magical-addons-for-elementor'),
                'default'     => __('Best pricing plan for you. It\' editable text you can edit it.', 'magical-addons-for-elementor'),
            ]
        );
        $this->add_responsive_control(
            'mg_pr_desc_align',
            [
                'label' => __('Description Alignment', 'magical-addons-for-elementor'),
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
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} p.mg-price-desc' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'mg_pr_list_text',
            [
                'label' => __('List text', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                //'default' => __( 'List item' , 'magical-addons-for-elementor' ),
                'description' => __('Some style not support list fields', 'magical-addons-for-elementor'),
                'placeholder' => __('Enter List text', 'magical-addons-for-elementor'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'mg_pr_list_item',
            [
                'label' => __('Pricing List', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'mg_pr_list_text' => __('List text one', 'magical-addons-for-elementor'),
                    ],
                    [
                        'mg_pr_list_text' => __('List text two', 'magical-addons-for-elementor'),
                    ],
                    [
                        'mg_pr_list_text' => __('List text three', 'magical-addons-for-elementor'),
                    ],
                    [
                        'mg_pr_list_text' => __('List text four', 'magical-addons-for-elementor'),
                    ],
                ],
                'title_field' => '{{{ mg_pr_list_text }}}',
            ]
        );
        $this->add_responsive_control(
            'mg_pr_list_align',
            [
                'label' => __('List Alignment', 'magical-addons-for-elementor'),
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
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .mg-price-list' => 'text-align: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_section();
        $this->start_controls_section(
            'mg_pr_price_section',
            [
                'label' => __('Price', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mg_pr_price',
            [
                'label' => __('Price', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('$99', 'magical-addons-for-elementor'),
                'label_block' => true,
            ]
        );
        $this->add_control(
            'mg_pr_price_text',
            [
                'label' => __('Extra text', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('/Month', 'magical-addons-for-elementor'),
                'label_block' => true,
            ]
        );
        $this->add_responsive_control(
            'mg_pr_price_align',
            [
                'label' => __('List Alignment', 'magical-addons-for-elementor'),
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
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .mg-price' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mg_pr_button_section',
            [
                'label' => __('Button', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mg_pr_btntitle',
            [
                'label'       => __('Button Title', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => __('Button Text', 'magical-addons-for-elementor'),
                'default'     => __('Choose Plan', 'magical-addons-for-elementor'),
            ]
        );
        $this->add_control(
            'mg_pr_btn_link',
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
            'mg_pr_usebtn_icon',
            [
                'label' => __('Use icon', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'default' => 'no',
            ]
        );

        $this->add_control(
            'mg_pr_btn_selected_icon',
            [
                'label' => __('Choose Icon', 'magical-addons-for-elementor'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-chevron-right',
                    'library' => 'solid',
                ],
                'condition' => [
                    'mg_pr_usebtn_icon' => 'yes',
                ],
            ]
        );


        $this->add_responsive_control(
            'mg_pr_icon_position',
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
                    'mg_pr_usebtn_icon' => 'yes',
                ],

            ]
        );
        $this->add_control(
            'mg_pr_iconspace',
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
                    'mg_pr_usebtn_icon' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-pricing .mg-btn .left i' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mg-pricing .mg-btn .right i' => 'margin-left: {{SIZE}}{{UNIT}};',
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
            'mgpr_base_style',
            [
                'label' => __('Base Style', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,

            ]
        );
        $this->add_control(
            'mgpr_style_select',
            [
                'label' => __('Title HTML Tag', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    's1' => __('Style One', 'magical-addons-for-elementor'),
                    's2' => 'Style Two',
                ],
                'default' => 's1',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'mg_pr_icon_style',
            [
                'label' => __('Icon Or Image', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'mg_pr_use_icon' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
            'mg_pr_icon_size',
            [
                'label' => __('Icon Size', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-pricing-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'mg_pr_icon_type' => 'icon'
                ]
            ]
        );
        $this->add_responsive_control(
            'mg_pr_image_width',
            [
                'label' => __('Image Width', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 400,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-pricing-img img, {{WRAPPER}} .mg-pricing-icon svg' => 'width: {{SIZE}}{{UNIT}};',
                ],

            ]
        );

        $this->add_responsive_control(
            'mg_pr_image_height',
            [
                'label' => __('Image Height', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 400,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-pricing-img img, {{WRAPPER}} .mg-pricing-icon svg' => 'height: {{SIZE}}{{UNIT}};',
                ],

            ]
        );
        $this->add_responsive_control(
            'mg_pr_icon_spacing',
            [
                'label' => __('Bottom Spacing', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .mg-pricing-icon' => 'margin-bottom: {{SIZE}}{{UNIT}} !important;',
                    '{{WRAPPER}} .mg-pricing-img img' => 'margin-bottom: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'mg_pr_icon_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .mg-pricing-icon i, {{WRAPPER}} .mg-pricing-img img, {{WRAPPER}} .mg-pricing-icon svg' => 'padding: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_responsive_control(
            'mg_pr_icmg_opacity',
            [
                'label' => __('Image or icon opacity', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-pricing-img img,{{WRAPPER}} .mg-pricing-icon i, {{WRAPPER}} .mg-pricing-icon svg' => 'opacity: {{SIZE}};',
                ],

            ]
        );
        $this->add_control(
            'mgpr_active_absulate',
            [
                'label' => __('Active Absolute position', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'default' => 'no',
            ]
        );
        $this->add_responsive_control(
            'mg_pr_icon_absolutepo',
            [
                'label' => __('Icon or image Absolute Position', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-pricing-img, {{WRAPPER}} .mg-pricing-icon' => 'top: {{TOP}}{{UNIT}};right: {{RIGHT}}{{UNIT}}; bottom:{{BOTTOM}}{{UNIT}};left: {{LEFT}}{{UNIT}};',

                ],
                'condition' => [
                    'mgpr_active_absulate' => 'yes'
                ]
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mg_pr_icon_border',
                'selector' => '{{WRAPPER}} .mg-pricing-img img, {{WRAPPER}} .mg-pricing-icon i, {{WRAPPER}} .mg-pricing-icon svg'

            ]
        );

        $this->add_responsive_control(
            'mg_pr_icon_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-pricing-img img, {{WRAPPER}} .mg-pricing-icon svg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .mg-pricing-icon i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mg_pr_info_block_shadow',
                'exclude' => [
                    'box_shadow_position',
                ],
                'selector' => '{{WRAPPER}} .mg-pricing-img img, {{WRAPPER}} .mg-pricing-icon i, {{WRAPPER}} .mg-pricing-icon svg'
            ]
        );

        $this->add_control(
            'mg_pr_icon_color',
            [
                'label' => __('Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-pricing-icon i' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'mg_pr_icon_type' => 'icon'
                ]
            ]
        );

        $this->add_control(
            'mg_pr_icon_bg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-pricing-img img, {{WRAPPER}} .mg-pricing-icon i, {{WRAPPER}} .mg-pricing-icon svg' => 'background-color: {{VALUE}};',
                ],

            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'mg_pc_title_style',
            [
                'label' => __('Title', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mg_pc_title_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-pricing-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mg_pc_title_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-pricing-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mg_pc_title_color',
            [
                'label' => __('Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-pricing-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_pc_title_bgcolor',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-pricing-title' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_pc_titleb_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-pricing-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mg_pc_title_typography',
                'selector' => '{{WRAPPER}} .mg-pricing-title',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mg_pc_title_border',
                'selector' => '{{WRAPPER}} .mg-pricing-title',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mg_pc_desc_style',
            [
                'label' => __('Description & list', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'mg_pc_description_heading',
            [
                'type' => \Elementor\Controls_Manager::HEADING,
                'label' => __('Description', 'magical-addons-for-elementor'),
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'mg_pc_desc_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-price-desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mg_pc_desc_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-price-desc' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mg_pc_description_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-price-desc' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_pc_description_bgcolor',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-price-desc' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_pc_descb_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-price-desc' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mg_pc_desc_typography',
                'selector' => '{{WRAPPER}} .mg-price-desc',
            ]
        );
        $this->add_control(
            'mg_pc_list_heading',
            [
                'type' => \Elementor\Controls_Manager::HEADING,
                'label' => __('List style', 'magical-addons-for-elementor'),
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'mg_pc_list_style',
            [
                'label' => __('List Style', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'disc',
                'options' => [
                    'none'  => __('None', 'magical-addons-for-elementor'),
                    'disc'  => __('Disc', 'magical-addons-for-elementor'),
                    'circle' => __('Circle', 'magical-addons-for-elementor'),
                    'square' => __('Square', 'magical-addons-for-elementor'),
                    'decimal' => __('Decimal', 'magical-addons-for-elementor'),
                    'decimal-leading-zero' => __('Decimal-leading-zero', 'magical-addons-for-elementor'),
                    'lower-roman' => __('Lower Roman', 'magical-addons-for-elementor'),
                    'upper-roman' => __('Upper Roman', 'magical-addons-for-elementor'),
                    'lower-greek' => __('Lower Greek', 'magical-addons-for-elementor'),
                    'lower-latin' => __('Lower Latin', 'magical-addons-for-elementor'),
                    'armenian' => __('Armenian', 'magical-addons-for-elementor'),
                    'georgian' => __('Georgian', 'magical-addons-for-elementor'),
                    'lower-alpha' => __('Lower Alpha', 'magical-addons-for-elementor'),
                    'upper-alpha' => __('Upper Alpha', 'magical-addons-for-elementor'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-price-list ul' => 'list-style: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mg_pc_list_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-price-list ul li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mg_pc_list_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-price-list ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mg_pc_list_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-price-list ul li' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_pc_list_bgcolor',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-price-list ul li' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_pc_listb_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-price-list ul li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mg_pc_list_border',
                'selector' => '{{WRAPPER}} .mg-price-list ul li',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mg_pc_list_typography',
                'selector' => '{{WRAPPER}} .mg-price-list ul li',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'mg_pc_price_style',
            [
                'label' => __('Price', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'mg_pc_price_heading',
            [
                'type' => \Elementor\Controls_Manager::HEADING,
                'label' => __('Price style', 'magical-addons-for-elementor'),
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'mg_pc_price_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mg_pc_price_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mg_pc_price_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-price .mgcur' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_pc_price_bgcolor',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-price' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_pc_priceb_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-price' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mg_pc_price_typography',
                'selector' => '{{WRAPPER}} .mg-price .mgcur',
            ]
        );
        $this->add_control(
            'mg_pc_pextra_heading',
            [
                'type' => \Elementor\Controls_Manager::HEADING,
                'label' => __('Price text style', 'magical-addons-for-elementor'),
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'mg_pc_pextra_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-price .mgext' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mg_pc_pextra_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-price .mgext' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mg_pc_pextra_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-price .mgext' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_pc_pextra_bgcolor',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-price .mgext' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_pc_pextrab_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-price .mgext' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mg_pc_pextra_typography',
                'selector' => '{{WRAPPER}} .mg-price .mgext',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mg_pc_pextra_border',
                'selector' => '{{WRAPPER}} .mg-price',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'mg_pc_price_btn_section',
            [
                'label' => __('Button', 'magical-addons-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mg_pc_btn_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mg_pc_btn_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mg_pc_btn_typography',
                'selector' => '{{WRAPPER}} .mg-btn',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mg_pc_btn_border',
                'selector' => '{{WRAPPER}} .mg-btn',
            ]
        );

        $this->add_control(
            'mg_pc_btn_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mg_pc_btn_box_shadow',
                'selector' => '{{WRAPPER}} .mg-btn',
            ]
        );
        $this->add_control(
            'mg_pc_button_color',
            [
                'label' => __('Button color', 'plugin-name'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('infobox_btn_tabs');

        $this->start_controls_tab(
            'mg_pc_btn_normal_style',
            [
                'label' => __('Normal', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'mg_pc_btn_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mg-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mg_pc_btn_bg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'mg_pc_btn_hover_style',
            [
                'label' => __('Hover', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'mg_pc_btn_hcolor',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-btn:hover, {{WRAPPER}} .mg-btn:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mg_pc_btn_hbg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-btn:hover, {{WRAPPER}} .mg-btn:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mg_pc_btn_hborder_color',
            [
                'label' => __('Border Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'condition' => [
                    'mg_pc_btn_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-btn:hover, {{WRAPPER}} .mg-btn:focus' => 'border-color: {{VALUE}};',
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

        //title
        $mg_pr_title = $this->get_settings('mg_pr_title');
        $mg_pr_title_tag = $this->get_settings('mg_pr_title_tag');
        $this->add_inline_editing_attributes('mg_pr_title');
        $this->add_render_attribute('mg_pr_title', 'class', 'mg-pricing-title');
        //price
        $mg_pr_price = $this->get_settings('mg_pr_price');
        $mg_pr_price_text = $this->get_settings('mg_pr_price_text');
        $this->add_inline_editing_attributes('mg_pr_price');
        $this->add_inline_editing_attributes('mg_pr_price_text');
        $this->add_render_attribute('mg_pr_price', 'class', 'mgcur');
        $this->add_render_attribute('mg_pr_price_text', 'class', 'mgext');
        //description
        $mg_pr_desc = $this->get_settings('mg_pr_desc');
        $this->add_inline_editing_attributes('mg_pr_desc');
        $this->add_render_attribute('mg_pr_desc', 'class', 'mg-price-desc');
        // list item
        $mg_pr_list_item = $this->get_settings('mg_pr_list_item'); //Repeter

?>
        <div class="mg-pricing <?php echo esc_attr($settings['mgpr_style_select']); ?> <?php if ($settings['mgpr_active_absulate'] == 'yes') : ?>mg-has-absolute<?php endif; ?>">
            <div class="mg-pcicontitle">
                <?php
                if ($mg_pr_title && $settings['mgpr_icon_posotion'] == 'middle') :
                    printf(
                        '<%1$s %2$s>%3$s</%1$s>',
                        tag_escape($mg_pr_title_tag),
                        $this->get_render_attribute_string('mg_pr_title'),
                        mg_kses_tags($mg_pr_title)
                    );
                endif;
                ?>
                <?php if ($settings['mg_pr_use_icon'] == 'yes') : ?>
                    <div class="mgprice-iconimg text-<?php echo esc_attr($settings['mg_pr_main_icon_position']); ?>">

                        <?php if ($settings['mg_pr_icon_type'] == 'image') : ?>
                            <figure class="mg-pricing-img <?php if ($settings['mgpr_active_absulate'] == 'yes') : ?>mg-absolute<?php endif; ?>">
                                <?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'mg_pr_thumbnail', 'mg_pr_type_image'); ?>
                            </figure>
                        <?php else : ?>
                            <div class="mg-pricing-icon <?php if ($settings['mgpr_active_absulate'] == 'yes') : ?>mg-absolute<?php endif; ?>">
                                <?php \Elementor\Icons_Manager::render_icon($settings['mg_pr_type_selected_icon']); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php
                if ($mg_pr_title && $settings['mgpr_icon_posotion'] == 'top') :
                    printf(
                        '<%1$s %2$s>%3$s</%1$s>',
                        tag_escape($mg_pr_title_tag),
                        $this->get_render_attribute_string('mg_pr_title'),
                        mg_kses_tags($mg_pr_title)
                    );
                endif;
                ?>
            </div>
            <?php if ($mg_pr_price && $settings['mgpr_style_select'] == 's1') : ?>
                <p class="mg-price"><span <?php echo $this->get_render_attribute_string('mg_pr_price'); ?>><?php echo mg_kses_tags($mg_pr_price); ?></span> <span <?php echo $this->get_render_attribute_string('mg_pr_price_text'); ?>><?php echo mg_kses_tags($mg_pr_price_text); ?></span></p>
            <?php endif; ?>
            <?php if ($mg_pr_desc) : ?>
                <p <?php echo $this->get_render_attribute_string('mg_pr_desc'); ?>><?php echo wp_kses_post($mg_pr_desc); ?></p>
            <?php endif; ?>
            <?php if ($mg_pr_list_item) : ?>
                <div class="mg-price-list">
                    <ul>
                        <?php
                        foreach ($mg_pr_list_item as $index => $item) :
                            $key1 = $this->get_repeater_setting_key('mg_pr_list_text', 'mg_pr_list_item', $index);
                            $this->add_inline_editing_attributes($key1);
                        ?>
                            <li <?php echo $this->get_render_attribute_string($key1); ?>><?php echo mg_kses_tags($item['mg_pr_list_text']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <?php if ($mg_pr_price && $settings['mgpr_style_select'] == 's2') : ?>
                <p class="mg-price mgps2"><span <?php echo $this->get_render_attribute_string('mg_pr_price'); ?>><?php echo mg_kses_tags($mg_pr_price); ?></span> <span <?php echo $this->get_render_attribute_string('mg_pr_price_text'); ?>><?php echo mg_kses_tags($mg_pr_price_text); ?></span></p>
            <?php endif; ?>
            <?php
            $btntitle = $this->get_settings('mg_pr_btntitle');
            $btn_link = $this->get_settings('mg_pr_btn_link');
            $mg_pr_usebtn_icon = $this->get_settings('mg_pr_usebtn_icon');
            $mg_pr_btn_icon = $this->get_settings('mg_pr_btn_icon');
            $mg_pr_icon_position = $this->get_settings('mg_pr_icon_position');

            $this->add_inline_editing_attributes('mg_pr_btntitle', 'none');
            $this->add_render_attribute('mg_pr_btntitle', 'class', 'mg-btn-text');

            $this->add_render_attribute('mg_pr_btntitle', 'class', 'mg-btn');
            $this->add_render_attribute('mg_pr_btntitle', 'href', esc_url($btn_link['url']));
            if (!empty($btn_link['is_external'])) {
                $this->add_render_attribute('mg_pr_btntitle', 'target', '_blank');
            }
            if (!empty($btn_link['nofollow'])) {
                $this->set_render_attribute('mg_pr_btntitle', 'rel', 'nofollow');
            }

            if ($mg_pr_usebtn_icon == 'yes') :
            ?>
                <a <?php echo $this->get_render_attribute_string('mg_pr_btntitle'); ?>>
                    <?php if ($mg_pr_icon_position == 'left') : ?>
                        <span class="left"><?php \Elementor\Icons_Manager::render_icon($settings['mg_pr_btn_selected_icon']); ?></span>

                    <?php endif; ?>
                    <span><?php echo mg_kses_tags($btntitle); ?></span>
                    <?php if ($mg_pr_icon_position == 'right') : ?>
                        <span class="right"><?php \Elementor\Icons_Manager::render_icon($settings['mg_pr_btn_selected_icon']); ?></span>
                    <?php endif; ?>
                </a>
            <?php else : ?>
                <a <?php echo $this->get_render_attribute_string('mg_pr_btntitle'); ?>><?php echo  mg_kses_tags($btntitle); ?></a>
            <?php endif; ?>


        </div>

<?php
    }
}
