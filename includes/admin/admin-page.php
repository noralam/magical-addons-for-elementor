<?php

/**
 * WordPress settings API demo class
 *
 * @author Tareq Hasan
 */
if (!class_exists('WeDevs_Settings_API_Test')) :
    class WeDevs_Settings_API_Test
    {

        private $settings_api;

        function __construct()
        {
            $this->settings_api = new WeDevs_Settings_API();
            //  add_action('wsa_form_top_magical_tabs_welcome', [$this, 'magical_welcome_tabs']);
            add_action('admin_init', array($this, 'admin_init'));
            add_action('admin_menu', array($this, 'admin_menu'));
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
            add_menu_page(esc_html__('Magical Addons', 'magical-addons-for-elementor'), esc_html__('Magical Addons', 'magical-addons-for-elementor'), 'delete_posts', 'magical-addons', array($this, 'plugin_page'), esc_url(MAGICAL_ADDON_URL . 'assets/img/mg-icons.png'), 60);
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
                    'title' => __('Addons', 'magical-addons-for-elementor')
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
                        'label'  => __('Magical Widgets', 'magical-addons-for-elementor'),
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
                'magical_extra' => array(
                    array(
                        'name'  => 'mg_mailchamp_api',
                        'label'  => __('MailChamp API key', 'magical-addons-for-elementor'),
                        'desc'  => sprintf(__('Insert your MailChamp API key. See artical <a href="%s" target="_blank">How to get my MailChamp API key</a>', 'magical-addons-for-elementor'), 'https://support.checkfront.com/hc/en-us/articles/115004180154-Introduction-to-Mailchimp-and-API-Keys'),
                        'type'  => 'text',
                    ),
                ),

            );

            return $settings_fields;
        }
        // General tab
        function magical_welcome_tabs()
        {
            ob_start();
            include MAGICAL_ADDON_PATH . '/includes/admin/admin-pages/welcome-page.php';
            echo ob_get_clean();
        }

        function plugin_page()
        {
            echo '<div class="wrap magical-addons-page">';

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

new WeDevs_Settings_API_Test();
