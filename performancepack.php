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
