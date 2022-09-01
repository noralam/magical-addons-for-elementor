<?php

// Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Control_Media;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Core\Schemes\Typography as Scheme_Typography;
use Elementor\Embed;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * Scroll Image Widget
 */

class MgAddon_imgSmoothScroll extends \Elementor\Widget_Base
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
		return 'mg_imgsmooth_scroll';
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
		return __('MG Image Smooth Scroll', 'magical-addons-for-elementor');
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
		return 'eicon-image-rollover';
	}

	public function get_keywords()
	{
		return ['mg', 'image', 'scroll', 'smooth', 'hover'];
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
	 * Retrieve the list of scripts the showcase widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_style_depends()
	{
		return array(
			'mg-image-scroll',
		);
	}
	public function get_script_depends()
	{
		return array(
			'imagesloaded',
			'mg-img-scroll',
		);
	}

	protected function register_controls()
	{

		/**
		 * Content Tab: Image
		 */
		$this->start_controls_section(
			'image_settings',
			array(
				'label' => __('Image', 'magical-addons-for-elementor'),
			)
		);

		$this->add_control(
			'image',
			array(
				'label'       => __('Image', 'magical-addons-for-elementor'),
				'type'        => Controls_Manager::MEDIA,
				'dynamic'     => array('active' => true),
				'default'     => array(
					'url' => Utils::get_placeholder_image_src(),
				),
				'label_block' => true,
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'    => 'image',
				'label'   => __('Image Size', 'magical-addons-for-elementor'),
				'default' => 'full',
			)
		);

		$this->add_responsive_control(
			'image_height',
			array(
				'label'      => __('Image Height', 'magical-addons-for-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px', 'em', 'vh'),
				'default'    => array(
					'unit' => 'px',
					'size' => 300,
				),
				'range'      => array(
					'px' => array(
						'min' => 200,
						'max' => 800,
					),
					'em' => array(
						'min' => 1,
						'max' => 50,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .mg-image-scroll-container' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'link',
			array(
				'label'       => __('URL', 'magical-addons-for-elementor'),
				'type'        => Controls_Manager::URL,
				'dynamic'     => array(
					'active' => true,
				),
				'placeholder' => 'https://wpthemespace.com/',
				'label_block' => true,
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'icon_settings',
			array(
				'label' => __('Icon', 'magical-addons-for-elementor'),
			)
		);
		$this->add_control(
			'selected_icon',
			array(
				'label'            => __('Cover icon', 'magical-addons-for-elementor'),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
			)
		);

		$this->add_control(
			'icon_size',
			array(
				'label'      => __('Icon Size', 'magical-addons-for-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px', 'em'),
				'default'    => array(
					'size' => 30,
				),
				'range'      => array(
					'px' => array(
						'min' => 5,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .mg-image-scroll-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'selected_icon[value]!' => '',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Content Tab: Settings
		 */
		$this->start_controls_section(
			'settings',
			array(
				'label' => __('Settings', 'magical-addons-for-elementor'),
			)
		);

		$this->add_control(
			'trigger_type',
			array(
				'label'              => __('Trigger', 'magical-addons-for-elementor'),
				'type'               => Controls_Manager::SELECT,
				'options'            => array(
					'hover'  => __('Hover', 'magical-addons-for-elementor'),
					'scroll' => __('Mouse Scroll', 'magical-addons-for-elementor'),
				),
				'default'            => 'hover',
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'duration_speed',
			array(
				'label'     => __('Scroll Speed', 'magical-addons-for-elementor'),
				'title'     => __('In seconds', 'magical-addons-for-elementor'),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 3,
				'selectors' => array(
					'{{WRAPPER}} .mg-image-scroll-container .mg-image-scroll-image img'   => 'transition: all {{Value}}s; -webkit-transition: all {{Value}}s;',
				),
				'condition' => array(
					'trigger_type' => 'hover',
				),
			)
		);

		$this->add_control(
			'direction_type',
			array(
				'label'              => __('Scroll Direction', 'magical-addons-for-elementor'),
				'type'               => Controls_Manager::SELECT,
				'options'            => array(
					'horizontal' => __('Horizontal', 'magical-addons-for-elementor'),
					'vertical'   => __('Vertical', 'magical-addons-for-elementor'),
				),
				'default'            => 'vertical',
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'reverse',
			array(
				'label'              => __('Reverse Direction', 'magical-addons-for-elementor'),
				'type'               => Controls_Manager::SWITCHER,
				'frontend_available' => true,
				'condition'          => array(
					'trigger_type' => 'hover',
				),
			)
		);

		$this->end_controls_section();
		$this->link_pro_added();



		/*
		STYLE TAB
		*/

		/**
		 * Style Tab: Image
		 */
		$this->start_controls_section(
			'image_style',
			array(
				'label' => __('Image', 'magical-addons-for-elementor'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label'     => __('Icon Color', 'magical-addons-for-elementor'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .mg-image-scroll-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mg-image-scroll-icon svg' => 'fill: {{VALUE}};',
				),
				'condition' => array(
					'selected_icon[value]!' => '',
				),
			)
		);

		$this->start_controls_tabs('image_style_tabs');

		$this->start_controls_tab(
			'image_style_tab_normal',
			array(
				'label' => __('Normal', 'magical-addons-for-elementor'),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'container_border',
				'selector' => '{{WRAPPER}} .mg-image-scroll-wrap',
			)
		);

		$this->add_control(
			'image_border_radius',
			array(
				'label'      => __('Border Radius', 'magical-addons-for-elementor'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array('px', '%', 'em'),
				'selectors'  => array(
					'{{WRAPPER}} .mg-image-scroll-wrap, {{WRAPPER}} .mg-container-scroll' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'container_box_shadow',
				'selector' => '{{WRAPPER}} .mg-image-scroll-wrap',
			)
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			array(
				'name'     => 'css_filters',
				'selector' => '{{WRAPPER}} .mg-image-scroll-container .mg-image-scroll-image img',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'image_style_tab_hover',
			array(
				'label' => __('Hover', 'magical-addons-for-elementor'),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'container_box_shadow_hover',
				'selector' => '{{WRAPPER}} .mg-image-scroll-wrap:hover',
			)
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			array(
				'name'     => 'css_filters_hover',
				'selector' => '{{WRAPPER}} .mg-image-scroll-container .mg-image-scroll-image img:hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Style Tab: Overlay
		 */
		$this->start_controls_section(
			'overlay_style',
			array(
				'label' => __('Overlay', 'magical-addons-for-elementor'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'overlay',
			array(
				'label'     => __('Overlay', 'magical-addons-for-elementor'),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => __('Show', 'magical-addons-for-elementor'),
				'label_off' => __('Hide', 'magical-addons-for-elementor'),

			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'      => 'overlay_background',
				'types'     => array('classic', 'gradient'),
				'selector'  => '{{WRAPPER}} .mg-image-scroll-overlay',
				'exclude'   => array(
					'image',
				),
				'condition' => array(
					'overlay' => 'yes',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render()
	{

		$settings = $this->get_settings_for_display();

		if (empty($settings['image']['url'])) {
			return;
		}

		$link_url = $settings['link']['url'];

		if ('' !== $settings['link']['url']) {
			$this->add_render_attribute('link', 'class', 'mg-image-scroll-link mg-media-content');

			$this->add_link_attributes('link', $settings['link']);
		}

		$this->add_render_attribute('icon', 'class', [
			'mg-image-scroll-icon',
			'mg-icon',
			'mg-mouse-scroll-' . $settings['direction_type'],
		]);

		if (!isset($settings['icon']) && !Icons_Manager::is_migration_allowed()) {
			// add old default
			$settings['icon'] = 'fa fa-star';
		}

		$has_icon = !empty($settings['icon']);

		if ($has_icon) {
			$this->add_render_attribute('i', 'class', $settings['icon']);
			$this->add_render_attribute('i', 'aria-hidden', 'true');
		}

		$icon_attributes = $this->get_render_attribute_string('icon');

		if (!$has_icon && !empty($settings['selected_icon']['value'])) {
			$has_icon = true;
		}
		$migrated = isset($settings['__fa4_migrated']['selected_icon']);
		$is_new = !isset($settings['icon']) && Icons_Manager::is_migration_allowed();

		$this->add_render_attribute([
			'container' => [
				'class' => 'mg-image-scroll-container',
			],
			'direction_type' => [
				'class' => ['mg-image-scroll-image', 'mg-image-scroll-' . $settings['direction_type']],
			],
		]);
?>
		<div class="mg-image-scroll-wrap">
			<div <?php echo wp_kses_post($this->get_render_attribute_string('container')); ?>>
				<?php if (!empty($settings['icon']) || (!empty($settings['selected_icon']['value']) && $is_new)) { ?>
					<div class="mg-image-scroll-content">
						<span <?php echo wp_kses_post($this->get_render_attribute_string('icon')); ?>>
							<?php
							if ($is_new || $migrated) {
								Icons_Manager::render_icon($settings['selected_icon'], ['aria-hidden' => 'true']);
							} elseif (!empty($settings['icon'])) {
							?><i <?php echo wp_kses_post($this->get_render_attribute_string('i')); ?>></i><?php
																										}
																											?>
						</span>
					</div>
				<?php } ?>
				<div <?php echo wp_kses_post($this->get_render_attribute_string('direction_type')); ?>>
					<?php if ('yes' === $settings['overlay']) { ?>
						<div class="mg-image-scroll-overlay mg-media-overlay">
						<?php } ?>
						<?php if (!empty($link_url)) { ?>
							<a <?php echo wp_kses_post($this->get_render_attribute_string('link')); ?>></a>
						<?php } ?>
						<?php if ('yes' === $settings['overlay']) { ?>
						</div>
					<?php } ?>

					<?php echo wp_kses_post(Group_Control_Image_Size::get_attachment_image_html($settings)); ?>
				</div>
			</div>
		</div>
<?php
	}
}
