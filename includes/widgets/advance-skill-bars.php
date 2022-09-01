<?php

/**
 * Skills widget class
 *
 * @package Magical Addons
 */


use Elementor\Group_Control_Text_Shadow;
use Elementor\Repeater;
use \Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

defined('ABSPATH') || die();

class mgSkillBars extends Widget_Base
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
		return 'mgskillbars';
	}
	/**
	 * Get widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title()
	{
		return __('Advance Skill Bars', 'magical-addons-for-elementor');
	}


	/**
	 * Get widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon()
	{
		return 'eicon-skill-bar';
	}

	public function get_keywords()
	{
		return ['mg', 'skill', 'bar', 'progress', 'chart'];
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
			'mg-skillbars',
		];
	}

	protected function register_controls()
	{

		$this->register_content_controls();
		$this->register_style_controls();
	}



	/**
	 * Register widget content controls
	 */
	protected function register_content_controls()
	{

		$this->start_controls_section(
			'_section_skills',
			[
				'label' => __('Skills', 'magical-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'name',
			[
				'type' => Controls_Manager::TEXT,
				'label' => __('Name', 'magical-addons-for-elementor'),
				'default' => __('Design', 'magical-addons-for-elementor'),
				'placeholder' => __('Type a skill name', 'magical-addons-for-elementor'),
			]
		);

		$repeater->add_control(
			'level',
			[
				'label' => __('Percentage', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
					'size' => 95
				],
				'size_units' => ['%'],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'dynamic' => [
					'active' => true,
				]
			]
		);

		$repeater->add_control(
			'color',
			[
				'label' => __('Text Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .mg-skill-info' => 'color: {{VALUE}};',
				],
				'style_transfer' => true,
			]
		);

		$repeater->add_control(
			'level_color',
			[
				'label' => __('Level Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .mg-skill-level' => 'background: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} .mg-skill-level:before' => 'background: {{VALUE}};',
				],
				'style_transfer' => true,
			]
		);

		$repeater->add_control(
			'base_color',
			[
				'label' => __('Base Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.mg-skill' => 'background-color: {{VALUE}};',
				],
				'style_transfer' => true,
			]
		);

		$this->add_control(
			'skills',
			[
				'show_label' => false,
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '<# print((name || level.size) ? (name || "Skill") + " - " + level.size + level.unit : "Skill - 0%") #>',
				'default' => [
					[
						'name' => 'Design',
						'level' => ['size' => 95, 'unit' => '%'],
						'level_color' => '#031b88'
					],
					[
						'name' => 'Elementor',
						'level' => ['size' => 93, 'unit' => '%'],
						'level_color' => '#EA4492'
					],
					[
						'name' => 'WordPress',
						'level' => ['size' => 90, 'unit' => '%'],
						'level_color' => '#522157'
					]

				]
			]
		);

		$this->add_control(
			'view',
			[
				'type' => Controls_Manager::SELECT,
				'label' => __('Text Position', 'magical-addons-for-elementor'),
				'separator' => 'before',
				'default' => 'outside',
				'options' => [
					'inside' => __('Text Inside', 'magical-addons-for-elementor'),
					'outside' => __('Text Outside', 'magical-addons-for-elementor'),
				],
				'style_transfer' => true,
			]
		);
		$this->add_control(
			'extra_dot',
			[
				'label' => __('Show Extra Dot?', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'magical-addons-for-elementor'),
				'label_off' => __('No', 'magical-addons-for-elementor'),
				'default' => 'yes',
				'prefix_class' => 'mg-skill-extra-dot-',
				'condition' => ['view' => 'outside'],

			]
		);
		$this->add_responsive_control(
			'extra_dot_width',
			[
				'label' => esc_html__('Width', 'magical-addons-for-elementor'),
				'type' =>  \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mg-skill--outside .mg-skill-level:before' => 'width: {{SIZE}}{{UNIT}} !important;',

				],
				'condition' => ['view' => 'outside', 'extra_dot' => 'yes'],

			]
		);
		$this->add_responsive_control(
			'extra_dot_height',
			[
				'label' => esc_html__('height', 'magical-addons-for-elementor'),
				'type' =>  \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mg-skill--outside .mg-skill-level:before' => 'height: {{SIZE}}{{UNIT}} !important;',

				],
				'condition' => ['view' => 'outside', 'extra_dot' => 'yes'],

			]
		);

		$this->end_controls_section();
		$this->link_pro_added();
	}

	/**
	 * Register widget style controls
	 */
	protected function register_style_controls()
	{
		$this->__bars_style_controls();
		$this->__content_style_controls();
	}

	protected function __bars_style_controls()
	{

		$this->start_controls_section(
			'_section_style_bars',
			[
				'label' => __('Skill Bars', 'magical-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'height',
			[
				'label' => __('Height', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 250,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mg-skill--outside' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .mg-skill--inside' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'spacing',
			[
				'label' => __('Spacing Between', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 250,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mg-skill--outside:not(:first-child)' => 'margin-top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .mg-skill--inside:not(:first-child)' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __('Border Radius', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-skill, {{WRAPPER}} .mg-skill-level' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .mg-skill'
			]
		);

		$this->end_controls_section();
	}

	protected function __content_style_controls()
	{

		$this->start_controls_section(
			'_section_content',
			[
				'label' => __('Content', 'magical-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'color',
			[
				'label' => __('Text Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-skill-info' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'level_color',
			[
				'label' => __('Level Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-skill-level' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'base_color',
			[
				'label' => __('Base Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-skill' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'info_typography',
				'selector' => '{{WRAPPER}} .mg-skill-info',
				'scheme' => Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'info_text_shadow',
				'selector' => '{{WRAPPER}} .mg-skill-info',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'_section_exdot',
			[
				'label' => __('Extra Dot Style', 'magical-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => ['view' => 'outside', 'extra_dot' => 'yes'],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'exdot_border',
				'selector' => '{{WRAPPER}}.mg-skill-extra-dot-yes .mg-skill--outside .mg-skill-level:before',
			]
		);
		$this->add_control(
			'exdot_border_radius',
			[
				'label' => __('Border Radius', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}}.mg-skill-extra-dot-yes .mg-skill--outside .mg-skill-level:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'exdot_box_shadow',
				'selector' => '{{WRAPPER}}.mg-skill-extra-dot-yes .mg-skill--outside .mg-skill-level:before'
			]
		);
		$this->add_control(
			'exdot_color',
			[
				'label' => __('Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.mg-skill-extra-dot-yes .mg-skill--outside .mg-skill-level:before' => 'background: {{VALUE}} !important;',
				],
			]
		);
		$this->end_controls_section();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();

		if (!is_array($settings['skills'])) {
			return;
		}

		foreach ($settings['skills'] as $index => $skill) :
			$name_key = $this->get_repeater_setting_key('name', 'bars', $index);
			$this->add_inline_editing_attributes($name_key, 'none');
			$this->add_render_attribute($name_key, 'class', 'mg-skill-name');
?>
			<div class="mg-skill mg-skill--<?php echo esc_attr($settings['view']); ?> elementor-repeater-item-<?php echo $skill['_id']; ?>">
				<div class="mg-skill-level" data-level="<?php echo esc_attr($skill['level']['size']); ?>">
					<div class="mg-skill-info"><span <?php echo $this->get_render_attribute_string($name_key); ?>><?php echo esc_html($skill['name']); ?></span><span class="mg-skill-level-text"></span></div>
				</div>
			</div>
		<?php
		endforeach;
	}

	protected function content_template()
	{
		?>
		<# if (_.isArray(settings.skills)) { _.each(settings.skills, function(skill, index) { var nameKey=view.getRepeaterSettingKey( 'name' , 'skills' , index); view.addInlineEditingAttributes( nameKey, 'none' ); view.addRenderAttribute( nameKey, 'class' , 'mg-skill-name' ); #>
			<div class="mg-skill mg-skill--{{settings.view}} elementor-repeater-item-{{skill._id}}">
				<div class="mg-skill-level" data-level="{{skill.level.size}}">
					<div class="mg-skill-info"><span {{{view.getRenderAttributeString( nameKey )}}}>{{skill.name}}</span><span class="mg-skill-level-text"></span></div>
				</div>
			</div>
			<# }); } #>
		<?php
	}
}
