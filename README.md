# Gauge-Performance-Pack
A performance plugin for the Gauge WordPress theme. 

If you are using this plugin there are several additions that you can add to improve the performance of your website even more. The reason they have not been added is for the sake of user experience. Below are some codes that can be added to the performancepack.php file to further improve the load time of your website.

TURN OFF THE WORDPRESS ADMIN BAR

// Turn Off Admin Bar
add_filter('show_admin_bar', '__return_false');

TURN OFF WORDPRESS 4.2 EMOJIS (SCRIPTS AND STYLES)
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

While this is not a performance item it will remove all of the generator tags added to this theme.
// Hide Generator Tags
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'woocommerce_generator');
add_action('init', 'myoverride', 100);function myoverride() {remove_action('wp_head', array(visual_composer(), 'addMetaData'));}
