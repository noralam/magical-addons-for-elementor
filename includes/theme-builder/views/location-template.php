<?php
/**
 * Magical Theme Builder - full-width page template for content locations.
 *
 * Returned from template_include for single/archive/search/404 locations.
 * The header/footer still flow through get_header()/get_footer(), which are
 * intercepted by MgTB_Locations when header/footer templates exist.
 *
 * @package Magical_Addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$mg_tb_location = mg_tb()->locations->get_current_location();

if ( ! $mg_tb_location ) {
	return;
}

get_header();

/**
 * Fires before the location content is printed on the page template.
 *
 * @param string $mg_tb_location Location name.
 */
do_action( 'mgtb/before_location_content', $mg_tb_location );
?>
<main class="mgtb-site-main mgtb-content-location-<?php echo esc_attr( $mg_tb_location ); ?>" role="main">
	<?php mg_tb()->locations->do_location( $mg_tb_location ); ?>
</main>
<?php
/**
 * Fires after the location content was printed on the page template.
 *
 * @param string $mg_tb_location Location name.
 */
do_action( 'mgtb/after_location_content', $mg_tb_location );

get_footer();
