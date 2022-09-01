<?php


class MgAddon_Dual_Heading extends \Elementor\Widget_Base
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
		return 'mghad_widget';
	}
	public function get_keywords()
	{
		return ['header', 'title', 'dual', 'mg'];
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
		return __('MG Dual Heading', 'magical-addons-for-elementor');
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
		return 'eicon-heading';
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
				'label' => __('Content', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'mgheading_one',
			[
				'label'       => __('Part one ', 'magical-addons-for-elementor'),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'input_type'  => 'text',
				'placeholder' => __('Title Part one', 'magical-addons-for-elementor'),
				'default'     => __('Part one', 'magical-addons-for-elementor'),
			]
		);
		$this->add_control(
			'mgheading_two',
			[
				'label'       => __('Part two ', 'magical-addons-for-elementor'),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'input_type'  => 'text',
				'placeholder' => __('Title Part two', 'magical-addons-for-elementor'),
				'default'     => __('Part two', 'magical-addons-for-elementor'),
			]
		);
		$this->add_control(
			'mgheader_tag',
			[
				'label' => __('HTML Tag', 'elementor'),
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
			'mgheader_link',
			[
				'label' => __('Link', 'elementor'),
				'type' => \Elementor\Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => '',
				],
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'mgheader_align',
			[
				'label' => __('Alignment', 'elementor'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __('Left', 'elementor'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __('Center', 'elementor'),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __('Right', 'elementor'),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __('Justified', 'elementor'),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
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
			'mg_head_style_one',
			[
				'label' => __('Header part one tyle', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'color',
			[
				'label'     => __('Text Color', 'magical-addons-for-elementor'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#000',
				'selectors' => [
					'{{WRAPPER}} .mgheading_one' => 'color: {{VALUE}}'
				]
			]
		);

		$this->add_control(
			'bgcolor',
			[
				'label'     => __('Text Background Color', 'magical-addons-for-elementor'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mgheading_one' => 'background-color: {{VALUE}}'
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'content_typography',
				'selector' => '{{WRAPPER}} .mgheading_one',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'mg_head_style_two',
			[
				'label' => __('Header part two tyle', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'color2',
			[
				'label'     => __('Text Color', 'magical-addons-for-elementor'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#00a8bf',
				'selectors' => [
					'{{WRAPPER}} .mgheading_two' => 'color: {{VALUE}}'
				]
			]
		);
		$this->add_control(
			'bgcolor2',
			[
				'label'     => __('Text background Color', 'magical-addons-for-elementor'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mgheading_two' => 'background-color: {{VALUE}}'
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'content_typography2',
				'selector' => '{{WRAPPER}} .mgheading_two',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'mg_head_style_extra',
			[
				'label' => __('Extra Style', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'mg_dheader_space',
			[
				'label' => __('Spacing', 'magical-addons-for-elementor'),
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
				'selectors' => [
					'{{WRAPPER}} span.mgheading_one' => 'padding-right: {{SIZE}}{{UNIT}} !important;',
					'{{WRAPPER}} span.mgheading_two' => 'padding-left: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);
		$this->add_responsive_control(
			'mg_header_padding',
			[
				'label' => __('Padding', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} span.mgheading_one, {{WRAPPER}} span.mgheading_two' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'mg_dheader_bradius',
			[
				'label' => __('Border Radius', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} span.mgheading_one' => 'border-radius: {{TOP}}{{UNIT}} 0 0 {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} span.mgheading_two' => 'border-radius: 0 {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} 0;',
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
		$mgheading_one = $this->get_settings('mgheading_one');
		$this->add_render_attribute('mgheading_one', 'class', 'mgheading_one');
		$this->add_inline_editing_attributes('mgheading_one');

		$mgheading_two = $this->get_settings('mgheading_two');
		$this->add_render_attribute('mgheading_two', 'class', 'mgheading_two');
		$this->add_inline_editing_attributes('mgheading_two');

		$mgheader_tag = $this->get_settings('mgheader_tag');


		if (!empty($settings['mgheader_link']['url'])) {
			$this->add_render_attribute('url', 'href', $settings['mgheader_link']['url']);

			if ($settings['mgheader_link']['is_external']) {
				$this->add_render_attribute('url', 'target', '_blank');
			}

			if (!empty($settings['mgheader_link']['nofollow'])) {
				$this->add_render_attribute('url', 'rel', 'nofollow');
			}


?>
			<a <?php echo $this->get_render_attribute_string('url'); ?>>
				<<?php echo esc_attr($mgheader_tag); ?>>
					<span <?php echo $this->get_render_attribute_string('mgheading_one'); ?>><?php echo mg_kses_tags($mgheading_one); ?></span>
					<span <?php echo $this->get_render_attribute_string('mgheading_two'); ?>><?php echo mg_kses_tags($mgheading_two); ?></span>

				</<?php echo esc_attr($mgheader_tag); ?>>
			</a>
		<?php
		} else {

		?>
			<<?php echo esc_attr($mgheader_tag); ?>>
				<span <?php echo $this->get_render_attribute_string('mgheading_one'); ?>><?php echo mg_kses_tags($mgheading_one); ?></span>
				<span <?php echo $this->get_render_attribute_string('mgheading_two'); ?>><?php echo mg_kses_tags($mgheading_two); ?></span>

			</<?php echo esc_attr($mgheader_tag); ?>>
		<?php
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
	protected function content_template()
	{
		$this->add_render_attribute('mgheading_one', 'class', 'mgheading_one');
		$this->add_inline_editing_attributes('mgheading_one');

		$this->add_render_attribute('mgheading_two', 'class', 'mgheading_two');
		$this->add_inline_editing_attributes('mgheading_two');

		if (!empty($settings['mgheader_link']['url'])) {
			$this->add_render_attribute('url', 'href', $settings['mgheader_link']['url']);

			if ($settings['mgheader_link']['is_external']) {
				$this->add_render_attribute('url', 'target', '_blank');
			}

			if (!empty($settings['mgheader_link']['nofollow'])) {
				$this->add_render_attribute('url', 'rel', 'nofollow');
			}


		?>
			<a <?php echo $this->get_render_attribute_string('url'); ?>>
				<{{ settings.mgheader_tag }}>
					<span <?php echo $this->get_render_attribute_string('mgheading_one') ?>>{{ settings.mgheading_one }}</span>
					<span <?php echo $this->get_render_attribute_string('mgheading_two') ?>>{{ settings.mgheading_two }}</span>

				</{{ settings.mgheader_tag }}>
			</a>
		<?php
		} else {
		?>
			<{{ settings.mgheader_tag }}>
				<span <?php echo $this->get_render_attribute_string('mgheading_one') ?>>{{ settings.mgheading_one }}</span>
				<span <?php echo $this->get_render_attribute_string('mgheading_two') ?>>{{ settings.mgheading_two }}</span>

			</{{ settings.mgheader_tag }}>
		<?php
		}

		?>

<?php
	}
}
