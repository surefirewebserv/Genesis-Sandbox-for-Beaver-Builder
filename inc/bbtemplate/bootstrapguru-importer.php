<?php
/**
 * WordPress eXtended RSS file parser implementations
 *
 * @package WordPress
 * @subpackage Importer
 */

/**
 * WordPress Importer class for managing parsing of WXR files.
 */

function autoimport_data_actived_theme() 
{
    $check_exists_import = get_option( 'gs_import_done', 'no' );

    if( 'no' != $check_exists_import ) return;

    global $wpdb; 

    if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);

    // Load Importer API
    require_once ABSPATH . 'wp-admin/includes/import.php';
    if ( ! class_exists( 'WP_Importer' ) ) {
        $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
        if ( file_exists( $class_wp_importer ) )
        {
            require $class_wp_importer;
        }
    }

    if ( ! class_exists( 'WP_Import' ) ) {
        $class_wp_importer = get_stylesheet_directory() . "/inc/bbtemplate/wordpress-importer.php";
        
        if ( file_exists( $class_wp_importer ) )
            require $class_wp_importer;
    }

    if ( class_exists( 'WP_Import' ) ) 
    { 
        $import_filepath = get_stylesheet_directory() . "/inc/bbtemplate/xml/myblog.wordpress.2016-10-21.xml" ;

        $wp_import = new WP_Import();
        $wp_import->fetch_attachments = true;
        $wp_import->import($import_filepath);

        update_option('gs_import_done', 'yes');
        
    }
}
add_action( 'admin_init', 'autoimport_data_actived_theme' );