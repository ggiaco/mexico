<?php
/*
Plugin Name: Assign Categories
Plugin URI: http://www.aswinanand.com/blog/2008/10/bulk-assign-categories-to-multiple-posts/
Description: Assign one or more categories to multiple posts in a single shot, with or without preserving existing categories.
Version: 1.0
Author: Aswin Anand
Author URI: http://www.aswinanand.com/

Copyright 2008  Aswin Anand  (email : aswin.net@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class Walker_Category_Div extends Walker {
	var $tree_type = 'category';
	var $db_fields = array ('parent' => 'parent', 'id' => 'term_id');

	function start_lvl(&$output, $depth, $args) {
		$output .= "<div class='children'>\n";
	}

	function end_lvl(&$output, $depth, $args) {
		$output .= "</div>";
	}

	function start_el(&$output, $category, $depth, $args) {
		extract($args);
		$arrids = explode(';', $_POST['setcat_catids']);
		$class = '';
		if (gettype($popular_cats) !== "array") $class = '';
		else $class = in_array( $category->term_id, $popular_cats ) ? ' class="popular-category"' : '';
		$output .= "\n";
		$output .= "<div id='category-$category->term_id'$class>" . '<span id="span_' . $category->term_id . '"><a id="a_' . $category->term_id . '" style="text-decoration: none;" href="javascript:;" onclick="toggle(this);">+</a>&nbsp;</span>' . '<label class="selectit">';
		$output .= '<input onclick="selectAllChildren(this);" value="' . $category->term_id . '" type="checkbox" name="cate_' . $category->term_id . '" id="in-category-' . $category->term_id . '"' . (in_array( $category->term_id, $arrids ) ? ' checked="checked"' : "" ) . '/> ' . esc_html( apply_filters('the_category', $category->name )) . '</label>';
	}

	function end_el(&$output, $category, $depth, $args) {
		$output .= "</div>";
	}
}

function com_aswinanand_assignCategories() {
?>	
<style type="text/css">
.children {
	position: relative;
	margin-left: 2em;
	display: none;
}
.selectit {
	font-family: "Lucida Grande",Verdana,Arial,"Bitstream Vera Sans",sans-serif;
	font-size: 11px;
}
</style>
<script type="text/javascript">
function $(id) {
	return document.getElementById(id);
}

function toggle(elt) {
	var j = jQuery;
	j(elt).parent().next().next().toggle();
	elt.innerHTML = (j(elt).html() == "+") ? "&ndash;" : "+";
}

function selectAllChildren(elt) {
	var j = jQuery;
	var selected = elt.checked;
	var id = "#category-" + j(elt).attr('id').split("-")[2];
	if ($("setcat_select_subcat").checked) {
		j(id).find("input[type=checkbox]").each(function() {
			j(this)[0].checked = selected;
		});
	}
}

function selectAll(elt, s) {
	var elts = $(elt).getElementsByTagName("input");
	var isIE;
	if (elts.length > 0)
		isIE = (elts[0].getAttribute) ? false : true;
	else return false;

	var id='', type='';
	for (var i=0; i<elts.length; i++) {
		if (isIE) {
			id = elts[i].attributes["id"];
			type = elts[i].attributes["type"];
		} else {
			id = elts[i].getAttribute("id");
			type = elts[i].getAttribute("type");
		}
		if ("checkbox" == type) $(id).checked = s;
	}
}

function getCheckedItems(elt) {
	var isIE;
	var elts = $(elt).getElementsByTagName("input");
	if (elts.length > 0) isIE = (elts[0].getAttribute) ? false : true;
	var type = '', id = '', catids = '';
	for (var i=0; i<elts.length; i++) {
		if (isIE) {
			id = elts[i].attributes["id"];
			type = elts[i].attributes["type"];
		}
		else {
			id = elts[i].getAttribute("id");
			type = elts[i].getAttribute("type");
		}

		if ("checkbox" == type) {
			if ($(id).checked) {
				catids += $(id).value + ";";
			}
		} else continue;
	}
	if (catids.length > 0) return catids.substring(0, catids.length - 1);
	return catids;
}

function showAlert() {
	var catids = getCheckedItems('setcat_cats');
	if (0 == catids.length) {
		alert("Please select at least one category.");
		$('setcat_cats').focus();
		return false;
	}
	$("setcat_catids").value = catids;

	catids = getCheckedItems('setcat_posts');
	if (0 == catids.length) {
		alert("Please select at least one post.");
		return false;
	}
	$("setcat_postids").value = catids;

	return true;
}
</script>
<?php

	/* Save Options */
	if ( isset($_POST['setcat_action']) && "save_option" == $_POST['setcat_action'] ) {
		if ( isset($_POST['setcat_select_subcat']) && "true" === $_POST['setcat_select_subcat'] ) {
			update_option('setcat_select_subcat', "true");
		} else {
			update_option('setcat_select_subcat', "false");
		}

		if ( isset($_POST['setcat_numposts']) ) {
			if (is_numeric($_POST['setcat_numposts']) && $_POST['setcat_numposts'] > 0) {
				if ($_POST['setcat_numposts'] >= 500)
					update_option('setcat_numposts', 500);
				else
					update_option('setcat_numposts', $_POST['setcat_numposts']);
			} else if ('all' == $_POST['setcat_numposts']) {
				update_option('setcat_numposts', 'all');
			} else {
				update_option('setcat_numposts', 25);
			}
		}

		echo '<div id="message" class="updated fade"><p><strong>Options have been updated successfully.</strong>';
		echo '<span style="float: right;"><a href="javascript:;" onclick="jQuery(\'#message\').hide();" title="Close this message">Close</a></span></p></div>';
	}

	/* Apply selected categories to posts */
	$arrids = null; $arrpostids = null; $res = null; 
	$suc = "";
	$fai = "";
	if (isset($_POST['setcat_catids']) && 0 != strlen(trim($_POST['setcat_catids'])) ) {
		$arrids = explode(';', $_POST['setcat_catids']);
		if (isset($_POST['setcat_postids']) && 0 != strlen(trim($_POST['setcat_postids'])) ) {
			$arrpostids = explode(';', $_POST['setcat_postids']);
			$preserve = isset($_POST['setcat_preserve']) ? true : false;
			echo '<div id="message" class="updated fade">';
			echo '<span style="float: right; margin-top: 5px;"><a href="javascript:;" onclick="jQuery(\'#message\').hide();" title="Close this message">Close</a></span>';
			echo '<p><strong>';
			foreach ($arrpostids as $ap) {
				if ($preserve) {
					$res = wp_get_object_terms($ap, 'category', array('fields'=>'ids'));
					$res = array_unique(array_merge($res, $arrids));
					$pdata = array('ID'=>$ap, 'post_category'=>$res);
				} else {
					$pdata = array('ID'=>$ap, 'post_category'=>$arrids);
				}
				if (is_numeric(wp_update_post($pdata))) $suc .= $ap . ", ";
				else								   $fai .= $ap . ", ";				
			}
			if (strlen($suc) > 0) echo "Categories have been successfully for the posts: " . substr($suc, 0, strlen($suc)-2) . "<br/>";
			if (strlen($fai) > 0) echo "Categories have NOT been applied for the posts: " . substr($fai, 0, strlen($fai)-2);
			echo '</strong>';
			echo '</p></div>';
		}
	}
	
	/* Display the UI */
	echo '<div class="wrap">';
	echo '<h2>Search</h2>';
	echo '<form method="post">';
	echo '<table class="form-table">';
	echo '<tr>';
	echo '<th scope="row">';
	echo '<label for="search">Search</label></th>';
	echo '<td><input type="text" name="search" id="setcat_search" value="' . attribute_escape(apply_filters('the_search_query', $_POST['search'])) . '" />&nbsp;';
	echo '<input type="submit" value="Search" class="button-secondary" /> ';
	echo '<input type="submit" value="Clear Search Results" class="button-secondary" onclick="javascript:$(\'setcat_search\').value=\'\';" /> ';
	echo '</td></tr>';
	echo '</table>';
	echo '</form>';
	echo '<form name="setcat_options" id="setcat_options" method="post">';
	echo '<h2>Options</h2><br/>';
	echo '<label>Select/Unselect all sub-categories when selecting/unselecting a parent category.&nbsp;';
	echo '<input type="checkbox" ';
	if ( "true" == get_option('setcat_select_subcat', "false") ) {
		echo 'checked="checked" ';
	}
	echo 'value="true" id="setcat_select_subcat" name="setcat_select_subcat"/></label>';
	echo '<br/><br/>';
	echo '<label>How many posts should be displayed in the table?&nbsp;';
	echo '<select name="setcat_numposts" id="setcat_numposts">';
	$numposts = get_option("setcat_numposts", 25);
	if ( 10 == $numposts )
		echo '<option value="10" selected>10</option>';
	else
		echo '<option value="10">10</option>';

	if ( 25 == $numposts )
		echo '<option value="25" selected>25 (default)</option>';
	else
		echo '<option value="25">25 (default)</option>';

	if ( 50 == $numposts )
		echo '<option value="50" selected>50</option>';
	else
		echo '<option value="50">50</option>';

	if ( 100 == $numposts )
		echo '<option value="100" selected>100</option>';
	else
		echo '<option value="100">100</option>';

	if ( 250 == $numposts )
		echo '<option value="250" selected>250</option>';
	else
		echo '<option value="250">250</option>';

	if ( 500 == $numposts )
		echo '<option value="500" selected>500</option>';
	else
		echo '<option value="500">500</option>';

	if ( "all" == $numposts ) {
		$numposts = 1000000;	// 1 million
		echo '<option value="all" selected>ALL</option>';
	} else
		echo '<option value="all">ALL</option>';

	echo '</select>';
	echo '</label>';
	echo '<br/><br/>';
	echo '<input type="hidden" name="setcat_action" value="save_option" />';
	echo '<input type="submit" value="Save Options" class="button-secondary" /> ';
	echo '</form>';
	echo '<h2>Set Categories</h2>';
	echo '<form method="post" id="setcatform" onsubmit="return showAlert();">';
	global $wpdb;
	$p = $wpdb->prefix;
	$res = get_terms('category','get=all');
	echo '<h3>Pick your categories</h3>';
	echo '<a href="javascript:void(0);" onclick="javascript:selectAll(\'setcat_cats\',true);" class="selectit">Select All Categories</a> &nbsp;|&nbsp; ';
	echo '<a href="javascript:void(0);" onclick="javascript:selectAll(\'setcat_cats\',false);" class="selectit">Unselect All Categories</a> <br/><br/>';
	echo '<div id="setcat_cats">';
	
	$arrgs = array(
		'hierarchical'=>true,
		'hide_empty'=>false
		);
	$res1 = get_categories($arrgs);
	$cat_args = array(
		'show_option_all' => '', 'show_option_none' => '',
		'orderby' => 'id', 'order' => 'ASC',
		'show_last_update' => 0, 'show_count' => 0,
		'hide_empty' => 1, 'child_of' => 0,
		'exclude' => '', 'echo' => 1,
		'selected' => 0, 'hierarchical' => 0,
		'name' => 'cat', 'class' => 'postform',
		'depth' => 0, 'tab_index' => 0
	);
	$argu = array($res1, 1000, wp_parse_args(array('hierarchical'=>true, 'hide_empty'=>false), $cat_args));
	$wlk = new Walker_Category_Div();
	echo call_user_func_array(array(&$wlk, 'walk'), $argu);

	echo '</div>';
	echo '<input type="hidden" name="setcat_catids" id="setcat_catids" />';
	echo '<hr/>';

	/* List Posts */
	global $wp_query; global $post;
	$wp_query->query(array('s'=>isset($_POST['search'])?$_POST['search']:'', 'paged'=>isset($_GET['paged'])?$_GET['paged']:1, 'posts_per_page'=>$numposts));
	$page_links = paginate_links( array(
		'base' => add_query_arg( 'paged', '%#%' ),
		'format' => '',
		'total' => $wp_query->max_num_pages,
		'current' => isset($_GET['paged'])?$_GET['paged']:1
	));

	echo "<h3>Pick your posts</h3>";
	echo '<input class="button-primary" type="submit" value="Apply Categories" /><br/><br/>';
	echo '<table class="widefat">';
	echo '<tr><td colspan="4"><a href="javascript:void(0);" title="Select All" onclick="javascript:selectAll(\'setcat_posts\',true);">Select All Posts</a> | <a href="javascript:void(0);" title="Unselect All" onclick="javascript:selectAll(\'setcat_posts\',false);">Unselect All Posts</a> | ';
	echo '<label for="setcat_preserve">';
	echo '<input ';
	if (isset($_POST['setcat_preserve'])) echo 'checked="checked" ';
	echo 'type="checkbox" id="setcat_preserve" name="setcat_preserve" value="1" /> Preserve existing categories for selected posts.</label> </td></tr>';
	echo '<thead>';
	echo '<tr><th></th><th>ID</th><th>Post Title</th><th>Categories</th></tr>';
	echo '</thead>';
	echo '<tbody id="setcat_posts">';
	while (have_posts()) {
		the_post();
		echo '<tr><td align="center">';
		echo '<input ';
		// deselect posts after categories have been applied
		// uncomment below to select the posts even after categories have been applied
		/*if (null != $arrpostids)
			if (in_array($post->ID, $arrpostids))
				echo 'checked="checked" ';*/
		echo 'type="checkbox" id="' . $post->ID . '" name="' . $post->ID . '" value="' . $post->ID . '" />' . '</td>';
		echo '<td align="center"><label for="' . $post->ID . '">' . $post->ID . '</label></td>';
		echo '<td><label for="' . $post->ID . '"><a href="' . get_permalink($post->ID) . '" title="' . $post->post_title . '">' . $post->post_title . '</a></label></td>';
		echo '<td>' . get_the_category_list(',', '', $post->ID) . '</td></tr>';
	}
	echo '</tbody>';
	echo '<tfoot>';
	echo '<tr><th></th><th>ID</th><th>Post Title</th><th>Categories</th></tr>';
	echo '</tfoot>';
	echo '<tr><td colspan="3"><a href="javascript:void(0);" title="Select All" onclick="javascript:selectAll(\'setcat_posts\',true);">Select All Posts</a> | <a href="javascript:void(0);" title="Unselect All" onclick="javascript:selectAll(\'setcat_posts\',false);">Unselect All Posts</a></td>';
	echo '<td>'; 
	
	if ( $page_links )
		echo "<div class='tablenav-pages'>$page_links</div>";

	echo '</td>';
	echo '</tr>';
	echo "</table>";
	echo '<input type="hidden" name="setcat_postids" id="setcat_postids" />';
	echo '<p class="submit"> <input class="button-primary" type="submit" value="Apply Categories" /> </p>';
	echo '</form>';
	echo '</div>';
	echo '';
}

function com_aswinanand_setAdminPages() {
	add_management_page('Assign Categories', 'Assign Categories', 8, __FILE__, 'com_aswinanand_assignCategories');
}

function com_aswinanand_removeSetCat() {
	delete_option('setcat_select_subcat');
	delete_option('setcat_numposts');
}

add_action('admin_menu', 'com_aswinanand_setAdminPages');
if (function_exists('register_uninstall_hook')) {
	register_uninstall_hook(__FILE__, 'com_aswinanand_removeSetCat');
}

?>
