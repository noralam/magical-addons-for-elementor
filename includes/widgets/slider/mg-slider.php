<?php

/**
 * Slider widget class
 *
 * @package Magical addons
 */

defined('ABSPATH') || die();

use Elementor\Group_Control_Background;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Scheme_Typography;
use Elementor\Utils;

class MgAddon_slider_lite extends \Elementor\Widget_Base
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
        return 'mgslider_lite_widget';
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
        return __('MG Slider', 'magical-addons-for-elementor');
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
        return 'eicon-slider-album';
    }

    public function get_keywords()
    {
        return ['slider', 'image', 'gallery', 'carousel', 'mg'];
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

    public function get_script_depends()
    {
        return [
            'mg-swiper',
        ];
    }
    public function get_style_depends()
    {
        return [
            'mg-swiper',
        ];
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
            'mg_slider_section',
            [
                'label' => __('Slides', 'magical-addons-for-elementor'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $repeater = new Repeater();

        $repeater->add_control(
            'mgs_image',
            [
                'type' => Controls_Manager::MEDIA,
                'label' => __('Image', 'magical-addons-for-elementor'),
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $repeater->add_control(
            'mgs_title',
            [
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'label' => __('Title', 'magical-addons-for-elementor'),
                'placeholder' => __('Type title here', 'magical-addons-for-elementor'),
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );

        $repeater->add_control(
            'mgs_subtitle',
            [
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'show_label' => false,
                'label' => __('Subtitle', 'magical-addons-for-elementor'),
                'placeholder' => __('Type subtitle here', 'magical-addons-for-elementor'),
                'dynamic' => [
                    'active' => true,
                ]
            ]
        );
        $repeater->add_control(
            'mgs_btn_use',
            [
                'label' => __('Use Button?', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
                'separator' => 'before',
            ]
        );
        $repeater->add_control(
            'mgs_btn_title',
            [
                'label'       => __('Button Title', 'magical-addons-for-elementor'),
                'type'        => Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => __('Button Text', 'magical-addons-for-elementor'),
                'default'     => __('Read More', 'magical-addons-for-elementor'),
                'condition' => [
                    'mgs_btn_use!' => '',
                ],
            ]
        );
        $repeater->add_control(
            'mgs_btn_link',
            [
                'label' => __('Button Link', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'magical-addons-for-elementor'),
                'default' => [
                    'url' => '#',
                ],
                'condition' => [
                    'mgs_btn_use!' => '',
                ],
            ]
        );

        $this->add_control(
            'mgs_slides',
            [
                'show_label' => false,
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '<# print(mgs_title || "Slider Item"); #>',
                'default' => [
                    [
                        'mgs_image' => [
                            'url' => Utils::get_placeholder_image_src(),

                        ],
                        'mgs_title' => __('Slide Title One', 'magical-addons-for-elementor'),
                        'mgs_subtitle' => __('Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio', 'magical-addons-for-elementor'),
                        'mgs_btn_title' => __('Read More', 'magical-addons-for-elementor'),
                        'mgs_btn_link' => '#',
                    ],
                    [
                        'mgs_image' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],

                        'mgs_title' => __('Slide Title Two', 'magical-addons-for-elementor'),
                        'mgs_subtitle' => __('Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio', 'magical-addons-for-elementor'),
                        'mgs_btn_title' => __('Read More', 'magical-addons-for-elementor'),
                        'mgs_btn_link' => '#',
                    ],
                    [
                        'mgs_image' => [
                            'url' => Utils::get_placeholder_image_src(),
                        ],
                        'mgs_title' => __('Slide Title Three', 'magical-addons-for-elementor'),
                        'mgs_subtitle' => __('Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio', 'magical-addons-for-elementor'),
                        'mgs_btn_title' => __('Read More', 'magical-addons-for-elementor'),
                        'mgs_btn_link' => '#',
                    ],

                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'default' => 'large',
                'separator' => 'before',
                'exclude' => [
                    'custom'
                ]
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'mgs_navdots_section',
            [
                'label' => __('Nav & Dots', 'magical-addons-for-elementor'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mgs_dots',
            [
                'label' => __('Slider Dots?', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );
        $this->add_control(
            'mgs_navigation',
            [
                'label' => __('Slider Navigation?', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mgs_nav_prev_icon',
            [
                'label' => __('Choose Prev Icon', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-angle-left',
                    'library' => 'fa-solid',
                ],
                'recommended' => [
                    'fa-solid' => [
                        'arrow-alt-circle-left',
                        'arrow-circle-left',
                        'arrow-left',
                        'long-arrow-alt-left',
                        'angle-left',
                        'chevron-circle-left',
                        'fa-chevron-left',
                        'angle-double-left',
                    ],
                    'fa-regular' => [
                        'hand-point-left',
                        'arrow-alt-circle-left',
                        'caret-square-left',
                    ],
                ],
                'condition' => [
                    'mgs_navigation' => 'yes',
                ],

            ]
        );
        $this->add_control(
            'mgs_nav_next_icon',
            [
                'label' => __('Choose Next Icon', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-angle-right',
                    'library' => 'fa-solid',
                ],
                'recommended' => [
                    'fa-solid' => [
                        'arrow-alt-circle-right',
                        'arrow-circle-right',
                        'arrow-right',
                        'long-arrow-alt-right',
                        'angle-right',
                        'chevron-circle-right',
                        'fa-chevron-right',
                        'angle-double-right',
                    ],
                    'fa-regular' => [
                        'hand-point-right',
                        'arrow-alt-circle-right',
                        'caret-square-right',
                    ],
                ],
                'condition' => [
                    'mgs_navigation' => 'yes',
                ],

            ]
        );


        $this->end_controls_section();
        $this->start_controls_section(
            'mgs_settings_section',
            [
                'label' => __('Settings', 'magical-addons-for-elementor'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mgs_slide_effect',
            [
                'label' => __('Slide Effect', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'fade' => __('fade', 'magical-addons-for-elementor'),
                    'slide' => __('Slide', 'magical-addons-for-elementor'),
                ],
                'default' => 'fade',
                'frontend_available' => true,
                'style_transfer' => true,
            ]
        );
        $this->add_control(
            'mgs_slide_direction',
            [
                'label' => __('Slide Direction', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'horizontal' => __('Horizontal', 'magical-addons-for-elementor'),
                    'vertical' => __('Vertical', 'magical-addons-for-elementor'),
                ],
                'default' => 'horizontal',
                'frontend_available' => true,
                'style_transfer' => true,
            ]
        );

        $this->add_control(
            'mgs_animation_speed',
            [
                'label' => __('Animation Speed', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'min' => 100,
                'step' => 1,
                'max' => 10000,
                'default' => 1000,
                'description' => __('Slide speed in milliseconds', 'magical-addons-for-elementor'),
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'mgs_autoplay',
            [
                'label' => __('Autoplay?', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );
        $this->add_control(
            'mgs_autoplay_delay',
            [
                'label' => __('Autoplay Delay', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'min' => 100,
                'step' => 1,
                'max' => 50000,
                'default' => 2500,
                'description' => __('Autoplay Delay in milliseconds', 'magical-addons-for-elementor'),
                'frontend_available' => true,
                'condition' => [
                    'mgs_autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mgs_autoplay_speed',
            [
                'label' => __('Autoplay Speed', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::NUMBER,
                'min' => 100,
                'step' => 100,
                'max' => 10000,
                'default' => 3000,
                'description' => __('Autoplay speed in milliseconds', 'magical-addons-for-elementor'),
                'condition' => [
                    'autoplay' => 'yes'
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'mgs_loop',
            [
                'label' => __('Infinite Loop?', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );
        $this->add_control(
            'mgs_grab_cursor',
            [
                'label' => __('Grab Cursor?', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',
                'frontend_available' => true,
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
            'mgs_style_section',
            [
                'label' => __('Slider Item', 'magical-addons-for-elementor'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'mgs_slide_height_auto',
            [
                'label' => __('Slider Auto Height?', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'default' => '',
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'mgs_slide_height',
            [
                'label' => __('Slider Height', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1200,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 500,
                ],
                'condition' => [
                    'mgs_slide_height_auto' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgs-main .mgs-item img, {{WRAPPER}} .swiper-container-vertical' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'mgs_img_background',
                'description' => __('Only show the background for transparent image', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .mgs-main .mgs-item',
                'exclude' => [
                    'image'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'mgs_item_border',
                'selector' => '{{WRAPPER}} .mgs-main .mgs-item',
            ]
        );

        $this->add_responsive_control(
            'mgs_item_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgs-main .mgs-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'mgs_style_content',
            [
                'label' => __('Slide Content', 'magical-addons-for-elementor'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgs_content_padding',
            [
                'label' => __('Content Padding', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgs-main .mgs-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'mgs_content_background',
                'selector' => '{{WRAPPER}} .mgs-main .mgs-content',
                'exclude' => [
                    'image'
                ]
            ]
        );
        $this->add_responsive_control(
            'mgs_content_radius',
            [
                'label' => __('Content Border Radius', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgs-main .mgs-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->add_control(
            'mgs_heading_title',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __('Title', 'magical-addons-for-elementor'),
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'mgs_title_spacing',
            [
                'label' => __('Bottom Spacing', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .mgs-content .mgs-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mgs_title_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgs-content .mgs-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'mgs_title_typo',
                'selector' => '{{WRAPPER}} .mgs-content .mgs-title',
            ]
        );
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'mgs_title_shadow',
                'label' => __('Title Text Shadow', 'plugin-domain'),
                'selector' => '{{WRAPPER}} .mgs-content .mgs-title',
            ]
        );

        $this->add_control(
            'mgs_heading_subtitle',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __('Subtitle', 'magical-addons-for-elementor'),
                'separator' => 'before'
            ]
        );

        $this->add_responsive_control(
            'mgs_subtitle_spacing',
            [
                'label' => __('Bottom Spacing', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .mgs-content .mgs-subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mgs_subtitle_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgs-content .mgs-subtitle' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'mgs_subtitle',
                'selector' => '{{WRAPPER}} .mgs-content .mgs-subtitle',
            ]
        );
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'mgs_subtitle_shadow',
                'label' => __('Title Text Shadow', 'plugin-domain'),
                'selector' => '{{WRAPPER}} .mgs-content .mgs-subtitle',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'mgs_btn_style',
            [
                'label' => __('Slider Button', 'magical-addons-for-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgs_btn_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} a.btn.mgs-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgs_btn_typography',
                'selector' => '{{WRAPPER}} a.btn.mgs-btn',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgs_btn_border',
                'selector' => '{{WRAPPER}} a.btn.mgs-btn',
            ]
        );

        $this->add_control(
            'mgs_btn_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} a.btn.mgs-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgs_btn_box_shadow',
                'selector' => '{{WRAPPER}} a.btn.mgs-btn',
            ]
        );
        $this->add_control(
            'mgs_btn_color',
            [
                'label' => __('Button color', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('mgs_btn_tabs');

        $this->start_controls_tab(
            'mgs_btn_normal_style',
            [
                'label' => __('Normal', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'mgs_text_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} a.btn.mgs-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgs_btn_bg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.btn.mgs-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'mgs_btn_hover_style',
            [
                'label' => __('Hover', 'magical-addons-for-elementor'),
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgs_btn_hover_boxshadow',
                'selector' => '{{WRAPPER}} a.btn.mgs-btn:hover',
            ]
        );

        $this->add_control(
            'mgs_btn_hcolor',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.btn.mgs-btn:hover, {{WRAPPER}} a.btn.mgs-btn:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgs_btn_hbg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a.btn.mgs-btn:hover, {{WRAPPER}} a.btn.mgs-btn:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgs_btn_hborder_color',
            [
                'label' => __('Border Color', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'mgs_btn_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} a.btn.mgs-btn:hover, {{WRAPPER}} a.btn.mgs-btn:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'mgs_section_style_arrow',
            [
                'label' => __('Navigation - Arrow', 'magical-addons-for-elementor'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'mgs_arrow_position_toggle',
            [
                'label' => __('Position', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::POPOVER_TOGGLE,
                'label_off' => __('None', 'magical-addons-for-elementor'),
                'label_on' => __('Custom', 'magical-addons-for-elementor'),
                'return_value' => 'yes',
            ]
        );

        $this->start_popover();

        $this->add_responsive_control(
            'mgs_arrow_positiony',
            [
                'label' => __('Vertical', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                // 'condition' => [
                //     'arrow_position_toggle' => 'yes'
                // ],
                'range' => [
                    'px' => [
                        'min' => -50,
                        'max' => 500,
                    ],

                ],

                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next,{{WRAPPER}} .swiper-button-prev' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgs_arrow_position_x',
            [
                'label' => __('Horizontal', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                // 'condition' => [
                //     'arrow_position_toggle' => 'yes'
                // ],
                'range' => [
                    'px' => [
                        'min' => -10,
                        'max' => 250,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-prev, {{WRAPPER}} .swiper-container-rtl .swiper-button-next' => 'left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .swiper-button-next,{{WRAPPER}} .swiper-container-rtl .swiper-button-prev' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_popover();
        $this->add_responsive_control(
            'mgs_arrow_border',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};width:inherit;height:inherit',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'mgs_arrow_border',
                'selector' => '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev',
            ]
        );

        $this->add_responsive_control(
            'mgs_arrow_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
                ],
            ]
        );

        $this->start_controls_tabs('mgs_tabs_arrow');

        $this->start_controls_tab(
            'mgs_tab_arrow_normal',
            [
                'label' => __('Normal', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'mgs_arrow_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next i, {{WRAPPER}} .swiper-button-prev i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgs_arrow_bg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'mgs_tab_arrow_hover',
            [
                'label' => __('Hover', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'mgs_arrow_hover_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-prev:hover, {{WRAPPER}} .slick-next:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgs_arrow_hover_bg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-prev:hover, {{WRAPPER}} .slick-next:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgs_arrow_hover_border_color',
            [
                'label' => __('Border Color', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'arrow_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .slick-prev:hover, {{WRAPPER}} .slick-next:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'mgs_section_style_dots',
            [
                'label' => __('Navigation - Dots', 'magical-addons-for-elementor'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgs_dots_position_y',
            [
                'label' => __('Vertical Position', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => -10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-horizontal>.swiper-pagination-bullets, {{WRAPPER}} .swiper-pagination-custom, {{WRAPPER}} .swiper-pagination-fraction' => 'bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .swiper-container-vertical>.swiper-pagination-bullets' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgs_dots_spacing',
            [
                'label' => __('Spacing', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-horizontal>.swiper-pagination-bullets .swiper-pagination-bullet' => 'margin-right: calc({{SIZE}}{{UNIT}} / 2); margin-left: calc({{SIZE}}{{UNIT}} / 2);',
                    '{{WRAPPER}} .swiper-container-vertical>.swiper-pagination-bullets .swiper-pagination-bullet' => 'margin-top: calc({{SIZE}}{{UNIT}} / 2); margin-bottom: calc({{SIZE}}{{UNIT}} / 2);',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgs_dots_nav_align',
            [
                'label' => __('Alignment', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
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
                    'mgs_slide_direction' => 'horizontal',
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .swiper-container-horizontal>.swiper-pagination-bullets, .swiper-pagination-custom, {{WRAPPER}} .swiper-pagination-fraction' => 'text-align: {{VALUE}}'
                ]
            ]
        );
        $this->add_control(
            'mgs_dots_width',
            [
                'label' => __('Dots Width', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 50,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgs_dots_height',
            [
                'label' => __('Dots Height', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 50,
                        'step' => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgs_dots_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->start_controls_tabs('mgs_tabs_dots');
        $this->start_controls_tab(
            'mgs_tab_dots_normal',
            [
                'label' => __('Normal', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'mgs_dots_nav_color',
            [
                'label' => __('Color', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'mgs_tab_dots_hover',
            [
                'label' => __('Hover', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'mgs_dots_nav_hover_color',
            [
                'label' => __('Color', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'mgs_tab_dots_active',
            [
                'label' => __('Active', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'mgs_dots_nav_active_color',
            [
                'label' => __('Color', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} span.swiper-pagination-bullet.swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
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
        $mgs_slides = $this->get_settings('mgs_slides');
        $mgs_autoplay = $settings['mgs_autoplay'] ? 'true' : 'false';
        $mgs_loop = $settings['mgs_loop'] ? 'true' : 'false';
        $mgs_grab_cursor = $settings['mgs_grab_cursor'] ? 'true' : 'false';
        $mgs_dots = $settings['mgs_dots'] ? 'true' : 'false';
        $mgs_navigation = $settings['mgs_navigation'] ? 'true' : 'false';
?>

        <div class="mgs-main swiper-container" data-loop="<?php echo esc_attr($mgs_loop); ?>" data-effect="<?php echo esc_attr($settings['mgs_slide_effect']); ?>" data-direction="<?php echo esc_attr($settings['mgs_slide_direction']); ?>" data-speed="<?php echo esc_attr($settings['mgs_animation_speed']); ?>" data-autoplay="<?php echo esc_attr($mgs_autoplay); ?>" data-auto-delay="<?php echo esc_attr($settings['mgs_autoplay_delay']); ?>" data-grab-cursor="<?php echo esc_attr($mgs_grab_cursor); ?>" data-nav="<?php echo esc_attr($mgs_navigation); ?>" data-dots="<?php echo esc_attr($mgs_dots); ?>">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">

                <?php
                foreach ($mgs_slides as $index => $slide) :
                    $key1 = $this->get_repeater_setting_key('mgs_btn_link', 'mgs_slides', $index);

                    $this->add_render_attribute($key1, 'href', esc_url($slide['mgs_btn_link']['url']));
                    $this->add_render_attribute($key1, 'class', 'btn btn-info mgs-btn');
                    if (!empty($slide['mgs_btn_link']['is_external'])) {
                        $this->add_render_attribute($key1, 'target', '_blank');
                    }
                    if (!empty($slide['mgs_btn_link']['nofollow'])) {
                        $this->set_render_attribute($key1, 'rel', 'nofollow');
                    }

                    $mgs_image = wp_get_attachment_image_url($slide['mgs_image']['id'], $settings['thumbnail_size']);
                    if (!$mgs_image) {
                        $mgs_image = $slide['mgs_image']['url'];
                    }
                ?>

                    <!-- Slides -->
                    <div class="swiper-slide mgs-item">
                        <?php if ($mgs_image) : ?>
                            <div class="mgs-img-before">
                                <img class="mgs-img" src="<?php echo esc_url($mgs_image); ?>" alt="<?php echo esc_attr($slide['mgs_title']); ?>">
                            </div>
                        <?php endif; ?>
                        <?php if ($slide['mgs_title'] || $slide['mgs_subtitle']) : ?>
                            <div class="mgs-content mgst-center mgs-overlay">
                                <?php if ($slide['mgs_title']) : ?>
                                    <h2 class="mgs-title" data-swiper-parallax-scale="0.15"><?php echo mg_kses_tags($slide['mgs_title']); ?></h2>
                                <?php endif; ?>
                                <?php if ($slide['mgs_subtitle']) : ?>
                                    <p class="mgs-subtitle" data-swiper-parallax-opacity="0.5"><?php echo mg_kses_tags($slide['mgs_subtitle']); ?></p>
                                <?php endif; ?>
                                <?php if ($slide['mgs_btn_use']) : ?>
                                    <a <?php echo $this->get_render_attribute_string($key1); ?>><?php echo esc_html($slide['mgs_btn_title']); ?></a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                    </div>


                <?php
                endforeach;  ?>
            </div>
            <?php if ($settings['mgs_dots']) : ?>
                <div class="swiper-pagination"></div>
            <?php endif; ?>

            <?php if ($settings['mgs_navigation']) : ?>
                <div class="swiper-button-prev">
                    <?php \Elementor\Icons_Manager::render_icon($settings['mgs_nav_prev_icon']); ?>
                </div>
                <div class="swiper-button-next">
                    <?php \Elementor\Icons_Manager::render_icon($settings['mgs_nav_next_icon']); ?>
                </div>
            <?php endif; ?>

            <!-- If we need scrollbar 
    <div class="swiper-scrollbar"></div>
    -->
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

    //	protected function content_template() {}





}
