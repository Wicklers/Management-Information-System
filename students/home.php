<?php
require_once '../core/init.php';
if(!loggedIn() || privilege()==NULL){
	Redirect::to('logout.php');
}
	
	include 'header.php';

	Session::put('side-nav-active', 'home');
	Session::put('side-nav-active-sub','');
	include 'sidebar.php';
	Session::delete('side-nav-active');
	Session::delete('side-nav-active-sub');
	
	include 'welcome.php';

	include 'footer.php';
?>