<?php
function creat_post_type_dvrealty() {
	register_post_type( 'Stores',
		array(
			'labels' => array(
				'name' => __( 'Stores' ),
				'singular_name' => __( 'Store' ),
				'add_new'	=>	__('Add New Store'),
				'add_new_item'=>__('Add New Store')
			),
			'show_ui' => true,
			'menu_icon' => PLUGIN_DIR . '/templates/code.png',
			'public' => false,
			'rewrite' => array('slug' => 'stores'),
			'supports' => array('thumbnail','title', 'editor','custom-fields')
		)
	);
}
add_action( 'init', 'creat_post_type_dvrealty' );


?>