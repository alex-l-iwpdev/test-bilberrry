jQuery( document ).ready( function( $ ) {
	$( '.has-mega-menu' ).hover( function() {
		const $submenu = $( this ).children( '.mega-menu-columns-wrapper' );
		if ( $submenu.length ) {
			$submenu.removeClass( 'align-right' );
			const submenuOffset = $submenu.offset();
			const submenuWidth = $submenu.outerWidth();
			const windowWidth = $( window ).width();
			if ( submenuOffset.left + submenuWidth > windowWidth ) {
				$submenu.addClass( 'align-right' );
			}
		}
	} );
} );
