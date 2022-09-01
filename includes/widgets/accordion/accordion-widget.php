<?php


class MgAccordion extends \Elementor\Widget_Base
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
        return 'mgaccordion_widget';
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
        return esc_html__('MG Accordion', 'magical-addons-for-elementor');
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
        return 'eicon-accordion';
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
    public function get_keywords()
    {
        return ['accordion', 'toggle', 'tab', 'mg'];
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
            'mgac_item_section',
            [
                'label' => esc_html__('MG Accordion', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'mgac_title',
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
            'mgac_content',
            [
                'label' => esc_html__('Description', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );
        $repeater->add_control(
            'mgac_is_open',
            [
                'label' => esc_html__('Keep this slide open? ', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_on' => esc_html__('Yes', 'magical-addons-for-elementor'),
                'label_off' => esc_html__('No', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'mgac_items',
            [
                'label' => esc_html__('Content', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'separator' => 'before',
                'title_field' => '{{ mgac_title }}',
                'fields' => $repeater->get_controls(),
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    [
                        'mgac_title' => ' Magical Addons For Elementor Accordion Title ',
                        'mgac_content' => 'Lorem ispam dummy text, you can edit or remove it. far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast',
                        'mgac_is_open'    => 'yes'
                    ],
                    [
                        'mgac_title' => ' Magical Addons For Elementor Accordion Title',
                        'mgac_content' => 'Lorem ispam dummy text, you can edit or remove it. far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast',
                    ],
                    [
                        'mgac_title' => 'Magical Addons For Elementor Accordion Title',
                        'mgac_content' => 'Lorem ispam dummy text, you can edit or remove it. far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast',
                    ],
                ],
            ]
        );
        /*$this->add_control(
            'mgac_open_first_slide',
            [
                'label' => esc_html__( 'Keep first slide auto open?', 'magical-addons-for-elementor' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'magical-addons-for-elementor' ),
                'label_off' => esc_html__( 'No', 'magical-addons-for-elementor' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );*/
        $this->add_control(
            'mgac_style',
            [
                'label' => esc_html__('Style', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'accoedion-primary',
                'options' => [
                    'accoedion-primary' => esc_html__('Primary', 'magical-addons-for-elementor'),
                    'curve-shape' => esc_html__('Curve Shape', 'magical-addons-for-elementor'),
                    'side-curve' => esc_html__('Side Curve', 'magical-addons-for-elementor'),
                    'box-icon' => esc_html__('Box Icon', 'magical-addons-for-elementor'),
                ],
            ]
        );
        $this->add_control(
            'mgac_effect',
            [
                'label' => esc_html__('Animation Effect', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'effect1',
                'options' => [
                    'none' => esc_html__('No Effect', 'magical-addons-for-elementor'),
                    'effect1' => esc_html__('Effect One', 'magical-addons-for-elementor'),
                    'effect2' => esc_html__('Effect Two', 'magical-addons-for-elementor'),
                    'effect3' => esc_html__('Effect Three', 'magical-addons-for-elementor'),
                ],
            ]
        );


        $this->add_responsive_control(
            'mgac_text_align',
            [
                'label' => esc_html__('Alignment', 'magical-addons-for-elementor'),
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
                'default' => 'center',

            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'mgac_icon_section',
            [
                'label' => esc_html__('Icon', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mgac_icon_show',
            [
                'label' => esc_html__('Show Icon?', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'magical-addons-for-elementor'),
                'label_off' => esc_html__('No', 'magical-addons-for-elementor'),
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mgac_selected_icon',
            [
                'label' => esc_html__('Icon', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'separator' => 'before',
                'default' => [
                    'value' => 'fas fa-plus',
                    'library' => 'fa-solid',
                ],
                'recommended' => [
                    'fa-solid' => [
                        'plus',
                        'plus-square',
                        'angle-double-down',
                        'angle-double-up',
                        'angle-double-right',
                        'angle-double-left',
                        'angle-double-left',
                        'angle-down',
                        'angle-up',
                        'angle-left',
                        'angle-right',
                        'arrow-circle-down',
                        'arrow-circle-up',
                        'arrow-circle-left',
                        'arrow-circle-right',
                        'arrow-down',
                        'arrow-up',
                        'arrow-left',
                        'arrow-right',
                        'caret-down',
                        'caret-up',
                        'caret-left',
                        'caret-right',
                    ],
                    'fa-regular' => [
                        'plus-square',
                        'plus-circle',
                        'arrow-alt-circle-down',
                        'arrow-alt-circle-up',
                        'arrow-alt-circle-left',
                        'arrow-alt-circle-right',
                    ],
                ],
                'condition' => [
                    'mgac_icon_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mgac_selected_active_icon',
            [
                'label' => esc_html__('Active Icon', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-minus',
                    'library' => 'fa-solid',
                ],
                'recommended' => [
                    'fa-solid' => [
                        'plus',
                        'plus-square',
                        'angle-double-down',
                        'angle-double-up',
                        'angle-double-right',
                        'angle-double-left',
                        'angle-double-left',
                        'angle-down',
                        'angle-up',
                        'angle-left',
                        'angle-right',
                        'arrow-circle-down',
                        'arrow-circle-up',
                        'arrow-circle-left',
                        'arrow-circle-right',
                        'arrow-down',
                        'arrow-up',
                        'arrow-left',
                        'arrow-right',
                        'caret-down',
                        'caret-up',
                        'caret-left',
                        'caret-right',
                    ],
                    'fa-regular' => [
                        'plus-square',
                        'plus-circle',
                        'arrow-alt-circle-down',
                        'arrow-alt-circle-up',
                        'arrow-alt-circle-left',
                        'arrow-alt-circle-right',
                    ],
                ],
                'condition' => [
                    'mgac_icon_show' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'mgac_icon_position',
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
                ],
                'default' => 'right',
                'toggle' => false,
                'label_block' => false,
                'condition' => [
                    'mgac_icon_show' => 'yes',
                ],
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
            'mgac_style_section',
            [
                'label' => esc_html__('Accordion', 'magical-addons-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'mgac_border_width',
            [
                'label' => esc_html__('Border Width', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .card.mgrc-item' => 'border-width: {{SIZE}}{{UNIT}};',

                ],
            ]
        );

        $this->add_control(
            'mgac_border_color',
            [
                'label' => esc_html__('Border Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .card.mgrc-item' => 'border-color: {{VALUE}};',

                ],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'mgac_title_style',
            [
                'label'     => esc_html__('Title', 'magical-addons-for-elementor'),
                'tab'     => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'         => 'mgac_title_typography',
                'selector'     => '{{WRAPPER}} .mgrc-title h2',
            ]
        );
        $this->add_control(
            'mgac_usebg_color',
            [
                'label' => esc_html__('Hide default gradient? ', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
                'label_on' => esc_html__('Yes', 'magical-addons-for-elementor'),
                'label_off' => esc_html__('No', 'magical-addons-for-elementor'),
            ]
        );
        $this->start_controls_tabs(
            'mgac_accordion_style_tabs'
        );
        $this->start_controls_tab(
            'mgac_open_tab',
            [
                'label' => esc_html__('Open', 'magical-addons-for-elementor'),
            ]
        );
        $this->add_control(
            'mgac_title_color_open',
            [
                'label'         => esc_html__('Color', 'magical-addons-for-elementor'),
                'type'         => \Elementor\Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .mgrc-title h2' => 'color: {{VALUE}};',

                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgac_title_background_open',
                'label' => esc_html__('Background', 'magical-addons-for-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .card-header.mg-accordion-title .mgrc-title',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgac_title_border_open',
                'label' => esc_html__('Border', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .card-header.mg-accordion-title .mgrc-title',
            ]
        );

        $this->add_control(
            'mgac_title_border_radius_open',
            [
                'label' => esc_html__('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .card-header.mg-accordion-title .mgrc-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgac_box_shadow_open',
                'label' => esc_html__('Box Shadow', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .card-header.mg-accordion-title .mgrc-title',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'mgac_style_close_tab',
            [
                'label' => esc_html__('Closed', 'magical-addons-for-elementor'),
            ]
        );
        $this->add_control(
            'mgac_title_color_close',
            [
                'label'         => esc_html__('Color', 'magical-addons-for-elementor'),
                'type'         => \Elementor\Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .mgrc-title.collapsed h2' => 'color: {{VALUE}};'
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgac_background_close',
                'label' => esc_html__('Background', 'magical-addons-for-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .card-header.mg-accordion-title .mgrc-title.collapsed',

            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgac_title_border_close',
                'label' => esc_html__('Border', 'magical-addons-for-elementor'),
                'condition' => [
                    'mgac_style!' => ['curve-shape']
                ],
                'selector' => '{{WRAPPER}} .card-header.mg-accordion-title .mgrc-title.collapsed',
            ]
        );
        $this->add_control(
            'mgac_border_radious_close',
            [
                'label' => esc_html__('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .card-header.mg-accordion-title .mgrc-title.collapsed' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgac_box_shadow_close',
                'label' => esc_html__('Box Shadow', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} .card-header.mg-accordion-title .mgrc-title.collapsed',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'mgac_title_divide',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->add_responsive_control(
            'mgac_title_padding',
            [
                'label' => esc_html__('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .card-header.mg-accordion-title .mgrc-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );



        $this->add_responsive_control(
            'mgac_title_margin_bottom',
            [
                'label'             => esc_html__('Margin Bottom', 'magical-addons-for-elementor'),
                'type'             => \Elementor\Controls_Manager::SLIDER,
                'default'         => [
                    'size' => '',
                ],
                'range'             => [
                    'px' => [
                        'min'     => -30,
                        'step'     => 1,
                    ],
                ],
                'size_units'     => ['px'],
                'selectors'         => [
                    '{{WRAPPER}} .card-header.mg-accordion-title .mgrc-title'    => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mg_cubestyle_bg_color',
            [
                'label' => __('cubestyle Background', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-side-curve .mgrc-title:before' => 'background: {{VALUE}};',
                ],
                'condition' => [
                    'mgac_style' => 'side-curve',
                ],

            ]
        );

        $this->end_controls_section();
        //accordion content style 
        $this->start_controls_section(
            'mgac_section_content_style',
            [
                'label'     => esc_html__('Content', 'magical-addons-for-elementor'),
                'tab'     => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'mgac_content_color',
            [
                'label'         => esc_html__('Color', 'magical-addons-for-elementor'),
                'type'         => \Elementor\Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .card-body.mgac-content p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'         => 'mgac_content_typography',
                'selector'     => '{{WRAPPER}} .card-body.mgac-content p',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgac_content_background',
                'label' => esc_html__('Background', 'magical-addons-for-elementor'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .card-body.mgac-content',
            ]
        );

        $this->add_control(
            'mgac_content_border_radious',
            [
                'label' => esc_html__('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .card-body.mgac-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgac_content_padding',
            [
                'label' => esc_html__('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .card-body.mgac-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgac_content_width',
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
                    'size' => 90,
                ],
                'selectors' => [
                    '{{WRAPPER}} .card-body.mgac-content' => 'width: {{SIZE}}{{UNIT}};',
                ],

            ]
        );

        $this->end_controls_section();
        //Icon Style Section
        $this->start_controls_section(
            'mgac_section_icon_style',
            [
                'label'     => esc_html__('Icon', 'magical-addons-for-elementor'),
                'tab'     => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'mgac_icon_move_heading',
            [
                'type' => \Elementor\Controls_Manager::HEADING,
                'label' => esc_html__('Move icon', 'magical-addons-for-elementor'),
                'separator' => 'before'
            ]
        );
        $this->start_controls_tabs(
            'mgac_tabs_icon_move'
        );
        $this->start_controls_tab(
            'mgac_icon_move_left_right',
            [
                'label' => esc_html__('Left & Right', 'magical-addons-for-elementor'),
            ]
        );
        $this->add_responsive_control(
            'mgac_icon_move_left_right_value',
            [
                'label' => esc_html__('Left & Right', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -10,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgc-icons.mgc-right-icon' => 'right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mgc-icons.mgc-left-icon' => 'left: {{SIZE}}{{UNIT}};'
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'mgac_icon_move_topbottom',
            [
                'label' => esc_html__('Top & Bottom', 'magical-addons-for-elementor'),
            ]
        );
        $this->add_responsive_control(
            'mgac_icon_move_topbottom_value',
            [
                'label' => esc_html__('Top & Bottom', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgc-icons.mgc-left-icon, {{WRAPPER}} .mgc-icons.mgc-right-icon' => 'top: {{SIZE}}{{UNIT}};'
                ],
            ]
        );
        $this->end_controls_tab();


        $this->end_controls_tabs();


        $this->start_controls_tabs(
            'mgac_style_tabs_icon'
        );
        $this->start_controls_tab(
            'mgac_icon_open_tab',
            [
                'label' => esc_html__('Slide Closed Icon', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'mgac_icon_color_close',
            [
                'label'         => esc_html__('Color', 'magical-addons-for-elementor'),
                'type'         => \Elementor\Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .mgrc-title.collapsed .mgc-icon i' => 'color: {{VALUE}};',

                ],
            ]
        );


        $this->add_responsive_control(
            'mgac_icon_typography_close',
            [
                'label' => esc_html__('Size', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgrc-title.collapsed .mgc-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_tab();
        $this->start_controls_tab(
            'mgac_icon_close_tab',
            [
                'label' => esc_html__(' Slide Open icon', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'mgac_icon_color',
            [
                'label'         => esc_html__('Color', 'magical-addons-for-elementor'),
                'type'         => \Elementor\Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .mgrc-title .mgc-icon i' => 'color: {{VALUE}};',

                ],
            ]
        );

        $this->add_responsive_control(
            'mgac_icon_typography', //icon id different because replaced the previous control
            [
                'label' => esc_html__('Size', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgrc-title .mgc-icon i' => 'font-size: {{SIZE}}{{UNIT}};',

                ]
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
        $mgac_items = $this->get_settings('mgac_items');
?>


        <?php
        $mgac_rand = rand(253495, 56934658);

        if ($settings['mgac_usebg_color'] == 'yes') {
            $mgac_excolor = 'excolor';
        } else {
            $mgac_excolor = 'eacolor';
        }
        ?>




        <div class="accordion mgaccordion mg-<?php echo esc_attr($settings['mgac_style']); ?> <?php echo $mgac_excolor; ?>" id="mgAccordion<?php echo esc_attr($mgac_rand); ?>">

            <?php if ($mgac_items) : ?>
                <?php
                foreach ($mgac_items as $index => $item) :
                    $key1 = $this->get_repeater_setting_key('mgac_title', 'mgac_items', $index);
                    $this->add_inline_editing_attributes($key1);
                    $key2 = $this->get_repeater_setting_key('mgac_content', 'mgac_items', $index);
                    $this->add_inline_editing_attributes($key2);
                ?>

                    <div class="card mgrc-item mgrc-item-<?php echo esc_attr($settings['mgac_text_align']); ?>-<?php echo esc_attr($settings['mgac_icon_position']); ?> text-<?php echo esc_attr($settings['mgac_text_align']); ?>">
                        <div class="card-header mg-accordion-title" id="heading<?php echo esc_attr($index); ?><?php echo esc_attr($mgac_rand); ?>">
                            <div class="mgrc-title <?php if ($item['mgac_is_open'] != 'yes') : ?>collapsed<?php endif; ?> <?php if ($settings['mgac_icon_position'] == 'left') : ?>mgrc-left<?php endif; ?>" data-bs-toggle="collapse" data-bs-target="#mgc-item<?php echo esc_attr($index); ?><?php echo esc_attr($mgac_rand); ?>" aria-expanded="<?php if ($item['mgac_is_open'] == 'yes') : ?>true<?php else : ?>false<?php endif; ?>" aria-controls="mgc-item<?php echo esc_attr($index); ?><?php echo esc_attr($mgac_rand); ?>">
                                <?php if ($settings['mgac_icon_position'] == 'left' && $settings['mgac_icon_show'] == 'yes') : ?>
                                    <div class="mgc-icons mgc-left-icon">
                                        <div class="mgc-icon">
                                            <span class="mgc-close"><?php \Elementor\Icons_Manager::render_icon($settings['mgac_selected_icon']); ?></span>

                                        </div>
                                        <div class="mgc-icon">
                                            <span class="mgc-open"><?php \Elementor\Icons_Manager::render_icon($settings['mgac_selected_active_icon']); ?></span>

                                        </div>
                                    </div>
                                <?php endif; ?>
                                <h2 <?php echo $this->get_render_attribute_string($key1); ?>><?php echo wp_kses_post($item['mgac_title']) ?></h2>
                                <?php if ($settings['mgac_icon_position'] == 'right' && $settings['mgac_icon_show'] == 'yes') : ?>
                                    <div class="mgc-icons mgc-right-icon">
                                        <div class="mgc-icon">
                                            <span class="mgc-close"><?php \Elementor\Icons_Manager::render_icon($settings['mgac_selected_icon']); ?></span>

                                        </div>
                                        <div class="mgc-icon">
                                            <span class="mgc-open"><?php \Elementor\Icons_Manager::render_icon($settings['mgac_selected_active_icon']); ?></span>

                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>

                        <div id="mgc-item<?php echo esc_attr($index); ?><?php echo esc_attr($mgac_rand); ?>" class="collapse mgaccont <?php if ($item['mgac_is_open'] == 'yes') : ?>show<?php endif; ?>" aria-labelledby="heading<?php echo esc_attr($index); ?><?php echo esc_attr($mgac_rand); ?>" data-bs-parent="#mgAccordion<?php echo esc_attr($mgac_rand); ?>">
                            <div class="card-body mgac-content mgac-<?php echo esc_attr($settings['mgac_effect']); ?>">
                                <p <?php echo $this->get_render_attribute_string($key2); ?>><?php echo wp_kses_post($item['mgac_content']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
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

    //	protected function content_template() {}



}
