function copy_to_clipboard(text,postid)  
  {  
 
      if(window.clipboardData){  
      	window.clipboardData.setData('text',text);  
		alert('The coupon code has been copied to your clipboard.');
      }else{  
      	//alert('Could not copy coupon to your clipboard.');
	  }  
       update_clicks(postid);
	   alert('The coupon code has been copied to your clipboard.');
      return false;  
  }
  
  
/*function submit_me(){
		jQuery.post(the_ajax_script.ajaxurl, jQuery("#theForm").serialize(),
			function(response_from_the_action_function){
				jQuery("#response_area").html(response_from_the_action_function);
			}
		);
}*/

function update_clicks(postid){
		jQuery.post(the_ajax_script.ajaxurl, 'action=the_ajax_hook&type=clicks&postid='+postid,
			function(response_from_the_action_function){
				jQuery("#coupon_clicks"+postid).html(response_from_the_action_function);
				
			}
		);
}

function	post_likes(obj, type, postid){
	
		jQuery.ajax({
			type:'POST',
			cache:false,
			url:the_ajax_script.ajaxurl,
			data:'action=the_ajax_hook&type='+type+'&postid='+postid,
			beforeSend:function(){
				jQuery(obj).removeClass("likes").addClass("dv_coupons_ajax_load");
			},
			success:function(res){
				
				jQuery(obj).removeClass("dv_coupons_ajax_load").addClass("likes");
				jQuery(obj).html(res);
			}
			
		});
}