<?php
/**
 * Genesis Sandbox.
 *
 * This file adds the Customizer additions to the Genesis Sandbox Theme.
 *
 * @package Genesis Sandbox
 * @author  Sure Fire Web Services, Inc.
 * @license GPL-2.0+
 * @link    https://surefirewebservices.com/
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
				'description' => __( 'Change the default color for linked titles, menu links, post info links and more.', 'genesis-sandbox' ),
			    'label'       => __( 'Link Color', 'genesis-sandbox' ),
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
				'description' => __( 'Change the default color for button hovers.', 'genesis-sandbox' ),
			    'label'       => __( 'Accent Color', 'genesis-sandbox' ),
			    'section'     => 'colors',
			    'settings'    => 'genesis_sandbox_accent_color',
			)
		)
	);

}
