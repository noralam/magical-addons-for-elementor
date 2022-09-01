<?php


class MgAddon_Tabs extends \Elementor\Widget_Base
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
        return 'mg_tabs';
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
        return esc_html__('MG Tabs', 'magical-addons-for-elementor');
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
        return 'eicon-tabs';
    }

    public function get_keywords()
    {
        return ['tab', 'tabs', 'animation', 'mg'];
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
            'mg-tabs',
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
    /*  public function get_style_depends()
    {
        return [
            'mg-scrolltop',
        ];
    }
*/
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
            'mgtab_content_section',
            [
                'label' => esc_html__('Tab Content', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mgtab_type',
            [
                'label' => esc_html__('Type', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => [
                    'horizontal' => esc_html__('Horizontal', 'magical-addons-for-elementor'),
                    'vertical' => esc_html__('Vertical', 'magical-addons-for-elementor'),
                ],
            ]
        );


        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'mgtab_title',
            [
                'label' => esc_html__('Title', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );
        $repeater->add_control(
            'mgtab_icon_show',
            [
                'label' => esc_html__('Show Icon?', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'magical-addons-for-elementor'),
                'label_off' => esc_html__('No', 'magical-addons-for-elementor'),
                'default' => '',
            ]
        );
        $repeater->add_control(
            'mgtab_selected_icon',
            [
                'label' => esc_html__('Select Icon', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'separator' => 'before',
                'default' => [
                    'value' => 'fas fa-plus',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'mgtab_icon_show' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'mgtab_content',
            [
                'label' => esc_html__('Description', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );


        $this->add_control(
            'mgtab_items',
            [
                'label' => esc_html__('Content', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'separator' => 'before',
                'title_field' => '{{ mgtab_title }}',
                'fields' => $repeater->get_controls(),
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    [
                        'mgtab_title' => ' Tab One ',
                        'mgtab_content' => 'Lorem ispam dummy text, you can edit or remove it. far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast',
                        'mgtab_is_open'    => 'yes'
                    ],
                    [
                        'mgtab_title' => ' Tab Two',
                        'mgtab_content' => 'Lorem ispam dummy text, you can edit or remove it. far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast',
                    ],
                    [
                        'mgtab_title' => 'Tab Three',
                        'mgtab_content' => 'Lorem ispam dummy text, you can edit or remove it. far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast',
                    ],
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'mgtab_options_section',
            [
                'label' => esc_html__('Tab Options', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'mgtab_style',
            [
                'label' => esc_html__('Tabs Style', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '4',
                'options' => [
                    '1' => esc_html__('Style One', 'magical-addons-for-elementor'),
                    '2' => esc_html__('Style Two', 'magical-addons-for-elementor'),
                    '3' => esc_html__('Style Three', 'magical-addons-for-elementor'),
                    '4' => esc_html__('Style Four', 'magical-addons-for-elementor'),
                ],
            ]
        );
        $this->add_control(
            'mgtab_animation',
            [
                'label' => esc_html__('Tabs Animation', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'slideUp',
                'options' => [
                    'none' => esc_html__('None', 'magical-addons-for-elementor'),
                    'fade' => esc_html__('Fade', 'magical-addons-for-elementor'),
                    'slideDown' => esc_html__('Slide Down', 'magical-addons-for-elementor'),
                    'slideUp' => esc_html__('Slide Up', 'magical-addons-for-elementor'),
                    'slideRight' => esc_html__('Slide Right', 'magical-addons-for-elementor'),
                    'slideLeft' => esc_html__('Slide Left', 'magical-addons-for-elementor'),
                ],
            ]
        );
        $this->add_control(
            'mgtab_full_width',
            [
                'label' => esc_html__('Full Width Nav', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_on' => esc_html__('Show', 'magical-addons-for-elementor'),
                'label_off' => esc_html__('Hide', 'magical-addons-for-elementor'),
                'condition' => [
                    'mgtab_type' => 'horizontal',
                ],
            ]
        );


        $this->add_responsive_control(
            'mgtab_text_align',
            [
                'label' => esc_html__('Content Alignment', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-text-align-right',
                    ],

                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .mgtab-content' => 'text-align:{{VALUE}};',

                ],

            ]
        );

        $this->add_responsive_control(
            'mgtab_nav_align',
            [
                'label' => esc_html__('Nav Alignment', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-text-align-right',
                    ],

                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .mgnav-fit' => 'text-align:{{VALUE}};',

                ],
                'condition' => [
                    'mgtab_full_width' => '',

                ],


            ]
        );


        $this->add_control(
            'mgtab_icon_position',
            [
                'label' => esc_html__('Icon Position', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-h-align-right',
                    ],
                    'top' => [
                        'title' => esc_html__('Top', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'bottom' => [
                        'title' => esc_html__('Bottom', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'default' => 'left',
                'toggle' => false,
                'label_block' => false,

            ]
        );

        $this->end_controls_section();
        $this->link_pro_added();
    }

    /**
     * Register Accordion widget style ontrols.
     *
     * Adds different input fields in the style tab to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_style_controls()
    {


        $this->start_controls_section(
            'mgtab_wrapper_section',
            [
                'label' => esc_html__('Wrapper', 'magical-addons-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'mgtab_wrapper_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-tabs' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgtab_wrapper_border',
                'selector' => '{{WRAPPER}} .mg-tabs',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            array(
                'name'     => 'mgtab_wrapper_bg',
                'default' => '',
                'selector' => '{{WRAPPER}} .mg-tabs',
            )
        );
        $this->add_responsive_control(
            'mgtab_wrapper_border_radius',
            [
                'label' => esc_html__('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-tabs' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgtab_wrapper_box_shadow',
                'label' => esc_html__('Box Shadow', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .mg-tabs',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'mgtab_navwrapper_section',
            [
                'label' => esc_html__('Nav Wrapper', 'magical-addons-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgtabnav_wrapper_bg',
                'label' => esc_html__('Background', 'magical-addons-for-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .mg-tabs .mgtab-nav-wrap',
            ]
        );
        $this->add_responsive_control(
            'mgtabnav_wrapper_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-tabs .mgtab-nav-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgtabnav_wrapper_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-tabs .mgtab-nav-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgtabnav_wrapper_border',
                'selector' => '{{WRAPPER}} .mg-tabs .mgtab-nav-wrap',
            ]
        );

        $this->add_responsive_control(
            'mgtab_navwrapper_border_radius',
            [
                'label' => esc_html__('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-tabs .mgtab-nav-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgtab_navwrapper_box_shadow',
                'label' => esc_html__('Box Shadow', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .mg-tabs .mgtab-nav-wrap',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'mgtab_navitems_style',
            [
                'label'     => esc_html__('Nav Items', 'magical-addons-for-elementor'),
                'tab'     => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'         => 'mgtab_tabitems_typography',
                'selector'     => '{{WRAPPER}} .mg-tabs ul li a',
            ]
        );
        $this->add_responsive_control(
            'mgtab_tabitems_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-tabs ul li a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgtab_tabitems_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-tabs ul li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'mgtab_navitems_style_tabs'
        );
        $this->start_controls_tab(
            'mgtabnav_items_normal_tab',
            [
                'label' => esc_html__('Normal', 'magical-addons-for-elementor'),
            ]
        );
        $this->add_control(
            'mgtabnav_items_normal_textcolor',
            [
                'label'         => esc_html__('Text Color', 'magical-addons-for-elementor'),
                'type'         => \Elementor\Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .mg-tabs ul li a' => 'color: {{VALUE}};',

                ],
            ]
        );

        $this->add_control(
            'mgtabnav_items_normal_iconcolor',
            [
                'label'         => esc_html__('Icon Color', 'magical-addons-for-elementor'),
                'type'         => \Elementor\Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .mg-tabs ul li a span i' => 'color: {{VALUE}};',
                    'condition' => [
                        'mgtab_icon_show' => 'yes',
                    ],

                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgtabnav_items_normal_bg',
                'label' => esc_html__('Background', 'magical-addons-for-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .mg-tabs ul li a',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgtabnav_items_normal_border',
                'label' => esc_html__('Border', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .mg-tabs ul li a',
            ]
        );

        $this->add_control(
            'mgtabnav_items_normal_border_radius',
            [
                'label' => esc_html__('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .mg-tabs ul li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgtabnav_items_normal_bshadow',
                'label' => esc_html__('Box Shadow', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .mg-tabs ul li a',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'mgtab_navitems_style_active_tab',
            [
                'label' => esc_html__('Active', 'magical-addons-for-elementor'),
            ]
        );
        $this->add_control(
            'mgtabnav_items_active_textcolor',
            [
                'label'         => esc_html__('Text Color', 'magical-addons-for-elementor'),
                'type'         => \Elementor\Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .mg-tabs ul li a.active' => 'color: {{VALUE}};',

                ],
            ]
        );
        $this->add_control(
            'mgtabnav_items_active_iconcolor',
            [
                'label'         => esc_html__('Icon Color', 'magical-addons-for-elementor'),
                'type'         => \Elementor\Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .mg-tabs ul li a.active span i' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'mgtab_icon_show' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgtabnav_items_active_bg',
                'label' => esc_html__('Background', 'magical-addons-for-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .mg-tabs ul li a.active, {{WRAPPER}} .mgt-style1 .nav-tabs li a.active:after',
            ]
        );
        $this->add_control(
            'mgtabnav_items_active_arrowcolor',
            [
                'label'         => esc_html__('Extra Arrow Color', 'magical-addons-for-elementor'),
                'type'         => \Elementor\Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .mgt-style2 .nav-tabs li a.active, {{WRAPPER}} .mgt-style2 .nav-tabs li a.active:hover' => 'border-top-color: {{VALUE}};',
                    '{{WRAPPER}}  .mgt-style1 .nav-tabs li a:after' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}}  .mgt-style3 .nav-tabs li a.active:after' => 'border-top-color: {{VALUE}};',
                ],


            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgtabnav_items_active_border',
                'label' => esc_html__('Border', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .mg-tabs ul li a.active',
            ]
        );

        $this->add_control(
            'mgtabnav_items_active_border_radius',
            [
                'label' => esc_html__('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .mg-tabs ul li a.active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgtabnav_items_active_bshadow',
                'label' => esc_html__('Box Shadow', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .mg-tabs ul li a.active',
            ]
        );
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
        //accordion content style 
        $this->start_controls_section(
            'mgtab_section_content_style',
            [
                'label'     => esc_html__('Content', 'magical-addons-for-elementor'),
                'tab'     => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'mgtab_content_color',
            [
                'label'         => esc_html__('Color', 'magical-addons-for-elementor'),
                'type'         => \Elementor\Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .mgtab-content .tab-pane, {{WRAPPER}} .mgtab-content .tab-pane p, {{WRAPPER}} .mgtab-content .tab-pane a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'         => 'mgtab_content_typography',
                'selector'     => '{{WRAPPER}} .mgtab-content .tab-pane',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgtab_content_background',
                'label' => esc_html__('Background', 'magical-addons-for-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .mgtab-content',
            ]
        );

        $this->add_control(
            'mgtab_content_border_radious',
            [
                'label' => esc_html__('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .mgtab-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgtab_content_padding',
            [
                'label' => esc_html__('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .mgtab-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgtab_content_width',
            [
                'label' => esc_html__('Width', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgtab-content' => 'width: {{SIZE}}{{UNIT}};',
                ],

            ]
        );

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
        $mgtab_items = $this->get_settings('mgtab_items');
?>


        <?php
        $mgtab_rand = rand(253195, 56914658);

        ?>
        <div class="mg-tabs mg-shadow mgt-style<?php echo esc_attr($settings['mgtab_style']); ?> mg-tab-<?php echo esc_attr($settings['mgtab_type']); ?>">
            <?php if ($mgtab_items) : ?>
                <?php
                // if( $settings['mgtab_type'] == 'horizontal'):
                ?>

                <!-- Horijontal tab start -->
                <?php if ($settings['mgtab_type'] == 'vertical') : ?>
                    <div class="mgv-tabs">
                        <div class="mgv-tmenu">
                            <!-- Horijontal tab end -->
                        <?php endif; ?>


                        <div class="mgtab-nav-wrap mgnav-<?php if ($settings['mgtab_full_width'] == 'yes') : ?>full<?php else : ?>fit<?php endif; ?>">
                            <ul class="nav nav-tabs <?php if ($settings['mgtab_full_width'] == 'yes' && $settings['mgtab_type'] == 'horizontal') : ?>nav-justified<?php endif; ?>" id="myTab" role="tablist">

                                <?php
                                foreach ($mgtab_items as $index => $item) :
                                    $key1 = $this->get_repeater_setting_key('mgtab_title', 'mgtab_items', $index);
                                    $this->add_inline_editing_attributes($key1);

                                    if ($index == 0) {
                                        $mglink_class = 'nav-link active';
                                    } else {
                                        $mglink_class = 'nav-link';
                                    }
                                ?>
                                    <li class="nav-item">
                                        <a class="<?php echo esc_attr($mglink_class); ?>" id="home-tab" data-toggle="tab" href="#mgtab<?php echo esc_attr($mgtab_rand . $index); ?>" role="tab" aria-controls="home" aria-selected="<?php if ($index == 0) : ?>true<?php else : ?>false<?php endif; ?>">
                                            <?php if ($item['mgtab_icon_show'] == 'yes' && ($settings['mgtab_icon_position'] == 'left' || $settings['mgtab_icon_position'] == 'top')) : ?>
                                                <span class="mgt-icon-<?php echo esc_attr($settings['mgtab_icon_position']); ?>">
                                                    <?php \Elementor\Icons_Manager::render_icon($item['mgtab_selected_icon']); ?>
                                                </span>
                                            <?php endif; ?>
                                            <span <?php echo $this->get_render_attribute_string($key1); ?>><?php echo mg_kses_tags($item['mgtab_title']); ?></span>
                                            <?php if ($item['mgtab_icon_show'] == 'yes' && ($settings['mgtab_icon_position'] == 'right' || $settings['mgtab_icon_position'] == 'bottom')) : ?>
                                                <span class="mgt-icon-<?php echo esc_attr($settings['mgtab_icon_position']); ?>">
                                                    <?php \Elementor\Icons_Manager::render_icon($item['mgtab_selected_icon']); ?>
                                                </span>
                                            <?php endif; ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>

                            </ul>
                        </div>
                        <!-- Horijontal tab start -->
                        <?php if ($settings['mgtab_type'] == 'vertical') : ?>
                        </div>
                        <div class="mgv-tcontent">
                            <!-- Horijontal tab end -->
                        <?php endif; ?>
                        <div class="tab-content mgtab-content">
                            <?php
                            foreach ($mgtab_items as $index => $item) :
                                $key2 = $this->get_repeater_setting_key('mgtab_content', 'mgtab_items', $index);
                                $this->add_inline_editing_attributes($key2);
                                $this->add_render_attribute($key2, 'class', 'tab-pane ' . $settings['mgtab_animation']);
                                if ($index == 0) {
                                    $this->add_render_attribute($key2, 'class', 'show active');
                                }
                            ?>
                                <div <?php echo $this->get_render_attribute_string($key2); ?> id="mgtab<?php echo esc_attr($mgtab_rand . $index); ?>" role="tabpanel" aria-labelledby="home-tab"><?php echo wp_kses_post($item['mgtab_content']) ?></div>

                            <?php endforeach; ?>

                        </div>
                        <!-- Horijontal tab start -->
                        <?php if ($settings['mgtab_type'] == 'vertical') : ?>
                        </div>
                    </div>
                    <!-- Horijontal tab end -->
                <?php endif; ?>

                <?php /* else: ?>
<div class="row">
  <div class="col-3">
    <div class="nav flex-column" id="v-pills-tab" role="tablist" aria-orientation="vertical">
      <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Home</a>
      <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profile</a>
      <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Messages</a>
      <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>
    </div>
  </div>
  <div class="col-9">
    <div class="tab-content" id="v-pills-tabContent">
      <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">...</div>
      <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">...</div>
      <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">...</div>
      <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">...</div>
    </div>
  </div>
</div>	

    <?php endif; */ ?>
        </div>
<?php
            endif; //Check tab item 
        }

        /**
         * Render Blank widget output on the frontend.
         *
         * Written in JS and used to generate the final HTML.
         *
         * @since 1.0.0
         * @access protected
         */
        /*protected function content_template() {}*/
    }
