<?php

/**
 * WordPress settings API demo class
 *
 * @author Tareq Hasan
 */
if (!class_exists('mgAdmin_Info_Items')) :
    class mgAdmin_Info_Items
    {

        private $settings_api;

        function __construct()
        {
            $this->settings_api = new WeDevs_Settings_API();
            //  add_action('wsa_form_top_magical_tabs_welcome', [$this, 'magical_welcome_tabs']);
            add_action('admin_init', array($this, 'admin_init'));
            add_action('admin_menu', array($this, 'admin_menu'));
            add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        }

        function admin_init()
        {

            //set the settings
            $this->settings_api->set_sections($this->get_settings_sections());
            $this->settings_api->set_fields($this->get_settings_fields());

            //initialize settings
            $this->settings_api->admin_init();
        }

        function admin_menu()
        {
            //add_options_page( 'Settings API', 'Settings API', 'delete_posts', 'settings_api_test', array($this, 'plugin_page') );
            add_menu_page(esc_html__('Magical Addons', 'magical-addons-for-elementor'), esc_html__('Magical Addons', 'magical-addons-for-elementor'), 'edit_pages', 'magical-addons', array($this, 'plugin_page'), esc_url(MAGICAL_ADDON_URL . 'assets/img/mg-icons.png'), 60);
        }

        function get_settings_sections()
        {
            $sections = array(
                /*  array(
                'id'    => 'magical_tabs_welcome',
                'title' => __( 'Home', 'magical-addons-for-elementor' )
            ),*/
                array(
                    'id'    => 'magical_addons',
                    'title' => __('Free Widgets', 'magical-addons-for-elementor')
                ),
                array(
                    'id'    => 'magical_addons_pro',
                    'title' => __('Pro Widgets', 'magical-addons-for-elementor')
                ),
                array(
                    'id'    => 'magical_headerfooter',
                    'title' => __('Header & Footer', 'magical-addons-for-elementor')
                ),
                array(
                    'id'    => 'magical_extra',
                    'title' => __('Extra', 'magical-addons-for-elementor')
                )
            );
            return $sections;
        }

        /**
         * Returns all the settings fields
         *
         * @return array settings fields
         */
        function get_settings_fields()
        {
            $settings_fields = array(
                //    'magical_tabs_welcome' => array(),

                'magical_addons' => array(
                    array(
                        'name'  => 'mg_content_head',
                        'label'  => __('Magical Free Widgets', 'magical-addons-for-elementor'),
                        'desc'  => __('Here is the list of our all widgets. You can enable or disable widgets from here. After enabling or disabling any widget make sure to click the Save Changes button.', 'magical-addons-for-elementor'),
                        'type'  => 'text',
                        'class' => 'mgaddons_checkhead',
                    ),
                    array(
                        'name'  => 'mg_slider',
                        'label'  => __('MG Slider', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_postgrid',
                        'label'  => __('MG Posts Grid', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_postlist',
                        'label'  => __('MG Posts List', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_sec_title',
                        'label'  => __('MG Section Title', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_infobox',
                        'label'  => __('MG Info Box', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_card',
                        'label'  => __('MG Card', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_hover_card',
                        'label'  => __('MG Hover Card', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_pricing_table',
                        'label'  => __('MG Pricing Table', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_tabs',
                        'label'  => __('MG Tabs', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_countdown',
                        'label'  => __('MG Countdown', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_dual_heading',
                        'label'  => __('MG Dual Heading', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_text_effects',
                        'label'  => __('MG Text Effects', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_team_members',
                        'label'  => __('MG Team Members', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_timeline',
                        'label'  => __('MG Timeline', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_accordion',
                        'label'  => __('MG Accordion', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_aboutme',
                        'label'  => __('MG About Me', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_progressbar',
                        'label'  => __('MG Progressbar', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_blockquote',
                        'label'  => __('MG Blockquote', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_video_card',
                        'label'  => __('MG Video Card', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_cf7',
                        'label'  => __('MG Contact Form 7', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_wpforms',
                        'label'  => __('MG WPForms', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_sharebtn',
                        'label'  => __('MG Share Buttons', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_piechart',
                        'label'  => __('MG Pie Chart', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_img_comparison',
                        'label'  => __('MG Image Comparison', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_imgaccordion',
                        'label'  => __('MG Image Accordion', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_content_reveal',
                        'label'  => __('MG Content Reveal', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_flipbox',
                        'label'  => __('MG Flipbox', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_dualbtn',
                        'label'  => __('MG Dual Button', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_iconlist',
                        'label'  => __('MG Icon List', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_imgsmooth_scroll',
                        'label'  => __('MG Image Smooth Scroll', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_infolist',
                        'label'  => __('MG Info List', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_etemplate',
                        'label'  => __('MG Elementor Template', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_scroll_top',
                        'label'  => __('MG Scroll To Top', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_site_logo',
                        'label'  => __('MG Website Logo', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_cattag_list',
                        'label'  => __('MG Categories Or Tags List', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_searchbar',
                        'label'  => __('MG Search Bar', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_navmenu',
                        'label'  => __('MG Nav Menu', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_data_table',
                        'label'  => __('MG Data Table', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_mailchimp',
                        'label'  => __('MG MailChimp', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mg_skillbar',
                        'label'  => __('MG Skillbar', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                ),
                'magical_addons_pro' => array(
                    array(
                        'name'  => 'mg_pro_head',
                        'label'  => __('Magical Pro Widgets', 'magical-addons-for-elementor'),
                        'desc'  => __('Here is the list of our all widgets. You can enable or disable widgets from here. After enabling or disabling any widget make sure to click the Save Changes button.', 'magical-addons-for-elementor'),
                        'type'  => 'text',
                        'class' => 'mgaddons_checkhead',
                    ),
                    array(
                        'name'  => 'mgp_lottie',
                        'label'  => __('MG Lottie Animation', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mgp_hotspot',
                        'label'  => __('MG Image Hotspots', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mgp_filter',
                        'label'  => __('MG Filter/Portfolio Gallery', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mgp_tcarosuel',
                        'label'  => __('MG Testimonial Carousel', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mgp_counter',
                        'label'  => __('MG Counter', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mgp_infocarousel',
                        'label'  => __('MG InfoBox Carousel', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mgp_adticker',
                        'label'  => __('MG Advanced Ticker', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mgp_adticker',
                        'label'  => __('MG Content Switcher', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mgp_photobunch',
                        'label'  => __('MG Photo Bunch', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mgp_barchart',
                        'label'  => __('MG Bar Chart', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mgp_pdfview',
                        'label'  => __('MG PDF View', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mgp_price_comp',
                        'label'  => __('MG Price Comparison', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mgp_nav_onepage',
                        'label'  => __('MG One Page Nav', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mgp_off_canvas',
                        'label'  => __('MG Off Canvas', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mgp_promobox',
                        'label'  => __('MG Promo Box', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mgp_pricemenu',
                        'label'  => __('MG Price Menu', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mgp_animatedh',
                        'label'  => __('MG Animated Heading', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mgp_popup',
                        'label'  => __('MG Modal/Popup', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),
                    array(
                        'name'  => 'mgp_ajsearch',
                        'label'  => __('MG ajax Search', 'magical-addons-for-elementor'),
                        'type'  => 'checkbox',
                        'default' => 'on',
                        'class' => 'mgaddons_checkbox',
                    ),

                ),
                'magical_headerfooter' => array(

                    array(
                        'name'  => 'mg_header_template',
                        'label'  => __('Select Header Template', 'magical-addons-for-elementor'),
                        'desc'  => magical_el_template_list_desc('Header Template?', 'https://www.youtube.com/watch?v=qOCqMaPNads'),
                        'type'       => 'select',
                        'options'    => mg_elementor_template_list(__('Default Theme Header', 'magical-addons-for-elementor')),
                    ),
                    array(
                        'name'  => 'mg_footer_template',
                        'label'  => __('Select Footer Template', 'magical-addons-for-elementor'),
                        'desc'  =>  magical_el_template_list_desc('Footer Template?', 'https://www.youtube.com/watch?v=qOCqMaPNads&t=153s'),
                        'type'       => 'select',
                        'options'    => mg_elementor_template_list(__('Default Theme Footer', 'magical-addons-for-elementor')),
                    ),
                ),
                'magical_extra' => array(
                    array(
                        'name'  => 'mg_mailchimp_api', // Corrected spelling
                        'label'  => __('Mailchimp API Key', 'magical-addons-for-elementor'),
                        'desc'  => sprintf(
                            // translators: %s is the URL to the Mailchimp API key documentation
                            __('Insert your Mailchimp API key. See article <a href="%s" target="_blank">How to get my Mailchimp API key</a>', 'magical-addons-for-elementor'),
                            esc_url('https://support.checkfront.com/hc/en-us/articles/115004180154-Introduction-to-Mailchimp-and-API-Keys')
                        ),
                        'type'  => 'text',
                    ),
                ),


            );

            return $settings_fields;
        }
        // General tab
        /* function magical_welcome_tabs()
        {
            ob_start();
            include MAGICAL_ADDON_PATH . '/includes/admin/admin-pages/welcome-page.php';
            echo ob_get_clean();
        } */
        function magical_welcome_tabs()
        {
            ob_start();
            include MAGICAL_ADDON_PATH . '/includes/admin/admin-pages/welcome-page.php';
            $output = ob_get_clean();
            echo wp_kses_post($output);
        }

        /**
         * Enqueue React admin assets
         */
        public function enqueue_admin_assets($hook)
        {
            // Only load on our admin page
            if ('toplevel_page_magical-addons' !== $hook) {
                return;
            }

            $asset_file = MAGICAL_ADDON_PATH . 'assets/admin-react/build/index.asset.php';
            
            // Check if React build exists
            if (!file_exists($asset_file)) {
                // Fallback to legacy admin if React build not available
                $this->plugin_page_legacy();
                return;
            }

            $asset = require $asset_file;
            $build_url = MAGICAL_ADDON_URL . 'assets/admin-react/build/';

            // Enqueue React app styles
            wp_enqueue_style(
                'magical-addons-admin-react',
                $build_url . 'index.css',
                array('wp-components'),
                $asset['version']
            );

            // Enqueue React app script
            wp_enqueue_script(
                'magical-addons-admin-react',
                $build_url . 'index.js',
                $asset['dependencies'],
                $asset['version'],
                true
            );

            // Get all editable roles for Role Manager
            $editable_roles = get_editable_roles();
            $roles = array();
            foreach ($editable_roles as $role_slug => $role_info) {
                if ($role_slug !== 'administrator') {
                    $roles[$role_slug] = $role_info['name'];
                }
            }

            // Localize script with data needed by React app
            wp_localize_script(
                'magical-addons-admin-react',
                'magicalAddonsData',
                array(
                    'restUrl'     => esc_url_raw(rest_url('magical-addons/v1/')),
                    'nonce'       => wp_create_nonce('wp_rest'),
                    'isPro'       => class_exists('magicalAddonsProMain'),
                    'version'     => defined('MAGICAL_ADDON_VERSION') ? MAGICAL_ADDON_VERSION : '1.0.0',
                    'roles'       => $roles,
                    'adminUrl'    => admin_url(),
                    'pluginUrl'   => MAGICAL_ADDON_URL,
                    'proUrl'      => 'https://wpthemespace.com/product/magical-addons-pro/',
                    'docsUrl'     => 'https://developer.developer/#',
                    'supportUrl'  => 'https://developer.developer/#',
                )
            );

            // Set script translations
            wp_set_script_translations(
                'magical-addons-admin-react',
                'magical-addons-for-elementor',
                MAGICAL_ADDON_PATH . 'languages'
            );
        }

        /**
         * Render React admin page
         */
        function plugin_page()
        {
            $asset_file = MAGICAL_ADDON_PATH . 'assets/admin-react/build/index.asset.php';
            
            // Check if React build exists, fallback to legacy if not
            if (!file_exists($asset_file)) {
                $this->plugin_page_legacy();
                return;
            }

            $is_pro = class_exists('magicalAddonsProMain');
            $wrap_class = $is_pro ? 'mghas-pro' : 'mghas-onlyfree';
            
            echo '<div id="magical-addons-root" class="magical-admin-wrap ' . esc_attr($wrap_class) . '"></div>';
        }

        /**
         * Legacy plugin page (fallback when React build not available)
         */
        function plugin_page_legacy()
        {
            if (class_exists('magicalAddonsProMain')) {
                echo '<div class="wrap magical-addons-page mghas-pro">';
            } else {
                echo '<div class="wrap magical-addons-page mghas-onlyfree">';
            }

            $this->magical_welcome_tabs();
            $this->settings_api->show_navigation();
            $this->settings_api->show_forms();

            echo '</div>';
        }

        /**
         * Get all the pages
         *
         * @return array page names with key value pairs
         */
        function get_pages()
        {
            $pages = get_pages();
            $pages_options = array();
            if ($pages) {
                foreach ($pages as $page) {
                    $pages_options[$page->ID] = $page->post_title;
                }
            }

            return $pages_options;
        }
    }
endif;

new mgAdmin_Info_Items();
