<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Site Title theme widget.
 *
 * @package    Magical_Addons
 * @subpackage Theme_Builder
 */

if ( ! class_exists( 'MgTB_Widget_Site_Title' ) ) {

	class MgTB_Widget_Site_Title extends \Elementor\Widget_Base {

		public function get_name() {
			return 'mgtb-site-title';
		}

		public function get_title() {
			return __( 'Site Title', 'magical-addons-for-elementor' );
		}

		public function get_icon() {
			return 'eicon-site-title';
		}

		public function get_categories() {
			return [ 'magical', 'mg-theme-elements' ];
		}

		public function get_keywords() {
			return [ 'site', 'title', 'name', 'brand', 'logo text' ];
		}

		protected function register_controls() {
			$this->start_controls_section(
				'section_content',
				[ 'label' => __( 'Site Title', 'magical-addons-for-elementor' ) ]
			);

			$this->add_control(
				'html_tag',
				[
					'label'   => __( 'HTML Tag', 'magical-addons-for-elementor' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'default' => 'h1',
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

			$this->add_control(
				'link_to_home',
				[
					'label'        => __( 'Link to Homepage', 'magical-addons-for-elementor' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'default'      => 'yes',
					'return_value' => 'yes',
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
						'{{WRAPPER}} .mgtb-site-title' => 'text-align: {{VALUE}};',
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
						'{{WRAPPER}} .mgtb-site-title, {{WRAPPER}} .mgtb-site-title a' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name'     => 'typography',
					'selector' => '{{WRAPPER}} .mgtb-site-title',
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Text_Shadow::get_type(),
				[
					'name'     => 'text_shadow',
					'selector' => '{{WRAPPER}} .mgtb-site-title',
				]
			);

			$this->end_controls_section();
		}

		protected function render() {
			$settings = $this->get_settings_for_display();
			$tag      = \Elementor\Utils::validate_html_tag( $settings['html_tag'] );
			$title    = get_bloginfo( 'name' );
			?>
			<<?php echo esc_html( $tag ); ?> class="mgtb-site-title elementor-heading-title">
				<?php if ( 'yes' === $settings['link_to_home'] ) : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $title ); ?></a>
				<?php else : ?>
					<?php echo esc_html( $title ); ?>
				<?php endif; ?>
			</<?php echo esc_html( $tag ); ?>>
			<?php
		}
	}
}
