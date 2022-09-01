<?php

// Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Schemes\Typography as Scheme_Typography;
use Elementor\Core\Schemes\Color as Scheme_Color;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * Image Comparison Widget
 */
class MgAddon_imgComparison extends \Elementor\Widget_Base
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
		return 'mg_imgcompar_widget';
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
		return __('MG Image Comparison', 'magical-addons-for-elementor');
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
		return 'eicon-image-before-after';
	}

	public function get_keywords()
	{
		return ['mg', 'Comparison', 'compare', 'divider', 'image'];
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
	 * Retrieve the list of scripts the image comparison widget depended on.
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
			'event-move',
			'twentytwenty',
			'twenty-active',
			'imagesloaded',
		];
	}

	/**
	 * Retrieve the list of styles the image comparison widget depended on.
	 *
	 * Used to set styles dependencies required to run the widget.
	 *
	 * @access public
	 *
	 * @return array Widget styles dependencies.
	 */
	public function get_style_depends()
	{
		return [
			'twentytwenty-style',
		];
	}

	/**
	 * Register image comparison widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 2.3.2
	 * @access protected
	 */
	protected function register_controls()
	{
		/* Content Tab */
		$this->register_content_before_image_controls();
		$this->register_content_after_image_controls();
		$this->register_content_settings_controls();

		/* Style Tab */
		$this->register_style_overlay_controls();
		$this->register_style_handle_controls();
		$this->register_style_divider_controls();
		$this->register_style_label_controls();
	}

	/*-----------------------------------------------------------------------------------*/
	/*	CONTENT TAB
	/*-----------------------------------------------------------------------------------*/

	protected function register_content_before_image_controls()
	{
		/**
		 * Content Tab: Before Image
		 */
		$this->start_controls_section(
			'section_before_image',
			[
				'label'             => __('Before Image', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'before_label',
			[
				'label'             => __('Label', 'magical-addons-for-elementor'),
				'type'              => Controls_Manager::TEXT,
				'default'           => __('Before', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'before_image',
			[
				'label'             => __('Image', 'magical-addons-for-elementor'),
				'type'              => Controls_Manager::MEDIA,
				'dynamic'           => [
					'active'   => true,
				],
				'default'           => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'              => 'before_image',
				'default'           => 'full',
				'separator'         => 'none',
			]
		);

		$this->end_controls_section();
	}

	protected function register_content_after_image_controls()
	{
		/**
		 * Content Tab: After Image
		 */
		$this->start_controls_section(
			'section_after_image',
			[
				'label'             => __('After Image', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'after_label',
			[
				'label'             => __('Label', 'magical-addons-for-elementor'),
				'type'              => Controls_Manager::TEXT,
				'default'           => __('After', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'after_image',
			[
				'label'             => __('Image', 'magical-addons-for-elementor'),
				'type'              => Controls_Manager::MEDIA,
				'dynamic'           => [
					'active'   => true,
				],
				'default'           => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'              => 'after_image',
				'default'           => 'full',
				'separator'         => 'none',
			]
		);

		$this->end_controls_section();
	}

	protected function register_content_settings_controls()
	{
		/**
		 * Content Tab: Settings
		 */
		$this->start_controls_section(
			'section_settings',
			[
				'label'             => __('Settings', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'visible_ratio',
			[
				'label'                 => __('Visible Ratio', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::SLIDER,
				'range'                 => [
					'px' => [
						'min'   => 0,
						'max'   => 1,
						'step'  => 0.1,
					],
				],
				'size_units'            => '',
			]
		);

		$this->add_control(
			'orientation',
			[
				'label'                 => __('Orientation', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'horizontal',
				'options'               => [
					'vertical'      => __('Vertical', 'magical-addons-for-elementor'),
					'horizontal'    => __('Horizontal', 'magical-addons-for-elementor'),
				],
			]
		);

		$this->add_control(
			'move_slider',
			[
				'label'                 => __('Move Slider', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::SELECT,
				'default'               => 'drag',
				'options'               => [
					'drag'          => __('Drag', 'magical-addons-for-elementor'),
					'mouse_move'    => __('Mouse Move', 'magical-addons-for-elementor'),
					'mouse_click'   => __('Mouse Click', 'magical-addons-for-elementor'),
				],
			]
		);

		$this->add_control(
			'overlay',
			[
				'label'             => __('Overlay', 'magical-addons-for-elementor'),
				'description'             => __('overlay show in hover', 'magical-addons-for-elementor'),
				'type'              => Controls_Manager::SWITCHER,
				'default'           => 'yes',
				'label_on'          => __('Show', 'magical-addons-for-elementor'),
				'label_off'         => __('Hide', 'magical-addons-for-elementor'),
				'return_value'      => 'yes',
			]
		);

		$this->end_controls_section();
		$this->link_pro_added();
	}


	/*-----------------------------------------------------------------------------------*/
	/*	STYLE TAB
	/*-----------------------------------------------------------------------------------*/

	protected function register_style_overlay_controls()
	{
		/**
		 * Style Tab: Overlay
		 */
		$this->start_controls_section(
			'section_overlay_style',
			[
				'label'             => __('Overlay', 'magical-addons-for-elementor'),
				'tab'               => Controls_Manager::TAB_STYLE,
				'condition'         => [
					'overlay'  => 'yes',
				],
			]
		);

		$this->start_controls_tabs('tabs_overlay_style');

		$this->start_controls_tab(
			'tab_overlay_normal',
			[
				'label'             => __('Normal', 'magical-addons-for-elementor'),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'              => 'overlay_background',
				'types'             => ['classic', 'gradient'],
				'selector'          => '{{WRAPPER}} .twentytwenty-overlay',
				'condition'         => [
					'overlay'  => 'yes',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_overlay_hover',
			[
				'label'             => __('Hover', 'magical-addons-for-elementor'),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'              => 'overlay_background_hover',
				'types'             => ['classic', 'gradient'],
				'selector'          => '{{WRAPPER}} .twentytwenty-overlay:hover',
				'condition'         => [
					'overlay'  => 'yes',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_style_handle_controls()
	{
		/**
		 * Style Tab: Handle
		 */
		$this->start_controls_section(
			'section_handle_style',
			[
				'label'             => __('Handle', 'magical-addons-for-elementor'),
				'tab'               => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs('tabs_handle_style');

		$this->start_controls_tab(
			'tab_handle_normal',
			[
				'label'             => __('Normal', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'handle_icon_color',
			[
				'label'             => __('Icon Color', 'magical-addons-for-elementor'),
				'type'              => Controls_Manager::COLOR,
				'default'           => '',
				'selectors'         => [
					'{{WRAPPER}} .twentytwenty-left-arrow' => 'border-right-color: {{VALUE}}',
					'{{WRAPPER}} .twentytwenty-right-arrow' => 'border-left-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'              => 'handle_background',
				'types'             => ['classic', 'gradient'],
				'selector'          => '{{WRAPPER}} .twentytwenty-handle',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'              => 'handle_border',
				'label'             => __('Border', 'magical-addons-for-elementor'),
				'placeholder'       => '1px',
				'default'           => '1px',
				'selector'          => '{{WRAPPER}} .twentytwenty-handle',
				'separator'         => 'before',
			]
		);

		$this->add_control(
			'handle_border_radius',
			[
				'label'             => __('Border Radius', 'magical-addons-for-elementor'),
				'type'              => Controls_Manager::DIMENSIONS,
				'size_units'        => ['px', '%'],
				'selectors'         => [
					'{{WRAPPER}} .twentytwenty-handle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'handle_box_shadow',
				'selector'              => '{{WRAPPER}} .twentytwenty-handle',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_handle_hover',
			[
				'label'             => __('Hover', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'handle_icon_color_hover',
			[
				'label'             => __('Icon Color', 'magical-addons-for-elementor'),
				'type'              => Controls_Manager::COLOR,
				'default'           => '',
				'selectors'         => [
					'{{WRAPPER}} .twentytwenty-handle:hover .twentytwenty-left-arrow' => 'border-right-color: {{VALUE}}',
					'{{WRAPPER}} .twentytwenty-handle:hover .twentytwenty-right-arrow' => 'border-left-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'              => 'handle_background_hover',
				'types'             => ['classic', 'gradient'],
				'selector'          => '{{WRAPPER}} .twentytwenty-handle:hover',
			]
		);

		$this->add_control(
			'handle_border_color_hover',
			[
				'label'             => __('Border Color', 'magical-addons-for-elementor'),
				'type'              => Controls_Manager::COLOR,
				'default'           => '',
				'selectors'         => [
					'{{WRAPPER}} .twentytwenty-handle:hover' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_style_divider_controls()
	{
		/**
		 * Style Tab: Divider
		 */
		$this->start_controls_section(
			'section_divider_style',
			[
				'label'             => __('Divider', 'magical-addons-for-elementor'),
				'tab'               => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'divider_color',
			[
				'label'             => __('Color', 'magical-addons-for-elementor'),
				'type'              => Controls_Manager::COLOR,
				'default'           => '',
				'selectors'         => [
					'{{WRAPPER}} .twentytwenty-horizontal .twentytwenty-handle:before, {{WRAPPER}} .twentytwenty-horizontal .twentytwenty-handle:after, {{WRAPPER}} .twentytwenty-vertical .twentytwenty-handle:before, {{WRAPPER}} .twentytwenty-vertical .twentytwenty-handle:after' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'divider_width',
			[
				'label'             => __('Width', 'magical-addons-for-elementor'),
				'type'              => Controls_Manager::SLIDER,
				'default'           => [
					'size' => 3,
					'unit' => 'px',
				],
				'size_units'        => ['px', '%'],
				'range'             => [
					'px' => [
						'max' => 20,
					],
				],
				'tablet_default'    => [
					'unit' => 'px',
				],
				'mobile_default'    => [
					'unit' => 'px',
				],
				'selectors'         => [
					'{{WRAPPER}} .twentytwenty-horizontal .twentytwenty-handle:before, {{WRAPPER}} .twentytwenty-horizontal .twentytwenty-handle:after' => 'width: {{SIZE}}{{UNIT}}; margin-left: calc(-{{SIZE}}{{UNIT}}/2);',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'              => 'divider_border',
				'label'             => __('Border', 'magical-addons-for-elementor'),
				'placeholder'       => '1px',
				'default'           => '1px',
				'selector'          => '{{WRAPPER}} .twentytwenty-horizontal .twentytwenty-handle:before, {{WRAPPER}} .twentytwenty-horizontal .twentytwenty-handle:after',
				'separator'         => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'                  => 'divider_box_shadow',
				'selector'              => '{{WRAPPER}} .twentytwenty-horizontal .twentytwenty-handle:before, {{WRAPPER}} .twentytwenty-horizontal .twentytwenty-handle:after',
			]
		);

		$this->end_controls_section();
	}

	protected function register_style_label_controls()
	{
		/**
		 * Style Tab: Label
		 */
		$this->start_controls_section(
			'section_label_style',
			[
				'label'             => __('Label', 'magical-addons-for-elementor'),
				'tab'               => Controls_Manager::TAB_STYLE,
				'condition'             => [
					'overlay'  => 'yes',
				],
			]
		);

		$this->add_control(
			'label_horizontal_position',
			[
				'label'                 => __('Position', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::CHOOSE,
				'label_block'           => false,
				'default'               => 'top',
				'options'               => [
					'top'          => [
						'title'    => __('Top', 'magical-addons-for-elementor'),
						'icon'     => 'eicon-v-align-top',
					],
					'middle'       => [
						'title'    => __('Middle', 'magical-addons-for-elementor'),
						'icon'     => 'eicon-v-align-middle',
					],
					'bottom'       => [
						'title'    => __('Bottom', 'magical-addons-for-elementor'),
						'icon'     => 'eicon-v-align-bottom',
					],
				],
				'prefix_class'          => 'mg-ic-label-horizontal-',
				'condition'             => [
					'orientation'  => 'horizontal',
				],

			]
		);

		$this->add_control(
			'label_vertical_position',
			[
				'label'                 => __('Position', 'magical-addons-for-elementor'),
				'type'                  => Controls_Manager::CHOOSE,
				'label_block'           => false,
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
				'prefix_class'  => 'mg-ic-label-vertical-',
				'condition'             => [
					'orientation'  => 'vertical',
				],
			]
		);

		$this->add_responsive_control(
			'label_align',
			[
				'label'             => __('Align', 'magical-addons-for-elementor'),
				'type'              => Controls_Manager::SLIDER,
				'size_units'        => ['px', '%'],
				'range'             => [
					'px' => [
						'max' => 200,
					],
				],
				'selectors'         => [
					'{{WRAPPER}}.mg-ic-label-horizontal-top .twentytwenty-horizontal .twentytwenty-before-label:before,
                    {{WRAPPER}}.mg-ic-label-horizontal-top .twentytwenty-horizontal .twentytwenty-after-label:before' => 'top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .twentytwenty-horizontal .twentytwenty-before-label:before' => 'left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .twentytwenty-horizontal .twentytwenty-after-label:before' => 'right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.mg-ic-label-horizontal-bottom .twentytwenty-horizontal .twentytwenty-before-label:before,
                    {{WRAPPER}}.mg-ic-label-horizontal-bottom .twentytwenty-horizontal .twentytwenty-after-label:before' => 'bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .twentytwenty-vertical .twentytwenty-before-label:before' => 'top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .twentytwenty-vertical .twentytwenty-after-label:before' => 'bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.mg-ic-label-vertical-left .twentytwenty-vertical .twentytwenty-before-label:before,
                    {{WRAPPER}}.mg-ic-label-vertical-left .twentytwenty-vertical .twentytwenty-after-label:before' => 'left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.mg-ic-label-vertical-right .twentytwenty-vertical .twentytwenty-before-label:before,
                    {{WRAPPER}}.mg-ic-label-vertical-right .twentytwenty-vertical .twentytwenty-after-label:before' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs('tabs_label_style');

		$this->start_controls_tab(
			'tab_label_before',
			[
				'label'             => __('Before', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'label_text_color_before',
			[
				'label'             => __('Text Color', 'magical-addons-for-elementor'),
				'type'              => Controls_Manager::COLOR,
				'default'           => '',
				'selectors'         => [
					'{{WRAPPER}} .twentytwenty-before-label:before' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'label_bg_color_before',
			[
				'label'             => __('Background Color', 'magical-addons-for-elementor'),
				'type'              => Controls_Manager::COLOR,
				'default'           => '',
				'selectors'         => [
					'{{WRAPPER}} .twentytwenty-before-label:before' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'              => 'label_border',
				'label'             => __('Border', 'magical-addons-for-elementor'),
				'placeholder'       => '1px',
				'default'           => '1px',
				'selector'          => '{{WRAPPER}} .twentytwenty-before-label:before',
			]
		);

		$this->add_control(
			'label_border_radius',
			[
				'label'             => __('Border Radius', 'magical-addons-for-elementor'),
				'type'              => Controls_Manager::DIMENSIONS,
				'size_units'        => ['px', '%'],
				'selectors'         => [
					'{{WRAPPER}} .twentytwenty-before-label:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_label_after',
			[
				'label'             => __('After', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'label_text_color_after',
			[
				'label'             => __('Text Color', 'magical-addons-for-elementor'),
				'type'              => Controls_Manager::COLOR,
				'default'           => '',
				'selectors'         => [
					'{{WRAPPER}} .twentytwenty-after-label:before' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'label_bg_color_after',
			[
				'label'             => __('Background Color', 'magical-addons-for-elementor'),
				'type'              => Controls_Manager::COLOR,
				'default'           => '',
				'selectors'         => [
					'{{WRAPPER}} .twentytwenty-after-label:before' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'              => 'label_border_after',
				'label'             => __('Border', 'magical-addons-for-elementor'),
				'placeholder'       => '1px',
				'default'           => '1px',
				'selector'          => '{{WRAPPER}} .twentytwenty-after-label:before',
			]
		);

		$this->add_control(
			'label_border_radius_after',
			[
				'label'             => __('Border Radius', 'magical-addons-for-elementor'),
				'type'              => Controls_Manager::DIMENSIONS,
				'size_units'        => ['px', '%'],
				'selectors'         => [
					'{{WRAPPER}} .twentytwenty-after-label:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'              => 'label_typography',
				'label'             => __('Typography', 'magical-addons-for-elementor'),
				'scheme'            => Scheme_Typography::TYPOGRAPHY_4,
				'selector'          => '{{WRAPPER}} .twentytwenty-before-label:before, {{WRAPPER}} .twentytwenty-after-label:before',
				'separator'         => 'before',
			]
		);

		$this->add_responsive_control(
			'label_padding',
			[
				'label'             => __('Padding', 'magical-addons-for-elementor'),
				'type'              => Controls_Manager::DIMENSIONS,
				'size_units'        => ['px', 'em', '%'],
				'selectors'         => [
					'{{WRAPPER}} .twentytwenty-before-label:before, {{WRAPPER}} .twentytwenty-after-label:before' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'         => 'before',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render image comparison widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render()
	{
		$settings = $this->get_settings_for_display();

		$widget_options = [
			'visible_ratio'      => ($settings['visible_ratio']['size']) ? $settings['visible_ratio']['size'] : '0.5',
			'orientation'        => ($settings['orientation']) ? $settings['orientation'] : 'vertical',
			'before_label'       => ($settings['before_label']) ? esc_attr($settings['before_label']) : '',
			'after_label'        => ($settings['after_label']) ? esc_attr($settings['after_label']) : '',
			'slider_on_hover'    => 'mouse_move' === $settings['move_slider'] ? true : false,
			'slider_with_handle' => 'drag' === $settings['move_slider'] ? true : false,
			'slider_with_click'  => 'mouse_click' === $settings['move_slider'] ? true : false,
			'no_overlay'         => ('yes' === $settings['overlay']) ? false : true,
		];

		$this->add_render_attribute('image-comparison', [
			'class'         => 'mg-image-comparison item-visiable',
			'id'            => 'mg-image-comparison-' . esc_attr($this->get_id()),
			'data-settings' => wp_json_encode($widget_options),
		]);
?>

		<div <?php echo wp_kses_post($this->get_render_attribute_string('image-comparison')); ?>>
			<?php


			if (!empty($settings['before_image']['url'])) :
				if ($settings['before_image']['id']) {
					$this->add_render_attribute('before-image', 'src', Group_Control_Image_Size::get_attachment_image_src($settings['before_image']['id'], 'before_image', $settings));
				} else {
					$this->add_render_attribute('before-image', 'src', $settings['before_image']['url']);
				}


				$this->add_render_attribute('before-image', 'alt', Control_Media::get_image_alt($settings['before_image']));
				$this->add_render_attribute('before-image', 'title', Control_Media::get_image_title($settings['before_image']));
				$this->add_render_attribute('before-image', 'class', 'mg-before-img');

				printf('<img %s />', $this->get_render_attribute_string('before-image'));

			endif;

			if (!empty($settings['after_image']['url'])) :
				if ($settings['after_image']['id']) {
					$this->add_render_attribute('after-image', 'src', Group_Control_Image_Size::get_attachment_image_src($settings['after_image']['id'], 'after_image', $settings));
				} else {
					$this->add_render_attribute('after-image', 'src', $settings['after_image']['url']);
				}

				$this->add_render_attribute('after-image', 'alt', Control_Media::get_image_alt($settings['after_image']));
				$this->add_render_attribute('after-image', 'title', Control_Media::get_image_title($settings['after_image']));
				$this->add_render_attribute('after-image', 'class', 'mg-after-img');

				printf('<img %s />', $this->get_render_attribute_string('after-image'));

			endif;
			?>
		</div>
<?php
	}

	/**
	 * Render image comparison widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 2.3.2
	 * @access protected
	 */
	/*	protected function content_template()
	{
	?>
		<# var visible_ratio=( settings.visible_ratio.size !='' ) ? settings.visible_ratio.size : '0.5' ; var slider_on_hover=( settings.move_slider=='mouse_move' ) ? true : false; var slider_with_handle=( settings.move_slider=='drag' ) ? true : false; var slider_with_click=( settings.move_slider=='mouse_click' ) ? true : false; var no_overlay=( settings.overlay=='yes' ) ? false : true; #>
			<div class="mg-image-comparison" data-settings='{ "visible_ratio":{{ visible_ratio }},"orientation":"{{ settings.orientation }}","before_label":"{{ settings.before_label }}","after_label":"{{ settings.after_label }}","slider_on_hover":{{ slider_on_hover }},"slider_with_handle":{{ slider_with_handle }},"slider_with_click":{{ slider_with_click }},"no_overlay":{{ no_overlay }} }'>
				<# if ( settings.before_image.url !='' ) { #>
					<# var before_image={ id: settings.before_image.id, url: settings.before_image.url, size: settings.before_image_size, dimension: settings.before_image_custom_dimension, model: view.getEditModel() }; var before_image_url=elementor.imagesManager.getImageUrl( before_image ); #>
						<img src="{{{ before_image_url }}}" class="mg-before-img">
						<# } #>

							<# if ( settings.after_image.url !='' ) { #>
								<# var after_image={ id: settings.after_image.id, url: settings.after_image.url, size: settings.after_image_size, dimension: settings.after_image_custom_dimension, model: view.getEditModel() }; var after_image_url=elementor.imagesManager.getImageUrl( after_image ); #>
									<img src="{{{ after_image_url }}}" class="mg-after-img">
									<# } #>
			</div>
	<?php
	}*/
}
