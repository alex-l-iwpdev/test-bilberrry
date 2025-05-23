jQuery( document ).ready( function( $ ) {
	fieldSettings.test_product += ', .test_product_image_setting, .test_product_title_setting, .test_product_desc_setting';

	$( document ).on( 'gform_load_field_settings', function( event, field ) {
		console.log( field );
		$( '#field_test_product_title' ).val( field.test_product_title || '' );
		$( '#field_test_product_desc' ).val( field.test_product_desc || '' );
		$( '#field_test_product_image' ).val( field.test_product_image || '' );
		$( '#tp-image-preview' ).attr( 'src', field.test_product_image || '' );
		if ( field.test_product_image ) {
			$( '#tp-image-preview' ).show();
			$( '#tp-remove-image' ).show();
		}

	} );

	$( document ).on( 'input', '#field_test_product_title', function() {
		SetFieldProperty( 'test_product_title', this.value );
		updateTestProductPreview();
	} );

	$( document ).on( 'input', '#field_test_product_desc', function() {
		SetFieldProperty( 'test_product_desc', this.value );
		updateTestProductPreview();
	} );

	$( '#test_product_upload_btn' ).click( function( e ) {
		e.preventDefault();
		const frame = wp.media( {
			title: 'Select Image',
			multiple: false,
			library: { type: 'image' },
			button: { text: 'Use this image' }
		} );
		frame.on( 'select', function() {
			const attachment = frame.state().get( 'selection' ).first().toJSON();
			$( '#field_test_product_image' ).val( attachment.url );
			$( '#tp-image-preview' ).attr( 'src', attachment.url ).show();
			SetFieldProperty( 'test_product_image', attachment.url );
			updateTestProductPreview();
		} );
		frame.open();
	} );

	$( '#tp-remove-image' ).click( function( e ) {
		e.preventDefault();
		$( '#field_test_product_image' ).val( '' );
		$( '#tp-image-preview' ).attr( 'src', '' );
		SetFieldProperty( 'test_product_image', '' );
		updateTestProductPreview();
	} );

	function updateTestProductPreview() {
		const title = $( '#field_test_product_title' ).val();
		const desc = $( '#field_test_product_desc' ).val();
		const image = $( '#field_test_product_image' ).val();

		const preview = $( '.gf-test-product-field' );
		if ( ! preview.length ) return;

		if ( image ) preview.find( 'img' ).attr( 'src', image ).show();
		else preview.find( 'img' ).hide();

		preview.find( 'h3' ).text( title );
		preview.find( 'p' ).text( desc );
	}
} );
