<?php
require_once '../core/init.php';
if(!loggedIn() || privilege()==NULL || privilege()=='admin'){
	Redirect::to('logout.php');
}
	
	include 'header.php';

	Session::put('side-nav-active', 'attendance');
	Session::put('side-nav-active-sub','');
	include 'sidebar.php';
	Session::delete('side-nav-active');
	Session::delete('side-nav-active-sub');
	
	include 'attendance_page.php';

	include 'footer.php';
?>