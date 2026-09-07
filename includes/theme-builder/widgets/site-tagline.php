<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Site Tagline theme widget.
 *
 * @package    Magical_Addons
 * @subpackage Theme_Builder
 */

if ( ! class_exists( 'MgTB_Widget_Site_Tagline' ) ) {

	class MgTB_Widget_Site_Tagline extends \Elementor\Widget_Base {

		public function get_name() {
			return 'mgtb-site-tagline';
		}

		public function get_title() {
			return __( 'Site Tagline', 'magical-addons-for-elementor' );
		}

		public function get_icon() {
			return 'eicon-site-tagline';
		}

		public function get_categories() {
			return [ 'magical', 'mg-theme-elements' ];
		}

		public function get_keywords() {
			return [ 'tagline', 'description', 'site', 'subtitle' ];
		}

		protected function register_controls() {
			$this->start_controls_section(
				'section_content',
				[ 'label' => __( 'Site Tagline', 'magical-addons-for-elementor' ) ]
			);

			$this->add_control(
				'html_tag',
				[
					'label'   => __( 'HTML Tag', 'magical-addons-for-elementor' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'default' => 'p',
					'options' => [
						'h1'   => 'H1',
						'h2'   => 'H2',
						'h3'   => 'H3',
						'h4'   => 'H4',
						'h5'   => 'H5',
						'h6'   => 'H6',
						'div'  => 'div',
						'span' => 'span',
						'p'    => 'p',
					],
				]
			);

			$this->add_responsive_control(
				'align',
				[
					'label'     => __( 'Alignment', 'magical-addons-for-elementor' ),
					'type'      => \Elementor\Controls_Manager::CHOOSE,
					'options'   => [
						'left'   => [ 'title' => __( 'Left', 'magical-addons-for-elementor' ), 'icon' => 'eicon-text-align-left' ],
						'center' => [ 'title' => __( 'Center', 'magical-addons-for-elementor' ), 'icon' => 'eicon-text-align-center' ],
						'right'  => [ 'title' => __( 'Right', 'magical-addons-for-elementor' ), 'icon' => 'eicon-text-align-right' ],
					],
					'selectors' => [
						'{{WRAPPER}} .mgtb-site-tagline' => 'text-align: {{VALUE}};',
					],
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'section_style',
				[
					'label' => __( 'Style', 'magical-addons-for-elementor' ),
					'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_control(
				'color',
				[
					'label'     => __( 'Text Color', 'magical-addons-for-elementor' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgtb-site-tagline' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name'     => 'typography',
					'selector' => '{{WRAPPER}} .mgtb-site-tagline',
				]
			);

			$this->end_controls_section();
		}

		protected function render() {
			$settings = $this->get_settings_for_display();
			$tag      = \Elementor\Utils::validate_html_tag( $settings['html_tag'] );
			?>
			<<?php echo esc_html( $tag ); ?> class="mgtb-site-tagline">
				<?php echo esc_html( get_bloginfo( 'description' ) ); ?>
			</<?php echo esc_html( $tag ); ?>>
			<?php
		}
	}
}
