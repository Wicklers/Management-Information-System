<?php
require_once 'core/init.php';
if(!loggedIn()){
	Redirect::to('index.php');
}
	
	include 'header.php';

	Session::put('side-nav-active', 'settings');
	Session::put('side-nav-active-sub','');
	include 'sidebar.php';
	Session::delete('side-nav-active');
	Session::delete('side-nav-active-sub');
	
	include 'system_settings.php';

	include 'footer.php';
?>