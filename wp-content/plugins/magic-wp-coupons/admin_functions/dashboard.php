<?php
	
	function	get_famous_coupons($max, $type){
		if($type=='recent'){
			$obj	=	new	WP_Query("posts_per_page=$max&orderby=post_date&&order=DESC");
		}else{
			$obj	=	new	WP_Query("meta_key=$type&posts_per_page=$max&orderby=meta_value_num&order=DESC");
		}
		echo '<ul>';
		if($obj->have_posts()){
			while($obj->have_posts()){
				$obj->the_post();
					echo '<li><a href="'.get_permalink( $post->ID ).'" target="_blank">';
					the_title();
					echo '</a></li>';
				
			}
		}else{
			echo '<li>No Coupons Found</li>';	
		}
		
		echo '</ul>';
	}

 function	dv_dashboard(){ ?>
	
<div class="wrap">
    		<h2>Dv Coupons Dashboard</h2>
			<table class="maintable" width="100%">
            	<tbody>
                	<tr>
                    	<td class="mainrow"><h2 class="title">Most Recent Coupons</h2></td>
                        <td class="mainrow"><h2 class="title">Most Clicked Coupons</h2></td>
                    </tr>
                    <tr>
                    	<td class="forminp"><?php get_famous_coupons(5,"recent"); ?></td>
                        <td class="forminp"><?php get_famous_coupons(5,"clicks"); ?></td>
                    </tr>
                </tbody>
            </table>
            <table class="maintable" width="100%">
            	<tbody>
                	<tr>
                    	<td class="mainrow"><h2 class="title">Most Liked Coupons</h2></td>
                        <td class="mainrow"><h2 class="title">Most Disiked Coupons</h2></td>
                    </tr>
                    <tr>
                    	<td class="forminp"><?php get_famous_coupons(5,"likes"); ?></td>
                        <td class="forminp"><?php get_famous_coupons(5,"dislikes"); ?></td>
                    </tr>
                </tbody>
            </table>
            
            	
	</div>
    
	<?php }	?>