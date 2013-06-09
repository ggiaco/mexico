<?php
include(PLUGIN_BASE."/admin_functions/dashboard.php");
add_theme_support( 'post-thumbnails', array( 'page','post' ) );

function	add_frontend_css(){
	/*echo '<script type="text/javascript" src="'.PLUGIN_DIR.'templates/dv_coupons.js"></script>';*/
	if(!get_option("dv_use_theme_css")){
		echo '<link href="'.PLUGIN_DIR.'templates/style.css" rel="stylesheet" />';
	}
	echo '<style type="text/css">';
		
		if(!get_option("dv_display_likes")){
			echo '.like{ display:none !important;}';
		}
		
		if(!get_option("dv_display_dislikes")){
			echo '.dislike{ display:none !important;}';
		}
		
		if(!get_option("dv_display_clicks")){
			echo ' .coupon_views{display:none !important;}';
		}
		
	echo '</style>';
}
add_action("wp_head", "add_frontend_css");





function	parse_template($tpl, $tags){
		foreach($tags	as $key=>$val){
			$tpl	=	str_replace("{".$key."}",$val,$tpl);
		}
		//$tpl		=	preg_replace("|{(.*)}|U","",$tpl);
		return	$tpl;
}


function	custom_excerpt($content){
			$excerpt_length = 40;
			$words = explode(' ', $content, $excerpt_length + 1);
			if(count($words) > $excerpt_length) :
				array_pop($words);
				array_push($words, '...');
				$content = implode(' ', $words);
			endif;
			//print($content);
			
			return $content;
}



function	safe_redirect($url="admin.php", $type="both"){
			
	switch($type){
		case "both":				
		@header("Location:$url");
		echo '<script type="text/javascript">window.location="'.$url.'"</script>';
		break;
		
		case "javascript":
		echo '<script type="text/javascript">window.location="'.$url.'"</script>';
		break;
		
		case "header":
		@header("Location:$url");
		break;
	}
}


/*add_filter('gettext',  'change_post_to_article');
add_filter('ngettext',  'change_post_to_article');

function change_post_to_article($translated) {
     $translated = str_ireplace('Post',  'Coupon',  $translated);
	 $translated = str_ireplace('Category',  'Store',  $translated);
     return $translated;
}*/
?>