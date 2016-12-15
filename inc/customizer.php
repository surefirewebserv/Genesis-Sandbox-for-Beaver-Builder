<?php
/**
 * Genesis Starter.
 *
 * This file adds the Customizer additions to the Genesis starter Theme.
 *
 * @package 
 * @author  
 * @license 
 * @link  http://surefirewebservices.com/
 */

/**
 * Get default link color for Customizer.
 *
 * Abstracted here since at least two functions use it.
 *
 * @since 2.2.3
 *
 * @return string Hex color code for link color.
 */
function genesis_sandbox_customizer_get_default_link_color() {
	return '#c3251d';
}

/**
 * Get default accent color for Customizer.
 *
 * Abstracted here since at least two functions use it.
 *
 * @since 2.2.3
 *
 * @return string Hex color code for accent color.
 */
function genesis_sandbox_customizer_get_default_accent_color() {
	return '#c3251d';
}
/**
 * Apply Actions to Replace Logo
 *
 * Set's the required actions to replace the current logo IF the theme settings are set to 'image' AND 
 * the theme mod exists.
 *
 * @since 1.0.0
 * @uses genesis_get_option() Get theme setting value.
 * @uses get_theme_mod() Retrieves a modification setting for the current theme.
 * 
 */
function genesis_sandbox_customizer_get_default_header_color() {
	return '#ffffff';
}

function genesis_sandbox_customizer_get_default_header_opacity() {
	return '1';
}

//Check upload logo
add_action('genesis_before', 'sflu_do_logo');
function sflu_do_logo() {
	if ( get_theme_mod( 'sflu_logo' ) ) {
		remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
		remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
		add_action( 'genesis_site_title', 'sflu_replace_logo' );
	}
}

/**
 * Replaces Site Logo
 *
 * Applies the uploaded image to the genesis_site_title hook.
 *
 * @since 1.0.1
 * @uses genesis_get_option() Get theme setting value.
 * @uses get_theme_mod() Retrieves a modification setting for the current theme.
 * 
 */
function sflu_replace_logo() {
	$sf_get_logo = get_theme_mod( 'sflu_logo' );
 	if  ( get_theme_mod( 'sflu_logo' ) )
 		echo '<div class="site-logo"><a href="' . site_url() . '"><img src="' . $sf_get_logo .'"></a></div>';
}
add_action( 'customize_register', 'genesis_sandbox_customizer_register' );

/**
 * Register settings and controls with the Customizer.
 *
 * @since 2.2.3
 * 
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function genesis_sandbox_customizer_register() {

	global $wp_customize;

	// ----------  H E A D E R  ----------

	//* Remove header image section form theme option
	remove_custom_image_header();
	
	/**
	 * Add header panels
	 */
	$wp_customize->add_panel(
	    'gs_header_settings_panel', 
	    array(
	        'priority'       => 21,
	        'capability'     => 'edit_theme_options',
	        'theme_supports' => '',
	        'title'          => __( 'Header Settings', 'genesis-starter' ),
	    ) 
    );
/*----------------------------------------------------------------------------------------------------*/

	$wp_customize->add_setting(
		'genesis_sandbox_link_color',
		array(
			'default'           => genesis_sandbox_customizer_get_default_link_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'genesis_sandbox_link_color',
			array(
				'description' => __( 'Change the default color for linked titles, menu links, post info links and more.', 'genesis-starter' ),
			    'label'       => __( 'Link Color', 'genesis-starter' ),
			    'section'     => 'colors',
			    'settings'    => 'genesis_sandbox_link_color',
			)
		)
	);

	$wp_customize->add_setting(
		'genesis_sandbox_accent_color',
		array(
			'default'           => genesis_sandbox_customizer_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'genesis_sandbox_accent_color',
			array(
				'description' => __( 'Change the default color for button hovers.', 'genesis-starter' ),
			    'label'       => __( 'Accent Color', 'genesis-starter' ),
			    'section'     => 'colors',
			    'settings'    => 'genesis_sandbox_accent_color',
			)
		)
	);

    // Add the section to the theme customizer in WP
    $wp_customize->add_section( 'sflu_logo_section' , array(
	    'title'       => __( 'Logo', 'genesis-starter' ),
	    'priority'    => 21,
	    'description' => __( 'Upload your logo to the header of the site.', 'genesis-starter' ),
	    'panel'      => 'gs_header_settings_panel'
	) );

	// Register the new setting
	$wp_customize->add_setting( 'sflu_logo' );

	// Tell WP to use an image uploader using WP_Customize_Image_Control
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'sflu_logo', array(
	    'section'  => 'sflu_logo_section',
	    'settings' => 'sflu_logo',
	) ) );

	// Logo add setting.
	$wp_customize->add_setting(
	    'gs_logo_radio_setting',
		array(
			'type'              => 'option',
			'default'           => 'logo_on_center',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_key',
		)
	);
	// Logo add control
	$wp_customize->add_control(
        'wp_logo_radio_control',
		array(
			'label'    =>  __( 'Logo Position', 'genesis-starter' ),
			'section'  => 'sflu_logo_section',
			'settings' => 'gs_logo_radio_setting',
			'type'     => 'radio',
			'choices'  => array(
				'logo_on_left'       => __( 'Left', 'genesis-starter' ),
				'logo_on_right'       => __( 'Right', 'genesis-starter' ),
				'logo_on_center'       => __( 'Middle', 'genesis-starter' )
			)
		)
	);

	// Add Menu Mobile section
    $wp_customize->add_section( 'gs_responsive_menu' , array(
	    'title'       => __( 'Mobile Menu', 'genesis-starter' ),
	    'priority'    => 22,
	    'panel'      => 'gs_header_settings_panel',
	) );  

    // Add Menu Mobile section
	$wp_customize->add_setting( 
		'gs_responsive_menu_settings',
		array(
			'type'              => 'option',
			'default'           => 'normal',
			'capability'     => 'edit_theme_options',
		)
	);

	// Add primary menu setting control
	$wp_customize->add_control(
        'gs_responsive_menu_controls',
		array(
			'section'  => 'gs_responsive_menu',
			'settings' => 'gs_responsive_menu_settings',
			'type'     => 'radio',
			'choices'  => array(
				'normal'       => __( 'Normal', 'genesis-starter' ),
				'slide_left'       => __( 'Slide from left', 'genesis-starter' ),
				'slide_right'       => __( 'Slide from right', 'genesis-starter' )
			),
			
		)
	);

	// Add Primary Menu section
    $wp_customize->add_section( 'gs_primary_position' , array(
	    'title'       => __( 'Primary Navigation', 'genesis-starter' ),
	    'priority'    => 23,
	    'panel'      => 'gs_header_settings_panel',
	    'active_callback' => 'logo_position_validate'
	) );  

	// Add Primary Menu setting
	$wp_customize->add_setting( 
		'primary_nav_position_setting',
		array(
			'type'              => 'option',
			'default'           => 'menu_float_logo',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'primary_sanitize_key',
		)
	);

	// Add primary menu setting control
	$wp_customize->add_control(
        'wp_menu_position_control',
		array(
			'label'    =>  __( 'Position', 'genesis-starter' ),
			'section'  => 'gs_primary_position',
			'settings' => 'primary_nav_position_setting',
			'type'     => 'radio',
			'choices'  => array(
				'menu_above_logo'       => __( 'Above Logo', 'genesis-starter' ),
				'menu_below_logo'       => __( 'Below Logo', 'genesis-starter' ),
				'menu_float_logo'       => __( 'Float With Logo', 'genesis-starter' )
			),
			
		)
	);

	// Add Primary Menu Alignment setting
	$wp_customize->add_setting( 
		'primary_alignment_setting',
		array(  
			'default'           => 'menu_align_right',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'primary_alignment_sanitize',
			'transport'         => 'postMessage'
		)
	);

	// Add primary menu alignment setting control
	$wp_customize->add_control(
        'wp_menu_align_control',
		array(
			'label'    =>  __( 'Alignment', 'genesis-starter' ),
			'section'  => 'gs_primary_position',
			'settings' => 'primary_alignment_setting',
			'type'     => 'radio',
			'choices'  => array(
				'menu_align_left'       => __( 'Left', 'genesis-starter' ),
				'menu_align_right'       => __( 'Right', 'genesis-starter' ),
				'menu_align_center'       => __( 'Center', 'genesis-starter' )
			),
			'active_callback' => 'primary_menu_validate'
		)
	);

	// Add Secondary Menu section
    $wp_customize->add_section( 'gs_secondary_position' , array(
	    'title'       => __( 'Secondary Navigation', 'genesis-starter' ),
	    'priority'    => 24,
	    'panel'      => 'gs_header_settings_panel',
	    'active_callback' => 'logo_position_validate'
	) );

    // Add Primary Menu setting
	$wp_customize->add_setting( 
		'secondary_position_setting',
		array(  
			'type'              => 'option',
			'default'           => 'second_menu_above_logo',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'secondary_sanitize_key'
		)
	);

	// Add primary menu setting control
	$wp_customize->add_control(
        'gs_second_menu_position_control',
		array(
			'priority' => 20,
			'label'    =>  __( 'Position', 'genesis-starter' ),
			'section'  => 'gs_secondary_position',
			'settings' => 'secondary_position_setting',
			'type'     => 'radio',
			'choices'  => array(
				'second_menu_above_logo'       => __( 'Top Header', 'genesis-starter' ),
				'second_menu_below_logo'       => __( 'Bottom Header', 'genesis-starter' ),
			)
		)
	);

   	// Add secondary Menu Alignment setting
	$wp_customize->add_setting( 
		'secondary_alignment_setting',
		array(
			'type'              => 'option',
			'default'           => 'menu_second_align_right',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'menu_sencond_align_sanitize',
			'transport'         => 'postMessage'
		)
	);

	// Add secondary menu alignment setting control
	$wp_customize->add_control(
        'wp_second_menu_align_control',
		array(
			'priority' => 20,
			'label'    =>  __( 'Alignment', 'genesis-starter' ),
			'section'  => 'gs_secondary_position',
			'settings' => 'secondary_alignment_setting',
			'type'     => 'radio',
			'choices'  => array(
				'menu_sencond_align_left'       => __( 'Left', 'genesis-starter' ),
				'menu_second_align_right'       => __( 'Right', 'genesis-starter' ),
				'menu_second_align_center'       => __( 'Center', 'genesis-starter' )
			)
		)
	);

	// Add Header transparent section
    $wp_customize->add_section( 'gs_header_transparent_section' , array(
	    'title'       => __( 'Header Sticky', 'genesis-starter' ),
	    'priority'    => 26,
	    'panel'      => 'gs_header_settings_panel'
	) );

	// Add sticky header setting
	$wp_customize->add_setting( 
		'header_sticky_setting',
		array(
			'default' 			=> 0,
			'capability' 		=> 'edit_theme_options',
			'sanitize_callback' => 'genesis_sandbox_checkbox_sanitize'
		)
	);

	// Add sticky header control
	$wp_customize->add_control( 
	'header_sticky_control', 
	array(
		'label' 			=> __( 'Check to enable the sticky header ', 'genesis-starter' ),
		'type' 				=> 'checkbox',
		'settings' 			=> 'header_sticky_setting',
		'section' 			=> 'gs_header_transparent_section'
		) 
	);

	// ----------  F O O T E R  ----------
	$wp_customize->add_section(
		'gs_footer_text',
		array(
			'title'       => __( 'Footer', 'genesis-starter' ),
			'description' => __( 'Customize footer', 'genesis-starter' ),
			'priority'    => 22,
		)
	);

	$wp_customize->add_setting(
		'gs_footer_text_settings',
		array(
			'type'              => 'option',
			'default'           => __( 'All rights reserved', 'genesis-starter' ),
			'sanitize_callback' => 'gs_sanitize_text',
			'transport'         => 'postMessage'
		)
	);

	$wp_customize->add_control( 
		'copyright_text_control',
		array(
			'settings' => 'gs_footer_text_settings',
			'label'    => __( "Copyright text", 'genesis-starter' ),
			'section'  => 'gs_footer_text',
			'type'     => 'text'
		)
	);

	// ----
	$wp_customize->add_setting(
		'gs_footer_html_settings',
		array(
			'type'              => 'option',
			'default'           => 'Copyright © 2016 · Sandbox on Genesis Framework · WordPress · Log in',
			'sanitize_callback' => 'gs_sanitize_html',
			'transport'         => 'postMessage'
		)
	);
	$wp_customize->add_control( 
		'footer_html_control',
		array(
			'settings' => 'gs_footer_html_settings',
			'label'    => __( "HTML", 'genesis-starter' ),
			'section'  => 'gs_footer_text',
			'type'     => 'textarea'
		)
	);
}

// ----------  C U S T O M I Z E    O U T P U T  ----------

// Primary Nav position Sanitize
function primary_sanitize_key( $input ) {
	$valid_keys = array(
		'menu_above_logo'       => __( 'Above Logo', 'genesis-starter' ),
		'menu_below_logo'       => __( 'Below Logo', 'genesis-starter' ),
		'menu_float_logo'       => __( 'Float With Logo', 'genesis-starter' )
	);

	if ( array_key_exists( $input, $valid_keys ) ) {
		return $input;
	} else {
		return '';
	}
}

// Primary Nav Alignment Sanitize
function primary_alignment_sanitize( $input ) {
	$valid_keys = array(
		'menu_align_left'       => __( 'Left', 'genesis-starter' ),
		'menu_align_right'       => __( 'Right', 'genesis-starter' ),
		'menu_align_center'       => __( 'center', 'genesis-starter' )
	);

	if ( array_key_exists( $input, $valid_keys ) ) {
		return $input;
	} else {
		return '';
	}
}

// Secondary Nav Alignment Sanitize
function menu_sencond_align_sanitize( $input ) {
	$valid_keys = array(
		'menu_sencond_align_left'       => __( 'Left', 'genesis-starter' ),
		'menu_second_align_right'       => __( 'Right', 'genesis-starter' ),
		'menu_second_align_center'       => __( 'center', 'genesis-starter' )
	);

	if ( array_key_exists( $input, $valid_keys ) ) {
		return $input;
	} else {
		return '';
	}
}

// Secondary Nav position Sanitize
function secondary_sanitize_key( $input ) {
	$valid_keys = array(
		'second_menu_above_logo'       => __( 'Top Header', 'genesis-starter' ),
		'second_menu_below_logo'       => __( 'Bottom Header', 'genesis-starter'),
	);

	if ( array_key_exists( $input, $valid_keys ) ) {
		return $input;
	} else {
		return '';
	}
}

// Checkbox Sanitize
function genesis_sandbox_checkbox_sanitize( $input ) {
	if ( $input == 1 ) {
		return 1;
	} else {
		return '';
	}
}

// ------------------------
function gs_sanitize_text( $value ) {
	return sanitize_text_field( $value );
}

// ------------------------
function gs_sanitize_html( $value ) {
	return esc_html( $value );
}

// Enqueue customize preview script.
if ( ! function_exists( 'gs_customizer_live' ) ):
	function gs_customizer_live() {

		wp_enqueue_script(
			'gs-customizer-js',
			get_stylesheet_directory_uri() . '/js/customizer-preview.js', // URL
			array( 'jquery', 'customize-preview' )
		);

	}
endif;
add_action( 'customize_preview_init', 'gs_customizer_live' );

// Check position primary menu.
$post_values = array();

if ( isset( $_POST['customized'] ) ) {
	$post_values = json_decode( wp_unslash( $_POST['customized'] ), true );
	
}

if( is_array($post_values) && count ($post_values) > 0 && isset($post_values['primary_nav_position_setting'])){
	$primary_position = $post_values['primary_nav_position_setting'];
} else{
	$primary_position = get_option('primary_nav_position_setting');
}

if( is_array($post_values) && count ($post_values) > 0 && isset($post_values['gs_logo_radio_setting'])){
	$logo_position = $post_values['gs_logo_radio_setting'];
} else{
	$logo_position = get_option('gs_logo_radio_setting');
}

if( is_array($post_values) && count ($post_values) > 0 && isset($post_values['secondary_position_setting'])){
	$second_nav_position = $post_values['secondary_position_setting'];
} else{
	$second_nav_position = get_option('secondary_position_setting');
}

//* Primary Position Validate
function primary_menu_validate(){

	$menu_float_logo = get_option('primary_nav_position_setting');	
	if ( isset( $_POST['customized'] ) ) {
		$post_values = json_decode( wp_unslash( $_POST['customized'] ), true );
		if( isset($post_values['primary_nav_position_setting']) )
			$menu_float_logo = $post_values['primary_nav_position_setting'];
	}

	if( $menu_float_logo != 'menu_float_logo' ){
		return true;
	} else {
		return false;
	}
}

//* Logo Position Validate
function logo_position_validate(){

	$logo_position_validate = get_option('gs_logo_radio_setting');	
	if ( isset( $_POST['customized'] ) ) {
		$post_values = json_decode( wp_unslash( $_POST['customized'] ), true );
		if( isset($post_values['gs_logo_radio_setting']) )
			$logo_position_validate = $post_values['gs_logo_radio_setting'];
	}

	if( $logo_position_validate != 'logo_on_center' ){
		return true;
	} else {
		return false;
	}
}

//* Header sticky Validate
function sticky_header_validate(){

	$sticky_header_validate = get_theme_mod('header_sticky_setting');	
	if ( isset( $_POST['customized'] ) ) {
		$post_values = json_decode( wp_unslash( $_POST['customized'] ), true );
		if( isset($post_values['header_sticky_setting']) )
			$sticky_header_validate = $post_values['header_sticky_setting'];
	}

	if( $sticky_header_validate == '1' ){
		return true;
	} else {
		return false;
	}
}
//* Reposition the primary navigation menu, secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_header', 'genesis_do_subnav' );
add_action( 'genesis_header', 'genesis_do_nav' );

//* Logo center 
if ($logo_position == 'logo_on_center'){

	remove_action( 'genesis_before_header', 'genesis_do_subnav' );
	add_action( 'genesis_header', 'genesis_do_subnav' );
	$second_nav_position = '';
	$primary_position = 'menu_float_logo';

}

// Customize Footer
remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'gs_customize_footer' );
function gs_customize_footer(){
	$gs_footer_text = get_option('gs_footer_text_settings');
	$gs_footer_html = get_option('gs_footer_html_settings');
	?>
	<div class="gs-copyright">
		<div class="gs-copyright-text">
			<p><?php echo $gs_footer_text; ?></p>
		</div>
		<div class="gs-copyright-html">
			<?php echo wp_specialchars_decode( $gs_footer_html, ENT_QUOTES ); ?>
		</div>
	</div>
	<?php
} 
	
//* Move sencondary navigation to bottom header
if ($second_nav_position == 'second_menu_below_logo') {
	remove_action( 'genesis_before_header', 'genesis_do_subnav' );
	add_action( 'genesis_after_header', 'genesis_do_subnav', 50);
}

//* Move primary navigation to bottom header
if ($primary_position == 'menu_below_logo') {

	remove_action( 'genesis_header', 'genesis_do_nav' );
	add_action( 'genesis_after_header', 'genesis_do_nav', 40 );

}

//* Move primary navigation to top header
if ($primary_position == 'menu_above_logo') {

	remove_action( 'genesis_header', 'genesis_do_nav' );
	add_action( 'genesis_before_header', 'genesis_do_nav' );

}

add_action('wp_enqueue_scripts', 'gs_get_option_nav_position');
function gs_get_option_nav_position(){
	$logo_position	    = get_option( 'gs_logo_radio_setting');
	$primary_position	= get_option( 'primary_nav_position_setting');
	$secondary_position	= get_option( 'secondary_position_setting');
	$responsive_menu	= get_option( 'gs_responsive_menu_settings');
	$header_sticky  	= get_theme_mod( 'header_sticky_setting', 0 );
	if ($logo_position == 'logo_on_center'){
		$secondary_position = '';
		$primary_position = 'menu_float_logo';
	}

	?>
		<script>
			var primary_position = "<?php echo $primary_position; ?>"
			var responsive_menu = "<?php echo $responsive_menu; ?>"
			var secondary_position = "<?php echo $secondary_position; ?>"
			var gs_logo_position = "<?php echo $logo_position; ?>"
			var gs_header_sticky = "<?php echo $header_sticky; ?>"
		</script>
	<?php
}
if( is_array($post_values) && count ($post_values) > 0 && isset($post_values['gs_responsive_menu_settings'])){
	$primary_nav_responsive = $post_values['gs_responsive_menu_settings'];
} else{
	$primary_nav_responsive = get_option('gs_responsive_menu_settings');
}

if( $primary_nav_responsive == 'normal' ){
	function genesis_sandbox_enqueue_responsive_menu() {
		wp_enqueue_script( 'genesis-starter-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0', true );
	}
	add_action( 'wp_enqueue_scripts', 'genesis_sandbox_enqueue_responsive_menu' );
}
if( $primary_nav_responsive != 'normal' ){
	add_action( 'genesis_before', 'genesis_sandbox_responsive_menu'); 
	function genesis_sandbox_responsive_menu(){
		?>
		<div class="gs-menu-space"></div>
		<a id="gs-menu-bar" class="gs-sird-icon" href="#sidr">
			<div class="wrap">
				<div class="gs-icon-container">
					<div class="bar1"></div>
					<div class="bar2"></div>
					<div class="bar3"></div>
				</div>
				<span>Menu</span>
			</div>
		</a>
		<?php
		$logo_position_m = get_option( 'gs_logo_radio_setting');
		if( $logo_position_m == 'logo_on_center' ){
			wp_nav_menu( array( 'theme_location' => 'secondary', 'container_class' => 'gs-second-responsive-menu' ) );
		}
		wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'gs-responsive-menu' ) );
	}
}
add_action( 'wp_enqueue_scripts', 'genesis_sandbox_css' );
/**
* Checks the settings for the link color, and accent color.
* If any of these value are set the appropriate CSS is output.
*
* @since 2.2.3
*/

function genesis_sandbox_css() {

	$handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

	$color_link = get_theme_mod( 'genesis_sandbox_link_color', genesis_sandbox_customizer_get_default_link_color() );
	$color_accent = get_theme_mod( 'genesis_sandbox_accent_color', genesis_sandbox_customizer_get_default_accent_color() );

	$css = '';

	//* Calculate Color Contrast
	function genesis_sandbox_color_contrast( $color ) {
	
		$hexcolor = str_replace( '#', '', $color );

		$red   = hexdec( substr( $hexcolor, 0, 2 ) );
		$green = hexdec( substr( $hexcolor, 2, 2 ) );
		$blue  = hexdec( substr( $hexcolor, 4, 2 ) );

		$luminosity = ( ( $red * 0.2126 ) + ( $green * 0.7152 ) + ( $blue * 0.0722 ) );

		return ( $luminosity > 128 ) ? '#333333' : '#ffffff';

	}
	
	//* Calculate Color Brightness
	function genesis_sandbox_color_brightness( $color, $change ) {

		$hexcolor = str_replace( '#', '', $color );

		$red   = hexdec( substr( $hexcolor, 0, 2 ) );
		$green = hexdec( substr( $hexcolor, 2, 2 ) );
		$blue  = hexdec( substr( $hexcolor, 4, 2 ) );
	
		$red   = max( 0, min( 255, $red + $change ) );
		$green = max( 0, min( 255, $green + $change ) );  
		$blue  = max( 0, min( 255, $blue + $change ) );

		return '#'.dechex( $red ).dechex( $green ).dechex( $blue );

	}

	$logo_position	          = get_option( 'gs_logo_radio_setting' );
	$primary_position         = get_option('primary_nav_position_setting');
	$header_sticky            = get_theme_mod( 'header_sticky_setting', 0 );
	$gs_secondary_alignment   = get_option('secondary_alignment_setting');
	$gs_primary_nav_alignment = get_theme_mod('primary_alignment_setting');
	$gs_primary_position	  = get_theme_mod( 'primary_nav_position_setting', 0 );
	$gs_responsive_menu_slide   = get_option('gs_responsive_menu_settings');
	if ($logo_position == 'logo_on_center'){
		$second_nav_position = '';
		$gs_primary_nav_alignment = 'menu_align_left';
		$primary_position = 'menu_float_logo';
		$gs_secondary_alignment ='menu_align_right';
	}

	if ( ($logo_position != 'logo_on_center') && ($primary_position != 'menu_float_logo') && ($gs_responsive_menu_slide=='normal') ){
		$mbi_logo_center = "
		@media only screen and (max-width: 1023px){
			.gs-logo-on-right .title-area,
			.gs-logo-on-left .title-area{
				float: none;
			}
			.nav-secondary .menu-secondary{
			    text-align: center;
			}
		}	
		";
	}
	$css .= $mbi_logo_center;

	if ($gs_secondary_alignment == 'menu_sencond_align_left'){
		$gs_secondary_alignment_css = "
			.nav-secondary{
				text-align: left;
			}	
		";
	} else if ($gs_secondary_alignment == 'menu_second_align_right') {
		$gs_secondary_alignment_css = "
			.nav-secondary{
				text-align: right;
			}	
		";
	} else if($gs_secondary_alignment == 'menu_second_align_center'){
		$gs_secondary_alignment_css = "
			.nav-secondary{
				text-align: center;
			}	
		";
	}
	$css .= $gs_secondary_alignment_css;

	if ($gs_primary_nav_alignment == 'menu_align_left'){
		$gs_primary_nav_alignment_css = "
			.nav-primary{
				text-align: left;
			}
		";	
	} else if ($gs_primary_nav_alignment == 'menu_align_right') {
		$gs_primary_nav_alignment_css = "
			.nav-primary{
				text-align: right;
			}
		";
	} else if ($gs_primary_nav_alignment == 'menu_align_center') {
		$gs_primary_nav_alignment_css = "
			.nav-primary{
				text-align: center;
			}
		";
	}
	$css .= $gs_primary_nav_alignment_css;

	$css .= ( genesis_sandbox_customizer_get_default_link_color() !== $color_link ) ? sprintf( '

		a,
		.entry-title a:focus,
		.entry-title a:hover,
		.genesis-nav-menu a:focus,
		.genesis-nav-menu a:hover,
		.genesis-nav-menu .current-menu-item > a,
		.genesis-nav-menu .sub-menu .current-menu-item > a:focus,
		.genesis-nav-menu .sub-menu .current-menu-item > a:hover,
		.js nav button:focus,
		.js .menu-toggle:focus {
			color: %s;
		}
		', $color_link ) : '';

	$css .= ( genesis_sandbox_customizer_get_default_accent_color() !== $color_accent ) ? sprintf( '

		button:focus,
		button:hover,
		input:focus[type="button"],
		input:focus[type="reset"],
		input:focus[type="submit"],
		input:hover[type="button"],
		input:hover[type="reset"],
		input:hover[type="submit"],
		.archive-pagination li a:focus,
		.archive-pagination li a:hover,
		.archive-pagination .active a,
		.button:focus,
		.button:hover,
		.sidebar .enews-widget input[type="submit"] {
			background-color: %s;
			color: %s;
		}
		', $color_accent, genesis_sandbox_color_contrast( $color_accent ) ) : '';

	if ( $css ) {
		wp_add_inline_style( $handle, $css );
	}
}