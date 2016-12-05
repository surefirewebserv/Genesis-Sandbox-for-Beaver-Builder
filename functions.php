<?php
/**
 * Genesis Sandbox.
 *
 * This file adds functions to the Genesis sandbox Theme.
 *
 * @package Genesis Sandbox
 * @author  Sure Fire Web Services, Inc.
 * @license GPL-2.0+
 * @link    https://surefirewebservices.com
 */

//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Setup Theme
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'genesis-sandbox', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'genesis-sandbox' ) );

//* Add Image upload and Color select to WordPress Theme Customizer
require_once( get_stylesheet_directory() . '/lib/customize.php' );

//* Include Customizer CSS
include_once( get_stylesheet_directory() . '/lib/output.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Genesis Sandbox' );
define( 'CHILD_THEME_URL', 'https://genesissandbox.com/' );
define( 'CHILD_THEME_VERSION', '2.0' );

//* Enqueue Scripts and Styles
add_action( 'wp_enqueue_scripts', 'genesis_sandbox_enqueue_scripts_styles' );
function genesis_sandbox_enqueue_scripts_styles() {

	wp_enqueue_style( 'genesis-sandbox-fonts', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'dashicons' );

	wp_enqueue_script( 'genesis-sandbox-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0', true );
	$output = array(
		'mainMenu' => __( 'Menu', 'genesis-sandbox' ),
		'subMenu'  => __( 'Menu', 'genesis-sandbox' ),
	);
	wp_localize_script( 'genesis-sandbox-responsive-menu', 'genesissandboxL10n', $output );

}

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

//* Add Accessibility support
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for after entry widget
add_theme_support( 'genesis-after-entry-widget-area' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Add Image Sizes
add_image_size( 'featured-image', 720, 400, TRUE );

//* Rename primary and secondary navigation menus
add_theme_support( 'genesis-menus' , array( 'primary' => __( 'After Header Menu', 'genesis-sandbox' ), 'secondary' => __( 'Footer Menu', 'genesis-sandbox' ) ) );

//* Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 5 );

//* Reduce the secondary navigation menu to one level depth
add_filter( 'wp_nav_menu_args', 'genesis_sandbox_secondary_menu_args' );
function genesis_sandbox_secondary_menu_args( $args ) {

	if ( 'secondary' != $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;

	return $args;

}

//* Modify size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'genesis_sandbox_author_box_gravatar' );
function genesis_sandbox_author_box_gravatar( $size ) {

	return 90;

}

//* Modify size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'genesis_sandbox_comments_gravatar' );
function genesis_sandbox_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;

	return $args;

}
