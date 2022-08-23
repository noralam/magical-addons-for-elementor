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
				<!--	<p class="mgad-text"><?php esc_html_e('Could you please do me a BIG favor and give it a 5-star rating on WordPress?', 'magical-addons-for-elementor'); ?><br><?php esc_html_e('Just to help us spread the word and boost our motivation!', 'magical-addons-for-elementor'); ?></p> -->
				<p class="mgad-text1"><?php esc_html_e('You can view all demos for use with better experience.', 'magical-addons-for-elementor'); ?><br><?php esc_html_e('If you want to use all features and options then to upgrade the pro version.. ', 'magical-addons-for-elementor'); ?></p>

				<a target="_blank" href="<?php echo esc_url('https://magic.wpcolors.net/'); ?>" class="btn-stars5"><?php esc_html_e('View Demos', 'magical-addons-for-elementor'); ?></a>
				<?php if (!class_exists('magicalAddonsProMain')) : ?>
					<a target="_blank" href="<?php echo esc_url('https://magic.wpcolors.net/pricing-plan/#mgpricing'); ?>" class="btn-stars5 btn-upgrade"><?php esc_html_e('Upgrade Pro', 'magical-addons-for-elementor'); ?></a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>