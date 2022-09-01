<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Core\Schemes\Typography;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Icons;
use WprAddons\Classes\Utilities;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class MG_Addon_SearchBar extends Widget_Base
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
		return 'mgsite_search';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_title()
	{
		return esc_html__('Mg Search Bar', 'magical-addons-for-elementor');
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_icon()
	{
		return 'eicon-site-search';
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

	public function get_keywords()
	{
		return ['mg', 'search', 'search widget', 'search bar'];
	}


	protected function register_controls()
	{

		// Section: Search -----------
		$this->start_controls_section(
			'section_search',
			[
				'label' => esc_html__('Search', 'magical-addons-for-elementor'),
			]
		);


		$this->add_control(
			'search_placeholder',
			[
				'label' => esc_html__('Placeholder', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__('Search...', 'magical-addons-for-elementor'),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'search_btn',
			[
				'label' => esc_html__('Button', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'search_btn_style',
			[
				'label' => esc_html__('Style', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SELECT,
				'default' => 'inner',
				'options' => [
					'inner' => esc_html__('Inner', 'magical-addons-for-elementor'),
					'outer' => esc_html__('Outer', 'magical-addons-for-elementor'),
				],
				'prefix_class' => 'mg-search-form-style-',
				'render_type' => 'template',
				'condition' => [
					'search_btn' => 'yes',
				],
			]
		);

		$this->add_control(
			'search_btn_disable_click',
			[
				'label' => esc_html__('Disable Button Click', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'prefix_class' => 'mg-search-form-disable-submit-btn-',
				'condition' => [
					'search_btn_style' => 'inner',
					'search_btn' => 'yes',
				],
			]
		);

		$this->add_control(
			'search_btn_type',
			[
				'label' => esc_html__('Type', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SELECT,
				'default' => 'icon',
				'options' => [
					'text' => esc_html__('Text', 'magical-addons-for-elementor'),
					'icon' => esc_html__('Icon', 'magical-addons-for-elementor'),
				],
				'render_type' => 'template',
				'condition' => [
					'search_btn' => 'yes',
				],
			]
		);

		$this->add_control(
			'search_btn_text',
			[
				'label' => esc_html__('Text', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::TEXT,
				'default' => 'Go',
				'condition' => [
					'search_btn_type' => 'text',
					'search_btn' => 'yes',
				],
			]
		);

		$this->add_control(
			'search_btn_icon',
			[
				'label' => esc_html__('Select Icon', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::ICONS,
				'skin' => 'inline',
				'label_block' => false,
				'default' => [
					'value' => 'fas fa-search',
					'library' => 'fa-solid',
				],
				'condition' => [
					'search_btn_type' => 'icon',
					'search_btn' => 'yes',
				],
			]
		);

		$this->end_controls_section();
		$this->link_pro_added();


		// Styles
		// Section: Input ------------
		$this->start_controls_section(
			'section_style_input',
			[
				'label' => esc_html__('Input', 'magical-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs('tabs_input_colors');

		$this->start_controls_tab(
			'tab_input_normal_colors',
			[
				'label' => esc_html__('Normal', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'input_color',
			[
				'label' => esc_html__('Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
				'selectors' => [
					'{{WRAPPER}} .mg-search-form-input' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_bg_color',
			[
				'label' => esc_html__('Background Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .mg-search-form-input' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_placeholder_color',
			[
				'label' => esc_html__('Placeholder Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '#9e9e9e',
				'selectors' => [
					'{{WRAPPER}} .mg-search-form-input::-webkit-input-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mg-search-form-input:-ms-input-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mg-search-form-input::-moz-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mg-search-form-input:-moz-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mg-search-form-input::placeholder' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_border_color',
			[
				'label' => esc_html__('Border Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '#E8E8E8',
				'selectors' => [
					'{{WRAPPER}} .mg-search-form-input' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'input_box_shadow',
				'selector' => '{{WRAPPER}} .mg-search-form-input-wrap'
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_input_focus_colors',
			[
				'label' => esc_html__('Focus', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'input_focus_color',
			[
				'label' => esc_html__('Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
				'selectors' => [
					'{{WRAPPER}}.mg-search-form-input-focus .mg-search-form-input' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_focus_bg_color',
			[
				'label' => esc_html__('Background Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}}.mg-search-form-input-focus .mg-search-form-input' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_focus_placeholder_color',
			[
				'label' => esc_html__('Placeholder Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '#9e9e9e',
				'selectors' => [
					'{{WRAPPER}}.mg-search-form-input-focus .mg-search-form-input::-webkit-input-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}}.mg-search-form-input-focus .mg-search-form-input:-ms-input-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}}.mg-search-form-input-focus .mg-search-form-input::-moz-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}}.mg-search-form-input-focus .mg-search-form-input:-moz-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}}.mg-search-form-input-focus .mg-search-form-input::placeholder' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_focus_border_color',
			[
				'label' => esc_html__('Border Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '#E8E8E8',
				'selectors' => [
					'{{WRAPPER}}.mg-search-form-input-focus .mg-search-form-input' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'input_focus_box_shadow',
				'selector' => '{{WRAPPER}}.mg-search-form-input-focus .mg-search-form-input-wrap'
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'input_typography_divider',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'input_typography',
				'scheme' => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .mg-search-form-input',
			]
		);

		$this->add_responsive_control(
			'input_align',
			[
				'label' => esc_html__('Alignment', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'default' => 'left',
				'options' => [
					'left' => [
						'title' => esc_html__('Left', 'magical-addons-for-elementor'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'magical-addons-for-elementor'),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__('Right', 'magical-addons-for-elementor'),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mg-search-form-input' => 'text-align: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'input_border_size',
			[
				'label' => esc_html__('Border Size', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => 1,
					'right' => 1,
					'bottom' => 1,
					'left' => 1,
				],
				'size_units' => ['px',],
				'selectors' => [
					'{{WRAPPER}} .mg-search-form-input' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'input_border_radius',
			[
				'label' => esc_html__('Border Radius', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => 2,
					'right' => 2,
					'bottom' => 2,
					'left' => 2,
				],
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-search-form-input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);

		$this->add_responsive_control(
			'input_padding',
			[
				'label' => esc_html__('Padding', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => 15,
					'right' => 15,
					'bottom' => 15,
					'left' => 15,
				],
				'size_units' => ['px',],
				'selectors' => [
					'{{WRAPPER}} .mg-search-form-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Styles
		// Section: Button ------------
		$this->start_controls_section(
			'section_style_btn',
			[
				'label' => esc_html__('Button', 'magical-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'search_btn' => 'yes',
				],
			]
		);

		$this->start_controls_tabs('tabs_btn_colors');

		$this->start_controls_tab(
			'tab_btn_normal_colors',
			[
				'label' => esc_html__('Normal', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'btn_text_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__('Text Color', 'magical-addons-for-elementor'),
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .mg-search-form-submit' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_bg_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__('Background Color', 'magical-addons-for-elementor'),
				'default' => '#4285f4',
				'selectors' => [
					'{{WRAPPER}} .mg-search-form-submit' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_border_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__('Border Color', 'magical-addons-for-elementor'),
				'default' => '#E8E8E8',
				'selectors' => [
					'{{WRAPPER}} .mg-search-form-submit' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'btn_box_shadow',
				'selector' => '{{WRAPPER}} .mg-search-form-submit',
				'condition' => [
					'search_btn_style' => 'outer',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_btn_hover_colors',
			[
				'label' => esc_html__('Hover', 'magical-addons-for-elementor'),
			]
		);


		$this->add_control(
			'btn_hv_text_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__('Text Color', 'magical-addons-for-elementor'),
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .mg-search-form-submit:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_hv_bg_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__('Background Color', 'magical-addons-for-elementor'),
				'default' => '#4A45D2',
				'selectors' => [
					'{{WRAPPER}} .mg-search-form-submit:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_hv_border_color',
			[
				'type' => Controls_Manager::COLOR,
				'label' => esc_html__('Border Color', 'magical-addons-for-elementor'),
				'default' => '#E8E8E8',
				'selectors' => [
					'{{WRAPPER}} .mg-search-form-submit:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'btn_hv_box_shadow',
				'selector' => '{{WRAPPER}} .mg-search-form-submit:hover',
				'condition' => [
					'search_btn_style' => 'outer',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'btn_width',
			[
				'label' => esc_html__('Width', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 125,
				],
				'selectors' => [
					'{{WRAPPER}} .mg-search-form-submit' => 'min-width: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'btn_height',
			[
				'label' => esc_html__('Height', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}}.mg-search-form-style-outer .mg-search-form-submit' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'search_btn_style' => 'outer',
				],
			]
		);

		$this->add_control(
			'btn_gutter',
			[
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Gutter', 'magical-addons-for-elementor'),
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}}.mg-search-form-style-outer.mg-search-form-position-right .mg-search-form-submit' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.mg-search-form-style-outer.mg-search-form-position-left .mg-search-form-submit' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'search_btn_style' => 'outer',
				],
			]
		);

		$this->add_control(
			'btn_position',
			[
				'label' => esc_html__('Position', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'default' => 'right',
				'options' => [
					'left' => [
						'title' => esc_html__('Left', 'magical-addons-for-elementor'),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__('Right', 'magical-addons-for-elementor'),
						'icon' => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'mg-search-form-position-',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'btn_typography_divider',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'btn_typography',
				'label' => esc_html__('Typography', 'magical-addons-for-elementor'),
				'scheme' => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .mg-search-form-submit',
			]
		);

		$this->add_control(
			'btn_border_size',
			[
				'label' => esc_html__('Border Size', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
				],
				'size_units' => ['px',],
				'selectors' => [
					'{{WRAPPER}} .mg-search-form-submit' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'btn_border_radius',
			[
				'label' => esc_html__('Border Radius', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
				],
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-search-form-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);

		$this->end_controls_section();
	}

	protected function render_search_submit_btn()
	{
		$settings = $this->get_settings();

		$this->add_render_attribute(
			'button',
			[
				'class' => 'mg-search-form-submit',
				'type' => 'submit',
			]
		);

		if ($settings['search_btn_disable_click']) {
			$this->add_render_attribute('button', 'disabled');
		}

		if ('yes' === $settings['search_btn']) : ?>

			<button <?php echo $this->get_render_attribute_string('button'); ?>>
				<?php if ('icon' === $settings['search_btn_type'] && '' !== $settings['search_btn_icon']['value']) : ?>
					<i class="<?php echo esc_attr($settings['search_btn_icon']['value']); ?>"></i>
				<?php elseif ('text' === $settings['search_btn_type'] && '' !== $settings['search_btn_text']) : ?>
					<?php echo esc_html($settings['search_btn_text']); ?>
				<?php endif; ?>
			</button>

		<?php
		endif;
	}

	protected function render()
	{
		// Get Settings
		$settings = $this->get_settings();

		$this->add_render_attribute(
			'input',
			[
				'placeholder' => $settings['search_placeholder'],
				'class' => 'mg-search-form-input',
				'type' => 'search',
				'name' => 's',
				'title' => esc_html__('Search', 'magical-addons-for-elementor'),
				'value' => get_search_query(),
			]
		);

		?>

		<form role="search" method="get" class="mg-search-form" action="<?php echo esc_url(home_url()); ?>">

			<div class="mg-search-form-input-wrap elementor-clearfix">
				<input <?php echo $this->get_render_attribute_string('input'); ?>>
				<?php
				if ($settings['search_btn_style'] === 'inner') {
					$this->render_search_submit_btn();
				}
				?>
			</div>

			<?php

			if ($settings['search_btn_style'] === 'outer') {
				$this->render_search_submit_btn();
			}

			?>

		</form>

<?php

	}
}
