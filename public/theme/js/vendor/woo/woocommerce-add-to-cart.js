window.jQuery( document ).ready( function ( $ ) {
	$( 'body' ).on( 'adding_to_cart', function ( event, $button, data ) {
		$button && $button.hasClass( 'sc_gitem-link' ) && $button
			.addClass( 'sc-gitem-add-to-cart-loading-btn' )
			.parents( '.sc_grid-item-mini' )
			.addClass( 'sc-woocommerce-add-to-cart-loading' )
			.append( $( '<div class="sc_wc-load-add-to-loader-wrapper"><div class="sc_wc-load-add-to-loader"></div></div>' ) );
	} ).on( 'added_to_cart', function ( event, fragments, cart_hash, $button ) {
		if ( 'undefined' === typeof($button) ) {
			$button = $( '.sc-gitem-add-to-cart-loading-btn' );
		}
		$button && $button.hasClass( 'sc_gitem-link' ) && $button
			.removeClass( 'sc-gitem-add-to-cart-loading-btn' )
			.parents( '.sc_grid-item-mini' )
			.removeClass( 'sc-woocommerce-add-to-cart-loading' )
			.find( '.sc_wc-load-add-to-loader-wrapper' ).remove();
	} );
} );
