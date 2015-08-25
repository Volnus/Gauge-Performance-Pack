<?php
/*
 * Plugin Name:       Gauge Performance Pack
 * Plugin URI:        https://github.com/Volnus/Gauge-Performance-Pack/
 * Description:       This plugin makes several modifications to the WordPress admin and the Frontend to improve the experience and performance of the website.
 * Version:           1.0
 * Author:            Scott Hartley
 * Author URI:        http://thearcadecorner.com
*/

// Remove query string from static files
function remove_cssjs_ver( $src ) {
 if( strpos( $src, '?ver=' ) )
 $src = remove_query_arg( 'ver', $src );
 return $src;
}
add_filter( 'style_loader_src', 'remove_cssjs_ver', 10, 2 );
add_filter( 'script_loader_src', 'remove_cssjs_ver', 10, 2 );


// Solve Auto Optimize Cache Problems
add_filter('autoptimize_js_include_inline','gad81_ao_include_inline',10,1);
function gad81_ao_include_inline() {
        return false;
	}

// Fix Write A Review Page

add_filter('autoptimize_filter_noptimize','my_ao_noptimize',10,0);
function my_ao_noptimize() {
	if (strpos($_SERVER['REQUEST_URI'],'/write-a-review/')!==false) {
		return true;
	} else {
		return false;
	}
}

// Fix Change Avatar Page
add_filter('autoptimize_filter_noptimize','second_ao_noptimize',10,0);
function second_ao_noptimize() {
if (strpos($_SERVER['REQUEST_URI'],'/change-avatar/')!==false) {
return true;
} else {
return false;
}

// Turn Off Admin Bar
//add_filter('show_admin_bar', '__return_false');

// Dequeue the Emoji script
//function disable_emoji_dequeue_script() { wp_dequeue_script( 'emoji' ); } add_action( 'wp_print_scripts', 'disable_emoji_dequeue_script', 100 );

// Remove the emoji styles
//remove_action( 'wp_print_styles', 'print_emoji_styles' ); remove_action( 'wp_print_scripts', 'print_emoji_detection_script' ); remove_action( 'wp_head', 'print_emoji_detection_script', 7 ); remove_action( 'admin_print_styles', 'print_emoji_styles'); remove_action( 'admin_print_scripts','print_emoji_detection_script');

// Hide Generator Tags
//remove_action('wp_head', 'wp_generator'); remove_action('wp_head', 'woocommerce_generator'); add_action('init', 'myoverride', 100);function myoverride() {remove_action('wp_head', array(visual_composer(), 'addMetaData'));}

// Optimize WooCommerce
//add_action( 'wp_enqueue_scripts', 'child_manage_woocommerce_styles', 99 ); function child_manage_woocommerce_styles() { first check that woo exists to prevent fatal errors if ( function_exists( 'is_woocommerce' ) ) { //dequeue scripts and styles if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) { wp_dequeue_style( 'woocommerce-layout' ); wp_dequeue_style( 'woocommerce-smallscreen' ); wp_dequeue_style( 'woocommerce-general' ); wp_dequeue_script( 'wc-add-to-cart' ); wp_dequeue_script( 'wc-cart-fragments' ); wp_dequeue_script( 'woocommerce' ); wp_dequeue_script( 'jquery-blockui' ); wp_dequeue_script( 'jquery-placeholder' ); } } }

// Dequeue bbPress CSS and .js on non-forum pages.
//function isa_dequeue_bbp_style() { if ( class_exists('bbPress') ) { if ( ! is_bbpress() ) { wp_dequeue_style('bbp-default'); wp_dequeue_style( 'bbp_private_replies_style'); wp_dequeue_script('bbpress-editor'); } } } add_action( 'wp_enqueue_scripts', 'isa_dequeue_bbp_style', 99 );

// Deregister Contact Form 7 styles
//add_action( 'wp_print_styles', 'aa_deregister_styles', 100 ); function aa_deregister_styles() { if ( ! is_page( 'contact-us' ) ) { wp_deregister_style( 'contact-form-7' ); } }

// Deregister Contact Form 7 JavaScript files on all pages without a form
//add_action( 'wp_print_scripts', 'aa_deregister_javascript', 100 ); function aa_deregister_javascript() { if ( ! is_page( 'contact-us' ) ) { wp_deregister_script( 'contact-form-7' ); } }
