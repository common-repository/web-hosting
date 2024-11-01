<?php

/*

Plugin Name: Web Hosting

Plugin URI: http://www.web-uk.co.uk/wp_plugins/web-hosting/

Description: Web Hosting plugin using resellerclub and WHM.

Version: 1.5.4

Text Domain: web-hosting

Domain Path: language/

Author: D.J.Gennoe

Author URI: http://www.web-uk.co.uk

*/

//********************************************************************************

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

define('WH_PATH', plugin_dir_path(__FILE__));

$wh_themepath = get_stylesheet_directory();

$wh_themepathurl = get_stylesheet_directory_uri();

define('THEME_PATH', $wh_themepath);

define('THEME_PATH_URL', $wh_themepathurl);

define('WH_SITE_URL',site_url());


//$wh_time_zone = get_option('timezone_string');
//date_default_timezone_set($wh_time_zone);
date_default_timezone_set('UTC');
ob_start();


$file_error_array = array();
$wh_cart_items = array();
global $file_error, $wh_cart_items;

add_action('plugins_loaded', 'wh_textdomain');

function wh_textdomain() {

	load_plugin_textdomain( 'web-hosting', false, dirname( plugin_basename(__FILE__) ) . '/language/' );

}

if (file_exists(THEME_PATH."/web-hosting/includes/wh_file-loader.php")){require_once (THEME_PATH."/web-hosting/includes/wh_file-loader.php" );}

	else{

		if (file_exists(WH_PATH."includes/wh_file-loader.php"))
			{require_once (WH_PATH."includes/wh_file-loader.php" );}
				else  {$file_error .= "Error: file " . WH_PATH . "includes/wh_file-loader.php" . " was not found<br>";}

		}
if($file_error <>""){
	
	
	function general_admin_notice(){
    global $pagenow,$file_error;
    if ( $pagenow == 'index.php' ) {
		$message = '<div class="notice notice-warning is-dismissible"><p>' . $file_error . '</p></div>';
         echo $message;
    }
}

	
	general_admin_notice();
	add_action('admin_notices', 'general_admin_notice'); 
	
	}

add_filter('widget_text', 'do_shortcode');

$rc_url = false;

if (isset($wh_checkbox) && ($wh_checkbox == 'yes')){$rc_url = 'test.';}

$domain_products = array();
$option_exists = (get_option("domain_products", null) !== null);

				if ($option_exists) {
					
					$a = get_option("domain_products", true);
					if ($a ==""){update_option("domain_products",$domain_products);}
					
					} else {
						
						add_option("domain_products",$domain_products);
						
					
						
							}
							
							
							$option_exists = (get_option("temp_wh_cart_items", null) !== null);

				if ($option_exists) {
					
					$a = get_option("temp_wh_cart_items", true);
					if ($a ==""){ update_option("temp_wh_cart_items",$wh_cart_items);}
					
					} else {
						
						add_option("temp_wh_cart_items",$wh_cart_items);
						
					
						
							}
							
function addwhcss() {

if (file_exists(THEME_PATH."/web-hosting/css/whstyle.css"))

{$url = (THEME_PATH."/web-hosting/css/whstyle.css"); wp_enqueue_style( 'whstyle', $url);}

else {

wp_enqueue_style( 'whstyle', plugins_url( '/web-hosting/css') . '/whstyle.css' );

}

}

add_action('wp_enqueue_scripts', 'addwhcss');


$output_string=ob_get_contents();
ob_end_clean();
return $output_string; ob_start();
?>