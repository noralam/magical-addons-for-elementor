<?php

use Elementor\Group_Control_Image_Size;


class MgAddon_Info_Box extends \Elementor\Widget_Base
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
        return 'mginfobox_widget';
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
        return __('MG Info Box', 'magical-addons-for-elementor');
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
        return 'eicon-info-box';
    }
    public function get_keywords()
    {
        return ['info', 'services', 'box', 'icon', 'mg'];
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
            'mginfo_icon_section',
            [
                'label' => __('Icon or Image', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mginfo_use_icon',
            [
                'label' => __('Show Icon or image?', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'default' => 'yes',
            ]
        );
        $this->add_responsive_control(
            'mginfo_main_icon_position',
            [
                'label' => __('Icon position', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'top' => __('Top', 'magical-addons-for-elementor'),
                    'title-left' => __('Title Left', 'magical-addons-for-elementor'),
                    'title-right' => __('Title Right', 'magical-addons-for-elementor'),
                    'left' => __('Left', 'magical-addons-for-elementor'),
                    'right' => __('Right', 'magical-addons-for-elementor'), 
                ],
                'default' => 'top',
                'toggle' => false,
                'condition' => [
                    'mginfo_use_icon' => 'yes',
                ]
            ]
        );
        $this->add_control(
            'mginfo_icon_alignment',
            [
                'label' => __('Icon Alignment', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'flex-start' => __('Left', 'magical-addons-for-elementor'),
                        'icon' => 'fas fa-long-arrow-alt-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'magical-addons-for-elementor'),
                        'icon' => 'fas fa-arrows-alt',
                    ],
                    'flex-end' => [
                        'title' => __('Right', 'magical-addons-for-elementor'),
                        'icon' => 'fas fa-long-arrow-alt-right',
                    ],

                ],
                'default' => 'center',
                'toggle' => true,
                'condition' => [
                    'mginfo_main_icon_position' => 'top',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgicon-area' => 'justify-content: {{VALUE}};',
                ],
            ]
         );
        $this->add_control(
            'mginfo_icon_vertical_position',
            [
                'label' => __('Icon Vertical Position', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'flex-start' => __('Top', 'magical-addons-for-elementor'),
                        'icon' => 'fas fa-long-arrow-alt-up',
                    ],
                    'center' => [
                        'title' => __('Middle', 'magical-addons-for-elementor'),
                        'icon' => 'fas fa-arrows-alt',
                    ],
                    'flex-end' => [
                        'title' => __('Bottom', 'magical-addons-for-elementor'),
                        'icon' => 'fas fa-long-arrow-alt-down',
                    ],

                ],
                'default' => 'center',
                'toggle' => true,
                'condition' => [
                    'mginfo_main_icon_position!' => 'top',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgicon-area, {{WRAPPER}} .mg-infobox-title-wrap' => 'align-items: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mginfo_icon_type',
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
                    'mginfo_use_icon' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mginfo_type_selected_icon',
            [
                'label' => __('Choose Icon', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'mginfo_icon_type' => 'icon',
                    'mginfo_use_icon' => 'yes',
                ],
            ]
        );


        $this->add_control(
            'mginfo_type_image',
            [
                'label' => __('Choose Image', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'mginfo_icon_type' => 'image',
                    'mginfo_use_icon' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'mginfo_thumbnail',
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
                    'mginfo_icon_type' => 'image',
                    'mginfo_use_icon' => 'yes',
                ]
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'mginfo_text_section',
            [
                'label' => __('Title and description', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'mginfo_title',
            [
                'label'       => __('Title', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => __('Magical info box title', 'magical-addons-for-elementor'),
                'default'     => __('Magical info box title', 'magical-addons-for-elementor'),
                'label_block' => true
            ]
        );
        $this->add_control(
            'mginfo_title_tag',
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
            'mginfo_desc',
            [
                'label'       => __('Description', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'input_type'  => 'text',
                'placeholder' => __('Magical info box description goes here.', 'magical-addons-for-elementor'),
                'default'     => __('Magical info box description goes here.', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_responsive_control(
            'mginfo_title_align',
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
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'mg_info_badge',
            [
                'label' => __('Badge', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'info_badge_use',
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
                    'info_badge_use' => 'yes',
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
                'default' => 'right-top',
                'toggle' => false,
                'condition' => [
                    'info_badge_use' => 'yes',
                ],

            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'mginfo_button_section',
            [
                'label' => __('Button & wrapper linking', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mginfo_wraplinking',
            [
                'label' => __('Wrapper linking', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'default' => '',
            ]
        );
        $this->add_control(
            'mginfo_wraplink',
            [
                'label' => __('Wrapper Link', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'magical-addons-for-elementor'),
                'default' => [
                    'url' => '#',
                ],
                'separator' => 'before',
                'condition' => [
                    'mginfo_wraplinking' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'mginfo_use_btn',
            [
                'label' => __('Use button', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mginfo_btntitle',
            [
                'label'       => __('Button Title', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => __('Button Text', 'magical-addons-for-elementor'),
                'default'     => __('Read More', 'magical-addons-for-elementor'),
                'condition' => [
                    'mginfo_use_btn' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'mginfo_btn_link',
            [
                'label' => __('Button Link', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'magical-addons-for-elementor'),
                'default' => [
                    'url' => '#',
                ],
                'separator' => 'before',
                'condition' => [
                    'mginfo_use_btn' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'mginfo_usebtn_icon',
            [
                'label' => __('Use icon', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'default' => 'no',
            ]
        );
        if (mg_elementor_version_check('<', '2.6.0')) {
            $this->add_control(
                'mginfo_btn_icon',
                [
                    'label' => __('Choose Icon', 'magical-addons-for-elementor'),
                    'label_block' => true,
                    'type' => \Elementor\Controls_Manager::ICON,
                    'default' => 'fas fa-chevron-right',
                    'condition' => [
                        'mginfo_usebtn_icon' => 'yes',
                    ],
                ]
            );
        } else {
            $this->add_control(
                'mginfo_btn_selected_icon',
                [
                    'label' => __('Choose Icon', 'magical-addons-for-elementor'),
                    'type' => \Elementor\Controls_Manager::ICONS,
                    'default' => [
                        'value' => 'fas fa-chevron-right',
                        'library' => 'fa-solid',
                    ],
                    'condition' => [
                        'mginfo_usebtn_icon' => 'yes',
                    ],
                ]
            );
        }

        $this->add_responsive_control(
            'mginfo_icon_position',
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
                'toggle' => false,
                'condition' => [
                    'mginfo_usebtn_icon' => 'yes',
                ],

            ]
        );
        $this->add_control(
            'mginfo_iconspace',
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
                    'mginfo_usebtn_icon' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-infobox .mg-infolink i.left' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mg-infobox .mg-infolink i.right' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mg-infobox .mg-infolink svg.left' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mg-infobox .mg-infolink svg.right' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
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
            'mginfo_box_style',
            [
                'label' => __('Box Basic Style', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'mginfo_min_height',
            [
                'label' => __('Box Minimum Height', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-infobox' => 'min-height: {{SIZE}}{{UNIT}};',
                ],

            ]
        );

        $this->add_responsive_control(
            'mginfo_box_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-infobox' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mginfo_box_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-infobox' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mginfo_box_border',
                'selector' => '{{WRAPPER}} .mg-infobox'

            ]
        );

        $this->add_responsive_control(
            'mginfo_box_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-infobox' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mginfo_box_block_shadow',
                'exclude' => [
                    'box_shadow_position',
                ],
                'selector' => '{{WRAPPER}} .mg-infobox'
            ]
        );

        $this->add_control(
            'mginfo_box_bg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-infobox' => 'background-color: {{VALUE}};',
                ],

            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'mginfo_icon_style',
            [
                'label' => __('Icon Or Image', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'mginfo_use_icon' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
            'mginfo_icon_size',
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
                    '{{WRAPPER}} .mg-infobox-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mg-infobox-icon svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'mginfo_icon_type' => 'icon'
                ]
            ]
        );
        $this->add_responsive_control(
            'mginfo_image_width',
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
                    '{{WRAPPER}} .mg-infobox-img img' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'mginfo_icon_type' => 'image'
                ]
            ]
        );

        $this->add_responsive_control(
            'mginfo_image_height',
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
                    '{{WRAPPER}} .mg-infobox-img img' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'mginfo_icon_type' => 'image'
                ]
            ]
        );
        $this->add_responsive_control(
            'mginfo_icon_spacing',
            [
                'label' => __('Bottom Spacing', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .mg-infobox-icon' => 'margin-bottom: {{SIZE}}{{UNIT}} !important;',
                    '{{WRAPPER}} .mg-infobox-img img' => 'margin-bottom: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'mginfo_icon_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .mg-infobox-icon, {{WRAPPER}} .mg-infobox-img img' => 'padding: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );
        $this->add_responsive_control(
            'mginfo_icon_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-infobox-img img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .mg-infobox-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mginfo_icon_border',
                'selector' => '{{WRAPPER}} .mg-infobox-img img, {{WRAPPER}} .mg-infobox-icon'

            ]
        );

        $this->add_responsive_control(
            'mginfo_icon_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-infobox-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .mg-infobox-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mginfo_info_block_shadow',
                'exclude' => [
                    'box_shadow_position',
                ],
                'selector' => '{{WRAPPER}} .mg-infobox-img img, {{WRAPPER}} .mg-infobox-icon'
            ]
        );

        $this->add_control(
            'mginfo_icon_color',
            [
                'label' => __('Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-infobox-icon i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .mg-infobox-icon svg' => 'fill: {{VALUE}}',
                ],
                'condition' => [
                    'mginfo_icon_type' => 'icon'
                ]
            ]
        );

        $this->add_control(
            'mginfo_icon_bg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-infobox-img img, {{WRAPPER}} .mg-infobox-icon' => 'background-color: {{VALUE}};',
                ],

            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'mginfo_content_style',
            [
                'label' => __('Title and description', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mginfo_content_padding',
            [
                'label' => __('Content padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-infobox-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mginfo_title_spacing',
            [
                'label' => __('Bottom Spacing', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .mg-infobox-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mginfo_title_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-infobox-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mginfo_title_typography',
                'selector' => '{{WRAPPER}} .mg-infobox-title',
            ]
        );

        $this->add_control(
            'mginfo_desc_heading',
            [
                'type' => \Elementor\Controls_Manager::HEADING,
                'label' => __('Description', 'magical-addons-for-elementor'),
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'mginfo_description_spacing',
            [
                'label' => __('Bottom Spacing', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .mg-infobox-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mginfo_description_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} p.mg-infobox-desc' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mginfo_description_typography',
                'selector' => '{{WRAPPER}} p.mg-infobox-desc',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'mgbtn_badge_style',
            [
                'label' => __('Badge', 'magical-addons-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'info_badge_use' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
            'mginfo_badge_margin',
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
            'mginfo_badge_padding',
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
            'mginfo_badge_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} span.mgc-badge' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mginfo_badge_bgcolor',
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
                'name' => 'mginfo_badge_typography',
                'selector' => '{{WRAPPER}} span.mgc-badge',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mginfo_badge_border',
                'selector' => '{{WRAPPER}} span.mgc-badge',
            ]
        );

        $this->add_control(
            'mginfo_badge_bradius',
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
                'name' => 'mginfo_badge_bshadow',
                'selector' => '{{WRAPPER}} span.mgc-badge',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mginfo_btn_style_section',
            [
                'label' => __('Button', 'magical-addons-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mginfo_btn_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-infolink' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mginfo_btn_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-infolink' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mginfo_btn_typography',
                'selector' => '{{WRAPPER}} .mg-infolink',
            ]
        );

        $this->add_responsive_control(
            'mg_infobox_button_icon_size',
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
                'default' => [
                    'unit' => 'px',
                    'size' => 14,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-infolink i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mg-infolink svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mginfo_btn_border',
                'selector' => '{{WRAPPER}} .mg-infolink',
            ]
        );

        $this->add_control(
            'mginfo_btn_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-infolink' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mginfo_btn_box_shadow',
                'selector' => '{{WRAPPER}} .mg-infolink',
            ]
        );
        $this->add_control(
            'mginfo_button_color',
            [
                'label' => __('Button color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('infobox_btn_tabs');

        $this->start_controls_tab(
            'mginfo_btn_normal_style',
            [
                'label' => __('Normal', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'mginfo_btn_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mg-infolink' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mg-infolink i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mg-infolink svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mginfo_btn_bg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-infolink' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'mginfo_btn_hover_style',
            [
                'label' => __('Hover', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'mginfo_btn_hcolor',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-infobox.active-fhover:hover .mg-infolink, {{WRAPPER}} .mg-infobox.active-fhover:focus .mg-infolink,{{WRAPPER}} .mg-infolink:hover, {{WRAPPER}} .mg-infolink:focus' => 'color: {{VALUE}};',

                    '{{WRAPPER}} .mg-infobox .active-fhover:hover .mg-infolink i, {{WRAPPER}} .mg-infobox.active-fhover:focus .mg-infolink i,{{WRAPPER}} .mg-infolink:hover i, {{WRAPPER}} .mg-infolink:focus i' => 'color: {{VALUE}};',

                    '{{WRAPPER}} .mg-infobox .active-fhover:hover .mg-infolink svg, 
                    {{WRAPPER}} .mg-infobox.active-fhover:focus .mg-infolink svg,{{WRAPPER}} .mg-infobox:hover .mg-infolink svg,
                    {{WRAPPER}} .mg-infobox:focus .mg-infolink svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mginfo_btn_hbg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-infobox.active-fhover:hover .mg-infolink, {{WRAPPER}} .mg-infobox.active-fhover:focus .mg-infolink,{{WRAPPER}} .mg-infolink:hover, {{WRAPPER}} .mg-infolink:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mginfo_btn_hborder_color',
            [
                'label' => __('Border Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'condition' => [
                    'mginfo_btn_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-infobox.active-fhover:hover .mg-infolink, {{WRAPPER}} .mg-infobox.active-fhover:focus .mg-infolink,{{WRAPPER}} .mg-infolink:hover, {{WRAPPER}} .mg-infolink:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
        $this->start_controls_section(
            'mginfo_main_hover',
            [
                'label' => __('Full Info Box Hover', 'magical-addons-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'mginfo_fullhover',
            [
                'label' => __('Active Full Hover', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'default' => ' ',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgdb_content_bg_color',
                'label' => esc_html__('Info Box Hover Background Color', 'magical-addons-for-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .mg-infobox.active-fhover:hover',
                'condition' => [
                    'mginfo_fullhover' => 'yes',
                ]
            ]
        );
        $this->add_control(
            'mginfo_fullh_icon_color',
            [
                'label' => __('Hover Icon Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-infobox.active-fhover:hover .mg-infobox-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mg-infobox.active-fhover:hover .mg-infobox-icon svg' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'mginfo_fullhover' => 'yes',
                ]
            ]
        );
        $this->add_control(
            'mginfo_fullh_head_color',
            [
                'label' => __('Hover Heading Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-infobox.active-fhover:hover .mg-infobox-title' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'mginfo_fullhover' => 'yes',
                ]
            ]
        );
        $this->add_control(
            'mginfo_fullh_desc_color',
            [
                'label' => __('Hover Description Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-infobox.active-fhover:hover .mg-infobox-desc' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'mginfo_fullhover' => 'yes',
                ]
            ]
        );


        $this->end_controls_section();
    }


    public function icon_output(){
        $settings   = $this->get_settings_for_display();
        $mginfo_icon_type = $this->get_settings('mginfo_icon_type');
    ?>
        <div class="mgicon-area">
            <?php if ($mginfo_icon_type == 'image') : ?>
                <figure class="mg-infobox-img">
                    <?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'mginfo_thumbnail', 'mginfo_type_image'); ?>
                </figure>
            <?php else : ?>
                    <div class="mg-infobox-icon">
                    <?php \Elementor\Icons_Manager::render_icon($settings['mginfo_type_selected_icon'], ['aria-hidden' => 'true']); ?>
                </div>
            <?php endif; ?>
        </div>

    <?php
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

        $settings   = $this->get_settings_for_display();
        $use_icon = $this->get_settings('mginfo_use_icon');
        $mginfo_icon_type = $this->get_settings('mginfo_icon_type');
        $type_icon = $this->get_settings('mginfo_type_icon');
        $title = $this->get_settings('mginfo_title');
        $title_tag = $this->get_settings('mginfo_title_tag');
        $desc = $this->get_settings('mginfo_desc');
        $title_align = $this->get_settings('mginfo_title_align');
        $use_btn = $this->get_settings('mginfo_use_btn');
        $btntitle = $this->get_settings('mginfo_btntitle');
        $mginfo_wraplinking = $this->get_settings('mginfo_wraplinking');
        $mginfo_wraplink = $this->get_settings('mginfo_wraplink');
        $btn_link = $this->get_settings('mginfo_btn_link');
        $usebtn_icon = $this->get_settings('mginfo_usebtn_icon');
        $btnicon = $this->get_settings('mginfo_btnicon');
        $icon_position = $this->get_settings('mginfo_icon_position');
        $iconspace = $this->get_settings('mginfo_iconspace');
        $main_icon_position = $this->get_settings('mginfo_main_icon_position');


        $this->add_inline_editing_attributes('mginfo_title', 'basic');
        $this->add_render_attribute('mginfo_title', 'class', 'mg-infobox-title');

        $this->add_inline_editing_attributes('mginfo_desc');
        $this->add_render_attribute('mginfo_desc', 'class', 'mg-infobox-desc');


        $this->add_render_attribute('mginfo_btntitle', 'class', 'mg-btn-text');
        $this->add_render_attribute('mginfo_btntitle', 'class', 'mg-infolink');
        $this->add_render_attribute('mginfo_btntitle', 'href', esc_url($btn_link['url']));
        if (!empty($btn_link['is_external'])) {
            $this->add_render_attribute('mginfo_btntitle', 'target', '_blank');
        }
        if (!empty($btn_link['nofollow'])) {
            $this->set_render_attribute('mginfo_btntitle', 'rel', 'nofollow');
        }
        // wrapper  linking
        $this->add_render_attribute('mginfo_wraplink', 'href', esc_url($mginfo_wraplink['url']));
        if (!empty($mginfo_wraplink['is_external'])) {
            $this->add_render_attribute('mginfo_wraplink', 'target', '_blank');
        }
        if (!empty($mginfo_wraplink['nofollow'])) {
            $this->set_render_attribute('mginfo_wraplink', 'rel', 'nofollow');
        }
?>

        <div class="mg-infobox <?php if ($settings['mginfo_fullhover']) : ?>active-fhover<?php endif; ?> mg-infobox-ps-<?php echo esc_attr($main_icon_position); ?> mg-infobox-ta-<?php echo esc_attr($title_align); ?>">
            <?php if ($mginfo_wraplinking) : ?>
                <a <?php echo $this->get_render_attribute_string('mginfo_wraplink'); ?>>
            <?php endif; ?>


            <div class="mg-infobox-inner">
            <?php
             if ($use_icon == 'yes' && ($main_icon_position != 'title-left' && $main_icon_position != 'title-right')) {
                $this->icon_output();
             } 
             ?>
            
                    <div class="mg-infobox-text">
                        <div class="mg-infobox-title-wrap">
                        <?php
                         if ($use_icon == 'yes' && ($main_icon_position === 'title-left' || $main_icon_position === 'title-right')) {
                            $this->icon_output();
                        }
                        if ($title) :
                            printf(
                                '<%1$s %2$s>%3$s</%1$s>',
                                mg_validate_html_tag($title_tag),
                                $this->get_render_attribute_string('mginfo_title'),
                                mg_kses_tags($title)
                            );
                        endif;
                        ?>
                        </div>
                        <?php if ($desc) : ?>
                            <p <?php $this->print_render_attribute_string('mginfo_desc'); ?>><?php echo wp_kses_post($desc); ?></p>
                        <?php endif; ?>
                        <?php if ($use_btn) : ?>
                            <?php if ($usebtn_icon == 'yes') : ?>
                                <a <?php echo $this->get_render_attribute_string('mginfo_btntitle'); ?>>
                                    <?php if ($icon_position == 'left') : ?>
                                        <?php mg_icons_render($settings, 'mginfo_btn_icon', 'mginfo_btn_selected_icon', ['class' => 'left']); ?>
                                    <?php endif; ?>
                                    <span><?php echo mg_kses_tags($btntitle); ?></span>
                                    <?php if ($icon_position == 'right') : ?>
                                        <?php mg_icons_render($settings, 'mginfo_btn_icon', 'mginfo_btn_selected_icon', ['class' => 'right']); ?>
                                    <?php endif; ?>
                                </a>
                            <?php else : ?>
                                <a <?php echo $this->get_render_attribute_string('mginfo_btntitle'); ?>><?php echo  mg_kses_tags($btntitle); ?></a>
                            <?php endif; ?>
                        <?php endif; ?>



                    </div>

             </div>
                <?php if ($mginfo_wraplinking) : ?>
                </a>
                <?php endif; ?>
            <?php if ($settings['info_badge_use']) : ?>
                <span class="mgc-badge mgcb-<?php echo esc_attr($settings['badge_position']); ?>"><?php echo mg_kses_tags($settings['badge_text']); ?></span>
            <?php endif; ?>
        </div>

    <?php
    }

    /**
     * Render Blank widget output on the frontend.
     *
     * Written in JS and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
     protected function content_template()
    {
    ?>
        <#
            var settings = settings;
            var use_icon = settings.mginfo_use_icon;
            var mginfo_icon_type = settings.mginfo_icon_type;
            var title = settings.mginfo_title;
            var title_tag = settings.mginfo_title_tag;
            var desc = settings.mginfo_desc;
            var title_align = settings.mginfo_title_align;
            var use_btn = settings.mginfo_use_btn;
            var btntitle = settings.mginfo_btntitle;
            var mginfo_wraplinking = settings.mginfo_wraplinking;
            var mginfo_wraplink = settings.mginfo_wraplink;
            var btn_link = settings.mginfo_btn_link;
            var usebtn_icon = settings.mginfo_usebtn_icon;
            var icon_position = settings.mginfo_icon_position;
            var main_icon_position = settings.mginfo_main_icon_position;

            view.addInlineEditingAttributes('mginfo_title', 'basic');
            view.addRenderAttribute('mginfo_title', 'class', 'mg-infobox-title');

            view.addInlineEditingAttributes('mginfo_desc');
            view.addRenderAttribute('mginfo_desc', 'class', 'mg-infobox-desc');

            view.addRenderAttribute('mginfo_btntitle', 'class', 'mg-btn-text');
            view.addRenderAttribute('mginfo_btntitle', 'class', 'mg-infolink');
            view.addRenderAttribute('mginfo_btntitle', 'href', btn_link.url);
            if (btn_link.is_external) {
                view.addRenderAttribute('mginfo_btntitle', 'target', '_blank');
            }
            if (btn_link.nofollow) {
                view.addRenderAttribute('mginfo_btntitle', 'rel', 'nofollow');
            }

            // wrapper linking
            view.addRenderAttribute('mginfo_wraplink', 'href', mginfo_wraplink.url);
            if (mginfo_wraplink.is_external) {
                view.addRenderAttribute('mginfo_wraplink', 'target', '_blank');
            }
            if (mginfo_wraplink.nofollow) {
                view.addRenderAttribute('mginfo_wraplink', 'rel', 'nofollow');
            }

            var mgInfoImage = {
                id: settings.mginfo_type_image.id,
                url: settings.mginfo_type_image.url,
                size: settings.mginfo_thumbnail_size,
                dimension: settings.mginfo_thumbnail_custom_dimension,
                model: view.getEditModel()
            };
            var mginfo_image_url = elementor.imagesManager.getImageUrl(mgInfoImage);

            function iconOutput() {
                if (mginfo_icon_type === 'image') {
                    return '<div class="mgicon-area"><figure class="mg-infobox-img"><img src="' + mginfo_image_url + '" /></figure></div>';
                } else {
                    var iconHTML = elementor.helpers.renderIcon(view, settings.mginfo_type_selected_icon, { 'aria-hidden': true }, 'i', 'object');
                    return '<div class="mgicon-area"><div class="mg-infobox-icon">' + iconHTML.value + '</div></div>';
                }
            }
        #>

        <div class="mg-infobox {{ settings.mginfo_fullhover ? 'active-fhover' : '' }} mg-infobox-ps-{{ main_icon_position }} mg-infobox-ta-{{ title_align }}">
            <# if (mginfo_wraplinking) { #>
                <a {{{ view.getRenderAttributeString('mginfo_wraplink') }}}>
            <# } #>

            <div class="mg-infobox-inner">
                <# if (use_icon === 'yes' && (main_icon_position !== 'title-left' && main_icon_position !== 'title-right')) { #>
                    {{{ iconOutput() }}}
                <# } #>
            
                <div class="mg-infobox-text">
                    <div class="mg-infobox-title-wrap">
                        <# if (use_icon === 'yes' && (main_icon_position === 'title-left' || main_icon_position === 'title-right')) { #>
                            {{{ iconOutput() }}}
                        <# } #>
                        <# if (title) { #>
                            <{{{ title_tag }}} {{{ view.getRenderAttributeString('mginfo_title') }}}>{{{ title }}}</{{{ title_tag }}}>
                        <# } #>
                    </div>
                    <# if (desc) { #>
                        <p {{{ view.getRenderAttributeString('mginfo_desc') }}}>{{{ desc }}}</p>
                    <# } #>
                    <# if (use_btn) { #>
                        <# if (usebtn_icon === 'yes') { #>
                            <a {{{ view.getRenderAttributeString('mginfo_btntitle') }}}>
                                <# if (icon_position === 'left') { #>
                                    <# var btnIconHTML = elementor.helpers.renderIcon(view, settings.mginfo_btn_selected_icon, { 'class': 'left' }, 'i', 'object'); #>
                                    {{{ btnIconHTML.value }}}
                                <# } #>
                                <span>{{{ btntitle }}}</span>
                                <# if (icon_position === 'right') { #>
                                    <# var btnIconHTML = elementor.helpers.renderIcon(view, settings.mginfo_btn_selected_icon, { 'class': 'right' }, 'i', 'object'); #>
                                    {{{ btnIconHTML.value }}}
                                <# } #>
                            </a>
                        <# } else { #>
                            <a {{{ view.getRenderAttributeString('mginfo_btntitle') }}}>{{{ btntitle }}}</a>
                        <# } #>
                    <# } #>
                </div>
            </div>

            <# if (mginfo_wraplinking) { #>
                </a>
            <# } #>
            <# if (settings.info_badge_use) { #>
                <span class="mgc-badge mgcb-{{ settings.badge_position }}">{{{ settings.badge_text }}}</span>
            <# } #>
        </div>

    <?php
    } 
}
