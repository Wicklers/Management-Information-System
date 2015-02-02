<?php
require_once 'core/init.php';
if(!loggedIn()){
	Redirect::to('index.php');
}
	
	include 'header.php';

	Session::put('side-nav-active', 'marks_entry_system');
	Session::put('side-nav-active-sub','approval');
	include 'sidebar.php';
	Session::delete('side-nav-active');
	Session::delete('side-nav-active-sub');
	
	include 'go_approval.php';

	include 'footer.php';
?>