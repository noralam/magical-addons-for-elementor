<?php

use Elementor\Core\Schemes;

class MgAddon_text_effects extends \Elementor\Widget_Base
{
	use mgProHelpLink;
	/**
	 * Get widget name.
	 *
	 * Retrieve heading widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name()
	{
		return 'mgtext_effects';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve heading widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title()
	{
		return __('MG Text Effects', 'magical-addons-for-elementor');
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve heading widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon()
	{
		return 'eicon-animation-text';
	}

	public function get_keywords()
	{
		return ['text', 'animation', 'title', 'mg'];
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the heading widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories()
	{
		return ['magical'];
	}



	/**
	 * Register heading widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls()
	{
		$this->start_controls_section(
			'section_title',
			[
				'label' => __('Animation Text', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __('Text', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => __('Enter your text', 'magical-addons-for-elementor'),
				'default' => __('Add Your Animation Text Here', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __('Link', 'magical-addons-for-elementor'),
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

		$this->add_control(
			'mg_text_effect',
			[
				'label' => __('Text Effect', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'mg-shining',
				'options' => [
					'flipX' => __('FlipX Effects', 'magical-addons-for-elementor'),
					'flipY' => __('FlipY Effects', 'magical-addons-for-elementor'),
					'lineUp' => __('lineUp Effects', 'magical-addons-for-elementor'),
					'mg-shining' => __('Shining', 'magical-addons-for-elementor'),
					'mg-shining2' => __('Shining Two', 'magical-addons-for-elementor'),

				],
			]
		);

		$this->add_control(
			'header_size',
			[
				'label' => __('HTML Tag', 'magical-addons-for-elementor'),
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

		$this->add_responsive_control(
			'align',
			[
				'label' => __('Alignment', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __('Left', 'magical-addons-for-elementor'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __('Center', 'magical-addons-for-elementor'),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __('Right', 'magical-addons-for-elementor'),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __('Justified', 'magical-addons-for-elementor'),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mg-text-effects' => 'text-align: {{VALUE}};',
				],
			]
		);


		$this->end_controls_section();
		$this->link_pro_added();

		$this->start_controls_section(
			'section_title_style',
			[
				'label' => __('Title', 'magical-addons-for-elementor'),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'mgte_text_color',
			[
				'label' => __('Text Color', 'magical-addons-for-elementor'),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .mg-text-effects span a,{{WRAPPER}} .mg-text-effects span' => 'color: {{VALUE}};',
				],
				'condition' => [
					'mg_text_effect' => 'mg-loader',
				],
			]
		);
		$this->add_control(
			'mg_title_bgcolor',
			[
				'label' => __('Text Background Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_1,
				],
				'selectors' => [
					// Stronger selector to avoid section style from overwriting
					'{{WRAPPER}} .mg-text-effects' => 'background: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'mg_loader_bgcolor',
			[
				'label' => __('Loader background Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_1,
				],
				'condition' => [
					'mg_text_effect' => 'mg-loader',
				],
				'selectors' => [
					// Stronger selector to avoid section style from overwriting
					'{{WRAPPER}} .mg-loader:before' => 'background: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'mg_loader_width',
			[
				'label' => __('Loader Width', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					]
				],
				'condition' => [
					'mg_text_effect' => 'mg-loader',
				],
				'selectors' => [
					'{{WRAPPER}} .mg-loader:before' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'mgta_title_padding',
			[
				'label' => __('Padding', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-text-effects' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'mfta_title_color',
			[
				'label' => esc_html__('Title Color', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-text-effects' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'mgta_text_shadow',
				'label' => esc_html__('Text Shadow', 'magical-addons-for-elementor'),
				'selector' => '{{WRAPPER}} .mg-text-effects',
			]
		);


		$this->add_control(
			'mgta_animation_time',
			[
				'label' => esc_html__('Animation Time', 'magical-addons-for-elementor'),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => ['s'],
				'range' => [
					's' => [
						'min' => 2,
						'max' => 60,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 2,
				],
				'selectors' => [
					'{{WRAPPER}} .flipX' => 'animation-duration: {{SIZE}}s;',
					'{{WRAPPER}} .flipY' => 'animation-duration: {{SIZE}}s;',
					'{{WRAPPER}} .lineUp' => 'animation-duration: {{SIZE}}s;',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'mg_typography',
				'selector' => '{{WRAPPER}} .mg-text-effects span',
			]
		);


		$this->end_controls_section();
	}

	/**
	 * Render heading widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render()
	{
		$settings = $this->get_settings_for_display();

		if ('' === $settings['title']) {
			return;
		}

		/*$this->add_render_attribute( 'title', 'class', 'elementor-heading-title' );

		if ( ! empty( $settings['size'] ) ) {
			$this->add_render_attribute( 'title', 'class', 'elementor-size-' . $settings['size'] );
		}*/

		$this->add_inline_editing_attributes('title');

		$title = $settings['title'];

		if (!empty($settings['link']['url'])) {
			$this->add_render_attribute('url', 'href', $settings['link']['url']);

			if ($settings['link']['is_external']) {
				$this->add_render_attribute('url', 'target', '_blank');
			}

			if (!empty($settings['link']['nofollow'])) {
				$this->add_render_attribute('url', 'rel', 'nofollow');
			}

			$title = sprintf('<a %1$s>%2$s</a>', $this->get_render_attribute_string('url'), $title);
		}

		$title_html = sprintf('<%1$s ><span %2$s>%3$s</span></%1$s>', $settings['header_size'], $this->get_render_attribute_string('title'), $title);

		//	echo $title_html;

		/*Loader markup*/
?>

		<div class="mg-text-effects <?php echo esc_attr($settings['mg_text_effect']); ?>">
			<?php echo $title_html; ?>
		</div>



	<?php
	}

	/**
	 * Render heading widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function content_template()
	{
	?>
		<# var title=settings.title; view.addInlineEditingAttributes( 'title' ); if ( '' !==settings.link.url ) { #>
			<div class="mg-text-effects {{{ settings.mg_text_effect }}}">
				<a href="{{{settings.link.url}}}">
					<{{{ settings.header_size }}}><span {{{view.getRenderAttributeString( 'title' )}}}>{{{ settings.title }}}</span></{{{ settings.header_size }}}>
				</a>
			</div>
			<# } else{ #>
				<div class="mg-text-effects {{{ settings.mg_text_effect }}}">
					<{{{ settings.header_size }}}><span {{{view.getRenderAttributeString( 'title' )}}}>{{{ settings.title }}} </span></{{{ settings.header_size }}}>
				</div>
				<# } #>
			<?php
		}
	}
