<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

//mgcta_img_height ,,  Image Height Not worrking

class MgAddon_Banner extends \Elementor\Widget_Base
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
        return 'mg_banner_widget';
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
        return __('MG Banner', 'magical-addons-for-elementor');
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
        return ['mg banner', 'image', 'banner', '', 'banner image', 'mg'];
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
            'mg_card_content',
            [
                'label' => __('Content', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'mg_cta_styles',
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

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgcta_content_bg_color',
                'label' => esc_html__('Background', 'magical-addons-for-elementor'),
                'types' => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .mg-cta',
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );




        $this->add_control(
            'mg_banner_subtitle_show',
            [
                'label' => __('Show Subtitle?', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'default' => 'yes',
            ]
        );


        $this->add_control(
            'mg_cta_subtitle',
            [
                'label'       => __('Subtitle', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'input_type'  => 'text',
                'placeholder' => __('Enter Subtitle', 'magical-addons-for-elementor'),
                'default'     => __('Beautiful Landing Page with', 'magical-addons-for-elementor'),
                'label_block'     => true,
                'condition' => [
                    'mg_banner_subtitle_show' => 'yes',
                ],

            ]
        );
        $this->add_control(
            'mg_cta_subtitle_tag',
            [
                'label' => __('Subtitle HTML Tag', 'magical-addons-for-elementor'),
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
                'default' => 'h4',
                'condition' => [
                    'mg_banner_subtitle_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mg_banner_sub_postion',
            [
                'label' => __('Subtitle Position', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'column-reverse' => [
                        'title' => __('Top', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'column' => [
                        'title' => __('Bottom', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-v-align-bottom',
                    ],

                ],
                'default' => 'column-reverse',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .mg-banner-sub' => 'flex-direction: {{VALUE}};',
                ],
                'condition' => [
                    'mg_banner_subtitle_show' => 'yes',
                ],
            ]
        );



        $this->add_control(
            'mg_banner_title_show',
            [
                'label' => __('Show Title?', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'default' => 'yes',
            ]
        );


        $this->add_control(
            'mg_cta_title',
            [
                'label'       => __('Title', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'input_type'  => 'text',
                'placeholder' => __('Enter Title', 'magical-addons-for-elementor'),
                'default'     => __('Beautiful Landing Page with', 'magical-addons-for-elementor'),
                'label_block'     => true,

                'condition' => [
                    'mg_banner_title_show' => 'yes',
                ],
            ]
        );


        $this->add_control(
            'mg_cta_highlight',
            [
                'label'       => __('Highlight Text', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => __('Enter Highlight Text', 'magical-addons-for-elementor'),
                'default'     => __('Elements', 'magical-addons-for-elementor'),
                'label_block'     => true,
                'condition' => [
                    'mg_banner_title_show' => 'yes',
                ],

            ]
        );
        $this->add_control(
            'mg_cta_title_tag',
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
                    'mg_banner_title_show' => 'yes',
                ],
            ]
        );


        $this->add_control(
            'mg_banner_des_show',
            [
                'label' => __('Show Description?', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mg_cta_desc',
            [
                'label'       => __('Description', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'input_type'  => 'text',
                'placeholder' => __('Call to action description goes here.', 'magical-addons-for-elementor'),
                'default'     => __('A small river named Duden flows by their place and supplies it with the necessary regelialia.
                It is a paradisematic country, in which', 'magical-addons-for-elementor'),
                'condition' => [
                    'mg_banner_des_show' => 'yes',
                ],

            ]
        );

        $this->add_responsive_control(
            'mgcta_title_align',
            [
                'label' => __('Title Alignment', 'magical-addons-for-elementor'),
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
                    '{{WRAPPER}} .mg-banner-sub' => 'align-items: {{VALUE}};',
                ],
            ]
        );


        $this->add_responsive_control(
            'mgcta_text_align',
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
                'default' => 'left',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .mg-cta-content' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgcta_btn_align',
            [
                'label' => __('Button Position', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'column' => [
                        'title' => __('Bottom', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                    'right' => [
                        'title' => __('Right', 'magical-addons-for-elementor'),
                        'icon' => ' eicon-h-align-right',
                    ],

                ],
                'default' => 'column',
                'toggle' => false,
                'condition' => [
                    'mg_cta_styles' => 'style1',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgcta_btn_content_align',
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
                    '{{WRAPPER}} .mg-cta .mg-cta-btn' => 'justify-content: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_section();



        $this->start_controls_section(
            'mgcla_img_section',
            [
                'label' => __('Image', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,

                'condition' => [
                    'mg_cta_styles' => 'style2',
                ],
            ]
        );

        $this->add_control(
            'mgcla_img',
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
            ]
        );
        $this->add_control(
            'mgcla_img_ps',
            [
                'label' => __('Image Position', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'row-reverse' => [
                        'title' => __('Left', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'row' => [
                        'title' => __('Right', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-h-align-right',
                    ],

                ],
                'default' => 'row',
                'toggle' => false,
                'selectors' => [
                    '{{WRAPPER}} .mg-cta' => 'flex-direction: {{VALUE}};',
                ],

            ]
        );
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
                'label' => __('Use Button?', 'magical-addons-for-elementor'),
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
                'default'     => __('VIEW DEALS', 'magical-addons-for-elementor'),
                'condition' => [
                    'mg_flip_btn_use' => 'yes',
                ],
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
                'condition' => [
                    'mg_flip_btn_use' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'mg_flip_usebtn_icon',
            [
                'label' => __('Use icon', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'default' => 'yes',
                'condition' => [
                    'mg_flip_btn_use' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'mg_flip_btn_selected_icon',
            [
                'label' => __('Choose Icon', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-long-arrow-alt-right',
                    'library' => 'solid',
                ],
                'condition' => [
                    'mg_flip_usebtn_icon' => 'yes',
                    'mg_flip_btn_use' => 'yes',
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
                    'mg_flip_btn_use' => 'yes',
                ],

            ]
        );

        $this->start_controls_tabs('mgcta_container');

        $this->start_controls_tab(
            'mgcta_btn_normal_style',
            [
                'label' => __('Normal', 'magical-addons-for-elementor'),

                'condition' => [
                    'mg_flip_usebtn_icon' => 'yes',
                    'mg_flip_btn_use' => 'yes',
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
                    'mg_flip_usebtn_icon' => 'yes',
                    'mg_flip_btn_use' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-flip-btn .left i' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mg-flip-btn .right i' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();


        $this->start_controls_tab(
            'mgcta_btn_hover_style',
            [
                'label' => __('Hover', 'magical-addons-for-elementor'),

                'condition' => [
                    'mg_flip_usebtn_icon' => 'yes',
                    'mg_flip_btn_use' => 'yes',
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
                    'mg_flip_usebtn_icon' => 'yes',
                    'mg_flip_btn_use' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} a.mg-flip-btn:hover .left i' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} a.mg-flip-btn:hover .right i' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();


        $this->end_controls_section();



        $this->start_controls_section(

            'mg_flip_button2',
            [
                'label' => __('2nd Button', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mg_flip_btn2_use',
            [
                'label' => __('Use Button?', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mg_flip_btn2_title',
            [
                'label'       => __('Button Title', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => __('Button Text', 'magical-addons-for-elementor'),
                'default'     => __('SEE IT', 'magical-addons-for-elementor'),
                'condition' => [
                    'mg_flip_btn2_use' => 'yes',
                ],
            ]
        );



        $this->add_responsive_control(
            'mg_flipbtn2_link_type',
            [
                'label' => __('Button Link Type', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'link' => [
                        'title' => __('Link', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-link',
                    ],
                    'video' => [
                        'title' => __('Video', 'magical-addons-for-elementor'),
                        'icon' => ' eicon-video-camera',
                    ],

                ],
                'default' => 'link',
                'condition' => [
                    'mg_flip_btn2_use' => 'yes',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'mg_flip_btn2_link',
            [
                'label' => __('Button Link', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'magical-addons-for-elementor'),
                'default' => [
                    'url' => '#',
                ],
                'condition' => [
                    'mg_flip_btn2_use' => 'yes',
                    'mg_flipbtn2_link_type' => 'link',
                ],
            ]
        );

        $this->add_control(
            'mg_flip_btn2_video_link',
            [
                'label' => __('YouTube Video Link', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'magical-addons-for-elementor'),
                'default' => [
                    'url' => '#',
                ],
                'condition' => [
                    'mg_flip_btn2_use' => 'yes',
                    'mg_flipbtn2_link_type' => 'video',
                ],
            ]
        );
        $this->add_control(
            'mg_flip_usebtn2_icon',
            [
                'label' => __('Use icon', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'default' => 'yes',
                'mg_flip_button2',
                [
                    'label' => __('2nd Button', 'magical-addons-for-elementor'),
                    'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
            ]
        );

        $this->add_control(
            'mg_flip_btn2_selected_icon',
            [
                'label' => __('Choose Icon', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-play-circle',
                    'library' => 'solid',
                ],
                'condition' => [
                    'mg_flip_usebtn2_icon' => 'yes',
                    'mg_flip_btn2_use' => 'yes',
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
                    'mg_flip_usebtn2_icon' => 'yes',
                    'mg_flip_btn2_use' => 'yes',
                ],
            ]
        );

        $this->start_controls_tabs('mgcta2_container');

        $this->start_controls_tab(
            'mgcta_btn2_normal_style',
            [
                'label' => __('Normal', 'magical-addons-for-elementor'),
                'condition' => [
                    'mg_flip_btn2_use' => 'yes',
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
                    'mg_flip_usebtn2_icon' => 'yes',
                    'mg_flip_btn2_use' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgcla-btn2 .left i' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mgcla-btn2 .right i' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();


        $this->start_controls_tab(
            'mgcta_btn2_hover_style',
            [
                'label' => __('Hover', 'magical-addons-for-elementor'),
                'condition' => [
                    'mg_flip_btn2_use' => 'yes',
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
                    'mg_flip_usebtn2_icon' => 'yes',
                    'mg_flip_btn2_use' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}}  a.mgcla-btn2:hover .left i' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} a.mgcla-btn2:hover .right i' => 'margin-left: {{SIZE}}{{UNIT}};',
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
            'mgcta_content_padding',
            [
                'label' => __('Content Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-cta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgcta_content_margin',
            [
                'label' => __('Content Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-cta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->add_control(
            'mgcta_content_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-cta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgcta_content_border',
                'selector' => '{{WRAPPER}} .mg-cta',
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgcta_block_shadow',
                'exclude' => [
                    'box_shadow_position',
                ],
                'selector' => '{{WRAPPER}} .mg-cta',
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
                'selector' => '{{WRAPPER}} .mg-cta:before',
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
                    '{{WRAPPER}} .mg-cta:before' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'mg_overly_css_filters',
                'selector' => '{{WRAPPER}} .mg-cta:before',
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'mg_cta_img_style',
            [
                'label' => __('Image style', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'mg_cta_styles' => 'style2'
                ],
            ]
        );
        $this->add_responsive_control(
            'mglca_image_width',
            [
                'label' => esc_html__('Width', 'magical-addons-for-elementor'),
                'type' =>  \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%', 'px'],
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
                    'px' => [
                        'min' => 10,
                        'max' => 1000,
                    ],

                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-cta.style-two img' => 'width: {{SIZE}}{{UNIT}} !important;',

                ],
            ]
        );

        $this->add_control(
            'mg_cta_img_auto_height',
            [
                'label' => __('Image auto height', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('On', 'magical-addons-for-elementor'),
                'label_off' => __('Off', 'magical-addons-for-elementor'),
                'default' => 'yes',
            ]
        );
        $this->add_responsive_control(
            'mglca_image_height',
            [
                'label' => esc_html__('Height', 'magical-addons-for-elementor'),
                'type' =>  \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%', 'px'],
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
                    'px' => [
                        'min' => 10,
                        'max' => 1000,
                    ],

                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-cta.style-two img' => 'height: {{SIZE}}{{UNIT}} !important;',

                ],
                'condition' => [
                    'mg_cta_img_auto_height' => '',
                ],
            ]
        );

        $this->add_control(
            'mg_cta_imgbg_height',
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
                    'mg_cta_img_auto_height' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-cta-img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mg_cta_img_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-cta-img figure' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mg_cta_img_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-cta-img figure' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mg_cta_img_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-cta-img figure img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->add_control(
            'mg_cta_imgbg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mg-cta-img' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mg_cta_img_border',
                'selector' => '{{WRAPPER}} .mg-cta-img figure img',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mg_card_card_details_style',
            [
                'label' => __('Title Style', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'mg_banner_title_show' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mg_cta_title_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-cta-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mg_cta_title_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-cta-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mg_cta_title_color',
            [
                'label' => __('Title Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-cta-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_cta_title_bgcolor',
            [
                'label' => __('Title Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-cta-title' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mg_cta_descb_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-cta-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mg_cta_title_typography',
                'label' => __('Title Typography', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .mg-cta-title',
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_3,
            ]
        );

        $this->add_control(
            'mgcta_highlights',
            [
                'type' => \Elementor\Controls_Manager::HEADING,
                'label' => __('Highlight Text', 'magical-addons-for-elementor'),
                'separator' => 'before'
            ]
        );
        $this->add_responsive_control(
            'mg_cta_highlight_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-cta-title span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mg_cta_highlight_color',
            [
                'label' => __('Highlight Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-cta-title span' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_cta_highlight_bgcolor',
            [
                'label' => __('Highlight Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-cta-title span' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mg_cta_high_descb_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-cta-title span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mg_cta_highlight_typography',
                'label' => __('Highlight Typography', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .mg-cta-title span',
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_3,
            ]
        );

        $this->end_controls_section();




        $this->start_controls_section(
            'mg_banner_subtitle_style',
            [
                'label' => __('Subtitle Style', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'mg_banner_subtitle_show' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mg_subtitle_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-cta-subtitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mg_subtitle_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-cta-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mg_subtitle_color',
            [
                'label' => __('Subtitle Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-cta-subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_subtitle_bgcolor',
            [
                'label' => __('Subtitle Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-cta-subtitle' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mg_subtitle_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-cta-subtitle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mg_subtitle_typography',
                'label' => __('Title Typography', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .mg-cta-subtitle',
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_3,
            ]
        );

        $this->end_controls_section();



        $this->start_controls_section(
            'mgtm_card_description_style',
            [
                'label' => __('Description', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'mg_banner_des_show' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mg_cta_description_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-cta-content p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mg_cta_description_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-cta-content p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mg_cta_description_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-cta-content p' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_cta_description_bgcolor',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-cta-content p' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mg_cta_description_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-cta-content p' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mg_cta_description_typography',
                'label' => __('Typography', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .mg-cta-content p',
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_3,
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'mgbtn_card_style',
            [
                'label' => __('Button', 'magical-addons-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'mg_flip_btn_use' => 'yes',
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
                    '{{WRAPPER}} a.mg-flip-btn.mgcla-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgflip_btn_typography',
                'selector' => '{{WRAPPER}} a.mg-flip-btn.mgcla-btn',
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_4,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgflip_btn_border',
                'selector' => '{{WRAPPER}} a.mg-flip-btn.mgcla-btn',
            ]
        );

        $this->add_control(
            'mgflip_btn_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} a.mg-flip-btn.mgcla-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgflip_btn_box_shadow',
                'selector' => '{{WRAPPER}} a.mg-flip-btn.mgcla-btn',
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
                    '{{WRAPPER}} a.mg-flip-btn.mgcla-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgflip_btn_bg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.mg-flip-btn.mgcla-btn' => 'background-color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} a.mg-flip-btn.mgcla-btn:hover',
            ]
        );

        $this->add_control(
            'mgflip_btn_hcolor',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.mg-flip-btn.mgcla-btn:hover, {{WRAPPER}} a.mg-flip-btn.mgcla-btn:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgflip_btn_hbg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.mg-flip-btn.mgcla-btn:hover, {{WRAPPER}} a.mg-flip-btn.mgcla-btn:focus' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} a.mg-flip-btn.mgcla-btn:hover, {{WRAPPER}} a.mg-flip-btn.mgcla-btn:focus' => 'border-color: {{VALUE}};',
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
                    'mg_flip_btn2_use' => 'yes',
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
                    '{{WRAPPER}} .mgcla-btn2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgflip_btn2_typography',
                'selector' => '{{WRAPPER}} .mgcla-btn2',
                'scheme' => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_4,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgflip_btn2_border',
                'selector' => '{{WRAPPER}} .mgcla-btn2',
            ]
        );

        $this->add_control(
            'mgflip_btn2_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgcla-btn2' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgflip_btn2_box_shadow',
                'selector' => '{{WRAPPER}} .mgcla-btn2',
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
                    '{{WRAPPER}} .mgcla-btn2' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgflip_btn2_bg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgcla-btn2' => 'background-color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .mgcla-btn2:hover',
            ]
        );

        $this->add_control(
            'mgflip_btn2_hcolor',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgcla-btn2:hover, {{WRAPPER}} .mgcla-btn2:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgflip_btn2_hbg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgcla-btn2:hover, {{WRAPPER}} .mgcla-btn2:focus' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .mgcla-btn2:hover, {{WRAPPER}} .mgcla-btn2:focus' => 'border-color: {{VALUE}};',
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
        $mg_cta_styles = $settings['mg_cta_styles'];
        if ($mg_cta_styles == 'style1') {
            $this->mgcta_style_base_one($settings);
        } else {
            $this->mgcta_style_base_two($settings);
        }
    }


    public function mgcta_style_base_one($settings)
    {


        //Banner title
        $mg_cta_title = $this->get_settings('mg_cta_title');
        $mg_banner_title_show = $this->get_settings('mg_banner_title_show');
        $mg_cta_highlight = $this->get_settings('mg_cta_highlight');
        $mg_cta_title_tag = $this->get_settings('mg_cta_title_tag');
        $this->add_render_attribute('mg_cta_title', 'class', 'mg-cta-title');

        //Banner subtitle
        $mg_cta_subtitle = $this->get_settings('mg_cta_subtitle');
        $mg_banner_subtitle_show = $this->get_settings('mg_banner_subtitle_show');
        $mg_cta_subtitle_tag = $this->get_settings('mg_cta_subtitle_tag');
        $this->add_render_attribute('mg_cta_subtitle', 'class', 'mg-cta-subtitle');


        //Banner description
        $mg_cta_desc = $this->get_settings('mg_cta_desc');
        $mg_banner_des_show = $this->get_settings('mg_banner_des_show');
        $this->add_inline_editing_attributes('mg_cta_desc');

        // Btn item    
        $mg_flip_btn_use = $settings['mg_flip_btn_use'];
        $mg_flip_btn2_use = $settings['mg_flip_btn2_use'];
        $mgcta_btn_align = $settings['mgcta_btn_align'];


?>

        <div class="mg-cta style-one mg-banner mg-banner-one mgcta-<?php echo esc_attr($mgcta_btn_align); ?>">
            <div class="mg-cta-content">

                <div class="mg-banner-sub">
                    <?php
                    if ($mg_cta_title && $mg_banner_title_show) :
                        printf(
                            '<%1$s %2$s>%3$s %4$s</%1$s>',
                            tag_escape($mg_cta_title_tag),
                            $this->get_render_attribute_string('mg_cta_title'),
                            mg_kses_tags($mg_cta_title),
                            '<span>' . wp_kses_post($mg_cta_highlight) . '</span>'
                        );
                    endif;
                    ?>

                    <?php
                    if ($mg_cta_subtitle && $mg_banner_subtitle_show) :
                        printf(
                            '<%1$s %2$s>%3$s',
                            tag_escape($mg_cta_subtitle_tag),
                            $this->get_render_attribute_string('mg_cta_subtitle'),
                            mg_kses_tags($mg_cta_subtitle)
                        );
                    endif;
                    ?>
                </div>

                <?php if ($mg_cta_desc && $mg_banner_des_show) : ?>
                    <p <?php echo $this->get_render_attribute_string('mg_cta_desc'); ?>><?php echo wp_kses_post($mg_cta_desc); ?></p>
                <?php endif; ?>

            </div>

            <?php if (($mg_flip_btn_use && $mg_flip_btn_use) || ($mg_flip_btn2_use && $mg_flip_btn2_use)) : ?>

                <div class="mg-cta-btn">
                    <?php
                    if ($mg_flip_btn_use && $mg_flip_btn_use) {
                        $this->mgf_button($settings, 1);
                    }
                    if ($mg_flip_btn2_use && $mg_flip_btn2_use) {
                        $this->mgf_button($settings, 2);
                    }
                    ?>
                </div>
            <?php endif; ?>


        </div>



    <?php
    }


    public function mgcta_style_base_two($settings)
    {


        //Banner title
        $mg_cta_title = $this->get_settings('mg_cta_title');
        $mg_banner_title_show = $this->get_settings('mg_banner_title_show');
        $mg_cta_highlight = $this->get_settings('mg_cta_highlight');
        $mg_cta_title_tag = $this->get_settings('mg_cta_title_tag');
        $this->add_render_attribute('mg_cta_title', 'class', 'mg-cta-title');


        //Banner subtitle
        $mg_cta_subtitle = $this->get_settings('mg_cta_subtitle');
        $mg_banner_subtitle_show = $this->get_settings('mg_banner_subtitle_show');
        $mg_cta_subtitle_tag = $this->get_settings('mg_cta_subtitle_tag');
        $this->add_render_attribute('mg_cta_subtitle', 'class', 'mg-cta-subtitle');


        //Banner description
        $mg_cta_desc = $this->get_settings('mg_cta_desc');
        $mg_banner_des_show = $this->get_settings('mg_banner_des_show');
        $this->add_inline_editing_attributes('mg_cta_desc');

        // Btn item    
        $mg_flip_btn_use = $settings['mg_flip_btn_use'];
        $mg_flip_btn2_use = $settings['mg_flip_btn2_use'];


    ?>

        <div class="mg-cta style-two mg-banner mg-banner-two">
            <div class="mg-cta-content">

                <div class="mg-banner-sub">
                    <?php
                    if ($mg_cta_title && $mg_banner_title_show) :
                        printf(
                            '<%1$s %2$s>%3$s %4$s</%1$s>',
                            tag_escape($mg_cta_title_tag),
                            $this->get_render_attribute_string('mg_cta_title'),
                            mg_kses_tags($mg_cta_title),
                            '<span>' . wp_kses_post($mg_cta_highlight) . '</span>'
                        );
                    endif;
                    ?>

                    <?php
                    if ($mg_cta_subtitle && $mg_banner_subtitle_show) :
                        printf(
                            '<%1$s %2$s>%3$s',
                            tag_escape($mg_cta_subtitle_tag),
                            $this->get_render_attribute_string('mg_cta_subtitle'),
                            mg_kses_tags($mg_cta_subtitle)
                        );
                    endif;
                    ?>
                </div>

                <?php if ($mg_cta_desc && $mg_banner_des_show) : ?>
                    <p <?php echo $this->get_render_attribute_string('mg_cta_desc'); ?>><?php echo wp_kses_post($mg_cta_desc); ?></p>
                <?php endif; ?>
                <?php if (($mg_flip_btn_use && $mg_flip_btn_use) || ($mg_flip_btn2_use && $mg_flip_btn2_use)) : ?>
                    <div class="mg-cta-btn">
                        <?php
                        if ($mg_flip_btn_use && $mg_flip_btn_use) {
                            $this->mgf_button($settings, 1);
                        }
                        if ($mg_flip_btn2_use && $mg_flip_btn2_use) {
                            $this->mgf_button($settings, 2);
                        }
                        ?>
                    </div>
                <?php endif; ?>

            </div>

            <div class="mg-cta-img">
                <figure>

                    <?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'mgcla_img'); ?>

                </figure>
            </div>




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
            $mg_flip_usebtn_icon = $settings['mg_flip_usebtn_icon'];
            $mg_flip_usebtn2_icon = '';
            $mg_flip_btn_title = $settings['mg_flip_btn_title'];
            $mg_flip_btn_link = $settings['mg_flip_btn_link'];
            $mg_flip_btn_selected_icon = $settings['mg_flip_btn_selected_icon'];
            $this->add_inline_editing_attributes('mg_flip_btn_title', 'none');
            $this->add_render_attribute('mg_flip_btn_title', 'class', 'mg-flip-btn');

            $this->add_render_attribute('mg_flip_btn_title', 'class', 'mgcla-btn');
            $this->add_render_attribute('mg_flip_btn_title', 'href', esc_url($mg_flip_btn_link['url']));
            if (!empty($mg_flip_btn_link['is_external'])) {
                $this->add_render_attribute('mg_flip_btn_title', 'target', '_blank');
            }
            if (!empty($mg_flip_btn_link['nofollow'])) {
                $this->set_render_attribute('mg_flip_btn_title', 'rel', 'nofollow');
            }
            $btn_attr =  $this->get_render_attribute_string('mg_flip_btn_title');
        } else {
            $mg_flipbtn_icon_position = $settings['mg_flipbtn2_icon_position'];
            $mg_flip_usebtn2_icon = $settings['mg_flip_usebtn2_icon'];
            $mg_flip_usebtn_icon = '';
            $mg_flip_btn_title = $settings['mg_flip_btn2_title'];
            $mg_flip_btn_link = $settings['mg_flip_btn2_link'];

            $mg_flipbtn2_link_type = $settings['mg_flipbtn2_link_type'];
            if ($mg_flipbtn2_link_type == 'video') {
                $mg_flip_btn_link = $settings['mg_flip_btn2_video_link'];
            } else {
                $mg_flip_btn_link = $settings['mg_flip_btn2_link'];
            }

            $mg_flip_btn_selected_icon = $settings['mg_flip_btn2_selected_icon'];

            $this->add_inline_editing_attributes('mg_flip_btn2_title', 'none');

            $this->add_render_attribute('mg_flip_btn2_title', 'class', 'mgcla-btn2');
            $this->add_render_attribute('mg_flip_btn2_title', 'href', esc_url($mg_flip_btn_link['url']));
            if (!empty($mg_flip_btn_link['is_external'])) {
                $this->add_render_attribute('mg_flip_btn2_title', 'target', '_blank');
            }
            if (!empty($mg_flip_btn_link['nofollow'])) {
                $this->set_render_attribute('mg_flip_btn2_title', 'rel', 'nofollow');
            }

            if ($mg_flipbtn2_link_type == 'video') {
                $this->add_render_attribute('mg_flip_btn2_title', 'class', 'mgcla-btn2-veno');
                $this->add_render_attribute('mg_flip_btn2_title', 'data-autoplay', 'true');
                $this->add_render_attribute('mg_flip_btn2_title', 'data-vbtype', 'video');
            }

            $btn_attr =  $this->get_render_attribute_string('mg_flip_btn2_title');
        }




        if (($mg_flip_usebtn_icon == 'yes' && $btn == 1) || ($mg_flip_usebtn2_icon == 'yes' && $btn == 2)) :
        ?>
            <a <?php echo $btn_attr; ?>>
                <?php if ($mg_flipbtn_icon_position == 'left') : ?>
                    <span class="left"><?php \Elementor\Icons_Manager::render_icon($mg_flip_btn_selected_icon); ?></span>

                <?php endif; ?>
                <span><?php echo mg_kses_tags($mg_flip_btn_title); ?></span>
                <?php if ($mg_flipbtn_icon_position == 'right') : ?>
                    <span class="right"><?php \Elementor\Icons_Manager::render_icon($mg_flip_btn_selected_icon); ?></span>
                <?php endif; ?>
            </a>
        <?php else : ?>
            <a <?php echo $btn_attr; ?>><?php echo  mg_kses_tags($mg_flip_btn_title); ?></a>
        <?php endif; ?>
<?php

    }
}
