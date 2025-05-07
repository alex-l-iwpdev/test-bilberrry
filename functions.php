<?php
/**
 * Functions theme.
 *
 * @package iwpdev/bilberrry
 */

use Iwpdev\Bilberrry\Main;

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Append parent styles.
 *
 * @return void
 */
function grand_sunrise_enqueue_styles(): void {
	wp_enqueue_style(
		'grand-parent-style',
		get_parent_theme_file_uri( 'style.css' ),
		[],
		'1.0'
	);

	wp_enqueue_style(
		'child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[],
		'1.0'
	);
}

add_action( 'wp_enqueue_scripts', 'grand_sunrise_enqueue_styles' );

new Main();
