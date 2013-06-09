<?php
add_action("widgets_init", array('Recent_Coupons', 'register'));
register_activation_hook( __FILE__, array('Recent_Coupons', 'activate'));
register_deactivation_hook( __FILE__, array('Recent_Coupons', 'deactivate'));

class Recent_Coupons {
  
  function activate(){
    $data = array( 'dv_recent_coupons_widget_title' => 'Recent Coupons' ,'dv_recent_coupons_num_posts' => 55);
    if ( ! get_option('Recent_Coupons')){
      add_option('Recent_Coupons' , $data);
    } else {
      update_option('Recent_Coupons' , $data);
    }
  }
  function deactivate(){
    delete_option('Recent_Coupons');
  }
  
  function control(){
   $data = get_option('Recent_Coupons');
  ?>
  	<p>
    <label><strong>Widget Title</strong><br /><input name="dv_recent_coupons_widget_title"
type="text" style="width:100%; padding:5px;" value="<?php echo $data['dv_recent_coupons_widget_title']; ?>" />
</label>
	</p>
    
    <p>
    <label><strong>Number of Posts</strong><br /><input name="dv_recent_coupons_num_posts"
type="text" style="width:100%; padding:5px;" value="<?php echo $data['dv_recent_coupons_num_posts']; ?>" />
</label>
	</p>

  
  <?php
   if (isset($_POST['dv_recent_coupons_widget_title'])){
	   unset($data);
    $data['dv_recent_coupons_widget_title'] = attribute_escape($_POST['dv_recent_coupons_widget_title']);
    $data['dv_recent_coupons_num_posts'] 	= attribute_escape($_POST['dv_recent_coupons_num_posts']);
    update_option('Recent_Coupons', $data);
  }
  }
  function widget($args){
	$data		=	 get_option('Recent_Coupons');
	$num_posts	=	 $data['dv_recent_coupons_num_posts'];
    echo $args['before_widget'];
    echo $args['before_title'] . $data['dv_recent_coupons_widget_title'] . $args['after_title'];
    
	$obj	=	new	WP_Query("posts_per_page=$num_posts&orderby=post_date&order=DESC");
	echo '<ul id="recent_posts">';
	if($obj->have_posts()){
		while($obj->have_posts()){
			$obj->the_post();
			
			$store_id	=	get_post_meta(get_the_id(), 'store_id', true);
			$feat_image = wp_get_attachment_url( get_post_thumbnail_id($store_id) );
			$feat_image	=	PLUGIN_DIR."timthumb.php?h=35&w=35&src=".$feat_image;
			echo '<li><img src="'.$feat_image.'"/><a href="'.get_permalink( $post->ID ).'">';
			the_title();
			echo '</a></li>';
			
		}
	}else{
		echo '<li>No Coupons Found</li>';	
	}
	
	echo '</ul>';
	
	
    echo $args['after_widget'];
  }
  function register(){
    register_sidebar_widget('Recent Coupons', array('Recent_Coupons', 'widget'));
    register_widget_control('Recent Coupons', array('Recent_Coupons', 'control'));
  }
}

?>