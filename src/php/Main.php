<?php
/**
 * Main theme class file.
 *
 * @package iwpdev/bilberrry
 */

namespace Iwpdev\Bilberrry;

use GF_Fields;
use Iwpdev\Bilberrry\CPT\RegisterJob;
use Iwpdev\Bilberrry\GravityForms\TestProductField;
use Iwpdev\Bilberrry\Nav\MegaMenu;

/**
 * Main class.
 */
class Main {
	/**
	 * Main construct.
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 * Init actions and filters.
	 *
	 * @return void
	 */
	private function init(): void {
		add_action( 'after_setup_theme', [ $this, 'remove_default_menu_walker' ], 20 );
		add_action( 'generate_after_header_content', [ $this, 'change_menu_walker' ], 50 );
		add_action( 'wp_enqueue_scripts', [ $this, 'add_script_and_style' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'add_admin_script_and_style' ] );
		add_action( 'init', [ $this, 'gf_register' ] );

		add_filter( 'mime_types', [ $this, 'add_support_mimes' ] );
		add_filter( 'the_content', [ $this, 'filter_content' ], 10, 2 );

		new RegisterJob();
	}

	/**
	 * Show sorted jobs array.
	 *
	 * @return bool|string
	 */
	public function filter_content() {
		//phpcs:disable
		return print_r( self::get_sorted_jobs_array(), true );
		//phpcs:enable
	}

	/**
	 * Get sorted jobs array.
	 *
	 * @return array
	 */
	public static function get_sorted_jobs_array(): array {
		global $wpdb;

		$results = [];
		//phpcs:disable
		$query = "SELECT p.post_title, pm.meta_value as custom_url
				  FROM {$wpdb->posts} p
				  INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
				  WHERE p.post_type = 'jobs'
		          AND p.post_status = 'publish'
		          AND pm.meta_key = 'job_url'
				  ORDER BY p.post_title ASC";

		$jobs = $wpdb->get_results( $query );
		//phpcs:enable
		if ( empty( $jobs ) ) {
			return [];
		}

		foreach ( $jobs as $job ) {
			$letter               = strtoupper( mb_substr( $job->post_title, 0, 1 ) );
			$results[ $letter ][] = [ $job->post_title => $job->custom_url ];
		}

		return $results;
	}

	/**
	 * Add SVG and Webp formats to upload.
	 *
	 * @param array $mimes Mimes type.
	 *
	 * @return array
	 */
	public function add_support_mimes( array $mimes ): array {

		$mimes['webp'] = 'image/webp';
		$mimes['svg']  = 'image/svg+xml';

		return $mimes;
	}

	/**
	 * Remove default menu walker.
	 *
	 * @return void
	 */
	public function remove_default_menu_walker(): void {
		remove_action( 'generate_after_header_content', 'generate_add_navigation_float_right', 5 );
	}

	/**
	 * Change menu walker.
	 *
	 * @return void
	 */
	public function change_menu_walker(): void {
		if ( has_nav_menu( 'primary' ) ) {
			wp_nav_menu(
				[
					'theme_location' => 'primary',
					'walker'         => new MegaMenu(),
				]
			);
		}
	}

	/**
	 * Add script and style.
	 *
	 * @return void
	 */
	public function add_script_and_style(): void {
		$url = get_stylesheet_directory_uri();
		$min = '.min';

		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			$min = '';
		}

		wp_enqueue_style( 'bootstrap_5', '//cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css', '', '5.3.6' );

		wp_enqueue_script( 'bootstrap_5', '//cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js', [ 'jquery' ], '5.3.6', true );
		wp_enqueue_script( 'main', $url . '/assets/js/main' . $min . '.js', [ 'jquery' ], '1.0.0', true );

	}

	/**
	 * Add script and style on admin pages.
	 *
	 * @return void
	 */
	public function add_admin_script_and_style(): void {
		$url = get_stylesheet_directory_uri();
		$min = '.min';

		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			$min = '';
		}

		wp_enqueue_script(
			'gf-test-product-field',
			$url . '/assets/js/test-product-admin' . $min . '.js',
			[ 'jquery', 'gform_gravityforms', 'media-editor' ],
			'1.0',
			true
		);
		wp_enqueue_media();
	}

	/**
	 *  Register GF custom field.
	 *
	 * @return void
	 */
	public function gf_register(): void {
		add_action(
			'gform_field_standard_settings',
			[
				'Iwpdev\Bilberrry\GravityForms\TestProductField',
				'render_custom_settings',
			],
			10,
			2
		);
		GF_Fields::register( new TestProductField() );
	}
}


