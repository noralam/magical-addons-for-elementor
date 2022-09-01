<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Responsive\Responsive;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Image_Size;
use WprAddons\Classes\Utilities;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class mgCatTag_List extends Widget_Base
{
	use mgProHelpLink;
	public function get_name()
	{
		return 'mg-taxonomy-list';
	}

	public function get_title()
	{
		return esc_html__('Mg Category/Tag List', 'magical-addons-for-elementor');
	}

	public function get_icon()
	{
		return 'eicon-editor-list-ul';
	}

	public function get_categories()
	{
		return ['magical'];
	}

	public function get_keywords()
	{
		return ['mg', 'category', 'tag', 'taxonomy'];
	}

	public function get_post_taxonomies()
	{
		if (class_exists('WooCommerce')) {
			return [
				'category' => esc_html__('Categories', 'magical-addons-for-elementor'),
				'post_tag' => esc_html__('Tags', 'magical-addons-for-elementor'),
				'product_cat' => esc_html__('Product Categories', 'magical-addons-for-elementor'),
				'product_tag' => esc_html__('Product Tags', 'magical-addons-for-elementor'),
			];
		} else {
			return [
				'category' => esc_html__('Categories', 'magical-addons-for-elementor'),
				'post_tag' => esc_html__('Tags', 'magical-addons-for-elementor'),
			];
		}
	}

	protected function register_controls()
	{

		// Tab: Content ==============
		// Section: General ----------
		$this->start_controls_section(
			'section_taxonomy_list_query',
			[
				'label' => esc_html__('Categories/Tags Query', 'magical-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'query_tax_selection',
			[
				'label' => esc_html__('Select Taxonomy', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SELECT,
				'default' => 'category',
				'options' => $this->get_post_taxonomies(),
			]
		);

		$this->add_control(
			'query_hide_empty',
			[
				'label' => esc_html__('Hide Empty', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes'
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_taxonomy_list_layout',
			[
				'label' => esc_html__('Layout', 'magical-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'taxonomy_list_layout',
			[
				'label' => esc_html__('Select Layout', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'vertical',
				'options' => [
					'vertical' => [
						'title' => esc_html__('Vertical', 'magical-addons-for-elementor'),
						'icon' => 'eicon-editor-list-ul',
					],
					'horizontal' => [
						'title' => esc_html__('Horizontal', 'magical-addons-for-elementor'),
						'icon' => 'eicon-ellipsis-h',
					],
				],
				'prefix_class' => 'mg-taxonomy-list-',
				'label_block' => false,
			]
		);

		$this->add_control(
			'show_tax_list_icon',
			[
				'label' => esc_html__('Show Icon', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'label_block' => false,
				'default' => 'yes'
			]
		);

		$this->add_control(
			'tax_list_icon',
			[
				'label' => esc_html__('Select Icon', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::ICONS,
				'skin' => 'inline',
				'label_block' => false,
				'exclude_inline_options' => 'svg',
				'default' => [
					'value' => 'fas fa-chevron-right',
					'library' => 'fa-solid',
				],
				'condition' => [
					'show_tax_list_icon' => 'yes'
				]
			]
		);

		$this->add_control(
			'show_tax_count',
			[
				'label' => esc_html__('Show Count', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'label_block' => false,
				'default' => 'yes'
			]
		);

		$this->end_controls_section();
		$this->link_pro_added();

		// Styles ====================
		// Section: Taxonomy Style ---
		$this->start_controls_section(
			'section_style_tax',
			[
				'label' => esc_html__('Taxonomy Style', 'magical-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->start_controls_tabs('tax_style');

		$this->start_controls_tab(
			'tax_normal',
			[
				'label' => esc_html__('Normal', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'tax_color',
			[
				'label'  => esc_html__('Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '#4285f4',
				'selectors' => [
					'{{WRAPPER}} .mg-taxonomy-list li a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'tax_bg_color',
			[
				'label'  => esc_html__('Background Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '#00000000',
				'selectors' => [
					'{{WRAPPER}} .mg-taxonomy-list li a' => 'background-color: {{VALUE}}',
				]
			]
		);

		$this->add_control(
			'tax_border_color',
			[
				'label'  => esc_html__('Border Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '#E8E8E8',
				'selectors' => [
					'{{WRAPPER}} .mg-taxonomy-list li a' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'tax_transition_duration',
			[
				'label' => esc_html__('Transition Duration', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::NUMBER,
				'default' => 0.5,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' => [
					'{{WRAPPER}} .mg-taxonomy-list li a' => 'transition-duration: {{VALUE}}s',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tax_typography',
				'scheme' => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .mg-taxonomy-list li a',
				'fields_options' => [
					'typography'      => [
						'default' => 'custom',
					],
					'font_size'      => [
						'default'    => [
							'size' => '14',
							'unit' => 'px',
						],
					]
				]
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tax_hover',
			[
				'label' => esc_html__('Hover', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'tax_color_hr',
			[
				'label'  => esc_html__('Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-taxonomy-list li a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'tax1_bg_color_hr',
			[
				'label'  => esc_html__('Background Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-taxonomy-list li a:hover' => 'background-color: {{VALUE}}',
				]
			]
		);

		$this->add_control(
			'tax1_border_color_hr',
			[
				'label'  => esc_html__('Border Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-taxonomy-list li a:hover' => 'border-color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'tax_padding',
			[
				'label' => esc_html__('Padding', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'default' => [
					'top' => 5,
					'right' => 0,
					'bottom' => 5,
					'left' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .mg-taxonomy-list li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'tax_margin',
			[
				'label' => esc_html__('Margin', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'default' => [
					'top' => 5,
					'right' => 8,
					'bottom' => 0,
					'left' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .mg-taxonomy-list li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'tax_border_type',
			[
				'label' => esc_html__('Border Type', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__('None', 'magical-addons-for-elementor'),
					'solid' => esc_html__('Solid', 'magical-addons-for-elementor'),
					'double' => esc_html__('Double', 'magical-addons-for-elementor'),
					'dotted' => esc_html__('Dotted', 'magical-addons-for-elementor'),
					'dashed' => esc_html__('Dashed', 'magical-addons-for-elementor'),
					'groove' => esc_html__('Groove', 'magical-addons-for-elementor'),
				],
				'default' => 'solid',
				'selectors' => [
					'{{WRAPPER}} .mg-taxonomy-list li a' => 'border-style: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'tax_border_width',
			[
				'label' => esc_html__('Border Width', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 1,
					'left' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .mg-taxonomy-list li a' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'tax_border_type!' => 'none',
				],
			]
		);

		$this->add_control(
			'tax_radius',
			[
				'label' => esc_html__('Border Radius', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .mg-taxonomy-list li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->end_controls_section();

		// Tab: Style ==============
		// Section: Content --------
		$this->start_controls_section(
			'section_style_icon',
			[
				'label' => esc_html__('Icon', 'magical-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_tax_list_icon' => 'yes'
				]
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'  => esc_html__('Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '#4285f4',
				'selectors' => [
					'{{WRAPPER}} .mg-taxonomy-list li i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__('Size', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .mg-taxonomy-list li i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'icon_distance',
			[
				'label' => esc_html__('Distance', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'selectors' => [
					'{{WRAPPER}} .mg-taxonomy-list li i' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render()
	{
		// Get Settings
		$settings = $this->get_settings_for_display();

		ob_start();
		\Elementor\Icons_Manager::render_icon($settings['tax_list_icon'], ['aria-hidden' => 'true']);
		$icon = ob_get_clean();
		$icon_wrapper = !empty($settings['tax_list_icon']) ? '<span>' . $icon . '</span>' : '';

		// Get Taxonomies
		$terms = get_terms([
			'taxonomy' => $settings['query_tax_selection'],
			'hide_empty' => 'yes' === $settings['query_hide_empty'],
		]);

		echo '<ul class="mg-taxonomy-list">';

		foreach ($terms as $key => $term) {
			$sub_class = $term->parent > 0 ? ' class="mg-sub-taxonomy"' : '';

			echo '<li' . $sub_class . '>';
			echo '<a href="' . esc_url(get_term_link($term->term_id)) . '">';
			echo '<span class="mg-tax-wrap">' . $icon_wrapper . '<span>' . esc_html($term->name) . '</span></span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo ($settings['show_tax_count']) ? '<span><span class="mg-term-count">&nbsp;(' . esc_html($term->count) . ')</span></span>' : '';
			echo '</a>';
			echo '</li>';
		}

		echo '</ul>';
	}
}
