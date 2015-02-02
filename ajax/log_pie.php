<?php
require_once '../core/init.php';
if(!loggedIn()){
	die();
}
if(privilege()==NULL){
	die();
}
if(Input::exists('get')){
	echo '<img src="log_pie.php?type='.Input::get('type').'" height="300px" width="600px"/>';
}
?>