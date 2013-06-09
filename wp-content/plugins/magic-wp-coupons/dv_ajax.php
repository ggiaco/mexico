<?php
 
 wp_enqueue_script( 'my-ajax-handle', plugin_dir_url( __FILE__ ) . 'templates/dv_coupons.js'  );
 wp_localize_script( 'my-ajax-handle', 'the_ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
 // THE AJAX ADD ACTIONS
 add_action( 'wp_ajax_the_ajax_hook', 'the_action_function' );
 add_action( 'wp_ajax_nopriv_the_ajax_hook', 'the_action_function' ); // need this to serve non logged in users
 // THE FUNCTION
 function the_action_function(){
	sleep(0);
	 
	 $postid	=	$_POST['postid'];
	 
	 switch($_POST['type']){
		 
		 case "like":
	 		$current_likes	=	get_post_meta($postid, "likes", true)+1;
			update_post_meta($postid, "likes", $current_likes);
		break;
		
		case	"dislike":
			$current_likes	=	get_post_meta($postid, "dislikes", true)+1;
			update_post_meta($postid, "dislikes", $current_likes)+1;
		break;
		
		case	"clicks":
			$current_likes	=	get_post_meta($postid, "clicks", true)+1;
			update_post_meta($postid, "clicks", $current_likes);
			$current_likes	=	$current_likes .' Clicks';
		break;
		
	 }
	 
	 echo $current_likes;
	 die();
 }
 
 ?>