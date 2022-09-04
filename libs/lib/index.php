<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

if (!class_exists('Magcial_Addon_Cloud_Library')) {

	class Magcial_Addon_Cloud_Library
	{

		private static $_instance = null;
		static $plugin_data = null;
		static public function init()
		{

			if (is_null(self::$_instance)) {
				self::$_instance = new self();
				self::$_instance->include_files();
			}
			return self::$_instance;
		}

		private function __construct()
		{

			self::$plugin_data = array(
				'root_file' =>  __FILE__,
				'pro-link' => 'https://magic.wpcolors.net/pricing-plan/#mgpricing',
				'remote_site' => 'https://magic.wpcolors.net/',
				'remote_page_site' => 'https://magic.wpcolors.net/',
				'widget' => 'mg-items',
				'mgaddon_import_data' => 'mg-widget'
			);

			add_action('elementor/editor/before_enqueue_scripts', array($this, 'editor_script'));
			add_action('wp_ajax_process_ajax', array($this, 'ajax_data'));
			add_action('wp_ajax_xl_tab_reload_template', array($this, 'reload_library'));
		}

		public function __clone()
		{

			_doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?', 'xlmega'), '1.0.0');
		}

		public function __wakeup()
		{

			_doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?', 'xlmega'), '1.0.0');
		}

		public function include_files()
		{

			require __DIR__ . '/inc/import.php';
		}

		public function editor_script()
		{

			wp_enqueue_script('mg-elibrary',  plugins_url('/assets/js/elementor-manage-library.js', __FILE__), ['jquery']);
			wp_localize_script('mg-elibrary', 'mg_lib_params', [
				'site' => site_url(),
			]);
			wp_enqueue_script('masonry');
			wp_enqueue_style('mgaddon_lib',  plugins_url('/assets/css/style.css', __FILE__));
		}

		function reload_library()
		{
			Magcial_Addon_Activation_Class::init();
			die();
		}

		function choose_option_table($table_name)
		{

			if ($table_name == 'element') {
				$out = 'widget';
			} elseif ($table_name == 'section') {
				$out = 'section';
			} elseif ($table_name == 'header-footer') {
				$out = 'header_footer';
			} elseif ($table_name == 'theme-builder') {
				$out = 'themebuilder';
			} else {
				$out = 'pages';
			}
			return $out;
		}

		function ajax_data()
		{
			$direct_data = json_decode(wp_remote_retrieve_body(wp_remote_get(self::$plugin_data['remote_site'] . '/wp-json/mg/v1/' . self::$plugin_data['widget'] . '/')), true);

			$option_type = $this->choose_option_table($_POST['data']['type']);
			$nav = '';
			$data = get_option('mgaddon_ready_items');

			if ($data) {
				$products = $data[$option_type];
			} else {
				$products = $direct_data[$option_type];
			}


			if (is_array($products)) {

				$category = isset($_POST['data']['category']) ? $_POST['data']['category'] : '';
				$page_number = esc_attr($_POST['data']['page']);
				$search = isset($_POST['data']['search']) ? $_POST['data']['search'] : '';
				$limit = 30;
				$offset = 0;

				$current_page = 1;
				if (isset($page_number)) {
					$current_page = (int)$page_number;
					$offset = ($current_page * $limit) - $limit;
				}
				$search_filter = strtolower($search);
				//$paged = $total_products > count($paged_products) ? true : false;

				if (!empty($search_filter)) {
					$filtered_products = array();
					foreach ($products as $product) {
						if (!empty($search_filter)) {
							if (preg_match("/{$search_filter}/", strtolower($product['name']))) {
								$filtered_products[] = $product;
							}
						}
					}

					$products = $filtered_products;
				}

				$paged_products = array_slice($products, $offset, $limit);
				$total_products = count($products);
				$total_pages = is_float($total_products / $limit) ? intval($total_products / $limit) + 1 : $total_products / $limit;

				//echo '<div class="filter-wrap"><a data-cat="" href="#">All</a>'.$nav.'</div>';
				echo '<div class="item-inner">';
				echo '<div class="item-wrap">';
				if (count($paged_products)) {
					foreach ($paged_products as $product) {
						$pro = $product['pro'] ? '<span class="pro">pro</span>' : '';
						$parent_site = substr($product['thumb'], 0, strpos($product['thumb'], 'wp-content'));
						if ($product['pro'] && !class_exists('magicalAddonsProMain')) {

							$btn = '<a target="_blank" href="' . self::$plugin_data['pro-link'] . '" class="buy-tmpl"><i class="eicon-external-link-square"></i> Buy pro</a>';
						} else {
							$btn = '<a href="#" data-parentsite="' . $parent_site . '" data-id="' . $product['id'] . '" class="insert-tmpl"><i class="eicon-file-download"></i> Insert</a>';
						}


?>
						<div class="item">
							<div class="product">
								<div data-preview='<?php echo esc_attr($product['preview']); ?>' class='lib-img-wrap'>
									<?php echo $pro; ?>
									<img src="<?php echo esc_url($product['thumb']); ?>">
									<i class="eicon-zoom-in-bold"></i>
								</div>
								<div class='lib-footer'>
									<p class="lib-name"><?php echo esc_html($product['name']); ?></p>
									<?php echo wp_kses_post($btn); ?>
								</div>

							</div>
						</div>

						<?php }
					if ($total_pages > 1) {
						echo '</div><div class="pagination-wrap"><ul>';
						for ($page_number = 1; $page_number <= $total_pages; $page_number++) { ?>
							<li class="page-item <?php echo $_POST['data']['page'] == $page_number ? 'active' : ''; ?>"><a class="page-link" href="#" data-page-number="<?php echo esc_attr($page_number); ?>"><?php echo esc_html($page_number); ?></a></li>

<?php }
						echo '</ul></div></div>';
					}
				} else {
					$mgnot_template_found = esc_html__('No template found', 'magical-addons-for-elementor');
					echo '<h3 class="no-found">' . $mgnot_template_found . '</h3>';
				}
				die();
			}
		}
	}

	Magcial_Addon_Cloud_Library::init();
}
