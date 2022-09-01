<?php

// Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Control_Media;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography as Scheme_Typography;
use Elementor\Core\Schemes\Color as Scheme_Color;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * Image Accordion Widget
 */
class MgAddon_imgAccordion extends \Elementor\Widget_Base
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
		return 'mg_imgaccordion';
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
		return __('MG Image Accordion', 'magical-addons-for-elementor');
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
		return 'eicon-post-navigation';
	}

	public function get_keywords()
	{
		return ['mg', 'accordion', 'image', 'tab', 'images'];
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
	 * Retrieve the list of scripts the image accordion widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_style_depends()
	{
		return array(
			'mg-imgaccordion',
		);
	}
	public function get_script_depends()
	{
		return array(
			'mg-image-accordion',
		);
	}

	/**
	 * Register image accordion widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 2.3.2
	 * @access protected
	 */
	protected function register_controls()
	{

		/*-----------------------------------------------------------------------------------*/
		/*	Content Tab
		/*-----------------------------------------------------------------------------------*/

		/**
		 * Content Tab: Items
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
			'section_items',
			[
				'label'                 => esc_html__('Items', 'magical-addons-for-elementor'),
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs('image_accordion_tabs');

		$repeater->start_controls_tab('tab_content', ['label' => __('Content', 'magical-addons-for-elementor')]);

		$repeater->add_control(
			'title',
			[
				'label'                 => esc_html__('Title', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::TEXT,
				'label_block'           => true,
				'default'               => esc_html__('Accordion Title', 'magical-addons-for-elementor'),
				'dynamic'               => [
					'active'   => true,
				],
			]
		);

		$repeater->add_control(
			'description',
			[
				'label'                 => esc_html__('Description', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::WYSIWYG,
				'label_block'           => true,
				'default'               => esc_html__('Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'magical-addons-for-elementor'),
				'dynamic'               => [
					'active'   => true,
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab('tab_image', ['label' => __('Image', 'magical-addons-for-elementor')]);

		$repeater->add_control(
			'image',
			[
				'label'                 => esc_html__('Choose Image', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::MEDIA,
				'label_block'           => true,
				'dynamic'               => [
					'active'   => true,
				],
				'default'               => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab('tab_link', ['label' => __('Link', 'magical-addons-for-elementor')]);

		$repeater->add_control(
			'show_button',
			[
				'label'                 => __('Show Button', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::SWITCHER,
				'default'               => '',
				'label_on'              => __('Yes', 'magical-addons-for-elementor'),
				'label_off'             => __('No', 'magical-addons-for-elementor'),
				'return_value'          => 'yes',
			]
		);

		$repeater->add_control(
			'link',
			[
				'label'                 => esc_html__('Link', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::URL,
				'label_block'           => true,
				'default'               => [
					'url'           => '#',
					'is_external'   => '',
				],
				'show_external'         => true,
				'condition'             => [
					'show_button'   => 'yes',
				],
			]
		);

		$repeater->add_control(
			'button_text',
			[
				'label'                 => __('Button Text', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::TEXT,
				'dynamic'               => [
					'active'   => true,
				],
				'default'               => __('Get Started', 'magical-addons-for-elementor'),
				'condition'             => [
					'show_button'   => 'yes',
				],
			]
		);

		$repeater->add_control(
			'select_button_icon',
			[
				'label'                 => __('Button Icon', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::ICONS,
				'fa4compatibility'      => 'button_icon',
				'condition'             => [
					'show_button'   => 'yes',
				],
			]
		);

		$repeater->add_control(
			'button_icon_position',
			[
				'label'                 => __('Icon Position', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'after',
				'options'               => [
					'before'    => __('Before', 'magical-addons-for-elementor'),
					'after'     => __('After', 'magical-addons-for-elementor'),
				],
				'condition'             => [
					'show_button'   => 'yes',
					'select_button_icon[value]!'  => '',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'accordion_items',
			[
				'type'                  => Controls_Manager::REPEATER,
				'seperator'             => 'before',
				'default'               => [
					[
						'title'         => esc_html__('Accordion #1', 'magical-addons-for-elementor'),
						'description'   => esc_html__('Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'magical-addons-for-elementor'),
						'image'         => [
							'url' => Utils::get_placeholder_image_src(),
						],
					],
					[
						'title'         => esc_html__('Accordion #2', 'magical-addons-for-elementor'),
						'description'   => esc_html__('Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'magical-addons-for-elementor'),
						'image'         => [
							'url' => Utils::get_placeholder_image_src(),
						],
					],
					[
						'title'         => esc_html__('Accordion #3', 'magical-addons-for-elementor'),
						'description'   => esc_html__('Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'magical-addons-for-elementor'),
						'image'         => [
							'url' => Utils::get_placeholder_image_src(),
						],
					],
					[
						'title'         => esc_html__('Accordion #4', 'magical-addons-for-elementor'),
						'description'   => esc_html__('Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'magical-addons-for-elementor'),
						'image'         => [
							'url' => Utils::get_placeholder_image_src(),
						],
					],
				],
				'fields'        => $repeater->get_controls(),
				'title_field' => '{{title}}',
			]
		);

		$this->add_control(
			'active_tab',
			[
				'label'                 => __('Default Active Item', 'magical-addons-for-elementor'),
				'description'                 => __('Add item number to make that item active by default. For example: Add 1 to make first item active by default.', 'magical-addons-for-elementor'),
				'type'                  => \Elementor\Controls_Manager::NUMBER,
				'min'                   => 1,
				'max'                   => 100,
				'step'                  => 1,
				'default'               => '',
				'separator'             => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_image_accordion_settings',
			[
				'label'                 => esc_html__('Settings', 'magical-addons-for-elementor'),
			]
		);

		$this->add_responsive_control(
			'accordion_height',
			[
				'label'                 => esc_html__('Height', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::SLIDER,
				'range'                 => [
					'px'        => [
						'min'   => 50,
						'max'   => 1000,
						'step'  => 1,
					],
				],
				'size_units'            => ['px'],
				'default'               => [
					'size' => 400,
					'unit' => 'px',
				],
				'selectors'             => [
					'{{WRAPPER}} .mg-image-accordion' => 'height: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'title_html_tag',
			[
				'label'                => __('Title HTML Tag', 'magical-addons-for-elementor'),
				'type'                 => Controls_Manager::SELECT,
				'default'              => 'h2',
				'separator'             => 'before',
				'options'              => [
					'h1'     => __('H1', 'magical-addons-for-elementor'),
					'h2'     => __('H2', 'magical-addons-for-elementor'),
					'h3'     => __('H3', 'magical-addons-for-elementor'),
					'h4'     => __('H4', 'magical-addons-for-elementor'),
					'h5'     => __('H5', 'magical-addons-for-elementor'),
					'h6'     => __('H6', 'magical-addons-for-elementor'),
					'div'    => __('div', 'magical-addons-for-elementor'),
					'span'   => __('span', 'magical-addons-for-elementor'),
					'p'      => __('p', 'magical-addons-for-elementor'),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'                  => 'image',
				'label'                 => __('Image Size', 'magical-addons-for-elementor'),
				'default'               => 'full',
			]
		);

		$this->add_control(
			'accordion_action',
			[
				'label'                 => esc_html__('Accordion Action', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'on-hover',
				'label_block'           => false,
				'options'               => [
					'on-hover'  => esc_html__('On Hover', 'magical-addons-for-elementor'),
					'on-click'  => esc_html__('On Click', 'magical-addons-for-elementor'),
				],
				'frontend_available'    => true,
			]
		);

		$this->add_control(
			'orientation',
			[
				'label'                 => esc_html__('Orientation', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'vertical',
				'label_block'           => false,
				'options'               => [
					'vertical'      => esc_html__('Vertical', 'magical-addons-for-elementor'),
					'horizontal'    => esc_html__('Horizontal', 'magical-addons-for-elementor'),
				],
				'frontend_available'    => true,
				'prefix_class'          => 'mg-image-accordion-orientation-',
			]
		);

		$this->add_control(
			'stack_on',
			[
				'label'                 => esc_html__('Stack On', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'tablet',
				'label_block'           => false,
				'options'               => [
					'tablet'    => esc_html__('Tablet', 'magical-addons-for-elementor'),
					'mobile'    => esc_html__('Mobile', 'magical-addons-for-elementor'),
					'none'      => esc_html__('None', 'magical-addons-for-elementor'),
				],
				'frontend_available'    => true,
				'prefix_class'          => 'mg-image-accordion-stack-on-',
				'condition'             => [
					'orientation'   => 'vertical',
				],
			]
		);

		$this->end_controls_section();
		$this->link_pro_added();

		/*-----------------------------------------------------------------------------------*/
		/*	Style Tab
		/*-----------------------------------------------------------------------------------*/

		/**
		 * Style Tab: Items
		 */
		$this->start_controls_section(
			'section_items_style',
			[
				'label'                 => esc_html__('Items', 'magical-addons-for-elementor'),
				'tab'                   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'items_spacing',
			[
				'label'                 => esc_html__('Items Spacing', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::SLIDER,
				'range'                 => [
					'px'        => [
						'min'   => 0,
						'max'   => 50,
						'step'  => 1,
					],
				],
				'size_units'            => ['px'],
				'default'               => [
					'size' => '',
					'unit' => 'px',
				],
				'selectors'             => [
					'(desktop){{WRAPPER}}.mg-image-accordion-orientation-vertical .mg-image-accordion-item:not(:last-child)' => 'margin-right: {{SIZE}}px',
					'(desktop){{WRAPPER}}.mg-image-accordion-orientation-horizontal .mg-image-accordion-item:not(:last-child)' => 'margin-bottom: {{SIZE}}px',
					'(tablet){{WRAPPER}}.mg-image-accordion-orientation-vertical.mg-image-accordion-stack-on-tablet .mg-image-accordion-item:not(:last-child)' => 'margin-bottom: {{SIZE}}px;',
					'(mobile){{WRAPPER}}.mg-image-accordion-orientation-vertical.mg-image-accordion-stack-on-mobile .mg-image-accordion-item:not(:last-child)' => 'margin-bottom: {{SIZE}}px;',
				],
			]
		);

		$this->start_controls_tabs('tabs_items_style');

		$this->start_controls_tab(
			'tab_items_normal',
			[
				'label'                 => __('Normal', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'accordion_img_overlay_color',
			[
				'label'                 => esc_html__('Overlay Color', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::COLOR,
				'default'               => 'rgba(0,0,0,0.3)',
				'selectors'             => [
					'{{WRAPPER}} .mg-image-accordion-item .mg-image-accordion-overlay' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'items_border',
				'label'                 => esc_html__('Border', 'magical-addons-for-elementor'),
				'selector'              => '{{WRAPPER}} .mg-image-accordion-item',
			]
		);

		$this->add_control(
			'items_border_radius',
			[
				'label'                 => __('Border Radius', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => ['px', 'em', '%'],
				'selectors'             => [
					'{{WRAPPER}} .mg-image-accordion-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'items_box_shadow',
				'selector'              => '{{WRAPPER}} .mg-image-accordion-item',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_items_hover',
			[
				'label'                 => __('Hover', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'accordion_img_hover_color',
			[
				'label'                 => esc_html__('Overlay Color', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::COLOR,
				'default'               => 'rgba(0,0,0,0.5)',
				'selectors'             => [
					'{{WRAPPER}} .mg-image-accordion-item:hover .mg-image-accordion-overlay' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .mg-image-accordion-item.mg-image-accordion-active .mg-image-accordion-overlay' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'items_border_color_hover',
			[
				'label'                 => esc_html__('Border Color', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .mg-image-accordion-item:hover, {{WRAPPER}} .mg-image-accordion-item.mg-image-accordion-active' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'items_box_shadow_hover',
				'selector'              => '{{WRAPPER}} .mg-image-accordion-item:hover, {{WRAPPER}} .mg-image-accordion-item.mg-image-accordion-active',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Style Tab: Content
		 */
		$this->start_controls_section(
			'section_content_style',
			[
				'label'                 => esc_html__('Content', 'magical-addons-for-elementor'),
				'tab'                   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_bg_color',
			[
				'label'                 => esc_html__('Background Color', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .mg-image-accordion .mg-image-accordion-content' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'content_border',
				'label'                 => esc_html__('Border', 'magical-addons-for-elementor'),
				'selector'              => '{{WRAPPER}} .mg-image-accordion .mg-image-accordion-content',
				'separator'             => 'before',
			]
		);

		$this->add_control(
			'content_border_radius',
			[
				'label'                 => __('Border Radius', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => ['px', 'em', '%'],
				'selectors'             => [
					'{{WRAPPER}} .mg-image-accordion .mg-image-accordion-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_vertical_align',
			[
				'label'                 => __('Vertical Align', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::CHOOSE,
				'default'               => 'middle',
				'options'               => [
					'top'       => [
						'title' => __('Top', 'magical-addons-for-elementor'),
						'icon'  => 'eicon-v-align-top',
					],
					'middle'    => [
						'title' => __('Middle', 'magical-addons-for-elementor'),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom'    => [
						'title' => __('Bottom', 'magical-addons-for-elementor'),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'selectors_dictionary'  => [
					'top'       => 'flex-start',
					'middle'    => 'center',
					'bottom'    => 'flex-end',
				],
				'selectors'             => [
					'{{WRAPPER}} .mg-image-accordion .mg-image-accordion-overlay' => '-webkit-align-items: {{VALUE}}; -ms-flex-align: {{VALUE}}; align-items: {{VALUE}};',
				],
				'separator'             => 'before',
			]
		);

		$this->add_responsive_control(
			'content_horizontal_align',
			[
				'label'                 => __('Horizontal Align', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::CHOOSE,
				'label_block'           => true,
				'options'               => [
					'left'      => [
						'title' => __('Left', 'magical-addons-for-elementor'),
						'icon'  => 'eicon-h-align-left',
					],
					'center'           => [
						'title' => __('Center', 'magical-addons-for-elementor'),
						'icon'  => 'eicon-h-align-center',
					],
					'right'            => [
						'title' => __('Right', 'magical-addons-for-elementor'),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'               => 'center',
				'selectors_dictionary'  => [
					'left'     => 'flex-start',
					'center'   => 'center',
					'right'    => 'flex-end',
				],
				'selectors'             => [
					'{{WRAPPER}} .mg-image-accordion .mg-image-accordion-overlay' => '-webkit-justify-content: {{VALUE}}; justify-content: {{VALUE}};',
					'{{WRAPPER}} .mg-image-accordion .mg-image-accordion-content-wrap' => '-webkit-align-items: {{VALUE}}; -ms-flex-align: {{VALUE}}; align-items: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'text_align',
			[
				'label'                 => __('Text Align', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::CHOOSE,
				'default'               => ' center',
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
				],
				'selectors'             => [
					'{{WRAPPER}} .mg-image-accordion .mg-image-accordion-content' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_width',
			[
				'label'                 => esc_html__('Width', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::SLIDER,
				'range'                 => [
					'px'        => [
						'min'   => 0,
						'max'   => 400,
						'step'  => 1,
					],
				],
				'size_units'            => ['px', '%'],
				'default'               => [
					'size' => '',
					'unit' => 'px',
				],
				'selectors'             => [
					'{{WRAPPER}} .mg-image-accordion .mg-image-accordion-content' => 'width: {{SIZE}}{{UNIT}}',
				],
				'separator'             => 'before',
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'                 => __('Padding', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => ['px', 'em', '%'],
				'selectors'             => [
					'{{WRAPPER}} .mg-image-accordion .mg-image-accordion-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'title_style_heading',
			[
				'label'                 => __('Title', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'                 => esc_html__('Color', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '#fff',
				'selectors'             => [
					'{{WRAPPER}} .mg-image-accordion .mg-image-accordion-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'                  => 'title_typography',
				'selector'              => '{{WRAPPER}} .mg-image-accordion .mg-image-accordion-title',
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label'                 => esc_html__('Spacing', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::SLIDER,
				'range'                 => [
					'px'        => [
						'min'   => 0,
						'max'   => 50,
						'step'  => 1,
					],
				],
				'size_units'            => ['px'],
				'default'               => [
					'size' => '',
					'unit' => 'px',
				],
				'selectors'             => [
					'{{WRAPPER}} .mg-image-accordion .mg-image-accordion-title' => 'margin-bottom: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'description_style_heading',
			[
				'label'                 => __('Description', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'                 => esc_html__('Color', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '#fff',
				'selectors'             => [
					'{{WRAPPER}} .mg-image-accordion .mg-image-accordion-description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'                  => 'description_typography',
				'selector'              => '{{WRAPPER}} .mg-image-accordion .mg-image-accordion-description',
			]
		);

		$this->end_controls_section();

		/**
		 * Style Tab: Button
		 * -------------------------------------------------
		 */
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

		$this->add_responsive_control(
			'button_spacing',
			[
				'label'                 => esc_html__('Button Spacing', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::SLIDER,
				'range'                 => [
					'px'        => [
						'min'   => 0,
						'max'   => 50,
						'step'  => 1,
					],
				],
				'size_units'            => ['px'],
				'default'               => [
					'size' => 15,
					'unit' => 'px',
				],
				'selectors'             => [
					'{{WRAPPER}} .mg-image-accordion-button' => 'margin-top: {{SIZE}}px',
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
			'mga_button_trans',
			[
				'label' => esc_html__('Transtion Time', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['s'],
				'range' => [
					's' => [
						'min' => 0,
						'max' => 60,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 2,
				],
				'selectors' => [
					'{{WRAPPER}} .mg-image-accordion .mg-image-accordion-button' => 'transition: {{SIZE}}s;',
				],
			]
		);




		$this->add_control(
			'button_bg_color_normal',
			[
				'label'                 => __('Background Color', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .mg-image-accordion-button' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_text_color_normal',
			[
				'label'                 => __('Text Color', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .mg-image-accordion-button' => 'color: {{VALUE}}',
					'{{WRAPPER}} .mg-image-accordion-button .mg-icon svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'                  => 'button_border_normal',
				'label'                 => __('Border', 'magical-addons-for-elementor'),
				'placeholder'           => '1px',
				'default'               => '1px',
				'selector'              => '{{WRAPPER}} .mg-image-accordion-button',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'                 => __('Border Radius', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => ['px', '%'],
				'selectors'             => [
					'{{WRAPPER}} .mg-image-accordion-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'                  => 'button_typography',
				'label'                 => __('Typography', 'magical-addons-for-elementor'),
				'scheme'                => Scheme_Typography::TYPOGRAPHY_4,
				'selector'              => '{{WRAPPER}} .mg-image-accordion-button',
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'                 => __('Padding', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => ['px', 'em', '%'],
				'selectors'             => [
					'{{WRAPPER}} .mg-image-accordion-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'button_box_shadow',
				'selector'              => '{{WRAPPER}} .mg-image-accordion-button',
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
			'button_bg_color_hover',
			[
				'label'                 => __('Background Color', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .mg-image-accordion-button:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_text_color_hover',
			[
				'label'                 => __('Text Color', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .mg-image-accordion-button:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .mg-image-accordion-button:hover .mg-icon svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_border_color_hover',
			[
				'label'                 => __('Border Color', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .mg-image-accordion-button:hover' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_hover_animation',
			[
				'label'                 => __('Animation', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'button_box_shadow_hover',
				'selector'              => '{{WRAPPER}} .mg-image-accordion-button:hover',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'button_icon_heading',
			[
				'label'                 => __('Icon', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::HEADING,
				'separator'             => 'before',
			]
		);

		$this->add_responsive_control(
			'button_icon_spacing',
			[
				'label'                 => esc_html__('Icon Spacing', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::SLIDER,
				'range'                 => [
					'px'        => [
						'min'   => 0,
						'max'   => 50,
						'step'  => 1,
					],
				],
				'size_units'            => ['px'],
				'default'               => [
					'size' => 2,
					'unit' => 'px',
				],
				'selectors'             => [
					'{{WRAPPER}} .mg-button-icon-before .mg-button-icon' => 'margin-right: {{SIZE}}px',
					'{{WRAPPER}} .mg-button-icon-after .mg-button-icon' => 'margin-left: {{SIZE}}px',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render_button_icon($item)
	{
		$settings = $this->get_settings_for_display();

		$migration_allowed = Icons_Manager::is_migration_allowed();

		// add old default
		if (!isset($item['button_icon']) && !$migration_allowed) {
			$item['hotspot_icon'] = '';
		}

		$migrated = isset($item['__fa4_migrated']['select_button_icon']);
		$is_new = !isset($item['button_icon']) && $migration_allowed;

		if (!empty($item['button_icon']) || (!empty($item['select_button_icon']['value']) && $is_new)) {
?>
			<span class="mg-button-icon mg-icon mg-no-trans">
				<?php if ($is_new || $migrated) {
					Icons_Manager::render_icon($item['select_button_icon'], ['aria-hidden' => 'true']);
				} else { ?>
					<i class="<?php echo esc_attr($item['button_icon']); ?>" aria-hidden="true"></i>
				<?php } ?>
			</span>
		<?php
		}
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute('image-accordion', [
			'class' => ['mg-image-accordion', 'item-visiable', 'mg-image-accordion-' . $settings['accordion_action']],
			'id'    => 'mg-image-accordion-' . $this->get_id(),
		]);

		if (!empty($settings['accordion_items'])) { ?>
			<div <?php echo wp_kses_post($this->get_render_attribute_string('image-accordion')); ?>>
				<?php foreach ($settings['accordion_items'] as $index => $item) { ?>
					<?php
					$item_key = $this->get_repeater_setting_key('item', 'accordion_items', $index);

					$this->add_render_attribute($item_key, [
						'class' => ['mg-image-accordion-item', 'elementor-repeater-item-' . esc_attr($item['_id'])],
					]);

					if ($item['image']['url']) {

						$image_url = Group_Control_Image_Size::get_attachment_image_src($item['image']['id'], 'image', $settings);

						if (!$image_url) {
							$image_url = $item['image']['url'];
						}

						$this->add_render_attribute($item_key, [
							'style' => 'background-image: url(' . $image_url . ');',
						]);
					}

					$content_key = $this->get_repeater_setting_key('content', 'accordion_items', $index);

					$this->add_render_attribute($content_key, 'class', 'mg-image-accordion-content-wrap');

					if ('yes' === $item['show_button'] && !empty($item['link']['url'])) {
						$button_key = $this->get_repeater_setting_key('button', 'accordion_items', $index);

						$this->add_render_attribute($button_key, 'class', [
							'mg-image-accordion-button',
							'mg-button-icon-' . $item['button_icon_position'],
							'elementor-button',
							'elementor-size-' . $settings['button_size'],
						]);

						if ($settings['button_hover_animation']) {
							$this->add_render_attribute($button_key, 'class', 'elementor-animation-' . $settings['button_hover_animation']);
						}

						$this->add_link_attributes($button_key, $item['link']);
					}

					if ($settings['active_tab']) {
						$tab_count = $settings['active_tab'] - 1;
						if ($index === $tab_count) {
							$this->add_render_attribute($item_key, [
								'class' => 'mg-image-accordion-active',
								'style' => 'flex: 3 1 0;',
							]);
							$this->add_render_attribute($content_key, [
								'class' => 'mg-image-accordion-content-active',
							]);
						}
					}
					?>
					<div <?php echo wp_kses_post($this->get_render_attribute_string($item_key)); ?>>
						<div class="mg-image-accordion-overlay mg-media-overlay">
							<div <?php echo wp_kses_post($this->get_render_attribute_string($content_key)); ?>>
								<div class="mg-image-accordion-content">
									<?php $title_tag = $settings['title_html_tag']; ?>
									<<?php echo esc_html($title_tag); ?> class="mg-image-accordion-title">
										<?php echo wp_kses_post($item['title']); ?>
									</<?php echo esc_html($title_tag); ?>>
									<div class="mg-image-accordion-description">
										<?php echo $this->parse_text_editor($item['description']); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
										?>
									</div>
								</div>
								<?php if ('yes' === $item['show_button'] && $item['link']['url']) { ?>
									<div class="mg-image-accordion-button-wrap">
										<a <?php echo wp_kses_post($this->get_render_attribute_string($button_key)); ?>>
											<?php
											if ('before' === $item['button_icon_position']) {
												$this->render_button_icon($item);
											}
											?>
											<?php if (!empty($item['button_text'])) { ?>
												<span class="mg-button-text">
													<?php echo wp_kses_post($item['button_text']); ?>
												</span>
											<?php } ?>
											<?php
											if ('after' === $item['button_icon_position']) {
												$this->render_button_icon($item);
											}
											?>
										</a>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
<?php }
	}
}
