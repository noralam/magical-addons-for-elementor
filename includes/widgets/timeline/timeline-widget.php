<?php


class MgAddon_Timeline_Widget extends \Elementor\Widget_Base
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
		return 'mgtimeline_widget';
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
		return __('Magical Timeline', 'magical-addons-for-elementor');
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
		return 'eicon-time-line';
	}

	public function get_keywords()
	{
		return ['timeline', 'slider', 'mg'];
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
			'mgtl_content',
			[
				'label' => __('Timeline Content', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'mgtl_title',
			[
				'label'       => __('Title', 'magical-addons-for-elementor'),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'input_type'  => 'text',
				'placeholder' => __('Enter Timeline Title', 'magical-addons-for-elementor'),
				'default'     => __('Timeline Title', 'magical-addons-for-elementor'),
				'label_block'     => true,


			]
		);

		$repeater->add_control(
			'mgtl_desc',
			[
				'label'       => __('Timeline Description', 'magical-addons-for-elementor'),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'input_type'  => 'text',
				'placeholder' => __('Timeline description goes here.', 'magical-addons-for-elementor'),
				'default'     => __('dummy text you can edit or remove it. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempo.', 'magical-addons-for-elementor'),

			]
		);

		$repeater->add_control(
			'mgtl_date',
			[
				'label'       => __('Timeline Date', 'magical-addons-for-elementor'),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'input_type'  => 'text',
				'placeholder' => __('Enter date here.', 'magical-addons-for-elementor'),
				'default'     => __('12-05-2020', 'magical-addons-for-elementor'),

			]
		);
		$this->add_control(
			'mgtl_list',
			[
				'label' => __('Timeline items', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'mgtl_title' => __('Timeline Title one', 'magical-addons-for-elementor'),
						'mgtl_desc' => __('Item content. Click the edit button to change this text.', 'magical-addons-for-elementor'),
						'mgtl_date' => __('25-12-2020', 'magical-addons-for-elementor'),
					],
					[
						'mgtl_title' => __('Timeline Title Two', 'magical-addons-for-elementor'),
						'mgtl_desc' => __('Item content. Click the edit button to change this text.', 'magical-addons-for-elementor'),
						'mgtl_date' => __('25-12-2020', 'magical-addons-for-elementor'),
					],
					[
						'mgtl_title' => __('Timeline Title Three', 'magical-addons-for-elementor'),
						'mgtl_desc' => __('Item content. Click the edit button to change this text.', 'magical-addons-for-elementor'),
						'mgtl_date' => __('25-12-2020', 'magical-addons-for-elementor'),
					],
					[
						'mgtl_title' => __('Timeline Title Four', 'magical-addons-for-elementor'),
						'mgtl_desc' => __('Item content. Click the edit button to change this text.', 'magical-addons-for-elementor'),
						'mgtl_date' => __('25-12-2020', 'magical-addons-for-elementor'),
					],
				],
				'title_field' => '{{{ mgtl_title }}}',

			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'mgtl_content_settings',
			[
				'label' => __('Timeline Content Settings', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'mgtl_title_show',
			[
				'label' => __('Show Timeline title', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'magical-addons-for-elementor'),
				'label_off' => __('No', 'magical-addons-for-elementor'),
				'default' => 'yes',
			]
		);
		$this->add_control(
			'mgtl_desc_show',
			[
				'label' => __('Show Timeline Description', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'magical-addons-for-elementor'),
				'label_off' => __('No', 'magical-addons-for-elementor'),
				'default' => 'yes',
			]
		);
		$this->add_control(
			'mgtl_date_show',
			[
				'label' => __('Show Timeline Date', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'magical-addons-for-elementor'),
				'label_off' => __('No', 'magical-addons-for-elementor'),
				'default' => 'yes',
			]
		);


		$this->add_control(
			'mgtl_title_tag',
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
					'mgtl_title_show' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'mgtl_text_align',
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
				'selectors' => [
					'{{WRAPPER}} .mg-timeline.timeline' => 'text-align: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'mgtl_date_position',
			[
				'label' => __('Date Position', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => __('Top', 'magical-addons-for-elementor'),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __('Middle', 'magical-addons-for-elementor'),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __('Bottom', 'magical-addons-for-elementor'),
						'icon' => 'eicon-v-align-bottom',
					],

				],
				'default' => 'top',

			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'mgtl_settings',
			[
				'label' => __('Timeline Settings', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'mgtl_mod',
			[
				'label' => __('Timeline Mode', 'magical-addons-for-elementor'),
				'description' => __('Choose whether the timeline should be vertical or horizontal.', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'vertical' => __('Vertical', 'magical-addons-for-elementor'),
					'horizontal' => __('Horizontal', 'magical-addons-for-elementor'),
				],
				'default' => 'vertical',
			]
		);
		$this->add_control(
			'mgtl_hs_position',
			[
				'label' => __('Horizontal Start Position', 'magical-addons-for-elementor'),
				'description' => __('Define the vertical alignment of the first item.', 'magical-addons-for-elementor'),

				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'top' => __('Top', 'magical-addons-for-elementor'),
					'bottom' => __('Bottom', 'magical-addons-for-elementor'),
				],
				'default' => 'top',
				'condition' => [
					'mgtl_mod' => 'horizontal',
				],
			]
		);
		$this->add_control(
			'mgtl_hs_startIndex',
			[
				'label' => __('Start Item', 'magical-addons-for-elementor'),
				'description' => __('Define which item the timeline should start. Start index 0', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 20,
				'step' => 1,
				'default' => 0,
				'condition' => [
					'mgtl_mod' => 'horizontal',
				],
			]
		);
		$this->add_control(
			'mgtl_slide_number',
			[
				'label' => __('Move Items', 'magical-addons-for-elementor'),
				'description' => __('Define how many items to move when clicking a navigation button.', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 20,
				'step' => 1,
				'default' => 1,
				'condition' => [
					'mgtl_mod' => 'horizontal',
				],
			]
		);

		$this->add_control(
			'mgtl_vst_position',
			[
				'label' => __('Start Position', 'magical-addons-for-elementor'),
				'description' => __('Define which item the timeline should start.', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'left' => __('Left', 'magical-addons-for-elementor'),
					'right' => __('Right', 'magical-addons-for-elementor'),
				],
				'default' => 'left',
				'condition' => [
					'mgtl_mod' => 'vertical',
				],
			]
		);
		$this->add_control(
			'mgtl_v_trigger',
			[
				'label' => __('vertical Trigger', 'magical-addons-for-elementor'),
				'description' => __('Define the distance from the bottom of the screen, in percent or pixels, that the items slide into view', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 15,
				],
				'condition' => [
					'mgtl_mod' => 'vertical',
				],

			]
		);
		$this->add_control(
			'mgtl_visible_items',
			[
				'label' => __('Horizontal Visible Items', 'magical-addons-for-elementor'),
				'description' => __('Define how many items are visible in the viewport.', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 20,
				'step' => 1,
				'default' => 3,
				'condition' => [
					'mgtl_mod' => 'horizontal',
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
			'mgtl_basic_style',
			[
				'label' => __('Basic style', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'mgtl_content_padding',
			[
				'label' => __('Timeline Content Padding', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-timeline .timeline__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'mgtl_content_margin',
			[
				'label' => __('Timeline Content Margin', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-timeline .timeline__content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'mgtl_content_bg_color',
			[
				'label' => __('Content Background color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-timeline .timeline__content' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .timeline--horizontal .timeline__item--top .timeline__content:after' => 'border-top:10px solid {{VALUE}};',
					'{{WRAPPER}} .timeline--horizontal .timeline__item--bottom .timeline__content:after' => 'border-bottom:10px solid {{VALUE}};',
					'{{WRAPPER}} .timeline__item--right .timeline__content:after' => 'border-right:11px solid {{VALUE}};',
					'{{WRAPPER}} .timeline__item--left .timeline__content:after' => 'border-left:11px solid {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'mgtl_content_border_color',
			[
				'label' => __('Content border color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-timeline .timeline__content' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .timeline--horizontal .timeline__item--top .timeline__content:before' => 'border-top:10px solid {{VALUE}};',
					'{{WRAPPER}} .timeline--horizontal .timeline__item--bottom .timeline__content:before' => 'border-bottom:10px solid {{VALUE}};',
					'{{WRAPPER}} .timeline__item--left .timeline__content:before' => 'border-left:12px solid {{VALUE}};',
					'{{WRAPPER}} .timeline__item--right .timeline__content:before' => 'border-right:12px solid {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'mgtl_content_border_radius',
			[
				'label' => __('Border Radius', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-timeline .timeline__content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'mgtl_title_style',
			[
				'label' => __('Timeline Title', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'mgtl_title_show' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'mgtl_title_padding',
			[
				'label' => __('Padding', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mgt-head' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'mgtl_title_margin',
			[
				'label' => __('Margin', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mgt-head' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'mgtl_title_color',
			[
				'label' => __('Text Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mgt-head' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'mgtl_title_bgcolor',
			[
				'label' => __('Background Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mgt-head' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'mgtl_descb_radius',
			[
				'label' => __('Border Radius', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .mgt-head' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'mgtl_title_typography',
				'selector' => '{{WRAPPER}} .mgt-head',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'mgtl_description_style',
			[
				'label' => __('Timeline Description', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'mgtl_desc_show' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'mgtl_description_padding',
			[
				'label' => __('Padding', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mgt-content p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'mgtl_description_margin',
			[
				'label' => __('Margin', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mgt-content p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'mgtl_description_color',
			[
				'label' => __('Text Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mgt-content p' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'mgtl_description_bgcolor',
			[
				'label' => __('Background Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mgt-content p' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'mgtl_description_radius',
			[
				'label' => __('Border Radius', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .mgt-content p' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'mgtl_description_typography',
				'selector' => '{{WRAPPER}} .mgt-content p',
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'mgtl_date_style',
			[
				'label' => __('Timeline Date', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'mgtl_date_show' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'mgtl_date_padding',
			[
				'label' => __('Padding', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mgt-time span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'mgtl_date_margin',
			[
				'label' => __('Margin', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mgt-time span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'mgtl_date_color',
			[
				'label' => __('Text Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mgt-time span' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'mgtl_date_bgcolor',
			[
				'label' => __('Background Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mgt-time span' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'mgtl_date_radius',
			[
				'label' => __('Border Radius', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .mgt-time span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'mgtl_date_typography',
				'selector' => '{{WRAPPER}} .mgt-time span',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'mgtl_extra_style',
			[
				'label' => __('Timeline Extra', 'magical-addons-for-elementor'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'mgtl_divider_color',
			[
				'label' => __('Timeline Divider Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .timeline--horizontal .timeline-divider,.timeline:not(.timeline--horizontal):before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .timeline__item:after' => 'border-color: {{VALUE}};',
				],
			]
		);


		$this->start_controls_tabs(
			'mgtl_btn_tabs',
			[
				'label' => __('Button color', 'magical-addons-for-elementor'),
				'condition' => [
					'mgtl_mod' => 'horizontal',
				],
			]

		);

		$this->start_controls_tab(
			'mgtl_btn_normal_style',
			[
				'label' => __('Normal', 'magical-addons-for-elementor'),

			]
		);

		$this->add_control(
			'mgtl_btn_bg_color',
			[
				'label' => __('Background Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .timeline-nav-button' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'mgtl_btn_border_color',
			[
				'label' => __('Border Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .timeline-nav-button' => 'border-color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab(
			'mgtl_btn_hover_style',
			[
				'label' => __('Hover', 'magical-addons-for-elementor'),
			]
		);


		$this->add_control(
			'mgtl_btn_hbg_color',
			[
				'label' => __('Background Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .timeline-nav-button:hover, {{WRAPPER}} .timeline-nav-button:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mgtl_btn_hborder_color',
			[
				'label' => __('Border Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .timeline-nav-button:hover, {{WRAPPER}} .timeline-nav-button:focus' => 'border-color: {{VALUE}};',
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
		$mgtl_title_show = $this->get_settings('mgtl_title_show');
		$mgtl_desc_show = $this->get_settings('mgtl_desc_show');
		$mgtl_date_show = $this->get_settings('mgtl_date_show');
		$mgtl_title_tag = $this->get_settings('mgtl_title_tag');
		$mgtl_date_position = $this->get_settings('mgtl_date_position');
		$mgtl_list = $this->get_settings('mgtl_list');

		// social list item
		$mgtl_mod = $this->get_settings('mgtl_mod');



?>

		<?php
		if ($mgtl_mod == 'horizontal') :
			$mgtl_hs_position = $this->get_settings('mgtl_hs_position');
			$mgtl_hs_startIndex = $this->get_settings('mgtl_hs_startIndex');
			$mgtl_slide_number = $this->get_settings('mgtl_slide_number');
			$mgtl_visible_items = $this->get_settings('mgtl_visible_items');

		?>
			<div class="mg-timeline timeline" data-mode="horizontal" <?php if ($mgtl_hs_position == 'bottom') : ?>data-horizontal-start-position="bottom" <?php endif; ?><?php if ($mgtl_hs_startIndex != '0') : ?> data-start-index="<?php echo esc_attr($mgtl_hs_startIndex); ?>" <?php endif; ?><?php if ($mgtl_slide_number != '1') : ?> data-move-items="<?php echo esc_attr($mgtl_slide_number); ?>" <?php endif; ?><?php if ($mgtl_visible_items != '4') : ?> data-visible-items="<?php echo esc_attr($mgtl_visible_items); ?>" <?php endif; ?>>
			<?php
		else :
			$mgtl_vst_position = $this->get_settings('mgtl_vst_position');
			$mgtl_v_trigger = $this->get_settings('mgtl_v_trigger');

			?>
				<div class="mg-timeline timeline" data-mode="vertical" <?php if ($mgtl_vst_position == 'right') : ?>data-vertical-start-position="right" <?php endif; ?> <?php if ($mgtl_v_trigger['size'] != '15' || $mgtl_v_trigger['unit'] != '15') : ?> data-vertical-trigger="<?php echo esc_attr($mgtl_v_trigger['size']); ?><?php echo esc_attr($mgtl_v_trigger['unit']); ?>" <?php endif; ?>>
				<?php endif; ?>

				<div class="timeline__wrap">
					<div class="timeline__items">
						<?php
						if ($mgtl_list) :
							foreach ($mgtl_list as $index => $value) :
								$key1 = $this->get_repeater_setting_key('mgtl_title', 'mgtl_list', $index);
								$key2 = $this->get_repeater_setting_key('mgtl_desc', 'mgtl_list', $index);
								$key3 = $this->get_repeater_setting_key('mgtl_date', 'mgtl_list', $index);
								$this->add_inline_editing_attributes($key1);
								$this->add_inline_editing_attributes($key2);
								$this->add_inline_editing_attributes($key3);
								$this->add_render_attribute($key1, 'class', 'mgt-head');


						?>
								<div class="timeline__item">
									<div class="timeline__content">
										<?php if ($value['mgtl_date'] && $mgtl_date_show == 'yes' && $mgtl_date_position == 'top') : ?>
											<div class="mgt-time"><span <?php echo $this->get_render_attribute_string($key3); ?>><?php echo mg_kses_tags($value['mgtl_date']); ?></span></div>
										<?php endif; ?>

										<?php
										if ($value['mgtl_title'] && $mgtl_title_show == 'yes') :
											printf(
												'<%1$s %2$s>%3$s</%1$s>',
												tag_escape($mgtl_title_tag),
												$this->get_render_attribute_string($key1),
												mg_kses_tags($value['mgtl_title'])
											);
										endif;
										?>
										<?php if ($value['mgtl_date'] && $mgtl_date_show == 'yes' && $mgtl_date_position == 'middle') : ?>
											<div class="mgt-time"><span <?php echo $this->get_render_attribute_string($key3); ?>><?php echo mg_kses_tags($value['mgtl_date']); ?></span></div>
										<?php endif; ?>
										<?php if ($value['mgtl_desc'] && $mgtl_desc_show == 'yes') : ?>
											<div class="mgt-content">
												<p <?php echo $this->get_render_attribute_string($key2); ?>><?php echo wp_kses_post($value['mgtl_desc']); ?></p>
											</div>
										<?php endif; ?>
										<?php if ($value['mgtl_date'] && $mgtl_date_show == 'yes' && $mgtl_date_position == 'bottom') : ?>
											<div class="mgt-time"><span <?php echo $this->get_render_attribute_string($key3); ?>><?php echo mg_kses_tags($value['mgtl_date']); ?></span></div>
										<?php endif; ?>
									</div>
								</div>
						<?php
							endforeach;
						endif;
						?>


					</div>
				</div>
				</div>



		<?php
	}
}
