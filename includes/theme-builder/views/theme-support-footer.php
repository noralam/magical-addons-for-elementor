<?php
/**
 * Magical Theme Builder - HTML closing replacing the theme footer.
 *
 * Prints the footer location, runs wp_footer and closes the document opened
 * by theme-support-header.php.
 *
 * @package Magical_Addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fires before the footer location is printed.
 */
do_action( 'mgtb/before_footer' );

mg_tb()->locations->do_location( 'footer' );

/**
 * Fires after the footer location was printed.
 */
do_action( 'mgtb/after_footer' );

wp_footer();
?>
</body>
</html>
