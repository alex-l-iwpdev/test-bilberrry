<?php
/**
 * Functions theme.
 *
 * @package iwpdev/bilberrry
 */

require_once __FILE__ . '/vendor/autoload.php';

/**
 * Append parent styles.
 *
 * @return void
 */
function grand_sunrise_enqueue_styles():void {
	wp_enqueue_style(
		'grand-parent-style',
		get_parent_theme_file_uri( 'style.css' )
	);
}
add_action( 'wp_enqueue_scripts', 'grand_sunrise_enqueue_styles' );

