<?php

use Elementor\Group_Control_Text_Shadow;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

defined('ABSPATH') || die();


class MgProgressbar extends \Elementor\Widget_Base
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
		return 'mgprogressbar_widget';
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
		return __('MG Progressbar', 'magical-addons-for-elementor');
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
		return 'eicon-form-vertical';
	}

	public function get_keywords()
	{
		return ['progress', 'progressbar', 'bar', 'mg'];
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
			'elementor-waypoints',
			'mg-progressbar',
			'mg-progressbar-active',
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
			'mg_progressbar',
			[
				'label' => __('Magical progress Bar', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'mgp_title_use',
			[
				'label' => __('Use Title', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',

			]
		);
		$this->add_control(
			'mgp_title',
			[
				'label' => __('Title', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'condition' => [
					'mgp_title_use' => 'yes',
				],
				'default' => __('My Skill', 'magical-addons-for-elementor'),

			]
		);
		$this->add_control(
			'mgp_parcent',
			[
				'label' => __('Percentage', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['%'],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 80,
				],

			]
		);
		$this->add_control(
			'mgp_parcent_show',
			[
				'label' => __('Show percentage', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',

			]
		);

		$this->add_control(
			'mgp_animation_time',
			[
				'label' => __('Animation time', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['%'],
				'range' => [
					'%' => [
						'min' => 100,
						'max' => 5000,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 1500,
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
			'progress_bgstyle',
			[
				'label' => __('Progress Bar Background style', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'pbar_bgcolor',
				'label' => __('Background', 'magical-addons-for-elementor'),
				'types' => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}} .mg-progress',
			]
		);
		$this->add_responsive_control(
			'pbar_padding',
			[
				'label' => __('Padding', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-progress' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'pbar_radius',
			[
				'label' => __('Border Radius', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mg-progress' => 'border-radius: {{SIZE}}{{UNIT}}'
				]

			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'pbar_bshadow',
				'selector' => '{{WRAPPER}} .mg-progress',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'progress_style',
			[
				'label' => __('Progress Bar style', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'bar_color',
			[
				'label'     => __('Bar color', 'magical-addons-for-elementor'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#f0ad4e',

			]
		);

		$this->add_control(
			'trail_color',
			[
				'label'     => __('Trail color', 'magical-addons-for-elementor'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#eee',

			]
		);

		$this->add_control(
			'bar_height',
			[
				'label' => __('Height', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],

			]
		);
		$this->add_control(
			'trail_height',
			[
				'label' => __('Trail Height', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 1,
				],

			]
		);
		$this->add_control(
			'stroke_width',
			[
				'label' => __('Stroke Width', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 4,
				],

			]
		);
		$this->add_control(
			'bar_radius',
			[
				'label' => __('Border Radius', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .mg-progress svg' => 'border-radius: {{SIZE}}{{UNIT}}'
				]

			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'bar_shadow',
				'selector' => '{{WRAPPER}} .mg-progress svg',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'progress_text_style',
			[
				'label' => __('Text style', 'magical-addons-for-elementor'),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'title_margin',
			[
				'label' => __('Title Margin', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} span.mg-progress-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __('Title color', 'magical-addons-for-elementor'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#222',
				'selectors' => [
					'{{WRAPPER}} span.mg-progress-title' => 'color: {{VALUE}}'
				]

			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .mg-progress-title',
			]
		);
		$this->add_control(
			'text_color',
			[
				'label'     => __('Percentage Text color', 'magical-addons-for-elementor'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#222',
				'selectors' => [
					'{{WRAPPER}} .mg-progress .progressbar-text' => 'color: {{VALUE}} !important'
				]

			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'text_typography',
				'selector' => '{{WRAPPER}} .mg-progress .progressbar-text',
			]
		);
		$this->add_control(
			'percentage_rlposition',
			[
				'label' => __('Percentage Text left right position', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mg-progress .progressbar-text' => 'right: {{SIZE}}{{UNIT}} !important'
				]


			]
		);
		$this->add_control(
			'percentage_tbposition',
			[
				'label' => __('Percentage Text top bottom position', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => -50,
						'max' => 50,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mg-progress .progressbar-text' => 'top: {{SIZE}}{{UNIT}} !important'
				]


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
		$mgp_title_use   = $this->get_settings('mgp_title_use');
		$mgp_title   = $this->get_settings('mgp_title');
		$mgp_parcent_show   = $this->get_settings('mgp_parcent_show');
		$mgp_parcent   = $this->get_settings('mgp_parcent');
		$bar_color   = $this->get_settings('bar_color');
		$trail_color   = $this->get_settings('trail_color');
		$bar_height   = $this->get_settings('bar_height');
		$trail_height   = $this->get_settings('trail_height');
		$stroke_width   = $this->get_settings('stroke_width');
		$mgp_animation_time   = $this->get_settings('mgp_animation_time');
		$this->add_inline_editing_attributes('mgp_title');
		$this->add_render_attribute('mgp_title', 'class', 'mg-progress-title');

?>
		<?php if ($mgp_title_use == 'yes') : ?>
			<span <?php echo $this->get_render_attribute_string('mgp_title'); ?>><?php echo mg_kses_tags($mgp_title); ?></span>
		<?php endif; ?>
		<div class="mg-progress" data-parcent-show="<?php echo esc_attr($mgp_parcent_show); ?>" data-parcent="<?php echo esc_attr($mgp_parcent['size']); ?>" data-barcolor="<?php echo esc_attr($bar_color); ?>" data-trailcolor="<?php echo esc_attr($trail_color); ?>" data-barheight="<?php echo esc_attr($bar_height['size']); ?>" data-trailheight="<?php echo esc_attr($trail_height['size']); ?>" data-strokewidth="<?php echo esc_attr($stroke_width['size']); ?>" data-animation-time="<?php echo esc_attr($mgp_animation_time['size']); ?>"></div>

<?php


	}
}
