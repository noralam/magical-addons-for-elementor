<?php

use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Repeater;

require_once(MAGICAL_ADDON_PATH . '/includes/widgets/nav-menu/nav-walker.php');


if (!defined('ABSPATH')) exit; // Exit if accessed directly

class MG_Addon_navMenu extends \Elementor\Widget_Base
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
        return 'mgnav_menu_widget';
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
        return __('MG Nav Menu', 'magical-addons-for-elementor');
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
        return 'eicon-nav-menu';
    }

    public function get_keywords()
    {
        return ['menu', 'nav', 'nav menu', 'navigation', 'mg'];
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
        return ['mg-nav-menu'];
    }

    public function get_style_depends()
    {
        return ['mg-nav-menu', 'elementor-icons-fa-solid'];
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Nav Menu', 'magical-addons-for-elementor'),
            ]
        );
        $this->add_control(
            'menu_source',
            [
                'label' => esc_html__('Menu Source', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'wpnav',
                'options' => [
                    'wpnav'  => esc_html__('WordPress Menu', 'magical-addons-for-elementor'),
                    'custom'  => esc_html__('Custom Create', 'magical-addons-for-elementor'),
                ],
            ]
        );

        if (!empty(mg_addons_get_available_menus())) {
            $this->add_control(
                'inline_menu_slug',
                [
                    'label'   => esc_html__('Menu', 'magical-addons-for-elementor'),
                    'type'    => Controls_Manager::SELECT,
                    'options' => mg_addons_get_available_menus(),
                    'default' => array_keys(mg_addons_get_available_menus())[0],
                    'save_default' => true,
                    'separator' => 'after',
                    'description' => sprintf(__('Go to the <a href="%s" target="_blank">Menus Option</a> to manage your menus.', 'magical-addons-for-elementor'), admin_url('nav-menus.php')),
                    'condition' => [
                        'menu_source' => 'wpnav',
                    ],
                ]
            );
        } else {
            $this->add_control(
                'inline_menu_notice',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => sprintf(__('<strong>There are no menus in your site.</strong><br>Go to the <a href="%s" target="_blank">Menus Option</a> to create one.', 'magical-addons-for-elementor'), admin_url('nav-menus.php?action=edit&menu=0')),
                    'separator' => 'after',
                    'condition' => [
                        'menu_source' => 'wpnav',
                    ],
                ]
            );
        }
        $repeater = new Repeater();
        $repeater->add_control(
            'menu_text',
            array(
                'label'       => __('Link Text', 'magical-addons-for-elementor'),
                'label_block' => true,
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => array(
                    'active' => true,
                ),
                'default'     => __('Menu Item', 'magical-addons-for-elementor'),
            )
        );
        $repeater->add_control(
            'menu_url',
            [
                'label' => __('Link', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'magical-addons-for-elementor'),
                'default' => [
                    'url' => '#',
                ],
                'separator' => 'before',

            ]
        );
        $this->add_control(
            'menu_items',
            array(
                'label'       => '',
                'type'        => Controls_Manager::REPEATER,
                'default'     => array(
                    array(
                        'menu_text' => __('Menu Text 1', 'magical-addons-for-elementor'),
                        'menu_url' => '#',
                    ),
                    array(
                        'menu_text' => __('Menu Text 1', 'magical-addons-for-elementor'),
                        'menu_url' => '#',
                    ),
                ),
                'fields'      => $repeater->get_controls(),
                'title_field' => '{{{ menu_text }}}',
                'condition' => [
                    'menu_source' => 'custom',
                ],
            )
        );

        $this->add_control(
            'menu_style',
            [
                'label' => esc_html__('Style', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SELECT,
                'default' => 'one',
                'options' => [
                    'one'  => esc_html__('Style One', 'magical-addons-for-elementor'),
                    'two'  => esc_html__('Style Two', 'magical-addons-for-elementor'),
                ],
            ]
        );


        $this->add_responsive_control(
            'area_alignment',
            [
                'label'   => esc_html__('Alignment', 'magical-addons-for-elementor'),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start'    => [
                        'title' => esc_html__('Left', 'magical-addons-for-elementor'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'magical-addons-for-elementor'),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'magical-addons-for-elementor'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'center' => 'one',
                'selectors' => [
                    '{{WRAPPER}} .mgnav-menu > .mgnav-menu-list'   => 'justify-content: {{VALUE}};',
                ],
                'prefix_class' => 'mgmnav-menu-align-%s',
            ]
        );


        $this->end_controls_section();

        // Additional Option
        $this->start_controls_section(
            'additional_option_section',
            [
                'label' => esc_html__('Addintional Options', 'magical-addons-for-elementor'),
            ]
        );
        $this->add_control(
            'fixed_menu',
            [
                'label' => __('Fixed On Scroll?', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'default' => '',
            ]
        );
        $this->add_control(
            'menu_topline',
            [
                'label'   => esc_html__('Top Line', 'magical-addons-for-elementor'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'hide-topline',
                'options' => [
                    'mgnav--topline'   => esc_html__('Show', 'magical-addons-for-elementor'),
                    'mgnav--topline-hvr'  => esc_html__('Show On Hover', 'magical-addons-for-elementor'),
                    'hide-topline'    => esc_html__('Hide', 'magical-addons-for-elementor'),
                ],

            ]
        );
        $this->add_control(
            'menu_bottomline',
            [
                'label'   => esc_html__('Bottom Line', 'magical-addons-for-elementor'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'hide-bottomline',
                'options' => [
                    'mgnav--bottomline'   => esc_html__('Show', 'magical-addons-for-elementor'),
                    'mgnav--bottomline-hvr'  => esc_html__('Show On Hover', 'magical-addons-for-elementor'),
                    'hide-bottomline'    => esc_html__('Hide', 'magical-addons-for-elementor'),
                ],

            ]
        );


        $this->end_controls_section();

        // Additional Option
        $this->start_controls_section(
            'mobilemenu_section',
            [
                'label' => esc_html__('Mobile menu', 'magical-addons-for-elementor'),
            ]
        );
        $this->add_control(
            'mobile_menu_show',
            [
                'label' => __('Active Mobile Menu?', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'return_value' => 'yes',
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'mobile_menu',
            [
                'label' => esc_html__('Mobile Menu Text', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Menu', 'magical-addons-for-elementor'),
                'label_block' => true,
                'condition' => [
                    'mobile_menu_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mobile_menu_toggler_icon',
            [
                'label' => esc_html__('Mobile Menu Toggler Icon', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'mobile_menu_togglericon',
                'default' => [
                    'value' => 'fas fa-bars',
                    'library' => 'solid',
                ],
                'condition' => [
                    'mobile_menu_show' => 'yes',
                ],
            ]
        );
        /*
        $this->add_control(
            'add_custom_menuicon',
            [
                'label' => esc_html__('Custom Menu Icon', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'magical-addons-for-elementor'),
                'label_off' => esc_html__('No', 'magical-addons-for-elementor'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'icon_pos',
            [
                'label'   => esc_html__('Icon Position', 'magical-addons-for-elementor'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left'   => esc_html__('Left', 'magical-addons-for-elementor'),
                    'right'  => esc_html__('Right', 'magical-addons-for-elementor'),
                    'top'    => esc_html__('Top', 'magical-addons-for-elementor'),
                    'bottom' => esc_html__('Bottom', 'magical-addons-for-elementor'),
                ],
                'condition' => [
                    'add_custom_menuicon' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'icon_specing',
            [
                'label' => esc_html__('Icon Spacing', 'magical-addons-for-elementor'),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 150,
                    ],
                ],
                'default' => [
                    'size' => 8,
                ],
                'condition' => [
                    'add_custom_menuicon' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgnav-menu.mgmnav-menu-icon-pos-right > .mgnav-menu-list > li > a span.mgnav-menu-icon'  => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mgnav-menu.mgmnav-menu-icon-pos-left > .mgnav-menu-list > li > a span.mgnav-menu-icon'   => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mgnav-menu.mgmnav-menu-icon-pos-top > .mgnav-menu-list > li > a span.mgnav-menu-icon'   => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mgnav-menu.mgmnav-menu-icon-pos-bottom > .mgnav-menu-list > li > a span.mgnav-menu-icon'   => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'menu_item',
            [
                'label' => esc_html__('Menu items ID', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'custom_menu_icon',
            [
                'label' => esc_html__('Custom Menu Icon', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-shopping-cart',
                    'library' => 'solid',
                ],
                'fa4compatibility' => 'custom_menuicon',
            ]
        );

        $this->add_control(
            'custom_icon_list',
            [
                'type'    => Controls_Manager::REPEATER,
                'fields'  => $repeater->get_controls(),
                'default' => [
                    [
                        'select_menu' => '',
                    ]
                ],
                'title_field' => '{{{ menu_item }}}',
                'condition' => [
                    'add_custom_menuicon' => 'yes',
                ],
            ]
        );
*/
        $this->end_controls_section();
        $this->link_pro_added();

        // Style tab section
        $this->start_controls_section(
            'area_style',
            [
                'label' => esc_html__('Menu Area', 'magical-addons-for-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'area_background',
                'label' => esc_html__('Background', 'magical-addons-for-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .mgnav-menu',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'area_border',
                'label' => esc_html__('Border', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .mgnav-menu',
            ]
        );

        $this->add_control(
            'area_border_radius',
            [
                'label' => esc_html__('Border Radius', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .mgnav-menu' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'area_padding',
            [
                'label' => esc_html__('Padding', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .mgnav-menu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'area_margin',
            [
                'label' => esc_html__('Margin', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .mgnav-menu' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();

        // Menu Item Style tab section
        $this->start_controls_section(
            'menu_item_style_section',
            [
                'label' => esc_html__('Menu Item', 'magical-addons-for-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'menu_item_typography',
                'label' => esc_html__('Typography', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .mgnav-menu > .mgnav-menu-list > li > a',
            ]
        );

        $this->add_responsive_control(
            'menu_item_padding',
            [
                'label' => esc_html__('Padding', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .mgnav-menu > .mgnav-menu-list > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'menu_item_space',
            [
                'label' => esc_html__('Space', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
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
                'selectors' => [
                    '{{WRAPPER}} .mgnav-menu > .mgnav-menu-list > li + li' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Menu Style Normal Tabs Start
        $this->start_controls_tabs('menu_style_tabs');

        // Menu Style Normal Tab Start
        $this->start_controls_tab(
            'menu_style_normal_tab',
            [
                'label' => esc_html__('Normal', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'menu_normal_color',
            [
                'label'     => esc_html__('Color', 'magical-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgnav-menu > .mgnav-menu-list > li > a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'menu_normal_bgcolor',
                'label' => esc_html__('Background', 'magical-addons-for-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .mgnav-menu > .mgnav-menu-list > li > a',
            ]
        );

        $this->end_controls_tab();

        // Menu Style Hover Tab Start
        $this->start_controls_tab(
            'menu_style_hover_tab',
            [
                'label' => esc_html__('Hover', 'magical-addons-for-elementor'),
            ]
        );
        $this->add_control(
            'menu_hover_color',
            [
                'label'     => esc_html__('Color', 'magical-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgnav-menu > .mgnav-menu-list > li > a:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mgnav-menu > .mgnav-menu-list > li.current-menu-item > a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mgnav-menu > .mgnav-menu-list > li > a.active' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mgnav-menu > .mgnav-menu-list > li.current-menu-item > a.active' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'menu_hvr_bgcolor',
                'label' => esc_html__('Background', 'magical-addons-for-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .mgnav-menu > .mgnav-menu-list > li > a:hover,{{WRAPPER}} .mgnav-menu > .mgnav-menu-list > li.current-menu-item > a,{{WRAPPER}} .mgnav-menu > .mgnav-menu-list > li > a.active,{{WRAPPER}} .mgnav-menu > .mgnav-menu-list > li.current-menu-item > a.active',
            ]
        );

        $this->end_controls_tab();


        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'menu_line_style',
            [
                'label' => esc_html__('Line Style', 'magical-addons-for-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'topline',
            [
                'label' => esc_html__('Top Line', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'menu_linetop_width',
            [
                'label' => esc_html__('Top Line Width', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgnav--topline ul li a span:before,{{WRAPPER}} .mgnav--topline-hvr ul li a span:before' => 'width: {{SIZE}}{{UNIT}};',
                ],

            ]
        );
        $this->add_responsive_control(
            'menu_linetop_height',
            [
                'label' => esc_html__('Top Line Height', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgnav--topline ul li a span:before,{{WRAPPER}} .mgnav--topline-hvr ul li a span:before' => 'height: {{SIZE}}{{UNIT}};',
                ],

            ]
        );
        $this->add_responsive_control(
            'menu_linetop_position',
            [
                'label' => esc_html__('Top Line Position', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => -50,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgnav--topline ul li a span:before,{{WRAPPER}} .mgnav--topline-hvr ul li a span:before' => 'top: {{SIZE}}{{UNIT}};',
                ],

            ]
        );
        $this->add_control(
            'menu_linetop_color',
            [
                'label'     => esc_html__('Topline Color', 'magical-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgnav--topline ul li a span:before,{{WRAPPER}} .mgnav--topline-hvr ul li a span:before' => 'background: {{VALUE}};opacity:1',
                ],
            ]
        );
        $this->add_control(
            'bottomline',
            [
                'label' => esc_html__('Bottom Line', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'menu_linebottom_width',
            [
                'label' => esc_html__('Bottom Line Width', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgnav--bottomline ul li a span:after,
                    {{WRAPPER}}.mgnav--bottomline-hvr ul li a span:after' => 'width: {{SIZE}}{{UNIT}};',
                ],

            ]
        );
        $this->add_responsive_control(
            'menu_linebottm_height',
            [
                'label' => esc_html__('Bottom Line Height', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgnav--bottomline ul li a span:after,
                    {{WRAPPER}}.mgnav--bottomline-hvr ul li a span:after' => 'height: {{SIZE}}{{UNIT}};',
                ],

            ]
        );
        $this->add_responsive_control(
            'menu_linebottm_position',
            [
                'label' => esc_html__('Bottom Line Position', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => -50,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgnav--bottomline ul li a span:after,
                    {{WRAPPER}}.mgnav--bottomline-hvr ul li a span:after' => 'bottom: {{SIZE}}{{UNIT}};',
                ],

            ]
        );
        $this->add_control(
            'menu_linebottom_color',
            [
                'label'     => esc_html__('Bottom Line Color', 'magical-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgnav--bottomline ul li a span:after,
                    {{WRAPPER}}.mgnav--bottomline-hvr ul li a span:after' => 'background: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'menu_dropdown_style',
            [
                'label' => esc_html__('Dropdown Menu', 'magical-addons-for-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'menu_dropdown_width',
            [
                'label' => esc_html__('Dropdown Menu Width', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 250,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgnav-menu ul li ul.sub-menu' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'dropdown_menu_bgcolor',
                'label' => esc_html__('Background', 'magical-addons-for-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .mgnav-menu ul li ul.sub-menu',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'dropdown_menu_border',
                'label' => esc_html__('Border', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .mgnav-menu ul li ul.sub-menu',
            ]
        );
        $this->add_responsive_control(
            'dropdown_menuitem_padding',
            [
                'label' => esc_html__('Item Padding', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .mgnav-menu ul li ul.sub-menu a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'dropdown_menuitem_margin',
            [
                'label' => esc_html__('Item Margin', 'magical-addons-for-elementor'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .mgnav-menu ul li ul.sub-menu a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Menu Style Normal Tabs Start
        $this->start_controls_tabs('dropmenu_style_tabs');

        // Menu Style Normal Tab Start
        $this->start_controls_tab(
            'dropdown_item_normal_style',
            [
                'label' => esc_html__('Normal', 'magical-addons-for-elementor'),
            ]
        );
        $this->add_control(
            'dropdown_normal_color',
            [
                'label'     => esc_html__('Color', 'magical-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgnav-menu ul li ul.sub-menu a' => 'color: {{VALUE}};opacity:1',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'drp_normal_bgcolor',
                'label' => esc_html__('Background', 'magical-addons-for-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .mgnav-menu ul li ul.sub-menu a',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'dropdown_normal_border',
                'label' => esc_html__('Border', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .mgnav-menu ul li ul.sub-menu a',
            ]
        );
        $this->end_controls_tab();

        // Menu Style Hover Tab Start
        $this->start_controls_tab(
            'dropdown_item_hvr_style',
            [
                'label' => esc_html__('Hover', 'magical-addons-for-elementor'),
            ]
        );
        $this->add_control(
            'dropdown_hvr_color',
            [
                'label'     => esc_html__('Color', 'magical-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgnav-menu ul li ul.sub-menu a:hover' => 'color: {{VALUE}};opacity:1',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'drp_hvr_bgcolor',
                'label' => esc_html__('Background', 'magical-addons-for-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .mgnav-menu ul li ul.sub-menu a:hover',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'dropdown_hvr_border',
                'label' => esc_html__('Border', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .mgnav-menu ul li ul.sub-menu a:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
        // Mobile Menu Toggler Style tab section
        $this->start_controls_section(
            'mobile_menu_toggler_style',
            [
                'label' => esc_html__('Mobile Menu Toggler', 'magical-addons-for-elementor'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'mobile_menu_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mobile_menu_icon_color',
            [
                'label'     => esc_html__('Icon Color', 'magical-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgnav-menu .mgnav-menu-head .mgnav-menu-toggle' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mgmnav-close::before,{{WRAPPER}} .mgmnav-close::after' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mobile_menu_text_color',
            [
                'label'     => esc_html__('Text Color', 'magical-addons-for-elementor'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgnav-menu .mgnav-menu-head .mgnav-menu-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render($instance = [])
    {
        $exclass = [];

        $settings = $this->get_settings_for_display();
        $id       = $this->get_id();
        if ($settings['fixed_menu']) {
            $exclass[] = 'mgfxtop';
        }
        $exclass[] = $settings['menu_topline'];
        $exclass[] = $settings['menu_bottomline'];

        $this->add_render_attribute('area_attr', 'class', 'mgnav-menu no-load mgnav-menu-' . $settings['menu_style']);

        $this->add_render_attribute('area_attr', 'class', implode(" ", $exclass));

        // Mobile Menu Toggler
        $mobile_text = (!empty($settings['mobile_menu']) ? '<h3 class="mgnav-menu-title">' . $settings['mobile_menu'] . '</h2>' : '');

        // Custom Title and Badge
        $customdata = [];
        /*
        if ($settings['add_custom_menuicon'] == 'yes') {
            $this->add_render_attribute('area_attr', 'class', 'mgmnav-menu-icon-pos-' . $settings['icon_pos']);
            $customicons = $settings['custom_icon_list'];
            if (is_array($customicons)) {
                foreach ($customicons as $customicon) {
                    $customdata[$customicon['menu_item']] = [
                        //   'icon' => move_addons_render_icon($customicon, 'custom_menu_icon', 'custom_menuicon'),
                        'icon' => Icons_Manager::render_icon($customicon['custom_menu_icon'], array('aria-hidden' => 'true')),
                    ];
                }
            }
        }
*/
        if ($settings['menu_source'] == 'wpnav') {
            // Menu Argument
            $args = [
                'echo' => false,
                'menu' => $settings['inline_menu_slug'],
                'menu_class' => 'mgnav-menu-list',
                'menu_id' => 'menu-' . $id,
                'fallback_cb' => '__return_empty_string',
                'depth' => 2,
                'container' => '',
                'walker' => new Mg_Addons_Walker_Nav_Menu(),
                'custom_data' => [
                    'icon' => $customdata,
                ]
            ];

            // Generate Menu.
            $menu_html = wp_nav_menu($args);
        }


?>
        <div <?php echo $this->get_render_attribute_string('area_attr'); ?>>
            <?php if ($settings['mobile_menu_show']) : ?>
                <div class="mgnav-menu-head">
                    <?php
                    if (!empty($settings['mobile_menu'])) : ?>
                        <h3 class="mgnav-menu-title">
                            <?php echo esc_html($settings['mobile_menu']);  ?>
                        </h3>
                    <?php
                    endif;
                    if (!empty($settings['mobile_menu_toggler_icon']['value'])) : ?>
                        <button class="mgnav-menu-toggle"><span class="mgmnav-open"><?php Icons_Manager::render_icon($settings['mobile_menu_toggler_icon'], array('aria-hidden' => 'true')); ?></span><span class="mgmnav-close">&nbsp;</span></button>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php
            if (!empty($menu_html) && $settings['menu_source'] == 'wpnav') {
                echo $menu_html;
            } else {
                $this->custom_menu($settings, $id);
            }
            ?>
        </div>
    <?php

    }

    public function custom_menu($settings, $id)
    {
        $num = 0;
        $menu_items = $settings['menu_items'];
    ?>
        <ul id="menu-<?php echo esc_attr($id); ?>" class="mgnav-menu-list">
            <?php if ($menu_items) : ?>
                <?php
                foreach ($menu_items as $index => $item) :
                    $key1 = $this->get_repeater_setting_key('menu_url', 'menu_items', $index);

                    $this->add_render_attribute($key1, 'href', esc_url($item['menu_url']['url']));
                    $this->add_render_attribute($key1, 'class', 'mg-menu-link');
                    if (!empty($item['menu_url']['is_external'])) {
                        $this->add_render_attribute($key1, 'target', '_blank');
                    }
                    if (!empty($item['menu_url']['nofollow'])) {
                        $this->set_render_attribute($key1, 'rel', 'nofollow');
                    }
                ?>
                    <li id="nav-menu-item-117" class="main-menu-item ">
                        <a <?php echo $this->get_render_attribute_string($key1); ?>><span class="mgnav-menu-text"><?php echo esc_html($item['menu_text']); ?></span></a>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
<?php
    }
}
