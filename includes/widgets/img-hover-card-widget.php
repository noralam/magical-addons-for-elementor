<?php


class MgimgHover_Card_Widget extends \Elementor\Widget_Base
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
        return 'mgimghover_card_widget';
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
        return __('MG Hover Card', 'magical-addons-for-elementor');
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
        return 'eicon-image';
    }

    public function get_keywords()
    {
        return ['card', 'hover', 'image', 'grid', 'mg'];
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
            'mg_imghvr_section',
            [
                'label' => __('Card Image', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'mg_hvrcard_img',
            [
                'label' => __('Choose Image', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'mghvr_thumbnail',
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

            ]
        );
        $this->add_control(
            'mg_hvr_card_effects',
            [
                'label' => __('Select Hover Effect', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'imghvr-fade' => __('Image Hover Fade', 'magical-addons-for-elementor'),
                    'imghvr-push-up' => __('Image Hover Push Up', 'magical-addons-for-elementor'),
                    'imghvr-push-down' => __('Image Hover Push Down', 'magical-addons-for-elementor'),
                    'imghvr-push-left' => __('Image Hover Push Left', 'magical-addons-for-elementor'),
                    'imghvr-push-right' => __('Image Hover Push Right', 'magical-addons-for-elementor'),
                    'imghvr-slide-up' => __('Image Hover slide Up', 'magical-addons-for-elementor'),
                    'imghvr-slide-down' => __('Image Hover Slide Down', 'magical-addons-for-elementor'),
                    'imghvr-slide-left' => __('Image Hover Slide Left', 'magical-addons-for-elementor'),
                    'imghvr-slide-right' => __('Image Hover Slide Right', 'magical-addons-for-elementor'),
                    'imghvr-reveal-up' => __('Image Hover Reveal Up', 'magical-addons-for-elementor'),
                    'imghvr-reveal-down' => __('Image Hover Reveal Down', 'magical-addons-for-elementor'),
                    'imghvr-reveal-left' => __('Image Hover Reveal Left', 'magical-addons-for-elementor'),
                    'imghvr-reveal-right' => __('Image Hover Reveal Right', 'magical-addons-for-elementor'),
                    'imghvr-hinge-down' => __('Image Hover Hinge Down', 'magical-addons-for-elementor'),

                ],
                'default' => 'imghvr-hinge-down',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'mg_hvrcard_content',
            [
                'label' => __('Card Content', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'mg_hvrcard_title',
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
            'mg_hvrcard_title_tag',
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
            'mg_hvrcard_desc',
            [
                'label'       => __('Description', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'input_type'  => 'text',
                'placeholder' => __('Card description goes here.', 'magical-addons-for-elementor'),
                'default'     => __('dummy text you can edit or remove it. Lorem ipsum dolor sit amet.', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_responsive_control(
            'mg_hvrcard_text_align',
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
                    '{{WRAPPER}} .mg-hvrcap-text' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mg_hvrcard_button',
            [
                'label' => __('Button', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mg_hvrcard_btn_use',
            [
                'label' => __('Use Card Button?', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mg_hvrcard_btn_title',
            [
                'label'       => __('Button Title', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => __('Button Text', 'magical-addons-for-elementor'),
                'default'     => __('Read More', 'magical-addons-for-elementor'),
            ]
        );
        $this->add_control(
            'mg_hvrcard_btn_link',
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
            'mg_hvrcard_usebtn_icon',
            [
                'label' => __('Use icon', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'default' => 'no',
            ]
        );
        $this->add_control(
            'mg_hvrcard_btn_selected_icon',
            [
                'label' => __('Choose Icon', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-chevron-right',
                    'library' => 'solid',
                ],
                'condition' => [
                    'mg_hvrcard_usebtn_icon' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mg_hvrcardbtn_icon_position',
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
                    'mg_hvrcard_usebtn_icon' => 'yes',
                ],

            ]
        );
        $this->add_responsive_control(
            'mg_hvrcardbtn_iconspace',
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
                    'mg_hvrcard_usebtn_icon' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-hvr-card .mg-hvrcard-btn .left i' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mg-hvr-card .mg-hvrcard-btn .right i' => 'margin-left: {{SIZE}}{{UNIT}};',
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
            'mg_hvrcard_basic_style',
            [
                'label' => __('Basic style', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mg_hvrcard_content_padding',
            [
                'label' => __('Content Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-hvr-card figcaption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        /*$this->add_responsive_control(
            'mg_hvrcard_content_margin',
            [
                'label' => __( 'Content Margin', 'magical-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .mg-hvr-card figcaption' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );*/
        $this->add_control(
            'mg_hvrcard_content_bg_color',
            [
                'label' => __('Content Background color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} [class*=" imghvr-"] figcaption,{{WRAPPER}} [class^=imghvr-] figcaption,{{WRAPPER}} .mg-hvr-card figure,{{WRAPPER}} figure.mg-hcard-main:before' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_hvrcard_content_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-hvr-card figure,{{WRAPPER}} .mg-hvr-card figure img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        /*
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mg_hvrcard_content_border',
                'selector' => '{{WRAPPER}} .mg-hvr-card figcaption .mg-hvrcap-text',
            ]
        );
        $this->add_responsive_control(
            'mg_hvrcard_border_padding',
            [
                'label' => __( 'Border Padding', 'magical-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .mg-hvr-card figcaption .mg-hvrcap-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mg_hvrcard_content_border_border!' => '',
                ]
            ]
        );*/
        $this->end_controls_section();
        $this->start_controls_section(
            'mg_hvrcard_img_style',
            [
                'label' => __('Image style', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_control(
            'mg_hvrcard_img_auto_height',
            [
                'label' => __('Image auto height', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('On', 'magical-addons-for-elementor'),
                'label_off' => __('Off', 'magical-addons-for-elementor'),
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mg_hvrcard_img_height',
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
                    'mg_hvrcard_img_auto_height!' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-hvr-card img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mg_hvrcard_img_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-hvr-card img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mg_hvrcard_img_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-hvr-card img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mg_hvrcard_img_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-hvr-card figure img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->add_control(
            'mg_hvrcard_imgbg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mg-hvr-card img' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mg_hvrcard_img_border',
                'selector' => '{{WRAPPER}} .mg-hvr-card img',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'mg_hvrcard_card_details_style',
            [
                'label' => __('Card Title', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mg_hvrcard_title_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-hvrcard-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mg_hvrcard_title_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-hvrcard-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mg_hvrcard_title_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-hvrcard-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_hvrcard_title_bgcolor',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-hvrcard-title' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_hvrcard_descb_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-hvrcard-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mg_hvrcard_title_typography',
                'selector' => '{{WRAPPER}} .mg-hvrcard-title',
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
            'mg_hvrcard_description_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-hvrcap-text p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mg_hvrcard_description_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-hvrcap-text p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mg_hvrcard_description_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-hvrcap-text p' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_hvrcard_description_bgcolor',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-hvrcap-text p' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_hvrcard_description_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-hvrcap-text p' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mg_hvrcard_description_typography',
                'selector' => '{{WRAPPER}} .mg-hvrcap-text p',
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
            'mghvrcard_btn_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-hvrcard-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mghvrcard_btn_typography',
                'selector' => '{{WRAPPER}} .mg-hvrcard-btn',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mghvrcard_btn_border',
                'selector' => '{{WRAPPER}} .mg-hvrcard-btn',
            ]
        );

        $this->add_control(
            'mghvrcard_btn_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-hvrcard-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mghvrcard_btn_box_shadow',
                'selector' => '{{WRAPPER}} .mg-hvrcard-btn',
            ]
        );
        $this->add_control(
            'mghvrcard_button_color',
            [
                'label' => __('Button color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('infobox_btn_tabs');

        $this->start_controls_tab(
            'mghvrcard_btn_normal_style',
            [
                'label' => __('Normal', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'mghvrcard_btn_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mg-hvrcard-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mghvrcard_btn_bg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-hvrcard-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'mghvrcard_btn_hover_style',
            [
                'label' => __('Hover', 'magical-addons-for-elementor'),
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mghvrcard_btnhover_boxshadow',
                'selector' => '{{WRAPPER}} .mg-hvrcard-btn:hover',
            ]
        );

        $this->add_control(
            'mghvrcard_btn_hcolor',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-hvrcard-btn:hover, {{WRAPPER}} .mg-hvrcard-btn:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mghvrcard_btn_hbg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-hvrcard-btn:hover, {{WRAPPER}} .mg-hvrcard-btn:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mghvrcard_btn_hborder_color',
            [
                'label' => __('Border Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'condition' => [
                    'mghvrcard_btn_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-hvrcard-btn:hover, {{WRAPPER}} .mg-hvrcard-btn:focus' => 'border-color: {{VALUE}};',
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
        $mg_hvrcard_title = $this->get_settings('mg_hvrcard_title');
        $mg_hvrcard_title_tag = $this->get_settings('mg_hvrcard_title_tag');
        $this->add_inline_editing_attributes('mg_hvrcard_title');
        $this->add_render_attribute('mg_hvrcard_title', 'class', 'mg-hvrcard-title');
        //description
        $mg_hvrcard_img = $this->get_settings('mg_hvrcard_img');
        $mg_hvr_card_effects = $this->get_settings('mg_hvr_card_effects');
        $mg_hvrcard_desc = $this->get_settings('mg_hvrcard_desc');
        $this->add_inline_editing_attributes('mg_hvrcard_desc');

        // social list item
        $mg_hvrcard_btn_use = $this->get_settings('mg_hvrcard_btn_use');
        $mg_hvrcard_btn_title = $this->get_settings('mg_hvrcard_btn_title');
        $mg_hvrcard_btn_link = $this->get_settings('mg_hvrcard_btn_link');
        $mg_hvrcard_usebtn_icon = $this->get_settings('mg_hvrcard_usebtn_icon');
        $mg_hvrcard_btnicon = $this->get_settings('mg_hvrcard_btnicon');
        $mg_hvrcardbtn_icon_position = $this->get_settings('mg_hvrcardbtn_icon_position');
        $main_icon_position = $this->get_settings('main_icon_position');

        $this->add_inline_editing_attributes('mg_hvrcard_btn_title', 'none');
        $this->add_render_attribute('mg_hvrcard_btn_title', 'class', 'mg-btn');

        $this->add_render_attribute('mg_hvrcard_btn_title', 'class', 'mg-hvrcard-btn');
        $this->add_render_attribute('mg_hvrcard_btn_title', 'href', esc_url($mg_hvrcard_btn_link['url']));
        if (!empty($mg_hvrcard_btn_link['is_external'])) {
            $this->add_render_attribute('mg_hvrcard_btn_title', 'target', '_blank');
        }
        if (!empty($mg_hvrcard_btn_link['nofollow'])) {
            $this->set_render_attribute('mg_hvrcard_btn_title', 'rel', 'nofollow');
        }


?>
        <div class="mg-hvr-card">
            <figure class="<?php echo esc_attr($mg_hvr_card_effects); ?> mg-hcard-main">
                <?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'mghvr_thumbnail', 'mg_hvrcard_img'); ?>
                <figcaption>
                    <div class="mg-hvrcap-text">
                        <?php
                        if ($mg_hvrcard_title) :
                            printf(
                                '<%1$s %2$s>%3$s</%1$s>',
                                tag_escape($mg_hvrcard_title_tag),
                                $this->get_render_attribute_string('mg_hvrcard_title'),
                                mg_kses_tags($mg_hvrcard_title)
                            );
                        endif;
                        ?>
                        <?php if ($mg_hvrcard_desc) : ?>
                            <p <?php echo $this->get_render_attribute_string('mg_hvrcard_desc'); ?>><?php echo wp_kses_post($mg_hvrcard_desc); ?></p>
                        <?php endif; ?>
                        <?php if ($mg_hvrcard_btn_use) : ?>
                            <?php if ($mg_hvrcard_usebtn_icon == 'yes') : ?>
                                <a <?php echo $this->get_render_attribute_string('mg_hvrcard_btn_title'); ?>>
                                    <?php if ($mg_hvrcardbtn_icon_position == 'left') : ?>
                                        <span class="left"><?php \Elementor\Icons_Manager::render_icon($settings['mg_hvrcard_btn_selected_icon']); ?></span>

                                    <?php endif; ?>
                                    <span><?php echo mg_kses_tags($mg_hvrcard_btn_title); ?></span>
                                    <?php if ($mg_hvrcardbtn_icon_position == 'right') : ?>
                                        <span class="right"><?php \Elementor\Icons_Manager::render_icon($settings['mg_hvrcard_btn_selected_icon']); ?></span>
                                    <?php endif; ?>
                                </a>
                            <?php else : ?>
                                <a <?php echo $this->get_render_attribute_string('mg_hvrcard_btn_title'); ?>><?php echo  mg_kses_tags($mg_hvrcard_btn_title); ?></a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </figcaption>
            </figure>
        </div>

<?php
    }


    protected function content_template()
    {
    }
}
