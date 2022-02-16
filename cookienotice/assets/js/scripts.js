( function($) {	
	"use strict";

	$( document ).on( 'ready', function() {
		const cookieNotice = Cookies.get( 'cookienotice' );
		if( ! cookieNotice ) {
			$('.cookie-popup').show();
		}
		$('#cookie-btn').on( 'click', function() {
			$('.cookie-popup').fadeOut( 500 );
			Cookies.set( 'cookienotice', 'hi', { expires: 30 } );
		} );
	});

}(jQuery) );	
