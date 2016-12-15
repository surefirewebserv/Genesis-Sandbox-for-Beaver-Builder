jQuery(document).ready(function ($) {

	/*----------  N A V I G A T I O N  ----------*/
	
	// Secondary Menu Alignment.
	wp.customize( 'secondary_alignment_setting', function (value) {
		value.bind(function (to) {
			if (to == 'menu_sencond_align_left') {
				$( '.nav-secondary' ).css('text-align', 'left' );
			} else if(to == 'menu_second_align_right'){
				$( '.nav-secondary' ).css('text-align', 'right' );
			} else if(to == 'menu_second_align_center'){
				$( '.nav-secondary' ).css('text-align', 'center' );
			}
		});
	});

	// Primary Menu Alignment.
	wp.customize( 'primary_alignment_setting', function (value) {
		value.bind(function (to) {
			if (to == 'menu_align_left'){
				$( '.nav-primary' ).css('text-align', 'left' );
			} else if(to == 'menu_align_right'){
				$( '.nav-primary' ).css('text-align', 'right' );
			} else if(to == 'menu_align_center'){
				$( '.nav-primary' ).css('text-align', 'center' );
			}
		});
	});

	/*----------  F O O T E R  ----------*/
	
	// footer text
	wp.customize( 'gs_footer_text_settings', function (value)  {
		value.bind(function (to) {
			$('.gs-copyright-text p').text( to );
		});
	});

	// footer html
	wp.customize( 'gs_footer_html_settings', function (value) {
		value.bind(function (to) {
			$('.gs-copyright-html').html( to );
		});
	});
	// -----------------------------------------------------------------------

});