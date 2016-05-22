<?php
/*
 * Plugin Name:       Gauge Performance Pack
 * Plugin URI:        https://github.com/Volnus/Gauge-Performance-Pack/
 * Description:       This plugin makes several modifications to the WordPress admin and the Frontend to improve the experience and performance of the website.
 * Version:           3.0
 * Author:            Scott Hartley
 * Author URI:        http://thearcadecorner.com
*/
/*****************************************
* 1. Reset
* 2. Improved bbPress Form
* 3. Conditional Loading 
*****************************************/
/******* 1. Reset ********/

// Remove query string from static files
function remove_cssjs_ver( $src ) {
 if( strpos( $src, '?ver=' ) )
 $src = remove_query_arg( 'ver', $src );
 return $src;
}
add_filter( 'style_loader_src', 'remove_cssjs_ver', 10, 2 );
add_filter( 'script_loader_src', 'remove_cssjs_ver', 10, 2 );

// Hide Generator Tags
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'woocommerce_generator');

//Turn Off Admin Bar
add_filter('show_admin_bar', '__return_false');

/******* 2. IMPROVED BBPRESS FORM ********/

// Enable MCE Editor for bbPress
function bbp_enable_visual_editor( $args = array() ) {
    $args['tinymce'] = true;
    $args['quicktags'] = false;
    return $args;
}
add_filter( 'bbp_after_get_the_content_parse_args', 'bbp_enable_visual_editor' );

/******* 3. CONDITIONAL LOADING ********/

//Dequeue the Emoji script
function disable_emoji_dequeue_script() { wp_dequeue_script( 'emoji' ); } add_action( 'wp_print_scripts', 'disable_emoji_dequeue_script', 100 );

//Remove the emoji styles
remove_action( 'wp_print_styles', 'print_emoji_styles' ); remove_action( 'wp_print_scripts', 'print_emoji_detection_script' ); remove_action( 'wp_head', 'print_emoji_detection_script', 7 ); remove_action( 'admin_print_styles', 'print_emoji_styles'); remove_action( 'admin_print_scripts','print_emoji_detection_script');

// Remove Useless Stuff
add_action( 'wp_print_styles',     'my_deregister_styles', 100 );
function my_deregister_styles()    { 
   wp_deregister_style( 'dashicons' ); 
}

// Optimize WooCommerce
add_action( 'wp_enqueue_scripts', 'child_manage_woocommerce_styles', 99 );
 
function child_manage_woocommerce_styles() {
 
	//first check that woo exists to prevent fatal errors
	if ( function_exists( 'is_woocommerce' ) ) {
		//dequeue scripts and styles
		if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
wp_dequeue_style( 'woocommerce-layout' );
wp_dequeue_style( 'woocommerce-smallscreen' );
wp_dequeue_style( 'woocommerce-general' );
wp_dequeue_style( 'gp-woocommerce' );  
wp_dequeue_script( 'wc-add-to-cart' );
wp_dequeue_script( 'wc-cart-fragments' );
wp_dequeue_script( 'woocommerce' );
wp_dequeue_script( 'jquery-blockui' );
wp_dequeue_script( 'jquery-placeholder' );
		}
	}
 
}


// Optimize BuddyPress
add_action( 'wp_enqueue_scripts', 'conditional_buddypress_styles_scripts', 99 );
 
function conditional_buddypress_styles_scripts() {
 
	//first check that buddypress exists to prevent fatal errors
	if ( function_exists( 'is_buddypress' ) ) {
		//dequeue scripts and styles
		if ( ! is_buddypress() ) {
    wp_dequeue_style('bp-mentions-css');
    wp_dequeue_style('gp-bp');
    wp_dequeue_style('bp-legacy-css');
    wp_dequeue_script('bp-confirm');
    wp_dequeue_script('bp-widget-members');
    wp_dequeue_script('bp-jquery-query');
    wp_dequeue_script('bp-jquery-cookie');
    wp_dequeue_script('bp-jquery-scroll-to');
    wp_dequeue_script('bp-legacy-js');
    wp_dequeue_script('jquery-atwho');
    wp_dequeue_script('bp-mentions');
		}
	}
 
}


// Optimize bbPress
add_action( 'wp_enqueue_scripts', 'conditional_bbpress_styles_scripts', 99 );
 
function conditional_bbpress_styles_scripts() {
 
	//first check that bbpress exists to prevent fatal errors
	if ( function_exists( 'is_bbpress' ) ) {
		//dequeue scripts and styles
		if ( ! is_bbpress() && ! is_buddypress() ) {
        wp_dequeue_style('bbp-default');
        wp_dequeue_style('gp-bbp');      
        wp_dequeue_style( 'bbp_private_replies_style');
        wp_dequeue_script('bbpress-editor');
		}
	}
}

// Optimize Posts
add_action( 'wp_enqueue_scripts', 'conditional_post_styles_scripts', 99 );
 
function conditional_post_styles_scripts() {
 
	//first check that single posts exists to prevent fatal errors
	if ( function_exists( 'is_single' ) ) {
		//dequeue scripts and styles
		if ( ! is_single() ) {
        wp_dequeue_style('post-views-counter-frontend');
        wp_dequeue_style('wp-mediaelement');
        wp_dequeue_style('mediaelement');
        wp_dequeue_script('post-views-counter-frontend');
        wp_dequeue_script('wp-mediaelement');
        wp_dequeue_script('mediaelement');
        wp_dequeue_script('wp-embed');
		}
	}
 
}
