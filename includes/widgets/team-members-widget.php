<?php


class MgAddon_Team_Member extends \Elementor\Widget_Base
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
		return 'mgteamber_widget';
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
		return __('MG Team Members', 'magical-addons-for-elementor');
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
		return 'eicon-user-circle-o';
	}

	public function get_keywords()
	{
		return ['team', 'member', 'card', 'mg'];
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
			'team_basic_style',
			[
				'label' => __('Basic Design', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'all_basic_style',
			[
				'label' => __('Select Design', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'style1' => 'Style One',
					'style2' => 'Style Two',
				],
				'default' => 'style1',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'img_section',
			[
				'label' => __('Team Member Image', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'member_img',
			[
				'label' => __('Choose Image', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
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

			]
		);


		$this->add_control(
			'team_imgbg_image',
			[
				'label' => __('Choose Background Image', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'condition' => [
					'all_basic_style' => 'style2',
				],

			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name' => 'bgimg_thumbnail',
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
					'all_basic_style' => 'style2',
				],


			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'team_details',
			[
				'label' => __('Team Member Details', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'mg_member_name',
			[
				'label'       => __('Name', 'magical-addons-for-elementor'),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'input_type'  => 'text',
				'placeholder' => __('John Doe', 'magical-addons-for-elementor'),
				'default'     => __('John Doe', 'magical-addons-for-elementor'),
				'label_block'     => true,

			]
		);
		$this->add_control(
			'mg_member_name_tag',
			[
				'label' => __('Name HTML Tag', 'magical-addons-for-elementor'),
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
				'default' => 'h3',
			]
		);
		$this->add_control(
			'mg_member_designation',
			[
				'label'       => __('Designation', 'magical-addons-for-elementor'),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'input_type'  => 'text',
				'placeholder' => __('Senior developer', 'magical-addons-for-elementor'),
				'default'     => __('Senior developer', 'magical-addons-for-elementor'),
				'label_block'     => true,

			]
		);
		$this->add_control(
			'mg_member_desc',
			[
				'label'       => __('Description', 'magical-addons-for-elementor'),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'input_type'  => 'text',
				'placeholder' => __('Team description goes here.', 'magical-addons-for-elementor'),
				'default'     => __('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempo, dummy text you can edit or remove it.', 'magical-addons-for-elementor'),
			]
		);

		$this->add_responsive_control(
			'mg_team_text_align',
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
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .mg-team-content' => 'text-align: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'mg_team_social',
			[
				'label' => __('Social Profile', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'mg_display_social',
			[
				'label' => __('Display Social Profile?', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'magical-addons-for-elementor'),
				'label_off' => __('No', 'magical-addons-for-elementor'),
				'default' => 'yes',
			]
		);
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'mg_team_social_selected_icon',
			[
				'label' => __('Choose Icon', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::ICONS,
				'default' => [
					'value' => 'fab fa-wordpress',
					'library' => 'fa-brands',
				],
				'recommended' => [
					'fa-brands' => [
						'facebook',
						'twitter',
						'linkedin',
						'instagram',
						'reddit',
						'pinterest',
						'tumblr',
						'wordpress',
						'skype',
						'vimeo',
						'android',
						'dribbble',
						'youtube',
						'apple',
						'behance',
						'bitbucket',
						'codepen',
						'delicious',
						'deviantart',
						'digg',
						'elementor',
						'flickr',
						'foursquare',
						'free-code-camp',
						'github',
						'gitlab',
						'globe',
						'houzz',
						'jsfiddle',
						'medium',
						'meetup',
						'mixcloud',
						'odnoklassniki',
						'product-hunt',
						'slideshare',
						'snapchat',
						'soundcloud',
						'spotify',
						'stack-overflow',
						'steam',
						'stumbleupon',
						'telegram',
						'thumb-tack',
						'tripadvisor',
						'twitch',
						'viber',
						'vk',
						'weibo',
						'weixin',
						'whatsapp',
						'xing',
						'yelp',
						'500px',
					],
					'fa-solid' => [
						'envelope',
						'link',
						'rss',
					],
				],

			]
		);

		$repeater->add_control(
			'mg_member_icon_link',
			[
				'label' => __('Social Link', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => 'https://your-link.com',
				'default' => [
					'url' => 'https://your-link.com',
				],
				'separator' => 'before',

			]
		);
		if (mg_elementor_version_check('<', '2.6.0')) {
			$default = [
				[
					'$mg_team_social_icon' => 'fa fa-facebook',
					'mg_member_icon_link' => [
						'url' => 'https://facebook.com',
					],
				],
				[
					'$mg_team_social_icon' => 'fa fa-twitter',
					'mg_member_icon_link' => [
						'url' => 'https://twitter.com',
					],
				],
				[
					'$mg_team_social_icon' => 'fa fa-linkedin',
					'mg_member_icon_link' => [
						'url' => 'https://linkedin.com',
					],
				],
				[
					'$mg_team_social_icon' => 'fa fa-instagram',
					'mg_member_icon_link' => [
						'url' => 'https://instagram.com',
					],
				],


			];
			$title_field = '<i class="{{ $mg_team_social_icon }}"></i>';
		} else {
			$default = [
				[
					'mg_team_social_selected_icon' => [
						'value' => 'fab fa-facebook-f',
						'library' => 'fa-brands'
					],
					'mg_member_icon_link' => [
						'url' => 'https://facebook.com',
					],
				],
				[
					'mg_team_social_selected_icon' => [
						'value' => 'fab fa-twitter',
						'library' => 'fa-brands'
					],
					'mg_member_icon_link' => [
						'url' => 'https://twitter.com',
					],
				],
				[
					'mg_team_social_selected_icon' => [
						'value' => 'fab fa-linkedin-in',
						'library' => 'fa-brands'
					],
					'mg_member_icon_link' => [
						'url' => 'https://linkedin.com',
					],
				],
				[
					'mg_team_social_selected_icon' => [
						'value' => 'fab fa-instagram',
						'library' => 'fa-brands'
					],
					'mg_member_icon_link' => [
						'url' => 'https://instagram.com',
					],
				],


			];
			$title_field = '<i class="{{ mg_team_social_selected_icon.value }}"></i>';
		}


		$this->add_control(
			'mg_memeber_icon_list',
			[
				'label' => __('Social Profiles', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => $default,
				'title_field' => $title_field,
				'condition' => [
					'mg_display_social' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'mg_social_icon_align',
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
				'default' => 'center',
				'condition' => [
					'mg_display_social' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .mg-social' => 'text-align: {{VALUE}};',
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
			'mg_team_basic_style',
			[
				'label' => __('Basic style', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'mg_team_content_padding',
			[
				'label' => __('Content Padding', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-team-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'mg_team_content_bg_color',
			[
				'label' => __('Content Background color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-team-content' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'mg_team_content_border_radius',
			[
				'label' => __('Border Radius', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-team-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'mg_team_content_border',
				'selector' => '{{WRAPPER}} .mg-team-content',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'mg_team_img_style',
			[
				'label' => __('Image style', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'mg_team_img_width',
			[
				'label' => __('Image Width', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
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
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .mg-team-img figure img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'mg_team_img_auto_height',
			[
				'label' => __('Image auto height', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('On', 'magical-addons-for-elementor'),
				'label_off' => __('Off', 'magical-addons-for-elementor'),
				'default' => 'no',
			]
		);
		$this->add_control(
			'mg_team_img_height',
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
					'mg_team_img_auto_height!' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .mg-team-img figure img, .mg-team-style2 .team-bg-img img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'mg_team_imgbg_height',
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
					'mg_team_img_auto_height!' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .mg-team-img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'mg_team_round_img_width',
			[
				'label' => __('Round Avatar Width', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
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
				'default' => [
					'unit' => 'px',
					'size' => 150,
				],
				'condition' => [
					'all_basic_style' => 'style2',
				],
				'selectors' => [
					'{{WRAPPER}} .mg-team-style2 .mg-round-img img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'mg_team_round_img_height',
			[
				'label' => __('Round Avatar Height', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
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
				'default' => [
					'unit' => 'px',
					'size' => 150,
				],
				'condition' => [
					'all_basic_style' => 'style2',
				],
				'selectors' => [
					'{{WRAPPER}} .mg-team-style2 .mg-round-img img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'mg_team_img_padding',
			[
				'label' => __('Padding', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-team-img figure img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'mg_team_img_margin',
			[
				'label' => __('Margin', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-team-img figure img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'mg_team_img_border_radius',
			[
				'label' => __('Border Radius', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-team-img figure img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],

			]
		);
		$this->add_control(
			'mg_team_imgbg_color',
			[
				'label' => __('Background Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mg-team-img' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'mg_team_img_border',
				'selector' => '{{WRAPPER}} .mg-team-img figure img',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'mg_team_member_details_style',
			[
				'label' => __('Member Name', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'mg_member_name_padding',
			[
				'label' => __('Padding', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-member-name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'mg_member_name_margin',
			[
				'label' => __('Margin', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-member-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'mg_member_name_color',
			[
				'label' => __('Text Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-member-name' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'mg_member_name_bgcolor',
			[
				'label' => __('Background Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-member-name' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'mg_member_descb_radius',
			[
				'label' => __('Border Radius', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-member-name' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'mg_member_name_typography',
				'selector' => '{{WRAPPER}} .mg-member-name',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'mg_team_member_designation_style',
			[
				'label' => __('Member Designation', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'mgtm_designation_padding',
			[
				'label' => __('Padding', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-designation' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'mgtm_designation_margin',
			[
				'label' => __('Margin', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-designation' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'mgtm_designation_color',
			[
				'label' => __('Text Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-designation' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'mgtm_designation_bgcolor',
			[
				'label' => __('Background Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-designation' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'mgtm_designation_radius',
			[
				'label' => __('Border Radius', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-designation' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'designation_typography',
				'selector' => '{{WRAPPER}} .mg-designation',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'mgtm_team_description_style',
			[
				'label' => __('Description', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'mgtm_description_padding',
			[
				'label' => __('Padding', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-team-content p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'mgtm_description_margin',
			[
				'label' => __('Margin', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-team-content p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'mgtm_description_color',
			[
				'label' => __('Text Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-team-content p' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'mgtm_description_bgcolor',
			[
				'label' => __('Background Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-team-content p' => 'background-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'mgtm_description_radius',
			[
				'label' => __('Border Radius', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-team-content p' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'mgtm_description_typography',
				'selector' => '{{WRAPPER}} .mg-team-content p',
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'mgtm_social_style',
			[
				'label' => __('Social Style', 'magical-addons-for-elementor'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'mgtm_icon_padding',
			[
				'label' => __('Padding', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-social ul li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'mgtm_icon_margin',
			[
				'label' => __('Margin', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-social ul li a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'mgtm_icon_typography',
				'selector' => '{{WRAPPER}} .mg-social ul li a',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'mgtm_icon_border',
				'selector' => '{{WRAPPER}} .mg-social ul li a',
			]
		);

		$this->add_control(
			'mgtm_icon_border_radius',
			[
				'label' => __('Border Radius', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-social ul li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'mgtm_icon_box_shadow',
				'selector' => '{{WRAPPER}} .mg-social ul li a',
			]
		);
		$this->add_control(
			'mgtm_icon_color_header',
			[
				'label' => __('Icon color', 'plugin-name'),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs('team_social_icon_tabs');

		$this->start_controls_tab(
			'mgtm_icon_normal_style',
			[
				'label' => __('Normal', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'mgtm_icon_color',
			[
				'label' => __('Text Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mg-social ul li a i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mgtm_icon_bg_color',
			[
				'label' => __('Background Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-social ul li a' => 'background-color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab(
			'mgtm_icon_hover_style',
			[
				'label' => __('Hover', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'mgtm_icon_hcolor',
			[
				'label' => __('Icon Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-social ul li a:hover i, {{WRAPPER}} .mg-btn:focus' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_hbg_color',
			[
				'label' => __('Background Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-social ul li a:hover, {{WRAPPER}} .mg-btn:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'mgtm_icon_hborder_color',
			[
				'label' => __('Border Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'condition' => [
					'mgtm_icon_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .mg-social ul li a:hover, {{WRAPPER}} .mg-social ul li a i:focus' => 'border-color: {{VALUE}};',
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

		$all_basic_style = $this->get_settings('all_basic_style');
		$team_imgbg_image = $this->get_settings('team_imgbg_image');
		$member_img = $this->get_settings('member_img');

		//Member name
		$mg_member_name = $this->get_settings('mg_member_name');
		$mg_member_name_tag = $this->get_settings('mg_member_name_tag');
		$this->add_inline_editing_attributes('mg_member_name');
		$this->add_render_attribute('mg_member_name', 'class', 'mg-member-name');
		//designation
		$mg_member_designation = $this->get_settings('mg_member_designation');
		$this->add_inline_editing_attributes('mg_member_designation');
		$this->add_render_attribute('mg_member_designation', 'class', 'mg-designation');
		//description
		$mg_member_desc = $this->get_settings('mg_member_desc');
		$this->add_inline_editing_attributes('mg_member_desc');


		// social list item
		$mg_display_social = $this->get_settings('mg_display_social');
		$mg_memeber_icon_list = $this->get_settings('mg_memeber_icon_list'); //Repeter



?>
		<div class="mg-team-member <?php if ($all_basic_style == 'style1') :  ?>style1<?php else : ?>mg-team-style2<?php endif; ?>">
			<?php if ($all_basic_style == 'style1') : ?>
				<?php if ($member_img['url'] || $member_img['id']) : ?>
					<div class="mg-team-img">
						<figure>
							<?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'member_img'); ?>
						</figure>
					</div>
				<?php endif; ?>
			<?php else : ?>
				<div class="mg-team-img">
					<?php if ($team_imgbg_image['url'] || $team_imgbg_image['id']) : ?>
						<div class="team-bg-img">
							<?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'bgimg_thumbnail', 'team_imgbg_image'); ?>
						</div>
					<?php endif; ?>
					<?php if ($member_img['url'] || $member_img['id']) : ?>
						<figure class="mg-round-img">
							<?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'member_img'); ?>
						</figure>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			<div class="mg-team-content">
				<?php
				if ($mg_member_name) :
					printf(
						'<%1$s %2$s>%3$s</%1$s>',
						tag_escape($mg_member_name_tag),
						$this->get_render_attribute_string('mg_member_name'),
						mg_kses_tags($mg_member_name)
					);
				endif;
				?>
				<?php if ($mg_member_designation) : ?>
					<span <?php echo $this->get_render_attribute_string('mg_member_designation'); ?>><?php echo mg_kses_tags($mg_member_designation); ?></span>
				<?php endif; ?>
				<?php if ($mg_member_desc) : ?>
					<p <?php echo $this->get_render_attribute_string('mg_member_desc'); ?>><?php echo wp_kses_post($mg_member_desc); ?></p>
				<?php endif; ?>
				<?php if ($mg_memeber_icon_list && $mg_display_social == 'yes') : ?>
					<div class="mg-social">
						<ul>
							<?php
							foreach ($mg_memeber_icon_list as $index => $memeber_icon) :
								$key1 = $this->get_repeater_setting_key('mg_member_icon_link', 'mg_memeber_icon_list', $index);

								$this->add_render_attribute($key1, 'href', esc_url($memeber_icon['mg_member_icon_link']['url']));
								if (!empty($memeber_icon['mg_member_icon_link']['is_external'])) {
									$this->add_render_attribute($key1, 'target', '_blank');
								}
								if (!empty($memeber_icon['mg_member_icon_link']['nofollow'])) {
									$this->set_render_attribute($key1, 'rel', 'nofollow');
								}
							?>
								<li><a <?php echo $this->get_render_attribute_string($key1); ?>>

										<?php mg_icons_render($memeber_icon, 'mg_team_social_icon', 'mg_team_social_selected_icon'); ?>
									</a></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>
			</div>
		</div>



	<?php
	}

	protected function content_template()
	{

	?>
		<# view.addInlineEditingAttributes( 'mg_member_name' ); view.addRenderAttribute( 'mg_member_name' , 'class' , 'mg-member-name' ); view.addInlineEditingAttributes( 'mg_member_designation' ); view.addRenderAttribute( 'mg_member_designation' , 'class' , 'mg-designation' ); view.addInlineEditingAttributes( 'mg_member_desc' ); if ( settings.member_img.url || settings.member_img.id ) { var image={ id: settings.member_img.id, url: settings.member_img.url, size: settings.thumbnail, dimension: settings.thumbnail_custom_dimension, model: view.getEditModel() }; var image_url=elementor.imagesManager.getImageUrl( image ); } #>
			<div class="mg-team-member <# if (settings.all_basic_style === 'style1') { #>style1<# } else { #>mg-team-style2<# } #>">
				<# if( settings.all_basic_style==='style1' ){ #>
					<# if( settings.member_img.url || settings.member_img.id ){ #>
						<div class="mg-team-img">
							<figure>
								<img alt="Team Image" src="{{ image_url }}">
							</figure>
						</div>
						<# } #>
							<# } else{ #>
								<div class="mg-team-img">
									<# if ( settings.team_imgbg_image.url || settings.team_imgbg_image.id ) { var bgimage={ id: settings.team_imgbg_image.id, url: settings.team_imgbg_image.url, size: settings.bgimg_thumbnail, dimension: settings.thumbnail_custom_dimension, model: view.getEditModel() }; var bgimage_url=elementor.imagesManager.getImageUrl( bgimage ); #>
										<div class="team-bg-img">
											<img alt="Team Bg Image" src="{{ bgimage_url }}">
										</div>
										<# } #>
											<# if( settings.member_img.url || settings.member_img.id ){ #>
												<figure class="mg-round-img">
													<img alt="Team Image" src="{{ image_url }}">
												</figure>
												<# } #>
								</div>
								<# } #>
									<div class="mg-team-content">
										<# if (settings.mg_member_name) { #>
											<{{ settings.mg_member_name_tag }} {{{ view.getRenderAttributeString( 'mg_member_name' ) }}}>{{{ settings.mg_member_name }}}</{{ settings.mg_member_name_tag }}>
											<# } #>
												<# if (settings.mg_member_designation) { #>
													<span {{{ view.getRenderAttributeString( 'mg_member_designation' ) }}}>{{{ settings.mg_member_designation }}}</span>
													<# } #>
														<# if (settings.mg_member_desc) { #>
															<p {{{ view.getRenderAttributeString( 'mg_member_desc' ) }}}>{{{ settings.mg_member_desc }}}</p>
															<# } #>


																<# if(settings.mg_memeber_icon_list && settings.mg_display_social==='yes' ){ #>
																	<div class="mg-social">
																		<ul>
																			<# _.each( settings.mg_memeber_icon_list, function( item, index ) { var iconHTML=elementor.helpers.renderIcon( view, item.mg_team_social_selected_icon, { 'aria-hidden' : true }, 'i' , 'object' ), migrated=elementor.helpers.isIconMigrated( item, 'mg_team_social_selected_icon' ); var key=view.getRepeaterSettingKey('mg_member_icon_link','mg_memeber_icon_list',index); if(item.mg_member_icon_link.url){ view.addRenderAttribute( key, 'href' , item.mg_member_icon_link.url ); }else{ view.addRenderAttribute( key, 'href' , '#' ); } if ( item.mg_member_icon_link.is_external ) { view.addRenderAttribute( key, 'target' , '_blank' ); } if ( item.mg_member_icon_link.nofollow ) { view.addRenderAttribute( key, 'rel' , 'nofollow' ); } #>
																				<li><a {{{ view.getRenderAttributeString( key ) }}}>
																						{{{ iconHTML.value }}}
																					</a></li>

																				<# } ); #>

																		</ul>
																	</div>
																	<# } #>
									</div>
			</div>



	<?php
	}
}
