<?php
	
	
	

	function dv_generate_page($options){
		global $themename;
		?>
			<div class="wrap">
    			<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
						<h2><?php echo $themename.' Social Settings'; ?></h2>
                        
						<?php if ( $_REQUEST['saved'] ) { ?><div style="clear:both;height:20px;"></div><div class="warning"><?php echo $themename; ?>'s Options has been updated!</div><?php } ?>
						<?php if ( $_REQUEST['reset'] ) { ?><div style="clear:both;height:20px;"></div><div class="warning"><?php echo $themename; ?>'s Options has been reset!</div><?php } ?>	
						<!--START: GENERAL SETTINGS-->
     						<table class="maintable">
							<?php foreach ($options as $value) { ?>
									<?php if ( $value['type'] <> "heading" ) { ?>
										<tr class="mainrow">
										<td class="titledesc"><?php echo $value['name']; ?></td>
										<td class="forminp">
									<?php } ?>	
									<?php
										switch ( $value['type'] ) {
										case 'text':
									?>
		        							<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings($value['id']); } else { echo $value['std']; } ?>" />
									<?php
										break;
										case 'select':
									?>
	            						<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
	                					<?php foreach ($value['options'] as $option) { ?>
	                						<option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
	                					<?php } ?>
	            						</select>
									<?php
										break;
										case 'textarea':
										$ta_options = $value['options'];
									?>
										<textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" cols="<?php echo $ta_options['cols']; ?>" rows="8"><?php  if( get_settings($value['id']) != "") { echo stripslashes(get_settings($value['id'])); } else { echo $value['std']; } ?></textarea>
									<?php
										break;
										case "radio":
 										foreach ($value['options'] as $key=>$option) { 
													$radio_setting = get_settings($value['id']);
													if($radio_setting != '') {
		    											if ($key == get_settings($value['id']) ) { $checked = "checked=\"checked\""; } else { $checked = ""; }
													} else {
														if($key == $value['std']) { $checked = "checked=\"checked\""; } else { $checked = ""; }
									} ?>
	            					<input type="radio" name="<?php echo $value['id']; ?>" value="<?php echo $key; ?>" <?php echo $checked; ?> /><?php echo $option; ?><br />
									<?php }
										break;
										case "checkbox":
										if(get_settings($value['id'])) { $checked = "checked=\"checked\""; } else { $checked = ""; }
									?>
		            				<input type="checkbox" class="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
									<?php
										break;
										case "multicheck":
 										foreach ($value['options'] as $key=>$option) {
	 											$sb_key = $value['id'] . '_' . $key;
												$checkbox_setting = get_settings($sb_key);
 												if($checkbox_setting != '') {
		    											if (get_settings($sb_key) ) { $checked = "checked=\"checked\""; } else { $checked = ""; }
												} else { if($key == $value['std']) { $checked = "checked=\"checked\""; } else { $checked = ""; }
									} ?>
	            					<input type="checkbox" class="checkbox" name="<?php echo $sb_key; ?>" id="<?php echo $sb_key; ?>" value="true" <?php echo $checked; ?> /><label for="<?php echo $sb_key; ?>"><?php echo $option; ?></label><br />
									<?php }
										break;
										case "heading":
									?>
										</table> 
		    									<h3 class="title"><?php echo $value['name']; ?></h3>
										<table class="maintable">
									<?php
										break;
										default:
										break;
									} ?>
									<?php if ( $value['type'] <> "heading" ) { ?>
										<?php if ( $value['type'] <> "checkbox" ) { ?><br/><?php } ?><span><?php echo $value['desc']; ?></span>
										</td></tr>
									<?php } ?>	
							<?php } ?>
							</table>
							<p class="submit">
								<input name="save" type="submit" value="Save changes" />    
								<input type="hidden" name="action" value="save" />
							</p>
							<div style="clear:both;"></div>
						<!--END: GENERAL SETTINGS-->
            </form>
</div><!--wrap-->
<div style="clear:both;height:20px;"></div>
 <?php
}
$dv_categories_obj = get_categories('hide_empty=0');
$dv_categories = array();
foreach ($dv_categories_obj as $dv_cat) {
	$dv_categories[$dv_cat->cat_ID] = $dv_cat->cat_name;
}
$categories_tmp = array_unshift($dv_categories, "Select a category:");
	
	$dvoptions[] = array(	"name" => "Social Sites",
							"type" => "heading");
	$dvoptions[] = array(	"name" => "Twitter",
							"desc" => "Enter your twitter link here",
							"id" => $shortname."_twitter",
							"std" => "",
							"type" => "text");
	$dvoptions[] = array(	"name" => "Facebook",
							"desc" => "Enter your facebook page link here",
							"id" => $shortname."_facebook",
							"std" => "",
							"type" => "text");
	$dvoptions[] = array(	"name" => "Youtube",
							"desc" => "Enter your youtube link here",
							"id" => $shortname."_youtube",
							"std" => "",
							"type" => "text");
	$dvoptions[] = array(	"name" => "Flickr",
							"desc" => "Enter your flickr link here",
							"id" => $shortname."_flickr",
							"std" => "",
							"type" => "text");
	
	
							
							
	function dv_index_options() {
		global $dvoptions;
		dv_generate_page($dvoptions);
	}
	
	function dv_add_admin() {
		global $themename,$dvoptions;
		
			if ( 'save' == $_REQUEST['action'] ) {
					foreach ($dvoptions as $value) {
						if($value['type'] != 'multicheck'){
							update_option( $value['id'], $_REQUEST[ $value['id'] ] ); 
						}else{
							foreach($value['options'] as $mc_key => $mc_value){
								$up_opt = $value['id'].'_'.$mc_key;
								update_option($up_opt, $_REQUEST[$up_opt] );
							}
						}
					}
					foreach ($dvoptions as $value) {
						if($value['type'] != 'multicheck'){
							if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } 
						}else{
							foreach($value['options'] as $mc_key => $mc_value){
								$up_opt = $value['id'].'_'.$mc_key;						
								if( isset( $_REQUEST[ $up_opt ] ) ) { update_option( $up_opt, $_REQUEST[ $up_opt ]  ); } else { delete_option( $up_opt ); } 
							}
						}
					}
					header("Location: admin.php?page=dv_coupons_social_settings&saved=true");								
				die;
			}
		
		
		
		dv_index_options();
		//add_menu_page("Main Options", "DV  Options", 'edit_themes', 'dv-options', 'dv_index_options');
		//add_submenu_page('dv_coupons','Import Data : DV Realty', 'Import Data', 'manage_options', 'import-data', 'dv_index_options');
	}
	

$plugin_metaboxes = array(
		"client-name" => array (
			"name"		=> "coupon_discount",
			"default" 	=> "",
			"label" 	=> "Coupon Discount",
			"type" 		=> "text",
			"desc"      => "How much discount this coupon will allow to get."
		),
		
		"project-url" => array (
			"name"		=> "coupon_code",
			"default" 	=> "",
			"label" 	=> "Coupon Code",
			"type" 		=> "text",
			"desc"      => "A coupon code which will be used to redeem the discount."
		),
		
		"project-date" => array (
			"name"		=> "coupon_expiry_date",
			"default" 	=> "",
			"label" 	=> "Coupon Expiry Date",
			"type" 		=> "text",
			"desc"      => "Put the date when this couopon will expire. you also set <strong>No Expires</strong>"
		)/*,
		"coupon_store_url" => array (
			"name"		=> "coupon_store_url",
			"default" 	=> "",
			"label" 	=> "Coupon Store URL",
			"type" 		=> "text",
			"desc"      => "The URL where coupon can be redeemed."
		)*/
		
		
	);
	
function cstheme_meta_box_content() {
	global $post, $plugin_metaboxes;
	foreach ($plugin_metaboxes as $theme_metabox) {
		$theme_metaboxvalue = get_post_meta($post->ID,$theme_metabox["name"],true);
		if ($theme_metaboxvalue == "" || !isset($theme_metaboxvalue)) {
			$theme_metaboxvalue = $theme_metabox['default'];
		}
		

		echo "\t".'<p>';
		echo "\t\t".'<label for="'.$theme_metabox['name'].'" style="font-weight:bold; ">'.$theme_metabox['label'].':</label>'."\n";
		echo "\t\t".'<input style="width:99%" type="'.$theme_metabox['type'].'" value="'.$theme_metaboxvalue.'" name="'.$theme_metabox["name"].'" id="'.$theme_metabox['name'].'"/><br/>'."\n";
		echo "\t\t".$theme_metabox['desc'].'</p>'."\n";	
				
	}
	get_stores();
	
}

function	get_stores(){
	$args = array( 'post_type'=>'stores' );
	$options = get_posts( $args );
	$data[0]	=	"No Stores Found";
	foreach($options as $option){
			$data[$option->ID]	=	$option->post_title;
	}
	
	
	generate_select_box("Store","store_id",$data);	
}

function	generate_select_box($label='',$name, $options){
	global $post;
	$current	=	get_post_meta($post->ID, 'store_id',true);
	echo '<p><label for="'.$name.'"><strong>'.$label.'</strong></label><br /><select style="width:50%" name="'.$name.'">';
	foreach($options	as	$key=>$val){
		if($current==$key){
			echo '<option value="'.$key.'" selected="selected">'.$val.'</option>';
		}else{
			echo '<option value="'.$key.'">'.$val.'</option>';
		}
	}
	echo '<select></p>';
}


function cstheme_metabox_insert($pID) {
	global $plugin_metaboxes;
	foreach ($plugin_metaboxes as $theme_metabox) {
		$var = $theme_metabox["name"];
		if (isset($_POST[$var])) {			
			if( get_post_meta( $pID, $theme_metabox["name"] ) == "" )
				add_post_meta($pID, $theme_metabox["name"], $_POST[$var], true );
			elseif($_POST[$var] != get_post_meta($pID, $theme_metabox["name"], true))
				update_post_meta($pID, $theme_metabox["name"], $_POST[$var]);
			elseif($_POST[$var] == "")
				delete_post_meta($pID, $theme_metabox["name"], get_post_meta($pID, $theme_metabox["name"], true));
		}
	}
	if($_POST['store_id']!=0){
		update_post_meta($pID,"store_id", $_POST['store_id']);
	}else{
		delete_post_meta($pID,"store_id");
	}
}

function cstheme_meta_box() {
	if ( function_exists('add_meta_box') ) {
		add_meta_box('theme-settings',PLUGIN_NAME.' Custom Settings','cstheme_meta_box_content','post','normal','high');
	}
}

add_action('admin_menu', 'cstheme_meta_box');
add_action('wp_insert_post', 'cstheme_metabox_insert');


?>