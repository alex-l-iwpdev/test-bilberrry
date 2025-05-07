<?php
/**
 * Register custom post type Job class file.
 *
 * @package iwpdev/bilberrry
 */

namespace Iwpdev\Bilberrry\CPT;

/**
 * RegisterJob class.
 */
class RegisterJob {
	/**
	 * Post type slug.
	 */
	const CPT_JOBS_SLAG = 'jobs';

	/**
	 * RegisterJob construct.
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 * Init Actions and Filters.
	 *
	 * @return void
	 */
	private function init(): void {
		add_action( 'init', [ $this, 'register_post_type_job' ] );
	}

	/**
	 * Register Job cpt.
	 *
	 * @return void
	 */
	public function register_post_type_job(): void {
		register_post_type(
			self::CPT_JOBS_SLAG,
			[
				'labels'        => [
					'name'               => __( 'Jobs', 'generatepress-child' ),
					'singular_name'      => __( 'Jobs', 'generatepress-child' ),
					'add_new'            => __( 'Add New', 'generatepress-child' ),
					'add_new_item'       => __( 'Add New Job', 'generatepress-child' ),
					'edit_item'          => __( 'Edit Job', 'generatepress-child' ),
					'new_item'           => __( 'New Job', 'generatepress-child' ),
					'view_item'          => __( 'View Job', 'generatepress-child' ),
					'search_items'       => __( 'Search Jobs', 'generatepress-child' ),
					'not_found'          => __( 'No Jobs found.', 'generatepress-child' ),
					'not_found_in_trash' => __( 'No Jobs found in Trash.', 'generatepress-child' ),
					'parent_item_colon'  => __( 'Parent Job:', 'generatepress-child' ),
					'menu_name'          => __( 'Jobs', 'generatepress-child' ),
				],
				'description'   => '',
				'public'        => true,
				'menu_position' => 20,
				'menu_icon'     => 'dashicons-businessman',
				'hierarchical'  => true,
				'supports'      => [
					'title',
					'editor',
					'author',
					'thumbnail',
					'excerpt',
					'revisions',
					'custom-fields',
				],
				'taxonomies'    => [],
				'rewrite'       => true,
				'query_var'     => true,
			]
		);
	}
}
