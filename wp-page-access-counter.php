<?php
/**
 * Plugin Name:     Wp Page Access Counter
 * Plugin URI:      https://github.com/daveabel/wp-page-access-counter
 * Description:     Counts access to pages and shows a secret word step-by-step if a specific amount of accesses is reached
 * Author:          Sebastian Weiß | David Abel
 * Author URI:      https://github.com/daveabel
 * Text Domain:     wp-page-access-counter
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         WP_PAGE_ACCESS_COUNTER
 */

// Your code starts here.
define('WP_PAGE_ACCESS_COUNTER', plugin_dir_path(__FILE__));
require_once WP_PAGE_ACCESS_COUNTER . '/post-types/region.php';
require_once WP_PAGE_ACCESS_COUNTER . '/post-types/question.php';



if(!function_exists('get_post_id')){
    function get_post_id() {
		if ( is_singular( 'question' ) ) {

        global $post;
        $deps = array('jquery');
        $version= '1.0'; 
        $in_footer = true;
		$region_id = get_field('region',$post->ID);
		$region = get_field('region',$region_id);
		$modulo = get_field('modulo',$region_id);
		$secret = get_field('secret',$region_id);
        wp_enqueue_script('wp-page-access-counter', plugins_url( '/js/wp-page-access-counter.js', __FILE__ ), array('jquery'), '', true);
        wp_localize_script('wp-page-access-counter', 'my_script_vars', array(
                'postID' => $post->ID,
				'region' => $region,
				'modulo' => $modulo,
				'secret' => $secret
            )
        );
    }
		}
}
add_action('wp_enqueue_scripts', 'get_post_id');

add_shortcode('ordendergsi_secret', 'ordendergsi_secret');

function ordendergsi_secret($atts = array(), $content = null, $tag = '' ){
	global $post;
	
	$region_id = get_field('region',$post->ID);
	$secret = get_field('secret',$region_id);
	$modulo = get_field('modulo',$region_id);
    $atts = array_change_key_case( (array) $atts, CASE_LOWER );
 
    // override default attributes with user attributes
    $args = shortcode_atts(
    array(
        'lvl' => '0',
    ), $atts, $tag
);

$output = '';

$output = '<div class="secret_wrapper">'.__('Lösungswort:','wp-page-access-counter').'<div id="secret"></div><div id="result"></div></div>';
	return $output;

}
