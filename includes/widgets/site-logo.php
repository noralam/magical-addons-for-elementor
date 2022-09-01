<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Border;
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

class MG_Addon_siteLogo extends Widget_Base
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
		return 'mgsite_logo';
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
		return esc_html__('Mg Site Logo', 'magical-addons-for-elementor');
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
		return 'eicon-logo';
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
		return ['mg', 'site logo', 'logo', 'header logo', 'footer logo'];
	}


	protected function register_controls()
	{

		// Section: logo -------------
		$this->start_controls_section(
			'section_general',
			[
				'label' => esc_html__('General', 'magical-addons-for-elementor'),
			]
		);
		$this->start_controls_tabs('_tab_site_logos');
		$this->start_controls_tab(
			'_tab_main_logo',
			[
				'label' => __('Logo', 'magical-addons-for-elementor'),
			]
		);
		$this->add_control(
			'image',
			[
				'label' => esc_html__('Upload Image Logo', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'_tab_retina_logo',
			[
				'label' => __('Retina Logo', 'magical-addons-for-elementor'),
			]
		);
		$this->add_control(
			'retina_image',
			[
				'label' => esc_html__('Upload Image Logo', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::MEDIA,
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'_tab_mobile_logo',
			[
				'label' => __('Mbbile Logo', 'magical-addons-for-elementor'),
			]
		);
		$this->add_control(
			'mobile_image',
			[
				'label' => esc_html__('Upload Image Logo', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::MEDIA,
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();



		$this->add_control(
			'title_type',
			[
				'label' => esc_html__('Site Title', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none' => esc_html__('None', 'magical-addons-for-elementor'),
					'default' => esc_html__('Default', 'magical-addons-for-elementor'),
					'custom' => esc_html__('Custom', 'magical-addons-for-elementor'),
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'custom_title',
			[
				'label' => esc_html__('Title Text', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::TEXT,
				'default' => 'My Custom Logo',
				'condition' => [
					'title_type' => 'custom',
				],
			]
		);

		$this->add_control(
			'description_type',
			[
				'label' => esc_html__('Tagline', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none' => esc_html__('None', 'magical-addons-for-elementor'),
					'default' => esc_html__('Default', 'magical-addons-for-elementor'),
					'custom' => esc_html__('Custom', 'magical-addons-for-elementor'),
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'custom_description',
			[
				'label' => esc_html__('Tagline Text', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::TEXT,
				'default' => 'Tagline',
				'condition' => [
					'description_type' => 'custom',
				],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => esc_html__('Alignment', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::CHOOSE,
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
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'url_type',
			[
				'label' => esc_html__('Logo URL', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'none' => esc_html__('None', 'magical-addons-for-elementor'),
					'default' => esc_html__('Default', 'magical-addons-for-elementor'),
					'custom' => esc_html__('Custom', 'magical-addons-for-elementor'),
				],
			]
		);

		$this->add_control(
			'custom_url',
			[
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__('https://www.your-link.com', 'magical-addons-for-elementor'),
				'condition' => [
					'url_type' => 'custom',
				],
			]
		);

		$this->add_control(
			'remove_front_page_url',
			[
				'label' => esc_html__('Disable Link on Front Page', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'url_type!' => 'none',
				],
			]
		);

		$this->end_controls_section(); // End Controls Section
		$this->link_pro_added();

		// Styles
		// Section: General ----------
		$this->start_controls_section(
			'section_style_general',
			[
				'label' => esc_html__('General', 'magical-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'bg_color',
			[
				'label' => esc_html__('Background Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-logo' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label' => esc_html__('Padding', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
				],
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-logo' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'image_section',
			[
				'label' => esc_html__('Image', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'width',
			[
				'label' => esc_html__('Width', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 500,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 150,
				],
				'selectors' => [
					'{{WRAPPER}} .mg-logo-image' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'position',
			[
				'label' => esc_html__('Alignment', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'default' => 'center',
				'options' => [
					'left' => [
						'title' => esc_html__('Left', 'magical-addons-for-elementor'),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'magical-addons-for-elementor'),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => esc_html__('Right', 'magical-addons-for-elementor'),
						'icon' => 'eicon-h-align-right',
					]
				],
				'prefix_class'	=> 'mg-logo-position-',
			]
		);

		$this->add_responsive_control(
			'image_distance',
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
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}}.mg-logo-position-left .mg-logo-image' => 'margin-right:{{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.mg-logo-position-right .mg-logo-image' => 'margin-left:{{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.mg-logo-position-center .mg-logo-image' => 'margin-bottom:{{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs('logo_img_effects');

		$this->start_controls_tab(
			'normal',
			[
				'label' => esc_html__('Normal', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'opacity',
			[
				'label' => esc_html__('Opacity', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mg-logo-image img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selector' => '{{WRAPPER}} .mg-logo-image img',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'hover',
			[
				'label' => esc_html__('Hover', 'magical-addons-for-elementor'),
			]
		);

		$this->add_control(
			'opacity_hv',
			[
				'label' => esc_html__('Opacity', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .mg-logo:hover img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters_hv',
				'selector' => '{{WRAPPER}} .mg-logo:hover img',
			]
		);

		$this->add_control(
			'bg_hv_duration',
			[
				'label' => esc_html__('Transition Duration', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::NUMBER,
				'default' => 0.7,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' => [
					'{{WRAPPER}} .mg-logo-image img' => '-webkit-transition-duration: {{VALUE}}s;transition-duration: {{VALUE}}s',
				],

			]
		);

		$this->add_control(
			'hv_animation',
			[
				'label' => esc_html__('Hover Animation', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'title_section',
			[
				'label' => esc_html__('Site Title', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__('Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '#4285f4',
				'selectors' => [
					'{{WRAPPER}} .mg-logo-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'scheme' => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .mg-logo-title',
			]
		);

		$this->add_responsive_control(
			'title_distance',
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
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .mg-logo-title' => 'margin: 0 0 {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'description_section',
			[
				'label' => esc_html__('Tagline', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => esc_html__('Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'default' => '#888888',
				'selectors' => [
					'{{WRAPPER}} .mg-logo-description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'scheme' => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .mg-logo-description',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => esc_html__('Border', 'magical-addons-for-elementor'),
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width' => [
						'default' => [
							'top' => '1',
							'right' => '1',
							'bottom' => '1',
							'left' => '1',
							'isLinked' => true,
						],
					],
					'color' => [
						'default' => '#E8E8E8',
					],
				],
				'selector' => '{{WRAPPER}} .mg-logo',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'border_radius',
			[
				'label' => esc_html__('Border Radius', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'default' => [
					'top' => 2,
					'right' => 2,
					'bottom' => 2,
					'left' => 2,
				],
				'selectors' => [
					'{{WRAPPER}} .mg-logo' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'selector' => '{{WRAPPER}} .mg-logo'
			]
		);

		$this->end_controls_section(); // End Controls Section
	}

	public function logo_is_linked()
	{

		$settings = $this->get_settings();

		if ('none' === $settings['url_type']) {
			return false;
		}

		if ('yes' === $settings['remove_front_page_url'] && is_front_page()) {
			return false;
		}

		return true;
	}


	protected function render()
	{

		$settings = $this->get_settings();

		$image_src = esc_url($settings['image']['url']);
		$mobile_image_src = esc_url($settings['mobile_image']['url']);

		// Title
		$title = '';
		if ('default' === $settings['title_type']) {
			$title = get_bloginfo('name');
		} elseif ('custom' === $settings['title_type']) {
			$title = $settings['custom_title'];
		}

		// Description
		$description = '';
		if ('default' === $settings['description_type']) {
			$description =  get_bloginfo('description');
		} elseif ('custom' === $settings['description_type']) {
			$description = $settings['custom_description'];
		}

		// Image hover animation
		$this->add_render_attribute('image_attr', 'class', 'mg-logo-image');
		if ($settings['hv_animation']) {
			$this->add_render_attribute('image_attr', 'class', 'elementor-animation-' . $settings['hv_animation']);
		}

		// Logo URL
		$this->add_render_attribute('url_attr', 'class', 'mg-logo-url');
		$this->add_render_attribute('url_attr', 'rel', 'home');

		if ('default' === $settings['url_type']) {
			$this->add_render_attribute('url_attr', 'href',  home_url('/'));
		} elseif ('custom' === $settings['url_type']) {

			if ($settings['custom_url']['is_external']) {
				$this->add_render_attribute('url_attr', 'target', '_blank');
			}

			if ($settings['custom_url']['nofollow']) {
				$this->add_render_attribute('url_attr', 'nofollow', '');
			}

			$this->add_render_attribute('url_attr', 'href',  $settings['custom_url']['url']);
		}


?>

		<div class="mg-logo elementor-clearfix">

			<?php
			if (!empty($image_src)) :
				$hashttps = '';
				$url = $image_src;
				$url_protocal = parse_url($url, PHP_URL_SCHEME) . '://';
				$site_protocal = mg_site_protocol();

				if ($url_protocal == 'https://' && $site_protocal == 'https://') {
					$hashttps = true;
				}

			?>
				<?php if (!empty($hashttps)) : ?>
					<picture <?php echo $this->get_render_attribute_string('image_attr'); ?>>
						<?php if (!empty($mobile_image_src)) : ?>
							<source media="(max-width: 767px)" srcset="<?php echo esc_url($mobile_image_src); ?>">
						<?php endif; ?>

						<?php if (!empty($settings['retina_image']['url'])) : ?>
							<source srcset="<?php echo esc_attr($image_src); ?> 1x, <?php echo esc_url($settings['retina_image']['url']); ?> 2x">
						<?php endif; ?>

						<img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr($title); ?>">

						<?php if ($this->logo_is_linked()) : ?>
							<a <?php echo $this->get_render_attribute_string('url_attr'); ?>></a>
						<?php endif; ?>
					</picture>
				<?php else : ?>
					<div <?php echo $this->get_render_attribute_string('image_attr'); ?>>
						<img src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_attr($title); ?>">

						<?php if ($this->logo_is_linked()) : ?>
							<a <?php echo $this->get_render_attribute_string('url_attr'); ?>></a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>

			<?php if (!empty($title) || !empty($description)) : ?>
				<div class="mg-logo-text">
					<?php if (!empty($title)) : ?>
						<h1 class="mg-logo-title"><?php echo esc_html__($title); ?></h1>
					<?php endif; ?>

					<?php
					if (!empty($description)) : ?>
						<p class="mg-logo-description"><?php echo esc_html__($description); ?></p>
					<?php endif; ?>
				</div>
				<?php if ($this->logo_is_linked()) : ?>
					<a <?php echo $this->get_render_attribute_string('url_attr'); ?>></a>
				<?php endif; ?>
			<?php endif; ?>



		</div>

<?php
	}
}
