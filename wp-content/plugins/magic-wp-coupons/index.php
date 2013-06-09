<?php
/*
Plugin Name: Magic WP Coupons
Plugin URI: http://dvcoupons.designsvalley.com
Description: A Free coupon site plugin for wordpress.
Author: Shahzad Ahmad Mirza
Author URI: http://shahzadmirza.com
Version: 1.0
License: GPLv2 or later
*/

define("PLUGIN_NAME","DV Coupons");
define("PLUGIN_POST_TYPE","coupons");
define("PLUGIN_URL",__file__);
define("PLUGIN_BASE",dirname(__file__));
define("PLUGIN_DIR",plugin_dir_url(PLUGIN_URL));
$themename = PLUGIN_NAME;
$shortname = "dv";

include("functions.php");
include("admin_functions/admin_css.php");
include("admin_functions/social_settings.php");
include("admin_functions/general_settings.php");
include("post_types.php");
include("dv_ajax.php");
include("custom-widgets.php");





function dv_coupons_menu() {
	add_menu_page(PLUGIN_NAME." Dashboard", PLUGIN_NAME, 'manage_options', 'dv_coupons', 'dv_dashboard');
	add_submenu_page('dv_coupons','General Settings : DV Coupons', 'General Settings', 'manage_options', 'dv_coupons_general_settings', 'dv_general_settings');
	add_submenu_page('dv_coupons','Social Settings : DV Coupons', 'Social Settings', 'manage_options', 'dv_coupons_social_settings', 'dv_add_admin');
	add_submenu_page('dv_coupons','Pro Version : DV Coupons', 'Pro Version', 'manage_options', 'dv_coupons_pro_version', 'pro_version');
	
}



function	pro_version(){
	echo '<iframe  scrolling="auto" height="100%" width="100%" src="http://dvcoupons.designsvalley.com"></iframe><noframes></noframes>';
}



add_action('admin_menu', 'dv_coupons_menu');





function	display_coupons($content){
	global $post;
	
	
	$file	=	file_get_contents(PLUGIN_BASE."/templates/coupon_snippet.html");
	$text	=	custom_excerpt($post->post_content);
	
	$post_meta	=	get_post_meta($post->ID);
	$likes		=	$post_meta['likes'][0];
	$dislikes	=	$post_meta['dislikes'][0];
	$clicks		=	$post_meta['clicks'][0];
	$store_id	=	$post_meta['store_id'][0];
	
	$feat_image = wp_get_attachment_url( get_post_thumbnail_id($store_id) );
	if(get_option("dv_use_timthumb")){
		$feat_image	=	PLUGIN_DIR."timthumb.php?h=120&w=120&src=".$feat_image;
	}
	
	$tags	=	array(
						"coupon_code"			=>	$post_meta['coupon_code'][0],
						"coupon_discount"		=>	$post_meta['coupon_discount'][0],
						"coupon_title"			=>	$post->post_title,
						"expiry_date"			=>	$post_meta['coupon_expiry_date'][0],
						"coupon_text_contents"	=>	$text,
						"post_id"				=>	$post->ID,
						"featured_image" 		=>  $feat_image,
						"store_url"				=>	get_post_meta($store_id,'coupon_store_url',true),
						"coupon_views"			=>	(empty($clicks))?'0':$clicks,
						"likes"					=>	(empty($likes))?'0':$likes,
						"dislikes"				=>	(empty($dislikes))?'0':$dislikes
					);
	
	
	return parse_template($file, $tags);
}

add_filter("the_content","display_coupons");
add_filter("the_excerpt","display_coupons");



?>