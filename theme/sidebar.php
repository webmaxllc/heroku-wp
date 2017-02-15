<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 3/1/15
 * Time: 8:18 PM
 */
$sidebar=bravo_get_sidebar();


echo "<div class='content-sidebar col-xs-12 col-sm-12 col-md-4'>";
if(is_active_sidebar($sidebar['id'])){

	dynamic_sidebar($sidebar['id']);
}
echo "</div><!--End sidebar-->";

