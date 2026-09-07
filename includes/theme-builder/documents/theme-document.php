<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Base document for all Magical Theme Builder templates.
 *
 * @package    Magical_Addons
 * @subpackage Theme_Builder
 */

if ( ! class_exists( 'MgTB_Document' ) ) {

	abstract class MgTB_Document extends \Elementor\Core\Base\Document {

		/**
		 * Theme location this document renders in.
		 *
		 * @return string
		 */
		protected static function get_location() {
			return '';
		}

		/**
		 * Top level condition group for this document type.
		 *
		 * @return string
		 */
		protected static function get_condition_type() {
			return 'general';
		}

		public static function get_properties() {
			$properties = parent::get_properties();

			$properties['location']        = static::get_location();
			$properties['condition_type']  = static::get_condition_type();
			$properties['support_kit']     = true;
			$properties['show_in_finder']  = true;
			$properties['support_conditions'] = true;

			// Let Elementor honor _wp_page_template (canvas / full width) for
			// the editor preview and direct template previews.
			$properties['support_wp_page_templates'] = true;

			return $properties;
		}

		public static function get_title() {
			return __( 'Theme Template', 'magical-addons-for-elementor' );
		}

		public static function get_icon() {
			return 'eicon-theme-builder';
		}

		/**
		 * Editor settings: preview content selector for single templates.
		 */
		protected function register_controls() {
			parent::register_controls();

			if ( ! $this->supports_preview_settings() ) {
				return;
			}

			$this->start_controls_section(
				'mgtb_preview_settings',
				[
					'label' => __( 'Preview Settings', 'magical-addons-for-elementor' ),
					'tab'   => \Elementor\Controls_Manager::TAB_SETTINGS,
				]
			);

			$this->add_control(
				'preview_id',
				[
					'label'       => __( 'Preview With', 'magical-addons-for-elementor' ),
					'type'        => \Elementor\Controls_Manager::SELECT2,
					'options'     => $this->get_preview_id_options(),
					'description' => __( 'Choose which existing content the editor should preview this template with.', 'magical-addons-for-elementor' ),
				]
			);

			$this->end_controls_section();
		}

		/**
		 * Whether this document type offers "Preview With" content.
		 */
		protected function supports_preview_settings() {
			return false;
		}

		/**
		 * Latest items of the previewed post type for the Preview With select.
		 *
		 * @return array id => title
		 */
		protected function get_preview_id_options() {
			$post_type = method_exists( $this, 'get_preview_post_type' ) ? $this->get_preview_post_type() : 'post';

			$posts = get_posts( [
				'post_type'      => $post_type,
				'posts_per_page' => 30,
				'post_status'    => 'publish',
				'fields'         => 'ids',
			] );

			$options = [];
			foreach ( $posts as $post_id ) {
				$options[ $post_id ] = get_the_title( $post_id ) . ' (#' . $post_id . ')';
			}

			return $options;
		}

		/**
		 * Render with the preview query while editing.
		 */
		public function get_content( $with_css = false ) {
			return mg_tb()->preview->wrap( $this, function () use ( $with_css ) {
				return \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $this->get_main_id(), $with_css );
			} );
		}

		public function get_elements_raw_data( $data = null, $with_html_content = false ) {
			return mg_tb()->preview->wrap( $this, function () use ( $data, $with_html_content ) {
				return parent::get_elements_raw_data( $data, $with_html_content );
			} );
		}

		public function render_element( $element_data ) {
			return mg_tb()->preview->wrap( $this, function () use ( $element_data ) {
				return parent::render_element( $element_data );
			} );
		}

		/**
		 * Print the template content on the frontend.
		 */
		public function print_content() {
			if ( \Elementor\Plugin::instance()->preview->is_preview_mode() ) {
				echo \Elementor\Plugin::instance()->preview->builder_wrapper( '' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} else {
				echo $this->get_content(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		/**
		 * Editor "Preview" button opens a matching real page with the template forced.
		 */
		public function get_wp_preview_url() {
			return mg_tb()->preview->get_preview_url( $this );
		}

		public function get_container_attributes() {
			$attrs = parent::get_container_attributes();

			$attrs['data-mgtb-location'] = static::get_location();

			return $attrs;
		}

		public function is_template() {
			return true;
		}
	}
}
