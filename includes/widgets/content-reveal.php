<?php

// Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Core\Schemes\Color as Scheme_Color;
use Elementor\Core\Schemes\Typography as Scheme_Typography;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * Content Reveal Widget
 */
class MgAddon_contentReveal extends \Elementor\Widget_Base
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
		return 'mg_contentReveal';
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
		return __('MG Content Reveal', 'magical-addons-for-elementor');
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
		return 'eicon-exchange';
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords()
	{
		return ['mg', 'content', 'reveal', 'expand', 'readmore'];
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
	 * Retrieve the list of scripts the Content Reveal widget depended on.
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
			'mg-content-reveal',
		];
	}

	/**
	 * Register Content Reveal widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 2.5.0
	 * @access protected
	 */
	protected function register_controls()
	{ // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore

		/*-----------------------------------------------------------------------------------*/
		/*	CONTENT TAB
		/*-----------------------------------------------------------------------------------*/
		$this->start_controls_section(
			'section_content',
			[
				'label'                 => __('Content', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'content_type',
			[
				'label'                 => esc_html__('Content Type', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::SELECT,
				'label_block'           => false,
				'options'               => [
					'content'   => __('Content', 'magical-addons-for-elementor'),
					'template'  => __('Template', 'magical-addons-for-elementor'),
				],
				'default'               => 'content',
			]
		);

		$this->add_control(
			'content',
			[
				'label'                 => '',
				'type'                  => Controls_Manager::WYSIWYG,
				'dynamic'               => ['active' => true],
				'default'               => __("Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.", 'magical-addons-for-elementor'),
				'condition'             => [
					'content_type' => 'content',
				],
			]
		);

		$this->add_control(
			'template',
			[
				'label' => __('Choose Template', 'magical-addons-for-elementor'),
				'type'  => Controls_Manager::SELECT,
				'default'  => '',
				'options'  => mg_display_posts_name('elementor_library'),
				'condition'             => [
					'content_type' => 'template',
				],
			]
		);


		$this->add_control(
			'separator',
			[
				'label'                 => __('Show Separator', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => 'yes',
				'return_value'          => 'yes',
				'separator'             => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_settings',
			[
				'label'                 => __('Settings', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'speed_unreveal',
			[
				'label'                 => __('Transition Speed', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::SLIDER,
				'dynamic'               => ['active' => true],
				'default'               => [
					'size'  => 0.5,
				],
				'range'                 => [
					'px'    => [
						'max' => 2,
						'min' => 0.1,
						'step' => 0.1,
					],
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'visible_type',
			[
				'label'                 => __('Content Visibility By', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'pixels',
				'options'               => [
					'lines'  => __('Lines', 'magical-addons-for-elementor'),
					'pixels' => __('Pixels', 'magical-addons-for-elementor'),
				],
				'frontend_available'    => 'true',
				'condition'             => [
					'content_type' => 'content',
				],
			]
		);

		$this->add_control(
			'visible_amount',
			[
				'label'                 => __('Visible Amount (px)', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::SLIDER,
				'dynamic'               => ['active' => true],
				'default'               => [
					'size'  => 50,
				],
				'range'                 => [
					'px'        => [
						'max' => 200,
						'min' => 10,
					],
				],
				'frontend_available'    => true,
				'selectors'             => [
					'{{WRAPPER}} .mg-content-reveal-content-wrapper' => 'height: {{SIZE}}{{UNIT}}',
				],
				'render_type'           => 'template',
				'conditions'            => [
					'relation'  => 'or',
					'terms'     => [
						[
							'name' => 'content_type',
							'operator' => '===',
							'value' => 'template',
						],
						[
							'relation'  => 'and',
							'terms'     => [
								[
									'name' => 'content_type',
									'operator' => '===',
									'value' => 'content',
								],
								[
									'name' => 'visible_type',
									'operator' => '===',
									'value' => 'pixels',
								],
							],
						],
					],
				],
			]
		);

		$this->add_control(
			'visible_lines',
			[
				'label'                 => __('Visible Amount (lines)', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::SLIDER,
				'dynamic'               => ['active' => true],
				'default'               => [
					'size'  => 2,
				],
				'range'                 => [
					'px'    => [
						'max' => 20,
						'min' => 1,
					],
				],
				'condition'             => [
					'visible_type' => 'lines',
				],
				'frontend_available'    => true,
			]
		);

		$this->add_control(
			'content_valid_warning',
			[
				'type'                  => Controls_Manager::RAW_HTML,
				'raw'                   => __('Make sure your WYSIWYG content is valid HTML.', 'magical-addons-for-elementor'),
				'content_classes'       => 'elementor-panel-alert elementor-panel-alert-warning',
				'condition'             => [
					'visible_type' => 'lines',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button',
			[
				'label'                 => __('Button', 'magical-addons-for-elementor'),
			]
		);

		$this->add_responsive_control(
			'button_align',
			[
				'label'                 => __('Alignment', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::CHOOSE,
				'default'               => 'center',
				'options'               => [
					'left'  => [
						'title'     => __('Left', 'magical-addons-for-elementor'),
						'icon'      => 'eicon-h-align-left',
					],
					'center'        => [
						'title'     => __('Center', 'magical-addons-for-elementor'),
						'icon'      => 'eicon-h-align-center',
					],
					'right'         => [
						'title'     => __('Right', 'magical-addons-for-elementor'),
						'icon'      => 'eicon-h-align-right',
					],
				],
				'selectors_dictionary'  => [
					'left'     => 'flex-start',
					'right'    => 'flex-end',
					'center'   => 'center',
				],
				'selectors'             => [
					'{{WRAPPER}} .mg-content-reveal-buttons-wrapper'   => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs('tabs_button_content');

		$this->start_controls_tab(
			'tab_button_closed',
			[
				'label'                 => __('Content Unreveal', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'button_text_closed',
			[
				'label'                 => __('Label', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::TEXT,
				'dynamic'               => ['active' => true],
				'default'               => __('Read More', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'button_icon_closed',
			[
				'label'                 => __('Icon', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::ICONS,
				'label_block'           => false,
				'skin'                  => 'inline',
				'default'               => array(
					'value'   => 'fas fa-angle-down',
					'library' => 'fa-solid',
				),
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_open',
			[
				'label'                 => __('Content Reveal', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'button_text_open',
			[
				'label'                 => __('Label', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::TEXT,
				'dynamic'               => ['active' => true],
				'default'               => __('Read Less', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'button_icon_open',
			[
				'label'                 => __('Icon', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::ICONS,
				'label_block'           => false,
				'skin'                  => 'inline',
				'default'               => array(
					'value'   => 'fas fa-angle-up',
					'library' => 'fa-solid',
				),
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'button_icon_position',
			[
				'label'                 => __('Icon Position', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'after',
				'options'               => [
					'after'     => __('After', 'magical-addons-for-elementor'),
					'before'    => __('Before', 'magical-addons-for-elementor'),
				],
				'conditions'            => [
					'relation'  => 'or',
					'terms'     => [
						[
							'name' => 'button_icon_closed',
							'operator' => '!==',
							'value' => '',
						],
						[
							'name' => 'button_icon_open',
							'operator' => '!==',
							'value' => '',
						],
					],
				],
				'separator'             => 'before',
			]
		);

		$this->end_controls_section();
		$this->link_pro_added();

		$this->start_controls_section(
			'section_style_content',
			[
				'label'                 => __('Content', 'magical-addons-for-elementor'),
				'tab'                   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'text_align',
			[
				'label'                 => __('Text Align', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::CHOOSE,
				'options'               => [
					'left'      => [
						'title' => __('Left', 'magical-addons-for-elementor'),
						'icon'  => 'eicon-text-align-left',
					],
					'center'    => [
						'title' => __('Center', 'magical-addons-for-elementor'),
						'icon'  => 'eicon-text-align-center',
					],
					'right'     => [
						'title' => __('Right', 'magical-addons-for-elementor'),
						'icon'  => 'eicon-text-align-right',
					],
					'justify'   => [
						'title' => __('Justify', 'magical-addons-for-elementor'),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .mg-content-reveal-content' => 'text-align: {{VALUE}};',
				],
				'default'               => 'left',
			]
		);

		$this->add_control(
			'content_color',
			[
				'label'                 => __('Color', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::COLOR,
				'selectors'             => [
					'{{WRAPPER}} .mg-content-reveal-content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_background',
			[
				'label'                 => __('Background Color', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::COLOR,
				'selectors'             => [
					'{{WRAPPER}} .mg-content-reveal-content' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'                  => 'content_typography',
				'selector'              => '{{WRAPPER}} .mg-content-reveal-content',
			]
		);

		$this->add_control(
			'content_margin',
			[
				'label'                 => __('margin', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::DIMENSIONS,
				'default'               => [
					'size'      => 10,
				],
				'size_units'            => ['px'],
				'selectors'             => [
					'{{WRAPPER}} .mg-content-reveal-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'content_padding',
			[
				'label'                 => __('Padding', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::DIMENSIONS,
				'default'               => [
					'size'      => 10,
				],
				'size_units'            => ['px'],
				'selectors'             => [
					'{{WRAPPER}} .mg-content-reveal-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_separator_style',
			[
				'label'                 => __('Separator', 'magical-addons-for-elementor'),
				'tab'                   => Controls_Manager::TAB_STYLE,
				'condition'             => [
					'separator' => 'yes',
				],
			]
		);

		$this->add_control(
			'separator_height',
			[
				'label'                 => __('Height', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::SLIDER,
				'dynamic'               => ['active' => true],
				'default'               => [
					'size'  => 50,
					'unit'  => 'px',
				],
				'range'                 => [
					'px'    => [
						'max' => 200,
						'min' => 0,
					],
				],
				'size_units'            => ['px', '%'],
				'selectors'             => [
					'{{WRAPPER}} .mg-content-reveal-saparator' => 'height: {{SIZE}}{{UNIT}}',
				],
				'condition'             => [
					'separator' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'                  => 'separator_background',
				'types'                 => ['gradient', 'classic'],
				'selector'              => '{{WRAPPER}} .mg-content-reveal-saparator',
				'default'               => 'gradient',
				'condition'             => [
					'separator' => 'yes',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_button_style',
			[
				'label'                 => __('Button', 'magical-addons-for-elementor'),
				'tab'                   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'button_size',
			[
				'label'                 => __('Size', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'md',
				'options'               => [
					'xs' => __('Extra Small', 'magical-addons-for-elementor'),
					'sm' => __('Small', 'magical-addons-for-elementor'),
					'md' => __('Medium', 'magical-addons-for-elementor'),
					'lg' => __('Large', 'magical-addons-for-elementor'),
					'xl' => __('Extra Large', 'magical-addons-for-elementor'),
				],
			]
		);

		$this->add_control(
			'button_top_spacing',
			[
				'label'                 => __('Button Top Spacing', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::SLIDER,
				'dynamic'               => ['active' => true],
				'default'               => [
					'size' => 20,
				],
				'range'                 => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .mg-content-reveal-buttons-wrapper' => 'margin-top: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'button_spacing',
			[
				'label'                 => __('Button Spacing', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::SLIDER,
				'dynamic'               => ['active' => true],
				'default'               => [
					'size' => 20,
				],
				'range'                 => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .mg-content-reveal-buttons-wrapper' => 'margin-bottom: {{SIZE}}px',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'                  => 'typography',
				'label'                 => __('Typography', 'magical-addons-for-elementor'),
				'selector'              => '{{WRAPPER}} .mg-content-reveal-button-inner',
				'conditions'            => [
					'relation'  => 'or',
					'terms'     => [
						[
							'name' => 'button_text_open',
							'operator' => '!==',
							'value' => '',
						],
						[
							'name' => 'button_text_closed',
							'operator' => '!==',
							'value' => '',
						],
					],
				],
			]
		);

		$this->start_controls_tabs('tabs_button_style');

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label'                 => __('Normal', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'                 => __('Text Color', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '#ffffff',
				'selectors'             => [
					'{{WRAPPER}} .mg-content-reveal-button-inner' => 'color: {{VALUE}};',
				],
				'conditions'            => [
					'relation'  => 'or',
					'terms'     => [
						[
							'name' => 'button_text_open',
							'operator' => '!==',
							'value' => '',
						],
						[
							'name' => 'button_text_closed',
							'operator' => '!==',
							'value' => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'button_icon_color',
			[
				'label'                 => __('Icon Color', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .mg-button-icon' => 'fill: {{VALUE}}; color: {{VALUE}};',
				],
				'conditions'            => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'button_icon_open',
							'operator' => '!==',
							'value' => '',
						],
						[
							'name' => 'button_icon_closed',
							'operator' => '!==',
							'value' => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'button_background',
			[
				'label'                 => __('Background Color', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .mg-content-reveal-button-inner' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'button_border',
				'label'                 => __('Border', 'magical-addons-for-elementor'),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .mg-content-reveal-button-inner',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'                 => __('Border Radius', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => ['px', '%'],
				'selectors'             => [
					'{{WRAPPER}} .mg-content-reveal-button-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'button_box_shadow',
				'selector'              => '{{WRAPPER}} .mg-content-reveal-button-inner',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label'                 => __('Hover', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'button_text_color_hover',
			[
				'label'                 => __('Text Color', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::COLOR,
				'selectors'             => [
					'{{WRAPPER}} .mg-content-reveal-button-inner:hover' => 'color: {{VALUE}};',
				],
				'conditions'            => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'button_text_open',
							'operator' => '!==',
							'value' => '',
						],
						[
							'name' => 'button_text_closed',
							'operator' => '!==',
							'value' => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'button_icon_color_hover',
			[
				'label'                 => __('Icon Color', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .mg-content-reveal-button-inner:hover .mg-button-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mg-content-reveal-button-inner:hover .mg-button-icon svg' => 'fill: {{VALUE}};',
				],
				'conditions'            => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'button_icon_open',
							'operator' => '!==',
							'value' => '',
						],
						[
							'name' => 'button_icon_closed',
							'operator' => '!==',
							'value' => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'button_background_hover',
			[
				'label'                 => __('Background Color', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::COLOR,
				'selectors'             => [
					'{{WRAPPER}} .mg-content-reveal-button-inner:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_border_color_hover',
			[
				'label'                 => __('Border Color', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::COLOR,
				'selectors'             => [
					'{{WRAPPER}} .mg-content-reveal-button-inner:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'button_text_padding',
			[
				'label'                 => __('Padding', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::DIMENSIONS,
				'default'               => [
					'size'      => '10',
					'unit'      => 'px',
				],
				'size_units'            => ['px', 'em', '%'],
				'selectors'             => [
					'{{WRAPPER}} .mg-content-reveal-button-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_style_heading',
			[
				'label'                 => __('Icon', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
				'conditions'            => [
					'relation' => 'or',
					'terms' => [
						[
							'name'     => 'button_icon_open[value]',
							'operator' => '!==',
							'value'    => '',
						],
						[
							'name'     => 'button_icon_closed[value]',
							'operator' => '!==',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'button_icon_size',
			[
				'label'                 => __('Size', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::SLIDER,
				'default'               => [
					'size' => '20',
				],
				'range'     => [
					'px' => [
						'min' => 6,
						'max' => 100,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .mg-button-icon' => 'font-size: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				],
				'conditions'            => [
					'relation' => 'or',
					'terms' => [
						[
							'name'     => 'button_icon_open[value]',
							'operator' => '!==',
							'value'    => '',
						],
						[
							'name'     => 'button_icon_closed[value]',
							'operator' => '!==',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'button_icon_spacing',
			[
				'label'                 => __('Spacing', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::SLIDER,
				'default'               => [
					'size' => 8,
				],
				'range'                 => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors'             => [
					'{{WRAPPER}} .mg-button-icon-before .mg-button-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .mg-button-icon-after .mg-button-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
				'conditions'            => [
					'relation' => 'or',
					'terms' => [
						[
							'name'     => 'button_icon_open[value]',
							'operator' => '!==',
							'value'    => '',
						],
						[
							'name'     => 'button_icon_closed[value]',
							'operator' => '!==',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render content.
	 *
	 * @since 2.5.0
	 */

	protected function get_content_type()
	{
		$settings     = $this->get_settings_for_display();
		$content_type = $settings['content_type'];
		$output       = '';

		switch ($content_type) {
			case 'content':
				$output = $settings['content'];
				break;

			case 'template':
				$output = \Elementor\Plugin::$instance->frontend->get_builder_content_for_display($settings['template']);
				break;

			default:
				return;
		}

		return $output;
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute([
			'wrapper' => [
				'class'           => 'mg-content-reveal-content-wrapper',
				'data-speed'      => $settings['speed_unreveal']['size'],
				'data-visibility' => ('content' === $settings['content_type']) ? $settings['visible_type'] : 'pixels',
			],
			'button'  => [
				'class'           => [
					'mg-content-reveal-button-inner',
					'elementor-button',
					'elementor-size-' . $settings['button_size'],
				],
			],
		]);

		if (('content' === $settings['content_type'] && 'pixels' === $settings['visible_type'] && $settings['visible_amount']['size']) || ('template' === $settings['content_type'] && $settings['visible_amount']['size'])) {
			$this->add_render_attribute('wrapper', 'data-content-height', $settings['visible_amount']['size']);
		}

		if ('content' === $settings['content_type'] && 'lines' === $settings['visible_type']) {
			$this->add_render_attribute('wrapper', 'data-lines', $settings['visible_lines']['size']);
		}

		if ($settings['button_icon_open'] || $settings['button_icon_closed']) {
			$this->add_render_attribute('button', 'class', 'mg-button-icon-' . $settings['button_icon_position']);
		}
?>
		<div class="mg-content-reveal-container">
			<div <?php echo wp_kses_post($this->get_render_attribute_string('wrapper')); ?>>
				<div class="mg-content-reveal-content">
					<?php echo $this->get_content_type(); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
					?>
				</div>
				<?php if ('yes' === $settings['separator']) { ?>
					<div class="mg-content-reveal-saparator"></div>
				<?php } ?>
			</div>
			<div class="mg-content-reveal-buttons-wrapper">
				<div <?php echo wp_kses_post($this->get_render_attribute_string('button')); ?>>
					<span class="mg-content-reveal-button mg-content-reveal-button-open">
						<span class="mg-content-reveal-button-content">
							<?php if ($settings['button_icon_open']['value']) { ?>
								<span class="mg-button-icon mg-icon"><?php Icons_Manager::render_icon($settings['button_icon_open']); ?></span>
							<?php } ?>
							<?php if ($settings['button_text_open']) { ?>
								<span class="mg-content-reveal-button-text">
									<?php echo wp_kses_post($settings['button_text_open']); ?>
								</span>
							<?php } ?>
						</span>
					</span>
					<span class="mg-content-reveal-button mg-content-reveal-button-closed">
						<span class="mg-content-reveal-button-content">
							<?php if ($settings['button_icon_closed']['value']) { ?>
								<span class="mg-button-icon mg-icon"><?php Icons_Manager::render_icon($settings['button_icon_closed']); ?></span>
							<?php } ?>
							<?php if ($settings['button_text_closed']) { ?>
								<span class="mg-content-reveal-button-text">
									<?php echo wp_kses_post($settings['button_text_closed']); ?>
								</span>
							<?php } ?>
						</span>
					</span>
				</div>
			</div>
		</div>
<?php
	}
}
