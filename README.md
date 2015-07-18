# Gauge-Performance-Pack
A performance plugin for the Gauge WordPress theme. 

If you are using this plugin there are several additions that you can add to improve the performance of your website even more. The reason they have not been added is for the sake of user experience. Below are some codes that can be added to the performancepack.php file to further improve the load time of your website.

// Turn Off Admin Bar

add_filter('show_admin_bar', '__return_false');

// Dequeue the Emoji script

function disable_emoji_dequeue_script() {
wp_dequeue_script( 'emoji' );
}
add_action( 'wp_print_scripts', 'disable_emoji_dequeue_script', 100 );

// Remove the emoji styles

remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'wp_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_styles', 'print_emoji_styles');
remove_action( 'admin_print_scripts','print_emoji_detection_script');

// Hide Generator Tags

remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'woocommerce_generator');
add_action('init', 'myoverride', 100);function myoverride() {remove_action('wp_head', array(visual_composer(), 'addMetaData'));}

// Optimize WooCommerce

add_action( 'wp_enqueue_scripts', 'child_manage_woocommerce_styles', 99 );
function child_manage_woocommerce_styles() {
first check that woo exists to prevent fatal errors
if ( function_exists( 'is_woocommerce' ) ) {
//dequeue scripts and styles
if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
wp_dequeue_style( 'woocommerce-layout' );
wp_dequeue_style( 'woocommerce-smallscreen' );
wp_dequeue_style( 'woocommerce-general' );
wp_dequeue_script( 'wc-add-to-cart' );
wp_dequeue_script( 'wc-cart-fragments' );
wp_dequeue_script( 'woocommerce' );
wp_dequeue_script( 'jquery-blockui' );
wp_dequeue_script( 'jquery-placeholder' );
		}
	}
 
}


// Dequeue bbPress CSS and .js on non-forum pages.

function isa_dequeue_bbp_style() {
    if ( class_exists('bbPress') ) {
      if ( ! is_bbpress() ) {
        wp_dequeue_style('bbp-default');
        wp_dequeue_style( 'bbp_private_replies_style');
        wp_dequeue_script('bbpress-editor');
      }
    }
}
add_action( 'wp_enqueue_scripts', 'isa_dequeue_bbp_style', 99 );


// Deregister Contact Form 7 styles

add_action( 'wp_print_styles', 'aa_deregister_styles', 100 );
function aa_deregister_styles() {
    if ( ! is_page( 'contact-us' ) ) {
        wp_deregister_style( 'contact-form-7' );
    }
}

// Deregister Contact Form 7 JavaScript files on all pages without a form

add_action( 'wp_print_scripts', 'aa_deregister_javascript', 100 );
function aa_deregister_javascript() {
    if ( ! is_page( 'contact-us' ) ) {
        wp_deregister_script( 'contact-form-7' );
    }
}
