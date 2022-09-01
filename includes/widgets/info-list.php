<?php
// Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Control_Media;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Schemes\Typography as Scheme_Typography;
use Elementor\Core\Schemes\Color as Scheme_Color;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * Info List Widget
 */
class MgAddon_infoList extends \Elementor\Widget_Base
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
		return 'mg_infolist';
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
		return __('MG Info List', 'magical-addons-for-elementor');
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
		return 'eicon-checkbox';
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords()
	{
		return ['mg', 'info', 'list', 'information', 'ul'];
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
	 * Retrieve the list of scripts the info list widget depended on.
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
			'mg-info-list',
		);
	}

	/**
	 * Register info list widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 2.3.2
	 * @access protected
	 */
	protected function register_controls()
	{
		/* Content Tab */
		$this->register_content_list_items_controls();

		/* Style Tab */
		$this->register_style_list_controls();
		$this->register_style_connector_controls();
		$this->register_style_icon_controls();
		$this->register_style_title_controls();
		$this->register_style_button_controls();
	}

	/*-----------------------------------------------------------------------------------*/
	/*	CONTENT TAB
	/*-----------------------------------------------------------------------------------*/

	protected function register_content_list_items_controls()
	{
		/**
		 * Content Tab: List Items
		 */
		$this->start_controls_section(
			'section_list',
			array(
				'label' => __('List Items', 'magical-addons-for-elementor'),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'text',
			array(
				'label'       => __('Title', 'magical-addons-for-elementor'),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => __('List Item #1', 'magical-addons-for-elementor'),
			)
		);

		$repeater->add_control(
			'description',
			array(
				'label'       => __('Description', 'magical-addons-for-elementor'),
				'label_block' => true,
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => array(
					'active' => true,
				),
				'default'     => __('List Item Description', 'magical-addons-for-elementor'),
			)
		);

		$repeater->add_control(
			'pp_icon_type',
			array(
				'label'       => esc_html__('Icon Type', 'magical-addons-for-elementor'),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => array(
					'none'  => array(
						'title' => esc_html__('None', 'magical-addons-for-elementor'),
						'icon'  => 'eicon-ban',
					),
					'icon'  => array(
						'title' => esc_html__('Icon', 'magical-addons-for-elementor'),
						'icon'  => 'eicon-star',
					),
					'image' => array(
						'title' => esc_html__('Image', 'magical-addons-for-elementor'),
						'icon'  => 'eicon-image-bold',
					),
					'text'  => array(
						'title' => esc_html__('Text', 'magical-addons-for-elementor'),
						'icon'  => 'eicon-font',
					),
				),
				'default'     => 'icon',
			)
		);

		$repeater->add_control(
			'icon',
			array(
				'label'            => __('Icon', 'magical-addons-for-elementor'),
				'type'             => Controls_Manager::ICONS,
				'label_block'      => true,
				'default'          => array(
					'value'   => 'fas fa-check',
					'library' => 'fa-solid',
				),
				'fa4compatibility' => 'list_icon',
				'condition'        => array(
					'pp_icon_type' => 'icon',
				),
			)
		);

		$repeater->add_control(
			'list_image',
			array(
				'label'       => __('Image', 'magical-addons-for-elementor'),
				'label_block' => true,
				'type'        => Controls_Manager::MEDIA,
				'default'     => array(
					'url' => Utils::get_placeholder_image_src(),
				),
				'condition'   => array(
					'pp_icon_type' => 'image',
				),
			)
		);

		$repeater->add_control(
			'icon_text',
			array(
				'label'       => __('Icon Text', 'magical-addons-for-elementor'),
				'label_block' => false,
				'type'        => Controls_Manager::TEXT,
				'default'     => __('1', 'magical-addons-for-elementor'),
				'condition'   => array(
					'pp_icon_type' => 'text',
				),
			)
		);

		$repeater->add_control(
			'link_type',
			array(
				'label'   => __('Link Type', 'magical-addons-for-elementor'),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'none'   => __('None', 'magical-addons-for-elementor'),
					'box'    => __('Box', 'magical-addons-for-elementor'),
					'title'  => __('Title', 'magical-addons-for-elementor'),
					'button' => __('Button', 'magical-addons-for-elementor'),
				),
				'default' => 'none',
			)
		);

		$repeater->add_control(
			'button_text',
			array(
				'label'     => __('Button Text', 'magical-addons-for-elementor'),
				'type'      => Controls_Manager::TEXT,
				'dynamic'   => array(
					'active' => true,
				),
				'default'   => __('Get Started', 'magical-addons-for-elementor'),
				'condition' => array(
					'link_type' => 'button',
				),
			)
		);

		$repeater->add_control(
			'selected_icon',
			array(
				'label'            => __('Button Icon', 'magical-addons-for-elementor'),
				'type'             => Controls_Manager::ICONS,
				'label_block'      => true,
				'fa4compatibility' => 'button_icon',
				'condition'        => array(
					'link_type' => 'button',
				),
			)
		);

		$repeater->add_control(
			'button_icon_position',
			array(
				'label'     => __('Icon Position', 'magical-addons-for-elementor'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'after',
				'options'   => array(
					'after'  => __('After', 'magical-addons-for-elementor'),
					'before' => __('Before', 'magical-addons-for-elementor'),
				),
				'condition' => array(
					'link_type' => 'button',
				),
			)
		);

		$repeater->add_control(
			'link',
			array(
				'label'       => __('Link', 'magical-addons-for-elementor'),
				'type'        => Controls_Manager::URL,
				'dynamic'     => array(
					'active' => true,
				),
				'label_block' => true,
				'placeholder' => __('http://your-link.com', 'magical-addons-for-elementor'),
				'default'     => array(
					'url' => '#',
				),
				'conditions'  => array(
					'terms' => array(
						array(
							'name'     => 'link_type',
							'operator' => '!=',
							'value'    => 'none',
						),
					),
				),
			)
		);

		$this->add_control(
			'list_items',
			array(
				'label'       => '',
				'type'        => Controls_Manager::REPEATER,
				'default'     => array(
					array(
						'text' => __('List Item #1', 'magical-addons-for-elementor'),
						'icon' => __('fa fa-check', 'magical-addons-for-elementor'),
					),
					array(
						'text' => __('List Item #2', 'magical-addons-for-elementor'),
						'icon' => __('fa fa-check', 'magical-addons-for-elementor'),
					),
				),
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ text }}}',
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_list_setup',
			array(
				'label' => __('Settings', 'magical-addons-for-elementor'),
			)
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.,
				'label'     => __('Image Size', 'magical-addons-for-elementor'),
				'default'   => 'full',
				'separator' => 'before',
			)
		);

		$this->add_control(
			'title_html_tag',
			array(
				'label'   => __('Title HTML Tag', 'magical-addons-for-elementor'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'div',
				'options' => array(
					'h1'   => __('H1', 'magical-addons-for-elementor'),
					'h2'   => __('H2', 'magical-addons-for-elementor'),
					'h3'   => __('H3', 'magical-addons-for-elementor'),
					'h4'   => __('H4', 'magical-addons-for-elementor'),
					'h5'   => __('H5', 'magical-addons-for-elementor'),
					'h6'   => __('H6', 'magical-addons-for-elementor'),
					'div'  => __('div', 'magical-addons-for-elementor'),
					'span' => __('span', 'magical-addons-for-elementor'),
					'p'    => __('p', 'magical-addons-for-elementor'),
				),
			)
		);

		$this->add_control(
			'connector',
			array(
				'label'        => __('Connector', 'magical-addons-for-elementor'),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => __('Yes', 'magical-addons-for-elementor'),
				'label_off'    => __('No', 'magical-addons-for-elementor'),
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'corner_lines',
			array(
				'label'        => __('Hide Corner Lines', 'magical-addons-for-elementor'),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '',
				'label_on'     => __('Yes', 'magical-addons-for-elementor'),
				'label_off'    => __('No', 'magical-addons-for-elementor'),
				'return_value' => 'yes',
				'condition'    => array(
					'connector' => 'yes',
				),
			)
		);

		$this->end_controls_section();
		$this->link_pro_added();
	}


	/*-----------------------------------------------------------------------------------*/
	/*	STYLE TAB
	/*-----------------------------------------------------------------------------------*/

	protected function register_style_list_controls()
	{
		/**
		 * Style Tab: List
		 */
		$this->start_controls_section(
			'section_list_style',
			array(
				'label' => __('List', 'magical-addons-for-elementor'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'items_spacing',
			array(
				'label'     => __('Items Spacing', 'magical-addons-for-elementor'),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 10,
				),
				'range'     => array(
					'px' => array(
						'max' => 50,
					),
				),
				'selectors' => array(
					'{{WRAPPER}}.mg-info-list-icon-left .mg-info-list-item:not(:last-child) .mg-info-list-item-inner, {{WRAPPER}}.mg-info-list-icon-right .mg-info-list-item:not(:last-child) .mg-info-list-item-inner' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.mg-info-list-icon-top .mg-info-list-item .mg-info-list-item-inner' => 'margin-right: calc({{SIZE}}{{UNIT}}/2); margin-left: calc({{SIZE}}{{UNIT}}/2);',
					'{{WRAPPER}}.mg-info-list-icon-top .mg-list-items' => 'margin-right: calc(-{{SIZE}}{{UNIT}}/2); margin-left: calc(-{{SIZE}}{{UNIT}}/2);',

					'(tablet){{WRAPPER}}.mg-info-list-stack-tablet.mg-info-list-icon-top .mg-info-list-item .mg-info-list-item-inner' => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-left: 0; margin-right: 0;',
					'(tablet){{WRAPPER}}.mg-info-list-stack-tablet.mg-info-list-icon-top .mg-list-items' => 'margin-right: 0; margin-left: 0;',

					'(mobile){{WRAPPER}}.mg-info-list-stack-mobile.mg-info-list-icon-top .mg-info-list-item .mg-info-list-item-inner' => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-left: 0; margin-right: 0;',
					'(mobile){{WRAPPER}}.mg-info-list-stack-mobile.mg-info-list-icon-top .mg-list-items' => 'margin-right: 0; margin-left: 0;',
				),
			)
		);

		$this->add_control(
			'icon_position',
			array(
				'label'        => __('Position', 'magical-addons-for-elementor'),
				'type'         => Controls_Manager::CHOOSE,
				'label_block'  => false,
				'toggle'       => false,
				'default'      => 'left',
				'options'      => array(
					'left'  => array(
						'title' => __('Left', 'magical-addons-for-elementor'),
						'icon'  => 'eicon-h-align-left',
					),
					'top'   => array(
						'title' => __('Top', 'magical-addons-for-elementor'),
						'icon'  => 'eicon-v-align-top',
					),
					'right' => array(
						'title' => __('Right', 'magical-addons-for-elementor'),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'prefix_class' => 'mg-info-list-icon-',
			)
		);

		$this->add_control(
			'responsive_breakpoint',
			array(
				'label'        => __('Responsive Breakpoint', 'magical-addons-for-elementor'),
				'type'         => Controls_Manager::SELECT,
				'label_block'  => false,
				'default'      => 'mobile',
				'options'      => array(
					''       => __('None', 'magical-addons-for-elementor'),
					'tablet' => __('Tablet', 'magical-addons-for-elementor'),
					'mobile' => __('Mobile', 'magical-addons-for-elementor'),
				),
				'prefix_class' => 'mg-info-list-stack-',
				'condition'    => array(
					'icon_position' => 'top',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function register_style_connector_controls()
	{
		/**
		 * Style Tab: Connector
		 */
		$this->start_controls_section(
			'section_connector_style',
			array(
				'label'     => __('Connector', 'magical-addons-for-elementor'),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'connector' => 'yes',
				),
			)
		);

		$this->add_control(
			'connector_color',
			array(
				'label'     => __('Color', 'magical-addons-for-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mg-info-list-connector .mg-infolist-icon-wrapper:before, {{WRAPPER}} .mg-info-list-connector .mg-infolist-icon-wrapper:after' => 'border-color: {{VALUE}};',
				),
				'condition' => array(
					'connector' => 'yes',
				),
			)
		);

		$this->add_control(
			'connector_style',
			array(
				'label'     => __('Style', 'magical-addons-for-elementor'),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'solid'  => __('Solid', 'magical-addons-for-elementor'),
					'double' => __('Double', 'magical-addons-for-elementor'),
					'dotted' => __('Dotted', 'magical-addons-for-elementor'),
					'dashed' => __('Dashed', 'magical-addons-for-elementor'),
				),
				'default'   => 'dotted',
				'selectors' => array(
					'{{WRAPPER}}.mg-info-list-icon-left .mg-info-list-connector .mg-infolist-icon-wrapper:before, {{WRAPPER}}.mg-info-list-icon-left .mg-info-list-connector .mg-infolist-icon-wrapper:after' => 'border-right-style: {{VALUE}};',
					'{{WRAPPER}}.mg-info-list-icon-right .mg-info-list-connector .mg-infolist-icon-wrapper:before, {{WRAPPER}}.mg-info-list-icon-right .mg-info-list-connector .mg-infolist-icon-wrapper:after' => 'border-left-style: {{VALUE}};',
					'{{WRAPPER}}.mg-info-list-icon-top .mg-info-list-connector .mg-infolist-icon-wrapper:before, {{WRAPPER}}.mg-info-list-icon-top .mg-info-list-connector .mg-infolist-icon-wrapper:after' => 'border-top-style: {{VALUE}};',

					'(tablet){{WRAPPER}}.mg-info-list-stack-tablet.mg-info-list-icon-top .mg-info-list-connector .mg-infolist-icon-wrapper:before, {{WRAPPER}}.mg-info-list-icon-top .mg-info-list-connector .mg-infolist-icon-wrapper:after' => 'border-right-style: {{VALUE}};',

					'(mobile){{WRAPPER}}.mg-info-list-stack-mobile.mg-info-list-icon-top .mg-info-list-connector .mg-infolist-icon-wrapper:before, {{WRAPPER}}.mg-info-list-icon-top .mg-info-list-connector .mg-infolist-icon-wrapper:after' => 'border-right-style: {{VALUE}};',
				),
				'condition' => array(
					'connector' => 'yes',
				),
			)
		);

		$this->add_control(
			'connector_width',
			array(
				'label'     => __('Width', 'magical-addons-for-elementor'),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 1,
				),
				'range'     => array(
					'px' => array(
						'min' => 1,
						'max' => 20,
					),
				),
				'selectors' => array(
					'{{WRAPPER}}.mg-info-list-icon-left .mg-info-list-connector .mg-infolist-icon-wrapper:before, {{WRAPPER}}.mg-info-list-icon-left .mg-info-list-connector .mg-infolist-icon-wrapper:after' => 'border-right-width: {{SIZE}}px;',
					'{{WRAPPER}}.mg-info-list-icon-right .mg-info-list-connector .mg-infolist-icon-wrapper:before, {{WRAPPER}}.mg-info-list-icon-right .mg-infolist-icon-wrapper:after' => 'border-left-width: {{SIZE}}px;',
					'{{WRAPPER}}.mg-info-list-icon-top .mg-info-list-connector .mg-infolist-icon-wrapper:before, {{WRAPPER}}.mg-info-list-icon-top .mg-info-list-connector .mg-infolist-icon-wrapper:after' => 'border-top-width: {{SIZE}}px;',

					'(tablet){{WRAPPER}}.mg-info-list-stack-tablet.mg-info-list-icon-top .mg-info-list-connector .mg-infolist-icon-wrapper:before, {{WRAPPER}}.mg-info-list-icon-top .mg-info-list-connector .mg-infolist-icon-wrapper:after' => 'border-right-width: {{SIZE}}px;',

					'(mobile){{WRAPPER}}.mg-info-list-stack-mobile.mg-info-list-icon-top .mg-info-list-connector .mg-infolist-icon-wrapper:before, {{WRAPPER}}.mg-info-list-icon-top .mg-info-list-connector .mg-infolist-icon-wrapper:after' => 'border-right-width: {{SIZE}}px;',
				),
				'condition' => array(
					'connector' => 'yes',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function register_style_icon_controls()
	{
		/**
		 * Style Tab: Icon
		 */
		$this->start_controls_section(
			'section_icon_style',
			array(
				'label' => __('Icon', 'magical-addons-for-elementor'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'icon_vertical_align',
			array(
				'label'                => __('Vertical Align', 'magical-addons-for-elementor'),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'toggle'               => false,
				'default'              => 'middle',
				'options'              => array(
					'top'    => array(
						'title' => __('Top', 'magical-addons-for-elementor'),
						'icon'  => 'eicon-v-align-top',
					),
					'middle' => array(
						'title' => __('Center', 'magical-addons-for-elementor'),
						'icon'  => 'eicon-v-align-middle',
					),
					'bottom' => array(
						'title' => __('Bottom', 'magical-addons-for-elementor'),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
				'selectors_dictionary' => array(
					'top'    => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				),
				'prefix_class'         => 'mg-info-list-icon-vertical-',
				'condition'            => array(
					'icon_position' => array('left', 'right'),
				),
			)
		);

		$this->add_control(
			'icon_horizontal_align',
			array(
				'label'                => __('Horizontal Align', 'magical-addons-for-elementor'),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'toggle'               => false,
				'options'              => array(
					'left'   => array(
						'title' => __('Left', 'magical-addons-for-elementor'),
						'icon'  => 'eicon-h-align-left',
					),
					'center' => array(
						'title' => __('Center', 'magical-addons-for-elementor'),
						'icon'  => 'eicon-h-align-center',
					),
					'right'  => array(
						'title' => __('Right', 'magical-addons-for-elementor'),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'default'              => 'center',
				'selectors_dictionary' => array(
					'left'   => 'flex-start',
					'center' => 'center',
					'right'  => 'flex-end',
				),
				'prefix_class'         => 'mg-info-list-icon-horizontal-',
				'condition'            => array(
					'icon_position' => 'top',
				),
			)
		);

		$this->start_controls_tabs('tabs_icon_style');

		$this->start_controls_tab(
			'tab_icon_normal',
			array(
				'label' => __('Normal', 'magical-addons-for-elementor'),
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label'     => __('Color', 'magical-addons-for-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mg-list-items .mg-info-list-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mg-list-items .mg-info-list-icon svg' => 'fill: {{VALUE}};',
				),
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
			)
		);

		$this->add_control(
			'icon_bg_color',
			array(
				'label'     => __('Background Color', 'magical-addons-for-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mg-list-items .mg-infolist-icon-wrapper' => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'icon_size',
			array(
				'label'     => __('Size', 'magical-addons-for-elementor'),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 14,
				),
				'range'     => array(
					'px' => array(
						'min' => 6,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .mg-list-items .mg-info-list-icon' => 'font-size: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .mg-list-items .mg-info-list-image img' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'icon_box_size',
			array(
				'label'     => __('Box Size', 'magical-addons-for-elementor'),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 14,
				),
				'range'     => array(
					'px' => array(
						'min' => 6,
						'max' => 200,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .mg-infolist-icon-wrapper' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',

					'{{WRAPPER}}.mg-info-list-icon-left .mg-info-list-container .mg-infolist-icon-wrapper:before' => 'left: calc(({{SIZE}}px/2) - ({{connector_width.SIZE}}px/2)); bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.mg-info-list-icon-left .mg-info-list-container .mg-infolist-icon-wrapper:after' => 'left: calc(({{SIZE}}px/2) - ({{connector_width.SIZE}}px/2)); top: {{SIZE}}{{UNIT}};',

					'{{WRAPPER}}.mg-info-list-icon-right .mg-info-list-container .mg-infolist-icon-wrapper:before' => 'right: calc(({{SIZE}}px/2) - ({{connector_width.SIZE}}px/2)); bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.mg-info-list-icon-right .mg-info-list-container .mg-infolist-icon-wrapper:after' => 'right: calc(({{SIZE}}px/2) - ({{connector_width.SIZE}}px/2)); top: {{SIZE}}{{UNIT}};',

					'{{WRAPPER}}.mg-info-list-icon-top .mg-info-list-container .mg-infolist-icon-wrapper:before' => 'top: calc(({{SIZE}}px/2) - ({{connector_width.SIZE}}px/2)); right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.mg-info-list-icon-top .mg-info-list-container .mg-infolist-icon-wrapper:after' => 'top: calc(({{SIZE}}px/2) - ({{connector_width.SIZE}}px/2)); left: {{SIZE}}{{UNIT}};',

					'(tablet){{WRAPPER}}.mg-info-list-stack-tablet.mg-info-list-icon-top .mg-info-list-container .mg-infolist-icon-wrapper:before' => 'left: calc(({{SIZE}}px/2) - ({{connector_width.SIZE}}px/2)); bottom: {{SIZE}}{{UNIT}}; right: auto; top: auto;',
					'(tablet){{WRAPPER}}.mg-info-list-stack-tablet.mg-info-list-icon-top .mg-info-list-container .mg-infolist-icon-wrapper:after' => 'left: calc(({{SIZE}}px/2) - ({{connector_width.SIZE}}px/2)); top: {{SIZE}}{{UNIT}};',

					'(mobile){{WRAPPER}}.mg-info-list-stack-mobile.mg-info-list-icon-top .mg-info-list-container .mg-infolist-icon-wrapper:before' => 'left: calc(({{SIZE}}px/2) - ({{connector_width.SIZE}}px/2)); bottom: {{SIZE}}{{UNIT}}; right: auto; top: auto;',
					'(mobile){{WRAPPER}}.mg-info-list-stack-mobile.mg-info-list-icon-top .mg-info-list-container .mg-infolist-icon-wrapper:after' => 'left: calc(({{SIZE}}px/2) - ({{connector_width.SIZE}}px/2)); top: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'icon_spacing',
			array(
				'label'     => __('Spacing', 'magical-addons-for-elementor'),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 8,
				),
				'range'     => array(
					'px' => array(
						'max' => 50,
					),
				),
				'selectors' => array(
					'{{WRAPPER}}.mg-info-list-icon-left .mg-infolist-icon-wrapper' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.mg-info-list-icon-right .mg-infolist-icon-wrapper' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.mg-info-list-icon-top .mg-infolist-icon-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',

					'(tablet){{WRAPPER}}.mg-info-list-stack-tablet.mg-info-list-icon-top .mg-infolist-icon-wrapper' => 'margin-right: {{SIZE}}{{UNIT}}; margin-bottom: 0;',

					'(mobile){{WRAPPER}}.mg-info-list-stack-mobile.mg-info-list-icon-top .mg-infolist-icon-wrapper' => 'margin-right: {{SIZE}}{{UNIT}}; margin-bottom: 0;',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'icon_border',
				'label'       => __('Border', 'magical-addons-for-elementor'),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .mg-list-items .mg-infolist-icon-wrapper',
			)
		);

		$this->add_control(
			'icon_border_radius',
			array(
				'label'      => __('Border Radius', 'magical-addons-for-elementor'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array('px', '%'),
				'selectors'  => array(
					'{{WRAPPER}} .mg-list-items .mg-infolist-icon-wrapper, {{WRAPPER}} .mg-list-items .mg-info-list-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_icon_hover',
			array(
				'label' => __('Hover', 'magical-addons-for-elementor'),
			)
		);

		$this->add_control(
			'icon_color_hover',
			array(
				'label'     => __('Color', 'magical-addons-for-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mg-list-items .mg-infolist-icon-wrapper:hover .mg-info-list-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .mg-list-items .mg-infolist-icon-wrapper:hover .mg-info-list-icon svg' => 'fill: {{VALUE}};',
				),
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
			)
		);

		$this->add_control(
			'icon_bg_color_hover',
			array(
				'label'     => __('Background Color', 'magical-addons-for-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mg-list-items .mg-infolist-icon-wrapper:hover' => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'icon_border_color_hover',
			array(
				'label'     => __('Border Color', 'magical-addons-for-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mg-list-items .mg-infolist-icon-wrapper:hover' => 'border-color: {{VALUE}};',
				),
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				),
			)
		);

		$this->add_control(
			'icon_hover_animation',
			array(
				'label' => __('Animation', 'magical-addons-for-elementor'),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'icon_number_heading',
			array(
				'label'     => __('Icon Type: Number', 'magical-addons-for-elementor'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'icon_number_typography',
				'label'    => __('Typography', 'magical-addons-for-elementor'),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .mg-list-items .mg-info-list-number',
			)
		);

		$this->end_controls_section();
	}

	protected function register_style_title_controls()
	{
		/**
		 * Style Tab: Title
		 */
		$this->start_controls_section(
			'section_content_style',
			array(
				'label' => __('Content', 'magical-addons-for-elementor'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'content_align',
			array(
				'label'     => __('Alignment', 'magical-addons-for-elementor'),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'    => array(
						'title' => __('Left', 'magical-addons-for-elementor'),
						'icon'  => 'eicon-text-align-left',
					),
					'center'  => array(
						'title' => __('Center', 'magical-addons-for-elementor'),
						'icon'  => 'eicon-text-align-center',
					),
					'right'   => array(
						'title' => __('Right', 'magical-addons-for-elementor'),
						'icon'  => 'eicon-text-align-right',
					),
					'justify' => array(
						'title' => __('Justified', 'magical-addons-for-elementor'),
						'icon'  => 'eicon-text-align-justify',
					),
				),
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mg-infolist-content-wrapper' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'content_padding',
			array(
				'label'      => __('Padding', 'magical-addons-for-elementor'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array('px', 'em', '%'),
				'selectors'  => array(
					'{{WRAPPER}} .mg-infolist-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'show_separator',
			[
				'label'     => esc_html__('Separator', 'magical-addons-for-elementor'),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => esc_html__('Hide', 'magical-addons-for-elementor'),
				'label_on'  => esc_html__('Show', 'magical-addons-for-elementor'),
				'default'   => '',
				'separator' => 'before',
				'condition' => [
					'icon_position!' => 'top',
				],
			]
		);

		$this->add_control(
			'separator_color',
			[
				'label'     => esc_html__('Color', 'magical-addons-for-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e1e8ed',
				'selectors' => [
					'{{WRAPPER}} .mg-info-list-item:not(:last-child) .mg-infolist-content-wrapper' => 'border-bottom-color: {{VALUE}}',
				],
				'condition' => [
					'icon_position!'  => 'top',
					'show_separator!' => '',
				],
			]
		);

		$this->add_control(
			'separator_style',
			array(
				'label'     => __('Style', 'magical-addons-for-elementor'),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'solid'  => __('Solid', 'magical-addons-for-elementor'),
					'double' => __('Double', 'magical-addons-for-elementor'),
					'dotted' => __('Dotted', 'magical-addons-for-elementor'),
					'dashed' => __('Dashed', 'magical-addons-for-elementor'),
				),
				'default'   => 'solid',
				'condition' => array(
					'icon_position!'  => 'top',
					'show_separator!' => '',
				),
				'selectors' => array(
					'{{WRAPPER}} .mg-info-list-item:not(:last-child) .mg-infolist-content-wrapper' => 'border-bottom-style: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'separator_size',
			[
				'label'     => esc_html__('Size', 'magical-addons-for-elementor'),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 1,
				),
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'condition' => [
					'icon_position!'  => 'top',
					'show_separator!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .mg-info-list-item:not(:last-child) .mg-infolist-content-wrapper' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'title_heading',
			array(
				'label'     => __('Title', 'magical-addons-for-elementor'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => __('Color', 'magical-addons-for-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mg-info-list-title' => 'color: {{VALUE}};',
				),
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'label'    => __('Typography', 'magical-addons-for-elementor'),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .mg-info-list-title',
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'      => 'title_text_shadow',
				'label'     => __('Text Shadow', 'magical-addons-for-elementor'),
				'selector'  => '{{WRAPPER}} .mg-info-list-title',
			)
		);

		$this->add_responsive_control(
			'title_margin',
			array(
				'label'      => __('Spacing', 'magical-addons-for-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 0,
						'max'  => 30,
						'step' => 1,
					),
				),
				'size_units' => array('px', '%'),
				'selectors'  => array(
					'{{WRAPPER}} .mg-info-list-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'description_heading',
			array(
				'label'     => __('Description', 'magical-addons-for-elementor'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'description_color',
			array(
				'label'     => __('Color', 'magical-addons-for-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mg-info-list-description' => 'color: {{VALUE}};',
				),
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'description_typography',
				'label'    => __('Typography', 'magical-addons-for-elementor'),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .mg-info-list-description',
			)
		);

		$this->end_controls_section();
	}

	protected function register_style_button_controls()
	{
		/**
		 * Style Tab: Button
		 * -------------------------------------------------
		 */
		$this->start_controls_section(
			'section_info_box_button_style',
			array(
				'label' => __('Button', 'magical-addons-for-elementor'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'button_size',
			array(
				'label'   => __('Size', 'magical-addons-for-elementor'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'sm',
				'options' => array(
					'xs' => __('Extra Small', 'magical-addons-for-elementor'),
					'sm' => __('Small', 'magical-addons-for-elementor'),
					'md' => __('Medium', 'magical-addons-for-elementor'),
					'lg' => __('Large', 'magical-addons-for-elementor'),
					'xl' => __('Extra Large', 'magical-addons-for-elementor'),
				),
			)
		);

		$this->add_responsive_control(
			'button_margin',
			array(
				'label'      => __('Spacing', 'magical-addons-for-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 0,
						'max'  => 30,
						'step' => 1,
					),
				),
				'size_units' => array('px', '%'),
				'selectors'  => array(
					'{{WRAPPER}} .mg-info-list-button' => 'margin-top: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->start_controls_tabs('tabs_button_style');

		$this->start_controls_tab(
			'tab_button_normal',
			array(
				'label' => __('Normal', 'magical-addons-for-elementor'),
			)
		);

		$this->add_control(
			'button_bg_color_normal',
			array(
				'label'     => __('Background Color', 'magical-addons-for-elementor'),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				),
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mg-info-list-button' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'button_text_color_normal',
			array(
				'label'     => __('Text Color', 'magical-addons-for-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mg-info-list-button'     => 'color: {{VALUE}}',
					'{{WRAPPER}} .mg-info-list-button svg' => 'fill: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'button_border_normal',
				'label'       => __('Border', 'magical-addons-for-elementor'),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .mg-info-list-button',
			)
		);

		$this->add_control(
			'button_border_radius',
			array(
				'label'      => __('Border Radius', 'magical-addons-for-elementor'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array('px', '%'),
				'selectors'  => array(
					'{{WRAPPER}} .mg-info-list-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'label'    => __('Typography', 'magical-addons-for-elementor'),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .mg-info-list-button',
			)
		);

		$this->add_responsive_control(
			'button_padding',
			array(
				'label'      => __('Padding', 'magical-addons-for-elementor'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array('px', 'em', '%'),
				'selectors'  => array(
					'{{WRAPPER}} .mg-info-list-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .mg-info-list-button',
			)
		);

		$this->add_control(
			'info_box_button_icon_heading',
			array(
				'label'     => __('Button Icon', 'magical-addons-for-elementor'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'button_icon_margin',
			array(
				'label'       => __('Margin', 'magical-addons-for-elementor'),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => array('px', '%'),
				'placeholder' => array(
					'top'    => '',
					'right'  => '',
					'bottom' => '',
					'left'   => '',
				),
				'selectors'   => array(
					'{{WRAPPER}} .mg-info-list-button .mg-button-icon' => 'margin-top: {{TOP}}{{UNIT}}; margin-left: {{LEFT}}{{UNIT}}; margin-right: {{RIGHT}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			array(
				'label' => __('Hover', 'magical-addons-for-elementor'),
			)
		);

		$this->add_control(
			'button_bg_color_hover',
			array(
				'label'     => __('Background Color', 'magical-addons-for-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mg-info-list-button:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'button_text_color_hover',
			array(
				'label'     => __('Text Color', 'magical-addons-for-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mg-info-list-button:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'button_border_color_hover',
			array(
				'label'     => __('Border Color', 'magical-addons-for-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .mg-info-list-button:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'button_animation',
			array(
				'label' => __('Animation', 'magical-addons-for-elementor'),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_box_shadow_hover',
				'selector' => '{{WRAPPER}} .mg-info-list-button:hover',
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Render info list widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render()
	{
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute(
			array(
				'info-list'        => array(
					'class' => array(
						'mg-info-list-container',
						'mg-list-container',
					),
				),
				'info-list-items'  => array(
					'class' => 'mg-list-items',
				),
				'list-item'        => array(
					'class' => 'mg-info-list-item',
				),
				'icon'             => array(
					'class' => array('mg-info-list-icon', 'mg-icon'),
				),
				'info-list-button' => array(
					'class' => array(
						'mg-info-list-button',
						'elementor-button',
						'elementor-size-' . $settings['button_size'],
					),
				),
			)
		);

		if ('yes' === $settings['connector']) {
			$this->add_render_attribute('info-list', 'class', 'mg-info-list-connector');
			if ('yes' === $settings['corner_lines']) {
				$this->add_render_attribute('info-list', 'class', 'mg-info-list-corners-hide');
			}
		}

		if ($settings['button_animation']) {
			$this->add_render_attribute('info-list-button', 'class', 'elementor-animation-' . $settings['button_animation']);
		}

		$i = 1;
?>
		<div <?php echo wp_kses_post($this->get_render_attribute_string('info-list')); ?>>
			<ul <?php echo wp_kses_post($this->get_render_attribute_string('info-list-items')); ?>>
				<?php foreach ($settings['list_items'] as $index => $item) : ?>
					<?php if ($item['text'] || $item['description']) { ?>
						<li <?php echo wp_kses_post($this->get_render_attribute_string('list-item')); ?>>
							<div class="mg-info-list-item-inner">
								<?php
								$text_key = $this->get_repeater_setting_key('text', 'list_items', $index);
								$this->add_render_attribute($text_key, 'class', 'mg-info-list-title');
								$this->add_inline_editing_attributes($text_key, 'none');

								$description_key = $this->get_repeater_setting_key('description', 'list_items', $index);
								$this->add_render_attribute($description_key, 'class', 'mg-info-list-description');
								$this->add_inline_editing_attributes($description_key, 'basic');

								$button_key = $this->get_repeater_setting_key('button-wrap', 'list_items', $index);
								$this->add_render_attribute($button_key, 'class', 'mg-info-list-button-wrapper mg-info-list-button-icon-' . $item['button_icon_position']);

								if (!empty($item['link']['url'])) {
									$link_key = 'link_' . $i;

									$this->add_link_attributes($link_key, $item['link']);
								}

								$this->render_infolist_icon($item, $i);
								?>
								<div class="mg-infolist-content-wrapper">
									<?php if (!empty($item['link']['url']) && 'box' === $item['link_type']) { ?>
										<a <?php echo wp_kses_post($this->get_render_attribute_string($link_key)); ?>>
										<?php } ?>
										<?php
										if ($item['text']) {
											$title_tag = $settings['title_html_tag'];
										?>
											<<?php echo esc_html($title_tag); ?> <?php echo wp_kses_post($this->get_render_attribute_string($text_key)); ?>>
												<?php if (!empty($item['link']['url']) && 'title' === $item['link_type']) { ?>
													<a <?php echo wp_kses_post($this->get_render_attribute_string($link_key)); ?>>
													<?php } ?>
													<?php echo wp_kses_post($item['text']); ?>
													<?php if (!empty($item['link']['url']) && 'title' === $item['link_type']) { ?>
													</a>
												<?php } ?>
											</<?php echo esc_html($title_tag); ?>>
										<?php } ?>
										<?php
										if ($item['description']) {
										?>
											<div <?php echo wp_kses_post($this->get_render_attribute_string($description_key)); ?>>
												<?php echo $this->parse_text_editor($item['description']); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
												?>
											</div>
										<?php
										}
										?>
										<?php if ('button' === $item['link_type'] && !empty($item['link']['url'])) { ?>
											<div <?php echo wp_kses_post($this->get_render_attribute_string($button_key)); ?>>
												<a <?php echo wp_kses_post($this->get_render_attribute_string($link_key)); ?>>
													<div <?php echo wp_kses_post($this->get_render_attribute_string('info-list-button')); ?>>
														<?php $this->render_infolist_button_icon($item); ?>

														<?php if (!empty($item['button_text'])) { ?>
															<span <?php echo wp_kses_post($this->get_render_attribute_string('button_text')); ?>>
																<?php echo wp_kses_post($item['button_text']); ?>
															</span>
														<?php } ?>
													</div>
												</a>
											</div>
										<?php } ?>
										<?php
										if (!empty($item['link']['url']) && 'box' === $item['link_type']) {
										?>
										</a>
									<?php
										}
									?>
								</div>
							</div>
						</li>
					<?php } ?>
				<?php
					$i++;
				endforeach;
				?>
			</ul>
		</div>
		<?php
	}

	/**
	 * Render info-box carousel icon output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render_infolist_button_icon($item)
	{
		$settings = $this->get_settings_for_display();

		$migration_allowed = Icons_Manager::is_migration_allowed();

		// add old default
		if (!isset($item['button_icon']) && !$migration_allowed) {
			$item['button_icon'] = '';
		}

		$migrated = isset($item['__fa4_migrated']['icon']);
		$is_new   = empty($item['button_icon']) && $migration_allowed;

		if (!empty($item['button_icon']) || (!empty($item['selected_icon']['value']) && $is_new)) {
		?>
			<span class="mg-button-icon mg-icon">
				<?php
				if ($is_new || $migrated) {
					Icons_Manager::render_icon($item['selected_icon'], array('aria-hidden' => 'true'));
				} else {
				?>
					<i class="<?php echo esc_attr($item['button_icon']); ?>" aria-hidden="true"></i>
				<?php
				}
				?>
			</span>
		<?php
		}
	}

	/**
	 * Render info-box carousel icon output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render_infolist_icon($item, $i)
	{
		$settings = $this->get_settings_for_display();

		$fallback_defaults = array(
			'fa fa-check',
			'fa fa-times',
			'fa fa-dot-circle-o',
		);

		$migration_allowed = Icons_Manager::is_migration_allowed();

		// add old default
		if (!isset($item['list_icon']) && !$migration_allowed) {
			$item['list_icon'] = isset($fallback_defaults[$index]) ? $fallback_defaults[$index] : 'fa fa-check';
		}

		$migrated = isset($item['__fa4_migrated']['icon']);
		$is_new   = empty($item['list_icon']) && $migration_allowed;

		if ('none' !== $item['pp_icon_type']) {
			$icon_wrap_key = $this->get_repeater_setting_key('icon_wrap', 'list_items', $i);
			$icon_key      = $this->get_repeater_setting_key('icon', 'list_items', $i);

			if ('' !== $settings['icon_hover_animation']) {
				$icon_animation = 'elementor-animation-' . $settings['icon_hover_animation'];
			} else {
				$icon_animation = '';
			}

			$this->add_render_attribute($icon_wrap_key, 'class', 'mg-infolist-icon-wrapper');
			$this->add_render_attribute(
				$icon_key,
				'class',
				array(
					'mg-info-list-icon',
					'mg-icon',
					esc_attr($icon_animation),
				)
			);
		?>
			<div <?php echo wp_kses_post($this->get_render_attribute_string($icon_wrap_key)); ?>>
				<?php
				if ('icon' === $item['pp_icon_type']) {
					if (!empty($item['list_icon']) || (!empty($item['icon']['value']) && $is_new)) {
				?>
						<span <?php echo wp_kses_post($this->get_render_attribute_string($icon_key)); ?>>
							<?php
							if ($is_new || $migrated) {
								Icons_Manager::render_icon($item['icon'], array('aria-hidden' => 'true'));
							} else {
							?>
								<i class="<?php echo esc_attr($item['list_icon']); ?>" aria-hidden="true"></i>
							<?php
							}
							?>
						</span>
					<?php
					}
				} elseif ('image' === $item['pp_icon_type']) {
					$image_url = Group_Control_Image_Size::get_attachment_image_src($item['list_image']['id'], 'thumbnail', $settings);

					if ($image_url) {
					?>
						<span class="mg-info-list-image <?php echo esc_attr($icon_animation); ?>"><img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr(Control_Media::get_image_alt($item['list_image'])); ?>"></span>
					<?php
					} else {
					?>
						<img src="<?php echo esc_url($item['list_image']['url']); ?>">
					<?php
					}
				} elseif ('text' === $item['pp_icon_type']) {
					?>
					<span class="mg-info-list-icon mg-info-list-number <?php echo esc_attr($icon_animation); ?>">
						<?php echo wp_kses_post($item['icon_text']); ?>
					</span>
				<?php
				}
				?>
			</div>
		<?php
		}
	}

	/**
	 * Render info list widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @access protected
	 */
	protected function content_template()
	{
		?>
		<# view.addRenderAttribute( 'info-list' , { 'class' : [ 'mg-info-list-container' , 'mg-list-container' ], } ); if ( settings.connector=='yes' ) { view.addRenderAttribute( 'info-list' , 'class' , 'mg-info-list-connector' ); if ( settings.corner_lines=='yes' ) { view.addRenderAttribute( 'info-list' , 'class' , 'mg-info-list-corners-hide' ); } } var iconsHTML={}, migrated={}, buttonIconHTML={}, buttonMigrated={}; #>
			<div {{{ view.getRenderAttributeString( 'info-list' ) }}}>
				<ul class="mg-list-items">
					<# var i=1; #>
						<# _.each( settings.list_items, function( item, index ) { #>
							<# var text_key='list_items.' + (i - 1) + '.text' ; var description_key='list_items.' + (i - 1) + '.description' ; view.addInlineEditingAttributes( text_key ); view.addRenderAttribute( description_key, 'class' , 'mg-info-list-description' ); view.addInlineEditingAttributes( description_key ); #>
								<# if ( item.text || item.description ) { #>
									<li class="mg-info-list-item">
										<div class="mg-info-list-item-inner">
											<# if ( item.pp_icon_type !='none' ) { #>
												<div class="mg-infolist-icon-wrapper">
													<# if ( item.pp_icon_type=='icon' ) { #>
														<# if ( item.list_icon || item.icon.value ) { #>
															<span class="mg-info-list-icon mg-icon elementor-animation-{{ settings.icon_hover_animation }}" aria-hidden="true">
																<# iconsHTML[ index ]=elementor.helpers.renderIcon( view, item.icon, { 'aria-hidden' : true }, 'i' , 'object' ); migrated[ index ]=elementor.helpers.isIconMigrated( item, 'icon' ); if ( iconsHTML[ index ] && iconsHTML[ index ].rendered && ( ! item.list_icon || migrated[ index ] ) ) { #>
																	{{{ iconsHTML[ index ].value }}}
																	<# } else { #>
																		<i class="{{ item.list_icon }}" aria-hidden="true"></i>
																		<# } #>
															</span>
															<# } #>
																<# } else if ( item.pp_icon_type=='image' ) { #>
																	<span class="mg-info-list-image elementor-animation-{{ settings.icon_hover_animation }}">
																		<# var image={ id: item.list_image.id, url: item.list_image.url, size: settings.thumbnail_size, dimension: settings.thumbnail_custom_dimension, model: view.getEditModel() }; var image_url=elementor.imagesManager.getImageUrl( image ); #>
																			<img src="{{{ image_url }}}" />
																	</span>
																	<# } else if ( item.pp_icon_type=='text' ) { #>
																		<span class="mg-info-list-icon mg-info-list-number elementor-animation-{{ settings.icon_hover_animation }}">
																			{{ item.icon_text }}
																		</span>
																		<# } #>
												</div>
												<# } #>
													<div class="mg-infolist-content-wrapper">
														<# if ( item.link.url !='' && item.link_type=='box' ) { #>
															<a href="{{ item.link.url }}">
																<# } #>
																	<# if ( item.text ) { #>
																		<{{settings.title_html_tag}} class="mg-info-list-title">
																			<# if ( item.link.url !='' && item.link_type=='title' ) { #>
																				<a href="{{ item.link.url }}">
																					<# } #>
																						<span {{{ view.getRenderAttributeString( 'list_items.' + (i - 1) + '.text' ) }}}>
																							{{{ item.text }}}
																						</span>
																						<# if ( item.link.url !='' && item.link_type=='title' ) { #>
																				</a>
																				<# } #>
																		</{{settings.title_html_tag}}>
																		<# } #>
																			<# if ( item.description ) { #>
																				<div {{{ view.getRenderAttributeString( description_key ) }}}>
																					{{{ item.description }}}
																				</div>
																				<# } #>
																					<# if ( item.link.url !='' && item.link_type=='button' ) { #>
																						<div class="mg-info-list-button-wrapper mg-info-list-button-icon-{{ item.button_icon_position }}">
																							<a href="{{ item.link.url }}">
																								<div class="mg-info-list-button elementor-button elementor-size-{{ settings.button_size }} elementor-animation-{{ settings.button_animation }}">
																									<# buttonIconHTML[ index ]=elementor.helpers.renderIcon( view, item.selected_icon, { 'aria-hidden' : true }, 'i' , 'object' ); buttonMigrated[ index ]=elementor.helpers.isIconMigrated( item, 'selected_icon' ); #>
																										<# if ( buttonIconHTML[ index ] && buttonIconHTML[ index ].rendered && ( ! item.button_icon || buttonMigrated[ index ] ) ) { #>
																											<span class="mg-button-icon mg-icon">
																												{{{ buttonIconHTML[ index ].value }}}
																											</span>
																											<# } else if ( item.button_icon ) { #>
																												<span class="mg-button-icon mg-icon">
																													<i class="{{ item.button_icon }}" aria-hidden="true"></i>
																												</span>
																												<# } #>

																													<# if ( item.button_text !='' ) { #>
																														<span class="mg-button-text">
																															{{{ item.button_text }}}
																														</span>
																														<# } #>
																								</div>
																							</a>
																						</div>
																						<# } #>
																							<# if ( item.link_type=='box' ) { #>
															</a>
															<# } #>
													</div>
										</div>
									</li>
									<# } #>
										<# i++ } ); #>
				</ul>
			</div>
	<?php
	}
}
