jQuery(function( $ ){	
	var sidrmenu = {
		submenu : $( '<div />', {
			'class' : 'sidr-class-sub-menu-toggle',
		})
	};	

	$(document).ready(function() {
		if ( (gs_logo_position == 'logo_on_center') && (responsive_menu != 'normal') ){
			$( '.gs-second-responsive-menu ul.menu > li' ).addClass( 'moved-item' );
			$( '.gs-second-responsive-menu ul.menu > li' ).appendTo( '.gs-responsive-menu ul.menu' );
		}

		$( '.gs-responsive-menu').attr( 'id', 'sidr');
		
		if (responsive_menu == 'slide_right'){
			$('#gs-menu-bar').sidr({
				source: '#sidr',
				side: 'right',
			});
		} else if (responsive_menu == 'slide_left'){
			$('#gs-menu-bar').sidr({
				source: '#sidr',
			});
		}
		$('.gs-responsive-menu .sidr-class-sub-menu').before( sidrmenu.submenu );
		$('.sidr-class-sub-menu > li').hide();
		$('.sidr-class-sub-menu-toggle').click(function(){
	        $( ".sidr-class-sub-menu > li" ).slideToggle();
    	});
	});

	$( "#gs-menu-bar" ).click(function() {
	  	$( '.gs-icon-container' ).toggleClass( "change" );
	});

	// Header Sticky

	headerSticky();
	headerSticky2();
	$(window).on( 'scroll resize ', function() {  
		if (responsive_menu != 'normal'){
			headerSticky();
		} else{
			headerSticky2();
		}
	});

	function headerSticky(){
		var scroll = $(window).scrollTop(); 
		if (( scroll >= 160) && (gs_header_sticky == '1') && ( window.innerWidth > 768 )) {
			$("body").addClass("gs-nav-responsive");
	        $(".site-header").addClass("gs-header-sticky animated slideInDown");
		} else {
	    	$("body").removeClass("gs-nav-responsive");
	        $(".site-header").removeClass("gs-header-sticky animated slideInDown");
	    }
	}

	function headerSticky2(){
		var scroll = $(window).scrollTop(); 
	    if (( scroll >= 160) && (gs_header_sticky == '1') && (responsive_menu == 'normal')){
	   		$("body").addClass("gs-nav-responsive");
	        $(".site-header").addClass("gs-header-sticky animated slideInDown");
	    } else {
	    	$("body").removeClass("gs-nav-responsive");
	        $(".site-header").removeClass("gs-header-sticky animated slideInDown");
	    }
	
	}

	$(window).on( 'scroll resize ', function() {    
		if ( ($('#wpadminbar').length > 0 ) && ( window.innerWidth > 600 )){
	    	$( '.gs-header-sticky').css('top', $('#wpadminbar').height() );
	    }else{
	    	$( '.gs-header-sticky').css('top', 0 );
	    }
	});
	$( window ).load(function(){

		if (responsive_menu == 'normal'){
	    	$(".site-header").addClass("responsive-menu-normal");
	    } else if (responsive_menu != 'normal'){
	    	$(".site-header").addClass("responsive-menu-slide");
	    	$("body").addClass("gs-hide-nav");
	    }
	    
		// Logo position
	    if (gs_logo_position == 'logo_on_center'){
	        $(".site-header").addClass("gs-logo-on-middle");
	    } else if (gs_logo_position == 'logo_on_left'){
	        $(".site-header").addClass("gs-logo-on-left");
	    } else if (gs_logo_position == 'logo_on_right'){
	        $(".site-header").addClass("gs-logo-on-right");
	    }

	    // Primary menu position
	    if (primary_position == 'menu_above_logo'){
	        $(".nav-primary").addClass("top");
	    } else if (primary_position == 'menu_below_logo'){
	        $(".nav-primary").addClass("bottom");
	    } else if (primary_position == 'menu_float_logo'){
	        $(".nav-primary").addClass("inline");
	    }

	    // Secondary menu position
	    if (secondary_position == 'second_menu_above_logo'){
	        $(".nav-secondary").addClass("top");
	    } else if (secondary_position == 'second_menu_below_logo'){
	        $(".nav-secondary").addClass("bottom");
	    }
	});
});

jQuery( function ( $ ) {

	setupMenus();

	$( window ).resize( function () {
		setupMenus();
	});

	// Setup Menus
	function setupMenus() {
		if (( window.innerWidth < 1023 ) && (gs_logo_position == 'logo_on_center') && (responsive_menu == 'normal')) {
			$( '.nav-secondary ul.menu-secondary > li' ).addClass( 'moved-item' ); // tag moved items so we can move them back
			$( '.nav-secondary ul.menu-secondary > li' ).appendTo( '.nav-primary ul.menu-primary' );
			$( '.nav-secondary' ).hide();
		}
		if (( window.innerWidth >= 1023 ) && (gs_logo_position == 'logo_on_center') && (responsive_menu == 'normal')) {
			$( '.nav-primary ul.menu-primary > li.moved-item' ).appendTo( '.nav-secondary ul.menu-secondary' );
			$( '.nav-secondary' ).show();
			$( '.nav-primary' ).show();
		}
	}

	$(window).scroll(function() {    
		var scroll = $(window).scrollTop();
	    if ((scroll >= 160) && (gs_header_sticky == '1') && (gs_logo_position == 'logo_on_center') && ( window.innerWidth < 1023 )){
	   		$("body").addClass("gs-nav-responsive");
	    } else if (scroll < 1){
	    	$("body").removeClass("gs-nav-responsive");
	    }
	});
});
