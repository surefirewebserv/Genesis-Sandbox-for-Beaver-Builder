<?php
/**
 * Genesis Starter.
 * This file adds functions to the Genesis Starter Theme.
 * @package Genesis Starter
 * @author
 * @license 
 * @link http://surefirewebservices.com/
 */

//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/inc/theme-defaults.php' );

//* Customizer
require_once( get_stylesheet_directory() . '/inc/customizer.php' );

//* BB Template
include "inc/bbtemplate/blank-template.php";

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Genesis Starter' );
define( 'CHILD_THEME_VERSION', '1.0.0' );

//* Enqueue Scripts and Styles
add_action( 'wp_enqueue_scripts', 'genesis_starter_enqueue_scripts_styles' );
function genesis_starter_enqueue_scripts_styles() {

	wp_enqueue_style( 'genesis-starter-fonts', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'dashicons' );

	wp_enqueue_style( 'gs-style-animate', get_stylesheet_directory_uri() . '/css/animate.css');

	wp_enqueue_script( 'front-end-js', get_bloginfo( 'stylesheet_directory' ) . '/js/front-end.js', array( 'jquery' ), '1.0.0',true );
	wp_enqueue_style( 'sidr-dark-css', get_stylesheet_directory_uri() . '/css/jquery.sidr.dark.css');
	
	wp_enqueue_script( 'sidr', get_bloginfo( 'stylesheet_directory' ) . '/js/jquery.sidr.js', array( 'jquery' ), '2.2.1',true );

	$output = array(
		'mainMenu' => __( 'Menu', 'genesis-starter' ),
		'subMenu'  => __( 'Menu', 'genesis-starter' ),
	);
	
	wp_localize_script( 'genesis-starter-responsive-menu', 'genesisSampleL10n', $output );

}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

//* Add Accessibility support
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Remove the header right widget area
unregister_sidebar( 'header-right' );

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Add support for 4-column footer widgets
add_theme_support( 'genesis-footer-widgets', 4 );

//* Register new menu location
function genesis_starter_register_new_menu() {
	register_nav_menus( array(
		'gs-footer-menu'	=> __( 'Footer Menu', 'genesis-starter'),
	) );
}
add_action( 'init', 'genesis_starter_register_new_menu' );

//* Check active menu location.
function genesis_starter_add_third_nav() {
	if ( has_nav_menu( 'gs-footer-menu' ) ) {
     	wp_nav_menu( array( 'theme_location' => 'gs-footer-menu', 'container_class' => 'gs-footer-menu genesis-nav-menu', 'menu_class'      => 'menu footer-nav' ) );
	}
}
add_action( 'genesis_footer', 'genesis_starter_add_third_nav', 5 ); 

//* Add Image Sizes
add_image_size( 'featured-image', 720, 400, TRUE );

//* Reduce the secondary navigation menu to one level depth
add_filter( 'wp_nav_menu_args', 'genesis_starter_secondary_menu_args' );
function genesis_starter_secondary_menu_args( $args ) {

	if ( 'secondary' != $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;

	return $args;

}

//* Modify size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'genesis_starter_author_box_gravatar' );
function genesis_starter_author_box_gravatar( $size ) {

	return 90;

}

//* Modify size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'genesis_starter_comments_gravatar' );
function genesis_starter_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;

	return $args;

}