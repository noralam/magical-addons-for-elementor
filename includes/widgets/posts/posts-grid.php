<?php


class mgPostGridWidget extends \Elementor\Widget_Base
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
        return 'mgposts_grid';
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
        return __('MG Posts Grid', 'magical-addons-for-elementor');
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
        return 'eicon-posts-grid';
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
            'mgpg_query',
            [
                'label' => esc_html__('Posts Query', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'mgpg_posts_filter',
            [
                'label' => esc_html__('Filter By', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'recent',
                'options' => [
                    'recent' => esc_html__('Recent Posts', 'magical-addons-for-elementor'),
                    /*'featured' => esc_html__( 'Popular Posts', 'magical-addons-for-elementor' ),*/
                    'random_order' => esc_html__('Random Posts', 'magical-addons-for-elementor'),
                    'show_byid' => esc_html__('Show By Id', 'magical-addons-for-elementor'),
                    'show_byid_manually' => esc_html__('Add ID Manually', 'magical-addons-for-elementor'),
                ],
            ]
        );

        $this->add_control(
            'mgpg_product_id',
            [
                'label' => __('Select posts', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => mgaddons_post_name(),
                'condition' => [
                    'mgpg_posts_filter' => 'show_byid',
                ]
            ]
        );

        $this->add_control(
            'mgpg_product_ids_manually',
            [
                'label' => __('posts IDs', 'magical-addons-for-elementor'),
                'description' => __('Separate IDs with commas', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'condition' => [
                    'mgpg_posts_filter' => 'show_byid_manually',
                ]
            ]
        );

        $this->add_control(
            'mgpg_posts_count',
            [
                'label'   => __('posts Limit', 'magical-addons-for-elementor'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 3,
                'step'    => 1,
            ]
        );

        $this->add_control(
            'mgpg_grid_categories',
            [
                'label' => esc_html__('posts Categories', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => mgaddons_taxonomy_list(),
                'condition' => [
                    'mgpg_posts_filter!' => 'show_byid',
                ]
            ]
        );

        $this->add_control(
            'mgpg_custom_order',
            [
                'label' => esc_html__('Custom order', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label' => esc_html__('Orderby', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none'          => esc_html__('None', 'magical-addons-for-elementor'),
                    'ID'            => esc_html__('ID', 'magical-addons-for-elementor'),
                    'date'          => esc_html__('Date', 'magical-addons-for-elementor'),
                    'name'          => esc_html__('Name', 'magical-addons-for-elementor'),
                    'title'         => esc_html__('Title', 'magical-addons-for-elementor'),
                    'comment_count' => esc_html__('Comment count', 'magical-addons-for-elementor'),
                    'rand'          => esc_html__('Random', 'magical-addons-for-elementor'),
                ],
                'condition' => [
                    'mgpg_custom_order' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__('order', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => [
                    'DESC'  => esc_html__('Descending', 'magical-addons-for-elementor'),
                    'ASC'   => esc_html__('Ascending', 'magical-addons-for-elementor'),
                ],
                'condition' => [
                    'mgpg_custom_order' => 'yes',
                ]
            ]
        );

        $this->end_controls_section();
        // posts Content
        $this->start_controls_section(
            'mgpg_layout',
            [
                'label' => esc_html__('Grid Layout', 'magical-addons-for-elementor'),
            ]
        );
        $this->add_control(
            'mgpg_post_style',
            [
                'label'   => __('Grid Style', 'magical-addons-for-elementor'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '1'   => __('Style One', 'magical-addons-for-elementor'),
                    '2'  => __('Style Two', 'magical-addons-for-elementor'),
                    '3'  => __('Style Three', 'magical-addons-for-elementor'),
                ]
            ]
        );
        $this->add_control(
            'mgpg_rownumber',
            [
                'label'   => __('Show Posts Per Row', 'magical-addons-for-elementor'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => '4',
                'options' => [
                    '12'   => __('1', 'magical-addons-for-elementor'),
                    '6'  => __('2', 'magical-addons-for-elementor'),
                    '4'  => __('3', 'magical-addons-for-elementor'),
                    '3'  => __('4', 'magical-addons-for-elementor'),
                    '2'  => __('6', 'magical-addons-for-elementor'),
                ]
            ]
        );
        $this->end_controls_section();
        // posts Content
        $this->start_controls_section(
            'mgpg_content',
            [
                'label' => esc_html__('Content Settings', 'magical-addons-for-elementor'),
            ]
        );


        $this->add_control(
            'mgpg_post_img_show',
            [
                'label'     => __('Show Posts image', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mgpg_show_title',
            [
                'label'     => __('Show posts Title', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'mgpg_crop_title',
            [
                'label'   => __('Crop Title By Word', 'magical-addons-for-elementor'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'step'    => 1,
                'default' => 5,
                'condition' => [
                    'mgpg_show_title' => 'yes',
                ]

            ]
        );
        $this->add_control(
            'mgpg_title_tag',
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
                'default' => 'h4',
                'condition' => [
                    'mgpg_show_title' => 'yes',
                ]

            ]
        );
        $this->add_control(
            'mgpg_desc_show',
            [
                'label'     => __('Show posts Description', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes'

            ]
        );
        $this->add_control(
            'mgpg_crop_desc',
            [
                'label'   => __('Crop Description By Word', 'magical-addons-for-elementor'),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'step'    => 1,
                'default' => 20,
                'condition' => [
                    'mgpg_desc_show' => 'yes',
                ]

            ]
        );

        $this->add_responsive_control(
            'mgpg_content_align',
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
                'classes' => 'flex-{{VALUE}}',
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mg-card-text' => 'text-align: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'mgpg_meta_section',
            [
                'label' => __('Posts Meta', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                'default' => '',
            ]
        );
        $this->add_control(
            'mgpg_date_show',
            [
                'label'     => __('Show Date', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'mgpg_category_show',
            [
                'label'     => __('Show Category', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'mgpg_cat_type',
            [
                'label' => __('Category type', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'all' => __('Show all categories', 'magical-addons-for-elementor'),
                    'one' => __('Show first category', 'magical-addons-for-elementor'),
                ],
                'default' => 'one',
                'condition' => [
                    'mgpg_category_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mgpg_author_show',
            [
                'label'     => __('Show Author', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',

            ]
        );
        $this->add_control(
            'mgpg_tag_show',
            [
                'label'     => __('Show Tags', 'magical-addons-for-elementor'),
                'type'      => \Elementor\Controls_Manager::SWITCHER,
                'default' => '',

            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'mgpg_button',
            [
                'label' => __('Button', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mgpg_post_btn',
            [
                'label' => __('Use post link?', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mgpg_link_type',
            [
                'label' => __('Link type', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'link1' => 'Link style one',
                    'link2' => 'Link style two',
                    'btn' => 'Button',
                ],
                'default' => 'link1',
            ]
        );

        $this->add_control(
            'mgpg_btn_title',
            [
                'label'       => __('Link Title', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => __('Read More', 'magical-addons-for-elementor'),
                'default'     => __('Read More', 'magical-addons-for-elementor'),
            ]
        );
        $this->add_control(
            'mgpg_btn_target',
            [
                'label' => __('Link Target', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '_self' => 'self',
                    '_blank' => 'Blank',
                ],
                'default' => '_self',
            ]
        );

        $this->add_control(
            'mgpg_usebtn_icon',
            [
                'label' => __('Use icon', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'default' => '',
            ]
        );

        $this->add_control(
            'mgpg_btn_icon',
            [
                'label' => __('Choose Icon', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-chevron-right',
                    'library' => 'solid',
                ],
                'condition' => [
                    'mgpg_usebtn_icon' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpg_btn_icon_position',
            [
                'label' => __('Icon Position', 'magical-addons-for-elementor'),
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
                    'mgpg_usebtn_icon' => 'yes',
                ],

            ]
        );
        $this->add_responsive_control(
            'mgpg_cardbtn_iconspace',
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
                    'mgpg_usebtn_icon' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mg-card .mg-card-btn i.left,{{WRAPPER}} .mg-card .mg-card-btn .left i' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mg-card .mg-card-btn i.right, {{WRAPPER}} .mg-card .mg-card-btn .right i' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mg-card .mg-card-btn svg.left,{{WRAPPER}} .mg-card .mg-card-btn .left svg' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mg-card .mg-card-btn svg.right, {{WRAPPER}} .mg-card .mg-card-btn .right svg' => 'margin-left: {{SIZE}}{{UNIT}};',
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
            'mgpg_style',
            [
                'label' => __('Layout style', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgpg_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-card.mgp-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpg_content_padding',
            [
                'label' => __('Content Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-items .mg-card-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpg_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-card.mgp-card' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgpg_bg_color',
                'label' => esc_html__('Background', 'magical-addons-for-elementor'),
                'types' => ['classic', 'gradient'],

                'selector' => '{{WRAPPER}} .mg-card.mgp-card',
            ]
        );

        $this->add_control(
            'mgpg_border_radius',
            [
                'label' => __('Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-card.mgp-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpg_content_border',
                'selector' => '{{WRAPPER}} .mg-card.mgp-card',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpg_content_shadow',
                'selector' => '{{WRAPPER}} .mg-card.mgp-card',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'mgpg_img_style',
            [
                'label' => __('Image style', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'mgpg_post_img_show' => 'yes',
                ]
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
                    '{{WRAPPER}} .mgp-card .mg-post-img figure img' => 'flex: 0 0 {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',

                ],
            ]
        );

        $this->add_responsive_control(
            'mgpg_img_auto_height',
            [
                'label' => __('Image auto height', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('On', 'magical-addons-for-elementor'),
                'label_off' => __('Off', 'magical-addons-for-elementor'),
                'default' => 'yes',
            ]
        );
        $this->add_responsive_control(
            'mgpg_img_height',
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
                    'mgpg_img_auto_height!' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mg-post-img figure img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgpg_imgbg_height',
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
                    'mgpg_img_auto_height!' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mg-post-img figure' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpg_img_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mg-post-img, {{WRAPPER}} .mgp-card .mg-post-img figure img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpg_img_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mg-post-img figure' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mgpg_img_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mg-post-img figure img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'mgpg_img_bgcolor',
                'label' => esc_html__('Background', 'magical-addons-for-elementor'),
                //'types' => [ 'classic', 'gradient' ],

                'selector' => '{{WRAPPER}} .mgp-card .mg-post-img, {{WRAPPER}} .mgp-card .mg-post-img figure img',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpg_img_border',
                'selector' => '{{WRAPPER}} .mgp-card .mg-post-img figure img',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mgpg_title_style',
            [
                'label' => __('posts Title', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgpg_title_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mgp-ptitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpg_title_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mgp-ptitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgpg_title_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-card a.mgp-title-link, .mgp-card .mgp-ptitle' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpg_title_bgcolor',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mgp-ptitle' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpg_descb_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mgp-ptitle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpg_title_typography',
                'selector' => '{{WRAPPER}} .mgp-card .mgp-ptitle',
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mgpg_description_style',
            [
                'label' => __('Description', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgpg_description_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mg-card-text p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpg_description_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mg-card-text p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgpg_description_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mg-card-text p' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpg_description_bgcolor',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mg-card-text p' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpg_description_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card .mg-card-text p' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpg_description_typography',
                'selector' => '{{WRAPPER}} .mgp-card .mg-card-text p',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'mgpg_meta_style',
            [
                'label' => __('Posts Meta', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'mgpg_meta_cat',
            [
                'label' => __('Category style', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'mgpg_category_show' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpg_meta_cat_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-post-cats' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpg_category_show' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpg_meta_cat_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-post-cats' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpg_category_show' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'mgpg_meta_cat_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-post-cats' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'mgpg_category_show' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'mgpg_meta_cat_bgcolor',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-post-cats' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'mgpg_category_show' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpg_meta_cat_typography',
                'selector' => '{{WRAPPER}} .mgp-post-cats',
                'condition' => [
                    'mgpg_category_show' => 'yes',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpg_cat_border',
                'selector' => '{{WRAPPER}} .mgp-post-cats',
                'condition' => [
                    'mgpg_category_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mgpg_cat_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-post-cats' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpg_category_show' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'mgpg_meta_author',
            [
                'label' => __('Posts Author', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'mgpg_author_show' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpg_meta_author_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-meta .mgp-author,{{WRAPPER}} .mgp3-meta .mgp3-author-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpg_author_show' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpg_meta_author_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-meta .mgp-author,{{WRAPPER}} .mgp3-meta .mgp3-author-meta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpg_author_show' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'mgpg_meta_author_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-meta .mgp-author a, {{WRAPPER}} .mgp-meta .mgp-author i,{{WRAPPER}} .mgp3-meta .mgp3-author-meta' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mgp-meta .mgp-author svg' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'mgpg_author_show' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'mgpg_meta_author_bgcolor',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-meta .mgp-author,{{WRAPPER}} .mgp3-meta .mgp3-author-meta' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'mgpg_author_show' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpg_meta_author_typography',
                'selector' => '{{WRAPPER}} .mgp-meta .mgp-author, {{WRAPPER}} .mgp-meta .mgp-author a,{{WRAPPER}} .mgp3-meta .mgp3-author-meta',
                'condition' => [
                    'mgpg_author_show' => 'yes',
                ],
            ]
        );


        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpg_author_border',
                'selector' => '{{WRAPPER}} .mgp-meta .mgp-author,{{WRAPPER}} .mgp3-meta .mgp3-author-meta',
                'condition' => [
                    'mgpg_author_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mgpg_author_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-meta .mgp-author,{{WRAPPER}} .mgp3-meta .mgp3-author-meta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpg_author_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mgpg_meta_date',
            [
                'label' => __('Date Style', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'mgpg_date_show' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpg_meta_date_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-time,{{WRAPPER}} .mgp3-meta .mgp3-date-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpg_date_show' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpg_meta_date_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-time,{{WRAPPER}} .mgp3-meta .mgp3-date-meta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpg_date_show' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'mgpg_meta_date_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-time,{{WRAPPER}} .mgp3-meta .mgp3-date-meta' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mgp-time i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mgp-time svg' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'mgpg_date_show' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'mgpg_meta_date_bgcolor',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-time,{{WRAPPER}} .mgp3-meta .mgp3-date-meta' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'mgpg_date_show' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpg_meta_date_typography',
                'selector' => '{{WRAPPER}} .mgp-time,{{WRAPPER}} .mgp3-meta .mgp3-date-meta',
                'condition' => [
                    'mgpg_date_show' => 'yes',
                ],
            ]
        );


        $this->add_responsive_control(
            'mg_post_gird_date_icon_time_size',
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
                    '{{WRAPPER}} .mgp-time i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mgp-time svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpg_date_border',
                'selector' => '{{WRAPPER}} .mgp-time,{{WRAPPER}} .mgp3-meta .mgp3-date-meta',
                'condition' => [
                    'mgpg_date_show' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mgpg_author_date_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-time,{{WRAPPER}} .mgp3-meta .mgp3-date-meta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpg_date_show' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'mgpg_meta_tag',
            [
                'label' => __('Tags style', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'mgpg_tag_show' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpg_meta_tag_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mpg-tags-links a, {{WRAPPER}} .mpg-tags-links i, {{WRAPPER}} .mpg-tags-links svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'mgpg_tag_show' => 'yes',
                ],
            ]
        );
        $this->add_control(
            'mgpg_meta_tag_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mpg-tags-links a, {{WRAPPER}} .mpg-tags-links i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mpg-tags-links svg' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'mgpg_tag_show' => 'yes',
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'mgpg_btn_style',
            [
                'label' => __('Button', 'magical-addons-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgpg_btn_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card a.mg-card-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpg_btn_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card a.mg-card-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpg_btn_typography',
                'selector' => '{{WRAPPER}} .mgp-card a.mg-card-btn',
            ]
        );


        $this->add_responsive_control(
            'mg_post_gird_button_icon_size',
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
                    '{{WRAPPER}} .mgp-card a.mg-card-btn i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mgp-card a.mg-card-btn svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpg_btn_border',
                'selector' => '{{WRAPPER}} .mgp-card a.mg-card-btn',
            ]
        );

        $this->add_control(
            'mgpg_btn_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card a.mg-card-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpg_btn_box_shadow',
                'selector' => '{{WRAPPER}} .mgp-card a.mg-card-btn',
            ]
        );
        $this->add_control(
            'mgpg_button_color',
            [
                'label' => __('Button color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('mgpg_btn_tabs');

        $this->start_controls_tab(
            'mgpg_btn_normal_style',
            [
                'label' => __('Normal', 'magical-addons-for-elementor'),
            ]
        );

        $this->add_control(
            'mgpg_btn_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .mgp-card a.mg-card-btn' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mgp-card a.mg-card-btn i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mgp-card a.mg-card-btn svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpg_btn_bg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-card a.mg-card-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'mgpg_btn_hover_style',
            [
                'label' => __('Hover', 'magical-addons-for-elementor'),
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mgpg_btnhover_boxshadow',
                'selector' => '{{WRAPPER}} .mgp-card a.mg-card-btn:hover',
            ]
        );

        $this->add_control(
            'mgpg_btn_hcolor',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-card a.mg-card-btn:hover, {{WRAPPER}} .mgp-card a.mg-card-btn:focus' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mgp-card a.mg-card-btn:hover i, {{WRAPPER}} .mgp-card a.mg-card-btn:focus i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mgp-card a.mg-card-btn:hover svg, {{WRAPPER}} .mgp-card a.mg-card-btn:focus svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpg_btn_hbg_color',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mgp-card a.mg-card-btn:hover, {{WRAPPER}} .mgp-card a.mg-card-btn:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mgpg_btn_hborder_color',
            [
                'label' => __('Border Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'condition' => [
                    'mgpg_btn_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .mgp-card a.mg-card-btn:hover, {{WRAPPER}} .mgp-card a.mg-card-btn:focus' => 'border-color: {{VALUE}};',
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
        $args = $this->build_query_args($settings);

        // Define button class based on link type
        $button_class = 'mg-card-btn ' . ($settings['mgpg_link_type'] === 'btn' ? 'mg-btn' : ($settings['mgpg_link_type'] === 'link2' ? 'mg-link2' : 'mg-link'));
        $this->add_render_attribute('mgpg_btn_title', 'class', $button_class);

        // WP Query
        $mgpg_posts = new WP_Query($args);

        if ($mgpg_posts->have_posts()) :
?>
            <div id="mgp-items" class="mgp-items style<?php echo esc_attr($settings['mgpg_post_style']); ?>">
                <div class="row">
                    <?php while ($mgpg_posts->have_posts()) : $mgpg_posts->the_post(); ?>
                        <div class="col-lg-<?php echo esc_attr($settings['mgpg_rownumber']); ?>">
                            <div class="mg-card mg-shadow mgp-card mb-4">
                                <?php $this->render_thumbnail($settings); ?>
                                <div class="mg-card-text">
                                    <?php if ($settings['mgpg_post_style'] != '3') $this->render_category_list($settings); ?>
                                    <?php if ($settings['mgpg_post_style'] == '3') $this->render_post_meta($settings);
                                    ?>
                                    <?php $this->render_post_title($settings); ?>
                                    <?php if ($settings['mgpg_post_style'] == '1') $this->render_post_meta($settings);
                                    ?>
                                    <?php
                                    if ($settings['mgpg_post_style'] == '3') $this->render_category_list($settings); ?>
                                    <?php $this->render_description($settings); ?>
                                    <?php $this->render_button($settings);
                                    ?>
                                    <?php $this->render_tags($settings); ?>
                                    <?php if ($settings['mgpg_post_style'] == '2') $this->render_post_meta($settings); // Style 2 meta at bottom 
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile;
                    wp_reset_postdata(); ?>
                </div>
            </div>
        <?php
        endif;
    }

    // Helper functions

    protected function build_query_args($settings)
    {
        $args = [
            'post_type'           => 'post',
            'post_status'         => 'publish',
            'ignore_sticky_posts' => 1,
            'posts_per_page'      => $settings['mgpg_posts_count'],
        ];

        switch ($settings['mgpg_posts_filter']) {
            case 'featured':
                $args['tax_query'][] = [
                    'taxonomy' => 'product_visibility',
                    'field'    => 'name',
                    'terms'    => 'featured',
                    'operator' => 'IN',
                ];
                break;
            case 'random_order':
                $args['orderby'] = 'rand';
                break;
            case 'show_byid':
                $args['post__in'] = $settings['mgpg_product_id'];
                break;
            case 'show_byid_manually':
                $args['post__in'] = explode(',', $settings['mgpg_product_ids_manually']);
                break;
            default:
                $args['orderby'] = 'date';
                $args['order']   = 'desc';
        }

        if ($settings['mgpg_custom_order'] == 'yes') {
            $args['orderby'] = $settings['orderby'];
            $args['order'] = $settings['order'];
        }

        return $args;
    }

    protected function render_thumbnail($settings)
    {
        if (has_post_thumbnail() && $settings['mgpg_post_img_show'] == 'yes') :
            echo '<div class="mg-card-img mg-post-img"><figure>';
            the_post_thumbnail('full');
            echo '</figure></div>';
        endif;
    }

    protected function render_category_list($settings)
    {
        if ($settings['mgpg_category_show']) :
            $category_type = $settings['mgpg_cat_type'];
            $categories = get_the_category();
            $category_output = $category_type === 'all' ? get_the_category_list(esc_html__('/ ', 'magical-addons-for-elementor')) : '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '">' . esc_html($categories[0]->name) . '</a>';

            if ($category_output) :
                echo '<div class="mgp-cat cat-list grid-meta' . (!has_post_thumbnail() ? ' empty-img' : '') . '">';
                echo '<span class="mgp-post-cats">' . wp_kses_post($category_output) . '</span>';
                echo '</div>';
            endif;

        endif;
    }

    protected function render_post_title($settings)
    {
        if ($settings['mgpg_show_title']) :
            echo '<a class="mgp-title-link" href="' . esc_url(get_the_permalink()) . '">';
            printf('<%1$s class="mgp-ptitle">%2$s</%1$s>', mg_validate_html_tag($settings['mgpg_title_tag'], 'h4'), esc_html(wp_trim_words(get_the_title(), $settings['mgpg_crop_title'])));
            echo '</a>';
        endif;
    }

    protected function render_post_meta($settings)
    {
        // Get author ID and name
        $author_id = get_the_author_meta('ID');
        $author_name = get_the_author();

        // Get post date information
        $year = get_post_time('Y');
        $month = get_post_time('m');
        $day = get_post_time('j');


        $post_style = $settings['mgpg_post_style'];
        if ($post_style == '3') : ?>

            <p class="blog-meta mgp3-meta">
                <i class="las la-user-circle"></i>
                <a class="mgp3-author-meta" href="<?php echo esc_url(get_author_posts_url($author_id)); ?>"
                    class="author-name"
                    title="<?php echo esc_attr(sprintf(
                        // translators: %s is the author name
                        __('View all posts by %s', 'magical-addons-for-elementor'), 
                        $author_name
                    )); ?>">
                    <?php echo esc_html($author_name); ?>
                </a> |
                <i class="las la-calendar-check"></i>
                <a class="mgp3-date-meta" href="<?php echo esc_url(get_day_link($year, $month, $day)); ?>"
                    title="<?php echo esc_attr(get_the_date()); ?>">
                    <?php echo esc_html(get_the_date('d M')); ?>
                </a>
            </p>
<?php
        elseif ($post_style == '2') :
            echo '<div class="mgp-meta mgp-ms2 mt-3 text-right">';
            echo '<div class="row">';
            if ($settings['mgpg_author_show']) :
                echo '<div class="col-auto">' . wp_kses_post(mgp_post_author()) . '</div>';
            endif;
            if ($settings['mgpg_date_show']) :
                echo '<div class="col-auto ml-auto text-right"><span class="mgp-time"><i class="fas fa-clock"></i>' . esc_html(get_the_date('d M Y')) . '</span></div>';
            endif;
            echo '</div></div>';
        else:
            echo '<div class="mgp-meta mb-3">';
            if ($settings['mgpg_author_show']) {
                echo wp_kses_post(mgp_post_author());
            }
            if ($settings['mgpg_date_show']) :
                echo '<span class="mgp-time"><i class="fas fa-calendar-alt"></i>' . esc_html(get_the_date('d M Y')) . '</span>';
            endif;
            echo '</div>';
        endif;
    }

    protected function render_description($settings)
    {
        if ($settings['mgpg_desc_show']) :
            echo '<p>' . esc_html(wp_trim_words(get_the_content(), $settings['mgpg_crop_desc'], '...')) . '</p>';
        endif;
    }

    protected function render_button($settings)
    {
        // Check if the button is enabled
        if (!empty($settings['mgpg_post_btn'])) {
            // Retrieve necessary settings
            $icon_position = !empty($settings['mgpg_btn_icon_position']) ? $settings['mgpg_btn_icon_position'] : 'right';
            $icon = $this->render_elementor_icon($settings['mgpg_btn_icon']); // Use the helper function to safely retrieve the icon
            $button_text = !empty($settings['mgpg_btn_title']) ? mg_kses_tags($settings['mgpg_btn_title']) :  __('Read More', 'magical-addons-for-elementor');
            $button_class = $this->get_render_attribute_string('mgpg_btn_title');

            // Sanitize the button target attribute to prevent XSS
            $button_target = !empty($settings['mgpg_btn_target']) ? esc_attr($settings['mgpg_btn_target']) : '_self';

            // Render the button
            echo '<a href="' . esc_url(get_the_permalink()) . '" target="' . esc_attr($button_target) . '" class="' . esc_attr($button_class) . '">';


            // Add icon to the left if applicable

            if (
                !empty($settings['mgpg_usebtn_icon']) &&
                $settings['mgpg_usebtn_icon'] === 'yes' &&
                $icon_position === 'left' &&
                !empty($icon)
            ) {
                echo '<span class="left">' . wp_kses_post($icon) . '</span>';
            }

            // Add button text
            echo '<span>' . esc_html($button_text) . '</span>';

            // Add icon to the right if applicable
            if (
                !empty($settings['mgpg_usebtn_icon']) &&
                $settings['mgpg_usebtn_icon'] === 'yes' &&
                $icon_position === 'right' &&
                !empty($icon)
            ) {
                echo '<span class="right">' . wp_kses_post($icon) . '</span>';
            }

            echo '</a>';
        }
    }

    /**
     * Helper function to safely render Elementor icons.
     *
     * @param array $icon_settings The icon settings array.
     * @return string The rendered icon HTML or an empty string.
     */
    protected function render_elementor_icon($icon_settings)
    {
        if (empty($icon_settings)) {
            return '';
        }

        // Use output buffering to capture the rendered icon
        ob_start();
        \Elementor\Icons_Manager::render_icon($icon_settings, ['aria-hidden' => 'true']);
        return ob_get_clean();
    }



    protected function render_tags($settings)
    {
        if ($settings['mgpg_tag_show']) :
            $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'magical-addons-for-elementor'));
            if ($tags_list) :
                echo '<span class="mpg-tags-links"><i class="fas fa-tag"></i>' . esc_html(sanitize_text_field($tags_list)) . '</span>';
            endif;
        endif;
    }
}
