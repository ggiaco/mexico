<?php
	

	function dv_general_settings_page($options){
		global $themename;
		?>
			<div class="wrap">
    			<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
						<h2><?php echo $themename.' General Settings'; ?></h2>
                        
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
	
	$dv_general_options = array();	
	$dv_general_options[] = array(	"name" => "General Settings",
							"type" => "heading");
	
	$dv_general_options[] = array(	"name" => "Display Likes",
							"desc" => "Check this if you want to display likes count for coupons.",
							"id" => $shortname."_display_likes",
							"std" => "",
							"type" => "checkbox");	
	$dv_general_options[] = array(	"name" => "Display Dislikes",
							"desc" => "Check this if you want to display dislikes count for coupons.",
							"id" => $shortname."_display_dislikes",
							"std" => "",
							"type" => "checkbox");
	$dv_general_options[] = array(	"name" => "Display Clicks",
							"desc" => "Check this if you want to display total clicks on coupon codes.",
							"id" => $shortname."_display_clicks",
							"std" => "",
							"type" => "checkbox");	
	$dv_general_options[] = array(	"name" => "Use Timthumb Library",
							"desc" => "This will resize your coupon images using timthumb library.",
							"id" => $shortname."_use_timthumb",
							"std" => "",
							"type" => "checkbox");
	$dv_general_options[] = array(	"name" => "Use Theme's CSS",
							"desc" => "The coupon snippet will use style sheets added to current theme.",
							"id" => $shortname."_use_theme_css",
							"std" => "",
							"type" => "checkbox");
	
	
	

							
							
	
	
	function dv_general_settings() {
		global $themename,$dv_general_options;
		
			if ( 'save' == $_REQUEST['action'] ) {
					foreach ($dv_general_options as $value) {
						if($value['type'] != 'multicheck'){
							update_option( $value['id'], $_REQUEST[ $value['id'] ] ); 
						}else{
							foreach($value['options'] as $mc_key => $mc_value){
								$up_opt = $value['id'].'_'.$mc_key;
								update_option($up_opt, $_REQUEST[$up_opt] );
							}
						}
					}
					foreach ($dv_general_options as $value) {
						if($value['type'] != 'multicheck'){
							if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } 
						}else{
							foreach($value['options'] as $mc_key => $mc_value){
								$up_opt = $value['id'].'_'.$mc_key;						
								if( isset( $_REQUEST[ $up_opt ] ) ) { update_option( $up_opt, $_REQUEST[ $up_opt ]  ); } else { delete_option( $up_opt ); } 
							}
						}
					}
					@safe_redirect("admin.php?page=dv_coupons_general_settings&saved=true");
												
				die;
			}
		
		
		global $dv_general_options;
		dv_general_settings_page($dv_general_options);
		
	}
	

	
	
		

?>