<?php

/**
 *  Magical addons widget init class
 */
class magicalWidgetInit
{

	function __construct()
	{
		add_action('elementor/widgets/register', [$this, 'mg_addons_widget_init']);
	}



	public function mg_addons_widget_init($widgets_manager)
	{



		if (mg_get_addons_option('mg_slider', 'on') == 'on') {
			wp_enqueue_style('swiper');
			wp_enqueue_style('swiper-style');
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/slider/mg-slider.php');
			$widgets_manager->register(new \MgAddon_slider_lite());
		}

		if (mg_get_addons_option('mg_postgrid', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/posts/posts-grid.php');
			$widgets_manager->register(new \mgPostGridWidget());
		}
		if (mg_get_addons_option('mg_postlist', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/posts/posts-list.php');
			$widgets_manager->register(new \mgPostListWidget());
		}
		if (mg_get_addons_option('mg_sec_title', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/section-title.php');
			$widgets_manager->register(new \MgAddonSectionTitle());
		}
		if (mg_get_addons_option('mg_infobox', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/infobox-widget.php');
			$widgets_manager->register(new \MgAddon_Info_Box());
		}
		if (mg_get_addons_option('mg_card', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/card-widget.php');
			$widgets_manager->register(new \MgAddon_Card_Widget());
		}
		if (mg_get_addons_option('mg_hover_card', 'on') == 'on') {
			wp_enqueue_style('mg-hover-card');
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/img-hover-card-widget.php');
			$widgets_manager->register(new \MgimgHover_Card_Widget());
		}
		if (mg_get_addons_option('mg_pricing_table', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/pricing-table-widget.php');
			$widgets_manager->register(new \MgAddon_Pricing_Table());
		}
		if (mg_get_addons_option('mg_tabs', 'on') == 'on') {
			wp_enqueue_style('mg-tabs');
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/tabs.php');
			$widgets_manager->register(new \MgAddon_Tabs());
		}
		if (mg_get_addons_option('mg_countdown', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/countdown-widget.php');
			$widgets_manager->register(new \MgCountdown());
		}

		if (mg_get_addons_option('mg_dual_heading', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/dual-heading-widget.php');
			$widgets_manager->register(new \MgAddon_Dual_Heading());
		}
		if (mg_get_addons_option('mg_text_effects', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/text-effects.php');
			$widgets_manager->register(new \MgAddon_text_effects());
		}
		if (mg_get_addons_option('mg_team_members', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/team-members-widget.php');
			$widgets_manager->register(new \MgAddon_Team_Member());
		}
		if (mg_get_addons_option('mg_timeline', 'on') == 'on') {
			wp_enqueue_style('mg-timeline');
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/timeline/timeline-widget.php');
			$widgets_manager->register(new \MgAddon_Timeline_Widget());
		}
		if (mg_get_addons_option('mg_accordion', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/accordion/accordion-widget.php');
			$widgets_manager->register(new \MgAccordion());
		}
		if (mg_get_addons_option('mg_aboutme', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/about-widget.php');
			$widgets_manager->register(new \MgAddon_About_Widget());
		}
		if (mg_get_addons_option('mg_progressbar', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/progressbar-widget.php');
			$widgets_manager->register(new \MgProgressbar());
		}

		if (mg_get_addons_option('mg_blockquote', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/qoute-widget.php');
			$widgets_manager->register(new \MgBlockquote());
		}
		if (mg_get_addons_option('mg_video_card', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/video-card.php');
			$widgets_manager->register(new \MgAddon_Video_Card());
		}
		if (mg_get_addons_option('mg_cf7', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/widget-cf7.php');
			$widgets_manager->register(new \MG_Addon_CF7());
		}
		if (mg_get_addons_option('mg_wpforms', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/wpforms-widget.php');
			$widgets_manager->register(new \MG_Addon_WPForm());
		}
		if (mg_get_addons_option('mg_sharebtn', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/share-buttons.php');
			$widgets_manager->register(new \MG_Addon_Sharebtn());
		}
		if (mg_get_addons_option('mg_piechart', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/piechart-widget.php');
			$widgets_manager->register(new \MG_AddonPieChart());
		}
		if (mg_get_addons_option('mg_img_comparison', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/image-comparison.php');
			$widgets_manager->register(new \MgAddon_imgComparison());
		}
		if (mg_get_addons_option('mg_imgaccordion', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/image-accordion.php');
			$widgets_manager->register(new \MgAddon_imgAccordion());
		}
		if (mg_get_addons_option('mg_content_reveal', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/content-reveal.php');
			$widgets_manager->register(new \MgAddon_contentReveal());
		}

		// Flip Box Widget
		if (mg_get_addons_option('mg_flipbox', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/flipbox-widget.php');
			$widgets_manager->register(new \MgAddon_Flip_Box());
		}
		// Call To Action Widget
		if (mg_get_addons_option('mg_flipbox', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/call-to-action.php');
			$widgets_manager->register(new \MgAddon_Call_To_Action());
		}
		if (mg_get_addons_option('mg_dualbtn', 'on') == 'on') {
			// Call To Action Widget
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/dual-button.php');
			$widgets_manager->register(new \MgAddon_Dual_Button());
		}
		if (mg_get_addons_option('mg_iconlist', 'on') == 'on') {
			// Feature List Widget
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/icon-list.php');
			$widgets_manager->register(new \MgAddon_Icon_List());
		}
		if (mg_get_addons_option('mg_imgsmooth_scroll', 'on') == 'on') {
			// Feature List Widget
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/image-smooth-scroll.php');
			$widgets_manager->register(new \MgAddon_imgSmoothScroll());
		}
		if (mg_get_addons_option('mg_infolist', 'on') == 'on') {
			// Feature List Widget
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/info-list.php');
			$widgets_manager->register(new \MgAddon_infoList());
		}
		if (mg_get_addons_option('mg_etemplate', 'on') == 'on') {
			// Feature List Widget
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/elementor-template.php');
			$widgets_manager->register(new \mg_ElementorTemplate());
		}
		if (mg_get_addons_option('mg_scroll_top', 'on') == 'on') {
			// Feature List Widget
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/scroll-top.php');
			$widgets_manager->register(new \mg_ScrollTop());
		}
		if (mg_get_addons_option('mg_site_logo', 'on') == 'on') {
			// Feature List Widget
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/site-logo.php');
			$widgets_manager->register(new \MG_Addon_siteLogo());
		}
		if (mg_get_addons_option('mg_cattag_list', 'on') == 'on') {
			// Feature List Widget
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/cattag-list.php');
			$widgets_manager->register(new \mgCatTag_List());
		}
		if (mg_get_addons_option('mg_searchbar', 'on') == 'on') {
			// Feature List Widget
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/search-bar.php');
			$widgets_manager->register(new \MG_Addon_SearchBar());
		}
		if (mg_get_addons_option('mg_navmenu', 'on') == 'on') {
			// Feature List Widget
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/nav-menu/nav-menu.php');
			$widgets_manager->register(new \MG_Addon_navMenu());
		}
		if (mg_get_addons_option('bk_project_details_widget', 'on') == 'on') {
			// project details Widget
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/project-details.php');
			$widgets_manager->register(new \BkProjectDetails());
		}
		if (mg_get_addons_option('mg_data_table', 'on') == 'on') {
			// Feature List Widget
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/data-table.php');
			$widgets_manager->register(new \mgDataTable());
		}
		if (mg_get_addons_option('mg_mailchimp', 'on') == 'on') {
			// Feature List Widget
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/mailchimp-widget.php');
			$widgets_manager->register(new \mgproMailchimp());
		}

		// banner Widget
		if (mg_get_addons_option('mg_mailchimp', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/banner.php');
			$widgets_manager->register(new \MgAddon_Banner());
		}

		// Advanced Skillbars
		if (mg_get_addons_option('mg_skillbar', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/advance-skill-bars.php');
			$widgets_manager->register(new \mgSkillBars());
		}
	}
}
