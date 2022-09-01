<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Repeater;
use Elementor\Utils;

/**
 * Elementor icon list widget.
 *
 * Elementor widget that displays a bullet list with any chosen icons and texts.
 *
 * @since 1.0.0
 */
class MgAddon_Icon_List extends \Elementor\Widget_Base
{
	use mgProHelpLink;
	/**
	 * Get widget name.
	 *
	 * Retrieve icon list widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name()
	{
		return 'mg-icon-list-widget';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve icon list widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title()
	{
		return esc_html__('MG Iocn List', 'magical-addons-for-elementor');
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve icon list widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon()
	{
		return 'eicon-bullet-list';
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords()
	{
		return ['mg icon list', 'icon', 'list', 'mg list', 'mg'];
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
			'section_icon',
			[
				'label' => esc_html__('Icon List', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'mg_fl_styles',
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
		$this->add_control(
			'view',
			[

				'label' => esc_html__('Layout', 'plugin-name'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'inherit' => [
						'title' => esc_html__('Default', 'magical-addons-for-elementor'),
						'icon' => 'eicon-editor-list-ul',
					],
					'inline-flex' => [
						'title' => esc_html__('Inline', 'magical-addons-for-elementor'),
						'icon' => 'eicon-ellipsis-h',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mg-features-list ul' => 'display: {{VALUE}};',
				],
				'default' => 'inline',
				'toggle' => true,

			]
		);

		$this->add_control(
			'mglc_show_title',
			[
				'label' => __('Show Title?', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'magical-addons-for-elementor'),
				'label_off' => __('No', 'magical-addons-for-elementor'),
				'default' => 'yes',
				'condition' => [
					'mg_fl_styles' => 'style1'
				]
			]
		);
		$this->add_control(
			'mglc_show_sub_title',
			[
				'label' => __('Show Subtitle?', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'magical-addons-for-elementor'),
				'label_off' => __('No', 'magical-addons-for-elementor'),
				'default' => 'yes',
				'condition' => [
					'mg_fl_styles' => 'style1'
				]
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'text',
			[
				'label' => esc_html__('Title', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__('List Item', 'magical-addons-for-elementor'),
				'default' => esc_html__('List Item', 'magical-addons-for-elementor'),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$repeater->add_control(
			'mg_subtitle',
			[
				'label' => esc_html__('Subtitle', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'placeholder' => esc_html__('Subtitle', 'magical-addons-for-elementor'),
				'default' => esc_html__('A title is one or more words used before or after a person name.', 'magical-addons-for-elementor'),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'mglc_icon_type',
			[
				'label' => __('Icon Type', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::CHOOSE,
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
			]
		);


		$repeater->add_control(
			'mglc_type_selected_icon',
			[
				'label' => __('Choose Icon', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'far fa-grin-alt',
					'library' => 'fa-solid',
				],
				'condition' => [
					'mglc_icon_type' => 'icon',
				],
			]
		);


		$repeater->add_control(
			'mglc_img',
			[
				'label' => __('Choose Image', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'mglc_icon_type' => 'image',
				],

			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => esc_html__('Link', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__('https://your-link.com', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'icon_list',
			[
				'label' => esc_html__('Items', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'text' => esc_html__('List Item #1', 'magical-addons-for-elementor'),


					],
					[
						'text' => esc_html__('List Item #2', 'magical-addons-for-elementor'),

					],
					[
						'text' => esc_html__('List Item #3', 'magical-addons-for-elementor'),

					],
				],
				'title_field' => '{{{ text }}}',
			]
		);


		$this->add_responsive_control(
			'mglc_icon_position',
			[
				'label' => __('Icon Position', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'row' => [
						'title' => __('Left', 'magical-addons-for-elementor'),
						'icon' => 'fas fa-arrow-left',
					],
					'row-reverse' => [
						'title' => __('Right', 'magical-addons-for-elementor'),
						'icon' => 'fas fa-arrow-right',
					],

				],
				'default' => 'row',
				'selectors' => [
					'{{WRAPPER}} .mg-lc-single' => 'flex-direction: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'mglc_icon_align',
			[
				'label' => __('Icon Alignment', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => __('Top', 'magical-addons-for-elementor'),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => __('Center', 'magical-addons-for-elementor'),
						'icon' => ' eicon-v-align-middle',
					],
					'flex-end' => [
						'title' => __('Bottom', 'magical-addons-for-elementor'),
						'icon' => ' eicon-v-align-bottom',
					],

				],
				'default' => 'flex-start',
				'selectors' => [
					'{{WRAPPER}} .mg-lc-img,{{WRAPPER}} .mg-ic-list' => 'align-items: {{VALUE}};',
				],

			]
		);



		$this->add_responsive_control(
			'mglc_content_align',
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
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .mg-lc-content' => 'text-align: {{VALUE}};',
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
			'mg_lc_basic_style',
			[
				'label' => __('Basic style', 'magical-addons-for-elementor'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);



		$this->start_controls_tabs('mg_lc_container_style');

		$this->start_controls_tab(
			'mglc_basic_normal_style',
			[
				'label' => __('Normal', 'magical-addons-for-elementor'),
			]
		);
		$this->add_control(
			'mg_lc_normal_content_bg_color',
			[
				'label' => __('Background color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-lc-single' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'mg_lc_normal_content_padding',
			[
				'label' => __('Padding', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-lc-single' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'mg_lc_normal_content_margin',
			[
				'label' => __('Margin', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-lc-single' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'mglc_normal_border',
				'selector' => '{{WRAPPER}} .mg-lc-single',
			],
		);
		$this->add_control(
			'mg_lc_normal_content_border_radius',
			[
				'label' => __('Border Radius', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-lc-single' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'mglc_boxshadow',
				'selector' => '{{WRAPPER}} a.mg-lc-single ',
			]
		);
		$this->end_controls_tab();


		$this->start_controls_tab(
			'mglc_basic_hover_style',
			[
				'label' => __('Hover', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'mg_lc_hover_content_bg_color',
			[
				'label' => __('Background color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-lc-single:hover' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'mglc_hover_boxshadow',
				'selector' => '{{WRAPPER}} a.mg-lc-single:hover',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();


		$this->start_controls_section(
			'section_icon_list',
			[
				'label' => esc_html__('Image And Icon', 'magical-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);




		$this->add_control(
			'mglc_img_width',
			[
				'label' => __('Image Width', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 35,
						'max' => 1000,
						'step' => 1,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .mg-lc-img img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_control(
			'mglc_img_height',
			[
				'label' => __('Image Height', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 35,
						'max' => 1000,
						'step' => 1,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .mg-lc-img img' => 'height: {{SIZE}}{{UNIT}};',
				],

			]
		);


		$this->add_responsive_control(
			'mglc_img_padding',
			[
				'label' => __('Padding', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-lc-img img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'mglc_img_margin',
			[
				'label' => __('Margin', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-lc-img img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->start_controls_tabs('mg_img_tabs');

		$this->start_controls_tab(
			'mg_lc_img_normal_style',
			[
				'label' => __('Normal', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'mglc_imgbg_color',
			[
				'label' => __('Background Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mg-lc-img img' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'mglc_img_border',
				'selector' => '{{WRAPPER}} .mg-lc-img img',
			],


		);


		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'mglc_image_boxshadow',
				'selector' => '{{WRAPPER}} .mg-lc-img img',
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'mg_lc_img_hover_style',
			[
				'label' => __('Hover', 'magical-addons-for-elementor'),
			]
		);
		$this->add_control(
			'mglc_imgbg_hover_color',
			[
				'label' => __('Background Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mg-lc-single:hover .mg-lc-img img' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'mglc_img_hover_border',
				'selector' => '{{WRAPPER}} .mg-lc-single:hover .mg-lc-img img',
			],
		);


		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'mglc_image_hover_boxshadow',
				'selector' => '{{WRAPPER}} .mg-lc-single:hover .mg-lc-img img',
			]
		);


		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'mglc_img_border_radius',
			[
				'label' => __('Border Radius', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-lc-img img' =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);


		$this->add_control(
			'mglc_icon_style',
			[
				'label' => __('Icon', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'mglc_icon_size',
			[
				'label' => __('Icon Size', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 1000,
						'step' => 1,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .mg-ic-list i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'mglc_icon_padding',
			[
				'label' => __('Padding', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-ic-list i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'mglc_icon_margin',
			[
				'label' => __('Margin', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-ic-list' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'mglc_icon_border_radius',
			[
				'label' => __('Border Radius', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-ic-list i' =>  'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);



		$this->start_controls_tabs('mg_icon_tabs');

		$this->start_controls_tab(
			'mg_lc_icon_normal_style',
			[
				'label' => __('Normal', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'mglc_icon_color',
			[
				'label' => __('Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mg-ic-list i' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'mglc_iconbg_color',
			[
				'label' => __('Background Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mg-ic-list i' => 'background-color: {{VALUE}};',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'mglc_icon_border',
				'selector' => '{{WRAPPER}} .mg-ic-list i',
			],


		);


		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'mglc_icon_boxshadow',
				'selector' => '{{WRAPPER}} .mg-ic-list i',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'mg_lc_icon_hover_style',
			[
				'label' => __('Hover', 'magical-addons-for-elementor'),
			]
		);
		$this->add_control(
			'mglc_icon_hover_color',
			[
				'label' => __('Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}  .mg-lc-single:hover .mg-ic-list i' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'mglc_iconbg_hover_color',
			[
				'label' => __('Background Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}  .mg-lc-single:hover .mg-ic-list i' => 'background-color: {{VALUE}};',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'mglc_icon_hover_border',
				'selector' => '{{WRAPPER}}  .mg-lc-single:hover .mg-ic-list i',
			],


		);


		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'mglc_icon_hover_boxshadow',
				'selector' => '{{WRAPPER}}  .mg-lc-single:hover .mg-ic-list i',
			]
		);



		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();



		$this->start_controls_section(
			'mg_section_text_style',
			[
				'label' => esc_html__('Text', 'magical-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'mg_normal_text_color',
			[
				'label' => esc_html__('Text Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mg-lc-title' => 'color: {{VALUE}};',
				],
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
			]
		);

		$this->add_control(
			'mg_text_color_hover',
			[
				'label' => esc_html__('Hover', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mg-lc-single:hover .mg-lc-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'mg_icon_typography',
				'selector' => '{{WRAPPER}} .mg-lc-title',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'selector' => '{{WRAPPER}} .mg-lc-title',
			]
		);

		$this->add_control(
			'mg_lc_subtitle_content',
			[
				'label' => __('Subtitle', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'mg_normal_subtitle_color',
			[
				'label' => esc_html__('Text Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mg-lc-subtitle' => 'color: {{VALUE}};',
				],
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
			]
		);

		$this->add_control(
			'mg_subtitle_color_hover',
			[
				'label' => esc_html__('Hover', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mg-lc-single:hover .mg-lc-subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'mg_subtitle_typography',
				'selector' => '{{WRAPPER}} .mg-lc-subtitle',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'subtitle_shadow',
				'selector' => '{{WRAPPER}} .mg-lc-subtitle',
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
		$settings   = $this->get_settings_for_display();
		$mg_fl_styles = $settings['mg_fl_styles'];
		if ($mg_fl_styles == 'style1') {
			$this->lc_style_base_one($settings);
		} else {
			$this->lc_style_base_two($settings);
		}
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

	public function lc_style_base_one($settings)
	{

		$settings = $this->get_settings_for_display();
		$icon_list = $settings['icon_list'];
		$mglc_show_title = $settings['mglc_show_title'];
		$mglc_show_sub_title = $settings['mglc_show_sub_title'];
?>


		<div class="mg-features-list">
			<ul>
				<?php if ($icon_list) : ?>
					<?php


					foreach ($icon_list as $index => $item) :
						$key1 = $this->get_repeater_setting_key('link', 'icon_list', $index);

						$this->add_render_attribute($key1, 'href', esc_url($item['link']['url']));
						$this->add_render_attribute($key1, 'class', 'mg-lc-single');
						if (!empty($item['link']['is_external'])) {
							$this->add_render_attribute($key1, 'target', '_blank');
						}
						if (!empty($item['link']['nofollow'])) {
							$this->set_render_attribute($key1, 'rel', 'nofollow');
						}


					?>

						<li>
							<a <?php echo $this->get_render_attribute_string($key1); ?>>

								<div class="mg-lc-icon-img">
									<?php if ($item['mglc_icon_type'] == 'image') : ?>
										<div class="mg-lc-img">
											<figure>
												<?php echo Group_Control_Image_Size::get_attachment_image_html($item, 'mglc_img'); ?>
											</figure>
										</div>
									<?php else : ?>
										<div class="mg-ic-list">
											<?php \Elementor\Icons_Manager::render_icon($item['mglc_type_selected_icon']); ?>
										</div>
									<?php endif; ?>
								</div>

								<div class="mg-lc-content">
									<?php if ($mglc_show_title) : ?>
										<span class="mg-lc-title"><?php echo esc_html($item['text']); ?></span>
									<?php endif; ?>
									<?php if ($mglc_show_sub_title) : ?>
										<span class="mg-lc-subtitle"><?php echo esc_html($item['mg_subtitle']); ?></span>
									<?php endif; ?>
								</div>

							</a>

						</li>
					<?php endforeach; ?>
				<?php endif; ?>

			</ul>
		</div>



	<?php
	}

	public function lc_style_base_two($settings)
	{
		$settings = $this->get_settings_for_display();
		$icon_list = $settings['icon_list'];

	?>


		<div class="mg-features-list">
			<ul>
				<?php if ($icon_list) : ?>
					<?php foreach ($icon_list as $item) : ?>
						<li>
							<a href="" class="mg-lc-single">

								<div class="mg-lc-icon-img">
									<?php if ($item['mglc_icon_type'] == 'image') : ?>
										<div class="mg-lc-img">
											<figure>
												<?php echo Group_Control_Image_Size::get_attachment_image_html($item, 'mglc_img'); ?>
											</figure>
										</div>
									<?php else : ?>
										<div class="mg-ic-list">
											<?php \Elementor\Icons_Manager::render_icon($item['mglc_type_selected_icon']); ?>
										</div>
									<?php endif; ?>
								</div>

								<div class="mg-lc-content">
									<span class="mg-lc-subtitle"><?php echo esc_html($item['mg_subtitle']); ?></span>

								</div>

							</a>

						</li>
					<?php endforeach; ?>
				<?php endif; ?>

			</ul>
		</div>



<?php
	}
}
