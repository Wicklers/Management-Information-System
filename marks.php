<?php
require_once 'core/init.php';
if(!loggedIn() || privilege()==NULL){
	Redirect::to('logout.php');
}
	
	include 'header.php';

	Session::put('side-nav-active', 'marks_entry_system');
	Session::put('side-nav-active-sub','marks');
	include 'sidebar.php';
	Session::delete('side-nav-active');
	Session::delete('side-nav-active-sub');
	
	include 'enter_marks.php';

	include 'footer.php';
?>