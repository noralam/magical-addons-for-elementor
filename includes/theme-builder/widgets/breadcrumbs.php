<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Breadcrumbs theme widget.
 *
 * Uses the theme breadcrumb when one exists, otherwise a simple fallback
 * trail (Home / Blog / Category / Post).
 *
 * @package    Magical_Addons
 * @subpackage Theme_Builder
 */

if ( ! class_exists( 'MgTB_Widget_Breadcrumbs' ) ) {

	class MgTB_Widget_Breadcrumbs extends \Elementor\Widget_Base {

		public function get_name() {
			return 'mgtb-breadcrumbs';
		}

		public function get_title() {
			return __( 'Breadcrumbs', 'magical-addons-for-elementor' );
		}

		public function get_icon() {
			return 'eicon-breadcrumb';
		}

		public function get_categories() {
			return [ 'magical', 'mg-theme-elements' ];
		}

		public function get_keywords() {
			return [ 'breadcrumbs', 'trail', 'navigation', 'path' ];
		}

		protected function register_controls() {
			$this->start_controls_section(
				'section_content',
				[ 'label' => __( 'Breadcrumbs', 'magical-addons-for-elementor' ) ]
			);

			$this->add_control(
				'separator',
				[
					'label'   => __( 'Separator', 'magical-addons-for-elementor' ),
					'type'    => \Elementor\Controls_Manager::TEXT,
					'default' => '/',
					'ai'      => [ 'active' => false ],
				]
			);

			$this->add_control(
				'show_current',
				[
					'label'        => __( 'Show Current Page', 'magical-addons-for-elementor' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'default'      => 'yes',
					'return_value' => 'yes',
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
				'text_color',
				[
					'label'     => __( 'Text Color', 'magical-addons-for-elementor' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgtb-breadcrumbs, {{WRAPPER}} .mgtb-breadcrumbs a' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'active_color',
				[
					'label'     => __( 'Current Page Color', 'magical-addons-for-elementor' ),
					'type'      => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mgtb-breadcrumbs .mgtb-breadcrumb-current' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name'     => 'typography',
					'selector' => '{{WRAPPER}} .mgtb-breadcrumbs',
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
						'{{WRAPPER}} .mgtb-breadcrumbs' => 'text-align: {{VALUE}};',
					],
				]
			);

			$this->end_controls_section();
		}

		/**
		 * Build the fallback breadcrumb trail items: [label, url|null].
		 *
		 * @return array
		 */
		private function get_trail() {
			$trail = [
				[
					'label' => __( 'Home', 'magical-addons-for-elementor' ),
					'url'   => home_url( '/' ),
				],
			];

			if ( is_singular() ) {
				$post_type = get_post_type();
				$post_type_object = get_post_type_object( $post_type );

				if ( 'post' === $post_type ) {
					$blog_page_id = (int) get_option( 'page_for_posts' );
					if ( $blog_page_id ) {
						$trail[] = [
							'label' => get_the_title( $blog_page_id ),
							'url'   => get_permalink( $blog_page_id ),
						];
					}

					$categories = get_the_category( get_the_ID() );
					if ( $categories ) {
						$trail[] = [
							'label' => $categories[0]->name,
							'url'   => get_category_link( $categories[0] ),
						];
					}
				} elseif ( 'page' === $post_type ) {
					$ancestors = array_reverse( get_post_ancestors( get_the_ID() ) );
					foreach ( $ancestors as $ancestor_id ) {
						$trail[] = [
							'label' => get_the_title( $ancestor_id ),
							'url'   => get_permalink( $ancestor_id ),
						];
					}
				} elseif ( $post_type_object && $post_type_object->has_archive ) {
					$trail[] = [
						'label' => $post_type_object->labels->name,
						'url'   => get_post_type_archive_link( $post_type ),
					];
				}

				$trail[] = [
					'label' => get_the_title(),
					'url'   => null,
				];
			} elseif ( is_archive() ) {
				$trail[] = [
					'label' => wp_strip_all_tags( get_the_archive_title() ),
					'url'   => null,
				];
			} elseif ( is_search() ) {
				$trail[] = [
					'label' => __( 'Search Results', 'magical-addons-for-elementor' ),
					'url'   => null,
				];
			}

			return $trail;
		}

		protected function render() {
			$settings  = $this->get_settings_for_display();
			$separator = ! empty( $settings['separator'] ) ? $settings['separator'] : '/';
			$show_current = ( 'yes' === $settings['show_current'] );

			// Prefer a theme breadcrumb implementation when available.
			if ( function_exists( 'breadcrumb_trail' ) ) {
				echo '<nav class="mgtb-breadcrumbs" aria-label="breadcrumb">';
				breadcrumb_trail();
				echo '</nav>';
				return;
			}

			$trail    = $this->get_trail();
			$last_key = count( $trail ) - 1;
			?>
			<nav class="mgtb-breadcrumbs" aria-label="breadcrumb">
				<?php foreach ( $trail as $key => $item ) : ?>
					<?php
					$is_last = ( $key === $last_key );
					if ( $is_last && ! $show_current ) {
						continue;
					}
					?>
					<?php if ( $key > 0 ) : ?>
						<span class="mgtb-breadcrumb-sep"><?php echo esc_html( $separator ); ?></span>
					<?php endif; ?>

					<?php if ( $item['url'] && ! $is_last ) : ?>
						<a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
					<?php else : ?>
						<span class="mgtb-breadcrumb-current" aria-current="page"><?php echo esc_html( $item['label'] ); ?></span>
					<?php endif; ?>
				<?php endforeach; ?>
			</nav>
			<?php
		}
	}
}
