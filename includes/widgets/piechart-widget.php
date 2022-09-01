<?php

use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;

class MG_AddonPieChart extends \Elementor\Widget_Base
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
        return 'mgpiechart_widget';
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
        return __('Mg PieChart', 'magical-addons-for-elementor');
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
        return 'eicon-undo';
    }

    public function get_keywords()
    {
        return ['piechart', 'chart', 'counter'];
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
        return ['snap-svg', 'mgpiechart', 'listtopie-active'];
    }
    /*
    public function get_style_depends()
    {
        return ['mgpiechart-css'];
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
            'mg_imghvr_section',
            [
                'label' => __('Pie Chart', 'magical-addons-for-elementor'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'pchart_title',
            [
                'label' => esc_html__('Item Name', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('Demo Item', 'magical-addons-for-elementor'),
            ]
        );
        $repeater->add_control(
            'pchart_percentage',
            [
                'label' => esc_html__('Percentage Number', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('25', 'magical-addons-for-elementor'),

            ]
        );

        $repeater->add_control(
            'pchart_color',
            [
                'label' => esc_html__('Item Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#008312',
            ]
        );

        $this->add_control(
            'mgpchart',
            [
                'label' => esc_html__('Pie chart Items', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'pchart_title' => esc_html__('Item #1', 'magical-addons-for-elementor'),
                        'pchart_percentage' => esc_html__('15', 'magical-addons-for-elementor'),
                        'pchart_color' => '#01008c',
                    ],
                    [
                        'pchart_title' => esc_html__('Item #2', 'magical-addons-for-elementor'),
                        'pchart_percentage' => esc_html__('35', 'magical-addons-for-elementor'),
                        'pchart_color' => '#3a6b34',
                    ],
                    [
                        'pchart_title' => esc_html__('Item #3', 'magical-addons-for-elementor'),
                        'pchart_percentage' => esc_html__('30', 'magical-addons-for-elementor'),
                        'pchart_color' => '#ee4e34',
                    ],
                    [
                        'pchart_title' => esc_html__('Item #4', 'magical-addons-for-elementor'),
                        'pchart_percentage' => esc_html__('25', 'magical-addons-for-elementor'),
                        'pchart_color' => '#d13ca4',
                    ],
                ],
                'title_field' => '{{{ pchart_title }}}',
            ]
        );


        $this->end_controls_section();
        $this->start_controls_section(
            'mgpyc_content',
            [
                'label' => __('Content', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mgpyc_show_title',
            [
                'label' => esc_html__('Show Title', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'your-plugin'),
                'label_off' => esc_html__('Hide', 'your-plugin'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mgpyc_title',
            [
                'label'       => __('Title', 'magical-addons-for-elementor'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'input_type'  => 'text',
                'placeholder' => __('Enter Card Title', 'magical-addons-for-elementor'),
                'default'     => __('Magical PieChart', 'magical-addons-for-elementor'),
                'label_block'     => true,
                'condition' => [
                    'mgpyc_show_title' => 'yes',
                ],

            ]
        );
        $this->add_control(
            'mgpyc_title_tag',
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
                    'mgpyc_show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mgpyc_show_list',
            [
                'label' => esc_html__('Show Item List', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'your-plugin'),
                'label_off' => esc_html__('Hide', 'your-plugin'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'mgpyc_show_cbox',
            [
                'label' => esc_html__('Show Item Color Box', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'your-plugin'),
                'label_off' => esc_html__('Hide', 'your-plugin'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_responsive_control(
            'mgpyc_text_align',
            [
                'label' => __('Alignment', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'row' => [
                        'title' => __('Left', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'row-reverse' => [
                        'title' => __('Right', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-text-align-right',
                    ],

                ],
                'default' => 'row',
                'selectors' => [
                    '{{WRAPPER}} .mgpchart-base' => 'flex-flow: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpyc_position',
            [
                'label' => __('Content Position', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __('Top', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-arrow-up',
                    ],
                    'center' => [
                        'title' => __('Middle', 'magical-addons-for-elementor'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => __('Bottom', 'magical-addons-for-elementor'),
                        'icon' => ' eicon-arrow-down',
                    ],

                ],
                'default' => 'flex-start',
                'selectors' => [
                    '{{WRAPPER}} .mgpchart-base' => 'align-items: {{VALUE}};',
                ],

            ]
        );
        $this->add_control(
            'mgpyc_cwidth',
            [
                'label' => esc_html__('Items Width', 'magical-addons-for-elementor'),
                'description' => esc_html__('PieChart Height & width will be fixed after reload the page.', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ul.mgpchart-name' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'mgpyc_options',
            [
                'label' => __('Options', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'mgpyc_strokecolor',
            [
                'label' => __('Stroke Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
            ]
        );
        $this->add_control(
            'mgpyc_hoverbordercolor',
            [
                'label' => __('Hover Border Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
            ]
        );
        $this->add_control(
            'mgpyc_show_infotext',
            [
                'label' => __('Show Hover Info Text?', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'return_value' => 1,
                'default' => 1,

            ]
        );
        $this->add_control(
            'mgpyc_show_percent',
            [
                'label' => __('Show percentage?', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'magical-addons-for-elementor'),
                'label_off' => __('No', 'magical-addons-for-elementor'),
                'return_value' => 1,
                'default' => 1,
                'condition' => [
                    'mgpyc_show_infotext!' => '',
                ],
            ]
        );

        $this->add_control(
            'mgpyc_textcolor',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000',
            ]
        );
        $this->add_control(
            'mgpyc_txtsize',
            [
                'label' => esc_html__('Text Size', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 5,
                'max' => 100,
                'step' => 1,
                'default' => 12,
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
            'mgpyc_card_details_style',
            [
                'label' => __('Title Style', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'mgpyc_show_title' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'mgpyc_title_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-pchart .mgpy-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpyc_title_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-pchart .mgpy-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgpyc_title_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-pchart .mgpy-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpyc_title_bgcolor',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mg-pchart .mgpy-title' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpyc_descb_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mg-pchart .mgpy-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpyc_title_typography',
                'selector' => '{{WRAPPER}} .mg-pchart .mgpy-title',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'mgtm_card_items_style',
            [
                'label' => __('Items List', 'magical-addons-for-elementor'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'mgpyc_items_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} ul.mgpchart-name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpyc_items_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} ul.mgpchart-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'mgpyc_items_color',
            [
                'label' => __('Text Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ul.mgpchart-name li' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpyc_items_bgcolor',
            [
                'label' => __('Background Color', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ul.mgpchart-name li' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'mgpyc_items_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} ul.mgpchart-name li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mgpyc_items_typography',
                'label' => __('Typography', 'magical-addons-for-elementor'),
                'selector' => '{{WRAPPER}} ul.mgpchart-name li',
            ]
        );
        $this->add_control(
            'mgpyc_item',
            [
                'type' => \Elementor\Controls_Manager::HEADING,
                'label' => __('Single Item', 'magical-addons-for-elementor'),
                'separator' => 'before'
            ]
        );
        $this->add_responsive_control(
            'mgpyc_item_padding',
            [
                'label' => __('Padding', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} ul.mgpchart-name li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgpyc_item_margin',
            [
                'label' => __('Margin', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} ul.mgpchart-name li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mgpyc_item_border',
                'selector' => '{{WRAPPER}} ul.mgpchart-name li'

            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'mgbtn_colorbox',
            [
                'label' => __('Color Box', 'magical-addons-for-elementor'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'mgpyc_show_cbox' => 'yes',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgbtn_colorbox_width',
            [
                'label' => __('Color Box Width', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .mgpchart-base span.mgpc-box' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'mgbtn_colorbox_height',
            [
                'label' => __('Color Box Height', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .mgpchart-base span.mgpc-box' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_control(
            'mghvrcard_btn_border_radius',
            [
                'label' => __('Border Radius', 'magical-addons-for-elementor'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .mgpchart-base span.mgpc-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mghvrcard_btn_box_shadow',
                'selector' => '{{WRAPPER}} .mgpchart-base span.mgpc-box',
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

        //card name
        $mgpchart = $this->get_settings('mgpchart');
        $mgpyc_show_title = $this->get_settings('mgpyc_show_title');
        $mgpyc_title = $this->get_settings('mgpyc_title');
        $mgpyc_title_tag = $this->get_settings('mgpyc_title_tag');
        $this->add_render_attribute('mgpyc_title', 'class', 'mgpy-title');

        /* Options items*/
        $strokecolor = $this->get_settings('mgpyc_strokecolor');
        $hoverbordercolor = $this->get_settings('mgpyc_hoverbordercolor');
        $mgpyc_show_percent = $this->get_settings('mgpyc_show_percent');
        $mgpyc_show_infotext = $this->get_settings('mgpyc_show_infotext');
        $mgpyc_textcolor = $this->get_settings('mgpyc_textcolor');
        $mgpyc_txtsize = $this->get_settings('mgpyc_txtsize');


?>

        <div class="mg-pchart">
            <?php
            if ($mgpyc_show_title && $mgpyc_title) :
                printf(
                    '<%1$s %2$s>%3$s</%1$s>',
                    tag_escape($mgpyc_title_tag),
                    $this->get_render_attribute_string('mgpyc_title'),
                    mg_kses_tags($mgpyc_title)
                );
            endif;
            ?>
            <?php if ($mgpchart) : ?>
                <div class="mgpchart-base">
                    <?php if ($settings['mgpyc_show_list']) : ?>
                        <ul class="mgpchart-name">
                            <?php foreach ($mgpchart as $item) : ?>
                                <li>
                                    <?php if ($settings['mgpyc_show_cbox']) : ?>
                                        <span style="background:<?php echo esc_attr($item['pchart_color']); ?>" class="mgpc-box"></span>
                                    <?php endif; ?>
                                    <?php echo esc_html($item['pchart_title']); ?>
                                </li>
                            <?php endforeach; ?>

                        </ul>
                    <?php endif; ?>
                    <div class="mg-pstatic" data-strokecolor="<?php echo esc_attr($strokecolor); ?>" data-hvborderc="<?php echo esc_attr($hoverbordercolor); ?>" data-percent="<?php echo esc_attr($mgpyc_show_percent); ?>" data-infotext="<?php echo esc_attr($mgpyc_show_infotext); ?>" data-textcolor="<?php echo esc_attr($mgpyc_textcolor); ?>" data-textsize="<?php echo esc_attr($mgpyc_txtsize); ?>">
                        <?php foreach ($mgpchart as $item) : ?>
                            <div data-lcolor="<?php echo esc_attr($item['pchart_color']); ?>"><?php echo esc_html($item['pchart_percentage']); ?></div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>


<?php


    }
}
