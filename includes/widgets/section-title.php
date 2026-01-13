<?php


class MgAddonSectionTitle extends \Elementor\Widget_Base
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
		return 'mgsectiontitle';
	}
	public function get_keywords()
	{
		return ['header', 'title', 'section', 'mg'];
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
		return __('MG Section Title', 'magical-addons-for-elementor');
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
		return 'eicon-site-title';
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
			'content_section',
			[
				'label' => __('Section Title', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'mgsec_title',
			[
				'label'       => __('Title', 'magical-addons-for-elementor'),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'input_type'  => 'text',
				'label_block'  => true,
				'placeholder' => __('Enter Section Title', 'magical-addons-for-elementor'),
				'default'     => __('Section title', 'magical-addons-for-elementor'),
			]
		);
		$this->add_control(
			'mgsectitle_tag',
			[
				'label' => __('HTML Tag', 'magical-addons-for-elementor'),
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
			]
		);

		$this->add_control(
			'mgsec_subtitle_show',
			[
				'label' => __('Show Subtitle?', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'magical-addons-for-elementor'),
				'label_off' => __('No', 'magical-addons-for-elementor'),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'mgsec_subtitle',
			[
				'label'       => __('Subtitle', 'magical-addons-for-elementor'),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'input_type'  => 'text',
				'label_block'  => true,
				'placeholder' => __('Enter subtitle', 'magical-addons-for-elementor'),
				'default'     => __('Section Subtitle', 'magical-addons-for-elementor'),
				'condition' => [
					'mgsec_subtitle_show' => 'yes',
				],
			]
		);
		$this->add_control(
			'mgsecsub_position',
			[
				'label' => __('Subtitle Position', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'default' => 'top',
				'options' => [
					'top' => [
						'title' => __('Top', 'magical-addons-for-elementor'),
						'icon' => 'eicon-arrow-up',
					],
					'bottom' => [
						'title' => __('Bottom', 'magical-addons-for-elementor'),
						'icon' => 'eicon-arrow-down',
					],

				],
				'toggle' => false,
				'condition' => [
					'mgsec_subtitle_show' => 'yes',
				],
			]
		);
		$this->add_control(
			'mgsecdesc_show',
			[
				'label' => __('Show Description?', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'magical-addons-for-elementor'),
				'label_off' => __('No', 'magical-addons-for-elementor'),
				'default' => '',
			]
		);

		$this->add_control(
			'mgsec_desc',
			[
				'label'       => __('Description', 'magical-addons-for-elementor'),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'placeholder' => __('Enter Section Title', 'magical-addons-for-elementor'),
				'default'     => __('Section title description goes here.', 'magical-addons-for-elementor'),
				'condition' => [
					'mgsecdesc_show' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'mgsectitle_align',
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
					'justify' => [
						'title' => __('Justified', 'magical-addons-for-elementor'),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => 'center',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'mgsecborder_show',
			[
				'label' => __('Show Extra border or image?', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'magical-addons-for-elementor'),
				'label_off' => __('No', 'magical-addons-for-elementor'),
				'default' => '',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'mgsecborder',
			[
				'label' => __('Extra Borders or image', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'mgsecborder_show' => 'yes',
				],
			]
		);
		$this->add_control(
			'mgsecborder_type',
			[
				'label' => __('Border Type', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'border' => [
						'title' => __('Border', 'magical-addons-for-elementor'),
						'icon' => 'eicon-info-circle-o',
					],
					'image' => [
						'title' => __('Image', 'magical-addons-for-elementor'),
						'icon' => 'eicon-image-bold',
					],

				],
				'default' => 'border',
				'toggle' => true,
			]
		);
		$this->add_control(
			'mgsec_image',
			[
				'label' => __('Choose Image', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'condition' => [
					'mgsecborder_type' => 'image',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' => 'mgsec_thumbnail',
				'default' => 'thumbnail',
				'separator' => 'none',
				'exclude' => [
					'full',
					'custom',
					'large',
					'shop_catalog',
					'shop_single',
					'shop_thumbnail'
				],
				'condition' => [
					'mgsecborder_type' => 'image'
				]
			]
		);
		$this->add_control(
			'mgsecborder_position',
			[
				'label' => __('Position', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'default' => 'bottom',
				'options' => [
					'top' => [
						'title' => __('Top', 'magical-addons-for-elementor'),
						'icon' => 'eicon-arrow-up',
					],
					'bottom' => [
						'title' => __('Bottom', 'magical-addons-for-elementor'),
						'icon' => 'eicon-arrow-down',
					],

				],
				'toggle' => false,


			]
		);
		$this->add_responsive_control(
			'mgsecborder_1width',
			[
				'label' => __('1st Border Width', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mgsb .mgsb1' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'mgsecborder_type' => 'border'
				]

			]
		);

		$this->add_responsive_control(
			'mgsecborder_1height',
			[
				'label' => __('1st Border Height', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mgsb .mgsb1' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'mgsecborder_type' => 'border'
				]

			]
		);
		$this->add_control(
			'mgsecborder_2nd_show',
			[
				'label' => __('Show 2nd border', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'magical-addons-for-elementor'),
				'label_off' => __('No', 'magical-addons-for-elementor'),
				'default' => 'yes',
				'condition' => [
					'mgsecborder_type' => 'border'
				]
			]
		);
		$this->add_responsive_control(
			'mgsecborder_2width',
			[
				'label' => __('2nd Border Width', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}}  .mgsb .mgsb2' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'mgsecborder_2nd_show' => 'yes',
					'mgsecborder_type' => 'border'
				]
			]
		);

		$this->add_responsive_control(
			'mgsecborder_2height',
			[
				'label' => __('2nd Border Height', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}}  .mgsb .mgsb2' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'mgsecborder_2nd_show' => 'yes',
					'mgsecborder_type' => 'border'
				]
			]
		);
		$this->add_control(
			'mgsecborder_3rd_show',
			[
				'label' => __('Show 3rd border', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'magical-addons-for-elementor'),
				'label_off' => __('No', 'magical-addons-for-elementor'),
				'default' => 'yes',
				'condition' => [
					'mgsecborder_type' => 'border'
				]
			]
		);
		$this->add_responsive_control(
			'mgsecborder_3width',
			[
				'label' => __('3rd Border Width', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}}  .mgsb .mgsb3' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'mgsecborder_3rd_show' => 'yes',
					'mgsecborder_type' => 'border'
				]
			]
		);

		$this->add_responsive_control(
			'mgsecborder_3height',
			[
				'label' => __('3nd Border Height', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}}  .mgsb .mgsb3' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'mgsecborder_3rd_show' => 'yes',
					'mgsecborder_type' => 'border'
				]
			]
		);
		$this->add_responsive_control(
			'mgsectitle_balign',
			[
				'label' => __('Border Alignment', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => __('Left', 'magical-addons-for-elementor'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __('Center', 'magical-addons-for-elementor'),
						'icon' => 'eicon-text-align-center',
					],
					'end' => [
						'title' => __('Right', 'magical-addons-for-elementor'),
						'icon' => 'eicon-text-align-right',
					],

				],
				'default' => 'center',
				'toggle' => false,

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
			'mgsec_sub_title_style',
			[
				'label' => __('Subtitle style', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'mgsec_subtitle_show' => 'yes',
				],
			]
		);

		$this->add_control(
			'mgsecsubt_color',
			[
				'label'     => __('Subtitle Color', 'magical-addons-for-elementor'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mgsec-title-wrap .mgsec-subtitle' => 'color: {{VALUE}}'
				]
			]
		);

		$this->add_control(
			'mgsecsubt_bgcolor',
			[
				'label'     => __('Subtitle Background Color', 'magical-addons-for-elementor'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mgsec-title-wrap .mgsec-subtitle' => 'background-color: {{VALUE}}'
				]
			]
		);
		$this->add_responsive_control(
			'mgsecsubt_padding',
			[
				'label' => __('SubTitle padding', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mgsec-title-wrap .mgsec-subtitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'mgsecsubt_marbottom',
			[
				'label' => __('Subtitle Margin Bottom', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mgsec-title-wrap .mgsec-subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],

			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'mgsecsubt_typography',
				'selector' => '{{WRAPPER}} .mgsec-title-wrap .mgsec-subtitle',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'mgsecsubt_border',
				'selector' => '{{WRAPPER}} .mg-infobox-img img, {{WRAPPER}} .mgsec-title-wrap .mgsec-subtitle'

			]
		);
		$this->add_control(
			'mgsecsubt_extra_line',
			[
				'type' => \Elementor\Controls_Manager::HEADING,
				'label' => __('Subtitle Extra Line', 'magical-addons-for-elementor'),
				'separator' => 'before'
			]
		);
		$this->add_control(
			'mgsecsubt_exline_show',
			[
				'label' => __('Extra Line Show?', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'magical-addons-for-elementor'),
				'label_off' => __('No', 'magical-addons-for-elementor'),
				'return_value' => 'yes',
				'default' => '',
			]
		);
		$this->add_responsive_control(
			'mgsecsubt_exline_height',
			[
				'label' => __('Extra Line Height', 'magical-addons-for-elementor'),
				'type' =>  \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', '%', 'rem'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 50,
					],
				],
				'condition' => [
					'mgsecsubt_exline_show' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .mgsec-subtitle-exline span:before' => 'height: {{SIZE}}{{UNIT}};'
				],

			]
		);
		$this->add_responsive_control(
			'mgsecsubt_exline_width',
			[
				'label' => __('Extra Line Width', 'magical-addons-for-elementor'),
				'type' =>  \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', '%', 'rem'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'condition' => [
					'mgsecsubt_exline_show' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .mgsec-subtitle-exline span:before' => 'width: {{SIZE}}{{UNIT}};'
				],

			]
		);
		$this->add_responsive_control(
			'mgsecsubt_exline_topbottom',
			[
				'label' => __(' Top Bottom Position', 'magical-addons-for-elementor'),
				'type' =>  \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', '%', 'rem'],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
					],
				],
				'condition' => [
					'mgsecsubt_exline_show' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .mgsec-subtitle-exline span:before' => 'top: {{SIZE}}{{UNIT}};'
				],

			]
		);
		$this->add_responsive_control(
			'mgsecsubt_exline_leftright',
			[
				'label' => __('Right Left Position', 'magical-addons-for-elementor'),
				'type' =>  \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', '%', 'rem'],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
					],
				],
				'condition' => [
					'mgsecsubt_exline_show' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .mgsec-subtitle-exline span:before' => 'left: {{SIZE}}{{UNIT}};'
				],

			]
		);
		$this->add_control(
			'mgsecsubt_exline_color',
			[
				'label'     => __('Extra Line Color', 'magical-addons-for-elementor'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mgsec-subtitle-exline span:before' => 'background: {{VALUE}}'
				]
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'mgsec_title_style',
			[
				'label' => __('Title style', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'mgsectitle_color',
			[
				'label'     => __('Title Color', 'magical-addons-for-elementor'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mgsec-title-wrap .mgsec-title' => 'color: {{VALUE}}'
				]
			]
		);

		$this->add_control(
			'mgsectitle_bgcolor',
			[
				'label'     => __('Title Background Color', 'magical-addons-for-elementor'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mgsec-title-wrap .mgsec-title' => 'background-color: {{VALUE}}'
				]
			]
		);
		$this->add_responsive_control(
			'mgsectitle_padding',
			[
				'label' => __('Title padding', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mgsec-title-wrap .mgsec-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'mgsectitle_marbottom',
			[
				'label' => __('Title Margin Bottom', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mgsec-title-wrap .mgsec-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],

			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'mgsectitle_typography',
				'selector' => '{{WRAPPER}} .mgsec-title-wrap .mgsec-title',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'mgsec_desc_style',
			[
				'label' => __('Description style', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'mgsecdesc_show' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'mgsecdesc_padding',
			[
				'label' => __('Description padding', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mgsec-title-wrap .mgsec-desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'mgsecdesc_color',
			[
				'label'     => __('Description text Color', 'magical-addons-for-elementor'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ccc',
				'selectors' => [
					'{{WRAPPER}} .mgsec-title-wrap .mgsec-desc' => 'color: {{VALUE}}'
				]
			]
		);

		$this->add_control(
			'mgsecdesc_bgcolor',
			[
				'label'     => __('Description Background Color', 'magical-addons-for-elementor'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mgsec-title-wrap .mgsec-desc' => 'background-color: {{VALUE}}'
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'mgsecdesc_typography',
				'selector' => '{{WRAPPER}} .mgsec-title-wrap .mgsec-desc',
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'mgsec_tborder_style',
			[
				'label' => __('Extra Border', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'mgsecborder_show' => 'yes',
				],

			]
		);
		$this->add_responsive_control(
			'mgsec_image_width',
			[
				'label' => __('Image Width', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 400,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mgsimg img' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'mgsecborder_type' => 'image'
				]

			]
		);

		$this->add_responsive_control(
			'mgsec_image_height',
			[
				'label' => __('Image Height', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 400,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mgsimg img' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'mgsecborder_type' => 'image'
				]

			]
		);
		$this->add_responsive_control(
			'mgsec_img_margin',
			[
				'label' => __('Image margin', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mgsimg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'mgsecborder_type' => 'image'
				]
			]
		);
		$this->add_responsive_control(
			'mgsec_tborder_padding',
			[
				'label' => __('All Border Padding', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mgsb' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'mgsecborder_type' => 'border'
				]
			]
		);
		$this->add_responsive_control(
			'mgsec_1sttmb',
			[
				'label' => __('1st Border Margin', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mgsb .mgsb1' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'mgsecborder_type' => 'border'
				]
			]
		);

		$this->add_control(
			'mgsec_1stt_color',
			[
				'label'     => __('1st Border Color', 'magical-addons-for-elementor'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ccc',
				'selectors' => [
					'{{WRAPPER}} .mgsb .mgsb1' => 'background-color: {{VALUE}}'
				],
				'condition' => [
					'mgsecborder_type' => 'border'
				]
			]
		);

		$this->add_control(
			'mgsec_1stt_bradius',
			[
				'label' => __('1st Border Radius', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .mgsb .mgsb1' => 'border-radius: {{TOP}}{{UNIT}} 0 0 {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'mgsecborder_type' => 'border'
				]

			]
		);
		$this->add_responsive_control(
			'mgsec_2sttmb',
			[
				'label' => __('2nd Border Margin', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mgsb .mgsb2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'mgsecborder_2nd_show' => 'yes',
					'mgsecborder_type' => 'border'

				],
			]
		);

		$this->add_control(
			'mgsec_2stt_color',
			[
				'label'     => __('2nd Border Color', 'magical-addons-for-elementor'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ccc',
				'condition' => [
					'mgsecborder_2nd_show' => 'yes',
					'mgsecborder_type' => 'border'

				],
				'selectors' => [
					'{{WRAPPER}} .mgsb .mgsb2' => 'background-color: {{VALUE}}'
				]
			]
		);

		$this->add_control(
			'mgsec_2stt_bradius',
			[
				'label' => __('2nd Border Radius', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .mgsb .mgsb2' => 'border-radius: {{TOP}}{{UNIT}} 0 0 {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'mgsecborder_2nd_show' => 'yes',
					'mgsecborder_type' => 'border'
				],

			]
		);
		$this->add_responsive_control(
			'mgsec_3sttmb',
			[
				'label' => __('3rd Border Margin', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mgsb .mgsb3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'mgsecborder_3rd_show' => 'yes',
					'mgsecborder_type' => 'border'
				],
			]
		);

		$this->add_control(
			'mgsec_3stt_color',
			[
				'label'     => __('3rd Border Color', 'magical-addons-for-elementor'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ccc',
				'condition' => [
					'mgsecborder_3rd_show' => 'yes',
					'mgsecborder_type' => 'border'
				],
				'selectors' => [
					'{{WRAPPER}} .mgsb .mgsb3' => 'background-color: {{VALUE}}'
				]
			]
		);

		$this->add_control(
			'mgsec_3stt_bradius',
			[
				'label' => __('3rd Border Radius', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .mgsb .mgsb3' => 'border-radius: {{TOP}}{{UNIT}} 0 0 {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'mgsecborder_3rd_show' => 'yes',
					'mgsecborder_type' => 'border'
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

		$settings   = $this->get_settings_for_display();
		$mgsec_subtitle = $this->get_settings('mgsec_subtitle');
		if ($settings['mgsecsubt_exline_show'] == 'yes') {
			$this->add_render_attribute('mgsec_subtitle', 'class', 'mgsec-subtitle-exline');
		}
		$this->add_render_attribute('mgsec_subtitle', 'class', 'mgsec-subtitle');

		$this->add_inline_editing_attributes('mgsec_subtitle');
		$mgsec_title = $this->get_settings('mgsec_title');
		$mgsectitle_tag = $this->get_settings('mgsectitle_tag');
		$this->add_render_attribute('mgsec_title', 'class', 'mgsec-title');
		$this->add_inline_editing_attributes('mgsec_title');

		$mgsec_desc = $this->get_settings('mgsec_desc');
		$this->add_render_attribute('mgsec_desc', 'class', 'mgsec-desc');
		$this->add_inline_editing_attributes('mgsec_desc');


?>
		<div class="mgsec-title-wrap">
			<?php if ($settings['mgsecborder_show'] && $settings['mgsecborder_position'] == 'top') : ?>
				<?php if ($settings['mgsecborder_type'] == 'border') : ?>
					<div class="mgsb mgsb-top mgsb-<?php echo esc_attr($settings['mgsectitle_balign']); ?>">
						<span class="mgsb1"></span>
						<?php if ($settings['mgsecborder_2nd_show']) : ?>
							<span class="mgsb2"></span>
						<?php endif; ?>
						<?php if ($settings['mgsecborder_3rd_show']) : ?>
							<span class="mgsb3"></span>
						<?php endif; ?>
					</div>
				<?php else : ?>
					<div class="mgsimg mgsb-top text-<?php echo esc_attr($settings['mgsectitle_balign']); ?>">
						<?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'mgsec_thumbnail', 'mgsec_image'); ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>
			<?php if ($settings['mgsec_subtitle_show'] && $settings['mgsec_subtitle'] && $settings['mgsecsub_position'] == 'top') : ?>
				<h5 <?php echo $this->get_render_attribute_string('mgsec_subtitle'); ?>><span><?php echo mg_kses_tags($mgsec_subtitle); ?></span></h5>
			<?php endif; ?>

			<?php if ($mgsec_title) : ?>
				<<?php echo mg_validate_html_tag($mgsectitle_tag); ?> <?php echo $this->get_render_attribute_string('mgsec_title'); ?>><?php echo mg_kses_tags($mgsec_title); ?></<?php echo mg_validate_html_tag($mgsectitle_tag); ?>>
			<?php endif; ?>
			<?php if ($settings['mgsec_subtitle_show'] && $settings['mgsec_subtitle'] && $settings['mgsecsub_position'] == 'bottom') : ?>
				<h5 <?php echo $this->get_render_attribute_string('mgsec_subtitle'); ?>><?php echo mg_kses_tags($mgsec_subtitle); ?></h5>
			<?php endif; ?>
			<?php if ($settings['mgsecborder_show'] && $settings['mgsecborder_position'] == 'bottom') : ?>
				<?php if ($settings['mgsecborder_type'] == 'border') : ?>
					<div class="mgsb mgsb-<?php echo esc_attr($settings['mgsectitle_balign']); ?>">
						<span class="mgsb1"></span>
						<?php if ($settings['mgsecborder_2nd_show']) : ?>
							<span class="mgsb2"></span>
						<?php endif; ?>
						<?php if ($settings['mgsecborder_3rd_show']) : ?>
							<span class="mgsb3"></span>
						<?php endif; ?>
					</div>
				<?php else : ?>
					<div class="mgsimg mgsb-top text-<?php echo esc_attr($settings['mgsectitle_balign']); ?>">
						<?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'mgsec_thumbnail', 'mgsec_image'); ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>

			<?php
			if ($mgsec_desc && $settings['mgsecdesc_show']) :
			?>
				<p <?php echo $this->get_render_attribute_string('mgsec_desc'); ?>>
					<?php echo mg_kses_tags($mgsec_desc); ?>
				</p>
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
	protected function content_template()
	{
	?>
		<# var settings=settings; <!-- This is title -->

			var mgsec_title=settings.mgsec_title;
			view.addInlineEditingAttributes( 'mgsec_title' , 'basic' );
			view.addRenderAttribute('mgsec_title', 'class' , 'mgsec-title' );

			<!-- This is subtitle -->

			var mgsec_subtitle=settings.mgsec_subtitle;
			view.addInlineEditingAttributes( 'mgsec_subtitle' , 'basic' );
			view.addRenderAttribute('mgsec_subtitle', 'class' , 'mgsec-subtitle' );
			if ( settings.mgsecsubt_exline_show ==='yes' ){
			view.addRenderAttribute('mgsec_subtitle', 'class' , 'mgsec-subtitle-exline' );
			}



			<!-- This is Description -->

			var mgsec_desc=settings.mgsec_desc;
			view.addInlineEditingAttributes( 'mgsec_desc' , 'basic' );
			view.addRenderAttribute('mgsec_desc', 'class' , 'mgsec-desc' );

			var mgsecImage = {
			id: settings.mgsec_image.id,
			url: settings.mgsec_image.url,
			size: settings.mgsec_thumbnail_size,
			dimension: settings.mgsec_thumbnail_custom_dimension,
			model: view.getEditModel()
			};
			var mgsec_image_url = elementor.imagesManager.getImageUrl( mgsecImage );

			#>
			<div class="mgsec-title-wrap">



				<# if ( settings.mgsecborder_show && settings.mgsecborder_position==='top' ) { #>
					<# if ( settings.mgsecborder_type==='border' ) { #>
						<div class="mgsb mgsb-top mgsb-{{ settings.mgsectitle_balign }}">
							<span class="mgsb1"></span>
							<# if ( settings.mgsecborder_2nd_show ) { #>
								<span class="mgsb2"></span>
								<# } #>
									<# if ( settings.mgsecborder_3rd_show ) { #>
										<span class="mgsb3"></span>
										<# } #>
						</div>
						<# } else { #>
							<# if ( settings.mgsectitle_balign ) { #>
								<div class="mgsimg mgsb-top text-{{ settings.mgsectitle_balign }}">
									<img src="{{{ mgsec_image_url }}}" />
								</div>
								<# } #>
									<# } #>
										<# } #>

											<# if ( settings.mgsec_subtitle_show && settings.mgsec_subtitle && settings.mgsecsub_position==='top' ) { #>
												<h5 {{{ view.getRenderAttributeString( 'mgsec_subtitle' ) }}}><span>{{{ mgsec_subtitle }}}</span></h5>
												<# } #>

													<# if ( mgsec_title ) { #>
														<{{ settings.mgsectitle_tag }} {{{ view.getRenderAttributeString( 'mgsec_title' ) }}}>{{{ mgsec_title }}}</{{ settings.mgsectitle_tag }}>
														<# } #>

															<# if ( settings.mgsec_subtitle_show && settings.mgsec_subtitle && settings.mgsecsub_position==='bottom' ) { #>
																<h5 {{{ view.getRenderAttributeString( 'mgsec_subtitle' ) }}}>{{{ mgsec_subtitle }}}</h5>
																<# } #>



																	<# if ( settings.mgsecborder_show && settings.mgsecborder_position==='bottom' ) { #>
																		<# if ( settings.mgsecborder_type==='border' ) { #>
																			<div class="mgsb mgsb-{{ settings.mgsectitle_balign }}">
																				<span class="mgsb1"></span>
																				<# if ( settings.mgsecborder_2nd_show ) { #>
																					<span class="mgsb2"></span>
																					<# } #>
																						<# if ( settings.mgsecborder_3rd_show ) { #>
																							<span class="mgsb3"></span>
																							<# } #>
																			</div>
																			<# } else { #>
																				<# if ( settings.mgsectitle_balign ) { #>
																					<div class="mgsimg mgsb-top text-{{ settings.mgsectitle_balign }}">
																						<img src="{{{ mgsec_image_url }}}" />
																					</div>
																					<# } #>
																						<# } #>
																							<# } #>





																								<# if ( settings.mgsecdesc_show && mgsec_desc ) { #>
																									<p {{{ view.getRenderAttributeString( 'mgsec_desc' ) }}}>{{{ mgsec_desc }}}</p>
																									<# } #>
			</div>
	<?php
	}
}
