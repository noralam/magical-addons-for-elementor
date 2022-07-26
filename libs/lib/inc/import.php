<?php

namespace Elementor\TemplateLibrary;

if (!defined('ABSPATH')) {
	exit;
}
if (did_action('elementor/loaded')) {
	class Magcial_Addon_Import_Library  extends Source_Base
	{

		public function __construct()
		{
			parent::__construct();
			add_action('wp_ajax_magical_addon_import_template', array($this, 'xl_tab_import_data'));
		}

		public function get_id()
		{
		}
		public function get_title()
		{
		}
		public function register_data()
		{
		}
		public function get_items($args = [])
		{
		}
		public function get_item($template_id)
		{
		}
		public function get_data(array $args)
		{
		}
		public function delete_template($template_id)
		{
		}
		public function save_item($template_data)
		{
		}
		public function update_item($new_data)
		{
		}
		public function export_template($template_id)
		{
		}

		public function xl_tab_import_data()
		{

			$id = esc_attr($_POST['id']);
			$remote = esc_url($_POST['parent_site']);
			$end_point = \Magcial_Addon_Cloud_Library::$plugin_data["mgaddon_import_data"];
			//	$data = json_decode(wp_remote_retrieve_body(wp_remote_get($remote . 'wp-json/mg/v1/' . $end_point . '/?id=' . $id)), true);
			$data = json_decode(wp_remote_retrieve_body(wp_remote_get($remote . 'wp-json/mg/v1/' . $end_point . '/?id=' .
				$id, ['timeout' => 120])), true);
			$content = $data['content'];
			$content = $this->process_export_import_content($content, 'on_import');
			$content = $this->replace_elements_ids($content);
			echo json_encode($content);
			wp_die();
		}
	}

	new Magcial_Addon_Import_Library();
}
