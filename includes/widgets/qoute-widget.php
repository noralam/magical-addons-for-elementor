<?php


class MgBlockquote extends \Elementor\Widget_Base
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
		return 'mgblockquote';
	}
	public function get_keywords()
	{
		return ['header', 'quote', 'section', 'mg', 'blockquote'];
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
		return __('MG Blockquote', 'magical-addons-for-elementor');
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
		return 'eicon-blockquote';
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
			'mgq_style_section',
			[
				'label' => __('Quote Style', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'mgq_style',
			[
				'label' => __('Select Style', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'style1' =>  __('Style One', 'magical-addons-for-elementor'),
					'style2' =>  __('Style Two', 'magical-addons-for-elementor'),
					'style3' =>  __('Style Three', 'magical-addons-for-elementor'),

				],
				'default' => 'style1',
			]
		);

		$this->add_control(
			'mgq_shadow_style',
			[
				'label' => __('Select Shadow Style', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'noshadow' =>  __('No Shadow', 'magical-addons-for-elementor'),
					'shadow1' =>  __('Shadow One', 'magical-addons-for-elementor'),
					'shadow2' =>  __('Shadow Two', 'magical-addons-for-elementor'),
					'shadow3' =>  __('Shadow Three', 'magical-addons-for-elementor'),
					'shadow4' =>  __('Shadow Four', 'magical-addons-for-elementor'),
					'shadow5' =>  __('Shadow Five', 'magical-addons-for-elementor'),
					'shadow6' =>  __('Shadow Six', 'magical-addons-for-elementor'),
					'shadow7' =>  __('Shadow Seven', 'magical-addons-for-elementor'),
					'shadow8' =>  __('Shadow eight', 'magical-addons-for-elementor'),
				],
				'default' => 'shadow5',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'mgq_content',
			[
				'label' => __('Blockquote Content', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'mgq_des',
			[
				'label'       => __('Description', 'magical-addons-for-elementor'),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'label_block'  => true,
				'placeholder' => __('Enter Description', 'magical-addons-for-elementor'),
				'default'     => __(' Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quia, saepe. Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt, nihil. Consectetur adipisicing elit. Quia, saepe. Rolor sit amet consectetur adipisicing elit. Deserunt, nihil.', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'mgq_show_icon_top',
			[
				'label' => __('Show Icon Top?', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'magical-addons-for-elementor'),
				'label_off' => __('No', 'magical-addons-for-elementor'),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'mgq_icon_top',
			[
				'label' => __('Choose Icon Top', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-quote-left',
					'library' => 'fa-solid',
				],
				'condition' => [
					'mgq_show_icon_top!' => '',
				],
			]
		);


		$this->add_control(
			'mgq_show_icon_bottom',
			[
				'label' => __('Show Icon Bottom?', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'magical-addons-for-elementor'),
				'label_off' => __('No', 'magical-addons-for-elementor'),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'mgq_icon_bottom',
			[
				'label' => __('Choose Icon Bottom', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-quote-right',
					'library' => 'fa-solid',
				],
				'condition' => [
					'mgq_show_icon_bottom!' => '',
				],
			]
		);

		$this->add_control(
			'mgq_name',
			[
				'label' => __('Name', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __('Enter Name', 'magical-addons-for-elementor'),
				'default' => 'Jone Dow',
			]
		);


		$this->add_control(
			'mgq_place',
			[
				'label' => __('Place', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __('Enter Place', 'magical-addons-for-elementor'),
				'default' => __('In The USA', 'magical-addons-for-elementor'),
			]
		);

		$this->add_responsive_control(
			'mgq_meta_position',
			[
				'label' => __('Meta Position', 'magical-addons-for-elementor'),
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
				'default' => 'right',
				'selectors' => [
					'{{WRAPPER}} figcaption.mg-quote-author' => 'text-align: {{VALUE}};',
				],
			]
		);


		$this->add_responsive_control(
			'mgq_des_position',
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
					'justify' => [
						'title' => __('Justified', 'magical-addons-for-elementor'),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => 'justify',
				'selectors' => [
					'{{WRAPPER}} blockquote.mg-blockquote p' => 'text-align: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'mgqborder_show',
			[
				'label' => __('Show Extra border?', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'border_show' => __('Yes', 'magical-addons-for-elementor'),
				'border_off' => __('No', 'magical-addons-for-elementor'),
				'default' => 'show',
				'return_value' => 'show',
			]
		);


		$this->add_responsive_control(
			'mgq_border_position',
			[
				'label' => __('Border Alignment', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __('Left', 'magical-addons-for-elementor'),
						'icon' => 'eicon-text-align-left',
					],
					'right' => [
						'title' => __('Right', 'magical-addons-for-elementor'),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'left',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'mgq_img_icon',
			[
				'label' => __('Icon or Image', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'mgq_style!' => 'style1',
				],
			]
		);


		$this->add_control(
			'mgq_icon_type',
			[
				'label' => __('Icon Type', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
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
				'default' => 'image',
				'toggle' => true,
			]
		);

		$this->add_control(
			'mgq_type_selected_icon',
			[
				'label' => __('Choose Icon', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-quote-right',
					'library' => 'fa-solid',
				],
				'condition' => [
					'mgq_icon_type' => 'icon',
				],
			]
		);


		$this->add_control(
			'mgq_type_image',
			[
				'label' => __('Choose Image', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'mgq_icon_type' => 'image',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' => 'mgq_thumbnail',
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
				'condition' => [
					'mgq_icon_type' => 'image'
				]
			]
		);

		$this->add_control(
			'mgq_icon_position',
			[
				'label' => __('Icon position', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'row' => [
						'title' => __('Left', 'magical-addons-for-elementor'),
						'icon' => 'eicon-h-align-left',
					],
					'row-reverse' => [
						'title' => __('Right', 'magical-addons-for-elementor'),
						'icon' => 'eicon-h-align-right',
					],
					'column' => [
						'title' => __('Top', 'magical-addons-for-elementor'),
						'icon' => 'eicon-v-align-top',
					],
					'column-reverse' => [
						'title' => __('Bottom', 'magical-addons-for-elementor'),
						'icon' => 'eicon-v-align-bottom',
					],

				],
				'default' => 'row',
				'toggle' => false,
				'condition' => [
					'mgq_style!' => 'style3',
				]
			]
		);

		$this->add_responsive_control(
			'mgq_icon_alignment',
			[
				'label' => __('Icon Alignment', 'magical-addons-for-elementor'),
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
				'selectors' => [
					'{{WRAPPER}} .mg-quote-imf' => 'align-items: {{VALUE}};',
				],

				'condition' => [
					'mgq_style!' => 'style3',
				]

			]
		);

		$this->add_responsive_control(
			'mgq_meta_style3_alignment',
			[
				'label' => __('Meta Alignment', 'magical-addons-for-elementor'),
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

				'default' => 'flex-end',
				'selectors' => [
					'{{WRAPPER}} .mg-qoute-single.mg-quote-style3 .mgq-author' => 'justify-content: {{VALUE}};',
				],
				'condition' => [
					'mgq_style' => 'style3',
				]

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
			'mgq_basic_style',
			[
				'label' => __('Quote Basic Style', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'mgq_min_height',
			[
				'label' => __('Quote Minimum Height', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mg-qoute-single' => 'min-height: {{SIZE}}{{UNIT}};',
				],

			]
		);

		$this->add_responsive_control(
			'mgq_box_padding',
			[
				'label' => __('Padding', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-qoute-single' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'mgq_box_margin',
			[
				'label' => __('Margin', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-qoute-single' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'mgq_box_border',
				'selector' => '{{WRAPPER}} .mg-qoute-single'

			]
		);

		$this->add_responsive_control(
			'mgq_box_border_radius',
			[
				'label' => __('Border Radius', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-qoute-single' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'mgq_box_block_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .mg-qoute-single'
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'basic_background',
				'label' => esc_html__('Background', 'magical-addons-for-elementor'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .mg-qoute-single ',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'mgq_icon_image_style',
			[
				'label' => __('Image And Icon', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'mgq_style!' => 'style1',
				],
			]
		);


		$this->add_responsive_control(
			'mgq_icon_size',
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
					'{{WRAPPER}} .mgq-quote-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'mgq_icon_type' => 'icon'
				]
			]
		);


		$this->add_responsive_control(
			'mgq_image_width',
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
					'{{WRAPPER}} figure.mg-quote-img img' => 'width: {{SIZE}}{{UNIT}} !important;',
					'{{WRAPPER}} figure.mg-quote-img' => 'flex: 0 0 {{SIZE}}{{UNIT}} !important;',
				],
				'condition' => [
					'mgq_icon_type' => 'image'
				]
			]
		);

		$this->add_responsive_control(
			'mgq_image_height',
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
					'{{WRAPPER}} figure.mg-quote-img img' => 'height: {{SIZE}}{{UNIT}} !important;',
				],
				'condition' => [
					'mgq_icon_type' => 'image'
				]
			]
		);


		$this->add_responsive_control(
			'mgq_icon_padding',
			[
				'label' => __('Padding', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .mgq-quote-icon i,
					 {{WRAPPER}} figure.mg-quote-img img' => 'padding: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);
		$this->add_responsive_control(
			'mgq_icon_margin',
			[
				'label' => __('Margin', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} figure.mg-quote-img img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .mgq-quote-icon i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'mgq_icon_border',
				'selector' => '{{WRAPPER}} figure.mg-quote-img img,
				 {{WRAPPER}} .mgq-quote-icon i'

			]
		);
		$this->add_responsive_control(
			'mgq_icon_border_radius',
			[
				'label' => __('Border Radius', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} figure.mg-quote-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .mgq-quote-icon i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'mgq_block_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} figure.mg-quote-img img, {{WRAPPER}} .mgq-quote-icon i'
			]
		);
		$this->add_control(
			'mgq_icon_color',
			[
				'label' => __('Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mgq-quote-icon i' => 'color: {{VALUE}}',
				],
				'condition' => [
					'mgq_icon_type' => 'icon'
				]
			]
		);
		$this->add_control(
			'mgq_icon_bg_color',
			[
				'label' => __('Background Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} figure.mg-quote-img img,
					 {{WRAPPER}} .mgq-quote-icon i' => 'background-color: {{VALUE}};',
				],

			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'mgq_content_style',
			[
				'label' => __('Description And Meta', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_responsive_control(
			'mgq_content_padding',
			[
				'label' => __('Content padding', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-quote-details' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'mgq_title_spacing',
			[
				'label' => __('Bottom Spacing', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .mg-blockquote' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'mgq_title_color',
			[
				'label' => __('Text Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} blockquote.mg-blockquote p' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'mgq_content_typography',
				'selector' => '{{WRAPPER}} blockquote.mg-blockquote p',
			]
		);


		$this->add_control(
			'mgq_desc_heading',
			[
				'type' => \Elementor\Controls_Manager::HEADING,
				'label' => __('Meta', 'magical-addons-for-elementor'),
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'mgq_description_spacing',
			[
				'label' => __('Bottom Spacing', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .mg-quote-author' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'mgq_description_color',
			[
				'label' => __('Text Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-quote-author' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'mgq_meta_typography',
				'selector' => '{{WRAPPER}} .mg-quote-author',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'mgq_content_icon_style',
			[
				'label' => __('Content Icon', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						['name' => 'mgq_show_icon_top', 'operator' => '==', 'value' => 'yes'],
						['name' => 'mgq_show_icon_bottom', 'operator' => '==', 'value' => 'yes'],
					],
				],

			]

		);
		$this->add_control(
			'mgq_top_icon',
			[
				'type' => \Elementor\Controls_Manager::HEADING,
				'label' => __('Content Top Icon', 'magical-addons-for-elementor'),


			]
		);

		$this->add_responsive_control(
			'mgq_top_icon_padding',
			[
				'label' => __('Top icon padding', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mcq-icon-top i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'mgq_top_icon_color',
			[
				'label' => __('Top Icon Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mcq-icon-top i' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'mgq_top_icon_size',
			[
				'label' => __('Top Icon Size', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .mcq-icon-top i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'mgq_bottom_icon',
			[
				'type' => \Elementor\Controls_Manager::HEADING,
				'label' => __('Content Bottom Icon', 'magical-addons-for-elementor'),
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'mgq_bottom_icon_padding',
			[
				'label' => __('Bottom icon padding', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mcq-icon-bottom i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'mgq_bottom_icon_color',
			[
				'label' => __('Top Icon Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mcq-icon-bottom i' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'mgq_bottom_icon_size',
			[
				'label' => __('Top Icon Size', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .mcq-icon-bottom i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'mgq_border_style',
			[
				'label' => __('Border Style', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'mgqborder_show' => 'show'
				],

			]

		);


		$this->add_responsive_control(
			'mgq_border_width',
			[
				'label' => __('Extra Border Width', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mg-qoute-single.mgq-border-show-left, {{WRAPPER}} .mg-qoute-single.mgq-border-show-right' => 'border-width: {{SIZE}}{{UNIT}};',
				],

			]
		);

		$this->add_control(
			'mgq_border_color',
			[
				'label' => __('Border Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,

				'selectors' => [
					'{{WRAPPER}} .mg-qoute-single.mgq-border-show-left, {{WRAPPER}} .mg-qoute-single.mgq-border-show-right' => 'border-color: {{VALUE}}',
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
		$mgq_style = $settings['mgq_style'];
		if ($mgq_style == 'style1') {
			$this->quate_style_base_one($settings);
		} elseif ($mgq_style == 'style3') {
			$this->quate_style_base_three($settings);
		} else {
			$this->quate_style_base_two($settings);
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




	public function quate_style_base_two($settings)
	{
		$mgq_shadow_style = $settings['mgq_shadow_style'];
		$mgq_icon_position = $settings['mgq_icon_position'];
		$mgq_name = $settings['mgq_name'];
		$mgq_place = $settings['mgq_place'];
		$mgqborder_show = $settings['mgqborder_show'];
		$mgq_border_position = $settings['mgq_border_position'];
		$mgq_icon_type = $settings['mgq_icon_type'];
		$mgq_style = $settings['mgq_style'];
?>
		<div class="mg-qoute-single mgq-border-<?php echo esc_attr($mgqborder_show); ?>-<?php echo esc_attr($mgq_border_position); ?> mg-<?php echo esc_attr($mgq_shadow_style); ?> mg-quote-<?php echo esc_attr($mgq_style); ?> mg-icon-<?php echo esc_attr($mgq_icon_position); ?>">

			<div class="mg-quote-imf">
				<?php if ($mgq_icon_type == 'image') : ?>
					<figure class="mg-quote-img">
						<?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'mgq_thumbnail', 'mgq_type_image'); ?>
					</figure>
				<?php else : ?>
					<div class="mgq-quote-icon">
						<?php \Elementor\Icons_Manager::render_icon($settings['mgq_type_selected_icon']); ?>
					</div>
				<?php endif; ?>
				<div class="mg-quote-details">
					<?php $this->main_content($settings); ?>

				</div>
			</div>
			<figcaption class="mg-quote-author">
				<?php echo esc_html($mgq_name); ?> <cite><?php echo esc_html($mgq_place); ?></cite>
			</figcaption>
		</div>
	<?php
	}

	public function quate_style_base_one($settings)
	{

		$mgq_style = $settings['mgq_style'];
		$mgq_shadow_style = $settings['mgq_shadow_style'];
		$mgq_name = $settings['mgq_name'];
		$mgq_place = $settings['mgq_place'];
		$mgqborder_show = $settings['mgqborder_show'];
		$mgq_border_position = $settings['mgq_border_position'];

	?>

		<div class="mg-qoute-single mgq-border-<?php echo esc_attr($mgqborder_show); ?>-<?php echo esc_attr($mgq_border_position); ?> mg-<?php echo esc_attr($mgq_shadow_style); ?> mg-quote-<?php echo esc_attr($mgq_style); ?>">
			<div class="mg-quote-details">
				<?php $this->main_content($settings); ?>

			</div>


			<figcaption class="mg-quote-author">
				<?php echo esc_html($mgq_name); ?> <cite><?php echo esc_html($mgq_place); ?></cite>
			</figcaption>

		</div>
	<?php
	}




	public function quate_style_base_three($settings)
	{
		$mgq_shadow_style = $settings['mgq_shadow_style'];
		$mgq_icon_position = $settings['mgq_icon_position'];
		$mgq_name = $settings['mgq_name'];
		$mgq_place = $settings['mgq_place'];
		$mgqborder_show = $settings['mgqborder_show'];
		$mgq_border_position = $settings['mgq_border_position'];
		$mgq_icon_type = $settings['mgq_icon_type'];
		$mgq_style = $settings['mgq_style'];
	?>
		<div class="mg-qoute-single mgq-border-<?php echo esc_attr($mgqborder_show); ?>-<?php echo esc_attr($mgq_border_position); ?> mg-<?php echo esc_attr($mgq_shadow_style); ?> mg-quote-<?php echo esc_attr($mgq_style); ?> mg-icon-<?php echo esc_attr($mgq_icon_position); ?>">

			<div class="mg-quote-imf">

				<div class="mg-quote-details">
					<?php $this->main_content($settings); ?>
				</div>
			</div>
			<div class="mgq-author">
				<?php if ($mgq_icon_type == 'image') : ?>
					<figure class="mg-quote-img">
						<?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'mgq_thumbnail', 'mgq_type_image'); ?>
					</figure>
				<?php else : ?>
					<div class="mgq-quote-icon">
						<?php \Elementor\Icons_Manager::render_icon($settings['mgq_type_selected_icon']); ?>
					</div>
				<?php endif; ?>

				<figcaption class="mg-quote-author">
					<?php echo esc_html($mgq_name); ?> <cite><?php echo esc_html($mgq_place); ?></cite>
				</figcaption>
			</div>
		</div>
	<?php
	}

	public function main_content($settings)
	{
		$mgq_des = $settings['mgq_des'];
		$mgq_icon_top = $settings['mgq_icon_top'];
		$mgq_icon_bottom = $settings['mgq_icon_bottom'];


	?>
		<blockquote class="mg-blockquote">
			<p>
				<?php if ($mgq_icon_top) : ?>
					<span class="mcq-icon-top">
						<?php \Elementor\Icons_Manager::render_icon($settings['mgq_icon_top']); ?>
					</span>
				<?php endif; ?>
				<?php echo esc_html($mgq_des); ?>
				<?php if ($mgq_icon_bottom) : ?>
					<span class="mcq-icon-bottom">
						<?php \Elementor\Icons_Manager::render_icon($settings['mgq_icon_bottom']); ?>
					</span>
				<?php endif; ?>
			</p>
		</blockquote>
<?php
	}
}
