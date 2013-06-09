<?php

function dv_admin_head() { ?>
		<style>
		h2 { margin-bottom: 20px;}
		.title { margin: 0px !important; background: #D4E9FA; padding: 10px; font-family: Georgia, serif; font-weight: normal !important; letter-spacing: 1px; font-size: 18px;padding-left:20px !important;border:solid 1px #fff; }
		.container { background: #EAF3FA; padding: 10px; }
		.maintable { box-shadow: 0px 0px 18px #c0c0c0; border:solid 1px #fff;  font-family:"Lucida Grande","Lucida Sans Unicode",Arial,Verdana,sans-serif; background: #EAF3FA; margin-bottom: 20px; padding: 10px 0px; }
		.mainrow { padding-bottom: 10px !important; border-bottom: 1px solid #D4E9FA !important;  margin: 0px 10px 10px 10px !important; }
		.titledesc { font-size: 14px; font-weight:bold; width: 220px !important; margin-right: 20px !important; }
		.forminp { width: 700px !important; valign: middle !important; }
		.forminp input, .forminp select, .forminp textarea { margin-bottom: 9px !important; background: #fff; border: 1px solid #D4E9FA; width: 500px; padding: 4px; font-family:"Lucida Grande","Lucida Sans Unicode",Arial,Verdana,sans-serif; font-size: 12px; }
		.forminp span { font-size: 11px !important; font-weight: normal !important; ine-height: 14px !important; }
		.info { background: #FFFFCC; border: 1px dotted #D8D2A9; padding: 10px; color: #333; }
		.forminp .checkbox { width:20px }
		.info a { color: #333; text-decoration: none; border-bottom: 1px dotted #333 }
		.info a:hover { color: #666; border-bottom: 1px dotted #666; }
		.warning { background: #FFEBE8; border: 1px dotted #CC0000; padding: 10px; color: #333; font-weight: bold; }
		.maintable .forminp ul{list-style: circle;padding-left: 40px;	}
		</style>
	<?php } add_action('admin_head', 'dv_admin_head'); 	