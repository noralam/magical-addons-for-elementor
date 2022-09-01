<?php


class MgAddon_Flip_Box extends \Elementor\Widget_Base
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
        return 'mgflipbox_widget';
    }

    /**
     * Get widget title.
     *
     * Retrieve Blank widget title.+
     * 
     * @return string Widget title.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_title()
    {
        return __('MG Flip Box', 'magical-addons-for-elementor');
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
        return 'eicon-flip-box';
    }
    public function get_keywords()
    {
        return ['flip', 'services', 'box', 'icon', 'mg', 'flipbox'];
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
            'mg_flip_style_section',
            [
                'label' => __('Flip Style Section', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );


        $this->add_control(
            'mgflip_style',
            [
                'label' => __('Flip Style', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );
        $this->add_control(
            'mg_flip_styles',
            [
                'label' => __('Select Flip Style', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'style1' => __('Style One', 'magical-addons-for-elementor'),
                    'style2' => __('Style Two', 'magical-addons-for-elementor'),

                ],
                'default' => 'style1',

            ]

        );


        $this->add_control(
            'mg_flip_effects',
            [
                'label' => __('Select Flip Effect', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '3d-flip-right' => __('3D Flip Right', 'magical-addons-for-elementor'),
                    '3d-flip-left' => __('3D Flip Left', 'magical-addons-for-elementor'),
                    '3d-flip-up' => __('3D Flip Up', 'magical-addons-for-elementor'),
                    '3d-flip-down' => __('3D Flip Down', 'magical-addons-for-elementor'),

                ],
                'default' => '3d-flip-down',

                'condition' => [
                    'mg_flip_styles' => 'style1',
                ],
            ]
        );

        $this->add_control(
            'mg_flip_style_two_effects',
            [
                'label' => __('Select Flip Effect', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'flip-right' => __('Flip Right', 'magical-addons-for-elementor'),
                    'flip-left' => __('Flip Left', 'magical-addons-for-elementor'),
                    'flip-up' => __('Flip Up', 'magical-addons-for-elementor'),
                    'flip-down' => __('Flip Down', 'magical-addons-for-elementor'),

                ],
                'default' => 'flip-right',

                'condition' => [
                    'mg_flip_styles' => 'style2',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'mg_flip_all_section',
            [
                'label' => __('Flip Section', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->start_controls_tabs('flip_container');

        $this->start_controls_tab(
            'mgflip_normal_style',
            [
                'label' => __('Normal', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'mgf_icon_type',
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
                'default' => 'image',
                'toggle' => true,
                'condition' => [
                    'mg_flip_styles' => 'style1',
                ],
            ]
        );

        $this->add_control(
            'mgf_type_selected_icon',
            [
                'label' => __('Choose Icon', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default' => [
                    'value' => 'far fa-grin-alt',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'mgf_icon_type' => 'icon',
                    'mg_flip_styles' => 'style1',
                ],
            ]
        );


        $this->add_control(
            'mgf_flip_normal_img',
            [
                'label' => __('Choose Image', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'mgf_icon_type' => 'image',
                    'mg_flip_styles' => 'style1',
                ],

            ]
        );
        $this->add_control(
            'mgf_flip_style_two_normal_img',
            [
                'label' => __('Choose Image', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'mg_flip_styles' => 'style2',
                ],

            ]
        );

        $this->add_control(
            'mgflip_normal_content',
            [
                'label' => __('Normal Content', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'mg_flip_normal_title',
            [
                'label'       => __('Title', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => __('Enter Normal Flip Title', 'magical-addons-for-elementor'),
                'default'     => __('Burger', 'magical-addons-for-elementor'),
                'label_block'     => true,
                'condition' => [
                    'mg_flip_styles' => 'style1',
                ],
            ]
        );
        $this->add_control(
            'mg_flip_style_two_normal_title',
            [
                'label'       => __('Title', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => __('Enter Normal Flip Title', 'magical-addons-for-elementor'),
                'default'     => __('Why You Should Bring Your Dog To Work', 'magical-addons-for-elementor'),
                'label_block'     => true,
                'condition' => [
                    'mg_flip_styles' => 'style2',
                ],
            ]
        );
        $this->add_control(
            'mg_flip_normal_title_tag',
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
                'condition' => [
                    'mg_flip_styles' => 'style1',
                ],
            ]
        );
        $this->add_control(
            'mg_flip_style_two_normal_title_tag',
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
                'default' => 'h3',
                'condition' => [
                    'mg_flip_styles' => 'style2',
                ],
            ]
        );

        $this->add_control(
            'mg_flip_normal_desc',
            [
                'label'       => __('Description', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'input_type'  => 'text',
                'placeholder' => __('Flip subtitle goes here.', 'magical-addons-for-elementor'),
                'default'     => __('Fresh tasty chicken burger', 'magical-addons-for-elementor'),

                'condition' => [
                    'mg_flip_styles' => 'style1',
                ],
            ]
        );

        $this->add_responsive_control(
            'mg_flip_normal_img_align',
            [
                'label' => __('Alignment', 'magical-addons-for-elementor'),
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
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .front-content' => 'align-items: {{VALUE}};',
                ],
                'condition' => [
                    'mg_flip_styles' => 'style1',
                ],
            ]
        );
        $this->add_responsive_control(
            'mg_flip_normal_text_align',
            [
                'label' => __('Content Alignment', 'magical-addons-for-elementor'),
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
                    '{{WRAPPER}} .front-details,{{WRAPPER}} .mg-flip-text' => 'text-align: {{VALUE}};',
                ],

            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgflip_normal_boxshadow',
                'selectors' => '{{WRAPPER}} .flip-container,{{WRAPPER}} .mg-flip-boxs',
            ]
        );
        $this->end_controls_tab();


        $this->start_controls_tab(
            'mgflip_hover_style',
            [
                'label' => __('Hover', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'mg_flip_hover_title',
            [
                'label'       => __('Title', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => __('Enter Hover Flip Title', 'magical-addons-for-elementor'),
                'default'     => __('Burger', 'magical-addons-for-elementor'),
                'label_block'     => true,
                'condition' => [
                    'mg_flip_styles' => 'style1',
                ],
            ]
        );
        $this->add_control(
            'mg_flip_style_two_hover_title',
            [
                'label'       => __('Title', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => __('Enter Hover Flip Title', 'magical-addons-for-elementor'),
                'default'     => __('For sun lovers', 'magical-addons-for-elementor'),
                'label_block'     => true,
                'condition' => [
                    'mg_flip_styles' => 'style2',
                ],
            ]
        );
        $this->add_control(
            'mg_flip_hover_title_tag',
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
                'default' => 'h3',
                'condition' => [
                    'mg_flip_styles' => 'style1',
                ],
            ]
        );
        $this->add_control(
            'mg_flip_style_two_hover_title_tag',
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
                'default' => 'h1',
                'condition' => [
                    'mg_flip_styles' => 'style2',
                ],
            ]
        );

        $this->add_control(
            'mg_flip_hover_desc',
            [
                'label'       => __('Description', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'input_type'  => 'text',
                'placeholder' => __('Flip description goes here.', 'magical-addons-for-elementor'),
                'default'     => __('Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum, necessitatibus?', 'magical-addons-for-elementor'),

                'condition' => [
                    'mg_flip_styles' => 'style1',
                ],
            ]
        );
        $this->add_control(
            'mg_flip_style_two_hover_desc',
            [
                'label'       => __('Description', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'input_type'  => 'text',
                'placeholder' => __('Flip description goes here.', 'magical-addons-for-elementor'),
                'default'     => __('Relax akorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda, illum.', 'magical-addons-for-elementor'),

                'condition' => [
                    'mg_flip_styles' => 'style2',
                ],
            ]
        );


        $this->add_responsive_control(
            'mg_flip_hover_btn_align',
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
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .back-content,{{WRAPPER}} .mg-flip-backend' => 'align-items: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mg_flip_hover_text_align',
            [
                'label' => __('Content Alignment', 'magical-addons-for-elementor'),
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
                    '{{WRAPPER}} .back-content,{{WRAPPER}} .mg-flip-backend' => 'text-align: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();
        $this->end_controls_tabs();


        $this->end_controls_section();

        $this->start_controls_section(
            'mg_flip_button',
            [
                'label' => __('Button', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mg_flip_btn_use',
            [
                'label' => __('Use Flip Button?', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mg_flip_btn_title',
            [
                'label'       => __('Button Title', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => __('Button Text', 'magical-addons-for-elementor'),
                'default'     => __('View Deals', 'magical-addons-for-elementor'),
            ]
        );
        $this->add_control(
            'mg_flip_btn_link',
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
            'mg_flip_usebtn_icon',
            [
                'label' => __('Use icon', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'default' => 'no',
            ]
        );
        $this->add_control(
            'mg_flip_btn_selected_icon',
            [
                'label' => __('Choose Icon', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-chevron-right',
                    'library' => 'solid',
                ],
                'condition' => [
                    'mg_flip_usebtn_icon' => 'yes',
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
                    'mg_flip_usebtn_icon' => 'yes',
                ],

            ]
        );



        $this->start_controls_tabs('mgflip_container');

        $this->start_controls_tab(
            'mgf_btn_normal_style',
            [
                'label' => __('Normal', 'magical-addons-for-elementor'),
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
                    'mg_flip_usebtn_icon' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-flip-btn .left i' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mg-flip-btn .right i' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();


        $this->start_controls_tab(
            'mgf_btn_hover_style',
            [
                'label' => __('Hover', 'magical-addons-for-elementor'),
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
                    'mg_flip_usebtn_icon' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-flip-btn:hover .left i' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mg-flip-btn:hover .right i' => 'margin-left: {{SIZE}}{{UNIT}};',
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
            'mg_flip_basic_style',
            [
                'label' => __('Basic style', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );



        $this->start_controls_tabs('flip_container_style');

        $this->start_controls_tab(
            'mgflip_basic_normal_style',
            [
                'label' => __('Normal', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'mg_normal_flip_box_height',
            [
                'label' => __('Flip Box Height', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .flip-container,{{WRAPPER}} .mg-flip-boxs' => '  min-height: {{SIZE}}{{UNIT}};',
                ],

            ]
        );


        $this->add_responsive_control(
            'mg_flip_normal_content_padding',
            [
                'label' => __('Content Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .front-content,{{WRAPPER}} .mg-flip-boxs' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mg_flip_normal_content_margin',
            [
                'label' => __('Content Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .front-content,{{WRAPPER}} .mg-flip-boxs' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mg_flip_normal_content_bg_color',
                'label' => esc_html__('Background', 'magical-addons-for-elementor'),
                'types' => ['classic', 'gradient', 'video'],
                'selectors' => [
                    '{{WRAPPER}} .front,{{WRAPPER}} .mg-flip-boxs' => 'background-color: {{VALUE}};',
                ],
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );



        $this->add_control(
            'mg_flip_normal_content_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .flip-container,{{WRAPPER}} .front,{{WRAPPER}} .mg-flip-boxs' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->end_controls_tab();


        $this->start_controls_tab(
            'mgflip_basic_hover_style',
            [
                'label' => __('Hover', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'mg_hover_flip_box_height',
            [
                'label' => __('Flip Box Height', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .flip-container' => '  min-height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'mg_flip_styles' => 'style1',
                ],
            ]
        );

        $this->add_responsive_control(
            'mg_flip_hover_content_padding',
            [
                'label' => __('Content Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .back-content,{{WRAPPER}} .mg-flip-backend' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mg_flip_hover_content_margin',
            [
                'label' => __('Content Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .back-content,{{WRAPPER}} .mg-flip-backend' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mg_flip_hover_content_bg_color',
                'label' => esc_html__('Background', 'magical-addons-for-elementor'),
                'types' => ['classic', 'gradient', 'video'],
                'selectors' => [
                    '{{WRAPPER}} .back,{{WRAPPER}} .mg-flip-backend' => 'background-color: {{VALUE}};',
                ],
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );





        $this->add_control(
            'mg_flip_hover_content_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .flip-container,{{WRAPPER}} .back,{{WRAPPER}} .mg-flip-backend' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();


        $this->start_controls_section(
            'mg_flip_img_style',
            [
                'label' => __('Image and Icon style', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'mg_flip_styles' => 'style1',
                ],
            ]
        );

        $this->add_control(
            'mg_flip_img_width',
            [
                'label' => __('Image Width', 'magical-addons-for-elementor'),
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
                    'mgf_icon_type' => 'image',
                ],
                'selectors' => [
                    '{{WRAPPER}} .front img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_control(
            'mg_flip_img_height',
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
                    'mgf_icon_type' => 'image',
                ],
                'selectors' => [
                    '{{WRAPPER}} .front img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_responsive_control(
            'mg_flip_img_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .front img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgf_icon_type' => 'image',
                ],
            ]
        );
        $this->add_responsive_control(
            'mg_flip_img_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .front img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgf_icon_type' => 'image',
                ],
            ]
        );
        $this->add_control(
            'mg_flip_imgbg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .front img' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'mgf_icon_type' => 'image',
                ],
            ]
        );

        $this->add_control(
            'mg_flip_img_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .front img' =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgf_icon_type' => 'image',
                ],

            ]
        );

        $this->add_responsive_control(
            'mg_flip_icon_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgf-normal-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgf_icon_type' => 'icon',
                ],
            ]
        );
        $this->add_responsive_control(
            'mg_flip_icon_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgf-normal-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgf_icon_type' => 'icon',
                ],
            ]
        );
        $this->add_control(
            'mg_flip_icon_color',
            [
                'label' => __('Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mgf-normal-icon i' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'mgf_icon_type' => 'icon',
                ],
            ]
        );
        $this->add_control(
            'mg_flip_iconbg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mgf-normal-icon' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'mgf_icon_type' => 'icon',
                ],
            ]
        );

        $this->add_control(
            'mg_flip_icon_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgf-normal-icon' =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgf_icon_type' => 'icon',
                ],

            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mg_flip_img_border',
                'selector' => '{{WRAPPER}} .front img,
				{{WRAPPER}} .mgf-normal-icon',
            ],


        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgflip_image_boxshadow',
                'selector' => '{{WRAPPER}} .front img,
				{{WRAPPER}} .mgf-normal-icon',
            ]
        );

        $this->end_controls_section();




        $this->start_controls_section(
            'mg_flip_style_two_img_style',
            [
                'label' => __('Image Style', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'mg_flip_styles' => 'style2',
                ],
            ]
        );

        $this->add_responsive_control(
            'mg_flip_style_two_img_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-flip-fornted img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mg_flip_style_two_img_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-flip-fornted img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mg_flip_style_two_imgbg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mg-flip-fornted img' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mg_flip_style_two_img_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-flip-fornted img' =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mg_flip_style_two_img_border',
                'selector' => '{{WRAPPER}} .mg-flip-fornted img',
            ],


        );

        $this->end_controls_section();


        $this->start_controls_section(
            'mg_flip_card_details_style',
            [
                'label' => __('Flip Box Title', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('flip_title_all_style');

        $this->start_controls_tab(
            'mgflip_title_normal_style',
            [
                'label' => __('Normal', 'magical-addons-for-elementor'),
            ]
        );



        $this->add_responsive_control(
            'mg_flip_normal_title_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-flip-normal-title,{{WRAPPER}} .mg-flip-style-two-normal-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mg_flip_normal_title_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-flip-normal-title,{{WRAPPER}} .mg-flip-style-two-normal-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mg_flip_normal_title_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-flip-normal-title,{{WRAPPER}} .mg-flip-style-two-normal-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_flip_normal_title_bgcolor',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-flip-normal-title,{{WRAPPER}} .mg-flip-style-two-normal-title' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_flip_normal_descb_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-flip-normal-title,{{WRAPPER}} .mg-flip-style-two-normal-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mg_flip_normal_title_typography',
                'label' => __('Typography', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .mg-flip-normal-title',
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_3,
                'condition' => [
                    'mg_flip_styles' => 'style1',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mg_flip_style_two_normal_title_typography',
                'label' => __('Typography', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .mg-flip-style-two-normal-title',
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_3,
                'condition' => [
                    'mg_flip_styles' => 'style2',
                ],
            ]
        );


        $this->end_controls_tab();


        $this->start_controls_tab(
            'mgflip_titlt_hover_style',
            [
                'label' => __('Hover', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_responsive_control(
            'mg_flip_hover_title_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-flip-hover-title,{{WRAPPER}} .mg-flip-style-two-hover-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mg_flip_hover_title_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-flip-hover-title,{{WRAPPER}} .mg-flip-style-two-hover-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mg_flip_hover_title_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-flip-hover-title,{{WRAPPER}} .mg-flip-style-two-hover-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_flip_hover_title_bgcolor',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-flip-hover-title,{{WRAPPER}} .mg-flip-style-two-hover-title' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_flip_hover_descb_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-flip-hover-title,{{WRAPPER}} .mg-flip-style-two-hover-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mg_flip_hover_title_typography',
                'label' => __('Typography', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .mg-flip-hover-title',
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_3,
                'condition' => [
                    'mg_flip_styles' => 'style1',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mg_flip_style_two_hover_title_typography',
                'label' => __('Typography', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .mg-flip-style-two-hover-title',
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_3,
                'condition' => [
                    'mg_flip_styles' => 'style2',
                ],
            ]
        );


        $this->end_controls_tab();
        $this->end_controls_tabs();


        $this->end_controls_section();







        $this->start_controls_section(
            'mgtm_card_description_style',
            [
                'label' => __('Flip Box Description', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'mg_flip_styles' => 'style1',
                ],
            ]
        );


        $this->start_controls_tabs('flip_description_content');

        $this->start_controls_tab(
            'mgflip_description_normal_style',
            [
                'label' => __('Normal', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_responsive_control(
            'mg_flip_normal_description_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .front-details p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mg_flip_normal_description_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .front-details p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mg_flip_normal_description_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .front-details p' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_flip_normal_description_bgcolor',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .front-details p' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_flip_normal_description_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .front-details p' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mg_flip_normal_description_typography',
                'label' => __('Typography', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .front-details p',
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_3,
            ]
        );



        $this->end_controls_tab();

        $this->start_controls_tab(
            'mgflip_description_hover_style',
            [
                'label' => __('Hover', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_responsive_control(
            'mg_flip_hover_description_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .back-content p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mg_flip_hover_description_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .back-content p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mg_flip_hover_description_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .back-content p' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_flip_hover_description_bgcolor',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .back-content p' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_flip_hover_description_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .back-content p' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mg_flip_hover_description_typography',
                'label' => __('Typography', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .back-content p',
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_3,
            ]
        );




        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();


        $this->start_controls_section(
            'mgflip_card_description_style',
            [
                'label' => __('Flip Box Hover Description', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'mg_flip_styles' => 'style2',
                ],
            ]
        );

        $this->add_responsive_control(
            'mg_flip_style_two_normal_description_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-flip-backend p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mg_flip_style_two_normal_description_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-flip-backend p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mg_flip_style_two_normal_description_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-flip-backend p' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_flip_style_two_normal_description_bgcolor',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-flip-backend p' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_flip_style_two_normal_description_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-flip-backend p' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mg_flip_style_two_normal_description_typography',
                'label' => __('Typography', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .mg-flip-backend p',
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_3,
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
            'mgflip_btn_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-flip-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgflip_btn_typography',
                'selector' => '{{WRAPPER}} .mg-flip-btn',
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_4,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgflip_btn_border',
                'selector' => '{{WRAPPER}} .mg-flip-btn',
            ]
        );

        $this->add_control(
            'mgflip_btn_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-flip-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgflip_btn_box_shadow',
                'selector' => '{{WRAPPER}} .mg-flip-btn',
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
                    '{{WRAPPER}} .mg-flip-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgflip_btn_bg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-flip-btn' => 'background-color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .mg-flip-btn:hover',
            ]
        );

        $this->add_control(
            'mgflip_btn_hcolor',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-flip-btn:hover, {{WRAPPER}} .mg-flip-btn:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgflip_btn_hbg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-flip-btn:hover, {{WRAPPER}} .mg-flip-btn:focus' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .mg-flip-btn:hover, {{WRAPPER}} .mg-flip-btn:focus' => 'border-color: {{VALUE}};',
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
        $mg_flip_styles = $settings['mg_flip_styles'];
        if ($mg_flip_styles == 'style1') {
            $this->flip_style_base_one($settings);
        } else {
            $this->flip_style_base_two($settings);
        }
    }


    public function flip_style_base_one($settings)
    {
        // Flip effets And Styles

        $mg_flip_styles = $this->get_settings('mg_flip_styles');

        $mg_flip_effects = $this->get_settings('mg_flip_effects');


        // Flip Icon Type
        $mgf_icon_type = $this->get_settings('mgf_icon_type');


        //Flip card normal Content
        $mg_flip_normal_title = $this->get_settings('mg_flip_normal_title');
        $mg_flip_normal_title_tag = $this->get_settings('mg_flip_normal_title_tag');
        $this->add_inline_editing_attributes('mg_flip_normal_title');
        $this->add_render_attribute('mg_flip_normal_title', 'class', 'mg-flip-normal-title');


        //Flip card Hover Content
        $mg_flip_hover_title = $this->get_settings('mg_flip_hover_title');
        $mg_flip_hover_title_tag = $this->get_settings('mg_flip_hover_title_tag');
        $this->add_inline_editing_attributes('mg_flip_hover_title');
        $this->add_render_attribute('mg_flip_hover_title', 'class', 'mg-flip-hover-title');

        //Normal description
        $mg_flip_normal_desc = $this->get_settings('mg_flip_normal_desc');
        $this->add_inline_editing_attributes('mg_flip_normal_desc');

        //hover description
        $mg_flip_hover_desc = $this->get_settings('mg_flip_hover_desc');
        $this->add_inline_editing_attributes('mg_flip_hover_desc');

        // Flip Btn item
        $mg_flip_btn_link = $this->get_settings('mg_flip_btn_link');

        $this->add_inline_editing_attributes('mg_flip_btn_title', 'none');
        $this->add_render_attribute('mg_flip_btn_title', 'class', 'mg-flip-btn');

        $this->add_render_attribute('mg_flip_btn_title', 'class', 'mg-flip-btn');
        $this->add_render_attribute('mg_flip_btn_title', 'href', esc_url($mg_flip_btn_link['url']));
        if (!empty($mg_flip_btn_link['is_external'])) {
            $this->add_render_attribute('mg_flip_btn_title', 'target', '_blank');
        }
        if (!empty($mg_flip_btn_link['nofollow'])) {
            $this->set_render_attribute('mg_flip_btn_title', 'rel', 'nofollow');
        }


?>


        <div class="flip-container mg-flip-<?php echo esc_attr($mg_flip_styles); ?> flip-container-<?php echo esc_attr($mg_flip_effects); ?> ">
            <div class="front side mg-shadow">
                <div class="front-content">

                    <?php if ($mgf_icon_type == 'image') : ?>
                        <figure>
                            <?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'mgf_flip_normal_img'); ?>

                        </figure>
                    <?php else : ?>
                        <div class="mgf-normal-icon">
                            <?php \Elementor\Icons_Manager::render_icon($settings['mgf_type_selected_icon']); ?>
                        </div>
                    <?php endif; ?>


                    <div class="front-details">
                        <?php
                        if ($mg_flip_normal_title) :
                            printf(
                                '<%1$s %2$s>%3$s</%1$s>',
                                tag_escape($mg_flip_normal_title_tag),
                                $this->get_render_attribute_string('mg_flip_normal_title'),
                                mg_kses_tags($mg_flip_normal_title)
                            );
                        endif;
                        ?>
                        <?php if ($mg_flip_normal_desc) : ?>
                            <p <?php echo $this->get_render_attribute_string('mg_flip_normal_desc'); ?>><?php echo wp_kses_post($mg_flip_normal_desc); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="back back-<?php echo esc_attr($mg_flip_effects); ?>  side mg-shadow">
                <div class="back-content">
                    <?php
                    if ($mg_flip_hover_title) :
                        printf(
                            '<%1$s %2$s>%3$s</%1$s>',
                            tag_escape($mg_flip_hover_title_tag),
                            $this->get_render_attribute_string('mg_flip_hover_title'),
                            mg_kses_tags($mg_flip_hover_title)
                        );
                    endif;
                    ?>
                    <?php if ($mg_flip_hover_desc) : ?>
                        <p <?php echo $this->get_render_attribute_string('mg_flip_hover_desc'); ?>><?php echo wp_kses_post($mg_flip_hover_desc); ?></p>
                    <?php endif; ?>
                    <?php $this->mgf_button($settings); ?>

                </div>
            </div>

        </div>

    <?php
    }



    public function flip_style_base_two($settings)
    {

        $mg_flip_styles = $settings['mg_flip_styles'];
        $mg_flip_style_two_effects = $settings['mg_flip_style_two_effects'];


        //Flip card normal Content
        $mg_flip_style_two_normal_title = $this->get_settings('mg_flip_style_two_normal_title');
        $mg_flip_style_two_normal_title_tag = $this->get_settings('mg_flip_style_two_normal_title_tag');
        $this->add_inline_editing_attributes('mg_flip_normal_title');
        $this->add_render_attribute('mg_flip_style_two_normal_title', 'class', 'mg-flip-style-two-normal-title');


        //Flip card Hover Content
        $mg_flip_style_two_hover_title = $this->get_settings('mg_flip_style_two_hover_title');
        $mg_flip_style_two_hover_title_tag = $this->get_settings('mg_flip_style_two_hover_title_tag');
        $this->add_inline_editing_attributes('mg_flip_style_two_hover_title');
        $this->add_render_attribute('mg_flip_style_two_hover_title', 'class', 'mg-flip-style-two-hover-title');

        //hover description
        $mg_flip_style_two_hover_desc = $this->get_settings('mg_flip_style_two_hover_desc');
        $this->add_inline_editing_attributes('mg_flip_style_two_hover_desc');

        // Flip Btn item
        $mg_flip_btn_link = $this->get_settings('mg_flip_btn_link');

        $this->add_inline_editing_attributes('mg_flip_btn_title', 'none');
        $this->add_render_attribute('mg_flip_btn_title', 'class', 'mg-flip-btn');

        $this->add_render_attribute('mg_flip_btn_title', 'class', 'mg-flip-btn');
        $this->add_render_attribute('mg_flip_btn_title', 'href', esc_url($mg_flip_btn_link['url']));
        if (!empty($mg_flip_btn_link['is_external'])) {
            $this->add_render_attribute('mg_flip_btn_title', 'target', '_blank');
        }
        if (!empty($mg_flip_btn_link['nofollow'])) {
            $this->set_render_attribute('mg_flip_btn_title', 'rel', 'nofollow');
        }
    ?>

        <div class="mg-flip-boxs mg-flip-<?php echo esc_attr($mg_flip_style_two_effects); ?> mg-shadow mg-flip-<?php echo esc_attr($mg_flip_styles); ?>">
            <div class="mg-flip-fornted">
                <div class="mg-flip-image">
                    <figure>
                        <?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'mgf_flip_style_two_normal_img'); ?>
                    </figure>
                </div>
                <div class="mg-flip-text">
                    <?php
                    if ($mg_flip_style_two_normal_title) :
                        printf(
                            '<%1$s %2$s>%3$s</%1$s>',
                            tag_escape($mg_flip_style_two_normal_title_tag),
                            $this->get_render_attribute_string('mg_flip_style_two_normal_title'),
                            mg_kses_tags($mg_flip_style_two_normal_title)
                        );
                    endif;
                    ?>
                </div>
            </div>
            <div class="mg-flip-backend mg-flip-<?php echo esc_attr($mg_flip_style_two_effects); ?>">
                <?php
                if ($mg_flip_style_two_hover_title) :
                    printf(
                        '<%1$s %2$s>%3$s</%1$s>',
                        tag_escape($mg_flip_style_two_hover_title_tag),
                        $this->get_render_attribute_string('mg_flip_style_two_hover_title'),
                        mg_kses_tags($mg_flip_style_two_hover_title)
                    );
                endif;
                ?>
                <?php if ($mg_flip_style_two_hover_desc) : ?>
                    <p <?php echo $this->get_render_attribute_string('mg_flip_style_two_hover_desc'); ?>><?php echo wp_kses_post($mg_flip_style_two_hover_desc); ?></p>
                <?php endif; ?>

                <?php $this->mgf_button($settings); ?>
            </div>
        </div>


        <?php
    }





















    protected function content_template()
    {
    }

    public function mgf_button($settings)
    {
        $mg_flipbtn_icon_position = $settings['mg_flipbtn_icon_position'];
        $mg_flip_btn_use = $settings['mg_flip_btn_use'];
        $mg_flip_usebtn_icon = $settings['mg_flip_usebtn_icon'];
        $mg_flip_btn_title = $settings['mg_flip_btn_title'];
        $mg_flip_btn_link = $settings['mg_flip_btn_link'];
        $this->add_inline_editing_attributes('mg_flip_btn_title', 'none');
        $this->add_render_attribute('mg_flip_btn_title', 'class', 'mg-flip-btn');

        $this->add_render_attribute('mg_flip_btn_title', 'class', 'mg-hvrcard-btn');
        $this->add_render_attribute('mg_flip_btn_title', 'href', esc_url($mg_flip_btn_link['url']));
        if (!empty($mg_flip_btn_link['is_external'])) {
            $this->add_render_attribute('mg_flip_btn_title', 'target', '_blank');
        }
        if (!empty($mg_flip_btn_link['nofollow'])) {
            $this->set_render_attribute('mg_flip_btn_title', 'rel', 'nofollow');
        }

        if ($mg_flip_btn_use) :
            if ($mg_flip_usebtn_icon == 'yes') :
        ?>
                <a <?php echo $this->get_render_attribute_string('mg_flip_btn_title'); ?>>
                    <?php if ($mg_flipbtn_icon_position == 'left') : ?>
                        <span class="left"><?php \Elementor\Icons_Manager::render_icon($settings['mg_flip_btn_selected_icon']); ?></span>

                    <?php endif; ?>
                    <span><?php echo mg_kses_tags($mg_flip_btn_title); ?></span>
                    <?php if ($mg_flipbtn_icon_position == 'right') : ?>
                        <span class="right"><?php \Elementor\Icons_Manager::render_icon($settings['mg_flip_btn_selected_icon']); ?></span>
                    <?php endif; ?>
                </a>
            <?php else : ?>
                <a <?php echo $this->get_render_attribute_string('mg_flip_btn_title'); ?>><?php echo  mg_kses_tags($mg_flip_btn_title); ?></a>
            <?php endif; ?>
<?php
        endif;
    }
}
