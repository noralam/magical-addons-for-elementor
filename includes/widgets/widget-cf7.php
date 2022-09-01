<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

class MG_Addon_CF7 extends \Elementor\Widget_Base
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
		return 'mgcg7_widget';
	}
	public function get_keywords()
	{
		return ['contact form', 'form', 'contact', 'cf7', 'mg'];
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
		return __('Mg Contact Form 7', 'magical-addons-for-elementor');
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
		return 'eicon-table-of-contents';
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
	/**
	 * Register widget content controls
	 */
	protected function register_content_controls()
	{

		$this->start_controls_section(
			'_section_cf7',
			[
				'label' => mg_is_cf7_activated() ? __('Contact Form 7', 'magical-addons-for-elementor') : __('Missing Notice', 'magical-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		if (!mg_is_cf7_activated()) {

			$this->add_control(
				'_cf7_missing_notice',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw' => sprintf(
						__('Hello %2$s, looks like %1$s is missing in your site. Please click on the link below and install/activate %1$s. Make sure to refresh this page after installation or activation.', 'magical-addons-for-elementor'),
						'<a href="' . esc_url(admin_url('plugin-install.php?s=Contact+Form+7&tab=search&type=term'))
							. '" target="_blank" rel="noopener">Contact Form 7</a>',
						mg_get_current_user_display_name()
					),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-danger',
				]
			);

			$this->add_control(
				'_cf7_install',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw' => '<a href="' . esc_url(admin_url('plugin-install.php?s=Contact+Form+7&tab=search&type=term')) . '" target="_blank" rel="noopener">Click to install or activate Contact Form 7</a>',
				]
			);
		} else {

			$this->add_control(
				'form_id',
				[
					'label' => __('Select Your Form', 'magical-addons-for-elementor'),
					'type' => Controls_Manager::SELECT,
					'label_block' => true,
					'options' => ['' => __('', 'magical-addons-for-elementor')] + \mg_get_cf7_forms(),
				]
			);

			$this->add_control(
				'html_class',
				[
					'label' => __('HTML Class', 'magical-addons-for-elementor'),
					'type' => Controls_Manager::TEXT,
					'label_block' => true,
					'description' => __('Add CSS custom class to the form.', 'magical-addons-for-elementor'),
				]
			);
		}

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
		$this->fields_style_controls();
		$this->fields_label_style_controls();
		$this->submit_btn_style_controls();
	}

	protected function fields_style_controls()
	{

		$this->start_controls_section(
			'_section_fields_style',
			[
				'label' => __('Form Fields', 'magical-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'field_width',
			[
				'label' => __('Width', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => ['%', 'px'],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .mg-cf7-form label' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'field_margin',
			[
				'label' => __('Spacing Bottom', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'input_height',
			[
				'label' => __('Input Height', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} input.wpcf7-form-control:not(.wpcf7-submit)' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'textarea_height',
			[
				'label' => __('Textarea Height', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} textarea.wpcf7-form-control' => 'height: {{SIZE}}{{UNIT}};max-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'field_padding',
			[
				'label' => __('Padding', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'field_border_radius',
			[
				'label' => __('Border Radius', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'hr',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'field_typography',
				'selector' => '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)',
			]
		);

		$this->add_control(
			'field_color',
			[
				'label' => __('Text Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'field_placeholder_color',
			[
				'label' => __('Placeholder Text Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ::-webkit-input-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} ::-moz-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} ::-ms-input-placeholder' => 'color: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs('tabs_field_state');

		$this->start_controls_tab(
			'tab_field_normal',
			[
				'label' => __('Normal', 'magical-addons-for-elementor'),
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'field_border',
				'selector' => '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'field_box_shadow',
				'selector' => '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)',
			]
		);

		$this->add_control(
			'field_bg_color',
			[
				'label' => __('Background Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)' => 'background: {{VALUE}} !important',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_field_focus',
			[
				'label' => __('Focus', 'magical-addons-for-elementor'),
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'field_focus_border',
				'selector' => '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit):focus',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'field_focus_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit):focus',
			]
		);

		$this->add_control(
			'field_focus_bg_color',
			[
				'label' => __('Background Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit):focus' => 'background: {{VALUE}} !important',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function fields_label_style_controls()
	{

		$this->start_controls_section(
			'cf7-form-label',
			[
				'label' => __('Form Fields Label', 'magical-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'label_margin',
			[
				'label' => __('Spacing Bottom', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'hr3',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'selector' => '{{WRAPPER}} label',
			]
		);

		$this->add_control(
			'label_color',
			[
				'label' => __('Text Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} label' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function submit_btn_style_controls()
	{

		$this->start_controls_section(
			'submit',
			[
				'label' => __('Submit Button', 'magical-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'submit_margin',
			[
				'label' => __('Margin', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .wpcf7-submit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'submit_padding',
			[
				'label' => __('Padding', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .wpcf7-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'submit_typography',
				'selector' => '{{WRAPPER}} .wpcf7-submit',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'submit_border',
				'selector' => '{{WRAPPER}} .wpcf7-submit',
			]
		);

		$this->add_control(
			'submit_border_radius',
			[
				'label' => __('Border Radius', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .wpcf7-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'submit_box_shadow',
				'selector' => '{{WRAPPER}} .wpcf7-submit',
			]
		);

		$this->add_control(
			'hr4',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->start_controls_tabs('tabs_button_style');

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => __('Normal', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'submit_color',
			[
				'label' => __('Text Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .wpcf7-submit' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'submit_bg_color',
			[
				'label' => __('Background Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpcf7-submit' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => __('Hover', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'submit_hover_color',
			[
				'label' => __('Text Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpcf7-submit:hover, {{WRAPPER}} .wpcf7-submit:focus' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'submit_hover_bg_color',
			[
				'label' => __('Background Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpcf7-submit:hover, {{WRAPPER}} .wpcf7-submit:focus' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'submit_hover_border_color',
			[
				'label' => __('Border Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpcf7-submit:hover, {{WRAPPER}} .wpcf7-submit:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

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
		if (!mg_is_cf7_activated()) {
			mg_show_plugin_missing_alert(__('Contact Forms 7', 'magical-addons-for-elementor'));
			return;
		}

		$settings = $this->get_settings_for_display();

		if (!empty($settings['form_id'])) {
			echo mg_do_shortcode('contact-form-7', [
				'id' => $settings['form_id'],
				'html_class' => 'mg-cf7-form ' . mg_sanitize_html_class_param($settings['html_class']),
			]);
		}
	}
}
