<?php

// Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Icons_Manager;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

class mgproMailchimp extends Widget_Base
{
	use mgProHelpLink;
	public function get_name()
	{
		return 'mg-mailchimp';
	}

	public function get_title()
	{
		return __('Mg MailChimp', 'mg-elementor');
	}

	public function get_icon()
	{
		return 'eicon-mailchimp';
	}

	public function get_categories()
	{
		return ['magical'];
	}

	public function get_keywords()
	{
		return array(
			'mailchimp',
			'newsletter',
			'email',
			'form',
			'mg',
		);
	}

	public function get_script_depends()
	{
		return ['mg-mailchimp'];
	}

	public function get_style_depends()
	{
		return [
			'mg-mailchimp', 'elementor-icons-fa-solid',
			'elementor-icons-fa-regular',
		];
	}

	protected function register_controls()
	{

		$this->start_controls_section(
			'section_form',
			array(
				'label' => __('MailChimp Settings', 'mg-elementor'),
			)
		);

		$this->add_control(
			'mailchimp_lists',
			[
				'label'         => __('Mailchimp List', 'mg-elementor'),
				'type'          => Controls_Manager::SELECT,
				'label_block'   => false,
				'description'   => sprintf(__('You need to set your Api Key on the %1$ssettings page (Extra tab)%2$s', 'mg-elementor'), '<a href="' . add_query_arg(array('page' => 'magical-addons'), esc_url(admin_url('admin.php'))) . '" target="_blank">', '</a>'),
				'options'       => mg_mailchimp_lists(),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_fields',
			[
				'label'         => __('Fields', 'mg-elementor'),
			]
		);

		$this->add_control(
			'mailchimp_layout',
			[
				'label'         => __('Layout', 'mg-elementor'),
				'type'          => Controls_Manager::SELECT,
				'options'       => [
					'blocks' => __('Blocks', 'mg-elementor'),
					'inline' => __('Inline', 'mg-elementor'),
				],
				'default'       => 'inline',

			]
		);

		$this->add_control(
			'display_labels',
			[
				'label'         => __('Display Labels', 'mg-elementor'),
				'type'          => Controls_Manager::SWITCHER,
				'default'       => '',
				'return_value'  => 'yes',
			]
		);
		$this->add_control(
			'display_icons',
			[
				'label'         => __('Display Icons', 'mg-elementor'),
				'type'          => Controls_Manager::SWITCHER,
				'default'       => 'yes',
				'return_value'  => 'yes',
			]
		);

		$this->add_control(
			'display_first_name',
			[
				'label'         => __('Enable First Name', 'mg-elementor'),
				'type'          => Controls_Manager::SWITCHER,
				'default'       => '',
				'return_value'  => 'yes',
			]
		);
		$this->add_control(
			'icon_fname',
			[
				'label' => esc_html__('First Name Icon', 'elementor'),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-user-alt',
					'library' => 'fa-solid',
				],
				'condition' => [
					'display_icons' => 'yes',
					'display_first_name' => 'yes',
				],
			]
		);

		$this->add_control(
			'first_name_text',
			[
				'label'         => __('First Name Label', 'mg-elementor'),
				'type'          => Controls_Manager::TEXT,
				'dynamic'       => [
					'active' => true,
				],
				'label_block'   => false,
				'default'       => __('First Name', 'mg-elementor'),
				'condition'     => [
					'display_first_name' => 'yes',
				],
			]
		);

		$this->add_control(
			'display_last_name',
			[
				'label'         => __('Enable Last Name', 'mg-elementor'),
				'type'          => Controls_Manager::SWITCHER,
				'default'       => '',
				'return_value'  => 'yes',
			]
		);
		$this->add_control(
			'icon_lname',
			[
				'label' => esc_html__('Last Name Icon', 'elementor'),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-user',
					'library' => 'fa-solid',
				],
				'condition' => [
					'display_icons' => 'yes',
					'display_last_name' => 'yes',
				],
			]
		);

		$this->add_control(
			'last_name_text',
			[
				'label'         => __('Last Name Label', 'mg-elementor'),
				'type'          => Controls_Manager::TEXT,
				'dynamic'       => [
					'active' => true,
				],
				'label_block'   => false,
				'default'       => __('Last Name', 'mg-elementor'),
				'condition'     => [
					'display_last_name' => 'yes',
				],
			]
		);
		$this->add_control(
			'icon_email',
			[
				'label' => esc_html__('Email Icon', 'elementor'),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fas fa-envelope',
					'library' => 'fa-solid',
				],
				'condition' => [
					'display_icons' => 'yes',
				],
			]
		);

		$this->add_control(
			'email_text',
			[
				'label'         => __('Email Label', 'mg-elementor'),
				'type'          => Controls_Manager::TEXT,
				'dynamic'       => [
					'active' => true,
				],
				'label_block'   => false,
				'default'       => __('Email Address', 'mg-elementor'),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button',
			[
				'label'         => __('Button', 'mg-elementor'),
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'         => __('Button Text', 'mg-elementor'),
				'type'          => Controls_Manager::TEXT,
				'dynamic'       => [
					'active' => true,
				],
				'label_block'   => false,
				'default'       => __('Subscribe', 'mg-elementor'),
			]
		);

		$this->add_control(
			'loading_text',
			[
				'label'         => __('Loading Text', 'mg-elementor'),
				'type'          => Controls_Manager::TEXT,
				'dynamic'       => [
					'active' => true,
				],
				'label_block'   => false,
				'default'       => __('Submitting...', 'mg-elementor'),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_message',
			[
				'label'         => __('Message', 'mg-elementor'),
			]
		);

		$this->add_control(
			'success_text',
			[
				'label'         => __('Success Text', 'mg-elementor'),
				'type'          => Controls_Manager::TEXT,
				'dynamic'       => [
					'active' => true,
				],
				'label_block'   => true,
				'default'       => __('You have subscribed successfully!', 'mg-elementor'),
			]
		);

		$this->end_controls_section();
		$this->link_pro_added();

		$this->start_controls_section(
			'section_general_style',
			[
				'label'         => __('General', 'mg-elementor'),
				'tab'           => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'          => 'mailchimp_bg',
				'label'         => __('Background', 'mg-elementor'),
				'types'         => ['none', 'classic', 'gradient'],
				'selector'      => '{{WRAPPER}} .mg-mailchimp-wrap',
			]
		);

		$this->add_responsive_control(
			'mailchimp_padding',
			[
				'label'         => __('Padding', 'mg-elementor'),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => ['px', 'em', '%'],
				'selectors'     => [
					'{{WRAPPER}} .mg-mailchimp-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'mailchimp_margin',
			[
				'label'         => __('Margin', 'mg-elementor'),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => ['px', 'em', '%'],
				'selectors'     => [
					'{{WRAPPER}} .mg-mailchimp-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'mailchimp_border',
				'label'         => __('Border', 'mg-elementor'),
				'selector'      => '{{WRAPPER}} .mg-mailchimp-wrap',
			]
		);

		$this->add_responsive_control(
			'mailchimp_border_radius',
			[
				'label'         => __('Border Radius', 'mg-elementor'),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => ['px', 'em', '%'],
				'selectors'     => [
					'{{WRAPPER}} .mg-mailchimp-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'          => 'mailchimp_box_shadow',
				'selector'      => '{{WRAPPER}} .mg-mailchimp-wrap',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_form_icon',
			[
				'label'         => __('Form Icons', 'mg-elementor'),
				'tab'           => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'icons_size',
			[
				'label'         => __('Icons Size', 'mg-elementor'),
				'type'          => Controls_Manager::SLIDER,
				'range'         => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'     => [
					'{{WRAPPER}} .input-icon-wrap i' => 'font-size: {{SIZE}}{{UNIT}};'
				],
			]
		);
		$this->add_control(
			'Icons_color',
			[
				'label' => __('Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .input-icon-wrap i' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'icons_bgcolor',
				'selector' => '{{WRAPPER}} .input-icon-wrap i',
			]
		);
		$this->add_responsive_control(
			'icons_padding',
			[
				'label' => __('Padding', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .input-icon-wrap i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'icons_margin',
			[
				'label' => __('Margin', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .input-icon-wrap i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'icons_border',
				'placeholder'   => '1px',
				'selector'      => '{{WRAPPER}} .input-icon-wrap i',
			]
		);
		$this->add_control(
			'icons_border_radius',
			[
				'label' => __('Border Radius', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .input-icon-wrap i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_form_style',
			[
				'label'         => __('Form Fields', 'mg-elementor'),
				'tab'           => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'fields_spacing',
			[
				'label'         => __('Fields Spacing', 'mg-elementor'),
				'type'          => Controls_Manager::SLIDER,
				'range'         => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'     => [
					'{{WRAPPER}} .mg-mailchimp-wrap.mg-mc-blocks .mg-field' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .mg-mailchimp-wrap.mg-mc-inline .mg-form-fields .mg-field' => 'margin-right: {{SIZE}}{{UNIT}};',
					'body.rtl {{WRAPPER}} .mg-mailchimp-wrap.mg-mc-inline .mg-form-fields .mg-field' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_labels_style',
			[
				'label'         => __('Layouts', 'mg-elementor'),
				'type'          => Controls_Manager::HEADING,
				'condition'     => [
					'display_labels' => 'yes',
				],
				'separator'     => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'          => 'labels_typography',
				'selector'      => '{{WRAPPER}} .mg-mailchimp-wrap .mg-field label',
				'condition'     => [
					'display_labels' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'labels_margin',
			[
				'label'         => __('Margin', 'mg-elementor'),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => ['px', 'em', '%'],
				'selectors'     => [
					'{{WRAPPER}} .mg-mailchimp-wrap .mg-field label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'     => [
					'display_labels' => 'yes',
				],
			]
		);

		$this->add_control(
			'heading_inputs_style',
			[
				'label'         => __('Inputs', 'mg-elementor'),
				'type'          => Controls_Manager::HEADING,
				'condition'     => [
					'display_labels' => 'yes',
				],
				'separator'     => 'before',
			]
		);

		$this->add_responsive_control(
			'inputs_width',
			[
				'label'         => __('Width', 'mg-elementor'),
				'type'          => Controls_Manager::SLIDER,
				'size_units'    => ['px', 'em', '%'],
				'range'         => [
					'px' => [
						'min' => 10,
						'max' => 1500,
					],
					'em' => [
						'min' => 1,
						'max' => 80,
					],
				],
				'selectors'     => [
					'{{WRAPPER}} .mg-mailchimp-wrap .mg-field .mg-mc-input' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'inputs_height',
			[
				'label'         => __('Height', 'mg-elementor'),
				'type'          => Controls_Manager::SLIDER,
				'size_units'    => ['px', 'em', '%'],
				'range'         => [
					'px' => [
						'min' => 30,
						'max' => 1500,
					],
					'em' => [
						'min' => 1,
						'max' => 80,
					],
				],
				'selectors'     => [
					'{{WRAPPER}} .mg-mailchimp-wrap .mg-field .mg-mc-input' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'          => 'inputs_typography',
				'selector'      => '{{WRAPPER}} .mg-mailchimp-wrap .mg-field .mg-mc-input',
			]
		);

		$this->start_controls_tabs('tabs_inputs_style');

		$this->start_controls_tab(
			'tab_inputs_normal',
			[
				'label'         => __('Normal', 'mg-elementor'),
			]
		);

		$this->add_control(
			'inputs_background_color',
			[
				'label'         => __('Background Color', 'mg-elementor'),
				'type'          => Controls_Manager::COLOR,
				'selectors'     => [
					'{{WRAPPER}} .mg-mailchimp-wrap .mg-field .mg-mc-input' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'inputs_text_color',
			[
				'label'         => __('Text Color', 'mg-elementor'),
				'type'          => Controls_Manager::COLOR,
				'default'       => '',
				'selectors'     => [
					'{{WRAPPER}} .mg-mailchimp-wrap .mg-field .mg-mc-input' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_inputs_hover',
			[
				'label'         => __('Hover', 'mg-elementor'),
			]
		);

		$this->add_control(
			'inputs_background_hover_color',
			[
				'label'         => __('Background Color', 'mg-elementor'),
				'type'          => Controls_Manager::COLOR,
				'selectors'     => [
					'{{WRAPPER}} .mg-mailchimp-wrap .mg-field .mg-mc-input:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'inputs_hover_color',
			[
				'label'         => __('Text Color', 'mg-elementor'),
				'type'          => Controls_Manager::COLOR,
				'selectors'     => [
					'{{WRAPPER}} .mg-mailchimp-wrap .mg-field .mg-mc-input:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'inputs_hover_border_color',
			[
				'label'         => __('Border Color', 'mg-elementor'),
				'type'          => Controls_Manager::COLOR,
				'selectors'     => [
					'{{WRAPPER}} .mg-mailchimp-wrap .mg-field .mg-mc-input:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_inputs_focus',
			[
				'label'         => __('Focus', 'mg-elementor'),
			]
		);

		$this->add_control(
			'inputs_background_focus_color',
			[
				'label'         => __('Background Color', 'mg-elementor'),
				'type'          => Controls_Manager::COLOR,
				'selectors'     => [
					'{{WRAPPER}} .mg-mailchimp-wrap .mg-field .mg-mc-input:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'inputs_focus_color',
			[
				'label'         => __('Text Color', 'mg-elementor'),
				'type'          => Controls_Manager::COLOR,
				'selectors'     => [
					'{{WRAPPER}} .mg-mailchimp-wrap .mg-field .mg-mc-input:focus' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'inputs_focus_border_color',
			[
				'label'         => __('Border Color', 'mg-elementor'),
				'type'          => Controls_Manager::COLOR,
				'selectors'     => [
					'{{WRAPPER}} .mg-mailchimp-wrap .mg-field .mg-mc-input:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'inputs_placeholder_color',
			[
				'label'         => __('Placeholder Color', 'mg-elementor'),
				'type'          => Controls_Manager::COLOR,
				'selectors'     => [
					'{{WRAPPER}} .mg-mailchimp-wrap .mg-field .mg-mc-input::-webkit-input-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mg-mailchimp-wrap .mg-field .mg-mc-input::-moz-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mg-mailchimp-wrap .mg-field .mg-mc-input::-ms-input-placeholder' => 'color: {{VALUE}};',
				],
				'separator'     => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'inputs_border',
				'placeholder'   => '1px',
				'selector'      => '{{WRAPPER}} .mg-mailchimp-wrap .mg-field .mg-mc-input',
			]
		);

		$this->add_control(
			'inputs_border_radius',
			[
				'label'         => __('Border Radius', 'mg-elementor'),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => ['px', '%'],
				'selectors'     => [
					'{{WRAPPER}} .mg-mailchimp-wrap .mg-field .mg-mc-input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'          => 'inputs_box_shadow',
				'selector'      => '{{WRAPPER}} .mg-mailchimp-wrap .mg-field .mg-mc-input',
			]
		);

		$this->add_responsive_control(
			'inputs_padding',
			[
				'label'         => __('Padding', 'mg-elementor'),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => ['px', 'em', '%'],
				'selectors'     => [
					'{{WRAPPER}} .mg-mailchimp-wrap .mg-field .mg-mc-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_btn_style',
			[
				'label'         => __('Button', 'mg-elementor'),
				'tab'           => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'          => 'button_typography',
				'selector'      => '{{WRAPPER}} .mg-mailchimp-wrap .mg-field .mg-mc-subscribe',
			]
		);

		$this->start_controls_tabs('tabs_button_style');

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label'         => __('Normal', 'mg-elementor'),
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'         => __('Background Color', 'mg-elementor'),
				'type'          => Controls_Manager::COLOR,
				'selectors'     => [
					'{{WRAPPER}} .mg-mailchimp-wrap .mg-field .mg-mc-subscribe' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'         => __('Text Color', 'mg-elementor'),
				'type'          => Controls_Manager::COLOR,
				'default'       => '',
				'selectors'     => [
					'{{WRAPPER}} .mg-mailchimp-wrap .mg-field .mg-mc-subscribe' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label'         => __('Hover', 'mg-elementor'),
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'         => __('Background Color', 'mg-elementor'),
				'type'          => Controls_Manager::COLOR,
				'selectors'     => [
					'{{WRAPPER}} .mg-mailchimp-wrap .mg-field .mg-mc-subscribe:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'label'         => __('Text Color', 'mg-elementor'),
				'type'          => Controls_Manager::COLOR,
				'selectors'     => [
					'{{WRAPPER}} .mg-mailchimp-wrap .mg-field .mg-mc-subscribe:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'         => __('Border Color', 'mg-elementor'),
				'type'          => Controls_Manager::COLOR,
				'selectors'     => [
					'{{WRAPPER}} .mg-mailchimp-wrap .mg-field .mg-mc-subscribe:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'button_border',
				'placeholder'   => '1px',
				'selector'      => '{{WRAPPER}} .mg-mailchimp-wrap .mg-field .mg-mc-subscribe',
				'separator'     => 'before',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'         => __('Border Radius', 'mg-elementor'),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => ['px', '%'],
				'selectors'     => [
					'{{WRAPPER}} .mg-mailchimp-wrap .mg-field .mg-mc-subscribe' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'          => 'button_box_shadow',
				'selector'      => '{{WRAPPER}} .mg-mailchimp-wrap .mg-field .mg-mc-subscribe',
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'         => __('Padding', 'mg-elementor'),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => ['px', 'em', '%'],
				'selectors'     => [
					'{{WRAPPER}} .mg-mailchimp-wrap .mg-field .mg-mc-subscribe' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_msg_style',
			[
				'label'         => __('Message', 'mg-elementor'),
				'tab'           => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'          => 'msg_typography',
				'selector'      => '{{WRAPPER}} .mg-mailchimp-wrap .mg-mc-message',
			]
		);

		$this->add_responsive_control(
			'msg_align',
			[
				'label'         => __('Alignment', 'mg-elementor'),
				'type'          => Controls_Manager::CHOOSE,
				'options'       => [
					'left'    => [
						'title' => __('Left', 'mg-elementor'),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __('Center', 'mg-elementor'),
						'icon'  => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __('Right', 'mg-elementor'),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'       => '',
				'selectors'     => [
					'{{WRAPPER}} .mg-mailchimp-wrap .mg-mc-message' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs('tabs_msg_style');

		$this->start_controls_tab(
			'tab_success_msg',
			[
				'label'         => __('Success', 'mg-elementor'),
			]
		);

		$this->add_control(
			'success_background_color',
			[
				'label'         => __('Background Color', 'mg-elementor'),
				'type'          => Controls_Manager::COLOR,
				'selectors'     => [
					'{{WRAPPER}} .mg-mailchimp-wrap .mg-mc-message.mg-mc-success-text' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'success_text_color',
			[
				'label'         => __('Text Color', 'mg-elementor'),
				'type'          => Controls_Manager::COLOR,
				'default'       => '',
				'selectors'     => [
					'{{WRAPPER}} .mg-mailchimp-wrap .mg-mc-message.mg-mc-success-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_error_msg',
			[
				'label'         => __('Error', 'mg-elementor'),
			]
		);

		$this->add_control(
			'error_background_color',
			[
				'label'         => __('Background Color', 'mg-elementor'),
				'type'          => Controls_Manager::COLOR,
				'selectors'     => [
					'{{WRAPPER}} .mg-mailchimp-wrap .mg-mc-message.mg-mc-error-text' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'error_text_color',
			[
				'label'         => __('Text Color', 'mg-elementor'),
				'type'          => Controls_Manager::COLOR,
				'default'       => '',
				'selectors'     => [
					'{{WRAPPER}} .mg-mailchimp-wrap .mg-mc-message.mg-mc-error-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'          => 'msg_border',
				'placeholder'   => '1px',
				'selector'      => '{{WRAPPER}} .mg-mailchimp-wrap .mg-mc-message',
				'separator'     => 'before',
			]
		);

		$this->add_control(
			'msg_border_radius',
			[
				'label'         => __('Border Radius', 'mg-elementor'),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => ['px', '%'],
				'selectors'     => [
					'{{WRAPPER}} .mg-mailchimp-wrap .mg-mc-message' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'          => 'msg_box_shadow',
				'selector'      => '{{WRAPPER}} .mg-mailchimp-wrap .mg-mc-message',
			]
		);

		$this->add_responsive_control(
			'msg_padding',
			[
				'label'         => __('Padding', 'mg-elementor'),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => ['px', 'em', '%'],
				'selectors'     => [
					'{{WRAPPER}} .mg-mailchimp-wrap .mg-mc-message' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'msg_margin',
			[
				'label'         => __('Margin', 'mg-elementor'),
				'type'          => Controls_Manager::DIMENSIONS,
				'size_units'    => ['px', 'em', '%'],
				'selectors'     => [
					'{{WRAPPER}} .mg-mailchimp-wrap .mg-mc-message' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render()
	{
		$dfname = get_bloginfo('name');
		$firstarr = explode(' ', trim($dfname));
		$settings   = $this->get_settings_for_display();
		$api_key    = mg_get_extra_option('mg_mailchamp_api');

		$mc_layout  = $settings['mailchimp_layout'];
		$labels     = $settings['display_labels'];
		$first_name    = $settings['first_name_text'];
		$fn_text = $first_name ? $first_name : $firstarr[0];
		$last_name    = $settings['last_name_text'];
		$ln_text = $last_name ? $last_name : __('user', 'magical-addons-for-elementor');

		$e_text     = $settings['email_text'];

		// Layout Class
		if ('blocks' === $mc_layout) {
			$layout = 'mg-mc-blocks';
		} elseif ('inline' === $mc_layout) {
			$layout = 'mg-mc-inline';
		}

		$this->add_render_attribute('wrapper', [
			'class' => [
				'mg-mailchimp-wrap item-visiable',
				esc_attr($layout),
			],
			'data-mailchimp-id' => [
				esc_attr($this->get_id()),
			],
			'data-api-key' => [
				esc_attr($api_key),
			],
			'data-list-id' => [
				$settings['mailchimp_lists'],
			],
			'data-button-text' => [
				$settings['button_text'],
			],
			'data-success-text' => [
				$settings['success_text'],
			],
			'data-loading-text' => [
				$settings['loading_text'],
			],
		]);

		$this->add_render_attribute('fields-wrapper', [
			'class' => [
				'mg-form-fields',
			],
		]);
		if (!empty($api_key)) { ?>

			<div <?php $this->print_render_attribute_string('wrapper'); ?>>
				<?php if (empty($settings['mailchimp_lists'])) : ?>
					<div class="mgmailchimp-error">
						<?php esc_html_e('Please select a MailChimp list to activate the form. Otherwise your form not working.'); ?>
					</div>
				<?php endif; ?>
				<form id="mg-mc-form-<?php echo esc_attr($this->get_id()); ?>" class="mg-mc-form" method="POST">
					<div <?php $this->print_render_attribute_string('fields-wrapper'); ?>>

						<?php
						if ('yes' === $settings['display_first_name']) { ?>
							<div class="mg-field mg-mc-fname">
								<?php
								if ('yes' === $labels) { ?>
									<label for="mg_mc_fn_<?php echo esc_attr($this->get_id()); ?>"><?php echo esc_attr($fn_text); ?></label>
								<?php
								}
								?>
								<div class="input-icon-wrap">
									<?php
									if ($settings['icon_fname']) {
										Icons_Manager::render_icon($settings['icon_fname'], ['aria-hidden' => 'true']);
									}
									?>
									<input id="mg_mc_fn_<?php echo esc_attr($this->get_id()); ?>" type="text" name="mg_mc_firstname" class="mg-mc-input mg-mc-input-fn" placeholder="<?php echo esc_attr($fn_text); ?>">
								</div>
							</div>
						<?php
						} else {
						?>
							<input type="hidden" name="hfname" id="hfname" value="<?php echo esc_attr($fn_text); ?>">
						<?php
						}

						if ('yes' === $settings['display_last_name']) { ?>
							<div class="mg-field mg-mc-lname">
								<?php
								if ('yes' === $labels) { ?>
									<label for="mg_mc_ln_<?php echo esc_attr($this->get_id()); ?>"><?php echo esc_attr($ln_text); ?></label>
								<?php
								} ?>
								<div class="input-icon-wrap">
									<?php
									if ($settings['icon_lname']) {
										Icons_Manager::render_icon($settings['icon_lname'], ['aria-hidden' => 'true']);
									}
									?>
									<input id="mg_mc_ln_<?php echo esc_attr($this->get_id()); ?>" type="text" name="mg_mc_lastname" class="mg-mc-input mg-mc-input-ln" placeholder="<?php echo esc_attr($ln_text); ?>">

								</div>
							</div>
						<?php
						} else {
						?>
							<input type="hidden" name="lname" id="lname" value="<?php echo esc_attr($ln_text); ?>">
						<?php
						} ?>

						<div class="mg-field mg-mc-email">
							<?php
							if ('yes' === $labels) { ?>
								<label for="mg_mc_e_<?php echo esc_attr($this->get_id()); ?>"><?php echo esc_attr($e_text); ?></label>
							<?php
							} ?>
							<div class="input-icon-wrap">
								<?php
								if ($settings['icon_email']) {
									Icons_Manager::render_icon($settings['icon_email'], ['aria-hidden' => 'true']);
								}
								?>
								<input id="mg_mc_e_<?php echo esc_attr($this->get_id()); ?>" type="email" name="mg_mc_email" class="mg-mc-input mg-mc-input-email" placeholder="<?php echo esc_attr($e_text); ?>" required="required">
							</div>
						</div>

						<div class="mg-field mg-mc-submit">
							<button type="submit" id="mg-subscribe-<?php echo esc_attr($this->get_id()); ?>" class="mg-button mg-mc-subscribe">
								<div class="mg-btn-loader"></div>
								<span><?php echo esc_attr($settings['button_text']); ?></span>
							</button>
						</div>

					</div>
					<div class="mg-mc-message"></div>
				</form>
			</div>

		<?php
		} else { ?>
			<p class="mg-mc-error"><?php echo esc_html__('Please insert your api key', 'mg-elementor'); ?></p>
<?php
		}
	}
}
