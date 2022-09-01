<?php

/**
 * Data Table
 *
 * @package Magical addons
 */
defined('ABSPATH') || die();

use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Control_Media;


class mgDataTable extends \Elementor\Widget_Base
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
		return 'mgdata_table_widget';
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
		return __('Mg Data Table', 'magical-addons-for-elementor');
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
		return 'eicon-table';
	}

	public function get_keywords()
	{
		return ['mg', 'data', 'table', 'data table', 'table data'];
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
	 * Retrieve the list of scripts the image accordion widget depended on.
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
			'mg-data-table',
		);
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
	 * Register widget content controls
	 */
	protected function register_content_controls()
	{
		$this->table_head_content_controls();
		$this->table_row_content_controls();
	}

	function table_head_content_controls()
	{

		$this->start_controls_section(
			'_section_table_column',
			[
				'label' => __('Table Header', 'magical-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs('_tabs_column');

		$repeater->start_controls_tab(
			'_tab_column_content',
			[
				'label' => __('Content', 'magical-addons-for-elementor'),
			]
		);

		$repeater->add_control(
			'column_name',
			[
				'label' => __('Title', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __('Column Name', 'magical-addons-for-elementor'),
				'default' => __('Column One', 'magical-addons-for-elementor'),
				'dynamic' => [
					'active' => true,
				]
			]
		);

		$repeater->add_control(
			'column_span',
			[
				'label' => __('Col Span', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::HIDDEN,

			]
		);
		/*
		$repeater->add_control(
			'column_span',
			[
				'label' => __('Col Span', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 50,
				'step' => 1
			]
		);
*/
		$repeater->add_responsive_control(
			'column_media',
			[
				'label' => __('Media', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'toggle' => false,
				'default' => 'none',
				'options' => [
					'none' => [
						'title' => __('None', 'magical-addons-for-elementor'),
						'icon' => 'eicon-editor-close',
					],
					'icon' => [
						'title' => __('Icon', 'magical-addons-for-elementor'),
						'icon' => 'eicon-info-circle',
					],
					'image' => [
						'title' => __('Image', 'magical-addons-for-elementor'),
						'icon' => 'eicon-image-bold',
					],
				]
			]
		);

		$repeater->add_control(
			'column_icons',
			[
				'label' => __('Icon', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'column_icon',
				'label_block' => true,
				'condition' => [
					'column_media' => 'icon'
				],
			]
		);

		$repeater->add_control(
			'column_image',
			[
				'label' => __('Image', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'column_media' => 'image'
				]
			]
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'column_thumbnail',
				'default' => 'thumbnail',
				'separator' => 'none',
				'condition' => [
					'column_media' => 'image'
				]
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'_tabs_column_style',
			[
				'label' => __('Style', 'magical-addons-for-elementor'),
			]
		);

		$repeater->add_control(
			'head_custom_color',
			[
				'label' => __('Icon Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'column_media' => 'icon'
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .mg-table--head-column-cell-icon i' => 'color: {{VALUE}}',
				],
			]
		);

		$repeater->end_controls_tab();
		$repeater->end_controls_tabs();

		$this->add_control(
			'columns_data',
			[
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ column_name }}}',
				'default' => [
					[
						'column_name' => __('Name', 'magical-addons-for-elementor')
					],
					[
						'column_name' => __('Position', 'magical-addons-for-elementor')
					],
					[
						'column_name' => __('Age', 'magical-addons-for-elementor')
					],
					[
						'column_name' => __('Salary', 'magical-addons-for-elementor')
					],
					[
						'column_name' => __('Office', 'magical-addons-for-elementor')
					]
				]
			]
		);

		$this->add_responsive_control(
			'head_align',
			[
				'label' => __('Alignment', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::CHOOSE,
				'separator' => 'before',
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
					]
				],
				'default' => 'left',
				'toggle' => false,
				'prefix_class' => 'mg-column-alignment-',
				'selectors' => [
					'{{WRAPPER}} .mg-table--head-column-cell' => 'text-align: {{VALUE}}'
				]
			]
		);

		$this->add_responsive_control(
			'icon_position',
			[
				'label' => __('Icon Position', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __('Left', 'magical-addons-for-elementor'),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => __('Right', 'magical-addons-for-elementor'),
						'icon' => 'eicon-h-align-right',
					],
					'top' => [
						'title' => __('Top', 'magical-addons-for-elementor'),
						'icon' => 'eicon-v-align-top',
					],
					'bottom' => [
						'title' => __('Bottom', 'magical-addons-for-elementor'),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'right',
				'toggle' => false,
				'prefix_class' => 'mg-column-icon-'
			]
		);

		$this->end_controls_section();
	}

	function table_row_content_controls()
	{

		$this->start_controls_section(
			'_section_table_row',
			[
				'label' => __('Table Row', 'magical-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'row_column_type',
			[
				'label'   => __('Row/Column', 'magical-addons-for-elementor'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'row',
				'options' => [
					'row' => __('Row', 'magical-addons-for-elementor'),
					'column' => __('Column', 'magical-addons-for-elementor'),
				],
			]
		);

		$repeater->start_controls_tabs('_tabs_row');

		$repeater->start_controls_tab(
			'_tab_row_content',
			[
				'label' => __('Content', 'magical-addons-for-elementor'),
				'condition' => [
					'row_column_type' => 'column'
				],
			]
		);

		$repeater->add_control(
			'cell_name',
			[
				'label' => __('Title', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __('Cell Name', 'magical-addons-for-elementor'),
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'row_column_type' => 'column'
				],
			]
		);

		$repeater->add_control(
			'cell_link',
			[
				'label' => __('Link', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::URL,
				'placeholder' => 'https://example.com',
				'dynamic' => [
					'active' => true,
				],
				'condition' => [
					'row_column_type' => 'column'
				],
			]
		);

		$repeater->add_control(
			'row_column_span',
			[
				'label' => __('Col Span', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::HIDDEN,
				'condition' => [
					'row_column_type' => 'column'
				],
			]
		);
		/*
		$repeater->add_control(
			'row_span',
			[
				'label' => __('Row Span', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 50,
				'step' => 1,
				'condition' => [
					'row_column_type' => 'column'
				],
			]
		);
		*/
		$repeater->add_control(
			'row_span',
			[
				'label' => __('Row Span', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::HIDDEN,
				'condition' => [
					'row_column_type' => 'column'
				],
			]
		);

		$repeater->add_control(
			'row_media',
			[
				'label' => __('Media', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'toggle' => false,
				'default' => 'none',
				'condition' => [
					'row_column_type' => 'column'
				],
				'options' => [
					'icon' => [
						'title' => __('Icon', 'magical-addons-for-elementor'),
						'icon' => 'eicon-info-circle',
					],
					'image' => [
						'title' => __('Image', 'magical-addons-for-elementor'),
						'icon' => 'eicon-image-bold',
					],
					'none' => [
						'title' => __('None', 'magical-addons-for-elementor'),
						'icon' => 'eicon-editor-close',
					],
				]
			]
		);

		$repeater->add_control(
			'row_icons',
			[
				'label' => __('Icon', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'row_icon',
				'label_block' => true,
				'condition' => [
					'row_media' => 'icon',
					'row_column_type' => 'column'
				],
			]
		);

		$repeater->add_control(
			'row_image',
			[
				'label' => __('Image', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'row_media' => 'image',
					'row_column_type' => 'column'
				],
				'dynamic' => [
					'active' => true,
				]
			]
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'row_thumbnail',
				'default' => 'thumbnail',
				'separator' => 'none',
				'exclude' => ['custom'],
				'condition' => [
					'row_media' => 'image',
					'row_column_type' => 'column'
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'_tabs_row_style',
			[
				'label' => __('Style', 'magical-addons-for-elementor'),
				'condition' => [
					'row_column_type' => 'column'
				],
			]
		);

		$repeater->add_control(
			'row_custom_background_color',
			[
				'label' => __('Background Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'row_column_type' => 'column'
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.mg-table--body-row-cell' => 'background-color: {{VALUE}}',
				],
			]
		);

		$repeater->add_control(
			'row_custom_text_color',
			[
				'label' => __('Text Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'row_column_type' => 'column'
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .mg-table--body-row-cell-text' => 'color: {{VALUE}}',
				],
			]
		);

		$repeater->add_control(
			'row_custom_icon_color',
			[
				'label' => __('Icon Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'row_column_type' => 'column',
					'row_media' => 'icon'
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .mg-table--body-row-cell-icon i' => 'color: {{VALUE}}',
				],
			]
		);

		$repeater->add_responsive_control(
			'row_custom_icon_size',
			[
				'label' => __('Icon/Image Size', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'condition' => [
					'row_column_type' => 'column'
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .mg-table--body-row-cell-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} .mg-table--body-row-cell-icon img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} .mg-table--body-row-cell-icon svg' => 'width: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$repeater->end_controls_tab();
		$repeater->end_controls_tabs();

		$this->add_control(
			'row_starts',
			[
				'label' => false,
				'type' => Controls_Manager::HIDDEN,
				'default' => __('Row Starts', 'magical-addons-for-elementor'),
				'condition' => [
					'row_column_type' => 'row'
				],
			]
		);

		$this->add_control(
			'rows_data',
			[
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '<# print( (row_column_type == "column" ) ? cell_name : ("Row Starts") ) #>',
				'default' => [
					[
						'row_column_type' => 'row',
						'row_starts' => __('Row Starts', 'magical-addons-for-elementor'),
					],
					[
						'row_column_type' => 'column',
						'cell_name' => __('Jone Doe', 'magical-addons-for-elementor')
					],
					[
						'row_column_type' => 'column',
						'cell_name' => __('Support Engineer', 'magical-addons-for-elementor')
					],
					[
						'row_column_type' => 'column',
						'cell_name' => __('32', 'magical-addons-for-elementor')
					],
					[
						'row_column_type' => 'column',
						'cell_name' => __('$327,900', 'magical-addons-for-elementor')
					],
					[
						'row_column_type' => 'column',
						'cell_name' => __('Sydney', 'magical-addons-for-elementor')
					],
					[
						'row_column_type' => 'row',
						'row_starts' => __('Row Starts', 'magical-addons-for-elementor'),
					],
					[
						'row_column_type' => 'column',
						'cell_name' => __('Jane Tako', 'magical-addons-for-elementor')
					],
					[
						'row_column_type' => 'column',
						'cell_name' => __('Support Engineer', 'magical-addons-for-elementor')
					],
					[
						'row_column_type' => 'column',
						'cell_name' => __('29', 'magical-addons-for-elementor')
					],
					[
						'row_column_type' => 'column',
						'cell_name' => __('$697,900', 'magical-addons-for-elementor')
					],
					[
						'row_column_type' => 'column',
						'cell_name' => __('New York', 'magical-addons-for-elementor')
					],
				]
			]
		);

		$this->add_responsive_control(
			'row_align',
			[
				'label' => __('Alignment', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::CHOOSE,
				'separator' => 'before',
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
					]
				],
				'default' => 'left',
				'toggle' => false,
				'prefix_class' => 'mg-row-alignment-',
				'selectors' => [
					'(desktop){{WRAPPER}} .mg-table--body-row-cell' => 'text-align: {{VALUE}}',
					'(tablet){{WRAPPER}} .mg-table--body-row-cell' => 'text-align: {{VALUE}}',
					'(mobile){{WRAPPER}} .mg-table--body-row-cell' => 'text-align: {{VALUE}}'
				]
			]
		);
		$this->add_responsive_control(
			'rowicon_position',
			[
				'label' => __('Icon Position', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::CHOOSE,
				'separator' => 'before',
				'options' => [
					'left' => [
						'title' => __('Left', 'magical-addons-for-elementor'),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => __('Right', 'magical-addons-for-elementor'),
						'icon' => 'eicon-h-align-right',
					],
					'top' => [
						'title' => __('Top', 'magical-addons-for-elementor'),
						'icon' => 'eicon-v-align-top',
					],
					'bottom' => [
						'title' => __('Bottom', 'magical-addons-for-elementor'),
						'icon' => 'eicon-v-align-bottom',
					],

				],
				'default' => 'right',
				'toggle' => false,
				'prefix_class' => 'mg-row-icon-',

			]
		);
		/*
		$this->add_responsive_control(
			'row_icons_position',
			[
				'label' => __('Icon Position', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __('Left', 'magical-addons-for-elementor'),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => __('Right', 'magical-addons-for-elementor'),
						'icon' => 'eicon-h-align-right',
					],
					'top' => [
						'title' => __('Top', 'magical-addons-for-elementor'),
						'icon' => 'eicon-v-align-top',
					],
					'bottom' => [
						'title' => __('Bottom', 'magical-addons-for-elementor'),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'right',
				'toggle' => false,
				'prefix_class' => 'mg-row-icon-'
			]
		);
*/
		$this->end_controls_section();
		$this->link_pro_added();
	}


	/**
	 * Register widget style controls
	 */
	protected function register_style_controls()
	{
		$this->table_head_style_controls();
		$this->table_row_style_controls();
	}

	function table_head_style_controls()
	{

		$this->start_controls_section(
			'_section_table_head',
			[
				'label' => __('Table Header', 'magical-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'table_head_padding',
			[
				'label' => __('Padding', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-table .mg-table--head-column-cell' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'head_border_radius',
			[
				'label' => __('Border Radius', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'(desktop){{WRAPPER}} .mg-table .mg-table--head-column-cell:first-child' => 'border-top-left-radius: {{SIZE}}{{UNIT}};',
					'(desktop){{WRAPPER}} .mg-table .mg-table--head-column-cell:last-child' => 'border-top-right-radius: {{SIZE}}{{UNIT}};',
					'(tablet){{WRAPPER}} .mg-table .mg-table--head-column-cell:first-child' => 'border-top-left-radius: {{SIZE}}{{UNIT}};',
					'(tablet){{WRAPPER}} .mg-table .mg-table--head-column-cell:last-child' => 'border-top-right-radius: {{SIZE}}{{UNIT}};',
					'(mobile){{WRAPPER}} .mg-table .mg-table--head-column-cell' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'head_border',
				'selector' => '{{WRAPPER}} .mg-table .mg-table--head-column-cell',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'head_background_color',
				'types' => ['classic', 'gradient'],
				'exclude' => ['image'],
				'selector' => '{{WRAPPER}} .mg-table .mg-table--head-column-cell',
			]
		);

		$this->add_control(
			'_heading_title',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __('Title', 'magical-addons-for-elementor'),
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'head_typography',
				'selector' => '{{WRAPPER}} .mg-table .mg-table--head-column-cell-text',
				'scheme' => Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'head_text_color',
			[
				'label' => __('Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-table .mg-table--head-column-cell-wrap' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'_heading_icon',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __('Icon/Image', 'magical-addons-for-elementor'),
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'icon_spacing',
			[
				'label' => __('Spacing', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-table .mg-table--head-column-cell-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'head_icon',
			[
				'label' => __('Icon Size', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .mg-table .mg-table--head-column-cell-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .mg-table .mg-table--head-column-cell-icon svg' => 'width: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_control(
			'column_image_border_radius',
			[
				'label' => __('Image Border Radius', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .mg-table .mg-table--head-column-cell-icon img' => 'border-radius: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_control(
			'head_icon_color',
			[
				'label' => __('Icon Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-table--head-column-cell-icon i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'column_color_notice',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => 'If you\'ve added <strong>Custom Style</strong> then Icon Color will be over written for that cell.',
			]
		);

		$this->end_controls_section();
	}

	function table_row_style_controls()
	{

		$this->start_controls_section(
			'_section_table_row_style',
			[
				'label' => __('Table Row', 'magical-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'table_row_padding',
			[
				'label' => __('Padding', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'(desktop){{WRAPPER}} .mg-table--body .mg-table--body-row-cell' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'(tablet){{WRAPPER}} .mg-table--body .mg-table--body-row-cell' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'(mobile){{WRAPPER}} .mg-table--body .mg-table--body-row-cell-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'row_border',
				'selector' => '{{WRAPPER}} .mg-table--body .mg-table--body-row-cell',
			]
		);

		$this->start_controls_tabs('_tabs_rows');
		$this->start_controls_tab(
			'_tab_head_row',
			[
				'label' => __('Normal', 'magical-addons-for-elementor')
			]
		);

		$this->add_responsive_control(
			'row_background_color_even',
			[
				'label' => __('Background Color (Even)', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'(desktop){{WRAPPER}} .mg-table--body .mg-table--body-row:nth-child(even)' => 'background-color: {{VALUE}}',
					'(tablet){{WRAPPER}} .mg-table--body .mg-table--body-row:nth-child(even)' => 'background-color: {{VALUE}}',
					'(mobile){{WRAPPER}} .mg-table--body .mg-table--body-row-cell:nth-child(even) .mg-table--body-row-cell-wrap' => 'background-color: {{VALUE}}',
					'(mobile){{WRAPPER}} .mg-table--body .mg-table--body-row:nth-child(even)' => 'background-color: transparent',
				],
			]
		);

		$this->add_responsive_control(
			'row_background_color_odd',
			[
				'label' => __('Background Color (Odd)', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'(desktop){{WRAPPER}} .mg-table--body .mg-table--body-row:nth-child(odd)' => 'background-color: {{VALUE}}',
					'(tablet){{WRAPPER}} .mg-table--body .mg-table--body-row:nth-child(odd)' => 'background-color: {{VALUE}}',
					'(mobile){{WRAPPER}} .mg-table--body .mg-table--body-row-cell:nth-child(odd) .mg-table--body-row-cell-wrap' => 'background-color: {{VALUE}}',
					'(mobile){{WRAPPER}} .mg-table--body .mg-table--body-row:nth-child(odd)' => 'background-color: transparent',
				],
			]
		);

		$this->add_responsive_control(
			'row_color_even',
			[
				'label' => __('Color (Even)', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'(desktop){{WRAPPER}} .mg-table--body .mg-table--body-row:nth-child(even) .mg-table--body-row-cell-wrap' => 'color: {{VALUE}}',
					'(tablet){{WRAPPER}} .mg-table--body .mg-table--body-row:nth-child(even) .mg-table--body-row-cell-wrap' => 'color: {{VALUE}}',
					'(mobile){{WRAPPER}} .mg-table--body .mg-table--body-row-cell:nth-child(even) .mg-table--body-row-cell-wrap' => 'color: {{VALUE}}'
				],
			]
		);

		$this->add_responsive_control(
			'row_color_odd',
			[
				'label' => __('Color (Odd)', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'(desktop){{WRAPPER}} .mg-table--body .mg-table--body-row:nth-child(odd) .mg-table--body-row-cell-wrap' => 'color: {{VALUE}}',
					'(tablet){{WRAPPER}} .mg-table--body .mg-table--body-row:nth-child(odd) .mg-table--body-row-cell-wrap' => 'color: {{VALUE}}',
					'(mobile){{WRAPPER}} .mg-table--body .mg-table--body-row-cell:nth-child(odd) .mg-table--body-row-cell-wrap' => 'color: {{VALUE}}'
				],
			]
		);

		$this->add_control(
			'row_text_link_color',
			[
				'label' => __('Link Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-table--body .mg-table--body-row-cell-text a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'_tab_row',
			[
				'label' => __('Hover', 'magical-addons-for-elementor')
			]
		);

		$this->add_responsive_control(
			'row_hover_background_color_even',
			[
				'label' => __('Background Color (Even)', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'(desktop){{WRAPPER}} .mg-table--body .mg-table--body-row:nth-child(even):hover' => 'background-color: {{VALUE}}',
					'(tablet){{WRAPPER}} .mg-table--body .mg-table--body-row:nth-child(even):hover' => 'background-color: {{VALUE}}',
					'(mobile){{WRAPPER}} .mg-table--body .mg-table--body-row-cell:nth-child(even) .mg-table--body-row-cell-wrap:hover' => 'background-color: {{VALUE}}',
					'(mobile){{WRAPPER}} .mg-table--body .mg-table--body-row:nth-child(even):hover' => 'background-color: transparent',
				],
			]
		);

		$this->add_responsive_control(
			'row_hover_background_color_odd',
			[
				'label' => __('Background Color (Odd)', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'(desktop){{WRAPPER}} .mg-table--body .mg-table--body-row:nth-child(odd):hover' => 'background-color: {{VALUE}}',
					'(tablet){{WRAPPER}} .mg-table--body .mg-table--body-row:nth-child(odd):hover' => 'background-color: {{VALUE}}',
					'(mobile){{WRAPPER}} .mg-table--body .mg-table--body-row-cell:nth-child(odd) .mg-table--body-row-cell-wrap:hover' => 'background-color: {{VALUE}}',
					'(mobile){{WRAPPER}} .mg-table--body .mg-table--body-row:nth-child(odd):hover' => 'background-color: transparent',
				],
			]
		);

		$this->add_responsive_control(
			'row_hover_color_even',
			[
				'label' => __('Color (Even)', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'(desktop){{WRAPPER}} .mg-table--body .mg-table--body-row:nth-child(even):hover .mg-table--body-row-cell-wrap' => 'color: {{VALUE}}',
					'(tablet){{WRAPPER}} .mg-table--body .mg-table--body-row:nth-child(even):hover .mg-table--body-row-cell-wrap' => 'color: {{VALUE}}',
					'(mobile){{WRAPPER}} .mg-table--body .mg-table--body-row-cell:nth-child(even):hover .mg-table--body-row-cell-wrap' => 'color: {{VALUE}}'
				],
			]
		);

		$this->add_responsive_control(
			'row_hover_color_odd',
			[
				'label' => __('Color (Odd)', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'(desktop){{WRAPPER}} .mg-table--body .mg-table--body-row:nth-child(odd):hover .mg-table--body-row-cell-wrap' => 'color: {{VALUE}}',
					'(tablet){{WRAPPER}} .mg-table--body .mg-table--body-row:nth-child(odd):hover .mg-table--body-row-cell-wrap' => 'color: {{VALUE}}',
					'(mobile){{WRAPPER}} .mg-table--body .mg-table--body-row-cell:nth-child(odd):hover .mg-table--body-row-cell-wrap' => 'color: {{VALUE}}'
				],
			]
		);

		$this->add_control(
			'row_text_link_hover_color',
			[
				'label' => __('Link Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-table--body .mg-table--body-row-cell-text a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'_row_title',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __('Title', 'magical-addons-for-elementor'),
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'row_text_typography',
				'selector' => '{{WRAPPER}} .mg-table--body .mg-table--body-row-cell-text',
				'scheme' => Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'_row_icon',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __('Icon/Image', 'magical-addons-for-elementor'),
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'row_icon_spacing',
			[
				'label' => __('Spacing', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .mg-table--body .mg-table--body-row-cell-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'row_icon_size',
			[
				'label' => __('Size', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .mg-table--body-row-cell-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .mg-table--body-row-cell-icon img' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .mg-table--body-row-cell-icon svg' => 'width: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_control(
			'row_image_border_radius',
			[
				'label' => __('Image Border Radius', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .mg-table--body .mg-table--body-row-cell-icon img' => 'border-radius: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_control(
			'row_icon_color',
			[
				'label' => __('Color', 'magical-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .mg-table--body-row-cell-icon i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'row_style_notice',
			[
				'type' => Controls_Manager::RAW_HTML,
				'separator' => 'before',
				'raw' => 'If you\'ve added <strong>Custom Style</strong> then Background Color, Color, Icon Size, Icon Color will be over written for that cell.',
			]
		);

		$this->end_controls_section();
	}

	protected function render()
	{

		$settings = $this->get_settings_for_display();

		$table_row  = [];
		$table_cell = [];

		foreach ($settings['rows_data'] as $row) {
			$row_id = uniqid();

			if ($row['row_column_type'] == 'row') {
				$table_row[] = [
					'id' => $row_id,
					'type' => $row['row_column_type'],
				];
			}

			if ($row['row_column_type'] == 'column') {
				$table_row_keys = array_keys($table_row);
				$cell_key = end($table_row_keys);

				$table_cell[] = [
					'repeater_id'        => $row['_id'],
					'row_id'             => isset($table_row[$cell_key]['id']) ? $table_row[$cell_key]['id'] : '',
					'title'              => $row['cell_name'],
					'row_span'           => $row['row_span'],
					'row_column_span'    => $row['row_column_span'],
					'row_icon'           => !empty($row['row_icon']) ? $row['row_icon'] : '',
					'row_icons'          => !empty($row['row_icons']['value']) ? $row['row_icons'] : '',
					'row_icon_show'      => !empty($row['row_icon_show']) ? $row['row_icon_show'] : '',
					'row_image'          => array_key_exists('row_image', $row) ? $row['row_image'] : '',
					'row_thumbnail_size' => !empty($row['row_thumbnail_size']) ? $row['row_thumbnail_size'] : '',
					'cell_link'          => !empty($row['cell_link']['url']) ? $row['cell_link'] : '',
				];
			}
		}
?>

		<table class="mg-data-table mg-table item-visiable">
			<thead class="mg-table--head">
				<tr class="mg-table--head-column">
					<?php foreach ($settings['columns_data'] as $index => $column_cell) :
						$column_repeater_key = $this->get_repeater_setting_key('column_span', 'columns_data', $index);

						$this->add_render_attribute($column_repeater_key, 'class', 'mg-table--head-column-cell');
						$this->add_render_attribute($column_repeater_key, 'class', 'elementor-repeater-item-' . $column_cell['_id']);

						if ($column_cell['column_span']) {
							$this->add_render_attribute($column_repeater_key, 'colspan', $column_cell['column_span']);
						}
					?>
						<th <?php echo $this->get_render_attribute_string($column_repeater_key); ?>>
							<div class="mg-table--head-column-cell-wrap">
								<div class="mg-table--head-column-cell-text"><?php echo mg_kses_tags($column_cell['column_name']); ?></div>
								<?php if ($column_cell['column_media'] == 'icon' && !empty($column_cell['column_icons'])) : ?>
									<div class="mg-table--head-column-cell-icon">
										<?php Icons_Manager::render_icon($column_cell['column_icons']); ?>
									</div>
								<?php endif; ?>

								<?php
								if (!empty($column_cell['column_image']['url']) || !empty($column_cell['column_image']['id'])) :
									$this->add_render_attribute('column_image', 'src', $column_cell['column_image']['url']);
									$this->add_render_attribute('column_image', 'alt', Control_Media::get_image_alt($column_cell['column_image']));
									$this->add_render_attribute('column_image', 'title', Control_Media::get_image_title($column_cell['column_image']));
								?>
									<div class="mg-table--head-column-cell-icon">
										<?php echo Group_Control_Image_Size::get_attachment_image_html($column_cell, 'column_thumbnail', 'column_image'); ?>
									</div>
								<?php endif; ?>
							</div>
						</th>
					<?php endforeach; ?>
				</tr>
			</thead>

			<tbody class="mg-table--body">
				<?php for ($i = 0; $i < count($table_row); $i++) : ?>
					<tr class="mg-table--body-row">
						<?php
						for ($j = 0; $j < count($table_cell); $j++) :
							if ($table_row[$i]['id'] == $table_cell[$j]['row_id']) :
								$row_span_repeater_key = $this->get_repeater_setting_key('row_span', 'rows_data', $table_cell[$j]['row_id'] . $i . $j);
								$this->add_render_attribute($row_span_repeater_key, 'class', 'mg-table--body-row-cell');
								$this->add_render_attribute($row_span_repeater_key, 'class', 'elementor-repeater-item-' . $table_cell[$j]['repeater_id']);
								if (!empty($table_cell[$j]['row_column_span'])) {
									$this->add_render_attribute($row_span_repeater_key, 'colspan', $table_cell[$j]['row_column_span']);
								}
								if (!empty($table_cell[$j]['row_span'])) {
									$this->add_render_attribute($row_span_repeater_key, 'rowspan', $table_cell[$j]['row_span']);
								}

								// link
								if (!empty($table_cell[$j]['cell_link']['url'])) {
									$row_link_key = $this->get_repeater_setting_key('cell_link', 'rows_data', $table_cell[$j]['row_id'] . $i . $j);
									$this->add_link_attributes($row_link_key, $table_cell[$j]['cell_link']);
								}
						?>
								<td <?php echo $this->get_render_attribute_string($row_span_repeater_key); ?>>
									<div class="mg-table--body-row-cell-wrap">
										<div class="mg-table--body-row-cell-text">
											<?php if (!empty($table_cell[$j]['cell_link']['url'])) : ?>
												<a <?php $this->print_render_attribute_string($row_link_key); ?>>
													<?php echo mg_kses_tags($table_cell[$j]['title']);  ?>
												</a>
											<?php else :
												echo mg_kses_tags($table_cell[$j]['title']);
											endif;
											?>
										</div>

										<?php if (!empty($table_cell[$j]['row_icons'])) : ?>
											<div class="mg-table--body-row-cell-icon">
												<?php Icons_Manager::render_icon($table_cell[$j]['row_icons']); ?>
											</div>
										<?php endif; ?>

										<?php
										if (!empty($table_cell[$j]['row_image']['url']) || !empty($table_cell[$j]['row_image']['id'])) :
											$image = wp_get_attachment_image_url($table_cell[$j]['row_image']['id'], $table_cell[$j]['row_thumbnail_size']);
											if (!$image) {
												$image = $table_cell[$j]['row_image']['url'];
											}
										?>
											<div class="mg-table--body-row-cell-icon">
												<img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($table_cell[$j]['title']); ?>">
											</div>
										<?php endif; ?>
									</div>
								</td>
						<?php
							endif;
						endfor;
						?>
					</tr>
				<?php endfor; ?>
			</tbody>
		</table>

<?php
	}
}
