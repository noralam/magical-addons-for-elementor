<?php


class MgAddon_Video_Card extends \Elementor\Widget_Base
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
		return 'mgvideo_card';
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
		return __('MG Video Card', 'magical-addons-for-elementor');
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
		return 'eicon-youtube';
	}

	public function get_keywords()
	{
		return ['card', 'image', 'grid', 'video', 'mg'];
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
			'mg_img_section',
			[
				'label' => __('Card Video', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'mg_vcard_video_url',
			[
				'label' => __('Enter Youtube video url', 'magical-addons-for-elementor'),
				'label_block' => true,
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => 'Paste Youtube url here',
				'default' => 'https://www.youtube.com/watch?v=LXb3EKWsInQ'
			]
		);
		$this->add_control(
			'mg_cvideo_thumb_type',
			[
				'label' => __('Use Default video Thumbnail?', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'magical-addons-for-elementor'),
				'label_off' => __('No', 'magical-addons-for-elementor'),
				'default' => 'yes',
			]
		);
		$this->add_control(
			'mg_cvideo_thumb',
			[
				'label' => __('Upload video thumbnail', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'mg_cvideo_thumb_type' => '',
				],
			]
		);
		$this->add_control(
			'mg_cvideo_playicon',
			[
				'label' => __('Show video play icon?', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'magical-addons-for-elementor'),
				'label_off' => __('No', 'magical-addons-for-elementor'),
				'default' => 'yes',
			]
		);
		$this->add_control(
			'mg_cvideo_playicon_bg',
			[
				'label' => __('Video Image Overlay?', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'magical-addons-for-elementor'),
				'label_off' => __('No', 'magical-addons-for-elementor'),
				'default' => 'yes',

			]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
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
					'mg_cvideo_thumb_type' => '',
				],

			]
		);
		$this->add_control(
			'mg_img_position',
			[
				'label' => __('Image position', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __('Left', 'magical-addons-for-elementor'),
						'icon' => 'fas fa-arrow-left',
					],
					'top' => [
						'title' => __('Top', 'magical-addons-for-elementor'),
						'icon' => 'fas fa-arrow-up',
					],
					'right' => [
						'title' => __('Right', 'magical-addons-for-elementor'),
						'icon' => 'fas fa-arrow-right',
					],

				],
				'default' => 'top',
				'toggle' => false,
				'prefix_class' => 'mg-card-img-',
				'style_transfer' => true,
			]

		);
		$this->add_control(
			'mg_cvideo_contetnt',
			[
				'label' => __('Show Card Video Content?', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'magical-addons-for-elementor'),
				'label_off' => __('No', 'magical-addons-for-elementor'),
				'default' => 'yes',
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'mg_vcard_content',
			[
				'label' => __('Video Card Content', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'mg_cvideo_contetnt' => 'yes',
				],
			]
		);


		$this->add_control(
			'mg_vcard_title',
			[
				'label'       => __('Title', 'magical-addons-for-elementor'),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'input_type'  => 'text',
				'placeholder' => __('Enter Video Card Title', 'magical-addons-for-elementor'),
				'default'     => __('Video Card Title', 'magical-addons-for-elementor'),
				'label_block'     => true,

			]
		);
		$this->add_control(
			'mg_vcard_title_tag',
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
			]
		);
		$this->add_control(
			'mg_cvideo_subtitle_show',
			[
				'label' => __('Show subtitle?', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'magical-addons-for-elementor'),
				'label_off' => __('No', 'magical-addons-for-elementor'),
				'default' => '',
			]
		);
		$this->add_control(
			'mg_vcard_subtitle',
			[
				'label'       => __('Sub Title', 'magical-addons-for-elementor'),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'input_type'  => 'text',
				'placeholder' => __('Enter Video Card Sub Title', 'magical-addons-for-elementor'),
				'default'     => __('Video Card Sub Title', 'magical-addons-for-elementor'),
				'label_block'     => true,
				'condition' => [
					'mg_cvideo_subtitle_show' => 'yes',
				],

			]
		);
		$this->add_responsive_control(
			'mg_vcard_subtile_position',
			[
				'label' => __('Sub Title Position', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => __('top', 'magical-addons-for-elementor'),
						'icon' => ' eicon-arrow-up',
					],
					'bottom' => [
						'title' => __('bottom', 'magical-addons-for-elementor'),
						'icon' => ' eicon-arrow-down',
					],


				],
				'default' => 'top',
				'condition' => [
					'mg_cvideo_subtitle_show' => 'yes',
				],

			]
		);

		$this->add_control(
			'mg_vcard_desc',
			[
				'label'       => __('Description', 'magical-addons-for-elementor'),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'input_type'  => 'text',
				'placeholder' => __('Card description goes here.', 'magical-addons-for-elementor'),
				'default'     => __('dummy text you can edit or remove it. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempo.', 'magical-addons-for-elementor'),
			]
		);

		$this->add_responsive_control(
			'mg_vcard_text_align',
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
					'{{WRAPPER}} .mg-card-text' => 'text-align: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'mg_vcard_button',
			[
				'label' => __('Button', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'mg_cvideo_contetnt' => 'yes',
				],
			]
		);
		$this->add_control(
			'mg_vcard_btn_use',
			[
				'label' => __('Use Video Card Button?', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'magical-addons-for-elementor'),
				'label_off' => __('No', 'magical-addons-for-elementor'),
				'default' => 'yes',
			]
		);
		$this->add_control(
			'mg_vcard_btn_title',
			[
				'label'       => __('Button Title', 'magical-addons-for-elementor'),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'input_type'  => 'text',
				'placeholder' => __('Button Text', 'magical-addons-for-elementor'),
				'default'     => __('Read More', 'magical-addons-for-elementor'),
			]
		);
		$this->add_control(
			'mg_vcard_btn_link',
			[
				'label' => __('Button Link', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __('https://your-link.com', 'magical-addons-for-elementor'),
				'default' => [
					'url' => '#',
				],
				'separator' => 'before',
			]
		);
		$this->add_control(
			'mg_vcard_usebtn_icon',
			[
				'label' => __('Use icon', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'magical-addons-for-elementor'),
				'label_off' => __('No', 'magical-addons-for-elementor'),
				'default' => 'no',
			]
		);

		$this->add_control(
			'mg_vcard_btn_selected_icon',
			[
				'label' => __('Choose Icon', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-chevron-right',
					'library' => 'solid',
				],
				'condition' => [
					'mg_vcard_usebtn_icon' => 'yes',
				],
			]
		);


		$this->add_responsive_control(
			'mg_vcardbtn_icon_position',
			[
				'label' => __('Button Icon Position', 'magical-addons-for-elementor'),
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
					'mg_vcard_usebtn_icon' => 'yes',
				],

			]
		);
		$this->add_responsive_control(
			'mg_vcardbtn_iconspace',
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
					'mg_vcard_usebtn_icon' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .mg-card .mg-card-btn i.left,{{WRAPPER}} .mg-card .mg-card-btn .left i' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .mg-card .mg-card-btn i.right, {{WRAPPER}} .mg-card .mg-card-btn .right i' => 'margin-left: {{SIZE}}{{UNIT}};',
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
			'mg_vcard_basic_style',
			[
				'label' => __('Basic style', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'mg_cvideo_contetnt' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'mg_vcard_content_padding',
			[
				'label' => __('Content Padding', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-card-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'mg_vcard_content_margin',
			[
				'label' => __('Content Margin', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-card-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'mg_vcard_content_bg_color',
			[
				'label' => __('Content Background color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-card-text' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'mg_vcard_content_border_radius',
			[
				'label' => __('Border Radius', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-card-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'mg_vcard_content_border',
				'selector' => '{{WRAPPER}} .mg-card-text',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'mg_vcard_img_style',
			[
				'label' => __('Video Image style', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
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
					'{{WRAPPER}} .mg-card-img' => 'flex: 0 0 {{SIZE}}{{UNIT}}; max-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.mg-card-img-top .mg-card-text,{{WRAPPER}}.mg-card-img-right .mg-card-text, {{WRAPPER}}.mg-card-img-left .mg-card-text' => 'flex: 0 0 calc(100% - {{SIZE || 50}}{{UNIT}}); max-width: calc(100% - {{SIZE || 50}}{{UNIT}});',
				],
			]
		);

		$this->add_responsive_control(
			'mg_vcard_img_auto_height',
			[
				'label' => __('Image auto height', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('On', 'magical-addons-for-elementor'),
				'label_off' => __('Off', 'magical-addons-for-elementor'),
				'default' => 'yes',
			]
		);
		$this->add_responsive_control(
			'mg_vcard_img_height',
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
					'mg_vcard_img_auto_height!' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .mg-card-img figure img, .mg-card-style2 .card-bg-img img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'mg_vcard_imgbg_height',
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
					'mg_vcard_img_auto_height!' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .mg-card-img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'mg_vcard_img_padding',
			[
				'label' => __('Padding', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-card-img figure' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'mg_vcard_img_margin',
			[
				'label' => __('Margin', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-card-img figure' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'mg_vcard_img_border_radius',
			[
				'label' => __('Border Radius', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-card-img figure img,{{WRAPPER}} .mgvideo-overlay' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->add_control(
			'mg_vcard_imgbg_color',
			[
				'label' => __('Background Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mg-card-img' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'mg_vcard_img_border',
				'selector' => '{{WRAPPER}} .mg-card-img figure img,{{WRAPPER}} .mgvideo-overlay',
			]
		);

		$this->add_responsive_control(
			'mg_vcard_icon_size',
			[
				'label' => __('Play Icon Size', 'magical-addons-for-elementor'),
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
					'mg_cvideo_playicon' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .mgplay-btn i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'mg_vcard_iconcolor',
			[
				'label' => __('Video Play Icon Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mgplay-btn i' => 'color: {{VALUE}};',
				],
				'condition' => [
					'mg_cvideo_playicon' => 'yes',
				],
			]
		);
		$this->add_control(
			'mg_vcard_imgoverlay',
			[
				'label' => __('Image overlay Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#00000080',
				'selectors' => [
					'{{WRAPPER}} .mgvideo-overlay' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'mg_cvideo_playicon_bg' => 'yes',
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'mg_vcard_card_details_style',
			[
				'label' => __('Card Title', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'mg_cvideo_contetnt' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'mg_vcard_title_padding',
			[
				'label' => __('Padding', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-card-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'mg_vcard_title_margin',
			[
				'label' => __('Margin', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-card-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'mg_vcard_title_color',
			[
				'label' => __('Text Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-card-title' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'mg_vcard_title_bgcolor',
			[
				'label' => __('Background Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-card-title' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'mg_vcard_title_radius',
			[
				'label' => __('Border Radius', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-card-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'mg_vcard_title_typography',
				'selector' => '{{WRAPPER}} .mg-card-title',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'mg_vcard_card_subtitle_style',
			[
				'label' => __('Card Sub Title', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'mg_cvideo_contetnt' => 'yes',
					'mg_cvideo_subtitle_show' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'mg_vcard_subtitle_padding',
			[
				'label' => __('Padding', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mgc-subtitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'mg_vcard_subtitle_margin',
			[
				'label' => __('Margin', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mgc-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'mg_vcard_subtitle_color',
			[
				'label' => __('Text Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mgc-subtitle' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'mg_vcard_subtitle_bgcolor',
			[
				'label' => __('Background Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mgc-subtitle' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'mg_vcard_subtitle_radius',
			[
				'label' => __('Border Radius', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .mgc-subtitle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'mg_vcard_subtitle_typography',
				'selector' => '{{WRAPPER}} .mgc-subtitle',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'mgtm_card_description_style',
			[
				'label' => __('Description', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'mg_cvideo_contetnt' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'mg_vcard_description_padding',
			[
				'label' => __('Padding', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-card-text p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'mg_vcard_description_margin',
			[
				'label' => __('Margin', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-card-text p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'mg_vcard_description_color',
			[
				'label' => __('Text Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-card-text p' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'mg_vcard_description_bgcolor',
			[
				'label' => __('Background Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-card-text p' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'mg_vcard_description_radius',
			[
				'label' => __('Border Radius', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-card-text p' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'mg_vcard_description_typography',
				'selector' => '{{WRAPPER}} .mg-card-text p',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'mgbtn_card_style',
			[
				'label' => __('Button', 'magical-addons-for-elementor'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'mg_cvideo_contetnt' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'mgcard_btn_padding',
			[
				'label' => __('Padding', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-card-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'mgcard_btn_typography',
				'selector' => '{{WRAPPER}} .mg-card-btn',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'mgcard_btn_border',
				'selector' => '{{WRAPPER}} .mg-card-btn',
			]
		);

		$this->add_control(
			'mgcard_btn_border_radius',
			[
				'label' => __('Border Radius', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-card-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'mgcard_btn_box_shadow',
				'selector' => '{{WRAPPER}} .mg-card-btn',
			]
		);
		$this->add_control(
			'mgcard_button_color',
			[
				'label' => __('Button color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs('infobox_btn_tabs');

		$this->start_controls_tab(
			'mgcard_btn_normal_style',
			[
				'label' => __('Normal', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'mgcard_btn_color',
			[
				'label' => __('Text Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mg-card-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mgcard_btn_bg_color',
			[
				'label' => __('Background Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-card-btn' => 'background-color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab(
			'mgcard_btn_hover_style',
			[
				'label' => __('Hover', 'magical-addons-for-elementor'),
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'mgcard_btnhover_boxshadow',
				'selector' => '{{WRAPPER}} .mg-card-btn:hover',
			]
		);

		$this->add_control(
			'mgcard_btn_hcolor',
			[
				'label' => __('Text Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-card-btn:hover, {{WRAPPER}} .mg-card-btn:focus' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mgcard_btn_hbg_color',
			[
				'label' => __('Background Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-card-btn:hover, {{WRAPPER}} .mg-card-btn:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mgcard_btn_hborder_color',
			[
				'label' => __('Border Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'condition' => [
					'mgcard_btn_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .mg-card-btn:hover, {{WRAPPER}} .mg-card-btn:focus' => 'border-color: {{VALUE}};',
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

		//card name
		$mg_cvideo_contetnt = $this->get_settings('mg_cvideo_contetnt');
		$mg_vcard_title = $this->get_settings('mg_vcard_title');
		$mg_vcard_title_tag = $this->get_settings('mg_vcard_title_tag');
		$this->add_inline_editing_attributes('mg_vcard_title');
		$this->add_render_attribute('mg_vcard_title', 'class', 'mg-card-title');
		//description
		$mg_cvideo_thumb = $this->get_settings('mg_cvideo_thumb');
		$mg_cvideo_thumb_type = $this->get_settings('mg_cvideo_thumb_type');
		$mg_cvideo_playicon = $this->get_settings('mg_cvideo_playicon');
		$mg_cvideo_playicon_bg = $this->get_settings('mg_cvideo_playicon_bg');
		$mg_vcard_desc = $this->get_settings('mg_vcard_desc');
		$this->add_inline_editing_attributes('mg_vcard_desc');

		// social list item
		$mg_vcard_btn_use = $this->get_settings('mg_vcard_btn_use');
		$mg_vcard_btn_title = $this->get_settings('mg_vcard_btn_title');
		$mg_vcard_btn_link = $this->get_settings('mg_vcard_btn_link');
		$mg_vcard_usebtn_icon = $this->get_settings('mg_vcard_usebtn_icon');
		$mg_vcard_btnicon = $this->get_settings('mg_vcard_btnicon');
		$mg_vcardbtn_icon_position = $this->get_settings('mg_vcardbtn_icon_position');
		$main_icon_position = $this->get_settings('main_icon_position');
		//for card button title
		$this->add_inline_editing_attributes('mg_vcard_btn_title', 'none');
		$this->add_render_attribute('mg_vcard_btn_title', 'class', 'mg-btn');

		$this->add_render_attribute('mg_vcard_btn_title', 'class', 'mg-card-btn');
		$this->add_render_attribute('mg_vcard_btn_title', 'href', esc_url($mg_vcard_btn_link['url']));
		if (!empty($mg_vcard_btn_link['is_external'])) {
			$this->add_render_attribute('mg_vcard_btn_title', 'target', '_blank');
		}
		if (!empty($mg_vcard_btn_link['nofollow'])) {
			$this->set_render_attribute('mg_vcard_btn_title', 'rel', 'nofollow');
		}
		//for card sub title
		$this->add_inline_editing_attributes('mg_vcard_subtitle', 'none');
		$this->add_render_attribute('mg_vcard_subtitle', 'class', 'mgc-subtitle');


?>
		<div class="mg-card <?php if (empty($mg_cvideo_contetnt)) : ?>mgno-content<?php endif; ?>">
			<div class="mg-card-img mgvideo-thumb">
				<figure>

					<a class="mgvlight" data-autoplay="true" data-vbtype="video" href="<?php echo esc_url($settings['mg_vcard_video_url']); ?>">
						<?php if ($mg_cvideo_thumb_type != 'yes') : ?>
							<?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'mg_cvideo_thumb'); ?>
						<?php else : ?>
							<img src="<?php echo esc_url('//img.youtube.com/vi/' . get_mg_youtube_id($settings['mg_vcard_video_url']) . '/hqdefault.jpg'); ?>" alt="<?php esc_attr_e('Card Video', 'magical-addons-for-elementor'); ?>" />
						<?php endif; ?>
						<?php if ($mg_cvideo_playicon) : ?>
							<div class="mgplay-btn"><i class="fas fa-play-circle"></i></div>
						<?php endif; ?>
						<?php if ($mg_cvideo_playicon_bg) : ?>
							<div class="mgvideo-overlay"></div>
						<?php endif; ?>
					</a>
				</figure>
			</div>
			<?php if ($mg_cvideo_contetnt) : ?>
				<div class="mg-card-text">
					<?php
					if ($settings['mg_cvideo_subtitle_show'] && $settings['mg_vcard_subtile_position'] == 'top') {
						echo '<h5 ' . $this->get_render_attribute_string('mg_vcard_subtitle') . '>' . $settings['mg_vcard_subtitle'] . '</h5>';
					}
					?>
					<?php
					if ($mg_vcard_title) :
						printf(
							'<%1$s %2$s>%3$s</%1$s>',
							tag_escape($mg_vcard_title_tag),
							$this->get_render_attribute_string('mg_vcard_title'),
							mg_kses_tags($mg_vcard_title)
						);
					endif;
					?>
					<?php
					if ($settings['mg_cvideo_subtitle_show'] && $settings['mg_vcard_subtile_position'] == 'bottom') {
						echo '<h5 ' . $this->get_render_attribute_string('mg_vcard_subtitle') . '>' . $settings['mg_vcard_subtitle'] . '</h5>';
					}
					?>
					<?php if ($mg_vcard_desc) : ?>
						<p <?php echo $this->get_render_attribute_string('mg_vcard_desc'); ?>><?php echo wp_kses_post($mg_vcard_desc); ?></p>
					<?php endif; ?>
					<?php if ($mg_vcard_btn_use) : ?>
						<?php if ($mg_vcard_usebtn_icon == 'yes') : ?>
							<a <?php echo $this->get_render_attribute_string('mg_vcard_btn_title'); ?>>
								<?php if ($mg_vcardbtn_icon_position == 'left') : ?>

									<span class="left"><?php \Elementor\Icons_Manager::render_icon($settings['mg_vcard_btn_selected_icon']); ?></span>

								<?php endif; ?>
								<span><?php echo mg_kses_tags($mg_vcard_btn_title); ?></span>
								<?php if ($mg_vcardbtn_icon_position == 'right') : ?>
									<span class="right"><?php \Elementor\Icons_Manager::render_icon($settings['mg_vcard_btn_selected_icon']); ?></span>
								<?php endif; ?>
							</a>
						<?php else : ?>
							<a <?php echo $this->get_render_attribute_string('mg_vcard_btn_title'); ?>><?php echo  mg_kses_tags($mg_vcard_btn_title); ?></a>
						<?php endif; ?>
					<?php endif; ?>
				</div>
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
	/*protected function content_template() {}*/
}
