<?php
add_action("widgets_init", array('Widget_name', 'register'));
class Widget_name {
  
  function control(){
   $data = get_option('widget_name');
  ?>
  <p><label>Option 1<input name="widget_name_option1"
type="text" value="<?php echo $data['option1']; ?>" /></label></p>
  <p><label>Option 2<input name="widget_name_option2"
type="text" value="<?php echo $data['option2']; ?>" /></label></p>
  <?php
   if (isset($_POST['widget_name_option1'])){
    $data['option1'] = attribute_escape($_POST['widget_name_option1']);
    $data['option2'] = attribute_escape($_POST['widget_name_option2']);
    update_option('widget_name', $data);
  }
  }
  function widget($args){
    echo $args['before_widget'];
    echo $args['before_title'] . 'Your widget title' . $args['after_title'];
    $arr	=	 get_option('widget_name');
	print_r($arr);
    echo $args['after_widget'];
  }
  function register(){
    register_sidebar_widget('Widget name', array('Widget_name', 'widget'));
    register_widget_control('Widget name', array('Widget_name', 'control'));
  }
}

?>