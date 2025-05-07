<?php
/**
 * Gravity forms custom fields Test Product class file.
 *
 * @package iwpdev/bilberrry
 */

namespace Iwpdev\Bilberrry\GravityForms;

use GF_Field;
use GFCommon;

/**
 * TestProductField class.
 */
class TestProductField extends GF_Field {

	/**
	 * Filed type.
	 *
	 * @var string
	 */
	public $type = 'test_product_field';

	/**
	 * Render custom settings.
	 *
	 * @param int $position
	 * @param int $form_id
	 *
	 * @return void
	 */
	public static function render_custom_settings( $position, $form_id ) {

		if ( $position == 25 ) {
			?>
			<li class="test_product_image_setting field_setting">
				<label for="field_image_url"><?php esc_html_e( 'Image', 'gravityforms' ); ?></label>
				<div style="margin-bottom: 8px;">
					<img
							id="tp-image-preview"
							src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/woocommerce-placeholder-100x100' ); ?>"
							style="max-width:100px; display:none;"/>
				</div>
				<input
						type="hidden" id="field_test_product_image"
						onchange="SetFieldProperty('test_product_image', this.value);"/>
				<button
						class="button"
						id="test_product_upload_btn">
					<?php esc_html_e( 'Upload Image', 'gravityforms' ); ?>
				</button>
				<button
						class="button"
						id="tp-remove-image"
						style="display:none;">
					<?php esc_html_e( 'Remove', 'gravityforms' ); ?>
				</button>
			</li>

			<li class="test_product_title_setting field_setting">
				<label for="field_test_product_title"><?php esc_html_e( 'Product Title', 'gravityforms' ); ?></label>
				<input
						type="text"
						id="field_test_product_title"
						onkeyup="SetFieldProperty('test_product_title', this.value);"/>
			</li>
			<li class="test_product_desc_setting field_setting">
				<label for="field_test_product_desc_setting"><?php esc_html_e( 'Product Description', 'gravityforms' ); ?></label>
				<textarea
						name="field_test_product_desc_setting"
						onkeyup="SetFieldProperty('test_product_desc_setting', this.value);"
						id="field_test_product_desc" cols="30"
						rows="10"></textarea>
			</li>
			<?php
		}
	}

	/**
	 * Get form editor field title.
	 *
	 * @return string
	 */
	public function get_form_editor_field_title() {
		return esc_html__( 'Test Product Field', 'text-domain' );
	}

	/**
	 * Get form editor button.
	 *
	 * @return array
	 */
	public function get_form_editor_button() {
		return [
			'group' => 'standard_fields',
			'text'  => esc_html__( 'Test Product', 'text-domain' ),
		];
	}

	/**
	 * Get form editor field settings.
	 *
	 * @return string[]
	 */
	public function get_form_editor_field_settings() {
		return [
			'label_setting',
			'description_setting',
			'test_product_title_setting',
			'test_product_desc_setting',
			'test_product_image_setting',
		];
	}

	/**
	 * Get form editor field icon.
	 *
	 * @return string
	 */
	public function get_form_editor_field_icon() {
		return 'gform-icon--list';
	}

	/**
	 * Get field container tag.
	 *
	 * @param array $form Form.
	 *
	 * @return string
	 */
	public function get_field_container_tag( $form ) {

		if ( GFCommon::is_legacy_markup_enabled( $form ) ) {
			return parent::get_field_container_tag( $form );
		}

		return 'fieldset';

	}

	/**
	 * Get value submission.
	 *
	 * @param string|array $field_values             Field values.
	 * @param array        $get_from_post_global_var Get from post global var.
	 *
	 * @return array|string
	 */
	public function get_value_submission( $field_values, $get_from_post_global_var = true ) {

		$value                                         = parent::get_value_submission( $field_values, $get_from_post_global_var );
		$value[ $this->id . '_copy_values_activated' ] = (bool) rgpost( 'input_' . $this->id . '_copy_values_activated' );

		return $value;
	}

	/**
	 * Get field input.
	 *
	 * @param array        $form  From.
	 * @param string|array $value Value.
	 * @param null|array   $entry
	 *
	 * @return false|string
	 */
	public function get_field_input( $form, $value = '', $entry = null ) {
		$title       = rgar( $this, 'test_product_title' );
		$description = rgar( $this, 'test_product_desc' );
		$image_url   = rgar( $this, 'test_product_image' );

		ob_start();
		?>
		<div class="gf-test-product-field">
			<img src="<?php echo esc_url( $image_url ?? '' ); ?>" alt="<?php echo esc_attr( $title ?? '' ); ?>"/>
			<h3><?php echo esc_html( $title ?? '' ); ?></h3>
			<p><?php echo esc_html( $description ?? '' ); ?></p>
		</div>
		<?php
		return ob_get_clean();
	}
}
