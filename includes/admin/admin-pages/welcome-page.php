<?php

/**
 * Dashboard home tab template
 */

defined('ABSPATH') || die();
?>

<div class="magical-welcome-tabs">
	<div class="mg-wmain-items">
		<div class="mg-wmain-item mg-wmain-logo">
			<div class="logo-icon">
				<img src="<?php echo esc_url(MAGICAL_ADDON_URL . 'assets/img/magical-logo.png'); ?>" alt="MG Icons">
			</div>
		</div>
		<div class="mg-wmain-item">
			<div class="mg-welcom-text">
				<h1 class="mgad-title"><?php esc_html_e('Magical Addons For Elementor', 'magical-addons-for-elementor'); ?></h1>
				<h6 class="mgad-subtitle"><?php esc_html_e('Thank You For Choosing Magical Addons', 'magical-addons-for-elementor'); ?></h6>
				<p class="mgad-text1"><?php esc_html_e('Premiume Addons For Elementor page builder. Ultimate addons for Elementor. Just install and boost your Elementor page builder. It\'s very easy and simple.', 'magical-addons-for-elementor'); ?></p>
				<p class="mgad-text"><?php esc_html_e('Could you please do me a BIG favor and give it a 5-star rating on WordPress?', 'magical-addons-for-elementor'); ?><br><?php esc_html_e('Just to help us spread the word and boost our motivation!', 'magical-addons-for-elementor'); ?></p>
				<a target="_blank" href="<?php echo esc_url('https://wordpress.org/support/plugin/magical-addons-for-elementor/reviews/?filter=5'); ?>" class="btn-stars5"><?php esc_html_e('Leave a Review', 'magical-addons-for-elementor'); ?></a>
			</div>
		</div>
	</div>
</div>