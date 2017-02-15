<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 2/4/15
 * Time: 12:01 AM
 */
?>
<div class="wrap">
	<h2><?php esc_html_e('One-click Install Demo Content',"bizone") ?></h2>
</div>
<div id="message" class="updated">
	<p>
		The Demo content is a replication of the Live Content. By importing it, you could get several sliders, sliders,
		pages, posts, theme options, widgets, sidebars and other settings.<br>
		To be able to get them, make sure that you have installed and activated these plugins:  Contact form 7 , Option Tree and Visual Composer<br> <span style="color:#f0ad4e">
WARNING: By clicking Import Demo Content button, your current theme options, sliders and widgets will be replaced. It can also take a minute to complete. <br><span style="color:red"><b>Please back up your database before  it.</b></span>
	</p>
</div>
<br>
<a href="#" onclick="return false" data-url="<?php echo esc_url(admin_url('?bravo_do_import=1&package=light')) ?>" class="btn_bravo_do_import button button-primary"><?php esc_html_e('Import','bizone')?></a>
<div id="import_debug">
</div>
<style>
	#import_debug{
		display:none;
		background: none repeat scroll 0 0 #eee;
		height: 300px;
		margin-top: 30px;
		overflow: scroll;
		padding: 20px;
		font-style: normal;
		border:1px solid #ccc;

	}
	#import_debug span{
		color:#0C0;
	}
	#import_debug .red{
		color: #ff0000;
	}

</style>