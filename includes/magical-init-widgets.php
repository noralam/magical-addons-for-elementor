<?php

/**
 *  Magical addons widget init class
 */
class magicalWidgetInit
{

	public static function mg_addons_widget_init()
	{



		if (mg_get_addons_option('mg_slider', 'on') == 'on') {
			wp_enqueue_style('swiper');
			wp_enqueue_style('swiper-style');
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/slider/mg-slider.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \MgAddon_slider_lite());
		}

		if (mg_get_addons_option('mg_postgrid', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/posts/posts-grid.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \mgPostGridWidget());
		}
		if (mg_get_addons_option('mg_postlist', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/posts/posts-list.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \mgPostListWidget());
		}
		if (mg_get_addons_option('mg_sec_title', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/section-title.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \MgAddonSectionTitle());
		}
		if (mg_get_addons_option('mg_infobox', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/infobox-widget.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \MgAddon_Info_Box());
		}
		if (mg_get_addons_option('mg_card', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/card-widget.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \MgAddon_Card_Widget());
		}
		if (mg_get_addons_option('mg_hover_card', 'on') == 'on') {
			wp_enqueue_style('mg-hover-card');
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/img-hover-card-widget.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \MgimgHover_Card_Widget());
		}
		if (mg_get_addons_option('mg_pricing_table', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/pricing-table-widget.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \MgAddon_Pricing_Table());
		}
		if (mg_get_addons_option('mg_tabs', 'on') == 'on') {
			wp_enqueue_style('mg-tabs');
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/tabs.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \MgAddon_Tabs());
		}
		if (mg_get_addons_option('mg_countdown', 'on') == 'on') {
			wp_enqueue_style('flipclock');
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/countdown-widget.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \MgCountdown());
		}

		if (mg_get_addons_option('mg_dual_heading', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/dual-heading-widget.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \MgAddon_Dual_Heading());
		}
		if (mg_get_addons_option('mg_text_effects', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/text-effects.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \MgAddon_text_effects());
		}
		if (mg_get_addons_option('mg_team_members', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/team-members-widget.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \MgAddon_Team_Member());
		}
		if (mg_get_addons_option('mg_timeline', 'on') == 'on') {
			wp_enqueue_style('mg-timeline');
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/timeline/timeline-widget.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \MgAddon_Timeline_Widget());
		}
		if (mg_get_addons_option('mg_accordion', 'on') == 'on') {
			wp_enqueue_style('mg-accordion');
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/accordion/accordion-widget.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \MgAccordion());
		}
		if (mg_get_addons_option('mg_aboutme', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/about-widget.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \MgAddon_About_Widget());
		}
		if (mg_get_addons_option('mg_progressbar', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/progressbar-widget.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \MgProgressbar());
		}

		if (mg_get_addons_option('mg_blockquote', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/qoute-widget.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \MgBlockquote());
		}
		if (mg_get_addons_option('mg_video_card', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/video-card.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \MgAddon_Video_Card());
		}
		if (mg_get_addons_option('mg_cf7', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/widget-cf7.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \MG_Addon_CF7());
		}
		if (mg_get_addons_option('mg_wpforms', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/wpforms-widget.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \MG_Addon_WPForm());
		}
		if (mg_get_addons_option('mg_sharebtn', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/share-buttons.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \MG_Addon_Sharebtn());
		}
		if (mg_get_addons_option('mg_piechart', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/piechart-widget.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \MG_AddonPieChart());
		}
		if (mg_get_addons_option('mg_img_comparison', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/image-comparison.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \MgAddon_imgComparison());
		}
		if (mg_get_addons_option('mg_imgaccordion', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/image-accordion.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \MgAddon_imgAccordion());
		}
		if (mg_get_addons_option('mg_content_reveal', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/content-reveal.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \MgAddon_contentReveal());
		}

		// Flip Box Widget
		if (mg_get_addons_option('mg_flipbox', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/flipbox-widget.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \MgAddon_Flip_Box());
		}
		// Call To Action Widget
		if (mg_get_addons_option('mg_flipbox', 'on') == 'on') {
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/call-to-action.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \MgAddon_Call_To_Action());
		}
		if (mg_get_addons_option('mg_dualbtn', 'on') == 'on') {
			// Call To Action Widget
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/dual-button.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \MgAddon_Dual_Button());
		}
		if (mg_get_addons_option('mg_iconlist', 'on') == 'on') {
			// Feature List Widget
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/icon-list.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \MgAddon_Icon_List());
		}
		if (mg_get_addons_option('mg_imgsmooth_scroll', 'on') == 'on') {
			// Feature List Widget
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/image-smooth-scroll.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \MgAddon_imgSmoothScroll());
		}
		if (mg_get_addons_option('mg_imgsmooth_scroll', 'on') == 'on') {
			// Feature List Widget
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/info-list.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \MgAddon_infoList());
		}
		if (mg_get_addons_option('mg_imgsmooth_scroll', 'on') == 'on') {
			// Feature List Widget
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/elementor-template.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \mg_ElementorTemplate());
		}
		if (mg_get_addons_option('mg_imgsmooth_scroll', 'on') == 'on') {
			// Feature List Widget
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/scroll-top.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \mg_ScrollTop());
		}
		if (mg_get_addons_option('mg_imgsmooth_scroll', 'on') == 'on') {
			// Feature List Widget
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/site-logo.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \MG_Addon_siteLogo());
		}
		if (mg_get_addons_option('mg_imgsmooth_scroll', 'on') == 'on') {
			// Feature List Widget
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/cattag-list.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \mgCatTag_List());
		}
		if (mg_get_addons_option('mg_imgsmooth_scroll', 'on') == 'on') {
			// Feature List Widget
			require_once(MAGICAL_ADDON_PATH . '/includes/widgets/search-bar.php');
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \MG_Addon_SearchBar());
		}



		// banner Widget
		require_once(MAGICAL_ADDON_PATH . '/includes/widgets/banner.php');
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \MgAddon_Banner());




		// Register widget















	}
}
