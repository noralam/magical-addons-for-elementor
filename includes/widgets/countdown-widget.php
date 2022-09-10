<?php


class MgCountdown extends \Elementor\Widget_Base
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
		return 'mgcountdown_widget';
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
		return __('MG Countdown', 'magical-addons-for-elementor');
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
		return 'eicon-countdown';
	}

	public function get_keywords()
	{
		return ['countdown', 'time', 'clock', 'mg'];
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
	public function get_script_depends()
	{
		return [
			'mg-flipclock',
			'mg-flipclock-active',
		];
	}
	public function get_style_depends()
	{
		return [
			'mg-flipclock',
		];
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
			'mg_countdown',
			[
				'label' => __('Countdown options', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'display_type',
			[
				'label' => __('Display Type', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'timec' => __('Time countdown', 'magical-addons-for-elementor'),
					'genericc' => __('Number countdown', 'magical-addons-for-elementor'),
					'clock' => __('Clock', 'magical-addons-for-elementor'),
				],
				'default' => 'timec',
			]
		);
		$this->add_control(
			'clock_format',
			[
				'label' => __('Clock format', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'12' => __('12 Hour format', 'magical-addons-for-elementor'),
					'24' => __('24 Hour format', 'magical-addons-for-elementor'),
				],
				'default' => '12',
				'condition' => [
					'display_type' => 'clock',
				],
			]
		);
		$this->add_control(
			'target_clock_time',
			[
				'label' => __('Set time', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DATE_TIME,
				'default' => '2024-11-01 23:57',
				'condition' => [
					'display_type' => 'timec',
				],
			]
		);
		$this->add_control(
			'genericc_countdown',
			[
				'label' => __('Countdown Form', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'condition' => [
					'display_type' => 'genericc',
				],
				'default' => '500',

			]
		);
		$this->add_control(
			'countdown_timing',
			[
				'label' => __('Countdown timing', 'magical-addons-for-elementor'),
				'description' => __('Set countdown timing by millisecond. default set 1 second (1000)', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'condition' => [
					'display_type' => 'genericc',
				],
				'default' => '1000',

			]
		);
		$this->add_control(
			'mg_countdown_label_show',
			[
				'label' => __('Show Label?', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'block',
				'options' => [
					'block'  => __('Show', 'magical-addons-for-elementor'),
					'none' => __('Hide', 'magical-addons-for-elementor'),
				],
				'condition' => [
					'display_type' => 'timec',
				],
				'selectors' => [
					'{{WRAPPER}} .flip-clock-wrapper .flip-clock-label' => 'display: {{VALUE}}'
				]
			]
		);
		$this->add_responsive_control(
			'mgcountdown_align',
			[
				'label' => __('Countdown Alignment', 'elementor'),
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

				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'mg_countdown_label',
			[
				'label' => __('Countdown Label', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
				'condition' => [
					'display_type' => 'timec',
					'mg_countdown_label_show' => 'block',
				],
			]
		);
		$this->add_control(
			'mg_days_label',
			[
				'label'       => __('Days Label', 'magical-addons-for-elementor'),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'input_type'  => 'text',
				'placeholder' => __('Days', 'magical-addons-for-elementor'),
				'default'     => __('Days', 'magical-addons-for-elementor'),
				'label_block'     => true,

			]
		);
		$this->add_control(
			'mg_hours_label',
			[
				'label'       => __('Hours Label', 'magical-addons-for-elementor'),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'input_type'  => 'text',
				'placeholder' => __('Hours', 'magical-addons-for-elementor'),
				'default'     => __('Hours', 'magical-addons-for-elementor'),
				'label_block'     => true,

			]
		);
		$this->add_control(
			'mg_minutes_label',
			[
				'label'       => __('Minutes Label', 'magical-addons-for-elementor'),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'input_type'  => 'text',
				'placeholder' => __('Minutes', 'magical-addons-for-elementor'),
				'default'     => __('Minutes', 'magical-addons-for-elementor'),
				'label_block'     => true,

			]
		);
		$this->add_control(
			'mg_seconds_label',
			[
				'label'       => __('Seconds Label', 'magical-addons-for-elementor'),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'input_type'  => 'text',
				'placeholder' => __('Seconds', 'magical-addons-for-elementor'),
				'default'     => __('Seconds', 'magical-addons-for-elementor'),
				'label_block'     => true,

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
			'mg_countdown_style',
			[
				'label' => __('Countdown Number Style', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'num_bgcolor',
			[
				'label'     => __('Number background color', 'magical-addons-for-elementor'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#222',
				'selectors' => [
					'{{WRAPPER}} .flip-clock-wrapper ul li a div div.inn' => 'background-color: {{VALUE}}'
				]
			]
		);
		$this->add_control(
			'num_color',
			[
				'label'     => __('Number color', 'magical-addons-for-elementor'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ccc',
				'selectors' => [
					'{{WRAPPER}} .flip-clock-wrapper ul li a div div.inn' => 'color: {{VALUE}}'
				]
			]
		);
		$this->add_control(
			'numdiv_color',
			[
				'label'     => __('Number divider color', 'magical-addons-for-elementor'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#000',
				'selectors' => [
					'{{WRAPPER}} .flip-clock-wrapper ul li a div.up:after' => 'background-color: {{VALUE}}'
				]
			]
		);
		$this->add_control(
			'numdot_color',
			[
				'label'     => __('Number dot color', 'magical-addons-for-elementor'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#000',
				'selectors' => [
					'{{WRAPPER}} .flip-clock-dot' => 'background-color: {{VALUE}}'
				]
			]
		);
		$this->add_responsive_control(
			'mg_num_height',
			[
				'label' => __('Number Height', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .flip-clock-wrapper ul.flip' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'mg_num_width',
			[
				'label' => __('Number Width', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .flip-clock-wrapper ul.flip' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'mg_num__shadow',
				'selector' => '{{WRAPPER}} .flip-clock-wrapper ul.flip'
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'number_typography',
				'selector' => '{{WRAPPER}} .mga-clock ul.flip li a .inn',
			]
		);
		$this->add_responsive_control(
			'mg_flip_num_padding',
			[
				'label' => __('Padding', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .flip-clock-wrapper ul.flip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'mg_flip_num_margin',
			[
				'label' => __('Margin', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .flip-clock-wrapper ul.flip' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'mg_clabel_style',
			[
				'label' => __('Countdown Label Style', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'display_type!' => 'genericc',
				],
			]
		);
		$this->add_control(
			'mg_label_color',
			[
				'label'     => __('Label Text Color', 'magical-addons-for-elementor'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#000',
				'selectors' => [
					'{{WRAPPER}} .flip-clock-meridium a, {{WRAPPER}} .flip-clock-divider .flip-clock-label' => 'color: {{VALUE}}'
				]
			]
		);
		$this->add_responsive_control(
			'mg_flip_label_margin',
			[
				'label' => __('Margin', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .flip-clock-meridium a, {{WRAPPER}} .flip-clock-divider .flip-clock-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'label_typography',
				'selector' => '{{WRAPPER}} .flip-clock-wrapper,.flip-clock-wrapper ul,.flip-clock-wrapper ul li a div,.flip-clock-wrapper ul li a div',
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
		wp_enqueue_style('flipclock');
		$settings   = $this->get_settings_for_display();
		$display_type   = $this->get_settings('display_type');
		$clock_format   = $this->get_settings('clock_format');
		$target_clock_time   = $this->get_settings('target_clock_time');
		$genericc_countdown   = $this->get_settings('genericc_countdown');
		$countdown_timing   = $this->get_settings('countdown_timing');
?>
		<div class="mga-clock" data-display-type="<?php echo $display_type; ?>" data-clock-format="<?php echo $clock_format; ?>" data-target-time="<?php echo $target_clock_time; ?>" data-countdown="<?php echo $genericc_countdown; ?>" data-timing="<?php echo $countdown_timing ?>" data-days-label="<?php echo esc_attr($settings['mg_days_label']); ?>" data-hours-label="<?php echo esc_attr($settings['mg_hours_label']); ?>" data-minutes-label="<?php echo esc_attr($settings['mg_minutes_label']); ?>" data-seconds-label="<?php echo esc_attr($settings['mg_seconds_label']); ?>"></div>
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
