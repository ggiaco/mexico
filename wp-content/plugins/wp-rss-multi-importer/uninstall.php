<?php
// If uninstall not called from WordPress exit
if( !defined( 'WP_UNINSTALL_PLUGIN' ) )
exit ();
// Delete option from options table
if (is_multisite()) {
    global $wpdb;
    $blogs = $wpdb->get_results("SELECT blog_id FROM {$wpdb->blogs}", ARRAY_A);
    if ($blogs) {
        foreach($blogs as $blog) {
            switch_to_blog($blog['blog_id']);
            delete_option('rss_import_items');
			delete_option('rss_import_options');
            delete_option('rss_import_categories');
			delete_option('rss_template_item');
			delete_option('rss_admin_options');
			delete_option('rss_feed_options');
			delete_option('rss_post_options');
			delete_option('rss_import_categories_images');
        }
        restore_current_blog();
    }
} else {
    delete_option('rss_import_items');
    delete_option('rss_import_categories');
	delete_option('rss_template_item');
	delete_option('rss_import_options');
	delete_option('rss_admin_options');
	delete_option('rss_feed_options');
	delete_option('rss_post_options');
	delete_option('rss_import_categories_images');
	
	$allposts = get_posts('numberposts=-1&post_type=post&post_status=any');
	foreach( $allposts as $postinfo) {
	    delete_post_meta($postinfo->ID, 'rssmi_source_link');
	    delete_post_meta($postinfo->ID, 'rssmi_source_protect');
	  }
	
}
//
?>