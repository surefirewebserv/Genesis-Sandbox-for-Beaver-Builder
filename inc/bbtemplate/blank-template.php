<?php
// No direct access, please
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'genesis_add_page_builder_meta_box' ) ) :
/**
 * genesis-sample the page builder integration metabox
 * @since 1.3.32
 */
add_action('add_meta_boxes', 'genesis_add_page_builder_meta_box');
function genesis_add_page_builder_meta_box() {  

	// Set user role - make filterable
	$allowed = apply_filters( 'genesis_metabox_capability', 'edit_theme_options' );
	
	// If not an administrator, don't show the metabox
	if ( ! current_user_can( $allowed ) )
		return;
		
	$post_types = get_post_types();
	foreach ($post_types as $type) {
		if ( 'attachment' !== $type ) {
			add_meta_box( 
				'genesis_page_builder_meta_box', // $id  
				__('Page Builder Integration','genesis-sample'), // $title   
				'genesis_show_page_builder_meta_box', // $callback  
				$type, // $page  
				'side', // $context  
				'default' // $priority  
			); 
		}
	}
}
endif;

if ( ! function_exists( 'genesis_show_page_builder_meta_box' ) ) :
/**
 * Outputs the content of the metabox
 */
function genesis_show_page_builder_meta_box( $post ) {  
	
    wp_nonce_field( basename( __FILE__ ), 'genesis_page_builder_nonce' );
    $stored_meta = get_post_meta( $post->ID );
	$stored_meta['_genesis-sample-full-width-content'][0] = ( isset( $stored_meta['_genesis-sample-full-width-content'][0] ) ) ? $stored_meta['_genesis-sample-full-width-content'][0] : '';
    ?>
 
    <p>
		<div class="genesis-sample_full_width_template">
			<label for="_genesis-sample-full-width-content" style="display:block;margin-bottom:10px;">
				<input type="checkbox" name="_genesis-sample-full-width-content" id="_genesis-sample-full-width-content" value="true" <?php checked( $stored_meta['_genesis-sample-full-width-content'][0], 'true' ); ?>>
				<?php _e('Blank Template','genesis-sample');?>
			</label>
		</div>
	</p>
    <?php
}
endif;

if ( ! function_exists( 'genesis_save_page_builder_meta' ) ) :
// Save the Data
add_action( 'save_post', 'genesis_save_page_builder_meta' );
function genesis_save_page_builder_meta($post_id) {  
    
	// Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'genesis_page_builder_nonce' ] ) && wp_verify_nonce( $_POST[ 'genesis_page_builder_nonce' ], basename( __FILE__ ) ) ) ? true : false;
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
        return;
    }
	
	$key   = '_genesis-sample-full-width-content';
	$value = filter_input( INPUT_POST, $key, FILTER_SANITIZE_STRING );

	if ( $value )
		update_post_meta( $post_id, $key, $value );
	else
		delete_post_meta( $post_id, $key );
}
endif;

//Get blank post blank template
function genesis_starter_get_blank_template() {
	if (  is_singular() ){
		
		// Get current post
		global $post;

		// Get the metabox value
		$value_key = get_post_meta( $post->ID, '_genesis-sample-full-width-content', 'true');
		if ($value_key == 'true'){
		
			//* Add blank page body class to the head
			add_filter( 'body_class', 'genesis_sample_add_body_class' );
			function genesis_sample_add_body_class( $classes ) {

				$classes[] = 'blank-page';

				return $classes;

			}

			//* Remove Skip Links
			remove_action ( 'genesis_before_header', 'genesis_skip_links', 5 );

			//* Force full width content layout
			add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

			//* Remove site header elements
			remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
			remove_action( 'genesis_header', 'genesis_do_header' );
			remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

			//* Remove navigation
			remove_theme_support( 'genesis-menus' );

			//* Remove breadcrumbs
			remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

			//* Remove footer widgets
			remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );

			//* Remove site footer elements
			remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
			remove_action( 'genesis_footer', 'gs_customize_footer' );
			remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

			//* Remove Page Title
			remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
			remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
			remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

			//* Remove the edit link
			add_filter ( 'genesis_edit_post_link' , '__return_false' );

			//* Remove post meta
			remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
			remove_action( 'genesis_after_post_content', 'genesis_post_meta' );

			//* Remove entry footer
			remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
			remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
			remove_action( 'genesis_footer'      , 'genesis_starter_add_third_nav', 5 ); 
			remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

			//* Remove comments
			remove_action( 'genesis_after_entry' , 'genesis_get_comments_template' );
		}
	}
}
add_action( 'wp', 'genesis_starter_get_blank_template' );

// Import demo content for bb template
include_once('bootstrapguru-importer.php');