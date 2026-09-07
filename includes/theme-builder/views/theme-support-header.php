<?php
/**
 * Magical Theme Builder - HTML shell replacing the theme header.
 *
 * Prints the document opening (head/body) and the header location, replacing
 * the theme's header.php output entirely.
 *
 * @package Magical_Addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
wp_body_open();

/**
 * Fires right after the body opens in the Theme Builder header shell.
 */
do_action( 'mgtb/before_header' );

mg_tb()->locations->do_location( 'header' );

/**
 * Fires after the header location was printed.
 */
do_action( 'mgtb/after_header' );
